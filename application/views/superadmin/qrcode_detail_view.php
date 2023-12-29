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
                </div>
                <div class="d-flex">
                    <div class="justify-content-center">
                        <a href="<?= base_url('Qrcode/index');?>">
                            <button type="button" class="btn btn-primary my-2 btn-icon-text">
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
                            <div class="table-responsive">
                                <table id="view_qrcode_table123" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>Sl No. 
                                                <!-- <input type="checkbox" onchange="checkAll(this)" name="chk[]" class="master_checkbox" > &nbsp; Select All  -->
                                            </th>
                                            <!-- <th>Date</th> -->
                                            <th>QR Code</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sl=0; if(count($qrcode_data) > 0){ foreach($qrcode_data as $data){ $sl++; ?>
                                        <tr>
                                            <td>
                                                <!-- <input type="checkbox" name="qrcodes" class="checkbox" value="<?= $data['AutoID']; ?>"> -->
                                                <?= $sl; ?>
                                            </td>
                                            <!-- <td><?= $data['create_date'];?></td> -->
                                            <td><?= $data['QRCodeText'];?> </td>
                                            <td><?= $data['status'];?></td>
                                            <td>
                                                <a href="#"  onclick="printSingleQrcode(<?= $data['AutoID'];?>)" >
                                                    <i class="fa fa-qrcode fa-lg" aria-hidden="true"></i>
                                                </a>
                                                <a href="<?= base_url();?>upload/qr-code/<?= $data['QRCodeText'];?>.png" download class="mx-2">
                                                    <i class="fa fa-download fa-lg" aria-hidden="true"></i>
                                                </a>
                                                <?php if($data['status'] === 'Used'){ ?>
                                                  <!-- <span>  &nbsp; &nbsp;</span>
                                                <a href="#"  onclick="showQrCodeTravelDetails(<?= $data['QRCodeText'];?>)" ><i class="fa fa-eye fa-lg ml-2" aria-hidden="true"></i></a> -->
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <?php }else{ echo "<tr><td colspan='4'> No record founds.</td></tr>"; } ?>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <td colspan='3' align="center">
                                                <a href="#" onclick="printQrcode()"><button class="btn btn-success btn-sm">Print QR Code</button>
                                                    <i class="fa fa-pdf fa-lg" aria-hidden="true"></i></a>
                                                    
                                            </td>
                                        </tr>
                                    </tfoot> -->
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">QR Code Copy Requireds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#exampleModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Qrcode/print_qrcode');?>" method="POST" target="_sanjeev">
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
                            <div class="form-group">
                                <p class="mg-b-10">Print Type</p>
                                <select name="type" class="form-control print_type">
                                    <option value="">Select Type</option>
                                    <option value="1" selected>Print only QRcode</option>
                                    <option value="2">Print with QRcode Number</option>
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

<!-- Single QR Code Print-->
<div class="modal fade" id="singleModal" tabindex="-1" role="dialog" aria-labelledby="singleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="singleModalLabel">QR Code Copy Requireds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#singleModal')">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
            <form action="<?= base_url('Qrcode/single_print_qrcode');?>" method="POST" target="_sushanta">
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
                            <div class="form-group">
                                <p class="mg-b-10">Print Type</p>
                                <select name="type" class="form-control print_type">
                                    <option value="">Select Type</option>
                                    <option value="1" selected>Print only QRcode</option>
                                    <option value="2">Print with QRcode Number</option>
                                </select>
                            </div>
                            <input type="hidden" name="qrcode_id" id="qrcode_id" value="">
                        </div> 
                    </div>                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('#singleModal')">Close</button>
                    <button type="submit" class="btn btn-primary printSingleQrcode">Print QR Code</button>
                </div>
            </form>
        </div>
    </div>
</div>










        

