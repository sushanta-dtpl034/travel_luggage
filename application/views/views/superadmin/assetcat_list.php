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
    					<button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" data-bs-target="#asstcat_model" data-bs-toggle="modal" href="">
    					  Add Asset Category
    					</button>
                        <a href="<?php echo base_url('Asset/cat_templatedownload'); ?>"> <button type="button" class="btn btn-success my-2 btn-icon-text btn-sm" >
    					  Download Template
    					</button></a>
                        <button type="button" class="btn btn-info my-2 btn-icon-text btn-sm" data-bs-target="#catimport" data-bs-toggle="modal" href="">
    					  Import
    					</button>
                        <a href="<?php echo base_url()."/Asset/Assetcat_excel_export"; ?>"><button type="button" class="btn btn-sm btn-warning my-2 btn-icon-text">Export</button></a>
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
                                <strong>Asset Category </strong> insert succesfully.
                                </div>

                                <div class="alert alert-solid-success update" role="alert" style="display:none">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong>Asset Category </strong> updated succesfully.
                                </div>

                                <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong>Already Exist.</strong>
                                </div>

                                <table id="assetcat_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Asset Type</th>
                                            <th>Asset Category</th>
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
<div class="modal" id="asstcat_model">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Asset Category Creation</h6>
                <button aria-label="Close" class="btn-close btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
			</div>
            <form id="asstcat_form">
			<div class="modal-body">
                
				<div class="row row-sm">
                <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Type <span class="tx-danger">*</span></p>
                             <select class="form-control" required="" name="asset_type" id="asset_type">
                                <option label="Choose one" value=""></option>
                                 <?php 
                                    foreach($type as $res){
                                        ?>
                                          <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['AsseTypeName']; ?></option>
                                        <?php
                                    }
                                 ?>
                            </select>
                        </div>
					</div>
					<div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Category <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="assetcat_name" required="" id="assetcat_name" data-parsley-pattern="^[a-zA-Z ]+$">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Category Image<span class="tx-danger">*(jpg,png,jpeg)</span></p>
                            <input type="file" class="form-control"  name="assetcat_image" required="" id="assetcat_image" accept=".png,.jpeg,.jpg">
                        </div>
					</div>
				</div>
			</div>
          </form>
			<div class="modal-footer">
                <button class="btn ripple btn-secondary load-assetcat" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
				<button class="btn ripple btn-primary" type="button" id="assetcat_button">Save changes</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
<!--End Grid modal -->

<!-- update Grid modal -->
<div class="modal" id="up_asstcatmodel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Asset Category  Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
			</div>
            <form id="up_asstcatform" enctype="multipart/form-data">
		    <div class="modal-body">
				<div class="row row-sm">
                <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Type <span class="tx-danger">*</span></p>
                             <select class="form-control" required="" name="up_assettype" id="up_assettype">
                                <option label="Choose one" value=""></option>
                                 <?php 
                                    foreach($type as $res){
                                        ?>
                                          <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['AsseTypeName']; ?></option>
                                        <?php
                                    }
                                 ?>

                            </select>
                        </div>
					</div>
					<div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Category<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="up_assetcatname" required="" id="up_assetcatname" data-parsley-pattern="^[a-zA-Z ]+$">
                            <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                            <input type="hidden" class="form-control"  name="old_catimg" id="old_catimg" value="">
                            
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Category Image<span class="tx-danger">*(jpg,png,jpeg)</span></p>
                            <img src="" id="update_catimg" class="catimage-update"  width="150" height="150">
                            <i class="fa fa-camera  button-aligh upload-button" ></i>
                            <input class="cat-fileupload" type="file" accept="image/*" id="updatecat_file" name="updatecat_file" accept=".png,.jpeg,.jpg"/>
                        </div>
					</div>
				</div>
			</div>
          </form>
			<div class="modal-footer">
               <button class="btn ripple btn-secondary load-assetcat" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
				<button class="btn ripple btn-primary" type="button" id="up_assetcatbut">Update</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updatemisc_close">Close</button>
			</div>
		</div>
	</div>
</div>
<!--End Grid modal -->

<!--upload-->
<div class="modal" id="catimport">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Catgory Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
			</div>
            <form id="import_catform" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row row-sm">
                   <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Catgory List<span class="tx-danger">*(Csv,Xls,Xlsx)</span></p>
                            <input type="file" class="form-control"  name="cat_file" required="" id="cat_file" >
                        </div>
					</div>
				</div>
			</div>
          </form>
			<div class="modal-footer">
				<button class="btn ripple btn-primary" type="button" id="catimp_button">Import</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
