<?php

require __DIR__ . '/../vendor/autoload.php';


$server   = 'broker.hivemq.com';
$port     = 1883;

$mqtt = new \PhpMqtt\Client\MqttClient($server, $port);
$mqtt->connect();
$mqtt->subscribe('php-mqtt/client/test', function ($topic, $message) {
    echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
}, 0);
$mqtt->loop(true);
$mqtt->disconnect();