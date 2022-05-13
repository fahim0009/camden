$(document).ready(function(){
	cat();
	brand();
	product();


	//cat() is a funtion fetching category record from database whenever page is load
	function cat(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{category:1},
			success	:	function(data){
				$("#get_category").html(data);
				
			}
		});
	}
	//brand() is a funtion fetching brand record from database whenever page is load
	function brand(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{brand:1},
			success	:	function(data){
				$("#get_brand").html(data);
			}
		});
	}
	//product() is a funtion fetching product record from database whenever page is load
		function product(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{getProduct:1},
			success	:	function(data){
				$("#get_product").html(data);
			}
		});
	}

	// ************ get all subcat with single  product ***************** 
	
	$("body").delegate(".pwithsubcat","click",function(event){
		event.preventDefault();
		var pid = $(this).attr('pid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{get_p_ForsubC:1,pforscat_id:pid},
			success	:	function(data){

				$("#get_subcat").html(data);
			
			}
		});
	
	});

	/*	when page is load successfully then there is a list of categories when user click on category we will get category id and 
		according to id we will show products
	*/
	$("body").delegate(".category","click",function(event){
		$("#get_product").html("<h3>Loading...</h3>");
		event.preventDefault();
		var cid = $(this).attr('cid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{get_seleted_Category:1,cat_id:cid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		});
	
	});

	/*	when page is load successfully then there is a list of brands when user click on brand we will get brand id and 
		according to brand id we will show products
	*/
	$("body").delegate(".selectBrand","click",function(event){
		event.preventDefault();
		$("#get_product").html("<h3>Loading...</h3>");
		var bid = $(this).attr('bid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{selectBrand:1,brand_id:bid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		});
	
	});
	/*
		At the top of page there is a search box with search button when user put name of product then we will take the user 
		given string and with the help of sql query we will match user given string to our database keywords column then matched product 
		we will show 
	*/
	$("#search_btn").click(function(){
		$("#get_product").html("<h3>Loading...</h3>");
		var keyword = $("#search").val();
		if(keyword !== ""){
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{search:1,keyword:keyword},
			success	:	function(data){ 
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		});
		}
	});
	//end


	/*
		Here #login is login form id and this form is available in index.php page
		from here input data is sent to login.php page
		if you get login_success string from login.php page means user is logged in successfully and window.location is 
		used to redirect user from home page to profile.php page
	*/
	$("#login").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url	:	"login.php",
			method:	"POST",
			data	:$("#login").serialize(),
			success	:function(data){
				if(data == "login_success"){
					window.location.href = "index.php";
				}else if(data == "cart_login"){
					window.location.href = "cart.php";
				}else{
					$("#e_msg").html(data);
					$(".overlay").hide();
				}
			}
		});
	});
	//end

	//Get User Information before checkout
	$("#signup_form").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "register.php",
			method : "POST",
			data : $("#signup_form").serialize(),
			success : function(data){
				$(".overlay").hide();
				if (data == "register_success") {
					window.location.href = "index.php";
				}else{
					$("#signup_msg").html(data);
				}
				
			}
		});
	});
	//Get User Information before checkout end here



	//Add Product into Cart
	$("body").delegate("#product","click",function(event){

var pid = $(this).attr("pid");

		var sp = 0;
		var sd = 'none';
		var note = 'none';
		var xx ='none';
		
		$('input[type="text"].note'+pid).each(function () {
			var b = $(this).val();
			if (typeof b === "undefined") {
				xx = "x is undefined";
			  }else{
				note = b;
			  }
		});

		$("#subcatdtls input[type=hidden]").each(function () {

			sp = $(this).attr("data-prices");
			sd = $(this).attr("data-desces");
			var n = $(this).attr("data-note");
			if (typeof n === "undefined") {
				xx = "x is undefined";
			  }else{
				note = n;
			  }
			
		});

		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {addToCart:1,proId:pid,subcatp:sp,subcatd:sd,pnote:note},
			success : function(data){
				count_item();
				getCartItem();
				$('#product_msg').html(data);
				$('.overlay').hide();
				$('#subcatdtls').html("<input type='hidden' class='subcatdls' value='' data-desces='0' data-prices='0' />");
				location.reload(true);
			}
		});
	});
	
	//Add Product into Cart End Here
	//Count user cart items funtion
	count_item();
	function count_item(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {count_item:1},
			success : function(data){
				$(".badge").html(data);
			}
		});
	}
	//Count user cart items funtion end

	//Fetch Cart item from Database to dropdown menu
	getCartItem();
	function getCartItem(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,getCartItem:1},
			success : function(data){
				$("#cart_product").html(data);
			}
		});
	}

	//Fetch Cart item from Database to dropdown menu

	/*
		Whenever user change qty we will immediate update their total amount by using keyup funtion
		but whenever user put something(such as ?''"",.()''etc) other than number then we will make qty=1
		if user put qty 0 or less than 0 then we will again make it 1 qty=1
		('.total').each() this is loop funtion repeat for class .total and in every repetation we will perform sum operation of class .total value 
		and then show the result into class .net_total
	*/
	$("body").delegate(".qty","keyup",function(event){
		event.preventDefault();
		var row = $(this).parent().parent();
		var price = row.find('.price').val();
		var update_id = row.find('.price').attr("update_id");
		var qty = row.find('.qty').val();
		if (isNaN(qty)) {
			qty = 1;
		}
		if (qty < 1) {
			qty = 1;
		}
		var total = price * qty;
		row.find('.total').val(total.toFixed(2));
		var net_total=0;
		$('.total').each(function(){
			net_total += ($(this).val()-0);
		})
		$('.net_total').html("Total : £ " +net_total.toFixed(2));
		$('#ttm').html("<input type='hidden' class='ttm' name='ttm' value="+net_total+">");
		
		// uptate to the server 
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:update_id,qty:qty},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})

	})
	//Change Quantity end here 

	/*
		whenever user click on .remove class we will take product id of that row 
		and send it to action.php to perform product removal operation
	*/
	$("body").delegate(".remove","click",function(event){
		var remove = $(this).parent().parent().parent();
		var remove_id = remove.find(".remove").attr("remove_id");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{removeItemFromCart:1,rid:remove_id},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		});
	});

