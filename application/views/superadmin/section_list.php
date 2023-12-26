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
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#sectionmodel" data-bs-toggle="modal" href="">
									  Add Section
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
                            <strong>Section </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Section </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Something went wrong.</strong>
                            </div>

                            <table id="section_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Section Name</th>
                                        <th>Color</th>
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
<div class="modal" id="sectionmodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Section  Creation</h6>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">&times;</button>
						</div>
                        <form id="sectionform">
						<div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Section Name<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="section_name" required="" id="section_name">
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Color</p>
                                         <select id="color" class="form-control" name="colors"> 
                                            <option value="0">Select color</option>
                                            <option value="1">RED</option>
                                            <option value="2">GREEN</option>
                                            <option value="3">BLUE</option>
                                            <option value="4">ORANGE</option>
                                            <option value="5">PINK</option>
                                            <option value="6">PURPLE</option>
                                            <option value="7">BROWN</option>
                                            <option value="8">MAGENTA</option>
                                            <option value="9">WHITE</option>
                                            <option value="10">SILVER</option>
                                            <option value="11">YELLOW</option>
                                        </select>
                                    </div>
								</div>
                             
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="section_button">Save changes</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
            <!-- update Grid modal -->
<div class="modal" id="up_sectionmodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Section  Update</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
						</div>
                        <form id="up_sectionform">
					    <div class="modal-body">
							<div class="row row-sm">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <p class="mg-b-10">Section Name<span class="tx-danger">*</span></p>
                                        <input type="text" class="form-control"  name="section_name" required="" id="up_section_name">
                                        <input type="hidden" class="form-control"  name="updateid" id="updateid" value="">
                                    </div>
								</div>
								<div class="col-md-6">
                                   <div class="form-group">
                                        <p class="mg-b-10">Color<span class="tx-danger">*</span></p>
                                        <select id="up_colors" class="form-control" name="colors"> 
                                            <option value="0">Select color</option>
                                            <option value="1">RED</option>
                                            <option value="2">GREEN</option>
                                            <option value="3">BLUE</option>
                                            <option value="4">ORANGE</option>
                                            <option value="5">PINK</option>
                                            <option value="6">PURPLE</option>
                                            <option value="7">BROWN</option>
                                            <option value="8">MAGENTA</option>
                                            <option value="9">WHITE</option>
                                            <option value="10">SILVER</option>
                                            <option value="11">YELLOW</option>
                                        </select>
                                    </div>
								</div>
                             
							</div>
						</div>
                      </form>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="button" id="update_section">Update</button>
							<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="updateclose">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Grid modal -->
