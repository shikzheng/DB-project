<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $current_user = $connection->real_escape_string(strip_tags($_POST['currUser'], ENT_QUOTES));

    $firstName = array();
    $lastName = array();
    $email = array();
    $username = array();
    $friend_to = array();
    if (!$connection->connect_errno) {
      $sql = "SELECT friend_to FROM friend WHERE friend_of = ?";
      $query= $connection->prepare($sql);
      $query->bind_param("s", $current_user);
      $query->execute();
      $query->bind_result($ft);
      while($query->fetch()){
        array_push($friend_to, $ft);
      }

    for($index = 0; $index<count($friend_to);$index++){
      $sql2 = "SELECT firstname,lastname,email,username FROM member WHERE username = ?";
      $query2 = $connection->prepare($sql2);
      $query2->bind_param("s", $friend_to[$index]);
      $query2->execute();
      $query2->bind_result($fn,$ln,$em,$userN);
      while($query2->fetch()){
        array_push($firstName, $fn);
        array_push($lastName, $ln);
        array_push($email, $em);
        array_push($username, $userN);
      }
    }
    echo json_encode($firstName);
    echo "#";
    echo json_encode($lastName);
    echo "#";
    echo json_encode($email);
    echo "#";
    echo json_encode($username);
  }
 ?>
