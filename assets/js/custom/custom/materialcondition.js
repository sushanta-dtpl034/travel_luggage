$( function() {

	var table = $('#super_materialcon').DataTable( {
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
			"url": base_url+"Masters/getmaterialcon",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "ConditionName"},
          	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm mail_materialcon bg-success mx-2 " id="'+row.AutoID+'"  datatype="edit"><i class="si si-envelope-open"></i></button><a href="'+base_url+'/Masters/materialcon_mailsend/'+row.AutoID+'" id="'+row.AutoID+'"><button class="btn btn-sm ripple mail_send btn-danger mx-2" ><i class="si si-pencil"></i></button></a>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */







 $("#mail_button").click(function(){
    if($('#mailsettingform').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Masters/mailsetting_save',
                 type: "POST",
                 data : $("#mailconf").serialize(),
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#projectmodel .btn-secondary").click()
                         $('.insert').show();
       					 $('#projectform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Masters/projects_list';
                         },2000);
                     }else{
						$("#materialmodal .btn-secondary").click()
						 $('#material_form').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Masters/projects_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#super_materialcon").on('click', '.mail_materialcon', function(){
	var id = $(this).attr("id");
       $.ajax({
        url: base_url+'Masters/getonematerialcon',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#mailsetting').modal('show');  
                $('#condition_title').html(response.data.ConditionName);
                $('#updateid').val(response.data.AutoID);
                $('#to_name').val(response.data.ToName);
                $('#to_email').val(response.data.ToEmail);
                $('#cc_email').val(response.data.CCEmail);
           }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#mail_button").click(function(){
    if($('#mailsettingform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Masters/mailsetting_save',
                 type: "POST",
                 data : $("#mailsettingform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#mailsetting').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Masters/superad_materialcon';
                            },2000);
                     }else{
                         $('#mailsetting').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Masters/superad_materialcon';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#project_table').on('click','.projectdelete',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Masters/deleteproject',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){

                swal("Deleted!", "Deleted Successfully", "success");
                setInterval(function () {
                    location.href= base_url+'Masters/projects_list';
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
