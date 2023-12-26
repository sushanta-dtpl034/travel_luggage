
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
<meta name="description" content="Spruha -  Admin Panel HTML Dashboard Template">
<meta name="author" content="Spruko Technologies Private Limited">
<meta name="keywords" content="Asset Management">

<!-- Favicon -->
<link rel="icon" href="<?php echo base_url(); ?>assets/img/brand/favicon.ico" type="image/x-icon"/>
<!-- Title -->
<title><?= isset($page_title)?$page_title:''?></title>

<!-- Default CSS Start -->
<!-- Bootstrap css-->
<link  id="style" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>


<!-- Icons css-->
<link href="<?php echo base_url(); ?>assets/plugins/web-fonts/icons.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/web-fonts/plugin.css" rel="stylesheet"/>


<!-- Style css-->
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/boxed.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/dark-boxed.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/skins.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/dark-style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/colors/default.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>assets/css/custom-style.css" rel="stylesheet">
<!-- Color css-->
<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>assets/css/colors/color.css">
<!-- Select2 css-->
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">

<?php if(isset($page_css[0]) == 'list'){ ?> 
<!-- DATA TABLE CSS -->
<!-- <link href="<?php echo base_url(); ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> -->
<link href="<?php echo base_url(); ?>assets/plugins/datatable/css/buttons.bootstrap5.min.css"  rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/datatable/css/responsive.bootstrap5.css" rel="stylesheet" /> 
<?php } ?>

<?php if(isset($page_css[0]) == 'form'){ ?> 
	<link href="<?php echo base_url(); ?>/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
<?php } ?>
<?php if(isset($page_css[0]) == 'other'){ ?> 

<?php } ?>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<script src='https://code.jquery.com/jquery-1.12.3.js'></script>
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Default CSS End -->	
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbuZi1kLIraGC1950pFaOUnGc228vsQrY&libraries=places"></script>          

