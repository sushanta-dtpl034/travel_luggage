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
           <!--  <div class="d-flex">
								<div class="justify-content-center">
									<button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#assetsub_model" data-bs-toggle="modal" href="">
									  Add Asset Sub Category 
									</button>
                                    <a href="<?php echo base_url('Asset/subcat_templatedownload'); ?>"> <button type="button" class="btn btn-success my-2 btn-icon-text" >
									  Download Template
									</button></a>
                                    <button type="button" class="btn btn-info my-2 btn-icon-text subcatimport">
									  Import
									</button>
								</div>
							</div> -->

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
                            <strong>Asset Sub Category </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Asset Sub Category  </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already exists.</strong>
                            </div>

                            <table id="supervisor_assetsubcat_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Asset Category</th>
                                        <th>Asset Sub Category </th>
                                        <th>Interval(month)</th>
                                        <th>Auditor</th>
                                        <th>NO of Image</th>
                                        <th>Title</th> 
                                        <!-- <th>Action</th> -->
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
<div class="modal" id="assetsub_model">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Asset Sub Category Creation</h6>
                            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="asetsubcat_form" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Category <span class="tx-danger">*</span></p>
                                         <select class="form-control" required="" name="assetcat_name" id="assetcat_name">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($cat as $res){
                                                    ?>
                                                      <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['AsseCatName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Sub Category <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="assetsubcat_name" required="" id="assetsubcat_name" data-parsley-pattern="^[a-zA-Z ]+$">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Measurement <span class="tx-danger">*</span></p>
                                         <select class="form-control select2" required="" name="measurement[]" id="measurement" multiple="multiple">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($mes as $result){
                                                    ?>
                                                      <option value="<?php echo $result['AutoID']; ?>"><?php echo $result['UomName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="mg-b-10">Number Of Picture<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="sub_numberpic" required="" id="sub_numberpic"  data-parsley-type="digits" min="1" max="10">
                                    </div>
								</div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                            <p class="mb-2">Title</p>
                                            <label class="custom-switch">
                                            <input type="checkbox" value="1" name="custom-switch-checkbox" class="custom-switch-input" name="sub_numberpic" checked id="sub_title">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Yes</span>
                                            </label>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <p class="mb-2">Verification Interval(month)</p>
                                            <select class="form-control select2" required="" name="verification_interval" id="verification_interval">
                                            <option label="Choose one" value=""></option>  
                                            <?php 
                                                for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                                   ?>
                                                     <option value="<?php echo $i_month; ?>"><?php echo $i_month; ?></option>
                                                   <?php 
                                                }
                                            ?>
                                            </select>
                                            
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Auditor<span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="auditor" id="auditor">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($audit as $audit_res){
                                                    ?>
                                                      <option value="<?php echo $audit_res['AutoID']; ?>"><?php echo $audit_res['Name']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mg-b-10">Sub Category Image<span class="tx-danger">*(jpg,png,jpeg)</span></p>
                                        <input type="file" class="form-control dropify"  name="sub_catimage" required="" id="sub_catimage" multiple>
                                    </div>
								</div>
                               
                                
                               
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Incharge<span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="incharge" id="incharge">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($incharge as $incharge_re){
                                                    ?>
                                                      <option value="<?php echo $incharge_re['AutoID']; ?>"><?php echo $incharge_re['Name']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div> -->
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Supervisor<span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="supervisor" id="supervisor">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($supervisor as $super_result){
                                                    ?>
                                                      <option value="<?php echo $super_result['AutoID']; ?>"><?php echo $super_result['Name']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div> -->
                              
							</div>
						</div>
                      </form>
						<div class="modal-footer">
                        <button class="btn ripple btn-secondary load-assetcat" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
							<button class="btn ripple btn-primary" type="button" id="assetsub_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_assetsubmodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Asset Sub Category  Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="up_assetsub" enctype="multipart/form-data">
					    <div class="modal-body">
							<div class="row row-sm">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Category <span class="tx-danger">*</span></p>
                                        <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                                        <input type="hidden" class="form-control"  name="old_subcatimg" id="old_subcatimg" value="">
                                         <select class="form-control" required="" name="up_assetcatname" id="up_assetcatname">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($cat as $res){
                                                    ?>
                                                      <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['AsseCatName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Sub Category <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="up_assetsubcatname" required="" id="up_assetsubcatname" data-parsley-pattern="^[a-zA-Z ]+$">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p id="mes"><p>
                                        <p class="mg-b-10">Measurement <span class="tx-danger">*</span></p>
                                         <select class="form-control select2" required="" name="up_measurement" id="up_measurement" multiple="multiple">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($mes as $result){
                                                    ?>
                                                      <option value="<?php echo $result['AutoID']; ?>"><?php echo $result['UomName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                               
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <p class="mg-b-10">Number Of Picture<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="up_subnumberpic" required="" id="up_subnumberpic">
                                    </div>
								</div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                            <p class="mb-2">Title</p>
                                            <label class="custom-switch">
                                            <input type="checkbox" value="1" name="custom-switch-checkbox" class="custom-switch-input" name="up_subtitle"  id="up_subtitle">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Yes</span>
                                            </label>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <p class="mb-2">Verification Interval(month)</p>
                                            <select class="form-control select2" required="" name="up_verificationinterval" id="up_verificationinterval">
                                            <option label="Choose one" value=""></option>  
                                            <?php 
                                                for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                                   ?>
                                                     <option value="<?php echo $i_month; ?>"><?php echo $i_month; ?></option>
                                                   <?php 
                                                }
                                            ?>
                                            </select>
                                            
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Auditor<span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="up_auditor" id="up_auditor">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($audit as $audit_res){
                                                    ?>
                                                      <option value="<?php echo $audit_res['AutoID']; ?>"><?php echo $audit_res['Name']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Incharge<span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="up_incharge" id="up_incharge">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($incharge as $incharge_re){
                                                    ?>
                                                      <option value="<?php echo $incharge_re['AutoID']; ?>"><?php echo $incharge_re['Name']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div> -->
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Supervisor<span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="up_supervisor" id="up_supervisor">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($supervisor as $super_result){
                                                    ?>
                                                      <option value="<?php echo $super_result['AutoID']; ?>"><?php echo $super_result['Name']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div> -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mg-b-10">Sub Category Image<span class="tx-danger">*(jpg,png,jpeg)</span></p>
                                        <!-- <img src="" id="update_catimg" class="subcatimage-update">
                                        <i class="fa fa-camera  button-aligh upload-button" ></i> -->
                                            <ul  class="list-unstyled row mb-0" id="view_catimage">

                                            </ul>
                                            <input type="file" class="form-control dropify"  name="updatesubcat_file"  id="updatesubcat_file" multiple>
                                   </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
                           <button class="btn ripple btn-secondary load-assetcat" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
							<button class="btn ripple btn-primary" type="button" id="update_assetsub">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updatemisc_close">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <div class="modal" id="subcatimport">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Sub Catgory Creation</h6>
                            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="subimport_catform" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="row row-sm">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Sub Catgory List<span class="tx-danger">*(Csv,Xls,Xlsx)</span></p>
                                        <input type="file" class="form-control"  name="subcat_file" required="" id="subcat_file">
                                    </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="subcatimp_button">Import</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
