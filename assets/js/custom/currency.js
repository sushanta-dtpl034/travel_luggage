$( function() {
    /*
	var table = $('#currecny_table').DataTable( {
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
           
            
        ],
		"ajax": {
			"url": base_url+"Masters/getcurrency",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "CurrencyName"},
            { "data": "CurrencyCode"},
            { "data": "CurrencySymbole"},
			{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn update_currency bg-success mx-2 btn-sm" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple delete_currency btn-danger btn-sm" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
		}
		
	} );
*/
	/* save the material condiotn */







 $("#currency_button").click(function(){
    if($('#currencyform').parsley().validate())
     {

            
         $.ajax({
                 url : base_url+'Masters/currency_save',
                 type: "POST",
                 data : $("#currencyform").serialize(),
                 success: function(result)
                 {          
                       
                     var jsonData = JSON.parse(result);
                    
						 if(jsonData.status==1){
                           $('#currencymodel').modal('toggle');
                           $('.insert').show();
       					 $('#currencymodel').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            table.ajax.reload();
                            location.href=base_url+'Masters/currency_list';
                         },2000);
                     }else{
                        $('#currencymodel').modal('toggle');
					      $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            table.ajax.reload();
                            location.href=base_url+'Masters/currency_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("body").on('click', '.up_currencymodel', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Masters/getonecurrecny',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
               
            
            	$('#up_currencymodel').modal('show');  
				$('#up_currencyname').val(response.data.CurrencyName);
                $('#up_currencycode').val(response.data.CurrencyCodeame);
                $('#up_currencysymbole').val(response.data.CurrencySymbole);
                $('#up_currencyunicode').val(response.data.CurrencyUnicode);
        		$('#cur_updateid').val(response.data.AutoID);
            }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#up_currencybutton").click(function(){
    if($('#up_currencyform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Masters/updatecurrency',
                 type: "POST",
                 data : $("#up_currencyform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_currencymodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Masters/currency_list';
                            },2000);
                     }else{
                         $('#up_currencymodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Masters/currency_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#currecny_table').on('click','.delete_currency ',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Masters/delete_currency',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");
                setInterval(function () {
                    location.href= base_url+'Masters/currency_list';
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


  




