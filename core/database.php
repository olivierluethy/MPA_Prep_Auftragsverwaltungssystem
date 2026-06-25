<?php

/**
 * Stellt eine PDO-Verbindung zur MySQL-Datenbank her.
 *
 * Die Zugangsdaten werden aus Umgebungsvariablen gelesen (so wie sie von
 * Docker gesetzt werden). Wenn keine gesetzt sind, werden die klassischen
 * lokalen XAMPP-Defaults verwendet (root ohne Passwort auf 127.0.0.1) –
 * dadurch funktioniert das Projekt sowohl in Docker als auch lokal.
 */
function connectDatabase() {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'minipaprep';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASSWORD');
    if ($pass === false) {
        $pass = '';
    }

    $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";

    try {
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}
