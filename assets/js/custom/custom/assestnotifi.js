$( function() {

	var service = $('#assetnotify_table').DataTable( {
		"processing": true,
		"serverSide": false,
        "stateSave": true,
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
			"url": base_url+"Assetmanagement/getnotification_asset",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{ "data": "UniqueRefNumber"},
                { "data": "CompanyName"},
                { "data": "UIN"},
                { "data": "AsseCatName"},
                { "data": "AssetSubcatName"},
                
                {
                    "render": function ( AutoID, type, row, meta ) {
                            if (row.daystatus=='plus') {
                                return '<span class="badge bg-warning text-white rounded-pill" style="width:100px;">'+'+'+row.days+'</span>' 
                            }else{
                               return '<span class="badge bg-danger text-white rounded-pill" style="width:100px;">'+row.days+'</span>' 
                            }
                      }
                    
                },
                { "data": "VerificationDate"},
				{ "data": "User"},
                { "data": "Auditor"},
                { "data": "Supervisor"},
                { "render": function ( AutoID, type, row, meta ) {
                     var url = base_url+"Assetmanagement/ViewAssetDetails?ref_no="+row.UniqueRefNumber+"&type=1";
                     return '<a href="'+url+'"><button class="btn bg-info btn-sm" data-id="'+row.AutoID+'"  datatype="edit">Verify Now</button></a>';
                  }
                }
          
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	});



});