// delivery if order is minimum amount.
	$("body").delegate("#clnChkYes","click",function(event){
		
		var ttm = $(".ttm").val();
		if(ttm < 10){
		$("input[type=radio][name=collection]").prop('checked', false);
		$("#guest-singup-msg").html('<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>You have to minimum order £10 for delivery.</b></div>');
		}
	});
	/*
		whenever user click on .update class we will take product id of that row 
		and send it to action.php to perform product qty updation operation
	*/
	$("body").delegate(".update","click",function(event){
		var update = $(this).parent().parent().parent();
		var update_id = update.find(".update").attr("update_id");
		var qty = update.find(".qty").val();
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:update_id,qty:qty},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		});


	});
	checkOutDetails();
	net_total();
	/*
		checkOutDetails() function work for two purposes
		First it will enable php isset($_POST["Common"]) in action.php page and inside that
		there is two isset funtion which is isset($_POST["getCartItem"]) and another one is isset($_POST["checkOutDetials"])
		getCartItem is used to show the cart item into dropdown menu 
		checkOutDetails is used to show cart item into Cart.php page
	*/

	$("body").delegate(".fahim","click",function(event){

		checkOutDetails();
	})
	$("body").delegate(".charge","click",function(event){

		net_total();
	})

	function checkOutDetails(){
	 $('.overlay').show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,checkOutDetails:1},
			success : function(data){
				$('.overlay').hide();
				$("#cart_checkout").html(data);
					net_total();
			}
		})
	}

	// add coupon 
	$("body").delegate("#getcouponcode","click",function(event){	
	
		var coupon= 'none';
		$('input[type="text"].couponcode').each(function () {
			coupon = $(this).val();
		});
		event.preventDefault();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Coupon:1,couponcode:coupon},
			success : function(data){
				var resp = $.parseJSON(data);
				if (resp.status == 303) {
					$("#coupenmsg").html(resp.message);
				}else{
					var couponp = resp.message;
					var net_total = 0;
					$('.total').each(function(){
						net_total += ($(this).val()-0);
					})
					var charge = 0;
					$('.dcharge').each(function(){
						charge += ($(this).val()-0);
					})
					// console.log(net_total);
					var disamount = (net_total * couponp / 100);
					var totalaftercoupon = net_total - (net_total * couponp / 100);

					var totalafcwithdcharge = totalaftercoupon + charge;

					// console.log(net_total);

					$('.net_total').html("Total : £ " +totalafcwithdcharge.toFixed(2));
					$('#ttm').html("<input type='hidden' class='ttm' name='ttm' value="+net_total+">");
					$('#disamount').html("<input type='hidden' name='disamount' class='disamount' value="+disamount+">");


				}
				
			}
		})
	})

	/*
		net_total function is used to calcuate total amount of cart item
	*/
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
			$('#ttm').html("<input type='hidden' class='ttm' name='ttm' value="+net_total+">");
		} else {
			$("#cart_checkout").html('<div class="row"><div class="col-md-2 col-xs-2"></div><div class="col-md-8 col-xs-8"><h3>Your cart is empty!!</h3></div><div class="col-md-2 col-xs-2"></div></div>');
		}

	}

	//remove product from cart

	page();
	function page(){
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{page:1},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	$("body").delegate("#page","click",function(){
		var pn = $(this).attr("page");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})

	$("body").delegate("#gust-signup-form","click",function () {
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "/guest-register.php",
			method : "POST",
			data : $("#guest_signup_form").serialize(),
			success : function(data){
				console.log(data);
				$(".overlay").hide();
				if (data == "Cash_success") {
					window.location.href = "payment_success_collection.php?success=1";
				}else if (data == "Paypal_success") {
					window.location.href = "payment_paypal_process.php?paypal=1";					
				} else {
					$("#guest-singup-msg").html(data);
				}
				
			}
		})

	});

