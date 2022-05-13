<?php namespace Listener;
require('PaypalIPN.php');
include_once($_SERVER['DOCUMENT_ROOT']. "/db.php");;

use PaypalIPN;
$ipn = new PaypalIPN();
date_default_timezone_set('Europe/London');
// Use the sandbox endpoint during testing. Comment this line when going live
//$ipn->useSandbox();

$verified = $ipn->verifyIPN();

$paypalmail = "SELECT * FROM `mails`";
    $paypalmailquery = mysqli_query($con,$paypalmail);

    if(mysqli_num_rows($paypalmailquery) > 0){
        while($row = mysqli_fetch_array($paypalmailquery)){

            $mailforpaypal = $row['paypal'];
            
        }
    }
	

if ($verified) {

	if ($_POST['receiver_email'] == $mailforpaypal){//if (($_POST['payment_status'] == 'Completed') && ($_POST['receiver_email'] == $mailforpaypal)){
        $digits = 8;
        $trx_id = rand(pow(10, $digits-1), pow(10, $digits)-1); 
		
		$cm_user_id = $_POST['custom'];
		
		// invoice query 
		$invoice = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p,note FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$cm_user_id'";
		$invoicequery = mysqli_query($con,$invoice);

		$customer = "SELECT * FROM `user_info` WHERE `user_id` = '$cm_user_id'";
		$customerquery = mysqli_query($con,$customer);

		$cinfo = mysqli_fetch_array($customerquery);
			$c_pamyment    = $cinfo['poption'];
			$c_cldl    = $cinfo['coption'];
			$c_date    = $cinfo['c_date'];
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
		
		$sql = "SELECT p_id,qty,subcat_d FROM cart WHERE user_id = '$cm_user_id'";
		$query = mysqli_query($con,$sql);
		if (mysqli_num_rows($query) > 0) {
			# code...
			while ($row=mysqli_fetch_array($query)) {
			$product_id[] = $row["p_id"];
			$qty[] = $row["qty"];
			}

			for ($i=0; $i < count($product_id); $i++) { 
				$sql = "INSERT INTO orders (user_id,product_id,qty,trx_id,subcat_d,p_status,date) VALUES ('$cm_user_id','".$product_id[$i]."','".$qty[$i]."','$trx_id','".$subcat_d[$i]."','$p_st',CURRENT_TIMESTAMP)";
				mysqli_query($con,$sql);
			}
			
			
			
			
			
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
			$message .= "<strong>Billed To:</strong><br>".$c_name."<br>".$c_add1."<br>".$c_add2."<br>".$c_code."<br></address></div><div class='col-xs-6 text-right'><address><strong>Contact Info:</strong><br>Mail: ".$c_mail."<br>Mobile: ".$c_mobile."<br></address></div></div><div class='row'><div class='col-xs-6'><address><strong>Payment Method:</strong><br> ".$c_pamyment." <br></address></div><div class='col-xs-6 text-right'><address><strong>Order Date:</strong><br> ".date("Y-m-d")."<br></address></div></div><div class='row'><div class='col-xs-6'><address><strong>Delivery/Collection Details:</strong><br>Type: ".$c_cldl."<br>Date: ".$c_date."<br>Time: ".$c_cdtime."<br></address></div><div class='col-xs-6 text-right'><address><strong>Order Time:</strong><br>Time: ".date("h:i a")."<br></address></div></div></div></div>";

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
				// $sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
				// mysqli_query($con,$sql);
				// $sql2 = "DELETE FROM `user_info` WHERE user_id = '$cm_user_id'";
				// mysqli_query($con,$sql2);
				
			} else{
				$myfile = fopen("mailError.txt", "w") or die("Unable to open file!");
				$txt = 'mail not sent!';
				fwrite($myfile, $txt);
				fclose($myfile);
			}			
		}	
			
			
			
		
	} else { //Payment is not complete OR merchant email is different, require manual action/investigation from Admin/Seller
	
		//maybe send an email with data dump in it to analyze further
	}
	
} 


header("HTTP/1.1 200 OK");
?>
