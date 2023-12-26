$(function () {
    var airlineTable = $('#airline_table').DataTable({
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
            "url": base_url + "Qrcode/getAirlineList",
            "type": "POST",
        },
        "columns": [
            {
                "render": function(data, type, full, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "Name" },
            {
                "render": function (AutoID, type, row, meta) {
                    return '<button class="btn btn-sm update_airline bg-success mx-2" id="' + row.AutoID + '"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_airline btn-danger" id="' + row.AutoID + '"><i class="fe fe-trash"></i></button>';
                }
            },
        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {
        }

    });

    /* save the material condiotn */

    $("#airline_button").click(function () {
        if ($('#airlineform').parsley().validate()) {
            var  airline_save = new FormData();
            var airline_name     = $('#airline_name').val();
            airline_save.append('airline_name', airline_name);

            $.ajax({
                url: base_url + 'Qrcode/save_airline',
                type: "POST",
                contentType: false,
                processData: false,
                data: airline_save,
                beforeSend: function () {
                    $('.load-airline').show();
                    $('#company_button').hide();
                },
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $("#airline_model .btn-secondary").click()
                        $('.insert').show();
                        $('#airlineform').trigger("reset");
                        airlineTable.ajax.reload();
                        setTimeout(function () {
                            $('.insert').hide();
                            $('.load-airline').hide();
                            $('#airline_button').show();
                            location.href = base_url + 'Qrcode/getAirlineList';
                        }, 2000);
                    } else {
                        $("#airline_model .btn-secondary").click()
                        $('#airlineform').trigger("reset");
                        $('.alert-solid-warning').show();
                        setTimeout(function () {
                            $('.alert-solid-warning').hide();
                            location.href = base_url + 'Qrcode/getAirlineList';
                        }, 2000);
                    }
                },

            });
        }

    });

    $("#airline_table").on('click', '.update_airline', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'Qrcode/getOneAirline',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == 200) {
                    $('#up_airlinemodel').modal('show');
                    $('#up_airline_id').val(response.data.AutoID);
                    $('#up_airline_name').val(response.data.Name);
                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    $("#update_airline").click(function () {
        if ($('#up_airlineform').parsley().validate()) {
            var airline_update = new FormData();
            var up_Name     = $('#up_airline_name').val();
            var up_AutoID   = $('#up_airline_id').val();
            airline_update.append('up_Name', up_Name);
            airline_update.append('up_AutoID', up_AutoID);
            $.ajax({
                url: base_url + 'Qrcode/update_airline',
                type: "POST",
                contentType: false,
                processData: false,
                data: airline_update,
                beforeSend: function () {
                    $('.load-airline').show();
                    $('#update_airline').hide();
                },
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $('#up_airlinemodel').modal('toggle');
                        $('.update').show();
                        airlineTable.ajax.reload();
                        setTimeout(function () {
                            $('.update').hide();
                            $('.load-airline').hide();
                            $('#update_airline').show();
                        }, 2000);
                    } else {
                        $('#up_airlinemodel').modal('toggle');
                        $('.alert-solid-warning').show();
                        setTimeout(function () {
                            $('.alert-solid-warning').hide();
                            location.href = base_url + 'Qrcode/getAirlineList';
                        }, 2000);

                    }

                },

            });
        }

    });

    $('#airline_table').on('click', '.delete_airline', function () {
        var id = $(this).attr('id');
        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: base_url + 'Qrcode/delete_airline',
                type: 'post',
                data: { id: id },
                success: function (response) {
                    if (response == 1) {
                        airlineTable.ajax.reload();
                        swal("Deleted!", "Deleted Successfully", "success");
                        location.href = base_url + 'Qrcode/getAirlineList';
                    } else {
                        alert("Invalid ID.");
                    }
                }
            });
        }

    });

    

});
