
$(function () {

    var service = $('#allocateasset_table').DataTable({
        "processing": true,
        "serverSide": true,
       // "stateSave": true,
        "order": [
            [0, "asc"]
        ],

        // dom: 'Bfrtip',
        buttons: [

            // {
            //     extend: 'excelHtml5',
            //     title: 'Assets List',
            //     text: '<i class="fa fa-files-o"></i> Excel Export',

            //     exportOptions: {
            //         columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,12,13,14]
            //     }

            // },
            // {
            //     extend: 'pdfHtml5',
            //     exportOptions: {
            //         columns: [0, 1, 2]
            //     }
            // },

        ],
        "ajax": {
            "url": base_url + "Assetmanagement/assetlist",
            "type": "POST",

        },
        "columns": [{
            "render": function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            "data": "UniqueRefNumber"
        },
        {
            "data": "CompanyName"
        },
        {
            "data": "Location"
        },
        {
            "data": "AssetTitle"
        },
        {
            "data": "AsseCatName"
        },
        {
            "data": "AssetSubcatName"
        },

        {
            "data": "UIN"
        },

		{
            "data": "date",
			'visible': false,
        },
		{
            "data": "CurrencyCode",
			'visible': false,
        },
		{
            "data": "PurchasePrice",
			'visible': false,
        },
        {
            "render": function (AutoID, type, row, meta) {
                if (row.isVerify == 1 && row.isRemove != 1) {
                    return '<span class="badge bg-success text-white rounded-pill px-3">Verified</span>';
                } else if (row.isRemove == 1 && row.isVerify == 1) {
                    return '<span class="badge bg-danger text-white rounded-pill px-3">Removed</span>';
                } else if (row.isVerify != 1) {
                    return '<span class="badge bg-warning text-white rounded-pill px-3">Pending</span>';
                }
            }
        },
        {
            "data": "VerificationDate"
        },
        {
            "data": "CreatedBy"
        },
        {
            "data": "User"
        },
        {
            "data": "Auditor"
        },
        {
            "data": "Supervisor"
        },
        {
            "render": function (AutoID, type, row, meta) {
                // if(row.isVerify==1 && userrole==2){
                //     return '<button class="btn print_qr bg-secondary" data-id="'+row.AutoID+'"  datatype="edit"><i class="si si-printer"></i></button> <button class="btn view_asset bg-success" id="'+row.AutoID+'"  datatype="edit"><i class="si si-eye"></i></button> <button class="btn update_asset bg-info" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button>';
                // }
                // else if(row.isVerify==1 && userrole!=2){
                //     return '<button class="btn print_qr bg-secondary" data-id="'+row.AutoID+'"  datatype="edit"><i class="si si-printer"></i></button> <button class="btn view_asset bg-success" id="'+row.AutoID+'"  datatype="edit"><i class="si si-eye"></i></button> ';
                // }
                // else if(row.isVerify!=1){
                //     return '<button class="btn print_qr bg-secondary" data-id="'+row.AutoID+'"  datatype="edit"><i class="si si-printer"></i></button> <button class="btn view_asset bg-success" id="'+row.AutoID+'"  datatype="edit"><i class="si si-eye"></i></button><button class="btn update_asset bg-info" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button> ';
                // }
                // console.log(meta.settings.json.role);
                var url = base_url + "Assetmanagement/ViewAssetDetails?ref_no=" + row.UniqueRefNumber + "&type=1";
                // var role=meta.settings.json.role;
                // var veryfybtn='';

                // if(role=='auditor' && row.isVerify!=1){
                //     var veryfybtn='<a href="'+url+'"><button class="btn bg-danger"datatype="edit"><i class="si si-check"></i></button></a>';
                // }
                // else if(row.isVerify==1 && row.isRemove!=1){
                //     var veryfybtn='<a href="'+url+'"><button class="btn bg-danger"datatype="edit"><i class="si si-check"></i></button></a>';
                // }

                 if(usergroupid==4){
                    return '<button class="btn bg-secondary btn-sm" data-id="' + row.AutoID + '"  datatype="print"  onclick="printAssetQrcode(' + row.AutoID + ')"><i class="fa fa-qrcode fa-lg" aria-hidden="true"></i></button> <button class="btn view_asset bg-success" id="' + row.AutoID + '"  datatype="edit"><i class="si si-eye"></i></button><a href="' + url + '"><button class="btn bg-warning"datatype="edit"><i class="si si-check"></i></button></a>';
                 }else{
                    return '<button class="btn view_allocateasset bg-info btn-sm" id="' + row.AutoID + '"  datatype="edit"><i class="mdi mdi-account-settings-variant"></i></button>';
                 }
                
                


                

            }
        },



        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });
   
 


    $("#allocateasset_table").on('click', '.view_allocateasset', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'Assetmanagement/getoneasset',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status == 1) {
                    $('#assetallocate_form').trigger("reset");
                    $("#view_picture").empty();
                    $("#view_vendor").empty();
                    $("#view_waranty").empty();
                    $('#assetallocateview_model').modal('show');
                    $('#viewallocate_urn').val(response.data.UniqueRefNumber);
                    $('#updateid').val(response.data.Assetid);
                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });

    $("#allocateadd_button").click(function () {
        if ($('#assetallocate_form').parsley().validate()) {

            $.ajax({
                    url : base_url+'Assetmanagement/allocate_save',
                    type: "POST",
                    data : $("#assetallocate_form").serialize(),
                    success: function(result)
                    {          
                          
                        var jsonData = JSON.parse(result);
                       
                        if(jsonData.status==1){
                            $("#assetallocateview_model .btn-secondary").click();
                            $('.insert').show();
                            service.ajax.reload();
                            setInterval(function () {
                                $('.insert').hide();
                                //  $('#addasset_button').show();
                                //  service.ajax.reload();
                                // location.href=base_url+'Assetmanagement/assetform_list';
                            }, 3000);

                        }else{

                            $("#assetallocateview_model").modal('hide');
                            //  $('#assetform').trigger("reset");
                            $('.alert-solid-warning').show();
                            setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Assetmanagement/allocateasset_list';
                            }, 2000);
                           
                        }
                    },
                  
                });
        }
    });


   
});



































