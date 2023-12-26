$(function () {

    var service = $('#assetsubcat_table').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [[0, "asc"]],

        //dom: 'Bfrtip',
        buttons: [

            {
                extend: 'excelHtml5',
                title: 'Any title for file',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },

        ],
        "ajax": {
            "url": base_url + "Asset/getassetsubcat",
            "type": "POST",

        },
        "columns": [
            {
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "catname" },
            { "data": "AssetSubcatName" },
            { "data": "VerificationInterval" },
            { "data": "auditor" },
            { "data": "NumberOfPicture" },
            {
                "render": function (AutoID, type, row, meta) {
                    if (row.titleStatus == 1) {
                        str = 'Yes';
                    }
                    else {
                        str = 'No';
                    }
                    return str;
                }
            },
			{ "data": "DepreciationRate" },
            {
                "render": function (AutoID, type, row, meta) {

                    return '<td><button class="btn btn-sm update_assetsub bg-success mx-2" id="' + row.AutoID + '"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_assetsub btn-danger" id="' + row.AutoID + '"><i class="fe fe-trash"></i></button> </td>';
                }
            }

        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });
    /* save the material condiotn */







    $("#assetsub_button").click(function () {


        if ($('#asetsubcat_form').parsley().validate()) {
            var sub_cat = new FormData();

            var assetpic_files = document.getElementById('sub_catimage').files.length;
            for (var index = 0; index < assetpic_files; index++) {
                sub_cat.append("sub_catimage[]", document.getElementById('sub_catimage').files[index]);
            }

            var asset_cat = $('#assetcat_name').val();
            var assetsubcat_name = $('#assetsubcat_name').val();
            var measurement = $('#measurement').val();
            var depreciation_rate = $('#depreciation_rate').val();
            //console.log(measurement);

            var sub_numberpic = $('#sub_numberpic').val();
            var sub_title = $("#sub_title").prop('checked');

            if (sub_title) {
                title = 1;
            } else {
                title = 0;
            }

            var verification_interval = $('#verification_interval').val();

            var auditor = $('#auditor').val();
            // var incharge =  $('#incharge').val();
            // var supervisor =  $('#supervisor').val();
            sub_cat.append('assetcat_name', asset_cat);
            sub_cat.append('assetsubcat_name', assetsubcat_name);
            sub_cat.append('measurement', measurement);
            sub_cat.append('depreciation_rate', depreciation_rate);
            sub_cat.append('auditor', auditor);
            sub_cat.append('verification_interval', verification_interval);
            // sub_cat.append('incharge',incharge);
            // sub_cat.append('supervisor',supervisor);
            sub_cat.append('sub_numberpic', sub_numberpic);
            sub_cat.append('title', title);

            $.ajax({
                url: base_url + 'Asset/assetsubcat_save',
                type: "POST",
                contentType: false,
                processData: false,
                data: sub_cat,
                beforeSend: function () {
                    $('.load-assetcat').show();
                    $('#assetsub_button').hide();
                },
                success: function (result) {

                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $("#assetsub_model .btn-secondary").click();
                        $('#asetsubcat_form').trigger("reset");
                        $('.insert').show();
                        setInterval(function () {
                            $('.insert').hide();
                            $('.load-assetcat').hide();
                            $('#assetsub_button').show();
                            service.ajax.reload();
                            // location.href=base_url+'Asset/assetsubcat_list';
                        }, 3000);
                    } else {
                        $("#assetsub_model .btn-secondary").click()
                        $('#asetsubcat_form').trigger("reset");
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Asset/assetsubcat_list';
                        }, 2000);
                    }
                },

            });
        } else {
            $('.select2CustomErrorShow ul.parsley-errors-list ').css({ 'position': 'absolute', 'top': '68px' });
        }

    });

    $("#assetsubcat_table").on('click', '.update_assetsub', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'Asset/get_oneassetsubcat',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == 1) {
                    $('#up_assetsubmodel').modal('show');
                    $("#view_catimage").empty();
                    $('#up_assetcatname').val(response.data.catname);
                    $('#up_assetsubcatname').val(response.data.subcatname);
                    $('#up_subnumberpic').val(response.data.NumberOfPicture);
                    $('#up_depreciation_rate').val(response.data.DepreciationRate);
                    if (response.data.titleStatus == 1) {
                        $("#up_subtitle").prop("checked", true);
                    } else {
                        $("#up_subtitle").prop("checked", false);
                    }
                    $('#updateid').val(response.data.id);
                    $('#up_auditor').val(response.data.auditor).change();
                    $('#up_incharge').val(response.data.incharge).change();
                    $('#up_supervisor').val(response.data.supervisor).change();
                    $('#up_verificationinterval').val(response.data.VerificationInterval).change();
                    var datas = JSON.parse(response.data.Measurement);
                    var selectedItems = [];
                    $.each(datas, function (i, value) {
                        if (value) {
                            // console.log(value.AutoID);
                            selectedItems.push(value.AutoID);
                        }
                    });
                    $('#up_measurement').val(selectedItems).change();

                    var SubCatIMG = response.data.AssetSubCatIMG.split(",");
                    var SubCatId = response.data.AssetSubCatId.split(",");


                    $.each(SubCatIMG, function (i, value) {
                        if (value) {
                            var data = "<li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3 upload-image-thumb' id='" + SubCatId[i] + "'><img class='img-responsive' src='" + base_url + "upload/asset_subcat/" + value + "' id='" + SubCatId[i] + "'><a href='#' id='' onclick='deletesubcatpic(" + SubCatId[i] + ")' class='del-icon'><i class='fa fa-trash'></i></a></li>";
                            $("#view_catimage").append(data);
                        }
                    });


                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    $("#update_assetsub").click(function () {
        if ($('#up_assetsub').parsley().validate()) {

            var update_subcat = new FormData();


            var assetpic_files = document.getElementById('updatesubcat_file').files.length;
            for (var index = 0; index < assetpic_files; index++) {
                update_subcat.append("up_subcatimage[]", document.getElementById('updatesubcat_file').files[index]);
            }


            var up_assetcatname = $('#up_assetcatname').val();
            var up_assetsubcatname = $('#up_assetsubcatname').val();
            var up_depreciation_rate = $('#up_depreciation_rate').val();
            var updateid = $('#updateid').val();
            var old_subcatimg = $('#old_subcatimg').val();

            var up_subnumberpic = $('#up_subnumberpic').val();
            var up_subtitle = $("#up_subtitle").prop('checked');

            if (up_subtitle) {
                up_title = 1;
            } else {
                up_title = 0;
            }

            var up_verificationinterval = $("#up_verificationinterval").val();


            update_subcat.append('up_assetcatname', up_assetcatname);
            update_subcat.append('up_assetsubcatname', up_assetsubcatname);
            update_subcat.append('old_subcatimg', old_subcatimg);
            update_subcat.append('updateid', updateid);

            update_subcat.append('up_subnumberpic', up_subnumberpic);

            update_subcat.append('up_depreciation_rate', up_depreciation_rate);
            update_subcat.append('up_subtitle', up_title);

            var up_assetcatname = $('#up_assetcatname').val();
            update_subcat.append('updateid', updateid);
            update_subcat.append('up_verificationinterval', up_verificationinterval);

            var up_auditor = $('#up_auditor').val();
            update_subcat.append('up_auditor', up_auditor);
            var up_incharge = $('#up_incharge').val();
            update_subcat.append('up_incharge', up_incharge);
            var up_supervisor = $('#up_supervisor').val();
            update_subcat.append('up_supervisor', up_supervisor);
            var up_measurement = $('#up_measurement').val();
            update_subcat.append('measurement', up_measurement);



            $.ajax({
                url: base_url + 'Asset/update_assetsubcat',
                type: "POST",
                contentType: false,
                processData: false,
                data: update_subcat,
                beforeSend: function () {
                    $('.load-assetcat').show();
                    $('#update_assetsub').hide();
                },
                success: function (result) {


                    var jsonData = JSON.parse(result);
                    if (jsonData.status == 1) {
                        $('#up_assetsubmodel').modal('toggle');
                        $('.update').show();
                        service.ajax.reload();
                        setInterval(function () {
                            $('.load-assetcat').hide();
                            $('.update').hide();
                            $('#update_assetsub').show();
                            //  location.href=base_url+'Asset/assetsubcat_list';
                        }, 3000);
                    } else {
                        $('#up_assetsubmodel').modal('toggle');
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            location.href = base_url + 'Asset/assetsubcat_list';
                        }, 2000);

                    }
                },

            });
        }

    });

    $('#assetsubcat_table').on('click', '.delete_assetsub', function () {
        var id = $(this).attr('id');
        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: base_url + 'Asset/delete_assetsubcat',
                type: 'post',
                data: { id: id },
                success: function (response) {
                    if (response == 1) {
                        swal("Deleted!", "Deleted Successfully", "success");
                        setInterval(function () {
                            location.href = base_url + 'Asset/assetsubcat_list';
                            table.ajax.reload();
                        }, 2000);
                    } else {
                        alert("Invalid ID.");
                    }
                }
            });
        }

    });

});

