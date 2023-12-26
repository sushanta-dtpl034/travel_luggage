	<!-- Main Content-->
    <div class="main-content side-content pt-0">

<div class="container-fluid">
    <div class="inner-body">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5"><?php echo $page_name; ?></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subscribers</li>
                </ol>
            </div>
        </div>
        <!-- Row -->
		
		<?php 
		
			
		   foreach ($subs_data as $sub){
			     $update_id = $sub['AutoID'];
      			$companyname = $sub['CompanyName'];
				$address = $sub['Address'].",".$sub['city'].",".$sub['state'].",".$sub['countryName'].",".$sub['Pincode'];  
				$email = $sub['Email'];
				$contactpersonname = $sub['ContactPersonName'];
				$officephonenumber = $sub['OfficePhoneNumber'];
				$contactpersonmobile = $sub['ContactPersonMobile'];
				$contactpersonmobile = $sub['ContactPersonMobile'];
				$planname = $sub['PlanName'];
				$palndays = $sub['TotalDays'];
				$price = $sub['Price'];
				$paiddate = date("d-m-Y", strtotime($sub['PaidDate']));
				$expdate = date('d-m-Y', strtotime("+$palndays days"));
				
		   }
		?>
						<div class="row row-sm">
							<div class="col-lg-12 col-md-12">
								<div class="card custom-card">
									<div class="card-body">
									<form method="post" action="<?php echo base_url('Subscribers/subscribers_update'); ?>" id="subscriber_edit">
									<input class="form-control"  type="hidden" id="planid" name="updated" value="<?php echo $update_id; ?>">
									<input class="form-control"  type="hidden" id="contactpersonname" name="contactpersonname" value="<?php echo $contactpersonname; ?>">
									<input class="form-control"  type="hidden" id="email" name="email" value="<?php echo $email; ?>">
                                        <input class="form-control"  type="hidden" id="planname" name="planname" value="<?php echo $planname; ?>">
                                        <input class="form-control"  type="hidden" id="planprice" name="planprice" value="<?php echo $price; ?>">
										<input class="form-control"  type="hidden" id="start_date" name="startdate" value="<?php echo date("d-m-Y"); ?>">
										<input class="form-control"  type="hidden" id="endate" name="enddate" value="<?php echo $expdate; ?>">
										<div class="row row-sm">
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">COMPANY NAME</p>
													<input type="text" class="form-control"  readonly value="<?php echo $companyname; ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">ADDRESS</p>
													<input type="text" class="form-control" name="example-text-input" placeholder="Address" value="<?php echo $address; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">CONTACT PERSON NAME</p>
													<input type="text" class="form-control" readonly value="<?php echo $contactpersonname; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">EMAIL ID</p>
													<input type="text" class="form-control" readonly value="<?php echo $email; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">OFFICE PHONE NO</p>
													<input type="text" class="form-control" readonly value="<?php echo $officephonenumber; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">CONTACT PERSON MOBILE NO</p>
													<input type="text" class="form-control" readonly value="<?php echo $contactpersonmobile; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">PLAN NAME</p>
													<input type="text" class="form-control" readonly value="<?php echo $planname; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">PRICE</p>
													<input type="text" class="form-control" readonly value="<?php echo $price; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">PAID ON</p>
													<input type="text" class="form-control" readonly value="<?php echo $paiddate; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">RECEIVED DATE</p>
													<!-- <input class="form-control fc-datepicker hasDatepicker" placeholder="MM/DD/YYYY" type="text" > -->
													<input class="form-control" id="datepicker-date" placeholder="MM/DD/YYYY" type="text" name="received_date">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">PAYMENT STATUS</p>
													<select class="form-control select2"  id="payment_status" name="payment_status">
															<option value="">Select Status</option>
															<option value="1">Received</option>
															<option value="2">Pending</option>
															<option value="3">Failed</option>
												      </select>
													  <span class="tx-danger" style="display:none;" id="status_erroralert">This value is required.</span>
													  
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<p class="mg-b-10">PAYMENT MODE</p>
														<select class="form-control select2 payment_mode"  id="payment_mode" name="payment_mode" required="" >
															<option value="">Select Mode</option>
															<option value="1">Credit Card/Debit Card</option>
															<option value="2">UPI</option>
															<option value="3">Net Banking</option>
															<option value="4">Cheque</option>
                                                        </select>
														<span class="tx-danger" style="display:none;" id="error_alert">This value is required.</span>
												</div>
											</div>

												<div class="col-md-6 hide_div cheque">
													<div class="form-group">
														<p class="mg-b-10">Cheque Number</p>
														<input type="text" class="form-control" name="cheque_number" value="" id="cheque_number" onchange="remove_errorclass(this.id);">
													</div>
												</div>
		                                    											
												<div class="col-md-6 hide_div upi">
													<div class="form-group">
														<p class="mg-b-10">UPI Transaction Number</p>
														<input type="text" class="form-control" name="upi_transactionnumber" value="" id="upi_trans_id" onchange="remove_errorclass(this.id);" >
													</div>
												</div>
												<div class="col-md-6 hide_div upi">
													<div class="form-group">
														<p class="mg-b-10">UPI ID</p>
														<input type="text" class="form-control" name="upi_id" value="" id="upi_id" onchange="remove_errorclass(this.id);">
													</div>
												</div>
                                           
										
											
										<div class="col-md-6 hide_div credit_debit">
														<div class="form-group">
															<p class="mg-b-10">Transaction Number</p>
															<input type="text" class="form-control" name="transaction_number" value="" id="transaction_number" onchange="remove_errorclass(this.id);">
														</div>
										</div>
										<div class="col-md-6 hide_div credit_debit">
														<div class="form-group">
															<p class="mg-b-10">Card Number</p>
															<input type="text" class="form-control" name="card_number" value="" id="card_number" onchange="remove_errorclass(this.id);">
														</div>
										</div>
											

										 

												
		                       				<div class="col-md-6 hide_div common">
													<div class="form-group">
														<p class="mg-b-10">Account Number</p>
														<input type="text" class="form-control" name="acount_number" value="" id="acount_number" onchange="remove_errorclass(this.id);">
													</div>
												</div>
												
												<div class="col-md-6 hide_div common">
													<div class="form-group">
														<p class="mg-b-10">Account Holder Name</p>
														<input type="text" class="form-control" name="acountholder_name" value="" id="acountholder_name" onchange="remove_errorclass(this.id);"> 
													</div>
												</div>
												<div class="col-md-6 hide_div common">
													<div class="form-group">
														<p class="mg-b-10">Bank Name</p>
														<input type="text" class="form-control" name="bank_name" value="" id="bank_name" onchange="remove_errorclass(this.id);">
													</div>
												</div>
												<div class="col-md-6 hide_div common">
													<div class="form-group">
														<p class="mg-b-10">IFSC Code</p>
														<input type="text" class="form-control" name="ifsc_code" value="" id="ifsc_code" onchange="remove_errorclass(this.id);">
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group">
														<p class="mg-b-10">Naration</p>
														<textarea class="form-control" placeholder="Textarea" rows="3" name="notes" id="notes"></textarea>
													</div>
												</div>
		                                   
										
										
											<div class="col-md-12 pt-3">
												<div class="form-group mt-10 text-center">
												    <button class="btn ripple btn-primary pd-x-30 mg-r-5" type="button" id="subcriberedit">Verify</button>
													<a href="<?php echo base_url('Subscribers/subscribers_list'); ?>"><button class="btn ripple btn-secondary pd-x-30">Cancel</button></a>
												</div>
											</div>
		                                       </form>
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
