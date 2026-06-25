<?php
$pageTitle = 'Auftrag hinzufügen';
$activeNav = 'auftraege';
require __DIR__ . '/partials/header.php';
?>
<main class="mx-auto max-w-xl px-4 py-6">
    <h1 class="text-xl font-semibold mb-4">Auftrag hinzufügen</h1>
    <form action="addOrder" method="post" class="space-y-4 bg-zinc-900 border border-zinc-800 rounded-xl p-6">
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Titel</label>
            <input type="text" name="titel" required class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Beschreibung</label>
            <textarea name="beschreibung" rows="4" class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Mitarbeiter</label>
            <select name="mitarbeiter" required class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <?php foreach ($mitarbeiter as $m) : ?>
                    <option value="<?= e((string) $m['id']) ?>"><?= e($m['id'] . ', ' . $m['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Anhang (Dateiname, optional)</label>
            <input type="text" name="file" class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Muss erledigt sein am</label>
            <input type="date" name="erledigen_am" required class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 [color-scheme:dark]">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md">Auftrag hinzufügen</button>
            <a href="../auftraege" class="px-4 py-2 rounded-md text-sm bg-zinc-800 hover:bg-zinc-700 text-zinc-200">Abbrechen</a>
        </div>
    </form>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
