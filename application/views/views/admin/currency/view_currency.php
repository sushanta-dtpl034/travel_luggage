<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-body">
				<?php $this->load->view('common/common_message'); ?> 
                <?php $this->load->view('common/datatable'); ?> 
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal" id="currencymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Currency Creation</h6>
				<button aria-label="Close" class="btn-close btn-secondary closeModal" data-bs-dismiss="modal" type="button">X</button>
			</div>
			
			<form id="addForm" accept-charset="utf-8">
				<!-- Show PHP Validation ERRORS Start -->
				<div class="alert alert-danger print-error-msg" style="display:none">
					<ul id="form_errors"></ul>
				</div>
				<!-- Show PHP Validation ERRORS End -->

				<div class="modal-body">
					<div class="row row-sm">
						<div class="col-md-6">
							<div class="form-group">
									<p class="mg-b-10">Currency Name<span class="tx-danger">*</span></p>
									<input type="text" class="form-control"  name="currency_name" required=""  id="currency_name" placeholder="Currency Name">
								</div>
							</div>
							<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Code<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="currency_code" required="" id="currency_code" placeholder="Currency Code">
							</div>
							</div>
					</div>
					<div class="row row-sm">
						<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Symbol<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="currency_symbole" required=""  id="currency_symbole" placeholder="Currency Symbol">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Unicode<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="currency_unicode" required=""  id="currency_unicode" placeholder="Currency Unicode">
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button class="btn ripple btn-primary" type="button" id="add_button">Save changes</button>
				<button class="btn ripple btn-secondary closeModal" data-bs-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Update Modal -->
<div class="modal" id="up_currencymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Currency  Update</h6>
				<button aria-label="Close" class="btn-close btn-secondary closeModal" data-bs-dismiss="modal" type="button">X</button>
			</div>
			<form id="updateForm">
				<!-- Show PHP Validation ERRORS Start -->
				<div class="alert alert-danger print-update-error-msg" style="display:none">
					<ul id="update_form_errors"></ul>
				</div>
				<!-- Show PHP Validation ERRORS End -->
				<input type="hidden" class="form-control"  name="cur_updateid" required="" id="cur_updateid">
				
				<div class="modal-body">
					<div class="row row-sm">
						<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Name<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="up_currencyname" required=""  id="up_currencyname">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Code<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="up_currencycode" required="" id="up_currencycode">
							</div>
						</div>
					</div>
					<div class="row row-sm">
						<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Symbol<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="up_currencysymbole" required=""  id="up_currencysymbole">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<p class="mg-b-10">Currency Unicode<span class="tx-danger">*</span></p>
								<input type="text" class="form-control"  name="up_currencyunicode" required=""  id="up_currencyunicode">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="button" id="update_button">Update</button>
						<button class="btn ripple btn-secondary closeModal" data-bs-dismiss="modal" type="button" id="">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<script type="module" src="<?php echo base_url();?>assets/js/common/common_index.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin/currency/currency.js"></script>
