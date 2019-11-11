<?php
 
 error_reporting( error_reporting() & ~E_NOTICE ); 
  
 include('config.php'); 
 
 header("Access-Control-Allow-Origin: *");
 
 $table1 = "CREATE TABLE users (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(50) NOT NULL,
			email VARCHAR(30) NOT NULL,
			password VARCHAR(20)
			)";
 mysql_query($table1);
  
  
 $appUser = $_REQUEST['app_user'];

 $checkEmail = mysql_query("select * from users where email='".$appUser."'");
 $num = mysql_num_rows($checkEmail);
 
// echo "select * from users where email='".$email."'";
 
 $data = array();

 if($num > 0){ 
	 $sql = mysql_query("select * from users where email='".$appUser."'");
	 while($res = mysql_fetch_array($sql)){
	   $data[] = array('email' => $res['email'], 'user_id' => $res['id'] );
	 }
 }else{   
	$data[] = array('error' => 'Invalid login');
 }

 echo json_encode($data);


?>
