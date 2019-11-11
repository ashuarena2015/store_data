<?php
 
 error_reporting( error_reporting() & ~E_NOTICE ); 
  
 include('config.php'); 

 //header("Access-Control-Allow-Origin: *");
	     
		// echo "select * from users where email='".$_REQUEST['logged_email']."'"; 
		 
		 
	     $get = array();
		  
		 $sql = mysql_query("select * from users where email='".$_REQUEST['logged_email']."'");
		 $res = mysql_fetch_array($sql);
		 $get[] = $res;
		 
		 echo json_encode($get);

?>

