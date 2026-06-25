<?php
$pageTitle = 'Übersicht';
$activeNav = 'welt';
require __DIR__ . '/partials/header.php';

$pageData = [
    'today'     => date('Y-m-d'),
    'tasks'     => $auftraege,
    'employees' => $mitarbeiter,
    'isAdmin'   => $isAdmin,
];
?>
<main id="content" x-data="uebersichtPage" x-cloak class="mx-auto max-w-7xl px-4 py-6">
    <!-- Tailwind safelist for runtime-generated status classes -->
    <div class="hidden border-red-500 border-amber-500 border-emerald-500 border-zinc-600 bg-red-500/15 text-red-400 bg-amber-500/15 text-amber-400 bg-emerald-500/15 text-emerald-400 bg-zinc-700/40 text-zinc-300 bg-red-500 bg-amber-500 bg-emerald-500 bg-zinc-500"></div>

    <h1 class="text-xl font-semibold mb-4">Übersicht</h1>

    <!-- sub-tabs -->
    <div class="flex gap-1 border-b border-zinc-800 mb-4">
        <button @click="setTab('auftraege')" class="px-4 py-2 text-sm font-medium -mb-px border-b-2"
                :class="tab==='auftraege' ? 'border-indigo-500 text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-100'">Aufträge</button>
        <button @click="setTab('mitarbeiter')" class="px-4 py-2 text-sm font-medium -mb-px border-b-2"
                :class="tab==='mitarbeiter' ? 'border-indigo-500 text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-100'">Mitarbeiter</button>
        <button @click="setTab('kalender')" class="px-4 py-2 text-sm font-medium -mb-px border-b-2"
                :class="tab==='kalender' ? 'border-indigo-500 text-zinc-100' : 'border-transparent text-zinc-400 hover:text-zinc-100'">Kalender</button>
    </div>

    <!-- ===== Aufträge ===== -->
    <div x-show="tab==='auftraege'" class="rounded-lg border border-zinc-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-900 text-zinc-400 text-xs uppercase tracking-wide">
                <tr class="sticky top-14">
                    <th class="text-left font-medium px-3 py-2">Status</th>
                    <th class="text-left font-medium px-3 py-2">Titel</th>
                    <th class="text-left font-medium px-3 py-2">Beschreibung</th>
                    <th class="text-left font-medium px-3 py-2">Betroffene Person</th>
                    <th class="text-left font-medium px-3 py-2">Muss erledigt sein am</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="t in data.tasks" :key="t.id">
                    <tr class="odd:bg-zinc-900/50 even:bg-zinc-900 border-t border-zinc-800/60">
                        <td class="px-3 py-2 border-l-4" :class="BUCKET[bucket(t)].accent">
                            <span class="px-2 py-0.5 rounded text-xs font-medium whitespace-nowrap" :class="BUCKET[bucket(t)].badge" x-text="BUCKET[bucket(t)].label"></span>
                        </td>
                        <td class="px-3 py-2 font-medium text-zinc-100" x-text="t.titel"></td>
                        <td class="px-3 py-2 text-zinc-400 max-w-xs"><span class="line-clamp-1" x-text="t.beschreibung"></span></td>
                        <td class="px-3 py-2 text-zinc-300" x-text="t.name"></td>
                        <td class="px-3 py-2 text-zinc-300 whitespace-nowrap" x-text="deDate(t.erledigen_am)"></td>
                    </tr>
                </template>
                <tr x-show="data.tasks.length===0"><td colspan="5" class="px-3 py-6 text-center text-zinc-500">Es wurde noch kein Auftrag hinzugefügt</td></tr>
            </tbody>
        </table>
    </div>

    <!-- ===== Mitarbeiter ===== -->
    <div x-show="tab==='mitarbeiter'" class="rounded-lg border border-zinc-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-zinc-900 text-zinc-400 text-xs uppercase tracking-wide">
                <tr class="sticky top-14">
                    <th class="text-left font-medium px-3 py-2">Name</th>
                    <th class="text-left font-medium px-3 py-2">Adresse</th>
                    <th class="text-left font-medium px-3 py-2">Email</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="m in data.employees" :key="m.id">
                    <tr class="odd:bg-zinc-900/50 even:bg-zinc-900 border-t border-zinc-800/60">
                        <td class="px-3 py-2 font-medium text-zinc-100" x-text="m.name"></td>
                        <td class="px-3 py-2 text-zinc-400" x-text="m.adresse"></td>
                        <td class="px-3 py-2 text-zinc-400" x-text="m.email"></td>
                    </tr>
                </template>
                <tr x-show="data.employees.length===0"><td colspan="3" class="px-3 py-6 text-center text-zinc-500">Es wurde noch kein Mitarbeiter hinzugefügt</td></tr>
            </tbody>
        </table>
    </div>

    <!-- ===== Kalender ===== -->
    <div x-show="tab==='kalender'">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
            <select x-model="selEmp" @change="_persist()" class="bg-zinc-800 border border-zinc-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="all">Alle Mitarbeiter</option>
                <template x-for="m in data.employees" :key="m.id"><option :value="m.id" x-text="m.name"></option></template>
            </select>
            <div class="flex items-center gap-2">
                <button @click="calPrev()" class="h-8 w-8 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-300">‹</button>
                <span x-text="calLabel" class="text-sm font-medium w-36 text-center"></span>
                <button @click="calNext()" class="h-8 w-8 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-300">›</button>
            </div>
        </div>
        <div class="grid grid-cols-7 gap-px bg-zinc-800 border border-zinc-800 rounded-lg overflow-hidden">
            <template x-for="(w,i) in weekdays" :key="i">
                <div class="bg-zinc-900 text-zinc-400 text-xs font-medium px-2 py-1.5 text-center" x-text="w"></div>
            </template>
            <template x-for="(cell,i) in calGrid" :key="i">
                <div class="bg-zinc-950 min-h-[6rem] p-1.5" :class="cell.date && isToday(cell.date) ? 'ring-1 ring-inset ring-indigo-500' : ''">
                    <div class="text-xs text-zinc-500 mb-1" x-text="cell.day"></div>
                    <div class="space-y-1">
                        <template x-for="t in tasksOn(cell.date)" :key="t.id">
                            <div class="text-[10px] leading-tight px-1.5 py-0.5 rounded truncate border-l-2"
                                 :class="BUCKET[bucket(t)].accent + ' ' + BUCKET[bucket(t)].badge"
                                 :title="t.titel + ' — ' + t.name"
                                 x-text="t.titel"></div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
        <div class="flex flex-wrap gap-4 mt-3 text-xs text-zinc-400">
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>Überfällig</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>Heute fällig</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>Pünktlich</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-zinc-500"></span>Erledigt</span>
        </div>
    </div>

    <script type="application/json" id="page-data"><?= json_encode($pageData, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?></script>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
