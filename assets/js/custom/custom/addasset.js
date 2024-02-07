
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

    var pendingstatus ='';
    $('#asset-filter-data').on('change', function(){
        pendingstatus = $(this).val();
        $(`#asset_table`).DataTable().ajax.reload(); 
        
    });


    var service = $('#asset_table').DataTable({
        "processing": true,
        "serverSide": true,
        // "stateSave": true,
        "order": [
            [0, "asc"]
        ],
        
        // "stateSave": true,

       

        //dom: 'Bfrtip',
        "dom": 'lrtip',
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
            data: function (d) {
                d.pendingstatus = pendingstatus;
            },	
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
                    return '<button class="btn btn-sm view_asset bg-success" id="' + row.AutoID + '"  datatype="edit"><i class="si si-eye"></i></button><a href="' + url + '"><button class="btn btn-sm bg-warning"datatype="edit"><i class="si si-check"></i></button></a>';
                 }else{
                    return '<!--<button class="btn btn-sm print_qr bg-secondary mx-2" data-id="' + row.AutoID + '"  datatype="edit"><i class="si si-printer"></i></button>--><button class="btn btn-sm  bg-secondary" data-id="' + row.AutoID + '"  datatype="print"  onclick="printAssetQrcode(' + row.AutoID + ')"><i class="fa fa-qrcode fa-lg" aria-hidden="true"></i></button> <button class="btn btn-sm  view_asset bg-success" id="' + row.AutoID + '"  datatype="edit"><i class="si si-eye"></i></button> <button class="btn btn-sm  update_asset bg-info" id="' + row.AutoID + '"  datatype="edit"><i class="si si-pencil"></i></button> <a href="' + url + '"><button class="btn btn-sm  bg-warning"datatype="edit"><i class="si si-check"></i></button></a>';
                 }
                
                


                

            }
        },



        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });
 
    // service.column(5).visible(false);

    ///////////////import excel add asset

    $("#assetadd_btn").click(function () {
        addFileupload();
        $('#assetadd_model').modal('show');
    });

    $(".assetimport").click(function () {
        $('#assetimport_modal').modal('show');
        $('#asset_importform')[0].reset();
    });
    $('#searchInput').on('keyup  change', function () {
        service.search(this.value).draw();
    });
  

    $("#assetimp_button").click(function () {
        if ($('#asset_importform').parsley().validate()) {

            var assetfile_data = new FormData();
            var import_file = $('#asset_file')[0].files;

            if (import_file.length > 0) {
                assetfile_data.append('asset_file', import_file[0]);
            }

            $.ajax({
                url: base_url + 'Assetmanagement/asset_import',
                type: "POST",
                contentType: false,
                processData: false,
                data: assetfile_data,
                success: function (result) {

                    // console.log(result);
                    var jsonData = JSON.parse(result);

                    if (jsonData.status === 1) {

                        $('#assetimport').modal('hide');
                        $('#asset_importform')[0].reset();
                        $("#asset_file").removeClass("parsley-success");

                        $('.insert').show();
                        service.ajax.reload();
                        $('#assetimport_modal').modal('hide');
                        setInterval(function () {
                            $('.insert').hide();

                            // location.href=base_url+'Asset/assetasset_list';
                        }, 3000);
                    } else {

                        $("#assetimp_button .  btn-secondary").click();
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Asset/assetasset_list';
                        }, 2000);
                    }

                }
            });

        }
    });

    /////////////////end import excel

    /* save the material condiotn */

    $("#printQr").click(function () {
        var printdata = document.getElementById("printTable");
        newwin = window.open("");
        newwin.document.write(printdata.outerHTML);
        newwin.print();
        newwin.close();
        // $("#qr_count").val('');
        // alert();
    });

    $("#addasset_button").click(function () {
        if ($('#addasset_form').parsley().validate()) {

            var add_asset = new FormData();
            // var assetpic_files = $('#picture')[0].files;
            // if(assetpic_files.length > 0 ){
            //     add_asset.append('picture',assetpic_files[0]);
            // }else{
            //   alert("Please select a file.");
            // }

            // var assetpic_files = document.getElementsByClassName('picture').files.length;
            // for (var index = 0; index < assetpic_files; index++) {
            //     add_asset.append("picture[]", document.getElementsByClassName('picture').files[index]);
            // }

            var count = 0;
            $.each($(".picture"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    add_asset.append('picture[' + count + ']', file);
                    count = count + 1;

                })
            });

            // var count1=0;
            // $.each($(".picturelimit"), function(i, obj) {
            //     $.each(obj.files,function(j, file){

            //         count1=count1+1;

            //     })
            // });


            var test_arr = $("input[name='picture_tile[]']");
            $.each(test_arr, function (i, item) { //i=index, item=element in array
                // myarray.push($(item).val());
                add_asset.append('picture_title[' + i + ']', $(item).val());
            });




            // var assetpic_files = document.getElementsByClassName('picture_tile').files.length;
            // for (var index = 0; index < assetpic_files; index++) {
            //     add_asset.append("picture_title[]", document.getElementsByClassName('picture_tile').files[index]);
            // }


            var totalfiles = document.getElementById('bill').files.length;
            for (var index = 0; index < totalfiles; index++) {
                add_asset.append("bill[]", document.getElementById('bill').files[index]);
            }

            var totalfiles1 = document.getElementById('warranty').files.length;
            for (var index1 = 0; index1 < totalfiles1; index1++) {
                add_asset.append("warranty[]", document.getElementById('warranty').files[index1]);
            }

            var assetman_type = $('#assetman_type').val();
            add_asset.append('assetman_type', assetman_type);
            var vendor_email = $('#vendor_email').val();
            add_asset.append('vendor_email', vendor_email);
            var vendor_mobile = $('#vendor_mobile').val();
            add_asset.append('vendor_mobile', vendor_mobile);
            var depreciation_rate = $('#depreciation_rate').val();
            add_asset.append('depreciation_rate', depreciation_rate);

            var assetowner_id = $('#assetowner_id').val();
            add_asset.append('assetowner_id', assetowner_id);
            var assetman_cat = $('#assetman_cat').val();
            add_asset.append('assetman_cat', assetman_cat);
            var assetment_subcat = $('#assetment_subcat').val();
            add_asset.append('assetment_subcat', assetment_subcat);
            var assetment_UIN = $('#assetment_UIN').val();
            add_asset.append('assetment_UIN', assetment_UIN);
            var assetment_purchaseprice = $('#assetment_orginalprice').val();
            add_asset.append('assetment_purchaseprice', assetment_purchaseprice);
            var currency_type = $('#currency').val();
            add_asset.append('currency_type', currency_type);

            var purchased_date = $('#purchased_date').val();
            add_asset.append('purchased_date', purchased_date);
            var vendor_name = $('#vendor_name').val();
            add_asset.append('vendor_name', vendor_name);
            var vendor_address = $('#vendor_address').val();
            add_asset.append('vendor_address', vendor_address);
            var assetment_dimenson = $('#assetment_dimenson').val();
            add_asset.append('assetment_dimenson', assetment_dimenson);
            var assetment_condition = $('#assetment_condition').val();
            add_asset.append('assetment_condition', assetment_condition);
            var valid_till = $('#valid_till').val();
            add_asset.append('valid_till', valid_till);
            var assetman_auditor = $('#assetman_auditor').val();
            add_asset.append('assetman_auditor', assetman_auditor);
            var asstman_incharge = $('#asstman_incharge').val();
            add_asset.append('asstman_incharge', asstman_incharge);
            var assetman_supervisor = $('#assetman_supervisor').val();
            add_asset.append('assetman_supervisor', assetman_supervisor);

            var warrantly_covered_for = $('#warrantly_covered_for').val();
            add_asset.append('warrantly_covered_for', warrantly_covered_for);
            var insurance_valid_upto = $('#insurance_valid_upto').val();
            add_asset.append('insurance_valid_upto', insurance_valid_upto);

            var warranty_contact_mobile = $('#warranty_contact_mobile').val();
            add_asset.append('warranty_contact_mobile', warranty_contact_mobile);
            var warranty_contact_email = $('#warranty_contact_email').val();
            add_asset.append('warranty_contact_email', warranty_contact_email);

            var VerificationInterval = $('#VerificationInterval').val();
            add_asset.append('VerificationInterval', VerificationInterval);

            var asset_qty = $('#asset_qty').val();
            add_asset.append('asset_qty', asset_qty);

            var Measurements = $('#Measurements').val();
            add_asset.append('Measurements', Measurements);

            var asset_title = $('#asset_title').val();
            add_asset.append('asset_title', asset_title);


            var company_location = $('#company_location').val();
            add_asset.append('company_location', company_location);

            var current_location = $('#current_location').val();
            add_asset.append('current_location', current_location);




            $.ajax({
                url: base_url + 'Assetmanagement/addasset_save',
                type: "POST",
                contentType: false,
                processData: false,
                data: add_asset,
                beforeSend: function () {
                    $('.load-addasset').show();
                    $('#addasset_button').hide();
                },
                success: function (result) {
                    //console.log(result);

                    var jsonData = JSON.parse(result);
                    if (jsonData.status == 1) {
                        $("#assetadd_model .btn-secondary").click();
                        $('.insert').show();
                        $('#addasset_form').trigger("reset");
                        service.ajax.reload();
                        $('#addasset_form')[0].reset();
                        $('.load-addasset').hide();
                        $(".file").next(".dropify-clear").trigger("click");
                        $('#addasset_button').show();

                        setInterval(function () {
                            $('.insert').hide();
                            //  $('#addasset_button').show();
                            //  service.ajax.reload();
                            // location.href=base_url+'Assetmanagement/assetform_list';
                        }, 3000);
                    } else {
                        $("#assetadd_model").modal('hide');
                        //  $('#assetform').trigger("reset");
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Assetmanagement/assetform_list';
                        }, 2000);
                    }

                },

            });
        } else {
            $('.select2CustomErrorShow ul.parsley-errors-list ').css({ 'position': 'absolute', 'top': '68px' })
            $('.select2CustomErrorShow2 ul.parsley-errors-list ').css({ 'position': 'absolute', 'top': '35px' })
        }

    });

    $("#asset_table").on('click', '.view_asset ', function () {
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


    $("#asset_table").on('click', '.update_asset', function () {
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
                    $('#up_addassetform').parsley().reset();
                    $('#up_addassetform').trigger("reset");
                    $("#update_picture").empty();
                    $("#update_vendor").empty();
                    $("#update_waranty").empty();
                    $('#update_assetaddmodel').modal('show');
                    $('#update_assetid').val(response.data.Assetid);
                    $('#upadte_cl').val(response.data.Location_id);
                    $('#update_assetownerid').val(response.data.Assetownerid).change();

                    $('#update_assetowner').val(response.data.AssetOwner);
                    $('#update_assettype').val(response.data.AssetType);
                    $('#up_assetmancat').val(response.data.AssetCat).change();

                    $('#up_assetmentsubcat').val(response.data.AssetSubcat).change();
                    $('#up_assetmentsubcat_hidden').val(response.data.AssetSubcat);
                    $('#update_assetmentUIN').val(response.data.UIN);
                    $('#update_currency').val(response.data.CurrencyType).trigger('change');
                    $('#update_assetorginalprice').val(response.data.PurchasePrice);
                    $('#up_assetpurchaseprice').val(response.data.PurchasePrice);
                    $('#update_purchaseddate').val(response.data.PurchaseDate);
                    $('#update_validtill').val(response.data.ValidTil);
                    $('#update_vendorname').val(response.data.VendorName);
                    $('#update_vendoremail').val(response.data.VendorEmail);
                    $('#update_vendormobile').val(response.data.VendorMobile);
                    $('#update_vendoraddress').val(response.data.VendorAddress);
                    $('#update_assetdimenson').val(response.data.DimensionOfAsset);
                    $('#update_depreciationrate').val(response.data.DepreciationRate);
                    $('#update_assetcondition').val(response.data.AssetCondition);
                    $('#update_assetauditorid').val(response.data.auditorid).trigger('change');
                    $('#update_asstinchargeid').val(response.data.inchargeid).trigger('change');
                    $('#update_assetsupervisorid').val(response.data.supervisorid).trigger('change');
                    $('#update_assetauditorname').val(response.data.auditor);
                    $('#update_asstinchargename').val(response.data.incharge);
                    $('#update_assetsupervisorname').val(response.data.supervisor);
                    $('#update_titlestatus').val(response.data.titleStatus);
                    $('#up_insurance_valid_upto').val(response.data.InsuranceValidUpto);
                    $('#up_warranty_contact_mobile').val(response.data.WarrantyContactPersonMobile);
                    $('#up_warranty_contact_email').val(response.data.WarrantyContactPersonEmail);
                    $('#update_current_location').val(response.data.CurrentLocation);

                    $('#update_assettitle').val(response.data.AssetTitle);
                    $('#update_assetqty').val(response.data.AssetQuantity);
                    // $('#update_assetqty').val(response.data.AssetQuantity);

                    $('#update_UniqueRefNumber').val(response.data.UniqueRefNumber);
                    $('#update_UniqueRefNumber_old').val(response.data.UniqueRefNumber);




                    var picture = response.data.Picture.split(",");
                    var Pictureid = response.data.Pictureid.split(",");
                    var pic_title = response.data.pic_title.split(",");
                    $('#up_warrantly_covered_for').empty();
                    var Warrantyselect = JSON.parse(response.data.Warrantyselect);
                    for (let i = 0; i < Warrantyselect.length; ++i) {
                        $('#up_warrantly_covered_for').append(`<option value="${Warrantyselect[i]['AutoID']}">${Warrantyselect[i]['WarrantyTypeName']}</option>`);
                    }

                    var war_datas = response.data.WarrantyCoverdid;
                    war_arr = war_datas.split(",");
                    $('#up_warrantly_covered_for').val(war_arr).change();

                    $("#updatepictureupload").empty();
                    $.each(picture, function (i, value) {
                        if (value) {
                            var data = "";
                            data += "<div class='row mb-2 picturelimit' id='row_" + Pictureid[i] + "'>";
                            data += "<div class='col-sm-5'>";
                            var vendor_array = value.split(".");
                            if (vendor_array[1] == 'pdf') {
                                data += " <a href='" + base_url + "upload/asset/" + value + "' id='src_" + Pictureid[i] + "'>" + value + "</a>";
                            } else {
                                data += " <img src='" + base_url + "upload/asset/" + value + "' id='src_" + Pictureid[i] + "'  width='150' height='150'>";
                            }
                            data += "<input type='file'  name=''  class='picture form-control d-none' id='upfile_" + Pictureid[i] + "'>";
                            data += "<i class='fa fa-camera  button-aligh upupload-button' id='icon_" + Pictureid[i] + "' onclick='fileuploadshow(" + Pictureid[i] + ")'></i>";
                            data += "</div>";
                            if (response.data.titleStatus == 1) {
                                data += "<div class='col-sm-5'> <input type='text' class='form-control'  name=''  class='picture_tile' value='" + pic_title[i] + "' id='uptitle_" + Pictureid[i] + "'> </div>";
                            }
                            data += "<div class='col-sm-2 text-right'><button class='btn btn-primary btn-circle btn-sm'  type='button' onclick='updateAssestpic(" + Pictureid[i] + ")'><i class='fa fa-edit'></i></button> <button class='btn btn-danger btn-circle btn-sm remCF' name='sub' id='del1' type='button' onclick='deleteassestpic(" + Pictureid[i] + ")'><i class='fa fa-trash'></i></button></div>";
                            data += "</div>";
                            $("#updatepictureupload").append(data);
                        }
                    });

                    var vendor = response.data.VendorBill.split(",");
                    var VendorBilliid = response.data.VendorBilliid.split(",");
                    $.each(vendor, function (i, value) {
                        if (value) {
                            var filearray = value.split(".");
                            var data1 = "";
                            if (filearray[1] == 'pdf') {
                                data1 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3 upload-image-thumb' id='" + VendorBilliid[i] + "'> <a href='" + base_url + "upload/asset/" + value + "' id='" + VendorBilliid[i] + "' target='_blank'>" + value + "</a><a href='#'  id='' onclick='deletepic(" + VendorBilliid[i] + ")' class='del-icon'><i class='fa fa-trash'></i></a></li>";
                            } else {
                                data1 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3 upload-image-thumb' id='" + VendorBilliid[i] + "'> <img class='img-responsive' src='" + base_url + "upload/asset/" + value + "' id='" + VendorBilliid[i] + "'><a href='#'  id='' onclick='deletepic(" + VendorBilliid[i] + ")' class='del-icon'><i class='fa fa-trash'></i></a></li>";
                            }
                            $("#update_vendor").append(data1);
                        }
                    });
                    var waranty = response.data.WarrantyCard.split(",");
                    var WarrantyCardid = response.data.WarrantyCardid.split(",");
                    $.each(waranty, function (i, value) {
                        if (value) {
                            var filearray1 = value.split(".");
                            var data2 = "";
                            if (filearray1[1] == 'pdf') {
                                data2 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3 upload-image-thumb' id='" + WarrantyCardid[i] + "'><a href='" + base_url + "upload/asset/" + value + "' id='" + WarrantyCardid[i] + "'target='_blank'>" + value + "</a><a href='#'  id='' onclick='deletepic(" + WarrantyCardid[i] + ")' class='del-icon'><i class='fa fa-trash'></i></a></li>";
                            } else {
                                data2 = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3 upload-image-thumb' id='" + WarrantyCardid[i] + "'><img class='img-responsive' src='" + base_url + "upload/asset/" + value + "' id='" + WarrantyCardid[i] + "'><a href='#'  id='' onclick='deletepic(" + WarrantyCardid[i] + ")' class='del-icon'><i class='fa fa-trash'></i></a></li>";
                            }
                            $("#update_waranty").append(data2);
                        }
                    });
                } else {
                    alert("Invalid ID.");
                }
            }
        });
    });

    $("#updateasset_button").click(function () {
        if ($('#up_addassetform').parsley().validate()) {
            var up_asset = new FormData();
            // var assetpic_files = $('#picture')[0].files;
            // if(assetpic_files.length > 0 ){
            //     add_asset.append('picture',assetpic_files[0]);
            // }else{
            //   alert("Please select a file.");
            // }
            var count = 0;
            $.each($(".picture"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    up_asset.append('update_picture[' + count + ']', file);
                    count = count + 1;
                })
            });

            var test_arr = $("input[name='picture_tile[]']");
            $.each(test_arr, function (i, item) { //i=index, item=element in array
                // myarray.push($(item).val());
                up_asset.append('update_picturetitle[' + i + ']', $(item).val());
            });

            // var assetpic_files = document.getElementById('update_assetpicture').files.length;

            // if(assetpic_files ){
            //     for (var index = 0; index < assetpic_files; index++) {
            //         up_asset.append("update_picture[]", document.getElementById('update_assetpicture').files[index]);
            //     }

            // }else{
            //     up_asset.append("update_picture[]",'');
            // }

            var totalfiles = document.getElementById('updatebill').files.length;
            for (var index = 0; index < totalfiles; index++) {
                up_asset.append("updatebill[]", document.getElementById('updatebill').files[index]);
            }

            var totalfiles1 = document.getElementById('updatewarranty').files.length;
            for (var index1 = 0; index1 < totalfiles1; index1++) {
                up_asset.append("updatewarranty[]", document.getElementById('updatewarranty').files[index1]);
            }


            var update_assetid = $('#update_assetid').val();
            up_asset.append('update_assetid', update_assetid);

            var assetman_type = $('#update_assettype').val();
            up_asset.append('update_assettype', assetman_type);
            var vendor_email = $('#update_vendoremail').val();
            up_asset.append('update_vendoremail', vendor_email);
            var vendor_mobile = $('#update_vendormobile').val();
            up_asset.append('update_vendormobile', vendor_mobile);
            var depreciation_rate = $('#update_depreciationrate').val();
            up_asset.append('update_depreciationrate', depreciation_rate);
            var assetowner_id = $('#update_assetownerid').val();
            up_asset.append('update_assetownerid', assetowner_id);

            var assetman_cat = $('#up_assetmancat').val();
            up_asset.append('up_assetmancat', assetman_cat);
            var assetment_subcat = $('#up_assetmentsubcat').val();
            up_asset.append('up_assetmentsubcat', assetment_subcat);

            var assetment_UIN = $('#update_assetmentUIN').val();
            up_asset.append('update_assetmentUIN', assetment_UIN);
            var assetment_purchaseprice = $('#update_assetorginalprice').val();
            up_asset.append('update_assetorginalprice', assetment_purchaseprice);
            var update_currency = $('#update_currency').val();
            up_asset.append('update_currency', update_currency);

            var purchased_date = $('#update_purchaseddate').val();
            up_asset.append('update_purchaseddate', purchased_date);
            var vendor_name = $('#update_vendorname').val();
            up_asset.append('update_vendorname', vendor_name);
            var vendor_address = $('#update_vendoraddress').val();
            up_asset.append('update_vendoraddress', vendor_address);
            var assetment_dimenson = $('#update_assetdimenson').val();
            up_asset.append('update_assetdimenson', assetment_dimenson);
            var assetment_condition = $('#update_assetcondition').val();
            up_asset.append('update_assetcondition', assetment_condition);
            var valid_till = $('#update_validtill').val();
            up_asset.append('update_validtill', valid_till);
            var assetman_auditor = $('#update_assetauditorid').val();
            up_asset.append('update_assetmanauditor', assetman_auditor);
            var asstman_incharge = $('#update_asstinchargeid').val();
            up_asset.append('update_asstmanincharge', asstman_incharge);
            var assetman_supervisor = $('#update_assetsupervisorid').val();
            up_asset.append('update_assetmansupervisor', assetman_supervisor);

            var up_warrantly_covered_for = $('#up_warrantly_covered_for').val();
            up_asset.append('up_warrantly_covered_for', up_warrantly_covered_for);
            var up_insurance_valid_upto = $('#up_insurance_valid_upto').val();
            up_asset.append('up_insurance_valid_upto', up_insurance_valid_upto);
            var up_warranty_contact_mobile = $('#up_warranty_contact_mobile').val();
            up_asset.append('up_warranty_contact_mobile', up_warranty_contact_mobile);

            var up_warranty_contact_email = $('#up_warranty_contact_email').val();
            up_asset.append('up_warranty_contact_email', up_warranty_contact_email);

            var update_company_location = $('#update_company_location').val();
            up_asset.append('update_company_location', update_company_location);
            var update_current_location = $('#update_current_location').val();
            up_asset.append('update_current_location', update_current_location);

            var update_assettitle = $('#update_assettitle').val();
            up_asset.append('update_assettitle', update_assettitle);
            var update_assetqty = $('#update_assetqty').val();
            up_asset.append('update_assetqty', update_assetqty);

            var update_UniqueRefNumber = $('#update_UniqueRefNumber').val();
            up_asset.append('update_UniqueRefNumber', update_UniqueRefNumber);

            var update_UniqueRefNumber_old = $('#update_UniqueRefNumber_old').val();
            up_asset.append('update_UniqueRefNumber_old', update_UniqueRefNumber_old);

            $.ajax({
                url: base_url + 'Assetmanagement/addasset_update',
                type: "POST",
                contentType: false,
                processData: false,
                data: up_asset,
                beforeSend: function () {
                    $('.load-addasset').show();
                    $('#updateasset_button').hide();
                },
                success: function (result) {


                    var jsonData = JSON.parse(result);
                    if (jsonData.status == 1) {
                        $("#update_assetaddmodel .btn-secondary").click()
                        $('.update').show();
                        $('#up_addassetform').trigger("reset");
                        $('.load-addasset').hide();
                        $('#updateasset_button').show();
                        service.ajax.reload();
                        setInterval(function () {
                            $('.update').hide();
                            // location.href = base_url + 'Assetmanagement/assetform_list';
                        }, 2000);
                    } else {

                        $("#update_assetaddmodel .btn-secondary").click()
                        $('#up_addassetform').trigger("reset");
                        $('.alert-solid-warning').show();
                        service.ajax.reload();
                        $('.load-addasset').hide();
                        $('#updateasset_button').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            // location.href = base_url + 'Assetmanagement/assetform_list';
                        }, 2000);
                    }
                },

            });
        }

    });
});


