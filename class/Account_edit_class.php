<?php

/**
 * Class registration
 * handles the user registration
 */
class Edit
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["submit_button"])) {
            header('Location: Account.php');
            $this->editPerference();

        } 
        
        if (isset($_POST["delete_button"])) {
            header('Location: Login.php');
            $this->deleteAccount();

        } 
            
        
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */

    private function editPerference()
    {
            $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");


            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               
                $user_name =  $_SESSION['user_name'];
                $user_email = $_SESSION['user_email']; 
                
                $taste = $this->db_connection->real_escape_string($_POST['taste']);
                $favourite = $this->db_connection->real_escape_string($_POST['favourite']);
                $hate = $this->db_connection->real_escape_string($_POST['hate']);
                $user_email_change = $this->db_connection->real_escape_string($_POST['user_email']); 

                echo $user_name;
                echo $taste;

                $sql = "UPDATE users 
                        SET taste='" .$taste. "' 
                        WHERE  user_name = '" .$user_name. "';";

                $this->db_connection->query($sql);
                
                
                $sql = "UPDATE users SET favourite='" .$favourite. "' WHERE  user_name = '" .$user_name. "';";
                $this->db_connection->query($sql);
                
                
                $sql = "UPDATE users SET hate='" .$hate. "' WHERE  user_name = '" .$user_name. "';";
                $this->db_connection->query($sql);

                $sql = "UPDATE users SET user_email='" .$user_email_change. "' WHERE  user_name = '" .$user_name. "';";
                $this->db_connection->query($sql);

                
                $sql ="SELECT taste, hate, favourite, user_email
                        FROM users
                        WHERE user_name = '" .$user_name. "';";
                
                
                
                $result = $this->db_connection->query($sql);
                $result_row = $result->fetch_object();


                
                $_SESSION['user_email'] = $result_row->user_email;
                $_SESSION['taste'] = $result_row->taste;
                $_SESSION['hate'] = $result_row->hate;
                $_SESSION['favourite'] = $result_row->favourite;


                

                    // if user has been added successfully
                
            } else {
                $this->errors[] = "Sorry, no database connection.";
            
        } 
    }
    
      private function deleteAccount()
    {
           $user_name =  $_SESSION['user_name'];
           $user_email = $_SESSION['user_email']; 
           $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");


            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {


                $sql = "DELETE FROM users 
                        WHERE  user_name = '" .$user_name. "';";
                        

                $this->db_connection->query($sql);
                 unset($_SESSION['user_login_status']);
                 unset($_SESSION['user_name']);
                

            
                
            } else {
                $this->errors[] = "Sorry, no database connection.";
            
        } 
    }
}
