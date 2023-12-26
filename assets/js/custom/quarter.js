$( function() {

	var service = $('#quarter_table').DataTable( {
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
			"url": base_url+"Quarterly/getquarter",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "QuarterlyName"},
                { "data": "Fromdate"},
                { "data": "Todate"},
               
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm update_quarter bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */

 $("#quarter_button").click(function(){

    
    if($('#quarterform').parsley().validate())
     {


        var quarter_save = new FormData();
        var quarter_name =  $('#quarter_name').val();
        var quarter_from =  $('#quarter_from').val();
        var quarter_to =  $('#quarter_to').val();
        quarter_save.append('quarter_name',quarter_name);
        quarter_save.append('quarter_from',quarter_from);
        quarter_save.append('quarter_to',quarter_to);


         $.ajax({
                 url : base_url+'Quarterly/quarterly_save',
                type: "POST",
                contentType: false,
                processData: false,
                 data : quarter_save,
              beforeSend: function() {
               $('.load-company').show();
               $('#company_button').hide();
            },
                 success: function(result)
                 {
            
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#quarter_model .btn-secondary").click()
                         $('.insert').show();
       					 $('#quarterform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Quarterly/Quarterly_list';
                         },2000);
                     }else{
						$("#quarter_model .btn-secondary").click()
						 $('#quarterform').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Quarterly/Quarterly_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#quarter_table").on('click', '.update_quarter', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Quarterly/getonequarter',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_quartermodel').modal('show');  
                $('#up_quartername').val(response.data.QuarterlyName);
				$('#up_quarterfrom').val(response.data.Fromdate);
                $('#up_quarterto').val(response.data.Todate);
             	$('#update_id').val(response.data.id);
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_quarter").click(function(){
    if($('#up_quarterform').parsley().validate())
     {


        var quarter_update = new FormData();
       
       
 
        var up_quartername =  $('#up_quartername').val();
        var up_quarterfrom =  $('#up_quarterfrom').val();
        var up_quarterto =  $('#up_quarterto').val();
        var update_id =  $('#update_id').val();
        
        quarter_update.append('up_quartername',up_quartername);
        quarter_update.append('up_quarterfrom',up_quarterfrom);
        quarter_update.append('up_quarterto',up_quarterto);
        quarter_update.append('update_id',update_id);


    
     
         $.ajax({
                 url : base_url+'Quarterly/update_quater',
                  type: "POST",
                contentType: false,
                processData: false,
                 data : quarter_update,
              beforeSend: function() {
                $('.load-company').show();
                $('#update_company').hide();
             },
              
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_quartermodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Quarterly/Quarterly_list';
                            },2000);
                     }else{
                         $('#up_quartermodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Quarterly/Quarterly_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#quarter_table').on('click','.delete_quarter',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Quarterly/delete_quarter',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");

                setInterval(function () {
                    location.href= base_url+'Quarterly/Quarterly_list';
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

$(document).ready(function() {


    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
            $('.update_companylogo').attr('src', e.target.result);
            }


            }
            reader.readAsDataURL(input.files[0]);

            
    }


    $(".companylog").on('change', function(){
       readURL(this);
    });

    $(".company").on('click', function() {
          $(".companylog").click();
        });

});

$(document).ready(function() {


    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
            $('.update_companystamp').attr('src', e.target.result);
            }


            }
            reader.readAsDataURL(input.files[0]);

            
    }


    $(".companystamp").on('change', function(){
       readURL(this);
    });

    $(".stamp").on('click', function() {
          $(".companystamp").click();
        });

});





  




