
			<!-- Main Footer-->
			<div class="main-footer text-center">
				<div class="container">
					<div class="row row-sm">
						<div class="col-md-12">
							<span>Copyright © <?php echo date('Y'); ?>. Designed by <a href="#">Dahlia Technologies Pvt Ltd</a> All rights reserved.</span>
						</div>
					</div>
				</div>
			</div>
			<!--End Footer-->
			<!-- Sidebar -->
		</div>
		<!-- End Page -->

		<!-- Default JS Start -->

		<!-- Jquery js-->
		<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap js-->
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<!-- Perfect-scrollbar js -->
		<script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<!-- Sidemenu js -->
		<script src="<?php echo base_url(); ?>assets/plugins/sidemenu/sidemenu.js" id="leftmenu"></script>
		<!-- Sidebar js -->
		<script src="<?php echo base_url(); ?>assets/plugins/sidebar/sidebar.js"></script>
		<!-- Select2 js-->
		<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
		<!-- Sticky js -->
		<script src="<?php echo base_url(); ?>assets/js/sticky.js"></script>
		<!-- Custom js -->
		<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
		<script>var base_url = '<?php echo base_url() ?>';</script>
		<script>var service_value = '<?php echo $this->session->userdata('serviceID'); ?>';</script>
		<script>var userrole = '<?php echo $this->session->userdata('userrole'); ?>';</script>
		<script>var usergroupid = '<?php echo $this->session->userdata('GroupID'); ?>';</script>
		<script>
		$(document).ready(function () {
			$('.dropdown-toggle').dropdown();
		});
		</script>
		<!-- Default JS End -->



		<!-- Internal Parsley js-->
		<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>

		<!-- Internal Form-validation js-->
		<script src="<?php echo base_url(); ?>assets/js/form-validation.js"></script>

		<!-- Internal Data Table js -->
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/table-data.js"></script>
		<!-- <script src="<?php echo base_url(); ?>assets/js/select2.js"></script> -->

		<!-- Internal Chart.Bundle js-->
		<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.bundle.min.js"></script>

		<!-- Peity js-->
		<script src="<?php echo base_url(); ?>assets/plugins/peity/jquery.peity.min.js"></script>

		
		

		<!-- Internal Morris js -->
		<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/morris.js/morris.min.js"></script>

		<!-- Circle Progress js-->
		<!-- <script src="<?php echo base_url(); ?>assets/js/circle-progress.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/chart-circle.js"></script> -->

		
		<!-- Internal Dashboard js-->
		<!-- <script src="<?php echo base_url(); ?>assets/js/index.js"></script> -->


		
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

		<script src="<?php echo base_url(); ?>assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
		
		<script  src="<?php echo base_url(); ?>assets/js/script.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/masters.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/miscellaneous.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/materialcondition.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/services.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assettype.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetsubcat.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetcat.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetincharge.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/addasset.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/removeasset.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/allocateasset.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/systemsetting.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/uom.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/currency.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/company_list.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/location.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/quarter.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/warranty.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/qucode.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/remindersetting.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assestnotifi.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/supervisor_assetsubcat.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/verifyasset.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetverifylist.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetremovelist.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assettransfer.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/luggage.js"></script>

		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script  src="<?php echo base_url(); ?>assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
		<!-- <script src="<?php echo base_url(); ?>assets/plugins/quill/quill.min.js"></script> -->
		<!-- <script src="<?php echo base_url(); ?>assets/js/form-editor.js"></script> -->

		<script src="<?php echo base_url(); ?>assets/plugins/fileuploads/js/fileupload.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/fileuploads/js/file-upload.js"></script>

		<script src="<?php echo base_url(); ?>assets/plugins/gallery/picturefill.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/gallery/lightgallery.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/gallery/lightgallery-1.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/gallery/lg-pager.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/gallery/lg-autoplay.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/gallery/lg-fullscreen.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/gallery/lg-zoom.js"></script>
        <!-- <script src=".<?php echo base_url(); ?>assets/plugins/gallery/lg-hash.js"></script> -->
        <script src="<?php echo base_url(); ?>assets/plugins/gallery/lg-share.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
		
		<script src="<?php echo base_url(); ?>assets/plugins/telephoneinput/telephoneinput.js"></script>
  
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <script type="text/javascript">
                            $(document).ready(function() {
                            $('#sample_list123').multiselect({
								includeSelectAllOption: true
							});
                            });

							
        </script>

