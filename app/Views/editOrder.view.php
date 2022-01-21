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
    <title>Auftrag bearbeiten</title>
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <meta name="author" content="Olivier Luethy">
    <link rel="stylesheet" href="../public/css/editPage.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Auftragsdaten bearbeiten</h1>

    <form action="updateAuf?id=<?= $auftraege[0][0] ?>" method="post">
        <label for="titel">Titel:</label><br>
        <input type="text" name="titel" id="titel" value="<?= $auftraege[0][1] ?>"><br><br>

        <label for="beschreibung">Beschreibung:</label><br>
        <textarea type="text" name="beschreibung" id="beschreibung" rows="4" cols="50"><?= $auftraege[0][2] ?></textarea><br><br>

        <label for="mitarbeiter">Mitarbeiter:</label><br>

        <select name="mitarbeiter" id="mitarbeiter" require>

        <?php 
        foreach ($mitarbeiter as $mitarbeiters){
            if ($auftraege[0][3] == $mitarbeiters['id']){
                echo "<option value='" . $mitarbeiters['id'] . "' selected>" . $mitarbeiters['id'] . ", " . $mitarbeiters['name'] . "</option>";
            }else{
                echo "<option value='" . $mitarbeiters['id'] . "'>" . $mitarbeiters['id'] . ", " . $mitarbeiters['name'] . "</option>";
            }
        }?>

        </select><br><br>

        <label for="email">Erledigen am:</label><br>
        <input type="date" name="erledigen_am" value="<?= $auftraege[0][4] ?>"><br><br>
        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Auftrag bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidationAuftraege.js"></script>
</body>

</html>