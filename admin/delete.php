<?php
	require "database.php";
	if(isset($_GET['id'])){
    echo "<script>confirm('Do you want to delete it? !!')</script>";
		$sql = "DELETE FROM `code_master` WHERE id = '".$_GET['id']."' ";
        $conn->query($sql);
        if ($conn->affected_rows == 1) { 
          $message = "Delete Successfully";
          echo "<script>window.location.href = 'additional_item.php';</script>";
          exit;
        }
    }
?>