<script type="text/javascript">
$(document).ready(function () { 
  $("#example-getting-started").multiselect({
    templates: {
      button: '<button type="button" class="form-select multiselect"  data-bs-toggle="dropdown">',
    }, 
  }); 
}); 
</script> -->


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
		
		<script>
			$(function() {
			  $(".vendor_mobile").intlTelInput();
			});

		</script>	
		

		<!-- <script src="<?php echo base_url(); ?>assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/fancyuploder/jquery.fileupload.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/fancyuploder/fancy-uploader.js"></script> -->
		<script>
			/*
				$( document ).ready(function() {
                  
					if(!service_value && (userrole==2 || userrole==3)){
				
				   $('#staticBackdrop').modal('show');
						$.ajax({
							url: "<?php echo base_url()?>Service/getservices",
							type: "POST",
							cache: false,
							dataType: 'json',
							success: function(result){
								$.each(result, function(index, element) {

									$.each(element, function(k, v) {

										service_markup ="<div class='col-lg-6'>";
										service_markup += "<label class='rdiobox'><input name='service' type='radio' value='"+v.AutoID+"' onchange='service("+v.AutoID+")' > <span>"+v.ServiceName+"</span></label>";
										service_markup += "</div>";
										$("#model_service").append(service_markup);

									});
									
									
								});

								
            
							}
						});
					}	
				});
				function service(service_id){

						$.ajax({
						url: "<?php echo base_url()?>Dashboard/set_service",
						type: "POST",
						cache: false,
						data :{ id:service_id },
						success: function(result){
							if(result){
								var url      = window.location.href;
								location.href = url;
							}
							
						}
					});
		
				}

				*/
		</script>	
		<script>
		
			$('#payment_status').on('change', function (e) {
				$('#status_erroralert').hide();
			});

			$('.payment_mode').on('change', function (e) {
				   var pay_mode = this.value;
				   $('#error_alert').hide();
				    if(pay_mode==1 || pay_mode==3){
					    $('.credit_debit').removeClass('hide_div');
						$('.common').removeClass('hide_div');
						$('.cheque').addClass('hide_div');
						$('.upi').addClass('hide_div');
				   }else if(pay_mode==2){
						$('.upi').removeClass('hide_div');
						$('.common').addClass('hide_div');
						$('.cheque').addClass('hide_div');
						$('.credit_debit').addClass('hide_div');
				   }else if(pay_mode==4){
						$('.cheque').removeClass('hide_div');
						$('.common').removeClass('hide_div');
						$('.credit_debit').addClass('hide_div');
						$('.upi').addClass('hide_div');
				   }
			});
		</script>	
	<script>
		$("#subcriberedit").click(function(){
		  var payment_status = $('#payment_status').val();
		  var payement_mode = $('#payment_mode').val();
		   if(!payment_status){
            $('#status_erroralert').show();
		  }
		  else if(payment_status==1){
		 
		  if(!payement_mode){
			$('#error_alert').show();
		  }else{

			  var success = 1;
			if(payement_mode==1 || payement_mode==3){
				if(!$('#transaction_number').val()){
				 $('#transaction_number').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#card_number').val()){
				 $('#card_number').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#acount_number').val()){
				 $('#acount_number').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#acountholder_name').val()){
				 $('#acountholder_name').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#bank_name').val()){
				 $('#bank_name').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#ifsc_code').val()){
				 $('#ifsc_code').addClass('parsley-error');
				 success = 0;
			   }
		    }else if(payement_mode==2){
				if(!$('#upi_trans_id').val()){
				  $('#upi_trans_id').addClass('parsley-error');
				  success = 0;
				}
				if(!$('#upi_id').val()){
				  $('#upi_id').addClass('parsley-error');
				  success = 0;
				}
			}else if(payement_mode==4){
				if(!$('#cheque_number').val()){
				  $('#cheque_number').addClass('parsley-error');
				  success = 0;
				}
				if(!$('#acount_number').val()){
				 $('#acount_number').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#acountholder_name').val()){
				 $('#acountholder_name').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#bank_name').val()){
				 $('#bank_name').addClass('parsley-error');
				 success = 0;
			   }
			   if(!$('#ifsc_code').val()){
				 $('#ifsc_code').addClass('parsley-error');
				 success = 0;
			   }
				
			}

			if(success==1){

				$.ajax({
					url: "<?php echo base_url()?>Subscribers/subscribers_update",
					type: "POST",
					cache: false,
					data : $("#subscriber_edit").serialize(),
					success: function(result){
						if(result.status){
                           location.href="<?php echo base_url()?>Subscribers/subscribers_list/1";
						}
					}
				});

			}


		  }
		}else if(payment_status!=1){
			$.ajax({
					url: "<?php echo base_url()?>Subscribers/subscribers_update",
					type: "POST",
					cache: false,
					data :$("#subscriber_edit").serialize(),
					success: function(result){
						if(result.status){
                           location.href="<?php echo base_url()?>Subscribers/subscribers_list/1";
						}
						
					}
				});
		
		  } 
		});

		function remove_errorclass(field_id){
			$('#'+field_id).removeClass('parsley-error');
		}

		var status = '<?php echo $this->uri->segment(3); ?>';
		var fun = '<?php echo $this->uri->segment(2); ?>';
        if(status==1 && fun=='subscribers_list'){
			setInterval(function(){ location.href="<?php echo base_url()?>Subscribers/subscribers_list/"; }, 3000);
		}
	</script>	

