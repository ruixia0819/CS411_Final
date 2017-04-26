<?php

class Recommend
{
    /**
     * @var object The database connection
     */
    
    private $db_connection = null;
    private $array_cur =array();
    
   
    public function doRecommend()
    {
        
        $this->db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
        
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }      


        
        // -----------------------------------Query Have_Histroy,users to find training data--------------------------------------- 
        //History tab, number of tab for each users-->List
        //users' taste
        //$_SESSION["r_name"], the input restaurants to be recommended
        //
        
        //query history of current user
        $sql_his_cur= "SELECT `have_histroy`.`user_name`,`restaurants`.`categories`, COUNT(`restaurants`.`categories`) AS num
                    FROM `have_histroy` JOIN `restaurants`
                    ON `have_histroy`.`restaurant_name`=`restaurants`.`name`
                    GROUP BY `restaurants`.`categories`,`have_histroy`.`user_name`
                    HAVING `have_histroy`.`user_name`=
                    '".$_SESSION['user_name']."'
                    ";
         
        $result_cur = $this->db_connection->query($sql_his_cur);
        
        
        
        $arr_cur=array();
        
        for ($x = 0; $x < $result_cur->num_rows; $x++){
            $row = $result_cur->fetch_object();
            //array_push($arr_cur,"dsjiah");
            
            $arr_cur[$row->categories]=$row->num;
            
         }
        
        
        //If nothing satisfied notice to try again
        if(sizeof($_SESSION["r_name_query"])==0){
             $_SESSION["python_var"]= "runing to 1";   
            //open an altert
            alert("No satisfied return, please try it again!");
//             $result='<div class="alert alert-success" role="alert">
// 			<strong>"No satisfied return, please try it again!"</strong></div>';
			//header("Location: query1.php");
            
        }
        
        elseif($_SESSION["should_recm"]==0 or sizeof($_SESSION["r_name"])==1){
            
            $_SESSION["r_name"]=$_SESSION["r_name_query"];
            //$_SESSION["python_var"]= "$_SESSION["should_recm"]"; 
            $_SESSION["python_var"]="running to 2";
            $_SESSION["should_recm"]=0;
            
        }
        
        
        //If no history for current user, use random algorithm
        elseif($_SESSION["should_recm"]==1 and sizeof($arr_cur)!==0 ){
         $_SESSION["python_var"]= "runing to 3";   
  
        //query history from other users
        $sql_his_others= 
                    "SELECT `have_histroy`.`user_name`,`restaurants`.`categories`, COUNT(`restaurants`.`categories`) AS num
                    FROM `have_histroy` JOIN `restaurants`
                    ON `have_histroy`.`restaurant_name`=`restaurants`.`name`
                    GROUP BY `restaurants`.`categories`,`have_histroy`.`user_name`
                    HAVING `have_histroy`.`user_name`<>
                    '".$_SESSION['user_name']."'
                    ";
                    
       
        
        $result_others = $this->db_connection->query($sql_his_others);
        $arr_others =array();
        
        for ($x = 0; $x < $result_others->num_rows; $x++){
            $row = $result_others->fetch_object();
            if(!isset($arr_others[$row->user_name]))
                $arr_others[$row->user_name]=array();
                
            $arr_others[$row->user_name][$row->categories]=$row->num;
            
         }
         
 
         // ----------------------------call python recommend algorithm-------------------------------------
                
        // This is the data you want to pass to Python
        
        
        //  Query data and give to python
        
        //      data points of other users:
        // 		[[(user1),(category1,freq1),(category2, freq2),...()], 
        // 		[(user2),(category1,freq1),(category2, freq2),...()], 
        // 		...                                         ]
        // 	    current user
        // 		[(category1,freq1),(category2, freq2),...()]
        
        $command='python /home/queenoflibra/public_html/CS411_Project/python/clustering.py '.escapeshellarg(json_encode($arr_others)) .' '. escapeshellarg(json_encode($arr_cur)); 
        //$_SESSION["python_var"]=$command;
                    
        //exec('public_html/CS411_Project/python/test_php.py' .escapeshellarg(json_encode($arr_cur)), $output);
        //python /home/queenoflibra/public_html/CS411_Project/python/test_php.py '{"0":"Chinese","Chinese":"1","1":"Coffee & Tea,Cafes","Coffee & Tea,Cafes":"1","2":"Mediterranean,Arabian","Mediterranean,Arabian":"1"}'

        $output=exec($command);
        //Decode the result
        
        $resultData = json_decode($output, true);
        
        //The results from clustering is a list with the nearest three users[usr1, usr2, usr3]
        
        
        
        // query history of other users 
        $rname= implode("','", $_SESSION["r_name_query"]);
        if(sizeof($resultData)==4){
            $sql_cluster="SELECT DISTINCT(`restaurant_name`)
                FROM `have_histroy`  
                WHERE `restaurant_name` IN ('". $rname .
                "') AND
                `attitude`<>-1 AND (
                `user_name`='" .$_SESSION['user_name'].
                "' OR `user_name`='" .$resultData[0].
                "' OR `user_name`='" .$resultData[1].
                "' OR `user_name`='" .$resultData[2].
                "' OR `user_name`='" .$resultData[3]."');";
                
                 //$_SESSION["python_var"]= $sql_cluster;
            
            $result_recm = $this->db_connection->query($sql_cluster);
            
        }
        
        if($result_recm->num_rows>0){
            $_SESSION["r_name"]=array();
            //$_SESSION["python_var"]= "runing to 4";   
            for ($x = 0; $x < $result_recm->num_rows; $x++){
                    $row = $result_recm->fetch_object();
                    array_push($_SESSION["r_name"],$row->restaurant_name);
    
                    }
             
        }
        }
      
       
        //$_SESSION["python_var"]=$_SESSION["r_name"][1];
        $len = sizeof($_SESSION["r_name"]);
        //$_SESSION["python_var"]=$len;
        $res_idx= rand(0, $len-1);
        $_SESSION["r_rec_name"]= $_SESSION["r_name"][$res_idx];
        
 
        // --------------------------------- End  Recommend Algorithm-------------------------------------           
        //The algorithm should output a $_SESSION["r_rec_name"] which is a restaurant name
                
      
        
        $sql     = "SELECT *
                    FROM restaurants
                    WHERE name = 
                    '".$_SESSION["r_rec_name"]."'
                    ";
                    
        $result = $this->db_connection->query($sql);
        $row = $result->fetch_object();
       
        //$_SESSION["r_rec_pl"] =$row->price_level;
         
        
        $_SESSION["r_rec_rating"] =$row->rating;
        $_SESSION["r_rec_type"] =$row->categories;
        $_SESSION['r_rec_addr']= $row->address;
        $_SESSION['r_rec_ima']= $row->image_url;
        $_SESSION["r_rec_pl"]=$row->price_level;
        $_SESSION["phone"]=$row->phone;
       
      
        //$_SESSION["r_rec_food"]=$row->price_level;
        

        // echo $_SESSION["r_rec_name"];
    
                
                
                
        }
    }
?>
