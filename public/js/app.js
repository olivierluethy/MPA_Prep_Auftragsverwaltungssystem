// Aufträgeverwaltung — front-end logic (Alpine.js).
// No framework build step: Alpine + Tailwind are vendored locally.

/* ---------------------------------------------------------------- helpers */
function pad2(n) { return String(n).padStart(2, '0'); }
function isoDate(y, m, d) { return `${y}-${pad2(m + 1)}-${pad2(d)}`; }

// ISO (YYYY-MM-DD) -> Swiss German DD.MM.YYYY
function deDate(iso) {
    if (!iso) return '';
    const p = iso.slice(0, 10).split('-');
    return p.length === 3 ? `${p[2]}.${p[1]}.${p[0]}` : iso;
}

const MONTHS_DE = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
    'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
const WEEKDAYS_DE = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];

// Status bucket of a task relative to "today" (ISO string).
function bucketOf(task, today) {
    if (Number(task.status) === 1) return 'done';
    const due = (task.erledigen_am || '').slice(0, 10);
    if (!due) return 'upcoming';
    if (due < today) return 'overdue';
    if (due === today) return 'today';
    return 'upcoming';
}

// Tailwind classes + label per bucket (kept in sync with the PHP bucketStyle()).
const BUCKET = {
    overdue:  { accent: 'border-red-500',     badge: 'bg-red-500/15 text-red-400',         dot: 'bg-red-500',     label: 'Überfällig' },
    today:    { accent: 'border-amber-500',   badge: 'bg-amber-500/15 text-amber-400',     dot: 'bg-amber-500',   label: 'Heute fällig' },
    upcoming: { accent: 'border-emerald-500', badge: 'bg-emerald-500/15 text-emerald-400', dot: 'bg-emerald-500', label: 'Pünktlich' },
    done:     { accent: 'border-zinc-600',    badge: 'bg-zinc-700/40 text-zinc-300',       dot: 'bg-zinc-500',    label: 'Erledigt' },
};

// Most "severe" bucket among a set of tasks (for calendar day markers).
function repBucket(tasks, today) {
    const order = ['overdue', 'today', 'upcoming', 'done'];
    let best = null;
    for (const t of tasks) {
        const b = bucketOf(t, today);
        if (best === null || order.indexOf(b) < order.indexOf(best)) best = b;
    }
    return best;
}

// 7-column month grid (Monday first). Returns [{day, date}] with nulls for padding.
function buildMonthGrid(year, month) {
    const first = new Date(year, month, 1);
    const start = (first.getDay() + 6) % 7;          // Monday = 0
    const dim = new Date(year, month + 1, 0).getDate();
    const cells = [];
    for (let i = 0; i < start; i++) cells.push({ day: null, date: null });
    for (let d = 1; d <= dim; d++) cells.push({ day: d, date: isoDate(year, month, d) });
    while (cells.length % 7 !== 0) cells.push({ day: null, date: null });
    return cells;
}

/* --------------------------------------------------------- data + network */
function readPageData(rootEl) {
    const el = rootEl.querySelector('#page-data');
    return el ? JSON.parse(el.textContent)
              : { today: '', tasks: [], employees: [], isAdmin: false };
}

function postForm(url, dataObj) {
    return fetch(url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'fetch', 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(dataObj),
    });
}
function getFetch(url) {
    return fetch(url, { headers: { 'X-Requested-With': 'fetch' } });
}
// multipart/form-data POST (file uploads) — let the browser set the boundary.
function postMultipart(url, formData) {
    return fetch(url, { method: 'POST', headers: { 'X-Requested-With': 'fetch' }, body: formData });
}
// Human-readable file size.
function fmtSize(bytes) {
    bytes = Number(bytes) || 0;
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1024 / 1024).toFixed(1) + ' MB';
}

// Re-fetch the current page and swap #content in place (no navigation).
async function refreshContent(rootEl) {
    const res = await getFetch(window.location.href);
    const html = await res.text();
    const fresh = new DOMParser().parseFromString(html, 'text/html').getElementById('content');
    if (fresh) rootEl.replaceWith(fresh);   // Alpine auto-initialises the new node
}

/* ----------------------------------------------- UI state across refreshes */
window.__ui = window.__ui || {};
function saveUI(key, c) {
    window.__ui[key] = { tab: c.tab, subtab: c.subtab, selEmp: c.selEmp, calYear: c.calYear, calMonth: c.calMonth };
}
function restoreUI(key, c) {
    const s = window.__ui[key];
    if (s) for (const k in s) if (s[k] !== undefined) c[k] = s[k];
}

