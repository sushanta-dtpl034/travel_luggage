<?php
  class Planmodel extends CI_Model{
     
      public function savePlan($data){
        $this->db->insert("PlanMST",$data);
        return $this->db->insert_id();
        
      }
      public function updateplan($data,$updateid){
        $this->db->where('AutoID',$updateid);
        $this->db->update('PlanMST',$data);
        return $this->db->affected_rows();
      }
      public function getplan(){
         
        $this->db->select('AutoID,PlanName,Price,TimePeriod,TotalDays,isActive,Storage');
        $this->db->from('PlanMST');
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();
        
      }
      public function getactiveplan(){
         
        $this->db->select('AutoID,PlanName,Price,TimePeriod,TotalDays,isActive,Storage');
        $this->db->from('PlanMST');
        $this->db->where('isActive',1);
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();
        
      }
      
      public function getsingleplan($id)
      {
        $this->db->select('AutoID,PlanName,Price,TimePeriod,TotalDays,isActive,Storage');
        $this->db->from('PlanMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }
      
      
      public function updateinvoice($data,$update_id){
        $this->db->where('AutoID',$update_id);
        $this->db->update('RegisterMST',$data);
        return $this->db->affected_rows();
      }
      public function deleteplan($id,$data)
      {
        $this->db->where('AutoID',$id);
        $this->db->update('PlanMST',$data);
        return $this->db->affected_rows();
      }
    
  }
?>