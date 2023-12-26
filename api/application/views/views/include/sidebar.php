<?php 
$IsAdmin =($this->session->userdata("userdata"))? $this->session->userdata("userdata")['IsAdmin']:1; ?>
<body class="main-body leftmenu hover-submenu">

	<!-- Loader -->
	<div id="global-loader">
		<img src="<?php echo base_url(); ?>assets/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- Modal -->
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
					$height = $this->session->userdata('height');
					$width = $this->session->userdata('width');
					$logo = $this->session->userdata('logo');
					if (!empty($height) && !empty($width) && !empty($logo)) {
					// $url = base_url() . 'upload/setting/' . $logo;
					$url = base_url() . 'assets/img/logo3.png';
					
					} else {
					$url = base_url() . 'assets/img/logo3.png';
					}
				?>
					<img src="<?php echo $url; ?>" class="header-brand-img desktop-logo" alt="logo" width="100"
					height="100">
					<img src="<?php echo $url; ?>" class="header-brand-img icon-logo" alt="logo" width="100"
					height="100">
					<img src="<?php echo $url; ?>" class="header-brand-img desktop-logo theme-logo" alt="logo"
					width="100" height="100">
					<img src="<?php echo $url; ?>" class="header-brand-img icon-logo theme-logo" alt="logo"
					width="100" height="100">
					
				</a>
			</div>
			<?php if($this->session->userdata("userdata")){ ?>
			<div class="main-sidebar-body">
				<?php
				
				$auditor = $this->session->userdata("userdata")['Isauditor'];
				$supervisor = $this->session->userdata("userdata")['issupervisor'];
				$admin = $this->session->userdata("userdata")['IsAdmin'];
				$userrole = $this->session->userdata('GroupID');
				if (isset($userrole)) {

					?>
					<ul class="nav">
					<?php
					if ($userrole == 1) {
						?>
						<li class="nav-header"><span class="nav-label">Dashboard</span></li>
						<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>Dashboard/admin_dasboard"><span
							class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i><span
							class="sidemenu-label">Dashboard</span></a>
						</li>
						<li class="nav-item">
						<a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
							class="ti-user sidemenu-icon"></i><span class="sidemenu-label">Subscription </span></a>
						<ul class="nav-sub">
							<li class="side-menu-label1"><a href="#">Subscription</a></li>
							<li class="nav-sub-item">
							<a class="nav-sub-link" href="<?php echo base_url(); ?>Plan/planList">Subscription Plan</a>
							</li>
							<li class="nav-sub-item">
							<a class="nav-sub-link" href="<?php echo base_url(); ?>Subscribers/subscribers_list">Subscribers</a>
							</li>
						</li>
					</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>Material/materialcondotionlist"><span
							class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i><span
							class="sidemenu-label">Material Condition</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>Service/services_list"><span class="shape1"></span><span
							class="shape2"></span><i class="ti-home sidemenu-icon"></i><span class="sidemenu-label">Service
							Master</span></a>
					</li>

					<?php
					} else if ($userrole == 2 || $userrole == 3 || $userrole == 4) {
						?>
						<br>
						<li class="nav-item">
						<a class="nav-link tt" href="<?php echo base_url(); ?>Dashboard/superadmin_dasboard">
							<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
							<span class="sidemenu-label">Dashboard</span></a>
						</li>
						<!-- <li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/index">
							<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
							<span class="sidemenu-label">Luggage QR Code</span></a>
						</li> -->
						<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/luggag_details">
							<span class="shape1"></span><span class="shape2"></span>
							<i class="fa fa-plane sidemenu-icon"></i>
							<span class="sidemenu-label">Luggage Details</span></a>
						</li>

						
						
						<?php

						if ($this->session->userdata('serviceID') == 1) {
						///////start assetmanagement
						?>


						<?php
						// if($userrole==1 || $userrole==2){
						if ($admin == 1) {
							?>
							<li class="nav-item">
							<a class="nav-link"
								href="<?php echo ($IsAdmin == 1 ? base_url('Usercontroller/user_list_admin') : base_url('Usercontroller/user_list')); ?>"><span
								class="shape1"></span><span class="shape2"></span><i class="ti-layout-grid2-alt sidemenu-icon"></i><span
								class="sidemenu-label">Asset User Controller</span></a>
							</li>

							<li class="nav-item">
							<a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
								class="ti-server sidemenu-icon"></i><span class="sidemenu-label">Asset Master</span></a>
							<ul class="nav-sub">
								<li class="side-menu-label1"><a href="#">Asset Master</a></li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Currency">Currency Master</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Company/company_list">Company Master</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Location/Location_list">Location Master</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Asset/uom_list"> Measurement Master</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Asset/assettype_list">Asset Type Master</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Asset/assetcat_list">Asset Category</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Asset/assetsubcat_list">Sub Category</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Material/super_materialcondotionlist">Material
									Condition</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Quarterly/Quarterly_list">Quarter Master</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Asset/warranty_list">Warranty Master</a>
								</li>
								<!-- <li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Asset/remnindersetting_list">Reminder Setting</a>
								</li>-->
							</li>
							</ul>

							</li>
						<?php }else{ ?>
							<br>
							<li class="nav-item">
							<a class="nav-link tt" href="<?php echo base_url(); ?>Dashboard/superadmin_dasboard">
								<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
								<span class="sidemenu-label">Dashboard</span></a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/index">
								<span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i>
								<span class="sidemenu-label">Luggage QR Code</span></a>
							</li> -->
							<li class="nav-item">
								<a class="nav-link tt" href="<?php echo base_url(); ?>Qrcode/luggag_details">
								<span class="shape1"></span><span class="shape2"></span>
								<i class="fa fa-plane sidemenu-icon"></i>
								<span class="sidemenu-label">Luggage Details</span></a>
							</li>
						<?php } ?>


						<?php if ($admin == 1 || $auditor == 1 || $supervisor == 1) {
							?>

							<li class="nav-item">
							<a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
								class="ti-layout-grid3-alt sidemenu-icon"></i><span class="sidemenu-label">Asset Management</span></a>
							<ul class="nav-sub">
								<li class="side-menu-label1"><a href="#">Asset Management</a></li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Assetmanagement/assetform_list">Asset Manage</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Assetmanagement/view_verifyassest">Verify/Remove
									Asset</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link"
									href="<?php echo base_url(); ?>Assetmanagement/assetnotification_list">Verification Reminder</a>
								</li>
								<li class="nav-sub-item">
								<a class="nav-sub-link" href="<?php echo base_url(); ?>Assetmanagement/allocateasset_list">Allocate
									Asset</a>
								</li>

								<!-- <li class="nav-sub-item">
													<a class="nav-sub-link" href="<?php echo base_url(); ?>Assetmanagement/assetform_list">Verify Asset</a>
												</li>
												<li class="nav-sub-item">
													<a class="nav-sub-link" href="<?php echo base_url(); ?>Dashboard/commingsoon">Remove Asset</a>
												</li> -->
								<!-- <li class="nav-sub-item">
													<a class="nav-sub-link" href="<?php echo base_url(); ?>Assetmanagement/qr_form">QR</a>
												</li> -->
								<!-- <li class="nav-sub-item">
													<a class="nav-sub-link" href="#">Asset handling instructions
													</a>
												</li>
												<li class="nav-sub-item">
													<a class="nav-sub-link" href="#">Location Master
													</a>
												</li> -->
							</li>
							</ul>

							</li>
							<?php
							if ($admin == 1 ||  $supervisor == 1){
							?>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
								class="ti-layout-grid3-alt sidemenu-icon"></i><span class="sidemenu-label">QR Code Management</span></a>
								<ul class="nav-sub">
									<li class="side-menu-label1"><a href="#">QR Code Management</a></li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="<?php echo base_url(); ?>Qrcode/index">QR Code Generate</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="<?php echo base_url(); ?>Assetmanagement/print_barcode_label">Print QR Code
										Label</a>
									</li>


								
									</ul>
								</li>
							<?php
							}
							?>

							</li>
						<?php
						}

						if (($admin != 1 && $supervisor == 1) || ($admin != 1 && $auditor == 1)) { ?>

							<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url(); ?>Asset/supervisor_assetsubcat_list">
								<span class="shape1"></span><span class="shape2"></span><i class="ti-eye sidemenu-icon"></i>
								<span class="sidemenu-label">View Sub Category</span></a>
							</li>
						<?php }
						if ($admin != 1 && $auditor != 1 && $supervisor != 1) { ?>

							<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url(); ?>Assetmanagement/assetnotification_list">
								<span class="shape1"></span><span class="shape2"></span><i class="fe fe-bell sidemenu-icon"></i>
								<span class="sidemenu-label">Verification Reminder</span></a>
							</li>
						<?php } ?>

						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url(); ?>Asset/myassets_list">
							<span class="shape1"></span><span class="shape2"></span><i class="ti-mouse-alt sidemenu-icon"></i>
							<span class="sidemenu-label">My Assets</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url(); ?>Asset/assetransfer_list">
							<span class="shape1"></span><span class="shape2"></span><i class="mdi mdi-arrow-collapse sidemenu-icon"></i>
							<span class="sidemenu-label">Asset Transfer</span></a>
						</li>

						<?php
						if ($admin == 1) {
							?>
							<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url(); ?>Systemsetting/view_setting">
								<span class="shape1"></span><span class="shape2"></span><i class="mdi mdi-settings sidemenu-icon"></i>
								<span class="sidemenu-label">System Setting</span></a>
							</li>
						<?php

						}
						?>
						<?php
						} ///////end assetmanagement
						if ($this->session->userdata('serviceID') == 2) {
						?>

						<li class="nav-item">
							<a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
								class="ti-server sidemenu-icon"></i><span class="sidemenu-label">Inventory Master</span></a>
							<ul class="nav-sub">
							<li class="side-menu-label1"><a href="#">Inventory Master</a></li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Location Master</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Section Master</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Factory / Office Master</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#"> Total Area of Office / Factory </a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Equpment Handling Master
								</a>
							</li>

						</li>
						</ul>
						<li>
						<?php
						}
						if ($this->session->userdata('serviceID') == 3) {
						?>
						<li class="nav-item">
							<a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
								class="ti-server sidemenu-icon"></i><span class="sidemenu-label">Dismantling Master</span></a>
							<ul class="nav-sub">
							<li class="side-menu-label1"><a href="#">Dismantling Master</a></li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Location Master</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Section Master</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Factory / Office Master</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#"> Total Area of Office / Factory </a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Equpment Handling Master
								</a>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="#">Cutting instruction master
								</a>
							</li>

						</li>
						</ul>

						</li>
						<?php
						}
						?>
					<?php
					}
					?>
					</ul>
					<?php

				}
				?>
			</div>

			<?php } ?>
		</div>
		<!-- End Sidemenu -->