/* ============================================================ ÜBERSICHT */
function uebersichtPage() {
    return {
        data: { today: '', tasks: [], employees: [], isAdmin: false },
        tab: 'auftraege',
        selEmp: 'all',
        calYear: 2026, calMonth: 0,
        weekdays: WEEKDAYS_DE,
        BUCKET, deDate, bucketOf,
        init() {
            this.data = readPageData(this.$root);
            const t = new Date(this.data.today || Date.now());
            this.calYear = t.getFullYear(); this.calMonth = t.getMonth();
            restoreUI('uebersicht', this);
        },
        _persist() { saveUI('uebersicht', this); },
        setTab(t) { this.tab = t; this._persist(); },
        bucket(t) { return bucketOf(t, this.data.today); },
        get calGrid() { return buildMonthGrid(this.calYear, this.calMonth); },
        get calLabel() { return MONTHS_DE[this.calMonth] + ' ' + this.calYear; },
        calPrev() { if (this.calMonth === 0) { this.calMonth = 11; this.calYear--; } else this.calMonth--; this._persist(); },
        calNext() { if (this.calMonth === 11) { this.calMonth = 0; this.calYear++; } else this.calMonth++; this._persist(); },
        isToday(iso) { return iso === this.data.today; },
        tasksOn(iso) {
            return this.data.tasks.filter(t =>
                (t.erledigen_am || '').slice(0, 10) === iso &&
                (this.selEmp === 'all' || String(t.mitarbeiterId) === String(this.selEmp)));
        },
    };
}

/* ============================================================= AUFTRÄGE */
function auftraegePage() {
    return {
        data: { today: '', tasks: [], employees: [], isAdmin: false },
        tab: 'offen', subtab: 'alle',
        expanded: {},
        modal: { open: false, mode: 'create', saving: false, error: '', form: {}, files: [], existing: [], taskRef: null },
        avYear: 2026, avMonth: 0,
        weekdays: WEEKDAYS_DE,
        BUCKET, deDate,
        init() {
            this.data = readPageData(this.$root);
            restoreUI('auftraege', this);
        },
        _persist() { saveUI('auftraege', this); },
        bucket(t) { return bucketOf(t, this.data.today); },
        get openTasks() { return this.data.tasks.filter(t => Number(t.status) !== 1); },
        get doneTasks() { return this.data.tasks.filter(t => Number(t.status) === 1); },
        get punktlich()    { return this.openTasks.filter(t => this.bucket(t) === 'upcoming'); },
        get heute()        { return this.openTasks.filter(t => this.bucket(t) === 'today'); },
        get ueberfaellig() { return this.openTasks.filter(t => this.bucket(t) === 'overdue'); },
        get currentList() {
            if (this.tab === 'erledigt') return this.doneTasks;
            if (this.subtab === 'punktlich') return this.punktlich;
            if (this.subtab === 'heute') return this.heute;
            if (this.subtab === 'ueberfaellig') return this.ueberfaellig;
            return this.openTasks;
        },
        setTab(t) { this.tab = t; this._persist(); },
        setSub(s) { this.subtab = s; this._persist(); },
        toggleExpand(id) { this.expanded[id] = !this.expanded[id]; },
        empName(id) { const e = this.data.employees.find(x => String(x.id) === String(id)); return e ? e.name : ''; },
        fmtSize,
        // ---- create / edit modal
        openCreate() {
            this.modal = { open: true, mode: 'create', saving: false, error: '',
                form: { id: '', titel: '', beschreibung: '', mitarbeiter: '', erledigen_am: '' },
                files: [], existing: [], taskRef: null };
            this.syncAv();
        },
        openEdit(t) {
            this.modal = { open: true, mode: 'edit', saving: false, error: '',
                form: { id: t.id, titel: t.titel, beschreibung: t.beschreibung,
                        mitarbeiter: String(t.mitarbeiterId), erledigen_am: (t.erledigen_am || '').slice(0, 10) },
                files: [], existing: (t.attachments || []).slice(), taskRef: t };
            this.syncAv();
        },
        closeModal() { this.modal.open = false; },
        // queued (not-yet-uploaded) files
        addFiles(e) { this.modal.files.push(...Array.from(e.target.files || [])); e.target.value = ''; },
        removeFile(i) { this.modal.files.splice(i, 1); },
        // delete an already-stored attachment (immediate, with confirm)
        async delAttachment(att) {
            if (!confirm('Diesen Anhang löschen?')) return;
            const res = await getFetch('../deleteAttachment?id=' + encodeURIComponent(att.id));
            if (!res.ok) return;
            let i = this.modal.existing.findIndex(a => a.id === att.id);
            if (i > -1) this.modal.existing.splice(i, 1);
            if (this.modal.taskRef && this.modal.taskRef.attachments) {
                let j = this.modal.taskRef.attachments.findIndex(a => a.id === att.id);
                if (j > -1) this.modal.taskRef.attachments.splice(j, 1);
            }
        },
        async save() {
            const f = this.modal.form;
            if (!f.titel || !f.mitarbeiter || !f.erledigen_am) { this.modal.error = 'Bitte Titel, Mitarbeiter und Datum ausfüllen.'; return; }
            this.modal.saving = true; this.modal.error = '';
            const fd = new FormData();
            fd.append('titel', f.titel);
            fd.append('beschreibung', f.beschreibung || '');
            fd.append('mitarbeiter', f.mitarbeiter);
            fd.append('erledigen_am', f.erledigen_am);
            this.modal.files.forEach(file => fd.append('attachments[]', file));
            const url = this.modal.mode === 'create' ? '../addOrder' : '../updateAuf?id=' + encodeURIComponent(f.id);
            const res = await postMultipart(url, fd);
            if (res.ok) { this.closeModal(); await refreshContent(this.$root); }
            else { this.modal.error = 'Speichern fehlgeschlagen.'; this.modal.saving = false; }
        },
        async del(t) {
            if (!confirm('Diesen Auftrag wirklich löschen?')) return;
            const res = await getFetch('../deleteAuf?id=' + encodeURIComponent(t.id));
            if (res.ok) await refreshContent(this.$root);
        },
        async markDone(t) {
            const res = await getFetch('../changeStatus?id=' + encodeURIComponent(t.id));
            if (res.ok) await refreshContent(this.$root);
        },
        // ---- availability mini-calendar (selected employee, month of selected date)
        months: MONTHS_DE,
        syncAv() {
            const base = this.modal.form.erledigen_am ? new Date(this.modal.form.erledigen_am) : new Date(this.data.today || Date.now());
            this.avYear = base.getFullYear(); this.avMonth = base.getMonth();
        },
        avPrev() { if (this.avMonth === 0) { this.avMonth = 11; this.avYear--; } else this.avMonth--; },
        avNext() { if (this.avMonth === 11) { this.avMonth = 0; this.avYear++; } else this.avMonth++; },
        avToday() { const t = new Date(this.data.today || Date.now()); this.avYear = t.getFullYear(); this.avMonth = t.getMonth(); },
        get yearOptions() { const base = new Date(this.data.today || Date.now()).getFullYear(); const a = []; for (let y = base - 3; y <= base + 5; y++) a.push(y); return a; },
        isAvToday(iso) { return iso && iso === this.data.today; },
        handleKey(e) {
            if (!this.modal.open) return;
            const tag = (e.target && e.target.tagName ? e.target.tagName : '').toLowerCase();
            if (tag === 'input' || tag === 'select' || tag === 'textarea') return;
            if (e.key === 'ArrowLeft') { this.avPrev(); }
            else if (e.key === 'ArrowRight') { this.avNext(); }
        },
        get avGrid() { return buildMonthGrid(this.avYear, this.avMonth); },
        get avLabel() { return MONTHS_DE[this.avMonth] + ' ' + this.avYear; },
        empTasksOn(iso) {
            const emp = this.modal.form.mitarbeiter;
            if (!emp || !iso) return [];
            return this.data.tasks.filter(t =>
                String(t.mitarbeiterId) === String(emp) &&
                (t.erledigen_am || '').slice(0, 10) === iso &&
                String(t.id) !== String(this.modal.form.id));
        },
        dayMarker(iso) {
            const ts = this.empTasksOn(iso);
            if (!ts.length) return null;
            return { count: ts.length, bucket: repBucket(ts, this.data.today) };
        },
        get conflictCount() { return this.empTasksOn(this.modal.form.erledigen_am).length; },
        pickDate(iso) { if (iso) { this.modal.form.erledigen_am = iso; } },
        isSelected(iso) { return iso && iso === this.modal.form.erledigen_am; },
    };
}

