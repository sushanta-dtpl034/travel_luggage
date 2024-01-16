<?php
defined('BASEPATH') OR exit('No direct script access allowed!.');

class TravelLuggageModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getTravelLuggageList(){
        $userid = $this->session->userdata('userid');
        $this->db->select("tl.*, rm.Name, rm.ProfileIMG, rm.Suffix");
        $this->db->where('tl.IsDelete',0);
        // $this->db->where('IsActive',0);
        if($this->session->userdata('userisadmin') == 0){
            $this->db->where('tl.UserID',$userid);
        }
        $this->db->from('TravelLuggage as tl');
		$this->db->join('RegisterMST as rm','rm.AutoID = tl.UserID','LEFT');
        $query = $this->db->get();
        if($query){
            return $query->result_array();
        }
    }
    function getTimeDifference(){
        // Get the current timestamp
        $currentTimestamp = date('Y-m-d H:i:s');
        $this->db->select("(DATEDIFF(HOUR, CreatedDate, '$currentTimestamp')) AS timeDifference", false);
        $this->db->where('Status',1);
        $this->db->from('QRScanHistory');
        $this->db->order_by('CreatedDate', 'DESC'); // Order by 'createdAt' in descending order
        $this->db->limit(1); // Limit the result to 1 record
        // Execute the query
        $query = $this->db->get();
        if($query){
            $result = $query->row();
            if($result){
                $timeDifferenceInHour = $result->timeDifference;
            }else{
                $timeDifferenceInHour = 0;
            }
            
        }else{
            $timeDifferenceInHour = 0;
        }
        return $timeDifferenceInHour;
    }


}

