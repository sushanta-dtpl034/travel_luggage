<style>
    .pos-absolute {
    position: absolute;
    left: 0;
    right: 0;
}
.text-right { text-align:right; }
.input-group .parsley-errors-list {
    position: absolute;
    bottom: -18px;
    left: 40px;
}
#parsley-id-5{
    
}
    </style>
<body class="main-body leftmenu">
    <!-- Loader -->
    <div id="global-loader">
        <img src="<?php echo base_url(); ?>assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Page -->
    <div class="page main-signin-wrapper">
        <div class="row signpages text-center">
            <div class="alert alert-danger mg-b-0 d-none w-100" role="alert" id="login_error_alert">
                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
                </button>
                <strong>Invalid</strong> Username or Password

            </div>
            <div class="col-lg-12">
                <!-- <p align="center">
                    <img src="<?php echo base_url(); ?>assets/img/logo2.png" class="header-brand-img mb-4" alt="logo" width="100" height="100">
                </p> -->
            </div>
            <div class="col-md-12">
                <div class="card">
                        
                      
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 pos-absolute">
                                <!-- <img src="<?php echo base_url(); ?>assets/img/logo.png" class="header-brand-img mb-4" alt="logo" width="100" height="100"> -->
                                <div class="clearfix"></div>
                                <img src="<?php echo base_url(); ?>assets/img/svgs/user.svg" class="ht-100 mb-0" alt="user">
                                <h5 class="mt-4 text-white"><?php echo $page_name; ?></h5>
                                
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
                            <div class="container-fluid">

                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                        <!-- <img src="<?php echo base_url(); ?>assets/img/logo.png" class=" d-lg-none header-brand-img text-start float-start mb-4" alt="logo"> -->
                                        <div class="clearfix"></div>
                                        <!-- method="post" action="<?php echo base_url('Login/validateUser'); ?>" -->
                                        <div id="usernamelogin">
                                        <form id="login">
                                            <h5 class="text-start mb-2"><?php echo $page_name; ?></h5>
                                            <p class="mb-4 text-muted tx-13 ms-0 text-start"></p>
                                            <!--<div class="form-group text-start">
                                                <label>Username</label>
                                                <input class="form-control" placeholder="Enter your username or email" type="text" name="username" required="required">
                                            </div>
                                            <div class="form-group text-start">
                                                <label>Password</label>
                                                <input class="form-control" placeholder="Enter your password" type="password" name="passwoord" required="required">
                                            </div>-->

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input class="form-control" placeholder="Enter your username or email" type="text" name="username" required="required">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input class="form-control" placeholder="Enter your password" type="password" name="passwoord" id="password" required="required">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" onclick="password_show_hide();">
                                                    <i class="fas fa-eye" id="show_eye"></i>
                                                    <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <button class="btn ripple btn-main-primary btn-block" type="button" name="singin" id="signin">Sign In</button>
                                        </form>
                                        </div>
                                         <div id="mobileotpform" style="display:none;">
                                            <form id="otp_login">
                                            <h5 class="text-start mb-2"><?php echo $page_name; ?></h5>
                                            <div class="alert alert-danger otperror" style="display:none;">
                                                User not found
                                                 <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
                </button>
                                            </div>
                                             <div class="alert alert-success otpsuccess" style="display:none;">
                                                  <strong>Success!</strong> OTP sent to your mobile.
                                                </div>
                                                <!--<div class="form-group text-start">
                                                    <label>Username</label>
                                                    <input class="form-control" placeholder="Enter your username or email" type="text" name="username" required="required">
                                                </div>
                                                <div class="form-group text-start">
                                                    <label>Password</label>
                                                    <input class="form-control" placeholder="Enter your password" type="password" name="passwoord" required="required">
                                                </div>-->
                                                    
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                                    </div>
                                                     <input class="form-control" placeholder="Enter your mobile no" type="tel" name="mobileno" id="mobileno" required="required" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" >
                                                     
                                                </div>
                                                 <button class="btn ripple btn-main-primary btn-block" type="button" name="sentotp" id="sentotp">Sent OTP</button>
                                            </form>
                                        </div>
                                        <div id="otpverification" style="display:none;">
                                            <form id="otpverificationform">
                                            <h5 class="text-start mb-2"><?php echo $page_name; ?></h5>
                                            <div class="alert alert-danger verifyerror" style="display:none;">
                                               Incorrect OTP
                                            </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input class="form-control" placeholder="Enter your OTP" type="number" name="otp" id="otp" required="required">
                                                </div>
                                                 <button class="btn ripple btn-main-primary btn-block" type="button" name="verifyotpbutton" id="verifyotpbutton">Verify OTP</button>
                                            </form>
                                        </div>
                                        <div class="mt-3 ms-0">
                                            <div class="row">
                                                <div class="col-12 col-md-5 text-start">
                                                <div class="mb-1"><button class="btn ripple btn-warning" type="button" id="usernameloginbutton" style="display:none">Login</button></div>
                                                <div class="mb-1"><button class="btn ripple btn-secondary" type="button" id="otpbutton">Login With Mobile</button></div>
                                                </div>
                                                <div class="col-12 col-md-7 ">
                                                
                                                <div class="mb-1 text-right"><a href="<?php echo base_url('Login/forgot'); ?>">Forgot password?</a></div>
                                                <!-- <div class="text-right">Don't have an account? <a href="<?php echo base_url('Plan'); ?>">Register Here</a></div> -->
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

    </div>
    <!-- End Page -->
<script>
function password_show_hide() {
    var x = document.getElementById("password");
    var show_eye = document.getElementById("show_eye");
    var hide_eye = document.getElementById("hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}


</script>
    