<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

if(isset($_POST["category"])){
	$category_query = "SELECT * FROM categories";
	$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));

	
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$cid = $row["cat_id"];
			$cat_name = $row["cat_title"];
			echo "
					<li><a href='#' class='category list-group-item' cid='$cid'>$cat_name</a></li>
			";
		}
		
	}
}
if(isset($_POST["brand"])){
	$brand_query = "SELECT * FROM brands";
	$run_query = mysqli_query($con,$brand_query);
	echo "
		<div class='nav nav-pills nav-stacked'>
			<li class='active'><a href='#'><h4>Brands</h4></a></li>
	";
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$bid = $row["brand_id"];
			$brand_name = $row["brand_title"];
			echo "
					<li><a href='#' class='selectBrand' bid='$bid'>$brand_name</a></li>
			";
		}
		echo "</div>";
	}
}
if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/9);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<li><a href='#' page='$i' id='page'>$i</a></li>
		";
	}
}
if(isset($_POST["getProduct"])){
	$limit = 9;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	$product_query = "SELECT * FROM products LIMIT $start,$limit";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_desc = $row['product_desc'];
			$pro_image = $row['product_image'];
			$subcat = $row['subcat'];

			if ($subcat == 0) {
				echo "<div class='col-md-9 col-xs-12'>
			<h3 style='margin-top: 0px'>$pro_title</h3>
			<p>$pro_desc</p>
			<input type='text' placeholder=' Note' class='note$pro_id' style='width:100%;border:1px solid black;margin-bottom:20px;' />
			</div>
			<div class='col-md-2 col-xs-6'>£$pro_price</div>
			<div class='col-md-1 col-xs-6'>
			<button pid='$pro_id' style='float:right;' id='product' class='btn btn-danger btn-sm fahim'>Add</button></div>";
			} else {
				echo "
				<div class='col-md-9 col-xs-12'>
			<h3 style='margin-top: 0px'>$pro_title</h3>
			<p>$pro_desc</p>
			</div>
			<div class='col-md-2 col-xs-6'>£$pro_price</div>
			<div class='col-md-1 col-xs-6'>
			<a href='#' pid='$pro_id' style='float:right;' data-toggle='modal' data-target='#assignSubcat' class='btn btn-danger btn-sm pwithsubcat'>Add</a></div>";
			}			
		}
	}
}


// *************** get single product with assign subcategory***************** 