//input e data-price="3.40" rakhen, tahole ar server e everytime call korte hobe na
        $("body").delegate(".getSubcval","click",function () {

			var subcatPrices = new Array();
			
 			var poprice = document.getElementById("pprice").value;
			var pvalue = Number(poprice);
			
			var note = document.getElementById("noteforpop").value;

			var subcatdescs = new Array();

			$("#tblPosts input[type=radio]:checked").each(function () {

				var desc = $(this).attr("data-desc");
				subcatdescs.push(desc);
                
			});

            $("#tblPosts input[type=checkbox]:checked").each(function () {

				var desc = $(this).attr("data-desc");
				subcatPrices.push(this.value);
				subcatdescs.push(desc);
                
			});

			 
			var alldesc = "Sauce :" ; 
	//**************start   for loop for added all desc ************* 		
			for(var i = 0; i < subcatdescs.length; i++){
				alldesc += subcatdescs[i]+",";
			  }
			//   console.log(alldesc);
			  
	//**************start   for loop for added all prices************* 
			var result=[];
			for (var i=0,l=subcatPrices.length;i<l;i++)
				result.push(+subcatPrices[i]);
			
			var sum = 0;

			for(var i = 0; i < result.length; i++){
			  sum += result[i]
			}
	//**************start   for loop for added all prices************* 
			var tsum = pvalue+sum;
			var fsum = sum.toFixed(2);
		 $('.totalwithsubcat').html("Add £"+ tsum.toFixed(2));
		 $('#subcatdtls').html("<input type='hidden' class='subcatdls' value='' data-note='"+note+"' data-desces='"+alldesc+"' data-prices='"+fsum+"' />");
         
            
		});
})




















