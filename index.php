<?php include("inc/header.php");?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<br>
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-5" id="product_msg"></div>
			<div class="col-md-5"></div>
		
		</div>
	
	<div class="row">
	
	<div class="col-md-2 col-xs-4">

	<ul class="list-group" id="get_category">

<!--		all category will be loaded here from action.php through get_category function-->
		
	</ul>

	</div>

 <script>
		function ShowHideDivforCln(){
			var clnChkYes = document.getElementById("clnChkYes");
			var dvClnDelivery = document.getElementById("dvClnDelivery");
			dvClnDelivery.style.display = clnChkYes.checked ? "block" : "none";
		}
				
		function myFunction() {
		var x = document.getElementById("mySelect").value;
		document.getElementById("demo").innerHTML = "<br><div class='col-md-4'></div><div class='col-md-5'><h4>Delivery Charge:</h4></div><div class='col-md-3'><input type='text' class='form-control dcharge' value='"+x+"' readonly='readonly'></div>";
		 net_total();
		}

		$("body").delegate(".rmvDiv","click",function(event){
			document.getElementById("guest_signup_form").reset();
		    document.getElementById("demo").innerHTML = " ";
			net_total();
			
			});
		
		function net_total(){
		var total = 0;
		var charge = 0;
		var disamount = 0;
		$('.qty').each(function(){
			var row = $(this).parent().parent();
			var price  = row.find('.price').val();
			var total = price * $(this).val()-0;
			row.find('.total').val(total.toFixed(2));
		})
		$('.total').each(function(){
			total += ($(this).val()-0);
		})
		 
				 
		$('.dcharge').each(function(){
			charge += ($(this).val()-0);
		})
		
		$('.disamount').each(function(){
			disamount += ($(this).val()-0);
		})

		var net_total = total + charge - disamount;

		if (net_total>0) {
			$('.net_total').html("Total : £ " +net_total.toFixed(2));
		} else {
			$("#cart_checkout").html('<div class="row"><div class="col-md-2 col-xs-2"></div><div class="col-md-8 col-xs-8"><h3>Your cart is empty!!</h3></div><div class="col-md-2 col-xs-2"></div></div>');
		}

	}
 </script>
 
	<div class="col-md-5 col-xs-8">		
	<div class="row" id="get_product">


<!--		product will be loaded here. by its class id feature. it will loaded from action.php get product function and get selected category-->
		
		
		
	
	
	
	</div>	
	</div>

<!--************************************* right side cart div start ************************************************* -->

	<div class="col-md-5 col-xs-12"> 
		
		

<!--**********************************cart item start *************************************************-->
		

				<div id="cart_checkout"></div>


		
		
		
<!--**********************************cart item end *************************************************-->
		
		
				<div id="cart_info"></div>	
	
</div>



<!--************************************* right side cart div end ************************************************* -->



	
	</div>


	
	
	</div>
<style>
	.modal-scrol {
    max-height: 350px;
    overflow-y: scroll;
}
</style>

<div class="container">
   <!-- Modal -->
  <div class="modal fade" id="assignSubcat" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="get_subcat">



            </div>    
	      </div>      
    </div>
  </div>  

  <div class="row">
			<div class="col-md-10">
				<center>
					<ul class="pagination" id="pageno">
						<li><a href="#">1</a></li>
					</ul>
				</center>
			</div>
		</div>
</div>


<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
    $('body').on('focus',".date-picker", function(){
  $(this).datepicker();
});
</script>
<?php  include("inc/footer2.php"); ?>
</body>
</html>
















































