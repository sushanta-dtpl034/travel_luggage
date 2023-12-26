	<!-- Main Content-->
	<?php $IsAdmin=$this->session->userdata("userdata")['IsAdmin']; ?>
<div class="main-content side-content pt-0">

	<div class="container-fluid">
		<div class="inner-body">

			<!-- Page Header -->
			<div class="page-header">
				<div>
					<h2 class="main-content-title tx-24 mg-b-5">Welcome To Dashboard</h2>
					<!-- <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#"></a></li>
						<li class="breadcrumb-item active" aria-current="page"></li>
					</ol> -->
				</div>
			</div>
			<!-- End Page Header -->
			<div class="row row-sm">
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card custom-card">
						<div class="card-body">
							<div class="card-order">
								<label class="main-content-label mb-3 pt-1">Total Travel</label>
								<h2 class="text-end"><a href="<?php echo base_url('Qrcode/luggag_details'); ?>"><i class="mdi mdi-cube icon-size float-start text-primary"></i><span class="font-weight-bold"><?php echo $dashboard_data->TOTAL_TRAVEL_DETAILS; ?></span></a></h2>
							</div>
						</div>
					</div>
				</div>
				<!-- COL END -->
				<!--<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card custom-card">
						<div class="card-body">
							<div class="card-order">
								<label class="main-content-label mb-3 pt-1">Total Used</label>
								<h2 class="text-end"><a href="<?php echo base_url('Qrcode/index') ?>"><i class="mdi mdi-cube icon-size float-start text-primary"></i><span class="font-weight-bold"><?php echo $dashboard_data->TOTAL_USED_QRCODE; ?></span></a></h2>
							</div>
						</div>
					</div>
				</div>-->
				<!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card custom-card">
						<div class="card-body">
							<div class="card-order">
								<label class="main-content-label mb-3 pt-1">Removed Asset</label>
								<h2 class="text-end"><a href="<?php echo (count($remove)!=0) ? base_url('Assetmanagement/removeassetform_list') :'javascript:void(0)'; ?>"><i class="mdi mdi-cube icon-size float-start text-primary"></i><span class="font-weight-bold"><?php echo $count = !empty($remove) ? count($remove) : 0; ?></span></a></h2>
							</div>
						</div>
					</div>
				</div> -->
			
				<!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card custom-card">
						<div class="card-body">
							<div class="card-order ">
								<label class="main-content-label mb-3 pt-1">Total Users</label>
								<h2 class="text-end card-item-icon card-icon">
								<a href="<?php  echo ( $IsAdmin ==1 ? base_url('Usercontroller/user_list_admin') : base_url('Usercontroller/user_list')); ?>"><i class="mdi mdi-account-multiple icon-size float-start text-primary"></i><span class="font-weight-bold"><?php echo count($total); ?></span></a></h2>
							</div>
						</div>
					</div>
				</div> -->
				
			
			</div>
							<?php 
								
							$firstTenValues = [];
							if(is_array($pending) && count($pending)>0){

								$al = '';
								if(count($pending)>=10){
									$al= 10;
								}else{
									$al= count($pending);
								}

								for ($i = 0; $i < $al; $i++) {
									$firstTenValues[] = $pending[$i];
								}

							}
						
							?>
							<!-- End Row -->
							<!-- <div class="row row-sm">
								<div class="col-lg-12">
											<div class="card custom-card mg-b-20">
												<div class="card-body">
													<div class="card-header border-bottom-0 pt-0 ps-0 pe-0 d-flex">
														<div>
															<label class="main-content-label mb-2">Pending Verification Task</label> <span class="d-block tx-12 mb-3 text-muted"></span>
														</div>
													</div>
													<div class="table-responsive tasks">
														<table class="table card-table table-vcenter text-nowrap mb-0  border">
															<thead>
																<tr>
																	<th class="wd-lg-10p">Title</th>
																	<th class="wd-lg-10p">Remaining Days</th>
																	<th class="wd-lg-20p">Category</th>
																	<th class="wd-lg-20p">Subcatgory</th>
																	<th class="wd-lg-20p">User</th>
																	<th class="wd-lg-20p">Supervisor</th>
																</tr>
															</thead>
															<tbody>
																	<?php 
																		
																		$classes = ['text-primary', 'text-secondary', 'text-warning', 'text-primary']; // Your classes
																		foreach($firstTenValues as $result_res){
																			$randomIndex = mt_rand(0, 3);
																			// Assign the corresponding class to the data point
																			$item['class'] = $classes[$randomIndex];

																			?>
																								<tr>
																									<td class="d-flex"><?php echo $result_res['AssetTitle'] ?></td>
																									<td class="font-weight-semibold btnTooltip" data-id="<?php echo $result_res['AutoID'] ?>">
																										
																										<?php
																											if($result_res['days']!=0){
																												if ($result_res['daystatus']=='plus') {
																													echo '+'.$result_res['days'];
																												}else{
																												echo '-'.$result_res['days'];
																												}
																											}else{
																												echo 0;
																											}
																										?>
																									</td>
																										<td><?php echo $result_res['AsseCatName'] ?></td>
																									<td><?php echo $result_res['AssetSubcatName'] ?></td>
																									<td><span class="badge bg-pill bg-primary-light"><?php echo $result_res['User'] ?></span></td>
																									<td><?php echo $result_res['Supervisor'] ?></td>
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
							</div>	 -->	 
		</div>
	</div>

	<div class="modal" id="assetview_model">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content modal-content-demo">
				<div class="modal-header">
					<h6 class="modal-title">View Asset </h6>
					<button aria-label="Close" class="btn-close btn-secondary" data-bs-dismiss="modal" type="button">X</button>
				</div>
				<form id="addassetview_form" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="row row-sm">
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Asset Owner company </p>
									<input type="text" class="form-control"  name="view_assetownerid"  id="view_assetownerid" value="" readonly>
									
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Asset Type </p>
									<input type="text" class="form-control"  name="view_assettype"  id="view_assettype" value="" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Company Location <span class="tx-danger">*</span></p>
									<input type="text" class="form-control" name="view_company_location" id="view_company_location" value="" readonly="">
									<!-- <select class="form-control select2"  name="view_company_location" id="view_company_location" readonly>
										<?php 
											foreach($clocation as $cl_res){
												?>
													<option value="<?php echo $cl_res['AutoID']; ?>" ><?php echo $cl_res['Name']; ?></option>
												<?php
											}
											?>
									</select> -->
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Current Location <span class="tx-danger">*</span></p>
									<input type="text" class="form-control" id="view_current_location" name="view_current_location"  readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Asset Category </p>
									<input type="text" class="form-control"  name="vew_assetcat"  id="vew_assetcat" value="" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Asset Sub Category </p>
									<input type="text" class="form-control"  name="view_assetsubcat"  id="view_assetsubcat" value="" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10"> Asset Title <span class="tx-danger">*</span></p>
									<input type="text" class="form-control"  name="asset_title" required=""  id="view_assettitle" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10"> Asset quantity </p>
									<input type="text" class="form-control"  name="asset_qty"   id="view_assetqty" readonly>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10"> Asset Unique Identification Number </p>
									<input type="text" class="form-control"  name="view_assetUIN" required="" id="view_assetUIN" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Asset purchased on</p>
									<!-- <input class="form-control datepicker"  placeholder="MM/DD/YYYY" type="text" id="purchased_date"> -->
									<input class="form-control datepicker"  placeholder="" type="date" id="viewasset_purchasedon" readonly>
									<!-- <input class="form-control" id="datetimepicker" placeholder="MM/DD/YYYY HH/MM/SS" type="text"> -->
									<!-- <input  class="edit-item-date form-control" data-bs-toggle="datepicker" placeholder="MM/DD/YYYY" name="editdueDate" id="edit_due_date"> -->
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Asset User </p>
									<input class="form-control" id="view_asstmaninchargename"  type="text" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<p class="mg-b-10">Supervisor </p>
									<input class="form-control" id="view_assetsupervisorname"  type="text" readonly>
								</div>
							</div>
							
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</div>