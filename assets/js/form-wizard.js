(function($) {
    "use strict";

    $('#wizard1').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>'
    });
    
    $('#wizard2').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex < newIndex) {
                // Step 1 form validation
                if (currentIndex === 0) {
                    var fname = $('#firstname').parsley();
                    var lname = $('#lastname').parsley();
                    if (fname.isValid() && lname.isValid()) {
                        return true;
                    } else {
                        fname.validate();
                        lname.validate();
                    }
                }
                // Step 2 form validation
                if (currentIndex === 1) {
                    var email = $('#email').parsley();
                    if (email.isValid()) {
                        return true;
                    } else {
                        email.validate();
                    }
                }
                // Always allow step back to the previous step even if the current step is not valid.
            } else {
                return true;
            }
        }
    });
    $('#wizard3').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex < newIndex) {
                // Step 1 form validation
                if (currentIndex === 0) {
                    var company_name = $('#company_name').parsley();
                    var address = $('#address').parsley();
                    var city = $('#city').parsley();
                    var state = $('#state').parsley();
                    var pincode = $('#pincode').parsley();
                    var country = $('#country').parsley();
                    if (company_name.isValid() && address.isValid() && city.isValid() && state.isValid() && pincode.isValid() && country.isValid()) {
                      return true;
                    } else {
                        company_name.validate();
                        address.validate();
                        city.validate();
                        state.validate();
                        pincode.validate();
                        country.validate();
                    }
                   
                }
     
                if (currentIndex === 1) {

                    var contactperson_name = $('#contactperson_name').parsley();
                    var contact_emailid = $('#contact_emailid').parsley();
                    var office_phone_no = $('#office_phone_no').parsley();
                    var contactperson_mobileno = $('#contactperson_mobileno').parsley();
                    if (contactperson_name.isValid() && contact_emailid.isValid() && office_phone_no.isValid() && contactperson_mobileno.isValid()) {
                        return true;
                    } else {
                        contactperson_name.validate();
                        contact_emailid.validate();
                        office_phone_no.validate();
                        contactperson_mobileno.validate();
                    }
                   
                }
               
                // Always allow step back to the previous step even if the current step is not valid.
            } else {
                return true;
            }
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            
        },
        onFinishing: function (event, currentIndex){
            var username = $('#username').parsley();
            var password = $('#password').parsley();
            var conform_password = $('#conform_password').parsley();
             if (username.isValid() && password.isValid() && conform_password.isValid()) {
                var number = /([0-9])/;
                var alphabets = /([A-Z])/;
                var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
                if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)){
                    $("#password").focus().removeClass('parsley-error');
                    $("#conform_password").focus().removeClass('parsley-error');
                       var Pasteurl = $('#regisurl').val();
                      
                        $.ajax({
                            url:Pasteurl,
                            method:"POST",
                            data:$('#wizard3').serialize(),
                            beforeSend: function() {
                                $('.loadingOverlay').show();
                            },
                            success:function(response)
                            {
                                // window.alert("suceee");
                                // console.log("successs");

                                // window.alert(response);
                                // return false;
                                $("#ajaxStart").attr("disabled", false);
                                window.location.href=response;
                            }
                        });

                }else{
                    $("#password").focus().addClass('parsley-error');
                    $("#conform_password").focus().addClass('parsley-error');
                }
                
                
            } else {
                username.validate();
                password.validate();
                conform_password.validate();
            }
        },
        onFinished: function (event, currentIndex){

          alert("this is come here");
            
        }
    });
    $('.dropify-clear').click(function() {
        $('.dropify-render img').remove();
        $(".dropify-preview").css("display", "none");
        $(".dropify-clear").css("display", "none");
    });
	
	//accordion-wizard
	var options = {
		mode: 'wizard',
		autoButtonsNextClass: 'btn btn-primary float-right',
		autoButtonsPrevClass: 'btn btn-secondary',
		stepNumberClass: 'badge badge-primary mr-1',
		onSubmit: function() {
		  alert('Form submitted!');
		  return true;
		}
	}


   
    $("#form").accWizard(options);

})(jQuery);

//Function to show image before upload

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.dropify-render img').remove();
            var img = $('<img id="dropify-img">'); //Equivalent: $(document.createElement('img'))
            img.attr('src', e.target.result);
            img.appendTo('.dropify-render');
            $(".dropify-preview").css("display", "block");
            $(".dropify-clear").css("display", "block");
        };
        reader.readAsDataURL(input.files[0]);
    }
}