$('#assetman_type').on('change', function () {
    var assetman_type = this.value;
    $('#assetman_cat').find('option').remove();
    $('#assetment_subcat').find('option').remove();
    $.ajax({
        url: base_url + 'Asset/get_cat_basedontypeid',
        type: "POST",
        dataType: "JSON",
        data: {
            id: assetman_type
        },
        success: function (result) {
            $('#assetman_cat').append(`<option value="">Select</option>`);
            for (let i = 0; i < result.length; ++i) {
                $('#assetman_cat').append(`<option value="${result[i]['AutoID']}">${result[i]['AsseCatName']}</option>`);
            }

        },
        error: function () {

        }
    });
});
///////////////location///////


$('#assetowner_id').on('change', function () {
    var id = $(this).val();
    $('#company_location').find('option').remove();
    $.ajax({
        url: base_url + 'Asset/get_location_bycompanyid',
        type: "POST",
        dataType: "JSON",
        data: {
            id: id
        },
        success: function (result) {
            $('#company_location').append(`<option value="">Select</option>`);
            for (let i = 0; i < result.length; ++i) {
                $('#company_location').append(`<option value="${result[i]['AutoID']}">${result[i]['Name']}</option>`);
            }
        },
        error: function () {

        }
    });
});


$('#update_assetownerid').on('change', function () {
    var cid = $("#upadte_cl").val();
    // alert(cid);
    var id = this.value;
    $('#update_company_location').find('option').remove();
    $.ajax({
        url: base_url + 'Asset/get_location_bycompanyid',
        type: "POST",
        dataType: "JSON",
        data: {
            id: id
        },
        success: function (result) {
            $('#update_company_location').append(`<option value="">Select</option>`);
            for (let i = 0; i < result.length; ++i) {
                $('#update_company_location').append(`<option value="${result[i]['AutoID']}" ${cid == result[i]['AutoID'] ? "selected" : ""} >${result[i]['Name']}</option>`);
            }
        },
        error: function () {

        }
    });

});

