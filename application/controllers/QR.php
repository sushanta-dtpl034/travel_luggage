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
		$this->load->helper('referenceno_helper');
		$this->load->helper('quarters_helper');

		$this->load->model('Qrcodemodel');
		$this->load->model('Assetmodel');
		$this->load->model('Companymodel');
		$this->load->model('Commonmodel');
	}
    function index($url){
		$qrcode = $this->uri->segment(2);
        echo $qrcode;
    }
	
}