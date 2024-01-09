$(function () {
    var table = $('#qrcode_table').DataTable({
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
            "url": base_url + "Qrcode/getactiveqrcodes",
            "type": "POST",
        },
        "columns": [
            {
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
           
            // { "data": "CompanyName" },
            // { "data": "ShortCode" },
            { "data": "NoofQRCode" },
            { "data": "TOTAL_USED_QRCODE" },
            { "data": "createdate" },

            {
                "render": function (AutoID, type, row, meta) {
                    return '<button class="btn btn-sm update_qrcode bg-success mx-2 " id="' + row.AutoID +  '"  datatype="edit"><i class="si si-eye"></i></button><button class="btn btn-sm ripple qrdelete btn-danger d-none" id="' + row.AutoID + '"><i class="fe fe-trash"></i></button>';
                }
            }

        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {
        }

    });

    /* save the condiotn */

    $('#qrcodeadd_model').click(function () {
        $('#qrcodeform_model').modal('show');
    })

    $("#addqrcode_button").on('click', function () {
        if ($('#addqrocde_form').parsley().validate()) {
            var formData = new FormData();
            // formData.append('company_id', $('#company_id').val());
            // formData.append('company_code', $('#company_code').val());
            formData.append('noof_qrcode', $('#noof_qrcode').val());

            $.ajax({
                url: base_url + 'Qrcode/qrcode_save',
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    $('.load-addqrcode').show();
                    $('#addqrcode_button').hide();
                },
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $('#qrcodeform_model').modal('hide');
                        $("#qrcodeadd_model .btn-secondary").click();
                        $('.insert').show();
                        $('#addqrocde_form').trigger("reset");
                        table.ajax.reload();
                        setInterval(function () {
                            $('.insert').hide();
                            $('.load-addqrcode').hide();
                            $('#addqrcode_button').show();
                            //  table.ajax.reload();
                            // location.href=base_url+'Company/company_list';
                        }, 2000);
                    } else {
                        $("#qrcodeadd_model .btn-secondary").click()
                        $('#addqrocde_form').trigger("reset");
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Qrcode/index';
                        }, 2000);
                    }

                },

            });


        }
    });

    /* View data */
    $("#qrcode_table").on('click', '.update_qrcode', function () {
        var id = $(this).attr("id");
        console.log(id);
        window.location.href = base_url + "Qrcode/get_qrcode_details/" + id;
    });
    //Delete QR Code
    $("#qrcode_table").on('click','qrdelete',function(){
        var id = $(this).attr("id");
        if(id != undefined && parseInt(id) > 0){
            var deleteConfirm = confirm("Are you sure?");
            if (deleteConfirm == true) {
                // AJAX request
                $.ajax({
                    url: base_url+'Qrcode/delete_qrcode',
                    type: 'post',
                    data: {id: id},
                    success: function(response){
                        if(response == 1){
                            swal("Deleted!", "Deleted Successfully", "success");
                            setInterval(function () {
                                location.href= base_url+'Masters/currency_list';
                                table.ajax.reload();
                            }, 2000);
                        
                        }else{
                            alert("Invalid ID.");
                        }
                    }
                });
            } 
        }
    })



});

/**
    * Generate and Show Sujjection for short code
    */
const generateShortCode = (val) => {
    let companyName = val.options[val.selectedIndex].text;
    let companyShortCode = companyName.substring(0, 3).toUpperCase();
    $('#company_code').val(companyShortCode);
}

$('#company_id').change(function () {
    var companyShortCode = $(this).find(':selected').data('code');
    $('#company_code').val(companyShortCode);
});


/**QR Code View Details */
$('#view_qrcode_table').DataTable({
    responsive: true,
    processing: true,
    serverSide: false,
    order: [[0, "asc"]],
    paging: false,
    // dom: 'Bfrtip',
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
});

function checkAll(ele) {
    var table = document.getElementById('view_qrcode_table123');
    var checkboxes = table.querySelectorAll('input[type=checkbox]');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }



}
$('.checkbox').change(function () {
    var table = document.getElementById('view_qrcode_table123');
    var checkboxes = table.querySelectorAll('input[type=checkbox]');
    var numberOfChecked = $('input:checkbox:not(":checked")').length;
    if (numberOfChecked != checkboxes.length - 1) {
        $('.master_checkbox').prop('checked', false);
    }
})

let timer;
const debounce = (fn, delay) => {
    if (timer) clearTimeout(timer)
    timer = setTimeout(fn, delay);
}
const printQrcode = () => {
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

                /*
                debounce(() => {
                    $.ajax({
                        url: base_url + 'Qrcode/print_qrcode',
                        type: 'post',
                        data: {
                            noof_copy: noOfCopy,
                            qrcode_ids: qrcodes
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log(response);
                        }
                    });
                }, 2000);
                */
            }
        });



    }

}

const closeModal = (closeId) => {
    $(closeId).modal('hide');
}

const printSingleQrcode = (id) => {
    $('#singleModal').modal('show');
    $('#qrcode_id').val(id);
    $('.printSingleQrcode').click(function () {
        let noOfCopy = $('.print_copySingle :selected').val();
        if (noOfCopy.length == 0) {
            alert('Choose No of Copy');
            return false;
        } else {
            $('#singleModal').modal('hide');
        }
    });

}