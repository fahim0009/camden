<?php
require "database.php";

?>
<h1>View Egg</h1>
<?php
$selectQuery = "SELECT * FROM `code_master` where hardcode='Egg N' and softcode>0";
$selectQueryResult = $conn->query($selectQuery);
//echo "$selectQueryResult->num_rows";	
if ($selectQueryResult->num_rows) {

    while ($row = $selectQueryResult->fetch_array()) {
        echo "<h2>".$row['hardcode'].".".$row['description']."........".$row['price']."</h2>";
    }
}

?>
<hr>
<h1>View Rice</h1>
<?php
$selectQuery = "SELECT * FROM `code_master` where hardcode='Rice' and softcode>0";
$selectQueryResult = $conn->query($selectQuery);
//echo "$selectQueryResult->num_rows";	
if ($selectQueryResult->num_rows) {

    while ($row = $selectQueryResult->fetch_array()) {
        echo "<h2>".$row['hardcode'].".".$row['description']."........".$row['price']."</h2>";
    }
}

?>
<hr>
<h1>View Meat</h1>
<?php
$selectQuery = "SELECT * FROM `code_master` where hardcode='meat' and softcode>0";
$selectQueryResult = $conn->query($selectQuery);
//echo "$selectQueryResult->num_rows";	
if ($selectQueryResult->num_rows) {

    while ($row = $selectQueryResult->fetch_array()) {
        echo "<h2>".$row['hardcode'].".".$row['description']."........".$row['price']."</h2>";
    }
}

?>
<hr>
<h1>View Fahim</h1>
<?php
$selectQuery = "SELECT * FROM `code_master` where hardcode='Fahim' and softcode>0";
$selectQueryResult = $conn->query($selectQuery);
//echo "$selectQueryResult->num_rows";	
if ($selectQueryResult->num_rows) {

    while ($row = $selectQueryResult->fetch_array()) {
        echo "<h2>".$row['hardcode'].".".$row['description']."........".$row['price']."</h2>";
    }
}

?>