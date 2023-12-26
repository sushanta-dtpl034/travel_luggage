<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class Master extends REST_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tokenHandler = new TokenHandler();
		$this->load->model('master_model');
		$this->load->model('api_model');
		$this->load->model('requestmodel');
		$this->load->library('authtoken');
		header('Content-Type: application/json');
	}
	public function Companylist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$Companylist = $this->master_model->CompanyList($data);
			$status=200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($Companylist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function emplyoeelist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$Employeelist = $this->master_model->EmployeeList($data);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($Employeelist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}	

	public function polist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$UserID = $logged_in_user_details['UserID'];
			if ($logged_in_user_details['UserType']==2) {
				$POlist = $this->master_model->POList($data);
			}else{
				$vendordata = $this->master_model->GetVendorCode($UserID);
				$vendor = $vendordata->VendorCode;
				$POlist = $this->master_model->POListByVendor($data,$vendor);
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($POlist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}	

	public function getcurrency_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			if ($logged_in_user_details['UserType']==2) {
				$currencylist = $this->master_model->getcurrency($logged_in_user_details['UserID']);
			}else{
				$currencylist = $this->master_model->getcurrencylist($logged_in_user_details['UserID']);
			}

			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($currencylist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function irpuserlist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$IrpUserList = $this->master_model->IrpUserList($data);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($IrpUserList));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function servicelist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$Servicelist = $this->master_model->ServiceList($data);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($Servicelist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function addservice_post(){
		$data=$this->request->body;
		$tableName = "ServiceMst";
		$type = 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['Service']=$data['Service'];
			$datasave['Priority']=$data['Priority'];
			$datasave['HeadID']=$data['HeadID'];
			$datasave['Status']=1;
			$datasave['IsDelete']=0;
			$Service = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$Service)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function updateservice_post(){
		$data=$this->request->body;
		$tableName = "ServiceMst";
		$type = 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['Service']=$data['Service'];
			$datasave['Priority']=$data['Priority'];
			$datasave['HeadID']=$data['HeadID'];
			$datasave['Status']=1;
			$Service = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$Service)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}
	
	public function deleteservice_post(){
		$data=$this->request->body;
		$tableName = "ServiceMst";
		$type = 3;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['IsDelete']=1;
			$response = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$status = 200;
			$Message = "Deleted successfully !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$response,"message"=>$Message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function SaveSystemSetting_post(){
		$data=$this->request->body;
		$tableName= 'SystemMst';
		//$type= 2;
		$getID=$this->api_model->getmaxid();
		if (($getID->AutoID) >0) {
			$check=$this->api_model->CheckRecord($getID->AutoID);
			$getAutoID= $getID->AutoID ;
		}else{
			$getAutoID= 1;
			$check = false;
		}
        if($check==true){
			$type= 2;
		}else{
			$type= 1;
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$data['EmailAddress'] = $_POST['EmailAddress'];
			$data['EmailPass'] = $_POST['EmailPass'];
			$data['EmailHost'] = $_POST['EmailHost'];
			$data['EmailPort'] = $_POST['EmailPort'];			
			$data['EmailAddName'] = $_POST['EmailAddName'];
			$data['SSL'] = $_POST['SSL'];
			$data['EmailCred'] = $_POST['EmailCred'];
			$data['WebURL'] = $_POST['WebURL'];
			$data['ClientWebURL'] = $_POST['ClientWebURL'];			
			$data['VendorWebURL'] = $_POST['VendorWebURL'];			
			$data['ReceiveEmail'] = $_POST['ReceiveEmail'];			
			$data['SMSURL'] = $_POST['SMSURL'];			
			$data['SMSSender'] = $_POST['SMSSender'];
			$data['SMSUserID'] = $_POST['SMSUserID'];			
			$data['SMSPass'] = $_POST['SMSPass'];			
			$data['SMSMobile'] = $_POST['SMSMobile'];			
			$data['SMSSenderForPass'] = $_POST['SMSSenderForPass'];
			$data['WeekSelect'] = $_POST['WeekSelect'];			
			$data['TotalWeek'] = $_POST['TotalWeek'];
			$data['CreatedDate'] = date('Y-m-d H:i:s');
			$data['CreatedBy'] = $logged_in_user_details['UserID'];
			$InsertedID = $this->master_model->ManageTable($data,$tableName,$type,$getAutoID);
			$message ="Records Updated Successfully !" ;
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('InsertID'=>$InsertedID,'status' => $status, 'message' => $message,)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function GetSystemSetting_post(){
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$Requestlist = $this->api_model->GetSystemSetting();
			$status=200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($Requestlist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($message));
		}
	}

	public function accountingheadlist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$headlist = $this->master_model->Headlist($data);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($headlist));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function addcompany_post(){
		$data=$this->request->body;
		$tableName = "CompanyMst";
		$type = 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['Name']=$data['Name'];
			$datasave['CCode']=$data['CompanyCode'];
			$datasave['BankName']=$data['BankName'];
			$datasave['AccountNumber']=$data['AccountNumber'];
			$datasave['IFSCCode']=$data['IFSCCode'];
			$datasave['Status']=1;
			$datasave['IsDelete']=0;
			$response = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$response)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function updatecompany_post(){
		$data=$this->request->body;
		$tableName = "CompanyMst";
		$type = 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['Name']=$data['Name'];
			$datasave['CCode']=$data['CompanyCode'];
			$datasave['BankName']=$data['BankName'];
			$datasave['AccountNumber']=$data['AccountNumber'];
			$datasave['IFSCCode']=$data['IFSCCode'];
			$datasave['Status']=1;
			
			$response = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$response)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function deletecompany_post(){
		$data=$this->request->body;
		$tableName = "CompanyMst";
		$type = 3;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['IsDelete']=1;
			$response = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$status = 200;
			$Message = "Deleted successfully !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$response,"message"=>$Message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function addemployee_post(){
		$data=$this->request->body;
		$tableName = "UserMst";
		$type = 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['UserType']=$data['UserType'];
			$datasave['Title']=$data['Title'];
			$datasave['Name']=$data['Name'];
			$datasave['Email']=$data['Email'];
			$datasave['Phone']=$data['Phone'];
			$datasave['Password']=md5($data['Password']);
			$datasave['CreatedDate']=date("Y-m-d");
			$datasave['Status']=1;
			$datasave['IsDelete']=0;
			$datasave['IsProfileUpdate']=1;
			$datasave['CreatedBy']=$logged_in_user_details['UserID'];
			$datasave['CreatedDate']=date("Y-m-d H:i:s");
			$datasave['CustomOTP']=$data['CustomOTP'];
			$response = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			if ($response>0) {
					$tableProfile = "ProfileMst";
					$typeprofile = 1;
					$UserID=$response;
					$dataprofile['UserID']=$UserID;
					$dataprofile['ECode']=$data['ECode'];
					$dataprofile['Gender']=$data['Gender'];
					$dataprofile['BDate']=$data['BDate'];
					$dataprofile['Branch']=$data['Branch'];
					$dataprofile['Department']=$data['Department'];
					$dataprofile['CompanyID']=$data['CompanyName'];
                    $dataprofile['Designation']=$data['Designation'];
                    $dataprofile['Team']=$data['Team'];
					$dataprofile['PAN']=$data['PAN'];
					$dataprofile['Aadhar']=$data['Aadhar'];
                    $dataprofile['IsDelete']=0;
					$dataprofile['CreatedDate']=date("Y-m-d");
					$dataprofile['CountryCode']=$data['CountryCode'];
					$this->master_model->ManageTable($dataprofile,$tableProfile,$typeprofile,$AutoID);

					$currency = $data['CurrencyID'];
					if(count($currency)>0){
						$total_currency=[];
						for ($i = 0; $i < count($currency); $i++) {
							$access=array(
								"VendorID"=>$UserID,
								"CurrencyID"=>$currency[$i],
							);
							array_push($total_currency,$access);
						}
						$response1=$this->db->insert_batch('CurrencyAccess', $total_currency); 
					}
					
					$head = $data['HeadID'];
					if(count($head)>0){
						$total_head=[];
						for ($i = 0; $i < count($head); $i++) {
							$access=array(
								"VendorID"=>$UserID,
								"HeadID"=>$head[$i],
							);
							array_push($total_head,$access);
						}
						$response2=$this->db->insert_batch('HeadAccess', $total_head);
					}
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("InsertID"=>$response)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function updateemployee_post(){
		$data=$this->request->body;
		$tableName = "UserMst";
		$type = 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['UserType']=$data['UserType'];
			$datasave['Title']=$data['Title'];
			$datasave['Name']=$data['Name'];
			$datasave['Email']=$data['Email'];
			$datasave['Phone']=$data['Phone'];
			$datasave['Password']=md5($data['Password']);
			$datasave['CreatedDate']=date("Y-m-d");
			$datasave['Status']=1;
			$datasave['IsDelete']=0;
			$datasave['IsProfileUpdate']=1;
			$datasave['CreatedBy']=$logged_in_user_details['UserID'];
			$datasave['CreatedDate']=date("Y-m-d H:i:s");
			$datasave['CustomOTP']=$data['CustomOTP'];
			$response = $this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			if ($AutoID>0) {
					// $tableProfile = "ProfileMst";
					$typeprofile = 2;
					$UserID=$AutoID;
					$dataprofile['UserID']=$UserID;
					$dataprofile['ECode']=$data['ECode'];
					$dataprofile['Gender']=$data['Gender'];
					$dataprofile['BDate']=$data['BDate'];
					$dataprofile['Branch']=$data['Branch'];
					$dataprofile['Department']=$data['Department'];
					$dataprofile['CompanyID']=$data['CompanyName'];
                    $dataprofile['Designation']=$data['Designation'];
                    $dataprofile['Team']=$data['Team'];
					$dataprofile['PAN']=$data['PAN'];
					$dataprofile['Aadhar']=$data['Aadhar'];
                    $dataprofile['IsDelete']=0;
					$dataprofile['CreatedDate']=date("Y-m-d");
					$dataprofile['CountryCode']=$data['CountryCode'];
					$this->master_model->ManageProfile($dataprofile,$typeprofile,$UserID);
					
					$currency = $data['CurrencyID'];
					if(count($currency)>0){
						$this->master_model->DeleteAccessCurrency($UserID);
						$total_currency=[];
						for ($i = 0; $i < count($currency); $i++) {
							$access=array(
								"VendorID"=>$UserID,
								"CurrencyID"=>$currency[$i],
							);
							array_push($total_currency,$access);
						}
						$this->db->insert_batch('CurrencyAccess', $total_currency);
					}
					
					$head = $data['HeadID'];
					if(count($head)>0){
						$this->master_model->DeleteAccessHead($UserID);
						$total_head=[];
						

						for ($i = 0; $i < count($head); $i++) {
							$access=array(
								"VendorID"=>$UserID,
								"HeadID"=>$head[$i],
							);
							array_push($total_head,$access);
						}
					}
			}
			$status = 200;
			$message="Updated successfully !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("status"=>$status,'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function deleteemployee_post(){
		$data=$this->request->body;
		$tableName = "UserMst";
		$type = 3;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$datasave['IsDelete']=1;
			$this->master_model->ManageTable($datasave,$tableName,$type,$AutoID);
			$Message = "Deleted successfully !";
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array("message"=>$Message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	
	
}
