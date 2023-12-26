<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH.'vendor/autoload.php';



class Material extends CI_Controller {

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
	  $this->load->model('Materialmodel');
    $this->load->model('Assetmodel');
	}
	public function materialcondotionlist()
	{
		$data['page_title'] = 'Material Condition';
		$data['page_name'] = 'Material Condition';
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('sysadmin/view_material',$data);
		$this->load->view('include/admin-footer');
	}
  public function super_materialcondotionlist()
	{
		$data['page_title'] = 'Material Condition';
		$data['page_name'] = 'Material Condition';
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/view_material',$data);
		$this->load->view('include/admin-footer');
	}
    public function get_materiallist(){
       $parentid = $this->session->userdata('userid');
       if($this->session->userdata('GroupID')!='1'){
         $parentid = $this->session->userdata('parentid');
       }
       $result = $this->Materialmodel->get_material($parentid);
       $json_data['data'] = $result;
       echo  json_encode($json_data);
    }
    public function save_material(){

    $parentid = $this->session->userdata('userid');
    if($this->session->userdata('GroupID')!='1'){
      $parentid = $this->session->userdata('parentid');
    }
    
    $this->form_validation->set_rules('mater_conditionname', 'Conditon Name', 'required|trim|is_unique[MaterialMST.ConditionName]');
    if ($this->form_validation->run() == FALSE)
    {
        echo json_encode(array('status' => 0));
    }
    else
    {
      $conditionname = $this->input->post('mater_conditionname');
        $data = array(
            'ConditionName'=>strip_tags($conditionname),
            'ParentID'=>$parentid,
            'CreatedBy'=>$this->session->userdata('userid'),
            'CreatedDate'=>date('Y-m-d'),
            );
       $resultId = $this->Materialmodel->savematerial($data);
       if($resultId){
             echo json_encode(array('status' => 1));
       }else{
            echo json_encode(array('status' => 0));
       }

    }
  }

  public function getmaterial_edit(){

    $id = $this->input->post('id');
    $result = $this->Materialmodel->getmaterial_edit($id);

    $response = array(
        "ConditionName" => $result->ConditionName,
        "AutoID" => $result->AutoID
     );

     echo json_encode( array("status" => 1,"data" => $response) );


  }
  public function material_update(){

           
            $updateid = $this->input->post('updateid');
            $this->form_validation->set_rules('mater_conditionname', 'Condition Name', 'required|trim');
            if ($this->form_validation->run() == FALSE)
            {
              return FALSE;
            }
            else
            {
              $mater_conditionname= $this->input->post('mater_conditionname');
                $data = array(
                'ConditionName'=>strip_tags($mater_conditionname),
                'ModifyBy'=>$this->session->userdata('userid'),
                'ModifyDate'=>date('Y-m-d'),
                );
                $resultId = $this->Materialmodel->updatematerial($data,$updateid);
                if($resultId){
                echo json_encode(array('status' => 1));
                }else{
                echo json_encode(array('status' => 0));
                }

            }
  }
  
  public function deletematerial(){

    $id = $this->input->post('id');
    $data = array(
            'IsDelete'=>1,
            'DeleteBy'=>$this->session->userdata('userid'),
            'DeleteDate'=>date('Y-m-d'),
            'ModifyDate'=>date('Y-m-d'),
        );

    $result = $this->Materialmodel->deletematerial($id,$data);
    echo TRUE;

  }
  public function Material_excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'MATERIAL CONDITION NAME');
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$data = $this->Materialmodel->get_material();
		//  echo '<pre>';
    //     print_r($data);
    //     echo '</pre>';
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
		$headerStyle = $worksheet->getStyle('A1:B1');
		$headerStyle->getFont()->setBold(true);
		
	
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'materialcondition.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
}
