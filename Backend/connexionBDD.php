<?php
$username = "root";
$password = "root";

try{
    $bdd = new PDO('mysql:host=localhost;dbname=prototype',$username,$password);
}
catch (PDOException $e){
    die('Error: '.$e->getMessage());
}
