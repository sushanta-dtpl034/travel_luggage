<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class Assetmaster extends REST_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tokenHandler = new TokenHandler();
		$this->load->model('Assetmaster_model');
		$this->load->model('api_model');
		$this->load->model('requestmodel');
		$this->load->library('authtoken');
		header('Content-Type: application/json');
	}

    //View Material Condition
    public function GetMaterialConditionList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();

		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
	
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->MaterialConditionList($data);
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


    //Add Material Condition
    public function AddMaterialCondition_post(){
		$data=$this->request->body;
		$tableName= 'MaterialMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1) {
			$data['IsDelete']      = 0;
			$data['CreatedDate']   = date('Y-m-d H:i:s');
			$data['ConditionName'] = trim($data['ConditionName']);
			$data['CreatedBy']     = $logged_in_user_details['AutoID'];
			$data['ParentID']      = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckMaterialCondition(trim($data['ConditionName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Material Condition already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Material Condition
	public function UpdateMaterialCondition_post(){
		$data=$this->request->body;
		$tableName= 'MaterialMST';
		$type= 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['ConditionName'] = $data['ConditionName'];
			$dataupdate['IsDelete']      = 0;
			$dataupdate['ModifyDate']    = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']      = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']      = $logged_in_user_details['ParentID'];
			$check = $this->Assetmaster_model->CheckMaterialCondition(trim($data['ConditionName']),$AutoID);

			if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckMaterialCondition(trim($data['ConditionName']),$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Material Condition already exist please update records!" ;
            }else{
				$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
				$status=200;
				$message ="Records Updated Successfully !" ;
			}
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Material Condition
	public function DeleteMaterialCondition_post(){
		$data=$this->request->body;
		$tableName= 'MaterialMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}



	//View Asset Type List
    public function GetAssetTypeList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->AssetTypeList($data);
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

	//Add Asset Type
    public function AddAssetType_post(){
		$data=$this->request->body;
		$tableName= 'AssetTypeMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$data['IsDelete']     = 0;
			$data['CreatedDate']  = date('Y-m-d H:i:s');
			$data['AsseTypeName'] = trim($data['AsseTypeName']);
			$data['CreatedBy']    = $logged_in_user_details['AutoID'];
			$data['ParentID']     = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckAssetType(trim($data['AsseTypeName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Asset Type already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Asset Type
	public function UpdateAssetType_post(){
		$data=$this->request->body;
		$tableName= 'AssetTypeMST';
		$type= 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['AsseTypeName'] = $data['AsseTypeName'];
			$dataupdate['IsDelete']     = 0;
			$dataupdate['ModifyDate']   = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']     = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']     = $logged_in_user_details['ParentID'];
			$check = $this->Assetmaster_model->CheckAssetType(trim($dataupdate['AsseTypeName'],$AutoID));

			if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckAssetType(trim($data['AsseTypeName']),$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Asset Type already exist please update records!" ;
			}else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Updated Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Asset Type
	public function DeleteAssetType_post(){
		$data=$this->request->body;
		$tableName= 'AssetTypeMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Measurement List
    public function GetMeasurementList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->MeasurementList($data);
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

	//Add Measurement
    public function AddMeasurement_post(){
		$data=$this->request->body;
		$tableName= 'UomMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$data['IsDelete']     = 0;
			$data['CreatedDate']  = date('Y-m-d H:i:s');
			$data['UomName']      = trim($data['UomName']);
			$data['UomShortName'] = trim($data['UomShortName']);
			$data['CreatedBy']    = $logged_in_user_details['AutoID'];
			$data['ParentID']     = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckMeasurement(trim($data['UomName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Measurement already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Measurement
	public function UpdateMeasurement_post(){
		$data=$this->request->body;
		$tableName= 'UomMST';
		$type= 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['UomName']      = $data['UomName'];
			$dataupdate['UomShortName'] = $data['UomShortName'];
			$dataupdate['IsDelete']     = 0;
			$dataupdate['ModifyDate']   = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']     = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']     = $logged_in_user_details['ParentID'];

			
			if ($data['UomName'] == $data['oldUomName']) {
				$check=false;
			}else{
				$check = $this->Assetmaster_model->CheckMeasurement(trim($dataupdate['UomName'],$AutoID));
			}
			if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckMeasurement(trim($data['UomName']),$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Measurement already exist please update records!" ;
			}else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Updated Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Measurement
	public function DeleteMeasurement_post(){
		$data=$this->request->body;
		$tableName= 'UomMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Asset Category List
    public function GetAssetCategoryList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->AssetCategoryList($data);
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

	//Add Asset Category
    public function AddAssetCategory_post(){
		//$data=$this->request->body;
		$tableName= 'AssetCatMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			
			$data['IsDelete']    = 0;
			$data['CreatedDate'] = date('Y-m-d H:i:s');
			$data['AsseCatName'] = $_POST['AsseCatName'];
			$data['AssetType']   = $_POST['AssetType'];
		    $data['CreatedBy']   = $logged_in_user_details['AutoID'];
			$data['ParentID']     = $logged_in_user_details['ParentID'];
			//print_r($data);exit();
			$check = $this->Assetmaster_model->CheckAssetCategory(trim($data['AsseCatName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Asset Category already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
			 	$response = array();
		   	    //$server_url = UPLOAD_CONSTANT_URL;
			    $upload_dir = '../upload/asset_cat/';
		
				if ($InsertedID) {

					if(!empty($_FILES['AssetCatIMG']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["AssetCatIMG"]["name"];
						    $file_tmp_name = $_FILES["AssetCatIMG"]["tmp_name"];
						    $error = $_FILES["AssetCatIMG"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
							    //echo 'error';
							    $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "The file Extension Not Allowed!"
						        );
							}else{

								if($error > 0){
						        $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "Error uploading the file!"
						        );
							    }else 
							    {
						        $random_name = rand(1000,1000000)."-".$file_name;
						        $upload_name = $upload_dir.strtolower($random_name);
						        $upload_name = preg_replace('/\s+/', '-', $upload_name);
						        $uploadfile  = str_replace("../","",$upload_name);
						     	
						     	$data['AssetCatIMG'] = $uploadfile;
							    //print_r($data);exit();
						        if(move_uploaded_file($file_tmp_name , $upload_name)) {
						            $response = array(
						                "status"  => "success",
						                "error"   => false,
						                "message" => "File uploaded successfully",
						                "url"     => $uploadfile
						            );
						        $this->Assetmaster_model->ManageCRUD($data,$tableName,2,$InsertedID);
						        }else
						        {
						            $response = array(
						                "status"  => "error",
						                "error"   => true,
						                "message" => "Error uploading the file!"
						            );
						        }
						    }

						}

					}else{
					    $response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "No file was sent!"
					    );
					}
				}else{
					$response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "id Not To be null!"
					    );

				}

			$status=200;
			$message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Asset Category
	public function UpdateAssetCategory_post(){
		//$data=$this->request->body;
		$tableName= 'AssetCatMST';
		$type= 2;
		if (!empty($_POST['AutoID'])) {
			$AutoID = $_POST['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['AsseCatName'] = $_POST['AsseCatName'];
			$dataupdate['AssetType']   = $_POST['AssetType'];
			$dataupdate['IsDelete']    = 0;
			$dataupdate['ModifyDate']  = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']    = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']    = $logged_in_user_details['ParentID'];
			if ($AutoID>0) {
				$check = $this->Assetmaster_model->CheckAssetCategory($dataupdate['AsseCatName'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Asset Category already exist please update records!" ;
			}else{
				//print_r($dataupdate);exit();
                $InsertedID =$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
				$response = array();
		   	    //$server_url = UPLOAD_CONSTANT_URL;
			    $upload_dir = '../upload/asset_cat/';
		
				if ($AutoID) {

					if(!empty($_FILES['AssetCatIMG']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["AssetCatIMG"]["name"];
						    $file_tmp_name = $_FILES["AssetCatIMG"]["tmp_name"];
						    $error = $_FILES["AssetCatIMG"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
							    //echo 'error';
							    $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "The file Extension Not Allowed!"
						        );
							}else{

								if($error > 0){
						        $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "Error uploading the file!"
						        );
							    }else 
							    {
						        $random_name = rand(1000,1000000)."-".$file_name;
						        $upload_name = $upload_dir.strtolower($random_name);
						        $upload_name = preg_replace('/\s+/', '-', $upload_name);
						        $uploadfile  = str_replace("../","",$upload_name);
						     	
						     	$dataupdate['AssetCatIMG'] = $uploadfile;
							    //print_r($dataupdate);exit();
						        if(move_uploaded_file($file_tmp_name , $upload_name)) {
						            $response = array(
						                "status"  => "success",
						                "error"   => false,
						                "message" => "File uploaded successfully",
						                "url"     => $uploadfile
						            );
						        $this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
						        }else
						        {
						            $response = array(
						                "status"  => "error",
						                "error"   => true,
						                "message" => "Error uploading the file!"
						            );
						        }
						    }

						}

					}else{
					    $response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "No file was sent!"
					    );
					}
				}else{
					$response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "id Not To be null!"
					    );

				}	
                $status=200;
                $message ="Records Updated Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Asset Category
	public function DeleteAssetCategory_post(){
		$data=$this->request->body;
		$tableName= 'AssetCatMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		// print_r($auth_token);exit();
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Company List
    public function GetCompanyList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->CompanyList($data);
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

	//Add Company
    public function AddCompany_post(){
		//$data=$this->request->body;
		$tableName= 'CompanyMst';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			
			$data['IsDelete']       = 0;
			$data['CreatedDate']    = date('Y-m-d H:i:s');
			$data['CompanyName']    = $_POST['CompanyName'];
			$data['CompanCurrency'] = $_POST['CompanCurrency'];
			$data['CompanyAddress'] = $_POST['CompanyAddress'];
			$data['BankDetails']    = $_POST['BankDetails'];
			$data['IsCompany']      = $_POST['IsCompany'];
			$data['CreatedBy']      = $logged_in_user_details['AutoID'];
			$data['ParentID']       = $logged_in_user_details['ParentID'];
			//print_r($data);exit();
			$check = $this->Assetmaster_model->CheckCompany(trim($data['CompanyName'],$AutoID));
			
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Company already exist please update records!" ;
            }else{
				
				
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
			 	$response = array();
		   	    //$server_url = UPLOAD_CONSTANT_URL;
			    $upload_dir = '../upload/company_logo/';
		
				if ($InsertedID) {

					if(!empty($_FILES['CompanyLogo']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["CompanyLogo"]["name"];
						    $file_tmp_name = $_FILES["CompanyLogo"]["tmp_name"];
						    $error = $_FILES["CompanyLogo"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
							    //echo 'error';
							    $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "The file Extension Not Allowed!"
						        );
							}else{

								if($error > 0){
						        $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "Error uploading the file!"
						        );
							    }else 
							    {
						        $random_name = rand(1000,1000000)."-".$file_name;
						        $upload_name = $upload_dir.strtolower($random_name);
						        $upload_name = preg_replace('/\s+/', '-', $upload_name);
						        $uploadfile  = str_replace("../","",$upload_name);
						     	
						     	$data['CompanyLogo'] = $uploadfile;
							    //print_r($data);exit();
						        if(move_uploaded_file($file_tmp_name , $upload_name)) {
						            $response = array(
						                "status"  => "success",
						                "error"   => false,
						                "message" => "File uploaded successfully",
						                "url"     => $uploadfile
						            );
						        $this->Assetmaster_model->ManageCRUD($data,$tableName,2,$InsertedID);
						        }else
						        {
						            $response = array(
						                "status"  => "error",
						                "error"   => true,
						                "message" => "Error uploading the file!"
						            );
						        }
						    }

						}

					}else{
					    $response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "No file was sent!"
					    );
					}

					if(!empty($_FILES['CompanyStamp']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["CompanyStamp"]["name"];
						    $file_tmp_name = $_FILES["CompanyStamp"]["tmp_name"];
						    $error = $_FILES["CompanyStamp"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
							    //echo 'error';
							    $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "The file Extension Not Allowed!"
						        );
							}else{

								if($error > 0){
						        $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "Error uploading the file!"
						        );
							    }else 
							    {
						        $random_name = rand(1000,1000000)."-".$file_name;
						        $upload_name = $upload_dir.strtolower($random_name);
						        $upload_name = preg_replace('/\s+/', '-', $upload_name);
						        $uploadfile  = str_replace("../","",$upload_name);
						     	
						     	$data['CompanyStamp'] = $uploadfile;
							    //print_r($data);exit();
						        if(move_uploaded_file($file_tmp_name , $upload_name)) {
						            $response = array(
						                "status"  => "success",
						                "error"   => false,
						                "message" => "File uploaded successfully",
						                "url"     => $uploadfile
						            );
						        $this->Assetmaster_model->ManageCRUD($data,$tableName,2,$InsertedID);
									if ($data['IsCompany'] == 1) {
										$res1=$this->Assetmaster_model->disablecompany($InsertedID);	
									}
						        }else
						        {
						            $response = array(
						                "status"  => "error",
						                "error"   => true,
						                "message" => "Error uploading the file!"
						            );
						        }
						    }

						}

					}else{
					    $response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "No file was sent!"
					    );
					}


				}else{
					$response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "id Not To be null!"
					    );

				}

			   $status=200;
			   $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Company
    public function UpdateCompany_post(){
		//$data=$this->request->body;
		$tableName= 'CompanyMst';
		$type= 2;
		if (!empty($_POST['AutoID'])) {
			$AutoID = $_POST['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['CompanyName']    = $_POST['CompanyName'];
			$dataupdate['CompanCurrency'] = $_POST['CompanCurrency'];
			$dataupdate['CompanyAddress'] = $_POST['CompanyAddress'];
			$dataupdate['IsCompany']      = $_POST['IsCompany'];
			$dataupdate['BankDetails']    = $_POST['BankDetails'];
			$dataupdate['IsDelete']       = 0;
			$dataupdate['ModifyDate']     = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']       = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']       = $logged_in_user_details['ParentID'];
			if ($AutoID>0) {
				$check = $this->Assetmaster_model->CheckCompany($dataupdate['CompanyName'],$AutoID);
			}
			if($check==true){
				$InsertedID = "";
				$status=400;
				$message ="Company already exist please update records!" ;
			}else{
				//print_r($dataupdate);exit();
				$InsertedID =$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
				if ($dataupdate['IsCompany'] == 1) {
					$res1=$this->Assetmaster_model->disablecompany($AutoID);	
				}
				$response = array();
				//$server_url = UPLOAD_CONSTANT_URL;
				$upload_dir = '../upload/company_logo/';
		
				if ($AutoID) {

					if(!empty($_FILES['CompanyLogo']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["CompanyLogo"]["name"];
							$file_tmp_name = $_FILES["CompanyLogo"]["tmp_name"];
							$error = $_FILES["CompanyLogo"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
								//echo 'error';
								$response = array(
									"status"  => "error",
									"error"   => true,
									"message" => "The file Extension Not Allowed!"
								);
							}else{

								if($error > 0){
								$response = array(
									"status"  => "error",
									"error"   => true,
									"message" => "Error uploading the file!"
								);
								}else 
								{
								$random_name = rand(1000,1000000)."-".$file_name;
								$upload_name = $upload_dir.strtolower($random_name);
								$upload_name = preg_replace('/\s+/', '-', $upload_name);
								$uploadfile  = str_replace("../","",$upload_name);
								
								$dataupdate['CompanyLogo'] = $uploadfile;
								//print_r($dataupdate);exit();
								if(move_uploaded_file($file_tmp_name , $upload_name)) {
									$response = array(
										"status"  => "success",
										"error"   => false,
										"message" => "File uploaded successfully",
										"url"     => $uploadfile
									);
								$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
								}else
								{
									$response = array(
										"status"  => "error",
										"error"   => true,
										"message" => "Error uploading the file!"
									);
								}
							}

						}

					}else{
						$response = array(
							"status"  => "error",
							"error"   => true,
							"message" => "No file was sent!"
						);
					}

					if(!empty($_FILES['CompanyStamp']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["CompanyStamp"]["name"];
							$file_tmp_name = $_FILES["CompanyStamp"]["tmp_name"];
							$error = $_FILES["CompanyStamp"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
								//echo 'error';
								$response = array(
									"status"  => "error",
									"error"   => true,
									"message" => "The file Extension Not Allowed!"
								);
							}else{

								if($error > 0){
								$response = array(
									"status"  => "error",
									"error"   => true,
									"message" => "Error uploading the file!"
								);
								}else 
								{
								$random_name = rand(1000,1000000)."-".$file_name;
								$upload_name = $upload_dir.strtolower($random_name);
								$upload_name = preg_replace('/\s+/', '-', $upload_name);
								$uploadfile  = str_replace("../","",$upload_name);
								
								$dataupdate['CompanyStamp'] = $uploadfile;
								//print_r($dataupdate);exit();
								if(move_uploaded_file($file_tmp_name , $upload_name)) {
									$response = array(
										"status"  => "success",
										"error"   => false,
										"message" => "File uploaded successfully",
										"url"     => $uploadfile
									);
								$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
							
								}else
								{
									$response = array(
										"status"  => "error",
										"error"   => true,
										"message" => "Error uploading the file!"
									);
								}
							}

						}

					}else{
						$response = array(
							"status"  => "error",
							"error"   => true,
							"message" => "No file was sent!"
						);
					}

				}else{
					$response = array(
							"status"  => "error",
							"error"   => true,
							"message" => "id Not To be null!"
						);

				}	
				$status=200;
				$message ="Records Updated Successfully !" ;
			}
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
    }

	//Delete Company
	public function DeleteCompany_post(){
		$data=$this->request->body;
		$tableName= 'CompanyMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}


	//View Asset User List
    public function GetAssetUserList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->AssetUserList($data);
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

	//Add Asset User
    public function AddAssetUser_post(){
		//$data=$this->request->body;
		$tableName= 'RegisterMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			
			$data['IsDelete']     = 0;
			$data['CreatedDate']  = date('Y-m-d H:i:s');
			$data['Name']         = $_POST['Name'];
			$data['Email']        = $_POST['Email'];
			$data['Mobile']       = $_POST['Mobile'];
			$data['EmployeeCode'] = $_POST['EmployeeCode'];
			$data['UserName']     = $_POST['UserName'];
			$data['Password']     = password_hash($_POST['Password'],PASSWORD_DEFAULT);
			$data['isActive']     = $_POST['isActive'];
			$data['IsAdmin']      = $_POST['IsAdmin'];
			$data['Isauditor']    = $_POST['Isauditor'];
			$data['issupervisor'] = $_POST['issupervisor'];
			$data['CreatedBy']    = $logged_in_user_details['AutoID'];
			$data['ParentID']     = $logged_in_user_details['ParentID'];
			$check = $this->Assetmaster_model->CheckAssetUser(trim($data['Name'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Asset User already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
			 	$response = array();
		   	    //$server_url = UPLOAD_CONSTANT_URL;
			    $upload_dir = '../upload/profile/';
		
				if ($InsertedID) {

					if(!empty($_FILES['ProfileIMG']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["ProfileIMG"]["name"];
						    $file_tmp_name = $_FILES["ProfileIMG"]["tmp_name"];
						    $error = $_FILES["ProfileIMG"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
							    //echo 'error';
							    $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "The file Extension Not Allowed!"
						        );
							}else{

								if($error > 0){
						        $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "Error uploading the file!"
						        );
							    }else 
							    {
						        $random_name = rand(1000,1000000)."-".$file_name;
						        $upload_name = $upload_dir.strtolower($random_name);
						        $upload_name = preg_replace('/\s+/', '-', $upload_name);
						        $uploadfile  = str_replace("../","",$upload_name);
						     	
						     	$data['ProfileIMG'] = $uploadfile;
							    //print_r($data);exit();
						        if(move_uploaded_file($file_tmp_name , $upload_name)) {
						            $response = array(
						                "status"  => "success",
						                "error"   => false,
						                "message" => "File uploaded successfully",
						                "url"     => $uploadfile
						            );
						        $this->Assetmaster_model->ManageCRUD($data,$tableName,2,$InsertedID);
						        }else
						        {
						            $response = array(
						                "status"  => "error",
						                "error"   => true,
						                "message" => "Error uploading the file!"
						            );
						        }
						    }

						}

					}else{
					    $response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "No file was sent!"
					    );
					}
				}else{
					$response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "id Not To be null!"
					    );

				}

			$status=200;
			$message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Asset User
	public function UpdateAssetUser_post(){
		//$data=$this->request->body;
		$tableName= 'RegisterMST';
		$type= 2;
		if (!empty($_POST['AutoID'])) {
			$AutoID = $_POST['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['Name']         = $_POST['Name'];
			$dataupdate['Email']        = $_POST['Email'];
			$dataupdate['Mobile']       = $_POST['Mobile'];
			$dataupdate['EmployeeCode'] = $_POST['EmployeeCode'];
			$dataupdate['UserName']     = $_POST['UserName'];
			$dataupdate['Password']     = password_hash($_POST['Password'],PASSWORD_DEFAULT);
			$dataupdate['isActive']     = $_POST['isActive'];
			$dataupdate['IsAdmin']      = $_POST['IsAdmin'];
			$dataupdate['Isauditor']    = $_POST['Isauditor'];
			$dataupdate['issupervisor'] = $_POST['issupervisor'];
			$dataupdate['IsDelete']     = 0;
			$dataupdate['ModifyDate']   = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']     = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']     = $logged_in_user_details['ParentID'];
            if ($AutoID>0) {
				$check = $this->Assetmaster_model->CheckAssetUser($dataupdate['Name'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Asset User already exist please update records!" ;
			}else{
				//print_r($dataupdate);exit();
                $InsertedID =$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
				$response = array();
		   	    //$server_url = UPLOAD_CONSTANT_URL;
			    $upload_dir = '../upload/profile/';
		
				if ($AutoID) {

					if(!empty($_FILES['ProfileIMG']['name']))
					{
							$allowed = array('pdf','jpg','jpeg','png');
							$file_name = $_FILES["ProfileIMG"]["name"];
						    $file_tmp_name = $_FILES["ProfileIMG"]["tmp_name"];
						    $error = $_FILES["ProfileIMG"]["error"];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							if (!in_array($ext, $allowed)) {
							    //echo 'error';
							    $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "The file Extension Not Allowed!"
						        );
							}else{

								if($error > 0){
						        $response = array(
						            "status"  => "error",
						            "error"   => true,
						            "message" => "Error uploading the file!"
						        );
							    }else 
							    {
						        $random_name = rand(1000,1000000)."-".$file_name;
						        $upload_name = $upload_dir.strtolower($random_name);
						        $upload_name = preg_replace('/\s+/', '-', $upload_name);
						        $uploadfile  = str_replace("../","",$upload_name);
						     	
						     	$dataupdate['ProfileIMG'] = $uploadfile;
							    //print_r($dataupdate);exit();
						        if(move_uploaded_file($file_tmp_name , $upload_name)) {
						            $response = array(
						                "status"  => "success",
						                "error"   => false,
						                "message" => "File uploaded successfully",
						                "url"     => $uploadfile
						            );
						        $this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
						        }else
						        {
						            $response = array(
						                "status"  => "error",
						                "error"   => true,
						                "message" => "Error uploading the file!"
						            );
						        }
						    }

						}

					}else{
					    $response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "No file was sent!"
					    );
					}
				}else{
					$response = array(
					        "status"  => "error",
					        "error"   => true,
					        "message" => "id Not To be null!"
					    );

				}	
                $status=200;
                $message ="Records Updated Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Asset User
	public function DeleteAssetUser_post(){
		$data=$this->request->body;
		$tableName= 'RegisterMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete AssetUser Image
	public function DeleteAssetUserImage_post(){
		$data=$this->request->body;
		$tableName= 'RegisterMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Sub Category List
    public function GetSubCategoryList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->SubCategoryList($data,$logged_in_user_details);
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

	//Add Sub Category
    public function AddSubCategory_post(){
		//$data=$this->request->body;
		$tableName= 'AssetSubcatMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			
			// $data['IsDelete']             = 0;
			$data['CreatedDate']          = date('Y-m-d H:i:s');
			$data['AssetCatName']         = $_POST['AssetCatName'];
			$data['AssetSubcatName']      = $_POST['AssetSubcatName'];
			$data['Measurement']          = $_POST['Measurement'];
			$data['NumberOfPicture']      = $_POST['NumberOfPicture'];
			$data['titleStatus']          = $_POST['titleStatus'];
			$data['VerificationInterval'] = $_POST['VerificationInterval'];
			$data['DepreciationRate']     = $_POST['DepreciationRate'];
			$data['auditor']              = $_POST['auditor'];
			$data['CreatedBy']            = $logged_in_user_details['AutoID'];
			$data['ParentID']             = $logged_in_user_details['ParentID'];
			$check = $this->Assetmaster_model->CheckSubCategory(trim($data['AssetSubcatName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Sub Category already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);
				//print_r($InsertedID);die();	
		
				if ($InsertedID>0) {
			
					$config['upload_path']   = '../upload/asset_subcat/'; 
					$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
			        if(!empty($_FILES['ImageName'])){
                      
						$picture = [];

						$picture_count = count($_FILES['ImageName']['name']);
			            for($p=0;$p<$picture_count;$p++){

							if(!empty($_FILES['ImageName']['name'][$p])){
							//print_r($_FILES['ImageName']['name']);die();
					
								$_FILES['file']['name']     = $_FILES['ImageName']['name'][$p];
								$_FILES['file']['type']     = $_FILES['ImageName']['type'][$p];
								$_FILES['file']['tmp_name'] = $_FILES['ImageName']['tmp_name'][$p];
								$_FILES['file']['error']    = $_FILES['ImageName']['error'][$p];
								$_FILES['file']['size']     = $_FILES['ImageName']['size'][$p];
				
					
								if($this->upload->do_upload('file')){
									$pictureData = $this->upload->data();
									$pic_filename = $pictureData['file_name'];

									$picdata = array(
										'AssetID'    =>$AutoID,
										'ImageName'  =>$pic_filename,
										'DocType'    =>2,
										'CreatedBy'  =>$logged_in_user_details['AutoID'],
										'CreatedDate'=>date('Y-m-d'),
										'IsDelete'   =>0
									);
									$picid = $this->Assetmaster_model->ManageCRUD($picdata,'AssetSubcatFileMst',$type,$InsertedID);
								}
							}
			            }
			        } 
				}
			}
			$status=200;
			$message ="Records Inserted Successfully !" ;
            
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Sub Category
	public function UpdateSubCategory_post(){
		//$data=$this->request->body;
		$tableName= 'AssetSubcatMST';
		$type= 2;
		if (!empty($_POST['AutoID'])) {
			$AutoID = $_POST['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['AssetCatName']         = $_POST['AssetCatName'];
			$dataupdate['AssetSubcatName']      = $_POST['AssetSubcatName'];
			$dataupdate['Measurement']          = $_POST['Measurement'];
			$dataupdate['NumberOfPicture']      = $_POST['NumberOfPicture'];
			$dataupdate['titleStatus']          = $_POST['titleStatus'];
			$dataupdate['VerificationInterval'] = $_POST['VerificationInterval'];
			$dataupdate['DepreciationRate']     = $_POST['DepreciationRate'];
			$dataupdate['auditor']              = $_POST['auditor'];
			$dataupdate['IsDelete']             = 0;
			$dataupdate['ModifyDate']           = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']             = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']             = $logged_in_user_details['ParentID'];

			if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckSubCategory($dataupdate['AssetSubcatName'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Sub Category already exist please update records!" ;
			}else{
				//print_r($dataupdate);exit();
                $InsertedID =$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);
		
				if ($InsertedID>0) {
			
					$config['upload_path']   = '../upload/asset_subcat/'; 
					$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
			        if(!empty($_FILES['ImageName'])){
                      
						$picture = [];

						$picture_count = count($_FILES['ImageName']['name']);
			            for($p=0;$p<$picture_count;$p++){

							if(!empty($_FILES['ImageName']['name'][$p])){
							//print_r($_FILES['ImageName']['name']);die();
					
								$_FILES['file']['name']     = $_FILES['ImageName']['name'][$p];
								$_FILES['file']['type']     = $_FILES['ImageName']['type'][$p];
								$_FILES['file']['tmp_name'] = $_FILES['ImageName']['tmp_name'][$p];
								$_FILES['file']['error']    = $_FILES['ImageName']['error'][$p];
								$_FILES['file']['size']     = $_FILES['ImageName']['size'][$p];
				
					
								if($this->upload->do_upload('file')){
									$pictureData = $this->upload->data();
									$pic_filename = $pictureData['file_name'];

									$picdata = array(
										'AssetID'    =>$AutoID,
										'ImageName'  =>$pic_filename,
										'DocType'    =>2,
										'ModifyBy'   =>$logged_in_user_details['AutoID'],
										'ModifyDate' =>date('Y-m-d'),
										'IsDelete'   =>0
									);
									
									$picid = $this->Assetmaster_model->ManageCRUD($picdata,'AssetSubcatFileMst',$type,$InsertedID);
								}
							}
			            }
			        } 
				}
		    }	
			$status=200;
			$message ="Records Updated Successfully !" ;
		
		$this->output
		->set_status_header($status)
		->set_content_type('application/json', 'utf-8')
		->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Sub Category
	public function DeleteSubCategory_post(){
		$data=$this->request->body;
		$tableName= 'AssetSubcatMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Currency
    public function GetCurrencyList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->CurrencyList($data);
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


    //Add Currency
    public function AddCurrency_post(){
		$data=$this->request->body;
		$tableName= 'CurrencyMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$data['IsDelete']        = 0;
			$data['CreatedDate']     = date('Y-m-d H:i:s');
			$data['CreatedBy']       = $logged_in_user_details['AutoID'];
			$data['CurrencyName']    = trim($data['CurrencyName']);
			$data['CurrencyCode']    = trim($data['CurrencyCode']);
			$data['CurrencySymbole'] = trim($data['CurrencySymbole']);
			$data['CurrencyUnicode'] = trim($data['CurrencyUnicode']);
			$data['ParentID']        = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckCurrency(trim($data['CurrencyName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Currency already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Currency
	public function UpdateCurrency_post(){
		$data = $this->request->body;
		$tableName = 'CurrencyMST';
		$type = 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['CurrencyName']    = trim($data['CurrencyName']);
			$dataupdate['CurrencyCode']    = trim($data['CurrencyCode']);
			$dataupdate['CurrencySymbole'] = trim($data['CurrencySymbole']);
			$dataupdate['CurrencyUnicode'] = trim($data['CurrencyUnicode']);
			$dataupdate['IsDelete']        = 0;
			$dataupdate['ModifyDate']      = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']        = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']        = $logged_in_user_details['ParentID'];
			if ($AutoID>0) {
				$check = $this->Assetmaster_model->CheckCurrency($dataupdate['CurrencyName'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Currency already exist please update records!" ;
            }else{
				$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
				$status=200;
				$message ="Records Updated Successfully !" ;
			}
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Currency
	public function DeleteCurrency_post(){
		$data=$this->request->body;
		$tableName= 'CurrencyMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Record Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Quarterly
	 public function GetQuarterlyList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();

		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
	
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->QuarterlyList($data);
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


    //Add Quarterly
    public function AddQuarterly_post(){
		$data=$this->request->body;
		$tableName= 'QuarterMst';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1) {
			$data['IsDelete']      = 0;
			$data['CreatedDate']   = date('Y-m-d H:i:s');
			$data['QuarterlyName'] = trim($data['QuarterlyName']);
			$data['Fromdate']      = $data['Fromdate'];
			$data['Todate']        = $data['Todate'];
			$data['CreatedBy']     = $logged_in_user_details['AutoID'];
			$data['ParentID']      = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckQuarterly(trim($data['QuarterlyName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Quarterly already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Quarterly
	public function UpdateQuarterly_post(){
		$data=$this->request->body;
		$tableName= 'QuarterMst';
		$type= 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['QuarterlyName'] = $data['QuarterlyName'];
			$dataupdate['Fromdate']      = $data['Fromdate'];
			$dataupdate['Todate']        = $data['Todate'];
			$dataupdate['IsDelete']      = 0;
			$dataupdate['ModifyDate']    = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']      = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']      = $logged_in_user_details['ParentID'];

			if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckQuarterly($data['QuarterlyName'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Quarterly already exist please update records!" ;
            }else{
				$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
				$status=200;
				$message ="Records Updated Successfully !" ;
			}
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Quarterly
	public function DeleteQuarterly_post(){
		$data=$this->request->body;
		$tableName= 'QuarterMst';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Location
	public function GetLocationList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();

		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
	
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->LocationList($data,$logged_in_user_details);
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

	//Add Location
	public function AddLocation_post(){
		$data=$this->request->body;
		$tableName= 'LocationMst';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1) {
			// $data['IsDelete']      = 0;
			$data['CreatedDate']   = date('Y-m-d H:i:s');
			$data['CompanyID']     = trim($data['CompanyID']);
			$data['Name']          = trim($data['Name']);
			$data['ContactPerson'] = trim($data['ContactPerson']);
			$data['Email']         = trim($data['Email']);
			$data['Phone']         = $data['Phone'];
			$data['CreatedBy']     = $logged_in_user_details['AutoID'];
			$data['ParentID']      = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckLocation(trim($data['Name'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Location already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Location
	public function UpdateLocation_post(){
		$data=$this->request->body;
		$tableName= 'LocationMst';
		$type= 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['CompanyID']     = $data['CompanyID'];
			$dataupdate['Name']          = trim($data['Name']);
			$dataupdate['ContactPerson'] = trim($data['ContactPerson']);
			$dataupdate['Email']         = trim($data['Email']);
			$dataupdate['Phone']         = $data['Phone'];
			$dataupdate['IsDelete']      = 0;
			$dataupdate['ModifyDate']    = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']      = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']      = $logged_in_user_details['ParentID'];
			if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckLocation($data['Name'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Location already exist please update records!" ;
            }else{
				$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
				$status=200;
				$message ="Records Updated Successfully !" ;
			}
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Location
	public function DeleteLocation_post(){
		$data=$this->request->body;
		$tableName= 'LocationMst';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			// $dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			// $dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//View Warranty
	public function GetWarrantyList_post() {
		$data=$this->request->body;
		$headerdata = $this->input->request_headers();

		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		$msg = "";
	
		$status=200;
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$Requestlist = $this->Assetmaster_model->WarrantyList($data,$logged_in_user_details);
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

	//Add Warranty
	public function AddWarranty_post(){
		$data=$this->request->body;
		$tableName= 'WarrantyTypeMST';
		$type= 1;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1) {
			// $data['IsDelete']         = 0;
			$data['CreatedDate']      = date('Y-m-d H:i:s');
			$data['AssetCat']         = $data['AssetCat'];
			$data['AssetSubCat']      = $data['AssetSubCat'];
			$data['WarrantyTypeName'] = trim($data['WarrantyTypeName']);
			$data['CreatedBy']        = $logged_in_user_details['AutoID'];
			$data['ParentID']         = $logged_in_user_details['ParentID'];
            $check = $this->Assetmaster_model->CheckWarranty(trim($data['WarrantyTypeName'],$AutoID));
            if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Warranty already exist please update records!" ;
            }else{
                $InsertedID =$this->Assetmaster_model->ManageCRUD($data,$tableName,$type,$AutoID);	
                $status=200;
                $message ="Records Inserted Successfully !" ;
            }
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Update Warranty
	public function UpdateWarranty_post(){
		$data=$this->request->body;
		$tableName= 'WarrantyTypeMST';
		$type= 2;
		if (!empty($data['AutoID'])) {
			$AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['AssetCat']         = trim($data['AssetCat']);
			$dataupdate['AssetSubCat']      = trim($data['AssetSubCat']);
			$dataupdate['WarrantyTypeName'] = trim($data['WarrantyTypeName']);
			$dataupdate['IsDelete']         = 0;
			$dataupdate['ModifyDate']       = date('Y-m-d H:i:s');
			$dataupdate['ModifyBy']         = $logged_in_user_details['AutoID'];
			$dataupdate['ParentID']         = $logged_in_user_details['ParentID'];
            if ($AutoID > 0) {
				$check = $this->Assetmaster_model->CheckWarranty($data['WarrantyTypeName'],$AutoID);
			}
			if($check==true){
		        $InsertedID = "";
                $status=400;
                $message ="Warranty already exist please update records!" ;
            }else{
				$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
				$status=200;
				$message ="Records Updated Successfully !" ;
			}
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
		}else{
			$status=403;
			$message="Invalid AUTH Key !";
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('status' => $status, 'message' => $message)));
		}
	}

	//Delete Warranty
	public function DeleteWarranty_post(){
		$data=$this->request->body;
		$tableName= 'WarrantyTypeMST';
		$type= 3;
		if (!empty($data['AutoID'])) {
		    $AutoID = $data['AutoID'];
		}else{
			$AutoID = "";
		}
		$headerdata = $this->input->request_headers();
		$auth_token = $headerdata['Token'];
		$logged_in_user_details = json_decode($this->authtoken->token_data_get($auth_token), true);
		if ($logged_in_user_details['AutoID'] > 0 && $logged_in_user_details['IsAdmin'] == 1 ) {
			$dataupdate['IsDelete']   = 1;
			$dataupdate['DeleteDate'] = date('Y-m-d H:i:s');
			$dataupdate['DeleteBy']   = $logged_in_user_details['AutoID'];
			$InsertedID =	$this->Assetmaster_model->ManageCRUD($dataupdate,$tableName,$type,$AutoID);	
			$status=200;
			$message ="Records Deleted Successfully !" ;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(array('Insert_ID'=>$InsertedID,'status' => $status, 'message' => $message)));
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