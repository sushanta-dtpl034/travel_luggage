<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
require FCPATH.'vendor/autoload.php';
use Com\Tecnick\Barcode\Barcode;
class TravelController extends REST_Controller {
    public function __construct(){
        parent::__construct();
		$this->load->database();
	    $this->tokenHandler = new TokenHandler();
		$this->load->model('api_model');
        $this->load->library(array('form_validation', 'Authtoken'));
		$this->load->model('Commonmodel');
		$this->load->model('Login_model');
        $this->load->model('TravelModel');
		$this->load->helper('referenceno_helper');
		header('Content-Type: application/json');
    }
   
    public function index_get(){
        $headers = apache_request_headers();
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $status = 200;
                $this->output
                ->set_status_header($status)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($arrdata));
            
            } catch (Exception $e) { 
                $result['message'] = "Invalid Token";
                $result['status']=false;
                return $this->set_response($result, 401);
            }
        }else{
			$result['message'] = "Token or oldpasswor / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
       

    }
    /**
	 * Get : title prefix
	 */
    function getTitlePrefix_get(){
        $titlePrefixArray = TITLE_PREFIX;
        if(is_array($titlePrefixArray) && count($titlePrefixArray) > 0){
            $status = 200;
            $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(["status"=>200,"data"=>$titlePrefixArray]));
        }else{
            $this->output
            ->set_status_header(404)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(["status"=>404,"message"=>"No data found.", "data"=>null]));
        }
       
    }
    /**
	 * Get : travel types
	 */
    function getTravelTypes_get(){
        $travelTypesArray = TRAVEL_TYPES;
        if(is_array($travelTypesArray) && count($travelTypesArray) > 0){
            $status = 200;
            $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(["status"=>200,"data"=>$travelTypesArray]));
        }else{
            $this->output
            ->set_status_header(404)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(["status"=>404,"message"=>"No data found.", "data"=>null]));
        }
       
    }
     /**
	 * Get : Airlines
	 */
    function getAirlines_get(){
        $airlinesObj = $this->TravelModel->airlineList();
        if(is_array($airlinesObj) && count($airlinesObj) > 0){
            $status = 200;
            $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(["status"=>200,"data"=>$airlinesObj]));
        }else{
            $this->output
            ->set_status_header(404)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(["status"=>404,"message"=>"No data found.", "data"=>null]));
        }
       
    }
	/**
	 * Post : traveler list  => Date:27-12-2023
	 */

	function travelerDetails_post(){
        $headers = apache_request_headers();
        $input_data=$this->request->body;
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $travelDetailsListObj = $this->TravelModel->travelerDetailsList($input_data);
                if($travelDetailsListObj){
                    $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($travelDetailsListObj));
                }else{
                    $this->output
                    ->set_status_header(404)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(["status"=>404,"message"=>"No Data Found."]));
                }
                
               
            } catch (Exception $e) { 
                $result['message'] = "Invalid Token";
                $result['status']=false;
                return $this->set_response($result, 401);
            }
        }else{
			$result['message'] = "Token or oldpasswor / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
    }
     /**
	 * Post : Traveler  add and update => Date:27-12-2023
	 */
    function addUpdateTraveler_post(){
        $headers = apache_request_headers();
		$this->load->library('myLibrary');
        $input_data=$this->input->post();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$this->form_validation->set_data($this->post());
				$this->form_validation->set_rules('TitlePrefix', 'Title Prefix', 'required|trim');
				$this->form_validation->set_rules('Name', 'Name', 'required|trim');
				$this->form_validation->set_rules('PhoneNumber', 'Phone Number', 'required|trim');
				$this->form_validation->set_rules('Address', 'Address', 'required|trim');
				$this->form_validation->set_rules('Address2', 'Address2', 'required|trim');
	
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();
					$this->output
					->set_status_header(406)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(["status"=>406,"errors"=>$errors]));                    
				}else{
					if(empty($input_data['AutoID'])){				
						$dataRegID = $this->TravelModel->checkUserDuplicate($input_data['PhoneNumber']);
					}else{
						$dataRegID = $this->TravelModel->checkUserDuplicate($input_data['PhoneNumber'],$input_data['AutoID']);
					}
					if($dataRegID > 0){
						$result['message'] ="Phone Number already exists.";
						$result['status']=403;
						$status = 403;
					}else{
						$data = array(
							'Suffix'   		=>$input_data['TitlePrefix'],
							'Name'          =>trim($input_data['Name']),
							'Email'   		=>trim($input_data['Email']),
							'CountryCode'	=>trim($input_data['PhoneCountryCode']),
							'Mobile'		=>trim($input_data['PhoneNumber']),
							'WhatsAppCountryCode'=>trim($input_data['WhatsAppCountryCode']),
							'WhatsappNumber'=>trim($input_data['WhatsAppNumber']),
							'Address'       =>trim($input_data['Address']),
							'AdressTwo'      =>trim($input_data['Address2']),
							'Landmark'      =>trim($input_data['Landmark']),
							'Gender'   		=>trim($input_data['Gender']),
							'IsAdmin'		=>0,
							'isActive'		=>1,
							'IsDelete'		=>0,
						);
						$picture = '';
						if(!empty($_FILES['ProfileIMG']['name'])){
							if (!file_exists('../upload/profile')) {
								mkdir('../upload/profile', 0777, true);
							}
							$config['upload_path']   = '../upload/profile/'; 
							$config['allowed_types'] = 'jpg|png|jpeg'; 
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('ProfileIMG')){
								$uploadData = $this->upload->data();
								$picture ="upload/profile/".$uploadData['file_name'];
							}else{ 
								$picture = '';  
							}
						}

						if(!empty($picture)){
							$data['ProfileIMG']  =$picture;
						}
						
						if(empty($input_data['AutoID'])){
							$data['CreatedBy']  =$userid;
							$data['CreatedDate'] =date('Y-m-d H:i:s');
							$response =$this->Commonmodel->common_insert('RegisterMST',$data);
							$result['message'] ="Created successfully.";
							$result['status']=201;
							$status = 201;

						}else{
							
							$data['ModifyBy']  =$userid;
							$data['ModifyDate'] =date('Y-m-d H:i:s');
							$where = array(
								'AutoID'    =>$input_data['AutoID'],
							);
							$response =$this->Commonmodel->common_update('RegisterMST',$where,$data);
							$result['message'] ="Updated successfully.";
							$result['status']=200;
							$status = 200;

						}

					}
					$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
				}
			} catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or oldpasswor / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
		
    }
	/**
	 * Post : Itinerary add and update => Date:27-12-2023
	 */
	function addItinerary_post(){
		$headers = apache_request_headers();
		$this->load->library('myLibrary');
		$input_data=$this->request->body;
		$TravelUserId = $input_data['UserID'];
		//$Type = isset($input_data['Type']) ? $input_data['Type'] : '';
		$Hotel = isset($input_data['Hotel']) ? $input_data['Hotel'] : [];
		$Airtravel = isset($input_data['Airtravel']) ? $input_data['Airtravel'] : []; 
		$Landtravel = isset($input_data['Landtravel']) ? $input_data['Landtravel'] : [];
		$Traintravel = isset($input_data['Traintravel']) ? $input_data['Traintravel'] : [];
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$dataHead = array(
					'UserID'		=>$TravelUserId,
					'StartDate'		=>date('Y-m-d H:i:s', strtotime($input_data['StartDate'])),
					'EndDate'		=>date('Y-m-d H:i:s', strtotime($input_data['EndDate'])),
					'IsDelete'		=>0,
				); 
				if(empty($input_data['AutoID'])){	
					$dataHead['CreatedBy']  =$userid;
					$dataHead['CreatedDate'] =date('Y-m-d H:i:s');

					$QrCodeID =$this->Commonmodel->common_insert('ItineraryHead',$dataHead);
				}else{
					$dataHead['ModifiedBy']  =$userid;
					$dataHead['ModifiedDate'] =date('Y-m-d H:i:s');
					$where = array(
						'AutoID'    =>$input_data['AutoID'],
					);
					$QrCodeID =$input_data['AutoID'];
					$this->Commonmodel->common_update('ItineraryHead',$where,$dataHead);					
				}
			
				if(isset($Hotel) && count($Hotel) > 0){
					foreach($Hotel as $key => $val){
						$dataHotel = array(
							'ItineraryHeadId'=>$QrCodeID,
							'Type'			=>$val['Type'],
							'TravelType'	=>$val['HotelType'],
							'HotelName'		=>$val['HotelName'],
							'RoomNo'		=>$val['RoomNo'],
							'HotelAddress'	=>$val['HotelAddress'],
							'CheckInDate'	=>date('Y-m-d H:i:s', strtotime($val['CheckInDate'])),
							'CheckOutDate'	=>date('Y-m-d H:i:s', strtotime($val['CheckOutDate'])),
							'IsDelete'  	=> 0,
						);
						if(empty($val['AutoID'])){
							$dataHotel['CreatedBy']  =$userid;
							$dataHotel['CreatedDate'] =date('Y-m-d H:i:s');
							$response =$this->Commonmodel->common_insert('ItineraryDetails',$dataHotel);
						}else{
							$dataHotel['ModifiedBy']  =$userid;
							$dataHotel['ModifiedDate'] =date('Y-m-d H:i:s');
							$hotelWhere = array(
								'AutoID'    =>$val['AutoID'],
							);
							$this->Commonmodel->common_update('ItineraryDetails',$hotelWhere,$dataHotel);
						}
						
					}
					$result['message'] ="Created successfully.";
					$result['status']=201;
					$status = 201;
				}
				
				if(isset($Airtravel) && count($Airtravel) > 0){
					foreach($Airtravel AS $key => $val){
						$dataTravel = array(
							'ItineraryHeadId'	=>$QrCodeID,
							'Type'			=>$val['Type'],
							'AirlineName'	=>$val['AirlineName'],
							'TravelType'	=>$val['TravelType'],
							'TravelFrom'	=>$val['TravelFrom'],
							'TravelTo'		=>$val['TravelTo'],
							'PnrNo'			=> $val['PnrNo'],
							'TravelStartDateTime'=>date('Y-m-d H:i:s', strtotime($val['TravelStartDateTime'])),
							'TravelEndDateTime'	=>date('Y-m-d H:i:s', strtotime($val['TravelEndDateTime'])),
							'IsDelete'  		=> 0,
						);
						if(empty($val['AutoID'])){
							$dataTravel['CreatedBy']  =$userid;
							$dataTravel['CreatedDate'] =date('Y-m-d H:i:s');
							$response =$this->Commonmodel->common_insert('ItineraryDetails',$dataTravel);
						}else{
							$dataTravel['ModifiedBy']  =$userid;
							$dataTravel['ModifiedDate'] =date('Y-m-d H:i:s');
							$TravelWhere = array(
								'AutoID'    =>$val['AutoID'],
							);
							$this->Commonmodel->common_update('ItineraryDetails',$TravelWhere,$dataTravel);
						}

					}
					$result['message'] ="Created successfully.";
					$result['status']=201;
					$status = 201;
				} 
				if(isset($Landtravel) && count($Landtravel) > 0){
					foreach($Landtravel AS $key => $val){
						$dataLandtravel = array(
							'ItineraryHeadId'	=>$QrCodeID,
							'Type'			=>$val['Type'],
							'LandTransferType'=>$val['LandTransferType'],
							'VehicleNo'		=>$val['VehicleNo'],
							'startDateTime'	=>date('Y-m-d H:i:s', strtotime($val['startDateTime'])),
							'EndDateTime'	=>date('Y-m-d H:i:s', strtotime($val['EndDateTime'])),
							'TravelFrom'	=>$val['TravelFrom'],
							'TravelTo'		=>$val['TravelTo'],
							'IsDelete'  	=> 0,
						);
						if(empty($val['AutoID'])){
							$dataTravel['CreatedBy']  =$userid;
							$dataLandtravel['CreatedDate'] =date('Y-m-d H:i:s');
							$dataLandtravel =$this->Commonmodel->common_insert('ItineraryDetails',$dataLandtravel);
						}else{
							$dataLandtravel['ModifiedBy']  =$userid;
							$dataLandtravel['ModifiedDate'] =date('Y-m-d H:i:s');
							$LandtravelWhere = array(
								'AutoID'    =>$val['AutoID'],
							);
							$this->Commonmodel->common_update('ItineraryDetails',$LandtravelWhere,$dataLandtravel);
						}

					}
					$result['message'] ="Created successfully.";
					$result['status']=201;
					$status = 201;
				}
				if(isset($Traintravel) && count($Traintravel) > 0){
					foreach($Traintravel AS $key => $val){
						$dataTraintravel = array(
							'ItineraryHeadId'=>$QrCodeID,
							'Type'			=>$val['Type'],
							'TrainName'		=>$val['TrainName'],
							'TrainNumber'	=>$val['TrainNumber'],
							'StartDate'		=>date('Y-m-d H:i:s', strtotime($val['StartDate'])),
							'EndDate'		=>date('Y-m-d H:i:s', strtotime($val['EndDate'])),
							'PnrNo'			=>$val['PnrNo'],
							'TravelFrom'	=>$val['TravelFrom'],
							'TravelTo'		=>$val['TravelTo'],
							'IsDelete'  	=> 0,
						);
						if(empty($val['AutoID'])){
							$dataTraintravel['CreatedBy']  =$userid;
							$dataTraintravel['CreatedDate'] =date('Y-m-d H:i:s');
							$dataLandtravel =$this->Commonmodel->common_insert('ItineraryDetails',$dataTraintravel);
						}else{
							$dataTraintravel['ModifiedBy']  =$userid;
							$dataTraintravel['ModifiedDate'] =date('Y-m-d H:i:s');
							$TraintravelWhere = array(
								'AutoID'    =>$val['AutoID'],
							);
							$this->Commonmodel->common_update('ItineraryDetails',$TraintravelWhere,$dataTraintravel);
						}

					}
					$result['message'] ="Created successfully.";
					$result['status']=201;
					$status = 201;
				}

				if(empty($input_data['AutoID'])){	
					$result['message'] ="Created successfully.";
					$result['status']=201;
					$status = 201;
				}else{
					$result['message'] ="Updated successfully.";
					$result['status']=200;
					$status = 200;
				}
				
				$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
				
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
	/**
	 * Post : Itinerary List API => Date:27-12-2023
	 */
	function TravelerItineraryDetails_post(){
		$headers = apache_request_headers();
		$input_data=$this->request->body;
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$travelDetailsListObj = $this->TravelModel->travelerListDetails($input_data);
				if($travelDetailsListObj){
					$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($travelDetailsListObj));
				}else{
					$this->output
					->set_status_header(404)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(["status"=>404,"message"=>"No Data Found."]));
				}
			}catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or oldpassword / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);
		}
	}

	function alertRoomUpdate_post(){
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$input_data=$this->input->post();
				$RoomNo = $input_data['RoomNo'];
				$travel_id =$input_data['travel_id'];
				$response=$this->TravelModel->alert_room_no($travel_id,$RoomNo);
				if($response){
					$google_address= getGoogleAddressByLatLong(trim($input_data['Lattitude']),trim($input_data['Longitude']));
					//Qr Code scanned record add
					$scanned_data=[
						'TravelDetailID'    =>$input_data['travel_id'],
						'ScanedBy'          =>$userid,
						'Lattitude'         =>trim($input_data['Lattitude']),
						'Longitude'         =>trim($input_data['Longitude']),
						'CreatedBy'         =>$userid,
						'CreatedDate'       =>date('Y-m-d H:i:s'),
						'Address'           =>$google_address
					];
					$this->Commonmodel->common_insert('QRScanHistory',$scanned_data);
					$result['message'] ="Updated successfully.";
					$result['status']=201;
					$status = 201;
					return $this->set_response($result, 200);
				}else{
					$result['message'] = "Invalid Data";
					$result['status']=false;
					return $this->set_response($result, 401);
				}
			} catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}
	}








	

    /**
	 * Post : travel details list
	 */

    function travelDetails_post(){
        $headers = apache_request_headers();
        $input_data=$this->request->body;
     
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $travelDetailsListObj = $this->TravelModel->travelDetailsList($input_data);
                if($travelDetailsListObj){
                    $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($travelDetailsListObj));
                }else{
                    $this->output
                    ->set_status_header(404)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(["status"=>404,"message"=>"No Data Found."]));
                }
                
               
            } catch (Exception $e) { 
                $result['message'] = "Invalid Token";
                $result['status']=false;
                return $this->set_response($result, 401);
            }
        }else{
			$result['message'] = "Token or oldpasswor / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
    }
     /**
	 * Post : travel details add and update
	 */
    function addUpdateTravelDetails_post(){
        $headers = apache_request_headers();
		$this->load->library('myLibrary');
        $input_data=$this->input->post();
		//$this->db->query("truncate table TravelHead");
		//$this->db->query("truncate table TravelDetails");
		//$this->db->query("truncate table QRScanHistory");exit;
		//$this->db->query("Delete from RegisterMST where AutoID = 55");
		//$this->db->query("update RegisterMST set Email = 'sanwar.kanoria@wilhloesch.com', ContactPersonName='Sanwar Kanoria', Mobile='+917208419654', Name = 'Sanwar Kanoria' where AutoID = 1");exit; 
		//$this->db->query("update RegisterMST set UserRole = 1 where AutoID = 1");exit; 
		//$resultData = $this->db->query("select * from RegisterMST")->result();
		//print_r($resultData);exit; 
		$type = $input_data['type'];
		if($type){
			if (!empty($headers['Token'])) {
				try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$userid=$arrdata['AutoID'];
					$this->form_validation->set_data($this->post());
					/* $this->form_validation->set_rules('QrCodeNo', 'Qr Code', 'required'); */
					$this->form_validation->set_rules('TitlePrefix', 'Title Prefix', 'required|trim');
					$this->form_validation->set_rules('Name', 'Name', 'required|trim');
					$this->form_validation->set_rules('PhoneNumber', 'Phone Number', 'required|trim');
					$this->form_validation->set_rules('Address', 'Address', 'required|trim');
					$this->form_validation->set_rules('Address2', 'Address2', 'required|trim');
		
					if ($this->form_validation->run() == FALSE){
						$errors = $this->form_validation->error_array();
						$this->output
						->set_status_header(406)
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode(["status"=>406,"errors"=>$errors]));                    
					}else{
						$picture = '';
						if(!empty($_FILES['files']['name'])){
							if (!file_exists('../upload/profile')) {
								mkdir('../upload/profile', 0777, true);
							}
							$config['upload_path']   = '../upload/profile/'; 
							$config['allowed_types'] = 'jpg|png|jpeg'; 
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('files')){
								$uploadData = $this->upload->data();
								$picture ="upload/profile/".$uploadData['file_name'];
							}else{ 
								$picture = '';  
							}
						}
						$dataRegID = $this->TravelModel->checkUserDuplicate($input_data['PhoneNumber']);
						if($dataRegID > 0){
							$dataRegisterMst = array(
								'Address'=>trim($input_data['Address']),
								'ContactPersonName'=>trim($input_data['Name']),
								'OfficePhoneNumber'=>trim($input_data['PhoneNumber']),
								'ContactPersonMobile'=>!empty(trim($input_data['AltPhoneNumber']))?$input_data['AltPhoneNumber']:NULL,
								'UserName'=>trim($input_data['Name']),
								'ModifyDate'=>date('Y-m-d H:i:s'),
								'ModifyBy'=>$userid,
								'ProfileIMG'=>$picture
							);
							$where = array(
								'AutoID'    =>$dataRegID,
							);
							$this->Commonmodel->common_update('RegisterMST',$where,$dataRegisterMst);
							$regid =$dataRegID; 
						}else{
							$dataRegisterMst = array(
								'CompanyName'=>'',
								'Address'=>trim($input_data['Address']),
								'City'=>'',
								'State'=>'',
								'Pincode'=>'',
								'Country'=>'',
								'GstNo'=>'',
								'Email'=>'',
								'ContactPersonName'=>trim($input_data['Name']),
								'OfficePhoneNumber'=>trim($input_data['PhoneNumber']),
								'ContactPersonMobile'=>!empty(trim($input_data['AltPhoneNumber']))?$input_data['AltPhoneNumber']:NULL,
								'UserName'=>trim($input_data['PhoneNumber']),
								'Password'=>password_hash(trim($input_data['PhoneNumber']).'@123',PASSWORD_DEFAULT),
								'isApprove'=>'',
								'isActive'=>'',
								'NotifyDate'=>'',
								'PlanId'=>'',
								'CreatedDate'=>date('Y-m-d H:i:s'),
								'CreatedBy'=>$userid,
								'ModifyDate'=>'',
								'ModifyBy'=>'',
								'IsDelete'=>0,
								'DeleteBy'=>'',
								'DeleteDate'=>'',
								'CompanyCode'=>'',
								'DatabaseName'=>'',
								'DatabaseUser'=>'',
								'DatabasePass'=>'',
								'UserRole'=>3,
								'PaidStatus'=>'',
								'PaidDate'=>'',
								'PaymentStatus'=>'',
								'PaymentDate'=>'',
								'PaymentMode'=>'',
								'VerifiedDate'=>'',
								'VerifiedBy'=>'',
								'TransactionNumber'=>'',
								'CardNumber'=>'',
								'AccountNumber'=>'',
								'AccountHolderName'=>'',
								'BankName'=>'',
								'IfscCode'=>'',
								'UpiTranNumber'=>'',
								'UpiId'=>'',
								'ReceivedDate'=>'',
								'Notes'=>'',
								'Pan'=>'',
								'TaxID'=>'',
								'ProfileIMG'=>$picture,
								'UserGroupID'=>'',
								'ParentID'=>'',
								'Name'=>trim($input_data['Name']),
								'Mobile'=>$input_data['PhoneCountryCode'].trim($input_data['PhoneNumber']),
								'EmployeeCode'=>'',
								'GroupID'=>'',
								'import_status'=>'',
								'from_status'=>'',
								'IsAdmin'=>0,
								'Isauditor'=>'',
								'issupervisor'=>'',
								'Suffix'=>'',
							);
							$regid = $this->Commonmodel->common_insert('RegisterMST',$dataRegisterMst);
						}
						
						$data = array(
							'TitlePrefix'   =>$input_data['TitlePrefix'],
							'Name'          =>trim($input_data['Name']),
							'PhoneNumber'   =>trim($input_data['PhoneNumber']),
							'AltPhoneNumber'=>!empty(trim($input_data['AltPhoneNumber']))?$input_data['AltPhoneNumber']:NULL,
							'Address'       =>trim($input_data['Address']),
							'Address2'      =>trim($input_data['Address2']),
							'Landmark'      =>!empty(trim($input_data['Landmark']))?trim($input_data['Landmark']):NULL,
							'TraavelType'   =>!empty($input_data['TraavelType'])?$input_data['TraavelType']:NULL,
							'TraavelFrom'   =>!empty(trim($input_data['TraavelFrom']))?trim($input_data['TraavelFrom']):NULL,
							'TraavelTo'     =>!empty(trim($input_data['TraavelTo']))?trim($input_data['TraavelTo']):NULL,
							'TravelDate'    =>!empty($input_data['TravelDate'])?date('Y-m-d H:i:s',strtotime($input_data['TravelDate'])):NULL,
							'HotelName'     =>!empty(trim($input_data['HotelName']))?trim($input_data['HotelName']):NULL,
							//'RoomNo'        =>!empty(trim($input_data['RoomNo']))?$input_data['RoomNo']:NULL,
							'CheckInDate'   =>!empty($input_data['CheckInDate'])?date('Y-m-d H:i:s',strtotime($input_data['CheckInDate'])):NULL,
							'CheckOutDate'  =>!empty($input_data['CheckOutDate'])?date('Y-m-d H:i:s',strtotime($input_data['CheckOutDate'])):NULL,
							'CreatedBy'     =>$userid,
							'CreatedDate'   =>date('Y-m-d H:i:s'),
							'ProfilePicture'  =>$picture,
							'PhoneCountryCode'      =>!empty(trim($input_data['PhoneCountryCode']))?trim($input_data['PhoneCountryCode']):NULL,
							'WhatsAppCountryCode'   =>!empty(trim($input_data['WhatsAppCountryCode']))?trim($input_data['WhatsAppCountryCode']):NULL,
							'PnrNo'                 =>!empty(trim($input_data['PnrNo']))?trim($input_data['PnrNo']):NULL,
							'AirlineName'           =>!empty(trim($input_data['AirlineName']))?trim($input_data['AirlineName']):NULL,
							'UserID' 				=> $regid,
						);
						if(empty($input_data['AutoID'])){
							$NewCountRow=$this->Commonmodel->getlast_row() + 1;
							$this->mylibrary->generate(create_refno($NewCountRow));
							$data['CreatedBy']  =$userid;
							$data['CreatedDate'] =date('Y-m-d H:i:s');
							$data['QrCodeNo'] =create_refno($NewCountRow);
							$response =$this->Commonmodel->common_insert('TravelDetails',$data);
							$result['message'] ="Created successfully.";
							$result['status']=201;
							$status = 201;

							// update in qrcode is used in QRCodeDetailsMst
							/* $qr_where = array(
								'QRCodeText'    =>$input_data['QrCodeNo'],
							);
							$this->Commonmodel->common_update('QRCodeDetailsMst',$qr_where,['IsUsed' => 1]); */

							$google_address= getGoogleAddressByLatLong(trim($input_data['Lattitude']),trim($input_data['Longitude']));
							//Qr Code scanned record add
							$scanned_data=[
								'TravelDetailID'    => $response,
								'ScanedBy'          =>$userid,
								'Lattitude'         =>trim($input_data['Lattitude']),
								'Longitude'         =>trim($input_data['Longitude']),
								'CreatedBy'         =>$userid,
								'CreatedDate'       =>date('Y-m-d H:i:s'), 
								'Address'           =>$google_address
							];
							$this->Commonmodel->common_insert('QRScanHistory',$scanned_data);

						}else{
							$data['ModifiedBy']  =$userid;
							$data['ModifiedDate'] =date('Y-m-d H:i:s');

							$where = array(
								'AutoID'    =>$input_data['AutoID'],
							);
							$response =$this->Commonmodel->common_update('TravelDetails',$where,$data);
							$result['message'] ="Updated successfully.";
							$result['status']=200;
							$status = 200;
							// update in qrcode is used in QRCodeDetailsMst
							/* $qr_where = array(
								'QRCodeText'    =>trim($input_data['QrCodeNo']),
							);
							$qr_data['IsUsed']=1;
							$this->Commonmodel->common_update('QRCodeDetailsMst',$qr_where,$qr_data); */

							$google_address= getGoogleAddressByLatLong(trim($input_data['Lattitude']),trim($input_data['Longitude']));
							//Qr Code scanned record add
							$scanned_data=[
								'TravelDetailID'    =>$input_data['AutoID'],
								'ScanedBy'          =>$userid,
								'Lattitude'         =>trim($input_data['Lattitude']),
								'Longitude'         =>trim($input_data['Longitude']),
								'CreatedBy'         =>$userid,
								'CreatedDate'       =>date('Y-m-d H:i:s'),
								'Address'           =>$google_address
							];
							$this->Commonmodel->common_insert('QRScanHistory',$scanned_data);
						}
						
						//return $this->set_response($result, REST_Controller::HTTP_OK);
						$this->output
						->set_status_header($status)
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($result));
					}
				} catch (Exception $e) { 
					$result['message'] = "Invalid Token";
					$result['status']=false;
					return $this->set_response($result, 401);
				}
			}else{
				$result['message'] = "Token or oldpasswor / newpassword not Found";
				$result['status']=false;
				return $this->set_response($result, 400);

			}
		}else{
			//$QrCode = $input_data['QrCodeNo'];
		}
    }
	
	
	/*
	function addUpdateTraveler_post(){
        $headers = apache_request_headers();
		$this->load->library('myLibrary');
        $input_data=$this->input->post();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$this->form_validation->set_data($this->post());
				$this->form_validation->set_rules('TitlePrefix', 'Title Prefix', 'required|trim');
				$this->form_validation->set_rules('Name', 'Name', 'required|trim');
				$this->form_validation->set_rules('PhoneNumber', 'Phone Number', 'required|trim');
				$this->form_validation->set_rules('Address', 'Address', 'required|trim');
				$this->form_validation->set_rules('Address2', 'Address2', 'required|trim');
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();
					$this->output
					->set_status_header(406)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(["status"=>406,"errors"=>$errors]));                    
				}else{
					$picture = '';
					if(!empty($_FILES['files']['name'])){
						if (!file_exists('../upload/profile')) {
							mkdir('../upload/profile', 0777, true);
						}
						$config['upload_path']   = '../upload/profile/'; 
						$config['allowed_types'] = 'jpg|png|jpeg'; 
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						if($this->upload->do_upload('files')){
							$uploadData = $this->upload->data();
							$picture ="upload/profile/".$uploadData['file_name'];
						}else{ 
							$picture = '';  
						}
					}
					$dataRegID = $this->TravelModel->checkUserDuplicate($input_data['PhoneNumber']);
					//if($dataRegID > 0){
					if(!empty($input_data['AutoID'])){
						$dataRegisterMst = array(
							'Suffix'=>$input_data['TitlePrefix'],
							'Address'=>trim($input_data['Address']),
							'City'=>trim($input_data['Address2']),
							'State'=>!empty(trim($input_data['Landmark']))?trim($input_data['Landmark']):NULL,
							'ContactPersonName'=>trim($input_data['Name']),
							'OfficePhoneNumber'=>trim($input_data['PhoneNumber']),
							'ContactPersonMobile'=>$input_data['WhatsupNumber'],
							'CompanyCode'=>$input_data['WhatsAppCountryCode'],
							'UserName'=>trim($input_data['Name']),
							'ModifyDate'=>date('Y-m-d H:i:s'),
							'ModifyBy'=>$userid
							//'ProfileIMG'=>$picture
						);
						$where = array(
							'AutoID'    =>$dataRegID,
						); 
						if($picture != ''){
							$dataRegisterMst['ProfileIMG'] = $picture;
						}
						$this->Commonmodel->common_update('RegisterMST',$where,$dataRegisterMst);
						$regid =$dataRegID; 
						$result['message'] ="Updated successfully.";
						$result['status']=200;
						$status = 200;
					}else{
						if($dataRegID == 0){
							$dataRegisterMst = array(
								'Address'=>trim($input_data['Address']),
								'City'=>trim($input_data['Address2']),
								'State'=>!empty(trim($input_data['Landmark']))?trim($input_data['Landmark']):NULL,
								'ContactPersonName'=>trim($input_data['Name']),
								'OfficePhoneNumber'=>trim($input_data['PhoneNumber']),
								'ContactPersonMobile'=>$input_data['WhatsupNumber'],
								'CompanyCode'=>$input_data['WhatsAppCountryCode'],
								'UserName'=>trim($input_data['PhoneNumber']),
								'Password'=>password_hash(trim($input_data['PhoneNumber']).'@123',PASSWORD_DEFAULT),
								'CreatedDate'=>date('Y-m-d H:i:s'),
								'CreatedBy'=>$userid,
								'Country'=>!empty(trim($input_data['PhoneCountryCode']))?trim($input_data['PhoneCountryCode']):NULL,
								'UserRole'=>3,
								'ProfileIMG'=>$picture,
								'Name'=>trim($input_data['Name']),
								'Mobile'=>$input_data['PhoneCountryCode'].trim($input_data['PhoneNumber']),
								'IsAdmin'=>0,
								'Suffix'=>$input_data['TitlePrefix'],
							);
							$regid = $this->Commonmodel->common_insert('RegisterMST',$dataRegisterMst);
							$result['message'] ="Created successfully.";
							$result['status']=201;
							$status = 201;
						}else{
							$result['message'] = "Contact Number already exist!";
							$result['status']=false;
							return $this->set_response($result, 401);
						}
					}
					$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
				}
			}catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or oldpassword / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);
		}
	}
	*/
	
	function TravelerList_post(){
		$headers = apache_request_headers();
		$input_data=$this->request->body;
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$travelDetailsListObj = $this->TravelModel->travelerList($input_data);
				if($travelDetailsListObj){
					$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($travelDetailsListObj));
				}else{
					$this->output
					->set_status_header(404)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(["status"=>404,"message"=>"No Data Found."]));
				}
			}catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or oldpassword / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);
		}
	}

	function deleteData_post(){
		print_r($this->db->query('SELECT* FROM TravelDetails')->result_array());
	}
	
	
}