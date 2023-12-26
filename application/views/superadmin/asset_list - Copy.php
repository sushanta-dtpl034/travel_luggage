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
                <div class="d-flex">
    				<div class="justify-content-center">
    					
    					<button type="button" class="btn btn-primary my-2 btn-icon-text" id="assetadd_btn"  href="">
    					  Add Asset
    					</button>
                        <a href="<?php echo base_url('Assetmanagement/asset_templatedownload'); ?>"> 
                            <button type="button" class="btn btn-success my-2 btn-icon-text" >
    					        Download Template
    					   </button>
                        </a>
                        <button type="button" class="btn btn-info my-2 btn-icon-text assetimport">
    					  Import
    					</button>
    				</div>
    			</div>

            </div>
            <!-- Row -->
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="row">
                        <div class="alert alert-solid-success insert" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Asset  </strong> insert succesfully.
                        </div>

                        <div class="alert alert-solid-success update" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Asset </strong> updated succesfully.
                        </div>

                        <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none;width: 100%;">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Already exists.</strong>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="">                            
                                <table id="asset_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100 table-responsive" >
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

											<th hidden>Puchase Date</th>
											<th hidden>Currency</th>
											<th hidden>Amount</th>

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

<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<div class="modal" id="assetadd_model">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Add Asset</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
			</div>
        <form id="addasset_form" enctype="multipart/form-data">
			<div class="modal-body" >
				<div class="row row-sm">
					<div class="col-md-6">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Asset Owner company <span class="tx-danger">*</span></p>
                            <!-- <input type="hidden" class="form-control"  name="assetowner_id"  id="assetowner_id" value="<?php echo $this->session->userdata('userid'); ?>"> -->
                            <!-- <input type="text" class="form-control"  name="asset_owner" required="" id="asset_owner" value="<?php echo $this->session->userdata('CompanyName'); ?>"> -->
                            
                            <input type="hidden" class="form-control"  name="VerificationInterval"  id="VerificationInterval" value="">
                            <input type="hidden" class="form-control"  name="assetman_auditor"  id="assetman_auditor" value="">
                            <select class="form-control select2-with-search"  required="" name="assetowner_id" id="assetowner_id">
                            <option label="Choose one" value=""></option>
                                 <?php 
                                    foreach($company as $com_res){
                                        ?>
                                          <option value="<?php echo $com_res['AutoID']; ?>"><?php echo $com_res['CompanyName']; ?></option>
                                        <?php
                                    }
                                 ?>

                            </select>
                            <!-- <input type="hidden" class="form-control"  name="asstman_incharge"  id="asstman_incharge" value="">
                            <input type="hidden" class="form-control"  name="assetman_supervisor"  id="assetman_supervisor" value=""> -->
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Asset Title <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="asset_title" required=""  id="asset_title">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Company Location <span class="tx-danger">*</span></p>
                            <select class="form-control select2"  name="company_location" id="company_location" required="">
                                <option label="Choose one" value=""></option>
                            </select>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Current Location <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control" id="current_location" name="current_location"  required="">
                        </div>
					</div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Type <span class="tx-danger">*</span></p>
                            <select class="form-control assetman_type" required="" name="assetman_type" id="assetman_type">
                                <option label="Choose one" value=""></option>
                                <?php foreach($type as $type_res){ ?>
                                    <option value="<?php echo $type_res['AutoID']; ?>"><?php echo $type_res['AsseTypeName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
					</div>
                   
                    <div class="col-md-4">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Asset Category <span class="tx-danger">*</span></p>
                            <select class="form-control select2 assetman_cat" required="" name="assetman_cat" id="assetman_cat" >
                            </select>
                        </div>
					</div>
                    <div class="col-md-4">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Asset Sub Category <span class="tx-danger">*</span></p>
                            <select class="form-control select2 assetment_subcat" required="" name="assetment_subcat" id="assetment_subcat">
                                <option label="Choose one" value=""></option>
                            </select>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Measurement</p>
                            <select class="form-control select2"  name="Measurements" id="Measurements">
                                <option label="Choose one" value=""></option>
                            </select>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Dimension of Asset in <span id="set_mesur_val">CMS</span> </p>
                            <input type="text" class="form-control"  name="assetment_dimenson"  id="assetment_dimenson" >
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Asset quantity </p>
                            <input type="text" class="form-control"  name="asset_qty"  id="asset_qty" value="1">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Asset Unique Identification Number </p>
                            <input type="text" class="form-control"  name="assetment_UIN"  id="assetment_UIN">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <p class="mg-b-10">Asset purchase price <span class="tx-danger">*</span></p>
                            <div class="input-group select2CustomErrorShow2">
                                <input class="form-control orginalprice" type="hidden" id="assetment_orginalprice"  name="assetment_orginalprice">
                                <div class="input-group-text">
                                    <select class="customize_select currency"  name="currency" id="currency" required>
                                    <!-- <option label="Choose one" value=""></option> -->
                                    <?php foreach($currency as $res){ ?>
                                        <option value="<?php echo $res['AutoID']?>" c-data="<?php echo $res['CurrencyCode']."/".$res['CurrencyUnicode']; ?>"><?php echo $res['CurrencyCode']; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <input class="form-control purchaseprice"  type="text" id="assetment_purchaseprice"  name="assetment_purchaseprice" required="">
							</div>
                            
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased on</p>
                            <!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
                            <input class="form-control datepicker"  placeholder="MM-DD-YYYY" type="date" id="purchased_date" required >
                            <!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
                            <!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor name)</p>
                            <input type="text" class="form-control"  name="vendor_name" id="vendor_name">
                        </div>
					</div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor email id)</p>
                            <input type="email" class="form-control"  name="vendor_email"  id="vendor_email">
                        </div>
					</div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor mobile no)</p>
                            <!-- <input type="text" class="form-control"  name="vendor_mobile" required="" id="vendor_mobile"> -->
                            <div class="input-group telephone-input" style="display: block";>
								<input type="tel"  class="form-control vendor_mobile" id="vendor_mobile" name="vendor_mobile" placeholder="e.g. +1 702 123 4567" style="width:100%;" >
							</div>
                        </div>
					</div>
                    
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor address)</p>
                            <!-- <textarea class="form-control" placeholder="Textarea" rows="3" id="vendor_address"></textarea> -->
                            <input type="text" class="form-control"  name="vendor_address"  id="vendor_address" >
                        </div>
					</div>

                   
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Depreciation rate (%)<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control" id="depreciation_rate" name="depreciation_rate" min="0.1" max="99.9" required="" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Asset condition <span class="tx-danger">*</span></p>
                            <select class="form-control" required="" name="assetment_condition" id="assetment_condition">
                                <option label="Choose one" value=""></option>
                                 <?php 
                                    foreach($material as $res){
                                        ?>
                                          <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['ConditionName']; ?></option>
                                        <?php
                                    }
                                 ?>

                            </select>
                        </div>
					</div>
                    <div class="col-md-12 mb-2 p-0">
                        <div class="form-row">
                            <input type="hidden" class="form-control"  name="" required="" id="titlestatus" required="">
                            <div class="col-6 p-0"> Picture <span class="tx-danger">*(jpg,png,jpeg)</span></div>
                                <!-- <input type="file" class="dropify" data-height="200" id="picture" multiple required=""> -->
                            <div class="col-6 p-0" style="text-align:right"> 
                                <button class="btn btn-success btn-circle btn-sm addmore" id="add_first_picturefield" type="button" name="add" onclick="addFileupload();">+</button><br>
                                <div>

                                </div>
                            </div>
                            <div id="pictureupload" class="col-12">
                                
                            </div> 
                        </div>
					</div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Vendor Bill <span class="tx-danger">(jpg,png,jpeg,pdf)</span></p>
                            <input type="file" class="file"  data-height="200" id="bill"   multiple  data-allowed-file-extensions="jpg png jpeg pdf">
                        </div>
					</div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty Card <span class="tx-danger">(jpg,png,jpeg,pdf)</span></p>
                            <input type="file"  class="file" data-height="200" id="warranty"  multiple  data-allowed-file-extensions="jpg png jpeg pdf">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty valid until</p>
                            <!-- <input class="form-control" id="valid_till" placeholder="MM/DD/YYYY" type="text"> -->
                            <input class="form-control" id="valid_till" placeholder="MM-DD-YYYY" type="date" >
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Auditor <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="" required="" id="assetman_auditorname" readonly >
                            
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group select2CustomErrorShow">
                            <p class="mg-b-10">Asset User <span class="tx-danger">*</span></p>
                            <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                            <select class="form-control select2 select2-with-search" required="" name="asstman_incharge" id="asstman_incharge">
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
                            <select class="form-control select2 select2-with-search" required="" name="assetman_supervisor" id="assetman_supervisor">
                                <option label="Choose one" value=""></option>
                                <?php foreach($supervisor as $super_result){ ?>
                                <option value="<?php echo $super_result['AutoID']; ?>"><?php echo $super_result['Name']; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
					</div>
                    
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <p class="mg-b-10"> Warranty Covered for</p>
                            <select class="form-control select2 select2-with-search"  name="warrantly_covered_for" id="warrantly_covered_for" multiple="multiple">
                                <option label="Choose one" value=""></option>
                            </select>
                        </div>
					</div>
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty contact person mobile </p>
                            <input type="text" class="form-control"  name="warranty_contact_mobile"  id="warranty_contact_mobile" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty contact person email </p>
                            <input type="email" class="form-control"  name="warranty_contact_email" id="warranty_contact_email">
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Insurance valid upto </p>
                            <input type="date" class="form-control"  name="insurance_valid_upto"  id="insurance_valid_upto">
                        </div>
					</div>
                    
				</div>
			</div>
          </form>
			<div class="modal-footer">
            <button class="btn ripple btn-secondary load-addasset" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
				<button class="btn ripple btn-primary" type="button" id="addasset_button">Save changes</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
          

<script>
var input = document.getElementById('vendor_address');
var autocomplete = new google.maps.places.Autocomplete(input);
</script>

<div class="modal" id="assetview_model">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">View Asset </h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
			</div>
        <form id="addassetview_form" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row row-sm">
					<div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Owner company </p>
                            <input type="text" class="form-control"  name="view_assetownerid"  id="view_assetownerid" value="" readonly>
                           
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Type </p>
                            <input type="text" class="form-control"  name="view_assettype"  id="view_assettype" value="" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Location <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control" name="view_company_location" id="view_company_location" value="" readonly="">
                            <!-- <select class="form-control select2"  name="view_company_location" id="view_company_location" readonly>
                                <?php 
                                    foreach($clocation as $cl_res){
                                        ?>
                                          <option value="<?php echo $cl_res['AutoID']; ?>" ><?php echo $cl_res['Name']; ?></option>
                                        <?php
                                    }
                                 ?>
                            </select> -->
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Current Location <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control" id="view_current_location" name="view_current_location"  readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Category </p>
                            <input type="text" class="form-control"  name="vew_assetcat"  id="vew_assetcat" value="" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Sub Category </p>
                            <input type="text" class="form-control"  name="view_assetsubcat"  id="view_assetsubcat" value="" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Asset Title <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="asset_title" required=""  id="view_assettitle" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Asset quantity </p>
                            <input type="text" class="form-control"  name="asset_qty"   id="view_assetqty" readonly>
                        </div>
					</div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Asset Unique Identification Number </p>
                            <input type="text" class="form-control"  name="view_assetUIN" required="" id="view_assetUIN" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchase price</p>
                            <div class="input-group">
                            <div class="input-group-text">
                            <select class="customize_select currency" name="view_currency_type" id="view_currency_type" disabled>
                            <!-- <option label="Choose one" value=""></option> -->
                                <?php 
                                foreach($currency as $res){
                                ?>
                                  <option value="<?php echo $res['AutoID']?>" c-data="<?php echo $res['CurrencyCode']."/".$res['CurrencyUnicode']; ?>"><?php echo $res['CurrencyCode']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                            <!-- <input class="form-control purchaseprice"  type="text" id="up_assetpurchaseprice"  name="up_assetpurchaseprice" required=""> -->
                             <input class="form-control " required="" type="text" id="viewasset_purchaseprice"  name="viewasset_purchaseprice" readonly>
							</div>
                            
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased on</p>
                            <!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
                            <input class="form-control datepicker"  placeholder="" type="date" id="viewasset_purchasedon" readonly>
                            <!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
                            <!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor name)</p>
                            <input type="text" class="form-control"  name="view_vendorname"  id="view_vendorname" readonly>
                        </div>
					</div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor email id)</p>
                            <input type="text" class="form-control"  name="view_vendoremail"  id="view_vendoremail" readonly>
                        </div>
					</div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor mobile no)</p>
                            <!-- <input type="text" class="form-control"  name="vendor_mobile" required="" id="vendor_mobile"> -->
                            <div class="input-group telephone-input" style="display: block";>
								<input type="tel"  class="form-control " id="view_vendormobile" name="view_vendormobile"  style="width:100%;" readonly>
							</div>
                        </div>
					</div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset purchased from(vendor address)</p>
                            <!-- <textarea class="form-control" placeholder="Textarea" rows="3" id="vendor_address"></textarea> -->
                            <input type="text" class="form-control"  name="view_vendoraddress" required="" id="view_vendoraddress" readonly >										


                        </div>
					</div>

                  

                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Dimension of Asset in <span id="view_set_mesur_val">CMS</span> </p>
                            <input type="text" class="form-control"  name="viewasset_dimenson"  id="viewasset_dimenson" readonly>    
                                                              

                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Depreciation rate </p>
                            <input type="text" class="form-control" id="view_depreciationrate"  name="view_depreciationrate" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset condition </p>
                            <input type="text" class="form-control" id="view_assetmentcondition" name="view_assetmentcondition" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty valid until</p>
                            <!-- <input class="form-control" id="valid_till" placeholder="MM/DD/YYYY" type="text"> -->
                            <input class="form-control" id="view_validtill"  type="date" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Auditor </p>
                            <input class="form-control" id="view_assetauditorname"  type="text" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset User </p>
                            <input class="form-control" id="view_asstmaninchargename"  type="text" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Supervisor </p>
                            <input class="form-control" id="view_assetsupervisorname"  type="text" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Warranty Covered for<span class="tx-danger">*</span></p>
                            <!-- <input type="text" class="form-control"  name="warrantly_covered_for" required="" id="view_warrantly_covered_for" readonly> -->
                            <select class="form-control select2 select2-with-search"  name="view_warrantly_covered_for" id="view_warrantly_covered_for" multiple="multiple" readonly>
                                <option label="Choose one" value=""></option>
                            </select>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10"> Insurance valid upto <span class="tx-danger">*</span></p>
                            <input type="date" class="form-control"  name="insurance_valid_upto" required="" id="view_insurance_valid_upto" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty contact person mobile <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="warranty_contact_person" required="" id="view_warranty_contact_mobile" readonly>
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty contact person email<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="warranty_contact_person" required="" id="view_warranty_contact_email" readonly>
                        </div>
					</div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Asset Picture </p>
                            <ul  class="list-unstyled row mb-0" id="view_picture">
                              
							</ul>

                            
                        </div>
					</div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <p class="mg-b-10">Vendor Bill </p>
                            <ul  class="list-unstyled row mb-0" id="view_vendor">
                              
                              </ul>
                           
                        </div>
					</div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Warranty Card </p>
                            <ul  class="list-unstyled row mb-0" id="view_waranty">
                              
                              </ul>
                        </div>
					</div>
                    <div class="col-md-12" id="dep-his">
                        <p class="mg-b-10">Depreciation Rate History</p>
					</div>
                    <div class="col-md-12" id="assest_his">
                        <p class="mg-b-10">VERIFICATION/REMOVE DETAILS</p>
          
                       
					</div>
                   
                  
				</div>
			</div>
          </form>
			
		</div>
	</div>
