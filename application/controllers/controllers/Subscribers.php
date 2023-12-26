<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
	  parent::__construct();
		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
		if (!isset($username) && !isset($userid)) { 
		  redirect('Login');
		} 
      $this->load->library('form_validation');
	  $this->load->model('Loginmodel');
	  $this->load->library('phpmailer_lib');
      $this->load->model('Subscribersmodel');
	}	
    public function subscribers_list()
	{

	
		$data['page_title'] = 'Subscribers';
		$data['page_name'] = "Subscribers List";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
        $data['subscribers_list'] = $this->Subscribersmodel->get_paidsubscribers();
		$this->load->view('subscribers_list',$data);
		$this->load->view('include/admin-footer');
	}
	public function subscribers_edit()
	{
		$data['page_title'] = 'Subscribers';
		$data['page_name'] = "Subscribers Edit";
		$id = $this->uri->segment(3);
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$data['subs_data'] = $this->Subscribersmodel->get_subscriber($id);
		$this->load->view('subscriber_edit',$data);
		$this->load->view('include/admin-footer');
	}
	public function subscribers_update()
	{
		  	$updateid = $this->input->post('updated');
			$planname = $this->input->post('planname');
			$planprice = $this->input->post('planprice');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$received_date = $this->input->post('received_date');
			$payment_status = $this->input->post('payment_status');
			$payment_mode = $this->input->post('payment_mode');
			$notes = $this->input->post('notes');
			$contactpersonname = $this->input->post('contactpersonname');
			$email = $this->input->post('email');

			$data = array(
			'isApprove'=>2,
			'ReceivedDate'=>date("Y-m-d", strtotime($received_date)),
			'PaymentStatus'=>$payment_status,
			'PaymentMode'=>$payment_mode,
			'Notes'=>$notes,
			'VerifiedDate'=>date('Y-m-d'),
			'VerifiedBy'=>$this->session->userdata('userid')
			);

			if($payment_mode==1 || $payment_mode==3 || $payment_mode==4){
				$data['TransactionNumber']  = $this->input->post('transaction_number');
				$data['CardNumber']  = $this->input->post('card_number');
				$data['AccountNumber']  = $this->input->post('acount_number');
				$data['AccountHolderName']  = $this->input->post('acountholder_name');
				$data['BankName']  = $this->input->post('bank_name');
				$data['IfscCode']  = $this->input->post('ifsc_code');
			}
     		if($payment_mode==2){
				$data['UpiTranNumber']  = $this->input->post('upi_transactionnumber');
				$data['UpiId']  = $this->input->post('upi_id');
			}
			if($payment_mode==4){
				$data['cheque_number']  = $this->input->post('cheque_number');
			}

		
		    $resultId = $this->Subscribersmodel->update_subscriber($data,$updateid);
			if($resultId){
				$mail = $this->phpmailer_lib->load();
				$from = 'testing@dahlia.tech';
				$mail->setFrom($from);
				$mail->isSMTP();
				//$mail->isSendmail();
				$mail->Host     = 'smtp.office365.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'testing@dahlia.tech';
				$mail->Password = 'Vur14262';
				$mail->SMTPSecure = 'tls';
				$mail->Port     = 587;
				 $data['customername'] = $contactpersonname;
				 $data['planname'] = $planname;
				 $data['amount'] = $planprice;
				 $data['customeremail'] = $email;
				 $data['start_date'] = $startdate;
				 $data['end_date'] = $enddate;
				// Add a recipient
				$mail->addAddress($email);
				// Email subject
				$mail->Subject = 'Plan activation details';
				// Set email format to HTML
				$mail->isHTML(true);
				// Email body content
				$mailContent = $this->load->view('activation_temp',$data,TRUE);
				$mail->Body = $mailContent;
				// Send email
				if(!$mail->send()){
				  $mail->ErrorInfo;
				}else{
				  $message = "Mail send successfully";
				}

				return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode(
					array(
                    'status' => 'success',
                 )));
			  
			}else{
		      redirect('Subscribers/subscribers_list');
			}

	}
	
	
}
