<?php
$username = "root";
$password = "";

try{
    $bdd = new PDO('mysql:host=localhost;dbname=prototypage',$username,$password);
}
catch (PDOException $e){
    die('Error: '.$e->getMessage());
}
