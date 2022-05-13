<?php
	if(!empty($_POST["forgot-password"])){
		include_once("db.php");
		
		$condition = "";
	
		if(!empty($_POST["user-email"])) {
	
			$condition = " email = '" . $_POST["user-email"] . "'";
		}
		
		if(!empty($condition)) {
			$condition = " where " . $condition;
		}

		$sql = "Select * from `user_info` " . $condition ."AND type = 1";
		$result = mysqli_query($con,$sql);
		$user = mysqli_fetch_array($result);
		
		if(!empty($user)) {
			require_once("forgot-password-recovery-mail.php");
		} else {
			$error_message = 'No User Found';
		}
	}
?>
  <?php  include("inc/header.php");	?>
<link href="demo-style.css" rel="stylesheet" type="text/css">
<script>
function validate_forgot() {
	if(document.getElementById("user-email").value == "") {
		document.getElementById("validation-message").innerHTML = "Email is required!"
		return false;
	}
	return true
}
</script>
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form name="frmForgot" id="frmForgot" method="post" onSubmit="return validate_forgot();">
<h4>Forgot Password?</h4>
	<?php if(!empty($success_message)) { ?>
	<div class="success_message"><?php echo $success_message; ?></div>
	<?php } ?>

	<div id="validation-message">
		<?php if(!empty($error_message)) { ?>
	<?php echo $error_message; ?>
	<?php } ?>
	</div>
	
	<div class="field-group">
		<div><label for="email">Enter Your Email</label></div>
		<div><input type="text" name="user-email" id="user-email" class="input-field"></div>
	</div>
	
	<div class="field-group">
		<div><input type="submit" name="forgot-password" id="forgot-password" value="Submit" class="form-submit-button"></div>
	</div>	
</form>
            
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
