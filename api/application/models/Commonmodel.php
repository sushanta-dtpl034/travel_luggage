<?php
  class Commonmodel extends CI_Model{
     
      
     
      public function common_insert($table_name, $data)
      {
        
         $this->db->insert($table_name, $data);
         $this->db->last_query();
          if ($this->db->insert_id() > 0) {
          return $this->db->insert_id();
        } else {
           return false;
        }
      }
      public function common_update($table_name, $where, $data){

        $this->db->where($where);
        $this->db->update($table_name, $data);
        if ($this->db->affected_rows() > 0) {
          return true;
        } else {
           return false;
        }
      }


      public function allreadycheck($table,$where){
      $this->db->where($where);
      $query = $this->db->get($table);
      if ($query->num_rows() > 0){
        return 0;
      }
      else{
        return 1;
      }

    }

    public function getshortcode($parent_id,$assetowner_id){
          
      $this->db->select('CompanyName,AutoID');
      $this->db->from('CompanyMst');
      $this->db->where('ParentID',$parent_id);
      $this->db->where('AutoID',$assetowner_id);
      $query = $this->db->get();
      return $query->row();
    }

     public function last_companycode($parent_id,$assetowner_id){

      $this->db->where('ParentID',$parent_id);
      $this->db->where('AssetOwner',$assetowner_id);
      $query = $this->db->get('AssetMst');
      return $query->num_rows();
    }

    public function getlast_row(){
		//where("MONTH('CreatedDate')", "MONTH(CURRENT_DATE())")->
		$row= $this->db->select('*')->order_by('AutoID',"desc")->get('TravelDetails')->result();
		return count($row);	
	}
  }
?>