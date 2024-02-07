$( function() {

	var service = $('#remindersetting_table').DataTable( {
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
			"url": base_url+"Asset/getremindersetting",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "catname"},
                { "data": "subcatname"},
                { "data": "Reminderdays"},
               
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm update_warrantytype bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_rs btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */

 $("#remindersetting_button").click(function(){

   if($('#reminderform').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Asset/remnindersetting_save',
                 type: "POST",
                 data : $("#reminderform").serialize(),
                 success: function(result)
                 {
                 
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#warranty_model .btn-secondary").click()
                         $('.insert').show();
       					 $('#reminderform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Asset/remnindersetting_list';
                         },2000);
                     }else{
						$("#warranty_model .btn-secondary").click()
						 $('#warrantyform').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Asset/remnindersetting_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#remindersetting_table").on('click', '.update_warrantytype', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Asset/getonereminderseeting',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_warrantymodel').modal('show');  
				$('#up_reminder_days').val(response.data.remindardays);
                $('#up_warrassetmancat').val(response.data.AssetCat).trigger('change');
                $('#up_warrassetmentsubcat').val(response.data.AssetSubCat).trigger('change');
             	$('#updateid').val(response.data.id);
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_rs").click(function(){
    if($('#up_rsform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Asset/update_remindersetting',
                 type: "POST",
                 data : $("#up_rsform").serialize(),
                 success: function(result)
                 {
                       
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_warrantymodel').modal('hide');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Asset/remnindersetting_list';
                            },2000);
                     }else{
                         $('#up_warrantymodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Asset/remnindersetting_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#remindersetting_table').on('click','.delete_rs',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Asset/delete_remindersetting',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");
                setInterval(function () {
                location.href= base_url+'Asset/remnindersetting_list';
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







  




