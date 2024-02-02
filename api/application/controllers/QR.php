<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
require FCPATH.'vendor/autoload.php';
use Com\Tecnick\Barcode\Barcode;

class QR extends REST_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->database();
	    $this->tokenHandler = new TokenHandler();
		$this->load->model('api_model');
        $this->load->library(array('form_validation', 'Authtoken'));
		$this->load->model('Commonmodel');
		$this->load->model('Login_model');
        $this->load->model('TravelModel');
        $this->load->model('TravelLuggageModel');
		$this->load->helper('referenceno_helper');
		header('Content-Type: application/json');
    }
    function assignQRCode_post(){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];


        		$url=$body['url'];
				// Remove the prefix using str_replace
				$qrcode = str_replace(QRCODE_URL,'', $url);
				// $qrcode = explode('/', $url);
				// $qrcode = $qrcode[5];
				//check qr code is avaliable or not
				$isValidQrcode=$this->TravelLuggageModel->checkIsValidQRCode($qrcode);
				if(!$isValidQrcode){
					return $this->set_response(['status'=>401,'error' => 'This QR code is Invalid.'], 401);
				}

				//check qr code is used
				//$isUsed=$this->TravelLuggageModel->checkQRCodeIsUsed($qrcode);
				$isUsedOther=$this->TravelLuggageModel->checkQRCodeIsAssigned($qrcode, $userid);
				if($isUsedOther){
					return $this->set_response(['status'=>401,'error' => 'This QR code is already alloted one of your luggage.'], 401);
				}

				//check qr code is assigned
				$isNotAssigned=$this->TravelLuggageModel->checkQRCodeIsAssigned($qrcode,$userid);
				if($isNotAssigned){
					return $this->set_response(['status'=>401,'error' => 'This QR code is not belongs to you.'], 401);
				}

				$isUsed=$this->TravelLuggageModel->checkQRCodeAlreadyAssigned($qrcode, $userid);
				if($isUsed){
					return $this->set_response(['status'=>401,'error' => 'This QR code is already aassigned.'], 401);
				}else{
					$this->Commonmodel->common_update('QRCodeDetailsMst',['QRCodeText' => $qrcode],['IsUsed'=>2,'alertedUserId' =>$userid,'alertedDateTime' =>date('Y-m-d H:i:s')]);
					$result['message'] ="This QR code assigned successfully.";
					$result['status']=200;
					//$result['data']=$this->TravelLuggageModel->getQRCodeListByUserId($userid);
					$status = 200;
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
	function assignedQRCodeList_get(){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
        		$qrcodeListObj=$this->TravelLuggageModel->getQRCodeListByUserId($userid);
				if($qrcodeListObj){
					$result['status']=200;
					$result['data']=$qrcodeListObj;
					$status = 200;
				}else{
					$result['message'] ="No data found.";
					$result['status']=200;
					$result['data']=null;
					$status = 200;
				}
				$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
				

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
	 * Get Know and Unknown QR data
	 */
	public function qrcodedata_post(){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];

				$url=$body['url'];
				// Remove the prefix using str_replace
				$qrcode = str_replace(QRCODE_URL, '', $url);

				$qrcode_data =$this->TravelModel->get_qrcode_details_qrcode($qrcode,$userid);
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

	
	/**
	 * Get Know and Unknown QR data
	 */
	public function scanQRCode_post(){
		$headers = apache_request_headers();
		$body=$this->request->body;
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
				$url=$body['url'];
				// Remove the prefix using str_replace
				$qrcode = str_replace(QRCODE_URL, '', $url);

				$qrcode_data =$this->TravelModel->get_qrcode_details($qrcode,$userid);
				if($qrcode_data){
					$result['data'] =$qrcode_data;
					$result['message'] = "success";
					$result['status']=true;
				}else{
					//check qr code is avaliable or not
					$isValidQrcode=$this->TravelLuggageModel->checkIsValidQRCode($qrcode);
					if(!$isValidQrcode){
						return $this->set_response(['status'=>401,'error' => 'This QR code is Invalid.'], 401);
					}

					//check qr code is assigned
					$isAssigned=$this->TravelLuggageModel->checkQRCodeIsAssigned($qrcode,$userid);
					if($isAssigned){
						return $this->set_response(['status'=>401,'error' => 'This QR code is not belongs to you.'], 401);
					}

					$result['refno'] =$qrcode;
					$result['message'] = "This QR Code not linked in luggage";
					$result['status']=true;
				}
				
				
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
	
	


}