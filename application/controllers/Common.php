<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

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
	  $this->load->library('form_validation');
	  $this->load->model('Commonmodel');
	}
	public function getStatedetails()
	{
	    $city =  $this->input->post('city');
        $state =  $this->input->post('state');
        $country =  $this->input->post('country');
	    $result =  $this->Commonmodel->getStatedetails($city);
		header('Content-type: application/json');
		echo  json_encode($result);
				
	}
	public function getoneCountrydetails()
	{
	    $countryid =  $this->input->post('countryid');
        $result =  $this->Commonmodel->getoneCountrydetails($countryid);
		header('Content-type: application/json');
		echo  json_encode($result);
				
	}

	
	
		
}