</div>

<div class="modal" id="update_assetaddmodel">

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h6 class="modal-title">Edit Asset </h6>
            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
        </div>
    <form id="up_addassetform" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row row-sm">
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Owner company <span class="tx-danger">*</span></p>
                        <input type="hidden" class="form-control"  name="update_assetid"  id="update_assetid" value="">
                        <input type="hidden" class="form-control"  name="update_titlestatus"  id="update_titlestatus" value="">
                        <!-- <input type="hidden" class="form-control"  name="update_assetownerid"  id="update_assetownerid" value=""> -->
                        <!-- <input type="text" class="form-control"  name="update_assetowner" required="" id="update_assetowner" value=""> -->
                        <input type="hidden" class="form-control"  name="update_assetauditorid"  id="update_assetauditorid" >
                        <!-- <input type="hidden" class="form-control"  name="update_asstinchargeid"  id="update_asstinchargeid" >
                        <input type="hidden" class="form-control"  name="update_assetsupervisorid"  id="update_assetsupervisorid" value=""> -->
                        <select class="form-control select2-with-search" required="" name="update_assetownerid" id="update_assetownerid">
                            <option label="Choose one" value=""></option>
                            <?php 
                            foreach($company as $com_res){
                                ?>
                                    <option value="<?php echo $com_res['AutoID']; ?>" ><?php echo $com_res['CompanyName']; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Type <span class="tx-danger">*</span></p>
                        <select class="form-control assetman_type" required="" name="update_assettype" id="update_assettype" disabled>
                            <option label="Choose one" value=""></option>
                             <?php 
                                foreach($type as $type_res){
                                    ?>
                                      <option value="<?php echo $type_res['AutoID']; ?>"><?php echo $type_res['AsseTypeName']; ?></option>
                                    <?php
                                }
                             ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Company Location <span class="tx-danger">*</span></p>
                        <input type="hidden" id="upadte_cl"/>
                        <select class="form-control select2"  name="update_company_location" id="update_company_location" >
                        
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Current Location <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control" id="update_current_location" name="update_current_location" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Category <span class="tx-danger">*</span></p>
                        <select class="form-control select2 assetman_cat" required="" name="up_assetmancat" id="up_assetmancat" disabled>
                        <option label="Choose one" value=""></option>
                        <?php 
                                foreach($cat as $upcat_res){
                                    ?>
                                      <option value="<?php echo $upcat_res['AutoID']; ?>"><?php echo $upcat_res['AsseCatName']; ?></option>
                                    <?php
                                }
                             ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Sub Category <span class="tx-danger">*</span></p>
                        <input type="hidden" id="up_assetmentsubcat_hidden"/>
                        <select class="form-control select2 assetment_subcat" required="" name="up_assetmentsubcat" id="up_assetmentsubcat" disabled>
                            <option label="Choose one" value=""></option>
                        <?php 
                                foreach($subcat as $upsubcat_res){
                                    ?>
                                      <option value="<?php echo $upsubcat_res['AutoID']; ?>"><?php echo $upsubcat_res['AssetSubcatName']; ?></option>
                                    <?php
                                }
                             ?>
                        </select>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset Title <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="asset_title" required=""  id="update_assettitle">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset quantity </p>
                        <input type="text" class="form-control"  name="asset_qty"   id="update_assetqty">
                    </div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset Unique Identification Number </p>
                        <input type="text" class="form-control"  name="update_assetmentUIN"  id="update_assetmentUIN">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Unique Ref No<span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="update_UniqueRefNumber"  id="update_UniqueRefNumber" <?php if($this->session->userdata("userdata")['IsAdmin']!=1){echo'readonly';}?> />
                        <input type="hidden" class="form-control"  name="update_UniqueRefNumber_old"  id="update_UniqueRefNumber_old">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchase price<span class="tx-danger">*</span></p>
                        <div class="input-group">
                            <input class="form-control orginalprice" type="hidden" id="update_assetorginalprice"  name="update_assetorginalprice">
                            <div class="input-group-text">
                                <select class="customize_select currency" name="update_currency" id="update_currency" required>
                                <!-- <option label="Choose one" value=""></option> -->
                                    <?php 
                                    foreach($currency as $res){
                                    ?>
                                        <option value="<?php echo $res['AutoID']?>" c-data="<?php echo $res['CurrencyCode']."/".$res['CurrencyUnicode']; ?>"><?php echo $res['CurrencyCode']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <input class="form-control purchaseprice"  type="text" id="up_assetpurchaseprice"  name="up_assetpurchaseprice" required="">
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased on<span class="tx-danger">*</span></p>
                        <!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
                        <input class="form-control datepicker"  placeholder="MM-DD-YYYY" type="date" id="update_purchaseddate">
                        <!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
                        <!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor name)<span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="vendor_name"  id="update_vendorname">
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor email id)<span class="tx-danger">*</span></p>
                        <input type="email" class="form-control"  name="update_vendoremail"  id="update_vendoremail">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor mobile no)<span class="tx-danger">*</span></p>
                        <!-- <input type="text" class="form-control"  name="vendor_mobile" required="" id="vendor_mobile"> -->
                        <div class="input-group telephone-input" style="display: block";>
                            <input type="tel"  class="form-control vendor_mobile" id="update_vendormobile" name="update_vendormobile" placeholder="e.g. +1 702 123 4567" style="width:100%;">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor address)<span class="tx-danger">*</span></p>
                        <!-- <textarea class="form-control" placeholder="Textarea" rows="3" id="vendor_address"></textarea> -->
                        <input type="text" class="form-control"  name="update_vendoraddress"  id="update_vendoraddress">
                    </div>
                </div>

              

                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Dimension of Asset in CMS <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="update_assetdimenson"  id="update_assetdimenson">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Depreciation rate <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control" id="update_depreciationrate" name="update_depreciationrate" min="0.1" max="99.9" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset condition <span class="tx-danger">*</span></p>
                        <select class="form-control" required="" name="update_assetcondition" id="update_assetcondition">
                            <option label="Choose one" value=""></option>
                             <?php 
                                foreach($material as $res){
                                    ?>
                                      <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['ConditionName']; ?></option>
                                    <?php
                                }
                             ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <p class="mg-b-10">Picture <span class="tx-danger">*(jpg,png,jpeg,pdf)</span> <button style="float:right" class="btn btn-success btn-circle btn-sm addmore" type="button" name="add" onclick="updateFileupload();">+</button></p>
                        <div class="col-12 p-0 mt-4" > 
                           <div id="updatepictureupload"></div> 
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <p class="mg-b-10">Vendor Bill <span class="tx-danger">*(jpg,png,jpeg,pdf)</span></p>
                        <ul  class="list-unstyled row mb-0" id="update_vendor">
                         </ul>
                        <input type="file" class="dropify"  data-height="200" id="updatebill"   multiple data-allowed-file-extensions="jpg png jpeg pdf">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <p class="mg-b-10">Warranty Card <span class="tx-danger">*(jpg,png,jpeg,pdf)</span></p>
                        <ul  class="list-unstyled row mb-0" id="update_waranty">
                         </ul>
                        <input type="file"  class="dropify" data-height="200" id="updatewarranty"  multiple data-allowed-file-extensions="jpg png jpeg pdf">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Warranty valid until</p>
                        <!-- <input class="form-control" id="valid_till" placeholder="MM/DD/YYYY" type="text"> -->
                        <input class="form-control" id="update_validtill" placeholder="MM-DD-YYYY" type="date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Auditor <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="" required="" id="update_assetauditorname" readonly >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset User <span class="tx-danger">*</span></p>
                        <!-- <input type="text" class="form-control"  name="" required="" id="update_asstinchargename" readonly > -->
                        <select class="form-control select2" required="" name="update_asstinchargeid" id="update_asstinchargeid">
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
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Supervisor <span class="tx-danger">*</span></p>
                        <!-- <input type="text" class="form-control"  name="" required="" id="update_assetsupervisorname" readonly > -->
                        <select class="form-control select2" required="" name="update_assetsupervisorid" id="update_assetsupervisorid">
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
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Measurement</p>
                        <select class="form-control select2"  name="up_measurements" id="up_measurements">
                            <option label="Choose one" value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Warranty Covered for</p>
                        <select class="form-control select2"  name="up_warrantly_covered_for" id="up_warrantly_covered_for" multiple="multiple">
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Insurance valid upto </p>
                        <input type="date" class="form-control"  name="insurance_valid_upto"  id="up_insurance_valid_upto">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Warranty contact person mobile</p>
                        <input type="text" class="form-control"  name="up_warranty_contact_mobile"  id="up_warranty_contact_mobile" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Warranty contact person Email </p>
                        <input type="email" class="form-control"  name="up_warranty_contact_email"  id="up_warranty_contact_email">
                    </div>
                </div>
              
            </div>
        </div>
      </form>
        <div class="modal-footer">
           <button class="btn ripple btn-secondary load-addasset" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
            <button class="btn ripple btn-primary" type="button" id="updateasset_button">Update</button>
            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
        </div>
    </div>
