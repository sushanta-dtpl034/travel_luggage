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
									
									<button type="button" class="btn btn-primary my-2 btn-icon-text stage_add" data-bs-target="#projectmodel" data-bs-toggle="modal" href="">
                                    <i class="si si-plus"></i>
									</button>
								</div>
							</div>

        </div>
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">

                    
                        <?php if($this->session->flashdata('succs_msg')): ?>
                            <div class="alert alert-success" role="alert">   
                        <?php echo $this->session->flashdata('succs_msg'); ?></p>
                        </div>
                        <?php endif; ?>
            
               
                        <form method="post" action="<?php echo base_url('Masters/save_stage'); ?>">
                        <div class="row row-sm stage_list">

                        <?php
                        
                         
                           if(!empty($stages)){
                            $i = 1;
                            foreach($stages as $result){
                                $id = $result['AutoID'];
                                $all_status = $result['Stages'];
                              }
                              $datas = json_decode($all_status,true);
                            foreach($datas as $status){
                                if($i==1){
                        ?>
                                 <div class="col-lg-9 <?php echo "stage_".$i;  ?>">
												<div class="input-group mb-3">
													<span class="input-group-text" id="basic-addon1">Stage-1</span>
													<input aria-describedby="basic-addon1"  class="form-control stage" placeholder="Description" type="text" name="description[]" value="<?php echo $status['description']; ?>">
                                                    <input aria-describedby="basic-addon1"  class="form-control"  name="days[]" type="hidden">
                                                    <input aria-describedby="basic-addon1"  class="form-control"  name="update_id" type="hidden" value="<?php echo $id; ?>">
												</div>
											</div>
   
                            <?php 
                            }
                            else{
                                 ?>
                                   <div class="col-lg-9 <?php echo "stage_".$i;  ?>"><div class="input-group mb-3"><span class="input-group-text stage_label" id="basic-addon1">Stage-<?php echo $i; ?></span><input aria-describedby="basic-addon1" class="form-control stage" placeholder="Description" name="description[]" type="text" value="<?php echo $status['description']; ?>"></div></div>
                                            <div class="col-lg-2 <?php echo "stage_".$i;  ?>"><div class="input-group mb-3"><input aria-describedby="basic-addon1" aria-label="Username" class="form-control" placeholder="Days" name="days[]" type="text" value="<?php echo $status['days']; ?>"></div></div>
                                            <div class="col-lg-1 <?php echo "stage_".$i;  ?>"><button type="button" class="btn btn-primary  btn-icon-text statge_remove" id="<?php echo $i;  ?>" onclick="stage_remove('<?php echo $i;  ?>')"><i class="si si-minus"></i></button></div>
                                <?php
                            }
                            $i++;
                           }
                               }else{
                                   ?>
                                     <div class="col-lg-9 stage_1">
												<div class="input-group mb-3">
													<span class="input-group-text" id="basic-addon1">Stage-1</span>
													<input aria-describedby="basic-addon1"  class="form-control stage" placeholder="Description" type="text" name="description[]">
                                                    <input aria-describedby="basic-addon1" aria-label="Username" class="form-control" placeholder="Days" name="days[]" type="hidden">
												</div>
											</div>
                                   <?php
                               }

                            ?>

                                            
                                           
											
					   </div>
                <div class="col-md-12 pt-3">
                                        <div class="form-group mt-10 text-center">
                                            <button class="btn ripple btn-danger pd-x-30 mg-r-5" type="submit" id="subcriberedit">Save</button>
                                        </div>
                                    </div>
                      
											
					   </div>
                </form>

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
