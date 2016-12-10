<?php
session_start();
require_once("config/db.php");
//$_SESSION["creategroup_GroupName"] = $_POST['creategroup_GroupName'];
//$_SESSION["creategroup_Description"] = $_POST['creategroup_Description'];

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
          $sql1 = "SELECT group_id FROM a_group WHERE group_name = '" . $joingroup_GroupName . "';";
          $result = $connection->query($sql1);
          if($result->num_rows < 1){
            $_SESSION['JoinGroupErrorMsg'] = "This group does not exist";
            header("Location:group.php");
          }
          while($row = $result->fetch_assoc()){
            $sql = "SELECT * FROM belongs_to WHERE group_id = '" . $row["group_id"] . "' AND username = '" . $user . "';";
            $check1 = $connection->query($sql);
            if ($check1->num_rows == 1) {
                $_SESSION['JoinGroupErrorMsg'] = "You've already joined the group";
                header("Location:group.php");
            }
            $sql2 = "INSERT INTO belongs_to (group_id, username, authorized)
                      VALUES('" . $row["group_id"] . "', '" . $user . "', '0');";
            $query_group_member_insert = $connection->query($sql2);
            if($query_group_member_insert){
              $_SESSION['JoinGroupErrorMsg'] = "Success! You have joined the group.";
            }else{
              $_SESSION['JoinGroupErrorMsg'] = "Error, please try again";
            }
          }
        } else {
            $_SESSION['JoinGroupErrorMsg'] = "Sorry, no database connection.";
        }
    }

  header("Location:group.php");

?>
