<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TravelLuggageModel extends CI_Model {
	// constructor
	function __construct(){
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//$this->load->library('session');
	}
    function getItineraryListBYUserId($userId){
        $this->db->select('ih.*');
        $this->db->where('ih.UserID',$userId);
		$this->db->where('ih.IsDelete',0);
        $this->db->from('ItineraryHead as ih');
		//$this->db->join('ItineraryDetails as id','ih.AutoID = id.ItineraryHeadId','LEFT');
		$query=$this->db->get('');
		if($query){
			return $query->result();
		}else{
			return false;
		}
    }
    function checkItineraryLuggageDuplicate($userId,$ItineraryDetailId,$AutoID=""){
		$this->db->where('IsDelete',0);
		$this->db->where('UserID',$userId);
		$this->db->where('ItineraryDetailId',$ItineraryDetailId);
		if(!empty($AutoID)){
			$this->db->where_not_in('AutoID',$AutoID);
		}
		$query =$this->db->get('TravelLuggage');
		$dataResult = $query->num_rows();
		if($dataResult){
			return $dataResult;
		}else{
			return false;
		}
	}

	public function travelLuggageList($data,$arrdata){
        $this->db->select('tl.*,ih.SchedulerDescription, rm.Name,rm.Suffix,rm.ProfileIMG');
        $this->db->from('TravelLuggage as tl');
        $this->db->where('tl.IsDelete',0);
		if($arrdata['IsAdmin'] == 0 ){
			$this->db->where('tl.UserID',$arrdata['AutoID']);
		}
        
        $this->db->join('RegisterMST as rm','tl.UserID = rm.AutoID','LEFT');
        $this->db->join('ItineraryHead as ih','tl.ItineraryHeadId = ih.AutoID','LEFT');
		//$this->db->join('TravelLuggageImages as tli','tli.TravelLuggageID = tl.AutoID','LEFT');
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('tl.AutoID',$data['AutoID']);
		}else{	
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('tl.SchedulerDescription', trim($data['keyword']));
				$this->db->or_like('tl.QrCodeNo', trim($data['keyword']));
				$this->db->group_end();
			}else{
				$this->db->limit($data['length']);
				$this->db->offset($data['start']);
				$this->db->order_by('tl.AutoID','desc');
			}
		}
        $query=$this->db->get();
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$Requestlist = $query->row();
		}else{
			$Requestlist = $query->result();
		}
		
		if($Requestlist){
			foreach($Requestlist as $reqData){
				$images=$this->getTravelLuggageMoreImageList($reqData->AutoID);
				$imagArr = array();
				if($images){
					foreach($images AS $key=>$val){
						$imagArr[]=$val->ImageName;
					}
				}
				$reqData->LuggageMoreImages=$imagArr;
			}
			//get scaned history list
			$Requestlist = json_decode(json_encode($Requestlist),true);
			$draw = $this->input->post('draw');
			$total = $this->db->count_all_results('TravelLuggage');
			$totalFilter = count($Requestlist);
			
			//$images=$this->getTravelLuggageMoreImageList(22);
			$contents = array(
				"status"		=>200,
				"msg"			=>"data found",
				"data"			=>$Requestlist,
				"recordsTotal"	=>$total,
				"recordsFiltered"=>$total
			);			
			
		}else{
			$contents = array(
				"status"		=>200,
				"msg"			=>"data not found",
				"data"			=>[],
			);	
		}   
		return $contents;    
    }
	public function getTravelLuggageMoreImageList($TravelLuggageID){
		$this->db->select('AutoID,ImageName');
		$this->db->where('TravelLuggageID',$TravelLuggageID);
		$query=$this->db->get('TravelLuggageImages');
		if(!$query){
			return false;
		}
		return $query->result();
	}
	public function count_luggage_images($AutoID){
		$this->db->where('TravelLuggageID',$AutoID);
		$query=$this->db->get('TravelLuggageImages');
		$count =$query->num_rows();
		if($count >= 3){
			return true;
		}
		return false;
	}
	public function travelLuggageImagesData($AutoID){
		$this->db->where('AutoID',$AutoID);
		$query=$this->db->get('TravelLuggageImages');
		if(!$query){
			return false;
		}
		return $query->row();
	}
	public function travelLuggageImagesDelete($AutoID){
		$this->db->where('AutoID',$AutoID);
		$query=$this->db->delete('TravelLuggageImages');
		if(!$query){
			return false;
		}
		return true;
	}
	/**
	 * Assign QR Code 
	 */
	public function checkIsValidQRCode($qrcode){
		$this->db->where('QRCodeText',$qrcode);
		$query=$this->db->get('QRCodeDetailsMst');
		if($query){
			return $query->row();
		}
		return false;
	}
	public function checkQRCodeIsUsed($qrcode){
		$this->db->where('QRCodeText',$qrcode);
		$this->db->where('IsUsed',1);
		$query=$this->db->get('QRCodeDetailsMst');
		if($query){
			$count =$query->num_rows();
			if($count > 0){
				return true;
			}
		}
		return false;
	}

	public function checkQRCodeIsAssigned($qrcode,$userid){
		$this->db->where('QRCodeText',$qrcode);
		// $this->db->where('IsUsed !=',0);
		$this->db->where('IsUsed',2);
		$this->db->where('alertedUserId !=',$userid);
		$query=$this->db->get('QRCodeDetailsMst');
		if($query){
			$count =$query->num_rows();
			if($count > 0){
				return true;
			}
		}
		return false;
	}
	public function checkQRCodeAlreadyAssigned($qrcode,$userid){
		$this->db->where('QRCodeText',$qrcode);
		// $this->db->where('IsUsed !=',0);
		$this->db->where('IsUsed',2);
		//$this->db->where('alertedUserId ==',$userid);
		$query=$this->db->get('QRCodeDetailsMst');
		if($query){
			$count =$query->num_rows();
			if($count > 0){
				return true;
			}
		}
		return false;
	}
	
	public function getQRCodeListByUserId($userId){
		$this->db->select('QRCodeDetailsMst.*, rm.Name,rm.Suffix,rm.ProfileIMG');
		$this->db->from('QRCodeDetailsMst');
		$this->db->where('QRCodeDetailsMst.alertedUserId',$userId);
		$this->db->join('RegisterMST as rm','QRCodeDetailsMst.alertedUserId = rm.AutoID','LEFT');
		$query=$this->db->get();
		if(!$query){
			return false;
		}
		return $query->result();
	}
	public function check_qrcode_assigned_or_used($qrcode, $userId,$AutoID=""){
		if(!empty($AutoID)){
		}else{
			//$sql="SELECT * FROM QRCodeDetailsMst WHERE QRCodeText='$qrcode' AND alertedUserId=$userId";
			//1-Alloted to Luggage, 2-Alloted to User
			$this->db->where('QRCodeText',$qrcode);
			$query=$this->db->get('QRCodeDetailsMst');
			if($query){
				return $query->row();
			}
			return false;
		}		
	}

	
}