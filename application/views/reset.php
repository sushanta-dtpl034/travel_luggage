	<body class="main-body leftmenu">

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url(); ?>assetsimg/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- End Loader -->

		<!-- Page -->
		<div class="page main-signin-wrapper">

			<!-- Row -->
			<div class="row signpages text-center">
				<div class="col-md-12">
					<div class="card">
						<div class="row row-sm">
							<div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
								<div class="mt-4 pt-5 p-2 pos-absolute">
								<img src="<?php echo base_url(); ?>assets/img/logo.png" class="header-brand-img mb-4" alt="logo">
									<div class="clearfix"></div>
									<img src="<?php echo base_url(); ?>assets/img/svgs/user.svg" class="ht-100 mb-0" alt="user">
									<h5 class="mt-4 text-white">Reset Your Password</h5>
									<span class="tx-white-6 tx-13 mb-5 mt-xl-0">Welcome to Dahlia Technologies Pvt Ltd</span>
								</div>
							</div>
							<div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
								<div class="container-fluid">
									<div class="row row-sm">
										<div class="card-body mt-2 mb-2">
											<img src="<?php echo base_url(); ?>assets/img/brand/logo.png" class=" d-lg-none header-brand-img text-start float-start mb-4" alt="logo">
											<div class="clearfix"></div>
											<h5 class="text-start mb-2">Reset Your Password</h5>
											<p class="mb-4 text-muted tx-13 ms-0 text-start">It's free to signup and only takes a minute.</p>
											<form id="resetForm" method="post" action="<?php echo base_url(); ?>/Login/resetPassword">
												<div class="form-group text-start">
													<label>New Password</label>
													<input class="form-control" placeholder="Enter your password"  type="password" name="password" required="required" id="password" data-required-message="Your password must have one Uppercase,one Number,one Special Charater">
												</div>
												<div class="form-group text-start">
													<label>Confirm Password</label>
													<input class="form-control" placeholder="Enter your password"  type="password"  name="conform_password" data-parsley-equalto="#password" required="required" id="conform_password">
												</div>
												<button class="btn ripple btn-main-primary btn-block" type="button" id="reset">Reset Password</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Row -->



		</div>
		<!-- End Page -->

	