<?php


$servername = "localhost";
$username = "root";
$password = "root";
try {

// récuperation total requetes
    $bdd = new PDO("mysql:host=$servername;dbname=prototype", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $result = $bdd->query("SELECT count(Id) as nbRequetes from Capteur");
    $donnes = $result->fetch();
    echo $donnes['nbRequetes'];



} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}