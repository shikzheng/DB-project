<?php
session_start();
require_once("config/db.php");
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$_SESSION["addInterest_Category"] = $connection->real_escape_string(strip_tags($_POST['addInterest_Category'], ENT_QUOTES));
$_SESSION["addInterest_Keyword"] = $connection->real_escape_string(strip_tags($_POST['addInterest_Keyword'], ENT_QUOTES));

$addInterest_Category = $connection->real_escape_string(strip_tags($_POST['addInterest_Category'], ENT_QUOTES));
$addInterest_Keyword = $connection->real_escape_string(strip_tags($_POST['addInterest_Keyword'], ENT_QUOTES));
$username = $connection->real_escape_string(strip_tags($_SESSION['user_name'], ENT_QUOTES));
    if (empty($addInterest_Category)) {
        $_SESSION['addInterestErrorMsg'] = "Empty Category Name";
    } elseif(empty($addInterest_Keyword)) {
	$_SESSION['addInterestErrorMsg'] = "Empty Keyword Name";
    } elseif(strlen($addInterest_Category)>20){
      $_SESSION['addInterestErrorMsg'] = "Category may not be more than 20 characters";
    } elseif(strlen($addInterest_Keyword)>50){
      $_SESSION['addInterestErrorMsg'] = "Keywords may not be more than 50 characters";
    } else{
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['addInterestErrorMsg'] = $connection->error;
        }
        if (!$connection->connect_errno) {

            $sql = "SELECT * FROM interest WHERE category = '" . $addInterest_Category . "' AND keyword = '" . $addInterest_Keyword . "';";
            $query_check_interest = $connection->query($sql);
            if ($query_check_interest->num_rows == 0) {
                $_SESSION['addInterestErrorMsg'] = "Sorry, that interest does not exist.";
            } else {
                $sql = "INSERT INTO interested_in (username, category, keyword)
                        VALUES('" . $username . "', '" . $addInterest_Category . "', '" . $addInterest_Keyword . "');";
                $query_add_interest_insert = $connection->query($sql);
                if ($query_add_interest_insert) {
                    $_SESSION['addInterestErrorMsg'] = "Success! The interest has been added.";
                } else {
                    $_SESSION['addInterestErrorMsg'] = "Interest addition failed, please try again";
                }
            }
        } else {
            $_SESSION['addInterestErrorMsg'] = "Sorry, no database connection.";
        }
    }

  header("Location:interests.php");

?>
