		<!-- Main Content-->
        <div class="main-content side-content pt-0">

<div class="container-fluid">
    <div class="inner-body">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                </ol>
            </div>
            <div class="d-flex">
								<div class="justify-content-center">
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#planmodal" data-bs-toggle="modal" href="">
									  Add plan
									</button>
								</div>
							</div>

        </div>
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="alert alert-solid-success insert" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Plan </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Plan </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Something went wrong.</strong>
                            </div>

                            <table id="planlist" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Plan Name</th>
                                        <th>Amount </th>
                                        <th>Storage</th>
                                        <th>Month/Year</th>
                                        <th>Days</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                  
                                </tbody>
                            </table>
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
<!-- insert Grid modal -->
<div class="modal" id="planmodal">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Plan Creation</h6>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="planform">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Plan Name<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="plan_name" required="">
                                        <input type="hidden" class="form-control"  name="" id="planurl" value="<?php echo base_url('Plan/savePlan'); ?>">
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Amount<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="amount" required="" data-parsley-type="digits" >
                                    </div>
								</div>
                             
							</div>
							<div class="row row-sm">
								<div class="col-md-6">
                                <div class="form-group">
                                        <p class="mg-b-10">Storage<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="storage" required="" data-parsley-type="digits" >
                                     </div>
								</div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <p class="">Month/Year<span class="tx-danger">*</span></p>
                                            <select class="form-control" required="" name="period">
                                            <option label="Choose one" value=""></option>
                                            <option value="1">Month</option>
                                            <option value="2">Year</option>
                                            </select>
                                        </div>   
								</div>
							</div>
                            <div class="row row-sm">
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="">Days<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="days" required="" data-parsley-type="digits" >
                                    </div> 
								</div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="ckbox mt-4"><input checked type="checkbox" value="1" name="active"><span>Active</span></label>
                                      </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="plan">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="updateplan">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Plan Creation</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
						</div>
                        <form id="updateplanform">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                    <p class="">Plan Name<span class="tx-danger">*</span></p>
                                    <input type="text" class="form-control"  name="plan_name" required="" id="up_planname">
                                    <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="">Amount<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="amount" required="" id="up_amount" >
                                     </div>
								</div>
                             
							</div>
							<div class="row row-sm">
								<div class="col-md-6">
                                        <div class="form-group">
                                            <p class="">Storage<span class="tx-danger">*</span></p>
                                            <input type="text" class="form-control"  name="storage" required="" id="up_storage">
                                        </div>
								</div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                        <p class="">Month/Year<span class="tx-danger">*</span></p>
                                        <select class="form-control" required="" name="period" id="up_period">
                                            <option label="Choose one" value=""></option>
                                            <option value="1">Month</option>
                                            <option value="2">Year</option>
                                        </select>
                                        </div>  
								</div>
							</div>
                            <div class="row row-sm">
								<div class="col-md-6">
                                   <div class="form-group">
                                    <p class="">Days<span class="tx-danger">*</span></p>
                                    <input type="text" class="form-control"  name="days" required="" id="up_days">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="ckbox mt-4"><input checked type="checkbox" value="1" name="active"><span>Active</span></label>
                                     </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="update">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updateclose">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
