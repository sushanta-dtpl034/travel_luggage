<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TravelModel extends CI_Model {
	// constructor
	function __construct(){
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//$this->load->library('session');
	}
	function airlineList(){
		$this->db->select('AutoID,Name');
		$query=$this->db->get('AirlineMst');
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	public function travelerDetailsList($data,$parentId){
		$this->db->select("*,(CASE WHEN ParentId=0 THEN 'Primary' ELSE 'Guest' END) AS TravellerType");
        $this->db->from('RegisterMST');
        $this->db->where('IsDelete',0);
		$this->db->where('IsAdmin',0);
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('AutoID',$data['AutoID']);
		}else{	
			if($parentId > 0){
				$this->db->where('ParentId',$parentId);
				$this->db->or_where('AutoID',$parentId);
			}


			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('Name', trim($data['keyword']));
				$this->db->or_like('PhoneNumber', trim($data['keyword']));
				$this->db->group_end();
			}else{
				$this->db->limit($data['length']);
				$this->db->offset($data['start']);
				$this->db->order_by('AutoID','desc');
			}
		}
        $query=$this->db->get();
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$Requestlist = $query->row();
			$scan_history_data=$this->getQRScanHistory($Requestlist->AutoID);
			$Requestlist->scan_history_data=$scan_history_data;
		}else{
			$Requestlist = $query->result();
			foreach($Requestlist as $res){
				$scan_history_data=$this->getQRScanHistory($res->AutoID);
				$res->scan_history_data=$scan_history_data;
			}
		}
		
		if($Requestlist){
			//get scaned history list
			$Requestlist = json_decode(json_encode($Requestlist),true);
			$draw = $this->input->post('draw');
			$total = $this->db->where('IsDelete',0)->count_all_results('RegisterMST');
			$totalFilter = count($Requestlist);
			// if(!empty($keyword)) {
			// 	$totalFilter = count($Requestlist);
			// }
			$contents = array(
				"status"		=>200,
				"msg"			=>"data found",
				"data"			=>$Requestlist,
				"draw"			=>$draw,
				"recordsTotal"	=>$total,
				"recordsFiltered"=>$total
			);			
			return $contents;
		}else{
			return false;
		}       
    }
	function checkUserDuplicate($mob, $AutoID=""){
		$this->db->where('IsDelete',0);
		$this->db->where('Mobile',$mob);
		if(!empty($AutoID)){
			$this->db->where_not_in('AutoID',$AutoID);
		}
		$query =$this->db->get('RegisterMST');
		$dataResult = $query->num_rows();
		if($dataResult){
			return $dataResult;
		}else{
			return false;
		}
	}
	public function travelerItineraryListDetails($data){ 
        $query=$this->db->select("rm.AutoID,rm.Name,rm.Mobile,rm.Suffix AS TitlePrefix,rm.ProfileIMG,ih.AutoID AS ItineraryHeadId,ih.UserID,ih.StartDate,ih.EndDate, ih.CreatedDate,ih.ModifiedDate,ih.ItineraryName");
        $this->db->from('ItineraryHead as ih');//ItineraryDetails
		$this->db->join('RegisterMST as rm','ih.UserID = rm.AutoID','LEFT');
        $this->db->where('ih.IsDelete',0);
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('ih.AutoID',$data['AutoID']);
		}else{	
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('Name', trim($data['keyword']));
				$this->db->group_end();
			}else{
				$this->db->limit($data['length']);
				$this->db->offset($data['start']);
				$this->db->order_by('AutoID','desc');
			}
		}
        $query=$this->db->get();
		
		$Requestlist = $query->result();
		if($Requestlist){
			foreach($Requestlist as $res){
				$scan_history_data = $this->getTravelItineraryDetails($res->ItineraryHeadId);
				$res->Itinerary=$scan_history_data;
				$scan_history_data=$this->getQRScanHistory($res->ItineraryHeadId);
				$res->scan_history_data=$scan_history_data;
			}
			$Requestlist = json_decode(json_encode($Requestlist),true);
			$draw = $this->input->post('draw');
			$total = $this->db->where('ItineraryHead.IsDelete',0)->count_all_results('ItineraryHead');
			$totalFilter = count($Requestlist);
			$contents = array(
				"status"		=>200,
				"msg"			=>"data found",
				"data"			=>$Requestlist,
				"draw"			=>$draw,
				"recordsTotal"	=>$total,
				"recordsFiltered"=>$total
			);			
			return $contents;
		}else{
			return false;
		}       
    }
	function getTravelItineraryDetails($travelHeadId){
		$query=$this->db->select("ItineraryDetails.*");
		$this->db->where('ItineraryHeadId',$travelHeadId);
		$this->db->from('ItineraryDetails');
		$query=$this->db->get();
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	function getQRScanHistory($travelId){
		$query=$this->db->select("qsh.*,rm.Name as ScanedByName");
		$this->db->where('TravelDetailID',$travelId);
		$this->db->from('QRScanHistory as qsh');
		$this->db->join('RegisterMST as rm','rm.AutoID = qsh.ScanedBy','LEFT');
		$query=$this->db->get();
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	function countGuestTraveller($parentId){
		$this->db->from('RegisterMST');
        $this->db->where('IsDelete',0);
		$this->db->where('IsAdmin',0);
		$this->db->where('ParentId',$parentId);
		$query=$this->db->get();
		return $query->num_rows();
	}



	
	function getid_from_qrdata($qrtext){
		/* $query=$this->db->select("TravelDetails.*, th.QrCodeNo");
		$this->db->where('TravelHeadId',$travelHeadId);
		$this->db->from('TravelDetails');
		$this->db->join('TravelHead as th','th.AutoID = TravelDetails.TravelHeadId','LEFT');
		$query=$this->db->get();
		if($query){
			return $query->result();
		}else{
			return false;
		} */
		$this->db->where('QrCodeNo',$qrtext);
		$query=$this->db->get('TravelLuggage');
		if($query){
			return $query->row();
		}else{
			return false;
		}
	}
	function get_qrcode_details_qrcode($QrCodeNo,$userId){
        $this->db->select("reg.AutoID as regId,CONCAT(reg.Suffix, reg.Name) as Name,reg.Mobile,reg.Address,reg.AdressTwo,reg.Landmark,reg.ProfileIMG,reg.CountryCode,reg.WhatsAppCountryCode,reg.WhatsappNumber,CONCAT(reg.WhatsAppCountryCode,' ',reg.WhatsappNumber) as WhatsappNo, QDM.QRCodeText,QDM.alertedDateTime, QDM.IsUsed,QDM.alertedUserId");
        $this->db->from('QRCodeDetailsMst as QDM');
        $this->db->join('RegisterMST as reg', 'QDM.alertedUserId = reg.AutoID','left');
        $this->db->where('QDM.QRCodeText',$QrCodeNo); 
        $query = $this->db->get();
        if($query){
            $row =$query->row();
			if($row->alertedUserId == $userId){
				return $row=[
					"regId"			=> $row->regId,
					"Name"			=> $row->Name,
					"Mobile"		=> $row->Mobile,
					"Address"		=> $row->Address,
					"AdressTwo"		=> $row->AdressTwo,
					"Landmark"		=> $row->Landmark,
					"ProfileIMG"	=> $row->ProfileIMG,
					"CountryCode"	=> $row->CountryCode,
					"WhatsAppCountryCode"=> $row->WhatsAppCountryCode,
					"WhatsappNumber"	=> $row->WhatsappNumber,
					"WhatsappNo"		=> $row->WhatsappNo,
					"QRCodeText"		=> $row->QRCodeText,
					"alertedDateTime"	=> $row->alertedDateTime,
					"IsUsed"			=> $row->IsUsed,
					"alertedUserId"		=> $row->alertedUserId
				];
			}else{
				return $row=[
					"regId"			=> $row->regId,
					"Name"			=> $row->Name,
					"Mobile"		=> $row->Mobile,
					"Address"		=> $row->Address,
					"AdressTwo"		=> $row->AdressTwo,
					"Landmark"		=> $row->Landmark,
					"ProfileIMG"	=> $row->ProfileIMG,
					"CountryCode"	=> $row->CountryCode,
					"WhatsAppCountryCode"=> $row->WhatsAppCountryCode,
					"WhatsappNumber"	=> $row->WhatsappNumber,
					"WhatsappNo"		=> $row->WhatsappNo,
					"QRCodeText"		=> $row->QRCodeText,
					"alertedDateTime"	=> $row->alertedDateTime,
					"IsUsed"			=> $row->IsUsed,
					"alertedUserId"		=> $row->alertedUserId
				];
			}
        }else{
            return false;
        }
    }
	function alert_room_no($AutoID, $roomNo){
        $this->db->where('AutoID', $AutoID);
        $result = $this->db->update('TravelDetails', ['RoomNo' =>$roomNo]);
        if($result){
            return true;
        }else{
            return false;
        }
    }
	







	public function travelDetailsList($data){       
        $query=$this->db->select("td.AutoID,td.QrCodeNo,td.TitlePrefix,td.Name,td.PhoneNumber,td.AltPhoneNumber,td.Address,td.Address2,td.Landmark,td.TraavelType,td.TraavelFrom,td.TraavelTo,td.TravelDate,td.HotelName,td.RoomNo,td.CheckInDate,td.CheckOutDate,td.ProfilePicture,td.CreatedDate,td.PhoneCountryCode,td.WhatsAppCountryCode,td.PnrNo,td.AirlineName");
        $this->db->from('TravelDetails as td');
       // $this->db->join('QRScanHistory as qsh','td.AutoID = qsh.TravelDetailID','LEFT');
        $this->db->where('IsDelete',0);

		

		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('AutoID',$data['AutoID']);
		}else{
			
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('Name', trim($data['keyword']));
				$this->db->or_like('QrCodeNo', trim($data['keyword']));
				//$this->db->or_like('PhoneNumber', trim($data['keyword']));
				$this->db->group_end();
			}else{
				$this->db->order_by('AutoID','desc');
				// $this->db->limit($data['length']);
				// $this->db->offset($data['start']);
				
			}
			
		}
        $query=$this->db->get();
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$Requestlist = $query->row();
			$scan_history_data=$this->getQRScanHistory($Requestlist->AutoID);
			$Requestlist->scan_history_data=$scan_history_data;
		}else{
			$Requestlist = $query->result();
			foreach($Requestlist as $res){
				$scan_history_data=$this->getQRScanHistory($res->AutoID);
				$res->scan_history_data=$scan_history_data;
			}
		}
		
		if($Requestlist){
			//get scaned history list
			$Requestlist = json_decode(json_encode($Requestlist),true);
			$draw = $this->input->post('draw');
			$total = $this->db->where('IsDelete',0)->count_all_results('TravelDetails');
			$totalFilter = count($Requestlist);
			// if(!empty($keyword)) {
			// 	$totalFilter = count($Requestlist);
			// }
			$contents = array(
				"status"		=>200,
				"msg"			=>"data found",
				"data"			=>$Requestlist,
				"draw"			=>$draw,
				"recordsTotal"	=>$total,
				"recordsFiltered"=>$total
			);			
			return $contents;
		}else{
			return false;
		}       
    }
	
	
	/**
	 * Qr code Use - When taravel luggage add
	 */
	function qrcodeUsed(){
		$query =$this->db->get('QRCodeDetailsMst');
		return $query->result();
	}
	/*
	function checkUserDuplicate($mob){
		$this->db->where('OfficePhoneNumber',$mob);
		$query =$this->db->get('RegisterMST');
		$dataResult = $query->row();
		if($dataResult){
			return $dataResult->AutoID;
		}else{
			return false;
		}
	}
	*/
	
	
	
	public function travelerList($data){ 
        $query=$this->db->select("td.AutoID,td.Address,td.City AS Address2,td.State AS Landmark,td.Name,td.Mobile,td.Country AS CountryCode,td.Suffix AS TitlePrefix,td.IsAdmin,td.ContactPersonMobile AS WhatsAppNumber,td.ProfileIMG,td.OfficePhoneNumber AS Phone,td.CompanyCode AS WhatsAppCountryCode");
        $this->db->from('RegisterMST as td');
        $this->db->where('IsDelete',0);
        $this->db->where('IsAdmin',0);
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('AutoID',$data['AutoID']);
		}else{	
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('Name', trim($data['keyword']));
				$this->db->or_like('QrCodeNo', trim($data['keyword']));
				$this->db->group_end();
			}else{
				$this->db->order_by('AutoID','desc');
				$this->db->limit($data['length']);
				$this->db->offset($data['start']);
			}
		}
        $query=$this->db->get();
		$Requestlist = $query->result();
		if($Requestlist){
			$Requestlist = json_decode(json_encode($Requestlist),true);
			$draw = $this->input->post('draw');
			$total = $this->db->where('IsDelete',0)->count_all_results('TravelDetails');
			$totalFilter = count($Requestlist);
			$contents = array(
				"status"		=>200,
				"msg"			=>"data found",
				"data"			=>$Requestlist,
				"draw"			=>$draw,
				"recordsTotal"	=>$total,
				"recordsFiltered"=>$total
			);			
			return $contents;
		}else{
			return false;
		}       
    }
	
	
	
	

}