	<body class="main-body leftmenu">

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url(); ?>assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- End Loader -->

		<!-- Page -->
		<div class="page">
		<!-- Main Content-->
			<div class="text-center pt-5">

				<div class="container-fluid">
					<div class="inner-body">
						<!-- Row -->
						<div class="row row-sm">
						
						<?php
						  $color = array('bg-primary','bg-danger','bg-success','btn-info');
						  $i=0;
						 foreach($result as $res){
							++$i;
							if($i==4){
                              $i=0;
							}
							 ?>
							<div class="col-xl-3 col-md-6 col-sm-12 col-lg-3">
								<div class="card custom-card pricingTable2">
									<div class="pricingTable2-header">
										<h3><?php echo $res['PlanName']; ?></h3>
										<span></span>
									</div>
									<div class="pricing-plans  <?php echo $color[$i]; ?>">
										<span class="price-value1"><i class="fa fa-usd"></i><span><?php echo round($res['Price']); ?></span></span>
										<span class="month">/<?php if($res['TimePeriod']==1){ echo "Month";}else{ echo "Year"; }; ?></span>
									</div>
									<div class="pricingContent2">
										<ul>
											<li><?php echo $res['Storage']; ?> MB Storage</li>
											<li><?php echo $res['TotalDays']; ?> Days</li>
										</ul>
									</div><!-- CONTENT BOX-->
									<div class="pricingTable2-sign-up">
										<a href="<?php echo base_url('Register/index/'.$res['AutoID']); ?>" class="btn btn-block <?php echo $color[$i]; ?>">Select</a>
									</div><!-- BUTTON BOX-->
								</div>
							</div>
							<?php } ?>
                        
						</div>
						<!-- End Row -->

					</div>
				</div>
			</div>
			<!-- End Main Content-->
		</div>
	