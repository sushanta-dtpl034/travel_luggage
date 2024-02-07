$( function() {

    $("#from_company,#to_company,#from_user,#to_user").select2({
        dropdownParent: $('#assettransfermodel .modal-content'),
        width: '100%',
        placeholder: "Choose one",
    });

	var table = $('#assettransfer_table').DataTable( {
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
			"url": base_url+"Asset/getAssettranferdetails",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "urn"},
            {
                "render": function (data, type, row, meta) {
                    if (row.Type==1) {
                        return '<span class="badge bg-success text-white rounded-pill px-3 badgewidth">Company to Company</span>';
                    } else{
                        return '<span class="badge bg-primary text-white rounded-pill px-3 badgewidth">User to User</span>';
                    } 
                }
            },
            {
                "render": function (data, type, row, meta) {
                    if (row.fromcompany!='' && row.fromcompany!=null) {
                        return row.fromcompany
                    } else{
                        return row.fromuser
                    } 
                }
            },
            // { "data": "fromcompany"},
            {
                "render": function (data, type, row, meta) {
                    if (row.tocompany!='' && row.tocompany!=null) {
                        return row.tocompany
                    } else{
                        return row.touser
                    } 
                }
            },
            { "data": "Transferby"},
            { "data": "TransferDatetime"}

			
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
		}
		
	} );


    $("#assettransfer_button").click(function(){
        if($('#assettransferform').parsley().validate())
         {

            var transfertype = $('#transfertype').val();
            if(transfertype==1){
                var fromcompany = $('#from_company').val();
                var to_company = $('#to_company').val();
                var asset_urn = $('#asset_urn').val();
                var status = "";
                if(fromcompany!='' && to_company!="" && asset_urn!=''){
                    status = 1;
                    if(fromcompany==to_company){
                      status = "";
                    }
                }else{
                    status = 3;
                }
               
               

            }else{
                var from_user = $('#from_user').val();
                var to_user = $('#to_user').val();
                var asseturn_user = $('#asseturn_user').val();
                var status = "";
                if(from_user!='' && to_user!="" && asseturn_user!=''){
                    status = 1;
                    if(from_user==to_user){
                        status ="";
                     }
                 }else{
                    status = 3;
                }

            }
            if(status==3){
                alert("Please select all mandatory fields");
                return false;
            }
            if(status==''){
                alert("From & to data cannot be empty or same");
                return false;
            }
                 $.ajax({
                     url : base_url+'Asset/assettransfer_save',
                     type: "POST",
                     data : $("#assettransferform").serialize(),
                     success: function(result)
                     {          
                           
                         var jsonData = JSON.parse(result);
                        
                             if(jsonData.status==1){
                               $('#assettransfermodel').modal('toggle');
                               $('.insert').show();
                                $('#assettransfermodel').trigger("reset");
                        setInterval(function(){
                                 $('.insert').hide();
                                table.ajax.reload();
                                location.href=base_url+'Asset/assetransfer_list';
                             },2000);
                         }else{
                            $('#currencymodel').modal('toggle');
                              $('.alert-solid-warning').show();
                              setInterval(function(){ 
                                $('.alert-solid-warning').hide();
                                table.ajax.reload();
                                location.href=base_url+'Asset/assetransfer_list';
                                },2000);
                         }
                     },
                   
                 });
         }
    
    }); 

	
});


  





function getval(e){
    var transfertype = e.value;
    if(transfertype==1){
      $('#company').show();
      $('#tocompany').show();
      $('#users').hide();
      $('#urnlist').show();
      
    }else{
        $('#company').hide();
        $('#tocompany').hide();
        $('#users').show();
        $('#urnlist').hide();
    }
}

$('#from_company').on('change', function () {
    var ownerid = this.value;
    var ownerType = $('#transfertype').val();
    $('#asset_urn').empty();
    $.ajax({
        url: base_url + 'Asset/get_asseturn',
        type: "POST",
        dataType: "JSON",
        data: {
            id: ownerid,
            ownerType: ownerType
        },
        success: function (result) {
                $('#asset_urn').append(`<option value="">Select</option>`);
                for (let i = 0; i < result.length; ++i) {
                    $('#asset_urn').append(`<option value="${result[i]['AutoID']}">${result[i]['UniqueRefNumber']+' - '+result[i]['AssetTitle']}</option>`);
                }
                $('#asset_urn').selectpicker('refresh');

        },
        error: function () {

        }
    });
});

$('#from_user').on('change', function () {

   
    var ownerid = this.value;
    var ownerType = $('#transfertype').val();
    $('#asseturn_user').empty();
    $.ajax({
        url: base_url + 'Asset/get_asseturn',
        type: "POST",
        dataType: "JSON",
        data: {
            id: ownerid,
            ownerType: ownerType
        },
        success: function (result) {
                $('#asseturn_user').append(`<option value="">Select</option>`);
                for (let i = 0; i < result.length; ++i) {
                    $('#asseturn_user').append(`<option value="${result[i]['AutoID']}">${result[i]['UniqueRefNumber']+' - '+result[i]['AssetTitle']}</option>`);
                }
                $('#asseturn_user').selectpicker('refresh');

        },
        error: function () {

        }
    });
});



  
