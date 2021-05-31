<?php

require __DIR__ . '/../vendor/autoload.php';


$server   = 'broker.hivemq.com';
$port     = 1883;

$mqtt = new MqttClient($server, $port);
$mqtt->connect();
$mqtt->publish('php-mqtt/client/test', 'Hello World zebi!', 0);
$mqtt->disconnect();
