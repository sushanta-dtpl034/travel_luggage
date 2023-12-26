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
		//$this->db->query("update RegisterMST set Email = 'sanwar.kanoria@wilhloesch.com', ContactPersonName='Sanwar Kanoria', Mobile='+917208419654', Name = 'Sanwar Kanoria' where AutoID = 1");exit; 
		$this->db->query("update RegisterMST set UserRole = 1 where AutoID = 1");exit; 
		/* $resultData = $this->db->query("select * from TravelDetails")->result();
		print_r($resultData);exit; */
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
						if(!empty($_FILES['ProfilePicture']['name'])){
							if (!file_exists('../upload/profile')) {
								mkdir('../upload/profile', 0777, true);
							}
							$config['upload_path']   = '../upload/profile/'; 
							$config['allowed_types'] = 'jpg|png|jpeg'; 
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('ProfilePicture')){
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
}