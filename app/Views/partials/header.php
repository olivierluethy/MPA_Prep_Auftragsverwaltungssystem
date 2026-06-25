<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login");
    exit;
}

$pageTitle = $pageTitle ?? 'Aufträgeverwaltung';
$activeNav = $activeNav ?? '';
$isAdmin   = isset($_SESSION['istAdmin']) && isset($_SESSION['email'])
             && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != "";

function navClass(string $name, string $active): string
{
    $base = 'px-3 py-2 rounded-md text-sm font-medium transition-colors';
    return $name === $active
        ? $base . ' bg-zinc-800 text-zinc-100'
        : $base . ' text-zinc-400 hover:text-zinc-100 hover:bg-zinc-800/60';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <meta name="author" content="Olivier Luethy">
    <!-- Tailwind + Alpine are vendored locally (public/js) so the app works fully offline -->
    <script src="../public/js/tailwind.js"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen antialiased">

<nav class="sticky top-0 z-40 border-b border-zinc-800 bg-zinc-950/90 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 flex items-center justify-between h-14">
        <a href="../welt" class="flex items-center gap-2">
            <img src="../images/verwaltung.png" alt="" class="h-7 w-7">
            <span class="font-semibold tracking-tight text-zinc-100">Aufträgeverwaltung</span>
        </a>
        <div class="flex items-center gap-1">
            <a href="../welt"        class="<?= navClass('welt', $activeNav) ?>">Übersicht</a>
            <a href="../auftraege"   class="<?= navClass('auftraege', $activeNav) ?>">Aufträge</a>
            <a href="../mitarbeiter" class="<?= navClass('mitarbeiter', $activeNav) ?>">Mitarbeiter</a>
            <a href="../logout"      class="px-3 py-2 rounded-md text-sm font-medium text-zinc-400 hover:text-red-400 hover:bg-zinc-800/60 transition-colors">Logout</a>
        </div>
    </div>
</nav>
