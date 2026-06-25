<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}

$dataCounter = 0;
$dataCounter1 = 0;
$dataCounter2 = 0;

foreach ($auftraege as $auftraeges){
    $dataCounter++;
}

foreach ($auftraege1 as $auftraeges1){
    $dataCounter1++;
}

foreach ($auftraege2 as $auftraeges2){
    $dataCounter2++;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Aufträge</title>
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
        <a class='active' href='../auftraege'>Aufträge</a>
        <a href='../mitarbeiter'>Mitarbeiter</a>
        <a href='../logout'>Logout</a>
    </div>";
    }else{
        echo "<div class='anchors'>
        <a href='../welt'>Übersicht</a>
        <a class='active' href='../auftraege'>Aufträge</a>
        <a href='../mitarbeiter'>Mitarbeiter</a>
        <a href='../login'>Login</a>
    </div>";
    }?>
</nav>

<main>
    <h1><u>Aufträge</u></h1>

    <?php
    if ($dataCounter > 0){
        if($dataCounter1 > 0){
            echo "<p style='color: red; font-weight: bold;'>Offene Aufträge ($dataCounter1)</p>";

            echo "<table>";

            if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != "") {
                echo "<tr>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Betroffene Person</th>
                <th>Muss erledigt sein am</th>
                <th>Anhänge</th>
                <th>Bearbeiten</th>
                <th>Löschen</th>
                <th>Status</th>
            </tr>";
            } else {
                echo "<tr>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Betroffene Person</th>
                <th>Muss erledigt sein am</th>
                <th>Anhänge</th>
            </tr>";
            }

            foreach ($auftraege1 as $auftraeges1){
                echo "<tr>";
                if(new DateTime() > new DateTime($auftraeges1['erledigen_am'])){
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges1['titel'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges1['beschreibung'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges1['name'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges1['erledigen_am'] . "</td>";
                    echo "<td style='background-color: lightcoral;'>" . $auftraeges1['document'] . "</td>";

                    if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
                        echo "<td style='background-color: lightcoral;'><a href='updateAuf?id=" . $auftraeges1['id'] . "'><button class='edit'>Bearbeiten</button></a></td>";
                        echo "<td style='background-color: lightcoral;'><a href='deleteAuf?id=" . $auftraeges1['id'] . "'><button class='delete'>Löschen</button></a></td>";
                        echo "<td style='background-color: lightcoral;'><a href='changeStatus?id=" . $auftraeges1['id'] . "'><button class='finish'>Offen</button></a></td>";
                    }else{
                        echo "";
                    }
                }
                else{
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges1['titel'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges1['beschreibung'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges1['name'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges1['erledigen_am'] . "</td>";
                    echo "<td style='background-color: lightgreen;'>" . $auftraeges1['document'] . "</a></td>";

                    if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
                        echo "<td style='background-color: lightgreen;'><a href='updateAuf?id=" . $auftraeges1['id'] . "'><button class='edit'>Bearbeiten</button></a></td>";
                        echo "<td style='background-color: lightgreen;'><a href='deleteAuf?id=" . $auftraeges1['id'] . "'><button class='delete'>Löschen</button></a></td>";
                        echo "<td style='background-color: lightgreen;'><a href='changeStatus?id=" . $auftraeges1['id'] . "'><button class='finish'>Offen</button></a></td>";
                    }else{
                        echo "";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        if($dataCounter2 > 0){
            echo "<p style='color: #34eb43; font-weight: bold';>Erledigte Aufträge ($dataCounter2)</p>";

            echo "<table>";

            if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
                echo "<tr>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Betroffene Person</th>
                <th>Muss erledigt sein am</th>
                <th>Anhänge</th>
                <th>Löschen</th>
                <th>Status</th>
            </tr>";
            }else{
                echo "<tr>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Betroffene Person</th>
                <th>Muss erledigt sein am</th>
            </tr>";
            }
            
            foreach ($auftraege2 as $auftraeges2){
                echo "<tr>";
                echo "<td>" . $auftraeges2['titel'] . "</td>";
                echo "<td>" . $auftraeges2['beschreibung'] . "</td>";
                echo "<td>" . $auftraeges2['name'] . "</td>";
                echo "<td>" . $auftraeges2['erledigen_am'] . "</td>";
                echo "<td>" . $auftraeges2['document'] . "</td>";

                if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
                    echo "<td><a href='deleteAuf?id=" . $auftraeges2['id'] . "'><button class='delete'>Löschen</button></a></td>";
                    echo "<td><button class='finishReal'>Erledigt</button></td>";
                }else{
                    echo "";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }else{
        echo "<h1 style='color: red';>Es wurde noch kein Auftrag hinzugefügt</h1>";
    }    
    
    if (isset($_SESSION['istAdmin']) && isset($_SESSION['email']) && $_SESSION['istAdmin'] == '1' && $_SESSION['email'] != ""){
        echo "<button class='hinzufuegen' onclick='addOrder()'>Auftrag hinzufügen</button><br><br><br>";
    }else {
        echo "";
    }?>
    
</main>


<script src="../public/js/app.js"></script>
</body>
</html>