</div>
</div>

<script>

var input = document.getElementById('update_vendoraddress');

var autocomplete = new google.maps.places.Autocomplete(input);

</script>


<div class="modal" id="print_qr">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Print QR</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
			</div>
        <form id="qr_form" enctype="multipart/form-data" target="_blank" action="<?php echo base_url("Assetmanagement/downloadqr");?>" method="post">
            <input type="hidden" name="assetuniq" id="assetuniq" value="">
			<div class="modal-body">
				
                <div class="row row-sm">
                    <div class="col-md-12 text-center" >
                        <div class="form-group">
                            <p class="mg-b-10">Qr Code <span class="tx-danger">*</span></p>
                           
                            <div id="">
                              <img src="" id="printimage">
                              <p style="color:red;">Note: Before print please check the  QR code once.</p>
                            </div>
                        </div>
					</div>
				</div>
                <div class="row row-sm justify-content-md-center">
                    <div class="col-md-4">
                 
                        <div class="form-group">
                            <p class="mg-b-10">Number of Print<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="qr_count" required=""  id="qr_count"  data-parsley-max="8">
                            <span style="color:red;display:none;" id="counr_valid">Value must be less than or equal to 8</span>

                        </div>
                   </div>  
                  
					</div>
				



                <table  id="printTable" >
                
                </table>
                    

              
			</div>
          
			<div class="modal-footer">
            <button class="btn ripple btn-primary" type="button" id="printQr">Print Qr</button>
				<button class="btn ripple btn-primary" type="button" id="print_button">Print</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
			</div>
            </form>
		</div>
	</div>
