<?php
  class Mastermodel extends CI_Model{
     
      public function saveproject($data){
        $this->db->insert("ProjectMST",$data);
        return $this->db->insert_id();
        
      }
      public function updateplan($data,$updateid){
        $this->db->where('AutoID',$updateid);
        $this->db->update('PlanMST',$data);
        return $this->db->affected_rows();
      }
      public function getactiveproject(){
         
        $this->db->select('AutoID,ProjectName,ProjectID,ContactNo,IsActive');
        $this->db->from('ProjectMST');
        $this->db->where('IsActive',1);
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();
        
      }
      public function getcurrency($id){
         
        $this->db->select('AutoID,CurrencyName,CurrencyCode,CurrencySymbole,CurrencyUnicode');
        $this->db->from('CurrencyMST');
        $this->db->where("ParentID",$id);
        $this->db->where("IsDelete",0);
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

      
      
      public function getsection(){
         
        $this->db->select('AutoID,SectionName,Colors');
        $this->db->from('SectionMST');
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();
        
      }

          
      public function getoneproject($id)
      {
        $this->db->select('AutoID,ProjectName,ProjectID,ContactNo,IsActive,ProjMangerName,ProMangerEmail');
        $this->db->from('ProjectMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }
      public function getonemisc($id)
      {
        $this->db->select('AutoID,MiscDes');
        $this->db->from('MiscellaneousMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }

      
      public function updateproject($data,$update_id){
        $this->db->where('AutoID',$update_id);
        $this->db->update('ProjectMST',$data);
        return $this->db->affected_rows();
      }
      public function deleteproject($id,$data)
      {
        $this->db->where('AutoID',$id);
        $this->db->update('ProjectMST',$data);
        return $this->db->affected_rows();
      }
      public function savesection($data){
        $this->db->insert("SectionMST",$data);
        return $this->db->insert_id();
        
      }
      public function getonesection($id){

        $this->db->select('AutoID,SectionName,Colors');
        $this->db->from('SectionMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();

      }
      public function updatesection($data,$update_id){
        $this->db->where('AutoID',$update_id);
        $this->db->update('SectionMST',$data);
        return $this->db->affected_rows();
      }
      public function savestages($data){
        $this->db->insert("StatusMST",$data);
        return $this->db->insert_id();
        
      }
      public function getstages(){
      
        $this->db->select('AutoID,Stages');
        $this->db->from('StatusMST');
        $query = $this->db->get();
        return $query->result_array();
        
      }
       public function updatestatge($data,$id){
        $this->db->where('AutoID',$id);
        $this->db->update('StatusMST',$data);
        return $this->db->affected_rows();
        
      }
      public function updatemisc($data,$id){
        $this->db->where('AutoID',$id);
        $this->db->update('MiscellaneousMST',$data);
        $this->db->last_query();
       return $this->db->affected_rows();
        
      }
      
      public function getmaterialcon(){
        $this->db->select('AutoID,ConditionName');
        $this->db->from('SuperAdminMaterialMST');
        $query = $this->db->get();
        return $query->result_array();

      }
      public function getonematerialcon($id){

        $this->db->select('AutoID,ConditionName,ToName,ToEmail,CCEmail,FromName,FromEmail,EmailSubject,EmailMessage');
        $this->db->from('SuperAdminMaterialMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();

      }
      

      public function getonecurrecny($id){

        $this->db->select('AutoID,CurrencyName,CurrencyCode,CurrencySymbole,CurrencyUnicode');
        $this->db->from('CurrencyMST');
        $this->db->where("AutoID",$id);
        $query = $this->db->get();
        return $query->row();

      }  

  
      public function save_currency($data){

         if(!empty($data)){
            $CurrencyName = $data['CurrencyName'];
            $CurrencyCode = $data['CurrencyCode'];
            $CurrencySymbole = $data['CurrencySymbole'];
            $CreatedBy = $data['CreatedBy'];
            $CreatedDate = $data['CreatedDate'];
            $ParentID = $data['ParentID'];
            $CurrencyUnicode = $data['CurrencyUnicode'];
            
         }

        $query = "INSERT INTO CurrencyMST (CurrencyName,CurrencyCode,CurrencySymbole,CurrencyUnicode,CreatedBy,CreatedDate,ParentID)VALUES ('$CurrencyName','$CurrencyCode',N'".$CurrencySymbole."','$CurrencyUnicode','$CreatedBy','$CreatedDate',' $ParentID')";
        $this->db->query($query);
        return $this->db->insert_id();

      }
      public function update_currency($data,$id){

        if(!empty($data)){
           $CurrencyName = $data['CurrencyName'];
           $CurrencyCode = $data['CurrencyCode'];
           $CurrencySymbole = $data['CurrencySymbole'];
           $CreatedBy = $data['ModifyBy'];
           $CreatedDate = $data['ModifyDate'];
           $CurrencyUnicode = $data['CurrencyUnicode'];
        }

       $query = "UPDATE CurrencyMST SET CurrencyName ='$CurrencyName', CurrencyCode='$CurrencyCode', CurrencySymbole=N'".$CurrencySymbole."',CurrencyUnicode='$CurrencyUnicode',ModifyBy='$CreatedBy',ModifyDate=' $CreatedDate' WHERE AutoID = '$id'";
       $this->db->query($query);
       return TRUE;

     }
     public function getsystemsetting($id){
         
      $this->db->select('*');
      $this->db->from('SystemsettingMST');
      $this->db->where("ParentID",$id);
      $query = $this->db->get();
      return $query->row();
      
    }
   
    
     

     
      
    
  }
?>