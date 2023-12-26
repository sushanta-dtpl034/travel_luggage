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

        $IsAdmin=$data['IsAdmin'];
        $Isauditor=$data['Isauditor'];
        $issupervisor=$data['issupervisor'];

        $keyword=$body['keyword'];
        $start=$body['start'];
        $length=$body['length'];

        $this->db->select("AM.AutoID,AssetOwner,AM.AssetCat,AM.AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AM.UniqueRefNumber,AM.isVerify,AM.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,CONCAT('upload/qr-code/',UniqueRefNumber,'.png') AS qrImage,currency.CurrencySymbole,currency.CurrencySymbole,AM.AssetTitle,ACM.AsseCatName,ASCM.AssetSubcatName,(SELECT COUNT(*) FROM VerifyHST WHERE VerifyHST.AssetID = AM.AutoID AND VerifyHST.type = 1) as VerificationCount");
        $this->db->from('AssetMst as AM');
        $this->db->join('AssetCatMST as ACM', 'ACM.AutoID = AM.AssetCat','left');
         $this->db->join('AssetSubcatMST as ASCM', 'ASCM.AutoID=AM.AssetSubcat','left');
        $this->db->join('CompanyMst as Company', 'AM.AssetOwner = Company.AutoID','left');
        $this->db->join('CurrencyMST as currency', 'AM.CurrencyType = currency.AutoID','left');

        if(!empty($keyword)) {  
            $this->db->group_start();
            $this->db->like('Company.CompanyName', $keyword);
            $this->db->or_like('ASCM.AssetSubcatName',$keyword);
            $this->db->or_like('UIN',$keyword);
            $this->db->or_like('UniqueRefNumber',$keyword);
            // $this->db->or_like('VendorName',$keyword);
            $this->db->or_like('AM.AssetTitle',$keyword);
            $this->db->group_end();
        }

        $this->db->limit($body['length'] ?? null);
        $this->db->offset($body['start'] ?? null);

        
        $this->db->where('AM.ParentID',$parentid);


        if($IsAdmin==1){
          //admin
         }
         else{
          if($Isauditor == 1 && $issupervisor == 1){
            $this->db->where("(AM.supervisor = $userid OR AM.CreatedBy = $userid)");
            $this->db->or_where('AM.auditor',$userid);
         
          }
         else if($Isauditor == 1){
            $this->db->where('AM.auditor',$userid);
          }
          else if($issupervisor == 1){
            $this->db->where("(AM.supervisor = $userid OR AM.CreatedBy = $userid)");
          }
          else{
            $this->db->where('AM.Incharge',$userid); 
          }
         }
        $this->db->where('AM.IsDelete',0);
        $this->db->order_by('AM.AutoID','DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        // foreach ($result as $key => $value) {
        //   $ids[]=$value->AutoID;
        //   getthum_img
        // }

        $values = array();
        foreach ($result as $key => $value) {
            $value['ImageName'] = $this->getthum_img($value['AutoID']);
            // $value['AsseCatName'] = $this->getcatName_byid($value['AssetCat']);
            // $value['AssetSubcatName'] = $this->get_subcatName_byid($value['AssetSubcat']);

          array_push($values, $value);
        }
          return $values;
        
      }

       public function get_myasset_list($id,$body){
            $this->db->select("AM.AutoID,AssetOwner,AM.AssetCat,AM.AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AM.UniqueRefNumber,AM.isVerify,AM.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,CONCAT('upload/qr-code/',UniqueRefNumber,'.png') AS qrImage,currency.CurrencySymbole,currency.CurrencySymbole,AM.AssetTitle,ACM.AsseCatName,ASCM.AssetSubcatName");
			$this->db->from('AssetMst as AM');
			
			
			$keyword=$body['keyword'];
			$start=$body['start'];
			$length=$body['length'];
			if(!empty($keyword)) {  
				$this->db->group_start();
				$this->db->like('Company.CompanyName', $keyword);
				$this->db->or_like('ASCM.AssetSubcatName',$keyword);
				$this->db->or_like('UIN',$keyword);
				$this->db->or_like('AM.UniqueRefNumber',$keyword);
				$this->db->or_like('AM.AssetTitle',$keyword);
				$this->db->group_end();
			}

			$this->db->limit($body['length'] ?? null);
			$this->db->offset($body['start'] ?? null);


			$this->db->join('AssetCatMST as ACM', 'ACM.AutoID = AM.AssetCat','left');
			$this->db->join('AssetSubcatMST as ASCM', 'ASCM.AutoID=AM.AssetSubcat','left');
			$this->db->join('CompanyMst as Company', 'AM.AssetOwner = Company.AutoID','left');
			$this->db->join('CurrencyMST as currency', 'AM.CurrencyType = currency.AutoID','left');
			$this->db->where('AM.Incharge',$id);
			$this->db->where('AM.IsDelete',0);
          
			$query = $this->db->get();
			$result = $query->result_array();


			$values = array();
			foreach ($result as $key => $value) {
				$value['ImageName'] = $this->getthum_img($value['AutoID']);
				// $value['AsseCatName'] = $this->getcatName_byid($value['AssetCat']);
				// $value['AssetSubcatName'] = $this->get_subcatName_byid($value['AssetSubcat']);

			  array_push($values, $value);
			}
			return $values;
        
		}
      
      function getcatName_byid($id){
      $this->db->select("AsseCatName");
        $this->db->from('AssetCatMST');
        $this->db->where('AutoID',$id);
        // $this->db->where('IsDelete',0);
        
        $query = $this->db->get();
        return $query->row()->AsseCatName;
      }

      function get_subcatName_byid($id){
      $this->db->select("AssetSubcatName");
        $this->db->from('AssetSubcatMST');
        $this->db->where('AutoID',$id);
        // $this->db->where('IsDelete',0);
         
        $query = $this->db->get();
        return $query->row()->AssetSubcatName;
      }


  

    public function getthum_img($id){
         
        $this->db->select("CONCAT('upload/asset/',ImageName) AS ImageName");
        $this->db->from('AssetFileMst');
        $this->db->where('AssetID',$id);
        $this->db->where('IsDelete',0);
          $this->db->where('DocType',1);
        $query = $this->db->get();
        // print_r();
        // die();
        return $query->row()->ImageName ?? null;
        
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

        $this->db->select('AssetMst.AutoID as Assetid,AssetMst.Auditor as Auditorid,AssetMst.Incharge as Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,Company.CompanyName as AssetOwner,AssetMst.AssetCat,AssetMst.AssetSubcat,AssetMst.Measurement,AssetMst.AssetTitle,AssetMst.AssetQuantity,AssetMst.isVerify,AssetMst.isRemove,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,AssetMst.CurrencyType as currency_type, VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,RegisterMST.CompanyName,AssettypeMST.AsseTypeName,UIN, convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,VendorAddress,DimensionOfAsset,VendorMobile,VendorEmail,AssetMst.DepreciationRate,ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,WarrantyCard,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,AssetMst.UniqueRefNumber as UniqueRefNumber,titleStatus,WarrantyCoverdfor,convert(varchar,InsuranceValidUpto, 23) as InsuranceValidUpto,WarrantyContactPersonMobile,WarrantyContactPersonEmail,AssetMst.WarrantyCoverdfor,AssetMst.UniqueRefNumber,AssetMst.VerificationDate,location.Name as Locationname,AssetMst.CurrentLocation,AssetMst.Location as Location_id,currency.CurrencySymbole,measurement.UomShortName,measurement.UomName,(SELECT COUNT(*) FROM VerifyHST WHERE VerifyHST.AssetID = AssetMst.AutoID AND VerifyHST.type = 1) as VerificationCount');

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
        $this->db->join('LocationMst as location', 'AssetMst.Location = location.AutoID','left');
        $this->db->join('CurrencyMST as currency', 'AssetMst.CurrencyType = currency.AutoID','left');
        $this->db->join('UomMST as measurement', 'AssetMst.Measurement = measurement.AutoID','left');

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


      public function getoneasset_urn_uin($keyword){

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
      $this->db->where('AssetMst.UniqueRefNumber',$keyword);
      $this->db->or_where('AssetMst.UIN',$keyword);
      
      $this->db->where('AssetMst.IsDelete',0);
        $query = $this->db->get();
        return $query->row();

    }

    public function getid_from_qrdata($id){
        $this->db->select('AssetMst.AutoID as Assetid, UIN,UniqueRefNumber,AssetMst.AssetCat,AssetMst.AssetSubcat,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,Location,LocationMst.Name');
        $this->db->from('AssetMst');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
        $this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
		$this->db->join('LocationMst', 'LocationMst.AutoID = AssetMst.Location');
		$this->db->where('AssetMst.UniqueRefNumber',$id);
		$this->db->or_where('AssetMst.UIN',$id);
		$this->db->where('AssetMst.IsDelete',0);
        $query = $this->db->get();
        return $query->row();

    }
	public function getid_from_rvsqrdata($id){
		$this->db->select('QRCodeHeadMst.CompanyID,Company.CompanyName');
        $this->db->from('QRCodeDetailsMst'); 
		$this->db->join('QRCodeHeadMst', 'QRCodeHeadMst.AutoID = QRCodeDetailsMst.QRCodeId');
		$this->db->join('CompanyMst as Company', 'Company.AutoID = QRCodeHeadMst.CompanyID','left');
		$this->db->where('QRCodeDetailsMst.QRCodeText',$id);
		$this->db->where('QRCodeDetailsMst.IsUsed',0);
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
        
        $this->db->where('IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();

    }

     public function getassetlist_notify($from,$to,$userid,$id,$IsAdmin,$Isauditor,$issupervisor){
         
      $this->db->select("AssetMst.AutoID,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,DATEDIFF(day,GETDATE(),VerificationDate) as days,case when GETDATE() > VerificationDate then 'minus' else 'plus' end as daystatus");
      $this->db->from('AssetMst');
      $this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
      $this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
      $this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
      $this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
      $this->db->where('AssetMst.ParentID',$id);
      if($IsAdmin==1){
        //admin
        $this->db->where('AssetMst.isVerify', NULL);
       }
       else{
        $this->db->where("AssetMst.VerificationDate BETWEEN '$from' AND '$to'");
        if($Isauditor == 1 && $issupervisor == 1){
          $this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
          $this->db->or_where('AssetMst.auditor',$userid);
       
        }
       else if($Isauditor == 1){
          // $this->db->where('AssetMst.auditor',$userid);
          $this->db->where('AssetSubcatMST.auditor',$userid);
        }
        else if($issupervisor == 1){
          $this->db->where("(AssetMst.supervisor = $userid)");
        }
        else{
          $this->db->where('AssetMst.Incharge',$userid); 
        }
       }
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      return $query->result_array();
    }

     public function getmeasuremnt_basedonsubcat($measurement){
      $where = "AutoID IN($measurement)";
      $this->db->select('AutoID,UomName,UomShortName');
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