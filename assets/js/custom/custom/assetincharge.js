$(function () {
    var service = $('#assetincharge_table').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [[0, "asc"]],
        "dom": 'lrtip',
        createdRow: function (row,data) {
            var stsId = data.isActive;
            if (stsId == 2){
                $(row).addClass('inactive');
            }
        },
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
        "ajax": {
            "url": base_url + "Usercontroller/get_users",
            "type": "POST",
        },
        "columns": [
            {
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "EmployeeCode" },
            {
                "render": function (data, type, row, meta) {
                    if ((row.Name !== null && row.Name !== undefined && row.Name !== '') && (row.Suffix !== null && row.Suffix !== undefined && row.Suffix!== '') ) {
                        return row.Suffix+" "+ row.Name;
                    }
                    else{
                        return row.Name;
                    }
                }
            },
            // { "data": "Name" },
            { "data": "Mobile" },
            { "data": "Email" },
            {
                "render": function (data, type, row, meta) {
                    if (row.IsAdmin == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            },
            {
                "render": function (data, type, row, meta) {
                    if (row.Isauditor == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            },
            {
                "render": function (data, type, row, meta) {
                    if (row.issupervisor == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            },
            {
                "render": function (AutoID, type, row, meta) {
                    return '<button class="btn btn-sm  update_user bg-success mx-2" id="' + row.AutoID + '"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn btn-sm ripple delete_user btn-danger" id="' + row.AutoID + '"><i class="fe fe-trash"></i></button>';
                }
            }

        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });


    $("#mobile_number").on('keyup', () => {
        var mobile = $("#mobile_number").val();
        modified = mobile.replace(" ", "")
        $("#mobile_number").val(modified);
    });

    $("#up_mobilenumber").on('keyup', () => {
        var mobile = $("#up_mobilenumber").val();
        modified = mobile.replace(" ", "")
        $("#up_mobilenumber").val(modified);
    });

    $("#changepass_btn").on('click', (e) => {
        e.preventDefault();
        $('#changepass_btn').hide();
        $('#up_password,#up_gen_pas').show();
    });

    // $("#emailid").on('keyup',()=>{
    //     var email_data = new FormData();
    //     var email=$("#emailid").val();
    //     email_data.append('email',email);
    //     $.ajax({
    //         url : base_url+'Usercontroller/userexist_email',
    //         type: "POST",
    //         contentType: false,
    //         processData: false,
    //         data :email_data,
    //         success: function(result)
    //         {
    //     console.log(result);      
    //     el = $('#emailid').parsley();
    //     el.manageErrorContainer(); // set up the error list container
    //     $(el.ulError).empty() // clear any previous errors if you want..
    //     el.addError({error: 'Hey, mind yerself!'});

    //                 }
    //         });
    // });




    $('#table-filter-data').on('change', function () {
        if (this.value == 'Admin') {
            service.columns().search('').draw();
            service.columns(5).search('Yes').draw();
        } else if (this.value == 'Auditor') {
            service.columns().search('').draw();
            service.columns(6).search('Yes').draw();
        } else if (this.value == 'Supervisor') {
            service.columns().search('').draw();
            service.columns(7).search('Yes').draw();
        } else {
            service.columns().search('').draw();

        }


    });


    $("#assetin_button").click(function () {
        if ($('#assetincharge_form').parsley().validate()) {

            var user_files = new FormData();
            var user_image = $('#userpro_image')[0].files;

            if (user_image.length > 0) {
                user_files.append('userpro_image', user_image[0]);
            } else {
                user_files.append('userpro_image', "");
            }
            var user_type = $('#user_type').val();
            user_files.append('user_type', user_type);
            var name = $('#name').val();
            user_files.append('name', name);
            var emailid = $('#emailid').val();
            user_files.append('emailid', emailid);
            var mobile_number = $('#mobile_number').val();
            user_files.append('mobile_number', mobile_number);
            var employee_code = $('#employee_code').val();
            user_files.append('employee_code', employee_code);
            var username = $('#username').val();
            user_files.append('username', username);
            var password = $('#password').val();
            user_files.append('password', password);
            var user_status;
            if ($("#user_status").prop('checked') == true) {
                user_status = 1;
            } else {
                user_status = 2;
            }
            user_files.append('user_status', user_status);
            var userpro_image = $('#userpro_image').val();
            user_files.append('userpro_image', userpro_image);

            var admin = $("#admin").prop('checked');

            if (admin) {
                admin_status = 1;
            } else {
                admin_status = 0;
            }

            user_files.append('admin_status', admin_status);

            var auditor = $("#auditor").prop('checked');

            if (auditor) {
                auditor_status = 1;
            } else {
                auditor_status = 0;
            }
            user_files.append('auditor_status', auditor_status);

            var supervisor = $("#supervisor").prop('checked');

            if (supervisor) {
                supervisor_status = 1;
            } else {
                supervisor_status = 0;
            }
            user_files.append('supervisor_status', supervisor_status);

            if (admin_status == 1) {
                groupid = 2; //for group
            } else {
                groupid = 4; //for user
            }
            user_files.append('group_id', groupid);

            var prefix = $('#prefix').val();
            user_files.append('prefix', prefix);

            $.ajax({
                url: base_url + 'Usercontroller/user_save',
                type: "POST",
                contentType: false,
                processData: false,
                data: user_files,
                success: function (result) {
                    //  console.log(result);
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $("#assetincharge_model .btn-secondary").click();
                        $('#assetincharge_form').trigger("reset");
                        $('.insert').show();
                        setInterval(function () {
                            $('.insert').hide();
                            //  table.ajax.reload();
                            location.href = base_url + 'Usercontroller/user_list_admin';
                        }, 2000);
                    } else {
                        $("#assetincharge_model .btn-secondary").click()
                        $('#assetincharge_form').trigger("reset");
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Usercontroller/user_list_admin';
                        }, 2000);
                    }
                },

            });
        }

    });

    $("#assetincharge_table").on('click', '.update_user', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: base_url + 'Usercontroller/get_user',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == 1) {

                    $('#up_usermodel').modal('show');
                    $('#up_usertype').val(response.data.UserGroupID);
                    $('#up_name').val(response.data.Name);
                    $('#up_emailid').val(response.data.Email);
                    $('#up_mobilenumber').val(response.data.Mobile.replace(" ", ""));
                    $('#up_employeecode').val(response.data.EmployeeCode);
                    $('#up_username').val(response.data.UserName);
                    $('#user_updateid').val(response.data.AutoID);
                    $('#old_catimg').val(response.data.AssetSubCatIMG);
                    $('#update_prefix').val(response.data.Suffix).change();
                    if (response.data.isActive == 1) {
                        $('#userup_status').prop('checked', true); // Checks it
                    } else {
                        $('#userup_status').prop('checked', false); // Unchecks it
                    }

                    if (response.data.IsAdmin == 1) {
                        $("#up_admin").prop("checked", true);
                    } else {
                        $("#up_admin").prop("checked", false);
                    }

                    if (response.data.Isauditor == 1) {
                        $("#up_auditor").prop("checked", true);
                    } else {
                        $("#up_auditor").prop("checked", false);
                    }

                    if (response.data.issupervisor == 1) {
                        $("#up_supervisor").prop("checked", true);
                    } else {
                        $("#up_supervisor").prop("checked", false);
                    }

                    if (response.data.ProfileIMG != null) {
                        $('#update_userprofile').attr('src', base_url + "upload/profile/" + response.data.ProfileIMG);
                    } else {
                        $('#update_userprofile').attr('src', 'data:image/png;base64,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');
                    }

                } else {
                    alert("Invalid ID.");
                }
            }
        });

    });


    $("#update_user").click(function () {
        if ($('#up_usermodelform').parsley().validate()) {

            var update_user = new FormData();
            var upd_file = $('#user-fileupload')[0].files;
            if (upd_file.length > 0) {
                update_user.append('userupdate_file', upd_file[0]);
            }
            var user_type = $('#up_usertype').val();
            update_user.append('user_type', user_type);
            var name = $('#up_name').val();
            update_user.append('name', name);
            var emailid = $('#up_emailid').val();
            update_user.append('emailid', emailid);
            var mobile_number = $('#up_mobilenumber').val();
            update_user.append('mobile_number', mobile_number);
            var employee_code = $('#up_employeecode').val();
            update_user.append('employee_code', employee_code);
            var username = $('#up_username').val();
            update_user.append('username', username);
            var password = $('#up_password').val();
            update_user.append('password', password);

            var update_prefix = $('#update_prefix').val();
            update_user.append('update_prefix', update_prefix);

            var user_status;
            if ($("#userup_status").prop('checked') == true) {
                user_status = 1;
            } else {
                user_status = 2;
            }

            var admin = $("#up_admin").prop('checked');

            if (admin) {
                admin_status = 1;
                up_groupid = 2;
            } else {
                admin_status = 0;
                up_groupid = 4;
            }
            update_user.append('up_group_id', up_groupid);

            update_user.append('admin_status', admin_status);

            var auditor = $("#up_auditor").prop('checked');

            if (auditor) {
                auditor_status = 1;
            } else {
                auditor_status = 0;
            }
            update_user.append('auditor_status', auditor_status);

            var supervisor = $("#up_supervisor").prop('checked');

            if (supervisor) {
                supervisor_status = 1;
            } else {
                supervisor_status = 0;
            }
            update_user.append('supervisor_status', supervisor_status);



            update_user.append('user_status', user_status);
            var user_updateid = $('#user_updateid').val();
            update_user.append('user_updateid', user_updateid);



            $.ajax({
                url: base_url + 'Usercontroller/user_update',
                type: "POST",
                contentType: false,
                processData: false,
                data: update_user,
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    if (jsonData.status === 1) {
                        $("#up_usermodel .btn-secondary").click();
                        $('#up_usermodelform').trigger("reset");
                        $('.update').show();
                        setInterval(function () {
                            $('.update').hide();
                            //  table.ajax.reload();
                            location.href = base_url + 'Usercontroller/user_list_admin';
                        }, 2000);
                    } else {
                        $("#up_usermodel .btn-secondary").click()
                        $('#up_usermodelform').trigger("reset");
                        $('.alert-solid-warning').show();
                        setInterval(function () {
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href = base_url + 'Usercontroller/user_list_admin';
                        }, 2000);
                    }
                },

            });

        }

    });

    $('#assetincharge_table').on('click', '.delete_user', function () {
        var id = $(this).attr('id');
        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: base_url + 'Usercontroller/delete_user',
                type: 'post',
                data: { id: id },
                success: function (response) {
                    if (response == 1) {
                        location.href = base_url + 'Usercontroller/user_list_admin';
                        table.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }
                }
            });
        }

    });

    $('#table-filter,#searchInput').on('keyup  change', function () {
        service.search(this.value).draw();
    });


    //////////////////////for user only //////////////////////////////

    var users = $('#users_table').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [[0, "asc"]],
        "dom": 'lrtip',


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
        "ajax": {
            "url": base_url + "Usercontroller/get_users",
            "type": "POST",

        },
        "columns": [
            {
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "Name" },
            { "data": "Mobile" },
            { "data": "Email" },
            {
                "render": function (data, type, row, meta) {
                    if (row.IsAdmin == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            },
            {
                "render": function (data, type, row, meta) {
                    if (row.Isauditor == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            },
            {
                "render": function (data, type, row, meta) {
                    if (row.issupervisor == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            }

        ],

        "drawCallback": function (settings) {

        },
        "initComplete": function (settings, json) {

        }

    });

    $('#table-filter-data').on('change', function () {
        var test = "Yes";
        if (this.value == 'Admin') {
            users.columns().search('').draw();
            users.columns(4).search('Yes').draw();
            console.log(this.value);
        } else if (this.value == 'Auditor') {
            users.columns().search('').draw();
            users.columns(5).search('Yes').draw();
        } else if (this.value == 'Supervisor') {
            users.columns().search('').draw();
            users.columns(6).search('Yes').draw();
        } else {
            users.columns().search('').draw();

        }


    });
    $('#table-filter,#searchInput').on('keyup  change', function () {
        users.search(this.value).draw();
    });



    /////////////////////////////////////end only for users



});

$(document).ready(function () {


    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.update_userprofile').attr('src', e.target.result);
            }


        }
        reader.readAsDataURL(input.files[0]);


    }


    $(".user-fileupload").on('change', function () {
        readURL(this);
    });

    $(".upload-button").on('click', function () {
        $(".user-fileupload").click();
    });

});

