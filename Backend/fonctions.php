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
function login($data){

    $user = $data['params']['user'];
    $pass = md5($data['params']['pass']);

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


//SUBSCRIBE
function subscribe(){
    $server   = 'broker.hivemq.com';
    $port     = 1883;

    $mqtt = new \PhpMqtt\Client\MqttClient($server, $port);
    $mqtt->connect();
    $mqtt->subscribe('php-mqtt/client/test', function ($topic, $message) {
        echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
    }, 0);
    $mqtt->loop(true);
    $mqtt->disconnect();
}