<?php
 
 error_reporting( error_reporting() & ~E_NOTICE );
 include('config.php'); 

 ///$table1 = "ALTER TABLE orders ADD (qty_price INT(10) NOT NULL)"; 
 //mysql_query($table1);	
 
 //$table = "TRUNCATE TABLE order_info";
 //$table1 = "TRUNCATE TABLE orders";
 
// mysql_query($table);
 //mysql_query($table1);

	 /*$sql = "CREATE TABLE IF NOT EXISTS `orders` (
				  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				  `pro_name` varchar(100) NOT NULL,
				  `pro_price` INT(5) NOT NULL,
				  `pro_qty` INT(3) NOT NULL,
				  `email` varchar(100) NOT NULL,
				  `order_date` date NOT NULL,
				  `order_id` INT(11) NOT NULL,
				  `payment_status` INT(3) NOT NULL,
				  `delivery_status` INT(3) NOT NULL
				)";
		$retval = mysql_query($sql);
		if(! $retval )
		{
		  die('Could not delete table: ' . mysql_error());
		}else{
		  echo "Table created successfully\n";
		}*/
	
	/*$sql = "DROP TABLE orders";
	$retval = mysql_query($sql);
	if(! $retval )
	{
	  die('Could not delete table: ' . mysql_error());
	}else{
	echo "Table deleted successfully\n";
	}*/

  $json = file_get_contents('php://input');
	
	//echo $json;  

    //convert json object to php associative array
    $result = json_decode($json);
	//$result->items = json_encode($result->items);
	
	//echo $data->name;
	//echo "hello"; 
	//print_r($result->items);
	
	$maindata = $result->items ;
	
	$shipping = $result->shipping;
	$tax = $result->tax;
	$taxRate = $result->taxRate;
	
	$a = mysql_query("select * from order_info order by id desc limit 1");
	$b = mysql_fetch_array($a);
	
	$orderid = $b['order_id']+1;
	//$orderid = $_REQUEST['orderID'];
	//$orderid = mt_rand(100000, 999999);
	
	//echo $orderid;
	
	$date = date('Y-m-d');
    // loop through the array
	
	//echo 1;
	//die();
	
	$checkExistOrder = mysql_query("select order_id from order_info where order_id=".$orderid."");
	$num = mysql_num_rows($checkExistOrder);
	
	if($_POST['email_update']==''){
		if($num < 1){	
			foreach($maindata as $row) { 
			
				//print_r($row);
			   
				$pro_name = $row->name;
				$pro_price = $row->price;
				$qty = $row->quantity;
				$pro_total = $row->total;
				$pro_img = $row->img;
				$email = $_REQUEST['email'];
				$date = date('Y-m-d');
				$payment_status = 0;
				$delivery_status = 0;
				
				// execute insert query
				mysql_query("insert into orders (pro_name,pro_price,pro_qty,qty_price,email,order_date,order_id,payment_status,delivery_status) values('".$pro_name."',".$pro_price.",".$qty.",'".$pro_total."','".$email."','".$date."',".$orderid.",".$payment_status.",".$delivery_status.")");
				
			}
			echo $orderid;
		}else{
			echo 0;  
		}
	}
	
	if($_POST['email_update']!=''){
	  
	  if($num < 1){	  
	    //echo "insert into order_info(email,order_id,order_date,payment_status,delivery_status,billing_address)values('".$_POST['email_update']."',".$_POST['orderID'].",".date('Y-m-d').",0,0,".$_POST['defaultAddress'].")";
	    mysql_query("insert into order_info(email,order_id,order_date,payment_status,delivery_status,billing_address)values('".$_POST['email_update']."',".$orderid.",'".$date."',0,0,".$_POST['defaultAddress'].")");
		$insertId = mysql_insert_id();
		if($insertId!=''){
			/*---- Mail Function after order placed -----------*/
			$to = $_POST['email_update'];
			$subject = 'Order Details - Store App';
			$from = $_POST['email_update'];
	
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";		
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Create email headers		
			$headers .= "From: orders@mystore.com" . "\r\n" .
						"CC: ashuarena@gmail.com";
		
			// Compose a simple HTML email message		
			$message = '<html><body>';
			$message .= '<h1 style="color:#333;">Hi '.$_POST['email_update'].'</h1>';		
			$message .= '<p style="color:#080;font-size:18px;">Here is your order.</p>';
			$message .= "<h2>Order Details</h2>";
			$message .= "<table style='border:1px solid #e2e2e2; border-collapse:collapse;'>";
			 $sql3 = mysql_query("select * from users where email='".$_POST['email_update']."'");
			 $res3 = mysql_fetch_array($sql3);
			$message .= "<tr><td colspan='5' style='border:1px solid #e2e2e2; padding:10px;'><h3>".$res3['name']."</h3>";
			if($_POST['defaultAddress']==1){
				  $address = $res3['address_1'];
			 }else{ 
				  $address = $res3['address_2'];
			 }
			 $message .= "<p>".$address."</p></td></tr>";
			 $message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;' colspan='5'>Order No. - ".$orderid." Date: <b>".$date."</b></td></tr>";
			 $message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;'>#</td><td style='border:1px solid #e2e2e2; padding:10px;'>Product Name</td><td style='border:1px solid #e2e2e2; padding:10px;'>Price/Qty</td><td style='border:1px solid #e2e2e2; padding:10px;'>Qty</td><td style='border:1px solid #e2e2e2; padding:10px;'>Price (In Rs.)</td></tr>";
			 $k=0; 
			 $sql = mysql_query("select * from orders where order_id='".$_POST['orderID']."'");
			 while($res = mysql_fetch_array($sql)){
				$k++;
				$message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;'>".$k."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['pro_name']."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['pro_price']."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['pro_qty']."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['qty_price']."</td></tr>";
			 }
			$sql2 = mysql_query("select *,SUM(qty_price) AS total_pro_price from orders where order_id='".$_POST['orderID']."'"); 		
			$res2 = mysql_fetch_array($sql2);
			
			$totalPriceAfterTaxAndShipping = $res2['total_pro_price']+($res2['total_pro_price']*7.5/100);
			
			$shipping =  $_REQUEST['shipping'];
			$taxRate = $_REQUEST['taxRate'];
			
			$tax = $res2['total_pro_price']*$taxRate/100;
			
			$message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;' colspan='4' align='right'>Shipping: </td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$shipping."</b></td></tr>";
			$message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;' colspan='4' align='right'>Tax: </td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$tax."</b></td></tr>";
			$message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;' colspan='4' align='right'>Tax Rate: </td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$taxRate."%</b></td></tr>";
			
			$message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;' colspan='4' align='right'>Total: </td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$totalPriceAfterTaxAndShipping."</b></td></tr>"; 	
			$message .= "<tr><td align='right' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Payment Status:</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res2['payment_status']."</td></tr>";
			$message .= "<tr><td align='right' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Delivery Status:</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res2['delivery_status']."</td></tr>";
				
			$message .= "</table>";
			$message .= '</body></html>';
			
			//echo $message;
			
			
			// Sending email		
			if(mail($to, $subject, $message, $headers)){		
				echo 1;		
			}else{		
				echo 0;
			}
	  }else{
		  echo 2;
	  }
	  }else{
		echo 4;  
	  }
	}	
	

?>