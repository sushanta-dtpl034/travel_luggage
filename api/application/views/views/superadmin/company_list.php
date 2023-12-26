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
                    <button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" data-bs-target="#company_model" data-bs-toggle="modal" href="">
                        Add Company
                    </button>
                    <a href="<?php echo base_url()."Company/excel_export"; ?>"><button type="button" class="btn btn-sm btn-warning my-2 btn-icon-text">Export</button></a>
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
                            <strong>Company </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Company </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already Exists.</strong>
                            </div>

                            <table id="company_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company Name</th>
                                        <th>Company Short Code</th>
                                        <th>Currency</th>
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
<div class="modal" id="company_model">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Company Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
            </div>
            <form id="companyform" >
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Name <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="company_name" required="" id="company_name" onkeyup="suggestShortCode(this.value)">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p class="mg-b-10">Base Currency <span class="tx-danger">*</span></p>
                            <select class="form-control" required="" name="company_currency" id="company_currency">
                                <option label="Choose one" value=""></option>
                                    <?php 
                                    foreach($currency as $curr_res){
                                        ?>
                                            <option value="<?php echo $curr_res['AutoID']; ?>"><?php echo $curr_res['CurrencyCode']; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p class="mg-b-10">Company Short Code <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="company_shortcode" required="" id="company_shortcode" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Logo <span class="tx-danger">*(jpg,png,jpeg)</span></p>
                            <input type="file" class="form-control" name="company_logo" required="" id="company_logo" accept=".png,.jpeg,.jpg">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Stamp <span class="tx-danger">*(jpg,png,jpeg)</span></p>
                            <input type="file" class="form-control" name="company_stamp"  id="company_stamp" accept=".png,.jpeg,.jpg">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Company Address <span class="tx-danger">*</span></p>
                            <textarea class="form-control" name="company_address" id="company_address" placeholder="" rows="3" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Bank Details <span class="tx-danger">*</span></p>
                            <textarea class="form-control" name="companybank_details" id="companybank_details" placeholder="" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <p class="mb-2">Default Company</p>
                                <label class="custom-switch">
                                <input type="checkbox" value="1" name="custom-switch-checkbox" class="custom-switch-input" name="basecompany" checked id="basecompany">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Yes</span>
                                </label>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="modal-footer">
            <button class="btn ripple btn-secondary load-company" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="company_button">Save changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_companymodel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Company Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
            </div>
            <form id="up_companyform">
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Name <span class="tx-danger">*</span></p>
                            <input type="hidden" class="form-control"  name="update_id" id="update_id" >
                            <input type="text" class="form-control"  name="up_companyname" required="" id="up_companyname" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p class="mg-b-10">Base Currency <span class="tx-danger">*</span></p>
                            <select class="form-control" required="" name="up_companycurrency" id="up_companycurrency">
                                <option label="Choose one" value=""></option>
                                    <?php 
                                    foreach($currency as $curr_res){
                                        ?>
                                            <option value="<?php echo $curr_res['AutoID']; ?>"><?php echo $curr_res['CurrencyCode']; ?></option>
                                        <?php
                                    }
                                    ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p class="mg-b-10">Company Short Code <span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="up_company_shortcode" required="" id="up_company_shortcode">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Logo <span class="tx-danger">*(jpg,png,jpeg)</span></p>
                            <!-- <input type="file" class="form-control" name="company_logo" required="" id="company_logo"> -->
                            <img src="" id="update_companylogo" class="update_companylogo"  width="150" height="150" style="object-fit: contain;">
                            <i class="fa fa-camera  button-aligh company" ></i>
                            <input class="companylog" type="file" accept="image/*" id="update_logo" name="update_logo" accept=".png,.jpeg,.jpg"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Company Stamp <span class="tx-danger">*(jpg,png,jpeg)</span></p>
                            <!-- <input type="file" class="form-control" name="company_stamp" required="" id="company_stamp"> -->
                            <img src="" id="update_companystamp" class="update_companystamp"  width="150" height="150" style="object-fit: contain;">
                            <i class="fa fa-camera  button-aligh stamp" ></i>
                            <input class="companystamp" type="file" accept="image/*" id="update_stamp" name="update_stamp" accept=".png,.jpeg,.jpg"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Company Address <span class="tx-danger">*</span></p>
                            <textarea class="form-control" name="up_companyaddress" id="up_companyaddress"  placeholder="Textarea" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="mg-b-10">Bank Details <span class="tx-danger">*</span></p>
                            <textarea class="form-control" name="up_bank_details" id="up_bank_details" placeholder="" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <p class="mb-2">Default Company</p>
                                <label class="custom-switch">
                                <input type="checkbox" value="1" name="custom-switch-checkbox" class="custom-switch-input" name="up_basecompany" checked id="up_basecompany">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Yes</span>
                                </label>
                        </div>
                    </div>
                   
                </div>
            </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-company" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="update_company">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="update_close">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->
