<?php
session_start();
if(!isset($_SESSION["uid"]) & !isset($_SESSION["gid"])){
	header("location:index.php");
}

	if(isset($_SESSION["uid"])){

		$user_id = $_SESSION["uid"];	

	}elseif(isset($_SESSION["gid"])){

		$user_id = $_SESSION["gid"];

    }
    
include_once("db.php");
$sql = "DELETE FROM cart WHERE user_id = '$user_id'";
mysqli_query($con,$sql);

if(isset($_SESSION["gid"])){
    
$sql2 = "DELETE FROM `user_info` WHERE user_id = '$user_id'";
mysqli_query($con,$sql2);

	unset($_SESSION["gid"]);
	unset($_SESSION["name"]);

}

header("location:index.php");