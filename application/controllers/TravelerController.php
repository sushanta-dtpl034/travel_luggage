<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TravelerController extends CI_Controller {
    function __construct(){
        parent ::__construct();
        $username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
        $this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->model('Commonmodel');
		$this->load->model('TravelerModel');
    }
	function index(){
		$data['page_title'] = 'Traveller  List';
		$data['page_name'] = "Traveller  List";
		$travelTypesArray = TITLE_PREFIX;
		$data['titles'] = $travelTypesArray;
		$data['country_codes'] = $this->TravelerModel->getCountryCode();
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/traveller_list',$data);
		$this->load->view('include/admin-footer');
	}
    public function getTravelLuggageList(){
		$IsAdmin = $this->session->userdata('userisadmin');
		$data['data'] = $this->TravelerModel->getTravelLuggageList();
		echo  json_encode($data);
	}
    function save_travel_luggage(){ 
        $this->form_validation->set_rules('Suffix', 'Title', 'required|trim');
        $this->form_validation->set_rules('Name', 'Name', 'required|trim');	
		$this->form_validation->set_rules('Mobile', 'Phone No', 'required|trim');
		$this->form_validation->set_rules('Address', 'Address', 'required|trim');
		$this->form_validation->set_rules('AdressTwo', 'Google Location', 'required|trim');
		$this->form_validation->set_rules('Gender', 'Gender', 'required|trim');
		// $this->form_validation->set_rules('ProfileIMG', 'Profile Image', 'required');
		if(empty($_FILES['ProfileIMG']['name']) && $_FILES['ProfileIMG']['error'] != 0){
			$this->form_validation->set_rules('ProfileIMG', 'Profile Image', 'required');
		}

		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			//$Password =strip_tags($this->input->post('Password'));
			$picture = '';
			if(!empty($_FILES['ProfileIMG']['name'])){
				if (!file_exists('upload/profile')) {
					mkdir('upload/profile', 0777, true);
				}
				
				$config['upload_path']   = 'upload/profile/'; 
				$config['allowed_types'] = 'jpg|png|jpeg'; 
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if($this->upload->do_upload('ProfileIMG')){
					$uploadData = $this->upload->data();
					$picture ="upload/profile/".$uploadData['file_name'];
				}else{ 
					$picture = '';  
				}
			}

			$data = array(
				'Suffix'			=>strip_tags($this->input->post('Suffix')),
				'Name'				=>strip_tags($this->input->post('Name')),
				//'UserName'			=>strip_tags($this->input->post('UserName')),
				//'Password'			=>password_hash($Password,PASSWORD_DEFAULT),
				'Email'				=>strip_tags($this->input->post('Email')),
				'Gender'			=>strip_tags($this->input->post('Gender')),
				'Address'			=>strip_tags($this->input->post('Address')),
				'AdressTwo'			=>strip_tags($this->input->post('AdressTwo')),
				'Landmark'			=>strip_tags($this->input->post('Landmark')),
				'CountryCode'		=>strip_tags($this->input->post('CountryCode')),
				'Mobile'			=>strip_tags($this->input->post('Mobile')),
				'WhatsAppCountryCode'=>strip_tags($this->input->post('WhatsAppCountryCode')),
				'WhatsappNumber'	=>strip_tags($this->input->post('WhatsappNumber')),
				'ProfileIMG'		=>$picture,
				'IsAdmin'			=>0,
				'isActive'			=>1,
				'IsDelete'			=>0,
				'CreatedBy'			=>$this->session->userdata('userid'),
				'CreatedDate'		=>date('Y-m-d'),
			);
			
			$resultId = $this->Commonmodel->common_insert('RegisterMST',$data);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}

		}
    }
	function update_travel_luggage(){ 
		$this->form_validation->set_rules('Gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('Suffix', 'Title', 'required|trim');
        $this->form_validation->set_rules('Name', 'Name', 'required|trim');	
		$this->form_validation->set_rules('Mobile', 'Phone No', 'required|trim');
		$this->form_validation->set_rules('Address', 'Address', 'required|trim');
		$this->form_validation->set_rules('AdressTwo', 'Google Location', 'required|trim');
		
		if(empty($this->input->post('oldimage')) && empty($_FILES['ProfileIMG']['name'])){
			$this->form_validation->set_rules('ProfileIMG', 'Profile Image', 'required');
		}

		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			//$Password =strip_tags($this->input->post('Password'));
			$oldimage =$this->input->post('oldimage');
		
			if(!empty($oldimage) && !empty($_FILES['ProfileIMG']['name'])){
				if (file_exists($oldimage)){
					if (unlink($oldimage)) {   
					}   
				} 
			}
			$picture = '';
			if(!empty($_FILES['ProfileIMG']['name'])){
				if (!file_exists('upload/profile')) {
					mkdir('upload/profile', 0777, true);
				}
				
				$config['upload_path']   = 'upload/profile/'; 
				$config['allowed_types'] = 'jpg|png|jpeg'; 
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if($this->upload->do_upload('ProfileIMG')){
					$uploadData = $this->upload->data();
					$picture ="upload/profile/".$uploadData['file_name'];
				}else{ 
					$picture = '';  
				}
			}

			$data = array(
				'Suffix'			=>strip_tags($this->input->post('Suffix')),
				'Name'				=>strip_tags($this->input->post('Name')),
				// 'UserName'			=>strip_tags($this->input->post('UserName')),
				// 'Password'			=>password_hash($Password,PASSWORD_DEFAULT),
				'Email'				=>strip_tags($this->input->post('Email')),
				'Gender'			=>strip_tags($this->input->post('Gender')),
				'Address'			=>strip_tags($this->input->post('Address')),
				'AdressTwo'			=>strip_tags($this->input->post('AdressTwo')),
				'Landmark'			=>strip_tags($this->input->post('Landmark')),
				'CountryCode'		=>strip_tags($this->input->post('CountryCode')),
				'Mobile'			=>strip_tags($this->input->post('Mobile')),
				'WhatsAppCountryCode'=>strip_tags($this->input->post('WhatsAppCountryCode')),
				'WhatsappNumber'	=>strip_tags($this->input->post('WhatsappNumber')),
				'IsAdmin'			=>0,
				'isActive'			=>1,
				'IsDelete'			=>0,
				'ModifyBy'			=>$this->session->userdata('userid'),
				'ModifyDate'		=>date('Y-m-d'),
			);
			if(!empty($picture)){
				$data['ProfileIMG']=$picture;
			}
			$where = array(
				'AutoID'=>$this->input->post('AutoId'),
			);
			$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}

		}
    }
	function getOneTravelLuggage(){
		$id =$this->input->post('id');
		$data = $this->TravelerModel->getTravelLuggageById($id);
		echo  json_encode(["status" => 200,"data"=>$data]);
	}
	function  delete_travel_luggage(){
		$id = $this->input->post('id');
		$data = array(
			'IsDelete'=>1,
			'DeleteBy'=>$this->session->userdata('userid'),
			'DeleteDate'=>date('Y-m-d'),
		);
		$where = array(
			'AutoID'=>$id,
		);
		$resultId = $this->Commonmodel->common_update('RegisterMST',$where,$data);
		if($resultId){
			echo json_encode(array('status' => 1));
		}else{
			echo json_encode(array('status' => 0));
		}
	}

}
