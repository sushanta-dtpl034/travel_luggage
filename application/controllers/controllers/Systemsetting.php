<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH.'vendor/autoload.php';


class Systemsetting extends CI_Controller {

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
	  $this->load->model('Planmodel');
	  $this->load->model('Commonmodel');
	  $this->load->model('Mastermodel');
      $this->load->model('Assetmodel');
	  $this->load->model('Companymodel');
	  $this->load->model('Usermodel');
	  $this->load->library('phpmailer_lib');
	  $this->load->library('upload');
	}
	/* System Setting */
    public function view_setting()
    {
        
            $data['page_title'] = 'System Setting';
            $data['page_name'] = "List of Transfer Asset";
            $this->load->view('include/admin-header',$data);
            $this->load->view('include/sidebar');
            $this->load->view('include/topbar');
			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			 $parentid = $this->session->userdata('parentid');
			}
			$data['systemsetting'] = $this->Mastermodel->getsystemsetting($parentid);
            $this->load->view('superadmin/system_setting',$data);
            $this->load->view('include/admin-footer');
    }
    public function setting_save(){

        $this->form_validation->set_rules('height', 'Height', 'required');
		$this->form_validation->set_rules('width', 'Width', 'required');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required');
        $this->form_validation->set_rules('email_password','Email Password', 'required');
        $this->form_validation->set_rules('email_host','Email Host', 'required');
        $this->form_validation->set_rules('email_port','Email Port', 'required');
        $this->form_validation->set_rules('email_address_name','Email Address Name', 'required'); 
        $this->form_validation->set_rules('receive_email_address','Recieve Email Address', 'required'); 
        $this->form_validation->set_rules('google_place','Places', 'required');      
		if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
		  	echo json_encode(array('status' => 0));
		}else{
          	$heightinsert = $this->input->post('height');
			$widthinsert = $this->input->post('width');
			$email_address = $this->input->post('email_address');
			$email_password = $this->input->post('email_password');
			$email_host = $this->input->post('email_host');
			$email_port = $this->input->post('email_port');
            $email_address_name = $this->input->post('email_address_name');
            $receive_email_address = $this->input->post('receive_email_address');
            $google_place = $this->input->post('google_place');
			$updateid = $this->input->post('updateid');
			
			
			$config['upload_path']   = './upload/setting/'; 
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$parent_id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			  $parent_id = $this->session->userdata('parentid');
			}
			$data = array(
				'Width'=>$widthinsert,
				'Height'=>$heightinsert,
				'EmailID'=>$email_address,
				'EmaillPassword'=>$email_password,
				'EmailHost'=>$email_host,
				'EmailPort'=>$email_port,
                'EmailAddressName'=>$email_address_name,
                'RecieveEmailAddress'=>$receive_email_address,
                'googlePlaces'=>$google_place,
				'ParentID'=>$parent_id,
				'CreatedBy'=>$this->session->userdata('userid'),
				'CreatedDate'=>date('Y-m-d'),
			);
			if (!empty($_FILES['company_logo']['name'])) {
				if (!$this->upload->do_upload('company_logo')) {
				   $error = array('error' => $this->upload->display_errors()); 
				}
				else { 
					$file_details = array('upload_data' => $this->upload->data()); 
					foreach($file_details as $f){
						$company_logo = $f['file_name']; 				
					}
					$data['Logoname'] = $company_logo;
				}	
			
			}

	    	if(!empty($updateid)){
				if(empty($company_logo)){
					$company_logo = $this->input->post('old_logoname');
				}
				$where = array(
					'AutoID'=>$updateid,
				);
				$resultId = $this->Commonmodel->common_update('SystemsettingMST',$where,$data);
			}else{
				$resultId = $this->Commonmodel->common_insert('SystemsettingMST',$data);
			}
			
			if($resultId){
				$this->session->set_userdata('height',$heightinsert);
				$this->session->set_userdata('width',$widthinsert);
				$this->session->set_userdata('logo',$company_logo);
		    	echo json_encode(array('status' => 1));
			}else{
			  echo json_encode(array('status' => 0));
			}

		}
 
	}
     
}