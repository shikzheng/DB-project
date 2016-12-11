<?php
  session_start();
  require_once("config/db.php");
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $current_user = $connection->real_escape_string(strip_tags($_POST['currUser'], ENT_QUOTES));
  $Userusername = array();
  $Usercategory = array();
  $Userkeywords = array();
  $gid = array();
  $gname = array();
  $gdesc = array();
  if (!$connection->connect_errno) {
    $sql1 = "SELECT username,category,keyword FROM interested_in;";
    $query1= $connection->query($sql1);
    while($row = $query1->fetch_assoc()){
      if($row['username']==$current_user){
      array_push($Usercategory, $row['category']);
      array_push($Userkeywords, $row['keyword']);
     }
    }
      for($i = 0; $i < count($Usercategory); $i++){
      $sql = "SELECT group_id, group_name, description FROM a_group natural join about where category = '" . $Usercategory[$i] . "' and keyword = '" . $Userkeywords[$i] . "';";
      $query= $connection->query($sql);
      while($row = $query->fetch_assoc()){
        array_push($gid, $row['group_id']);
        array_push($gname, $row['group_name']);
        array_push($gdesc, $row['description']);
      }
     }

    }

    echo json_encode($gid);
    echo "#";
    echo json_encode($gname);
    echo "#";
    echo json_encode($gdesc);
  ?>
