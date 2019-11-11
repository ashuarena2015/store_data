<?php
 
 include('config.php'); 
 
 error_reporting( error_reporting() & ~E_NOTICE );
 
 	if($_REQUEST['invoice']=='' && $_REQUEST['orderid']=='' && $_REQUEST['getShippingTax']==''){

     $orders = array(); 
  	 //echo "select * from order_info where email='".$_REQUEST['email']."'";
	 $sql = mysql_query("select * from order_info where email='".$_REQUEST['email']."'");
	 while($res = mysql_fetch_array($sql)){
		
		 $orders[] = $res;
		
		 
		 
	 }
   
     echo json_encode($orders);


	}
	
	if($_REQUEST['invoice']!='' && $_REQUEST['orderid']=='' && $_REQUEST['getShippingTax']==''){
		
		/*---- Mail Function after order placed -----------*/
			$to = $_REQUEST['email'];
			$subject = 'Order Details - Store App';
			$from = "info@storeapp.com";
	
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";		
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Create email headers		
			$headers .= "From: orders@mystore.com" . "\r\n" .
						"CC: ashuarena@gmail.com";
		
			// Compose a simple HTML email message		
			$message = '<html><body>';
			$message .= '<h1 style="color:#333;">Hi '.$_REQUEST['email'].'</h1>';		
			$message .= '<p style="color:#080;font-size:18px;">Here is your order.</p>';
			$message .= "<h2>Order Details</h2>";
			$message .= "<table style='border:1px solid #e2e2e2; border-collapse:collapse;'>";
			 $sql3 = mysql_query("select * from users where email='".$_REQUEST['email']."'");
			 $res3 = mysql_fetch_array($sql3);
			$message .= "<tr><td colspan='5' style='border:1px solid #e2e2e2; padding:10px;'><h3>".$res3['name']."</h3>";
			if($_POST['defaultAddress']==1){
				  $address = $res3['address_1'];
			 }else{ 
				  $address = $res3['address_2'];
			 }
			 $message .= "<p>".$address."</p></td></tr>";
			 $message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;' colspan='5'>Order No. - ".$_REQUEST['invoice']." Date: <b>".$date."</b></td></tr>";
			 $message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;'>#</td><td style='border:1px solid #e2e2e2; padding:10px;'>Product Name</td><td style='border:1px solid #e2e2e2; padding:10px;'>Price/Qty</td><td style='border:1px solid #e2e2e2; padding:10px;'>Qty</td><td style='border:1px solid #e2e2e2; padding:10px;'>Price (In Rs.)</td></tr>";
			 $k=0; 
			 $sql = mysql_query("select * from orders where order_id='".$_REQUEST['invoice']."'");
			 while($res = mysql_fetch_array($sql)){
				$k++;
				$message .= "<tr><td style='border:1px solid #e2e2e2; padding:10px;'>".$k."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['pro_name']."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['pro_price']."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['pro_qty']."</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res['qty_price']."</td></tr>";
			 }
			$sql2 = mysql_query("select *,SUM(qty_price) AS total_pro_price from orders where order_id='".$_REQUEST['invoice']."'"); 		
			$res2 = mysql_fetch_array($sql2);
			
			$totalPriceAfterTaxAndShipping = $res2['total_pro_price']+($res2['total_pro_price']*7.5/100);
			
			$shipping =  $_REQUEST['shipping'];
			$taxRate =   $_REQUEST['taxRate'];
			
			$tax = $res2['total_pro_price']*$taxRate/100;
			
			$message .= "<tr><td align='right' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Shipping: </td></td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$shipping."</b></td></tr>";
			$message .= "<tr><td align='right' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Tax: </td></td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$tax."</b></td></tr>";
			$message .= "<tr><td align='right' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Tax Rate: </td></td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$taxRate."%</b></td></tr>";
			
			$message .= "<tr><td align='right' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Total: </td></td><td style='border:1px solid #e2e2e2; padding:10px;'><b>".$totalPriceAfterTaxAndShipping."</b></td></tr>"; 		
			$message .= "<tr><td align='right' colspan='4' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Payment Status:</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res2['payment_status']."</td></tr>";
			$message .= "<tr><td align='right' colspan='4' style='border:1px solid #e2e2e2; padding:10px;' colspan='4'>Delivery Status:</td><td style='border:1px solid #e2e2e2; padding:10px;'>".$res2['delivery_status']."</td></tr>";
			$message .= "</table>";
			$message .= '</body></html>';
			
			
			//echo $message;
			
			// Sending email		
			if(mail($to, $subject, $message, $headers)){		
				echo 1;		
			}else{		
				echo 0;
			} 
			
	}
	
	if($_REQUEST['orderid']!='' && $_REQUEST['getShippingTax']==''){
		 	
		 
		 $order = array();
		 $total = array(); 
		 $sql = mysql_query("select * from orders where email='".$_REQUEST['email']."' and order_id=".$_REQUEST['orderid']."");
		 while($res = mysql_fetch_array($sql)){
			 $order[] = $res;
		 }
		 
	  	 //$orders = array_merge($order,$total);
		 //print_r($orders);
		 echo json_encode($order);


	}
	
	if($_REQUEST['getShippingTax']!=''){
		 	
		 
		 $total = array(); 
		 $sql = mysql_query("select * from order_info where email='".$_REQUEST['email']."' and order_id=".$_REQUEST['orderid']."");
		 while($res = mysql_fetch_array($sql)){
			 $total[] = $res;
		 }

		 echo json_encode($total);


	}


?>