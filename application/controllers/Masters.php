<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Masters extends CI_Controller {

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
	  $this->load->library('phpmailer_lib');
	  $this->load->model('Assetmodel');
	  $this->load->library('phpspreadsheet_lib');
	}
	public function projects_list()
	{

		
        $data['page_title'] = 'Project List';
		$data['page_name'] = "List of Projects";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$city_id = $this->session->userdata['userdata']['City'];
		$result = $this->Commonmodel->getStatedetails($city_id);
		if(!empty($result)){
			$data['pincode'] = $result->pCode;
		}
		$this->load->view('superadmin/project_list',$data);
		$this->load->view('include/admin-footer');
	}
	public function projects_save(){

		$project_name = $this->input->post('project_name');
		$project_id = $this->input->post('project_id');
		$contactperson_mobileno = $this->input->post('contactperson_mobileno');
		$promanager_name = $this->input->post('promanager_name');
		$projtmanager_email = $this->input->post('projtmanager_email');
		$active = $this->input->post('active');
		
    $this->form_validation->set_rules('project_name', 'Plan', 'required|is_unique[ProjectMST.ProjectName]');
    $this->form_validation->set_rules('project_id', 'Amount', 'required');
    
	if ($this->form_validation->run() == FALSE)
	{
		echo json_encode(array('status' => 0));
	}
	else
	{

		$data = array(
			'ProjectName'=>$project_name,
			'ProjectID'=>$project_id,
			'ContactNo'=>$contactperson_mobileno,
			'ProjMangerName'=>$promanager_name,
			'ProMangerEmail'=>$projtmanager_email,
			'IsActive'=>$active,
			'CreatedBy'=>$this->session->userdata('userid'),
			'CreatedDate'=>date('Y-m-d'),
			);
	   $resultId = $this->Mastermodel->saveproject($data);
	   if($resultId){
			 echo json_encode(array('status' => 1));
	   }else{
			echo json_encode(array('status' => 0));
	   }

	}
}
public function getactiveproject(){

	$result = $this->Mastermodel->getactiveproject();
	 $json_data['data'] = $result;
	echo  json_encode($json_data);
  }

  
  public function getonemisc(){

	$id = $this->input->post('id');
	$result = $this->Mastermodel->getonemisc($id);

	$response = array(
		"misc_name" => $result->MiscDes,
		"id" => $result->AutoID
	 );

	 echo json_encode( array("status" => 1,"data" => $response) );
  }

  public function getoneproject(){

	$id = $this->input->post('id');
	$result = $this->Mastermodel->getoneproject($id);

	$response = array(
		"project_name" => $result->ProjectName,
		"project_id" => $result->ProjectID,
		"mangername" => $result->ProjMangerName,
		"mangeremail" => $result->ProMangerEmail,
		"contact_no" => $result->ContactNo,
		"active" => $result->IsActive,
	     "id" => $result->AutoID
	 );

	 echo json_encode( array("status" => 1,"data" => $response) );
  }
  public function updateproject(){

		$project_name = $this->input->post('project_name');
		$project_id= $this->input->post('project_id');
		$active = $this->input->post('active');
		$contactperson_mobileno = $this->input->post('contactperson_mobileno');

		$promanager_name = $this->input->post('promanager_name');
		$projtmanager_email = $this->input->post('projtmanager_email');
		$updateid = $this->input->post('updateid');

		
		
	$this->form_validation->set_rules('project_name', 'Project', 'required');
	$this->form_validation->set_rules('project_id', 'Project Id', 'required');
	if ($this->form_validation->run() == FALSE)
	{
		return FALSE;
	}
	else
	{

		$data = array(
			'ProjectName'=>$project_name,
			'ProjectID'=>$project_id,
			'ContactNo'=>$contactperson_mobileno,
			'ProjMangerName'=>$promanager_name,
			'ProMangerEmail'=>$projtmanager_email,
			'IsActive'=>$active,
			'ModifyBy'=>1,
			'ModifyDate'=>date('Y-m-d'),
			);
	$resultId = $this->Mastermodel->updateproject($data,$updateid);
	if($resultId){
			echo json_encode(array('status' => 1));
	}else{
			echo json_encode(array('status' => 0));
	}

}
}
public function deleteproject(){
	$id = $this->input->post('id');
	$data = array(
			'IsDelete'=>1,
			'DeleteBy'=>1,
			'DeleteDate'=>date('Y-m-d'),
			'ModifyDate'=>date('Y-m-d'),
		);

	$result = $this->Mastermodel->deleteproject($id,$data);
	echo TRUE;
}

     public function section_list()
	{

		
        $data['page_title'] = 'Section List';
		$data['page_name'] = "List of Section";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/section_list');
		$this->load->view('include/admin-footer');
	}
   public function section_save(){

	$section_name= $this->input->post('section_name');
	$colors = $this->input->post('colors');

    $this->form_validation->set_rules('section_name', 'Section Nane', 'required|is_unique[SectionMST.SectionName]');
     if ($this->form_validation->run() == FALSE)
    {
	    echo json_encode(array('status' => 0));
    }
   else
   {

	    $data = array(
		'SectionName'=>$section_name,
		'Colors'=>$colors,
		'CreatedBy'=>$this->session->userdata('userid'),
		'CreatedDate'=>date('Y-m-d'),
		);
      $resultId = $this->Mastermodel->savesection($data);
      if($resultId){
		 echo json_encode(array('status' => 1));
      }else{
		echo json_encode(array('status' => 0));
      }

  }

}



