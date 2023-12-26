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
		
		<?php 
            $update_id = $result->AutoID;
            $ConditionName = $result->ConditionName;
            $ToName = $result->ToName;
            $ToEmail = $result->ToEmail;
            $CCEmail = $result->CCEmail;
			$FromName = $result->FromName;
			$FromEmail = $result->FromEmail;
			$EmailSubject = $result->EmailSubject;
			$EmailMessage = $result->EmailMessage;
	
	
		 ?>
						<div class="row row-sm">
							<div class="col-lg-12 col-md-12">
								<div class="card custom-card">
									<div class="card-body">
								

									<form method="post"  id="sendmail_form">
									<input class="form-control"  type="hidden" id="sendmial" name="updated" value="<?php echo $update_id; ?>">
										<div class="row row-sm">
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">Condition Name</p>
													<input type="text" class="form-control" name="condition_name"  value="<?php echo $ConditionName; ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">From Email<span class="tx-danger">*</span></p>
													<input type="text" class="form-control"  name="from_email" value="<?php echo $FromEmail; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">From Name<span class="tx-danger">*</span></p>
													<input type="text" class="form-control"   name="from_name" value="<?php echo $FromName; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">Email Subject<span class="tx-danger">*</span></p>
													<input type="text" class="form-control"   name="email_subject" value="<?php echo $EmailSubject; ?>">
												</div>
											</div>
                                            <div class="col-md-12">
												<div class="form-group">
													<p class="mg-b-10">Email Message<span class="tx-danger">*</span></p>
                                                <div class="ql-wrapper">
                                                    <div id="quillEditor">
													<?php echo $EmailMessage; ?>
                                                    </div>
													<textarea  style="display:none" name="email_message" id="hiddenArea"></textarea>
                                                </div>
		
												</div>
											</div>
                                            
											<div class="col-md-12 pt-3">
												<div class="form-group mt-10 text-center">
												   <button class="btn ripple btn-secondary loading" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
												    <button class="btn ripple btn-primary pd-x-30 mg-r-5" type="button" id="mailsend">Send</button>
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
