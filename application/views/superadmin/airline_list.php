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
                        <button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm" data-bs-target="#airline_model" data-bs-toggle="modal" href="">
                            Add Airline
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
                        <strong>Airline  </strong> Generate succesfully.
                    </div>
                    <div class="alert alert-solid-success update" role="alert" style="display:none">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>Airline </strong> updated succesfully.
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
                                <table id="airline_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
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
<div class="modal" id="airline_model">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Airline Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
            </div>
            <form id="airlineform" >
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="airline_name" required="" id="airline_name">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-airline" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="airline_button">Save changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->
<!-- update Grid modal -->
<div class="modal" id="up_airlinemodel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Airline Update</h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
            </div>
            <form id="up_airlineform">
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">Name <span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="up_airline_name" required="" id="up_airline_name">
                                <input type="hidden" class="form-control"  name="up_airline_id" required="" id="up_airline_id">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary load-airline" disabled type="button" style="display:none;"><span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...</button>
                <button class="btn ripple btn-primary" type="button" id="update_airline">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="update_close">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Grid modal -->









        

