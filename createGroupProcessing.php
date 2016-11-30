<?php
session_start();
require_once("config/db.php");
$_SESSION["creategroup_GroupName"] = $_POST['creategroup_GroupName'];
$_SESSION["creategroup_Description"] = $_POST['creategroup_Description'];
$_SESSION["creategroup_Category"] = $_POST['creategroup_Category'];
$_SESSION["creategroup_Keywords"] = $_POST['creategroup_Keywords'];

    if (empty($_POST['creategroup_GroupName'])) {
        $_SESSION['createGroupErrorMsg'] = "Empty Group Name";
    } elseif(strlen($_POST['creategroup_GroupName'])>20){
      $_SESSION['createGroupErrorMsg'] = "Group Name may not be more than 20 characters";
    } elseif(strlen($_POST['creategroup_Category'])>20){
      $_SESSION['createGroupErrorMsg'] = "Category may not be more than 20 characters";
    } elseif(strlen($_POST['creategroup_Keywords'])>20){
      $_SESSION['createGroupErrorMsg'] = "Keywords may not be more than 20 characters";
    } else{
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['createGroupErrorMsg'] = $connection->error;
        }
        if (!$connection->connect_errno) {
            $creategroup_GroupName = $connection->real_escape_string(strip_tags($_POST['creategroup_GroupName'], ENT_QUOTES));
            $creategroup_Description = $connection->real_escape_string(strip_tags($_POST['creategroup_Description'], ENT_QUOTES));
            $group_creator = $connection->real_escape_string(strip_tags($_SESSION['user_name'], ENT_QUOTES));
            $category = $connection->real_escape_string(strip_tags($_POST['creategroup_Category'], ENT_QUOTES));
            $keyword = $connection->real_escape_string(strip_tags($_POST['creategroup_Keywords'], ENT_QUOTES));

            $sql = "SELECT * FROM a_group WHERE group_name = '" . $creategroup_GroupName . "';";
            $query_check_group_name = $connection->query($sql);
            if ($query_check_group_name->num_rows == 1) {
                $_SESSION['createGroupErrorMsg'] = "Sorry, that group name is already taken.";
            } else {
                $sql = "INSERT INTO a_group (group_name, description, creator)
                        VALUES('" . $creategroup_GroupName . "', '" . $creategroup_Description . "', '" . $group_creator . "');";
                $query_new_user_insert = $connection->query($sql);
                if ($query_new_user_insert) {
                    $_SESSION['createGroupErrorMsg'] = "Success! The group has been created.";
                    $sql1 = "SELECT group_id FROM a_group WHERE group_name = '" . $creategroup_GroupName . "';";
                    $result = $connection->query($sql1);
                    while($row = $result->fetch_assoc()){
                      $sql2 = "INSERT INTO belongs_to (group_id, username, authorized)
                              VALUES('" . $row["group_id"] . "', '" . $group_creator . "', '1');";
                      $sql3 = "INSERT INTO interest (category, keyword)
                              VALUES('" . $category . "', '" . $keyword . "');";
                      $sql4 = "INSERT INTO about (category, keyword, group_id)
                              VALUES('" . $category . "', '" . $keyword . "', '" . $row["group_id"] . "');";
                              $query_group_interest_insert = $connection->query($sql3);
                              $query_group_creator_belongsTo_insert = $connection->query($sql2);
                              $query_group_about_insert = $connection->query($sql4);
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
