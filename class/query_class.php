<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Query
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


   
    public function doQuery()
    {
    
   
   $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");

            
    // change character set to utf8 and check it       
    if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }      

    // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                $len1 = sizeof($_SESSION["style"]);
                $len2 = sizeof($_SESSION["price"]);

                $price_level = array();
                for ($x = 0; $x < $len2; $x++) {
                    if($_SESSION["price"][$x]=='Less than $10'){
                        array_push($price_level, "1");
                    }
                    if($_SESSION["price"][$x]=='$10-$20'){
                        array_push($price_level, "2" );
                    }
                    if($_SESSION["price"][$x]=='$20-$30'){
                        array_push($price_level, "3");
                    }
                    if($_SESSION["price"][$x]=='More than $30'){
                        array_push($price_level,"4");
                    }


                }




                if($len1==0 && $len2 ==0){
                //if($len1==0){ 
                $sql = "SELECT name, address,image_url
                    FROM restaurants
                    ;";
                $result_of_query = $this->db_connection->query($sql);
                } 
                

                else{
                     $sql_prefix = "SELECT name, address,image_url
                                FROM restaurants
                                WHERE";

                
                    for ($x = 0; $x < $len1; $x++) {

                        $style_name = '%'.$_SESSION["style"][$x].'%';

                       
                        $sql =" categories like '".$style_name."' ";
                        
                        //array_push($this->sqlArray, $sql);
                        $this->sqlArray_type[]=$sql;
                        //echo $sql;

                        $sql_type = implode(" OR ", $this->sqlArray_type);

                        $sql_type = "(".''. $sql_type .''. ")";
           

                    }
                     
                    for ($x = 0; $x < $len2; $x++) {
                         $sql = " price_level like '" .  $price_level[$x]. "'
                            ";  
                         //array_push($this->sqlArray, $sql);
                         $this->sqlArray_price[]=$sql;
                         $sql_price = implode(" OR ", $this->sqlArray_price);
                         $sql_price = "(".''. $sql_price .''. ")";

                    } 
                
                
                    if($len1==0){
                        $sql_final =$sql_prefix .''. $sql_price;
                    }
                    elseif($len2==0){
                        $sql_final =$sql_prefix .''.$sql_type;
                    }
                    else{
                        $sql_final = $sql_prefix .''. $sql_type .''.  " AND " .' '. $sql_price;
                    }
                    
                    

                $result_of_query = $this->db_connection->query($sql_final);
                
                
            }


                
                $_SESSION["sql_queryfinal"] = $sql_final;
                $_SESSION["r_name"] = array();
                $_SESSION['r_name_query'] = array();
                $_SESSION['r_ima']= array();
                

                for ($x = 0; $x < $result_of_query->num_rows; $x++){
                $row = $result_of_query->fetch_object();
                
                array_push($_SESSION["r_name"],$row->name);
                array_push($_SESSION["r_name_query"],$row->name);
                
                
                }
                
               
                
                
                
                

                
               
                //mysql_close($db);// close mysql then do other job with set_time_limit(59)
                // $len= sizeof(result_addr);
                // for ($x = 0; $x < len; $x++) {
                //     echo $result_addr[$x];
                //     echo $result_image[$x];

                // }
                
                    
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
