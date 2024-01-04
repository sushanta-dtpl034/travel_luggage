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
	public function __construct(){
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
		$this->load->model('TravelerModel');
	  
	}
    public function sup_profile(){
		$data['page_title'] = 'Profile';
		$data['page_name'] = "Profile Edit";
		$this->load->view('header',$data);
		$this->load->view('include/sidebar',$data);
		$this->load->view('include/topbar',$data);
        $id = $this->session->userdata('userid'); 
		$travelTypesArray = TITLE_PREFIX;
		$data['titles'] = $travelTypesArray;
		$data['country_codes'] = $this->TravelerModel->getCountryCode();      
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
					$filename ="upload/profile/".$f['file_name']; 				
				}

				if(!empty($old_image)){
					if (file_exists($old_image)){
						if (unlink($old_image)) {   
						}   
					} 
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
		$data_id = $this->input->post('data_id');
		$this->form_validation->set_rules('Profile_Gender', 'Gender', 'required');
		$this->form_validation->set_rules('Profile_Suffix', 'Title', 'required');
		$this->form_validation->set_rules('Profile_Name', 'Name', 'required');

		$this->form_validation->set_rules('Profile_CountryCode', 'Country Code', 'required');
		$this->form_validation->set_rules('Profile_Mobile', 'Phone No', 'required|callback_duplicate_mobile_check['.$data_id.']');
		$this->form_validation->set_rules('Profile_Address', 'Address', 'required');
		$this->form_validation->set_rules('Profile_AdressTwo', 'Address2', 'required');

		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			$data = array(
				'Suffix'			=>strip_tags($this->input->post('Profile_Suffix')),
				'Name'				=>strip_tags($this->input->post('Profile_Name')),
				'Email'				=>strip_tags($this->input->post('Profile_Email')),
				'Gender'			=>strip_tags($this->input->post('Profile_Gender')),
				'Address'			=>strip_tags($this->input->post('Profile_Address')),
				'AdressTwo'			=>strip_tags($this->input->post('Profile_AdressTwo')),
				'Landmark'			=>strip_tags($this->input->post('Profile_Landmark')),
				'CountryCode'		=>strip_tags($this->input->post('Profile_CountryCode')),
				'Mobile'			=>strip_tags($this->input->post('Profile_Mobile')),
				'WhatsAppCountryCode'=>strip_tags($this->input->post('Profile_WhatsAppCountryCode')),
				'WhatsappNumber'	=>strip_tags($this->input->post('Profile_WhatsappNumber')),
				'ModifyBy'			=>$this->session->userdata('userid'),
				'ModifyDate'		=>date('Y-m-d H:i:s'),
			);
			$where = array(
				'AutoID'=>$data_id,
			);
			$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}

		}
		
	}
	function duplicate_mobile_check($str,$AutoID){
		$response =checkDuplicate('RegisterMST', 'Mobile',$str,["AutoId !="=>$AutoID,"IsDelete"=>0]);
		if ($response){
			$this->form_validation->set_message('duplicate_mobile_check', 'The Mobile field  must contain a unique value.');
			return FALSE;
		}else{
            return TRUE;
        }
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
		$change_id = $this->input->post('change_id');
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|callback_oldpassword_check['.$change_id.']');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('Password_2', 'Confirm Password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			$current_password = $this->input->post('current_password');
			$password = $this->input->post('password');
			$Password_2 = $this->input->post('Password_2');
			$data = array(
				'Password'=>password_hash($password,PASSWORD_DEFAULT),
				'ModifyBy'=>$this->session->userdata('userid'),
				'ModifyDate'=>date('Y-m-d')	
			);
			$where = array(
				'AutoID'=>$change_id,
			);
			$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}
		}

	}
	//duplicate account no check
	function oldpassword_check($str,$AutoID){
		$user_data= $this->Usermodel->get_user($AutoID);
		if($user_data){
			if(password_verify($str,$user_data->Password)){ 
				return TRUE;
			}else{
				$this->form_validation->set_message('oldpassword_check', 'The Current Password not matched.');
				return FALSE;
			}
		}
    }

		

	
}
