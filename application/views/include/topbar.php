        	
			
			<!-- Main Header-->
			<div class="main-header side-header sticky">
				<div class="container-fluid">
					<div class="main-header-left">
						<a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
					</div>
					<div class="main-header-center">
						<div class="responsive-logo">
							<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/brand/logo3.png" class="mobile-logo" alt="logo" height="50" width="50"></a>
						        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/brand/logo-light.png" class="mobile-logo-dark" alt="logo"></a>
						</div>
					</div>
					<?php if($this->session->userdata("userdata")){ ?>
					
					<div class="main-header-right">
						<div class="dropdown main-profile-menu">
							<a class="d-flex" href="">
								<?php if(!empty($this->session->userdata('profile'))){ ?>
									<span class="main-img-user" >
										<img alt="avatar" src="<?php echo base_url(); ?><?php echo $this->session->userdata('profile'); ?>">
									</span> 
								<?php }else{ ?>
									<span class="main-img-user" >
										<img alt="avatar" src="<?php echo base_url(); ?>assets/img/users/avatar-2.jpg">
									</span>
								<?php } ?>
							</a>
							<div class="dropdown-menu">
								<div class="header-navheading">
									
									<h6 class="main-notification-title"><b><?php $CompanyName = $this->session->userdata('CompanyName'); $username = $this->session->userdata('username'); if(!empty($CompanyName)){ echo $CompanyName;}else{ echo $username; }?></b></h6>
									<p class="main-notification-text">
									<?php 
										$IsAdmin = $this->session->userdata('userisadmin');
										if($IsAdmin == 1){
											echo "Admin"; 
										}
										else{
											echo "User";
										}
									?>
										</p>
								</div>
								<!-- <a class="dropdown-item border-top" href="#">
								<i class="fe fe-check"></i>
									<?php
									/*
									    if($this->session->userdata('serviceID')==1){
                                            ?>
											 <p style="color:green;">Asset Management</p>
											<?php
										}else if($this->session->userdata('serviceID')==2){
											?>
											 <p style="color:blue;">As Built Inventory</p>
											<?php
										}else if($this->session->userdata('serviceID')==3){
											?>
											 <p style="color:orange;">Dismantling</p>
											<?php
										}
										*/
									?>
								   
								</a> -->
								<!-- <a class="dropdown-item border-top" href="<?php echo base_url("profile/sup_profile"); ?>">
									<i class="fe fe-user"></i> My Profile
								</a>
								<a class="dropdown-item border-top" href="<?php echo base_url("profile/change_password"); ?>">
									<i class="fe fe-user"></i> Change Password
								</a> -->
								<!-- <a class="dropdown-item" href="#">
									<i class="fe fe-settings"></i> Account Settings
								</a> -->
								<a class="dropdown-item" href="<?php echo base_url()."/Login/logout"; ?>">
									<i class="fe fe-power"></i>Sign Out
								</a>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<!-- End Main Header-->
		


			<!-- Mobile-header -->
			<div class="mobile-main-header">
				<div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
					<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
						<div class="d-flex order-lg-2 ms-auto">
							<div class="dropdown header-search">
								<a class="nav-link icon header-search">
									<i class="fe fe-search header-icons"></i>
								</a>
								<div class="dropdown-menu">
									<div class="main-form-search p-2">
										<div class="input-group">
											<div class="input-group-btn search-panel">
												<select class="form-control select2">
													<option label="All categories">
													</option>
													<option value="IT Projects">
														IT Projects
													</option>
													<option value="Business Case">
														Business Case
													</option>
													<option value="Microsoft Project">
														Microsoft Project
													</option>
													<option value="Risk Management">
														Risk Management
													</option>
													<option value="Team Building">
														Team Building
													</option>
												</select>
											</div>
											<input type="search" class="form-control" placeholder="Search for anything...">
											<button class="btn search-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
										</div>
									</div>
								</div>
							</div>
						<div class="dropdown main-header-notification">
							<a class="nav-link icon" href="">
								<i class="fe fe-bell header-icons"></i>
								<span class="badge bg-danger nav-link-badge">4</span>
							</a>
							<div class="dropdown-menu">
								<div class="header-navheading">
									<p class="main-notification-text">You have 1 unread notification<span class="badge bg-pill bg-primary ms-3">View all</span></p>
								</div>
								<div class="main-notification-list">
									<div class="media new">
										<div class="main-img-user online"><img alt="avatar" src="<?php echo base_url(); ?>assets/img/users/5.jpg"></div>
										<div class="media-body">
											<p>Congratulate <strong>Olivia James</strong> for New template start</p><span>Oct 15 12:32pm</span>
										</div>
									</div>
									<div class="media">
										<div class="main-img-user"><img alt="avatar" src="<?php echo base_url(); ?>assets/img/users/2.jpg"></div>
										<div class="media-body">
											<p><strong>Joshua Gray</strong> New Message Received</p><span>Oct 13 02:56am</span>
										</div>
									</div>
									<div class="media">
										<div class="main-img-user online"><img alt="avatar" src="<?php echo base_url(); ?>assets/img/users/3.jpg"></div>
										<div class="media-body">
											<p><strong>Elizabeth Lewis</strong> added new schedule realease</p><span>Oct 12 10:40pm</span>
										</div>
									</div>
								</div>
								<div class="dropdown-footer">
									<a href="#">View All Notifications</a>
								</div>
							</div>
						</div>
					
						<div class="dropdown main-profile-menu">
							<a class="d-flex" href="#">
								<span class="main-img-user" ><img alt="avatar" src="<?php echo base_url(); ?>assets/img/users/1.jpg"></span>
							</a>
							<div class="dropdown-menu">
								<div class="header-navheading">
									<h6 class="main-notification-title"></h6>
									<p class="main-notification-text">Super Admin</p>
								</div>
								<a class="dropdown-item border-top" href="<?php echo base_url("profile/sup_profile"); ?>">
									<i class="fe fe-user"></i> My Profile
								</a>
								<a class="dropdown-item" href="profile.html">
									<i class="fe fe-settings"></i> Account Settings
								</a>
								<a class="dropdown-item" href="profile.html">
									<i class="fe fe-settings"></i> Support
								</a>
								<a class="dropdown-item" href="profile.html">
									<i class="fe fe-compass"></i> Activity
								</a>
								<a class="dropdown-item" href="signin.html">
									<i class="fe fe-power"></i> Sign Out
								</a>
							</div>
						</div>
						<div class="dropdown  header-settings">
							<a href="#" class="nav-link icon" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
								<i class="fe fe-align-right header-icons"></i>
							</a>
						</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Mobile-header closed -->
