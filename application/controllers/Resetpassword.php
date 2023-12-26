<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetpassword extends CI_Controller {

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
	  /*
		if (!isset($username) && !isset($userid)) { 
			redirect('Login');
		} 
		else { 
			redirect('Invoice');
		} */
      $this->load->library('form_validation');
	  $this->load->model('Loginmodel');
	  $this->load->library('phpmailer_lib');
	}
	public function index()
	{
		$page_data['page_title'] = 'Forgot Password';
		$this->load->view('header',$page_data);
        $this->load->view('resetpassword');
        $this->load->view('footer');
   }
   public function passwordreset(){
    
      $password = $this->input->post('password');
      $uid = $this->input->post('uid');
      $newpassword  = password_hash($password,PASSWORD_DEFAULT);
      $data = array(
        'Password'=>$newpassword,
       );
         $resultId = $this->Loginmodel->UpdateresetPassword($uid,$data);
         if($resultId){
            $response = array("status"=>1);
            echo json_encode($response);
         }         

   }
	
}