if(isset($_POST["get_p_ForsubC"]) & isset($_POST["pforscat_id"])){
	$pid = $_POST["pforscat_id"];
	$pp = "SELECT * FROM `products` where product_id='$pid'";
	$run_query = mysqli_query($con,$pp);
	if(mysqli_num_rows($run_query) > 0){
		echo"<form action='#' id='tblPosts' method='post'>
		<button type='button' class='close' data-dismiss='modal'>×</button>";
		
		while($row = mysqli_fetch_array($run_query)){
			$p_id    = $row['product_id'];
			$p_title = $row['product_title'];
			$p_desc = $row['product_desc'];
			$p_price = $row['product_price'];

			echo"<h4>".$p_title."&nbsp;&nbsp;&nbsp;&nbsp; Price: £".$p_price."</h4>
			<input type='text' id='noteforpop' placeholder=' Note' class='note$p_id' style='width:80%;border:1px solid black;margin-bottom:20px;' />	
			<input type='hidden' value='".$p_price."' id='pprice'/>
			<div id='subcatdtls'><input type='hidden' class='subcatdls' value='' data-note='' data-desces='Sauce :Peanut Sauce,' data-prices=''></div>";

			}

			echo"<div class='modal-body modal-scrol'>";
	}

	$subcat1 = "SELECT * FROM `code_master` where hardcode='sauce' and softcode>0";
	$run_query = mysqli_query($con,$subcat1);
	if(mysqli_num_rows($run_query) > 0){
		echo"<h3>Please select a sauce:</h3>";
		while($row = mysqli_fetch_array($run_query)){
			$sc_id    = $row['id'];
			$sc_hardcode   = $row['hardcode'];
			$sc_title = $row['description'];
			$sc_price = $row['price'];

			echo"<div class='radio'><label>
			<input name='sauce' type='radio' class='getSubcval' checked data-desc='".$sc_title."' />".$sc_title."</label>
			</div>";

		}
	}


	$subcat2 = "SELECT * FROM `code_master` where hardcode='Favourites' and softcode>0";
	$run_query = mysqli_query($con,$subcat2);
	if(mysqli_num_rows($run_query) > 0){
		echo" <h3>Add Favourites:</h3>";
		while($row = mysqli_fetch_array($run_query)){
			$sc_id    = $row['id'];
			$sc_hardcode   = $row['hardcode'];
			$sc_title = $row['description'];
			$sc_price = $row['price'];

			echo"<div class='checkbox'>
			<label><input name='group1' type='checkbox' class='getSubcval' data-desc='".$sc_title."' value='".$sc_price."'/>
			".$sc_title."&nbsp;&nbsp;&nbsp;&nbsp;£".$sc_price."</label>
		  </div>";
		}
	}


	$subcat3 = "SELECT * FROM `code_master` where hardcode='Toppings' and softcode>0";
	$run_query = mysqli_query($con,$subcat3);
	if(mysqli_num_rows($run_query) > 0){
		echo"<h3>Add Toppings:</h3>";
		while($row = mysqli_fetch_array($run_query)){
			$sc_id    = $row['id'];
			$sc_hardcode   = $row['hardcode'];
			$sc_title = $row['description'];
			$sc_price = $row['price'];

			echo"<div class='checkbox'>
			<label><input name='group1' type='checkbox' class='getSubcval' data-desc='".$sc_title."' value='".$sc_price."' />
			".$sc_title."&nbsp;&nbsp;&nbsp;&nbsp;£".$sc_price."</label>          
		  </div>";
		}
	}



	$subcat4 = "SELECT * FROM `code_master` where hardcode='Drinks' and softcode>0";
	$run_query = mysqli_query($con,$subcat4);
	if(mysqli_num_rows($run_query) > 0){
		echo"<h3>Add Drinks:</h3>";
		while($row = mysqli_fetch_array($run_query)){
			$sc_id    = $row['id'];
			$sc_hardcode   = $row['hardcode'];
			$sc_title = $row['description'];
			$sc_price = $row['price'];

			echo"<div class='checkbox'>
			<label><input name='group1' type='checkbox' class='getSubcval' data-desc='".$sc_title."' value='".$sc_price."'/>
			".$sc_title."&nbsp;&nbsp;&nbsp;&nbsp;£".$sc_price."</label>
			</div>";
		}
	}
	
			$subcat5 = "SELECT * FROM `code_master` where hardcode='Dietary Exceptions' and softcode>0";
		$run_query = mysqli_query($con,$subcat5);
		if(mysqli_num_rows($run_query) > 0){
			echo"<h3>Dietary Exceptions:</h3>";
			while($row = mysqli_fetch_array($run_query)){
				$sc_id    = $row['id'];
				$sc_hardcode   = $row['hardcode'];
				$sc_title = $row['description'];
				$sc_price = $row['price'];

	             echo"<div class='checkbox'>
				<label><input name='group1' type='checkbox' class='getSubcval' data-desc='".$sc_title."' value='".$sc_price."'/>
				".$sc_title."&nbsp;&nbsp;&nbsp;&nbsp;£".$sc_price."</label>
				</div>";


			}
		}
	
	echo"</div>
	<div class='modal-footer'>
	  <button pid='".$p_id."' style='float:right;' id='product' onclick='this.form.reset();'  class='btn btn-danger btn-xm totalwithsubcat fahim' data-dismiss='modal'>Add&nbsp;&nbsp;£".$p_price."</button><button type='button' style='float:left;' class='btn btn-default'  data-dismiss='modal' > Close </button>
	  </form>";

}
// *************** get single product with assign subcategory end***************** 


// *********** get subcategory end **********************


