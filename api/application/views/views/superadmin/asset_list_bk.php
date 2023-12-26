		<!-- Main Content-->
        <style>
            .sp-container.sp-hidden{z-index: 20000 !important;}
            .text-right{ text-align:right;}
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
                    <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                </ol> -->
            </div>
            <div class="d-flex">
								<div class="justify-content-center">
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#assetadd_model" data-bs-toggle="modal" href="">
									  Add Asset
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
                            <strong>Asset  </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Asset </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already exists.</strong>
                            </div>

                            <table id="asset_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Asset Owner</th>
                                        <th>UIN</th>
                                        <th>Asset Category</th>
                                        <th>Asset Sub Category </th>
                                        <th>Unique Ref No</th>
                                        <th>Status</th>
                                        <th>Verification Date</th>
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
							<h6 class="modal-title">Add Asset </h6>
                            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
						</div>
                    <form id="addasset_form" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Owner company <span class="tx-danger">*</span></p>
                                        <!-- <input type="hidden" class="form-control"  name="assetowner_id"  id="assetowner_id" value="<?php echo $this->session->userdata('userid'); ?>"> -->
                                        <!-- <input type="text" class="form-control"  name="asset_owner" required="" id="asset_owner" value="<?php echo $this->session->userdata('CompanyName'); ?>"> -->
                                        
                                        <input type="hidden" class="form-control"  name="VerificationInterval"  id="VerificationInterval" value="">
                                        <input type="hidden" class="form-control"  name="assetman_auditor"  id="assetman_auditor" value="">
                                        <select class="form-control " required="" name="assetowner_id" id="assetowner_id">
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
                                        <p class="mg-b-10">Asset Type <span class="tx-danger">*</span></p>
                                        <select class="form-control assetman_type" required="" name="assetman_type" id="assetman_type">
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
                                        <p class="mg-b-10">Asset Category <span class="tx-danger">*</span></p>
                                        <select class="form-control select2 assetman_cat" required="" name="assetman_cat" id="assetman_cat" >
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Sub Category <span class="tx-danger">*</span></p>
                                        <select class="form-control select2 assetment_subcat" required="" name="assetment_subcat" id="assetment_subcat">
                                            <option label="Choose one" value=""></option>
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Asset Unique Identification Number <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="assetment_UIN" required="" id="assetment_UIN">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchase price<span class="tx-danger">*</span></p>

                                        <div class="input-group">
                                        <input class="form-control orginalprice" required="" type="hidden" id="assetment_orginalprice"  name="assetment_orginalprice">
                                                    <div class="input-group-text">
                                                        <select class="customize_select currency" required="" name="currency" id="currency">
                                                        <!-- <option label="Choose one" value=""></option> -->
                                                            <?php 
                                                            foreach($currency as $res){
                                                            ?>
                                                              <option value="<?php echo $res['CurrencyCode']."/".$res['CurrencyUnicode']; ?>"><?php echo $res['CurrencyCode']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                        <input class="form-control purchaseprice" required="" type="text" id="assetment_purchaseprice"  name="assetment_purchaseprice">
										</div>
                                        
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchased on<span class="tx-danger">*</span></p>
                                        <!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
                                        <input class="form-control datepicker"  placeholder="MM-DD-YYYY" type="date" id="purchased_date" required="">
                                        <!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
                                        <!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchased from(vendor name)<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="vendor_name" required="" id="vendor_name">
                                    </div>
								</div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchased from(vendor email id)<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="vendor_email" required="" id="vendor_email">
                                    </div>
								</div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchased from(vendor mobile no)<span class="tx-danger">*</span></p>
                                        <!-- <input type="text" class="form-control"  name="vendor_mobile" required="" id="vendor_mobile"> -->
                                        <div class="input-group telephone-input" style="display: block";>
											<input type="tel"  class="form-control vendor_mobile" id="vendor_mobile" name="vendor_mobile" placeholder="e.g. +1 702 123 4567" style="width:100%;" required="">
										</div>
                                    </div>
								</div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchased from(vendor address)<span class="tx-danger">*</span></p>
                                        <!-- <textarea class="form-control" placeholder="Textarea" rows="3" id="vendor_address"></textarea> -->
                                        <input type="text" class="form-control"  name="vendor_address" required="" id="vendor_address" required="">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Dimension of Asset in CMS <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="assetment_dimenson" required="" id="assetment_dimenson" required="">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Depreciation rate (%)<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control" id="depreciation_rate" name="depreciation_rate" min="0.1" max="99.9" required="">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
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
                                       <div class="col-6 p-0"> Picture <span class="tx-danger">*(jpg,png,jpeg,pdf)</span></div>
                                        <!-- <input type="file" class="dropify" data-height="200" id="picture" multiple required=""> -->
                                        <div class="col-6 p-0" style="text-align:right"> <button class="btn btn-success btn-circle btn-sm addmore" type="button" name="add" onclick="addFileupload();">+</button><br>
                                            <div></div>
                                            </div>
                                            <div id="pictureupload" class="col-12">
                                            </div> 
                                    </div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mg-b-10">Vendor Bill <span class="tx-danger">*(jpg,png,jpeg,pdf)</span></p>
                                        <input type="file"  data-height="200" id="bill"   multiple required="" data-allowed-file-extensions="jpg png jpeg pdf">
                                    </div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty Card <span class="tx-danger">*(jpg,png,jpeg,pdf)</span></p>
                                        <input type="file"  data-height="200" id="warranty"  multiple required="" data-allowed-file-extensions="jpg png jpeg pdf">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty valid until<span class="tx-danger">*</span></p>
                                        <!-- <input class="form-control" id="valid_till" placeholder="MM/DD/YYYY" type="text"> -->
                                        <input class="form-control" id="valid_till" placeholder="MM-DD-YYYY" type="date" required="">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Auditor <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="" required="" id="assetman_auditorname" readonly >
                                        
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Incharge <span class="tx-danger">*</span></p>
                                        <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                                        <select class="form-control select2" required="" name="asstman_incharge" id="asstman_incharge">
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
                                        <select class="form-control select2" required="" name="assetman_supervisor" id="assetman_supervisor">
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
                                        <p class="mg-b-10"> Warranty Covered for<span class="tx-danger">*</span></p>
                                        <select class="form-control" required="" name="warrantly_covered_for" id="warrantly_covered_for">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($warranty as $res_warranty){
                                                    ?>
                                                      <option value="<?php echo $res_warranty['AutoID']; ?>"><?php echo $res_warranty['WarrantyTypeName']; ?></option>
                                                    <?php
                                                }
                                             ?>
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty contact person mobile <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="warranty_contact_mobile" required="" id="warranty_contact_mobile" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty contact person email <span class="tx-danger">*</span></p>
                                        <input type="email" class="form-control"  name="warranty_contact_email" required="" id="warranty_contact_email">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Insurance valid upto <span class="tx-danger">*</span></p>
                                        <input type="date" class="form-control"  name="insurance_valid_upto" required="" id="insurance_valid_upto">
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
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAiYn74tyGdnPn3eTZm6b6RcuaQq92vDY&libraries=places"></script>

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
                                        <p class="mg-b-10"> Asset Unique Identification Number </p>
                                        <input type="text" class="form-control"  name="view_assetUIN" required="" id="view_assetUIN" readonly>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchase price</p>
                                        <div class="input-group">
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
                                        <input type="text" class="form-control"  name="view_vendorname" required="" id="view_vendorname" readonly>
                                    </div>
								</div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset purchased from(vendor email id)</p>
                                        <input type="text" class="form-control"  name="view_vendoremail" required="" id="view_vendoremail" readonly>
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
                                        <p class="mg-b-10">Dimension of Asset in CMS </p>
                                        <input type="text" class="form-control"  name="viewasset_dimenson" required="" id="viewasset_dimenson" readonly>    
                                                                          

                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Depreciation rate </p>
                                        <input type="text" class="form-control" id="view_depreciationrate" name="view_depreciationrate" readonly>
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
                                        <p class="mg-b-10">Asset Incharge </p>
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
                                        <input type="text" class="form-control"  name="warrantly_covered_for" required="" id="view_warrantly_covered_for" readonly>
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
                        <select class="form-control" required="" name="update_assetownerid" id="update_assetownerid">
                                            
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
                        <p class="mg-b-10"> Asset Unique Identification Number <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="update_assetmentUIN" required="" id="update_assetmentUIN">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchase price<span class="tx-danger">*</span></p>
                        <div class="input-group">
                        <input class="form-control orginalprice" required="" type="hidden" id="update_assetorginalprice"  name="update_assetorginalprice">
                                    <div class="input-group-text">
                                        <select class="customize_select currency" required="" name="update_currency" id="update_currency">
                                        <!-- <option label="Choose one" value=""></option> -->
                                            <?php 
                                            foreach($currency as $res){
                                            ?>
                                              <option value="<?php echo $res['CurrencyCode']."/".$res['CurrencyUnicode']; ?>"><?php echo $res['CurrencyCode']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                        <input class="form-control purchaseprice" required="" type="text" id="up_assetpurchaseprice"  name="up_assetpurchaseprice">
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
                        <input type="text" class="form-control"  name="vendor_name" required="" id="update_vendorname">
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor email id)<span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="update_vendoremail" required="" id="update_vendoremail">
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
                        <input type="text" class="form-control"  name="update_vendoraddress" required="" id="update_vendoraddress">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Dimension of Asset in CMS <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control"  name="update_assetdimenson" required="" id="update_assetdimenson">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Depreciation rate <span class="tx-danger">*</span></p>
                        <input type="text" class="form-control" id="update_depreciationrate" name="update_depreciationrate" min="0.1" max="99.9">
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
                        <p class="mg-b-10">Warranty valid until<span class="tx-danger">*</span></p>
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
                        <p class="mg-b-10">Asset Incharge <span class="tx-danger">*</span></p>
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
                                        <p class="mg-b-10"> Warranty Covered for<span class="tx-danger">*</span></p>
                                        <select class="form-control" required="" name="up_warrantly_covered_for" id="up_warrantly_covered_for">
                                            <option label="Choose one" value=""></option>
                                             <?php 
                                                foreach($warranty as $res_warranty){
                                                    ?>
                                                      <option value="<?php echo $res_warranty['AutoID']; ?>"><?php echo $res_warranty['WarrantyTypeName']; ?></option>
                                                    <?php
                                                }
                                             ?>
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Insurance valid upto <span class="tx-danger">*</span></p>
                                        <input type="date" class="form-control"  name="insurance_valid_upto" required="" id="up_insurance_valid_upto">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty contact person mobile<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="up_warranty_contact_mobile" required="" id="up_warranty_contact_mobile" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$">
                                    </div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty contact person Email <span class="tx-danger">*</span></p>
                                        <input type="email" class="form-control"  name="up_warranty_contact_email" required="" id="up_warranty_contact_email">
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
							



              <table  cellpadding="3" id="printTable" width="700">
               
             </table>
                                

                          
						</div>
                      
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="print_button">Print</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
                        </form>
					</div>
				</div>
			</div>





        

