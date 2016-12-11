<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $username = $connection->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
    $categoryArr = array();
    $keywordArr = array();
    if (!$connection->connect_errno) {
      $sql1 = "SELECT category,keyword FROM interested_in WHERE username = '".$username."';";
      $query1= $connection->query($sql1);
      while($row = $query1->fetch_assoc()){
        array_push($categoryArr, $row['category']);
        array_push($keywordArr, $row['keyword']);
      }
    }
    echo json_encode($categoryArr);
    echo "#";
    echo json_encode($keywordArr);
 ?>
