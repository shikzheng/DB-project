<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$authorizedArr = $_POST['authorizedArr'];
$members = $_POST['members'];
$thisGroup = $_POST['thisGroup'];
echo $thisGroup;
if (!$connection->connect_errno) {
  for($i = 0; $i < sizeof($members); $i++){
    $sql = "UPDATE belongs_to SET authorized = '" .  $authorizedArr[$i] . "' WHERE username = '" .  $members[$i] . "' AND group_id = '" .  $thisGroup . "';";
    $query = $connection->query($sql);
  }
}

?>
