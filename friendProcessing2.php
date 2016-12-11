<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $usernameArr = $_POST['usernameArr'];

    $eventId = array();
    $eventTitle = array();
    $eventDescription = array();
    $eventStart = array();
    $eventEnd = array();
    $eventLocationName = array();
    $eventZipCode = array();

    if (!$connection->connect_errno) {
      for($i=0;$i<count($usernameArr);$i++){
      $sql = "SELECT * FROM an_event NATURAL JOIN sign_up WHERE start_time < NOW() + INTERVAL 3 DAY AND end_time >= NOW() AND username = '" . $usernameArr[$i] . "';";
      $query= $connection->query($sql);
      while($row = $query->fetch_assoc()){
        if(!(in_array($row['event_id'], $eventId))){
        array_push($eventId, $row['event_id']);
        array_push($eventTitle, $row['title']);
        array_push($eventDescription, $row['description']);
        array_push($eventStart, $row['start_time']);
        array_push($eventEnd, $row['end_time']);
        array_push($eventLocationName, $row['location_name']);
        array_push($eventZipCode, $row['zipcode']);
      }
      }
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
