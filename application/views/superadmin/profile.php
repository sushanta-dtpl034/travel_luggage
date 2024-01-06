
<div class="main-content side-content pt-0">
    <div class="container-fluid">
        <div class="inner-body">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-5">Profile</h2>
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol> -->
                </div>
            </div>
            <!-- End Page Header -->
            <div class="alert alert-success profile_success" role="alert" style="display:none;" >
                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">X</span>
                </button>
                <strong></strong> <p class="text-center">Profile Image Updated Successfully.</p>
            </div>

            <div class="row square">
                <div class="col-lg-12 col-md-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="panel profile-cover mb-5" style="padding-bottom:30px;">
                                <div class="profile-cover__img mb-5">
                                    
                                    <?php if($subs_data['ProfileIMG']!=''){ ?>
                                    <img src="<?php echo base_url(); ?><?php echo $subs_data['ProfileIMG']; ?>" alt="img" class="profile-pic" />     
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url(); ?>/assets/img/users/1.jpg" alt="img" class="profile-pic" />     
                                    <?php }  ?>
                                    <form id="profileimage_form" enctype="multipart/form-data">
                                        <input type="hidden" name="updated_id" value="<?php echo $this->session->userdata('userid'); ?>" id="updated_id">
                                        <input type="hidden" name="old_image" value="<?php echo $subs_data['ProfileIMG']; ?>" id="old_image">                                  
                                        <div class="row row-sm">
                                            <div class="col">
                                                <div class="p-image mt-2 mb-2">
                                                <button type="button" class="btn ripple btn-secondary btn-sm" ><i class="fa fa-camera upload-button"></i></button>
                                                <input class="file-upload" type="file" accept="image/*" id="file" name="profile"/>
                                                <button class="btn ripple btn-primary btn-sm" type="button" id="project_image"  >Change</button>
                                                </div>
                                                
                                            </div>
                                            <!-- <div class="col-lg-4 col-md-12">
                                                <div class="profile_remove ">
                                                <i class="fe fe-trash btn-danger"></i>
                                                </div>
                                            </div> -->
                                        
                                        </div>
                                    </form>
                                    <h3 class="h3"><?php echo $this->session->userdata('username'); ?></h3>
                                    
                                
                                </div>
                                <!-- <div class="profile-cover__action bg-img"></div> -->
                                <div class="profile-cover__info">
                                    <ul class="nav">
                                        <li>.<strong>.</strong></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="profile-tab tab-menu-heading">
                                <nav class="nav main-nav-line p-3 tabs-menu profile-nav-line bg-gray-100">
                                    <a class="nav-link  active" data-bs-toggle="tab" href="#about">About</a>
                                    <a class="nav-link" data-bs-toggle="tab" href="#edit">Edit Profile</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12 col-md-12">
                    <div class="card custom-card main-content-body-profile">
                        <div class="tab-content">
                            <div class="main-content-body tab-pane p-4 border-top-0 active" id="about">
                                <div class="card-body p-0 border p-0 rounded-10">
                                    <div class="border-top"></div>
                                    <div class="p-4">
                                        <label class="main-content-label tx-13 mg-b-20">Contact</label>
                                        <div class="d-sm-flex">
                                            <div class="mg-sm-r-20 mg-b-10">
                                                <div class="main-profile-contact-list">
                                                    <div class="media">
                                                        <div class="media-icon bg-primary-transparent text-primary"> <i class="icon ion-md-phone-portrait"></i> </div>
                                                        <div class="media-body"> <span>Mobile</span>
                                                            <div> <?php echo (!empty($user->Mobile)) ? $user->Mobile : "";?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mg-sm-r-20 mg-b-10">
                                                <div class="main-profile-contact-list">
                                                    <div class="media">
                                                        <div class="media-icon bg-primary-transparent text-primary"> <i class="ion ion-md-mail"></i> </div>
                                                        <div class="media-body"> <span>Email</span>
                                                            <div><?php echo (!empty($user->Email)) ? $user->Email : "";?> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                               
                                </div>
                            </div>

                            <div class="main-content-body tab-pane p-4 border-top-0" id="edit">
                                <div class="card-body border">
                                    <div class="row">
                                        <div class="col-md-8 col-8">
                                        
                                            <div class="mb-4 main-content-label">Personal Details</div>
                                                <form class="form-horizontal" id="profile_edit">
                                                    <!-- Show PHP Validation ERRORS Start -->
                                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                                        <ul id="form_errors"></ul>
                                                    </div>
                                                    <!-- Show PHP Validation ERRORS End -->
                                                    <div class="alert alert-success profile_data" role="alert" style="display:none;" >
                                                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                                        <span aria-hidden="true">X</span>
                                                        </button>
                                                        <strong></strong> <p class="text-center">Updated Successfully.</p>
                                                    </div>

                                                    <input type="hidden" name="data_id" value="<?php echo $this->session->userdata('userid'); ?>" id="data_id">


                                                    <div class="row row-sm">
                                                        <!-- <div class="col-md-2">
                                                            <div class="form-group">
                                                                <p class="mg-b-10">Gender <span class="tx-danger">*</span></p>
                                                                <div class="parsley-select" id="Gender">
                                                                    <select class="form-control Gender" data-parsley-class-handler="#Gender" data-parsley-errors-container="#GenderErrorContainer"  required="" name="Profile_Gender">
                                                                        <option value="">Choose Gender</option>
                                                                        <option value="Male" <?= ( 'Male' == $user->Gender)?'selected':''?>>Male</option>
                                                                        <option value="Female" <?= ( 'Female' == $user->Gender)?'selected':''?>>Female</option>
                                                                        <option value="Transgender" <?= ( 'Transgender' == $user->Gender)?'selected':''?>>Transgender</option>
                                                                    </select>
                                                                    <div id="GenderErrorContainer"></div>
                                                                </div>                                                                          
                                                            </div>
                                                        </div> -->

                                                        <div class="col-md-2">
                                                            <p class="mg-b-10">Title <span class="tx-danger">*</span></p>
                                                            <div class="parsley-select" id="Suffix">
                                                                <select class="form-control select2" data-parsley-class-handler="#Suffix" data-parsley-errors-container="#SuffixErrorContainer"  required=""  name="Profile_Suffix" data-parsley-required-message="Choose Title">
                                                                    <option label="Choose Title"></option>
                                                                    <?php foreach($titles as $title){ ?>
                                                                    <option value="<?= $title['value'];?>" <?= ( $title['value'] == $user->Suffix)?'selected':''?>><?= $title['value'];?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                                <div id="SuffixErrorContainer"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                                                <input type="text" class="form-control"  name="Profile_Name" required="" id="Name" placeholder="Enter Name" value="<?= $user->Name;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <p class="mg-b-10">Email </p>
                                                                <input type="text" class="form-control"  name="Profile_Email" id="Email" placeholder="Enter Email" value="<?= $user->Email;?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                        

                                                    <div class="row row-sm">
                                                        <div class="col-md-6">
                                                            <div class="row row-sm">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <p class="mg-b-10">Country Code </p>
                                                                        <div class="parsley-select" id="CountryCode">
                                                                            <select class="form-control select2 Profile_CountryCode" required=""  name="Profile_CountryCode" data-parsley-class-handler="#CountryCode" data-parsley-errors-container="#CountryCodeErrorContainer"  data-parsley-required
                                                                            data-parsley-required-message="Select Country Code">
                                                                            <option value="">Select Country Code</option>
                                                                                <?php foreach($country_codes as $country_code){ ?>
                                                                                <option value="+<?= $country_code['Dialing'];?>" <?= ( '+'.$country_code['Dialing'] == $user->CountryCode)?'selected':''?>>+ <?= $country_code['Dialing'];?> - <?= $country_code['Name'];?></option>
                                                                                <?php } ?>
                                                                            </select>

                                                                            <div id="CountryCodeErrorContainer"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <p class="mg-b-10">Phone No <span class="tx-danger">*</span></p>
                                                                        <input type="number" class="form-control" name="Profile_Mobile" id="Mobile" data-parsley-length="[6, 10]" placeholder="Phone No" value="<?= $user->Mobile;?>" required>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row row-sm">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <p class="mg-b-10">Whatsapp Country Code </p>
                                                                        <select class="form-control select2 Profile_WhatsAppCountryCode" name="Profile_WhatsAppCountryCode" >
                                                                            <option value="">Select Country Code</option>
                                                                            <?php foreach($country_codes as $country_code){ ?>
                                                                            <option value="+<?= $country_code['Dialing'];?>" <?= ( '+'.$country_code['Dialing'] == $user->WhatsAppCountryCode)?'selected':''?>>+ <?= $country_code['Dialing'];?> - <?= $country_code['Name'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <div id="WhatsAppCountryCodeErrorContainer"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <p class="mg-b-10">Whatsapp No </p>
                                                                        <input type="tel" class="form-control" name="Profile_WhatsappNumber" placeholder="Whatsapp No" value="<?= $user->WhatsappNumber;?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                    

                                                    <div class="row row-sm">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <p class="mg-b-10">Address  <span class="tx-danger">*</span></p>
                                                                <input type="text" class="form-control"  name="Profile_Address" required="" id="Address" placeholder="Enter Address" value="<?= $user->Address;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <p class="mg-b-10">Addrss2 <span class="tx-danger">*</span></p>
                                                                <input type="text" class="form-control"  name="Profile_AdressTwo" required="" id="AdressTwo" placeholder="Enter Addrss2" value="<?= $user->AdressTwo;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <p class="mg-b-10">Landmark </p>
                                                                <input type="text" class="form-control"  name="Profile_Landmark" id="Landmark" placeholder="Enter Landmark" value="<?= $user->Landmark;?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                

                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <p class="text-center"><button class="btn ripple btn-primary " type="button" id="profileedit_button">Update</button></p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="main-content-body tab-pane p-4 border-top-0" id="edit" style="display:none">
                                <div class="card-body border">
                                    <div class="mb-4 main-content-label">Company Details</div>
                                    <form class="form-horizontal" id="profile_edit">
                                        <div class="alert alert-success profile_data" role="alert" style="display:none;" >
                                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                            <span aria-hidden="true">X</span>
                                            </button>
                                            <strong></strong> <p class="text-center">Updated Successfully.</p>
                                        </div>
                                        <input type="hidden" name="data_id" value="<?php echo $this->session->userdata('userid'); ?>" id="data_id">
                                        
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">ADDRESS</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="profile_address" value="<?php echo $subs_data['Address']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">EMAIL ID</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"  name="profile_emailid" value="<?php echo $subs_data['Email']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">OFFICE PHONE NO</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="profile_office"  value="<?php echo $subs_data['Mobile']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">CONTACT PERSON MOBILE NO</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="profile_mobile" value="<?php echo $subs_data['WhatsappNumber']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-9">
                                                <button class="btn ripple btn-primary pull-right" type="button" id="profileedit_button">Edit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
                        </div>                                                   
            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Content-->

<script>
$(".Profile_CountryCode").select2({
    dropdownParent: $("#update-traveller-modal"),
    width:'100%',
});
$(".Profile_WhatsAppCountryCode").select2({
    dropdownParent: $("#update-traveller-modal"),
    width:'100%',
});
</script>