$("#assetman_cat").on("change", function () {
    var assetman_catid = $(this).val();
    $.ajax({
        url: base_url + 'Asset/get_subcat_basedoncatid',
        type: "POST",
        dataType: "JSON",
        data: {
            id: assetman_catid
        },
        success: function (result) {
            $('#assetment_subcat').empty();
            $('#assetment_subcat').append('<option label="Choose one" value=""></option>');
            for (let i = 0; i < result.length; ++i) {
                $('#assetment_subcat').append(`<option value="${result[i]['AutoID']}">${result[i]['AssetSubcatName']}</option>`);
            }
        },
        error: function () {

        }
    });
});



$('#assetment_subcat').on('change', function () {
    var assetman_subcatid = $(this).val();
    $.ajax({
        url: base_url + 'Asset/get_oneassetsubcat',
        type: "POST",
        dataType: "JSON",
        data: {
            id: assetman_subcatid
        },
        success: function (response) {
            $('#assetman_auditorname').val(response.data.auditorname);
            $('#asstman_inchargename').val(response.data.inchargename);
            $('#assetman_supervisorname').val(response.data.supervisorname);
            $('#assetman_auditor').val(response.data.auditor);
            $('#asstman_incharge').val(response.data.incharge);
            $('#assetman_supervisor').val(response.data.supervisor);
            $('#depreciation_rate').val(response.data.DepreciationRate);
            $('#titlestatus').val(response.data.titleStatus);
            $('#VerificationInterval').val(response.data.VerificationInterval);

            var numpic = response.data.NumberOfPicture;
            var titlestatus = response.data.titleStatus;

            var warranty = JSON.parse(response.data.warranty);
            for (let i = 0; i < warranty.length; ++i) {
                $('#warrantly_covered_for').append(`<option value="${warranty[i]['AutoID']}">${warranty[i]['WarrantyTypeName']}</option>`);
            }

            var Measurement = JSON.parse(response.data.Measurement);
            for (let i = 0; i < Measurement.length; ++i) {
                $('#Measurements').append(`<option value="${Measurement[i]['AutoID']}" data-val="${Measurement[i]['UomName']}">${Measurement[i]['UomName']}</option>`);
            }


            $("#pictureupload").empty();
            var data = "";
            for (let i = 0; i < numpic; ++i) {
                data += "<div class='row p-0 mb-2 mt-4 picturelimit' id='row_" + i + "'>";
                data += "<div class='col-sm-5'><input type='file'  name='picture[]'  class='picture form-control' accept='.png,.jpg,.jpeg' required></div>";
                if (titlestatus == 1) {
                    data += "<div class='col-sm-5'><input type='text' name='picture_tile[]'  class='picture_tile form-control' required></div>";
                }
                data += "<div class='col-sm-2 text-right'><button class='btn btn-danger btn-circle btn-sm remCF' name='sub' id='del1' type='button' onclick='removefile(" + i + ")'>-</button></div>";
                data += "</div>";
            }
            $('#pictureupload').append(data);

        },
        error: function () {

        }
    });

});