$(document).ready(function () {


    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.subcatimage-update').attr('src', e.target.result);
            }


        }
        reader.readAsDataURL(input.files[0]);


    }


    $(".subcat-fileupload").on('change', function () {
        readURL(this);
    });

    $(".upload-button").on('click', function () {
        $(".subcat-fileupload").click();
    });

});

function deletesubcatpic(imageid) {

    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
        var id = imageid;
        $.ajax({
            url: base_url + 'Asset/delete_subcatimg',
            type: 'post',
            data: { id: id },
            success: function (response) {
                if (response == 1) {
                    $('#' + id).remove();
                    swal("Deleted!", "Deleted Successfully", "success");
                    // $('#'+id).attr('src','');
                } else {
                    alert("Invalid ID.");
                }
            }
        });

    }

}

$(".subcatimport").click(function () {
    $('#subcatimport').modal('show');
    $('#subimport_catform')[0].reset();
});

$("#subcatimp_button").click(function () {
    if ($('#subimport_catform').parsley().validate()) {

        var subcatfile_data = new FormData();
        var import_file = $('#subcat_file')[0].files;

        if (import_file.length > 0) {
            subcatfile_data.append('subcat_file', import_file[0]);
        }

        $.ajax({
            url: base_url + 'Asset/subcat_import',
            type: "POST",
            contentType: false,
            processData: false,
            data: subcatfile_data,
            success: function (result) {


                var jsonData = JSON.parse(result);

                if (jsonData.status === 1) {

                    $('#subcatimport').modal('hide');
                    $('#subimport_catform').trigger("reset");
                    $('.insert').show();
                    setInterval(function () {
                        $('.insert').hide();
                        //  table.ajax.reload();
                        location.href = base_url + 'Asset/assetsubcat_list';
                    }, 2000);
                } else {

                    $("#subcatimp_button .btn-secondary").click();
                    $('.alert-solid-warning').show();
                    setInterval(function () {
                        $('.alert-solid-warning').hide();
                        // table.ajax.reload();
                        location.href = base_url + 'Asset/assetsubcat_list';
                    }, 2000);
                }

            }
        });

    }
});








