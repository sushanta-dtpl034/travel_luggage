<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
require FCPATH.'vendor/autoload.php';

use Com\Tecnick\Barcode\Barcode;

class Asset extends REST_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->database();
	    $this->tokenHandler = new TokenHandler();
	    $this->load->model('Master_model');
		$this->load->model('Companymodel');
		$this->load->model('Companymodel');
		$this->load->model('Assetmodel');
		$this->load->library('Authtoken');
		$this->load->model('Login_model');
		$this->load->model('Materialmodel');
		$this->load->model('Commonmodel');
		$this->load->helper('referenceno_helper');
		$this->load->library('form_validation');
		$this->load->helper('quarters_helper');
		$this->load->library('phpmailer_lib');

		$this->load->model('TravelModel');
		header('Content-Type: application/json');
	}
	public function asset_owner_company_list_post(){
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$parentid=$arrdata['ParentID'];
					$result['company'] = $this->Companymodel->getcompany($parentid);
					$result['message'] = "success";
					$result['status']=true;
					return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
	   					 $result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function getasset_type_post($value=''){
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
						$parent_id = $arrdata['AutoID'];
						if($arrdata['GroupID']!='1'){
						  $parent_id = $arrdata['ParentID'];
						}
					$result['type'] = $this->Assetmodel->getassettype($parent_id);
					$result['message'] = "success";
					$result['status']=true;
					return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
	   					 $result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function getasset_cat_post(){	
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body['typeid']) && !empty($body)) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$typeid=$body['typeid'];
					$parent_id = $arrdata['AutoID'];
						if($arrdata['GroupID']!='1'){
						  $parent_id = $arrdata['ParentID'];
						}
					$result['category'] = $this->Assetmodel->getassetcat($parent_id,$typeid);
					$result['message'] = "success";
					$result['status']=true;
					return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
	   					 $result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or Typeid not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	

	public function getasset_subcat_post($value=''){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'] && !empty($body['catid']))) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				// $parentid=$arrdata['ParentID'];

				$catid=$body['catid'];
				$result['subcategory'] = $this->Assetmodel->get_subcat_basedoncatid($catid);
				$result['message'] = "success";
				$result['status']=true;
				return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) { 
					$result['message'] = "Invalid Token";
					$result['status']=false;
					return $this->set_response($result, 401);
				}
		}
		else{
			$result['message'] = "Token or categoryid not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function get_oneasset_subcat_post($value=''){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'] && !empty($body['subcatid']))) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				// $parentid=$arrdata['ParentID'];

				// $measurement_list = $this->Assetmodel->getmeasuremnt_basedonsubcat($result->Measurement);
				$subcatid=$body['subcatid'];
				$result['subcategory'] = $this->Assetmodel->get_oneasset_subcat($subcatid);

				$result['message'] = "success";
				$result['status']=true;
				return $this->set_response($result, REST_Controller::HTTP_OK);
			} catch (\Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or subcategoryid not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function get_mesurmentbysubcat_post($value=''){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'] && !empty($body['subcatid']))) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				// $parentid=$arrdata['ParentID'];
				$subcatid=$body['subcatid'];
				$data = $this->Assetmodel->get_oneasset_subcat($subcatid);
				$measurement_list = $this->Assetmodel->getmeasuremnt_basedonsubcat($data->Measurement);
				$result['mesurements'] = $measurement_list;
				$result['message'] = "success";
				$result['status']=true;

				return $this->set_response($result, REST_Controller::HTTP_OK);
			} catch (\Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
		else{
			$result['message'] = "Token or subcategoryid not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}


	public function getcurrency_post($value=''){
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$parent_id = $arrdata['AutoID'];
					if($arrdata['GroupID']!='1'){
						$parent_id = $arrdata['ParentID'];
					}
				$result['currency'] = $this->Master_model->getcurrency($parent_id);
				$result['message'] = "success";
				$result['status']=true;
				return $this->set_response($result, REST_Controller::HTTP_OK);
			} catch (\Exception $e){ 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}


	public function getasset_condition_post(){
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$parent_id = $arrdata['AutoID'];
				if($arrdata['GroupID']!='1'){
					$parent_id = $arrdata['ParentID'];
				}
					$result['material'] = $this->Materialmodel->get_material($parent_id);
					$result['message'] = "success";
					$result['status']=true;
					return $this->set_response($result, REST_Controller::HTTP_OK);
			} catch (Exception $e){ 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}


	public function getasset_list_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					// $parentid=$arrdata['ParentID'];

							// $list=$this->Assetmodel->getasset_list($arrdata,$body);
							// foreach ($list as $key => $value) {
							// 	$asset_id=$value['AutoID'];
							// 	$thumimg[]=$this->Assetmodel->getone_thumimgby_asstid($asset_id);
							// }

							
						$result['assetlist'] = $this->Assetmodel->getasset_list($arrdata,$body);
						// $result['thumimges'] = $thumimg;
						$result['message'] = "success";
						$result['status']=true;

						return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			
			return $this->set_response($result, 400);

		}
	}

	public function getmyasset_list_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);	
				$userid=$arrdata['AutoID'];									
				$result['assetlist'] = $this->Assetmodel->get_myasset_list($userid,$body);
				
				$result['message'] = "success";
				$result['status']=true;

				return $this->set_response($result, REST_Controller::HTTP_OK);
			}catch (\Exception $e){ 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			
			return $this->set_response($result, 400);

		}
	}

	public function getasset_warrant_basedonsubcat_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body) && !empty($body['subcatid'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$subcatid=$body['subcatid'];
					// $parentid=$arrdata['ParentID'];
						$result['warrants'] = $this->Assetmodel->getwarrant_basedonsubcat($subcatid);
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or subcategoryid not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function getoneasset_detail_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body) && !empty($body['assetid'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$id=$body['assetid'];
							$resultId = $this->Assetmodel->getoneasset($id);

							$respictures = $this->Assetmodel->getpictures($id);

							$allhis_data=$this->Assetmodel->getdata_verify($id);
				

						/////check veryfication butoon staus
							$button_status = 0;
							$today = date("Y-m-d");
							$VerificationDate = $resultId->VerificationDate;
							$date1_ts = strtotime($today);
							$date2_ts = strtotime($VerificationDate);
							$diff = $date2_ts - $date1_ts;
							$verifyday = round($diff / 86400);
								if($verifyday<=7){
									$button_status = 1;
									}
								elseif($resultId->isVerify == null){
											$button_status = 1;
									}

							////////////////
							foreach($allhis_data as $data){
								$hisid[]=$data->AutoID;
							}
						
							$Picture_array = array();
							$pic_autoid = "";
							$pic_title = "";
							foreach($respictures as $pic){
								$pic_autoid.= $pic['AutoID'].",";
								$pic_title.= $pic['ImageTitle'].",";
								$Picture_array[] = 'upload/asset/'.$pic['ImageName'];
							}
							
							$pictures = implode(",",$Picture_array);

							$resbill = $this->Assetmodel->getbils($id);

							// $resbill_array = array();
							// $res_autoid = "";
							//   foreach($resbill as $bill){
							//  $res_autoid.= $bill['AutoID'].",";	
							//  $resbill_array[] = 'upload/asset/'.$bill['ImageName'];
							//   }

							//   $bills = implode(",",$resbill_array);

							$warbill = $this->Assetmodel->getwaranty($id);
							//   $war_array = array();
							//   $war_autoid = "";
							//  foreach($warbill as $war){
							// $war_autoid.= $war['AutoID'].",";	   
							// $war_array[] = 'upload/asset/'.$war['ImageName'];
							//  }
							$his = $this->Assetmodel->getHistory($id);
							// $war = implode(",",$war_array);

							$waranty = $this->Assetmodel->getwarrant_basedonsubcat($resultId->AssetSubcat);

							$fromdate = $resultId->PurchaseDate;
							$todate = date('Y-m-d');
							$dep_his = array();
							if(!is_null($fromdate) && $fromdate!='1970-01-01' && $fromdate!='')
							{
								$quarters = get_quarters($fromdate,$todate);


							$i=1;
							$dep_his = array();
							$temp = '';
							foreach($quarters as $res_quarters){
							$dep_his[$i]['period'] = $res_quarters->period;
							$dep_his[$i]['start'] = $res_quarters->period_start;
							$dep_his[$i]['end'] = $res_quarters->period_end;
							$dep_his[$i]['dep'] = $resultId->DepreciationRate;
							if($i==1){
								$price = $resultId->PurchasePrice;
								$temp = $price;
							}else{
								$quar_per = $resultId->DepreciationRate/4;
								$price = (int)$temp - ((int)$temp*$quar_per/100);
								$temp = $price;
							}
							
							$dep_his[$i]['price'] =round($price,2);
							$i++;

							}
							}
						$response = array(
								"Assetid" => $resultId->Assetid,
								"UniqueRefNumber" => $resultId->UniqueRefNumber,
								"QrImage" => "upload/qr-code/".$resultId->UniqueRefNumber.".png",
								"AssetOwner" => $resultId->AssetOwner,
									"UNI" => $resultId->UIN,
								"Assetownerid" => $resultId->Assetownerid,
								"AssetType" => $resultId->AssetType,
								"AsseTypeName" => $resultId->AsseTypeName,
								"AsseCatName" => $resultId->AsseCatName,
								"AssetCat" => $resultId->AssetCat,
								"AssetSubcat" => $resultId->AssetSubcat,
								"AssetSubcatName" => $resultId->AssetSubcatName,
								"isVerify" => $resultId->isVerify,
								"isRemove" => $resultId->isRemove,
								"PurchasePrice" => $resultId->PurchasePrice,
								"PurchaseDate" => $resultId->PurchaseDate,
								"ValidTil" => $resultId->ValidTil,
								"VendorName" => $resultId->VendorName,
								"VendorEmail" => $resultId->VendorEmail,
								"VendorMobile" => $resultId->VendorMobile,
								"VendorAddress" => $resultId->VendorAddress,
								"DimensionOfAsset" => $resultId->DimensionOfAsset,
								"DepreciationRate" => $resultId->DepreciationRate, 
								"ConditionName" => $resultId->ConditionName,
								"AssetCondition" => $resultId->AssetCondition,
								// "Pictureid" => rtrim($pic_autoid,','),
								"VendorBilliid" => $resbill,
								"WarrantyCardid" => $warbill,
								// "pic_title" => rtrim($pic_title,','),
								"Picture" => $respictures,
								// "VendorBill" => $resbill,
								// "WarrantyCard" => $warbill,
								"auditor" => $resultId->auditor,
								"incharge" => $resultId->incharge,
								"supervisor" => $resultId->supervisor,
								"auditorid" => $resultId->Auditorid,
								"inchargeid" => $resultId->Inchargeid,
								"supervisorid" => $resultId->Supervisorid,
								"titleStatus" => $resultId->titleStatus,
								"WarrantyCoverdfor" => $resultId->WarrantyCoverdfor,
								"InsuranceValidUpto" => $resultId->InsuranceValidUpto,
								"WarrantyContactPersonMobile" => $resultId->WarrantyContactPersonMobile,
								"WarrantyContactPersonEmail" => $resultId->WarrantyContactPersonEmail,
								"Warrantyselect" =>json_encode($waranty),
								"WarrantyCoverdid" => $resultId->WarrantyCoverdfor,
								"his" =>json_encode($his),
								"dep_his"=>$dep_his,
								"Measurement"=>$resultId->Measurement,
								"AssetTitle"=>$resultId->AssetTitle,
								"AssetQuantity"=>$resultId->AssetQuantity,
								"VerificationDate"=>$resultId->VerificationDate,
								"timeline"=>$this->Assetmodel->getpicturesby_asstid($hisid ?? 0),
								"location_name"=>$resultId->Locationname,
								"current_location"=>$resultId->CurrentLocation,
								"Location_id"=>$resultId->Location_id,
								"currency_type"=>$resultId->currency_type,
								"verifybtn"=>$button_status,
								"CurrencySymbole"=>$resultId->CurrencySymbole,
								"UomShortName"=>$resultId->UomShortName,
								"UomName"=>$resultId->UomName,
								"VerificationCount"=>$resultId->VerificationCount,
							);

							// $array = array("2022-12-12", "2022-12-12", "2022-12-12", "2022-12-22");
							// $array = array_unique($array);
							// print_r($array);

							// foreach ($verify_images as $key => $value) {
							// 	$value['timeline']= $this->Assetmodel->getpicturesby_img($value['ModifyDate']);
							// 	array_push($response,$value);
							// }
						


						$result['details'] = $response;
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid or Assetid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or Assetid not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

		

	public function getoneasset_detail_urn_uin_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body) && !empty($body['keyword'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$keyword=$body['keyword'];
						$result['assetdetail'] = $this->Assetmodel->getoneasset_urn_uin($keyword);
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
						
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or keyword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}



	public function getoneasset_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body) && !empty($body['keyword'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$keyword=$body['keyword'];
						$result['assetdetail'] = $this->Assetmodel->getoneasset_urn_uin($keyword);
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
						
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or keyword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function getuserbygroupid_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body) && !empty($body['rolename'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$parent_id = $arrdata['AutoID'];
					if($arrdata['GroupID']!='1'){
						$parent_id = $arrdata['ParentID'];
					}
					$rolename=$body['rolename'];
						$result['assetdetail'] = $this->Assetmodel->get_users($parent_id,$rolename);
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
						
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or rolename not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function addasset_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$parentid=$arrdata['ParentID'];
					$groupid=$arrdata['GroupID'];
					$userid=$arrdata['AutoID'];
					// print_r($_POST);
					// $parent_id = $arrdata['AutoID'];
					// if($arrdata['GroupID']!='1'){
					//   $parent_id = $arrdata['ParentID'];
					// }

					// $FourDigitRandomNumber = rand(1000000000,9999999999);
					$assetowner_id  = $this->input->post('assetowner_id');
					$assetman_type  = $this->input->post('assetman_type');
					$vendor_email  = $this->input->post('vendor_email');
					$vendor_mobile  = $this->input->post('vendor_mobile');
					$depreciation_rate  = $this->input->post('depreciation_rate');
					$assetman_cat  = $this->input->post('assetman_cat');
					$assetment_subcat  = $this->input->post('assetment_subcat');
					$assetment_UIN  = $this->input->post('assetment_UIN');
					$assetment_purchaseprice  = $this->input->post('assetment_purchaseprice');
					$purchased_date  = date_create($this->input->post('purchased_date'));
					$vendor_name  = $this->input->post('vendor_name');
					$vendor_address  = $this->input->post('vendor_address');
					$assetment_dimenson  = $this->input->post('assetment_dimenson');
					$assetment_condition  = $this->input->post('assetment_condition');
					$valid_till  = date_create($this->input->post('valid_till'));
					$assetman_auditor  = $this->input->post('assetman_auditor');
					$asstman_incharge  = $this->input->post('asstman_incharge');
					$assetman_supervisor  = $this->input->post('assetman_supervisor');
					$picture_title  = json_decode($this->input->post('picture_title'));
					$warrantly_covered_for  =implode(',',json_decode($this->input->post('warrantly_covered_for')));
					$insurance_valid_upto  = date_create($this->input->post('insurance_valid_upto'));
					$warranty_contact_mobile  = $this->input->post('warranty_contact_mobile');
					$warranty_contact_email  = $this->input->post('warranty_contact_email');
					$VerificationInterval  = $this->input->post('VerificationInterval');
					$Measurement  = $this->input->post('measurement');
					$AssetTitle  = $this->input->post('assettitle');
					$AssetQuantity  = $this->input->post('assetquantity');

					$locationid  = $this->input->post('locationid');
					$Current_location  = $this->input->post('current_location');
					$currency_type  = $this->input->post('currency_type');

					$refno  = $this->input->post('refno')?? '';
					
					$config['upload_path']   = '../upload/asset/'; 
					$config['allowed_types'] = '*'; //jpg|png|jpeg|pdf
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					$parent_id = $userid;
					if($groupid!='1'){
					$parent_id = $parentid;
					}

					$where = array(
						'ParentID'=>$parent_id,
						'AssetOwner'=>$assetowner_id,
						);

					if($refno == ''){
						$response = $this->Commonmodel->allreadycheck('AssetMst',$where);
						$shortcode= $this->Commonmodel->getshortcode($parent_id,$assetowner_id);
						$lc = date('ym');					   
						$fc = strtoupper(substr($shortcode->CompanyName,0,3));					  
						if($response==0){
							$oldshortcode= $this->Commonmodel->last_companycode($parent_id,$assetowner_id);
							$ref=create_refno($oldshortcode+1,$fc);
						}
						else{
							$ref=create_refno(1,$fc);
						}
						$this->load->library('myLibrary');
						$this->mylibrary->generate($ref);
					}else{
					$ref=$refno;
					// chnage the status of qr code is_use 1
					$data = array('IsUsed'=>1);
					$where = array('QRCodeText'=>$refno);
					$this->Commonmodel->common_update('QRCodeDetailsMst',$where,$data);
					}
					

					$data = array(
						'AssetOwner'=>$assetowner_id,
						'AssetType'=>$assetman_type,	
						'VendorMobile'=>$vendor_mobile,	
						'VendorEmail'=>$vendor_email,	
						'DepreciationRate'=>$depreciation_rate,	
						'AssetCat'=>$assetman_cat,
						'AssetSubcat'=>$assetment_subcat,
						'UIN'=>$assetment_UIN,	
						'PurchasePrice'=>$assetment_purchaseprice,
						'PurchaseDate'=>date_format($purchased_date,"Y-m-d"),
						'VendorName'=>$vendor_name,
						'VendorAddress'=>$vendor_address,
						'DimensionOfAsset'=>$assetment_dimenson,
						'AssetCondition'=>$assetment_condition,
						'ValidTil'=>date_format($valid_till,"Y-m-d"),
						'Auditor'=>$assetman_auditor,
						'Incharge'=>$asstman_incharge,
						'Supervisor'=>$assetman_supervisor,
						'UniqueRefNumber'=>$ref,
						'WarrantyCoverdfor'=>$warrantly_covered_for,
						'InsuranceValidUpto'=>date_format($insurance_valid_upto,"Y-m-d"),
						'WarrantyContactPersonMobile'=>$warranty_contact_mobile,
						'WarrantyContactPersonEmail'=>$warranty_contact_email,
						'ParentID'=>$parent_id,
						'CreatedBy'=>$userid,
						'VerificationDate'=>date('Y-m-d'),
						'CreatedDate'=>date('Y-m-d'),
						'Measurement'=>$Measurement,
						'AssetTitle'=>$AssetTitle,
						'AssetQuantity'=>$AssetQuantity,
						'Location'=>$locationid,
						'CurrentLocation'=>$Current_location,
						'CurrencyType'=>$currency_type,
						);

				
					
					$resultId = $this->Commonmodel->common_insert('AssetMst',$data);
				// $picture = [];
				$picture_count = count(array_filter($_FILES['picture']['name'])) ?? 0;
				$picturetittle_count = count(array_filter($picture_title)) ?? 0;
				
				if($picture_count==0){
					$result['message'] = "picture empty";
					$result['status']=false;
					return $this->set_response($result, 400);
				}else if($picturetittle_count == 0){
					$result['message'] = "picture Tittle empty";
					$result['status']=false;
					return $this->set_response($result, 400);
				}
			
				for($p=0;$p<$picture_count;$p++){
					if(!empty($_FILES['picture']['name'][$p])){
						$_FILES['file']['name'] = $_FILES['picture']['name'][$p];
						$_FILES['file']['type'] = $_FILES['picture']['type'][$p];
						$_FILES['file']['tmp_name'] = $_FILES['picture']['tmp_name'][$p];
						$_FILES['file']['error'] = $_FILES['picture']['error'][$p];
						$_FILES['file']['size'] = $_FILES['picture']['size'][$p];
						if($this->upload->do_upload('file')){
						$pictureData = $this->upload->data();
						$pic_filename = $pictureData['file_name'];
						$picdata = array(
							'AssetID'=>$resultId,
							'ImageName'=>$pic_filename,
							'DocType'=>1,
							'CreatedBy'=>$userid,
							'CreatedDate'=>date('Y-m-d')
						);
						if($picture_title[$p]!=''){
							$picdata['ImageTitle']=$picture_title[$p];
						}
						$picid = $this->Commonmodel->common_insert('AssetFileMst',$picdata);
						}
					}
					}
					// $data = [];
					if(!empty($_FILES['bill'])){
					$count = count($_FILES['bill']['name']) ?? null;
					for($i=0;$i<$count;$i++){
						if(!empty($_FILES['bill']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['bill']['name'][$i];
						$_FILES['file']['type'] = $_FILES['bill']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['bill']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['bill']['error'][$i];
						$_FILES['file']['size'] = $_FILES['bill']['size'][$i];
						if($this->upload->do_upload('file')){
							$uploadData = $this->upload->data();
							$filename = $uploadData['file_name'];
								$billdata = array(
								'AssetID'=>$resultId,
								'ImageName'=>$filename,
								'DocType'=>2,
								'CreatedBy'=>$userid,
								'CreatedDate'=>date('Y-m-d')
								);

								$vendorid = $this->Commonmodel->common_insert('AssetFileMst',$billdata);
						}
						}
					}
					}
					// $wara_data = [];
				if(!empty($_FILES['warranty'])){
					$count1 = count($_FILES['warranty']['name']) ?? null;
				for($i=0;$i<$count1;$i++){
					if(!empty($_FILES['warranty']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['warranty']['name'][$i];
						$_FILES['file']['type'] = $_FILES['warranty']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['warranty']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['warranty']['error'][$i];
						$_FILES['file']['size'] = $_FILES['warranty']['size'][$i];
						if($this->upload->do_upload('file')){
						$uploadData1 = $this->upload->data();
						$filename = $uploadData1['file_name'];
						$wardata = array(
							'AssetID'=>$resultId,
							'ImageName'=>$filename,
							'DocType'=>3,
							'CreatedBy'=>$userid,
							'CreatedDate'=>date('Y-m-d')
							);
						$warantyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

						}
					}
					}
				}
					if($resultId){
						$result['message'] = "Asset Created Successfully";
						$result['status']=true;
						return $this->set_response($result, 201);
					}else{
						$result['message'] = "Server Error";
						$result['status']=false;
						return $this->set_response($result, 500);
					}

				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token  or All Inputs Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function getVerification_reminder_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$userid = $arrdata['AutoID'];
					$userresult = $this->Login_model->getuserdata_byid($userid);
					$parent_id = $arrdata['AutoID'];
					$GroupID = $arrdata['GroupID'];
					$IsAdmin = $userresult->IsAdmin;
					$Isauditor = $userresult->Isauditor;
					$issupervisor = $userresult->issupervisor;
					if( $GroupID!='1'){
						$parent_id =  $arrdata['ParentID'];
					}
					// $today =  date('Y-m-d');
					// $from = date('Y-m-d', strtotime("-15 days", strtotime($today)));
					// $to = date('Y-m-d', strtotime("+15 days", strtotime($today)));
					$from =  date('Y-m-d');
					$to = date('Y-m-d', strtotime("+7 days", strtotime($from)));
					// $parentid = $userid;
						$result['reminders'] = $this->Assetmodel->getassetlist_notify($from,$to,$userid,$parent_id,$IsAdmin,$Isauditor,$issupervisor);
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}

		}
		else{
			$result['message'] = "Token  not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}

	public function updateassets_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$userid = $arrdata['AutoID'];						
				// $result['reminders'] = $this->Assetmodel->updateassets();
				$update_assetid  = $this->input->post('update_assetid');
				$update_assetownerid  = $this->input->post('update_assetownerid');
				$update_assettype  = $this->input->post('update_assettype');
				$update_vendoremail  = $this->input->post('update_vendoremail');
				$update_vendormobile  = $this->input->post('update_vendormobile');
				$update_depreciationrate  = $this->input->post('update_depreciationrate');
				$up_assetmancat  = $this->input->post('up_assetmancat');
				$up_assetmentsubcat  = $this->input->post('up_assetmentsubcat');
				$update_assetmentUIN  = $this->input->post('update_assetmentUIN'); 
				$update_assetorginalprice = $this->input->post('update_assetorginalprice');
				$update_purchaseddate  = date_create($this->input->post('update_purchaseddate'));
				$update_vendorname  = $this->input->post('update_vendorname');
				$update_vendoraddress  = $this->input->post('update_vendoraddress');
				$update_purchaseddate  = date_create($this->input->post('update_purchaseddate'));
				$update_assetdimenson  = $this->input->post('update_assetdimenson');
				$update_assetcondition  = $this->input->post('update_assetcondition');
				$update_assetmanauditor  = $this->input->post('update_assetmanauditor');
				$update_assetmansupervisor  = $this->input->post('update_assetmansupervisor');
				$update_asstmanincharge  = $this->input->post('update_asstmanincharge');
				$update_validtill  = date_create($this->input->post('update_validtill'));
				$update_picturetitle  = json_decode($this->input->post('update_picturetitle'));
				$delete_files =json_decode($this->input->post('delete_files'));
				$up_warrantly_covered_for  = implode(',',json_decode($this->input->post('up_warrantly_covered_for')));
				$up_insurance_valid_upto  = date_create($this->input->post('up_insurance_valid_upto'));
				$up_warranty_contact_mobile  = $this->input->post('up_warranty_contact_mobile');
				$up_warranty_contact_email  = $this->input->post('up_warranty_contact_email');
				$up_measurements  = $this->input->post('up_measurements');

				$update_assettitle  = $this->input->post('update_assettitle');
				$update_assetqty  = $this->input->post('update_assetqty');

				$up_location_id  = $this->input->post('up_location_id');
				$up_current_location  = $this->input->post('up_current_location');
				$currency_type=$this->input->post('currency_type');

				// $dels_data=explode(",",$delete_files);
				$countdels=count($delete_files);
				
				
				for ($i=0; $i < $countdels; $i++) { 

				$data = array('IsDelete'=>1,'DeleteBy'=>$userid,'DeleteDate'=>date('Y-m-d'));
					$where = array('AutoID'=>$delete_files[$i]);
				$this->Commonmodel->common_update('AssetFileMst',$where,$data);
					
				}
				
			$config['upload_path']   = '../upload/asset/'; 
			$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

		
			

			$data = array(
				'AssetOwner'=>$update_assetownerid,
				'AssetType'=>$update_assettype,	
				'VendorMobile'=>$update_vendormobile,	
				'VendorEmail'=>$update_vendoremail,	
				'DepreciationRate'=>$update_depreciationrate,	
				'AssetCat'=>$up_assetmancat,
				'AssetSubcat'=>$up_assetmentsubcat,
				'UIN'=>$update_assetmentUIN,	
				'PurchasePrice'=>$update_assetorginalprice,
				'PurchaseDate'=>date_format($update_purchaseddate,"Y-m-d"),
				'VendorName'=>$update_vendorname,
				'VendorAddress'=>$update_vendoraddress,
				'DimensionOfAsset'=>$update_assetdimenson,
				'AssetCondition'=>$update_assetcondition,
				'ValidTil'=>date_format($update_validtill,"Y-m-d"),
				'Auditor'=>$update_assetmanauditor,
				'Incharge'=>$update_asstmanincharge,
				'Supervisor'=>$update_assetmansupervisor,
				'WarrantyCoverdfor'=>$up_warrantly_covered_for,
				'InsuranceValidUpto'=>date_format($up_insurance_valid_upto,"Y-m-d"),
				'WarrantyContactPersonMobile'=>$up_warranty_contact_mobile,
				'WarrantyContactPersonEmail'=>$up_warranty_contact_email,
				'AssetTitle'=>$update_assettitle,
				'AssetQuantity'=>$update_assetqty,
				'Measurement'=>$up_measurements,
				'ModifyBy'=>$userid,
				'ModifyDate'=>date('Y-m-d'),
				'Location'=>$up_location_id,
				'CurrentLocation'=>$up_current_location,
				'CurrencyType'=>$currency_type,
				);
		
				$where = array(
					'AutoID'=>$update_assetid,
				);

				$resultId = $this->Commonmodel->common_update('AssetMst',$where,$data);
				
				if(!empty($_FILES['update_picture'])){
					
					$picture = [];

				$picture_count = count($_FILES['update_picture']['name']);
				// if($picture_count >0){
				// 	$data = array('IsDelete'=>1,'DeleteBy'=>$userid,'DeleteDate'=>date('Y-m-d'));
				// 	$where = array('AutoID'=>$update_assetid,'DocType'=>1,);
				// 	$this->Commonmodel->common_update('AssetFileMst',$where,$data);
				// }
				for($p=0;$p<$picture_count;$p++){

					if(!empty($_FILES['update_picture']['name'][$p])){
				
						$_FILES['file']['name'] = $_FILES['update_picture']['name'][$p];
						$_FILES['file']['type'] = $_FILES['update_picture']['type'][$p];
						$_FILES['file']['tmp_name'] = $_FILES['update_picture']['tmp_name'][$p];
						$_FILES['file']['error'] = $_FILES['update_picture']['error'][$p];
						$_FILES['file']['size'] = $_FILES['update_picture']['size'][$p];
				
				
						if($this->upload->do_upload('file')){
						$pictureData = $this->upload->data();
						$pic_filename = $pictureData['file_name'];

						$picdata = array(
							'AssetID'=>$update_assetid,
							'ImageName'=>$pic_filename,
							'DocType'=>1,
							'ModifyBy'=>$userid,
							'ModifyDate'=>date('Y-m-d')
							);

							if(isset($update_picturetitle[$p])){
								$picdata['ImageTitle']=$update_picturetitle[$p];
							}
							$picid = $this->Commonmodel->common_insert('AssetFileMst',$picdata);
				
						
						}
					}
				
					}
				}  

				if(!empty($_FILES['updatebill'])){

				$data = [];

				// $count = count($_FILES['updatebill']['name']);
				// 	if($count >0){
				// 	$data = array('IsDelete'=>1,'DeleteBy'=>$userid,'DeleteDate'=>date('Y-m-d'));
				// 	$where = array('AutoID'=>$update_assetid,'DocType'=>2,);
				// 	$this->Commonmodel->common_update('AssetFileMst',$where,$data);
				// }

				for($i=0;$i<$count;$i++){

					if(!empty($_FILES['updatebill']['name'][$i])){
				
						$_FILES['file']['name'] = $_FILES['updatebill']['name'][$i];
						$_FILES['file']['type'] = $_FILES['updatebill']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['updatebill']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['updatebill']['error'][$i];
						$_FILES['file']['size'] = $_FILES['updatebill']['size'][$i];
				
				
						if($this->upload->do_upload('file')){
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

							$billdata = array(
							'AssetID'=>$update_assetid,
							'ImageName'=>$filename,
							'DocType'=>2,
							'ModifyBy'=>$userid,
							'ModifyDate'=>date('Y-m-d')
							);

							$vendorid = $this->Commonmodel->common_insert('AssetFileMst',$billdata);
						}
					}
				
					}
				} 

				if(!empty($_FILES['updatewarranty'])){

					$wara_data = [];

				$count1 = count($_FILES['updatewarranty']['name']);

				// 	if($count1 >0){
				// 	$data = array('IsDelete'=>1,'DeleteBy'=>$userid,'DeleteDate'=>date('Y-m-d'));
				// 	$where = array('AutoID'=>$update_assetid,'DocType'=>3,);
				// 	$this->Commonmodel->common_update('AssetFileMst',$where,$data);
				// }

				for($i=0;$i<$count1;$i++){

					if(!empty($_FILES['updatewarranty']['name'][$i])){
				
						$_FILES['file']['name'] = $_FILES['updatewarranty']['name'][$i];
						$_FILES['file']['type'] = $_FILES['updatewarranty']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['updatewarranty']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['updatewarranty']['error'][$i];
						$_FILES['file']['size'] = $_FILES['updatewarranty']['size'][$i];
				
				
						if($this->upload->do_upload('file')){
						$uploadData1 = $this->upload->data();
						$filename = $uploadData1['file_name'];
						$wardata = array(
							'AssetID'=>$update_assetid,
							'ImageName'=>$filename,
							'DocType'=>3,
							'ModifyBy'=>$userid,
							'ModifyDate'=>date('Y-m-d')
							);

							$warantyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

						}
					}
				
					}
				}  
					

				// echo json_encode(array('status' => 1));

						$result['message'] = "Update Successfully";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}

		}
		else{
			$result['message'] = "Token  not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}







	public function verifyasset_post(){
		// $body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($this->input->post('view_assetid'))) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];

				$view_assetid = $this->input->post('view_assetid');
				$verify_condition = $this->input->post('verify_condition');
				$verifyinterval = $this->input->post('verifyinterval');
				$location = $this->input->post('location');
				$VerificationDate = date("Y-m-d");
				$verify_picturetitle = $this->input->post('verify_picturetitle');
				$effectiveDate = date('Y-m-d', strtotime("+$verifyinterval months", strtotime($VerificationDate)));
				
				$old_qnt = $this->input->post('old_qnt');
				$new_qnt = $this->input->post('new_qnt');
				
				$config['upload_path']   = '../upload/asset/'; 
				$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if($old_qnt != $new_qnt){
					$remark = $this->input->post('remark') ?? null;
					$data = array(
						'isVerify'=>1,
							'VerifyCondition'=>$verify_condition,	
							'VerifiedLocation'=>json_encode($location),	
							'VerifiedBy'=>$userid,
							'VerificationDate'=>$effectiveDate,
							'VerifiedDatetime'=>date("Y-m-d H:i:s"),
						'AssetQuantity'=>$new_qnt,
					);
					
					$his_data = array(
								'AssetID'=>$view_assetid,	
								'type'=>1,	
								'VerifyCON'=>$verify_condition,	
								'VerifiedOrRemoveBY'=>$userid,
								'VerifiedOrRemoveDate'=>date("Y-m-d H:i:s"),
								'prev_Asset_Qnt'=>$old_qnt,
								'curr_Asset_Qnt'=>$new_qnt,
								'Remark'=>$remark =='' ? null :$remark
								);
						
				}else{
					$data = array(
							'isVerify'=>1,
							'VerifyCondition'=>$verify_condition,	
							'VerifiedLocation'=>json_encode($location),	
							'VerifiedBy'=>$userid,
							'VerificationDate'=>$effectiveDate,
							'VerifiedDatetime'=>date("Y-m-d H:i:s")
							);

						$his_data = array(
								'AssetID'=>$view_assetid,	
								'type'=>1,	
								'VerifyCON'=>$verify_condition,	
								'VerifiedOrRemoveBY'=>$userid,
								'VerifiedOrRemoveDate'=>date("Y-m-d H:i:s"),
								);
				}

				$where = array('AutoID'=>$view_assetid,);
				$resultId = $this->Commonmodel->common_update('AssetMst',$where,$data);
				$resulthis = $this->Commonmodel->common_insert('VerifyHST',$his_data);


				if(!empty($_FILES['verifypicture'])){

					$wara_data = [];

					$count1 = count($_FILES['verifypicture']['name']);

					for($i=0;$i<$count1;$i++){

						if(!empty($_FILES['verifypicture']['name'][$i])){
					
							$_FILES['verify']['name'] = $_FILES['verifypicture']['name'][$i];
							$_FILES['verify']['type'] = $_FILES['verifypicture']['type'][$i];
							$_FILES['verify']['tmp_name'] = $_FILES['verifypicture']['tmp_name'][$i];
							$_FILES['verify']['error'] = $_FILES['verifypicture']['error'][$i];
							$_FILES['verify']['size'] = $_FILES['verifypicture']['size'][$i];
					
						
							if($this->upload->do_upload('verify')){
								$uploadData1 = $this->upload->data();
								$filename = $uploadData1['file_name'];
								$wardata = array(
									'HisID'=>$resulthis,
									'AssetID'=>$view_assetid,
									'ImageName'=>$filename,
									'DocType'=>4,
									'ModifyBy'=>$userid,
									'ModifyDate'=>date('Y-m-d')
									);

									if(isset($verify_picturetitle[$i])){
									$wardata['ImageTitle']=$verify_picturetitle[$i];
									}

									$verifyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

							}
						}
					
					}
				}  
				$result['message'] = "successfully Verify";
				$result['status']=true;
				return $this->set_response($result, REST_Controller::HTTP_OK);
			} catch (Exception $e){ 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
		else{
			$result['message'] = "Token or some paremiters not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}





	public function removeasset_post(){

		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$userid=$arrdata['AutoID'];

					$view_uin = $this->input->post('view_uin');			
					$view_assetid = $this->input->post('view_assetid');
					$remove_condition = $this->input->post('remove_condition');
					$remove_status = $this->input->post('remove_status');
					$remove_address = $this->input->post('remove_address');
					$removepicturetitle = $this->input->post('removepicturetitle');

					$config['upload_path']   = '../upload/asset/'; 
					$config['allowed_types'] = 'jpg|png'; 
					$this->load->library('upload',$config);
					$this->upload->initialize($config);

					$data = array(
					'isRemove'=>1,
					'RemovedLocation'=>$remove_address,	
					'RemovedCondition'=>$remove_condition,	
					'RemovedBy'=>$userid,
					'RemovedDatetime'=>date("Y-m-d H:i:s")
					);

					$where = array(
					'AutoID'=>$view_assetid,
					);

					$resultId = $this->Commonmodel->common_update('AssetMst',$where,$data);

					$remove_hisdata = array(
						'AssetID'=>$view_assetid,	
						'RemoveStatus'=>$remove_status,	
						'type'=>2,	
						'VerifyCON'=>$remove_condition,	
						'VerifiedOrRemoveBY'=>$userid,
						'VerifiedOrRemoveDate'=>date("Y-m-d H:i:s")
						);

					$resulthis = $this->Commonmodel->common_insert('VerifyHST',$remove_hisdata);


					if(!empty($_FILES['removepicture'])){

			$wara_data = [];

			$count1 = count($_FILES['removepicture']['name']);

			for($i=0;$i<$count1;$i++){

				if(!empty($_FILES['removepicture']['name'][$i])){
			
				$_FILES['remove']['name'] = $_FILES['removepicture']['name'][$i];
				$_FILES['remove']['type'] = $_FILES['removepicture']['type'][$i];
				$_FILES['remove']['tmp_name'] = $_FILES['removepicture']['tmp_name'][$i];
				$_FILES['remove']['error'] = $_FILES['removepicture']['error'][$i];
				$_FILES['remove']['size'] = $_FILES['removepicture']['size'][$i];
		
			
				if($this->upload->do_upload('remove')){
					$uploadData1 = $this->upload->data();
					$filename = $uploadData1['file_name'];
					$wardata = array(
						'AssetID'=>$view_assetid,
						'HisID'=>$resulthis,
						'ImageName'=>$filename,
						'DocType'=>5,
						'ModifyBy'=>$userid,
						'ModifyDate'=>date('Y-m-d')
						);
						if(isset($removepicturetitle[$i])){
						$wardata['ImageTitle']=$removepicturetitle[$i];
						}

						$verifyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

				}
				}
			
			}
			}

			$mail = $this->phpmailer_lib->load();
		$from = 'testing@dahlia.tech';

		$removeasset_array = $this->Assetmodel->get_removeassetdetails($view_assetid);

		foreach($removeasset_array as $remove_result){

			$remove_address = $remove_result['RemovedLocation'];
			$remove_on = $remove_result['RemovedDatetime'];
			$remove_by = $remove_result['Rname'];
			$remove_condition = $remove_result['removecond'];
			$supervisoremail = $remove_result['supervisoremail'];

		}


	

		// $maildata = array(
		// 	'uin'=>$view_uin,	
		// 	'RemovedLocation'=>$remove_address,	
		// 	'RemovedCondition'=>$remove_condition,	
		// 	'RemovedBy'=>$remove_by,
		// 	'RemovedDatetime'=>$remove_on
		// 	);
		$uin=$view_uin;
			$RemovedLocation=$remove_address;	
			$RemovedCondition=$remove_condition;	
			$RemovedBy=$remove_by;
			$RemovedDatetime=$remove_on;

			


		$this->load->library('phpmailer_lib');
		$mail = $this->phpmailer_lib->load();
		$mail->ClearAddresses();
		$mail->ClearAttachments();
		$mail->isSMTP();
		$mail->Host     = 'smtp.office365.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'OTP@india-dahlia.com';
		$mail->Password = 'Huv199342';
		$mail->SMTPSecure = 'tls';
		$mail->Port     = 587;
		$mail->setFrom('OTP@india-dahlia.com', 'Barcode Recovery Password');
		$mail->addReplyTo('OTP@india-dahlia.com', 'Barcode Recovery Password');
		$mail->addAddress('sanjeev@dahlia.tech');
		$mail->setFrom('OTP@india-dahlia.com', 'Barcode Recovery Password');
		// Email body content
			// $mailContent = $this->load->view($email['template'],$data,TRUE);
			$mailContent = 'Urn id-'.$uin.' <br>
							Remove Location -'.$RemovedLocation.'	<br>
							Remove Condition -'.$remove_condition.' <br>
							Removed By- '.$remove_by.' <br>
							RemoveDate- '.$RemovedDatetime.' <br>
							';
			$mail->Body = $mailContent;
			

			// Send email
			if(!$mail->send()){
				// $mail->ErrorInfo;
					$result['message'] = $mail->ErrorInfo;
						$result['status']=false;
						return $this->set_response($result, 500);
			}else{
				// $message = "Mail send successfully";

						$result['message'] = "Mail send successfully";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
			}


					
				} catch (\Exception $e) 
					{ 
							$result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}

	}

	public function qrcodedata_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token']) && !empty($body['url'])){
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				/* $fullurl=$body['url'];
				$parts = parse_url($fullurl);
				parse_str($parts['query'], $query);
				$encoded=trim($query['ref_no']); */
				$encoded=trim($body['url']);
				$ciphering = "AES-128-CTR";
				$options = 0;
				$decryption_iv = '1234567891011121';
				// Store the decryption key
				$decryption_key = "dahliatech";
				$refno=openssl_decrypt ($encoded, $ciphering,$decryption_key, $options, $decryption_iv)??0;
				$qrcode_data =false;//$this->TravelModel->getid_from_qrdata($refno);
				if($qrcode_data){
					$result['data'] =$qrcode_data;
				}else{
					$result['refno'] =$refno;
				}
				
				$result['message'] = "success";
				$result['status']=true;
				return $this->set_response($result, REST_Controller::HTTP_OK);
			} catch (Exception $e) { 
				$result['message'] = "invalid data";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
		else{
			$result['message'] = "Token not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
	}



	public function get_locationlist_post(){
		$body=$this->request->body;
		$headers = apache_request_headers();
			if (!empty($headers['Token']) && !empty($body['cid'])) {
				try {
						$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
						$cid=$body['cid'];
						
						
						$result['locationlist'] = $this->Assetmodel->get_location_bycompanyid($cid);
						$result['message'] = "success";
						$result['status']=true;
						return $this->set_response($result, REST_Controller::HTTP_OK);
					} catch (\Exception $e) 
						{ 
							$result['message'] = "Invalid Token";
							$result['status']=false;
							return $this->set_response($result, 401);
						}
			}
			else{
				$result['message'] = "Token or Company Id not Found";
				$result['status']=false;
				return $this->set_response($result, 400);

			}
			
	}



		

		



				


	
	

}