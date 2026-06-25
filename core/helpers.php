<?php
/**
 * Nutze diese Funktion um einfach eine Ausgabe
 * mit htmlspecialchars() zu erstellen.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Nutze diese Funktion um auf einen POST-Wert
 * zuzugreifen.
 */
function post(string $key, $default = '')
{
    return $_POST[$key] ?? $default;
}

/**
 * Stellt eine Verbindung zur Datenbank her und gibt die
 * Datenbankverbindung als PDO zurück.
 */
$dbInstance = null;

function db(): PDO
{
    global $dbInstance;

    if ($dbInstance) {
        return $dbInstance;
    }

    try {
        $dbInstance = new PDO('mysql:host=127.0.0.1;dbname=' . $db['name'], $db['username'], $db['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}

/**
 * Formatiert ein ISO-Datum (Y-m-d) als Schweizer Format DD.MM.YYYY.
 */
function formatDate(?string $iso): string
{
    if (!$iso) {
        return '';
    }
    $d = DateTime::createFromFormat('Y-m-d', substr($iso, 0, 10));
    return $d ? $d->format('d.m.Y') : $iso;
}

/**
 * Status-Bucket eines Auftrags relativ zu "heute".
 * Liefert: 'done' | 'overdue' | 'today' | 'upcoming'
 */
function taskBucket(?string $erledigen_am, $status): string
{
    if ((int) $status === 1) {
        return 'done';
    }
    if (!$erledigen_am) {
        return 'upcoming';
    }
    $today = new DateTime('today');
    $due   = new DateTime(substr($erledigen_am, 0, 10));
    if ($due < $today) {
        return 'overdue';
    }
    if ($due == $today) {
        return 'today';
    }
    return 'upcoming';
}

/**
 * Tailwind-Klassen + Label pro Bucket: [linker Akzent-Border, Badge-Klassen, Label].
 */
function bucketStyle(string $bucket): array
{
    $map = [
        'overdue'  => ['border-red-500',     'bg-red-500/15 text-red-400',        'Überfällig'],
        'today'    => ['border-amber-500',   'bg-amber-500/15 text-amber-400',    'Heute fällig'],
        'upcoming' => ['border-emerald-500', 'bg-emerald-500/15 text-emerald-400','Pünktlich'],
        'done'     => ['border-zinc-600',    'bg-zinc-700/40 text-zinc-300',      'Erledigt'],
    ];
    return $map[$bucket] ?? $map['upcoming'];
}