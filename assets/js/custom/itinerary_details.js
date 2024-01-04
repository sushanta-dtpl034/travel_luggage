$(function () {
    var travellerTable = $('#itinerary_details_table').DataTable({
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
            "url": base_url + "ItineraryController/getItineraryDetailList/"+itineraryHeadId,
            "type": "POST",
        },
        "columns": [
            {
                "render": function(data, type, full, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            
            // { 
            //     "data": "Name" ,
            //     "render": function(data, type, full, meta) {
            //         return `<img src="${base_url}${full.ProfileIMG}" height="40" width="40"/> &nbsp; &nbsp;${full.Suffix} ${full.Name}`;
            //     }
            // },
            { 
                "data": "Type",
            },
            { 
                "data": "TravelFrom",
            },
            { 
                "data": "TravelTo",
            },
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
    // $("#mobile-number").intlTelInput();
    // $("#mobile-number2").intlTelInput();
    $(".CountryCode").select2({
        dropdownParent: $("#traveller_modal"),
        width:'100%',
    });
    $(".WhatsAppCountryCode").select2({
        dropdownParent: $("#traveller_modal"),
        width:'100%',
    });

    /*
    $("#traveller_button").click(function () {
        if ($('#add-traveller-form').parsley().validate()) {
            let frm = $('#add-traveller-form');
            let traveller_save = new FormData(frm[0]);
            $.ajax({
                url: base_url + 'TravelerController/save_travel_luggage',
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                data: traveller_save,
                beforeSend: function () {
                    $('.load-traveller').show();
                    $('#traveller_button').hide();
                },
                success: function (jsonData) {
                    //var jsonData = JSON.parse(result);
                    $("#traveller_modal .print-error-msg").hide();
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
                error: function (xhr, status, errors) {
                    //$('.spinner').hide();
                    //console.log(xhr.responseText);
                    var pattern = /<p>(.*?)<\/p>/g;
                    var arrayOfStrings = [];
                    var match;
                    while ((match = pattern.exec(xhr.responseText)) !== null) {
                        arrayOfStrings.push(match[1]);
                    }
                    $('#form_errors').html(""); 
                    if(arrayOfStrings.length > 0){
                        $.each(arrayOfStrings, function (key, item) {
                            $("#traveller_modal #form_errors").append("<li class='alert alert-danger m-0 border-0 p-1'>" + item + "</li>");
                        });
                        $("#traveller_modal .print-error-msg").show();
                        $('.load-traveller').hide();
                        $('#traveller_button').show();
                    }
                
                }

            });
        }

    });
    */
   /*  $(".uSuffix").select2({
        dropdownParent: $("#update-traveller-modal"),
        width:'100%',
    }); */
    $(".uCountryCode").select2({
        dropdownParent: $("#update-traveller-modal"),
        width:'100%',
    });
    $(".uWhatsAppCountryCode").select2({
        dropdownParent: $("#update-traveller-modal"),
        width:'100%',
    });
    /*
    $("#itinerary_details_table").on('click', '.update_travel_luggage', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'TravelerController/getOneTravelLuggage',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == 200) {
                    $('#update-traveller-modal').modal('show');
                    $('#uAutoId').val(response.data.AutoID);
                    $('#uName').val(response.data.Name);
                    $('#uMobile').val(response.data.Mobile);
                    $('#uWhatsappNumber').val(response.data.WhatsappNumber);
                    $('#uEmail').val(response.data.Email);
                    $('#uAddress').val(response.data.Address);
                    $('#uAdressTwo').val(response.data.AdressTwo);
                    $('#uLandmark').val(response.data.Landmark);
                    $('#uoldimage').val(response.data.ProfileIMG);

                    $('.uSuffix').val(response.data.Suffix).trigger('change');
                    $('.uCountryCode').val(response.data.CountryCode).trigger('change');
                    $('.uWhatsAppCountryCode').val(response.data.WhatsAppCountryCode).trigger('change');
                    $(`.uGender`).each(function () {
                        if ($(this).val() == response.data.Gender) {
                           $(this).prop("checked", true);
                        }
                    });
                    $('#image-show').attr("src",`${base_url}/${response.data.ProfileIMG}`);
                   
                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    $("#update_travel_luggage").click(function () {
       
        if ($('#update-traveller-form').parsley().validate()) {
            let frm = $('#update-traveller-form');
            let traveller_save = new FormData(frm[0]);
            $.ajax({
                url: base_url + 'TravelerController/update_travel_luggage',
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                data: traveller_save,
                beforeSend: function () {
                    $('.load-travel_luggage').show();
                    $('#update_travel_luggage').hide();
                },
                success: function (jsonData) {
                    //var jsonData = JSON.parse(result);
                    $("#update-traveller-modal .print-error-msg").hide();
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
                error: function (xhr, status, errors) {
                    //$('.spinner').hide();
                    //console.log(xhr.responseText);
                    var pattern = /<p>(.*?)<\/p>/g;
                    var arrayOfStrings = [];
                    var match;
                    while ((match = pattern.exec(xhr.responseText)) !== null) {
                        arrayOfStrings.push(match[1]);
                    }
                    $('#form_errors').html(""); 
                    if(arrayOfStrings.length > 0){
                        $.each(arrayOfStrings, function (key, item) {
                            $("#update-traveller-modal #form_errors").append("<li class='alert alert-danger m-0 border-0 p-1'>" + item + "</li>");
                        });
                        $("#update-traveller-modal .print-error-msg").show();
                        $('.load-travel_luggage').hide();
                        $('#update_travel_luggage').show();
                        //$('#submit').attr('disabled', false);
                    }
                
                }

            });
        }else{
            $(".uCountryCode").select2({
                dropdownParent: $("#update-traveller-modal"),
                width:'100%',
            });
            $(".uWhatsAppCountryCode").select2({
                dropdownParent: $("#update-traveller-modal"),
                width:'100%',
            });
        }

    });

    $('#itinerary_details_table').on('click', '.delete_travel_luggage', function () {
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
    */
});
