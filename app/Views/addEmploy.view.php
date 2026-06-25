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
      
        <button class="reset" type="reset">Reset</button>
        <button type="submit" name="form-submit">Mitarbeiter hinzufügen</button>
    </form>
    <script src="../public/js/clientSideValidationMitarbeiter.js"></script>
</body>
</html>