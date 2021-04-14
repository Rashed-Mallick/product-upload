<?php
include_once('inc/header.php');

/**************** The PHP code for edit form submission ********************************************************/
$msg='';
if(isset($_POST['post'])&&($_POST['post']=='Update Now')){
	$id = $_GET['id'];
	$title = $_POST['title'];
	$description = nl2br(addslashes($_POST['description']));
	$price = $_POST['price'];
	$quantity = $_POST['quantity'];
	$imgrelation = $_POST['imgrelation'];
	if($imgrelation==''){
		echo $sql = 'update product_details set prod_title="'.$title.'",prod_description="'.$description.'",prod_price="'.$price.'",prod_quqntity="'.$quantity.'" where prod_id ='.$id;
	}else{
		$sql = 'update product_details set prod_title="'.$title.'",prod_relation="'.$imgrelation.'",prod_description="'.$description.'",prod_price="'.$price.'",prod_quqntity="'.$quantity.'" where prod_id='.$id;
	}
	$res = mysqli_query($conn,$sql);
	if($res){
		$_SESSION['msg'] = '<div class="alert alert-success">Successfully! Updated.</div>';
		header('location:index.php');
	}else{
		$msg = '<div class="alert alert-danger">Sorry! Fail to Updated.</div>';
	}
}
/**************** End ********************************************************/

/**************** Retrieve a product details from database ********************************************************/
if(isset($_GET['id'])&&($_GET['id']!='')){
	$id = $_GET['id'];
	$sqle = 'select * from product_details where prod_id='.$id;
	$rese = mysqli_query($conn,$sqle);
	$rowe = mysqli_fetch_assoc($rese);
	
	$sqlF = 'select * from product_image where img_relation='.$rowe['prod_relation'];
	$resF = mysqli_query($conn,$sqlF);
}
/**************** End ********************************************************/
?>

<div class="container">
  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
          <h2 class="text-white pb-2 fw-bold">Product</h2>
        </div>
        <div class="ml-md-auto py-2 py-md-0"> </div>
      </div>
    </div>
  </div>
  <div class="page-inner mt--5">
    <div class="row mt--4">
      <div class="col-md-12">
        <div class="card card-black">
          <div class="card-header"><?php echo $msg; ?>
            <div class="d-flex align-items-center">
              <h4 class="card-title">Edit Product</h4>
              <a href="index.php" class="btn btn-success btn-round ml-auto"> <i class="fa fa-arrow-left"></i> Back </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Title:</label>
                        <div class="input-group">
                          <input type="text" class="form-control" name="title" required value="<?php echo $rowe['prod_title']; ?>" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Description:</label>
                        <div class="input-group">
                          <textarea class="" name="description" id="description" rows="4" cols="50"><?php echo stripslashes($rowe['prod_description']); ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Price($):</label>
                        <div class="input-group">
                          <input type="number" class="form-control" name="price" value="<?php echo $rowe['prod_price']; ?>" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Quantity:</label>
                        <div class="input-group">
                          <input type="text" class="form-control" name="quantity"  value="<?php echo $rowe['prod_quqntity']; ?>" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="imgrelation" name="imgrelation" />
                  <input type="submit" name="post" class="btn btn-primary ml-2 mb-3" value="Update Now">
                </form>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                  <div class="col-md-12">
                    <form action="upload_edit.php" id="dropDiv" class="dropzone" method="post" enctype="multipart/form-data">
                      <div class="dz-message" data-dz-message>
                        <div class="icon"> <i class="flaticon-file"></i> </div>
                        <h4 class="message">Drag and Drop files here</h4>
                      </div>
                      <div class="fallback">
                        <input name="file" type="file" multiple />
                      </div>
                      <input type="hidden" id="rowid" name="rowid" value="<?php echo $_GET['img_id']; ?>" />
                      <input type="hidden" id="relation" name="relation" value="<?php echo $rowe['prod_relation']; ?>" />
                    </form>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <?php
						while($rowF = mysqli_fetch_assoc($resF)){
							$ext = end(explode('.',$rowF['img_images']));
							$imgArr = array('jpg','JPG','JPEG','jpeg','png','PNG','gif','GIF');
							if(in_array($ext,$imgArr)){
								$file = '<img src="assets/upload/'.$rowF['img_images'].'" class="img-fluid" draggable="false" width="100%">';
							}else{
								$file = '<img src="assets/img/empty.png" class="img-fluid mt-2" draggable="false" width="50%">';
							}
						?>
                      <div class="col-md-4 pb-3 mt-3" id="<?php echo $rowF['img_id']; ?>">
                        <div class="kanban-item imgheight" draggable="false">
                          <div class="kanban-image text-center"> <a href="<?php echo 'assets/upload/'.$rowF['img_images']; ?>"> <?php echo $file; ?> </a> </div>
                          <div class="kanban-edit" onclick="delRecord(<?php echo $_GET['id']; ?>,<?php echo $rowF['img_id']; ?>,'<?php echo $rowF['img_images']; ?>')"> <i class="fa fa-trash-alt"></i> </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
/************** The js code for description editor *********************************/
tinymce.init({
  selector: 'textarea#description',  //Change this value according to your HTML
  auto_focus: 'element1',
  width: "700",
  height: "180"
});
/************** End *********************************/

/************** Assign only image upload on drag and drop***************************/
Dropzone.options.dropDiv = {
    acceptedFiles: 'image/*'
};
/************** End ***************************/

/************** Drag and drop image upload **************************************/
jQuery(".dropzone").dropzone({
	success : function(file, response) {
		if(response=='fail'){
			$("#submit").attr('disabled','disabled');
		}else{
			$("#imgrelation").val(response.trim());
		}
	}
});
/************** End ***************************/

/************** Delete a particular image from directory and database ***************************/
function delRecord(edit,id,file){
	if(confirm('Are you really want to delete?')){
		$.ajax({
			type: 'get',
			url: 'ajaxdelete.php?id='+edit+'&del='+id+'&file='+file,
			data: '',
			success: function(msg){
				$("#"+id).remove();
			}
		})
	}
}
/************** End ***************************/
</script>
<?php
include('inc/footer.php');
?>