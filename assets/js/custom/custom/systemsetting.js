
$(function () {


    $("#setting_save").click(function () {
        if ($('#systemsettingform').parsley().validate()) {
           
            var company_save = new FormData();
            var company_log = $('#logo_name')[0].files;
            if (company_log.length > 0) {
                company_save.append('company_logo', company_log[0]);
            }
            var height = $('#height').val();
            var width = $('#width').val();
            var email_address = $('#email_address').val();
            var email_password = $('#email_password').val();
            var email_host = $('#email_host').val();
            var email_port = $('#email_port').val();
            var email_address_name = $('#email_address_name').val();
            var receive_email_address = $('#receive_email_address').val();
            var old_logoname = $('#old_logoname').val();
            var google_place = $('#google_place').val();
            var updateid = $('#updateid').val();
            company_save.append('height', height);
            company_save.append('width', width);
            company_save.append('email_address', email_address);
            company_save.append('email_password', email_password);
            company_save.append('email_host', email_host);
            company_save.append('email_port', email_port);
            company_save.append('email_address_name', email_address_name);
            company_save.append('receive_email_address', receive_email_address);
            company_save.append('google_place', google_place);
            company_save.append('updateid', updateid);
            company_save.append('old_logoname', old_logoname);
            $.ajax({
                url: base_url + 'Systemsetting/setting_save',
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
						 if(jsonData.status==1){
                            $('.insert').show();
                            setInterval(function(){
                                window.location = base_url + 'Systemsetting/view_setting';
                            },2000);
                             }else{
                            $('.insert').hide();
                         }

                    
                },

            });
        }
    });

});  