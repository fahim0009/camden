<?php session_start(); 
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  }

?>
<?php require "database.php"; ?>
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
//update query
if (isset($_POST['update'])) {

    $hardcode = $_POST['hardcode'];
    $softcode = $_POST['softcode'];
    $description = $_POST['des'];
    $price = $_POST['price'];

  
  $ss_modified_on = date("Y-m-d H:i:s");
 

  $idno = $_GET['id'];
  $updateQuery = "UPDATE `code_master` SET hardcode='$hardcode', softcode='$softcode', description='$description', price='$price', modify_date='$ss_modified_on' WHERE id = '$idno'";
  // echo $updateQuery; exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) { 
    $message = "Update Successfully";
  }
//   header("Location:user_menu.php");
}
//select query start
if (isset($_GET['id'])) {
  $idno = $_GET['id'];
  $selectQuery = "SELECT * FROM `code_master` WHERE id=$idno";
  // echo $selectQuery; exit;
  $selectQueryResult = $conn->query($selectQuery);
  //if($selectQueryResult->num_rows){		
  $row = $selectQueryResult->fetch_array();
  //}
}
// $conn->close();
?>
    <?php if (isset($message)) echo $message; ?>
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
      <div class="container">
    <h3><?php if (isset($message)){ echo $message; }?></h3>
    <div class="row">
      <div class="col-md-6">
        <div style="border:1px solid #d1d1d1;padding:10px; background-color: #f0efef99; margin-top:20px;">
          <div class="row">
            <div class="col-md-12">
              <h2 style="background-color: #dbdbdb;padding: 10px 10px 10px 10px;">Code Master Information</h2>
            </div>
          </div>
          <hr>
          <form action="" method="post">
            <div class="form-group">
            <label for="">Hard Codes</label>
              <select class="form-control" id="" name="hardcode">

                <?php

                $selectQuery = "SELECT * FROM `code_master` where softcode=0";
                $selectQueryResult =  $conn->query($selectQuery);

                if ($selectQueryResult->num_rows) {
                  while ($rows = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $rows['hardcode']; ?>" <?php if($row['hardcode']==$rows['hardcode']){echo "selected";} ?>><?php  echo $rows['hardcode']; ?></option>
                    <?php
                  }
                }
                ?>



              </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput1">Soft Code</label>
              <input type="text" class="form-control" id="" name="softcode" placeholder="Exmple:12345" value="<?php echo $row['softcode']; ?>"> 
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput1">Description</label>
              <input type="text" class="form-control" id="" name="des" placeholder="Write Text" value="<?php echo $row['description']; ?>">
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput1">Sort Description</label>
              <input type="text" class="form-control" id="" name="price" placeholder="Write Text" value="<?php echo $row['price']; ?>">
            </div>

            <div class="col-md-12 text-center">
              <div class="form-group">
                <!-- <button class="btn btn-success" id="SubBtn">Submit</button> -->
                <input type="submit" name="update" value="update" class="btn btn-success">
                <!-- <a href="view.php" class="btn btn-success">View Data</a> -->
                <a href="add_hardcode.php" class="btn btn-success">Add Hardcode</a>
                <!-- <a href="view_product.php" class="btn btn-success">View_product</a> -->
                <a href="additional_item.php" class="btn btn-success">Back</a>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
         <!------------------------------------------------------------------>
           
         <?php include_once("./templates/footer.php"); ?>