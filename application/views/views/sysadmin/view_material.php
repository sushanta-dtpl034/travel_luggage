		<!-- Main Content-->
        <div class="main-content side-content pt-0">

            <div class="container-fluid">
                <div class="inner-body">
            
                    <!-- Page Header -->
                    <div class="page-header">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                            </ol>
                        </div>
                        <div class="d-flex">
                                            <div class="justify-content-center">
                                                
                                                <button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#materialmodal" data-bs-toggle="modal" >
                                                  Add  Material Conditon
                                                </button>
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
                                        <strong>Material </strong> insert succesfully.
                                        </div>
            
                                        <div class="alert alert-solid-success update" role="alert" style="display:none">
                                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                        <strong>Material </strong> updated succesfully.
                                        </div>
            
                                        <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                        <strong>Already exists.</strong>
                                        </div>
            
                                        <table id="material_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Material Condition Name</th>
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
               <div class="modal" id="materialmodal">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Material Condition Creation</h6>
                                        <button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
                                    </div>
                                    <form id="material_form">
                                    <div class="modal-body">
                                        <div class="row row-sm">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="mg-b-10">Material Condition Name<span class="tx-danger">*</span></p>
                                                    <input type="text" class="form-control"  name="mater_conditionname" required="" data-parsley-pattern="^[a-zA-Z ]+$">
                                                    <input type="hidden" class="form-control"  name="" id="planurl" value="<?php echo base_url('Plan/savePlan'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </form>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="button" id="material">Save changes</button>
                                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Grid modal -->
                        <!-- update Grid modal -->
            <div class="modal" id="updatematerialmodal">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Material Condition </h6><button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">&times;</button>
                                    </div>
                                    <form id="updatematerialform">
                                    <div class="modal-body">
                                        <div class="row row-sm">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <p class="">Material Condition Name<span class="tx-danger">*</span></p>
                                                <input type="text" class="form-control"  name="mater_conditionname" required="" id="up_conditionname" data-parsley-pattern="^[a-zA-Z ]+$">
                                                <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </form>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="button" id="updatematerial">Update</button>
                                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updateclose">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Grid modal -->
                     
            