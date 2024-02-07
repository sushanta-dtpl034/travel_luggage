$( function() {

	var table = $('#misc_table').DataTable( {
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
			"url": base_url+"Masters/getactivemisc",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "MiscDes"},
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn update_misc bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple delete_misc btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */







 $("#misc_button").click(function(){
    if($('#miscform').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Masters/misc_save',
                 type: "POST",
                 data : $("#miscform").serialize(),
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#misc_model .btn-secondary").click()
                         $('.insert').show();
       					 $('#miscform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Masters/miscellaneous_list';
                         },2000);
                     }else{
						$("#misc_model .btn-secondary").click()
						 $('#miscform').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Masters/miscellaneous_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#misc_table").on('click', '.update_misc', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Masters/getonemisc',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_miscmodel').modal('show');  
				$('#up_miscname').val(response.data.misc_name);
             	$('#updateid').val(response.data.id);
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_misc").click(function(){
    if($('#up_miscform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Masters/update_misc',
                 type: "POST",
                 data : $("#up_miscform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_miscmodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Masters/miscellaneous_list';
                            },2000);
                     }else{
                         $('#up_miscmodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Masters/miscellaneous_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#misc_table').on('click','.delete_misc',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Masters/delete_misc',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
				location.href= base_url+'Masters/miscellaneous_list';
                table.ajax.reload();
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

});





  




