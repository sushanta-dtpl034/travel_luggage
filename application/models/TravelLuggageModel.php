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
}

