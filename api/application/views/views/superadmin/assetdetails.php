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
                  $UIN = !empty($res_deta['UIN']) ? $res_deta['UIN'] : 'NA';
                  $auditerid = !empty($res_deta['Auditorid']) ? $res_deta['Auditorid'] : 'NA';
                  $PurchasePrice = !empty($res_deta['PurchasePrice']) ? $res_deta['PurchasePrice'] : 'NA';
                  $VendorName = !empty($res_deta['VendorName']) ? $res_deta['VendorName'] : 'NA';
                  $AsseCatName = !empty($res_deta['AsseCatName']) ? $res_deta['AsseCatName'] : 'NA';
                  $AssetSubcatName = !empty($res_deta['AssetSubcatName']) ? $res_deta['AssetSubcatName'] : 'NA'; 
                  $AssetTitle = !empty($res_deta['AssetTitle']) ? $res_deta['AssetTitle'] : 'NA'; 
                  $AssetQuantity = !empty($res_deta['AssetQuantity']) ? $res_deta['AssetQuantity'] : 'NA'; 
                  $AsseTypeName = !empty($res_deta['AsseTypeName']) ? $res_deta['AsseTypeName'] : 'NA'; 
                  $PurchaseDate = !empty($res_deta['PurchaseDate']) ? $res_deta['PurchaseDate'] : 'NA'; 
                  $VendorAddress = !empty($res_deta['VendorAddress']) ? $res_deta['VendorAddress'] : 'NA'; 
                  $DimensionOfAsset = !empty($res_deta['DimensionOfAsset']) ? $res_deta['DimensionOfAsset'] : 'NA'; 
                  $VendorMobile = !empty($res_deta['VendorMobile']) ? $res_deta['VendorMobile'] : 'NA'; 
                  $VendorEmail = !empty($res_deta['VendorEmail']) ? $res_deta['VendorEmail'] : 'NA'; 
                  $DepreciationRate = !empty($res_deta['DepreciationRate']) ? $res_deta['DepreciationRate'] : 'NA'; 
                  $ConditionName = !empty($res_deta['ConditionName']) ? $res_deta['ConditionName'] : 'NA'; 
                  $ValidTil = !empty($res_deta['ValidTil']) ? $res_deta['ValidTil'] : 'NA'; 
                  $auditor = !empty($res_deta['auditor']) ? $res_deta['auditor'] : 'NA';
                  $incharge = !empty($res_deta['incharge']) ? $res_deta['incharge'] : 'NA'; 
                  $supervisor = !empty($res_deta['supervisor']) ? $res_deta['supervisor'] : 'NA'; 
                  $VerifiedLocation = !empty($res_deta['VerifiedLocation']) ? $res_deta['VerifiedLocation'] : 'NA'; 
                  $verifiedname = !empty($res_deta['vname']) ? $res_deta['vname'] : 'NA'; 
                  $VerifiedDatetime = !empty($res_deta['VerifiedDatetime']) ? $res_deta['VerifiedDatetime'] : 'NA'; 
                  $verifycon = !empty($res_deta['verifycon']) ? $res_deta['verifycon'] : 'NA'; 
                  $isVerify = !empty($res_deta['isVerify']) ? $res_deta['isVerify'] : 'NA'; 
                  $isRemove = !empty($res_deta['isRemove']) ? $res_deta['isRemove'] : 'NA'; 
                  $RemovedLocation = !empty($res_deta['RemovedLocation']) ? $res_deta['RemovedLocation'] : 'NA'; 
                  $RemovedDatetime = !empty($res_deta['RemovedDatetime']) ? $res_deta['RemovedDatetime'] : 'NA'; 
                  $Rname = !empty($res_deta['Rname']) ? $res_deta['Rname'] : 'NA'; 
                  $removecond = !empty($res_deta['removecond']) ? $res_deta['removecond'] : 'NA'; 
                  $AssetOwner = !empty($res_deta['CompanyName']) ? $res_deta['CompanyName'] : 'NA'; 
                  $VerificationInterval = !empty($res_deta['VerificationInterval']) ? $res_deta['VerificationInterval'] : 'NA'; 
                  $CreatedDate = !empty($res_deta['CreatedDate']) ? $res_deta['CreatedDate'] : 'NA'; 
                $today = date("Y-m-d");
                 $VerificationDate = $res_deta['VerificationDate'];
                $date1_ts = strtotime($today);
                $date2_ts = strtotime($VerificationDate);
                $diff = $date2_ts - $date1_ts;
                $verifyday = round($diff / 86400);
                $button_status = 0;
                $NumberOfPicture = !empty($res_deta['NumberOfPicture']) ? $res_deta['NumberOfPicture'] : 'NA'; 
                $titleStatus = !empty($res_deta['titleStatus']) ? $res_deta['titleStatus'] : 'NA'; 
                $UniqueRefNumber = !empty($res_deta['UniqueRefNumber']) ? $res_deta['UniqueRefNumber'] : 'NA'; 
                $WarrantyCoverdfor = !empty($res_deta['WarrantyCoverdfor']) ? $res_deta['WarrantyCoverdfor'] : 'NA'; 
                $InsuranceValidUpto = !empty($res_deta['InsuranceValidUpto']) ? $res_deta['InsuranceValidUpto'] : 'NA'; 
                $WarrantyContactPersonMobile = !empty($res_deta['WarrantyContactPersonMobile']) ? $res_deta['WarrantyContactPersonMobile'] : 'NA'; 
                $WarrantyContactPersonEmail = !empty($res_deta['WarrantyContactPersonEmail']) ? $res_deta['WarrantyContactPersonEmail'] : 'NA';
                $assetSubcat = !empty($res_deta['AssetSubcat']) ? $res_deta['AssetSubcat'] : 'NA';
                $waranty = $this->Assetmodel->getwarrant_basedonsubcat($assetSubcat);
                $waranty_list = explode(',',$WarrantyCoverdfor);

              }

            //   print_r($button_status);
            $userid=$this->session->userdata('userid');
              ///for first time veryfication
              if($auditerid==$userid && $veryfy_exists==0){
                    $button_status=1;
                    // print_r("auditer");
              }else{
                $button_status=0;
                // print_r("no auditer");
                if($verifyday<=7){
                    $button_status = 1;
                }
              }
          ?>
        
        <div class="card custom-card overflow-hidden">
                         <div class="card-body">
           
             <div class="row row-sm">
             <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset Unique Identification Number </p>
                        <p><b><?php echo $UIN; ?></b></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10"> Unique Ref No </p>
                        <p><b><?php echo $UniqueRefNumber; ?></b></p>
                    </div>
                </div>
                 
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Owner company </p>
                        <input type="hidden" class="form-control"  name="view_createdDate"  id="view_createdDate" value="<?php echo $CreatedDate; ?>" >
                        <input type="hidden" class="form-control"  name="view_verifyinterval"  id="view_verifyinterval" value="<?php echo $VerificationInterval; ?>" >

                        <input type="hidden" class="form-control"  name="view_VerificationDate"  id="view_VerificationDate" value="<?php echo $VerificationDate; ?>" >

                        <input type="hidden" class="form-control"  name="view_assetid"  id="view_assetid" value="<?php echo $AutoID;  ?>" >
                        <input type="hidden" class="form-control"  name="view_titlestatus"  id="view_titlestatus" value="<?php echo $titleStatus;  ?>" >
                        <!-- <input type="text" class="form-control"  name="view_assetownerid"  id="view_assetownerid" value="<?php echo $AssetOwner;  ?>" readonly> -->
                        <!-- if first time veryfy NumberOfPicture=0 defult -->
                        <p><b><?php echo $AssetOwner; ?></b></p>
                        <input type="hidden" class="form-control"  name="view_numberOfPicture"  id="view_numberOfPicture" value="<?php echo $veryfy_exists==0 ? 0 : $NumberOfPicture;?>" >  
                       
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Type </p>
                        <!-- <input type="text" class="form-control"  name="view_assettype"  id="view_assettype" value="<?php echo $AsseTypeName;  ?>" readonly> -->
                        <p><b><?php echo $AsseTypeName; ?></b></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Category </p>
                        <!-- <input type="text" class="form-control"  name="vew_assetcat"  id="vew_assetcat"value="<?php echo $AsseCatName;  ?>" readonly> -->
                        <p><b><?php echo $AsseCatName; ?></b></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Sub Category </p>
                        <!-- <input type="text" class="form-control"  name="view_assetsubcat"  id="view_assetsubcat" value="<?php echo $AssetSubcatName;  ?>" readonly> -->
                        <p><b><?php echo $AssetSubcatName; ?></b></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset Title </p>
                        <!-- <input type="text" class="form-control" name="asset_title" required="" value="<?php echo $AssetTitle;  ?>" id="view_assettitle" readonly=""> -->
                        <p><b><?php echo $AssetTitle; ?></b></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10"> Asset quantity </p>
                        <!-- <input type="text" class="form-control" name="asset_qty" id="view_assetqty" value="<?php echo $AssetQuantity;  ?>" readonly=""> -->
                        <p><b><?php echo $AssetQuantity; ?></b></p>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchase price</p>
                        <div class="input-group">
                         <!-- <input class="form-control " required="" type="text" id="viewasset_purchaseprice"  value="<?php echo $PurchasePrice;  ?>" name="viewasset_purchaseprice" readonly> -->
                         <p><b><?php echo $PurchasePrice; ?></b></p>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased on</p>
                        <!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
                        <!-- <input class="form-control datepicker"  placeholder="" type="date" id="viewasset_purchasedon" readonly value="<?php echo $PurchaseDate;  ?>"> -->
                        <!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
                        <!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
                        <p><b><?php echo $PurchaseDate; ?></b></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor name)</p>
                        <!-- <input type="text" class="form-control"  name="view_vendorname" required="" id="view_vendorname" value="<?php echo $VendorName;  ?>"  readonly> -->
                        <p><b><?php echo $VendorName; ?></b></p>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor email id)</p>
                        <!-- <input type="text" class="form-control"  name="view_vendoremail" required="" id="view_vendoremail" value="<?php echo $VendorEmail;  ?>"  readonly> -->
                        <p><b><?php echo $VendorEmail; ?></b></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor mobile no)</p>
                        <!-- <input type="text" class="form-control"  name="vendor_mobile" required="" id="vendor_mobile"> -->
                        <div class="input-group telephone-input" style="display: block";>
                            <!-- <input type="tel"  class="form-control " id="view_vendormobile" name="view_vendormobile"  style="width:100%;" value="<?php echo $VendorMobile;  ?>" readonly> -->
                            <p><b><?php echo $VendorMobile; ?></b></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset purchased from(vendor address)</p>
                        <!-- <textarea class="form-control" placeholder="Textarea" rows="3" id="vendor_address"></textarea> -->
                        <!-- <input type="text" class="form-control"  name="view_vendoraddress" required="" id="view_vendoraddress" readonly value="<?php echo $VendorAddress;  ?>">										 -->
                        <p><b><?php echo $VendorAddress; ?></b></p>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Dimension of Asset in CMS </p>
                        <!-- <input type="text" class="form-control"  name="viewasset_dimenson" required="" id="viewasset_dimenson" readonly value="<?php echo $DimensionOfAsset  ;  ?>">     -->
                        <p><b><?php echo $DimensionOfAsset; ?></b></p>                                  
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Depreciation rate </p>
                        <!-- <input type="text" class="form-control" id="view_depreciationrate" name="view_depreciationrate" readonly value="<?php echo $DepreciationRate;  ?>"> -->
                        <p><b><?php echo $DepreciationRate; ?></b></p>    
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset condition </p>
                        <!-- <input type="text" class="form-control" id="view_assetmentcondition" name="view_assetmentcondition" readonly value="<?php echo $ConditionName;  ?>"> -->
                        <p><b><?php echo $ConditionName; ?></b></p>    
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Warranty valid until</p>
                        <!-- <input class="form-control" id="valid_till" placeholder="MM/DD/YYYY" type="text"> -->
                        <!-- <input class="form-control" id="view_validtill"  type="date" readonly value="<?php echo $ValidTil;  ?>"> -->
                        <p><b><?php echo $ValidTil; ?></b></p>    
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Auditor </p>
                        <!-- <input class="form-control" id="view_assetauditorname"  type="text" readonly value="<?php echo $auditor;  ?>"> -->
                        <p><b><?php echo $auditor; ?></b></p>  
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Asset Incharge </p>
                        <!-- <input class="form-control" id="view_asstmaninchargename"  type="text" readonly value="<?php echo $incharge;  ?>"> -->
                        <p><b><?php echo $incharge; ?></b></p>  
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p class="mg-b-10">Supervisor </p>
                        <!-- <input class="form-control" id="view_assetsupervisorname"  type="text" readonly value="<?php echo $supervisor;  ?>"> -->
                        <p><b><?php echo $supervisor; ?></b></p>  
                    </div>
                </div>

                                    <div class="form-group">
                                        <p class="mg-b-10"> Warranty Covered for</p>
                                        <?php 
                                                 
                                                foreach($waranty as $res_waranty){
                                                      if (in_array($res_waranty['AutoID'],$waranty_list)){ 
                                                          echo "<p><b>".$res_waranty['WarrantyTypeName']."</b></p>";
                                                      }
                                                }
                                             ?>
                                        </select>
                                    </div>
								</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty contact person mobile </p>
                                        <!-- <input type="text" class="form-control"  name="warranty_contact_mobile" required="" id="warranty_contact_mobile" value="<?php echo $WarrantyContactPersonMobile; ?>" readonly> -->
                                        <p><b><?php echo $WarrantyContactPersonMobile; ?></b></p>
                                    </div>
								</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Warranty contact person email </p>
                                        <p><b><?php echo $WarrantyContactPersonEmail; ?></b></p>
                                        <!-- <input type="email" class="form-control"  name="warranty_contact_email" required="" id="warranty_contact_email" value="<?php echo $WarrantyContactPersonEmail; ?>" readonly> -->
                                    </div>
								</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Insurance valid upto </p>
                                        <p><b><?php echo $InsuranceValidUpto; ?></b></p>
                                        <!-- <input type="date" class="form-control"  name="insurance_valid_upto" required="" id="insurance_valid_upto" value="<?php echo $InsuranceValidUpto; ?>"  readonly> -->
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
                                        }else{
                                             ?>
                                                <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='javascript:void(0);'>No Attachement</a></li>
                                             <?php 
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
                                        }else{
                                            ?>
                                               <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='javascript:void(0);'>No Attachement</a></li>
                                            <?php 
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
                                        }else{
                                            ?>
                                               <li class='col-xs-6 col-sm-4 col-md-4 col-xl-4 mb-3'><a  href='javascript:void(0);'>No Attachement</a></li>
                                            <?php 
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
                                        <th>Condition</th>
                                        <th>Remove Status</th>
                                        <th>By</th>
                                        <th>Date</th>
                                        <th>Attachment</th>
                                        </tr>

                                        
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                       foreach($His as $res_his){
                                           $i++;
                                        ?>
                                           <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php if($res_his['type']==1){ ?>
                                            <span class="badge bg-success text-white rounded-pill" style="width:130px;">Verified</span>
                                            <?php
                                            }
                                            else{ ?>
                                                <span class="badge bg-danger text-white rounded-pill" style="width:130px;">Removed</span>
                                                <?php
                                            }
                                            ?></th>
                                         <td><?php  echo $res_his['ConditionName'];?></td>
                                        
                                         </td>  
                                         <td><?php 
                                         if($res_his['RemoveStatus']==1){
                                            echo "Sold";
                                         }elseif($res_his['RemoveStatus']==2){
                                            echo "Transferred";
                                         }
                                         elseif($res_his['RemoveStatus']==3){
                                            echo "lost";
                                        }
                                        elseif($res_his['RemoveStatus']==4){
                                            echo "destroyed";
                                        }
                                         ?></td>
                                        <td><?php  echo $res_his['Name'];?></td>
                                        <td><?php  echo $res_his['VRemoveDate']; ?></td>
                                        <td>
                                            <?php
                                               $hid = $res_his['AutoID'];
                                               $attachment = $this->Assetmodel->getAttachement($hid);
                                               if(count($attachment)>0){
                                                   ?>
                                                    <button class="btn view_his bg-success"  datatype="edit" id="<?php echo $res_his['AutoID']; ?>"><i class="si si-eye"></i></button>
                                                   <?php
                                               }
                                            ?>
                                         
                                         </td>  
                                        </tr>
                                        <?php
                                       }
                                    ?>
                                </tbody>
                            </table>
                            
                          

                             <?php
                                   }
                                if(($verify_type==1 ||$verify_type==3)  && $verify_type!=2){
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
                                        <button class="btn ripple btn-secondary verify" type="button" id="assetverify_button" >Verify Asset</button>
                                        </div>   
                                    <?php 
                                            }
                                        }
                                  }
                                ?>  

                              <?php
                                   if(($verify_type=='2' || $verify_type==3) && $isVerify==1){
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
      <div class="row">
                 <!-- <div class="col-md-6">
            <div class="form-group">
            <div id="map"></div>
                <p class="mg-b-10">Location </p>
            <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly >
                <textarea class="form-control" placeholder="" rows="3" id="verify_address" readonly></textarea>
            </div>
        </div> -->

       

        <div class="col-md-6">
            <div class="form-group">
                <p class="mg-b-10">Material Condition </p>
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
        <div class="col-md-6">
            <div class="form-group">
                <p class="mg-b-10">Asset quantity</p>
                <input type="hidden" class="form-control" name="up_asset_qnt_old" id="up_asset_qnt_old" value="<?php echo $AssetQuantity;  ?>">
                <input type="text" class="form-control" name="up_asset_qnt_new" id="up_asset_qnt_new" value="<?php echo $AssetQuantity;  ?>">
            </div>
        </div>

        <div class="col-md-12" id="remark_for_qnt" style="display:none;">
            <div class="form-group">
                <p class="mg-b-10">Remark</p>
                <textarea  class="form-control" id="qnt_remark" name="qnt_remark" rows="4" cols="50" require=""></textarea>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="form-group">
                <p class="mg-b-10">Location </p>
            <input type="text" class="form-control"  name="" required="" id="asstman_inchargename">
            </div>
        </div> -->                   
      </div>
     
      
        <div class="col-md-12 <?php echo ($veryfy_exists==0 ?'d-none':'d-block' );?>">
            <div class="form-group">
            <p class="mg-b-10">Picture </p>
            <div id="pictureupload" class="col-12">
            <div class="row " id="">
                 <div class="col-sm-5"></div>
                 <div class="col-sm-5"></div>
                 <div class="col-sm-2"><button class="btn btn-success btn-circle btn-sm float-right" type="button" name="add" onclick="addverifyFileupload();">+</button>                           </div>
            </div>
            <?php
              if($NumberOfPicture>0){
                for($i=0;$i<$NumberOfPicture;$i++){
                ?>
                <div class="row p-0 mb-2 mt-4 picturelimit" id="<?php echo "row_".$i; ?>">

                    <div class="col-sm-5"><input type="file" name="picture[]" class="picture form-control" accept=".png,.jpg,.jpeg,.pdf"></div>
                     
                    <?php
                    if($titleStatus==1){
                    ?>
                    <div class="col-sm-5"><input type="text" name="picture_tile[]" class="picture_tile form-control"></div>
                     <?php
                    }
                     ?> 
                     <div class="col-sm-2 text-right">
                        <button class="btn btn-danger btn-circle btn-sm remCF" name="sub" id="del1" type="button" onclick="removefileverify(<?php echo $i; ?>)">-</button>
                    </div>
                </div>
                <?php
                    }
              }
            ?>
            <!-- <input type="file" class="dropify" data-height="200" id="verify_picture" multiple required=""> -->
            </div>
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




<div class="modal" id="attach_model">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
            <h6 class="modal-title">View Attachment</h6>
            <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            </div>

            <div class="modal-body">
               <ul class="list-unstyled row mb-0" id="view_allattachment">
                
                
                </ul>
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
                            
                <!-- start 1st row -->
                       <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <!-- <input type="text" class="form-control"  name="" required="" id="asstman_inchargename" readonly > -->
                                <p class="mg-b-10">Remove Status</p>
                                <select class="form-control select2" required="" name="remove_status" id="remove_status">
                                <option  value="">Select Status</option>
                                <option  value="1">Sold</option>
                                <option  value="2">transferred</option>
                                <option  value="3">lost</option>
                                <option  value="4">destroyed</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Material Condition</p>
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

                       </div> 
                       <!-- end 1st row -->

                       <div class="col-md-12">
                        <div class="form-group">
                        <p class="mg-b-10">Picture </p>
                            <div class="row" id="">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                <button class="btn btn-success btn-circle btn-sm " type="button" name="add" onclick="addremoveFileupload();">+</button>
                                    </div>
                            </div>
         <div id="pictureremove" class="col-12">
            <?php
              if($NumberOfPicture>0){
                for($i=0;$i<$NumberOfPicture;$i++){
                ?>

<div class="row p-0 mb-2 mt-4 removepicturelimit" id="<?php echo "remove_".$i; ?>">
    <div class="col-sm-5">
        <input type="file" name="picture[]" class="picture form-control" accept=".png,.jpg,.jpeg,.pdf">
      </div>
      <?php
            if($titleStatus==1){
            ?>
            <div class="col-sm-5">
            <input type="text" name="remove_tile[]" class="picture_tile form-control">
            </div>
            <?php
            }
            ?> 
    <div class="col-sm-2 text-right">
       <button class="btn btn-danger btn-circle btn-sm remCF" name="sub" id="del1" type="button" onclick="removefileremove(<?php echo $i; ?>)">-</button>
    </div>
</div>


                 
                <?php 
                }
            }
                ?>
        </div>

                        </div>
                        </div>

                        
                </div>
            </form>    
   
        <div class="modal-footer">
           <button class="btn ripple btn-secondary load-removeasset" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
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



</div>
</div>
</div>


