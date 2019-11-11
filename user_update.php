<?php
 
 error_reporting( error_reporting() & ~E_NOTICE ); 
  
 include('config.php'); 
 
 //header("Access-Control-Allow-Origin: *"); 
  
 $name =  $_POST['name_update']; 
 $email =  $_POST['email_update'];
 $mob	=  $_POST['mobile_update'];
 $pass  =  $_POST['pass_update'];
 $add1  =  $_POST['address1_update'];
 $add2  =  $_POST['address2_update'];
 //$default_add  =  $_POST['default_address'];


// echo $name.",".$email.",".$pass.",".$add1.",".$add2.",".$default_add;

 $checkEmail = mysql_query("select * from users where email='".$email."'");
 $num = mysql_num_rows($checkEmail);

 if($num > 0){
	 
	 $get = array();   
	 $sql = mysql_query("update users set name='".$name."', mobile='".$mob."', password='".$pass."',address_1='".$add1."',address_2='".$add2."' where email='".$email."'");
 		  
	 $sql2 = mysql_query("select * from users where email='".$email."'");
	 $res2 = mysql_fetch_array($sql2);
	 $get[] = $res2;
		 
	 echo json_encode($get);

 }else{
	echo "0";
 }


?>