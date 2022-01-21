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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/css/addPage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/verwaltung.png">
    <meta name="author" content="Olivier Luethy">
    <title>Mitarbeiter hinzufügen</title>
</head>
<body>
    <h1>Mitarbeiter hinzufügen</h1>

     <form action="addEmploy" method="post">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" require><br><br>

        <label for="adresse">Adresse:</label><br>
        <input type="text" name="adresse" id="adresse" require><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email"><br><br>
      
        <button class="reset" type="reset"><i class="fas fa-undo"></i> Reset</button>
        <button type="submit" name="form-submit"><i class="fas fa-plus"></i> Mitarbeiter hinzufügen</button>
    </form>
    <script src="../public/js/clientSideValidationMitarbeiter.js"></script>
</body>
</html>