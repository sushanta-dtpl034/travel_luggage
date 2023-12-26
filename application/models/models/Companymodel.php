<?php
  class Companymodel extends CI_Model{
     
      
      public function getcompany($parent_id){
         
        $this->db->select('CompanyMst.AutoID,CompanyMst.CompanyName,CompanyMst.CompanyShortCode,CompanyMst.CompanyAddress,currency.CurrencyCode,CompanyMst.IsCompany');
        $this->db->from('CompanyMst');
        $this->db->join('CurrencyMST as currency', 'CompanyMst.CompanCurrency = currency.AutoID','left');
        $this->db->where('CompanyMst.ParentID',$parent_id);
        $this->db->where('CompanyMst.IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();
      }
      public function getdropcompany($parent_id){
         
        $this->db->select('AutoID,CompanyName,CompanyAddress');
        $this->db->from('CompanyMst');
        $this->db->where('ParentID',$parent_id);
        //$this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();
        
      }
      public function getonecompany($id)
      {
        $this->db->select('AutoID,CompanyName,CompanyAddress,CompanyShortCode,CompanyLogo,CompanyStamp,BankDetails,CompanCurrency,IsCompany');
        $this->db->from('CompanyMst');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }

     
      
  }
?>