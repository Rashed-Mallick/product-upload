<?php
error_reporting(0);
include_once('inc/db_connection.php');
/*************** Delete from directory and database ******************************/
if(isset($_GET['del'])&&isset($_GET['file'])){
	$ds = DIRECTORY_SEPARATOR;  //1

	$sqlD = 'delete from product_image where img_id='.$_GET['del'];
	$resD = mysqli_query($conn, $sqlD);
	unlink(dirname( __FILE__ ) . $ds.'assets/upload/'.$_GET['file']);
	echo 'true';
}
/*************** End ******************************/

?>