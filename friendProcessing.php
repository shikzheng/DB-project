<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $current_user = $_POST['currUser'];
    $firstName = array();
    $lastName = array();
    $email = array();
    $username = array();
    $friend_to = array();
    if (!$connection->connect_errno) {
      $sql = "SELECT friend_to FROM friend WHERE friend_of = '" . $current_user . "';";
      $query= $connection->query($sql);
      while($row = $query->fetch_assoc()){
        array_push($friend_to, $row['friend_to']);
      }

    for($index = 0; $index<count($friend_to);$index++){
      $sql2 = "SELECT firstname,lastname,email,username FROM member WHERE username = '" . $friend_to[$index] . "';";
      $query2 = $connection->query($sql2);
      while($row = $query2->fetch_assoc()){
        array_push($firstName, $row['firstname']);
        array_push($lastName, $row['lastname']);
        array_push($email, $row['email']);
        array_push($username, $row['username']);
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
