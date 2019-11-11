<?php
 
 include('config.php'); 
 
 //header("Access-Control-Allow-Origin: *");    
	 
	 //echo $_REQUEST['cid'];

     $cat = array(); 
     
	 $sql = mysql_query("select * from products where id=".$_REQUEST['pid']."");
	// $sql = mysql_query("select * from products");
	 while($res = mysql_fetch_array($sql)){
		
		 $cat[] = $res;
		
		 
		 
	 }
   
    echo json_encode($cat);


?>