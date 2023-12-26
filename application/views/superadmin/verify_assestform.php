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
        </div>
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                            <div class="d-flex justify-content-center">

                                    <div class="col-md-6">
                                    <p class="mg-b-10">URN/UIN Number</p>
                                    <div class="input-group mb-3">
                                   
  <input type="text" class="form-control"  name="asset_number"  id="asset_number">
  <button class="btn ripple btn-primary" type="button" id="find_Assest">Go</button>
  <!-- <span class="input-group-text" id="basic-addon2"></span> -->
</div>
                                        <!-- <div class="form-group">
                                            <p class="mg-b-10">URN/UIN Number</p>
                                            <input type="text" class="form-control"  name="asset_number"  id="asset_number" value="" style="border-radius:200px;">
                                            <button class="btn ripple btn-primary mt-2 float-right" type="button" id="find_Assest">Go</button>
                                        </div> -->
                                  </div>
                            </div> 
                       
                        <table id="assest_details" class="table table-bordered border-t0 key-buttons text-nowrap w-100 table-responsive" style="display:none;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Unique Ref No</th>
                                        <th>UIN</th>
                                        <th>Asset Owner Company</th>
                                        <th>Asset Category</th>
                                        <th>Asset Sub Category </th>
                                        <th>Vendor</th>
                                        <th>Purchase Price</th>
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
        <!-- End Row -->
    </div>
</div>
</div>