</div>

<!-- import modal start -->
<div class="modal" id="assetimport_modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Asset Import</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
			</div>
            <form id="asset_importform" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row row-sm">
                   <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Asset List<span class="tx-danger">*(Csv,Xls,Xlsx)</span></p>
                            <input type="file" class="form-control"  name="asset_file" required="" id="asset_file">
                        </div>
					</div>
				</div>
			</div>
          </form>
			<div class="modal-footer">
				<button class="btn ripple btn-primary" type="button" id="assetimp_button">Import</button>
				<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- import modal end  -->


<!-- Single QR Code Print-->
<div class="modal fade" id="singleAssetModal" tabindex="-1" role="dialog" aria-labelledby="singleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="singleModalLabel">QR Code Copy Requireds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#singleAssetModal')">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Assetmanagement/single_print_qrcode');?>" target="_blank" method="POST">
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">No of Copy required</p>
                                <select name="noof_copy" class="form-control print_copySingle">
                                    <option value="">Select No of Copy</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <input type="hidden" name="qrcode_id" id="qrcode_id" value="">
                        </div> 
                    </div>                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('#singleAssetModal')">Close</button>
                    <button type="submit" class="btn btn-primary printSingleQrcode">Print QR Code</button>
                </div>
            </form>
        </div>
    </div>
</div>




        

