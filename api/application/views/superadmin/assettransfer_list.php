<!-- <style>
    span.select2-container {
    z-index:10050;
}
</style>     -->
<style>
    .sp-container.sp-hidden{z-index: 20000 !important;}
    .text-right{ text-align:right;}
    *::-webkit-scrollbar {
    width: 3px;
    height: 5px;
    transition: .3s background;
}
.badgewidth{
    width: auto;
    min-width: 150px;
}
</style>
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
                    
                    <button type="button" class="btn btn-sm btn-primary my-2 btn-icon-text" data-bs-target="#assettransfermodel" data-bs-toggle="modal" href="">
                        Transfer Asset
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
                            <strong>Asset  </strong> transfer succesfully.
                            </div>

                            <!-- <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Asset </strong> updated succesfully.
                            </div> -->

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Currency Already Exists.</strong>
                            </div>
                            <!-- <select class="form-control assetman_urn" required="" name="asset_urn[]" id="asset_urn1" Required multiple="multiple">
                                            <option value="">Select<option>
                                           <?php 
                                              foreach($assetlist as $res_asset){
                                                ?>
                                                 <option value="<?php echo $res_asset['AutoID']; ?>"><?php  echo $res_asset['UniqueRefNumber']; ?></option>
                                                <?php 
                                            }
                                           ?>
                                        </select> -->

                            

                            <table id="assettransfer_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Urn</th>
                                        <th>Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Transfer By</th>
                                        <th>Transfer Date Time</th>
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
<div class="modal" id="assettransfermodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Asset Transfer</h6>
                            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
						</div>
                        
                        <form id="assettransferform" accept-charset="utf-8">
						<div class="modal-body">
							<div class="row row-sm">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <p class="mg-b-10">Type<span class="tx-danger">*</span></p>
                                            <?php
                                           
                                           $userid=$this->session->userdata("userdata")['AutoID'];
                                          $Isauditor=$this->session->userdata("userdata")['Isauditor'];
                                          $issupervisor=$this->session->userdata("userdata")['issupervisor'];
                                          $IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
                                            ?>
                                            <select class="form-control Type" required="" name="transfertype" id="transfertype" onchange="getval(this);" Required>
                                                <option value="">Select</option>
                                                <?php 
                                                    if($IsAdmin==1){
                                                        ?>
                                                          <option value="1">Company to Company</option>
                                                        <?php
                                                    }
                                                ?>
                                                <option value="2">Person to Person</option>
                                             </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    </div>
								  </div>
							</div>

                            <?php 
                        if($IsAdmin==1){
                            ?>
                            <div class="row row-sm" id="company" style="display:none;">
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">From<span class="tx-danger">*</span></p>
                                        <select class="form-control select2"  name="from_company" id="from_company">
                                        <option value="">Select</option>
                                           <?php 
                                              foreach($company as $res_company){
                                                ?>
                                                 <option value="<?php echo $res_company['AutoID']; ?>"><?php  echo $res_company['CompanyName']; ?></option>
                                                <?php 
                                            }
                                           ?>
                                        </select>
                                    </div>
								</div>
                            </div>    
                            <?php
                            }
                            ?>
                           
                            <div class="row row-sm" id="urnlist" style="display:none;">
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Asset(Unique Ref No)<span class="tx-danger">*</span></p>
                                        <select class="form-control assetman_urn selectpicker" multiple  name="asset_urn[]" id="asset_urn">
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        
                                    </div>
								</div>
							</div>
                            <div class="row row-sm" id="tocompany" style="display:none;">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">To<span class="tx-danger">*</span></p>
                                        <select class="form-control select2"  name="to_company" id="to_company">
                                        <option value="">Select</option>
                                           <?php 
                                              foreach($company as $res_company){
                                                ?>
                                                 <option value="<?php echo $res_company['AutoID']; ?>"><?php  echo $res_company['CompanyName']; ?></option>
                                                <?php 
                                            }
                                           ?>
                                        </select>
                                    </div>
								</div>
							</div>
                            <div id="users" style="display:none;">
                            <div class="row row-sm">
                				<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">From<span class="tx-danger">*</span></p>
                                        <select class="form-control assetman_urn select2" name="from_user" id="from_user" <?php if(($Isauditor==0 &&  $issupervisor==0 && $IsAdmin==0) or ($Isauditor===null &&  $issupervisor===null && $IsAdmin=== null)){ echo "disabled";} ?>>
                                        <option value="">Select</option>
                                           <?php 
                                              foreach($incharge as $res_incharge){
                                                ?>
                                                 <option value="<?php echo $res_incharge['AutoID']; ?>" <?php if(($Isauditor==0 &&  $issupervisor==0 && $IsAdmin==0) or ($Isauditor===null &&  $issupervisor===null && $IsAdmin=== null)){ if($userid==$res_incharge['AutoID']){ echo "Selected";}} ?>><?php  echo $res_incharge['Name']; ?></option>
                                                <?php 
                                            }
                                           ?>
                                        </select>
                                    </div>
								</div>
                            </div>   
                            <div class="row row-sm">
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Asset(Unique Ref No)<span class="tx-danger">*</span></p>
                                        <select class="form-control assetman_urn selectpicker"  name="asset_urn[]" id="asseturn_user">
                                           <?php 
                                              foreach($urn as $res_urn){
                                                ?>
                                                 <option value="<?php echo $res_urn['AutoID']; ?>"><?php  echo $res_urn['UniqueRefNumber']." - ".$res_urn['AssetTitle']; ?></option>
                                                <?php 
                                            }
                                           ?>
                                        </select>
                                    </div>
								</div>
                            </div>    
                            <div class="row row-sm">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">To<span class="tx-danger">*</span></p>
                                        <select class="form-control select2"  name="to_user" id="to_user">
                                        <option value="">Select</option>
                                           <?php 
                                              foreach($incharge as $res_incharge){
                                                ?>
                                                 <option value="<?php echo $res_incharge['AutoID']; ?>"><?php  echo $res_incharge['Name']; ?></option>
                                                <?php 
                                            }
                                           ?>
                                        </select>
                                    </div>
								</div>
                            </div>    
							</div>
                            <div class="row row-sm">
								<div class="col-md-12">
                                   <div class="form-group">
                                        <p class="mg-b-10">Remarks<span class="tx-danger">*</span></p>
                                        <textarea class="form-control" name="remarks" id="remarks" placeholder="" rows="3" Required></textarea>
                                    </div>
								</div>
                                <div class="col-md-6">
                                  
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="assettransfer_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
            
                <script>
                   
                    




                    // $('#from_company').select2({
                    //   dropdownParent: $('#assettransfermodel')
                    // });
                    // $('#to_company').select2({
                    // dropdownParent: $('#assettransfermodel')
                    // });
                    // $('#from_user').select2({
                    // dropdownParent: $('#assettransfermodel')
                    // });
                    // $('#to_user').select2({
                    // dropdownParent: $('#assettransfermodel')
                    // });
                    // $(document).ready(function() {
                    //    $('#asset_urn').multiselect();
                    // });
                </script>

                
     


		