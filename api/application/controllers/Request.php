<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class Request extends REST_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tokenHandler = new TokenHandler();
		$this->load->model('master_model');
		$this->load->model('requestmodel');
		$this->load->model('Commonmodel');
		$this->load->library(array('form_validation', 'Authtoken'));
		header('Content-Type: application/json');
	}
	public function requestlist_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$UserID = $logged_in_user_details['UserID'];
			if ($logged_in_user_details['UserType']==2) {
				$RequestList = $this->master_model->RequestList($data);
			}else{
				$RequestList = $this->master_model->RequestUserList($data,$UserID);
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($RequestList));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function userdetails_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$UserID = $logged_in_user_details['UserID'];
			if ($logged_in_user_details['UserType']>2) {
				$RequestList = $this->requestmodel->last_request_id($UserID);
			}else{
				$RequestList = "No Data Found ! Please login to User";
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($RequestList));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function requestdetailsbyid_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$RequestList['Request_details'] = $this->requestmodel->RequestDetailsByID($data['ReqID']);
			$RequestList['Bill_details'] = $this->requestmodel->ManageBillDetailsByID($data['ReqID']);
			$RequestList['History'] = $this->requestmodel->ManageRemarksByID($data['ReqID']);
			$RequestList['Attachment_Files'] = $this->requestmodel->ManageFilesByID($data['ReqID']);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($RequestList));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}


	function convertCurrency($amount,$taxamount,$from_currency,$to_currency){
		$apikey = '28109453e70c4d10b26ce33cb7c4818a';
		$from_Currency = urlencode($from_currency);
		$to_Currency = urlencode($to_currency);
		$query =  "{$from_Currency}_{$to_Currency}";
		// change to the free URL if you're using the free version
		$json = file_get_contents("https://api.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
		$obj = json_decode($json, true);
		$val = floatval($obj["$query"]);
		$total = $val * ($amount+$taxamount);
		$exchangeRate= number_format($total, 3, '.', '');
		$convertedAmount = ($amount+$taxamount)*$val;
		$data = array('exhangeRate' => $val,'convertedAmount' =>$convertedAmount,'fromCurrency' => strtoupper($from_Currency), 'toCurrency' => strtoupper($to_Currency));
		//echo json_encode($data);
		return $convertedAmount;
	}

	function setindex_prefix($index_assigned,$company_name)
	{
			switch(strlen($index_assigned))
			{
				case 1:
					$new_index_assigned = "000".$index_assigned;
					break;
				case 2:
					$new_index_assigned = "00".$index_assigned;
				break;
				case 3:
					$new_index_assigned = "0".$index_assigned;
					break;
				default:
					$new_index_assigned = $index_assigned;
			}
			$date=date("Y");
			$month=date("m");
			$format="$company_name".$date.$month.$new_index_assigned;
			return $format;
	}

	public function createrequest_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
			if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
						
						$last_request_id = $this->requestmodel->last_request_no();
						$form_id=$last_request_id->AutoID+1;
						//die();
						$ReqNo=$this->setindex_prefix($form_id,'DTPL');
						$data['UserID']=$logged_in_user_details['UserID'];
						$data['ReqNo']=$ReqNo;
						$data['Name']=$_POST['Name'];					
						$data['Email']=$_POST['Email'];
						$data['Phone']=$_POST['Phone'];
						$data['CompanyName']=$_POST['CompanyName'];
						$data['Address']=$_POST['Address'];
						$data['PinCode']=$_POST['PinCode'];
						$data['GSTNo']=$_POST['GSTNo'];
						$data['PANNo']=$_POST['PANNo'];
						$data['MSMENumber']=$_POST['MSMENumber'];
						$data['PayeeAccountName']=$_POST['PayeeAccountName'];
						$data['AccountNumber']=$_POST['AccountNumber'];
						$data['BankName']=$_POST['BankName'];
						$data['IFSCCode']=$_POST['IFSCCode'];
						$data['CreatedDate']=date("Y-m-d H:i:s");
						$data['Status']=0;
						$RequestID=$this->requestmodel->ManageRequest($data);
						
					if($RequestID>0){
						$remark['ReqID']=$RequestID;
						$remark['UserID']=$logged_in_user_details['UserID'];
						$remark['Remark']='Pending';
						$remark['Status']=0;
						$remark['CreatedDate']=date("Y-m-d H:i:s");
						$remark = $this->requestmodel->create_remark($remark);
						$ReqID=$RequestID;
						$BillNumber = $_POST['BillArray'];
						foreach ($BillNumber as $key => $value) {
							$billData[]= json_decode($value);
						}	
						foreach ($billData as $keyr => $valuer) {
							$Currency = $valuer->CurrencyID;
							$amount = $valuer->Amount;
							$taxamount = $valuer->taxAmount;
							$CurrencySymbol=$this->requestmodel->getCurrencyNameByID($Currency);
							$from_currency = $CurrencySymbol;
							$to_currency = 'INR';
							if($from_currency == $to_currency) {
								$converted_currency=$amount+$taxamount;
							}
							else{
								$converted_currency= $this->convertCurrency($amount,$taxamount,$from_currency, $to_currency);
							}
							$total_bill[]=array(
								"ReqID"=>$ReqID,
								"Status"=>0,
								"BillNumber"=>$valuer->BillNumber,
								"BillDate"=>$valuer->BillDate,
								"ConvertedAmount"=>$converted_currency,
								"FinalAmount"=>$converted_currency,
								"Amount"=>$valuer->Amount,
								"taxAmount"=>$valuer->taxAmount,
								/* "PONumber"=>$PONumber[$i], */
								"POID"=>$valuer->POID,
								"BilledCompany"=>$valuer->BilledCompany,
								"ServiceProvided"=>$valuer->ServiceProvided,
								"ContactPerson"=>$valuer->ContactPerson,
								"PaymentBy"=>$valuer->PaymentBy,
								"CurrencyID"=>$valuer->CurrencyID,
								"Narration"=>$valuer->Narration,
								"Deduction"=>0
							);
							
						}
						
					$this->db->insert_batch('BillDetails', $total_bill); 
					//Load PHPMailer library
					$response=[];
					$response['ReqID']=$RequestID;
					$ReqData=$this->requestmodel->GetLastRequest($RequestID);
					$response['LastReqNo']=$ReqData->ReqNo;
								
					$status = 200;
					$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response));
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

	public function podetailsbyid_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$PO_num = $data['POID'];
			$orginal_amount=$this->requestmodel->GetPODetailsByNo($PO_num);
			$bill_sum_of_po=$this->requestmodel->GetBillAmountByPO($PO_num);
			$bill_sum_of_tax=$this->requestmodel->GetTaxAmountByPO($PO_num);
			$final =str_replace( ',','',$orginal_amount->AmountVAT)-($bill_sum_of_po + $bill_sum_of_tax);

			// print_r($orginal_amount);
			// exit();
			$days =$orginal_amount->PaymentBy;
			
			if($final< $orginal_amount->AmountVAT)
			{
				$array = array('amount'=>'0.00','taxAmount'=>'0.00','days'=>$days);
			}
			else{
				$array = array('amount'=>$final,'taxAmount'=>$bill_sum_of_tax,'days'=>$days);
			}
			

		//echo json_encode($array);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($array));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function servicebyheadno_post(){
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$HeadID = $data['HeadNo'];
			// print_r($HeadID);
			// exit();
			$response = $this->requestmodel->getServiceByHead($HeadID);
			if(!$response){
				$status = 404;
				$response= ["error"=>"Record not found"];
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//push notification
	public function pushNotificationRegistration_post() {
		$data=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$this->form_validation->set_data($data);
				$this->form_validation->set_rules('fcm_token', 'Fcm Token', 'required|trim');
				$this->form_validation->set_rules('device_token', 'Device Token', 'required|trim');
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();
					return $this->set_response(["status"=>406,"errors"=>$errors], 406);                
				}else{
					$userdata['message'] = "User device registered successfully";
					$userdata['status']=201;

					//push notification
					$notification_data['FcmToken'] 		=$data['fcm_token'];
					$notification_data['DeviceToken'] 	=$data['device_token'];
					$notification_data['UserID'] 		=$arrdata['AutoID'];
					// $notification_data['UserMobile'] 	=$arrdata['Mobile'];
					$response =$this->Commonmodel->common_insert('NotificationMST',$notification_data);
					if($response){
						return $this->set_response($userdata, REST_Controller::HTTP_OK);			
					}else{
						return $this->set_response(["status"=>500,"message"=>"Something wents wrong. Try Again. "], 500);
					}
							
				}


			}catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or old password / new password not Found";
			$result['status']=false;
			return $this->set_response($result, 400);
		}
		
		

	}
	//logout API
	public function logout_get(){
		//delete all session
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$query = $this->db->query("DELETE FROM NotificationMST WHERE UserID=$userid");
        		if($query){
					session_destroy();
					$this->output->set_output(json_encode(array('status'=>true,'msg'=>'log Out successfully')));
				}
			}catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or old password / new password not Found";
			$result['status']=false;
			return $this->set_response($result, 400);
		}
	}
	
}
