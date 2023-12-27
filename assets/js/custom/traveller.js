
$(function () {
   
    var travellerTable = $('#traveller_table').DataTable({
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
            "url": base_url + "TravelerController/getTravelLuggageList",
            "type": "POST",
        },
        "columns": [
            {
                "render": function(data, type, full, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { 
                "data": "Name" ,
                "render": function(data, type, full, meta) {
                    return `${full.Suffix} ${data}`;
                }
            },
            { 
                "data": "Mobile",
                "render": function(data, type, full, meta) {
                    return `${full.CountryCode} ${data}`;
                }
            },
            { 
                "data": "WhatsappNumber",
                "render": function(data, type, full, meta) {
                    return `${full.WhatsappNumber?full.WhatsAppCountryCode:''} ${data}`;
                }
            
            },
            { "data": "AdressTwo" },
            {
                "render": function (AutoID, type, row, meta) {
                    return '<button class="btn btn-sm update_travel_luggage bg-success mx-2" id="' + row.AutoID + '"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_travel_luggage btn-danger" id="' + row.AutoID + '"><i class="fe fe-trash"></i></button>';
                }
            },
        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {
        }

    });

    /* save the material condiotn */
    $("#mobile-number").intlTelInput();
    $("#mobile-number2").intlTelInput();
    $("#traveller_button").click(function () {
        if ($('#add-traveller-form').parsley().validate()) {
            let frm = $('#add-traveller-form');
            let traveller_save = new FormData(frm[0]);
           // var  traveller_save = new FormData();
            // var Suffix     = $('#Suffix').val();
            // airline_save.append('Suffix', Suffix);

            $.ajax({
                url: base_url + 'TravelerController/save_travel_luggage',
                type: "POST",
                contentType: false,
                processData: false,
                data: traveller_save,
                beforeSend: function () {
                    $('.load-traveller').show();
                    $('#traveller_button').hide();
                },
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $("#traveller_modal .btn-secondary").click()
                        $('.insert').show();
                        $('#add-traveller-form').trigger("reset");
                        travellerTable.ajax.reload();
                       // travellerTable.draw();
                        setTimeout(function () {
                            $('.insert').hide();
                            $('.load-traveller').hide();
                            $('#traveller_button').show();
                            location.href = base_url + 'TravelerController/index';
                        }, 2000);
                    } else {
                        $("#traveller_modal .btn-secondary").click()
                        $('#add-traveller-form').trigger("reset");
                        $('.alert-solid-warning').show();
                        setTimeout(function () {
                            $('.alert-solid-warning').hide();
                            location.href = base_url + 'TravelerController/index';
                        }, 2000);
                    }
                },

            });
        }

    });

    $("#traveller_table").on('click', '.update_travel_luggage', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'TravelerController/getOneTravelLuggage',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == 200) {
                    console.log(response.data);
                    $('#update-traveller-modal').modal('show');
                    $('#uAutoId').val(response.data.AutoID);
                    $('#uName').val(response.data.Name);
                    $('#uMobile').val(response.data.Mobile);
                    $('#uMobil2').val(response.data.WhatsappNumber);
                    $('#uUserName').val(response.data.UserName);
                    $('#uEmail').val(response.data.Email);
                    $('#uAddress').val(response.data.Address);
                    $('#uAdressTwo').val(response.data.AdressTwo);
                    $('#uLandmark').val(response.data.Landmark);
                    $('#uoldimage').val(response.data.ProfileIMG);
                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    $("#update_travel_luggage").click(function () {
        if ($('#update-traveller-form').parsley().validate()) {
            var airline_update = new FormData();
            var up_Name     = $('#up_airline_name').val();
            var up_AutoID   = $('#up_airline_id').val();
            airline_update.append('up_Name', up_Name);
            airline_update.append('up_AutoID', up_AutoID);
            $.ajax({
                url: base_url + 'TravelerController/update_travel_luggage',
                type: "POST",
                contentType: false,
                processData: false,
                data: airline_update,
                beforeSend: function () {
                    $('.load-travel_luggage').show();
                    $('#update_travel_luggage').hide();
                },
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $('#update-traveller-modal').modal('toggle');
                        $('.update').show();
                        travellerTable.ajax.reload();
                        setTimeout(function () {
                            $('.update').hide();
                            $('.load-travel_luggage').hide();
                            $('#update_travel_luggage').show();
                        }, 2000);
                    } else {
                        $('#update-traveller-modal').modal('toggle');
                        $('.alert-solid-warning').show();
                        setTimeout(function () {
                            $('.alert-solid-warning').hide();
                            location.href = base_url + 'TravelerController/index';
                        }, 2000);

                    }

                },

            });
        }

    });

    $('#traveller_table').on('click', '.delete_travel_luggage', function () {
        var id = $(this).attr('id');
        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: base_url + 'TravelerController/delete_travel_luggage',
                type: 'post',
                dataType: 'json',
                data: { id: id },
                success: function (jsonData) {
                    //console.log(jsonData.status);
                    if (jsonData.status === 1) {
                        travellerTable.ajax.reload();
                        Swal.fire({
							title: 'Deleted!',
							text:"Deleted Successfully",
							icon: 'success',
						})
                        // setTimeout(function () {
                        //     location.href = base_url + 'TravelerController/index';
                        // }, 2000);
                    } else {
                        alert("Invalid ID.");
                    }
                }
            });
        }

    });

    
   
});
