<?php
session_start();
include "db.php";
if (isset($_POST["name"])) {

    $poption = $_POST['payment'];
    $coption = $_POST['collection'];
    $c_date = $_POST['date'];
    $cdtime = $_POST['timeslot'];
	$name = $_POST["name"];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];

	if (isset($_POST["disamount"])) {
	$disamount = $_POST['disamount'];
	}else{
		$disamount = 00;
	}
    if (isset($_POST["address1"])) {

	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$postcode = $_POST['postcode'];
    $dcharge = $_POST['dcharge'];

    }else{
        $address1 = 'none';
        $address2 = 'none';
        $postcode = 'none';
        $dcharge = 0;
    }
    
	$namecheck = "/^[a-zA-Z ]+$/";
// 	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	$emailValidation = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,10}$/";
	$number = "/^[0-9]+$/";

	if($cdtime==0){

		echo "
		<div class='alert alert-warning'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>You must select collection/delivery time ...!</b>
		</div>";
	exit();

	}
	
	if($c_date==0){

		echo "
		<div class='alert alert-warning'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>You must select collection/delivery date ...!</b>
		</div>";
	exit();

	}

if(empty($name) || empty($email) ||	empty($mobile)){
		
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Fill all fields in 'Your Details' area..!</b>
			</div>
		";
		exit();
	} else {
		if(!preg_match($namecheck,$name)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $name is not valid..!</b>
			</div>
		";
		exit();
	}
	if(!preg_match($emailValidation,$email)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $email is not valid..!</b>
			</div>
		";
		exit();
	}

	if(!preg_match($number,$mobile)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Mobile number $mobile is not valid</b>
			</div>
		";
		exit();
	}

	//guest all info send to database

	if(isset($_SESSION["uid"]) || isset($_SESSION["gid"])){


		if(isset($_SESSION["uid"])){

    	$user_id = $_SESSION["uid"];	
    	
    	}elseif(isset($_SESSION["gid"])){
    	
    	$user_id = $_SESSION["gid"];
    	
    	}
		
		$sql = "UPDATE `user_info` SET 	poption='$poption', coption='$coption', c_date='$c_date', cdtime='$cdtime', name='$name',cmail='$email', mobile='$mobile', address1='$address1', address2='$address2', postcode='$postcode', dcharge='$dcharge', disamount='$disamount' WHERE user_id = $user_id";

		// echo $sql;exit;

		$run_query = mysqli_query($con,$sql);
		$ip_add = getenv("REMOTE_ADDR");
		$sql = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add='$ip_add' AND user_id = -1";
		if(mysqli_query($con,$sql)){
			// echo "register_success";
			if ($poption=="Paypal") {
				echo "Paypal_success";
			}elseif($poption=="Cash"){
				echo "Cash_success";
			}
			exit();
		}

	}else{

		$sql = "INSERT INTO `user_info` 
		(`user_id`,`type`, `poption`, `coption`, `c_date`, `cdtime`, 
		`name`, `cmail`,`mobile`, `address1`, `address2`,`postcode`,`dcharge`,`disamount`,`cdate`) 
		VALUES (NULL,'0', '$poption', '$coption', '$c_date', '$cdtime', '$name', '$email', 
        '$mobile', '$address1', '$address2', '$postcode', '$dcharge', '$disamount', CURRENT_TIMESTAMP)";
        // echo $sql;exit;
		$run_query = mysqli_query($con,$sql);
		$userid = mysqli_insert_id($con);
		$_SESSION["gid"] = $userid;
		$_SESSION["name"] = $name;
		$ip_add = getenv("REMOTE_ADDR");
		$sql = "UPDATE cart SET user_id = '$userid' WHERE ip_add='$ip_add' AND user_id = -1";
		if(mysqli_query($con,$sql)){
			// echo "register_success";
			if ($poption=="Paypal") {
				echo "Paypal_success";
			}elseif($poption=="Cash"){
				echo "Cash_success";
			}
			exit();
		}
	}
	}
	
}


?>
