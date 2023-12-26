
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
                                    <img src="<?php echo base_url(); ?>/upload/profile/<?php echo $subs_data['ProfileIMG']; ?>" alt="img" class="profile-pic" />     
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
                                    <div class="mb-4 main-content-label">Personal Details</div>
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
                                                    <label class="form-label">Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group mb-3">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <select class="form-select form-control" id="prefix"
                                                                    required="" name="profile_prefix">
                                                                    <option label="Choose one" value=""></option>
                                                                    <option value="Mr."<?php echo (!empty($user->Suffix) && $user->Suffix === 'Mr.') ? "selected" : "";?>>Mr.</option>
                                                                    <option value="Ms." <?php echo (!empty($user->Suffix) && $user->Suffix === 'Ms.') ? "selected" : "";?>>Ms.</option>
                                                                    <option value="Mrs." <?php echo (!empty($user->Suffix) && $user->Suffix === 'Mrs.') ? "selected" : "";?>>Mrs.</option>
                                                                    <option value="Dr." <?php echo (!empty($user->Suffix) && $user->Suffix === 'Dr.') ? "selected" : "";?>>Dr.</option>
                                                                </select>
                                                            </div>
                                                        </div> 
                                                        <input type="text" class="form-control" name="profile_name" value="<?php echo (!empty($user->Name)) ? $user->Name : "";?>">
                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">Email</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="profile_email" value="<?php echo (!empty($user->Email)) ? $user->Email : "";?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">Mobile Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                <input type="text" class="form-control"  value="<?php echo $user->Mobile; ?>" id="pro_statename" name="profile_mobile"> 
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">Username</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"  value="<?php echo $user->UserName; ?>" name="profile_username">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                    <label class="form-label">Access</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" value="1" id="admin" name="custom-switch-checkbox" class="custom-switch-input" name="basecompany" id="basecompany" <?php if($user->IsAdmin){ echo "checked";}; ?> disabled="disabled">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Admin</span>
                                                        </label>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row row-sm">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-9">
                                                    <button class="btn ripple btn-primary pull-right" type="button" id="profileedit_button">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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