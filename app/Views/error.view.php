<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../hallo/login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/error.css">
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <h1>Der Mitarbeiter kann nicht gelöscht werden, da er einer Aufgabe zugeteilt worden ist. </h1>
    <h1>Löschen sie zuerst die zugeteilte Aufgabe und probieren sie es noch einmal.</h1>
    <a href="mitarbeiter"><button><i class="fas fa-long-arrow-alt-left"></i> Zurück zu den Mitarbeitern</button></a>
</body>
</html>