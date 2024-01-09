<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcodemodel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    function get_qrcode_data(){
        $sql="SELECT qr.AutoID, qr.ShortCode, qr.NoofQRCode, FORMAT(qr.CreatedDate, 'dd-MM-yyyy hh:mm tt') as createdate, 
            (SELECT COUNT(*) FROM QRCodeDetailsMst WHERE IsUsed = 1 AND  QRCodeDetailsMst.QRCodeId = qr.AutoID) AS TOTAL_USED_QRCODE 
            FROM QRCodeHeadMst as qr
            WHERE qr.IsDelete = 0";
        // $this->db->select("qr.AutoID,qr.ShortCode,qr.NoofQRCode,FORMAT(qr.CreatedDate, 'dd-MM-yyyy hh:mm tt') as createdate, 
        // (SELECT COUNT(*) FROM QRCodeDetailsMst WHERE IsUsed = 1) AS TOTAL_USED_QRCODE");
        // $this->db->from('QRCodeHeadMst as qr');
        // $this->db->join('QRCodeDetailsMst as qdm', 'qr.AutoID = qdm.QRCodeId','left');
        // $this->db->where('qr.IsDelete',0);
        // $query = $this->db->get();
        $query =$this->db->query($sql);
        return $query->result_array();
    }
    function qrcode_head_save($data){
        $this->db->insert('QRCodeHeadMst', $data);
        return $this->db->insert_id();
    }
    function qrcode_details_save($data){
        $this->db->insert('QRCodeDetailsMst', $data);
        return true;   
    }
    //get qrcode data by id
    function getoneqrcode($id){
        $this->db->where('AutoID',$id);
        $query =$this->db->get('QRCodeHeadMst');
        return $query->row();
    }
    function qrcode_head_update($data){
        $this->db->where('AutoID',$data['AutoID']);
        $this->db->update('QRCodeHeadMst', $data);
        return true;
    }
    function get_qrcode_details($id){
        $sql="CASE WHEN (qdt.IsUsed = 1) THEN 'Alerted to luggage' WHEN (qdt.IsUsed = 2) THEN 'Alerted to user' ELSE 'Not used' END as status";
        $this->db->select("qdt.AutoID,qdt.QRCodeText,FORMAT(qr.CreatedDate, 'dd-MM-yyyy') as create_date,$sql");
        $this->db->from('QRCodeDetailsMst as qdt');
        $this->db->join('QRCodeHeadMst as qr', 'qr.AutoID = qdt.QRCodeId','left');
        $this->db->where('qdt.QRCodeId',$id);        
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_qrcode_companyDetails($id){
        $this->db->select('Company.CompanyName');
        $this->db->from('QRCodeHeadMst as qr');
        $this->db->join('CompanyMst as Company', 'qr.CompanyID = Company.AutoID','left');
        $this->db->where('qr.IsDelete',0);
        $this->db->where('qr.AutoID',$id); 
        $query = $this->db->get();
        $result =$query->row();
        $company_name =($result)?$result->CompanyName:'';
        return $company_name;

    }
    function get_qrcode_details_ids($qrcode_ids){
        $sql="SELECT qcdm.AutoID,qcdm.QRCodeText,qcdm.QRCodeImage FROM 
		QRCodeDetailsMst as qcdm ,QRCodeHeadMst as qchm
		WHERE qcdm.AutoID IN($qrcode_ids) AND 
		qcdm.QRCodeId=qchm.AutoID";
        $query=$this->db->query($sql);
       // echo $this->db->last_query();
        return $query->result();
    }
    function get_multiple_qrdata($qrtext){
		$this->db->where('QrCodeNo',$qrtext);
		$query=$this->db->get('TravelDetails');
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}

    /* function get_qrcode_details_qrcode($QrCodeNo){
        $this->db->select('reg.AutoID as regId,CONCAT(reg.Suffix, reg.Name) as Name,reg.Mobile,reg.Address,reg.City,reg.State,reg.ProfileIMG,th.QrCodeNo,th.AutoID as TravelHeadId');
        $this->db->from('TravelHead as th');
        $this->db->join('RegisterMST as reg', 'th.UserID = reg.AutoID','left');
        $this->db->where('th.IsDelete',0);
        $this->db->where('th.QrCodeNo',$QrCodeNo); 
        $query = $this->db->get();
        if($query){
            return $query->row();
        }else{
            return false;
        }
    } */
	function get_qrcode_details_qrcode($QrCodeNo){
        $this->db->select("reg.AutoID as regId,CONCAT(reg.Suffix, reg.Name) as Name,reg.Mobile,reg.Address,reg.AdressTwo,reg.Landmark,reg.ProfileIMG,reg.CountryCode,reg.WhatsAppCountryCode,reg.WhatsappNumber,CONCAT(reg.WhatsAppCountryCode,' ',reg.WhatsappNumber) as WhatsappNo, QDM.QRCodeText,QDM.alertedDateTime, QDM.IsUsed,QDM.alertedUserId");
        $this->db->from('QRCodeDetailsMst as QDM');
        $this->db->join('RegisterMST as reg', 'QDM.alertedUserId = reg.AutoID','left');
        $this->db->where('QDM.QRCodeText',$QrCodeNo); 
        $query = $this->db->get();
        if($query){
            return $query->row();
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
    /**
     * Luggage Details List
     */
   /*  function getLuggageList($id=""){
        $this->db->select("AutoID,QrCodeNo,TitlePrefix,Name,PhoneNumber,AltPhoneNumber,Address,Address2,Landmark,TraavelType,TraavelFrom,TraavelTo,FORMAT(TravelDate, 'dd/MM/yyyy hh:mm') as TravelDate,HotelName,RoomNo,FORMAT(CheckInDate, 'dd/MM/yyyy hh:mm') as CheckInDate,FORMAT(CheckOutDate, 'dd/MM/yyyy hh:mm') as CheckOutDate,IsDelete,PhoneCountryCode,WhatsAppCountryCode,PnrNo,AirlineName");
        $this->db->from('TravelDetails');
		if(!empty($id)){
			$this->db->where('UserID',$id);
		}
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        if($query){
            return $query->result_array();
        }
    } */
    function getLuggageList($id=""){
        $this->db->select("th.AutoID,td.Address,td.City AS Address2,td.State AS Landmark,td.Name,td.Mobile AS PhoneNumber,td.Country AS CountryCode,td.Suffix AS TitlePrefix,td.IsAdmin,td.ContactPersonMobile AS WhatsAppNumber,td.ProfileIMG,td.OfficePhoneNumber AS Phone,td.CompanyCode AS WhatsAppCountryCode, th.QrCodeNo, th.AutoID AS TravelHeadId");
        $this->db->from('TravelHead as th');
		$this->db->join('RegisterMST as td','th.UserID = td.AutoID','LEFT');
        $this->db->where('th.IsDelete',0);
        $query = $this->db->get();
        if($query){
            return $query->result_array();
        }
    }
    function get_luggage_qrcode_details_ids($qrcode_ids){
        //CONCAT(TitlePrefix, Name) as Name
		$this->db->select("td.AutoID,CONCAT(td.Suffix, td.Name) as Name, th.QrCodeNo");
        $this->db->from('TravelHead as th');
		$this->db->join('RegisterMST as td','th.UserID = td.AutoID','LEFT');
        //$sql="SELECT AutoID,QrCodeNo,CONCAT(TitlePrefix, Name) as Name FROM TravelHead WHERE AutoID=$qrcode_ids";
		$this->db->where('th.AutoID',$qrcode_ids);
        $query = $this->db->get();
        return $query->row();
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
    function getid_from_qrdata($qrtext){
		$this->db->where('QrCodeNo',$qrtext);
		$query=$this->db->get('TravelHead');
		if($query){
			return $query->row();
		}else{
			return false;
		}
	}
  
    function getAirlineList(){
        $query = $this->db->get('AirlineMst');
        if($query){
            return $query->result_array();
        }
    }
    function getAirlineById($id){
        $this->db->where('AutoID',$id);
        $query = $this->db->get('AirlineMst');
        if($query){
            return $query->row_array();
        }
    }


}
