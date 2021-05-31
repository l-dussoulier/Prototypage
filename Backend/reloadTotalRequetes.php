<?php


$servername = "localhost";
$username = "root";
$password = "root";
try {

// récuperation total requetes
    $bdd = new PDO("mysql:host=$servername;dbname=prototype", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $result = $bdd->prepare("SELECT count(Id) from Capteur");
    $result->execute();
    $Temp = ($result->fetch(PDO::FETCH_OBJ));
    echo $Temp->Valeur;



} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}