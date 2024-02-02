<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemSettingModel extends CI_Model {

	public function __construct()
    {
		parent::__construct();
		// $this->load->database();
        
	}
	public function ManageSystemSetting($data,$type,$id=""){
		if($type==1){
			$this->db->insert('SystemMst',$data);
			return $this->db->insert_id();
		}
		elseif($type==2){
			//$this->db->where('AutoID', $id);
            return $this->db->update('SystemMst', $data);
		}
		elseif($type==3){
			$this->db->where('AutoID', $id);
            return $this->db->update('SystemMst', $data);
		}
	}
	function CheckRecord(){
	    $query=$this->db->get('SystemMst');
		$data=$query->row();
		
		if($data->AutoID>0){
			return false;
		}
		else{
			return true;
		}
	}
	
	public function ManageSystemByID(){
		$this->db->select('*');
		$this->db->from('SystemMst');
		//$this->db->where('AutoID', $id);
		$query = $this->db->get();
		
		return $query->row();
	}

	public function getSystemSetting($id){
		$this->db->select('*');
		$this->db->from('SystemMst');
		$this->db->where('AutoID', $id);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
}