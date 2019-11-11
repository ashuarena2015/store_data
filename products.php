<?php
 
 include('config.php'); 
     
	 
	 //echo $_REQUEST['cid'];

	 header("Access-Control-Allow-Origin: *");
	 
     $cat = array(); 
     
	 $sql = mysql_query("select * from products where category=".$_REQUEST['cid']."");
	// $sql = mysql_query("select * from products");
	 while($res = mysql_fetch_array($sql)){
		
		 $cat[] = $res;
		
		 
		 
	 }
   
    echo json_encode($cat);


?>