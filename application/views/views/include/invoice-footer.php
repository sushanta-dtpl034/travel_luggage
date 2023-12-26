
			<!-- Main Footer-->
			<div class="main-footer text-center">
				<div class="container">
					<div class="row row-sm">
						<div class="col-md-12">
							<span>Copyright © 2021 <a href="#">Dahlia</a>. Designed by <a href="#">Dahlia Technologies Pvt Ltd</a> All rights reserved.</span>
						</div>
					</div>
				</div>
			</div>
			<!--End Footer-->

			<!-- Sidebar -->
		</div>
		<!-- End Page -->

		
		<!-- Jquery js-->
		<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js-->
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

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

		<!-- Select2 js-->
		<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>

		<!-- Perfect-scrollbar js -->
		<script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

		<!-- Sidemenu js -->
		<script src="<?php echo base_url(); ?>assets/plugins/sidemenu/sidemenu.js" id="leftmenu"></script>

		<!-- Sidebar js -->
		<script src="<?php echo base_url(); ?>assets/plugins/sidebar/sidebar.js"></script>

		<!-- Internal Morris js -->
		<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/morris.js/morris.min.js"></script>

		<!-- Circle Progress js-->
		<script src="<?php echo base_url(); ?>assets/js/circle-progress.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/chart-circle.js"></script>

		<!-- Internal Dashboard js-->
		<script src="<?php echo base_url(); ?>assets/js/index.js"></script>

		<!-- Sticky js -->
		<script src="<?php echo base_url(); ?>assets/js/sticky.js"></script>

		<!-- Custom js -->
		<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
		

		<script>var base_url = '<?php echo base_url() ?>';</script>
		<script>var service_value = '<?php echo $this->session->userdata('serviceID'); ?>';</script>
		<script>var userrole = '<?php echo $this->session->userdata('userrole'); ?>';</script>
		<script  src="<?php echo base_url(); ?>assets/js/script.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/masters.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/miscellaneous.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/materialcondition.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/services.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assettype.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetsubcat.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/assetcat.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/custom/uom.js"></script>
	
		
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script  src="<?php echo base_url(); ?>assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/quill/quill.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/form-editor.js"></script>
	
		<script>
			$(function () {
				//Date picker
				$('#datepicker-date').datepicker({
				   autoclose: true
				})
			})
			
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
            return '<button class="btn update bg-success mx-2" id="'+row.AutoID+'"  datatype="edit"><i class="si si-pencil"></i></button><button class="btn ripple materialdelete btn-info mx-2" id="'+row.AutoID+'"><i class="fe fe-trash"></i></button>';
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

	</body>
</html>