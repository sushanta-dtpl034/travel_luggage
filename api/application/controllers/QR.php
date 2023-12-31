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
				$qrcode = str_replace(QRCODE_URL, '', $url);

				$isUsed=$this->TravelLuggageModel->checkQRCodeIsAssigned($qrcode);
				if($isUsed){
					return $this->set_response(['status'=>401,'error' => 'This QR Code Already Used.'], 401);
				}
			
				$this->Commonmodel->common_update('QRCodeDetailsMst',['QRCodeText' => $qrcode],['IsUsed'=>2,'alertedUserId' =>$userid,'alertedDateTime' =>date('Y-m-d H:i:s')]);

				$result['message'] ="Assigned successfully.";
				$result['status']=200;
				$result['data']=$this->TravelLuggageModel->getQRCodeListByUserId($userid);
				$status = 200;
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
					$result['status']=404;
					$result['data']=null;
					$status = 404;
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
	
}