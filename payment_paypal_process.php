<?php
session_start();
if(!isset($_SESSION["uid"]) & !isset($_SESSION["gid"])){
	header("location:index.php");
}
if (isset($_GET["paypal"])) {


	if(isset($_SESSION["uid"])){

		$user_id = $_SESSION["uid"];	

	}elseif(isset($_SESSION["gid"])){

		$user_id = $_SESSION["gid"];

    }
    
    include_once("db.php");
    //paypal mail
    $paypalmail = "SELECT * FROM `mails`";
    $paypalmailquery = mysqli_query($con,$paypalmail);

    if(mysqli_num_rows($paypalmailquery) > 0){
        while($row = mysqli_fetch_array($paypalmailquery)){

            $mailforpaypal = $row['paypal'];		

        }
    }

    //Delivery charge 

    $sqlcrg = "SELECT * FROM `user_info` WHERE `user_id` = '$user_id'";
    $query9 = mysqli_query($con,$sqlcrg);
    if (mysqli_num_rows($query9) > 0) {
        while ($row=mysqli_fetch_array($query9)) {

            $dlcharge = $row["dcharge"];
            $name = $row["name"];
            $disamount = $row["disamount"];
        
        }
    }	
    
    include("inc/header.php");	
    // echo '<h4>Hi, '.$name.'Thanks for choosing paypal. Please proceed to pay.</h4>';
//Paypal checkout form
echo '					
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalForm">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="business" value="'.$mailforpaypal.'">
        <input type="hidden" name="upload" value="1">';
          
        $x=0;
        $sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,b.subcat_d,subcat_p FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$user_id'";
        $query = mysqli_query($con,$sql);
        while($row=mysqli_fetch_array($query)){
            $x++;
            $product_price = $row["product_price"];
            $subcat_d = $row["subcat_d"];
            $subcat_p = $row["subcat_p"];			
            $totalp = $product_price+$subcat_p;
            $detailWithsub = $row["product_title"].$subcat_d;
            echo  	
                '<input type="hidden" name="item_name_'.$x.'" value="'.$detailWithsub.'">
                   <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
                 <input type="hidden" name="amount_'.$x.'" value="'.$totalp.'">
                 <input type="hidden" name="quantity_'.$x.'" value="'.$row["qty"].'">';
            }
            $x = $x + 1;
          echo'<input type="hidden" name="item_name_'.$x.'" value="Delivery Charge">
          <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
          <input type="hidden" name="amount_'.$x.'" value="'.$dlcharge.'">
          <input type="hidden" name="quantity_'.$x.'" value="1">';
          
$x = $x + 1;
          echo'<input type="hidden" name="item_name_'.$x.'" value="Delivery Charge">
          <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
          <input type="hidden" name="discount_amount_cart" id="discount_amount_cart" value="'.$disamount.'">
          <input type="hidden" name="quantity_'.$x.'" value="1">';
          
        echo '<input type="hidden" name="return" value="http://www.camden.wokandfire.co.uk/thanks.php?success=1"/>
              <input type="hidden" name="notify_url" value="http://www.camden.wokandfire.co.uk/paypal/IPNHandler.php"/>
              <input type="hidden" name="cancel_return" value="http://www.camden.wokandfire.co.uk/cancel.php"/>
              <input type="hidden" name="currency_code" value="GBP"/>
              <input type="hidden" name="custom" value="'.$user_id.'"/>
              <input style="float:right;margin-right:80px;" type="image" name="submit"
                
                    src="images/paypal.jpg" onClick=" alt="Loading....."
                    alt="PayPal - The safer, easier way to pay online">
            </form>';

}
?>
 <script>
window.onload = function(){
  document.forms['paypalForm'].submit();
}
 </script>