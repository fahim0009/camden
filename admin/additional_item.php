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
if (isset($_POST['submitbtn'])) {

  $hardcode = $_POST['hardcode'];
  $softcode = $_POST['softcode'];
  $description = $_POST['des'];
  $sort_des = $_POST['sdes'];

  $insertQuery = "INSERT INTO `code_master` (id,hardcode,softcode,description,price,created_date) VALUES(NULL,'$hardcode','$softcode','$description','$sort_des',now())";


  $conn->query($insertQuery);
  // echo $insertQuery; exit;
  if ($conn->affected_rows == 1) {
    $message = "Insert Successfully";
    //header("Location:additional_item.php");
  }
  //$conn->close();
}
?>


  <div class="container">
    <h3><?php if (isset($message)) echo $message; ?></h3>
    <div class="row">
      <div class="col-md-6">
        <div style="border:1px solid #d1d1d1;padding:10px; background-color: #f0efef99; margin-top:20px;">
          <div class="row">
            <div class="col-md-12">
              <h2 style="background-color: #dbdbdb;padding: 10px 10px 10px 10px;">Manage additional items.</h2>
            </div>
          </div>
          <hr>
          <form action="" method="post">
            <div class="form-group">
              <label for="">Hard Code</label>
              <select class="form-control" id="" name="hardcode" required>

                <?php

                $selectQuery = "SELECT * FROM `code_master` where softcode=0";
                $selectQueryResult =  $conn->query($selectQuery);

                if ($selectQueryResult->num_rows) {
                  while ($row = $selectQueryResult->fetch_assoc()) {


                    echo '<option value="' . $row['hardcode'] . '">' . $row['hardcode'] . '</option>';
                  }
                }
                ?>



              </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput1">Soft Code</label>
              <input type="number" class="form-control" id="" name="softcode" placeholder="Exmple:12345" required>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput1">Title</label>
              <input type="text" class="form-control" id="" name="des" placeholder="Write Text" required>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput1">Amount</label>
              <input type="text" class="form-control" id="" name="sdes" placeholder="" required>
            </div>

            <div class="col-md-12 text-center">
              <div class="form-group">
                <!-- <button class="btn btn-success" id="SubBtn">Submit</button> -->
                <input type="submit" name="submitbtn" value="Submit" class="btn btn-success">
                <!-- <a href="view.php" class="btn btn-success">View Data</a> -->
                <a href="add_hardcode.php" class="btn btn-success">Add Hardcode</a>
                <!-- <a href="view_product.php" class="btn btn-success">View_product</a> -->

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>


    <h3>View all Data</h3>
<table class="table table-hover">
    <tr>
    <th>ID</th>
    <th>Hardcode</th>
    <th>Soft Code</th>
    <th>Description</th>
    <th>price</th>
    <th>action</th>
    
    </tr>
    <?php
	$selectQuery = "SELECT * FROM `code_master` where softcode>0 ORDER BY hardcode";
	$selectQueryResult = $conn->query($selectQuery);	
	//echo "$selectQueryResult->num_rows";	
	if($selectQueryResult->num_rows){
		
		while($row = $selectQueryResult->fetch_array()){
			echo"<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['hardcode']."</td>";
			echo "<td>".$row['softcode']."</td>";
			echo "<td>".$row['description']."</td>";
      echo "<td>".$row['price']."</td>";
      echo "<td><a href='edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-edit'></span> Edit</a>
      <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
      
                </td>";
			
            echo "</tr>";
		}
	}
	
	?>
    </table>
    </div>




    <?php // include_once("./templates/footer.php"); ?>