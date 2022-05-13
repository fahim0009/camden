<?php
session_start();
if(!isset($_SESSION["uid"]) & !isset($_SESSION["gid"])){
	header("location:index.php");
}
date_default_timezone_set('Europe/London');
if (isset($_GET["success"])) {

	if(isset($_SESSION["uid"])){

		$cm_user_id = $_SESSION["uid"];	

	}elseif(isset($_SESSION["gid"])){

		$cm_user_id = $_SESSION["gid"];

	}
        $digits = 8;
        $trx_id = rand(pow(10, $digits-1), pow(10, $digits)-1); 

        // $p_st = "Not Completed";
		include_once("db.php");
		
		// invoice query 
		$invoice = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p,note FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$cm_user_id'";
		$invoicequery = mysqli_query($con,$invoice);

		$customer = "SELECT * FROM `user_info` WHERE `user_id` = '$cm_user_id'";
		$customerquery = mysqli_query($con,$customer);

		$cinfo = mysqli_fetch_array($customerquery);
			$c_pamyment    = $cinfo['poption'];
			$c_cldl    = $cinfo['coption'];
			$c_cdtime    = $cinfo['cdtime'];
			$c_name    = $cinfo['name'];
			$c_mail    = $cinfo['cmail'];
			$c_mobile   = $cinfo['mobile'];
			$c_add1    = $cinfo['address1'];
			$c_add2    = $cinfo['address2'];
			$c_code    = $cinfo['postcode'];
			$c_dcharge    = $cinfo['dcharge'];
			$c_disamount    = $cinfo['disamount'];
			
			if($c_pamyment == 'Cash'){
				$p_st = "Not Completed";
			}else{
				$p_st = "Completed";
			}

		$invoicemail = "SELECT * FROM `mails`";
		$invoicemailquery = mysqli_query($con,$invoicemail);

		if(mysqli_num_rows($invoicemailquery) > 0){
			while($row = mysqli_fetch_array($invoicemailquery)){

				$mailforinvoice = $row['invoice'];		
	
			}
		}

		// invoice query end 
		
		$sql = "SELECT p_id,qty FROM cart WHERE user_id = '$cm_user_id'";
		$query = mysqli_query($con,$sql);
		if (mysqli_num_rows($query) > 0) {
			# code...
			while ($row=mysqli_fetch_array($query)) {
			$product_id[] = $row["p_id"];
			$qty[] = $row["qty"];
			}

			for ($i=0; $i < count($product_id); $i++) { 
				$sql = "INSERT INTO orders (user_id,product_id,qty,trx_id,p_status) VALUES ('$cm_user_id','".$product_id[$i]."','".$qty[$i]."','$trx_id','$p_st')";
				mysqli_query($con,$sql);
			}
				?>
					<!DOCTYPE html>
					<html>
						<head>
							<meta charset="UTF-8">
							<title>Wok And Fire</title>
							<link rel="stylesheet" href="css/bootstrap.min.css"/>
							<script src="js/jquery2.js"></script>
							<script src="js/bootstrap.min.js"></script>
							<script src="main.js"></script>
							<style>
								table tr td {padding:10px;}
							</style>
						</head>
					<body>
						<div class="navbar navbar-inverse navbar-fixed-top">
							<div class="container-fluid">	
								<div class="navbar-header">
									<a href="#" class="navbar-brand"><img src="images/img_1118.jpg" width="224px" height="25px"></a>
								</div>
								<ul class="nav navbar-nav">
									<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
									
								</ul>
							</div>
						</div>
						<p><br/></p>
						<p><br/></p>
						<p><br/></p>
						<div class="container-fluid">
						
							<div class="row">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<div class="panel panel-default">
										<div class="panel-heading"></div>
										<div class="panel-body">
											<h1>Thank YOU </h1>
											<hr/>
											<p>Hello <?php echo "<b>".$_SESSION["name"]."</b>"; ?>,Your order submited 
											successfully and your Transaction id is <b><?php echo $trx_id; ?></b><br/>
											you can continue your Shopping <br/></p>
											<a href="http://www.victoria.wokandfire.co.uk" class="btn btn-success btn-lg">Continue Shopping</a>
										</div>
										<div class="panel-footer"></div>
									</div>
								</div>
								<div class="col-md-2"></div>
							</div>
						</div>
						

<!-- ******************************************Invoice start **************************************** -->
<style>
	
	.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
	
	
	</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # <?php echo $trx_id; ?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
					<?php echo $c_name; ?><br>
					<?php echo $c_add1; ?><br>
					<?php echo $c_add2; ?><br>
					<?php echo $c_code; ?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Contact Info:</strong><br>
					Mail: <?php echo $c_mail; ?><br>
					Mobile: <?php echo $c_mobile; ?><br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					<?php echo $c_pamyment; ?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
						<?php echo date("Y-m-d"); ?><br>
    				</address>
    			</div>
    		</div>
			
			
			 <div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Delivery/Collection Details:</strong><br>
					Type: <?php echo $c_cldl; ?><br>
					Time: <?php echo $c_cdtime; ?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Order Time:</strong><br>
					Time: <?php echo date("h:i a");?><br>
    				</address>
    			</div>
    		</div>
			
					
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Additional Item</strong></td>
        							<td class="text-center"><strong>Note</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
								<?php
								if (mysqli_num_rows($invoicequery) > 0) {
									$n=0;
									$subtotal= 0;
									while ($row=mysqli_fetch_array($invoicequery)) {
										$n++;
										$product_id = $row["product_id"];
										$product_title = $row["product_title"];
										$product_price = $row["product_price"];
										$product_image = $row["product_image"];
										$cart_item_id = $row["id"];
										$qty = $row["qty"];
										$subcat_d = $row["subcat_d"];
										$subcat_p = $row["subcat_p"];
										$note = $row["note"];					
										$totalp = $product_price+$subcat_p ;

										$subtotal += $totalp*$qty;

									echo'
									<tr>
										<td>'.$product_title.'</td>
										<td class="text-center">'.$subcat_d.'</td>
										<td class="text-center">'.$note.'</td>
										<td class="text-center">'.$totalp.'</td>
										<td class="text-center">'.$qty.'</td>
										<td class="text-right">'.$totalp*$qty.'</td>
									</tr>';  
								}

								}        
									?>
					<!-- item foreach end  -->

    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right"><?php echo $subtotal; ?></td>
    							</tr>
								<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="thick-line text-center"><strong>Discout Amount</strong></td>
    								<td class="thick-line text-right">-<?php echo $c_disamount; ?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Delivery Charge</strong></td>
    								<td class="no-line text-right"><?php echo $c_dcharge;?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right"><?php echo $c_dcharge+$subtotal-$c_disamount;?></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>


<!-- ******************************************Invoice end **************************************** -->

<!--//mail sent		start			-->
	<?php
	$to = $c_mail;
	$subject = 'Order Confirmation';
	$from = 'info@wpfreetool.com';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'cc: '.$mailforinvoice."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	
	// Compose a simple HTML email message
	$message = '<html><body>';
	$message .= '<style>.invoice-title h2,.invoice-title h3{display:inline-block}.table>tbody>tr>.no-line{border-top:0}.table>thead>tr>.no-line{border-bottom:0}.table>tbody>tr>.thick-line{border-top:2px solid}</style>
	<div class="container">
	<div class="row">
	<div class="col-xs-12">
	<div class="invoice-title">
	<h2>Invoice</h2><h3 class="pull-right">Order # '.$trx_id.'</h3>
	</div>
	<hr>
	<div class="row">
	<div class="col-xs-6">
	<address>';
	$message .= "<strong>Billed To:</strong><br>".$c_name."<br>".$c_add1."<br>".$c_add2."<br>".$c_code."<br></address></div><div class='col-xs-6 text-right'><address><strong>Contact Info:</strong><br>Mail: ".$c_mail."<br>Mobile: ".$c_mobile."<br></address></div></div><div class='row'><div class='col-xs-6'><address><strong>Payment Method:</strong><br> ".$c_pamyment." <br></address></div><div class='col-xs-6 text-right'><address><strong>Order Date:</strong><br> ".date("Y-m-d")."<br></address></div></div><div class='row'><div class='col-xs-6'><address><strong>Delivery/Collection Details:</strong><br>	Type: ".$c_cldl."<br>Time: ".$c_cdtime."<br></address></div><div class='col-xs-6 text-right'><address><strong>Order Time:</strong><br>Time: ".date("h:i a")."<br></address></div></div></div></div>";

	$message .= '<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">
	<h3 class="panel-title"><strong>Order summary</strong></h3>
	</div>
	<div class="panel-body">
	<div class="table-responsive">
	<table class="table table-condensed">
	<thead>
	<tr>
	<td><strong>Item</strong></td>
	<td class="text-center"><strong>Additional Item</strong></td>
	<td class="text-center"><strong>Note</strong></td>
	<td class="text-center"><strong>Price</strong></td>
	<td class="text-center"><strong>Quantity</strong></td>
	<td class="text-right"><strong>Totals</strong></td>
	</tr>
	</thead>
	<tbody>';

	$invoice2 = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p,note FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$cm_user_id'";
	$invoicequery2 = mysqli_query($con,$invoice2);
	if (mysqli_num_rows($invoicequery2) > 0) {
		$n=0;
		$subtotal= 0;
		while ($row=mysqli_fetch_array($invoicequery2)) {
			$n++;
			$product_id = $row["product_id"];
			$product_title = $row["product_title"];
			$product_price = $row["product_price"];
			$product_image = $row["product_image"];
			$cart_item_id = $row["id"];
			$qty = $row["qty"];
			$subcat_d = $row["subcat_d"];
			$subcat_p = $row["subcat_p"];
			$note = $row["note"];					
			$totalp = $product_price+$subcat_p ;

			$subtotal += $totalp*$qty;

			$message .='
		<tr>
			<td>'.$product_title.'</td>
			<td class="text-center">'.$subcat_d.'</td>
			<td class="text-center">'.$note.'</td>
			<td class="text-center">'.$totalp.'</td>
			<td class="text-center">'.$qty.'</td>
			<td class="text-right">'.$totalp*$qty.'</td>
		</tr>';  
	}

	} 
	
	$totalafdlcrg = $c_dcharge+$subtotal-$c_disamount;


	$message .= "<tr><td class='thick-line'></td><td class='thick-line'></td><td class='thick-line'></td><td class='thick-line'></td><td class='thick-line text-center'><strong>Subtotal</strong></td><td class='thick-line text-right'> ".$subtotal."</td></tr><tr><td class='no-line'></td><td class='no-line'></td><td class='no-line'></td>
	<td class='no-line'></td><td class='thick-line text-center'><strong>Discout Amount</strong></td><td class='thick-line text-right'>-".$c_disamount."</td></tr><tr><td class='no-line'></td><td class='no-line'></td><td class=no-line></td><td class='no-line'></td><td class='no-line text-center'><strong>Delivery Charge</strong></td><td class='no-line text-right'>".$c_dcharge."</td></tr><tr><td class='no-line'></td><td class='no-line'></td><td class='no-line'></td><td class='no-line'></td><td class='no-line text-center'><strong>Total</strong></td><td class='no-line text-right'>".$totalafdlcrg."</td></tr></tbody></table></div></div></div></div></div></div>";
	$message .= '</body></html>';
	
	// Sending email
	if(mail($to, $subject, $message, $headers)){
		echo 'A copy of invoice send to your mail.';
	} else{
		echo 'Unable to send email.';
	}
	?>
	<!-- mail send end  -->


					</body>
					</html>

				<?php
			


		}else{
			header("location:index.php");
		}
		

}


$sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
mysqli_query($con,$sql);
if(isset($_SESSION["gid"])){

    $user_id = $_SESSION["gid"];
	unset($_SESSION["gid"]);
	unset($_SESSION["name"]);
	
	$sql2 = "DELETE FROM `user_info` WHERE user_id = '$user_id'";
mysqli_query($con,$sql2);

}

?>

















































