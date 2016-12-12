<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $username = $_POST['username'];

    $eventId = array();
    $eventTitle = array();
    $eventDescription = array();
    $eventStart = array();
    $eventEnd = array();
    $eventLocationName = array();
    $eventZipCode = array();

    if (!$connection->connect_errno) {

      $sql = "SELECT * FROM an_event NATURAL JOIN sign_up WHERE start_time < NOW() + INTERVAL 3 DAY AND end_time >= NOW() AND username = ?";
      $query= $connection->prepare($sql);
      $query->bind_param("s", $username);
      $query->execute();
      $query->bind_result($eid,$titl,$des,$st,$et,$locn,$zcode,$userN,$rate);
      while($query->fetch()){
        array_push($eventId, $eid);
        array_push($eventTitle, $titl);
        array_push($eventDescription, $des);
        array_push($eventStart, $st);
        array_push($eventEnd, $et);
        array_push($eventLocationName, $locn);
        array_push($eventZipCode, $zcode);
     }
    }
    echo json_encode($eventId);
    echo "#";
    echo json_encode($eventTitle);
    echo "#";
    echo json_encode($eventDescription);
    echo "#";
    echo json_encode($eventStart);
    echo "#";
    echo json_encode($eventEnd);
    echo "#";
    echo json_encode($eventLocationName);
    echo "#";
    echo json_encode($eventZipCode);
    echo "#";
     ?>
