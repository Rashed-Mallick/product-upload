<?php
include_once('inc/db_connection.php');
error_reporting(1);

/***************** Images upload on directory and image name save in directory **********************************/
$sql = 'select prod_id from product_details order by prod_id desc limit 1';
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);

$ds = DIRECTORY_SEPARATOR;  //1
$storeFolder = 'assets/upload';   //2
if(!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];          //3             
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
	$filename = time().'.'.$_FILES['file']['name'];
    $targetFile =  $targetPath. $filename;  //5
    $mov = move_uploaded_file($tempFile,$targetFile); //6
	
     if($mov==true){
		$rel = $row['prod_id']==''?1:$row['prod_id'];
		$sql = "insert into product_image (`img_relation`,`img_images`)values('".$rel."','".$filename."')";
		$res = mysqli_query($conn,$sql);
		echo $rel;
	 }else{
		 echo 'fail';
	 }
}
/***************** End **********************************/
?>
