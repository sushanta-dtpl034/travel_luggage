	<body class="main-body leftmenu">

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url(); ?>assets/img/loader.svg" class="loader-img" alt="Loader">
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
								<div class="mt-3 pt-3 p-2 pos-absolute">
									<img src="<?php echo base_url(); ?>assets/img/svgs/user.svg" class="header-brand-img mb-4" alt="logo">
									<div class="clearfix"></div>
									<!-- <img src="<?php echo base_url(); ?>assets/img/svgs/user.svg" class="ht-100 mb-0" alt="user"> -->
									<!-- <h5 class="mt-4 text-white">Reset Your Password</h5>
									<span class="tx-white-6 tx-13 mb-5 mt-xl-0">Signup to create, discover and connect with the global community</span> -->
								</div>
							</div>
							<div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
								<div class="container-fluid">
								<div class="row">
                              <div class="alert alert-solid-success success" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                                 Your password has been reset successfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0 bothempty" role="alert" style="display:none;width: 100%;">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong id="">Please fill in both password fields</strong>
                            </div>

                            <div class="alert alert-solid-warning mg-b-0 passwordnotmatch" role="alert" style="display:none;width: 100%;">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong id="">Passwords do not match</strong>
                            </div>
                            <div class="alert alert-solid-warning mg-b-0 passwordcondition" role="alert" style="display:none;width: 100%;">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong id="">Password must have at least one uppercase letter, one special character, one number, and a minimum length of 6 characters</strong>
                            </div>

                </div>
									<div class="row row-sm">
										<div class="card-body mt-2 mb-2">
											<!-- <img src="<?php echo base_url(); ?>assets/img/logo.png" class=" d-lg-none header-brand-img text-start float-start mb-4" alt="logo"> -->
											<div class="clearfix"></div>
											<h5 class="text-start mb-2">Reset Password</h5>
											<p class="mb-4 text-muted tx-13 ms-0 text-start"></p>
											<form id="reset-password-form">
												<div class="form-group text-start">
													<label>Password</label>
													<input class="form-control" name="password"  id="password" type="text" required="">
                                                    <input   id="uid" name="uid" type="hidden" value="<?php echo $this->input->get('token'); ?>">
												</div>
                                                <div class="form-group text-start">
													<label>Conform Password</label>
													<input class="form-control" name="confirm-password" id="confirm-password"  type="text" required="">

												</div>
												<button type="button" class="btn ripple btn-main-primary btn-block resetpassword">Reset Password</button>
											</form>
											<div class="card-footer border-top-0 ps-0 mt-3 text-start ">
												<p>Did you remembered your password?</p>
												<p class="mb-0">Try to <a href="<?php echo base_url('Login'); ?>">Signin</a></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			

		</div>
		<!-- End Page -->

		