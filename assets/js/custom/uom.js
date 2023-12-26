$( function() {

	var service = $('#uom_table').DataTable( {
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
			"url": base_url+"Asset/getuom",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "UomName"},
                { "data": "UomShortName"},
               
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm update_uom bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_uom btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */







 $("#uom_button").click(function(){

    
    if($('#uom_form').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Asset/uom_save',
                 type: "POST",
                 data : $("#uom_form").serialize(),
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#uom_model .btn-secondary").click();
                         $('.insert').show();
       					 $('#uom_form').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Asset/uom_list';
                         },2000);
                     }else{
						$("#uom_model .btn-secondary").click();
						 $('#uom_form').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Asset/uom_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#uom_table").on('click', '.update_uom', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Asset/getoneuom',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_uommodel').modal('show');  
				$('#up_uomname').val(response.data.Name);
                $('#up_uomshortname').val(response.data.ShortName);
             	$('#updateid').val(response.data.id);
                
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#up_uom").click(function(){
    if($('#up_uomform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Asset/update_uom',
                 type: "POST",
                 data : $("#up_uomform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_uommodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Asset/uom_list';
                            },2000);
                     }else{
                         $('#up_uommodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Asset/uom_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#uom_table').on('click','.delete_uom',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Asset/delete_uom',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");
                setInterval(function () {
                    location.href= base_url+'Asset/uom_list';
                    table.ajax.reload();
                }, 2000);
				
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

});





  




