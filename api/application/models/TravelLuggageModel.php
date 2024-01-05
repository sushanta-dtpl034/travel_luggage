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
        $this->db->select('tl.*,ih.ItineraryName, rm.Name,rm.Suffix,rm.ProfileIMG');
        $this->db->from('TravelLuggage as tl');
        $this->db->where('tl.IsDelete',0);
		if($arrdata['IsAdmin'] == 0 ){
			$this->db->where('tl.UserID',$arrdata['AutoID']);
		}
        
        $this->db->join('RegisterMST as rm','tl.UserID = rm.AutoID','LEFT');
        $this->db->join('ItineraryHead as ih','tl.ItineraryHeadId = ih.AutoID','LEFT');
		if(isset($data['AutoID']) && !empty($data['AutoID'])){
			$this->db->where('tl.AutoID',$data['AutoID']);
		}else{	
			if(!empty(trim($data['keyword']))) {
				$this->db->group_start();
				$this->db->like('tl.LuggageName', trim($data['keyword']));
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
			//get scaned history list
			$Requestlist = json_decode(json_encode($Requestlist),true);
			$draw = $this->input->post('draw');
			$total = $this->db->count_all_results('TravelLuggage');
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
	
}