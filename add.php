<?php
include_once('inc/header.php');

$msg='';

if(isset($_POST['post'])&&($_POST['post']=='Add Now')){
	$title = $_POST['title'];
	$description = nl2br(addslashes($_POST['description']));
	$price = $_POST['price'];
	$quantity = $_POST['quantity'];

	$imgrelation = $_POST['imgrelation'];
	
	$sql = "insert into product_details (`prod_relation`,`prod_title`,`prod_description`,`prod_price`,`prod_quqntity`)values('".$imgrelation."','".$title."','".$description."','".$price."','".$quantity."')";
	$res = mysqli_query($conn,$sql);
	if($res){
		$_SESSION['msg'] = '<div class="alert alert-success">Successfully! Added.</div>';
		header('location:index.php');
	}else{
		$msg = '<div class="alert alert-danger">Sorry! Fail to Add.</div>';
	}
}



?>

<div class="container">
  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
          <h2 class="text-white pb-2 fw-bold">Products</h2>
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
              <h4 class="card-title">Add Product</h4>
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
                          <input type="text" class="form-control" name="title" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Description:</label>
                        <div class="input-group">
                          <textarea name="description" id="description"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Price($):</label>
                        <div class="input-group">
                          <input type="number" class="form-control" name="price" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Quantity:</label>
                        <div class="input-group">
                          <input type="number" class="form-control" name="quantity" required />
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="submit" name="post" class="btn btn-primary ml-3 mt-2 mb-3" id="submit" value="Add Now">
                  <input type="hidden" id="imgrelation" name="imgrelation" />
                </form>
              </div>
              <div class="col-md-6 col-sm-8 col-xs-12">
                <form action="upload.php" class="dropzone" id="dropDiv" method="post" enctype="multipart/form-data">
                  <div class="dz-message" data-dz-message>
                    <div class="icon"> <i class="flaticon-file"></i> </div>
                    <h4 class="message">Drag and Drop image here</h4>
                  </div>
                  <div class="fallback">
                    <input name="file" type="file" multiple  />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	tinymce.init({
	  selector: 'textarea#description',  
	  auto_focus: 'element1',
	  width: "700",
	  height: "180"
	});
	</script> 
<script>

Dropzone.options.dropDiv = {
    acceptedFiles: 'image/*'
};
jQuery(".dropzone").dropzone({
	success : function(file, response) {
		if(response=='fail'){
			$("#submit").attr('disabled','disabled');
		}else{
			$("#imgrelation").val(response);
		}
	}
});
</script>
<?php
include('inc/footer.php');
?>