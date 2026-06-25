<?php
$pageTitle = 'Fehler';
$activeNav = 'mitarbeiter';
require __DIR__ . '/partials/header.php';
?>
<main class="mx-auto max-w-2xl px-4 py-16 text-center">
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-8">
        <h1 class="text-lg font-semibold text-red-400 mb-2">Der Mitarbeiter kann nicht gelöscht werden, da er einer Aufgabe zugeteilt worden ist.</h1>
        <p class="text-zinc-400 mb-6">Löschen sie zuerst die zugeteilte Aufgabe und probieren sie es noch einmal.</p>
        <a href="../mitarbeiter" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-4 py-2 rounded-md">Zurück zu den Mitarbeitern</a>
    </div>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
