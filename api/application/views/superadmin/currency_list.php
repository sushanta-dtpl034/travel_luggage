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
                    
                    <button type="button" class="btn  btn-sm btn-primary my-2 btn-icon-text" data-bs-target="#currencymodel" data-bs-toggle="modal" href="">
                        Add Currency
                    </button>
                    <a href="<?php echo base_url()."Masters/excel_export"; ?>"><button type="button" class="btn btn-sm btn-warning my-2 btn-icon-text">Export</button></a>
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
                                <strong>Currency </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong>Currency </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong>Currency Already Exists.</strong>
                            </div>

                            <table id="currecny_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Currency Name</th>
                                        <th>Currency Code </th>
                                        <th>Currency Symbol</th>
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
<div class="modal" id="currencymodel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Currency Creation</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            </div>
            
            <form id="currencyform" accept-charset="utf-8">
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                                <p class="mg-b-10">Currency Name<span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="currency_name" required=""  id="currency_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Currency Code<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="currency_code" required="" id="currency_code">
                        </div>
                        </div>
                </div>
                <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Currency Symbol<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="currency_symbole" required=""  id="currency_symbole">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Currency Unicode<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="currency_unicode" required=""  id="currency_unicode">
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button" id="currency_button">Save changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>


			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_currencymodel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Currency  Update</h6>
                <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
            </div>
            <form id="up_currencyform">
            <div class="modal-body">
            <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                                <p class="mg-b-10">Currency Name<span class="tx-danger">*</span></p>
                                <input type="text" class="form-control"  name="up_currencyname" required=""  id="up_currencyname">
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Currency Code<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="up_currencycode" required="" id="up_currencycode">
                            <input type="hidden" class="form-control"  name="cur_updateid" required="" id="cur_updateid">
                        </div>
                        </div>
                </div>
                <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Currency Symbol<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="up_currencysymbole" required=""  id="up_currencysymbole">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <p class="mg-b-10">Currency Unicode<span class="tx-danger">*</span></p>
                            <input type="text" class="form-control"  name="up_currencyunicode" required=""  id="up_currencyunicode">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button" id="up_currencybutton">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
			<!--End Grid modal -->
