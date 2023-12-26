		<!-- Main Content-->
        <style>
            .sp-container.sp-hidden{z-index: 20000 !important;}
        </style>
        <div class="main-content side-content pt-0">

<div class="container-fluid">
    <div class="inner-body">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">Asset details</h2>
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                </ol> -->
            </div>
           

        </div>
        <!-- Row -->

           <?php 
              
              foreach($asset_details as $res_deta){
                 $AutoID = $res_deta['Assetid'];
                 $UIN = $res_deta['UIN'];
                 $PurchasePrice = $res_deta['PurchasePrice'];
                 $VendorName = $res_deta['VendorName'];
                 $AsseCatName = $res_deta['AsseCatName'];
                 $AssetSubcatName = $res_deta['AssetSubcatName'];
                 $AsseTypeName = $res_deta['AsseTypeName'];
                 $PurchaseDate = $res_deta['PurchaseDate'];
                 $VendorAddress = $res_deta['VendorAddress'];
                 $DimensionOfAsset = $res_deta['DimensionOfAsset'];
                 $VendorMobile = $res_deta['VendorMobile'];
                 $VendorEmail = $res_deta['VendorEmail'];
                 $DepreciationRate = $res_deta['DepreciationRate'];
                 $ConditionName = $res_deta['ConditionName'];
                 $ValidTil = $res_deta['ValidTil'];
                 $auditor = $res_deta['auditor'];
                 $incharge = $res_deta['incharge'];
                 $supervisor = $res_deta['supervisor'];
                 $VerifiedLocation = $res_deta['VerifiedLocation'];
                 $verifiedname = $res_deta['vname'];
                 $VerifiedDatetime = $res_deta['VerifiedDatetime'];
                 $verifycon = $res_deta['verifycon'];
                 $isVerify = $res_deta['isVerify'];
                 $isRemove = $res_deta['isRemove'];
                 $RemovedLocation = $res_deta['RemovedLocation'];
                 $RemovedDatetime = $res_deta['RemovedDatetime'];
                 $Rname = $res_deta['Rname'];
                 $removecond = $res_deta['removecond'];
                 $AssetOwner = $res_deta['CompanyName'];
                 $AssetOwner = $res_deta['CompanyName'];
                 $VerificationInterval = $res_deta['VerificationInterval'];
                 $CreatedDate = $res_deta['CreatedDate'];
                 $today = date("Y-m-d");
                 $VerificationDate = $res_deta['VerificationDate'];
                $date1_ts = strtotime($today);
                $date2_ts = strtotime($VerificationDate);
                $diff = $date2_ts - $date1_ts;
                $verifyday = round($diff / 86400);
                $button_status = 0;
                if($verifyday<=7){
                    $button_status = 1;
                }
            
			// 	 $resbill = $this->Assetmodel->getbils($id);
			// 	foreach($resbill as $bill){
			//       $res_autoid.= $bill['AutoID'].",";	
			// 	  $resbill_array[] = $bill['ImageName'];
			// 	}

			// 	$warbill = $this->Assetmodel->getwaranty($id);
			//    foreach($warbill as $war){
			// 	 $war_autoid.= $war['AutoID'].",";	   
			// 	 $war_array[] = $war['ImageName'];
			//    }

	
              }


          ?>
        
        <div class="card custom-card overflow-hidden">
                         <div class="card-body">
           
             <div class="row row-sm">
                 
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Owner company </p>
                        <input type="hidden" class="form-control"  name="view_createdDate"  id="view_createdDate" value="<?php echo $CreatedDate; ?>" >
                        <input type="hidden" class="form-control"  name="view_verifyinterval"  id="view_verifyinterval" value="<?php echo $VerificationInterval; ?>" >

                        <input type="hidden" class="form-control"  name="view_VerificationDate"  id="view_VerificationDate" value="<?php echo $VerificationDate; ?>" >

                        <input type="hidden" class="form-control"  name="view_assetid"  id="view_assetid" value="<?php echo $AutoID;  ?>" >
                        <input type="text" class="form-control"  name="view_assetownerid"  id="view_assetownerid" value="<?php echo $AssetOwner;  ?>" readonly>
                       
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Type </p>
                        <input type="text" class="form-control"  name="view_assettype"  id="view_assettype" value="<?php echo $AsseTypeName;  ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Category </p>
                        <input type="text" class="form-control"  name="vew_assetcat"  id="vew_assetcat"value="<?php echo $AsseCatName;  ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Sub Category </p>
                        <input type="text" class="form-control"  name="view_assetsubcat"  id="view_assetsubcat" value="<?php echo $AssetSubcatName;  ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset Unique Identification Number </p>
                        <input type="text" class="form-control"  name="view_assetUIN" id="view_assetUIN" required="" value="<?php echo $UIN;  ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchase price</p>
                        <div class="input-group">
                         <input class="form-control " required="" type="text" id="viewasset_purchaseprice"  value="<?php echo $PurchasePrice;  ?>" name="viewasset_purchaseprice" readonly>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased on</p>
                        <!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
                        <input class="form-control datepicker"  placeholder="" type="date" id="viewasset_purchasedon" readonly value="<?php echo $PurchaseDate;  ?>">
                        <!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
                        <!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor name)</p>
                        <input type="text" class="form-control"  name="view_vendorname" required="" id="view_vendorname" value="<?php echo $VendorName;  ?>"  readonly>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor email id)</p>
                        <input type="text" class="form-control"  name="view_vendoremail" required="" id="view_vendoremail" value="<?php echo $VendorEmail;  ?>"  readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor mobile no)</p>
                        <!-- <input type="text" class="form-control"  name="vendor_mobile" required="" id="vendor_mobile"> -->
                        <div class="input-group telephone-input" style="display: block";>
                            <input type="tel"  class="form-control " id="view_vendormobile" name="view_vendormobile"  style="width:100%;" value="<?php echo $VendorMobile;  ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor address)</p>
                        <!-- <textarea class="form-control" placeholder="Textarea" rows="3" id="vendor_address"></textarea> -->
                        <input type="text" class="form-control"  name="view_vendoraddress" required="" id="view_vendoraddress" readonly value="<?php echo $VendorAddress;  ?>">										


                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Dimension of Asset in CMS </p>
                        <input type="text" class="form-control"  name="viewasset_dimenson" required="" id="viewasset_dimenson" readonly value="<?php echo $DimensionOfAsset  ;  ?>">    
                                                          

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Depreciation rate </p>
                        <input type="text" class="form-control" id="view_depreciationrate" name="view_depreciationrate" readonly value="<?php echo $DepreciationRate;  ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset condition </p>
                        <input type="text" class="form-control" id="view_assetmentcondition" name="view_assetmentcondition" readonly value="<?php echo $ConditionName;  ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Warranty valid until</p>
                        <!-- <input class="form-control" id="valid_till" placeholder="MM/DD/YYYY" type="text"> -->
                        <input class="form-control" id="view_validtill"  type="date" readonly value="<?php echo $ValidTil;  ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Auditor </p>
                        <input class="form-control" id="view_assetauditorname"  type="text" readonly value="<?php echo $auditor;  ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Incharge </p>
                        <input class="form-control" id="view_asstmaninchargename"  type="text" readonly value="<?php echo $incharge;  ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <p class="mg-b-10">Supervisor </p>
                        <input class="form-control" id="view_assetsupervisorname"  type="text" readonly value="<?php echo $supervisor;  ?>">
                    </div>
                </div>
                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mg-b-10">Asset Picture </p>
                                        <ul  class="list-unstyled row mb-0" id="detail_picture">
                                        <?php 
                                           if(count($assetpictures)>0){
                                           foreach ($assetpictures as $detail_pic){
                                              $url =  base_url()."upload/asset/".$detail_pic['ImageName'];
                                               $ext = pathinfo($detail_pic['ImageName'], PATHINFO_EXTENSION);
                                               if($ext=='pdf'){
                                              ?>
                                                <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='<?php echo  $url; ?>'><?php echo $detail_pic['ImageName'];  ?></a></li>
                                               <?php 
                                               }
                                               else{
                                               ?>
                                                 <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><img class='img-responsive' src='<?php echo  $url; ?>'></li>
                                               <?php
                                               }
                                           }
                                        }
                                        ?>
									</ul>
                                       
                                    </div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <p class="mg-b-10">Vendor Bill </p>
                                        <ul  class="list-unstyled row mb-0" id="view_vendor">

                                        <?php 
                                         if(count($assetbill)>0){
                                           foreach ($assetbill as $detail_bill){
                                               $url1 =  base_url()."upload/asset/".$detail_bill['ImageName'];
                                               $ext1 = pathinfo($detail_bill['ImageName'], PATHINFO_EXTENSION);
                                               if($ext1=='pdf'){
                                              ?>
                                                <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='<?php echo $url1; ?>'><?php echo $detail_bill['ImageName'];  ?></a></li>
                                               <?php 
                                               }
                                               else{
                                               ?>
                                                 <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><img class='img-responsive' src='<?php echo  $url1; ?>'></li>
                                               <?php
                                               }
                                           }
                                        }
                                        ?>
                                          
                                          </ul>
                                       
                                    </div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty Card </p>
                                        <ul  class="list-unstyled row mb-0" id="view_waranty">
                                        <?php 
                                            if(count($assetwaranty)>0){
                                           foreach ($assetwaranty as $detail_waranty){
                                             
                                               $url2 =  base_url()."upload/asset/".$detail_waranty['ImageName'];
                                               $ext3 = pathinfo($detail_waranty['ImageName'], PATHINFO_EXTENSION);
                                               if($ext3=='pdf'){
                                              ?>
                                                <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='<?php echo $url2; ?>'><?php echo $detail_waranty['ImageName'];  ?></a></li>
                                               <?php 
                                               }
                                               else{
                                               ?>
                                                 <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><img class='img-responsive' src='<?php echo  $url2; ?>'></li>
                                               <?php
                                               }
                                           }
                                        }
                                        ?>
                                          </ul>
                                    </div>
								</div>  
                                <?php
                                   if(count($His)>0){
                                ?>
                                <div class="col-md-12">
                                    <h6 class="main-content-label mb-1">Verification/Remove Details</h6>
                                </div>
                            <table id="assest_details" class="table table-bordered border-t0 key-buttons text-nowrap w-100">
                                <thead>
                                        <tr>
                                        <th>S.No</th>
                                        <th>Type</th>
                                        <th>By</th>
                                        <th>Date</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                       foreach($His as $res_his){
                                           $i++;
                                        ?>
                                           <tr>
                                        <th><?php echo $i; ?></th>
                                        <th><?php if($res_his['type']==1){ ?>
                                            <span class="badge bg-success text-white rounded-pill" style="width:130px;">Verified</span>
                                            <?php
                                            }
                                            else{ ?>
                                                <span class="badge bg-danger text-white rounded-pill" style="width:130px;">Removed</span>
                                                <?php
                                            }
                                            ?></th>
                                        <th><?php  echo $res_his['Name'];?></th>
                                        <th><?php  echo $res_his['VRemoveDate']; ?></th>
                                        </tr>
                                        <?php
                                       }
                                    ?>
                                </tbody>
                            </table>

                             <?php
                                   }
                                if($verify_type==1 && $verify_type!=2){
                                        if( $isRemove==1){
                                            ?>
                                                <div class="alert alert-danger" role="alert">
                                                Asset is Removed
                                                </div>
                                            <?php
                                        }else{
                                            
                                            if($button_status==1){
                                    ?>
                                        <div class="col-md-12 text-center">
                                        <button class="btn ripple btn-primary verify" type="button" id="assetverify_button" >Verify</button>
                                        </div>   
                                    <?php 
                                            }
                                        }
                                  }
                                ?>  

                              <?php
                                   if($verify_type=='2' && $isVerify==1){
                                    if( $isRemove==1){
                                        ?>
                                            <div class="alert alert-danger" role="alert">
                                            Asset  is Already Removed
                                            </div>
                                        <?php
                                    }else{
                                ?>  
                                    <div class="col-md-12 text-center">
                                    <button class="btn ripple btn-primary remove" type="button" id="assetremove_button">Remove</button>
                                    </div>   
                                <?php 
                                    }
                                  }
                                ?>  
                                
               
               
              </div>     
         
             
        
 
           
    </div>
