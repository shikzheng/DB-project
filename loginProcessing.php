<?php
session_start();
require_once("config/db.php");
$_SESSION['curr_user_name'] = $_POST['user_name'];
if (empty($_POST['user_name'])) {
    $_SESSION['loginErrorMsg'] = "Username field was empty.";
} elseif (empty($_POST['user_password'])) {
    $_SESSION['loginErrorMsg'] = "Password field was empty.";
} elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$connection->set_charset("utf8")) {
        $_SESSION['loginErrorMsg'] = $connection->error;
    }
    if (!$connection->connect_errno) {
        $user_name = $connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
        $user_password = $connection->real_escape_string(strip_tags($_POST['user_password'], ENT_QUOTES));
	$stmt = $connection->prepare("SELECT username, email, password, zipcode, firstname, lastname FROM member WHERE username = ?");
	$stmt->bind_param("s", $user_name);
        $stmt->execute();
	$stmt->bind_result($unme, $eml, $pwd, $zip, $fname, $lname);
	$stmt->store_result();
        if ($stmt->num_rows == 1){
            $stmt->fetch();
            if (password_verify($user_password, $pwd)) {
                $_SESSION['user_name'] = $unme;
                $_SESSION['user_email'] = $eml;
                $_SESSION['user_firstname'] = $fname;
                $_SESSION['user_lastname'] = $lname;
                $_SESSION['user_zipcode'] = $zip;
                $_SESSION['user_login_status'] = 1;
            } else {
                $_SESSION['loginErrorMsg'] = "Wrong username / password combination. Try again.";
            }
        } else {
            $_SESSION['loginErrorMsg'] = "Wrong username / password combination. Try again.";
        }
    } else {
        $_SESSION['loginErrorMsg'] = "Database connection problem.";
    }
}
$_SESSION['real_user_name'] = $_SESSION['user_name'];
if($_SESSION['user_login_status'] != 1){
header("Location:index.php");
}else{
  header("Location:main.php");
}


?>
