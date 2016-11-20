<?php
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();
    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * such as do "$login = new Login();"
     */
    public function __construct(){
        session_start();
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }
    private function dologinWithPostData(){
        if (empty($_POST['user_name'])) {
            $this->messages = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->messages = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->set_charset("utf8")) {
                $this->messages = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $sql = "SELECT username, email, password, zipcode, firstname, lastname
                        FROM member
                        WHERE username = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);
                if ($result_of_login_check->num_rows == 1){
                    $result_row = $result_of_login_check->fetch_object();
                    if (password_verify($_POST['user_password'], $result_row->password)) {
                        $_SESSION['user_name'] = $result_row->username;
                        $_SESSION['user_email'] = $result_row->email;
                        $_SESSION['user_firstname'] = $result_row->firstname;
                        $_SESSION['user_lastname'] = $result_row->lastname;
                        $_SESSION['user_zipcode'] = $result_row->zipcode;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->messages = "Wrong username / password combination. Try again.";
                    }
                } else {
                    $this->messages = "Wrong username / password combination. Try again.";
                }
            } else {
                $this->messages = "Database connection problem.";
            }
        }
    }

    public function doLogout()
    {
        $_SESSION = array();
        session_destroy();
        $this->messages = "You have been logged out.";
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
