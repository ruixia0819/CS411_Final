<?php

/**
 * Class record
 * handles the user's login and logout process
 */
class Record
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * array store the query records
     *
     **/
    public $inviters = array();
    public $messages = array();
    public $restaurants = array();
    public $timeStamps = array();
    public $peoples = array();
    public $numbers = array();
    public $addrs = array();
    public $attenders = array();
    public $post_id = array();
    
    
    public function getRecord(){
        $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
    // change character set to utf8 and check it       
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }      

    // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            $sql = "SELECT * FROM have_posts ORDER BY post_id DESC LIMIT 5";
            $result_of_query = $this->db_connection->query($sql);
            
            for ($x = 0; $x < $result_of_query->num_rows; $x++){
                $row = $result_of_query->fetch_object();
                array_push($this->inviters,$row->poster_name);
                array_push($this->messages,$row->message);
                array_push($this->restaurants,$row->restaurant_name);
                array_push($this->timeStamps,$row->time_stamp);
                array_push($this->attenders,$row->attenders);
                array_push($this->numbers,$row->number);
                array_push($this->post_id,$row->post_id);
                $test_sql = "SELECT * FROM restaurants WHERE name = '" .$row->restaurant_name."'";
                $result = $this->db_connection->query($test_sql);
                if($result){
                   array_push($this->addrs, $result->fetch_object()->address);
                }else{
                    echo "Empty";
                }
                
                //push positions into peoples
                
                $get_position = "SELECT * FROM position WHERE user_name = '".$row->poster_name."'";
                if($row->attenders!=null){
                    $attender=null;
                    $attender = explode(",",$row->attenders);
                    for($i=0;$i<sizeof($attender);$i++){
                        if($attender[$i]!=""){
                        $get_position = $get_position." Or user_name='".$attender[$i]."'";
                        }
                    }
                }
                // echo $get_position;
                $res_position  = $this->db_connection->query($get_position);
                for($y=0;$y<$res_position->num_rows;$y++){
                    $row_pos=$res_position->fetch_object();
                    // if($y==0){
                    //     array_push($this->peoples,$row->poster_name);
                    // }else{
                    //     array_push($this->peoples,$attender[$y-1]);
                    // }
                    array_push($this->peoples,$row_pos->user_name);
                    array_push($this->peoples,$row_pos->lat);
                    array_push($this->peoples,$row_pos->lng);
                    array_push($this->peoples,$this->addrs[$x]);
                    //push info into peoples
                    //array_push($peoples,$info);
                    
                }
                
               // array_push($this->addrs, $result->fetch_object()->address);
            }
            
            
           
        }else {
                $this->errors[] = "Database connection problem.";
        }
    }
    public function joinMeal($id){
        $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        $join_sql="SELECT attenders FROM have_posts WHERE post_id=".$id." LIMIT 1";
        $result_of_join=$this->db_connection->query($join_sql);
        if($result_of_join!=null){
            $obj=$result_of_join->fetch_object();
            // echo $obj->attenders;
            $oriAttender=$obj->attenders;
            $newAttender=$oriAttender.$_SESSION['user_name'].",";
            $update_sql="UPDATE have_posts SET attenders='".$newAttender."' WHERE post_id=".$id;
            // echo $update_sql;
            $this->db_connection->query($update_sql);
        }else{
            echo $join_sql;
        }
        
        // $oriAttender=$obj->attenders;
        // echo $oriAttender;
    }
     
}
?>