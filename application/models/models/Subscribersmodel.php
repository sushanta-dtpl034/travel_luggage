<?php
  class Subscribersmodel extends CI_Model{
    
      public function get_paidsubscribers(){
        $this->db->where('PaidStatus',1);
        $result = $this->db->get('RegisterMST');
        return $result->result_array();
      }
      public function get_subscriber($id){
        $this->db->where('RegisterMST.AutoID',$id);
         $this->db->select('RegisterMST.AutoID,RegisterMST.ProfileIMG,RegisterMST.CompanyName,RegisterMST.Address,RegisterMST.City,RegisterMST.Pincode,RegisterMST.Email,RegisterMST.ContactPersonName,RegisterMST.OfficePhoneNumber,RegisterMST.ContactPersonMobile,
        RegisterMST.PaidDate,PlanMST.PlanName,PlanMST.Price,PlanMST.TotalDays,PlanMST.Storage,CityMST.CitiName as city,StateMST.StateName as state,
        CountryMST.CoutryName as countryName,StateMST.AutoID as stateid,CountryMST.AutoID as countryid,CityMSt.AutoID as cityid,RegisterMST.Pan,RegisterMST.TaxID,RegisterMST.GstNo')
         ->from('RegisterMST')
         ->join('PlanMST', 'RegisterMST.PlanId = PlanMST.AutoID','left')
         ->join('CityMSt', 'RegisterMST.City = CityMSt.AutoID','left')
         ->join('StateMST', 'CityMST.StateID = StateMST.AutoID','left')
         ->join('CountryMST', 'CityMST.CountryID = CountryMST.AutoID','left');
          $query = $this->db->get();
         
          return $query->result_array();

      }
      public function update_subscriber($data,$update_id){
        $this->db->where('AutoID',$update_id);
        $this->db->update('RegisterMST',$data);
        return $this->db->affected_rows();
      }
        
  }
?>