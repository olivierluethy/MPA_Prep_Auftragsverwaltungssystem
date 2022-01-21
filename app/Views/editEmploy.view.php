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
    <title>Mitarbeiter bearbeiten</title>
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <link rel="stylesheet" href="../public/css/editPage.css">
    <meta name="author" content="Olivier Luethy">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Mitarbeiterdaten bearbeiten</h1>

    <form action="updateMit?id=<?= $auftraege[0][0] ?>" method="post">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" value="<?= $auftraege[0][1] ?>"><br><br>

        <label for="email">Adresse:</label><br>
        <textarea type="text" name="adresse" id="adresse" rows="4" cols="50"><?= $auftraege[0][2] ?></textarea><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= $auftraege[0][3] ?>"><br><br>
        <button type="submit" name="form-submit"><i class='fas fa-edit'></i> Auftrag bearbeiten</button>
    </form>
    <script src="../public/js/clientSideValidationMitarbeiter.js"></script>
</body>

</html>