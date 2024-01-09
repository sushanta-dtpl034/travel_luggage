
<body class="main-body leftmenu hover-submenu">
	<!-- Loader -->
	<div id="global-loader">
		<img src="<?php echo base_url(); ?>assets/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- Modal -->
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Select Service</h5>
				</div>
				<div class="modal-body" id="model_service">

				</div>
				<div class="modal-footer">

				</div>
			</div>
		</div>
	</div>

	<!-- Page -->
	<div class="page">
		<!-- Sidemenu -->
		<div class="main-sidebar main-sidebar-sticky side-menu">
			<div class="sidemenu-logo" style="width: 232px;">
				<a class="main-logo" href="<?php echo base_url('/Dashboard/superadmin_dasboard'); ?>">
				<?php
					$height = ($this->session->userdata('height'))?$this->session->userdata('height'):120;
					$width = ($this->session->userdata('width'))?$this->session->userdata('width'):120;
					$logo = $this->session->userdata('logo');
					if (!empty($height) && !empty($width) && !empty($logo)) {
						//$url = base_url() . 'upload/setting/' . $logo;
						$url = base_url() . 'assets/img/logo3.png';
					}else{
						$url = base_url() . 'assets/img/logo3.png';
					}
				?>
					<img src="<?php echo $url; ?>" class="header-brand-img desktop-logo" alt="logo" width="<?php echo $width; ?>"
					height="<?php echo $height; ?>">
					<img src="<?php echo $url; ?>" class="header-brand-img icon-logo" alt="logo" width="<?php echo $width; ?>"
					height="<?php echo $height; ?>">
					<img src="<?php echo $url; ?>" class="header-brand-img desktop-logo theme-logo" alt="logo"
					width="<?php echo $width; ?>" height="<?php echo $height; ?>">
					<img src="<?php echo $url; ?>" class="header-brand-img icon-logo theme-logo" alt="logo"
					width="<?php echo $width; ?>" height="<?php echo $height; ?>">
					
				</a>
			</div>
			<div class="main-sidebar-body">
				<ul class="nav mt-4">
					<?php $IsAdmin = $this->session->userdata('userisadmin');?>
					<?php if(intval($IsAdmin) === 1){ ?>
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Dashboard/superadmin_dasboard">
								<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
								<span class="sidemenu-label">Dashboard</span>
							</a>
						</li>
						
						
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>TravelerController">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-user sidemenu-icon"></i>
								<span class="sidemenu-label">Manage User</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>ItineraryController">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa  fa-list-alt sidemenu-icon"></i>
								<span class="sidemenu-label">Manage Itinerary</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>TravelLuggageController">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-suitcase sidemenu-icon"></i>
								<span class="sidemenu-label">Manage Luggage</span>
							</a>
						</li>						
						<!-- <li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/index">
							<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
							<span class="sidemenu-label">Luggage QR Code</span></a>
						</li> -->
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/index">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-qrcode sidemenu-icon"></i>
								<span class="sidemenu-label">Manage QR Code</span>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/airline">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-plane sidemenu-icon"></i>
								<span class="sidemenu-label">Manage Airlines</span>
							</a>
						</li>
					<?php } if($this->session->userdata('userisadmin') === 0){ ?>
						<!--<li class="nav-item">
						<a class="nav-link tt" href="<?php echo base_url(); ?>Dashboard/superadmin_dasboard">
							<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
							<span class="sidemenu-label">Dashboard</span></a>
						</li>-->
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>TravelerController">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-user sidemenu-icon"></i>
								<span class="sidemenu-label">Manage User</span>
							</a>
						</li>
						

						<!-- <li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/luggag_details">
							<span class="shape1"></span><span class="shape2"></span>
							<i class="fa fa-plane sidemenu-icon"></i>
							<span class="sidemenu-label">Luggage Details</span></a>
						</li> -->
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>TravelLuggageController">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-suitcase sidemenu-icon"></i>
								<span class="sidemenu-label">Manage Luggage</span>
							</a>
						</li>	

						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Login/logout">
							<span class="shape1"></span><span class="shape2"></span>
							<i class="fe fe-power sidemenu-icon"></i>
							<span class="sidemenu-label">Sign Out</span></a>
						</li>

					<?php }else{ ?>
						<li class="nav-item">
						<a class="nav-link tt" href="<?php echo base_url(); ?>Login/logout">
						<span class="shape1"></span><span class="shape2"></span>
						<i class="fa fa-sign-in-alt sidemenu-icon"></i>
						<span class="sidemenu-label">Login</span></a>
					</li>
					<?php } ?>
				</ul>
			</div>

		</div>
		<!-- End Sidemenu -->