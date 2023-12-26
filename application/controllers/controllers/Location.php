<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Location extends CI_Controller {

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
	  $this->load->model('Usermodel');
	  $this->load->model('Companymodel');
	//   $this->load->library('phpmailer_lib');
	//   $this->load->library('upload');
	  $this->load->helper('security'); 
	}
	
    public function location_list()
	{

		
        $data['page_title'] = 'Location List';
		$data['page_name'] = "List of  Location";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		 $parentid = $this->session->userdata('parentid');
		}
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$this->load->view('superadmin/location_list',$data);
		$this->load->view('include/admin-footer');
	}

	public function location_save(){

        $this->form_validation->set_rules('CompanyID', 'Company Name', 'required|trim');
		$this->form_validation->set_rules('location_name', 'Location Name', 'required|trim');

		if ($this->form_validation->run() == FALSE)
		{
		   echo json_encode(array('status' => 0));
		}
		else
		{
			$company_id = $this->input->post('CompanyID');
			$location_name = $this->input->post('location_name');
            $contactperson = $this->input->post('ContactPerson');
            $email = $this->input->post('Email');
			$phone = $this->input->post('Phone');
			$countryCode = $this->input->post('countryCode');
			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			  $parentid = $this->session->userdata('parentid');
			}

			$where = array(
						'ParentID'=>$parentid,
						'Name'=>$location_name,
						'CompanyID'=>$company_id,
						'IsDelete'=> NULL,
						);

			$check=$this->Commonmodel->companyallreadycheck('LocationMst',$where);
				
			if($check){
				$data = array(
					'CompanyID'=>$company_id,	
					'Name'=>$location_name,
					'ContactPerson'=> $contactperson,
					'email'=> $email,
					'phone'=> $phone,
					'CountryCode'=> $countryCode,
					'CreatedBy'=>$this->session->userdata('userid'),
					'ParentID'=>$parentid,
					'CreatedDate'=>date("Y-m-d H:i:s"),
					);
		
					$resultId = $this->Commonmodel->common_insert('LocationMst',$data);
					if($resultId){
						echo json_encode(array('status' => 1));
					}else{
					  echo json_encode(array('status' => 0));
					}
			}else{
				echo json_encode(array('status' => 0));
			}
		

		}
 
	}
// 	function quarterxist($key)
// 	{
	
// 		$parent_id = $this->session->userdata('userid');
// 		if($this->session->userdata('GroupID')!='1'){
// 		 $parent_id = $this->session->userdata('parentid');
// 		}
// 		$where = array(
// 		'ParentID'=>$parent_id,
// 		'QuarterlyName'=>$key,
// 		'IsDelete'=>0,
// 		);
// 		$res =  $this->Commonmodel->allreadycheck('QuarterMst',$where);
// 		if ($res == 0)
// 		{
// 		return FALSE;
// 		}
// 		else
// 		{
// 		return TRUE;
// 		}

// 	}

	public function getlocation(){

		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parent_id = $this->session->userdata('parentid');
		}
		$result = $this->Assetmodel->getlocation($parent_id);
		$json_data['data'] = $result;
        // print_r($result);
        // die();
		echo  json_encode($json_data);

	}

	
	public function getonelocation(){
	  $id = $this->input->post('id');
	  $result = $this->Assetmodel->getonelocation($id);
		$response = array(
			"id" => $result->AutoID,
			"CompanyName" => $result->CompanyID,
			"CompanyID" => $result->CompanyID,
			"Name" => $result->Name,
			"ContactPerson" => $result->ContactPerson,
			"Email" => $result->Email,
			"Phone" => $result->Phone,
			"countrycode" => $result->CountryCode,
		 );
	
		 echo json_encode( array("status" => 1,"data" => $response) );
	}
	
	public function update_location(){

          

           
		$this->form_validation->set_rules('up_assetowner_id', 'Company Name', 'required|trim');
		$this->form_validation->set_rules('up_location_name', 'Location Name', 'required|trim');

				if ($this->form_validation->run() == FALSE)
			{
			  return FALSE;
			}
			else
			{
			
			$update_id = $this->input->post('update_id');	
			$company_id = $this->input->post('up_assetowner_id');
			$location_name = $this->input->post('up_location_name');
            $contactperson = $this->input->post('up_ContactPerson');
            $email = $this->input->post('up_email');
			$phone = $this->input->post('up_phone');
            $countryCode = $this->input->post('up_countryCode');
           

			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			  $parentid = $this->session->userdata('parentid');
			}

			// $where = array(
			// 			'ParentID'=>$parentid,
			// 			'Name'=>$location_name,
			// 			'CompanyID'=>$company_id,
			// 			'IsDelete'=> NULL,
			// 			);

			// $check=$this->Commonmodel->allreadycheck('LocationMst',$where);

				// if($check){}
					$data = array(
					'CompanyID'=>$company_id,	
					'Name'=>$location_name,
					'ContactPerson'=> $contactperson,
					'email'=> $email,
					'CountryCode'=> $countryCode,
					'phone'=> $phone,
					 'ModifyBy'=>$this->session->userdata('userid'),
					'ModifyDate'=>date("Y-m-d H:i:s"),
						);
						
					
						$where = array(
							'AutoID'=>$update_id,
						);
		
						$resultId = $this->Commonmodel->common_update('LocationMst',$where,$data);
						if($resultId){
						   echo json_encode(array('status' => 1));
						}else{
						   echo json_encode(array('status' => 0));
						}
				

			}

}
public function delete_location(){
	$id = $this->input->post('id');
	$data = array(
	'IsDelete'=>1,
	'ModifyBy'=>$this->session->userdata('userid'),
	'ModifyDate'=>date("Y-m-d H:i:s"),	
	);
	$where = array(
	'AutoID'=>$id,
	);

	$resultId = $this->Commonmodel->common_update('LocationMst',$where,$data);
	echo TRUE;
}
public function excel_export() {
	$spreadsheet = new Spreadsheet();
	$worksheet = $spreadsheet->getActiveSheet();

	// Define the header row data
	$headerData = array('S.NO', 'Company Name', 'Location Name', 'Contact Person','Email','Countrycode','Phone');

	// Apply header data to the worksheet
	$worksheet->fromArray([$headerData], null, 'A1');

	// Get the dynamic data
	$parent_id = $this->session->userdata('userid');
	if($this->session->userdata('GroupID')!='1'){
	$parent_id = $this->session->userdata('parentid');
	}
	$result = $this->Assetmodel->getlocation($parent_id);
	// Loop through the array and reorder the keys
	foreach ($result as &$subArray) {
		$subArray = array_merge(
			array_slice($subArray, 0, array_search('Phone', array_keys($subArray), true) + 1),
			['CountryCode' => $subArray['CountryCode']],
			array_slice($subArray, array_search('Phone', array_keys($subArray), true) + 1)
		);
	}

	

	// Populate the spreadsheet with dynamic data (starting from row 2)
	$worksheet->fromArray($result, null, 'A2');
	// Apply style to header row (green color and bold)
	$headerStyle = $worksheet->getStyle('A1:D1');
	$headerStyle->getFont()->setBold(true);
	// Create a writer and save the spreadsheet
	$writer = new Xlsx($spreadsheet);
	$filename = 'Location.xlsx';
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');
	$writer->save('php://output');
}
  
 
	
	
  
}