<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/addPage.css">
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <meta name="author" content="Olivier Luethy">
    <title>Auftrag hinzufügen</title>
</head>
<body>
    <h1>Auftrag hinzufügen</h1>

    <form action="addOrder" method="post">
        <label for="titel">Titel:</label><br>
        <input type="text" name="titel" id="titel" require><br><br>

        <label for="beschreibung">Beschreibung:</label><br>
        <textarea type="text" name="beschreibung" id="beschreibung" rows="4" cols="50" require></textarea><br><br>

        <label for="fname">Mitarbeiter:</label><br>

        <select name="mitarbeiter" id="cars" require>

        <?php foreach ($mitarbeiter as $mitarbeiters) : ?>
            <option><?= $mitarbeiters['id'] ?> <?= $mitarbeiters['name'] ?></option>
        <?php endforeach; ?>

        </select><br><br>

        <label for="file">Datei hinzufügen:</label><br>
        <input type="file" name="file" id="file" require><br><br>

        <label for="erledigen_am">Erledigen am:</label><br>
        <input type="date" name="erledigen_am" id="erledigen_am" require><br><br>
        
        <button class="reset" type="reset">Reset</button>
        <button type="submit" name="form-submit">Auftrag hinzufügen</button>
    </form>
    <script src="../public/js/clientSideValidationAuftraege.js"></script>
</body>
</html>