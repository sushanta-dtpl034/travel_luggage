<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';

use Com\Tecnick\Barcode\Barcode;

class QR extends CI_Controller {
    public function __construct(){
		parent::__construct();
		// Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');

		if($this->uri->segment(1) != 'qr'){
			if (!isset($username) && !isset($userid)) { 
				//$this->session->set_userdata('redirect_url', current_url());
				redirect('Login');
			} 
		}
		
		
		$this->load->helper('referenceno_helper');
		$this->load->helper('quarters_helper');

		$this->load->model('Qrcodemodel');
		$this->load->model('Assetmodel');
		$this->load->model('Companymodel');
		$this->load->model('Commonmodel');
		$this->load->model('TravelerModel');
		
	}
    function index($url){
		//$this->session->unset_userdata('redirect_url');
		$qrcode = $this->uri->segment(2);
		$data['luggage_details'] =$this->Qrcodemodel->get_qrcode_details_qrcode($qrcode);
		$data['country_codes'] = $this->TravelerModel->getCountryCode();
		$data['page_title'] = 'QR Code Details';
		$data['page_name'] = "QR Code Details";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/travel_luggage_details', $data);
		$this->load->view('include/admin-footer');
    }
	
}