</div>
</div>
    </div>
                                    </div>
                                    </div>
<!-- End Main Content-->
<!-- insert Grid modal -->


<div class="modal" id="verify_model">

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h6 class="modal-title">Verify Asset</h6>
            <input type="hidden" id="verify_lat" name="location['lat']" value="">
            <input type="hidden" id="verify_long" name="location['long']" value="">
            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
        </div>
    <form id="verify_form" enctype="multipart/form-data">
        <div class="modal-body">
        <!-- <div class="col-md-6">
            <div class="form-group">
            <div id="map"></div>
                <p class="mg-b-10">Location <span class="tx-danger">*</span></p>
            <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly >
                <textarea class="form-control" placeholder="" rows="3" id="verify_address" readonly></textarea>
            </div>
        </div> -->
        <div class="col-md-6">
            <div class="form-group">
                <p class="mg-b-10">Material Condition <span class="tx-danger">*</span></p>
                <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                <select class="form-control select2" required="" name="verify_condition" id="verify_condition">
                <option label="Choose one" value=""></option>
                <?php 
                foreach($material as $mat_res){
                ?>
                <option value="<?php echo $mat_res['AutoID']; ?>"><?php echo $mat_res['ConditionName']; ?></option>
                <?php
                }
                ?>

                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <p class="mg-b-10">Picture <span class="tx-danger">*</span></p>
            <input type="file" class="dropify" data-height="200" id="verify_picture" multiple required="">
            </div>
        </div>
          
          
        </div>
      </form>
        <div class="modal-footer">
            <button class="btn ripple btn-primary" type="button" id="verify_button">Verify</button>
            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
        </div>
    </div>
