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

<?php if(isset($page_css[0]) == 'list'){ ?> 
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
<?php } ?>
<?php if(isset($page_css[0]) == 'form'){ ?> 
<!-- Internal Form-validation js-->
<script src="<?php echo base_url(); ?>assets/js/form-validation.js"></script>
<!-- Internal Parsley js-->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
<?php } ?>
<?php if(isset($page_css[0]) == 'other'){ ?> 

<?php } ?>

<script>
$(document).ready(function () {
	$('.dropdown-toggle').dropdown();
	$(".vendor_mobile").intlTelInput();
});
</script>
<!-- Default JS End -->
	<script>
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
	</script>
		
	</body>
</html>