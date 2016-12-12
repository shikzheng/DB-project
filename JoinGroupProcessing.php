<?php
session_start();
require_once("config/db.php");
//$_SESSION["creategroup_GroupName"] = $_POST['creategroup_GroupName'];
//$_SESSION["creategroup_Description"] = $_POST['creategroup_Description'];
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$joingroup_GroupName = $connection->real_escape_string(strip_tags($_POST['joingroup_GroupName'], ENT_QUOTES));

    if (empty($joingroup_GroupName)) {
        $_SESSION['createGroupErrorMsg'] = "Empty Group Name";
    } elseif(strlen($joingroup_GroupName)>20){
      $_SESSION['JoinGroupErrorMsg'] = "Group Name may not be more than 20 characters";
    } else{
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['JoinGroupErrorMsg'] = $connection->error;
        }
        if (!$connection->connect_errno) {
          $user = $connection->real_escape_string(strip_tags($_SESSION['user_name'], ENT_QUOTES));
	  $stmt1 = $connection->prepare("SELECT group_id FROM a_group WHERE group_name = ?");
	  $stmt1->bind_param("s", $joingroup_GroupName);
          $stmt1->execute();
	  $stmt1->bind_result($g_id);
	  $stmt1->store_result();
          if($stmt1->num_rows < 1){
            $_SESSION['JoinGroupErrorMsg'] = "This group does not exist";
            header("Location:group.php");
          }else{
          while($stmt1->fetch()){
	    $stmt = $connection->prepare("SELECT * FROM belongs_to WHERE group_id = ? AND username = ?");
	    $stmt->bind_param("ss", $g_id, $user);
	    $stmt->execute();
	    $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $_SESSION['JoinGroupErrorMsg'] = "You've already joined the group";
                header("Location:group.php");
            }else{
	    $stmt2 = $connection->prepare("INSERT INTO belongs_to (group_id, username, authorized) VALUES(?, ?, '0')");
	    $stmt2->bind_param("ss", $g_id, $user);
	    if($stmt2->execute()){
              $_SESSION['JoinGroupErrorMsg'] = "Success! You have joined the group.";
            }else{
              $_SESSION['JoinGroupErrorMsg'] = "Error, please try again";
            }
          }
          }
        }
        } else {
            $_SESSION['JoinGroupErrorMsg'] = "Sorry, no database connection.";
        }
    }

  header("Location:group.php");

?>
