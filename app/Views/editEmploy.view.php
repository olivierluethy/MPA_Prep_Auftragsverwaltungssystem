<?php
$pageTitle = 'Mitarbeiter bearbeiten';
$activeNav = 'mitarbeiter';
require __DIR__ . '/partials/header.php';
$row = $auftraege[0] ?? ['id' => '', 'name' => '', 'adresse' => '', 'email' => ''];
?>
<main class="mx-auto max-w-xl px-4 py-6">
    <h1 class="text-xl font-semibold mb-4">Mitarbeiterdaten bearbeiten</h1>
    <form action="updateMit?id=<?= e((string) $row['id']) ?>" method="post" class="space-y-4 bg-zinc-900 border border-zinc-800 rounded-xl p-6">
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Name</label>
            <input type="text" name="name" value="<?= e($row['name']) ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Adresse</label>
            <input type="text" name="adresse" value="<?= e($row['adresse']) ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Email</label>
            <input type="email" name="email" value="<?= e($row['email']) ?>" class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md">Speichern</button>
            <a href="../mitarbeiter" class="px-4 py-2 rounded-md text-sm bg-zinc-800 hover:bg-zinc-700 text-zinc-200">Abbrechen</a>
        </div>
    </form>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
