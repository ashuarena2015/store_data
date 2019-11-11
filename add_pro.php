<?php
 
 
 error_reporting( error_reporting() & ~E_NOTICE );
 
 include('config.php');
 
 header("Access-Control-Allow-Origin: *");
 
 
 $table1 = "ALTER TABLE category ADD cat_icon VARCHAR(255) NOT NULL";
 $table2 = "ALTER TABLE category ADD cat_desc VARCHAR(255) NOT NULL";
 mysql_query($table1);
 mysql_query($table2);
 
 
 $table3 = "CREATE TABLE products (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			pro_name VARCHAR(150) NOT NULL,
			pro_price VARCHAR(30) NOT NULL,
			pro_desc VARCHAR(50)
			)";
 mysql_query($table3);


 $table4 = "ALTER TABLE products ADD pro_img VARCHAR(255) NOT NULL";
 mysql_query($table4);
 
 $table5 = "ALTER TABLE products ADD category int(11) NOT NULL";
 mysql_query($table5);
 
 
 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['addCategorySubmit'])){

	if (!empty($_FILES["cat_icon"]["name"])) {

		$file_name=$_FILES["cat_icon"]["name"];
		$temp_name=$_FILES["cat_icon"]["tmp_name"];
		$imgtype=$_FILES["cat_icon"]["type"];
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$imgType = $_FILES['cat_icon']['type']; //returns the mimetype
		$allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf");
		if(!in_array($imgType, $allowed)) {
		  echo 'Only jpg, gif and png files are allowed.';
		}else{
			$imagename=date("d-m-Y")."-".time().".".$ext;
			$target_path = "icons/".$imagename;
			if(move_uploaded_file($temp_name, $target_path)) {
				$sql = mysql_query("insert into category(category,cat_desc,cat_icon) values ('".$_POST['cat_name']."','".$_POST['cat_desc']."','".$target_path."')");
				echo "Category added.";
			}else{
			   exit("Error While uploading image on the server");
			} 
		}
	
	}
	
	 
	 
 }
 
 
 
 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['editCatFormSubmit'])){

	if (!empty($_FILES["cat_icon"]["name"])) {

		$file_name=$_FILES["cat_icon"]["name"];
		$temp_name=$_FILES["cat_icon"]["tmp_name"];
		$imgtype=$_FILES["cat_icon"]["type"];
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$imgType = $_FILES['cat_icon']['type']; //returns the mimetype
		$allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf");
		if(!in_array($imgType, $allowed)) {
		  echo 'Only jpg, gif and png files are allowed.';
		}else{
		
			$imagename=date("d-m-Y")."-".time().".".$ext;
			$target_path = "icons/".$imagename;
			
		
			if(move_uploaded_file($temp_name, $target_path)) {
				
				//echo "update category set category='".$_POST['cat_name']."', cat_desc='".$_POST['cat_desc']."', cat_icon='".$target_path."' where id=".$_POST['cat_id']."";
			   //die('Ashu');
				
				$sql = mysql_query("update category set category='".$_POST['cat_name']."', cat_desc='".$_POST['cat_desc']."', cat_icon='".$target_path."' where id=".$_POST['cat_id']."");
				echo "Category updated.";
			}else{
			   
			   exit("Error While uploading image on the server");
			} 
		}
	
	}else{
		
		//echo "update category set category='".$_POST['cat_name']."', cat_desc='".$_POST['cat_desc']."' where id=".$_POST['cat_id']."";
		//die('Ashutosh');
		
	    $sql = mysql_query("update category SET category='".$_POST['cat_name']."', cat_desc='".$_POST['cat_desc']."' where id=".$_POST['cat_id']."");
		echo "Category updated.";	
	}
	
	 
	 
 }
 
 
 if($_REQUEST['catDelete']!='' && $_REQUEST['cat_id']!=''){
	 
	 $sql = mysql_query("delete from category where id=".$_REQUEST['cat_id']."");
	 echo "Category deleted!";
	 
 }
 
 
 
 
 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['addProductSubmit'])){

	if (!empty($_FILES["pro_img"]["name"])) {

		$file_name=$_FILES["pro_img"]["name"];
		$temp_name=$_FILES["pro_img"]["tmp_name"];
		$imgtype=$_FILES["pro_img"]["type"];
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$imgType = $_FILES['pro_img']['type']; //returns the mimetype
		$allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf");
		if(!in_array($imgType, $allowed)) {
		  echo 'Only jpg, gif and png files are allowed.';
		}else{
			$imagename=date("d-m-Y")."-".time().".".$ext;
			$target_path = "products_img/".$imagename;
			if(move_uploaded_file($temp_name, $target_path)) {
				//echo "insert into products(category,pro_name,pro_desc,pro_price,pro_img) values ('".$_POST['cat_id']."','".$_POST['pro_name']."','".$_POST['pro_desc']."','".$_POST['pro_price']."','".$target_path."')";
				//die('aaaaaa');
				$sql = mysql_query("insert into products(category,pro_name,pro_desc,pro_price,pro_img) values ('".$_POST['cat_id']."','".$_POST['pro_name']."','".$_POST['pro_desc']."','".$_POST['pro_price']."','".$target_path."')");
				echo "Product added.";
			}else{
			   exit("Error While uploading image on the server");
			} 
		}
	
	}
	
	 
	 
 }
 
 
 if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['editProFormSubmit'])){

	if (!empty($_FILES["pro_img"]["name"])) {

		$file_name=$_FILES["pro_img"]["name"];
		$temp_name=$_FILES["pro_img"]["tmp_name"];
		$imgtype=$_FILES["pro_img"]["type"];
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$imgType = $_FILES['pro_img']['type']; //returns the mimetype
		$allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf");
		if(!in_array($imgType, $allowed)) {
		  echo 'Only jpg, gif and png files are allowed.';
		}else{
		
			$imagename=date("d-m-Y")."-".time().".".$ext;
			$target_path = "icons/".$imagename;
			
		
			if(move_uploaded_file($temp_name, $target_path)) {
				
				//echo "update products set category=".$_POST['cat_id'].", pro_name='".$_POST['pro_name']."', pro_desc='".$_POST['pro_desc']."', pro_img='".$target_path."', pro_price=".$_POST['pro_price']." where id=".$_POST['pro_id']."";
			   // die('Ashu');
				
				$sql = mysql_query("update products set category=".$_POST['cat_id'].", pro_name='".$_POST['pro_name']."', pro_desc='".$_POST['pro_desc']."', pro_img='".$target_path."', pro_price=".$_POST['pro_price']." where id=".$_POST['pro_id']."");
				echo "Product updated.";
			}else{
			   
			   exit("Error While uploading image on the server");
			} 
		}
	
	}else{
		
		//echo "update products SET category=".$_POST['cat_id'].", pro_name='".$_POST['pro_name']."', pro_desc='".$_POST['pro_desc']."', pro_price='".$_POST['pro_price']."' where id=".$_POST['pro_id']."";;
		//die('Ashutosh');
		
	    $sql = mysql_query("update products SET category=".$_POST['cat_id'].", pro_name='".$_POST['pro_name']."', pro_desc='".$_POST['pro_desc']."', pro_price='".$_POST['pro_price']."' where id=".$_POST['pro_id']."");
		echo "Product updated.";	
	}
	
	 
	 
 }
 
 
  if($_REQUEST['proDelete']!='' && $_REQUEST['pro_id']!=''){
	 
	 $sql = mysql_query("delete from products where id=".$_REQUEST['pro_id']."");
	 echo "Product deleted!";
	 
 }
 

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Products</title>
</head>


