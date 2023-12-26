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
                    <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?> </h2>
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscription Plan</li>
                    </ol> -->
                </div>
                <div class="d-flex">
                    <div class="justify-content-center">
                        <a href="<?= base_url('Qrcode/index');?>">
                            <button type="button" class="btn btn-primary my-2 btn-icon-text btn-sm">
                                back
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Row -->
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="row">
                        <div class="alert alert-solid-success insert" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>QR Code  </strong> Generate succesfully.
                        </div>
                        <div class="alert alert-solid-success update" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>QR Code  </strong> updated succesfully.
                        </div>
                        <div class="alert alert-solid-warning mg-b-0" role="alert" style="display:none">
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span></button>
                            <strong>Already exists.</strong>
                        </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">					
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<p class="mg-b-10">Location <span class="tx-danger">*</span></p>
										<select name="location" class="form-control" id="location" onchange="getAssets(this.value)">
											<option value="">Select Location </option>
											<?php foreach($clocation as $location){ ?>
                                                <option value="<?= $location['AutoID'] ;?>"><?= $location['CompanyName']." - ".$location['Name'] ;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
							</div>
                            
                                <table id="view_qrcode_table123" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th> <input type="checkbox" onchange="checkAll(this)" name="chk[]" class="master_checkbox" > &nbsp; Select All </th>
											<th>Unique Ref No</th>
											<th>Company Name</th>
											<th>Title</th>
											<th>Category</th>
											<th>Sub category</th>
                                            <th>Date</th>                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="asset_body">
                                       
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan='9' align="center">
                                                <a href="#" onclick="printAssetQrcode22()"><button class="btn btn-success btn-sm">Print QR Code</button>
                                                    <i class="fa fa-pdf fa-lg" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    </tfoot>
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

<!-- Single QR Code Print-->
<div class="modal fade" id="singleAssetModal" tabindex="-1" role="dialog" aria-labelledby="singleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="singleModalLabel">QR Code Copy Requireds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#singleAssetModal')">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Assetmanagement/single_print_qrcode');?>" method="POST" target="_blank">
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">No of Copy required</p>
                                <select name="noof_copy" class="form-control print_copySingle">
                                    <option value="">Select No of Copy</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <input type="hidden" name="qrcode_id" id="qrcode_id" value="">
                        </div> 
                    </div>                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('#singleAssetModal')">Close</button>
                    <button type="submit" class="btn btn-primary printSingleQrcode">Print QR Code</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">QR Code Copy Requireds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#exampleModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Assetmanagement/print_qrcode');?>" method="POST" target="_blank">
				<div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">No of Copy required</p>
                                <select name="noof_copy" class="form-control print_copy">
                                    <option value="">Select No of Copy</option>
                                    <?php for($i=1; $i <= 2; $i++){ ?>
                                    <option value="<?= $i;?>"><?= $i;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="hidden" name="qrcode_ids" id="qrcode_ids" value="">
                        </div> 
                    </div>                     
               
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('#exampleModal')">Close</button>
					<button type="submit" class="btn btn-primary printQrcode">Print QR Code</button>
				</div>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

var locationId =document.getElementById('location').value; //$('#location').val();
if(locationId){
	console.log(locationId);
	getAssets(locationId);
}
	

</script>


