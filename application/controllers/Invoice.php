<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

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
	  $this->load->model('Commonmodel');
	  $this->load->model('Planmodel');
	}
	public function index()
	{
		
		if (!empty($this->session->userdata['userdata'])) {
			$data['company_name'] = $this->session->userdata['userdata']['CompanyName'];
			$data['address']  = $this->session->userdata['userdata']['Address'];
			$city = $this->session->userdata['userdata']['City'];
			$data['city'] =  $this->Commonmodel->getStatedetails($city);
			$planid = $this->session->userdata['userdata']['PlanId'];
			$data['plan'] =  $this->Planmodel->getsingleplan($planid);
			$data['updateid'] = $this->session->userdata['userdata']['AutoID'];
		}

		$this->load->view('header');
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('invoice',$data);
		$this->load->view('include/invoice-footer');
	}
	public function saveinvoice()
	{
		
		$update_id = $this->input->post('invoice_updateid');
		$data = array(
			'isApprove'=>1,
			'PaidStatus'=>1,
			'PaidDate'=>date('Y-m-d')
		);
	   $resultId = $this->Planmodel->updateinvoice($data,$update_id);
	   if($resultId){
            redirect('Dashboard/superadmin_success');
	   }else{
		   redirect('Dashboard/superadmin_dasboard');
	   }
		
	}
	
}
