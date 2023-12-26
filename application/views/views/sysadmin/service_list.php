		<!-- Main Content-->
        <div class="main-content side-content pt-0">

<div class="container-fluid">
    <div class="inner-body">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                </ol> -->
            </div>
            <div class="d-flex">
								<div class="justify-content-center">
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#service_model" data-bs-toggle="modal" href="">
									  Add Service
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
                            <strong>Service </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Service </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Something went wrong.</strong>
                            </div>

                            <table id="service_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Service</th>
                                        <th>Status</th>
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
<div class="modal" id="service_model">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Service Creation</h6>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="serviceform">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Service <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="service_name" required="" id="service_name">
                                    </div>
								</div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="ckbox mt-4"><input checked="" type="checkbox" value="1" name="service_Active" id="service_Active"><span>Active</span></label>
                                      </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="service_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_service">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Service  Update</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
						</div>
                        <form id="up_serviceform">
					    <div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Service<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="up_servicename" required="" id="up_servicename">
                                        <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                                    </div>
								</div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="ckbox mt-4"><input checked="" type="checkbox" value="1" name="up_serviceactive" id="up_serviceactive"><span>Active</span></label>
                                      </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="update_service">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updatemisc_close">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
