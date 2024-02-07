$( function() {

	var service = $('#service_table').DataTable( {
		"processing": true,
		"serverSide": false,
		"order": [[ 0, "asc" ]],
		
		//dom: 'Bfrtip',
        buttons: [
            
            {
                extend: 'excelHtml5',
				title: 'Any title for file',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            },
            
        ],
		"ajax": {
			"url": base_url+"Service/getservices",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "ServiceName"},
                {
                    "render": function ( AutoID, type, row, meta ) {
                        if(row.isActive==1){
                            return '<p class="text-success small mb-0 mt-1 tx-12">Active</p>';
                        }else{
                            return '<p class="text-danger small mb-0 mt-1 tx-12">Inactive</p>';
                        }
                      }
                },
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn update_service bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple delete_service btn-info" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */







 $("#service_button").click(function(){

    
    if($('#serviceform').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Service/service_save',
                 type: "POST",
                 data : $("#serviceform").serialize(),
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#service_model .btn-secondary").click()
                         $('.insert').show();
       					 $('#serviceform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Service/services_list';
                         },2000);
                     }else{
						$("#service_model .btn-secondary").click()
						 $('#serviceform').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Service/services_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#service_table").on('click', '.update_service', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Service/getoneservice',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_service').modal('show');  
				$('#up_servicename').val(response.data.ServiceName);
             	$('#updateid').val(response.data.id);
                 if(response.data.active==1){
                    $('#up_serviceactive').prop('checked', true); // Checks it
                 }else{
                    $('#up_serviceactive').prop('checked', false); // Unchecks it
                 }
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_service").click(function(){
    if($('#up_serviceform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Service/update_service',
                 type: "POST",
                 data : $("#up_serviceform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_service').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Service/services_list';
                            },2000);
                     }else{
                         $('#up_service').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Service/services_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#service_table').on('click','.delete_service',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Service/delete_service',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
				location.href= base_url+'Service/services_list';
                table.ajax.reload();
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

});





  