$(document).ready(function () {

    $('#generate').on('click', function () {
        var randomstring = Math.random().toString(36).slice(-8);
        $('#password').val(randomstring);
    });

    $('#up-generate').on('click', function () {
        var randomstring = Math.random().toString(36).slice(-8);
        $('#up_password').val(randomstring);
    });

});

$("#userimp_button").click(function () {
    location.href = base_url + 'Usercontroller/user_list_admin';
    if ($('#import_userform').parsley().validate()) {

        var user_data = new FormData();
        var import_file = $('#user_file')[0].files;

        if (import_file.length > 0) {
            user_data.append('userfile', import_file[0]);
        }

        $.ajax({
            url: base_url + 'Usercontroller/user_import',
            type: "POST",
            contentType: false,
            processData: false,
            data: user_data,
            success: function (result) {


                var jsonData = JSON.parse(result);

                if (jsonData.status === 1) {

                    $("#userimport .btn-secondary").click();
                    $('#up_usermodelform').trigger("reset");
                    $('.insert').show();
                    setInterval(function () {
                        $('.insert').hide();
                        //  service.ajax.reload();
                        location.href = base_url + 'Usercontroller/user_list_admin';
                    }, 2000);
                } else {

                    $("#userimport .btn-secondary").click();
                    $('.alert-solid-warning').show();
                    setInterval(function () {
                        $('.alert-solid-warning').hide();
                        // service.ajax.reload();
                        location.href = base_url + 'Usercontroller/user_list_admin';
                    }, 2000);
                }

            }
        });

    }
});
$(document).ready(function(){
    $(".linkuser").click(function(){
        $("#loadmodel").modal('show');
        $.ajax({
            type: "POST",
            url: base_url + 'Assetmanagement/Userlistdirectory',
            data: {},
            success: function(response) {
                // Hide the loader when the response is received
                //$("#loadmodel").modal('hide');
                // location.href = base_url + 'Usercontroller/user_list_admin';
            }
        });
    });
});

$(".depreciation_rate").on('blur', function () {

    var dr = $('.depreciation_rate').val();
    var status;

    if (dr >= 0.1 && dr < 99.9) {
        status = 1;
    } else {
        status = 2;
    }

    if (status == 2) {
        $('.depreciation_rate').addClass('parsley-error');
    }

});








