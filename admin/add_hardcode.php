<?php session_start(); 
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>

<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>


      <div class="row">
      	<div class="col-10">
      		<h2>Manage additional items</h2>
      	</div>
        
<?php
if (isset($_POST['submitbtn'])) {

    require "database.php";
    $hardcode = $_POST['hardcode'];
    $softcode = $_POST['softcode'];
    $description = $_POST['des'];
    $sort_des = $_POST['sdes'];

    $insertQuery = "INSERT INTO `code_master` (id,hardcode,softcode,description,price,created_date) VALUES(NULL,'$hardcode','$softcode','$description','$sort_des',now())";


    $conn->query($insertQuery);
    // echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $message = "Insert Successfully";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h3><?php if (isset($message)) echo $message; ?></h3>
        <div class="row">
            <div class="col-md-6">
                <div style="border:1px solid #d1d1d1;padding:10px; background-color: #f0efef99; margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="background-color: #dbdbdb;padding: 10px 10px 10px 10px;">Sub category add</h5>
                        </div>
                    </div>
                    <hr>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Hard Code</label>
                            <input type="text" name="hardcode" id="" class="form-control" placeholder="Title" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Soft Code</label>
                            <input type="text" class="form-control" id="" readonly name="softcode" value="0" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Description</label>
                            <input type="text" class="form-control" id="" name="des" placeholder="Write Text" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Amount</label>
                            <input type="text" class="form-control" id="" name="sdes" readonly value="0" required>
                        </div>

                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <!-- <button class="btn btn-success" id="SubBtn">Submit</button> -->
                                <input type="submit" name="submitbtn" value="Submit" class="btn btn-success">
                                <a href="additional_item.php" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </form>
                </div>




                <?php include_once("./templates/footer.php"); ?>