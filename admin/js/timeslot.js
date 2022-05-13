$(document).ready(function(){

	getTimeslot();
	
	function getTimeslot(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {GET_TIMESLOT:1},
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);

				var brandHTML = '';

				$.each(resp.message, function(index, value){
					brandHTML += '<tr>'+
									'<td></td>'+
									'<td>'+ value.time_slot +'</td>'+
									'<td><a class="btn btn-sm btn-info edit-time-slot"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;<a cid="'+value.time_id+'" class="btn btn-sm btn-danger delete-time-slot"><i class="fas fa-trash-alt"></i></a></td>'+
								'</tr>';
				});

				$("#all_timeslot").html(brandHTML);

			}
		});
		
	}

	$(".add-time-slot").on("click", function(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#add-time-slot-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				//console.log(response);
				if (resp.status === 202) {
					$("#add-time-slot-form").trigger("reset");
					alert(resp.message);
					getTimeslot();
				}else if(resp.status === 303){
					alert(resp.message);
				}
				$("#add_category_modal").modal('hide');
			}
		});
	});

	$(document.body).on("click", ".edit-time-slot", function(){

		var time = $.parseJSON($.trim($(this).children("span").html()));
		$("input[name='time_slot']").val(time.time_slot);
		$("input[name='time_id']").val(time.time_id);

		$("#edit_category_modal").modal('show');

		

	});

	$(".edit-time-slot-btn").on('click', function(){

		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : $("#edit-time-slot-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status === 202) {
					getTimeslot();
					alert(resp.message);
				}else if(resp.status === 303){
					alert(resp.message);
				}
				$("#edit_category_modal").modal('hide');
			}
		});

	});

	$(document.body).on('click', '.delete-time-slot', function(){

		var cid = $(this).attr('cid');

		if (confirm("Are you sure to delete this time slot")) {
			$.ajax({
				url : '../admin/classes/Products.php',
				method : 'POST',
				data : {DELETE_TIME_SLOT:1, cid:cid},
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