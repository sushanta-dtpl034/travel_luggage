<?php
  class Servicemodel extends CI_Model{
     
      
      public function getservices(){
         
        $this->db->select('AutoID,ServiceName,isActive');
        $this->db->from('ServiceMST');
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();
        
      }
      public function getactivemisc(){
         
        $this->db->select('AutoID,MiscDes');
        $this->db->from('MiscellaneousMST');
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();
        
      }
      
      public function getoneservice($id)
      {
        $this->db->select('AutoID,ServiceName,isActive');
        $this->db->from('ServiceMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }

      
      
      

          
    
  }
?>