<?php
$pageTitle = 'Mitarbeiter';
$activeNav = 'mitarbeiter';
require __DIR__ . '/partials/header.php';

$pageData = [
    'today'     => date('Y-m-d'),
    'tasks'     => [],
    'employees' => $mitarbeiter,
    'isAdmin'   => $isAdmin,
];
?>
<main id="content" x-data="mitarbeiterPage" x-cloak class="mx-auto max-w-7xl px-4 pb-10">

    <!-- sticky section header with always-visible add button -->
    <div class="sticky top-14 z-30 -mx-4 px-4 py-3 bg-zinc-950/95 backdrop-blur border-b border-zinc-800 flex items-center justify-between">
        <h1 class="text-xl font-semibold">Mitarbeiter</h1>
        <button x-show="data.isAdmin" @click="openCreate()"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">+ Mitarbeiter hinzufügen</button>
    </div>

    <div class="rounded-lg border border-zinc-800 overflow-x-auto mt-4">
        <table class="w-full text-sm">
            <thead class="bg-zinc-900 text-zinc-400 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left font-medium px-3 py-2">Name</th>
                    <th class="text-left font-medium px-3 py-2">Adresse</th>
                    <th class="text-left font-medium px-3 py-2">Email</th>
                    <th class="text-left font-medium px-3 py-2" x-show="data.isAdmin">Bearbeiten</th>
                    <th class="text-left font-medium px-3 py-2" x-show="data.isAdmin">Löschen</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="m in data.employees" :key="m.id">
                    <tr class="odd:bg-zinc-900/50 even:bg-zinc-900 border-t border-zinc-800/60">
                        <td class="px-3 py-2 font-medium text-zinc-100" x-text="m.name"></td>
                        <td class="px-3 py-2 text-zinc-400" x-text="m.adresse"></td>
                        <td class="px-3 py-2 text-zinc-400" x-text="m.email"></td>
                        <td class="px-3 py-2" x-show="data.isAdmin">
                            <button @click="openEdit(m)" class="text-xs px-2.5 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-200">Bearbeiten</button>
                        </td>
                        <td class="px-3 py-2" x-show="data.isAdmin">
                            <button @click="del(m)" class="text-xs px-2.5 py-1 rounded-md bg-red-600/90 hover:bg-red-600 text-white">Löschen</button>
                        </td>
                    </tr>
                </template>
                <tr x-show="data.employees.length===0"><td colspan="5" class="px-3 py-8 text-center text-zinc-500">Es wurde noch kein Mitarbeiter hinzugefügt</td></tr>
            </tbody>
        </table>
    </div>

    <!-- ============================== CREATE / EDIT MODAL ============================== -->
    <div x-show="modal.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal()"></div>
        <div class="relative bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4" x-text="modal.mode==='create' ? 'Mitarbeiter hinzufügen' : 'Mitarbeiter bearbeiten'"></h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs text-zinc-400 mb-1">Name</label>
                    <input type="text" x-model="modal.form.name"
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs text-zinc-400 mb-1">Adresse</label>
                    <input type="text" x-model="modal.form.adresse"
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs text-zinc-400 mb-1">Email</label>
                    <input type="email" x-model="modal.form.email"
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
