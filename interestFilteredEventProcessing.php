<?php
    session_start();
    require_once("config/db.php");
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $categoryArr = $_POST['category'];
    $keywordArr = $_POST['keyword'];
    if (!$connection->connect_errno) {
      $eventId = array();
      $eventTitle = array();
      $eventDescription = array();
      $eventStart = array();
      $eventEnd = array();
      $eventLocationName = array();
      $eventZipCode = array();
      for($i = 0; $i<count($categoryArr);$i++){
      $sql = "SELECT * FROM an_event NATURAL JOIN organize NATURAL JOIN about WHERE start_time < NOW() + INTERVAL 3 DAY AND end_time >= NOW() AND category = ? AND keyword = ?";
      $query= $connection->prepare($sql);
      $query->bind_param("ss", $categoryArr[$i],$keywordArr[$i]);
      $query->execute();
      $query->bind_result($gid,$eid,$titl,$des,$st,$et,$locn,$zcode,$cat,$keyw);
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
