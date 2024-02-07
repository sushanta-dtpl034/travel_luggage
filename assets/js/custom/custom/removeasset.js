
$(function () {

    $("#company_location,#assetman_supervisor,#asstman_incharge,#assetment_condition,#assetman_cat,#assetment_subcat").select2({
        dropdownParent: $('#assetadd_model .modal-content'),
        width: '100%',
        placeholder: "Choose one",
    });
    $("#Measurements").change(function () {

        $("#set_mesur_val").html($("#Measurements option:selected").text());

    });

    var input1 = document.getElementById('current_location');
    var autocomplete = new google.maps.places.Autocomplete(input1);

    var input2 = document.getElementById('update_current_location');
    var autocomplete1 = new google.maps.places.Autocomplete(input2);


    var service = $('#removeasset_table').DataTable({
		"processing": true,
		"serverSide": false,
		"order": [[ 0, "asc" ]],
        // "stateSave": true,

       

        //dom: 'Bfrtip',
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
            "url": base_url + "Assetmanagement/getremovedasset_list",
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
                    return '<button class="btn btn-sm view_asset bg-success" id="' + row.AutoID + '"  datatype="edit"><i class="si si-eye"></i></button>';
                 }else{
                    return '<button class="btn btn-sm  view_asset bg-success" id="' + row.AutoID + '"  datatype="edit"><i class="si si-eye"></i></button>';
                 }
                
                


                

            }
        },



        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });
});
    // service.column(5).visible(false);

    ///////////////import excel add asset

   

    

   

 
   

    $("#removeasset_table").on('click', '.view_asset ', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'Assetmanagement/getoneasset',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 1) {
                    $('#addassetview_form').trigger("reset");
                    $("#view_picture").empty();
                    $("#view_vendor").empty();
                    $("#view_waranty").empty();
                    $('#assetview_model').modal('show');
                    $('#view_assetownerid').val(response.data.AssetOwner);
                    $('#view_assettype').val(response.data.AsseTypeName);
                    $('#vew_assetcat').val(response.data.AsseCatName);
                    $('#view_assetsubcat').val(response.data.AssetSubcatName);
                    $('#view_assetUIN').val(response.data.UIN);
                    $('#viewasset_purchaseprice').val(response.data.PurchasePrice);
                    $('#viewasset_purchasedon').val(response.data.PurchaseDate);
                    $('#view_validtill').val(response.data.ValidTil);
                    $('#view_vendorname').val(response.data.VendorName);
                    $('#view_vendoremail').val(response.data.VendorEmail);
                    $('#view_vendormobile').val(response.data.VendorMobile);
                    $('#view_vendoraddress').val(response.data.VendorAddress);
                    $('#viewasset_dimenson').val(response.data.DimensionOfAsset);
                    $('#view_depreciationrate').val(response.data.DepreciationRate);
                    $('#view_assetmentcondition').val(response.data.ConditionName);
                    $('#view_assetauditorname').val(response.data.auditor);
                    $('#view_asstmaninchargename').val(response.data.incharge);
                    $('#view_assetsupervisorname').val(response.data.supervisor);
                    $('#view_currency_type').val(response.data.CurrencyType).change();

                    // console.log(Warrantyselect);
                    $('#view_warrantly_covered_for').empty();
                    var Warrantyselect = JSON.parse(response.data.Warrantyselect);
                    for (let i = 0; i < Warrantyselect.length; i++) {
                        $('#view_warrantly_covered_for').append(`<option value="${Warrantyselect[i]['AutoID']}">${Warrantyselect[i]['WarrantyTypeName']}</option>`);
                    }
                    var war_datas = response.data.WarrantyCoverdid;
                    war_arr = war_datas.split(",");

                    var Measurement = JSON.parse(response.data.measurementselect);
                    $('#view_set_mesur_val').html(Measurement[0]['UomName']);

                    $('#view_warrantly_covered_for').val(war_arr).change();
                    $("#view_warrantly_covered_for").select2({
                        disabled: 'readonly'
                    });
                    // $('#view_warrantly_covered_for').val(response.data.WarrantyCoverdname);
                    $('#view_insurance_valid_upto').val(response.data.InsuranceValidUpto);
                    $('#view_warranty_contact_mobile').val(response.data.WarrantyContactPersonMobile);
                    $('#view_warranty_contact_email').val(response.data.WarrantyContactPersonEmail);

                    $('#view_assettitle').val(response.data.AssetTitle);
                    $('#view_assetqty').val(response.data.AssetQuantity);
                    // $('#update_assetqty').val(response.data.AssetQuantity);

                    $('#view_company_location').val(response.data.Location).change();
                    $('#view_current_location').val(response.data.CurrentLocation);

                    var picture = response.data.Picture.split(",");

                    $.each(picture, function (i, value) {
                        if (value) {
                            var picture_array = value.split(".");
                            var data = "";
                            if (picture_array[1] == 'pdf') {
                                data = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a href='" + base_url + "upload/asset/" + value + "'>" + value + "'</a>";
                            } else {
                                data = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><img class='img-responsive' src='" + base_url + "upload/asset/" + value + "'  width='150' height='150'>";
                            }
                            $("#view_picture").append(data);
                        }
                    });

                    var vendor = response.data.VendorBill.split(",");
                    $.each(vendor, function (i, value) {
                        if (value) {
                            var ven_array = value.split(".");
                            var data1 = "";
                            if (ven_array[1] == 'pdf') {
                                data1 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='" + base_url + "upload/asset/" + value + "'>" + value + "'</li>";
                            } else {
                                data1 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><img class='img-responsive' src='" + base_url + "upload/asset/" + value + "' width='150' height='150'></li>";
                            }
                            $("#view_vendor").append(data1);
                        }
                    });


                    var waranty = response.data.WarrantyCard.split(",");
                    $.each(waranty, function (i, value) {
                        if (value) {

                            var waranty_array = value.split(".");
                            var data2 = "";
                            if (waranty_array[1] == 'pdf') {
                                data2 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='" + base_url + "upload/asset/" + value + "'>" + value + "'</li>";
                            } else {
                                data2 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><img class='img-responsive' src='" + base_url + "upload/asset/" + value + "' width='150' height='150'></li>";
                            }
                            $("#view_waranty").append(data2);
                        }
                    });

                    var table = '<table class="table table-bordered border-t0 key-buttons text-nowrap w-100"><thead><th>S.NO</th><th>TYPE</th><th>BY</th><th>DATE</th></thead><tbody>';
                    var obj = $.parseJSON(response.data.his);
                    i = 0;
                    $("#assest_his").empty();
                    if (obj.length > 0) {
                        $.each(obj, function () {
                            i++;
                            var typename = "";
                            if (this['type'] == 1) {
                                typename = "<span class='badge bg-success text-white rounded-pill' style='width:130px;'>Verified</span>";
                            } else {
                                typename = "<span class='badge bg-primary text-white rounded-pill' style='width:130px;'>Removed</span>";
                            }
                            table += '<tr><td>' + i + '</td><td>' + typename + '</td><td>' + this['Name'] + '</td><td>' + this['VRemoveDate'] + '</td></tr>';
                        });
                        table += '</tbody></table>';
                        $("#assest_his").append(table);
                    }

                    
                    var depre_table = '<p class="mg-b-10">Depreciation Rate History</p><br><table class="table table-bordered border-t0 key-buttons text-nowrap w-100"><thead><th>S.NO</th><th>Period</th><th>price</th></thead><tbody>';
                    var obj1 = response.data.dep_his;
                    k = 0;
                    $("#dep-his").empty();
                    $.each(obj1, function () {
                        k++;
                        depre_table += '<tr><td>' + k + '</td><td>' + this['period'] + '</td><td>' + this['price'] + '</td></tr>';
                    });
                    depre_table += '</tbody></table>';
                    $("#dep-his").append(depre_table);

                    var attable = '<p class="mg-b-10">Asset Transfer History</p><br><table class="table table-bordered border-t0 key-buttons text-nowrap w-100"><thead><th>S.NO</th><th>TYPE</th><th>FROM</th><th>TO</th><th>TRANSFER BY</th><th>TRANSFER DATE TIME</th></thead><tbody>';
                    var atd = $.parseJSON(response.data.AssetTransferDetails);
                    i = 0;
                    $("#assettransfer-his").empty();
                    if (atd.length > 0) {
                        $.each(atd, function () {
                            i++;
                            var typename = "";
                            if (this['Type'] == 1) {
                                typename = "<span class='badge bg-success text-white rounded-pill' style='width:130px;'>Company to Company</span>";
                            } else {
                                typename = "<span class='badge bg-primary text-white rounded-pill' style='width:130px;'>User to User</span>";
                            }

                            var fromname = "";
                            if (this['fromcompany']!='' && this['fromcompany']!=null) {
                                fromname =  this['fromcompany']
                            } else{
                                fromname =  this['fromuser']
                            } 

                            var toname = "";
                            if (this['tocompany']!='' && this['tocompany']!=null) {
                                toname =  this['tocompany']
                            } else{
                                toname =  this['touser']
                            } 

                            
                            attable += '<tr><td>' + i + '</td><td>' + typename + '</td><td>' +fromname+ '</td><td>' +toname+ '</td><td>' + this['Transferby'] + '</td><td>' + this['TransferDatetime'] + '</td></tr>';
                        });
                        attable += '</tbody></table>';
                        $("#assettransfer-his").append(attable);
                    }

                    


                    


                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    
   












   

    

   




    

    

   

   


















