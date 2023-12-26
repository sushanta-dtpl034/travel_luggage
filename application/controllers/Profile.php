<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
	  $this->load->model('Commonmodel');
	  $this->load->model('Assetmodel');
	  $this->load->model('Usermodel');

	  
	}
    public function sup_profile()
	{
		
		$data['page_title'] = 'Profile';
		$data['page_name'] = "Profile Edit";
		$this->load->view('header',$data);
		$this->load->view('include/sidebar',$data);
		$this->load->view('include/topbar',$data);
        $id = $this->session->userdata('userid');
		$data['city'] = $this->Commonmodel->getCiti();
       
	    $data['subs_data'] = $this->Subscribersmodel->get_subscriber($id);
		$data['user']= $this->Usermodel->get_user($id);

	
		$this->load->view('superadmin/profile',$data);
		$this->load->view('include/admin-footer');
	}
	public function profileimage_save(){

                

		  $id = $this->input->post('id');
		  $old_image = $this->input->post('old_image');
		  
		if (!empty($_FILES['file']['name'])) {
		
			$this->load->library('upload');
			$config['upload_path']   = './upload/profile/'; 
			$config['allowed_types'] = 'jpg|png'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
					
			if (!$this->upload->do_upload('file')) {
			 $error = array('error' => $this->upload->display_errors()); 
			}
			else { 
				$file_details = array('upload_data' => $this->upload->data()); 
				foreach($file_details as $f){
					$filename = $f['file_name']; 				
				}

				$data = array(
					'ProfileIMG'=>$filename,
					'ModifyBy'=>$this->session->userdata('userid'),
					'ModifyDate'=>date('Y-m-d')	
				);
				$where = array(
					'AutoID'=>$id,
				);

				$this->session->set_userdata('profile',$filename);
		
				$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
				echo  true;

				
			} 
		}

		

	}
	
	public function profile_update(){

		$profile_name = $this->input->post('profile_name');
		$profile_email = $this->input->post('profile_email');
		$profile_mobile = $this->input->post('profile_mobile');
		$profile_username = $this->input->post('profile_username');
		$profile_prefix = $this->input->post('profile_prefix');
		// $profile_companyname = $this->input->post('bio');
		// $profile_address = $this->input->post('profile_address');
		// $profile_city = $this->input->post('city_id');
		// $profile_state = $this->input->post('state_id');
		// $profile_pincode = $this->input->post('profile_pincode');
		// $profile_country = $this->input->post('country_id');
		// $profile_pan = $this->input->post('profile_pan');
		// $profile_tax = $this->input->post('profile_tax');
		// $profile_gst = $this->input->post('profile_gst');
		// $profile_contactperson = $this->input->post('profile_contactperson');
		// $profile_emailid = $this->input->post('profile_emailid');
		// $profile_office = $this->input->post('profile_office');
		// $profile_mobile = $this->input->post('profile_mobile');
		$data_id = $this->input->post('data_id');
		// $data = array(
		// 	'CompanyName'=>$profile_companyname,
		// 	'Address'=>$profile_address,
		// 	'City'=>$profile_city,
		// 	'State'=>$profile_state,
		// 	'Pincode'=>$profile_pincode,
		// 	'Country'=>$profile_country,
		// 	'GstNo'=>$profile_gst,
		// 	'TaxID'=>$profile_tax,
		// 	'Pan'=>$profile_pan,
		// 	'Email'=>$profile_emailid,
		// 	'ContactPersonName'=>$profile_contactperson,
		// 	'OfficePhoneNumber'=>$profile_office,
		// 	'ContactPersonMobile'=>$profile_mobile,
		// 	'ModifyBy'=>$this->session->userdata('userid'),
		// 	'ModifyDate'=>date('Y-m-d')	
		// );
		$data = array(
			'Name'=>$profile_name,
			'Email'=>$profile_email,
			'Mobile'=>$profile_mobile,
			'UserName'=>$profile_username,
			'Suffix'=>$profile_prefix,
			'ModifyBy'=>$this->session->userdata('userid'),
			'ModifyDate'=>date('Y-m-d')	
		);
		$where = array(
			'AutoID'=>$data_id,
		);

		

		$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
		echo  true;
	}
	public function change_password(){

		$data['page_title'] = 'Change Password';
		$data['page_name'] = "Change Password";
		$this->load->view('header',$data);
		$this->load->view('include/sidebar',$data);
		$this->load->view('include/topbar',$data);
		$this->load->view('superadmin/change_password');
		$this->load->view('include/admin-footer');

	}
   
	public function update_password(){


		$password = $this->input->post('password');
		$change_id = $this->input->post('change_id');
		$data = array(
			'Password'=>password_hash($password,PASSWORD_DEFAULT),
			'ModifyBy'=>$this->session->userdata('userid'),
			'ModifyDate'=>date('Y-m-d')	
		);
		$where = array(
			'AutoID'=>$change_id,
		);

		$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
		echo  true;


	}

		

	
}
