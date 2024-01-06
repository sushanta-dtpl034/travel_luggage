<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
	public function __construct(){
	  	parent::__construct();
		// Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
		if (!isset($username) && !isset($userid)) { 
		 	redirect('Login');
		} 
		$this->load->library('form_validation');
		$this->load->model('Loginmodel');
		$this->load->model('Usermodel');
		$this->load->model('Assetmodel');
		$this->load->library('phpmailer_lib');
	}
	public function admin_dasboard(){
		$data['page_title'] = 'Dashboard';
		$data['page_name'] = "Welcome To Dashboard";
		$this->load->view('header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('dashboard',$data);
		$this->load->view('include/admin-footer');
	}
	public function superadmin_dasboard(){
		$userid = $this->session->userdata('userid');
		$IsAdmin = $this->session->userdata('userisadmin');
		//get dashboard data count
		$data['dashboard_data'] = $this->Assetmodel->get_dashboard_data();

		$data['page_title'] = 'Dashboard';
		$data['page_name'] = "Welcome To Dashboard";
		$this->load->view('header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin_dashboard',$data);
		$this->load->view('include/admin-footer');		
	}
	public function commingsoon(){		
        $data['page_title'] = 'Coming soon';
		$data['page_name'] = "List of Asset Type";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('comming');
		$this->load->view('include/admin-footer');
	}
	public function assetcontroller(){		
        $data['page_title'] = 'Coming soon';
		$data['page_name'] = "List of Asset Type";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('comming');
		$this->load->view('include/admin-footer');
	}
	public function superadmin_success(){
		$this->load->view('header');
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin_succes');
		$this->load->view('include/invoice-footer');
	}
	
	public function productDashboard(){
		$this->load->view('header');
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('product-dashboard');
		$this->load->view('include/admin-footer');
	}
	public function list(){
		$this->load->view('include/admin-header');
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('list');
		$this->load->view('include/admin-footer');
	}
	
	public function form(){
		$this->load->view('header');
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('form');
		$this->load->view('include/admin-footer');
	}
	
	public function set_service(){
		$service = $this->input->post('id');
		$this->session->set_userdata('serviceID',$service);
		echo  true;
	}

}
