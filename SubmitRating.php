<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$rating = $connection->real_escape_string(strip_tags($_POST['event_rating'], ENT_QUOTES));
$username = $connection->real_escape_string(strip_tags($_POST['rating_username'], ENT_QUOTES));


if (!$connection->connect_errno) {
  $sql = "UPDATE sign_up SET rating = '" .  $rating . "' WHERE event_id = '" .  $_SESSION['event_page_eventid'] . "' AND username = '" .  $username . "';";
  $query = $connection->query($sql);
  if($query){
    $sql2 = "SELECT * FROM sign_up WHERE event_id = '" .  $_SESSION['event_page_eventid'] . "' AND username = '" .  $username . "';";
    $query2 = $connection->query($sql2);
    if ($query2->num_rows < 1) {
        $_SESSION['RatingSubmitMsg'] = "Rating Submission Failed. Please sign up for the event first.";
    } else {
    $_SESSION['RatingSubmitMsg'] = "Rating Submitted!";
  }
  }else{
    $_SESSION['RatingSubmitMsg'] = "An unknown error has occured";
  }
}





header("Location:eventPage.php");

?>
