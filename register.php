<?php
 
 error_reporting( error_reporting() & ~E_NOTICE ); 
  
 include('config.php'); 
 
 //header("Access-Control-Allow-Origin: *");
 
 $table1 = "CREATE TABLE users (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(50) NOT NULL,
			email VARCHAR(30) NOT NULL,
			password VARCHAR(20)
			)";
 mysql_query($table1);
 
 $table2 = "ALTER TABLE users ADD validate int(2) NOT NULL";
 mysql_query($table2);
 
 $table3 = "ALTER TABLE users ADD validate_key VARCHAR(255) NOT NULL";
 mysql_query($table3);
  
  
 $name =  $_POST['name_reg']; 
 $email =  $_POST['email_reg'];
 $mobile =  $_POST['mobile_reg'];
 $pass  =  $_POST['password_reg'];

 $checkEmail = mysql_query("select * from users where email='".$email."'");
 $num = mysql_num_rows($checkEmail);
 
 $key = $email.$email;
 
 if($num > 0){	 
	$get = array();
	$get[] = 0;
    echo json_encode($get);
 }else{
	 $get = array();   
	 $sql = mysql_query("insert into users(name,mobile,email,password,validate,validate_key) values('".$name."','".$mobile."','".$email."','".$pass."','0','".md5($key)."')");
	/* while($res = mysql_fetch_array($sql)){		
		 $get[] = $res;
	 }*/
	 $insertId = mysql_insert_id();
	 if($insertId > 0){
		
		$to = $email;
		$subject = "Welcome, Please validate your email";		
		
		// To send HTML mail, the Content-type header must be set
		$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
		$headers .= "CC:";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = "<html><body>";
		$message .= '<a href="http://ideaweaver.in/samples/mystore/signup-validate.php">Click here to validate your account</a>'; 
		$message .= '</body></html>';
		
	 	mail($to, $subject, $message, $headers);
	 }
	
	//echo $email;
	 
    echo json_encode($email);
	 
 }


?>