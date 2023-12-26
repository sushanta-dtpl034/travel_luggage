<style>
    .centered-col{margin:auto; float:none; }
</style>
<!-- Main Content-->

    <div class="main-content side-content pt-0">

<div class="container-fluid">
    <div class="inner-body">

        <!-- Page Header -->
        <div class="page-header" style="display:block; text-align:center; min-height: auto;">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscribers</li>
                </ol> -->
            </div>
        </div>
     		<div class="row row-sm">
							<div class="col-lg-6 col-md-6 centered-col">
								<div class="card custom-card">
									<div class="card-body">
                                        <div class="col-md-12">

                                        <div class="alert alert-success change_success" role="alert" style="display:none;" >
                                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                        <span aria-hidden="true">X</span>
                                        </button>
                                        <strong></strong> <p class="text-center">Password Changed Successfully.</p>
                                    </div>
                                       <form id="change_password"> 
										<div class="row row-sm">
											<div class="col-md-12">
												<div class="form-group">
													<p class="mg-b-10">Password</p>
                                                    <input type="hidden" class="form-control"   name="change_id" id="change_id" value="<?php echo $this->session->userdata('userid'); ?>">
                                                    <input id="password1" name="password" type="password" class="form-control password" data-parsley-minlength="6" data-parsley-errors-container=".errorspannewpassinput"  data-parsley-required-message="Please enter your new password." data-parsley-uppercase="1"  data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1"  data-parsley-required />
												</div>
											</div>
										</div>
                                        <div class="row row-sm">
											<div class="col-md-12">
												<div class="form-group">
													<p class="mg-b-10">Confirm Password</p>
													<input name="Password_2" id="password2" type="password" class="form-control password"  data-parsley-minlength="6"  data-parsley-errors-container=".errorspanconfirmnewpassinput"  data-parsley-required-message="Please re-enter your new password."  data-parsley-equalto="#password1"  data-parsley-required />
												</div>
											</div>
										</div>
                                        <div class="row row-sm">
											<div class="col-md-12">
												<div class="form-group" style="text-align:right">
                                                    <button class="btn ripple btn-primary" type="button" id="pass_change">Change</button>
                                                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="reset">Reset</button>
												</div>
											</div>
										</div>
                                 </form>
                                  </div>

									</div>
								</div>
							</div>
						</div>
						<!-- End Row -->
    </div>
</div>
</div>
<!-- End Main Content-->
