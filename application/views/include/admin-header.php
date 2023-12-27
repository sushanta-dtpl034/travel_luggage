<!DOCTYPE html>
<html lang="en" id="demo">
	<head>

		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<!-- Favicon -->
		<link rel="icon" href="<?php echo base_url(); ?>assets/img/brand/favicon.ico" type="image/x-icon"/>
		<!-- Title -->
		<title><?php echo $page_title; ?></title>

		<!-- Default CSS Start -->
		<!-- Bootstrap css-->
		<link  id="style" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
		<!-- Icons css-->
		<link href="<?php echo base_url(); ?>assets/plugins/web-fonts/icons.css" rel="stylesheet"/>
		<link href="<?php echo base_url(); ?>assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/web-fonts/plugin.css" rel="stylesheet"/>
		<link href="<?php echo base_url(); ?>assets/css/icon-list.css" rel="stylesheet" />
		<!-- Style css-->
		<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/boxed.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/dark-boxed.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/skins.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/dark-style.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/colors/default.css" rel="stylesheet">
		<!-- Color css-->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>assets/css/colors/color.css">
		<!-- Select2 css-->
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">

		<!-- Default CSS End -->




		<!-- Internal Quill css-->
		<link href="<?php echo base_url(); ?>assets/plugins/quill/quill.snow.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/quill/quill.bubble.css" rel="stylesheet">

		<!-- DATA TABLE CSS -->
		<link href="<?php echo base_url(); ?>assets/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/plugins/datatable/css/buttons.bootstrap5.min.css"  rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/datatable/css/responsive.bootstrap5.css" rel="stylesheet" />
		

		<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css">
		<link href="<?php echo base_url(); ?>assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url(); ?>assets/plugins/fancyuploder/fancy_fileupload.css" rel="stylesheet" />
		<!-- Internal TelephoneInput css-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/telephoneinput/telephoneinput.css">
		<link href="<?php echo base_url(); ?>/assets/plugins/gallery/gallery.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />	
		<style>
			.hide_div{
				display:none;
			}
			.show_div{
				display:block;
			}
			.loadingOverlay {
					display:    none;
					position:   fixed;
					z-index:    1000;
					top:        0;
					left:       0;
					height:     100%;
					width:      100%;
					background: rgba( 255, 255, 255, .8 ) 
					url('<?php echo base_url(); ?>assets/img/loader.svg') 
					50% 50%
					no-repeat;
				}
				.cat-fileupload,.subcat-fileupload ,.user-fileupload,.companylog,.companystamp{
				  display: none;
				}
				.button-aligh{
					position: absolute;
					bottom: 0px;
					color: red;
				}
				.customize_select{
					background-color: transparent;
					border: 0px;
				}
				.hover-submenu .main-sidebar-body .nav-item.active .nav-link .shape1, .hover-submenu .main-sidebar-body .nav-item.active .nav-link .shape2{ width:19px;}
				.upload-image-thumb { position:relative;}
				.del-icon { position: absolute; width:30px; height:30px; background-color:#f5f5f5; line-height:30px; top:0; right:15px; text-align:center; }
				.del-icon .fa{ color:#252525;}
				
			
	    </style>	
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbuZi1kLIraGC1950pFaOUnGc228vsQrY&libraries=places"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          
	</head> 
