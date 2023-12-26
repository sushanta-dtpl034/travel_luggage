$(function () {

    var service = $('#company_table').DataTable({
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
            "url": base_url + "Company/getcompany",
            "type": "POST",

        },
        "columns": [
            {
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {

                "render": function (AutoID, type, row, meta) {
                    if (row.IsCompany == 1) {
                        return '<span class="badge bg-success text-white rounded-pill" style="padding: 9px;">' + row.CompanyName + '</span>'
                    } else {
                        return '<span class="" style="">' + row.CompanyName + '</span>'
                    }
                }

            },
            { "data": "CompanyShortCode" },
            { "data": "CurrencyCode" },

            {
                "render": function (AutoID, type, row, meta) {
                    return '<button class="btn btn-sm update_company bg-success mx-2" id="' + row.AutoID + '"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_company btn-danger" id="' + row.AutoID + '"><i class="fe fe-trash"></i></button>';
                }
            }

        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });

    /* save the material condiotn */

    $("#company_button").click(function () {
        if ($('#companyform').parsley().validate()) {
            var company_save = new FormData();
            var company_log = $('#company_logo')[0].files;

            if (company_log.length > 0) {
                company_save.append('company_log', company_log[0]);
            }

            var company_stamp = $('#company_stamp')[0].files;

            if (company_stamp.length > 0) {
                company_save.append('company_stamp', company_stamp[0]);
            }

            var company_name = $('#company_name').val();
            var company_address = $('#company_address').val();
            var companybank_details = $('#companybank_details').val();
            var company_shortcode = $('#company_shortcode').val();

            company_save.append('company_name', company_name);
            company_save.append('company_address', company_address);
            company_save.append('companybank_details', companybank_details);
            company_save.append('company_shortcode', company_shortcode);

            var company_currency = $('#company_currency').val();
            company_save.append('company_currency', company_currency);

            var basecompany = $("#basecompany").prop('checked');

            if (basecompany) {
                company_status = 1;
            } else {
                company_status = 0;
            }
            company_save.append('company_status', company_status);

            $.ajax({
                url: base_url + 'Company/company_save',
                type: "POST",
                contentType: false,
                processData: false,
                data: company_save,
                // beforeSend: function () {
                //     $('.load-company').show();
                //     $('#company_button').hide();
                // },
                success: function (result) {
            
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $("#company_model .btn-secondary").click()
                        $('.insert').show();
                        $('#companyform').trigger("reset");
                        service.ajax.reload();
                        setInterval(function () {
                            $('.insert').hide();
                            $('.load-company').hide();
                            $('#company_button').show();
                            //  table.ajax.reload();
                            // location.href=base_url+'Company/company_list';
                        }, 5000);
                    } else {
                        $("#company_model .btn-secondary").click()
                        $('#companyform').trigger("reset");
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Company/company_list';
                        }, 2000);
                    }
                },

            });
        }

    });

    $("#company_table").on('click', '.update_company', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'Company/getonecompany',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == 1) {
                    console.log(response.data.CompanyStamp);
                    $('#up_companymodel').modal('show');

                    $('#up_companycurrency').val(response.data.CompanCurrency);
                    $('#up_companyname').val(response.data.companyname);
                    $('#up_companyname').val(response.data.companyname);
                    $('#up_company_shortcode').val(response.data.CompanyShortCode);
                    $('#update_id').val(response.data.id);
                    $('#up_bank_details').val(response.data.BankDetails);
                    $('#update_companylogo').attr('src', base_url + "upload/company_logo/" + response.data.CompanyLogo);

                    if (response.data.CompanyStamp != null && response.data.CompanyStamp != '') {
                        $('#update_companystamp').attr('src', base_url + "upload/company_logo/" + response.data.CompanyStamp);
                    } else {
                        console.log('no data found');
                        $('#update_companystamp').attr('src', 'data:image/png;base64,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');

                    }
                    if (response.data.IsCompany == 1) {
                        $("#up_basecompany").prop("checked", true);
                    } else {
                        $("#up_basecompany").prop("checked", false);
                    }


                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    $("#update_company").click(function () {
        if ($('#up_companyform').parsley().validate()) {
            var company_update = new FormData();
            var update_logo = $('#update_logo')[0].files;

            if (update_logo.length > 0) {
                company_update.append('up_companylog', update_logo[0]);
            }

            var update_stamp = $('#update_stamp')[0].files;

            if (update_stamp.length > 0) {
                company_update.append('up_companystamp', update_stamp[0]);
            }

            var up_basecompany = $("#up_basecompany").prop('checked');

            if (up_basecompany) {
                up_companystatus = 1;
            } else {
                up_companystatus = 0;
            }
            company_update.append('up_companystatus', up_companystatus);
            var up_companyname = $('#up_companyname').val();
            var up_companyaddress = $('#up_companyaddress').val();
            var up_bank_details = $('#up_bank_details').val();
            var up_company_shortcode = $('#up_company_shortcode').val();
            company_update.append('up_companyname', up_companyname);
            company_update.append('up_companyaddress', up_companyaddress);
            company_update.append('up_bank_details', up_bank_details);
            company_update.append('up_company_shortcode', up_company_shortcode);

            var update_id = $('#update_id').val();
            company_update.append('update_id', update_id);

            var up_companycurrency = $('#up_companycurrency').val();
            company_update.append('up_companycurrency', up_companycurrency);

            $.ajax({
                url: base_url + 'Company/update_company',
                type: "POST",
                contentType: false,
                processData: false,
                data: company_update,
                beforeSend: function () {
                    $('.load-company').show();
                    $('#update_company').hide();
                },
                success: function (result) {
                    //console.log(result);
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $('#up_companymodel').modal('toggle');
                        $('.update').show();
                        service.ajax.reload();
                        setInterval(function () {
                            $('.update').hide();
                            $('.load-company').hide();
                            $('#update_company').show();
                            //  location.href=base_url+'Company/company_list';
                        }, 5000);
                    } else {
                        $('#up_companymodel').modal('toggle');
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            location.href = base_url + 'Company/company_list';
                        }, 2000);

                    }

                },

            });
        }

    });

    $('#company_table').on('click', '.delete_company', function () {
        var id = $(this).attr('id');
        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: base_url + 'Company/delete_company',
                type: 'post',
                data: { id: id },
                success: function (response) {
                    if (response == 1) {
                        service.ajax.reload();
                        swal("Deleted!", "Deleted Successfully", "success");

                        // setInterval(function () {
                        //     location.href= base_url+'Company/company_list';
                        //     table.ajax.reload();
                        // }, 2000);

                    } else {
                        alert("Invalid ID.");
                    }
                }
            });
        }

    });

});


/**
* Generate and Show Sujjection for short code
*/

// let timer1;
// const debounce = (fn, dealy) => {
//     if (timer1) clearTimeout(timer)
//     timer1 = setTimeout(fn, dealy)
// }


const suggestShortCode = (val) => {
    debounce(() => {
        let companyShortCode = val.substring(0, 3).toUpperCase();
        $('#company_shortcode').val(companyShortCode);
    }, 500);
}


$(document).ready(function () {


    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.update_companylogo').attr('src', e.target.result);
            }


        }
        reader.readAsDataURL(input.files[0]);


    }


    $(".companylog").on('change', function () {
        readURL(this);
    });

    $(".company").on('click', function () {
        $(".companylog").click();
    });

});

$(document).ready(function () {


    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.update_companystamp').attr('src', e.target.result);
            }


        }
        reader.readAsDataURL(input.files[0]);


    }


    $(".companystamp").on('change', function () {
        readURL(this);
    });

    $(".stamp").on('click', function () {
        $(".companystamp").click();
    });



});













