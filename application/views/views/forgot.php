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
                             Please check your mail. We have sent you the password reset link.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Asset </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0 error" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>User Not Exists.</strong>
                            </div>

                </div>
									<div class="row row-sm">
										<div class="card-body mt-2 mb-2">
											<!-- <img src="<?php echo base_url(); ?>assets/img/logo.png" class=" d-lg-none header-brand-img text-start float-start mb-4" alt="logo"> -->
											<div class="clearfix"></div>
											<h5 class="text-start mb-2">Forgot Password</h5>
											<p class="mb-4 text-muted tx-13 ms-0 text-start">It's free to signup and only takes a minute.</p>
											<form id="forgot">
												<div class="form-group text-start">
													<label>Email</label>
													<input class="form-control" name="email" placeholder="Enter your email" type="email" required="">
												</div>
												<button class="btn ripple btn-main-primary btn-block sendotp" id="reset_link" type="button">Submit</button>
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
			<!-- End Row -->

			<!-- Datepicker modal -->
			<div class="modal" id="otpmodel">
				<div class="modal-dialog" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Enter OTP</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
						</div>
						<form id="validaeotp">
						<div class="modal-body">
							<h6>Enter The OTP</h6>
							<!-- Select2 -->
						 <input  class="edit-item-date form-control"  name="otp" id="otp">
							<!-- Select2 -->
						</div>
						<div class="modal-footer">
						    <button class="btn ripple btn-primary sendotp" type="button" type="button" id="">Resend</button>
							<button class="btn ripple btn-primary" type="button" type="button" id="otpform">Submit</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
                        </form>
					</div>
				</div>
			</div>

		</div>
		<!-- End Page -->

		