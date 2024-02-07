$( function() {

	var table = $('#project_table').DataTable( {
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
			"url": base_url+"Masters/getactiveproject",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "ProjectName"},
            { "data": "ProjectID"},
            {  "render": function ( AutoID, type, row, meta ) {
                if(row.IsActive==1){
                    return '<p class="text-success small mb-0 mt-1 tx-12">Active</p>';
                }else{
                    return '<p class="text-danger small mb-0 mt-1 tx-12">Inactive</p>';
                }
              }
            },
			{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn update_project bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple projectdelete btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
		}
		
	} );

	/* save the material condiotn */







 $("#project_button").click(function(){
    if($('#projectform').parsley().validate())
     {

         $.ajax({
                 url : base_url+'Masters/projects_save',
                 type: "POST",
                 data : $("#projectform").serialize(),
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#projectmodel .btn-secondary").click()
                         $('.insert').show();
       					 $('#projectform').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            table.ajax.reload();
                            location.href=base_url+'Masters/projects_list';
                         },2000);
                     }else{
						$("#materialmodal .btn-secondary").click()
						 $('#material_form').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            table.ajax.reload();
                            location.href=base_url+'Masters/projects_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#project_table").on('click', '.update_project', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Masters/getoneproject',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){

            	$('#up_projectmodel').modal('show');  
				$('#up_projectname').val(response.data.project_name);
                $('#up_projectid').val(response.data.project_id);
                $('#up_contactmobileno').val(response.data.contact_no);
                $('#up_managername').val(response.data.mangername);
                $('#up_manageremail').val(response.data.mangeremail);
				$('#updateid').val(response.data.id);
                if(response.data.active==1){
                    $('#upproject_active').prop('checked', true); // Checks it
                 }else{
                    $('#upproject_active').prop('checked', false); // Unchecks it
                 }
           }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#update_project").click(function(){
    if($('#up_projectform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Masters/updateproject',
                 type: "POST",
                 data : $("#up_projectform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_projectmodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Masters/projects_list';
                            },2000);
                     }else{
                         $('#up_projectmodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Masters/projects_list';
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
				location.href= base_url+'Masters/projects_list';
                table.ajax.reload();
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

});

$( function() {

    var section_table = $('#section_table').DataTable( {
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
			"url": base_url+"Masters/getsection",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "SectionName"},
            { 
                "render": function ( AutoID, type, row, meta ) {
                    if(row.Colors==1){
                        return '<p style="color:red;">Red</p>';
                    }else if(row.Colors==2){
                        return '<p style="color:green;">Green</p>';
                    }else if(row.Colors==3){
                        return '<p style="color:blue;">Blue</p>';
                    }else if(row.Colors==4){
                        return '<p style="color:orange;">Orange</p>';
                    }else if(row.Colors==5){
                        return '<p style="color:pink;">Pink</p>';
                    }else if(row.Colors==6){
                        return '<p style="color:purple;">Purple</p>';
                    }else if(row.Colors==8){
                        return '<p style="color:brown;">Brown</p>';
                    }else if(row.Colors==9){
                        return '<p style="color:magenta;">Magenta</p>';
                    }else if(row.Colors==10){
                        return '<p style="color:white;">White</p>';
                    }else{
                        return '';
                    }
                        
                    
                  }
            },
			{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn update_section bg-success" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple delete_section btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );


    $("#section_button").click(function(){

        if($('#sectionform').parsley().validate())
        {

            $.ajax({
                    url : base_url+'Masters/section_save',
                    type: "POST",
                    data : $("#sectionform").serialize(),
                    success: function(result)
                    {
                       var jsonData = JSON.parse(result);
                            if(jsonData.status===1){
                           $("#sectionmodel .btn-secondary").click()
                            $('.insert').show();
                               $('#sectionform').trigger("reset");
                       setInterval(function(){
                                $('.insert').hide();
                               //  table.ajax.reload();
                               location.href=base_url+'Masters/section_list';
                            },2000);
                        }else{
                           $("#sectionmodel .btn-secondary").click()
                            $('#sectionform').trigger("reset");
                            $('.alert-solid-warning').show();
                             setInterval(function(){ 
                               $('.alert-solid-warning').hide();
                               // table.ajax.reload();
                               location.href=base_url+'Masters/section_list';
                               },2000);
                        }
                    },
                  
                });
        }
        
    
    }); 

    
$("#section_table").on('click', '.update_section', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Masters/getonesection',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_sectionmodel').modal('show');  
				$('#up_section_name').val(response.data.section_name);
                $('#up_colors').val(response.data.colors);
				$('#updateid').val(response.data.id);
           }else{
             alert("Invalid ID.");
           }
        }
     });

});

$("#update_section").click(function(){
    if($('#up_sectionform').parsley().validate())
     {
     
         $.ajax({
                 url : base_url+'Masters/updatesection',
                 type: "POST",
                 data : $("#up_sectionform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_sectionmodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Masters/section_list';
                            },2000);
                     }else{
                         $('#up_sectionmodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Masters/section_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 


$('#section_table').on('click','.delete_section',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Masters/deletesection',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
				location.href= base_url+'Masters/section_list';
                section_table.ajax.reload();
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });



    

} );


$(".stage_add").click(function(){
   
    var numItems = $('.stage').length;
    numItems++;
    var row = numItems-1;
    markup ="<div class='col-lg-9 stage_"+numItems+"'>";
    markup += "<div class='input-group mb-3'>";
    markup += "<span class='input-group-text stage_label' id='basic-addon1'>Stage-"+numItems+"</span>";
    markup += "<input aria-describedby='basic-addon1'  class='form-control stage' placeholder='Description' name='description[]' type='text'>";
    markup += "</div>";
    markup += "</div>";
    markup += "<div class='col-lg-2 stage_"+numItems+"'>";
    markup += "<div class='input-group mb-3'>";
    markup += "<input aria-describedby='basic-addon1' aria-label='Username' class='form-control' placeholder='Days' name='days[]' type='text'>";
    markup += "</div>";
    markup += "</div>";
    markup += "<div class='col-lg-1 stage_"+numItems+"'>";
    markup += "<button type='button' class='btn btn-primary  btn-icon-text statge_remove' id='"+numItems+"' onclick='stage_remove("+numItems+")'>";
    markup += "<i class='si si-minus'></i>";
    markup += "</button>";
    markup += "</div>";
    $('.stage_list').append(markup); 


  });


  function stage_remove(id){
    var remove_id = id;
    $(".stage_"+remove_id).remove();
    var currentlength = $('.stage').length;
    --currentlength;
    for (i = 0; i<currentlength; ++i) {
        label_value = i + 2;
        $(".stage_label:eq("+i+")").html("Stage-"+label_value);
      }
       
  }

  




