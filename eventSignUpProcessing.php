<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$eventId = $connection->real_escape_string(strip_tags($_POST['eventId'], ENT_QUOTES));
$userName = $connection->real_escape_string(strip_tags($_POST['uname'], ENT_QUOTES));
$eventEndTime = array();

if (!$connection->connect_errno) {
  $sql1 = "SELECT end_time FROM an_event WHERE event_id = '" . $eventId . "';";
  $query1 = $connection->query($sql1);
  while($row = $query1->fetch_assoc()){
    array_push($eventEndTime, $row["end_time"]);
  }
  if(time($eventEndTime[0]) >  time()){
  $sql = "INSERT INTO sign_up (event_id, username, rating)
          VALUES('" . $eventId . "', '" .  $userName . "', 6);";
  $query = $connection->query($sql);
}else{
  echo "Passed";
}
}






?>
