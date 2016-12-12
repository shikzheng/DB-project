<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
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
          $stmt1 = $connection->prepare("SELECT username FROM member WHERE username = ?");
	  $stmt1->bind_param("s", $addFriend_username);
	  $stmt1->execute();
	  $stmt1->bind_result($usnme);
	  $stmt1->store_result();
          if($stmt1->num_rows < 1){
            $_SESSION['AddFriendErrorMsg'] = "Error. This user does not exist";
            header("Location:friends.php");
          }else if($addFriend_username == $user){
            $_SESSION['AddFriendErrorMsg'] = "Error. You cannot add yourself";
            header("Location:friends.php");
          }else{
	    $stmt = $connection->prepare("SELECT * FROM friend WHERE friend_of = ? AND friend_to = ?");
	    $stmt->bind_param("ss", $user, $addFriend_username);
            $stmt->execute();
	    $stmt->bind_result($f_of, $f_to);
	    $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $_SESSION['AddFriendErrorMsg'] = "Error. You two are already friends";
                header("Location:friends.php");
            }else{
	    $stmt2 = $connection->prepare("INSERT INTO friend (friend_of, friend_to) VALUES(?, ?)");
	    $stmt2->bind_param("ss", $user, $addFriend_username);
            if($stmt2->execute()){
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
