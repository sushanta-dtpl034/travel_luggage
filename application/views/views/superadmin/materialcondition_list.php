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
                                <a href="<?php echo base_url('Masters/materialcon_mailconf'); ?>" class="btn btn-primary my-2 btn-icon-text"> Add Material Condition</a>
								</div>
							</div>

        </div>
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="table-responsive">

                        <?php

                        if($this->session->flashdata('materialcon_success')) {
                        $message = $this->session->flashdata('materialcon_success');
                        ?>
                            <div class="alert alert-solid-success insert" role="alert" style="display:none">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong><?php echo  $message; ?></strong> 
                            </div>
                        <?php
                        }
                        if($this->session->flashdata('materialcon_errmess')) {
                        $message = $this->session->flashdata('materialcon_errmess');
                        ?>
                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span></button>
                                <strong><?php echo  $message; ?></strong> 
                            </div>
                        <?php
                        }
                        ?>
                           
                           <table id="super_materialcon" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Material Conditions</th>
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
<div class="modal" id="mailsetting">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title" id="condition_title"></h6>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="mailsettingform">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Name<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="to_name" required="" id="to_name">
                                        <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">    
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">To Email Address<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="to_email" required=""  id="to_email">
                                    </div>
								</div>
                             
							</div>
                            <div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">CC Email Address<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="cc_email" id="cc_email">
                                    </div>
								</div>
							                            
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="mail_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_projectmodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Project  Update</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
						</div>
                        <form id="up_projectform">
					    <div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Project Name<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="project_name" required="" id="up_projectname">
                                        <input type="hidden" class="form-control"  name="" id="planurl" value="<?php echo base_url('Plan/savePlan'); ?>">
                                        <input type="hidden" class="form-control"  name="updateid" id="updateid1" value="">
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Project ID<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="project_id" required=""  id="up_projectid">
                                    </div>
								</div>
                             
							</div>
                            <div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Project Manager Name<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="promanager_name" required="" id="up_managername">
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Email Id<span class="tx-danger">*</span></p>
                                        <input type="email" class="form-control"  name="projtmanager_email" required=""  id="up_manageremail">
                                    </div>
								</div>
                             
							</div>
							
                            <div class="row row-sm">
                            <div class="col-md-6">
												<div class="mg-b-20">
                                                <p class="mg-b-10">Contact person mobile no</p>
													<div class="input-group">
														<div class="input-group-text">
															<i class="flh--9 op-6" id="countryCode"><?php echo $pincode;?></i>
														</div>
                                                        <input class="form-control"  type="text" id="up_contactmobileno"  name="contactperson_mobileno">
													</div>
												</div>
							</div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="ckbox mt-4"><input checked type="checkbox" value="1" name="active" id="upproject_active"><span>Active</span></label>
                                      </div>
								</div>
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="update_project">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updateclose">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
