<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>view</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<a href="index.php" class="btn btn-primary">Back</a><br>
<h3>View all Data</h3>
<table class="table table-hover">
    <tr>
    <th>ID</th>
    <th>Hardcode</th>
    <th>Soft Code</th>
    <th>Description</th>
    <th>Sort Description</th>
    <th>Created By</th>
    <th>Created Date</th>
    <th>Modify By</th>
    <th>Modify Date</th>
    </tr>
    <?php
    require "database.php";
	$selectQuery = "SELECT * FROM `code_master`";
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
			echo "<td>".$row['created_by']."</td>";
			echo "<td>".$row['created_date']."</td>";
			echo "<td>".$row['modify_by']."</td>";
            echo "<td>".$row['modify_date']."</td>";
            echo "</tr>";
		}
	}
	
	?>
    </table>
</body>
</html>