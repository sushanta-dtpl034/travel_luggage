<?php
  class Registermodel extends CI_Model{
     
      public function saveRegister($data){
        $this->db->insert("RegisterMST",$data);
        return $this->db->insert_id();
        
      }
      public function saveLogin($data){

        $this->db->insert("Login",$data);
        echo  $this->db->last_query();
        die();
        return $this->db->insert_id();
        
      }

     public function last_companycode(){

      $this->db->select('CompanyCode');
      $this->db->from('RegisterMST');
        $this->db->order_by("CompanyCode", "desc");
        $this->db->limit(1);
        $query = $this->db->get(); 
        return $query->row();

     }
      
    
  }
?>