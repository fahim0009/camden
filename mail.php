<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<?php

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "info@wpfreetool.com";
    $to = "fahim.amin71@gmail.com";
    $subject = "Checking PHP mail";
    $message = "PHP test 2 mail works just fine";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "The email message was sent.";

	
	
	?>
</body>
</html>