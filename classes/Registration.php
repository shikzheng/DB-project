<?php

class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var
     */
    public $messages = "";

    public function __construct(){
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser(){
        if (empty($_POST['user_name'])) {
            $this->messages = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->messages = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->messages = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->messages = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->messages = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->messages = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['user_email'])) {
            $this->messages = "Email cannot be empty";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->messages = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->messages = "Your email address is not in a valid email format";
        } elseif(strlen($_POST['user_zipcode']) != 5){
          $this->messages = "Zip code must be 5 digits";
        } elseif(!ctype_digit($_POST['user_zipcode'])){
          $this->messages = "Only intergers are allowed for zip code";
        } elseif(!preg_match('/[a-z]/i', $_POST['user_firstname'])){
          $this->messages = "Only alphabet letters are allowed for first name / last name";
        }elseif(!preg_match('/[a-z]/i', $_POST['user_lastname'])){
          $this->messages = "Only alphabet letters are allowed for first name / last name";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->set_charset("utf8")) {
                $this->messages = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));
                $user_firstname = $this->db_connection->real_escape_string(strip_tags($_POST['user_firstname'], ENT_QUOTES));
                $user_lastname = $this->db_connection->real_escape_string(strip_tags($_POST['user_lastname'], ENT_QUOTES));
                $user_zipcode = $this->db_connection->real_escape_string(strip_tags($_POST['user_zipcode'], ENT_QUOTES));
                $user_password = $_POST['user_password_new'];
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM member WHERE username = '" . $user_name . "' OR email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->messages = "Sorry, that username / email address is already taken.";
                } else {
                    $sql = "INSERT INTO member (username, password, email, firstname, lastname, zipcode)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "', '" . $user_firstname . "', '" . $user_lastname . "', '" . $user_zipcode . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);
                    if ($query_new_user_insert) {
                        $this->messages = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->messages = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->messages = "Sorry, no database connection.";
            }
        } else {
            $this->messages = "An unknown error occurred.";
        }
    }
}