<script>

function datatable(){
	var table = $('#material_table').DataTable( {
		"processing": true,
		"serverSide": false,
		"order": [[ 0, "asc" ]],
		
		//dom: 'Bfrtip',
        buttons: [
            
            {
                extend: 'excelHtml5',
				title: 'Any title for file',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            },
            
        ],
		"ajax": {
			"url": "<?php echo base_url(); ?>Material/get_materiallist",
			"type": "POST",
			
		},
		"columns": [
				{
					"render": function(data, type, row, meta ) {
					return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
			{ "data": "ConditionName"},
			{ "render": function ( AutoID, type, row, meta ) {
            return '<button class="btn update bg-success btn-sm mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple materialdelete btn-danger btn-sm" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
          }
        }
			
		],
		
	"drawCallback": function( settings ) {
			
		},
		"initComplete": function( settings, json ) {
			
		}
		
	} );

	/* save the material condiotn */


}
$( function() {
datatable();
});

 $("#material").click(function(){
    if($('#material_form').parsley().validate())
     {
         var planurl = $('#planurl').val();
         $.ajax({
                 url : '<?php echo base_url('Material/save_material'); ?>',
                 type: "POST",
                 data : $("#material_form").serialize(),
                 success: function(result)
                 {
                    var jsonData = JSON.parse(result);
						 if(jsonData.status===1){
						$("#materialmodal .btn-secondary").click()
                         $('.insert').show();
       					 $('#material_form').trigger("reset");
                    setInterval(function(){
                             $('.insert').hide();
                            //  table.ajax.reload();
                             location.href='<?php echo base_url('Material/materialcondotionlist') ?>';
                         },2000);
                     }else{
						$("#materialmodal .btn-secondary").click()
						 $('#material_form').trigger("reset");
                         $('.alert-solid-warning').show();
                          setInterval(function(){ 
                            $('.alert-solid-warning').hide();
                            // table.ajax.reload();
                            location.href='<?php echo base_url('Material/materialcondotionlist') ?>';
                            },2000);
                     }
                 },
               
             });
     }

}); 

$("#material_table").on('click', '.update', function(){
	var id = $(this).attr("id");
    $.ajax({
        url: '<?php echo base_url('Material/getmaterial_edit'); ?>',
        type: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(response){
           if(response.status == 1){
				$('#updatematerialmodal').modal('show');  
				$('#up_conditionname').val(response.data.ConditionName);
				$('#updateid').val(response.data.AutoID);
           }else{
             alert("Invalid ID.");
           }
        }
     });

});


$("#updatematerial").click(function(){
    if($('#updatematerialform').parsley().validate())
     {
     
         $.ajax({
                 url : '<?php echo base_url('Material/material_update'); ?>',
                 type: "POST",
                 data : $("#updatematerialform").serialize(),
                 success: function(result)
                 {
                     var jsonData = JSON.parse(result);
                     if(jsonData.status===1){
                         $('#updatematerialmodal').modal('toggle');
                         $('.update').show();
                         setInterval(function(){ 
                             $('.update').hide();
                             location.href='<?php echo base_url('Material/materialcondotionlist'); ?>';
                            },2000);
                     }else{
                         $('#updatematerialmodal').modal('toggle');
                         $('.alert-solid-warning').show();
                         setInterval(function(){ 
                             $('.alert-solid-warning').hide();
                             location.href='<?php echo base_url('Material/materialcondotionliste'); ?>';
                            },2000);
                         
                     }
                 },
                
             });
     }

}); 

$('#material_table').on('click','.materialdelete',function(){
    var id = $(this).attr('id');
    var deleteConfirm = confirm("Are you sure?");
    if (deleteConfirm == true) {
       // AJAX request
       $.ajax({
         url: base_url+'Material/deletematerial',
         type: 'post',
         data: {id: id},
         success: function(response){
            if(response == 1){
				location.href='<?php echo base_url('Material/materialcondotionlist'); ?>';
                table.ajax.reload();
            }else{
               alert("Invalid ID.");
            }
         }
       });
    } 

 });

</script>   
   
     <script>
		$('#mailsend').on('click', () => { 
					// Get HTML content
					var myEditor = document.querySelector('#quillEditor')
					var html = myEditor.children[0].innerHTML
					$('#hiddenArea').val( html )
					$.ajax({
						url: base_url+'Masters/Material_sendmail',
						type:'post',
						data :$("#sendmail_form").serialize(),
						beforeSend: function() {
                                $('#mailsend').hide();
								$('.loading').show();
                         },
						success: function(response){
							if(response == 1){
							  location.href='<?php echo base_url('Masters/superad_materialcon'); ?>';
							}else{
							  location.href='<?php echo base_url('Masters/superad_materialcon'); ?>';
							}
						}
					});
			})
     </script>
	  <script>
		$('#mailsetting-ins').on('click', () => { 
					// Get HTML content
					var myEditor = document.querySelector('#quillEditor')
					var html = myEditor.children[0].innerHTML
					$('#hiddenArea').val( html )
					$.ajax({
						url: base_url+'Masters/materialemailconf_save',
						type:'post',
						data :$("#mailconf").serialize(),
						beforeSend: function() {
                                $('#mailsetting-ins').hide();
								$('.loading').show();
                         },
						success: function(response){
							if(response == 1){
							  location.href='<?php echo base_url('Masters/superad_materialcon'); ?>';
							}else{
							  location.href='<?php echo base_url('Masters/superad_materialcon'); ?>';
							}
						}
					});
			})
     </script>	
	 <script>
		 $('#currency_country').on('change', function() {
           var countryid = this.value;
 
  
   
    $.ajax({
        url : '<?php echo base_url(); ?>/Common/getoneCountrydetails',
        type: "POST",
        dataType: "JSON",
        data :  {countryid: countryid},
        success: function(result)
        {
			 $('#currency_name').val(result.CurrencyName);
             $('#currency_code').val(result.CurrencyCode);
             $('#currency_symbole').val(result.CurrencySymbol);
        },
        error: function ()
        {
     
        }
    });
    


});
	 </script>	 	
	 <script>
		 

				$(document).ready(function() {


				var readURL = function(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
						$('.profile-pic').attr('src', e.target.result);
						}


						}
						reader.readAsDataURL(input.files[0]);

						
				}


				$(".file-upload").on('change', function(){
				   readURL(this);
				});

				$(".upload-button").on('click', function() {
				$(".file-upload").click();
				});
				});
				// $(document).on('click','.profile_remove',function(){
				//     $(".profile-pic").attr("src","<?php echo base_url(); ?>/assets/img/users/1.jpg");
				// });

				$('#profile_city').on('change', function() {
  var allDetails = this.value;
  var cityDetails = allDetails.split("/");
  var city = cityDetails[0];
  var state = cityDetails[1];
  var country = cityDetails[2];
   
    $.ajax({
        url : ' <?php echo base_url(); ?>Common/getStatedetails',
        type: "POST",
        dataType: "JSON",
        data :  {city: city,state: state,country: country},
        success: function(result)
        {
             $('#profile_state').val(result.state);
             $('#profile_country').val(result.countryName);
			 $('#pro_cityid').val(result.state);
             $('#pro_stateid').val(result.stateid);
			 $('#pro_countryid').val(result.countryid);
			 $('#pro_cityname').val(result.city);
             $('#pro_statename').val(result.state);
			 $('#pro_countrname').val(result.countryName);
        },
        error: function ()
        {
     
        }
    });
    


});
	 </script>	 
	 <script>
		 
		 $('#profileedit_button').on('click', function() {


				$.ajax({
					url : ' <?php echo base_url(); ?>Profile/profile_update',
					type: "POST",
					data :  $("#profile_edit").serialize(),
					success: function(result)
					{
						$('.profile_data').show().focus();
						
					}
				
				});
			

		 });


			$('#project_image').on('click', function() {

					var fd = new FormData();
					var files = $('#file')[0].files;

					if(files.length > 0 ){
					fd.append('file',files[0]);
					}else{
					alert("Please select a file.");
					}
					
					var old_image =  $('#old_image').val();
					var id =  $('#updated_id').val();
					fd.append('id',id);
					fd.append('old_image',old_image);
						
					$.ajax({
						url: '<?php echo base_url(); ?>Profile/profileimage_save',
						type: 'post',
						data: fd,
						contentType: false,
						processData: false,
						success: function(response){
							if(response){
                               $('.profile_success').show();
							   setInterval(function(){ location.href="<?php echo base_url('profile/sup_profile'); ?>"; }, 3000);
							}
						},
					});


			});


			

		

		
	
		 
	</script>
	<script type="text/javascript">
