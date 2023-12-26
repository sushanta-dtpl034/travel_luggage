<!-- Main Content-->
<div class="main-content side-content pt-0">

<div class="container-fluid">
	<div class="inner-body">

		<!-- Page Header -->
		<div class="page-header">
			<div>
				<h2 class="main-content-title tx-24 mg-b-5"></h2>
				<!-- <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Pages</a></li>
					<li class="breadcrumb-item active" aria-current="page">Invoice</li>
				</ol> -->
			</div>
		</div>
		<!-- End Page Header -->
         <?php 
		     
			
		?>

		<!-- Row -->
		<div class="row row-sm">
			<div class="col-lg-12 col-md-12">
				<div class="card custom-card">
					<div class="card-body">
						<div class="d-lg-flex">
							<h2 class="main-content-label mb-1"></h2>
							<div class="ms-auto">
								<p class="mb-1"><span class="font-weight-bold">Date :</span> <?php echo date('d-m-y'); ?></p>
							</div>
						</div>
						<hr class="mg-b-40">
						<form method="post" action="<?php echo base_url('Invoice/saveinvoice'); ?>">
						<input class="form-control"  type="hidden" id="invoice_updateid" name="invoice_updateid" value="<?php echo $updateid; ?>">
						<div class="row row-sm">
							<div class="col-lg-6">
							    <p class="h3">Address</p>
								<address>
								<?php echo $company_name; ?>,<br>
								<?php echo $address; ?>,<br>
								<?php echo $city->city.",".$city->state.",".$city->countryName; ?><br>
								</address>
							</div>
							<div class="col-lg-6 text-end">
							</div>
						</div>
					      <div class="table-responsive mg-t-40">
							<table class="table table-invoice table-bordered">
								<thead>
									<tr>
										<th class="wd-20p">Plan</th>
										<th class="wd-40p">Storage</th>
										<th class="tx-center">Days</th>
										<th class="tx-right">Price</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $plan->PlanName; ?></td>
										<td class="tx-12"><?php echo $plan->Storage; ?></td>
										<td class="tx-center"><?php echo $plan->TotalDays; ?></td>
										<td class="tx-right"><?php echo $plan->Price; ?></td>
										
									</tr>
									<tr>
										<td class="valign-middle" colspan="2" rowspan="4">
											<div class="invoice-notes">
												<label class="main-content-label tx-13">Notes</label>
												<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
											</div><!-- invoice-notes -->
										</td>
										<td class="tx-right">Sub-Total</td>
										<td class="tx-right" colspan="2"><?php echo $plan->Price; ?></td>
									</tr>
									<tr>
										<td class="tx-right">Tax</td>
										<td class="tx-right" colspan="2">0%</td>
									</tr>
									<tr>
										<td class="tx-right">Discount</td>
										<td class="tx-right" colspan="2">0%</td>
									</tr>
									<tr>
										<td class="tx-right tx-uppercase tx-bold tx-inverse">Total</td>
										<td class="tx-right" colspan="2">
											<h4 class="tx-bold">$<?php echo $plan->Price; ?></h4>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer text-end">
						<button type="submit" class="btn ripple btn-primary mb-1"><i class="fe fe-credit-card me-1"></i> Pay Invoice</button>
						<button type="button" class="btn ripple btn-secondary mb-1"><i class="fe fe-send me-1"></i>Cancel</button>
					</div>
                 </form>	
				</div>
			</div>
		</div>
		<!-- End Row -->
	</div>
</div>
</div>
<!-- End Main Content-->