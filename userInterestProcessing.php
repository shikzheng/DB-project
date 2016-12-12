<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $username = $connection->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
    $categoryArr = array();
    $keywordArr = array();
    if (!$connection->connect_errno) {
      $stmt1 = $connection->prepare("SELECT category,keyword FROM interested_in WHERE username = ?");
      $stmt1->bind_param("s", $username);
      $stmt1->execute();
      $stmt1->bind_result($ctg, $kyw);
      while($stmt1->fetch()){
        array_push($categoryArr, $ctg);
        array_push($keywordArr, $kyw);
      }
    }
    echo json_encode($categoryArr);
    echo "#";
    echo json_encode($keywordArr);
 ?>
