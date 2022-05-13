$(document).ready(function(){

	getDeliverycharge();
	
	function getDeliverycharge(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {GET_DELIVERY_CHARGE:1},
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);

				var brandHTML = '';

				$.each(resp.message, function(index, value){
					brandHTML += '<tr>'+
									'<td></td>'+
									'<td>'+ value.town +'</td>'+
									'<td>'+ value.charge +'</td>'+
									'<td><a class="btn btn-sm btn-info edit-delivery-charge"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;<a cid="'+value.charge_id+'" class="btn btn-sm btn-danger delete-delivery-charge"><i class="fas fa-trash-alt"></i></a></td>'+
								'</tr>';
				});

				$("#all_delivery_charge").html(brandHTML);

			}
		});
		
	}

	$(".add-delivery-charge").on("click", function(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#add-delivery-charge-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				//console.log(response);
				if (resp.status === 202) {
					$("#add-delivery-charge-form").trigger("reset");
					alert(resp.message);
					getDeliverycharge();
				}else if(resp.status === 303){
					alert(resp.message);
				}
				$("#add_category_modal").modal('hide');
			}
		});
	});

	$(document.body).on("click", ".edit-delivery-charge", function(){

		var d = $.parseJSON($.trim($(this).children("span").html()));
		$("input[name='town']").val(d.town);
		$("input[name='charge']").val(d.charge);
		$("input[name='charge_id']").val(d.charge_id);

		$("#edit_category_modal").modal('show');

		

	});

	$(".edit-delivery-charge-btn").on('click', function(){

		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#edit-delivery-charge-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status === 202) {
					$("#edit-delivery-charge-form").trigger("reset");
					getDeliverycharge();
					alert(resp.message);
				}else if(resp.status === 303){
					alert(resp.message);
				}
				$("#edit_category_modal").modal('hide');
			}
		});

	});

	$(document.body).on('click', '.delete-delivery-charge', function(){
		var cid = $(this).attr('cid');
		if (confirm("Are you sure to delete this Delivery town and charge")) {
			$.ajax({
				url : '../admin/classes/Products.php',
				method : 'POST',
				data : {DELETE_DELIVERY_CHARGE:1, cid:cid},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status === 202) {
						alert(resp.message);
						getDeliverycharge();
					}else if(resp.status === 303){
						alert(resp.message);
					}
				}
			});
		}else{
			alert('Cancelled');
		}	

	});

});