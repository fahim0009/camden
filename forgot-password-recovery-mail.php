<?php
	$to = $user["email"];
	$subject = 'Password Recovery Mail';
	$from = 'info@wpfreetool.com';
	
	// To send HTML mail, the Content-type header must be set
// 	$headers  = 'MIME-Version: 1.0' . "\r\n";
// 	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Create email headers
	$headers = 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();


  $headers .= "Organization: WOK AND FIRE\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

	
	// Compose a simple HTML email message
	$message = "<div> Hi" . $user["name"] . ",<br><br><p>Click this link to recover your password<br><a href='" .'http://victoria.wokandfire.co.uk/'. "reset_password.php?token=" . $user["token"] . "'>" .'http://victoria.wokandfire.co.uk/'. "reset_password.php?token=" . $user["token"] . "</a><br><br></p>Regards,<br> Admin-WOKANDFIRE</div>";
//echo $message; exit;
	// Sending email
	if(mail($to, $subject, $message, $headers)){
		
		$success_message = 'Please check your email to reset password!';
	} else{
		$error_message = 'Problem in Sending Password Recovery Email';
	}
	?>