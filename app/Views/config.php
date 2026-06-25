<?php
/* Datenbank-Zugangsdaten.
   Werden aus Umgebungsvariablen gelesen (Docker). Fallback auf lokale
   XAMPP-Defaults (Benutzer 'root' ohne Passwort), damit das Projekt auch
   ohne Docker lokal läuft. */
define('DB_SERVER',   getenv('DB_HOST')     ?: 'localhost');
define('DB_USERNAME', getenv('DB_USER')     ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '');
define('DB_NAME',     getenv('DB_NAME')     ?: 'minipaprep');
define('DB_PORT',     (int) (getenv('DB_PORT') ?: 3306));

/* Verbindung zur MySQL-Datenbank aufbauen */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Verbindung prüfen
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