$(document).ready(function () {
    $('#purchased_date').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
    // $('#purchased_date').datepicker({

    //     autoHide: true,
    //     zIndex: 999998,

    // });

});


$(document).ready(function () {
    $(".currency").on("change", function () {
        var currency_detail = $('#currency option:selected').attr('c-data');
        var details = currency_detail.split("/");
        var currency = details[0];
        var unicode = details[1];
        var n = parseFloat($('.purchaseprice').val().replaceAll(/[^\d.]/g, ''), 10);
        $('#assetment_orginalprice').val(n);
        if (n) {
            var myObj = {
                style: "currency",
                currency: currency
            }
            $('.purchaseprice').val(n.toLocaleString(unicode, myObj));
        }
    });

    $("#assetment_purchaseprice").on('blur', function () {
        var currency_detail = $('#currency option:selected').attr('c-data');
        var details = currency_detail.split("/");
        if (currency_detail != '') {
            var currency = details[0];
            var unicode = details[1];
            var n = parseFloat($(this).val().replaceAll(/[^\d.]/g, ''), 10);
            $('#assetment_orginalprice').val(n);
            if (n) {
                var myObj = {
                    style: "currency",
                    currency: currency
                }
                $(this).val(n.toLocaleString(unicode, myObj));
            }
        } else {
            $('.currency').addClass('parsley-error');
        }
    });

    $("#up_assetpurchaseprice").on('blur', function () {
        // var currency=$(this).attr("data-currency");
        // var unicode=$(this).attr("data-unicode");
        var currency_detail = $('#update_currency option:selected').attr('c-data');
        var details = currency_detail.split("/");
        if (currency_detail != '') {
            var currency = details[0];
            var unicode = details[1];
            var n = parseFloat($(this).val().replaceAll(/[^\d.]/g, ''), 10);
            $('#update_assetorginalprice').val(n);
            if (n) {
                var myObj = {
                    style: "currency",
                    currency: currency
                }
                $(this).val(n.toLocaleString(unicode, myObj));
            }
        } else {
            $('.currency').addClass('parsley-error');
        }
    });

    $("#update_currency").on("change", function () {
        var currency_detail = $('#update_currency option:selected').attr('c-data');
        try {
            var details = currency_detail.split("/");
            var currency = details[0];
            var unicode = details[1];
        }
        catch (err) {
            console.log("Currency type is null");
        }
        var n = parseFloat($('#up_assetpurchaseprice').val().replaceAll(/[^\d.]/g, ''), 10);
        $('#update_assetorginalprice').val(n);
        if (n) {
            var myObj = {
                style: "currency",
                currency: currency
            }
            $('#up_assetpurchaseprice').val(n.toLocaleString(unicode, myObj));
        }

    });

    $('#update_assettype').on('change', function () {
        var assetman_type = this.value;
        $('#up_assetmancat').empty();
        $.ajax({
            url: base_url + 'Asset/get_cat_basedontypeid',
            type: "POST",
            dataType: "JSON",
            data: {
                id: assetman_type
            },
            success: function (result) {
                $('#up_assetmancat').append(`<option value="">Select</option>`);
                for (let i = 0; i < result.length; ++i) {
                    $('#up_assetmancat').append(`<option value="${result[i]['AutoID']}">${result[i]['AsseCatName']}</option>`);
                }

            },
            error: function () {

            }
        });

    });

    $("#up_assetmancat").on("change", function () {
        $('#up_assetmentsubcat').empty();
        $('#assetment_subcat').empty();
        var assetman_catid = $(this).val();
        $.ajax({
            url: base_url + 'Asset/get_subcat_basedoncatid',
            type: "POST",
            dataType: "JSON",
            data: {
                id: assetman_catid
            },
            success: function (result) {
                for (let i = 0; i < result.length; ++i) {
                    $('#up_assetmentsubcat').append(`<option value="${result[i]['AutoID']}">${result[i]['AssetSubcatName']}</option>`);
                }
                $('#up_assetmentsubcat').val($('#up_assetmentsubcat_hidden').val()).change();

            },
            error: function () {

            }
        });
    });



    // $('#up_assetmentsubcat').on('change', function() {

    //     var assetman_subcatid = $(this).val();
    //     // alert("test"+assetman_subcatid);

    //     $.ajax({
    //         url: base_url + 'Asset/get_oneassetsubcat',
    //         type: "POST",
    //         dataType: "JSON",
    //         data: {
    //             id: assetman_subcatid
    //         },
    //         success: function(response) {
    //             $('#update_assetauditorname').val(response.data.auditorname);
    //             $('#update_asstinchargename').val(response.data.inchargename);
    //             $('#update_assetsupervisorname').val(response.data.supervisorname);
    //             $('#update_assetmanauditor').val(response.data.auditor);
    //             $('#update_asstmanincharge').val(response.data.incharge);
    //             $('#update_assetmansupervisor').val(response.data.supervisor);
    //         },
    //         error: function() {

    //         }
    //     });

    // });

    $('#generate_button').on('click', function () {
        var code = $("#code").val();
        $.ajax({
            url: base_url + 'Assetmanagement/qrgenerate',
            type: "POST",
            dataType: "JSON",
            data: {
                code: code
            },
            success: function (response) {
                var file = response.filename;
                if (response.status == 1) {
                    $('#qrdiv').show();
                    $("#qrimage").attr("src", base_url + '/upload/qr-code/' + file);
                }
            },
            error: function () {

            }
        });

    });

    $("#asset_table").on('click', '.print_qr ', function () {
        var assmentid = $(this).attr("data-id");
        $.ajax({
            url: base_url + 'Assetmanagement/getqrcode',
            type: "POST",
            dataType: "JSON",
            data: {
                assmentid: assmentid
            },
            success: function (response) {

                $("#assetuniq").val(response.filename);
                $('#print_qr').modal('show');
                $("#printTable").find("tr").remove();
                var file = response.filename;
                if (response.status == 1) {
                    $('#qrdiv').show();
                    $("#printimage").attr("src", base_url + '/upload/qr-code/' + file + ".png");

                }
            },
            error: function () {

            }
        });



    });

    $('#print_button').on('click', function () {

        // if($('#qr_form').parsley().validate())
        // {
        $("#print_button").prop("type", "submit");
        // var count = $("#qr_count").val();
        // var src = $('#printimage').prop('src');
        // location.href = base_url+'Assetmanagement/downloadqr';



        // $.ajax({
        //     url : base_url+'Assetmanagement/downloadqr',
        //     type: "POST",
        //     dataType: "JSON",
        //     data :  {count: count,src: src},
        //     success: function(response)
        //     {

        //     },
        //     error: function ()
        //     {

        //     }
        // });

        // }    

    });

    $("#qr_count").on('keyup', function () {

        var code = $("#qr_count").val();

        if (code > 8) {

            $("#qr_count").val();
            $("#qr_count").addClass('parsley-error');
            $("#counr_valid").show();
            return false;

        } else {

            $("#qr_count").val();
            $("#qr_count").removeClass('parsley-error');

        }

        var images = $('#printimage').attr('src');

        $("#printTable").find("tr").remove();


        // if(code>4){
        //     l = 1;
        // }else{
        //     l =1;
        // }

        var html = "";
        for (var a = 0; a < 1; a++) {

            html += "<tr>";
            for (var b = 0; b < code; b++) {
                // height 94.59px , weight 189px
                html += "<td><img style='width:94px; height:94px' src='" + images + "' id='' ></td>";
                if (b == 3) {
                    html += "</tr>";
                    html += "<tr>";
                }

            }
            html += "</tr>";

        }



        $("#printTable").append(html);
    });


});
//sushanta code for print qrcode
const printAssetQrcode = (id) => {
    $('#singleAssetModal').modal('show');
    $('#qrcode_id').val(id);
    $('.printSingleQrcode').click(function () {
        let noOfCopy = $('.print_copySingle :selected').val();
        if (noOfCopy.length == 0) {
            alert('Choose No of Copy');
            return false;
        } else {
            $('#singleAssetModal').modal('hide');
        }
    });

}


