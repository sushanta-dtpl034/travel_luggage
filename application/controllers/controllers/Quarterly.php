<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH.'vendor/autoload.php';


class Quarterly extends CI_Controller {

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
	  $this->load->library('phpmailer_lib');
	  $this->load->library('upload');
	  $this->load->helper('security'); 
	}
	
    public function quarterly_list()
	{

		
        $data['page_title'] = 'Quarter List';
		$data['page_name'] = "List of  Quarter";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		 $parentid = $this->session->userdata('parentid');
		}
		$data['currency'] = $this->Assetmodel->getquarter($parentid);
		$this->load->view('superadmin/quarterly_list',$data);
		$this->load->view('include/admin-footer');
	}

	public function quarterly_save(){

        $this->form_validation->set_rules('quarter_name', 'Quarter Name', 'required|trim|callback_quarterxist');
		$this->form_validation->set_rules('quarter_from', 'Quarter From', 'required|trim');
		$this->form_validation->set_rules('quarter_to', 'Quarter To', 'required|trim');
		if ($this->form_validation->run() == FALSE)
		{
		   echo json_encode(array('status' => 0));
		}
		else
		{
			$quarter_name = $this->input->post('quarter_name');
			$quarter_from = $this->input->post('quarter_from');
			$quarter_to = $this->input->post('quarter_to');

            $quarter_from = explode("-",$quarter_from);
            $insert_quarter_from = $quarter_from[0]."-".$quarter_from[1]."-".$quarter_from[2];
            $quarter_to = explode("-",$quarter_to);
            $insert_quarter_to = $quarter_to[0]."-".$quarter_to[1]."-".$quarter_to[2];

			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			  $parentid = $this->session->userdata('parentid');
			}
						
			$data = array(
			'QuarterlyName'=>$quarter_name,	
            'Fromdate'=>$insert_quarter_from,
			'Todate'=> $insert_quarter_to,
			'CreatedBy'=>$this->session->userdata('userid'),
			'ParentID'=>$parentid,
			'CreatedDate'=>date('Y-m-d'),
			);
			$resultId = $this->Commonmodel->common_insert('QuarterMst',$data);
			if($resultId){
		    	echo json_encode(array('status' => 1));
			}else{
			  echo json_encode(array('status' => 0));
			}

		}
 
	}
	function quarterxist($key)
	{
	
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		 $parent_id = $this->session->userdata('parentid');
		}
		$where = array(
		'ParentID'=>$parent_id,
		'QuarterlyName'=>$key,
		'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('QuarterMst',$where);
		if ($res == 0)
		{
		return FALSE;
		}
		else
		{
		return TRUE;
		}

	}

	public function getquarter(){

		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parent_id = $this->session->userdata('parentid');
		}
		$result = $this->Assetmodel->getquarter($parent_id);
		$json_data['data'] = $result;
		echo  json_encode($json_data);

	}

	
	public function getonequarter(){

	 $id = $this->input->post('id');
	$result = $this->Assetmodel->getonequarter($id);

		

		$response = array(
			"QuarterlyName" => $result->QuarterlyName,
			"Fromdate" => $result->Fromdate,
			"Todate" => $result->Todate,
			"id" => $result->AutoID
		 );
	
		 echo json_encode( array("status" => 1,"data" => $response) );
		


	}
	
	public function update_quater(){

          

           
			$this->form_validation->set_rules('up_quartername', 'Quarter Name', 'required|trim');
			$this->form_validation->set_rules('up_quarterfrom', 'Quarter From', 'required|trim');
			$this->form_validation->set_rules('up_quarterto', 'Auarter To', 'required|trim');
				if ($this->form_validation->run() == FALSE)
			{
			  return FALSE;
			}
			else
			{
			

				$up_quartername = $this->input->post('up_quartername');
				$update_id = $this->input->post('update_id');

                $up_quarterfrom = $this->input->post('up_quarterfrom');
                $up_quarterto = $this->input->post('up_quarterto');

                $up_quarterfrom = explode("-",$up_quarterfrom);
                $insert_up_quarterfrom = $up_quarterfrom[0]."-".$up_quarterfrom[1]."-".$up_quarterfrom[2];
                $up_quarterto = explode("-",$up_quarterto);
                $insert_up_quarterto = $up_quarterto[0]."-".$up_quarterto[1]."-".$up_quarterto[2];
				

				$data = array(
				'QuarterlyName'=>$up_quartername,
				'Fromdate'=>$insert_up_quarterfrom,
				'Todate'=>$insert_up_quarterto,
              	'ModifyBy'=>$this->session->userdata('userid'),
				'ModifyDate'=>date('Y-m-d'),
				);
			
				$where = array(
					'AutoID'=>$update_id,
				);

				$resultId = $this->Commonmodel->common_update('QuarterMst',$where,$data);
				if($resultId){
				   echo json_encode(array('status' => 1));
				}else{
				   echo json_encode(array('status' => 0));
				}

			}

}
public function delete_quarter(){
	$id = $this->input->post('id');
	$data = array(
	'IsDelete'=>1,
	'DeleteBy'=>$this->session->userdata('userid'),
	'DeleteDate'=>date('Y-m-d')	
	);
	$where = array(
	'AutoID'=>$id,
	);

	$resultId = $this->Commonmodel->common_update('QuarterMst',$where,$data);
	echo TRUE;
}
public function quarter_excel_export() {
	$spreadsheet = new Spreadsheet();
	$worksheet = $spreadsheet->getActiveSheet();

	// Define the header row data
	$headerData = array('S.NO', 'QUARTER NAME','FROM DATE','TO DATE');

	// Apply header data to the worksheet
	$worksheet->fromArray([$headerData], null, 'A1');

	// Get the dynamic data
	$data = $this->Assetmodel->getquarter();
	//  echo '<pre>';
	// print_r($data);
	// echo '</pre>';
	//  die();
	

	$serialNo = 1; // Initialize serial number
	foreach ($data as &$subArray) {

		unset($subArray['AutoID']);
		$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
		$serialNo++;
	}
	

	// Populate the spreadsheet with dynamic data (starting from row 2)
	$worksheet->fromArray($data, null, 'A2');

	// Apply style to header row (green color and bold)
	$headerStyle = $worksheet->getStyle('A1:H1');
	$headerStyle->getFont()->setBold(true);
	

	// Create a writer and save the spreadsheet
	$writer = new Xlsx($spreadsheet);
	$filename = 'Quarter.xlsx';
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');
	$writer->save('php://output');
}

  
 
	
	
  
}