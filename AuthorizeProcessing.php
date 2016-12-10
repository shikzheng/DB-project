<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$authorizedArr = $connection->real_escape_string(strip_tags($_POST['authorizedArr'], ENT_QUOTES));
$members = $connection->real_escape_string(strip_tags($_POST['members'], ENT_QUOTES));
$thisGroup = $connection->real_escape_string(strip_tags($_POST['thisGroup'], ENT_QUOTES));
if (!$connection->connect_errno) {
  for($i = 0; $i < sizeof($members); $i++){
    $sql = "UPDATE belongs_to SET authorized = '" .  $authorizedArr[$i] . "' WHERE username = '" .  $members[$i] . "' AND group_id = '" .  $thisGroup . "';";
    $query = $connection->query($sql);
  }
}

?>
