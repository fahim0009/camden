<?php session_start(); 
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>


      <div class="row">
      	<div class="col-10">
      		<h4>Manage Coupon</h4>
      	</div>
      	<div class="col-2">
      		<a href="#" data-toggle="modal" data-target="#add_category_modal" class="btn btn-primary btn-sm">Add Coupon</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Coupon Code</th>
              <th>Coupon Percentage</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="all_mails">
            <!-- <tr>
              <td>1</td>
              <td>ABC</td>
              <td>FDGR.JPG</td>
              <td>122</td>
              <td>eLECTRONCS</td>
              <td>aPPLE</td>
              <td><a class="btn btn-sm btn-info"></a><a class="btn btn-sm btn-danger">Delete</a></td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>



<!-- Add time slot Modal -->
<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-mail-form" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Coupon Code</label>
		        		<input type="mail" name="paypalmail" class="form-control" placeholder="Enter coupon code">
		        	</div>
        		</div>
                <div class="col-12">
        			<div class="form-group">
		        		<label>Coupon Percentage</label>
		        		<input type="number" name="invoicemail" class="form-control" placeholder="">
		        	</div>
        		</div>
        		<input type="hidden" name="coupon" value="1">
        		<div class="col-12">
        			<button type="button" class="btn btn-primary addmail">Add Coupon</button>
        		</div>
        	</div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->



<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/coupon.js"></script>