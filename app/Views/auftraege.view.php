<?php
$pageTitle = 'Aufträge';
$activeNav = 'auftraege';
require __DIR__ . '/partials/header.php';

$pageData = [
    'today'     => date('Y-m-d'),
    'tasks'     => $auftraege,
    'employees' => $mitarbeiter,
    'isAdmin'   => $isAdmin,
];
?>
<main id="content" x-data="auftraegePage" x-cloak class="mx-auto max-w-7xl px-4 pb-10">
    <!-- Tailwind safelist for runtime-generated status classes -->
    <div class="hidden border-red-500 border-amber-500 border-emerald-500 border-zinc-600 bg-red-500/15 text-red-400 bg-amber-500/15 text-amber-400 bg-emerald-500/15 text-emerald-400 bg-zinc-700/40 text-zinc-300 bg-red-500 bg-amber-500 bg-emerald-500 bg-zinc-500"></div>

    <!-- sticky section header with always-visible add button -->
    <div class="sticky top-14 z-30 -mx-4 px-4 py-3 bg-zinc-950/95 backdrop-blur border-b border-zinc-800 flex items-center justify-between">
        <h1 class="text-xl font-semibold">Aufträge</h1>
        <button x-show="data.isAdmin" @click="openCreate()"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">+ Auftrag hinzufügen</button>
    </div>

    <!-- top-level tabs -->
    <div class="flex gap-1 border-b border-zinc-800 mt-4 mb-3">
        <button @click="setTab('offen')" class="px-4 py-2 text-sm font-medium -mb-px border-b-2"
                :class="tab==='offen' ? 'border-indigo-500 text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-100'"
                x-text="'Offene Aufträge (' + openTasks.length + ')'"></button>
        <button @click="setTab('erledigt')" class="px-4 py-2 text-sm font-medium -mb-px border-b-2"
                :class="tab==='erledigt' ? 'border-indigo-500 text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-100'"
                x-text="'Erledigte Aufträge (' + doneTasks.length + ')'"></button>
    </div>

    <!-- sub-tabs (only for open) -->
    <div x-show="tab==='offen'" class="flex flex-wrap gap-2 mb-4">
        <button @click="setSub('alle')" class="px-3 py-1 rounded-full text-xs font-medium border"
                :class="subtab==='alle' ? 'bg-zinc-800 border-zinc-700 text-zinc-100' : 'border-zinc-800 text-zinc-400 hover:text-zinc-100'"
                x-text="'Alle (' + openTasks.length + ')'"></button>
        <button @click="setSub('punktlich')" class="px-3 py-1 rounded-full text-xs font-medium border"
                :class="subtab==='punktlich' ? 'bg-emerald-500/15 border-emerald-500/40 text-emerald-300' : 'border-zinc-800 text-zinc-400 hover:text-zinc-100'"
                x-text="'Pünktlich (' + punktlich.length + ')'"></button>
        <button @click="setSub('heute')" class="px-3 py-1 rounded-full text-xs font-medium border"
                :class="subtab==='heute' ? 'bg-amber-500/15 border-amber-500/40 text-amber-300' : 'border-zinc-800 text-zinc-400 hover:text-zinc-100'"
                x-text="'Heute fällig (' + heute.length + ')'"></button>
        <button @click="setSub('ueberfaellig')" class="px-3 py-1 rounded-full text-xs font-medium border"
                :class="subtab==='ueberfaellig' ? 'bg-red-500/15 border-red-500/40 text-red-300' : 'border-zinc-800 text-zinc-400 hover:text-zinc-100'"
                x-text="'Überfällig (' + ueberfaellig.length + ')'"></button>
    </div>

    <!-- task table -->
    <div class="rounded-lg border border-zinc-800 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-900 text-zinc-400 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left font-medium px-3 py-2">Status</th>
                    <th class="text-left font-medium px-3 py-2">Titel</th>
                    <th class="text-left font-medium px-3 py-2">Beschreibung</th>
                    <th class="text-left font-medium px-3 py-2">Betroffene Person</th>
                    <th class="text-left font-medium px-3 py-2 whitespace-nowrap">Muss erledigt sein am</th>
                    <th class="text-left font-medium px-3 py-2">Anhänge</th>
                    <th class="text-left font-medium px-3 py-2" x-show="data.isAdmin">Bearbeiten</th>
                    <th class="text-left font-medium px-3 py-2" x-show="data.isAdmin">Löschen</th>
                    <th class="text-left font-medium px-3 py-2" x-show="data.isAdmin && tab==='offen'">Status</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="t in currentList" :key="t.id">
                    <tr class="odd:bg-zinc-900/50 even:bg-zinc-900 border-t border-zinc-800/60 align-top">
                        <td class="px-3 py-2 border-l-4" :class="BUCKET[bucket(t)].accent">
                            <span class="px-2 py-0.5 rounded text-xs font-medium whitespace-nowrap" :class="BUCKET[bucket(t)].badge" x-text="BUCKET[bucket(t)].label"></span>
                        </td>
                        <td class="px-3 py-2 font-medium text-zinc-100" x-text="t.titel"></td>
                        <td class="px-3 py-2 text-zinc-400 max-w-sm">
                            <div :class="expanded[t.id] ? '' : 'line-clamp-2'" x-text="t.beschreibung"></div>
                            <button type="button" class="text-indigo-400 hover:text-indigo-300 text-xs mt-0.5"
                                    x-show="t.beschreibung && t.beschreibung.length > 80"
                                    @click="toggleExpand(t.id)" x-text="expanded[t.id] ? 'weniger' : 'mehr'"></button>
                        </td>
                        <td class="px-3 py-2 text-zinc-300 whitespace-nowrap" x-text="t.name"></td>
                        <td class="px-3 py-2 text-zinc-300 whitespace-nowrap" x-text="deDate(t.erledigen_am)"></td>
                        <td class="px-3 py-2 text-zinc-400" x-text="t.anhang || '—'"></td>
                        <td class="px-3 py-2" x-show="data.isAdmin">
                            <button @click="openEdit(t)" class="text-xs px-2.5 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-200 whitespace-nowrap">Bearbeiten</button>
                        </td>
                        <td class="px-3 py-2" x-show="data.isAdmin">
                            <button @click="del(t)" class="text-xs px-2.5 py-1 rounded-md bg-red-600/90 hover:bg-red-600 text-white whitespace-nowrap">Löschen</button>
                        </td>
                        <td class="px-3 py-2" x-show="data.isAdmin && tab==='offen'">
                            <button @click="markDone(t)" class="text-xs px-2.5 py-1 rounded-md bg-emerald-600/90 hover:bg-emerald-600 text-white whitespace-nowrap">Erledigt</button>
                        </td>
                    </tr>
                </template>
                <tr x-show="currentList.length===0"><td colspan="9" class="px-3 py-8 text-center text-zinc-500">Keine Aufträge in dieser Ansicht</td></tr>
            </tbody>
        </table>
    </div>

    <!-- ============================== CREATE / EDIT MODAL ============================== -->
    <div x-show="modal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal()"></div>
        <div class="relative bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
            <h2 class="text-lg font-semibold mb-4" x-text="modal.mode==='create' ? 'Auftrag hinzufügen' : 'Auftrag bearbeiten'"></h2>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- form -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Titel</label>
                        <input type="text" x-model="modal.form.titel"
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Beschreibung</label>
                        <textarea x-model="modal.form.beschreibung" rows="3"
                                  class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Mitarbeiter</label>
                        <select x-model="modal.form.mitarbeiter" @change="syncAv()"
                                class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">— Mitarbeiter wählen —</option>
                            <template x-for="m in data.employees" :key="m.id">
                                <option :value="String(m.id)" x-text="m.id + ', ' + m.name"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Muss erledigt sein am</label>
                        <input type="date" x-model="modal.form.erledigen_am" @change="syncAv()"
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 [color-scheme:dark]">
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Anhang (Dateiname, optional)</label>
                        <input type="text" x-model="modal.form.file"
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- availability calendar -->
                <div>
                    <p class="text-sm text-zinc-300 mb-2">Verfügbarkeit
                        <span class="text-zinc-500" x-show="modal.form.mitarbeiter" x-text="'– ' + empName(modal.form.mitarbeiter)"></span>
                    </p>
                    <div x-show="!modal.form.mitarbeiter" class="text-sm text-zinc-500 border border-dashed border-zinc-700 rounded-lg p-6 text-center">
                        Bitte zuerst einen Mitarbeiter wählen, um die Auslastung zu sehen.
                    </div>
                    <div x-show="modal.form.mitarbeiter">
                        <div class="flex items-center justify-between mb-2">
                            <button type="button" @click="avPrev()" class="h-7 w-7 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-300">‹</button>
                            <span class="text-sm font-medium" x-text="avLabel"></span>
                            <button type="button" @click="avNext()" class="h-7 w-7 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-300">›</button>
                        </div>
                        <div class="grid grid-cols-7 gap-1">
                            <template x-for="(w,i) in weekdays" :key="i">
                                <div class="text-[10px] text-zinc-500 text-center" x-text="w"></div>
                            </template>
                            <template x-for="(cell,i) in avGrid" :key="i">
                                <button type="button"
                                        class="aspect-square rounded text-xs flex flex-col items-center justify-center relative"
                                        :class="!cell.date ? 'invisible' : (isSelected(cell.date) ? 'bg-indigo-600 text-white' : 'bg-zinc-800 hover:bg-zinc-700 text-zinc-300')"
                                        @click="pickDate(cell.date)">
                                    <span x-text="cell.day"></span>
                                    <template x-if="dayMarker(cell.date)">
                                        <span class="mt-0.5 h-1.5 w-1.5 rounded-full" :class="BUCKET[dayMarker(cell.date).bucket].dot"></span>
                                    </template>
                                </button>
                            </template>
                        </div>
                        <p class="text-xs mt-3" :class="conflictCount>0 ? 'text-amber-400' : 'text-zinc-500'"
                           x-text="conflictCount>0 ? (conflictCount + ' Auftrag(e) an diesem Tag bereits zugewiesen') : 'Keine weiteren Aufträge an diesem Tag'"></p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-6">
                <p x-show="modal.error" x-text="modal.error" class="text-red-400 text-sm mr-auto"></p>
                <button @click="closeModal()" class="px-4 py-2 rounded-md text-sm bg-zinc-800 hover:bg-zinc-700 text-zinc-200">Abbrechen</button>
                <button @click="save()" :disabled="modal.saving"
                        class="px-4 py-2 rounded-md text-sm bg-indigo-600 hover:bg-indigo-500 text-white disabled:opacity-50"
                        x-text="modal.saving ? 'Speichern…' : 'Speichern'"></button>
            </div>
        </div>
    </div>

    <script type="application/json" id="page-data"><?= json_encode($pageData, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?></script>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
