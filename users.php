<?php
 
 error_reporting( error_reporting() & ~E_NOTICE ); 
  
 include('config.php'); 
 
 //header("Access-Control-Allow-Origin: *");
 
 $table1 = "ALTER TABLE users ADD default_address INT(2) NOT NULL"; 
 mysql_query($table1);
 
 if($_REQUEST['del']!='' && $_REQUEST['id']!=''){
	
	$sql = mysql_query("delete from users where id=".$_REQUEST['id']."");
	echo "Deleted successfully."; 
	 
 }


?>

<style>
   
   table{}
   table td{ padding:5px;border:1px solid #ccc; border-collapse:collapse;}

</style>

 <table>    
    <tr>
      <td><strong>#</strong></td>
      <td><strong>Name</strong></td>
      <td><strong>Email</strong></td>
      <td><strong>Password</strong></td>
      <td><strong>Address 1</strong></td>
      <td><strong>Address 2</strong></td>
      <td><strong>Default Address</strong></td>
      <td><strong>Action</strong></td>
    </tr>   
    <?php	 
	     $k=0; 
		 $sql = mysql_query("select * from users");
		 while($res = mysql_fetch_array($sql)){
		 $k++;
	?>
     <tr>
          <td><?php echo $k; ?></td>
          <td><?php echo $res['name']; ?></td>
          <td><?php echo $res['email']; ?></td>
          <td><?php echo $res['password']; ?></td>
          <td><?php echo $res['address_1']; ?></td>
          <td><?php echo $res['address_2']; ?></td>
          <td><?php echo $res['default_address']; ?></td>
          <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?del=1&id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure want to delete?');">X</a></td>
        </tr>

<?php } ?> 


</table>