/* ========================================================== MITARBEITER */
function mitarbeiterPage() {
    return {
        data: { today: '', tasks: [], employees: [], isAdmin: false },
        modal: { open: false, mode: 'create', saving: false, error: '', form: {} },
        init() { this.data = readPageData(this.$root); },
        openCreate() {
            this.modal = { open: true, mode: 'create', saving: false, error: '',
                form: { id: '', name: '', adresse: '', email: '' } };
        },
        openEdit(m) {
            this.modal = { open: true, mode: 'edit', saving: false, error: '',
                form: { id: m.id, name: m.name, adresse: m.adresse, email: m.email } };
        },
        closeModal() { this.modal.open = false; },
        async save() {
            const f = this.modal.form;
            if (!f.name || !f.adresse) { this.modal.error = 'Bitte Name und Adresse ausfüllen.'; return; }
            this.modal.saving = true; this.modal.error = '';
            const url = this.modal.mode === 'create' ? '../addEmploy' : '../updateMit?id=' + encodeURIComponent(f.id);
            const res = await postForm(url, { name: f.name, adresse: f.adresse, email: f.email || '' });
            if (res.ok) { this.closeModal(); await refreshContent(this.$root); }
            else { this.modal.error = 'Speichern fehlgeschlagen.'; this.modal.saving = false; }
        },
        async del(m) {
            if (!confirm('Diesen Mitarbeiter wirklich löschen?')) return;
            const res = await getFetch('../deleteMit?id=' + encodeURIComponent(m.id));
            if (res.status === 409) {
                const j = await res.json().catch(() => ({}));
                alert(j.error || 'Mitarbeiter kann nicht gelöscht werden.');
                return;
            }
            if (res.ok) await refreshContent(this.$root);
        },
    };
}

/* ------------------------------------------------------ register w/ Alpine */
document.addEventListener('alpine:init', () => {
    Alpine.data('uebersichtPage', uebersichtPage);
    Alpine.data('auftraegePage', auftraegePage);
    Alpine.data('mitarbeiterPage', mitarbeiterPage);
});
