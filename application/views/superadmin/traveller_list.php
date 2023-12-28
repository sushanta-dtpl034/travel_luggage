<!-- Main Content-->
<style>
.sp-container.sp-hidden{z-index: 20000 !important;}
.text-right{ text-align:right;}
.intl-tel-input input {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    height: 39px;
    padding-left: 47px;
    position: relative;
    z-index: 0;
    border: 1px solid #e8e8f7;
    width: 100% !important;
}
.intl-tel-input .flag-dropdown {
    position: absolute;
    z-index: 1;
    cursor: pointer;
    height: 40px;
    line-height: 15px !important;
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
                        <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                    </ol> -->
                </div>
                <div class="d-flex">
                    <div class="justify-content-center">
                        <button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" data-bs-target="#traveller_modal" data-bs-toggle="modal" href="">
                            Add Traveller
                        </button>
                        <!-- <a href="<?php echo base_url()."Company/excel_export"; ?>"><button type="button" class="btn btn-sm btn-warning my-2 btn-icon-text">Export</button></a> -->
                    </div>
                </div>
            </div>
            <!-- Row -->
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="alert alert-solid-success insert" role="alert" style="display:none">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Traveller   </strong> Generate succesfully.
                    </div>
                    <div class="alert alert-solid-success update" role="alert" style="display:none">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>Traveller  </strong> updated succesfully.
                    </div>
                    <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>Already exists.</strong>
                    </div>                        
                </div>
                <div class="col-lg-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="traveller_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Phone No</th>
                                            <th>Whatsapp No</th>
                                            <th>Address</th>
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
<div class="modal" id="traveller_modal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Traveller Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
            </div>
            <form id="add-traveller-form" >
                <div class="modal-body">
                    <!-- Show PHP Validation ERRORS Start -->
                     <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul id="form_errors"></ul>
                    </div>
                    <!-- Show PHP Validation ERRORS End -->

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Gender <span class="tx-danger">*</span></p>
                                <div class="row mg-t-10  parsley-error" id="Gender">
                                    <div class="col-lg-3">
                                        <label class="rdiobox"><input name="Gender" type="radio" class="Gender" value="Male" data-parsley-multiple="Gender" data-parsley-errors-container="#GenderErrorContainer" data-parsley-class-handler="#Gender" required> <span>Male</span></label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox"><input name="Gender" type="radio" class="Gender" value="Female" data-parsley-multiple="Gender" data-parsley-errors-container="#GenderErrorContainer" required> <span>Female</span></label>
                                    </div>
                                    <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox"><input name="Gender" type="radio" class="Gender" value="Transgender" data-parsley-multiple="Gender" data-parsley-errors-container="#GenderErrorContainer" required> <span>Transgender</span></label>
                                    </div>
                                    <div id="GenderErrorContainer"></div>
                                </div>
                                                              
                            </div>
                        </div>

                        <div class="col-md-6">
                            <p class="mg-b-10">Title <span class="tx-danger">*</span></p>
                            <div class="parsley-select" id="Suffix">
                                <select class="form-control select2" data-parsley-class-handler="#Suffix" data-parsley-errors-container="#SuffixErrorContainer"  required=""  name="Suffix" data-parsley-required-message="Choose Title">
                                    <option label="Choose Title"></option>
                                    <?php foreach($titles as $title){ ?>
                                    <option value="<?= $title['value'];?>">
                                       <?= $title['value'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <div id="SuffixErrorContainer"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="Name" required="" id="Name" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Email </p>
                                <input type="text" class="form-control"  name="Email" id="Email" placeholder="Enter Email">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Country Code </p>
                                <div class="parsley-select" id="CountryCode">
                                    <select class="form-control select2 CountryCode" required=""  name="CountryCode" data-parsley-class-handler="#CountryCode" data-parsley-errors-container="#CountryCodeErrorContainer"  data-parsley-required
                                    data-parsley-required-message="Select Country Code">
                                    <option value="">Select Country Code</option>
                                        <?php foreach($country_codes as $country_code){ ?>
                                        <option value="+<?= $country_code['Dialing'];?>">+ <?= $country_code['Dialing'];?></option>
                                        <?php } ?>
                                    </select>

                                    <div id="CountryCodeErrorContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Phone No <span class="tx-danger">*</span></p>
                                <input type="number" class="form-control" name="Mobile" id="Mobile" data-parsley-length="[6, 10]" placeholder="Phone No" required>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Country Code </p>
                                <select class="form-control select2 WhatsAppCountryCode" name="WhatsAppCountryCode" >
                                    <option value="">Select Country Code</option>
                                    <?php foreach($country_codes as $country_code){ ?>
                                    <option value="+<?= $country_code['Dialing'];?>">+ <?= $country_code['Dialing'];?></option>
                                    <?php } ?>
                                </select>
                                <div id="WhatsAppCountryCodeErrorContainer"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Whatsapp No </p>
                                <input type="tel" class="form-control" name="WhatsappNumber" placeholder="Whatsapp No">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Address  <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="Address" required="" id="Address" placeholder="Enter Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Addrss2 <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="AdressTwo" required="" id="AdressTwo" placeholder="Enter Addrss2">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Landmark </p>
                                <input type="text" class="form-control"  name="Landmark" id="Landmark" placeholder="Enter Landmark">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Profile Image<span class="tx-danger">*</span></p>
                                <input type="file" class="form-control"  name="ProfileIMG" required="" id="ProfileIMG">
                                <input type="hidden" name="oldimage" value="">
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-traveller" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="traveller_button">Save changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->
<!-- update Grid modal -->
<div class="modal" id="update-traveller-modal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Traveller Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
            </div>
            <form id="update-traveller-form">
                <div class="modal-body">
                    <!-- Show PHP Validation ERRORS Start -->
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul id="form_errors"></ul>
                    </div>
                    
                    <!-- Show PHP Validation ERRORS End -->
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Gender <span class="tx-danger">*</span></p>
                                <div class="row mg-t-10  parsley-error" id="uGender">
                                    <div class="col-lg-3">
                                        <label class="rdiobox"><input name="Gender" type="radio" class="uGender" value="Male" data-parsley-multiple="Gender" data-parsley-errors-container="#uGenderErrorContainer" data-parsley-class-handler="#uGender" required> <span>Male</span></label>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox"><input name="Gender" type="radio" class="uGender" value="Female" data-parsley-multiple="Gender" data-parsley-errors-container="#uGenderErrorContainer" required> <span>Female</span></label>
                                    </div>
                                    <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox"><input name="Gender" type="radio" class="uGender" value="Transgender" data-parsley-multiple="Gender" data-parsley-errors-container="#uGenderErrorContainer" required> <span>Transgender</span></label>
                                    </div>
                                    <div id="uGenderErrorContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mg-b-10">Title <span class="tx-danger">*</span></p>
                            <div class="parsley-select" id="uSuffix">
                                <select class="form-control uSuffix select2" data-parsley-class-handler="#uSuffix" data-parsley-errors-container="#uSuffixErrorContainer"  required="" name="Suffix">
                                    <option value="">Choose Title</option>
                                    <?php foreach($titles as $title){ ?>
                                    <option value="<?= $title['value'];?>">
                                       <?= $title['value'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <div id="uSuffixErrorContainer"></div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="Name" required="" id="uName" placeholder="Enter Name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Email </p>
                                <input type="text" class="form-control"  name="Email" id="uEmail" placeholder="Enter Email">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Country Code </p>
                                <div class="parsley-select" id="uCountryCode">
                                    <select class="form-control select2 uCountryCode" required=""  name="CountryCode" data-parsley-class-handler="#uCountryCode" data-parsley-errors-container="#uCountryCodeErrorContainer"  data-parsley-required
                                    data-parsley-required-message="Select Country Code">
                                    <option value="">Select Country Code</option>
                                        <?php foreach($country_codes as $country_code){ ?>
                                        <option value="+<?= $country_code['Dialing'];?>">+ <?= $country_code['Dialing'];?></option>
                                        <?php } ?>
                                    </select>

                                    <div id="uCountryCodeErrorContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Phone No <span class="tx-danger">*</span></p>
                                <input type="number" class="form-control" name="Mobile" id="uMobile" data-parsley-length="[6, 10]" placeholder="Phone No" required>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Whatsapp Country Code </p>
                                <select class="form-control select2  uWhatsAppCountryCode" name="WhatsAppCountryCode" >
                                    <option value="">Select Country Code</option>
                                    <?php foreach($country_codes as $country_code){ ?>
                                    <option value="+<?= $country_code['Dialing'];?>">+ <?= $country_code['Dialing'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Whatsapp No </p>
                                <input type="tel" class="form-control" name="WhatsappNumber" id="uWhatsappNumber"  placeholder="Whatsapp No">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Address  <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="Address" required="" id="uAddress" placeholder="Enter Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Address 2 <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="AdressTwo" required="" id="uAdressTwo" placeholder="Enter Address">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Landmark </p>
                                <input type="text" class="form-control"  name="Landmark" id="uLandmark" placeholder="Enter Landmark">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Profile Image<span class="tx-danger">*</span></p>
                                <input type="file" class="form-control"  name="ProfileIMG" id="ProfileIMG">
                                <input type="hidden" name="oldimage" id="uoldimage" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <img src="" id="image-show" class="header-brand-img desktop-logo" alt="" height="100" width="100">
                            </div>
                        </div>
                       
                    </div>

                </div>

                <input type="hidden" name="AutoId" value="" id="uAutoId">
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-travel_luggage" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="update_travel_luggage">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="update_close">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->









        

