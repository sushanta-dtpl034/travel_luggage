<?php
class Assetmodel extends CI_Model{
		
	Public function check_UniqueRefNumber_exists($UniqueRefNumber){
		$count=$this->db->where(['UniqueRefNumber'=>$UniqueRefNumber])->from("AssetMst")->count_all_results();
		return $count; 
	}
	/**
	 * Customize Queruy for Dashboard 
	 */
	function get_dashboard_data(){
		$sql="SELECT
        (SELECT SUM(NoofQRCode) FROM QRCodeHeadMst) AS TOTAL_QRCODE,
        (SELECT COUNT(*) FROM QRCodeDetailsMst WHERE IsUsed = 1) AS TOTAL_USED_QRCODE";
		$query =$this->db->query($sql);
		return $query->row();
	}

	public function getassettype($id=''){
			
		$this->db->select('AutoID,AsseTypeName');
		$this->db->from('AssettypeMST');
		if(!empty($id)){
			$this->db->where('ParentID',$id); 
		}
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
		
		
	public function getoneassettype($id){
		$this->db->select('AutoID,AsseTypeName');
		$this->db->from('AssettypeMST');
		$this->db->where('AutoID',$id);
		$query = $this->db->get();
		return $query->row();
	}
	public function getassettype_byname($name){
		$this->db->select('AutoID,AsseTypeName');
		$this->db->from('AssettypeMST');
		$this->db->where('AsseTypeName',$name);
		$query = $this->db->get();
		return $query->row();
	}

		
		public function getassetcat($id=''){         
		$this->db->select('AssetCatMST.AutoID as AutoID,,AssettypeMST.AsseTypeName as AsseTypeName,AssetCatMST.AsseCatName as AsseCatName');
		$this->db->join('AssettypeMST','AssetCatMST.AssetType=AssettypeMST.AutoID','left');
		$this->db->from('AssetCatMST');
		if(!empty($id)){
			$this->db->where('AssetCatMST.ParentID',$id);
		}
		$this->db->where('AssetCatMST.IsDelete',0);
		$this->db->order_by("AssettypeMST.AsseTypeName,AssetCatMST.AsseCatName", "asc");
		$query = $this->db->get();
		return $query->result_array();
		//echo $this->db->last_query();
		
		}
		public function getassetcat_byname($name){
			
		$this->db->select('AutoID,AsseCatName');
		$this->db->from('AssetCatMST');
		$this->db->where('AsseCatName',$name);
		$query = $this->db->get();
		return $query->row();
		
		}
		

		public function get_cat_basedontypeid($assetman_type){
			
		$this->db->select('AutoID,AsseCatName');
		$this->db->from('AssetCatMST');
		$this->db->where('AssetType',$assetman_type);
		$this->db->where('IsDelete',0);
		$query = $this->db->get();
		return $query->result_array();
		
		}
		public function getasset_list($parentid){
		$Isauditor=$this->session->userdata("userdata")['Isauditor'];
		$issupervisor=$this->session->userdata("userdata")['issupervisor'];
		$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];


		$userid=$this->session->userdata('userid');
		$group_id=$this->session->userdata('GroupID');
		$this->db->select("AssetMst.AutoID,FORMAT (AssetMst.PurchaseDate, 'dd-MM-yyyy') as date ,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice
		,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.AssetTitle,
		AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,AssetMst.CurrentLocation,
		CreatedBy.Name as CreatedBy, Auditor.Name as Auditor,Supervisor.Name as Supervisor,User.Name as User,Location.Name as Location,CurrencyMST.CurrencyCode");
		$this->db->from('AssetMst');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
		$this->db->join('RegisterMST as CreatedBy', 'AssetMst.CreatedBy = CreatedBy.AutoID','left');
		$this->db->join('RegisterMST as Auditor', 'AssetMst.Auditor = Auditor.AutoID','left');
		$this->db->join('RegisterMST as Supervisor', 'AssetMst.Supervisor = Supervisor.AutoID','left');
		$this->db->join('RegisterMST as User', 'AssetMst.Incharge = User.AutoID','left');
		$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
		$this->db->join('LocationMst as location', 'AssetMst.Location = location.AutoID','left');
		$this->db->join('CurrencyMST', 'CurrencyMST.AutoID = AssetMst.CurrencyType','left');
		$this->db->where('AssetMst.ParentID',$parentid);
		// if($group_id==4){
		//   $this->db->where('AssetMst.CreatedBy',$userid);
		// }
		if($IsAdmin==1){
			//admin
			}
			else{
			if($Isauditor == 1 && $issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
			$this->db->or_where('AssetMst.auditor',$userid);
			
			}
			else if($Isauditor == 1){
			$this->db->where('AssetMst.auditor',$userid);
			}
			else if($issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
			}
			else{
			$this->db->where('AssetMst.Incharge',$userid); 
			}
			}
		$this->db->where('AssetMst.IsDelete',0);
		$this->db->order_by("AssetMst.AutoID","desc");
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		return $query->result_array();

		
		}

		public function getmyasset_list($parentid){

		$userid=$this->session->userdata('userid');
		$group_id=$this->session->userdata('GroupID');
		$this->db->select('AssetMst.AutoID,AssetMst.AssetTitle,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice,
		VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,
		AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate');
		$this->db->from('AssetMst');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
		//  $this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
		$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
		
		//  $this->db->where('AssetMst.ParentID',$parentid);
		$this->db->where('AssetMst.Incharge',$userid);
		//  if($group_id==4){
		//    $this->db->where('AssetMst.CreatedBy',$userid);
		//  }


		


		$this->db->where('AssetMst.IsDelete',0);
		$query = $this->db->get();
		return $query->result_array();
		
		}
		


		public function getassetsubcat($id=''){
			
		$this->db->select('AssetSubcatMST.AutoID,AssetCatMST.AsseCatName as catname,
		AssetSubcatName,AssetSubcatMST.VerificationInterval,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor
		,NumberOfPicture,AssetSubcatMST.titleStatus,AssetSubcatMST.DepreciationRate');
		$this->db->from('AssetSubcatMST');
		$this->db->join('AssetCatMST', 'AssetSubcatMST.AssetCatName = AssetCatMST.AutoID','left');
		$this->db->join('RegisterMST AS audit', 'AssetSubcatMST.auditor = audit.AutoID','left');
		$this->db->join('RegisterMST AS incharge', 'AssetSubcatMST.incharge = incharge.AutoID','left');
		$this->db->join('RegisterMST AS supervisor', 'AssetSubcatMST.supervisor = supervisor.AutoID','left');
		if(!empty($id)){
			$this->db->where('AssetSubcatMST.ParentID',$id); 
		}
		$this->db->where('"AssetSubcatMST.IsDelete" IS NULL');
		$query = $this->db->get();
		return $query->result_array();
		}
		

		public function getoneassetcat($id)
		{
		$this->db->select('AutoID,AsseCatName,AssetType,AssetCatIMG');
		$this->db->from('AssetCatMST');
		$this->db->where('AutoID',$id);
		$query = $this->db->get();
		return $query->row();
		}

		public function getoneassetsubcat($id)
		{
		$this->db->select('AssetSubcatMST.AutoID,AssetSubcatMST.AssetCatName,AssetSubcatMST.AssetSubcatName,AssetSubcatMST.AssetSubCatIMG,AssetSubcatMST.Measurement,AssetSubcatMST.auditor,AssetSubcatMST.incharge,AssetSubcatMST.supervisor,audit.Name as auditorname,incharge.Name as inchargename,supervisor.Name as supervisorname,NumberOfPicture,titleStatus,VerificationInterval,Measurement,DepreciationRate');
		$this->db->from('AssetSubcatMST');
		$this->db->join('RegisterMST AS audit', 'AssetSubcatMST.auditor = audit.AutoID','left');
		$this->db->join('RegisterMST AS incharge', 'AssetSubcatMST.incharge = incharge.AutoID','left');
		$this->db->join('RegisterMST AS supervisor', 'AssetSubcatMST.supervisor = supervisor.AutoID','left');
		$this->db->where('AssetSubcatMST.AutoID',$id);
		$query = $this->db->get();
		return $query->row();
		}




		public function getoneuom($id)
		{
		$this->db->select('AutoID,UomName,UomShortName');
		$this->db->from('UomMST');
		$this->db->where('AutoID',$id);
		$query = $this->db->get();
		return $query->row();
		}
		public function getuom($id=''){
			
		$this->db->select('AutoID,UomName,UomShortName');
		$this->db->from('UomMST');
		if(!empty($id)){
			$this->db->where('ParentID',$id);
		}
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
		public function getwarrant_basedonsubcat($id){
			
		$this->db->select('AutoID,WarrantyTypeName');
		$this->db->from('WarrantyTypeMST');
		$this->db->where('AssetSubCat',$id);
		$this->db->where('"IsDelete" IS NULL');
		$query = $this->db->get();
		return $query->result_array();
		
		}

		

		public function getoneasset($id){

		$this->db->select('AssetMst.AutoID as Assetid,AssetMst.Auditor as Auditorid,AssetMst.Incharge as 
		Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,
		AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,AssetMst.CurrentLocation,Company.CompanyName as AssetOwner,
		AssetMst.AssetCat,AssetMst.AssetSubcat,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,
		VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.DepreciationRate,Company.CompanyName,AssettypeMST.AsseTypeName,UIN, 
		convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,VendorAddress,DimensionOfAsset,VendorMobile,
		VendorEmail,ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,
		WarrantyCard,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,
		AssetMst.UniqueRefNumber as UniqueRefNumber,titleStatus,WarrantyCoverdfor,convert(varchar,InsuranceValidUpto, 23) as InsuranceValidUpto,WarrantyContactPersonMobile,
		WarrantyContactPersonEmail,AssetMst.WarrantyCoverdfor,AssetMst.AssetTitle,AssetMst.AssetQuantity,AssetMst.Measurement,
		AssetSubcatMST.Measurement as subcatmeaurement,location.Name as Location,AssetMst.Location as Lid,AssetMst.CurrencyType,AssetMst.UniqueRefNumber');
		$this->db->from('AssetMst');
		$this->db->join('AssettypeMST', 'AssetMst.AssetType = AssettypeMST.AutoID');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
		// $this->db->join('RegisterMST', 'AssetMst. = RegisterMST.AutoID','left');
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

		$this->db->select('AutoID,AssetID,ImageName,ImageTitle');
		$this->db->from('AssetFileMst');
		$this->db->where('DocType',1);
		$this->db->where('AssetID',$id);
		$this->db->where('IsDelete',0);
		$query = $this->db->get();
		return $query->result_array();

	}

	public function getpictures_assetids($id){

		$this->db->select('AutoID,AssetID,ImageName,ImageTitle');
		$this->db->from('AssetFileMst');
		$this->db->where('DocType',1);
		$this->db->where_in('AssetID',$id);
		$this->db->where('IsDelete',0);
		$query = $this->db->get();
		return $query->result_array();

	}

	public function getasset_ids($id){

		$this->db->select('AutoID');
		$this->db->from('AssetMst');
		$this->db->where('IsDelete',0);
		$query = $this->db->get();
		return $query->result_array();

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

		$this->db->select('AutoID,AssetID,ImageName');
		$this->db->from('AssetFileMst');
		$this->db->where('DocType',2);
		$this->db->where('AssetID',$id);
		$this->db->where('IsDelete',0);
		$query = $this->db->get();
		return $query->result_array();

	}
	Public function getwaranty($id){

	$this->db->select('AutoID,AssetID,ImageName');
	$this->db->from('AssetFileMst');
	$this->db->where('DocType',3);
	$this->db->where('AssetID',$id);
	$this->db->where('IsDelete',0);
	$query = $this->db->get();
	return $query->result_array();


	}

	Public function getverifiypic($id){

	$this->db->select('AutoID,AssetID,ImageName');
	$this->db->from('AssetFileMst');
	$this->db->where('DocType',4);
	$this->db->where('AssetID',$id);
	$this->db->where('IsDelete',0);
	$query = $this->db->get();
	return $query->result_array();


	}

	Public function getremovepic($id){

	$this->db->select('AutoID,AssetID,ImageName');
	$this->db->from('AssetFileMst');
	$this->db->where('DocType',5);
	$this->db->where('AssetID',$id);
	$this->db->where('IsDelete',0);
	$query = $this->db->get();
	return $query->result_array();


	}

	Public function check_veryfy_data_exists($assetid){
	$count=$this->db->where(['AssetID'=>$assetid])->from("VerifyHST")->count_all_results();
	return $count; 
	}

	public function get_assetforqr($decryption){

	$this->db->select('AssetMst.AutoID as Assetid,AssetMst.Auditor as Auditorid,AssetMst.AssetTitle,AssetMst.AssetQuantity,AssetMst.Incharge as Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,
	RegisterMST.CompanyName as AssetOwner,AssetCat,AssetSubcat,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,
	VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,RegisterMST.CompanyName,
	AssettypeMST.AsseTypeName,UIN, convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,
	VendorAddress,DimensionOfAsset,VendorMobile,VendorEmail,AssetMst.DepreciationRate,
	MaterialMST.ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,WarrantyCard,
	audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,verified.Name as vname,convert(varchar,VerifiedDatetime, 22) as VerifiedDatetime,verifiedcon.ConditionName as verifycon,isVerify,isRemove,RemovedLocation,convert(varchar,RemovedDatetime, 22) as RemovedDatetime,rby.Name as Rname,RemovedCondition.ConditionName as removecond,VerifiedLocation,Company.CompanyName,AssetSubcatMST.VerificationInterval,AssetMst.CreatedDate,AssetMst.VerificationDate,AssetSubcatMST.NumberOfPicture,AssetSubcatMST.titleStatus,AssetMst.UniqueRefNumber,AssetMst.WarrantyCoverdfor,AssetMst.InsuranceValidUpto,AssetMst.WarrantyContactPersonMobile,AssetMst.WarrantyContactPersonEmail');
	$this->db->from('AssetMst');
	$this->db->join('AssettypeMST', 'AssetMst.AssetType = AssettypeMST.AutoID');
	$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
	$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
	$this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
	$this->db->join('MaterialMST', 'AssetMst.AssetCondition = MaterialMST.AutoID');
	$this->db->join('RegisterMST AS audit', 'AssetMst.Auditor = audit.AutoID','left');
	$this->db->join('RegisterMST AS incharge', 'AssetMst.Incharge = incharge.AutoID','left');
	$this->db->join('RegisterMST AS supervisor', 'AssetMst.Supervisor = supervisor.AutoID','left');
	$this->db->join('RegisterMST AS verified', 'AssetMst.VerifiedBy = verified.AutoID','left');
	$this->db->join('MaterialMST as verifiedcon', 'AssetMst.VerifyCondition = verifiedcon.AutoID','left');
	$this->db->join('RegisterMST AS rby', 'AssetMst.RemovedBy = rby.AutoID','left');
	$this->db->join('MaterialMST as RemovedCondition', 'AssetMst.VerifyCondition = RemovedCondition.AutoID','left');
	$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
	$this->db->where('AssetMst.UniqueRefNumber',$decryption);
	$this->db->where('AssetMst.IsDelete',0);
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


	public function getquarter($parentid=''){
	$this->db->select('AutoID,QuarterlyName,convert(varchar,Fromdate,103) as Fromdate,convert(varchar,Todate,103) as Todate');
	$this->db->from('QuarterMst');
	if(!empty($id)){
		$this->db->where('ParentID',$parentid);
	}
	$this->db->where('IsDelete',0);
	$query = $this->db->get();
	return $query->result_array();
	}

	public function getonequarter($id){
	$this->db->select('AutoID,QuarterlyName,convert(varchar,Fromdate,23) as Fromdate,convert(varchar,Todate,23) as Todate');
	$this->db->from('QuarterMst');
	$this->db->where('AutoID',$id);
	$this->db->where('IsDelete',0);
	$query = $this->db->get();
	return $query->row();

	}
	public function getwarantytype($id=''){
			
	$this->db->select('AutoID,WarrantyTypeName');
	$this->db->from('WarrantyTypeMST');
	if(!empty($id)){
	$this->db->where('ParentID',$id);
	}
	$this->db->where('"IsDelete" IS NULL');
	$query = $this->db->get();
	return $query->result_array();

	}
	public function getremindersetting($id){
			
	$this->db->select('rs.AutoID,Reminderdays,AssetCatMST.AsseCatName as catname,AssetSubcatMST.AssetSubcatName as subcatname,rs.ParentID');
	$this->db->from('RemindersettingMST as rs');
	$this->db->join('AssetCatMST', 'rs.AssetCat = AssetCatMST.AutoID');
	$this->db->join('AssetSubcatMST', 'rs.AssetSubcat = AssetSubcatMST.AutoID');
	$this->db->where('rs.ParentID',$id);
	$this->db->where('rs.IsDelete',0);
	$query = $this->db->get();
	return $query->result_array();

	}
	public function getonewarrantytype($id)
	{
	$this->db->select('AutoID,WarrantyTypeName,AssetCat,AssetSubCat');
	$this->db->from('WarrantyTypeMST');
	$this->db->where('AutoID',$id);
	$query = $this->db->get();
	return $query->row();
	}

	public function get_assetforverify($decryption){
		$Isauditor=$this->session->userdata("userdata")['Isauditor'];
		$issupervisor=$this->session->userdata("userdata")['issupervisor'];
		$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
		$userid=$this->session->userdata('userid');

		$this->db->select('AssetMst.AutoID as Assetid,AssetMst.UniqueRefNumber as UniqueRefNumber,AssetMst.AssetTitle,AssetMst.AssetQuantity,AssetMst.Auditor as Auditorid,AssetMst.Incharge as Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,RegisterMST.CompanyName as AssetOwner,AssetCat,AssetSubcat,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,RegisterMST.CompanyName,AssettypeMST.AsseTypeName,UIN, convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,VendorAddress,DimensionOfAsset,VendorMobile,VendorEmail,AssetMst.DepreciationRate,MaterialMST.ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,WarrantyCard,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,verified.Name as vname,convert(varchar,VerifiedDatetime, 22) as VerifiedDatetime,verifiedcon.ConditionName as verifycon,isVerify,isRemove,RemovedLocation,convert(varchar,RemovedDatetime, 22) as RemovedDatetime,rby.Name as Rname,RemovedCondition.ConditionName as removecond,VerifiedLocation,Company.CompanyName');
		$this->db->from('AssetMst');
		$this->db->join('AssettypeMST', 'AssetMst.AssetType = AssettypeMST.AutoID','left');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
		$this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
		$this->db->join('MaterialMST', 'AssetMst.AssetCondition = MaterialMST.AutoID');
		$this->db->join('RegisterMST AS audit', 'AssetMst.Auditor = audit.AutoID','left');
		$this->db->join('RegisterMST AS incharge', 'AssetMst.Incharge = incharge.AutoID','left');
		$this->db->join('RegisterMST AS supervisor', 'AssetMst.Supervisor = supervisor.AutoID','left');
		$this->db->join('RegisterMST AS verified', 'AssetMst.VerifiedBy = verified.AutoID','left');
		$this->db->join('MaterialMST as verifiedcon', 'AssetMst.VerifyCondition = verifiedcon.AutoID','left');
		$this->db->join('RegisterMST AS rby', 'AssetMst.RemovedBy = rby.AutoID','left');
		$this->db->join('MaterialMST as RemovedCondition', 'AssetMst.VerifyCondition = RemovedCondition.AutoID','left');
		$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
		if($IsAdmin==1){
		//admin
		}
		else{
		if($Isauditor == 1 && $issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
			$this->db->or_where('AssetMst.auditor',$userid);
		
		}
		else if($Isauditor == 1){
			$this->db->where('AssetMst.auditor',$userid);
		}
		else if($issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
		}
		else{
			$this->db->where('AssetMst.Incharge',$userid); 
		}
		}

		
		$this->db->where('AssetMst.UniqueRefNumber',$decryption);
		$this->db->or_where('AssetMst.UIN',$decryption);
		$this->db->where('AssetMst.IsDelete',0);
		$query = $this->db->get();
		// $this->db->last_query();
		// print_r($this->db->last_query());
		return $query->result_array();
		

	}

	public function getassetfor_remove($decryption){

		$this->db->select('AssetMst.AutoID as Assetid,AssetMst.UniqueRefNumber as UniqueRefNumber,AssetMst.Auditor as Auditorid,AssetMst.Incharge as Inchargeid,AssetMst.Supervisor as Supervisorid,AssetMst.AssetOwner as Assetownerid,AssetMst.AssetType,AssetMst.AssetCondition,AssetMst.AssetCat,AssetMst.AssetSubcat,RegisterMST.CompanyName as AssetOwner,AssetCat,AssetSubcat,UIN,cast(AssetMst.PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,RegisterMST.CompanyName,AssettypeMST.AsseTypeName,UIN, convert(varchar,PurchaseDate, 23) as PurchaseDate,VendorName,VendorAddress,DimensionOfAsset,VendorMobile,VendorEmail,AssetSubcatMST.DepreciationRate,MaterialMST.ConditionName,convert(varchar,ValidTil, 23) as ValidTil,Picture,VendorBill,WarrantyCard,audit.Name as auditor,incharge.Name as incharge,supervisor.Name as supervisor,verified.Name as vname,convert(varchar,VerifiedDatetime, 22) as VerifiedDatetime,verifiedcon.ConditionName as verifycon,isVerify,isRemove,RemovedLocation,convert(varchar,RemovedDatetime, 22) as RemovedDatetime,rby.Name as Rname,RemovedCondition.ConditionName as removecond,VerifiedLocation,Company.CompanyName');
		$this->db->from('AssetMst');
		$this->db->join('AssettypeMST', 'AssetMst.AssetType = AssettypeMST.AutoID');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
		$this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
		$this->db->join('MaterialMST', 'AssetMst.AssetCondition = MaterialMST.AutoID');
		$this->db->join('RegisterMST AS audit', 'AssetMst.Auditor = audit.AutoID','left');
		$this->db->join('RegisterMST AS incharge', 'AssetMst.Incharge = incharge.AutoID','left');
		$this->db->join('RegisterMST AS supervisor', 'AssetMst.Supervisor = supervisor.AutoID','left');
		$this->db->join('RegisterMST AS verified', 'AssetMst.VerifiedBy = verified.AutoID','left');
		$this->db->join('MaterialMST as verifiedcon', 'AssetMst.VerifyCondition = verifiedcon.AutoID','left');
		$this->db->join('RegisterMST AS rby', 'AssetMst.RemovedBy = rby.AutoID','left');
		$this->db->join('MaterialMST as RemovedCondition', 'AssetMst.VerifyCondition = RemovedCondition.AutoID','left');
		$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
		$this->db->where('AssetMst.UniqueRefNumber',$decryption);
		$this->db->or_where('AssetMst.UIN',$decryption);
		$this->db->where('AssetMst.isVerify',1);
		$this->db->where('AssetMst.IsDelete',0);
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
	public function getmeasuremnt_basedonsubcat($measurement){
		$where = "AutoID IN($measurement)";
		$this->db->select('AutoID,UomName');
		$this->db->from('UomMST');
		$this->db->where($where);
		$query = $this->db->get();
		
		return $query->result_array();

	}

	public function getassetlist_notify($from,$to,$parentid){
		
		$Isauditor=$this->session->userdata("userdata")['Isauditor'];
		$issupervisor=$this->session->userdata("userdata")['issupervisor'];
		$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
		
		$userid=$this->session->userdata('userid');
		$group_id=$this->session->userdata('GroupID');

		$this->db->select("AssetMst.AssetTitle,AssetMst.AutoID,AssetOwner,AssetCat,AssetSubcat,UIN,
		cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,
		AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.isVerify,AssetMst.isRemove,
		Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,
		DATEDIFF(day,GETDATE(),VerificationDate) as days,Auditor.Name as Auditor,Supervisor.Name as Supervisor,User.Name as User,User.Email as useremail,
		case when GETDATE() > VerificationDate then 'minus' else 'plus' end as daystatus");
		$this->db->from('AssetMst');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
		$this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
		$this->db->join('RegisterMST as Auditor', 'AssetMst.Auditor = Auditor.AutoID','left');
		$this->db->join('RegisterMST as Supervisor', 'AssetMst.Supervisor = Supervisor.AutoID','left');
		$this->db->join('RegisterMST as User', 'AssetMst.Incharge = User.AutoID','left');
		$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
		$this->db->where('AssetMst.ParentID',$parentid);
		// if($group_id==4){
		//   $this->db->where('AssetMst.CreatedBy',$userid);
		// }

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

	public function getremoveassest_dash($parenid){
		$Isauditor=$this->session->userdata("userdata")['Isauditor'];
		$issupervisor=$this->session->userdata("userdata")['issupervisor'];
		$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
		$userid=$this->session->userdata('userid');      

		$this->db->select('AutoID');
		$this->db->from('AssetMst');
		$this->db->where('ParentID',$parenid);
		$this->db->where('isRemove',1);
		$this->db->where('IsDelete',0);
		// $query = $this->db->get();
		if($IsAdmin==1){
		//admin
		}
		else{
		if($Isauditor == 1 && $issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
			$this->db->or_where('AssetMst.auditor',$userid);
		
		}
		else if($Isauditor == 1){
			$this->db->where('AssetMst.auditor',$userid);
		}
		else if($issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
		}
		else{
			$this->db->where('AssetMst.Incharge',$userid); 
		}
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getAttachement($id){
		$this->db->select('ImageName,ImageTitle');
		$this->db->from('AssetFileMst');
		$this->db->where('HisID',$id);
		$query = $this->db->get();
		return $query->result_array();
	}

	///////location//////////////
	public function getlocation($id){
		$this->db->select('LocationMst.AutoID,Company.CompanyName,LocationMst.Name,LocationMst.ContactPerson,LocationMst.Email,LocationMst.Phone,LocationMst.CountryCode');
		$this->db->from('LocationMst');
		$this->db->join('CompanyMst as Company', 'LocationMst.CompanyID = Company.AutoID','left');
		$this->db->where('LocationMst.ParentID',$id);
		$this->db->where('LocationMst.IsDelete is NULL');
		$query = $this->db->get();
		return $query->result_array();
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
	// public function checklocation_exists($cid,$name,$pid){
	//   $this->db->select('LocationMst.AutoID,LocationMst.CompanyID,LocationMst.Name,LocationMst.ContactPerson,LocationMst.Email,LocationMst.Phone');
	//   $this->db->from('LocationMst');
	//     // $this->db->join('CompanyMst as Company', 'LocationMst.CompanyID = Company.AutoID','left');
	//     $this->db->where('LocationMst.ParentID',$pid);
	//     $this->db->where('LocationMst.AutoID',$cid);
	//     $this->db->where('LocationMst.Name',$name);
	//     $this->db->where('LocationMst.IsDelete is NULL');
	//   $query = $this->db->get();
	//   return $query->row();

	// }
	public function getonelocation($id){
	$this->db->select('LocationMst.AutoID,LocationMst.CompanyID,LocationMst.Name,LocationMst.ContactPerson,LocationMst.Email,LocationMst.Phone,LocationMst.CountryCode');
	$this->db->from('LocationMst');
		// $this->db->join('CompanyMst as Company', 'LocationMst.CompanyID = Company.AutoID','left');
		$this->db->where('LocationMst.AutoID',$id);
		$this->db->where('LocationMst.IsDelete is NULL');
	$query = $this->db->get();
	return $query->row();

	}
	public function getoneassetdata($id){
		$this->db->select('AssetMst.AutoID,AssetMst.AssetTitle,AssetMst.UniqueRefNumber,AssetMst.CreatedDate,AssetCatMST.AsseCatName,
	AssetSubcatMST.AssetSubcatName,Company.CompanyName,LocationMst.Name');
	$this->db->from('AssetMst');
	$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
	$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
	$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
	$this->db->join('LocationMst', 'LocationMst.AutoID = AssetMst.Location','left');
	$this->db->where('AssetMst.AutoID',$id);
	$query =$this->db->get();
	return $query->row();
	}
	function get_qrcode_details_ids($qrcode_ids){
	$sql="SELECT AutoID,QRCodeText,QRCodeImage FROM QRCodeDetailsMst WHERE AutoID IN($qrcode_ids)";
	$query=$this->db->query($sql);
	return $query->result();
	}

	function get_asset_by_location($location){
	$this->db->select('AssetMst.AutoID,AssetMst.AssetTitle,AssetMst.UniqueRefNumber,AssetMst.CreatedDate,AssetCatMST.AsseCatName,
	AssetSubcatMST.AssetSubcatName,Company.CompanyName,LocationMst.Name');
	$this->db->from('AssetMst');
	$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
	$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
	$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
	$this->db->join('LocationMst', 'LocationMst.AutoID = AssetMst.Location','left');
	$this->db->where('AssetMst.Location',$location);
	$query =$this->db->get();
	return $query->result();
	}
	function get_asset_details_ids($ids){
	$assetIds =explode(',', $ids);
	$this->db->select('AssetMst.AutoID,AssetMst.AssetTitle,AssetMst.UniqueRefNumber,AssetMst.CreatedDate,AssetCatMST.AsseCatName,
	AssetSubcatMST.AssetSubcatName,Company.CompanyName,LocationMst.Name');
	$this->db->from('AssetMst');
	$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
	$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
	$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
	$this->db->join('LocationMst', 'LocationMst.AutoID = AssetMst.Location','left');
	$this->db->where_in('AssetMst.AutoID',$assetIds);
	$query =$this->db->get();
	return $query->result();
	}
	public function getasset_urn($parentid,$ownerType){
	$this->db->select("AssetMst.AutoID,UniqueRefNumber,AssetTitle");
	$this->db->from('AssetMst');
	if($ownerType==2){
		$this->db->where('AssetMst.Incharge',$parentid);
	}else{
		$this->db->where('AssetMst.AssetOwner',$parentid);
	}

	$this->db->where('AssetMst.IsDelete',0);
	$this->db->where('AssetMst.isRemove is NULL');
	$this->db->order_by("AssetMst.AutoID","desc");
	$query = $this->db->get();
	return $query->result_array();
	}
	public function getAssettransferdetails($id){
	$this->db->select('fc.CompanyName as fromcompany,tc.CompanyName as tocompany,fu.Name as fromuser,tu.Name as touser,asset.UniqueRefNumber as urn,cb.Name as Transferby,convert(varchar,AssettransferHIS.TransferDatetime,22) as TransferDatetime,AssettransferHIS.Type');    
	$this->db->from('AssettransferHIS');
	$this->db->join('CompanyMst as fc','AssettransferHIS.FromCompany = fc.AutoID','left');
	$this->db->join('CompanyMst as tc','AssettransferHIS.ToCompany = tc.AutoID','left');
	$this->db->join('RegisterMST as fu','AssettransferHIS.FromUser = fu.AutoID','left');
	$this->db->join('RegisterMST as tu','AssettransferHIS.ToUser = tu.AutoID','left');
	$this->db->join('AssetMst as asset','AssettransferHIS.AssetID = asset.AutoID','left');
	$this->db->join('RegisterMST as cb','AssettransferHIS.CreatedBy = cb.AutoID','left');
	$this->db->where('AssettransferHIS.AssetID',$id); // Produces: WHERE name = 'Joe'
	$query = $this->db->get();
	return $query->result_array();


	}

	public function getUserslistfornotify($dates){
	$this->db->distinct();
	$this->db->select('User.AutoID as userid,User.Email as Email,User.UserName as UserName');
	$this->db->from('AssetMst');
	$this->db->join('RegisterMST as User', 'AssetMst.Incharge = User.AutoID','left');
	// $this->db->where("AssetMst.VerificationDate",$from);
	$this->db->where_in('AssetMst.VerificationDate', $dates);
	// $this->db->where("AssetMst.VerificationDate BETWEEN '$from' AND '$to'");
		$query = $this->db->get();
		return $query->result_array();
		
	}
	public function getDetailsforverification($dates,$userid){

	$this->db->select('AssetMst.AutoID,AssetOwner,AssetCat,AssetSubcat,UIN,
	cast(PurchasePrice as decimal(10,2)) as PurchasePrice,VendorName,AssetCatMST.AsseCatName,
	AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.isVerify,AssetMst.isRemove,
	Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,
	DATEDIFF(day,GETDATE(),VerificationDate) as days,Auditor.Name as Auditor,Supervisor.Name as Supervisor,User.Name as User,User.Email as useremail,AssetMst.AssetTitle');
	$this->db->from('AssetMst');
	$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID');
	$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID');
	$this->db->join('RegisterMST', 'AssetMst.AssetOwner = RegisterMST.AutoID','left');
	$this->db->join('RegisterMST as Auditor', 'AssetMst.Auditor = Auditor.AutoID','left');
		$this->db->join('RegisterMST as Supervisor', 'AssetMst.Supervisor = Supervisor.AutoID','left');
		$this->db->join('RegisterMST as User', 'AssetMst.Incharge = User.AutoID','left');
	$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
	//  $this->db->where("AssetMst.VerificationDate BETWEEN '$from' AND '$to'");
	$this->db->where_in('AssetMst.VerificationDate',$dates);
	$this->db->where('AssetMst.Incharge',$userid);
	$query = $this->db->get();
	return $query->result_array();

	}
	// public function getonRemindersetting($id)
	// {
	//   $this->db->select('AutoID,AssetCat,AssetSubCat,ParentID,Reminderdays');
	//   $this->db->from('RemindersettingMST');
	//   $this->db->where('AutoID',$id);
	//   $query = $this->db->get();
	//   return $query->row();
	// }
	public function assetlist($parentid){

	$data = $this->input->post();
	//For Filter
	$columnIndex = $data['order'][0]['column']; // Column index
	$columnName = $data['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $data['order'][0]['dir']; // asc or desc
	$keyword = trim($data["search"]["value"]);
	$Isauditor=$this->session->userdata("userdata")['Isauditor'];
	$issupervisor=$this->session->userdata("userdata")['issupervisor'];
	$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
	$userid=$this->session->userdata('userid');
	$group_id=$this->session->userdata('GroupID');


	$this->db->select("AssetMst.AutoID,FORMAT (AssetMst.PurchaseDate, 'dd-MM-yyyy') as date ,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice
	,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.AssetTitle,
	AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,AssetMst.CurrentLocation,
	CreatedBy.Name as CreatedBy, Auditor.Name as Auditor,Supervisor.Name as Supervisor,User.Name as User,Location.Name as Location,CurrencyMST.CurrencyCode");
	$this->db->from('AssetMst');
	$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
	$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
	$this->db->join('RegisterMST as CreatedBy', 'AssetMst.CreatedBy = CreatedBy.AutoID','left');
	$this->db->join('RegisterMST as Auditor', 'AssetMst.Auditor = Auditor.AutoID','left');
	$this->db->join('RegisterMST as Supervisor', 'AssetMst.Supervisor = Supervisor.AutoID','left');
	$this->db->join('RegisterMST as User', 'AssetMst.Incharge = User.AutoID','left');
	$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
	$this->db->join('LocationMst as location', 'AssetMst.Location = location.AutoID','left');
	$this->db->join('CurrencyMST', 'CurrencyMST.AutoID = AssetMst.CurrencyType','left');
	$this->db->where('AssetMst.ParentID',$parentid);

	if(!empty($keyword)) {
		$this->db->group_start();
		$this->db->like('AssetMst.AssetTitle', $keyword);
		$this->db->or_like('AssetMst.UniqueRefNumber', $keyword);
		$this->db->or_like('Company.CompanyName', $keyword);
		$this->db->or_like('Location.Name', $keyword);
		$this->db->or_like('AssetCatMST.AsseCatName', $keyword);
		$this->db->or_like('AssetSubcatMST.AssetSubcatName', $keyword);
		$this->db->group_end();
	}
	$pendingstatus = $this->input->post('pendingstatus');
	if($pendingstatus=='Pending'){
			$this->db->where('AssetMst.isVerify is NULL');
		}
	if($pendingstatus=='Removed'){
		$this->db->where('AssetMst.isVerify',1);
		$this->db->where('AssetMst.isRemove',1);
	}
	if($pendingstatus=='Verified'){
		$this->db->where('AssetMst.isVerify=',1);
		$this->db->where('AssetMst.isRemove is NULL');
	}
	// if($group_id==4){
	//   $this->db->where('AssetMst.CreatedBy',$userid);
	// }

	if($IsAdmin==1){
		//admin
		}
		else{
		if($Isauditor == 1 && $issupervisor == 1){
		$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
		$this->db->or_where('AssetMst.auditor',$userid);
		}
		else if($Isauditor == 1){
		$this->db->where('AssetMst.auditor',$userid);
		}
		else if($issupervisor == 1){
		$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
		}
		else{
		$this->db->where('AssetMst.Incharge',$userid); 
		}
		}
		$this->db->where('AssetMst.IsDelete',0);
	$this->db->order_by("AssetMst.AutoID","desc");
	$countQuery = $this->db;
	$this->db->limit($data['length']);
	$this->db->offset($data['start']);
		$query = $this->db->get();
	$assetlist = $query->result();
	$assetlist = json_decode(json_encode($assetlist),true);
	$draw = $this->input->post('draw');
	$total = $countQuery->count_all_results('AssetMst');
	$totalFilter = count($assetlist);
	$contents = array("msg"=>"data found",
		"data"=>$assetlist,
		"draw"=>$draw,
		"recordsTotal"=>$total,
		"recordsFiltered"=>$total
	);
	return $contents;
	// echo $this->db->last_query();
	// die();

	}
	public function Companylist(){
		$data = $this->input->post();
		//For Filter
		$columnIndex = $data['order'][0]['column']; // Column index
		$columnName = $data['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $data['order'][0]['dir']; // asc or desc
		$keyword = trim($data["search"]["value"]);
		$query=$this->db->select("AutoID,Name,CCode,BankName,AccountNumber,IFSCCode");
		$this->db->from('CompanyMst');
		$this->db->where('Status', 1);
		if(!empty($keyword)) {
		$this->db->group_start();
		$this->db->like('Name', $keyword);
		$this->db->or_like('CCode', $keyword);
		$this->db->or_like('BankName', $keyword);
		$this->db->or_like('AccountNumber', $keyword);
		$this->db->or_like('IFSCCode', $keyword);
		$this->db->group_end();
		}
		if($columnIndex>=0){
		if($columnIndex==1){
			$this->db->order_by("CompanyMst.$columnName", $columnSortOrder);
		}
		else if($columnIndex==2){
			$this->db->order_by("CompanyMst.Name", $columnSortOrder);
		}
		
		elseif($columnIndex==3){
			$this->db->order_by("CompanyMst.CCode", $columnSortOrder);
		}elseif($columnIndex==4){
			$this->db->order_by("CompanyMst.BankName", $columnSortOrder);
		}elseif($columnIndex==5){
			$this->db->order_by("CompanyMst.AccountNumber", $columnSortOrder);
		}elseif($columnIndex==6){
			$this->db->order_by("CompanyMst.IFSCCode", $columnSortOrder);
		}
		
		}
		else{
		$this->db->order_by('CompanyMst.AutoID','asc');
		}
		$this->db->limit($data['length']);
		$this->db->offset($data['start']);
		$query=$this->db->get();
		$Companylist = $query->result();
		$Companylist = json_decode(json_encode($Companylist),true);
		$draw = $this->input->post('draw');
		$total = $this->db->where(['Status'=>1])->count_all_results('CompanyMst');
		$totalFilter = count($Companylist);
		if(!empty($keyword)) {
		$totalFilter = count($Companylist);
		}
		$contents = array("msg"=>"data found",
		"data"=>$Companylist,
		"draw"=>$draw,
		"recordsTotal"=>$total,
		"recordsFiltered"=>$total
		);
		return $contents;
	}

	public function getremoveassetlist($parentid){
		$Isauditor=$this->session->userdata("userdata")['Isauditor'];
	$issupervisor=$this->session->userdata("userdata")['issupervisor'];
	$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];


		$userid=$this->session->userdata('userid');
		$group_id=$this->session->userdata('GroupID');
		$this->db->select("AssetMst.AutoID,FORMAT (AssetMst.PurchaseDate, 'dd-MM-yyyy') as date ,AssetOwner,AssetCat,AssetSubcat,UIN,cast(PurchasePrice as decimal(10,2)) as PurchasePrice
		,VendorName,AssetCatMST.AsseCatName,AssetSubcatMST.AssetSubcatName,AssetMst.UniqueRefNumber,AssetMst.AssetTitle,
		AssetMst.isVerify,AssetMst.isRemove,Company.CompanyName,convert(varchar, VerificationDate, 103) as VerificationDate,AssetMst.CurrentLocation,
		CreatedBy.Name as CreatedBy, Auditor.Name as Auditor,Supervisor.Name as Supervisor,User.Name as User,Location.Name as Location,CurrencyMST.CurrencyCode");
		$this->db->from('AssetMst');
		$this->db->join('AssetCatMST', 'AssetMst.AssetCat = AssetCatMST.AutoID','left');
		$this->db->join('AssetSubcatMST', 'AssetMst.AssetSubcat = AssetSubcatMST.AutoID','left');
		$this->db->join('RegisterMST as CreatedBy', 'AssetMst.CreatedBy = CreatedBy.AutoID','left');
		$this->db->join('RegisterMST as Auditor', 'AssetMst.Auditor = Auditor.AutoID','left');
		$this->db->join('RegisterMST as Supervisor', 'AssetMst.Supervisor = Supervisor.AutoID','left');
		$this->db->join('RegisterMST as User', 'AssetMst.Incharge = User.AutoID','left');
		$this->db->join('CompanyMst as Company', 'AssetMst.AssetOwner = Company.AutoID','left');
		$this->db->join('LocationMst as location', 'AssetMst.Location = location.AutoID','left');
		$this->db->join('CurrencyMST', 'CurrencyMST.AutoID = AssetMst.CurrencyType','left');
		$this->db->where('AssetMst.ParentID',$parentid);
		$this->db->where('isRemove',1);
		// if($group_id==4){
		//   $this->db->where('AssetMst.CreatedBy',$userid);
		// }
		if($IsAdmin==1){
		//admin
		}
		else{
		if($Isauditor == 1 && $issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
			$this->db->or_where('AssetMst.auditor',$userid);
		
		}
		else if($Isauditor == 1){
			$this->db->where('AssetMst.auditor',$userid);
		}
		else if($issupervisor == 1){
			$this->db->where("(AssetMst.supervisor = $userid OR AssetMst.CreatedBy = $userid)");
		}
		else{
			$this->db->where('AssetMst.Incharge',$userid); 
		}
		}
		$this->db->where('AssetMst.IsDelete',0);
		$this->db->order_by("AssetMst.AutoID","desc");
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		return $query->result_array();

		
	}
	public function getasset_basedonuserrole($parentid){

		$Isauditor=$this->session->userdata("userdata")['Isauditor'];
		$issupervisor=$this->session->userdata("userdata")['issupervisor'];
		$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
		$userid=$this->session->userdata('userid');
		$this->db->select("AssetMst.AutoID,UniqueRefNumber,AssetTitle");
		$this->db->from('AssetMst');
		if($issupervisor==1){
		$this->db->group_start();
		$this->db->where('AssetMst.Incharge',$userid);
		$this->db->or_where('AssetMst.Supervisor',$userid);
		$this->db->group_end();
		}else{
		$this->db->group_start();
		$this->db->where('AssetMst.Incharge',$userid);
		$this->db->group_end();
		}
		$this->db->where('AssetMst.IsDelete',0);
		$this->db->where('AssetMst.isRemove is NULL');
		$this->db->order_by("AssetMst.AutoID","desc");
		$query = $this->db->get();
		return $query->result_array();
	}


	

}
?>