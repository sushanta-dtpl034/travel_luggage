<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Company extends CI_Controller {

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
	  $this->load->library(array('form_validation', 'utility'));
	  $this->load->model('Commonmodel');
	  $this->load->model('Companymodel');

	  $this->load->model('Planmodel');
	  $this->load->model('Mastermodel');
      $this->load->model('Assetmodel');
	  $this->load->model('Usermodel');
	  $this->load->library('phpmailer_lib');
	  $this->load->library('upload');
	  $this->load->helper('security'); 
	}
	
    public function company_list()
	{

        $data['page_title'] = 'Company List';
		$data['page_name'] = "List of Company";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');

		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		 $parentid = $this->session->userdata('parentid');
		}
		$data['currency'] = $this->Mastermodel->getcurrency($parentid);
		$this->load->view('superadmin/company_list',$data);
		$this->load->view('include/admin-footer');
	}

	public function company_save(){
        $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim|callback_companyexist');
		//$this->form_validation->set_rules('company_address', 'Company Address', 'required|trim');
		//$this->form_validation->set_rules('companybank_details', 'Bank Details', 'required|trim');
		$this->form_validation->set_rules('company_currency', 'Currency', 'required');

		if ($this->form_validation->run() == FALSE){
		  	echo json_encode(array('status' => 0));
		}else{
			$company_name = $this->input->post('company_name');
			$company_address = $this->input->post('company_address');
			$bank_details = $this->input->post('companybank_details');
			$company_currency = $this->input->post('company_currency');
			$company_status = $this->input->post('company_status');
			$company_shortcode = $this->input->post('company_shortcode');

			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
				$parentid = $this->session->userdata('parentid');
			}

			if($company_status==1){
				$where = array(
					'ParentID'=>$parentid,
					'IsCompany'=>1
				);
				$data['IsCompany'] = 0;
				$update = $this->Commonmodel->common_update('CompanyMst',$where,$data);
			}

			$config['upload_path']   = './upload/company_logo/'; 
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if (!empty($_FILES['company_log']['name'])) {
				if (!$this->upload->do_upload('company_log')) {
				   $error = array('error' => $this->upload->display_errors()); 
				}
				else { 
					$file_details = array('upload_data' => $this->upload->data()); 
					foreach($file_details as $f){
						$company_logo = $f['file_name']; 				
					}
				}	
			
			}else{
				$company_logo='';
			}

			if (!empty($_FILES['company_stamp']['name'])) {
				if (!$this->upload->do_upload('company_stamp')) {
				   $error = array('error' => $this->upload->display_errors()); 
				}
				else { 
					$file_details = array('upload_data' => $this->upload->data()); 
					foreach($file_details as $f){
						$company_stamp = $f['file_name']; 				
					}
				}	
			
			}else{
				$company_stamp='';
			}
						
			$data = array(
				'CompanyName'=>strip_tags($company_name),	
				'CompanyAddress'=>strip_tags($company_address),
				'CompanCurrency'=>$company_currency,
				'CompanyShortCode'=>strtoupper(strtolower($company_shortcode)),
				'CompanyLogo'=>$company_logo,
				'CompanyStamp'=>$company_stamp,
				'BankDetails'=>$bank_details,
				'CreatedBy'=>$this->session->userdata('userid'),
				'ParentID'=>$parentid,
				'IsCompany'=>$company_status,
				'CreatedDate'=>date('Y-m-d'),
			);
			$resultId = $this->Commonmodel->common_insert('CompanyMst',$data);
			if($resultId){
		    	echo json_encode(array('status' => 1));
			}else{
			  echo json_encode(array('status' => 0));
			}

		}
 
	}
	function companyexist($key){
	
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		}
		$where = array(
		'ParentID'=>$parent_id,
		'CompanyName'=>$key,
		'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('CompanyMst',$where);
		if ($res == 0){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function getcompany(){
		$parent_id = $this->session->userdata('userid');
        if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		}
		$result = $this->Companymodel->getcompany($parent_id);
		$json_data['data'] = $result;
		echo  json_encode($json_data);
	}

	
	public function getonecompany(){
		$id = $this->input->post('id');
		$result = $this->Companymodel->getonecompany($id);
		$response = array(
			"CompanCurrency" => $result->CompanCurrency,
			"companyname" => $result->CompanyName,
			"CompanyShortCode" => $result->CompanyShortCode,
			"companyaddres" => $result->CompanyAddress,
			"CompanyLogo" => $result->CompanyLogo,
			"CompanyStamp" => $result->CompanyStamp,
			"BankDetails" => $result->BankDetails,
			"IsCompany" => $result->IsCompany,
			"id" => $result->AutoID
		 );
		 echo json_encode( array("status" => 1,"data" => $response) );
	}
	
	public function update_company(){			
		$this->form_validation->set_rules('up_companyname', 'Company Name', 'required|trim');
		//$this->form_validation->set_rules('up_companyaddress', 'Company Address', 'required|trim');
		//$this->form_validation->set_rules('up_bank_details', 'Bank Details', 'required|trim');
		$this->form_validation->set_rules('up_companycurrency', 'currency', 'required');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			$up_companyname = $this->input->post('up_companyname');
			$up_companyaddress = $this->input->post('up_companyaddress');
			$up_bank_details = $this->input->post('up_bank_details');
			$update_id = $this->input->post('update_id');
			$up_companycurrency = $this->input->post('up_companycurrency');
			$company_shortcode = $this->input->post('up_company_shortcode');

			$up_companystatus = $this->input->post('up_companystatus');
			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('userrole')!='1'){
				$parentid = $this->session->userdata('parentid');
			}
			if($up_companystatus==1){
				$where = array(
					'ParentID'=>$parentid,
					'IsCompany'=>1
				);
				$data['IsCompany'] = 0;
				$update = $this->Commonmodel->common_update('CompanyMst',$where,$data);
			}
			$data = array(
				'CompanyName'=>strip_tags($up_companyname),
				'CompanyAddress'=>strip_tags($up_companyaddress),
				'BankDetails'=>strip_tags($up_bank_details),
				'CompanCurrency'=>$up_companycurrency,
				"CompanyShortCode" =>strtoupper(strtolower($company_shortcode)),
				'IsCompany'=>$up_companystatus,
				'ModifyBy'=>$this->session->userdata('userid'),
				'ModifyDate'=>date('Y-m-d'),
			);

			$config['upload_path']   = './upload/company_logo/'; 
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if (!empty($_FILES['up_companylog']['name'])) {
				if (!$this->upload->do_upload('up_companylog')) {
				   $error = array('error' => $this->upload->display_errors()); 
				}
				else { 
					$file_details = array('upload_data' => $this->upload->data()); 
					foreach($file_details as $f){
						$company_logo = $f['file_name']; 				
					}
				}	
				$data['CompanyLogo'] = $company_logo;
			}

			
			if (!empty($_FILES['up_companystamp']['name'])) {
				if (!$this->upload->do_upload('up_companystamp')) {
				   $error = array('error' => $this->upload->display_errors()); 
				}
				else { 
					$logo_details = array('upload_data' => $this->upload->data()); 
					foreach($logo_details as $ld){
						$company_stamp = $ld['file_name']; 				
					}
				}	
				$data['CompanyStamp'] = $company_stamp;
			
			}
			$where = array(
				'AutoID'=>$update_id,
			);
			$resultId = $this->Commonmodel->common_update('CompanyMst',$where,$data);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}

		}

	}
	public function delete_company(){
		$id = $this->input->post('id');
		$data = array(
		'IsDelete'=>1,
		'DeleteBy'=>$this->session->userdata('userid'),
		'DeleteDate'=>date('Y-m-d')	
		);
		$where = array(
		'AutoID'=>$id,
		);

		$resultId = $this->Commonmodel->common_update('CompanyMst',$where,$data);
		echo TRUE;
	}
	public function excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'Company Name', 'Company Short Code', 'Currency');
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$parent_id = $this->session->userdata('userid');
        if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		}

		
		$data = $this->Companymodel->getcompany($parent_id);

		$serialNo = 1; // Initialize serial number
		foreach ($data as &$subArray) {
	
			unset($subArray['CompanyAddress']);
			unset($subArray['AutoID']);
			unset($subArray['IsCompany']);
			$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
			$serialNo++;
		}
		
		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');
		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:D1');
		$headerStyle->getFont()->setBold(true);
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Company.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	
	
  
}