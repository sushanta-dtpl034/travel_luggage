<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Jquery js-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap js-->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- Internal Parsley js-->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>

<!-- Select2 js-->
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
<!-- Internal Jquery-steps js-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-steps/jquery.steps.min.js"></script>
<!-- 

<script src="<?php echo base_url(); ?>assets/plugins/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();
    });

    
</script> -->


<!-- Internal Form-wizard js-->
<script src="<?php echo base_url(); ?>assets/js/form-wizard.js"></script>
<!-- Custom js -->
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script>
var status = '<?php echo $this->uri->segment('3'); ?>';

if(status=='s2'){
	setInterval(function(){ location.href="<?php echo base_url('login'); ?>"; }, 3000);
}
if(status=='s3' || status=='s4'){
	setInterval(function(){ location.href="<?php echo base_url('Register'); ?>"; }, 3000);
}

$(document).ready(function() {
	$("#signin").click(function(){
		if($('#login').parsley().validate()){
			$.ajax({
				url: '<?php echo base_url(); ?>Login/validateUser',
				type: 'post',
				data: $('#login').serialize(),
				dataType: 'json',
				success: function(response){
					console.log(response);
					if(response.status == 200){
					window.location= "<?php echo base_url('Dashboard/superadmin_dasboard'); ?>";
					}else{
					Swal.fire({
						title: 'Error!',
						text: response.error,
						icon: 'error',
					})
					}
					// if(response == "success"){
					// 	window.location= "<?php echo base_url('Dashboard/superadmin_dasboard'); ?>";
					// }else if(response == "usersuccess"){
					// 	const returnurl=sessionStorage.getItem("returnurl")
					// 	if(returnurl == null){
					// 		window.location= "<?php echo base_url('Qrcode/luggag_details'); ?>";
					// 	}else{
					// 		window.location=returnurl
					// 	}
					// }else{
					// 	$("#login_error_alert").removeClass("d-none");
					// }
				},
				error:function(xhr, status, errors){
					console.log(xhr.responseText);
				}
			});

		}
  	}); 

	$('#city').on('change', function() {
		var allDetails = this.value;
		var cityDetails = allDetails.split("/");
		var city = cityDetails[0];
		var state = cityDetails[1];
		var country = cityDetails[2];
	
		$.ajax({
			url : '<?php echo base_url(); ?>/Common/getStatedetails',
			type: "POST",
			dataType: "JSON",
			data :  {city: city,state: state,country: country},
			success: function(result){
				$('#state').val(result.state);
				$('#country').val(result.countryName);

				$('#cityid').val(result.citiId);
				$('#stateid').val(result.stateId);
				$('#countryid').val(result.countryId);
				$('#countryCode').text(result.pCode);	
			},
			error:function(xhr, status, errors){
				console.log(xhr.responseText);
			}
		});
	});


	$(".sendotp").click(function(){
		if($('#forgot').parsley().validate()){
			$.ajax({
				url:'<?php echo base_url(); ?>Login/sendResetlink',
				method:"POST",
				dataType: "json",
				data:$('#forgot').serialize(),
				success:function(data){
					if(data.status==2){
						$('.success').hide();
						$('.error').show();
					}else{
						$('.error').hide();
						$('.success').show();
					}
				}
			});
		}		
	});

	$("#otpform").click(function(){
		$.ajax({
			url:'<?php echo base_url(); ?>Login/validateOTP',
			method:"POST",
			data:$('#validaeotp').serialize(),
			success:function(data){
				console.log(response);
				if(response.status == 200){
					window.location= "<?php echo base_url('Dashboard/superadmin_dasboard'); ?>";
				}else{
					Swal.fire({
						title: 'Error!',
						text: response.error,
						icon: 'error',
					})
				}
			}
		});
	});

	$("#reset").click(function(){
        if($('#resetForm').parsley().validate()){
			var number = /([0-9])/;
			var alphabets = /([A-Z])/;
			var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
			if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)){
				$("#password").focus().removeClass('parsley-error');
				$("#conform_password").focus().removeClass('parsley-error');
				$("#reset").prop("type", "submit");
			}else{
				$("#password").focus().addClass('parsley-error');
				$("#conform_password").focus().addClass('parsley-error');
			}
        }
    });

	$(".resetpassword").on("click", function(){
		var password = $('#password').val();
		var confirmPassword = $('#confirm-password').val();

		if (password === '' || confirmPassword === '') {
			$('.bothempty').show();
			event.preventDefault();
			return;
		}
		if (password !== confirmPassword) {
			$('.passwordnotmatch').show();
			$('.passwordcondition').hide();
			event.preventDefault();
		}else{
			if (!/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9]).{6,}$/.test(password)) {
				$('.passwordcondition').show();
				$('.passwordnotmatch').hide();
				event.preventDefault();
			}else{
				$.ajax({
					url:'<?php echo base_url(); ?>Resetpassword/passwordreset',
					method:"POST",
					dataType: "json",
					data:$('#reset-password-form').serialize(),
					success:function(data)
					{
						if(data.status==1){
							$('.success').show();
							$('.passwordnotmatch').hide();
							$('.passwordcondition').hide();
						}
					}
				});

			}
		}

	}); 

	$('#usernameloginbutton').on('click',function() {
		$('#usernamelogin').show();   
		$('#usernameloginbutton').hide();   
		$('#mobileotpform').hide();
		$('#otpbutton').show(); 
	});

	$("#sentotp").click(function(){
		if($('#otp_login').parsley().validate()){
			var mobile = $('#mobileno').val();
			$.ajax({
			url: '<?php echo base_url(); ?>Login/otpsent',
			type: 'post',
			data: { mobile:mobile},
			dataType: 'json',
			success: function(response){
				if(response.status=='succcess'){
					$('.otpsuccess').show();
					$('.otperror').hide();
					$('#mobileotpform').hide();
					$('#usernameloginbutton').hide();
					$('#otpverification').show();
					setTimeout(function () {
						
						
					}, 1000);
				}else{
					$('.otpsuccess').hide();
					$('.otperror').show();
				}
			}
			});
		}
      
    }); 


	$("#verifyotpbutton").click(function(){
		var mobile = $('#mobileno').val();
		var otp = $('#otp').val();
		$.ajax({
			url: '<?php echo base_url(); ?>Login/CheckOTP',
			type: 'post',
			data: { mobile:mobile,otp:otp},
			dataType: 'json',
			success: function(response){
				console.log(response);
				if(response.status == 200){
					window.location= "<?php echo base_url('Dashboard/superadmin_dasboard'); ?>";
				}else{
					$(".verifyerror").show();
				}
			
			}
		});
            
    }); 


});




$(document).ready(
	function(){
		$('#otpbutton').on('click',function(){
			$('#mobileotpform').show();
			$('#otpbutton').hide(); 
			$('#usernameloginbutton').show();
			$('#usernamelogin').hide();
		});
	}
);

</script>




</body>
</html>