public function getsection(){

	$result = $this->Mastermodel->getsection();
	 $json_data['data'] = $result;
	echo  json_encode($json_data);
  }

  public function getonesection(){

	$id = $this->input->post('id');
	$result = $this->Mastermodel->getonesection($id);

	$response = array(
		"section_name" => $result->SectionName,
		"colors" => $result->Colors,
	     "id" => $result->AutoID
	 );

	 echo json_encode( array("status" => 1,"data" => $response) );

  }

  public function updatesection(){

	$section_name = $this->input->post('section_name');
	$colors= $this->input->post('colors');
	$updateid = $this->input->post('updateid');

	
	
$this->form_validation->set_rules('section_name', 'Section Name', 'required');
if ($this->form_validation->run() == FALSE)
{
	   return FALSE;
}
else
{

	$data = array(
		'SectionName'=>$section_name,
		'Colors'=>$colors,
		'ModifyBy'=>$this->session->userdata('userid'),
		'ModifyDate'=>date('Y-m-d'),
		);
   $resultId = $this->Mastermodel->updatesection($data,$updateid);
   if($resultId){
		 echo json_encode(array('status' => 1));
   }else{
		echo json_encode(array('status' => 0));
   }

}
}


public function deletesection(){
	$id = $this->input->post('id');
	$data = array(
			'IsDelete'=>1,
			'DeleteBy'=>$this->session->userdata('userid'),
			'DeleteDate'=>date('Y-m-d')	
		);

	$result = $this->Mastermodel->updatesection($data,$id);
	echo TRUE;
}

public function statges_list(){

	$data['page_title'] = 'Stage List';
	$data['page_name'] = "Project Stage Information";
	$this->load->view('include/admin-header',$data);
	$this->load->view('include/sidebar');
	$this->load->view('include/topbar');
	$data['stages'] = $this->Mastermodel->getstages();
	$this->load->view('superadmin/status_list',$data);
	$this->load->view('include/admin-footer');

}

