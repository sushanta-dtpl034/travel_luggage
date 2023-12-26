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
                            <strong>User  </strong> insert succesfully.
                            </div>

                            <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>User    </strong> updated succesfully.
                            </div>

                            <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already exists or data not vallid</strong>
                            </div>


                        <div class="col">
                                <div class="row" style="text-align:right;">
                                    <div class="col-md-12" >
                                          <input type="text" id="searchInput" placeholder="Type keywords..." />
                                            <label> Role:
                                            <select id="table-filter-data" class="form-select">
                                            <option value="">All</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Auditor">Auditor</option>
                                                <option value="Supervisor">Supervisor</option>
                                            </select>
                                            </label> 
                                        </div>
                                 </div>
                             </div>  





                            <table id="users_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Admin</th>
                                        <th>Auditor</th>
                                        <th>Supervisor</th>
                                       
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








       