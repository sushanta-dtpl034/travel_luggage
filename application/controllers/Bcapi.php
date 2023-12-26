<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class Bcapi extends REST_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tokenHandler = new TokenHandler();
		$this->load->model('master_model');
		$this->load->library('authtoken');
		header('Content-Type: application/json');
	}
	
	public function getpolist_post(){
		//$data=$this->request->body;
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		// print_r($auth_token);
		// exit();
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) 
		{
			$url="https://api.businesscentral.dynamics.com/v2.0/4630396c-85d2-409f-a630-70d67fa14818/Production-IN/ODataV4/Company('Wilh%20Loesch%20India%20Pvt.%20Ltd')/API_PurchaseOrderList";
			$method="GET";
			$username="API";
			$password="YFn87VQsGKkqATtac/4omSVaTTEYm+RYQ3ZIIscTI68=";
			$result=$this->CallAPI($method, $url, $username,$password,$data1="");
			$json = json_decode($result, true);
			if(count($json)>0){
				$count = 0;
				$count1 =0;
				$i = 1;
				foreach($json['value'] as $item) {
					$PO_code=$item['No'];
					$check=$this->master_model->CheckPONumber($PO_code);
					if($check==true){
						$count1 = $i++;
						$userdata['PayCity']=$item['Pay_City'];
						$userdata['Amount']=$item['Amount'];
						$userdata['AmountVAT']=$item['GST_Amount'];
						$PO_code=$item['No'];
						$this->master_model->ManagePOVendor($userdata,2,$PO_code);
						
					}
					else{
						$VendorData = $this->master_model->GetUserVendorID($item['Vendor_Code']);
						//print_r($VendorData);
						if ($VendorData['Name']="") {
							$vendorname = "N/A";
						}else{
							$vendorname = $VendorData['Name'];
						}

						if ($VendorData['CompanyName']="") {
							$companyname = "N/A";
						}else{
							$companyname = $VendorData['CompanyName'];
						}
						$data['PONumber']=$item['No'];
						$data['VendorID']=$item['Vendor_Code'];
						$data['VendorName']=$vendorname;
						$data['PayCity']=$item['Pay_City'];
						$data['DocumentDate']=$item['Posting_Date'];
						$data['Amount']=$item['Amount'];
						$data['AmountVAT']=$item['GST_Amount'];
						$data['CName']=$companyname;
						$data['IsActive']=1;
						$this->master_model->ManagePOVendor($data,1);
					} 
					$count++;
					$message = array('msg'=>'Total "'.$count.'" Records Found "'.$count1.'" Records Updated "'.($count - $count1).'" Inserted');
					//$message = array('msg'=>'Total "'.$count.'" Records Found');
				}
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($message));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}
	
	public function getvendorlist_post(){
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$url="https://api.businesscentral.dynamics.com/v2.0/4630396c-85d2-409f-a630-70d67fa14818/Production-IN/ODataV4/Company(%27Wilh%20Loesch%20India%20Pvt.%20Ltd%27)/API_VendorList";
			$method="GET";
			$username="API";
			$password="YFn87VQsGKkqATtac/4omSVaTTEYm+RYQ3ZIIscTI68=";
			$result=$this->CallAPI($method, $url, $username,$password,$data1="");
			$json = json_decode($result, true);

			if(count($json)>0){
				$count = 0;
				$count1 =0;
				$i = 1;
				foreach($json['value'] as $item) {
					
					$client_code=$item['No'];
					$check=$this->master_model->CheckVendorCode($client_code);
					if($check==true){
						$count1 = $i++;
						$userdata['Phone']=$item['Mobile_Phone_No'];
						$userdata['Email']=$item['E_Mail'];
						$userdata['Status']=1;
						$userdata['IsDelete']=0;
						$userdata['IsProfileUpdate']=1;
						$userdata['CreatedBy']=$logged_in_user_details['UserID'];
						$userdata['CreatedDate']=date("Y-m-d H:i:s");
						$client_code=$item['No'];
						$UserID=$this->master_model->GetVendorID($client_code);
						$this->master_model->ManageUser($userdata,2,$UserID->AutoID);
						$profile = array();
						$profile['ContactPerson']=$item['Contact_Name'];
						$profile['ContactNo']=$item['Phone_No'];
						$profile['PAN']=$item['P_A_N_No'];
						$profile['GSTNo']=$item['GST_Registration_No'];
						$profile['CountryCode']='91';
						$profile['State']=$item['State_Code'];
						$profile['City']=$item['City'];
						$profile['Address1']=$item['Address'];
						$profile['Address2']=$item['Address_2'];
						$profile['Address3']='N/A';
						$profile['PostalCode']='';
						$profile['IsDelete']=0;
						$profile['CreatedDate']=date("Y-m-d H:i:s");
						$this->master_model->ManageProfile($profile,2,$UserID->AutoID);
					}
					else{
						$userdata['UserType']=4;
						$userdata['Name']=$item['Name'];
						$userdata['Phone']=$item['Mobile_Phone_No'];
						$userdata['Email']=$item['E_Mail'];
						$userdata['Status']=1;
						$userdata['IsDelete']=0;
						$userdata['IsProfileUpdate']=1;
						$userdata['CreatedBy']=$logged_in_user_details['UserID'];;
						$userdata['CreatedDate']=date("Y-m-d H:i:s");
						$userresult=$this->master_model->ManageUser($userdata,1);
						if($userresult>0){
							$profile = array();
							$profile['UserID']=$userresult;
							
							if($item['P_A_N_No'] !=""){
								$profile['PAN']=$item['P_A_N_No'];
							}
							else{
								$profile['PAN']='';
							}
	
							if($item['GST_Registration_No'] !=""){
								$profile['GSTNo']=$item['GST_Registration_No'];
							}
							else{
								$profile['GSTNo']='N/A';
							}
							$profile['CountryCode']='';
	
							if($item['City'] !=""){
								$profile['City']=$item['City'];
							}
							else{
								$profile['City']='N/A';
							}
							if($item['Contact_Name'] !=""){
								$profile['ContactPerson']=$item['Contact_Name'];
							}
							else{
								$profile['ContactPerson']='N/A';
							}
							if($item['Phone_No'] !=""){
								$profile['ContactNo']=$item['Phone_No'];
							}
							else{
								$profile['ContactNo']='N/A';
							}
	
							if($item['State_Code'] !=""){
								$profile['State']=$item['State_Code'];
							}
							else{
								$profile['State']='N/A';
							}
							if($item['Post_Code'] !=""){
								$profile['PostalCode']=$item['Post_Code'];
							}
							else{
								$profile['PostalCode']='N/A';
							}
	
							if($item['Address'] !=""){
								$profile['Address1']=$item['Address'];
							}
							else{
								$profile['Address1']='N/A';
							}
	
							if($item['Address_2'] !=""){
								$profile['Address2']=$item['Address_2'];
							}
							else{
								$profile['Address2']='N/A';
							}
							$profile['Address3']='N/A';
							$profile['VendorCode']=$client_code;
						
							$profileresult=$this->master_model->ManageProfile($profile,1);
						   
						}
					} 
					$count++;
					$message = array('msg'=>'Total "'.$count.'" Records Found "'.$count1.'" Records Updated "'.($count - $count1).'" Inserted');
				}
				
			}

			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($message));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	public function acheadbyvendorcode_post(){
		//$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) {
			$VendorCode = $logged_in_user_details['VendorCode'];
			$Head = $this->GetAcheadVendor($VendorCode);
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($Head));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}
	public function getbchead_post(){
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Auth-Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['UserID'] > 0 && $logged_in_user_details['exist'] == 1) 
		{
			$url="https://api.businesscentral.dynamics.com/v2.0/4630396c-85d2-409f-a630-70d67fa14818/Production-IN/ODataV4/Company(%27Wilh%20Loesch%20India%20Pvt.%20Ltd%27)/Chart_of_Accounts";
			$method="GET";
			$username="API";
			$password="YFn87VQsGKkqATtac/4omSVaTTEYm+RYQ3ZIIscTI68=";
			$result=$this->CallAPI($method, $url, $username,$password,$data1="");
			$json = json_decode($result, true);
			if(count($json)>0){
				$count = 0;
				$count1 =0;
				$i = 1;
				foreach($json['value'] as $item) {
					
					$HeadNo=$item['No'];
					$check=$this->master_model->CheckHeadNumber($HeadNo);
					$tableName = "HeadMst";
					$id= "";
					if($check==true){
						$count1 = $i++;
						$headdata['Head']=$item['Name'];
						$headdata['HeadNo']=$item['No'];
						$headdata['Status']=1;
						$headdata['Priority']=1;
						$HeadNo=$item['No'];
						$Head=$this->master_model->GetHeadNo($HeadNo);
						$head=$this->master_model->ManageTable($headdata,$tableName,2,$Head->AutoID);
					}
					else{
						$headdata['Head']=$item['Name'];
						$headdata['HeadNo']=$item['No'];
						$headdata['Status']=1;
						$headdata['Priority']=1;
						$userresult=$this->master_model->ManageTable($headdata,$tableName,1,$id);
					} 
					$count++;
					$message = array('msg'=>'Total "'.$count.'" Records Found "'.$count1.'" Records Updated "'.($count - $count1).'" Inserted');
				}
			}
			$status = 200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($message));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	function CallAPI($method, $url, $username,$password,$data="")
	{
		$curl = curl_init();
		switch ($method)
		{
		case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);
			if ($data)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
		case "PUT":
			curl_setopt($curl, CURLOPT_PUT, 1);
			break;
		default:
			if ($data)
				$url = sprintf("%s?%s", $url, http_build_query($data));
		}
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_PROXYPORT, 3128);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		$response = curl_exec($curl);
		if ($response) {
		$result=$response;
		}
		else {
		echo 'An error has occurred: ' . curl_error($curl);
		}
		return $response;
		curl_close($curl);
	}

	public function GetAcheadVendor($VendorCode){
		$url="https://api.businesscentral.dynamics.com/v2.0/4630396c-85d2-409f-a630-70d67fa14818/Production-IN/ODataV4/Company('Wilh%20Loesch%20India%20Pvt.%20Ltd')/StandardPurchaseLine";
		$method="GET";
		$username="API";
		$password="YFn87VQsGKkqATtac/4omSVaTTEYm+RYQ3ZIIscTI68=";
		$result=$this->CallAPI($method, $url, $username,$password,$data1="");
		$json = json_decode($result, true);
		$resources = $json['value'];
		foreach ($resources as $rkey => $resource){
			if ($resource['Vendor_No_'] == $VendorCode ){
				$vendordata[] = $resource;
			} 
		}	
		return $vendordata;
	}
}