//// js function 
function updateFileupload() {
    var numItems = $('.picturelimit').length;
    var currentlength = numItems + 1;
    var titlestatus = $("#update_titlestatus").val();
    data = "<div class='row p-0 mb-2 mt-4 picturelimit' id='row_" + currentlength + "'>";
    data += "<div class='col-sm-5'><input type='file'  class='picture form-control' name='picture[]'></div>";
    data += "<input type='file'  name='pictureid[]'  class='d-none' value=''>";
    if (titlestatus == 1) {
        data += "<div class='col-sm-5'><input type='text'  class='picture_tile form-control' name='picture_tile[]' ></div>";
    }
    data += "<div class='col-sm-2 text-right'><button class='btn btn-danger btn-circle btn-sm remCF' name='sub' id='del1' type='button' onclick='removefile(" + currentlength + ")'>-</button></div>";
    data += "</div>";
    $('#updatepictureupload').append(data);

}

function addFileupload() {
    var numItems = $('.picturelimit').length;
    var currentlength = numItems + 1;
    var titlestatus = $("#titlestatus").val();
    data = "<div class='row p-0 mb-2 mt-4 picturelimit' id='row_" + currentlength + "'>";
    data += "<div class='col-sm-5'><input type='file'  name='picture[]'  class='picture form-control' accept='.png,.jpg,.jpeg' required></div>";
    if (titlestatus == 1) {
        data += "<div class='col-sm-5'><input type='text' name='picture_tile[]'  class='picture_tile form-control' required></div>";
    }
    data += "<div class='col-sm-2 text-right'><button class='btn btn-danger btn-circle btn-sm remCF' name='sub' id='del1' type='button' onclick='removefile(" + currentlength + ")'>-</button></div>";
    data += "</div>";
    $('#pictureupload').append(data);
}

