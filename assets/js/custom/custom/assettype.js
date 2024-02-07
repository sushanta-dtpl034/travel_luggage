$( function() {

	var service = $('#assettype_table').DataTable( {
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
			"url": base_url+"Asset/getassettype",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "AsseTypeName"},
               
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm  update_assettype bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple delete_assettype btn-danger btn-sm" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */







 $("#asset_button").click(function(){

    
    if($('#assetform').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Asset/assettype_save',
                 type: "POST",
                 data : $("#assetform").serialize(),
                 success: function(result)
                 {
                             
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#asset_model .btn-secondary").click()
                         $('.insert').show();
       					 $('#assetform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Asset/assettype_list';
                         },2000);
                     }else{
						$("#asset_model .btn-secondary").click()
						 $('#assetform').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Asset/assettype_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#assettype_table").on('click', '.update_assettype', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Asset/getoneassettype',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_assetmodel').modal('show');  
				$('#up_asseytype').val(response.data.AsseTypeName);
             	$('#updateid').val(response.data.id);
                
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_assettype").click(function(){
    if($('#up_assettypeform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Asset/update_assettype',
                 type: "POST",
                 data : $("#up_assettypeform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_assetmodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Asset/assettype_list';
                            },2000);
                     }else{
                         $('#up_assetmodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Asset/assettype_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#assettype_table').on('click','.delete_assettype',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Asset/delete_assettype',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");
                setInterval(function () {
                location.href= base_url+'Asset/assettype_list';
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





  




