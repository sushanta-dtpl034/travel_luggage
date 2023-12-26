<style type="text/css">
    .table-responsive {
        display: inline-table !important;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .inactive {
        background-color: lightpink !important;
    }


    .bottom-validation ul.parsley-errors-list {
        position: absolute;
        bottom: 16px;

    }
</style>
<!-- Main Content-->
<div class="main-content side-content pt-0">
    <div class="container-fluid">
        <div class="inner-body">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-5">
                        <?php echo $page_name; ?>
                    </h2>
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                    </ol> -->
                </div>

                <!-- Small modal -->
                <div class="modal" id="loadmodel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="col-lg-4 col-sm-4">
                                <div class="card custom-card" id="loaders2">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="lds-facebook">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Small Modal -->
                <div class="d-flex">
                    <div class="justify-content-center">
                        <button type="button" class="btn btn-warning my-2 btn-icon-text btn-sm linkuser">
                           Directory Sync
                        </button>
                        <a href="<?php echo base_url('Usercontroller/usertemplate_download'); ?>">
                            <button type="button" class="btn btn-success my-2 btn-icon-text btn-sm">
                                Download Template
                            </button>
                        </a>
                        <button type="button" class="btn btn-info my-2 btn-icon-text btn-sm"
                            data-bs-target="#userimport" data-bs-toggle="modal" href="">
                            Import
                        </button>

                        <button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm"
                            data-bs-target="#assetincharge_model" data-bs-toggle="modal" href="">
                            Add User
                        </button>
                    </div>
                </div>

            </div>
            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="">
                                <div class="alert alert-solid-success insert" role="alert" style="display:none">
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                    <strong>User </strong> insert succesfully.
                                </div>

                                <div class="alert alert-solid-success update" role="alert" style="display:none">
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                    <strong>User </strong> updated succesfully.
                                </div>

                                <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                    <strong>Already exists or data not vallid</strong>
                                </div>


                                <div class="col">
                                    <div class="row" style="text-align:right;">
                                        <div class="col-md-12">
                                            <label> Search: </label>
                                            <input type="text" id="searchInput" class=""
                                                placeholder="Type keywords..." />
                                            <label> Role: </label>
                                            <select id="table-filter-data" class="form-select">
                                                <option value="">All</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Auditor">Auditor</option>
                                                <option value="Supervisor">Supervisor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <table id="assetincharge_table"
                                    class="table table-bordered border-t0 key-buttons text-nowrap w-100 table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>EMP ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Admin</th>
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

<div class="modal" id="userimport">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">User Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal"
                    type="button">&times;</button>
            </div>
            <form id="import_userform" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">User List<span class="tx-danger">*(Csv,Xls,Xlsx)</span></p>
                                <input type="file" class="form-control" name="user_file" required="" id="user_file">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button" id="userimp_button">Import</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- insert Grid modal -->
<div class="modal" id="assetincharge_model">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">User Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal"
                    type="button">&times;</button>
            </div>
            <form id="assetincharge_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row row-sm">
                        <input type="hidden" class="form-control" name="user_type" required="" id="up_usertype"
                            value="4">
                        <!-- <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">User Type <span class="tx-danger">*</span></p>
                             <select class="form-control" required="" name="user_type" id="user_type">
                                <option label="Choose one" value=""></option>
                                 <?php
                                 foreach ($group as $res) {
                                     ?>
                                          <option value="<?php echo $res['AutoID']; ?>"><?php echo $res['Name']; ?></option>
                                        <?php
                                 }
                                 ?>

                            </select>
                        </div>
                    </div> -->
                        <div class="col-md-6">
                            <div class="row row-cols-2">
                                <div class="col-auto px-0">
                                    <p class="mg-b-10">Prefix <span class="tx-danger">*</span></p>
                                    <div class="bottom-validation">
                                        <select class="form-select form-control select2-with-search" id="prefix"
                                            required="">
                                            <option label="Choose one" value=""></option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Dr.">Dr.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col pe-0">
                                    <div class="form-group">
                                        <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control" name="name" required="" id="name">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Email <span class="tx-danger">*</span></p>
                                <input type="email" class="form-control" name="emailid" required="" id="emailid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Mobile Number <span class="tx-danger">*</span></p>
                                <div class="input-group telephone-input" style="display: block" ;>
                                    <input type="text" class="form-control vendor_mobile" name="mobile_number"
                                        required="" id="mobile_number" style="width:100%;" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Employee Code <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control" name="employee_code" required=""
                                    id="employee_code">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Username <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control" name="username" required="" id="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Password<span class="tx-danger">*</span></p>
                                <input type="text" class="form-control" name="password" required="" id="password">
                            </div>
                            <div class="form-group mt-2" style="text-align:right">
                                <button type="button" name="generate" class="btn btn-success btn-sm"
                                    id="generate">Generate Password</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Active<span class="tx-danger">*</span></p>

                                <label class="ckbox mt-2"><input checked type="checkbox" value="1" name="user_status"
                                        id="user_status"><span>Active</span></label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mg-b-10">User Type <span class="tx-danger">*</span></p>

                            <div class="form-group">
                                <label class="custom-switch">
                                    <input type="checkbox" value="1" id="admin" name="custom-switch-checkbox"
                                        class="custom-switch-input" name="basecompany" id="basecompany">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Admin</span>
                                </label>
                                <label class="custom-switch">
                                    <input type="checkbox" value="1" id="auditor" name="custom-switch-checkbox"
                                        class="custom-switch-input" name="basecompany" id="basecompany">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Auditor</span>
                                </label>
                                <label class="custom-switch">
                                    <input type="checkbox" value="1" id="supervisor" name="custom-switch-checkbox"
                                        class="custom-switch-input" name="basecompany" id="basecompany">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Supervisor</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Profile Image<span class="tx-danger">(jpg,png,jpeg)</span></p>
                                <input type="file" class="form-control" name="userpro_image" id="userpro_image">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button" id="assetin_button">Save changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->

<!-- update Grid modal -->
<div class="modal" id="up_usermodel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">User Update</h6><button aria-label="Close" class="btn-close btn-secondary"
                    data-bs-dismiss="modal" type="button">X</button>
            </div>
            <form id="up_usermodelform" enctype="multipart/form-data">

                <div class="modal-body">
                    <div class="row row-sm">
                        <input type="hidden" class="form-control" name="user_updateid" required="" id="user_updateid">
                        <div class="col-md-6">
                            <div class="row row-cols-2">
                                <div class="col-auto px-0">
                                    <p class="mg-b-10">Prefix <span class="tx-danger">*</span></p>
                                    <div class="bottom-validation">
                                        <select class="form-select form-control select2-with-search" id="update_prefix"
                                            required="">
                                            <option label="Choose one" value=""></option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Dr.">Dr.</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col pe-0">
                                    <div class="form-group">
                                        <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control" name="up_name" required="" id="up_name">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Email <span class="tx-danger">*</span></p>
                                <input type="email" class="form-control" name="up_emailid" required="" id="up_emailid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Mobile Number <span class="tx-danger">*</span></p>
                                <div class="input-group telephone-input" style="display: block" ;>
                                    <input type="text" class="form-control vendor_mobile" name="up_mobilenumber"
                                        required="" id="up_mobilenumber" style="width:100%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Employee Code <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control" name="up_employeecode" required=""
                                    id="up_employeecode">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">User Name <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control" name="up_username" required="" id="up_username">
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Password<span class="tx-danger">*</span></p>
                            <input type="password" class="form-control"  name="up_password"  id="up_password" autocomplete="off">
                        </div>
                        <div class="form-group mt-2" style="text-align:right">
                           <button type="button" name="generate" class="btn btn-success btn-sm" id="up-generate">Generate Password</button>
                        </div>
                    </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Change password</p>
                                <button class="btn ripple btn-primary" id="changepass_btn">Change password</button>
                                <input type="text" class="form-control" style="display: none;"
                                    placeholder="Enter New Password" name="up_password" id="up_password">
                                <div class="form-group mt-2" style="text-align:right;display: none;" id="up_gen_pas">
                                    <button type="button" name="generate" class="btn btn-success btn-sm"
                                        id="up-generate">Generate Password</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Active<span class="tx-danger">*</span></p>

                                <label class="ckbox mt-2"><input checked type="checkbox" id="userup_status" value="1"
                                        name="active"><span>Active</span></label>

                            </div>
                            <p class="mg-b-10">User Type <span class="tx-danger">*</span></p>

                            <div class="form-group">
                                <label class="custom-switch">
                                    <input type="checkbox" value="1" id="up_admin" name="custom-switch-checkbox"
                                        class="custom-switch-input" name="basecompany" checked id="basecompany">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Admin</span>
                                </label>
                                <label class="custom-switch">
                                    <input type="checkbox" value="1" id="up_auditor" name="custom-switch-checkbox"
                                        class="custom-switch-input" name="basecompany" checked id="basecompany">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Auditor</span>
                                </label>
                                <label class="custom-switch">
                                    <input type="checkbox" value="1" id="up_supervisor" name="custom-switch-checkbox"
                                        class="custom-switch-input" name="basecompany" checked id="basecompany">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Supervisor</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Profile Image<span class="tx-danger">(jpg,png,jpeg)</span></p>
                                <img src="" id="update_userprofile" class="update_userprofile" width="120" height="120">
                                <i class="fa fa-camera  button-aligh upload-button"></i>
                                <input class="user-fileupload" type="file" accept="image/*" id="user-fileupload"
                                    name="user-fileupload" />
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button" id="update_user">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button"
                    id="updateuser_close">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->