function removefile(id) {
    var removeid = id;
    $('#row_' + removeid).remove();
}

function fileuploadshow(id) {
    var hideid = id;
    $('#src_' + hideid).hide();
    $('#icon_' + hideid).hide();
    $('#upfile_' + hideid).removeClass('d-none');
}

function updateAssestpic(id) {
    var assestid = id;
    var assestpic = new FormData();
    var files = $('#upfile_' + assestid)[0].files;
    if (files.length > 0) {
        assestpic.append('assetpic_image', files[0]);
    }
    var pic_title = $('#uptitle_' + assestid).val();
    var asset_id = assestid;
    assestpic.append('pic_title', pic_title);
    assestpic.append('asset_id', asset_id);
    $.ajax({
        url: base_url + 'Asset/assetpic_update',
        type: "POST",
        contentType: false,
        processData: false,
        data: assestpic,
        success: function (result) {
            if (result) {
                swal("Updated!", "Updated Successfully", "success");
            } else {
                swal("Updated!", "Something wrong", "success");
            }
        },

    });

}

function deletepic(imageid) {
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        var id = imageid;
        $.ajax({
            url: base_url + 'Assetmanagement/delete_assetimg',
            type: 'post',
            data: {
                id: id
            },
            success: function (response) {
                if (response == 1) {
                    $('#' + id).remove();
                    // $('#'+id).attr('src','');
                } else {
                    alert("Invalid ID.");
                }
            }
        });

    }

}

