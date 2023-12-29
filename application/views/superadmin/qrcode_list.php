<!-- Main Content-->
<style>
    .sp-container.sp-hidden{z-index: 20000 !important;}
    .text-right{ text-align:right;}
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
                        <button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" id="qrcodeadd_model">
                            Generate QR Code
                        </button>
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
                        <strong>Luggage QR Code  </strong> Generate succesfully.
                    </div>
                    <div class="alert alert-solid-success update" role="alert" style="display:none">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>Luggage QR Code  </strong> updated succesfully.
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
                                <table id="qrcode_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            
                                            <!-- <th>Company Name</th> -->
                                            <!-- <th>Short Code</th> -->
                                            <th>Number of QR Code</th>
                                            <th>Number of QR Code Used</th>
                                            <th>Date</th>
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
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<div class="modal" id="qrcodeform_model">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add QR Code</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            </div>
            <form id="addqrocde_form" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="row row-sm">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Company <span class="tx-danger">*</span></p>                                
                                <input type="hidden" class="form-control"  name="VerificationInterval"  id="VerificationInterval" value="">
                                <input type="hidden" class="form-control"  name="assetman_auditor"  id="assetman_auditor" value="">

                                <select class="form-control select2-with-search"  required="" name="company_id" id="company_id">
                                    <option label="Choose Company" value="">Select Company</option>
                                    <?php foreach($company as $com_res){ ?>
                                    <option value="<?php echo $com_res['AutoID']; ?>" data-code="<?php echo $com_res['CompanyShortCode']; ?>"><?php echo $com_res['CompanyName']; ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="mg-b-10">Company Short Code<span class="tx-danger">*</span></p>
                                <input type="text" class="form-control" id="company_code" name="company_code"  required="" placeholder="Company Short Code" disabled>
                            </div>
                        </div> -->
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10" >Number of QR Code Required<span class="tx-danger">*</span></p>
                                <input type="number" class="form-control" id="noof_qrcode" min="1" name="noof_qrcode" placeholder="Number QR Code Required" required="">
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-addqrcode" disabled type="button" style="display:none;">
                <span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Generating...</button>
                <button class="btn ripple btn-primary" type="button" id="addqrcode_button">Generate QR Code</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
          

<script>
//var input = document.getElementById('vendor_address');
//var autocomplete = new google.maps.places.Autocomplete(input);
</script>


<div class="modal" id="update_qrmodel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">List of QR Code </h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            </div>
            <form id="up_qrocde_form" enctype="multipart/form-data">
                <div class="modal-body" >
                    <div class="table-responsive">
                        <table id="qrcode_show_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>QR Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-addasset" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="updateqr_button">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="assetview_model">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">View Asset </h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            </div>
            <form id="addassetview_form" enctype="multipart/form-data">
                
            </form>
            
        </div>
    </div>
</div>








        

