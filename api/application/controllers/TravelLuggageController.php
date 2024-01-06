<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
require FCPATH.'vendor/autoload.php';
use Com\Tecnick\Barcode\Barcode;
class TravelLuggageController extends REST_Controller {
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
  
    /**
	 * Get : Itinerary details API
	 */
    function getItineraryListBYUserId_get($userId){
        $headers = apache_request_headers();
        //$input_data=$this->request->body;
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $travelDetailsListObj = $this->TravelLuggageModel->getItineraryListBYUserId($userId);
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
	 * Post : Travel Luggage list  => Date:27-12-2023
	 */

	function travelLuggageList_post(){
        $headers = apache_request_headers();
        $input_data=$this->request->body;
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $travelDetailsListObj = $this->TravelLuggageModel->travelLuggageList($input_data,$arrdata);
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
	 * Post : Travel Luggage  add and update => Date:27-12-2023
	 */
    function addUpdateTravelLuggage_post(){
        $headers = apache_request_headers();
		$this->load->library('myLibrary');
        $input_data=$this->input->post();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];

				$this->form_validation->set_data($input_data);
				$this->form_validation->set_rules('UserID', 'User', 'required|trim');
				$this->form_validation->set_rules('ItineraryHeadId', 'Itinerary Name', 'required|trim');
				$this->form_validation->set_rules('LuggageName', 'Luggage Name', 'required|trim');
                if(empty($input_data['AutoID'])){
                    if(empty($_FILES['LuggageImage']['name']) && $_FILES['LuggageImage']['error'] != 0){
                        $this->form_validation->set_rules('LuggageImage', 'Luggage Image', 'required');	
                    }
                }
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();
					$this->output
					->set_status_header(406)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(["status"=>406,"errors"=>$errors]));                    
				}else{
					/* if(empty($input_data['AutoID'])){				
						$dataRegID = $this->TravelLuggageModel->checkItineraryLuggageDuplicate($input_data['UserID'], $input_data['ItineraryDetailId']);
					}else{
						$dataRegID = $this->TravelLuggageModel->checkItineraryLuggageDuplicate($input_data['UserID'], $input_data['ItineraryDetailId'],$input_data['AutoID']);
					} */
                    $dataRegID =0;
					if($dataRegID > 0){
						$result['message'] ="Travel Luggage already exists.";
						$result['status']=403;
						$status = 403;
					}else{
						$data = array(
							'UserID'            =>$input_data['UserID'],
							'ItineraryHeadId'   =>$input_data['ItineraryHeadId'],
							'LuggageName'       =>trim($input_data['LuggageName']),
							'LuggageRemarks'    =>trim($input_data['LuggageRemarks']),
							'LuggageColor'      =>trim($input_data['LuggageColor']),
							'BrandName'      	=>trim($input_data['BrandName']),
							'AppleAirTag'      	=>trim($input_data['AppleAirTag']),
							'QrCodeNo'      	=>trim($input_data['QrCodeNo']),
							'IsDelete'		    =>0,    //0-Active, 1-Inactive
							'IsActive'		    =>0,    //0-Live, 1-Delete
						);
						$picture = '';
						if(!empty($_FILES['LuggageImage']['name'])){
							if (!file_exists('../upload/luggage')) {
								mkdir('../upload/luggage', 0777, true);
							}
							$config['upload_path']   = '../upload/luggage/'; 
							$config['allowed_types'] = 'jpg|png|jpeg'; 
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('LuggageImage')){
								$uploadData = $this->upload->data();
								$picture ="upload/luggage/".$uploadData['file_name'];
							}else{ 
								$picture = '';  
							}
						}

						if(!empty($picture)){
							$data['LuggageImage']  =$picture;
						}
						
						if(empty($input_data['AutoID'])){
							$data['CreatedBy']  =$userid;
							$data['CreatedDate'] =date('Y-m-d H:i:s');
							$response =$this->Commonmodel->common_insert('TravelLuggage',$data);
							$result['message'] ="Created successfully.";
							$result['status']=201;
							$status = 201;

						}else{
							$data['ModifiedBy']  =$userid;
							$data['ModifiedDate'] =date('Y-m-d H:i:s');
							$where = array(
								'AutoID'    =>$input_data['AutoID'],
							);
							$response =$this->Commonmodel->common_update('TravelLuggage',$where,$data);
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
     * Delete : Travel luggage Delete
     */
    function deleteTravelLuggage_delete($AutoId){
        $headers = apache_request_headers();
        //$input_data=$this->request->body;        
		if (!empty($headers['Token'])) {
            try {
                $arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];
                $data['DeletedBy']  =$userid;
                $data['DeletedDate'] =date('Y-m-d H:i:s');
                $data['IsDelete']  =1;
                $where = array(
                    'AutoID'    =>$AutoId,
                );
                $response =$this->Commonmodel->common_update('TravelLuggage',$where,$data);
                $result['message'] ="Deleted successfully.";
                $result['status']=200;
                $status = 200;

                if($response){
                    $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($result));
                }else{
                    $this->output
                    ->set_status_header(500)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(["status"=>500,"message"=>"Error Occured."]));
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