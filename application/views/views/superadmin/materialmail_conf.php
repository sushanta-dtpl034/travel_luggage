	<!-- Main Content-->
    <div class="main-content side-content pt-0">

<div class="container-fluid">
    <div class="inner-body">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscribers</li> -->
                </ol>
            </div>
        </div>
        <!-- Row -->
		
	
						<div class="row row-sm">
							<div class="col-lg-12 col-md-12">
								<div class="card custom-card">
									<div class="card-body">
								

									<form method="post"  id="mailconf">
										<div class="row row-sm">
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">Condition Name <span class="tx-danger">*</span></p>
													<input type="text" class="form-control"   value=""  name="condition_name">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">From Email<span class="tx-danger">*</span></p>
													<input type="text" class="form-control"  value="" name="from_email">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">From Name<span class="tx-danger">*</span></p>
													<input type="text" class="form-control"  value="" name="from_name">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">Email Subject<span class="tx-danger">*</span></p>
													<input type="text" class="form-control"  value="" name="email_subject">
												</div>
											</div>
                                            <div class="col-md-12">
												<div class="form-group">
													<p class="mg-b-10">Email Message<span class="tx-danger">*</span></p>
                                                <div class="ql-wrapper">
                                                    <div id="quillEditor">
                                                    </div>
													<textarea  style="display:none" name="email_message" id="hiddenArea"></textarea>
                                                </div>
		
												</div>
											</div>
                                            
											<div class="col-md-12 pt-3">
												<div class="form-group mt-10 text-center">
												   <button class="btn ripple btn-secondary loading" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
												    <button class="btn ripple btn-primary pd-x-30 mg-r-5" type="button" id="mailsetting-ins">Send</button>
													<a href="<?php echo base_url('Masters/superad_materialcon'); ?>" class="btn ripple btn-secondary pd-x-30">Cancel</a>
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
