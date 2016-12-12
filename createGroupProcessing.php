<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$_SESSION["creategroup_GroupName"] = $connection->real_escape_string(strip_tags($_POST['creategroup_GroupName'], ENT_QUOTES));
$_SESSION["creategroup_Description"] = $connection->real_escape_string(strip_tags($_POST['creategroup_Description'], ENT_QUOTES));
$_SESSION["creategroup_Category"] = $connection->real_escape_string(strip_tags($_POST['creategroup_Category'], ENT_QUOTES));
$_SESSION["creategroup_Keywords"] = $connection->real_escape_string(strip_tags($_POST['creategroup_Keywords'], ENT_QUOTES));

$creategroup_GroupName = $connection->real_escape_string(strip_tags($_POST['creategroup_GroupName'], ENT_QUOTES));
$creategroup_Description = $connection->real_escape_string(strip_tags($_POST['creategroup_Description'], ENT_QUOTES));
$group_creator = $connection->real_escape_string(strip_tags($_SESSION['user_name'], ENT_QUOTES));
$category = $connection->real_escape_string(strip_tags($_POST['creategroup_Category'], ENT_QUOTES));
$keyword = $connection->real_escape_string(strip_tags($_POST['creategroup_Keywords'], ENT_QUOTES));

    if (empty($creategroup_GroupName)) {
        $_SESSION['createGroupErrorMsg'] = "Empty Group Name";
    } elseif(strlen($creategroup_GroupName)>20){
      $_SESSION['createGroupErrorMsg'] = "Group Name may not be more than 20 characters";
    } elseif(strlen($category)>20){
      $_SESSION['createGroupErrorMsg'] = "Category may not be more than 20 characters";
    } elseif(strlen($keyword)>20){
      $_SESSION['createGroupErrorMsg'] = "Keyword may not be more than 20 characters";
    } elseif(!ctype_alpha($keyword)){
      $_SESSION['createGroupErrorMsg'] = "Keyword may only contain alphabet letters.";
    }else{
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['createGroupErrorMsg'] = $connection->error;
        }
        if (!$connection->connect_errno) {

	    $stmt = $connection->prepare("SELECT * FROM a_group WHERE group_name = ?");
	    $stmt->bind_param("s", $creategroup_GroupName);
            $stmt->execute();
	    $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $_SESSION['createGroupErrorMsg'] = "Sorry, that group name is already taken.";
            } else {
		$stmt5 = $connection->prepare("INSERT INTO a_group (group_name, description, creator) VALUES(?, ?, ?)");
		$stmt5->bind_param("sss", $creategroup_GroupName, $creategroup_Description, $group_creator);
                if ($stmt5->execute()) {
                    $_SESSION['createGroupErrorMsg'] = "Success! The group has been created.";
		    $stmt1 = $connection->prepare("SELECT group_id FROM a_group WHERE group_name = ?");
		    $stmt1->bind_param("s", $creategroup_GroupName);
                    $stmt1->execute();
		    $stmt1->bind_result($g_id);
		    $stmt1->store_result();
                    while($stmt1->fetch()){

		      $stmt2 = $connection->prepare("INSERT INTO belongs_to (group_id, username, authorized) VALUES(?, ?, '1')");
		      $stmt2->bind_param("ss", $g_id, $group_creator);
		      $stmt3 = $connection->prepare("INSERT INTO interest (category, keyword) VALUES(?, ?)");
		      $stmt3->bind_param("ss", $category, $keyword);
		      $stmt4 = $connection->prepare("INSERT INTO about (category, keyword, group_id) VALUES(?, ?, ?)");
		      $stmt4->bind_param("sss", $category, $keyword, $g_id);
    			$stmt2->execute();
			$stmt3->execute();
			$stmt4->execute();
		    }
                } else {
                    $_SESSION['createGroupErrorMsg'] = "Group creation failed, please try again";
                }
            }
        } else {
            $_SESSION['createGroupErrorMsg'] = "Sorry, no database connection.";
        }
    }

  header("Location:group.php");

?>
