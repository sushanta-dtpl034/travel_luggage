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
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" data-bs-target="#location_model" data-bs-toggle="modal" href="">
									  Add Location
									</button>
                                    <a href="<?php echo base_url()."Location/excel_export"; ?>"><button type="button" class="btn btn-sm btn-warning my-2 btn-icon-text">Export</button></a>
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
                            <strong>Location </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Location </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already Exists.</strong>
                            </div>

                            <table id="location_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company Name</th>
                                        <th>Location Name</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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
<div class="modal" id="location_model">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Location Creation</h6>
                            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="locationform" >
						<div class="modal-body">
							<div class="row row-sm">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Company Name <span class="tx-danger">*</span></p>
                                        <select class="form-control select2-with-search" required="" name="assetowner_id" id="assetowner_id">
                                        <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($company as $com_res){
                                                    ?>
                                                      <option value="<?php echo $com_res['AutoID']; ?>" <?php if($com_res['IsCompany']==1){ echo "selected";} ?>><?php echo $com_res['CompanyName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Location Name <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="location_name" required="" id="location_name" >
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Contact Person </p>
                                        <input class="form-control datepicker hasDatepicker" placeholder="" type="text" id="ContactPerson">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Email </p>
                                        <input class="form-control datepicker hasDatepicker" placeholder="" type="email" id="email" >
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <p class="mg-b-10">Phone</p>
                                    <div class="input-group">
                                    <!-- Country Code Selector -->
                                    <div class="input-group-prepend">
                                        <select class="form-control" id="countryCode">
                                            <option value="">Select</option>
                                            <option value="+91">+91</option>
                                        <!-- Add more country code options as needed -->
                                        </select>
                                    </div>
                                      <!-- Phone Input -->
                                      <input class="form-control datepicker hasDatepicker" placeholder="" type="text" id="phone">
                                    </div>
                                    </div>
								</div>
                            </div>
						</div>
                      </form>
						<div class="modal-footer">
                        <button class="btn ripple btn-secondary load-company" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
							<button class="btn ripple btn-primary" type="button" id="location_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_locationmodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Location Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="up_locationform">
					    <div class="modal-body">
							<div class="row row-sm">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Company Name <span class="tx-danger">*</span></p>
                                        <input type="hidden" id="update_id" >
                                        <select class="form-control select2-with-search" required="" name="up_assetowner_id" id="up_assetowner_id">
                                        <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($company as $com_res){
                                                    ?>
                                                      <option value="<?php echo $com_res['AutoID']; ?>"><?php echo $com_res['CompanyName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Location Name <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="location_name" required="" id="up_location_name" >
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Contact Person </p>
                                        <input class="form-control datepicker hasDatepicker" placeholder="" type="text" id="up_ContactPerson">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Email </p>
                                        <input class="form-control datepicker hasDatepicker" placeholder="" type="email" id="up_email" >
                                    </div>
								</div>
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <p class="mg-b-10">Phone</p>
                                    <div class="input-group">
                                    <!-- Country Code Selector -->
                                    <div class="input-group-prepend">
                                        <select class="form-control" id="up_countryCode">
                                            <option value="">Select</option>
                                            <option value="+91">+91</option>
                                        <!-- Add more country code options as needed -->
                                        </select>
                                    </div>
                                      <!-- Phone Input -->
                                      <input class="form-control datepicker hasDatepicker" placeholder="" type="text" id="up_phone">
                                    </div>
                                    </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
                           <button class="btn ripple btn-secondary load-company" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
							<button class="btn ripple btn-primary" type="button" id="update_location">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="update_close">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
