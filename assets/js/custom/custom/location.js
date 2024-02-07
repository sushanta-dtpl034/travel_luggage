$( function() {

	var service = $('#location_table').DataTable( {
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
			"url": base_url+"Location/getlocation",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "CompanyName"},
                { "data": "Name"},
                { "data": "ContactPerson"},
                { "data": "Email"},
                {
                    "render": function (AutoID, type, row, meta) {
                        if ((row.Phone !== null && row.Phone !== undefined && row.Phone !== '') && (row.CountryCode !== null && row.CountryCode !== undefined && row.CountryCode !== '') ) {
                            return row.CountryCode+" "+ row.Phone;
                        }else if((row.Phone !== null && row.Phone !== undefined && row.Phone !== '')){
                            return "+91 "+ row.Phone;
                        }
                        else{
                            return row.Phone;
                        }
                    }
                },
               
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm update_location bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm  ripple delete_location btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the location data */

 $("#location_button").click(function(){

    
    if($('#locationform').parsley().validate())
     {


        var location_save = new FormData();
        var assetowner_id =  $('#assetowner_id').val();
        var location_name =  $('#location_name').val();
        var ContactPerson =  $('#ContactPerson').val();
        var email =  $('#email').val();
        var phone =  $('#phone').val();
        var countryCode =  $('#countryCode').val();
        location_save.append('CompanyID',assetowner_id);
        location_save.append('location_name',location_name);
        location_save.append('ContactPerson',ContactPerson);
        location_save.append('Email',email);
        location_save.append('Phone',phone);
        location_save.append('countryCode',countryCode);


         $.ajax({
                 url : base_url+'Location/location_save',
                type: "POST",
                contentType: false,
                processData: false,
                 data : location_save,
              beforeSend: function() {
               $('.load-company').show();
               $('#company_button').hide();
            },
                 success: function(result)
                 {
                 
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#location_model .btn-secondary").click()
                         $('.insert').show();
       					 $('#locationform').trigger("reset");
                            service.ajax.reload();
                            $('.load-company').hide();
                    setInterval(function(){
                             $('.insert').hide();
                             
                            //  service.ajax.reload();
                            // location.href=base_url+'Location/location_list';
                         },3000);
                     }else{
						$("#location_model .btn-secondary").click()
						 $('#locationform').trigger("reset");
                         $('.alert-solid-warning').show();
                         service.ajax.reload();
                         $('.load-company').hide();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            // location.href=base_url+'Location/location_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#location_table").on('click', '.update_location', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Location/getonelocation',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_locationmodel').modal('show'); 
                $('#up_assetowner_id').val(response.data.CompanyID).change(); 
                $('#up_location_name').val(response.data.Name);
				$('#up_ContactPerson').val(response.data.ContactPerson);
                $('#up_phone').val(response.data.Phone);
                $('#up_email').val(response.data.Email);
             	$('#update_id').val(response.data.id);
                 $('#up_countryCode').val(response.data.countrycode);
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_location").click(function(){
    if($('#up_locationform').parsley().validate())
     {


        var location_update = new FormData();
       
       
 
        
        var up_assetowner_id =  $('#up_assetowner_id').val();
        var up_location_name =  $('#up_location_name').val();
        var up_ContactPerson =  $('#up_ContactPerson').val();
        var up_phone =  $('#up_phone').val();
        var up_email =  $('#up_email').val();
        var update_id =  $('#update_id').val();
        var up_countryCode =  $('#up_countryCode').val();
       
        location_update.append('up_assetowner_id',up_assetowner_id);
        location_update.append('up_location_name',up_location_name);
        location_update.append('up_ContactPerson',up_ContactPerson);
        location_update.append('up_phone',up_phone);
        location_update.append('up_email',up_email);
        location_update.append('update_id',update_id);
        location_update.append('up_countryCode',up_countryCode);


    
     
         $.ajax({
                 url : base_url+'location/update_location',
                  type: "POST",
                contentType: false,
                processData: false,
                 data : location_update,
              beforeSend: function() {
                $('.load-company').show();
                $('#update_company').hide();
             },
              
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                    //  console.log(jsonData);
                     if(jsonData.status===1){
                         $('#up_locationmodel').modal('toggle');
                         $('.update').show();
                         $('.load-company').hide();
                         service.ajax.reload();
                         setInterval(function(){ 
                             $('.update').hide();
                            //  location.href=base_url+'Location/location_list';
                            },3000);
                     }else{
                         $('#up_locationmodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         service.ajax.reload();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                            //  location.href=base_url+'Location/location_list';
                            },3000);
                         
                     }
                 },
                
             });
     }

}); 

$('#location_table').on('click','.delete_location',function(){
    
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Location/delete_location',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");
                service.ajax.reload();
                // setInterval(function () {
                //     // location.href=base_url+'Location/location_list';
                //     // table.ajax.reload();
                // }, 2000);

            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

});

// $(document).ready(function() {


//     var readURL = function(input) {
//         if (input.files && input.files[0]) {
//             var reader = new FileReader();
//             reader.onload = function (e) {
//             $('.update_companylogo').attr('src', e.target.result);
//             }


//             }
//             reader.readAsDataURL(input.files[0]);

            
//     }


//     $(".companylog").on('change', function(){
//        readURL(this);
//     });

//     $(".company").on('click', function() {
//           $(".companylog").click();
//         });

// });

// $(document).ready(function() {


//     var readURL = function(input) {
//         if (input.files && input.files[0]) {
//             var reader = new FileReader();
//             reader.onload = function (e) {
//             $('.update_companystamp').attr('src', e.target.result);
//             }


//             }
//             reader.readAsDataURL(input.files[0]);

            
//     }


//     $(".companystamp").on('change', function(){
//        readURL(this);
//     });

//     $(".stamp").on('click', function() {
//           $(".companystamp").click();
//         });

// });





  




