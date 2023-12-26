

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
                                    <!-- <div class="justify-content-center">
                                        
                                        <button type="button" class="btn btn-primary my-2 btn-icon-text" data-bs-target="#planmodal" data-bs-toggle="modal" href="">
                                        Add plan
                                        </button>
                                    </div> -->
                </div>

            </div>


            <!-- <div class="row ">
                <div id="carouselExampleControls" class="carousel slide p-5" data-ride="carousel">
                                <div class="carousel-inner">
                                <?php 
                              
                                    // print_r($sliders);
                                    $i=0;
                                    foreach ($sliders as  $value) { ?>
                                        <div class="carousel-item <?php echo($i==0 ? 'active' :'');?>">
                                    <img class="d-block w-10" src="<?php echo(base_url('/upload/asset/').$value['ImageName']);?>" alt="Third slide">
                                    </div>
                                <?php  $i++; }
                                    ?>
                                </div>
                           <?php
                                if(!empty($sliders)){ ?>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                <?php }
                                
                           ?>
                           </div>
                </div>
            </div> -->

            <?php
            if(!empty($myassets)){
            ?>
            <!-- Row -->
            <div class="row row-sm">
 

             
                    
                           <?php
                            // print_r($myassets);
                            $index=0;
                           
                            foreach($myassets as $val){
                            ?>
                             <div class="col-md-4">
                                <div class="card custom-card" style="width: 18rem;">                                              
                                            <div class="carousel slide" data-bs-ride="carousel" id="carouselExample<?php echo $index;?>">
												<div class="carousel-inner">
                                                <?php  $i=0;
                                                        foreach ($sliders as  $value) {                                                             
                                                            if($val['AutoID']== $value['AssetID']){  
                                                              $url = trim(base_url().'upload/asset/'.$value['ImageName']);
                                                            ?>                                                        
                                                              <div class="carousel-item <?php echo $i==0? 'active': '';?>">
                                                                 <img class="d-block w-100" src="<?php echo $url;?>" alt="First slide" style="height:200px;">
                                                                </div>
                                                              <?php $i=1;
                                                            }else{
                                                                ?>
                                                                 <div class="carousel-item <?php echo $i==0? 'active': '';?>">
                                                                   <img class="d-block w-100" src="<?php echo base_url()."upload/noasset.jpg";?>" alt="First slide" style="height:200px;">
                                                                </div>
                                                                <?php
                                                            }
                                                        }                                          
                                                    ?>  
												</div>
												<a class="carousel-control-prev" href="#carouselExample<?php echo $index;?>" role="button" data-bs-slide="prev">
													<i class="fa fa-angle-left fs-30" aria-hidden="true"></i>
												</a>
												<a class="carousel-control-next" href="#carouselExample<?php echo $index;?>" role="button" data-bs-slide="next">
													<i class="fa fa-angle-right fs-30" aria-hidden="true"></i>
												</a>
											</div>

                                                <div class="card-body">
                                                                    <div>
                                                                        <h6><?php echo $val['AssetTitle']; ?></h6>
                                                                        <div class="input-group mb-3">
                                                                              <a href="<?php echo base_url('Assetmanagement/ViewAssetDetails')."?ref_no=".$val['UniqueRefNumber']."&type=1" ?>">
                                                                               <h6><?php echo $val['UniqueRefNumber']; ?></h6>
                                                                            </a>&nbsp;
                                                                            <span class="input-group-text" id="basic-addon1" style="margin-top:-10px"><button class="btn ripple btn-outline-light btn-icon btn-sm" data-value="<?php echo $val['UniqueRefNumber']; ?>" onclick="copyText(this);" title="Copy to clipboard"><i class="ti-files"></i></button></span>
                                                                        </div>
                                                                        <?php  echo ($val['isVerify'] == 1) ? '<h6>Next Verification:'.$val['VerificationDate'].'</h6>' : '' ?></h6>
                                                                        <?php  echo ($val['isVerify'] == 1 ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-warning" style="color: white !important;">Verify</span>' ) ?>
                                                                       <!-- <h6><?php echo $val['CompanyName']; ?></h6> -->
                                                                    </div>
                                                  </div>
                                </div>
                             </div>
                                                
                                                            <!-- <div class="card custom-card">
                                                                
                                                                <div class="card-body">
                                                                    <div>
                                                                        <h6><?php echo $val['CompanyName']; ?></h6>
                                                                        <h6><span class="fs-30 me-2"><?php echo $val['UniqueRefNumber']; ?></span>
                                                                        <?php  echo ($val['isVerify'] == 1 ? '<span class="badge bg-success">Verify</span>' : '<span class="badge bg-warning">Pending</span>' ) ?>
                                                                        
                                                                    </h6>
                                                                        <span class="text-muted"><?php echo $val['AsseCatName']; ?>  <?php echo $val['AssetSubcatName']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                
                            <?php  $index++;} ?>

    
                            
                                    
                                </div>
              
            </div>
            <?php 
              }
              else{
            ?>
            <!-- End Row -->
             
                    
                    <img class="d-block mx-auto" src="<?php echo base_url()."upload/no-image.png";?>" alt="First slide" width="500px;" height="500px;">
                  
              <?php
                 }
              ?>

              
        </div>                        
                        
    </div>
</div>
<!-- End Main Content-->
