<?php


  $servername = "localhost";
  $username = "root";
  $password = "root";
  $user = $_GET['user'];
  $pass = $_GET['password'];
  try {
    $bdd = new PDO("mysql:host=$servername;dbname=prototype", $username, $password);
    // set the PDO error mode to exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $passwordCrypt = md5($pass);
    $result = $bdd->prepare("SELECT * FROM User WHERE Username = :username AND Password = :password ");

    $result->execute([
       "username" => $user,
       "password" => $passwordCrypt
    ]);

    $UnUser = ($result->fetch(PDO::FETCH_OBJ));
    if ($UnUser != null) {
      echo $UnUser->Username;
    } else {
      echo "0";
    }

  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

  }

?>
