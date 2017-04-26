<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class QueryHis
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    public $sqlArray_price= array();
    public $sqlArray_type= array();

    /**
     * @var array Collection of success / neutral messages
     */

    public function doInsertHis() //Insert History if choose "go"
    {
   
   $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
    
            
    // change character set to utf8 and check it       
    if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }      

    // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                //Insert a history tuple, including username, resname and time
                //$_SESSION["r_rec_name"] 
                //$_SESSION['user_name'] 
                
                date_default_timezone_set('America/Chicago');
                
                $localtime = localtime();
                $localtime_assoc = localtime(time(), true);
                
                $time_array= array($localtime_assoc[tm_mon]+1,$localtime_assoc[tm_mday],$localtime_assoc[tm_year]+1900);
                $time =implode("/", $time_array);
                // print $time;
                
                $sql_prefix = "INSERT INTO `have_histroy` (user_name, date, restaurant_name,attitude)
                    VALUES('";
                
                $val_arr= array($_SESSION['user_name'] ,$time, $_SESSION["r_rec_name"] );
                $values =implode("','", $val_arr);
                    
                $sql_suffix="',0);";
                $sql_final =$sql_prefix .''. $values .''.$sql_suffix;
                //print $sql_final;
                
                // INSERT INTO `have_histroy` VALUES('ruixia0819','4/16/2017/5','xxxx',0);
                
                $this->db_connection->query($sql_final);
                    
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
        
    
    public function doQueryHis(){
        // print "run doQueryHis sucessfully";
   
        $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
        // change character set to utf8 and check it       
        if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }      
    
        // if no connection errors (= working database connection)
                if (!$this->db_connection->connect_errno) {
                    // print "connect database sucessfully";
                    //SELECT * FROM `have_histroy` WHERE `user_name`='ruixia0819'
                    $sql_prefix = "SELECT * FROM `have_histroy`
                    WHERE `user_name`='";
                    
                    $sql_suffix="';";
                    $sql_final =$sql_prefix .''. $_SESSION['user_name'] .''.$sql_suffix;
                    //print $sql_final;
                    
                    $result_of_query = $this->db_connection->query($sql_final);
                    
                    
                    $_SESSION["his_date"]=array();
                    $_SESSION["his_rn"]=array();
                        
                    for ($x = 0; $x < $result_of_query->num_rows; $x++){
                        $row = $result_of_query->fetch_object();
                        
                        
                        list($month, $day, $year,$hour) = split ('[/.-]', $row->date);
                        $hours = ($year-2000)*365*24+$month*30*24+$day*24+$hour;
                        
                       
                        $_SESSION["his_date"][$row->his_id]=$row->date;
                        $_SESSION["his_rn"][$row->his_id]=$row->restaurant_name;
                        
                        // print $hours;
                        // print $row->restaurant_name;    
                
                    }
                    
                    krsort($_SESSION["his_date"]);
                    krsort($_SESSION["his_rn"]);
                    
                    
                    
                    // foreach ($_SESSION["his_date"] as $key => $val) {
                    //     echo "$key = $val ;";
                    // }
                        
                        
                } else {
                    $this->errors[] = "Database connection problem.";
                }
        }
    public function doInsertPost($message){
        
        if ($message=="Type your message here"){
            $message="Hey I am going to " .$_SESSION['r_rec_name']. ". Come join me!";
        }
        $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        date_default_timezone_set('America/Chicago');
        $localtime = localtime();
        $localtime_assoc = localtime(time(), true);
        $hour_array=array($localtime_assoc[tm_hour],$localtime_assoc[tm_min]);
        $day_array= array($localtime_assoc[tm_mon]+1,$localtime_assoc[tm_mday],$localtime_assoc[tm_year]+1900);
        $hour = implode(":", $hour_array);
        $day = implode("/", $day_array);
        $time=$hour." ".$day;
        $insert = "INSERT INTO have_posts (poster_name,time_stamp,message,number,poster_email,type,restaurant_name) 
                        VALUES('"
                        ;
                        
        $value_arr = array($_SESSION['user_name'],$time,$message,1,$_SESSION['user_email'],1,$_SESSION['r_rec_name']);
        $value=implode("','",$value_arr);
        $insert=$insert.$value."');";
       // echo $insert;
        $this->db_connection->query($insert);
    }
        
        
}
