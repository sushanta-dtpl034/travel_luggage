<?php
  class Assetmodel extends CI_Model{
     
      
      public function getassettype($id=""){
         
        $this->db->select('AutoID,AsseTypeName');
        $this->db->from('AssettypeMST');
        $this->db->where('ParentID',$id);
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();
        
      }
     
  
      
      public function getassetcat($id,$typeid){
         
        $this->db->select('AutoID,AsseCatName');
        $this->db->from('AssetCatMST');
        $this->db->where('ParentID',$id);
        $this->db->where('AssetType',$typeid);
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();
        
      }

      public function get_subcat_basedoncatid($assetman_catid){
         
        $this->db->select('AutoID,AssetSubcatName');
        $this->db->from('AssetSubcatMST');
        $this->db->where('"IsDelete" IS NULL');
        $this->db->where('AssetCatName',$assetman_catid);
        $query = $this->db->get();
        return $query->result_array();
        
      }

            public function get_oneasset_subcat($id)
      {
        $this->db->select('AssetSubcatMST.AutoID,AssetSubcatMST.AssetCatName,AssetSubcatMST.AssetSubcatName,AssetSubcatMST.AssetSubCatIMG,AssetSubcatMST.Measurement,AssetSubcatMST.auditor,AssetSubcatMST.incharge,AssetSubcatMST.supervisor,audit.Name as auditorname,incharge.Name as inchargename,supervisor.Name as supervisorname,NumberOfPicture,titleStatus,VerificationInterval , AssetSubcatMST.DepreciationRate');
        $this->db->from('AssetSubcatMST');
        $this->db->join('RegisterMST AS audit', 'AssetSubcatMST.auditor = audit.AutoID','left');
        $this->db->join('RegisterMST AS incharge', 'AssetSubcatMST.incharge = incharge.AutoID','left');
        $this->db->join('RegisterMST AS supervisor', 'AssetSubcatMST.supervisor = supervisor.AutoID','left');
        $this->db->where('AssetSubcatMST.AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }

       public function getasset_list($data,$body){
        $userid=$data['AutoID'];
        $group_id=$data['GroupID'];
        $parentid=$data['ParentID'];

        $keyword=$body['keyword'];
        $start=$body['start'];
        $length=$body['length'];

       
        $this->db->select("AssetMst.AutoID,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate, CONCAT('upload/asset/',ImageName) AS ImageName,CONCAT('upload/qr-code/',UniqueRefNumber,'.png') AS qrImage");
        $this->db->from('AssetMst');

           if(!empty($keyword)) {  
            $this->db->group_start();
            $this->db->like('AssetOwner', $keyword);
            $this->db->or_like('AssetCat',$keyword);
            $this->db->or_like('UIN',$keyword);
            $this->db->or_like('VendorName',$keyword);
            $this->db->group_end();
            }

        $this->db->limit($body['length'] ?? null);
        $this->db->offset($body['start'] ?? null);

        $this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
        $this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
        $this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
        $this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
        $this->db->join('AssetFileMst as file', 'AssetMst.AutoID = file.AssetID','left');
        $this->db->where('AssetMst.ParentID',$parentid);
        if($group_id==4){
          $this->db->where('AssetMst.CreatedBy',$userid);
        }


        $this->db->where('AssetMst.IsDelete',0);

        $this->db->where('file.IsDelete',0);

        //for image condition
        $this->db->where('file.IsDelete',0);
        $this->db->where('file.DocType',1);
        
        $query = $this->db->get();
       
        return $query->result_array();
        
      }
      
  

      

      public function getwarrant_basedonsubcat($id){
         
        $this->db->select('AutoID,WarrantyTypeName');
        $this->db->from('WarrantyTypeMST');
        $this->db->where('AssetSubCat',$id);
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();
        
      }

      

      public function getoneasset($id){

        $this->db->select('AssetMst.AutoID as Assetid,AssetMst.Auditor as Auditorid,AssetMst.Incharge as Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,Company.CompanyName as AssetOwner,AssetMst.AssetCat,AssetMst.AssetSubcat,AssetMst.Measurement,AssetMst.AssetTitle,AssetMst.AssetQuantity,AssetMst.isVerify,AssetMst.isRemove,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,RegisterMST.CompanyName,AssettypeMST.AsseTypeName,UIN, convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,VendorAddress,DimensionOfAsset,VendorMobile,VendorEmail,AssetMst.DepreciationRate,ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,WarrantyCard,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,AssetMst.UniqueRefNumber as UniqueRefNumber,titleStatus,WarrantyCoverdfor,convert(varchar,InsuranceValidUpto, 23) as InsuranceValidUpto,WarrantyContactPersonMobile,WarrantyContactPersonEmail,AssetMst.WarrantyCoverdfor,AssetMst.UniqueRefNumber,AssetMst.VerificationDate,location.Name as Locationname,AssetMst.CurrentLocation,AssetMst.Location as Location_id');
        $this->db->from('AssetMst');
        $this->db->join('AssettypeMST', 'AssetMst.AssetType = AssettypeMST.AutoID');
        $this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
        $this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
        $this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
        $this->db->join('MaterialMST', 'AssetMst.AssetCondition = MaterialMST.AutoID');
        $this->db->join('RegisterMST AS audit', 'AssetMst.Auditor = audit.AutoID','left');
        $this->db->join('RegisterMST AS incharge', 'AssetMst.Incharge = incharge.AutoID','left');
        $this->db->join('RegisterMST AS supervisor', 'AssetMst.Supervisor = supervisor.AutoID','left');
        $this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
        $this->db->join('LocationMst as location', 'AssetMst.AssetOwner = location.AutoID','left');

        $this->db->where('AssetMst.AutoID',$id);
        $this->db->where('AssetMst.IsDelete',0);

        $query = $this->db->get();
        return $query->row();
        

    }
      public function getpictures($id){

        $this->db->select("AutoID,AssetID,CONCAT('upload/asset/',ImageName) AS ImageName,ImageTitle");
        $this->db->from('AssetFileMst');
        $this->db->where('DocType',1);
        $this->db->where('AssetID',$id);
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();

    }

     public function getdata_verify($id){

        $this->db->select('AutoID');
        $this->db->from('VerifyHST');
        $this->db->where('AssetID',$id);
        $query = $this->db->get();
        return $query->result();

       
    }
    public function get_location_bycompanyid($cid){
    $this->db->select('LocationMst.AutoID,Company.CompanyName,LocationMst.Name,LocationMst.ContactPerson,LocationMst.Email,LocationMst.Phone');
    $this->db->from('LocationMst');
    $this->db->join('CompanyMst as Company', 'LocationMst.CompanyID = Company.AutoID','left');
    $this->db->where('Company.AutoID',$cid);
    $this->db->where('LocationMst.IsDelete is NULL');
    $query = $this->db->get();
    
    return $query->result_array();
}

    public function getpicturesby_doctypeid($id,$doctype){

        $this->db->select('ModifyDate,HisID');
        $this->db->from('AssetFileMst');
        $this->db->where('DocType',$doctype);
        $this->db->where('AssetID',$id);
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result();

        // print_r($query->result_array());
        // die();
    }
    public function getpicturesby_asstid($id){

        $this->db->select("CONCAT('upload/asset/',ImageName) AS ImageName,ModifyDate,DocType");
        $this->db->from('AssetFileMst');
        $this->db->where_in('HisID',$id);
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();

        // print_r($query->result_array());
        // die();
    }

    public function getsubpictures($id){

      $this->db->select('AutoID,AssetID,ImageName');
      $this->db->from('AssetSubcatFileMst');
      $this->db->where('AssetID',$id);
      $this->db->where('IsDelete',0);
      $query = $this->db->get();
      return $query->result_array();

  }

    public function getbils($id){

      $this->db->select("AutoID,AssetID,CONCAT('upload/asset/',ImageName) AS ImageName");
      $this->db->from('AssetFileMst');
      $this->db->where('DocType',2);
      $this->db->where('AssetID',$id);
      $this->db->where('IsDelete',0);
      $query = $this->db->get();
      return $query->result_array();

  }
  Public function getwaranty($id){

    $this->db->select("AutoID,AssetID,CONCAT('upload/asset/',ImageName) AS ImageName");
    $this->db->from('AssetFileMst');
    $this->db->where('DocType',3);
    $this->db->where('AssetID',$id);
    $this->db->where('IsDelete',0);
    $query = $this->db->get();
    return $query->result_array();


}

    public function getHistory($id){

      $this->db->select('RegisterMST.Name, convert(varchar,VerifiedOrRemoveDate, 101) as VRemoveDate,type,VerifyHST.AutoID,MaterialMST.ConditionName,RemoveStatus');
      $this->db->from('VerifyHST');
      $this->db->join('RegisterMST', 'VerifyHST.VerifiedOrRemoveBY= RegisterMST.AutoID','left');
      $this->db->join('MaterialMST', 'VerifyHST.VerifyCON= MaterialMST.AutoID','left');
      $this->db->where('VerifyHST.AssetID',$id);
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      return $query->result_array();

    }


      public function getoneasset_urn_uin($id){

             $this->db->select('AssetMst.AutoID as Assetid,AssetMst.Auditor as Auditorid,AssetMst.Incharge as Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,Company.CompanyName as AssetOwner,AssetMst.AssetCat,AssetMst.AssetSubcat,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,RegisterMST.CompanyName,AssettypeMST.AsseTypeName,UIN, convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,VendorAddress,DimensionOfAsset,VendorMobile,VendorEmail,AssetMst.DepreciationRate,ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,WarrantyCard,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,AssetMst.UniqueRefNumber as UniqueRefNumber,titleStatus,WarrantyCoverdfor,convert(varchar,InsuranceValidUpto, 23) as InsuranceValidUpto,WarrantyContactPersonMobile,WarrantyContactPersonEmail,AssetMst.WarrantyCoverdfor');
        $this->db->from('AssetMst');
        $this->db->join('AssettypeMST', 'AssetMst.AssetType = AssettypeMST.AutoID');
        $this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
        $this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
        $this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
        $this->db->join('MaterialMST', 'AssetMst.AssetCondition = MaterialMST.AutoID');
        $this->db->join('RegisterMST AS audit', 'AssetMst.Auditor = audit.AutoID','left');
        $this->db->join('RegisterMST AS incharge', 'AssetMst.Incharge = incharge.AutoID','left');
        $this->db->join('RegisterMST AS supervisor', 'AssetMst.Supervisor = supervisor.AutoID','left');
        $this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
      $this->db->where('AssetMst.UniqueRefNumber',$id);
      $this->db->or_where('AssetMst.UIN',$id);
      $this->db->where('AssetMst.IsDelete',0);
        $query = $this->db->get();
        return $query->row();

    }

    public function getid_from_qrdata($id){

             $this->db->select('AssetMst.AutoID as Assetid');
        $this->db->from('AssetMst');
       
      $this->db->where('AssetMst.UniqueRefNumber',$id);
      $this->db->or_where('AssetMst.UIN',$id);
      $this->db->where('AssetMst.IsDelete',0);
        $query = $this->db->get();
        return $query->row();

    }


    public function get_users($parentid,$rolename){

        $this->db->select('RegisterMST.AutoID,GroupID,RegisterMST.Name,Mobile,EmployeeCode,Email,UserName,isActive,ProfileIMG,UserGrouMSt.Name AS groupname,import_status,IsAdmin,Isauditor,issupervisor');   
        $this->db->from('RegisterMST');
        $this->db->join('UserGrouMSt', 'RegisterMST.UserGroupID = UserGrouMSt.AutoID');
        $this->db->where('ParentID',$parentid); 
        

        if ($rolename =='admin') {
          $this->db->where('IsAdmin',1); 
        }
        elseif ($rolename =='auditor') {
          $this->db->where('Isauditor',1); 
        }
        elseif ($rolename =='supervisor') {
          $this->db->where('issupervisor',1); 
        }
        // elseif($rolename== 'user'){
        //   $this->db->where('GroupID',4);
        // }
        
        $this->db->where('"IsDelete" IS NULL');
        $query = $this->db->get();
        return $query->result_array();

    }

     public function getassetlist_notify($from,$to,$id){
         
      $this->db->select('AssetMst.AutoID,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,DATEDIFF(day,GETDATE(),VerificationDate) as days');
      $this->db->from('AssetMst');
      $this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
      $this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
      $this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
      $this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
      $this->db->where("AssetMst.VerificationDate BETWEEN '$from' AND '$to'");
      $this->db->where('AssetMst.ParentID',$id);
      $query = $this->db->get();
      return $query->result_array();
      
    }

     public function getmeasuremnt_basedonsubcat($measurement){
      $where = "AutoID IN($measurement)";
      $this->db->select('AutoID,UomName');
      $this->db->from('UomMST');
      $this->db->where($where);
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      return $query->result_array();
    
    }

    public function get_removeassetdetails($id){

  $this->db->select('AssetMst.AutoID as Assetid,isRemove,RemovedLocation,convert(varchar,RemovedDatetime, 22) as RemovedDatetime,rby.Name as Rname,RemovedCondition.ConditionName as removecond,super.Email as supervisoremail');
  $this->db->from('AssetMst');
  $this->db->join('RegisterMST AS rby', 'AssetMst.RemovedBy = rby.AutoID','left');
  $this->db->join('MaterialMST as RemovedCondition', 'AssetMst.VerifyCondition = RemovedCondition.AutoID','left');
  $this->db->join('RegisterMST AS super', 'AssetMst.Supervisor = super.AutoID','left');
  $this->db->where('AssetMst.AutoID',$id);
  $this->db->where('AssetMst.IsDelete',0);
  $query = $this->db->get();
  $this->db->last_query();
  return $query->result_array(); 

}

  
    
  }
?>