<style>

 .category_table{}
 .category_table td{padding:5px; border:1px solid #e2e2e2; border-collapse:collapse;}

</style>

<body>

  <h2>Add Category</h2> 
   <form action="" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="addCat" value="1">
    <p><input required type="text" name="cat_name" placeholder="Category Name"></p>
    <p><input required type="text" name="cat_desc" placeholder="Category Description"></p>
    <p><input required type="file" name="cat_icon"></p>
    <p><input required type="submit" value="Add Category" name="addCategorySubmit"></p>
  
  </form><br>


   <h2>Edit Category</h2> 
   
  <?php 
     
	 if(!isset($_REQUEST['catEdit'])){
	 
  ?> 
   
   <table cellpadding="0" cellspacing="0" class="category_table">
   
    <?php
	     $k=0;
	     $cat = mysql_query("select * from category");
	     while($data = mysql_fetch_array($cat)){ 
		 $k++;
	?>
     <tr>
       <td><?php echo $k; ?></td>
       <td><img src="<?php echo $data['cat_icon']; ?>" width="50"></td>
       <td><?php echo $data['category']; ?></td>
       <td><?php echo $data['cat_desc']; ?></td>
       <td><?php echo $data['cat_icon']; ?></td>
       <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?catEdit=y&cat_id=<?php echo $data['id']; ?>">Edit</a> / <a onClick="return confirm('Are you sure want to delete?');" href="<?php echo $_SERVER['PHP_SELF']; ?>?catDelete=y&cat_id=<?php echo $data['id']; ?>">Delete</a></td>
     </tr>
    <?php } ?> 
   </table>
   
   <?php }else{ 
     
	 $getCat = mysql_query("select * from category where id=".$_REQUEST['cat_id']."");
	 $getCatData = mysql_fetch_array($getCat);
   
   
   ?> 
    <form name="editCatForm" action="" method="post" enctype="multipart/form-data">
        
        <div><img src="<?php echo $getCatData['cat_icon']; ?>" width="75"></div>
        
        <input type="hidden" name="editCat" value="1">
        <input type="hidden" name="cat_id" value="<?php echo $getCatData['id']; ?>">
        <p><input required type="text" name="cat_name" value="<?php echo $getCatData['category']; ?>"></p>
        <p><input required type="text" name="cat_desc" value="<?php echo $getCatData['cat_desc']; ?>"></p>
        <input type="hidden" name="cat_prev_icon" value="<?php echo $getCatData['cat_icon']; ?>">
        <p><input type="file" name="cat_icon"></p>
        <p><input required type="submit" value="Edit Category" name="editCatFormSubmit"></p>
  
   </form>
    
   
   <?php } ?>

   <br>

  <h2>Add Product</h2> 
   
  <form action="" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="addPro" value="1">
    <p>
       
       <select name="cat_id" required>
         <option value="">Choose Category</option>
         <?php
		   $sql = mysql_query("select * from category");
		   while($res = mysql_fetch_array($sql)){
		 ?>
          <option value="<?php echo $res['id']; ?>"><?php echo $res['category']; ?></option>
         <?php } ?>
       </select>
       
    </p>
    <p><input required type="text" name="pro_name" placeholder="Product Name"></p>
    <p><input type="text" name="pro_price" placeholder="Price"></p>
    <p><textarea name="pro_desc" placeholder="Product Description"></textarea></p>
    <p><input type="file" name="pro_img"></p>
    <p><input type="submit" value="Add Product" name="addProductSubmit"></p>
  
  </form>
    
    
    
    <h2>Edit Product</h2> 
   
  <?php 
     
	 if(!isset($_REQUEST['proEdit'])){
	 
  ?> 
   
   <table cellpadding="0" cellspacing="0" class="category_table">
   
    <?php
	     $k=0;
	     $pro = mysql_query("select * from products");
	     while($data = mysql_fetch_array($pro)){ 
		 $k++;
	?>
     <tr>
       <td><?php echo $k; ?></td>
       <td><img src="<?php echo $data['pro_img']; ?>" width="50"></td>
       <td><?php echo $data['pro_name']; ?></td>
       <td><?php echo $data['pro_price']; ?></td>
       <td><?php echo $data['pro_desc']; ?></td>
       <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?proEdit=y&pro_id=<?php echo $data['id']; ?>">Edit</a> / <a onClick="return confirm('Are you sure want to delete?');" href="<?php echo $_SERVER['PHP_SELF']; ?>?proDelete=y&pro_id=<?php echo $data['id']; ?>">Delete</a></td>
     </tr>
    <?php } ?> 
   </table>
   
   <?php }else{ 
     
	 $getPro = mysql_query("select * from products where id=".$_REQUEST['pro_id']."");
	 $getProData = mysql_fetch_array($getPro);
   
   
   ?> 
    <form action="" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="editPro" value="1">
    <input type="hidden" name="pro_id" value="<?php echo $getProData['id']; ?>">
    <p>
       <select name="cat_id" required>
         <option value="">Choose Category</option>
         <?php
		   $sql = mysql_query("select * from category");
		   while($res = mysql_fetch_array($sql)){
		 ?>
          <option value="<?php echo $res['id']; ?>" <?php if($res['id']== $getProData['category']){ echo "selected"; } ?>><?php echo $res['category']; ?></option>
         <?php } ?>
       </select>
       
    </p>
    <p><input required type="text" name="pro_name" value="<?php echo $getProData['pro_name']; ?>"></p>
    <p><input type="text" name="pro_price" value="<?php echo $getProData['pro_price']; ?>"></p>
    <p><textarea name="pro_desc"> <?php echo $getProData['pro_desc']; ?></textarea></p>
    <input type="hidden" name="pro_prev_img" value="<?php echo $getCatData['pro_img']; ?>">
    <p><input type="file" name="pro_img"></p>
    <p><input type="submit" value="Edit Product" name="editProFormSubmit"></p>
  
  </form>
    
   
   <?php } ?>

   <br>

</body>
</html>



