<?php
defined('BASEPATH') OR exit('No direct script access allowed!.');

class ItineraryModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getItineraryList(){
        $this->db->select("ih.*, rm.Name, rm.ProfileIMG, rm.Suffix");
        $this->db->where('ih.IsDelete',0);
        // $this->db->where('IsActive',0);
        $this->db->from('ItineraryHead as ih');
		$this->db->join('RegisterMST as rm','rm.AutoID = ih.UserID','LEFT');
        $query = $this->db->get();
        if($query){
            return $query->result_array();
        }
    }

    /**
     * Itinerary Details
     */
    function getItineraryDetailList($itineraryHeadId){
        $this->db->select("id.*, rm.Name, rm.ProfileIMG, rm.Suffix");
        $this->db->where('id.IsDelete',0);
        $this->db->where('id.ItineraryHeadId',$itineraryHeadId);
        $this->db->from('ItineraryDetails as id');
		$this->db->join('ItineraryHead as ih','ih.AutoID = id.ItineraryHeadId','LEFT');
		$this->db->join('RegisterMST as rm','rm.AutoID = ih.UserID','LEFT');
        $query = $this->db->get();
        if($query){
            return $query->result_array();
        }
    }



}

