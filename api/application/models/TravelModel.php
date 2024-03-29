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
				$this->db->order_by('ParentId','asc');
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
		$this->db->where('ParentId',0);
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
	public function travelerItineraryListDetails($data,$parentId){ 
        $query=$this->db->select("rm.AutoID,rm.Name,rm.Mobile,rm.Suffix AS TitlePrefix,rm.ProfileIMG,ih.AutoID AS SchedulerHeadId,ih.UserID,ih.StartDate,ih.EndDate, ih.CreatedDate,ih.ModifiedDate,ih.SchedulerDescription");
        $this->db->from('ItineraryHead as ih');//ItineraryDetails
		$this->db->join('RegisterMST as rm','ih.UserID = rm.AutoID','LEFT');
        $this->db->where('ih.IsDelete',0);
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('ih.AutoID',$data['AutoID']);
		}else{	
			if($parentId > 0){
				$this->db->where('UserID',$parentId);
			}
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
				$itineararyDetailsData = $this->getTravelItineraryDetails($res->SchedulerHeadId);
				$res->Itinerary=$itineararyDetailsData;
				// $scan_history_data=$this->getQRScanHistory($res->SchedulerHeadId);
				// $scan_history_data=$this->getQRScanHistory($res->AutoID);
				// $res->scan_history_data=$scan_history_data;
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
	function SchedulerList($data,$parentId){
		$this->db->select("AutoID,StartDate,EndDate,SchedulerDescription");
        $this->db->from('ItineraryHead');
        $this->db->where('IsDelete',0);
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('AutoID',$data['AutoID']);
		}else{	
			if($parentId > 0){
				$this->db->where('UserID',$parentId);
			}
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('SchedulerDescription', trim($data['keyword']));
				$this->db->group_end();
				$this->db->order_by('AutoID','desc');
			}else{
				$this->db->limit($data['length']);
				$this->db->offset($data['start']);
				$this->db->order_by('AutoID','desc');
			}
		}
        $query=$this->db->get();
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$Requestlist = $query->row();
		}else{
			$Requestlist = $query->result();
		}
		
		if($Requestlist){
			$draw = $this->input->post('draw');
			$total = $this->db->where('IsDelete',0)->count_all_results('ItineraryHead');
			$contents = array(
				"status"		=>200,
				"msg"			=>"data found",
				"data"			=>$Requestlist,
				"recordsTotal"	=>$total,
				"recordsFiltered"=>$total
			);			
			return $contents;
		}else{
			return false;
		} 
	}
	function ActivityListBySchedulerId($schedularId){
		
		//$this->db->select("ih.StartDate,ih.EndDate,ih.SchedulerDescription,ItineraryDetails.*");
        $this->db->from('ItineraryDetails');
		//$this->db->join('ItineraryHead as ih','ih.AutoID = ItineraryDetails.SchedulerHeadId','LEFT');
		if($schedularId > 0){
			$this->db->where('ItineraryDetails.SchedulerHeadId',$schedularId);
		}
        
        $this->db->where('ItineraryDetails.IsDelete',0);
		/*
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('AutoID',$data['AutoID']);
		}
		else{	
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('Type', trim($data['keyword']));
				$this->db->group_end();
				$this->db->order_by('AutoID','desc');
			}else{
				$this->db->limit($data['length']);
				$this->db->offset($data['start']);
				$this->db->order_by('AutoID','desc');
			}
		}
		*/
		$this->db->order_by('ItineraryDetails.AutoID','desc');
        $query=$this->db->get();
		// if(isset($data['AutoID']) && !empty($data['AutoID'])){
		// 	$Requestlist = $query->row();
		// }else{
		// 	$Requestlist = $query->result();
		// }
		
		if($query){
			$Requestlist = $query->result();
			$schedularObj=$this->getSchedulerData($schedularId);
			if($schedularObj){
				$result_data['StartDate']=$schedularObj->StartDate;
				$result_data['EndDate']=$schedularObj->EndDate;
				$result_data['SchedulerDescription']=$schedularObj->SchedulerDescription;
				$linkedLuggageListObj=$this->getLinkedLuggageList($schedularId);
				$result_data['activity_data']=$Requestlist;
				$result_data['linked_luggage_data']=$linkedLuggageListObj;
				$contents = array(
					"status"		=>200,
					"msg"			=>"data found",
					"data"			=>$result_data,
				);	
			}else{
				$contents = array(
					"status"		=>200,
					"msg"			=>"data not found",
					"data"			=>new stdClass(),
				);				
			}
			return $contents;
		}else{
			$contents = array(
				"status"		=>200,
				"msg"			=>"data not found",
				"data"			=>new stdClass(),
			);			
			return $contents;
		} 
	}
	function ActivityListByActiveScheduler($userid){
		$this->db->select("AutoID,StartDate,EndDate,SchedulerDescription");
        $this->db->from('ItineraryHead');
        $this->db->where('IsDelete',0);
        $this->db->where('UserID',$userid);
		$this->db->order_by('AutoID','desc');
		$this->db->limit(1);
		$query=$this->db->get();
		//echo $this->db->last_query();
		if($query){
			$schedularObj = $query->row();
				if($schedularObj){
				$result_data['StartDate']=$schedularObj->StartDate;
				$result_data['EndDate']=$schedularObj->EndDate;
				$result_data['SchedulerDescription']=$schedularObj->SchedulerDescription;

				$activitylist = $this->getActivityList($schedularObj->AutoID);
				$linkedLuggageListObj=$this->getLinkedLuggageList($schedularObj->AutoID);
				$result_data['activity_data']=$activitylist;
				$result_data['linked_luggage_data']=$linkedLuggageListObj;

				$contents = array(
					"status"		=>200,
					"msg"			=>"data found",
					"data"			=>$result_data,
				);			
				return $contents;
			}else{
				$contents = array(
					"status"		=>200,
					"msg"			=>"data not found",
					"data"			=>new stdClass(),
				);			
				return $contents;
			}

		}else{
			$contents = array(
				"status"		=>200,
				"msg"			=>"data not found",
				"data"			=>new stdClass(),
			);			
			return $contents;
		}
	}
	function getSchedulerData($schedularId){
		$this->db->select("AutoID,StartDate,EndDate,SchedulerDescription");
        $this->db->from('ItineraryHead');
        $this->db->where('IsDelete',0);
		$this->db->where('AutoID',$schedularId);
		$query=$this->db->get();
		if($query){
			return $Requestlist = $query->row();
		}else{
			return [];
		}
		
	}
	function getActivityList($SchedulerHeadId){
 		$this->db->from('ItineraryDetails');
        $this->db->where('SchedulerHeadId',$SchedulerHeadId);
        $this->db->where('IsDelete',0);
		$this->db->order_by('AutoID','desc');
        $query=$this->db->get();
		if($query){
			return $query->result();
		}else{
			return [];
		}
	}
	function getLinkedLuggageList($SchedulerHeadId){
		$this->db->select("SL.AutoID,SL.QrCodeID,SL.CreatedBy, QRDM.QRCodeText, TL.AutoID, TL.LuggageName, TL.LuggageImage, TL.QrCodeNo, TL.LuggageType, TL.LuggageRemarks, TL.LuggageColor, TL.BrandName, TL.AppleAirTag");
		$this->db->from('SchedulerLuggage AS SL');
		$this->db->join('QRCodeDetailsMst as QRDM','SL.QrCodeID = QRDM.AutoID','LEFT');
		$this->db->join('TravelLuggage as TL','TL.QrCodeNo = QRDM.QRCodeText','LEFT');
		$this->db->where('SL.SchedulerID',$SchedulerHeadId);
		$this->db->order_by('SL.AutoID','desc');
		$query=$this->db->get();
		$schedulerObj = $query->result();
		if($schedulerObj){
			return $schedulerObj;
		}else{
			return [];
		}	
		/* if($query){
			$schedulerObj = $query->result();
			if($schedulerObj){
				$NotifyLuggageArr =json_decode($schedulerObj->NotifyLuggage);
				$NotifyLuggageStr="'".implode("','",$NotifyLuggageArr)."'";
				$sql="SELECT * FROM TravelLuggage WHERE QrCodeNo IN($NotifyLuggageStr)";
				$query=$this->db->query($sql);
				if($query){
					$result =$query->result();
					if($result){
						return $result;
					}else{
						return [];
					}
				}else{
					return [];
				}
			}else{
				return [];
			}
		}else{
			return [];
		} */
	}
	function getTravelItineraryDetails($travelHeadId){
		$query=$this->db->select("ItineraryDetails.*");
		$this->db->where('SchedulerHeadId',$travelHeadId);
		$this->db->from('ItineraryDetails');
		$query=$this->db->get();
		if($query){
			$results=$query->result();
			foreach($results as $res){
				$res->NotifyScheduleInMin=intval($res->NotifyScheduleInMin);
				$res->NotifyType =json_decode($res->NotifyType, true);
			}
			return $results;
			//return $query->result();
		}else{
			return false;
		}
	}
	function getQRScanHistory($travelId){
		$query=$this->db->select("qsh.*,rm.Name as ScanedByName");
		// $this->db->where('TravelDetailID',$travelId);
		$this->db->where('rm.AutoID ',$travelId);
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
	function checkItineraryExistsOrNot($userId,$parentId){
		$currentDate=date('Y-m-d');
		// $this->db->where('StartDate >=',$currentDate);
		$this->db->where('EndDate >=',$currentDate);
		if($parentId > 0){
			$this->db->where('UserID',$parentId);
		}

		$this->db->from('ItineraryHead');
		$query=$this->db->get();
		if($query){
			return $query->num_rows();
		}else{
			return false;
		} 
	}
	function checkSchedulerExistsOrNot($id){
		$this->db->where('AutoID',$id);
		$this->db->from('ItineraryHead');
		$query=$this->db->get();
		if($query){
			return $query->num_rows();
		}else{
			return false;
		} 
	}
	function getSchedulerById($id){
		$this->db->where('AutoID',$id);
		$this->db->from('ItineraryHead');
		$query=$this->db->get();
		if($query){
			return $query->row();
		}else{
			return false;
		} 
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
	function get_qrcode_details($QrCodeNo,$userId){
        $this->db->select("reg.AutoID as regId,CONCAT(reg.Suffix, reg.Name) as Name,reg.ProfileIMG,reg.Mobile,reg.CountryCode,tl.LuggageName,tl.LuggageImage,tl.QrCodeNo,tl.LuggageType,tl.LuggageColor,tl.BrandName,tl.AppleAirTag");
        $this->db->from('TravelLuggage as tl');
        $this->db->join('RegisterMST as reg', 'tl.UserID = reg.AutoID','left');
        $this->db->where('tl.QrCodeNo',$QrCodeNo); 
        $query = $this->db->get();
        if($query){
            $row =$query->row();
			return $row;
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