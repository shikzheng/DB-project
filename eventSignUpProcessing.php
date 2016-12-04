<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$eventId = $_POST['eventId'];
$userName = $_POST['uname'];

if (!$connection->connect_errno) {
  $sql = "INSERT INTO sign_up (event_id, username, rating)
          VALUES('" . $eventId . "', '" .  $userName . "', 6);";
  $query = $connection->query($sql);
}






?>
