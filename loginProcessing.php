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
        $sql = "SELECT username, email, password, zipcode, firstname, lastname
                FROM member
                WHERE username = '" . $user_name . "';";
        $result_of_login_check = $connection->query($sql);
        if ($result_of_login_check->num_rows == 1){
            $result_row = $result_of_login_check->fetch_object();
            if (password_verify($user_password, $result_row->password)) {
                $_SESSION['user_name'] = $result_row->username;
                $_SESSION['user_email'] = $result_row->email;
                $_SESSION['user_firstname'] = $result_row->firstname;
                $_SESSION['user_lastname'] = $result_row->lastname;
                $_SESSION['user_zipcode'] = $result_row->zipcode;
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
