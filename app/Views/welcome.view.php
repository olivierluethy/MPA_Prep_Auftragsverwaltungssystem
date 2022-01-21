<?php
session_start();

$dataCounter = 0;
$dataCounter2 = 0;

foreach ($auftraege as $auftraeges){
    $dataCounter++;
}

foreach ($mitarbeiter as $mitarbeiters){
    $dataCounter2++;
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../hallo/login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Übersicht</title>
    <link rel="stylesheet" href="../public/css/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
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
        <a class='active' href='../hallo/welt'>Übersicht</a>
        <a href='../hallo/auftraege'>Aufträge</a>
        <a href='../hallo/mitarbeiter'>Mitarbeiter</a>
        <a href='../hallo/logout'>Logout</a>
    </div>";
    }else{
        echo "<div class='anchors'>
        <a class='active' href='../hallo/welt'>Übersicht</a>
        <a href='../hallo/auftraege'>Aufträge</a>
        <a href='../hallo/mitarbeiter'>Mitarbeiter</a>
        <a href='../hallo/login'>Login</a>
    </div>";
    }?>
</nav>

<main>
    <h1><u>Übersicht aller Aufträge</u></h1>
    
    <table>
        <?php
        if($dataCounter > 0){
            echo "<tr>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Betroffene Person</th>
                <th>Muss erledigt sein am</th>
                </tr>";
            foreach ($auftraege as $auftraeges){
                echo "<tr>";
                if (new DateTime() > new DateTime($auftraeges['erledigen_am'])){
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges['titel'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges['beschreibung'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges['name'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges['erledigen_am'] . "</td>";
                }else{
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges['titel'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges['beschreibung'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges['name'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges['erledigen_am'] . "</td>";
                }
                
                echo "</tr>";
            }
        }else{
            echo "<h1 style='color: red';>Es wurde noch kein Auftrag hinzugefügt</h1>";
        }?>

    </table>

    <h1><u>Übersicht aller Mitarbeiter</u></h1>
    
    <table>
        <?php
        if($dataCounter2 > 0){
            echo "<tr>
                <th>Name</th>
                <th>Adresse</th>
                <th>Email</th>
                </tr>";
            foreach ($mitarbeiter as $mitarbeiters){
                echo "<tr>";
                echo "<td>" . $mitarbeiters['name'] . "</td>";
                echo "<td>" . $mitarbeiters['adresse'] . "</td>";
                echo "<td>" . $mitarbeiters['email'] . "</td>";
                echo "</tr>";
            }
        }else{
            echo "<h1 style='color: red';>Es wurde noch kein Mitarbeiter hinzugefügt</h1>";
        }?>
        
    </table>

</main>

<script src="../public/js/app.js"></script>
</body>
</html>