if(isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])){
	if(isset($_POST["get_seleted_Category"])){
		$id = $_POST["cat_id"];
		$sql = "SELECT * FROM products WHERE product_cat = '$id'";
	}else if(isset($_POST["selectBrand"])){
		$id = $_POST["brand_id"];
		$sql = "SELECT * FROM products WHERE product_brand = '$id'";
	}else {
		$keyword = $_POST["keyword"];
		$sql = "SELECT * FROM products WHERE product_keywords LIKE '%$keyword%'";
	}
	
	$run_query = mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
			$pro_desc = $row['product_desc'];
			$subcat = $row['subcat'];
			
			if ($subcat == 0) {
				echo "<div class='col-md-9 col-xs-12'>
			<h3 style='margin-top: 0px'>$pro_title</h3>
			<p>$pro_desc</p>
			<input type='text' placeholder=' Note' class='note$pro_id' style='width:100%;border:1px solid black;margin-bottom:20px;' />
			</div>
			<div class='col-md-2 col-xs-6'>£$pro_price</div>
			<div class='col-md-1 col-xs-6'>
			<button pid='$pro_id' style='float:right;' id='product' class='btn btn-danger btn-sm fahim'>Add</button></div>";
			} else {
				echo "
				<div class='col-md-9 col-xs-12'>
			<h3 style='margin-top: 0px'>$pro_title</h3>
			<p>$pro_desc</p>
			</div>
			<div class='col-md-2 col-xs-6'>£$pro_price</div>
			<div class='col-md-1 col-xs-6'>
			<a href='#' pid='$pro_id' style='float:right;' data-toggle='modal' data-target='#assignSubcat' class='btn btn-danger btn-sm pwithsubcat'>Add</a></div>";
			}

		}
	}
	


	if(isset($_POST["addToCart"])){		

		$p_id = $_POST["proId"];

		if(isset($_POST["subcatp"]) & isset($_POST["subcatd"])){

			$subcatprice = $_POST["subcatp"];
			$subcatdls = $_POST["subcatd"];	
			
		}else{
		    $subcatprice = 0;
			$subcatdls = "none";	
		}	

		if(isset($_POST["pnote"]) & $_POST["pnote"]==''){

			$note = "none";

		}else{

			$note = $_POST["pnote"];
		}

		if (isset($_SESSION["uid"]) || isset($_SESSION["gid"])){

				if(isset($_SESSION["uid"])){

            			$user_id = $_SESSION["uid"];	
            	
            		}elseif(isset($_SESSION["gid"])){
            	
            			$user_id = $_SESSION["gid"];
            	
            		}

				$sql = "INSERT INTO `cart`
				(`p_id`, `ip_add`, `user_id`, `qty`, `subcat_d`, `subcat_p`, `note`) 
				VALUES ('$p_id','$ip_add','$user_id','1','$subcatdls','$subcatprice','$note')";
				if(mysqli_query($con,$sql)){
					echo "
						<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is Added..!</b>
						</div>";
				}
						
		}else{
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`, `subcat_d`, `subcat_p`, `note`) 
			VALUES ('$p_id','$ip_add','-1','1','$subcatdls','$subcatprice','$note')";
			if (mysqli_query($con,$sql)) {
				echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Your product is Added Successfully..!</b>
					</div>";
				exit();
			}
			
		}		
		
	}

//Count User cart item
if (isset($_POST["count_item"])) {
	//When user is logged in then we will count number of item in cart by using user session id
	if (isset($_SESSION["uid"])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = $_SESSION[uid]";
	}else{
		//When user is not logged in then we will count number of item in cart by using users unique ip address
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0";
	}
	
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	echo $row["count_item"];
	exit();
}
//Count User cart item


//match coupon code & get value
if (isset($_POST["Coupon"])) {

	$couponcode = $_POST["couponcode"];

	$allcoupon = "SELECT * FROM `coupon` where coupon = '$couponcode'";
	$allcouponquery = mysqli_query($con,$allcoupon);

	if(mysqli_num_rows($allcouponquery) > 0){
		$row=mysqli_fetch_array($allcouponquery);	
		$prcn = $row['percentage'];	
		echo  json_encode( ['status'=> 202, 'message'=> $prcn]);
	}else {			
		
		echo  json_encode(['status'=> 303, 'message'=> 'Invalid Coupon!']);
		// echo  json_encode();
	}
}

		


//Get Cart Item From Database to Dropdown menu
if (isset($_POST["Common"])) {

	if (isset($_SESSION["uid"]) || isset($_SESSION["gid"])){


		if(isset($_SESSION["uid"])){

			$userId = $_SESSION["uid"];	
	
		}elseif(isset($_SESSION["gid"])){
	
			$userId = $_SESSION["gid"];
	
		}

		// $userId = $_SESSION["uid"];
		//get delivery charge from guest_info table
		$sqlcrg = "SELECT * FROM `user_info` WHERE `user_id` = '$userId'";
		$query9 = mysqli_query($con,$sqlcrg);
		if (mysqli_num_rows($query9) > 0) {
			while ($row=mysqli_fetch_array($query9)) {

				$dlcharge = $row["dcharge"];
				$name = $row["name"];
				$email = $row["email"];
				$mobile = $row["mobile"];
				$address1 = $row["address1"];
				$address2 = $row["address2"];
				$postcode = $row["postcode"];
				$poption = $row["poption"];
			
			}
		}		
		//When user is logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$userId'";
	}else{
		//When user is not logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p FROM products a,cart b WHERE a.product_id=b.p_id AND b.ip_add='$ip_add' AND b.user_id < 0";
	}

	$sql2 = "SELECT * FROM `time_slot`";
	$query2 = mysqli_query($con,$sql2);

	$sql3 = "SELECT * FROM `delivery_charge`";
	$query3 = mysqli_query($con,$sql3);

	$query = mysqli_query($con,$sql);
	if (isset($_POST["getCartItem"])) {
		//display cart item in dropdown menu
		if (mysqli_num_rows($query) > 0) {
			$n=0;
			while ($row=mysqli_fetch_array($query)) {
				$n++;
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				echo '
					<div class="row">
						<div class="col-md-3">'.$n.'</div>
						<div class="col-md-3"><img class="img-responsive" src="product_images/'.$product_image.'" /></div>
						<div class="col-md-3">'.$product_title.'</div>
						<div class="col-md-3">£'.$product_price.'</div>
					</div>';
				
			}
			?>
				<!-- <a style="float:right;" href="cart.php" class="btn btn-warning">Edit&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span></a> -->
			<?php
			exit();
		}
	}
	if (isset($_POST["checkOutDetails"])) {
		if (mysqli_num_rows($query) > 0) {
			//display user cart item with "Ready to checkout" button if user is not login			
			echo'<div class="row"><div class="col-md-12 col-xs-12"><div class="panel panel-primary"><div class="panel-heading"><div class="row"><div class="col-md-4 col-xs-4">Cart Checkout</div><div class="col-md-8" id="cart_msg"><!--Cart Message--> </div></div></div><div class="panel-body"><div class="row"><div class="col-md-2 col-xs-2"><b>Action</b></div><div class="col-md-3 col-xs-4"><b>Name</b></div><div class="col-md-2 col-xs-2"><b>Quantity</b></div><div class="col-md-2 col-xs-2"><b>Price</b></div><div class="col-md-3 col-xs-2"><b>Total £</b></div></div>';
				$n=0;
				while ($row=mysqli_fetch_array($query)) {
					$n++;
					$product_id = $row["product_id"];
					$product_title = $row["product_title"];
					$product_price = $row["product_price"];
					$product_image = $row["product_image"];
					$cart_item_id = $row["id"];
					$qty = $row["qty"];
					$subcat_d = $row["subcat_d"];
					$subcat_p = $row["subcat_p"];

					$totalp = $product_price+$subcat_p ;
					if($subcat_d == 'none' || $subcat_d == '0'){
					echo 
					'<div class="row">
							<div class="col-md-2 col-xs-3">
								<div class="btn-group">
									<a href="#" remove_id="'.$cart_item_id.'" class="btn btn-danger remove"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</div>
							<input type="hidden" name="product_id[]" value="'.$product_id.'"/>
							<input type="hidden" name="" value="'.$cart_item_id.'"/>								
							<div class="col-md-3 col-xs-3">'.$product_title.'</div>
							<div class="col-md-2 col-xs-2"><input type="text" class="form-control qty" value="'.$qty.'" ></div>
							<div class="col-md-2 col-xs-2"><input type="text" class="form-control price" update_id="'.$cart_item_id.'" value="'.$product_price.'" readonly="readonly"></div>
							<div class="col-md-3 col-xs-2"><input type="text" class="form-control total" value="'.$product_price.'" readonly="readonly"></div>
						</div>';
				}else{
					echo 
						'<div class="row">
								<div class="col-md-2 col-xs-3">
									<div class="btn-group">
									   <a href="#" remove_id="'.$cart_item_id.'" class="btn btn-danger remove"><span class="glyphicon glyphicon-trash"></span></a> 
									</div>
								</div>
								<input type="hidden" name="product_id[]" value="'.$cart_item_id.'"/>
								<input type="hidden" name="" value="'.$cart_item_id.'"/>								
								<div class="col-md-3 col-xs-3">'.$product_title.'</div>
								<div class="col-md-2 col-xs-2"><input type="text" class="form-control qty" value="'.$qty.'" ></div>
								<div class="col-md-2 col-xs-2"><input type="text" class="form-control price" update_id="'.$cart_item_id.'" value="'.$totalp.'" readonly="readonly"></div>
								<div class="col-md-3 col-xs-2"><input type="text" class="form-control total" value="'.$totalp.'" readonly="readonly"></div>
							</div>';
							echo'<div class="row">
							<div class="col-md-8"><p>'.$subcat_d.'</p></div>
							<div class="col-md-4"></div>
							</div>';
					}
				}
				if (isset($dlcharge)){
					echo '<div id="demo"><br><div class="col-md-4"></div><div class="col-md-5"><h4>Delivery Charge:</h4></div><div class="col-md-3"><input type="text" class="form-control total" value="'.$dlcharge.'" readonly="readonly"></div></div>';
				}else{
					echo'<div id="demo"></div>';
				}
				// add coupon  **************************************************
				echo'<br><br><br><p style="color:red" id="coupenmsg"></p>';
				echo '<div id="coupon"><div class="col-md-1"></div><div class="col-md-5 col-xs-5"><h4>Coupon code:</h4></div><div class="col-md-3 col-xs-4"><input type="text" class="form-control couponcode" ></div><div class="col-md-3 col-xs-3"><button id="getcouponcode" class="btn btn-success">Apply</button></div></div>';

				echo '<div class="row">
							<div class="col-md-7"></div>
							<div class="col-md-5"><b class="net_total" style="font-size:18px;"></b></div>
					  </div>';

				echo '</div></div></div></div>';
				
				if (!isset($_SESSION["uid"]) & !isset($_SESSION["gid"])) {
					echo "<div id='guest-singup-msg'></div><form id='guest_signup_form' action='#' method='post'>";
					echo '<!--**********************************Payment Option start*************************************************--> 
					<div id="ttm"></div>
					<div class="col-md-5"><b class="net_total" style="font-size:18px;"></b></div>
					<div class="row">
					 <div class="col-md-12">
					  <div class="panel panel-primary">
					   <div class="panel-heading">
						<div class="row">
						 <div class="col-md-4">Payment Option</div> 
						 </div> 
						 </div> 
						 <div class="panel-body"> 
						 <div class="row"> 
						 <div class="col-md-6 col-xs-12"><b>
						 <div class="radio"> 
						 <label><input type="radio" name="payment" value="Paypal" checked>Paypal</label>
						 </div> </b>
						 </div> 
						 <div class="col-md-6 col-xs-12"><b>
					 <div class="radio"> 
						 <label><input type="radio" name="payment" value="Cash">Cash</label>
						 </div></b> 
						 </div> 
						 </div> 
						 </div> 
						 </div> 
						 </div> 
						 </div> 
						 <!--**********************************Payment Option end*************************************************--> <!--**********************************Collection Option start*************************************************--> 
						 <div class="row"> 
						 <div class="col-md-12">
						  <div class="panel panel-primary"> 
						  <div class="panel-heading"> 
						  <div class="row"> <div class="col-md-4">Collection Option</div> 
						  </div> 
						  </div> 
						  <div class="panel-body"> 
						  <div class="row"> 
						  <div class="col-md-6 col-xs-12">
						  <b>
						  <div class="radio"> 
						  <label for="clnChkNo" class="rmvDiv">
						  <input type="radio" name="collection" value="Collection" class="rmvDiv" id="clnChkNo" onclick="ShowHideDivforCln()" checked>Collection</label> <p>Within 20 Minutes</p> 
						  </div></b></div> 
						  <div class="col-md-6 col-xs-12"><b>
						 <div class="radio"> 
						  <label for="clnChkYes">
						  <input type="radio" name="collection" value="Delivery" id="clnChkYes" onclick="ShowHideDivforCln()">Delivery</label> <p>Within 60 Minutes</p> 
						  </div></b>
						  </div>';
					
					if (mysqli_num_rows($query2) > 0) {
					// collection date 
					echo'<br><br><br><br>
					<div class="col-md-6">
					<label for="delivery">Collection/Delivery Date</label>';					
				
					echo '<input type="text" class="date-picker form-control" name="date" id="date" placeholder="Select date" required />';
				

				echo'</div>';

				// collection date end 

				// code for collection time 
				echo '<div class="col-md-6">
					<label for="delivery">Collection/Delivery Time</label> 
					<select id="timeslot" class="form-control" name="timeslot">					
					  <option value="0">Delivery/Collection time</option>';

						$n=0;
					while ($row=mysqli_fetch_array($query2)) {
						$n++;
						$time_id = $row["time_id"];
						$time_slot = $row["time_slot"];
						
						echo'<option value="'.$time_slot.'">'.$time_slot.'</option>';
					}						
				echo'</select></div>';
				// code for collection time 


				
				echo'</div> </div> </div> </div> </div> 
				<!--**********************************Collection Option end*************************************************-->';
					
					}
					echo'<!--**********************************Customer details Option start*************************************************--> 

					<div class="row"> 
					<div class="col-md-12"> 
					<div class="panel panel-primary"> 
					<div class="panel-heading"> 
					<div class="row"> 
					<div class="col-md-4">Your Details</div> 
					</div> </div> <div class="panel-body"> 
					<div class="row"> 
					<div class="col-md-12 col-xs-12"> 
					<div class="form-group"> 
						<label for="name">Name</label> 
						<input type="text" class="form-control" id="name" name="name" placeholder="John"> </div> 
					<div class="form-group"> 
						<label for="email">Mail</label> 
						<input type="text" class="form-control" id="email" name="email" placeholder="example@mail.com"> </div> 
					<div class="form-group"> 
						<label for="contactno">Contact No</label> 
						<input type="text" class="form-control" id="mobile" name="mobile" placeholder="mobile"> 
					</div>
					<div id="dvClnDelivery" style="display: none"> 
					<div class="form-group"> 
						<label for="address">Address</label> 
						<input type="text" class="form-control" id="address1" name="address1" placeholder="address"> 
					</div> 
					<div class="form-group"> 
						<label for="address2">Address 2</label> 
						<input type="text" class="form-control" id="address2" name="address2" placeholder="address2"> 
					</div> 
					<div class="form-group"> 
						<label for="postcode">Postcode</label> 
						<input type="text" class="form-control" id="postcode" name="postcode" placeholder="address2"> 
					</div>
					<div class="form-group" id="disamount"> 						
					</div>';		
		

				if (mysqli_num_rows($query3) > 0) {
					
					echo'<div class="form-group"><label for="delivery">Town & Delivery Charge</label><select id="mySelect" class="form-control charge" name="dcharge" onchange="myFunction()"><option value="0">Town - Delivery Charge</option>';

						$n=0;
					while ($row=mysqli_fetch_array($query3)) {
						$n++;
						$charge = $row["charge"];
						$town = $row["town"];
						
						echo'<option value="'.$charge.'">'.$town.' - (£'.$charge.')</option>';
					}
						
				echo'</select></div>';
					
					}
					
					
					echo'</div> </div> </div> </div> </div> </div> </div> <!--**********************************Customer details Option end*************************************************-->

					<input type="button" id="gust-signup-form" style="float:right;" name="login_user_with_product" class="btn btn-info btn-lg" value="Submit Order" >
					</form>';
					
				}else if(isset($_SESSION["uid"]) || isset($_SESSION["gid"])){

					if(isset($_SESSION["uid"])){

						$user_id = $_SESSION["uid"];	
				
					}elseif(isset($_SESSION["gid"])){
				
						$user_id = $_SESSION["gid"];
				
					}

		


						// all check out form if also login start

						echo "<div id='guest-singup-msg'></div><form id='guest_signup_form' action='#' method='post'>";
					echo '<!--**********************************Payment Option start*************************************************--> 
					
					<div class="row">
					 <div class="col-md-12">
					  <div class="panel panel-primary">
					   <div class="panel-heading">
						<div class="row">

						 <div class="col-md-4">Payment Option</div> 
						 </div> 
						 </div> 
						 <div class="panel-body"> 
						 <div class="row"> 
						 <div class="col-md-6 col-xs-12"><b>
						 <div class="radio"> 
						 <label><input type="radio" name="payment" value="Paypal" checked>Paypal</label>
						 </div> </b>
						 </div> 
						 <div class="col-md-6 col-xs-12"><b>
				<!--	 <div class="radio"> 
						 <label><input type="radio" name="payment" value="Cash">Cash</label>
						 </div></b> -->
						 </div> 
						 </div> 
						 </div> 
						 </div> 
						 </div> 
						 </div> 
						 <!--**********************************Payment Option end*************************************************--> <!--**********************************Collection Option start*************************************************--> 
						 <div class="row"> 
						 <div class="col-md-12">
						  <div class="panel panel-primary"> 
						  <div class="panel-heading"> 
						  <div class="row"> <div class="col-md-4">Collection Option</div> 
						  </div> 
						  </div> 
						  <div class="panel-body"> 
						  <div class="row"> 
						  <div class="col-md-6 col-xs-12">
						  <b>
						  <div class="radio"> 
						  <label for="clnChkNo" class="rmvDiv">
						  <input type="radio" name="collection" value="Collection" class="rmvDiv" id="clnChkNo" onclick="ShowHideDivforCln()" checked>Collection</label> <p>Within 20 Minutes</p> 
						  </div></b></div> 
						  <div class="col-md-6 col-xs-12"><b>
						 <!-- <div class="radio"> 
						  <label for="clnChkYes">
						  <input type="radio" name="collection" value="Delivery" id="clnChkYes" onclick="ShowHideDivforCln()">Delivery</label> <p>Within 60 Minutes</p> 
						  </div></b> -->
						  </div>';
					
					if (mysqli_num_rows($query2) > 0) {
					
				// collection date 
					echo'<br><br><br><br>
					<div class="col-md-6">
					<label for="delivery">Collection/Delivery Date</label>';
					echo '<input type="text" class="date-picker form-control" name="date" id="date" placeholder="Select date" />';
				    echo'</div>';
				// collection date end 
				
				//collection time
					echo'<div class="col-md-6">
					<label for="delivery">Collection/Delivery Time</label> 
					<select id="timeslot" class="form-control" name="timeslot">					
					  <option value="0">Delivery/Collection time</option>';

						$n=0;
					while ($row=mysqli_fetch_array($query2)) {
						$n++;
						$time_id = $row["time_id"];
						$time_slot = $row["time_slot"];
						
						echo'<option value="'.$time_slot.'">'.$time_slot.'</option>';
					}
						
				echo'</select></div>'; 
				//collection time end
				
				echo '</div> </div> </div> </div> </div> 
				<!--**********************************Collection Option end*************************************************-->';
					
					}
					echo'<!--**********************************Customer details Option start*************************************************--> 

					<div class="row"> 
					<div class="col-md-12"> 
					<div class="panel panel-primary"> 
					<div class="panel-heading"> 
					<div class="row"> 
					<div class="col-md-4">Your Details</div> 
					</div> </div> <div class="panel-body"> 
					<div class="row"> 
					<div class="col-md-12 col-xs-12"> 
					<div class="form-group"> 
						<label for="name">Name</label> 
						<input type="text" class="form-control" value="'.$name.'" id="name" name="name" placeholder="John"> </div> 
					<div class="form-group"> 
						<label for="email">Mail</label> 
						<input type="text" class="form-control" value="'.$email.'" id="email" name="email" placeholder="example@mail.com"> </div> 
					<div class="form-group"> 
						<label for="contactno">Contact No</label> 
						<input type="text" class="form-control" value="'.$mobile.'" id="mobile" name="mobile" placeholder="mobile"> 
					</div>
					<div id="dvClnDelivery" style="display:none"> 
					<div class="form-group"> 
						<label for="address">Address</label> 
						<input type="text" class="form-control" value="'.$address1.'" id="address1" name="address1" placeholder="address"> 
					</div> 
					<div class="form-group"> 
						<label for="address2">Address 2</label> 
						<input type="text" class="form-control" value="'.$address2.'" id="address2" name="address2" placeholder="address2"> 
					</div> 
					<div class="form-group"> 
						<label for="postcode">Postcode</label> 
						<input type="text" class="form-control" value="'.$postcode.'"  id="postcode" name="postcode" placeholder="address2"> 
					</div>

					<div class="form-group" id="disamount"> 						
					</div>';		
		

				if (mysqli_num_rows($query3) > 0) {
					
					echo'<div class="form-group"><label for="delivery">Town & Delivery Charge</label><select id="mySelect" class="form-control charge" name="dcharge" onchange="myFunction()"><option value="0">Town - Delivery Charge</option>';

						$n=0;
					while ($row=mysqli_fetch_array($query3)) {
						$n++;
						$charge = $row["charge"];
						$town = $row["town"];
						
						echo'<option value="'.$charge.'">'.$town.' - (£'.$charge.')</option>';
					}
						
				echo'</select></div>';
					
					}
					
					
					echo'</div> </div> </div> </div> </div> </div> </div> <!--**********************************Customer details Option end*************************************************-->

					<input type="button" id="gust-signup-form" style="float:right;" name="login_user_with_product" class="btn btn-info btn-lg" value="Submit Order" >
					</form>';

						// all checkout form if also login End

					// 	//paypal mail
					// 	$paypalmail = "SELECT * FROM `mails`";
					// 	$paypalmailquery = mysqli_query($con,$paypalmail);
				
					// 	if(mysqli_num_rows($paypalmailquery) > 0){
					// 		while($row = mysqli_fetch_array($paypalmailquery)){
				
					// 			$mailforpaypal = $row['paypal'];		
					
					// 		}
					// 	}
					
					// //Paypal checkout form
					// echo '					
					// 	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
					// 		<input type="hidden" name="cmd" value="_cart">
					// 		<input type="hidden" name="business" value="'.$mailforpaypal.'">
					// 		<input type="hidden" name="upload" value="1">';
							  
					// 		$x=0;
					// 		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$user_id'";
					// 		$query = mysqli_query($con,$sql);
					// 		while($row=mysqli_fetch_array($query)){
					// 			$x++;
					// 			$product_price = $row["product_price"];
					// 			$subcat_d = $row["subcat_d"];
					// 			$subcat_p = $row["subcat_p"];			
					// 			$totalp = $product_price+$subcat_p;
					// 			$detailWithsub = $row["product_title"].$subcat_d;
					// 			echo  	
					// 				'<input type="hidden" name="item_name_'.$x.'" value="'.$detailWithsub.'">
					// 			  	 <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
					// 			     <input type="hidden" name="amount_'.$x.'" value="'.$totalp.'">
					// 			     <input type="hidden" name="quantity_'.$x.'" value="'.$row["qty"].'">';
					// 			}
					// 			$x = $x + 1;
					// 		  echo'<input type="hidden" name="item_name_'.$x.'" value="Delivery Charge">
					// 		  <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
					// 		  <input type="hidden" name="amount_'.$x.'" value="'.$dlcharge.'">
					// 		  <input type="hidden" name="quantity_'.$x.'" value="1">';
					// 		echo   
					// 			'<input type="hidden" name="return" value="http://localhost/project1/payment_success.php"/>
					//                 <input type="hidden" name="notify_url" value="http://localhost/fiverrorder/php/towhidfinal/payment_success.php">
					// 				<input type="hidden" name="cancel_return" value="http://localhost/fiverrorder/php/towhidfinal/cancel.php"/>
					// 				<input type="hidden" name="currency_code" value="USD"/>
					// 				<input type="hidden" name="custom" value="'.$user_id.'"/>
					// 				<input style="float:right;margin-right:80px;" type="image" name="submit"
					// 					src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/blue-rect-paypalcheckout-60px.png" alt="PayPal Checkout"
					// 					alt="PayPal - The safer, easier way to pay online">
					// 			</form>';

							// }  cash or paypal condition

				}
			}
	}
	
	
}

//Remove Item From cart
if (isset($_POST["removeItemFromCart"])) {
	$remove_id = $_POST["rid"];
	if (isset($_SESSION["uid"])) {
		$sql = "DELETE FROM cart WHERE id = '$remove_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "DELETE FROM cart WHERE id = '$remove_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo "<div class='alert alert-danger'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is removed from cart</b>
				</div>";
		exit();
	}
}


//Update Item From cart
if (isset($_POST["updateCartItem"])) {
	$update_id = $_POST["update_id"];
	$qty = $_POST["qty"];
	if (isset($_SESSION["uid"])) {
		$sql = "UPDATE cart SET qty='$qty' WHERE id = '$update_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "UPDATE cart SET qty='$qty' WHERE id = '$update_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo "<div class='alert alert-info'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is updated</b>
				</div>";
		exit();
	}
}




?>






