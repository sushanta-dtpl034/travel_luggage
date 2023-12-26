<body class="main-body leftmenu">

<!-- Loader -->
<div id="global-loader">
    <img src="<?php echo base_url(); ?>assets/img/loader.svg" class="loader-img" alt="Loader">
</div>
<!-- End Loader -->

<!-- Page -->
<div class="page">
    <!-- Main Content-->
    <!-- <div class="main-content side-content pt-0"> -->
        
    <div class="main-content  pt-0">

        <div class="container-fluid">
            <div class="inner-body">
                <!-- Row -->
              
                       
             
                <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                    
                        <div class="card" style="width:100%;">
                            <div class="card-body">
                            <div class="row row-sm">
                            <div class="col-lg-12">

                                <?php 
                                    $register =  $this->uri->segment(3);
                                    if(isset($register)){
                                        if($register=='s3'){    
                                        ?>
                                            <div class="alert alert-danger mg-b-0" role="alert">
                                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Already</strong> registered
                                            </div>
                                        <?php
                                        }
                                    }
                                ?>
                                <div class="text-center">
                                    <h6 class="main-content-label mb-1"><?php if(isset($plan->PlanName)){echo $plan->PlanName;}?></h6>
                                    <p class="text-muted card-sub-title"><?php if(isset($plan->Price)){echo '$'.round($plan->Price); }?></p>
                                </div>
                               
                                <form id="wizard3" action="#" enctype="multipart/form-data">
                                
                                    <h3>Company Details</h3>
                                                                      <section>
                                        <div class="form-group">
                                        <input class="form-control"  type="hidden" id="cityid" name="cityid" >
                                        <input class="form-control"  type="hidden" id="stateid" name="stateid">
                                        <input class="form-control"  type="hidden" id="countryid" name="countryid" >
                                        <input class="form-control"  type="hidden" id="planid" name="planid" value="<?php echo $plan->AutoID; ?>">
                                        <input class="form-control"  type="hidden" id="planname" name="planname" value="<?php echo $plan->PlanName; ?>">
                                        <input class="form-control"  type="hidden" id="planprice" name="planprice" value="<?php echo $plan->Price; ?>">

                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Company name<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="company_name" name="company_name" data-parsley-minlength="3">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Company Logo<span class="tx-danger">*</span></label>
                                            <input type="file" required=""  name="company_logo" class="form-control" id="company_logo"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Address<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="address"  name="address" data-parsley-minlength="5">
                                        </div>
                                        <div class="form-group"> 
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">City<span class="tx-danger">*</span></label>
                                            <select class="form-control select select2-with-search"  id="city" name="city" required="">
                                                <option value="">Select City</option>
                                                <?php foreach($city as $res){?>
                                                <option value="<?php echo $res['AutoID']."/".$res['AutoID']."/".$res['AutoID']; ?>"><?php echo $res['CitiName']; ?></option>
                                              <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">State<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="state" name="state" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Pincode<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="pincode" name="pincode">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Country<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="country"  name="country" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">PAN</label>
                                            <input class="form-control" required="" type="text" name="pan" id="pan">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Tax ID</label>
                                            <input class="form-control" required="" type="text"  name="tax_id"  id="tax_id">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">GST no</label>
                                            <input class="form-control" required="" type="text" name="gst_no" id="gst_no">
                                        </div>
                                    </section>
                                    <h3>Contact Details</h3>
                                    <section >
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Contact person name<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="contactperson_name"  name="contactperson_name" data-parsley-minlength="3">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Email Id<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="email" id="contact_emailid"  name="contact_emailid">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Office phone no</label>
                                            <input class="form-control" required="" type="text" id="office_phone_no"  name="office_phone_no">
                                        </div>
                                        <div class="row row-sm">
											<div class="col-lg-12">
												<div class="mg-b-20">
                                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Contact person mobile no<span class="tx-danger">*</span></label>
													<div class="input-group">
														<div class="input-group-text">
															<i class="flh--9 op-6" id="countryCode"></i>
														</div>
                                                        <input class="form-control" required="" type="text" id="contactperson_mobileno"  name="contactperson_mobileno">
													</div>
												</div>
											</div>
                                    </div>    
                                    </section>
                                    <h3>Login Details</h3>  
                                    <section id="login">
                                    <div class="loadingOverlay"></div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">User Name<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="username"  name="username">
                                            <input class="form-control"  value="<?php echo base_url()."Register/saveRegister"; ?>" type="hidden" id="regisurl">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Pass Word(password must be at least 6 characters long with 1 uppercase ,1 number,1 special characters)<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="password" id="password"  name="password" placeholder="Password@123">
                                        </div>
                                        <div class="form-group">
                                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Conform Password<span class="tx-danger">*</span></label>
                                            <input class="form-control" required="" type="password" id="conform_password"  name="conform_password" data-parsley-equalto="#password">
                                        </div>
                                        <div class="form-group text-center">
                                           <button class="btn ripple btn-secondary" disabled type="button" style="display:none"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                                        </div>
                                    </section>
                                            </div> 
                                    </form>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    