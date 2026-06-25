<?php
$pageTitle = 'Mitarbeiter hinzufügen';
$activeNav = 'mitarbeiter';
require __DIR__ . '/partials/header.php';
?>
<main class="mx-auto max-w-xl px-4 py-6">
    <h1 class="text-xl font-semibold mb-4">Mitarbeiter hinzufügen</h1>
    <form action="addEmploy" method="post" class="space-y-4 bg-zinc-900 border border-zinc-800 rounded-xl p-6">
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Name</label>
            <input type="text" name="name" required class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Adresse</label>
            <input type="text" name="adresse" required class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-zinc-400 mb-1">Email</label>
            <input type="email" name="email" class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md">Mitarbeiter hinzufügen</button>
            <a href="../mitarbeiter" class="px-4 py-2 rounded-md text-sm bg-zinc-800 hover:bg-zinc-700 text-zinc-200">Abbrechen</a>
        </div>
    </form>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
