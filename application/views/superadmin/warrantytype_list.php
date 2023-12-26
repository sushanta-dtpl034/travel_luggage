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
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" data-bs-target="#warranty_model" data-bs-toggle="modal" href="">
									  Add Warranty Type
									</button>
                                    <a href="<?php echo base_url()."/Asset/Warrantytype_excel_export"; ?>"><button type="button" class="btn btn-sm btn-warning my-2 btn-icon-text">Export</button></a>
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
                            <strong>Warranty Type </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Warranty Type </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already exist.</strong>
                            </div>

                            <table id="warrantytype_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Warranty Period</th>
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
<div class="modal" id="warranty_model">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Warranty Type Creation</h6>
                            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="warrantyform">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Category <span class="tx-danger">*</span></p>
                                        <select class="form-control select2" required="" name="warr_assetmancat" id="warr_assetmancat">
                                        <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($cat as $cat_res){
                                                    ?>
                                                      <option value="<?php echo $cat_res['AutoID']; ?>"><?php echo $cat_res['AsseCatName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Sub Category <span class="tx-danger">*</span></p>
                                        <select class="form-control select2 warr_assetment_subcat" required="" name="warr_assetment_subcat" id="warr_assetment_subcat">
                                            <option label="Choose one" value=""></option>
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty Type <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="warrantytype_name" required="" id="warrantytype_name" >
                                    </div>
								</div>
                            </div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="warranty_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_warrantymodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Warranty Type  Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="up_warrantyform">
					    <div class="modal-body">
							<div class="row row-sm">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Category <span class="tx-danger">*</span></p>
                                        <select class="form-control " required="" name="up_warrassetmancat" id="up_warrassetmancat">
                                        <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($cat as $cat_res){
                                                    ?>
                                                      <option value="<?php echo $cat_res['AutoID']; ?>"><?php echo $cat_res['AsseCatName']; ?></option>
                                                    <?php
                                                }
                                             ?>

                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Sub Category <span class="tx-danger">*</span></p>
                                    <select class="form-control assetman_type" required="" name="up_warrassetmentsubcat" id="up_warrassetmentsubcat">
                                        <option label="Choose one" value=""></option>
                                        <?php 
                                        foreach($subcat as $subcat_res){
                                        ?>
                                        <option value="<?php echo $subcat_res['AutoID']; ?>"><?php echo $subcat_res['AssetSubcatName']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    </div>
								</div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty Type <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="up_warrantytype" required="" id="up_warrantytype" >
                                        <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                                    </div>
								</div>
                                
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="update_warrantytype">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updatewarranty_close">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
