$(document).ready(function(){

	getTimeslot();
	
	function getTimeslot(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {GET_COUPON:1},
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);

				var brandHTML = '';

				$.each(resp.message, function(index, value){
					brandHTML += '<tr>'+
									'<td></td>'+
									'<td>'+ value.coupon +'</td>'+
									'<td>'+ value.percentage +'</td>'+
									'<td><a cid="'+value.id+'" class="btn btn-sm btn-danger delete-mails"><i class="fas fa-trash-alt"></i></a></td>'+
								'</tr>';
				});

				$("#all_mails").html(brandHTML);

			}
		});
		
	}

	$(".addmail").on("click", function(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#add-mail-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				//console.log(response);
				if (resp.status === 202) {
					$("#add-mail-form").trigger("reset");
					alert(resp.message);
					getTimeslot();
				}else if(resp.status === 303){
					alert(resp.message);
				}
				$("#add_category_modal").modal('hide');
			}
		});
	});



	$(document.body).on('click', '.delete-mails', function(){

		var cid = $(this).attr('cid');

		if (confirm("Are you sure to delete this coupon!!")) {
			$.ajax({
				url : '../admin/classes/Products.php',
				method : 'POST',
				data : {DELETE_COUPON:1, cid:cid},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status === 202) {
						alert(resp.message);
						getTimeslot();
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