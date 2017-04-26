SELECT `have_histroy`.`user_name`,`restaurants`.`categories`, COUNT(`restaurants`.`categories`) AS num
FROM `have_histroy` JOIN `restaurants`
ON `have_histroy`.`restaurant_name`=`restaurants`.`name`
GROUP BY `restaurants`.`categories`,`have_histroy`.`user_name`
HAVING `have_histroy`.`user_name`='xiaruirui'

                    

SELECT `have_histroy`.`user_name`,`restaurants`.`categories`, COUNT(`restaurants`.`categories`) AS num
FROM `have_histroy` JOIN `restaurants`
ON `have_histroy`.`restaurant_name`=`restaurants`.`name`
GROUP BY `restaurants`.`categories`,`have_histroy`.`user_name`
HAVING `have_histroy`.`user_name`<>'xiaruirui'


$rname= implode("','", $_SESSION["r_name_query"]);
                
SELECT DISTINCT(`restaurant_name`)
FROM `have_histroy`  
WHERE `restaurant_name` IN ('". $rname .
"') AND
`attitude`<>-1 AND (
`user_name`='" .$_SESSION['user_name'].
"' OR `user_name`='" .$resultData[0].
"' OR `user_name`='" .$resultData[1].
"' OR `user_name`='" .$resultData[2].
"' OR `user_name`='" .$resultData[3]."');";


    
    

         