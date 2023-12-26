<!-- Main Content-->
<style>
   .sp-container.sp-hidden {
      z-index: 20000 !important;
   }
</style>
<div class="main-content side-content pt-0">
   <div class="container-fluid">
      <div class="inner-body">
         <!-- Page Header -->
         <div class="page-header">
            <div>
               <h2 class="main-content-title tx-24 mg-b-5">System Setting</h2>
               <!-- <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                  </ol> -->
            </div>
         </div>
         <!-- Row -->
         <div class="alert alert-solid-success insert" role="alert" style="display:none">
            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
               <span aria-hidden="true">&times;</span></button>
            <strong>System Setting </strong> insert succesfully.
         </div>
         <?php
         $Logoname = isset($systemsetting->Logoname) ? $systemsetting->Logoname : "";
         $Width = isset($systemsetting->Width) ? $systemsetting->Width : "";
         $Height = isset($systemsetting->Height) ? $systemsetting->Height : "";
         $EmailID = isset($systemsetting->EmailID) ? $systemsetting->EmailID : "";
         $EmaillPassword = isset($systemsetting->EmaillPassword) ? $systemsetting->EmaillPassword : "";
         $EmailHost = isset($systemsetting->EmailHost) ? $systemsetting->EmailHost : "";
         $EmailPort = isset($systemsetting->EmailPort) ? $systemsetting->EmailPort : "";
         $EmailAddressName = isset($systemsetting->EmailAddressName) ? $systemsetting->EmailAddressName : "";
         $RecieveEmailAddress = isset($systemsetting->RecieveEmailAddress) ? $systemsetting->RecieveEmailAddress : "";
         $googlePlaces = isset($systemsetting->googlePlaces) ? $systemsetting->googlePlaces : "";
         $AutoID = isset($systemsetting->AutoID) ? $systemsetting->AutoID : "";
         ?>
         <div class="card custom-card overflow-hidden">
            <div class="card-body">
               <div class="modal-header">
                  <h6 class="modal-title">Application Configuration</h6>
               </div>
               <form id="systemsettingform">
                  <!--imagesetting-->
                  <div class="row row-sm pt-3">
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10">Logo </p>
                           <input type="hidden" class="form-control" name="updateid" id="updateid"
                              value="<?php echo $AutoID; ?>">
                           <input type="file" class="form-control" name="logo_name" id="logo_name" value="">
                           <input type="hidden" class="form-control" name="old_logoname" id="old_logoname"
                              value="<?php echo $Logoname; ?>">

                           <?php
                           if ($Logoname) {
                              ?>
                              <img src="<?php echo base_url() . "upload/setting/" . $Logoname; ?>"
                                 width="<?php echo $Width; ?>" height="<?php echo $Height; ?>">
                              <?php
                           }
                           ?>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10"> Height</p>
                           <input type="text" class="form-control" name="height" id="height" required=""
                              value="<?php echo $Height; ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10"> Width</p>
                           <input type="text" class="form-control" name="width" id="width" required=""
                              value="<?php echo $Width; ?>">
                        </div>
                     </div>
                  </div>
                  <div class="modal-header">
                     <h6 class="modal-title">Email Configuration</h6>
                  </div>
                  <div class="row row-sm pt-3">
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10">Email Address </p>
                           <input type="text" class="form-control" name="email_address" id="email_address" required=""
                              value="<?php echo $EmailID; ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10"> Email Password</p>
                           <input type="password" class="form-control" name="email_password" id="email_password"
                              required="" value="<?php echo $EmaillPassword; ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10"> Email Host</p>
                           <input type="text" class="form-control" name="email_host" id="email_host" required=""
                              value="<?php echo $EmailHost; ?>">
                        </div>
                     </div>
                  </div>
                  <div class="row row-sm">
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10">Email Port </p>
                           <input type="text" class="form-control" name="email_port" id="email_port" required=""
                              value="<?php echo $EmailPort; ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10"> From Email Name</p>
                           <input type="text" class="form-control" name="email_address_name" id="email_address_name"
                              required="" value="<?php echo $EmailAddressName; ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10">From Email Address</p>
                           <input type="email" class="form-control" name="receive_email_address"
                              id="receive_email_address" required="" value="<?php echo $RecieveEmailAddress; ?>">
                        </div>
                     </div>
                  </div>
                  <div class="modal-header">
                     <h6 class="modal-title">Api Configuration</h6>
                  </div>
                  <div class="row row-sm">
                     <div class="col-md-4">
                        <div class="form-group">
                           <p class="mg-b-10">Google Places Api Configuration</p>
                           <input type="text" class="form-control" name="google_place" id="google_place" required=""
                              value="<?php echo $googlePlaces; ?>">
                        </div>
                     </div>
                  </div>
                  <div class="row mx-auto">
                     <div class="col-md-4">
                        <button class="btn ripple btn-primary" type="button" id="setting_save">Save changes</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Main Content-->
<!-- insert Grid modal -->