$(document).ready(function(){

	var productList;

	function getProducts(){
		$.ajax({
			url : '../admin/classes/Products.php',
			method : 'POST',
			data : {GET_PRODUCT:1},
			success : function(response){
				//console.log(response);
                var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var productHTML = '';
					productList = resp.message.products;
					if (productList) {
						$.each(resp.message.products, function(index, value){
                               
                            var subcatvalue = value.subcat;
                            var catst = function(v){
                                    if (v==0) {
                                        return "fas fa-times";
                                    } else {
                                        return "fa fa-check";
                                    }
                                }
                                //catst(subcatvalue);
							productHTML += '<tr>'+
								              '<td>'+''+'</td>'+
								              '<td>'+ value.product_title +'</td>'+
								              '<td>'+ value.cat_title +'</td>'+
								              '<td>'+ value.brand_title +'</td>'+
                                              '<td><a pid="'+value.product_id+'" class="btn btn-sm btn-danger assigncat" style="color:#fff;"><i class="'+catst(subcatvalue)+'"></i></a></td>'+
                                              '<td>'+ value.subcat +'</td>'+
								            '</tr>';

						});

						$("#product_list").html(productHTML);
					}

					
				}
			}

		});
	}

	getProducts();


    

	$(document.body).on('click', '.assigncat', function(){

		var pid = $(this).attr('pid');
		if (confirm("Are you sure to change the satus ?")) {
			$.ajax({

				url : '../admin/classes/Products.php',
				method : 'POST',
				data : {ASSING_CAT: 1, pid:pid},
				success : function(response){
					console.log(response);
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
                        alert(resp.message);
						getProducts();
					}else if (resp.status == 303) {
						alert(resp.message);
					}
				}

			});
		}else{
			alert('Cancelled');
		}
		

	});

});