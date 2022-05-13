<?php
	if(isset($_POST["reset-password"])) {
		include_once("db.php");
		$sql = "UPDATE `user_info` SET `password` = '" . md5($_POST["member_password"]). "' WHERE `token` = '" . $_GET["token"] . "'AND `type` = 1";
		$result = mysqli_query($con,$sql);
		$success_message = "Password is reset successfully.";
		
	}
?>
  <?php  include("inc/header.php");	?>
<link href="demo-style.css" rel="stylesheet" type="text/css">
<script>
function validate_password_reset() {
	if((document.getElementById("member_password").value == "") && (document.getElementById("confirm_password").value == "")) {
		document.getElementById("validation-message").innerHTML = "Please enter new password!"
		return false;
	}
	if(document.getElementById("member_password").value  != document.getElementById("confirm_password").value) {
		document.getElementById("validation-message").innerHTML = "Both password should be same!"
		return false;
	}
	
	return true;
}
</script>
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
<form name="frmReset" id="frmReset" method="post" onSubmit="return validate_password_reset();">
<h1>Reset Password</h1>
	<?php if(!empty($success_message)) { ?>
	<div class="success_message"><?php echo $success_message; ?></div>
	<?php } ?>

	<div id="validation-message">
		<?php if(!empty($error_message)) { ?>
	<?php echo $error_message; ?>
	<?php } ?>
	</div>

	<div class="field-group">
		<div><label for="Password">Password</label></div>
		<div>
		<input type="password" name="member_password" id="member_password" class="input-field"></div>
	</div>
	
	<div class="field-group">
		<div><label for="email">Confirm Password</label></div>
		<div><input type="password" name="confirm_password" id="confirm_password" class="input-field"></div>
	</div>
	
	<div class="field-group">
		<div><input type="submit" name="reset-password" id="reset-password" value="Reset Password" class="form-submit-button"></div>
	</div>	
</form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
				