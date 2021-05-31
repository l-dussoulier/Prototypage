<?php

require __DIR__ . '/../vendor/autoload.php';

//BDD
$servername = "localhost";
$username = "root";
$password = "root";
//BROKER
$server   = 'broker.hivemq.com';
$port     = 1883;

try {
    $bdd = new PDO("mysql:host=$servername;dbname=prototype", $username, $password);
    // set the PDO error mode to exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $result = $bdd->prepare("INSERT INTO Capteur (Id,typeC,Valeur,dateCreation) VALUES (null,:typeC,:valeur,:dateC)");


    $mqtt = new MqttClient($server, $port);
    $mqtt->connect();
    $mqtt->subscribe('php-mqtt/client/Humidite', function ($topic, $message) use ($result) {
        echo $topic,' ',$message;
        $result->execute([
            "typeC" => 'Humidite',
            "valeur" => $message,
            "dateC" => date('Y-m-d H:i:s')
        ]);

    }, 0);
    $mqtt->loop(true);
    $mqtt->disconnect();


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}

