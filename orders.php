<?php
 
 error_reporting( error_reporting() & ~E_NOTICE ); 
  
 include('config.php'); 
 
 //header("Access-Control-Allow-Origin: *");
 
 //$table1 = "ALTER TABLE orders ADD billing_address TEXT NOT NULL"; 
 //mysql_query($table1);
 
 
/*$sql = "CREATE TABLE IF NOT EXISTS `order_info` (
				  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				  `email` varchar(100) NOT NULL,
				  `order_date` date NOT NULL,
				  `order_id` INT(11) NOT NULL,
				  `payment_status` INT(3) NOT NULL,
				  `delivery_status` INT(3) NOT NULL,
				  `billing_address` TEXT NOT NULL
				)";
		$retval = mysql_query($sql);
		if(! $retval )
		{
		  die('Could not delete table: ' . mysql_error());
		}else{
		  echo "Table created successfully\n";
} 
 */
 
if($_REQUEST['del']==1 && $_REQUEST['id']!=''){
	
	$sql = mysql_query("delete from orders where id=".$_REQUEST['id']."");
	echo "Deleted successfully."; 
	 
 }
 

	/*$sql = mysql_query("delete from orders");
	echo "Deleted all successfully."; 
	
	$sql = mysql_query("delete from order_info");
	echo "Deleted all successfully."; */



?>

 <h2>All Orders </h2>
 <table>    
    <tr>
      <td><strong>#</strong></td>
      <td><strong>Order#</strong></td>
      <td><strong>Name</strong></td>
      <td><strong>Price</strong></td>
      <td><strong>Quantity</strong></td>
      <td><strong>Email</strong></td>
      <td><strong>Date</strong></td>
    </tr>   
    <?php	 
	     $k=0; 
		 $sql = mysql_query("select * from orders");
		 while($res = mysql_fetch_array($sql)){
		 $k++;
	?>
     <tr>
          <td><?php echo $k; ?></td>
          <td><?php echo $res['order_id']; ?></td>
          <td><?php echo $res['pro_name']; ?></td>
          <td><?php echo $res['pro_price']; ?></td>
          <td><?php echo $res['pro_qty']; ?></td>
          <td><?php echo $res['email']; ?></td>
          <td><?php echo $res['order_date']; ?></td>
          <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?del=1&id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure want to delete?');">X</a></td>
        </tr>
<?php } ?> 

       <tr>
         <td colspan="7"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?delall=1" onClick="return confirm('Are you sure want to delete?');">Delete all</a></td>
        </tr>

</table>

<h2>Orders Info </h2>

<table>    
    <tr>
      <td><strong>#</strong></td>
      <td><strong>Order#</strong></td>
      <td><strong>Date</strong></td>
      <td><strong>Email</strong></td>
      <td><strong>Billing Address</strong></td>
      <td><strong>Payment Status</strong></td>
      <td><strong>Delivery Status</strong></td>
    </tr>   
    <?php	 
	     $k=0; 
		 $sql = mysql_query("select * from order_info");
		 while($res = mysql_fetch_array($sql)){
		 $k++;
	?>
     <tr>
          <td><?php echo $k; ?></td>
          <td><?php echo $res['order_id']; ?></td>
          <td><?php echo $res['order_date']; ?></td>
          <td><?php echo $res['email']; ?></td>
          <td><?php echo $res['billing_address']; ?></td>
          <td><?php echo $res['payment_status']; ?></td>
          <td><?php echo $res['delivery_status']; ?></td>
          <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?del=1&id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure want to delete?');">X</a></td>
        </tr>
<?php } ?> 

       <tr>
         <td colspan="7"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?delall=1" onClick="return confirm('Are you sure want to delete?');">Delete all</a></td>
        </tr>

</table>








