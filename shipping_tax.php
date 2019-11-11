<?php
 
 
 error_reporting( error_reporting() & ~E_NOTICE );
 
 include('config.php');

 $table = "CREATE TABLE shipping_tax (
			shipping int(5) NOT NULL,
			tax int(5) NOT NULL
			)";
 mysql_query($table);

 
 
 	 $shippingTax = array(); 
  	 //echo "select * from order_info where email='".$_REQUEST['email']."'";
	 $sql = mysql_query("select * from shipping_tax");
	 while($res = mysql_fetch_array($sql)){
		
		 $shippingTax[] = $res;
		
		 
		 
	 }
     echo json_encode($shippingTax);


?>


