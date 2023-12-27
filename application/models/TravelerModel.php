<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TravelerModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    function getCountryCode(){
        $query = $this->db->get('CountryMst');
        if($query){
            return $query->result_array();
        }  
    }
    function getTravelLuggageList(){
        $this->db->where('IsDelete',0);
        $this->db->where('IsAdmin',0);
        $query = $this->db->get('RegisterMST');
        if($query){
            return $query->result_array();
        }
    }
    function getTravelLuggageById($id){
        $this->db->where('AutoID',$id);
        $query = $this->db->get('RegisterMST');
        if($query){
            return $query->row_array();
        }
    }


}
