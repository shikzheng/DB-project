<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$rating = $connection->real_escape_string(strip_tags($_POST['event_rating'], ENT_QUOTES));
$username = $connection->real_escape_string(strip_tags($_POST['rating_username'], ENT_QUOTES));


if (!$connection->connect_errno) {
  $stmt = $connection->prepare("UPDATE sign_up SET rating = ? WHERE event_id = ? AND username = ?");
  $stmt->bind_param("sss", $rating, $_SESSION['event_page_eventid'], $username);
  if($stmt->execute()){
    $stmt2 = $connection->prepare("SELECT * FROM sign_up WHERE event_id = ? AND username = ?");
    $stmt2->bind_param("ss", $_SESSION['event_page_eventid'], $username);
    $stmt2->execute();
    $stmt2->store_result();
    if ($stmt2->num_rows < 1) {
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
