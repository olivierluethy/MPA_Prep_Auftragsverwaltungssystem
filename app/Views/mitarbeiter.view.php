<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}

$dataCounter = 0;

foreach ($mitarbeiter as $mitarbeiters){
    $dataCounter++;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Mitarbeiter</title>
    <link rel="stylesheet" href="../public/css/app.css">


    <link rel="shortcut icon" href="../images/verwaltung.png">
    <meta name="author" content="Olivier Luethy">
</head>
<body>

<nav>
    <div class="title">
        <img src="../images/verwaltung.png" alt="">
        <h1>Aufträgeverwaltung</h1>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) == true){
        echo "<div class='anchors'>
        <a href='../welt'>Übersicht</a>
        <a href='../auftraege'>Aufträge</a>
        <a class='active' href='../mitarbeiter'>Mitarbeiter</a>
        <a href='../logout'>Logout</a>
    </div>";
    }else{
        echo "<div class='anchors'>
        <a class='active' href='../welt'>Übersicht</a>
        <a href='../auftraege'>Aufträge</a>
        <a class='active' href='../mitarbeiter'>Mitarbeiter</a>
        <a href='../login'>Login</a>
    </div>";
    }?>
</nav>

<main>
    <h1><u>Mitarbeiter</u></h1>

    <table>
    <?php
    if($dataCounter > 0){
        if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
            echo "<tr>
            <th>Name</th>
            <th>Adresse</th>
            <th>Email</th>
            <th>Bearbeiten</th>
            <th>Löschen</th>
        </tr>";
        }else{
            echo "<tr>
            <th>Name</th>
            <th>Adresse</th>
            <th>Email</th>
        </tr>";
        }
        
        foreach ($mitarbeiter as $mitarbeiters){
            echo "<tr>";
            echo "<td>" . $mitarbeiters['name'] . "</td>";
            echo "<td>" . $mitarbeiters['adresse'] . "</td>";
            echo "<td>" . $mitarbeiters['email'] . "</td>";
            if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
                echo "<td><a href='updateMit?id=" . $mitarbeiters['id'] . "'><button class='edit'>Bearbeiten</button></a></td>";
                echo "<td><a href='deleteMit?id=" . $mitarbeiters['id'] . "'><button class='delete'>Löschen</button></a></td>";
            }else{
                echo "";
            }
            
            echo "</tr>";
        }
    }else{
        echo "<h1 style='color: red';>Es wurde noch kein Mitarbeiter hinzugefügt</h1>";
    }?>

    </table>

    <?php
    if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
        echo "<button class='hinzufuegen' onclick='addEmployee()'>Mitarbeiter hinzufügen</button>";
    }else{
        echo "";
    }?>

</main>

<script src="../public/js/app.js"></script>
</body>
</html>
