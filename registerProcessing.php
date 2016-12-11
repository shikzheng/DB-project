<?php
session_start();
require_once("config/db.php");
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$user_firstname = $_POST['user_firstname'];
$user_lastname = $_POST['user_lastname'];
$user_zipcode = $_POST['user_zipcode'];
$user_password = $_POST['user_password_new'];
$user_password_repeat = $_POST['user_password_repeat'];



$_SESSION["registration_user_firstname"] = $user_firstname;
$_SESSION["registration_user_lastname"] = $user_lastname;
$_SESSION["registration_user_email"] = $user_email;
$_SESSION["registration_user_zipcode"] = $user_zipcode;
$_SESSION["registration_user_name"] = $user_name;



    if (empty($user_name)) {
        $_SESSION['registerErrorMsg'] = "Empty Username";
        header("Location:register.php");
    } elseif (empty($user_password) || empty($user_password_repeat)) {
        $_SESSION['registerErrorMsg'] = "Empty Password";
        header("Location:register.php");
    } elseif ($user_password !== $user_password_repeat) {
        $_SESSION['registerErrorMsg'] = "Password and password repeat are not the same";
        header("Location:register.php");
    } elseif (strlen($user_password) < 6) {
      $_SESSION['registerErrorMsg'] = "Password has a minimum length of 6 characters";
      header("Location:register.php");
    } elseif (strlen($user_name) > 20 || strlen($user_name) < 2) {
        $_SESSION['registerErrorMsg'] = "Username cannot be shorter than 2 or longer than 20 characters";
        header("Location:register.php");
    } elseif (!preg_match('/^[a-z\d]{2,32}$/i', $user_name)) {
        $_SESSION['registerErrorMsg'] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 32 characters";
        header("Location:register.php");
    } elseif (empty($user_email)) {
        $_SESSION['registerErrorMsg'] = "Email cannot be empty";
        header("Location:register.php");
    } elseif (strlen($user_email) > 32) {
        $_SESSION['registerErrorMsg'] = "Email cannot be longer than 32 characters";
        header("Location:register.php");
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registerErrorMsg'] = "Your email address is not in a valid email format";
        header("Location:register.php");
    } elseif(strlen($user_zipcode) != 5){
      $_SESSION['registerErrorMsg'] = "Zip code must be 5 digits";
      header("Location:register.php");
    } elseif(!ctype_digit($user_zipcode)){
      $_SESSION['registerErrorMsg'] = "Only intergers are allowed for zip code";
      header("Location:register.php");
    } elseif(!ctype_alpha($user_firstname)){
      $_SESSION['registerErrorMsg'] = "Only alphabet letters are allowed for first name / last name";
      header("Location:register.php");
    }elseif(!ctype_alpha($user_lastname)){
      $_SESSION['registerErrorMsg'] = "Only alphabet letters are allowed for first name / last name";
      header("Location:register.php");
    } else {
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection->set_charset("utf8")) {
            $_SESSION['registerErrorMsg'] = $connection->error;
            header("Location:register.php");
        }
        if (!$connection->connect_errno) {
            $user_name = $connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
            $user_email = $connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));
            $user_firstname = $connection->real_escape_string(strip_tags($_POST['user_firstname'], ENT_QUOTES));
            $user_lastname = $connection->real_escape_string(strip_tags($_POST['user_lastname'], ENT_QUOTES));
            $user_zipcode = $connection->real_escape_string(strip_tags($_POST['user_zipcode'], ENT_QUOTES));
            $user_password = $connection->real_escape_string(strip_tags($_POST['user_password_new'], ENT_QUOTES));
            $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

            $sql = "SELECT * FROM member WHERE username = '" . $user_name . "' OR email = '" . $user_email . "';";
            $query_check_user_name = $connection->query($sql);

            if ($query_check_user_name->num_rows == 1) {
                $_SESSION['registerErrorMsg'] = "Sorry, that username / email address is already taken.";
                header("Location:register.php");
            } else {
                $sql = "INSERT INTO member (username, password, email, firstname, lastname, zipcode)
                        VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "', '" . $user_firstname . "', '" . $user_lastname . "', '" . $user_zipcode . "');";
                $query_new_user_insert = $connection->query($sql);
                if ($query_new_user_insert) {
                    $_SESSION['registerErrorMsg'] = "Your account has been created successfully. You can now log in.";
                    header("Location:register.php");
                } else {
                    $_SESSION['registerErrorMsg'] = "Sorry, your registration failed. Please go back and try again.";
                    header("Location:register.php");
                }
            }
        } else {
            $_SESSION['registerErrorMsg'] = "Sorry, no database connection.";
            header("Location:register.php");
        }
    }

  header("Location:register.php");

?>