function deleteassestpic(imageid) {
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        var id = imageid;
        $.ajax({
            url: base_url + 'Assetmanagement/delete_assetimg',
            type: 'post',
            data: {
                id: id
            },
            success: function (response) {
                if (response == 1) {
                    $('#row_' + id).remove();
                    // $('#'+id).attr('src','');
                } else {
                    alert("Invalid ID.");
                }
            }
        });
    }
}

function copyText(obj) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(obj).attr("data-value")).select();
    document.execCommand("copy");
    $temp.remove();
}




const getAssets=(id)=>{
	if(id){
		$.ajax({
			url: base_url + 'Assetmanagement/get_assets_by_location_id',
			type: 'post',
			dataType: 'json',
			cache:false,
			data: {
				location: id,
			},
			success: function (response){
				if(response.status == 200){
					$('#asset_body').html(response.data);
				}else{
					alert('No Asset Found..');
				}
				
			}
		});
	}
}

//sushanta code for print qrcode

const printAssetQrcode2 = (id) => {
    $('#singleAssetModal').modal('show');
    $('#qrcode_id').val(id);
    $('.printSingleQrcode').click(function () {
        let noOfCopy = $('.print_copySingle :selected').val();
        if (noOfCopy.length == 0) {
            alert('Choose No of Copy');
            return false;
        } else {
            $('#singleAssetModal').modal('hide');
        }
    });

}
const printAssetQrcode22 = () => {
    var numberOfChecked = $('input:checkbox:checked').length;
    if (numberOfChecked == 0) {
        alert('Select at least one.');
    } else {
        let qrcodes = new Array();
        $("input:checkbox[name=qrcodes]:checked").each(function () {
            qrcodes.push($(this).val());
        });
        $('#exampleModal').modal('show');
        $('#qrcode_ids').val(qrcodes);

        $('.printQrcode').click(function () {
            let noOfCopy = $('.print_copy :selected').val();
            if (noOfCopy.length == 0) {
                alert('Choose No of Copy');
                return false;
            } else {
                $('#exampleModal').modal('hide');
            }
        });

    }
}

$(document).ready(()=>{
	var locationId =$('#location').val();
	if(locationId){
		getAssets(locationId);
	}
	
})