public function save_stage(){

	$des = $this->input->post('description');
	$days = $this->input->post('days');
	$id = $this->input->post('update_id');
	$i = 0;
   $stages = array();
   for($i=0;$i<count($des);$i++){
		$stages[$i]['description'] = $des[$i];
		$stages[$i]['days'] = $days[$i];
	 }
	 $stage = json_encode($stages);
	$data = array(
	'Stages'=>$stage,
	'ProjectID'=>1,
	'CreatedBy'=>$this->session->userdata('userid'),
	'CreatedDate'=>date('Y-m-d'),
	);

	if(isset($id)){
		$resultId = $this->Mastermodel->updatestatge($data,$id);
		$this->session->set_flashdata('succs_msg', 'Status Updated Successfully');	
		
	}else{
		$resultId = $this->Mastermodel->savestages($data);
		$this->session->set_flashdata('succs_msg', 'Status Insert Successfully');	
	}
	if($resultId){
	  redirect('Masters/statges_list');
	}else{
	  redirect('Masters/statges_list');
	}

  }

    public function miscellaneous_list()
	{

		
        $data['page_title'] = 'Miscellaneous List';
		$data['page_name'] = "List of Miscellaneous";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/miscellaneous_list');
		$this->load->view('include/admin-footer');
	}
	public function misc_save(){

		$misc_name= $this->input->post('misc_name');
		$this->form_validation->set_rules('misc_name', 'Misc Name', 'required|is_unique[MiscellaneousMST.MiscDes]');
		if ($this->form_validation->run() == FALSE)
		{
		  echo json_encode(array('status' => 0));
		}
		else
		{

			$data = array(
			'MiscDes'=>$misc_name,
			'ProjectID'=>'1',
			'CreatedBy'=>$this->session->userdata('userid'),
			'CreatedDate'=>date('Y-m-d'),
			);
			$resultId = $this->Commonmodel->common_insert('MiscellaneousMST',$data);
			if($resultId){
			echo json_encode(array('status' => 1));
			}else{
			echo json_encode(array('status' => 0));
			}

		}

	}
	public function getactivemisc(){

		$result = $this->Mastermodel->getactivemisc();
		$json_data['data'] = $result;
		echo  json_encode($json_data);

	}

	
	public function update_misc(){

        $up_miscform = $this->input->post('misc_name');
	      $updateid = $this->input->post('updateid');
			$this->form_validation->set_rules('misc_name', 'Miscellaneous Name', 'required');
			if ($this->form_validation->run() == FALSE)
			{
			  return FALSE;
			}
			else
			{

				$data = array(
				'MiscDes'=>$up_miscform,
				'ModifyBy'=>1,
				'ModifyDate'=>date('Y-m-d'),
				);


				$where = array(
					'AutoID'=>$updateid,
				);


				$resultId = $this->Commonmodel->common_update('MiscellaneousMST',$where,$data);
				if($resultId){
				   echo json_encode(array('status' => 1));
				}else{
				   echo json_encode(array('status' => 0));
				}

			}

}
public function delete_misc(){
	$id = $this->input->post('id');
	$data = array(
			'IsDelete'=>1,
			'DeleteBy'=>$this->session->userdata('userid'),
			'DeleteDate'=>date('Y-m-d')	
		);
		$where = array(
			'AutoID'=>$id,
		);

		$resultId = $this->Commonmodel->common_update('MiscellaneousMST',$where,$data);
	echo TRUE;
}
    public function superad_materialcon()
	{

		
        $data['page_title'] = 'Material Conditions';
		$data['page_name'] = "List of Material Conditions";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/materialcondition_list',$data);
		$this->load->view('include/admin-footer');
	}
	public function getmaterialcon(){
			$result = $this->Mastermodel->getmaterialcon();
			$json_data['data'] = $result;
			echo  json_encode($json_data);
	}
	public function getonematerialcon(){

		$id = $this->input->post('id');
	$result = $this->Mastermodel->getonematerialcon($id);



	$response = array(
		"AutoID" => $result->AutoID,
		"ConditionName" => $result->ConditionName,
		"ToName" => $result->ToName,
		"ToEmail" => $result->ToEmail,
		"CCEmail" => $result->CCEmail
	 );

	 echo json_encode( array("status" => 1,"data" => $response) );

	}
	
	public function mailsetting_save(){

			$to_name = $this->input->post('to_name');
			$to_email = $this->input->post('to_email');
			$cc_email = $this->input->post('cc_email');
			$updateid = $this->input->post('updateid');
			$this->form_validation->set_rules('to_name', 'To Name', 'required');
			$this->form_validation->set_rules('to_email', 'To Email', 'required');
			$this->form_validation->set_rules('cc_email', 'CC Email', 'required');
			if ($this->form_validation->run() == FALSE)
			{
			  return FALSE;
			}
			else
			{
				$data = array(
				'ToName'=>$to_name,
				'ToEmail'=>$to_email,
				'CCEmail'=>$cc_email,
				'ModifyBy'=>1,
				'ModifyDate'=>date('Y-m-d'),
				);

				$where = array(
				'AutoID'=>$updateid,
				);

				$resultId = $this->Commonmodel->common_update('SuperAdminMaterialMST',$where,$data);
				if($resultId){
				  echo json_encode(array('status' => 1));
				}else{
				  echo json_encode(array('status' => 0));
				}

			}


	}

	public function materialcon_mailsend(){

		$id = $this->uri->segment(3);
		$data['result'] = $this->Mastermodel->getonematerialcon($id);
		$data['page_title'] = 'Material Condition';
		$data['page_name'] = "Material Condition";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/sendmail',$data);
		$this->load->view('include/admin-footer');

	}
	public function materialcon_mailconf(){

		$id = $this->uri->segment(3);
		$data['page_title'] = 'Material Condition';
		$data['page_name'] = "Material Condition";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/materialmail_conf',$data);
		$this->load->view('include/admin-footer');

	}
	public function Material_sendmail(){
     
		    $condition_name = $this->input->post('condition_name');
			$from_email = $this->input->post('from_email');
			$from_name= $this->input->post('from_name');
            $subject= $this->input->post('email_subject');
			$email_message= $this->input->post('email_message');
			$updated= $this->input->post('updated');

			

			$this->form_validation->set_rules('condition_name', 'Condition_name', 'required');
			$this->form_validation->set_rules('from_email', 'From email', 'required');
			$this->form_validation->set_rules('from_name', 'From name', 'required');
			$this->form_validation->set_rules('email_subject', 'Email', 'required');
			$this->form_validation->set_rules('email_message', 'Message', 'required');

			if ($this->form_validation->run() == FALSE)
			{
							
		      $this->session->set_flashdata('materialcon_errmess', 'All fields are mandatory');
			  return FALSE;
			}
			else
			{
				
			
				$data = array(
					'ConditionName'=>$condition_name,
					'FromEmail'=>$from_email,
					'FromName'=>$from_name,
					'EmailSubject'=>$subject,
					'EmailMessage'=>$email_message,
					'ModifyBy'=>$this->session->userdata('userid'),
					'ModifyDate'=>date('Y-m-d'),
					);
	
					$where = array(
					'AutoID'=>$updated,
					);
	
					$resultId = $this->Commonmodel->common_update('SuperAdminMaterialMST',$where,$data);
					if($resultId){
					  echo json_encode(array('status' => 1));
					}else{
					  echo json_encode(array('status' => 0));
					}
	
					// Add a recipient
			
			}		

			
	}

	public function materialemailconf_save(){
     
		$condition_name = $this->input->post('condition_name');
		$from_email = $this->input->post('from_email');
		$from_name= $this->input->post('from_name');
		$subject= $this->input->post('email_subject');
		$email_message= $this->input->post('email_message');


        $this->form_validation->set_rules('condition_name', 'Condition Name', 'required');
		$this->form_validation->set_rules('from_email', 'From email', 'required');
		$this->form_validation->set_rules('from_name', 'From name', 'required');
		$this->form_validation->set_rules('email_subject', 'Email', 'required');
		$this->form_validation->set_rules('email_message', 'Message', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			
		  $this->session->set_flashdata('materialcon_errmess', 'All fields are mandatory');
		  return FALSE;
		}
		else
		{
			$data = array(
				'ConditionName'=>$condition_name,
				'FromEmail'=>$from_email,
				'FromName'=>$from_name,
				'EmailSubject'=>$subject,
				'EmailMessage'=>$email_message,
				'ModifyBy'=>1,
				'ModifyDate'=>date('Y-m-d'),
				);

				
			$resultId = $this->Commonmodel->common_insert('SuperAdminMaterialMST',$data);
			if($resultId){
				$this->session->set_flashdata('materialcon_success', 'Email Configure successfully');
				return true;
			}else{
				$this->session->set_flashdata('materialcon_errmess', 'Email Configure  Ntot Save');
				return false;
			}
		}		

    }
	
	public function getcurrency(){
		$id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$id = $this->session->userdata('parentid');
		}
		$result = $this->Mastermodel->getcurrency($id);
			$json_data['data'] = $result;
		echo  json_encode($json_data);
	}

	/*
	public function currency_list(){
        $data['page_title'] = 'Currencies  List';
		$data['page_name'] = "List of Currencies";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$data['country'] = $this->Commonmodel->getCurrencydetails();
		$this->load->view('superadmin/currency_list',$data);
		$this->load->view('include/admin-footer');
	}

	public function currency_save(){		
		$this->form_validation->set_rules('currency_name', 'Currency Name', 'required|trim');
		$this->form_validation->set_rules('currency_code', 'Currency Code', 'required|trim|callback_currencyexist');
		$this->form_validation->set_rules('currency_symbole', 'Currency Symbole', 'required');
		$this->form_validation->set_rules('currency_unicode', 'Currency Unicode', 'required');
    
		if ($this->form_validation->run() == FALSE){
			echo json_encode(array('status' => 0));
		}else{

			$currency_name  = $this->input->post('currency_name');
			$currency_code  = $this->input->post('currency_code');
			$currency_symbole = $this->input->post('currency_symbole');
			$currency_unicode = $this->input->post('currency_unicode');


			$parent_id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
			}
		
			$data = array(
				'CurrencyName'=>strip_tags($currency_name),
				'CurrencyCode'=>strip_tags($currency_code),
				'CurrencySymbole'=>$currency_symbole,
				'CurrencyUnicode'=>$currency_unicode,
				'ParentID'=>$parent_id,
				'CreatedBy'=>$this->session->userdata('userid'),
				'CreatedDate'=>date('Y-m-d'),
				);

			$resultId = $this->Mastermodel->save_currency($data);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}
		}	
	}
	function currencyexist($key){
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parent_id = $this->session->userdata('parentid');
		}
		$where = array(
			'ParentID'=>$parent_id,
			'CurrencyCode'=>$key,
			'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('CurrencyMST',$where);
		if ($res == 0){
			return FALSE;
		}else{
			return TRUE;
		}

	}    
	public function getonecurrecny(){
		$id = $this->input->post('id');
		$result = $this->Mastermodel->getonecurrecny($id);
		$response = array(
			"AutoID" => $result->AutoID,
			"CurrencyName" => $result->CurrencyName,
			"CurrencyCodeame" => $result->CurrencyCode,
			"CurrencySymbole" => $result->CurrencySymbole,
			"CurrencyUnicode" => $result->CurrencyUnicode,
		);
		echo json_encode( array("status" => 1,"data" => $response) );

	}
	public function updatecurrency(){
		$currency_name  = $this->input->post('up_currencyname');
		$currency_code  = $this->input->post('up_currencycode');
		$currency_symbole = $this->input->post('up_currencysymbole');
		$cur_updateid = $this->input->post('cur_updateid');
		$currencyunicode = $this->input->post('up_currencyunicode');

		$this->form_validation->set_rules('up_currencyname', 'Currency Name', 'required|trim');
		$this->form_validation->set_rules('up_currencycode', 'Currency Code', 'required|trim');
		$this->form_validation->set_rules('up_currencysymbole', 'Currency Symbole', 'required');
		$this->form_validation->set_rules('up_currencyunicode', 'Currency Unicode', 'required');

		if ($this->form_validation->run() == FALSE){
			echo json_encode(array('status' => 0));
		}else{
			$currency_name  = $this->input->post('up_currencyname');
			$currency_code  = $this->input->post('up_currencycode');
			$currency_symbole = $this->input->post('up_currencysymbole');
			$cur_updateid = $this->input->post('cur_updateid');
			$currencyunicode = $this->input->post('up_currencyunicode');

			$data = array(
				'CurrencyName'=>strip_tags($currency_name),
				'CurrencyCode'=>strip_tags($currency_code),
				'CurrencySymbole'=>$currency_symbole,
				'CurrencyUnicode'=>$currencyunicode,
				'ModifyBy'=>$this->session->userdata('userid'),
				'ModifyDate'=>date('Y-m-d'),
			);

			$resultId = $this->Mastermodel->update_currency($data,$cur_updateid);
			if($resultId){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}

		}
	}

	public function delete_currency(){
		$id = $this->input->post('id');
		$data = array(
			'IsDelete'=>1,
			'DeleteBy'=>$this->session->userdata('userid'),
			'DeleteDate'=>date('Y-m-d')	
		);
		$where = array(
			'AutoID'=>$id,
		);
		$resultId = $this->Commonmodel->common_update('CurrencyMST',$where,$data);
		echo TRUE;
	}

	public function excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();

		// Define the header row data
		$headerData = array('S.NO', 'NAME', 'CODE', 'SYMBOL');

		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');

		// Get the dynamic data
		$data = $this->Commonmodel->getCurrencydetails();

		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');

		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:D1');
		$headerStyle->getFont()->setBold(true);
		

		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Currencies.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	*/

  

  
}