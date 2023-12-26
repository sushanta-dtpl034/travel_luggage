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
	function getid_from_qrdata($qrtext){
		$this->db->where('QrCodeNo',$qrtext);
		$query=$this->db->get('TravelDetails');
		if($query){
			return $query->row();
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

}