window.Parsley.addValidator('uppercase', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var uppercases = value.match(/[A-Z]/g) || [];
    return uppercases.length >= requirement;
  },
  messages: {
    en: 'Your password must contain at least (%s) uppercase letter.'
  }
});

//has lowercase
window.Parsley.addValidator('lowercase', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var lowecases = value.match(/[a-z]/g) || [];
    return lowecases.length >= requirement;
  },
  messages: {
    en: 'Your password must contain at least (%s) lowercase letter.'
  }
});

//has number
window.Parsley.addValidator('number', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var numbers = value.match(/[0-9]/g) || [];
    return numbers.length >= requirement;
  },
  messages: {
    en: 'Your password must contain at least (%s) number.'
  }
});

//has special char
window.Parsley.addValidator('special', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var specials = value.match(/[^a-zA-Z0-9]/g) || [];
    return specials.length >= requirement;
  },
  messages: {
    en: 'Your password must contain at least (%s) special characters.'
  }
});

		$("#pass_change").click(function(){
			if($('#change_password').parsley().validate())
			{
				$.ajax({
					url : ' <?php echo base_url(); ?>Profile/update_password',
					type: "POST",
					data :  $("#change_password").serialize(),
					success: function(result)
					{
						$('.change_success').show().focus();
						setInterval(function(){ location.href="<?php echo base_url('profile/change_password'); ?>"; }, 3000);
						
					}
				
				});
			
			}
		});

		$(".btnTooltip").on('click',function() {
			var id = $(this).attr("data-id");
			$.ajax({
            url: base_url + 'Assetmanagement/getoneasset',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 1) {
                    $('#addassetview_form').trigger("reset");
                     $('#assetview_model').modal('show');
                    $('#view_assetownerid').val(response.data.AssetOwner);
                    $('#view_assettype').val(response.data.AsseTypeName);
                    $('#vew_assetcat').val(response.data.AsseCatName);
                    $('#view_assetsubcat').val(response.data.AssetSubcatName);
                    $('#view_assetUIN').val(response.data.UIN);
                    $('#viewasset_dimenson').val(response.data.DimensionOfAsset);
                    $('#view_depreciationrate').val(response.data.DepreciationRate);
                    $('#view_assetmentcondition').val(response.data.ConditionName);
                    $('#view_assetauditorname').val(response.data.auditor);
                    $('#view_asstmaninchargename').val(response.data.incharge);
                    $('#view_assetsupervisorname').val(response.data.supervisor);
                    $('#view_assettitle').val(response.data.AssetTitle);
                    $('#view_assetqty').val(response.data.AssetQuantity);
                    // $('#update_assetqty').val(response.data.AssetQuantity);
                    $('#view_company_location').val(response.data.Location).change();
                    $('#view_current_location').val(response.data.CurrentLocation);

                } else {
                    alert("Invalid ID.");
                }
            }
        });
		});

</script>

	</body>
</html>