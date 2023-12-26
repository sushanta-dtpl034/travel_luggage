		<!-- Main Content-->
			<div class="main-content side-content pt-0">

				<div class="container-fluid">
					<div class="inner-body">

						<!-- Page Header -->
						<div class="page-header">
							<div>
								<h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name;?></h2>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Subscription</a></li>
									<li class="breadcrumb-item active" aria-current="page">Subscribers</li>
								</ol>
							</div>
							
						</div>
						<!-- End Page Header -->
                        
						<!-- Row -->

						<div class="row row-sm">
							<div class="col-lg-12">
								<?php 
								    $status = $this->uri->segment(3);

									if (isset($status)) {
										?>
										<div class="alert alert-success" role="alert">
										Verified successfully
										</div>
								<?php 
									} 
								?>
								
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered border-bottom" id="example1">
												<thead>
													<tr>
														<th class="wd-20p">S.no</th>
														<th class="wd-25p">CompanyName</th>
														<th class="wd-20p">Database Name</th>
                                                        <th class="wd-20p">UserName</th>
														<th class="wd-20p">PaidDate</th>
                                                        <th class="wd-20p">Approve</th>
                                                        <th class="wd-20p">Action</th>
													</tr>
												</thead>
												<tbody>
                                                    <?php 
                                                    $i=1;
                                                    foreach($subscribers_list as $sub){
                                                       ?>
                                                        <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $sub['CompanyName']; ?></td>
														<td><?php echo $sub['DatabaseName']; ?></td>
														<td><?php echo $sub['UserName']; ?></td>
														<td><?php echo $sub['PaidDate']; ?></td>
                                                        <td><?php 
														if($sub['isApprove']==2){ 
															?> <p class="text-success">Verified</p> 
															<?php 
															}else{ 
																?> <p class="text-warning">Pending</p> <?php } ?></td>
                                                        
                                                        <td><a class="btn planview btn-warning" id="1" datatype="edit" role="button" href="<?php echo base_url('Subscribers/subscribers_edit/'.$sub['AutoID']); ?>"><i class="si si-pencil"></i></a></td>
                                                        </tr>
                                                       <?php
                                                    }
                                                    ?>

													
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Main Content-->

		
		