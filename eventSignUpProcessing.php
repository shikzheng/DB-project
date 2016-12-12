<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$eventId = $connection->real_escape_string(strip_tags($_POST['eventId'], ENT_QUOTES));
$userName = $connection->real_escape_string(strip_tags($_POST['uname'], ENT_QUOTES));
$eventEndTime = array();

if (!$connection->connect_errno) {
  $sql1 = "SELECT end_time FROM an_event WHERE event_id = ?";
  $query1 = $connection->prepare($sql1);
  $query1->bind_param("i", $eventId);
  $query1->execute();
  $query1->bind_result($et);
  while($query1->fetch()){
    array_push($eventEndTime, $et);
  }
  if(strtotime($eventEndTime[0]) > time() - 5*60*60){
  $sql = "INSERT INTO sign_up (event_id, username, rating)
          VALUES(?,?,?)";
  $query = $connection->prepare($sql);
  $rate = 6;
  $query->bind_param("isi", $eventId,$userName,$rate);
  $query->execute();
}else{
  echo "Passed";
}
}


?>
