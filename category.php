<?php
 
 
 include('config.php'); 
 
 	header("Access-Control-Allow-Origin: *");

     $cat = array(); 
  
	 $sql = mysql_query("select * from category");
	 while($res = mysql_fetch_array($sql)){
		
		 $cat[] = $res;
		
		 
		 
	 }
   
    echo json_encode($cat);


?>