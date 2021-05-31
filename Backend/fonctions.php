<?php
include('connexionBDD.php');

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    echo $action;
    switch($action) {
        case 'login' : login();break;
        case 'register' : register();break;
        // ...etc...
    }
}


// LOGIN
function login($user, $pass1){
    echo "clc";
    $pass = md5($pass1);
    echo $user;
    try {
        $result = $bdd->prepare("SELECT * FROM User WHERE Username = :username AND Password = :password ");

        $result->execute([
            "username" => $user,
            "password" => $pass
        ]);

        $UnUser = ($result->fetch(PDO::FETCH_OBJ));
        if ($UnUser != null) {
            return $UnUser->Username;
        } else {
            return 0;
        }

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();

    }
}


//REGISTER
function register(){
    $user = $_GET['user'];
    $pass = $_GET['password'];
    try {
        $passwordCrypt = md5($pass);

        $result = $bdd->prepare("INSERT INTO User (Id,Username,Password) VALUES (null,:username,:password)");
        $result->execute([
            "username" => $user,
            "password" => $passwordCrypt
        ]);

        $UnUser = ($result->fetch(PDO::FETCH_OBJ));
        if ($UnUser != null) {
            echo "1";
        } else {
            echo "0";
        }

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();

    }
}


//PUBLISH
function publish(){
    $server   = 'broker.hivemq.com';
    $port     = 1883;

    $mqtt = new \PhpMqtt\Client\MqttClient($server, $port);
    $mqtt->connect();
    $mqtt->publish('php-mqtt/client/test', 'Hello World zebi!', 0);
    $mqtt->disconnect();
}

/////////////
//SUBSCRIBE
/////////////


// reload
function reloadTemperature(){

    $result = $bdd->prepare("SELECT * FROM Capteur WHERE TypeC = 'Temperature' ORDER BY DateCreation DESC limit 1");

    $result->execute();
    $Temp = ($result->fetch(PDO::FETCH_OBJ));
    console.log($Temp);
    if ($Temp != null) {
        echo $Temp->Valeur;
    } else {
        echo "erreur retour temperature";
    }
}

function reloadHumidite(){

    $result = $bdd->prepare("SELECT * FROM Capteur WHERE TypeC = 'Humidite' ORDER BY DateCreation DESC limit 1");
    $result->execute();
    $Temp = ($result->fetch(PDO::FETCH_OBJ));
    if ($Temp != null) {
        echo $Temp->Valeur;
    } else {
        echo "erreur retour humidité";
    }
}

function reloadTotalRequetes() {

    $result = $bdd->prepare("SELECT count(Id) from Capteur");
    $result->execute();
    $Temp = ($result->fetch(PDO::FETCH_OBJ));
    echo $Temp;

}

function subscribeTemperature(){

    $result = $bdd->prepare("INSERT INTO Capteur (Id,typeC,Valeur,dateCreation) VALUES (null,:typeC,:valeur,:dateC)");


    $server   = 'broker.hivemq.com';
    $port     = 1883;
    $mqtt = new \PhpMqtt\Client\MqttClient($server, $port);
    $mqtt->connect();
    $mqtt->subscribe('php-mqtt/client/temperature', function ($topic, $message) use ($result) {
        $result->execute([
            "typeC" => 'Temperature',
            "valeur" => $message,
            "dateC" => date('Y-m-d H:i:s')
        ]);

    }, 0);
    $mqtt->loop(true);
    $mqtt->disconnect();

}


function subscribeHumidite(){

    $result = $bdd->prepare("INSERT INTO Capteur (Id,typeC,Valeur,dateCreation) VALUES (null,:typeC,:valeur,:dateC)");


    $server   = 'broker.hivemq.com';
    $port     = 1883;
    $mqtt = new \PhpMqtt\Client\MqttClient($server, $port);
    $mqtt->connect();
    $mqtt->subscribe('php-mqtt/client/humidite', function ($topic, $message) use ($result) {
        $result->execute([
            "typeC" => 'Humidite',
            "valeur" => $message,
            "dateC" => date('Y-m-d H:i:s')
        ]);

    }, 0);
    $mqtt->loop(true);
    $mqtt->disconnect();

}