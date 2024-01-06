<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class TravelController extends REST_Controller {
    public function __construct(){
        parent::__construct();
		$this->load->database();
        // Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
        
	    $this->tokenHandler = new TokenHandler();
		$this->load->model('api_model');
        $this->load->library(array('form_validation', 'Authtoken'));
		$this->load->model('Commonmodel');
		$this->load->model('Login_model');
        $this->load->model('TravelModel');
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
        $input_data=$this->input->post();
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $this->form_validation->set_data($this->post());
                $this->form_validation->set_rules('QrCodeNo', 'Qr Code', 'required');
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
                    $data = array(
                        'QrCodeNo'      =>trim($input_data['QrCodeNo']),
                        'TitlePrefix'   =>$input_data['TitlePrefix'],
                        'Name'          =>trim($input_data['Name']),
                        'PhoneNumber'   =>$input_data['PhoneNumber'],
                        'AltPhoneNumber'=>$input_data['AltPhoneNumber'],
                        'Address'       =>trim($input_data['Address']),
                        'Address2'      =>trim($input_data['Address2']),
                        'Landmark'      =>trim($input_data['Landmark']),
                        'TraavelType'   =>$input_data['TraavelType'],
                        'TraavelFrom'   =>trim($input_data['TraavelFrom']),
                        'TraavelTo'     =>trim($input_data['TraavelTo']),
                        'TravelDate'    =>date('Y-m-d H:i:s',strtotime($input_data['TravelDate'])),
                        'HotelName'     =>trim($input_data['HotelName']),
                        'RoomNo'        =>$input_data['RoomNo'],
                        'CheckInDate'   =>date('Y-m-d H:i:s',strtotime($input_data['CheckInDate'])),
                        'CheckOutDate'  =>date('Y-m-d H:i:s',strtotime($input_data['CheckOutDate'])),
                        'CreatedBy'     =>$userid,
                        'CreatedDate'   =>date('Y-m-d H:i:s'),
                    );
                    if (!file_exists('../upload/profile')) {
                        mkdir('../upload/profile', 0777, true);
                    }

                    if(!empty($_FILES['ProfilePicture']['name'])){
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
                        $data['ProfilePicture']  =$picture;
                    }
                    

                    if(empty($input_data['AutoID'])){
                        $data['CreatedBy']  =$userid;
                        $data['CreatedDate'] =date('Y-m-d H:i:s');
                        $response =$this->Commonmodel->common_insert('TravelDetails',$data);
                        $result['message'] ="Created successfully.";
                        $result['status']=201;
                        $status = 201;

                        // update in qrcode is used in QRCodeDetailsMst
                        $qr_where = array(
                            'QRCodeText'    =>$input_data['QrCodeNo'],
                        );
                        $this->Commonmodel->common_update('QRCodeDetailsMst',$qr_where,['IsUsed' => 1]);

                        //Qr Code scanned record add
                        $scanned_data=[
                            'TravelDetailID'    => $response,
                            'ScanedBy'          =>$userid,
                            'Lattitude'         =>trim($input_data['Lattitude']),
                            'Longitude'         =>trim($input_data['Longitude']),
                            'CreatedBy'         =>$userid,
                            'CreatedDate'       =>date('Y-m-d H:i:s'),
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
                        $qr_where = array(
                            'QRCodeText'    =>trim($input_data['QrCodeNo']),
                        );
                        $qr_data['IsUsed']=1;
                        $this->Commonmodel->common_update('QRCodeDetailsMst',$qr_where,$qr_data);

                        //Qr Code scanned record add
                        $scanned_data=[
                            'TravelDetailID'    =>$input_data['AutoID'],
                            'ScanedBy'          =>$userid,
                            'Lattitude'         =>trim($input_data['Lattitude']),
                            'Longitude'         =>trim($input_data['Longitude']),
                            'CreatedBy'         =>$userid,
                            'CreatedDate'       =>date('Y-m-d H:i:s'),
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
    }
}