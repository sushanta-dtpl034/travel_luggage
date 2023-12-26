<!-- Main Content-->
<style>
    .sp-container.sp-hidden{z-index: 20000 !important;}
    .text-right{ text-align:right;}
    *::-webkit-scrollbar {
    width: 3px;
    height: 5px;
    transition: .3s background;
}
</style>
<div class="main-content side-content pt-0">
    <div class="container-fluid">
        <div class="inner-body">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                        <l`i class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                    </ol> -->
                </div>
                <!-- <div class="d-flex">
    				<div class="justify-content-center">
                       <a href="<?php echo base_url('Assetmanagement/exportAssetdetails'); ?>"> 
                            <button type="button" class="btn btn-warning my-2 btn-icon-text" id="excel_btn"  href="">
                                Excel Export
                            </button>
                         </a> 
                        <a href="<?php echo base_url('Assetmanagement/asset_templatedownload'); ?>"> 
                            <button type="button" class="btn btn-success my-2 btn-icon-text" >
    					        Download Template
    					   </button>
                        </a>
                        <button type="button" class="btn btn-info my-2 btn-icon-text assetimport">
    					  Import
    					</button>
                        <button type="button" class="btn btn-primary my-2 btn-icon-text" id="assetadd_btn"  href="">
    					  Add Asset
    					</button>
    				</div>
    			</div> -->

            </div>
            <!-- Row -->
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="row">
                        <div class="alert alert-solid-success insert" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Asset Allocated</strong> succesfully.
                        </div>

                       

                        <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Something went wrong </strong>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="">                            
                                <table id="allocateasset_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100 table-responsive" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Unique Ref No</th>
                                            <th>Asset Owner Company</th>
                                            <th>Location</th>
                                            <th>Title</th>
                                            <th>Asset Category</th>
                                            <th>Asset Sub Category </th>                                           
                                            <th>UIN</th>

											<th>Puchase Date</th>
											<th>Currency</th>
											<th>Purchase Price</th>

                                            <th>Status</th>
                                            <th>Next Verification</th>
                                            <th>CREATED BY</th>
                                            <th>User</th>
                                            <th>Auditor</th>
                                            <th>Supervisor</th>
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
<div class="modal" id="assetallocateview_model">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Allocate Asset </h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
			</div>
        <form id="assetallocate_form" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row row-sm">
					<div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Urn NO </p>
                            <input type="hidden" class="form-control"  name="updateid"  id="updateid">
                            <input type="text" class="form-control"  name="viewallocate_urn"  id="viewallocate_urn" value="" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Asset User <span class="tx-danger">*</span></p>
                            <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                            <select class="form-control select2 select2-with-search"  name="allocate_incharge" id="allocate_incharge" required="">
                                <option label="Choose one" value=""></option>
                                <?php foreach($incharge as $incharge_re){ ?>
                                <option value="<?php echo $incharge_re['AutoID']; ?>"><?php echo $incharge_re['Name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Supervisor <span class="tx-danger">*</span></p>
                            <select class="form-control select2 select2-with-search" name="allocate_supervisor" id="allocate_supervisor" required="">
                                <option label="Choose one" value=""></option>
                                <?php foreach($supervisor as $super_result){ ?>
                                <option value="<?php echo $super_result['AutoID']; ?>"><?php echo $super_result['Name']; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
					</div>
                    
              	</div>
			</div>
          </form>
          <div class="modal-footer">
               <button class="btn ripple btn-secondary load-addasset" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
				<button class="btn ripple btn-primary" type="button" id="allocateadd_button">Save changes</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>











        

