<?php
session_start();
require_once("config/db.php");

$addFriend_username = $connection->real_escape_string(strip_tags($_POST['addFriend_username'], ENT_QUOTES));

    if (empty($addFriend_username)) {
        $_SESSION['createGroupErrorMsg'] = "Empty Group Name";
    } elseif(strlen($addFriend_username)>20){
      $_SESSION['AddFriendErrorMsg'] = "Username may not be more than 20 characters";
    } else{
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['AddFriendErrorMsg'] = $connection->error;
        }
        if (!$connection->connect_errno) {
          $user = $connection->real_escape_string(strip_tags($_SESSION['user_name'], ENT_QUOTES));
          $sql1 = "SELECT username FROM member WHERE username = '" . $addFriend_username . "';";
          $result = $connection->query($sql1);
          if($result->num_rows < 1){
            $_SESSION['AddFriendErrorMsg'] = "Error. This user does not exist";
            header("Location:friends.php");
          }else{
            $sql = "SELECT * FROM friend WHERE friend_of = '" . $user . "' AND friend_to = '" . $addFriend_username . "';";
            $check1 = $connection->query($sql);
            if ($check1->num_rows > 0) {
                $_SESSION['AddFriendErrorMsg'] = "Error. You two are already friends";
                header("Location:friends.php");
            }else{
            $sql2 = "INSERT INTO friend (friend_of, friend_to)
                      VALUES('" . $user . "', '" . $addFriend_username . "');";
            $query_group_member_insert = $connection->query($sql2);
            if($query_group_member_insert){
              $_SESSION['AddFriendErrorMsg'] = "Success! You two are friends now!";
            }else{
              $_SESSION['AddFriendErrorMsg'] = "Error, please try again";
            }
          }
          }
        } else {
            $_SESSION['JoinGroupErrorMsg'] = "Sorry, no database connection.";
        }
    }

  header("Location:friends.php");

?>
