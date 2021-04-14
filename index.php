<?php
include_once('inc/header.php');

/****************** Delete a product from database and remove the images from directory **********************************/
$msg = '';
if(isset($_GET['del'])&&($_GET['del']!='')){
	$id = $_GET['del'];
	$sqlImg = 'select img_images from product_image where img_relation='.$_GET['rel'];
	$resImg = mysqli_query($conn,$sqlImg);
	while($row=mysqli_fetch_assoc($resImg)){
		unlink('assets/upload/'.$row['img_images']);
	}
	$sqlF = 'delete from product_image where img_relation='.$_GET['rel'];
	$resF = mysqli_query($conn, $sqlF);
	
	$sqlD = 'delete from product_details where prod_id='.$_GET['del'];
	$resD = mysqli_query($conn, $sqlD);
	if($resD){
		$msg = '<div class="alert alert-success">Successfully! Deleted.</div>';
	}
}
/****************** End **********************************/

/****************** Fetching all products from database **********************************/
$sql = 'select * from product_details where 1 order by prod_id desc';
$res = mysqli_query($conn,$sql);
$row_num = mysqli_num_rows($res);
/****************** End **********************************/
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
        <div class="card card-grey">
          <div class="card-header"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?><?php echo $msg; ?>
            <div class="d-flex align-items-center">
              <h4 class="card-title">Product Grid</h4>
              <a href="add.php" class="btn btn-success btn-round ml-auto"> <i class="fa fa-plus"></i> Add Product </a> </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover table-head-bg-info" >
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
					if($row_num>0){
						$i=1;
					while($row = mysqli_fetch_assoc($res)){
						$sqlF = 'select * from product_image where img_relation='.$row['prod_relation'].'';
						$resF = mysqli_query($conn,$sqlF);
						$rowF = mysqli_fetch_assoc($resF);
						$rowN = mysqli_num_rows($resF);
						$ext = end(explode('.',$rowF['img_images']));
						$imgArr = array('jpg','JPG','JPEG','jpeg','png','PNG','gif','GIF');
						if($ext==''){
							$file = 'assets/img/empty.png';
						}else{
							if(in_array($ext,$imgArr)){
								$file = 'assets/upload/'.$rowF['img_images'];
							}
						}
					?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['prod_title']; ?></td>
                    <td class="text-justify"><div class="hidetxt"><?php echo $row['prod_description']; ?></div>
                      <?php 
						if(strlen($row['prod_description'])>=200) {
							echo substr(stripslashes($row['prod_description']),0,160).'...<a href="javascript:void(0)" class="badge badge-info wraptext">More</a>';
						}else{
							echo stripslashes($row['prod_description']);
						}
						?>
                    </td>
                    <td>$<?php echo number_format($row['prod_price'],2); ?></td>
                    <td><?php echo $row['prod_quqntity']; ?></td>
                    <td><?php if($file!='assets/img/empty.png'){ ?>
                      <a class="imgthumb" href="assets/upload/<?php echo $rowF['img_images']; ?>"><span class="badge badge-secondary"><?php echo $rowN; ?></span><img src="<?php echo $file; ?>" width="40"></a>
                      <?php } ?></td>
                    <td><div class="form-button-action"> <a href="edit.php?id=<?php echo $row['prod_id']; ?>" data-toggle="tooltip" title="" class="btn-link btn-primary mr-3" data-original-title="Edit Order"> <i class="fa fa-edit"></i> </a> <a href="javascript:void(0)" onclick="delRecord(<?php echo $row['prod_id']; ?>,'<?php echo $row['prod_relation']; ?>')" data-toggle="tooltip" title="" class="btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </a> </div></td>
                  </tr>
                  <?php
						}
					}else{
						echo '<tr><td colspan="10" class="alert alert-danger">Empty Record!</td></tr>';
					}
					?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	$(".wraptext").on('click', function(){
		var txt = $(this).parent().parent().find('.hidetxt').html();
		$(this).parent().parent().html(txt);
	})
})
function selStatus(val){
	window.location = 'index.php?select='+val;
}
function delRecord(id,rel){
	if(confirm('Are you really want to delete?')){
		window.location = 'index.php?del='+id+'&rel='+rel;
	}
}
</script>
<?php
include('inc/footer.php');
?>