</div>
</div>


<div class="modal" id="remove_model">

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-content-demo">
        <div class="modal-header">
            <h6 class="modal-title">Remove Asset</h6>
            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            
        </div>
    <form id="remove_form" enctype="multipart/form-data">
        <input type="hidden" name="location['lat']"id="lat" value="">
        <input type="hidden" name="location['long']" id="long" value="">
        <div class="modal-body">

        <!-- <div class="col-md-6">
            <div class="form-group">
                <p class="mg-b-10">Location <span class="tx-danger">*</span></p>
                <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly >
                <textarea class="form-control" placeholder="" rows="3" id="remove_address" readonly></textarea>
            </div>
        </div> -->
            
        <div class="col-md-6">
            <div class="form-group">
                <p class="mg-b-10">Material Condition<span class="tx-danger">*</span></p>
                <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                <select class="form-control select2" required="" name="remove_condition" id="remove_condition">
                <option label="Choose one" value=""></option>
                <?php 
                foreach($material as $mat_res){
                ?>
                <option value="<?php echo $mat_res['AutoID']; ?>"><?php echo $mat_res['ConditionName']; ?></option>
                <?php
                }
                ?>

                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <p class="mg-b-10">Picture <span class="tx-danger">*</span></p>
            <input type="file" class="dropify" data-height="200" id="remove_picture" multiple required="">
            </div>
        </div>
          
          
        </div>
      </form>
        <div class="modal-footer">
            <button class="btn ripple btn-primary" type="button" id="remove_button">Remove</button>
            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="Removereason" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Remove Status</h5>
        </div>
      <div class="modal-body" id="">
      <div class="col-md-6">
            <div class="form-group">
                  <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                <select class="form-control select2" required="" name="remove_status" id="remove_status">
                   <option  value="1">Sold</option>
                   <option  value="2">transferred</option>
                   <option  value="3">lost</option>
                   <option  value="4">destroyed</option>
               </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>





