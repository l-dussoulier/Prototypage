<?php


$servername = "localhost";
$username = "root";
$password = "root";
try {

    // récuperation température
    $bdd = new PDO("mysql:host=$servername;dbname=prototype", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $result = $bdd->prepare("SELECT * FROM Capteur WHERE TypeC = 'Temperature' ORDER BY DateCreation DESC limit 1");
    $result->execute();
    $Temp = ($result->fetch(PDO::FETCH_OBJ));
    if ($Temp != null) {
        echo $Temp->Valeur;
    } else {
        echo "erreur retour temperature";
    }


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}