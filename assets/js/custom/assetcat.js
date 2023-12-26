$( function() {

	var service = $('#assetcat_table').DataTable( {
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
			"url": base_url+"Asset/getassetcat",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                { "data": "AsseTypeName"},
                { "data": "AsseCatName"},
               
           	{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn btn-sm update_assetcat bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_assetcat btn-danger" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */







 $("#assetcat_button").click(function(){

    
    if($('#asstcat_form').parsley().validate())
     {

            var cd = new FormData();
            var files = $('#assetcat_image')[0].files;

            if(files.length > 0 ){
                cd.append('assetcat_image',files[0]);
            }else{
              alert("Please select a file.");
            }

            var asset_type =  $('#asset_type').val();
            var asset_cat =  $('#assetcat_name').val();
            cd.append('asset_type',asset_type);
            cd.append('assetcat_name',asset_cat);
            
         $.ajax({
                 url : base_url+'Asset/assetcat_save',
                 type: "POST",
                 contentType: false,
                 processData: false,
                 data : cd,
                beforeSend: function() {
                  $('.load-assetcat').show();
                  $('#assetcat_button').hide();
                },
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#asstcat_model .btn-secondary").click();
                         $('.insert').show();
       					 $('#asstcat_form').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                            location.href=base_url+'Asset/assetcat_list';
                         },2000);
                     }else{
						$("#asstcat_model .btn-secondary").click();
						 $('#assetform').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href=base_url+'Asset/assetcat_list';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#assetcat_table").on('click', '.update_assetcat', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: base_url+'Asset/getoneassetcat',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
            	$('#up_asstcatmodel').modal('show');  
				$('#up_assetcatname').val(response.data.AsseCatName);
                $('#up_assettype').val(response.data.AssetType);
             	$('#updateid').val(response.data.id);
                 $('#old_catimg').val(response.data.AssetCatIMG);
                $('#update_catimg').attr('src', base_url+"upload/asset_cat/"+response.data.AssetCatIMG);
               
          }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#up_assetcatbut").click(function(){
    if($('#up_asstcatform').parsley().validate())
     {

         var update_cat = new FormData();
        var cat = $('#updatecat_file')[0].files;

        if(cat.length > 0 ){
          update_cat.append('updatecat_file',cat[0]);
        }
 
        var asset_type =  $('#up_assettype').val();
        var asset_cat =  $('#up_assetcatname').val();
        var old_imag =  $('#old_catimg').val();
        var updateid =  $('#updateid').val();
        update_cat.append('up_assetcatname',asset_cat);
        update_cat.append('up_assettype',asset_type);
        update_cat.append('old_catimg',old_imag);
        update_cat.append('updateid',updateid);
        
        
        
         $.ajax({
                 url : base_url+'Asset/update_assetcat',
                 type: "POST",
                contentType: false,
                processData: false,
                 data : update_cat,
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#up_asstcatmodel').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href=base_url+'Asset/assetcat_list';
                            },2000);
                     }else{
                         $('#up_asstcatmodel').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href=base_url+'Asset/assetcat_list';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#assetcat_table').on('click','.delete_assetcat',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Asset/delete_assetcat',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
                swal("Deleted!", "Deleted Successfully", "success");
                setInterval(function () {
                    location.href= base_url+'Asset/assetcat_list';
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
            $('.catimage-update').attr('src', e.target.result);
            }


            }
            reader.readAsDataURL(input.files[0]);

            
    }


    $(".cat-fileupload").on('change', function(){
       readURL(this);
    });

    $(".upload-button").on('click', function() {
          $(".cat-fileupload").click();
        });

});

$("#catimp_button").click(function(){
    if($('#import_catform').parsley().validate()){

        var catfile_data = new FormData();
        var import_file = $('#cat_file')[0].files;

        if(import_file.length > 0 ){
            catfile_data.append('cat_file',import_file[0]);
        }

        $.ajax({
            url : base_url+'Asset/cat_import',
            type: "POST",
            contentType: false,
            processData: false,
            data : catfile_data,
            success: function(result){
                var jsonData = JSON.parse(result);
                if(jsonData.status===1){
                    $('#catimport').modal('hide');
                    $('#import_catform').trigger("reset");
                    $('.insert').show();
                    setInterval(function(){
                         $('.insert').hide();
                        //  table.ajax.reload();
                        location.href=base_url+'Asset/assetcat_list';
                    },2000);
                 }else{
                    $("#catimp_button .btn-secondary").click();
                    $('.alert-solid-warning').show();
                    setInterval(function(){ 
                        $('.alert-solid-warning').hide();
                        // table.ajax.reload();
                        location.href=base_url+'Asset/assetcat_list';
                    },2000);
                }

            }
        });

    }
});                







