<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model {
	// constructor
	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//$this->load->library('session');
	}

	  public function getcurrency($id){
         
        $this->db->select('AutoID,CurrencyName,CurrencyCode,CurrencySymbole,CurrencyUnicode');
        $this->db->from('CurrencyMST');
        $this->db->where("ParentID",$id);
        $this->db->where("IsDelete",0);
        $query = $this->db->get();
        return $query->result_array();
        
      }


	// public function ManageTable($data,$tableName,$type,$id=""){
	// 	if($type==1){
	// 		$this->db->insert($tableName,$data);
	// 		return $this->db->insert_id();
	// 	}
	// 	elseif($type==2){
	// 		$this->db->where('AutoID',$id);
 //            return $this->db->update($tableName, $data);
	// 	}
	// 	elseif($type==3){
	// 		$this->db->where('AutoID',$id);
 //            return $this->db->update($tableName, $data);
	// 	}
		
	// }
	
	// public function Companylist($data){
	// 	extract($data);
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("AutoID,Name,CCode,BankName,AccountNumber,IFSCCode");
	// 	$this->db->from('CompanyMst');
	// 	$this->db->where('Status', 1);
	// 	$this->db->where('IsDelete', 0);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('Name', $keyword);
	// 		$this->db->or_like('BankName', $keyword);
	// 		$this->db->or_like('AccountNumber', $keyword);
	// 		$this->db->or_like('IFSCCode', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
		
	// 	$Companylist = $query->result();
	// 	$Companylist = json_decode(json_encode($Companylist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['Status'=>1])->count_all_results('CompanyMst');
	// 	$totalFilter = count($Companylist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Companylist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Companylist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
	// }
	// public function Employeelist($data){
	// 	//extract($data);
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("AutoID,Name,Email,Phone");
	// 	$this->db->from('UserMst');
	// 	$this->db->where('Status', 1);
	// 	$this->db->where('IsDelete', 0);
	// 	$this->db->where('UserType', $data['UserType']);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('Name', $keyword);
	// 		$this->db->or_like('Email', $keyword);
	// 		$this->db->or_like('Phone', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
	// 	$Employeelist = $query->result();
	// 	$Employeelist = json_decode(json_encode($Employeelist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['UserType'=>5])->count_all_results('UserMst');
	// 	$totalFilter = count($Employeelist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Employeelist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Employeelist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
	// }

	// public function IrpUserList($data){
	// 	//extract($data);
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("AutoID,Name,Email,Phone");
	// 	$this->db->from('UserMst');
	// 	$this->db->where('Status', 1);
	// 	$this->db->where('UserType', 4);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('Name', $keyword);
	// 		$this->db->or_like('Email', $keyword);
	// 		$this->db->or_like('Phone', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
	// 	$Userlist = $query->result();
	// 	$Userlist = json_decode(json_encode($Userlist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['UserType'=>5])->count_all_results('UserMst');
	// 	$totalFilter = count($Userlist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Userlist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Userlist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
	// }


	// public function POlist($data){
		
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("*");
	// 	$this->db->from('POMst');
	// 	$this->db->where('IsActive', 1);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('PO', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
		
	// 	$POlist = $query->result();
	// 	$POlist = json_decode(json_encode($POlist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['IsActive'=>1])->count_all_results('POMst');
	// 	$totalFilter = count($POlist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($POlist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$POlist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
 //    }

	// public function POListByVendor($data,$vcode){
		
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("*");
	// 	$this->db->from('POMst');
	// 	$this->db->where('IsActive', 1);
	// 	$this->db->where('VendorID', $vcode);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('PO', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
	// 	$POlist = $query->result();
	// 	$POlist = json_decode(json_encode($POlist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['IsActive'=>1,'VendorID'=>$vcode])->count_all_results('POMst');
	// 	$totalFilter = count($POlist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($POlist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$POlist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
 //    }

	// function CheckVendorCode($vendor_code){
	// 	$this->db->select('*');
	// 	$this->db->from('ProfileMst');
	// 	$this->db->where('VendorCode',$vendor_code);
	// 	$num_results = $this->db->count_all_results();
	// 	if($num_results>0){
	// 		return true;
	// 	}
	// 	else{
	// 		return false;
	// 	}
	// }

	// public function CheckHeadNumber($HeadNo){
	// 	$this->db->select('*');
	// 	$this->db->from('HeadMst');
	// 	$this->db->where('HeadNo',$HeadNo);
	// 	$num_results = $this->db->count_all_results();
	// 	if($num_results>0){
	// 		return true;
	// 	}
	// 	else{
	// 		return false;
	// 	}
	// }

	// public function GetHeadNo($HeadNo){
 //        $query=$this->db->select("*");
	// 	$this->db->from('HeadMst');
	// 	$this->db->where('HeadNo', $HeadNo);
	// 	$query = $this->db->get();
	// 	return $query->row();
 //    }

	// public function GetVendorID($vendor_code){
 //        $query=$this->db->select("u.AutoID");
	// 	$this->db->from('UserMst u');
	// 	$this->db->join('ProfileMst p','u.AutoID=p.UserID','LEFT');
	// 	$this->db->where('p.VendorCode', $vendor_code);
	// 	$query = $this->db->get();
	// 	return $query->row();
 //    }

	// public function GetVendorCode($UserID){
 //        $query=$this->db->select("u.AutoID,p.VendorCode");
	// 	$this->db->from('ProfileMst p');
	// 	$this->db->join('UserMst u','u.AutoID=p.UserID','LEFT');
	// 	$this->db->where('p.UserID', $UserID);
	// 	$query = $this->db->get();
	// 	return $query->row();
 //    }

	// public function getcurrencylist($userid){
 //        $query=$this->db->select("CurrencyAccess.VendorID,CurrencyAccess.CurrencyID,CurrencyMst.Name,CurrencyMst.Symbol");
	// 	$this->db->from('CurrencyAccess');
	// 	$this->db->join('CurrencyMst','CurrencyMst.AutoID=CurrencyAccess.CurrencyID','LEFT');
	// 	$this->db->where('CurrencyAccess.VendorID', $userid);
	// 	$this->db->where('CurrencyMst.Status', 1);
	// 	$query = $this->db->get();
	// 	return $query->result();
 //    }

	// public function getcurrency(){
 //        $query=$this->db->select("CurrencyMst.AutoID,CurrencyMst.Name,CurrencyMst.Symbol");
	// 	$this->db->from('CurrencyMst');
	// 	$this->db->where('Status', 1);
	// 	$query = $this->db->get();
	// 	return $query->result();
 //    }

	// public function ManageUser($data,$type,$id=""){
	// 	if($type==1){
	// 		$this->db->insert('UserMst',$data);
	// 		return $this->db->insert_id();
	// 	}
	// 	elseif($type==2){
	// 		$this->db->where('AutoID', $id);
 //            return $this->db->update('UserMst', $data);
	// 	}
	// 	elseif($type==3){
	// 		$this->db->where('AutoID', $id);
 //            return $this->db->update('UserMst', $data);
	// 	}
	// }

	// public function ManageProfile($profile,$type,$id=""){
	// 	if($type==1){
	// 		$this->db->insert('ProfileMst',$profile);
	// 		return $this->db->insert_id();
	// 	}
	// 	elseif($type==2){
	// 		$this->db->where('UserID', $id);
 //            return $this->db->update('ProfileMst', $profile);
	// 	}
	// }

	// public function DeleteAccessCurrency($id){
	// 	$this->db->where('VendorID', $id);
 //        return $this->db->delete('CurrencyAccess');
 //    }

	// public function DeleteAccessHead($id){
	// 	$this->db->where('VendorID', $id);
 //        return $this->db->delete('HeadAccess');
 //    }

	// public function ManagePOVendor($data,$type,$id=""){
	// 	if($type==1){
	// 		$this->db->insert('POMst',$data);
	// 		return true;
	// 	}
	// 	elseif($type==2){
	// 		$this->db->where('PONumber', $id);
 //            return $this->db->update('POMst', $data);
	// 	}
	// 	elseif($type==3){
	// 		$this->db->where('PONumber', $id);
 //            return $this->db->update('POMst', $data);
	// 	}
	// }

	// public function GetUserVendorID($vendor_code){
 //        $query=$this->db->select("u.Name,u.AutoID,p.CompanyID as CompanyName");
	// 	$this->db->from('ProfileMst p');
	// 	$this->db->join('UserMst u','u.AutoID=p.UserID','LEFT');
	// 	$this->db->where('p.VendorCode', $vendor_code);
	// 	$query = $this->db->get();
	// 	return $query->row_array();
 //    }

	// public function CheckPONumber($PONumber){
	// 	$this->db->where('PONumber', $PONumber);
 //        $query = $this->db->get('POMst');
 //        $count_row = $query->num_rows();
 //        if ($count_row > 0) {
 //            return TRUE; 
 //         } else {
 //            return FALSE; 
 //         }
	// }

	// public function RequestList($data){
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("r.AutoID,r.ReqNo,r.Status,r.Name,r.CompanyName,sum(b.ConvertedAmount) as Total,r.CreatedDate,r.ATxnNo");
	// 	$this->db->from('Request as r');
	// 	$this->db->join('BillDetails as b', 'b.ReqID=r.AutoID','LEFT');
	// 	$this->db->join('ServiceMst as s', 's.AutoID=b.ServiceProvided','LEFT');
	// 	$this->db->group_by('r.AutoID,r.ReqNo,r.Status,r.Name,r.CompanyName,r.CreatedDate,r.ATxnNo');
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('r.ReqNo', $keyword);
	// 		$this->db->or_like('r.Status', $keyword);
	// 		$this->db->or_like('r.Name', $keyword);
	// 		$this->db->or_like('r.CompanyName', $keyword);
	// 		$this->db->or_like('r.CreatedDate', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	if($data['status']==11){
	// 		$this->db->where('b.ServiceProvided', 1); 
	// 	}
	// 	elseif($data['status']==10){
	// 		$this->db->where('b.ServiceProvided', 2); 
	// 	}
	// 	elseif($data['status']==""){
	// 		//$this->db->where('r.Status', $status); 
	// 	}
	// 	elseif($data['status']==6){
	// 		$this->db->where('s.Priority', 1); 
	// 	}
	// 	elseif($data['status']==7){
	// 		$this->db->where('r.ATxnNo', ''); 
	// 	}
	// 	elseif($data['status']>=0 && $data['status']!=7 && $data['status']!=6){
	// 		$this->db->where('r.Status', $data['status']); 
	// 	}

	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
		
	// 	$Requestlist = $query->result();
	// 	$Requestlist = json_decode(json_encode($Requestlist),true);
	// 	$draw = $this->input->post('draw');
	// 	if($data['status']==11){
	// 		//$total = $this->db->where(['Status'=>$status])->count_all_results('Request');
	// 		$total = $this->db->where(['ServiceProvided'=>1])->count_all_results('BillDetails');
	// 	}
	// 	elseif($data['status']==10){
	// 		//$total = $this->db->where(['Status'=>$status])->count_all_results('Request');
	// 		$total = $this->db->where(['ServiceProvided'=>2])->count_all_results('BillDetails');
	// 	}
	// 	elseif($data['status']==""){
	// 		$total = $this->db->count_all_results('Request');
	// 	}
	// 	elseif($data['status']==6){
	// 		$total = $this->db->where(['Priority'=>1])->count_all_results('ServiceMst'); //Doubt in priority count
	// 	}
	// 	elseif($data['status']==7){
	// 		$total = $this->db->where(['ATxnNo'=>''])->count_all_results('Request');
	// 	}
	// 	elseif($data['status']>=0 && $data['status']!=7 && $data['status']!=6){
	// 		$total = $this->db->where(['Status'=>$data['status']])->count_all_results('Request');
	// 	}
	// 	$totalFilter = count($Requestlist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Requestlist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Requestlist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
 //    }

	// public function RequestUserList($data,$UserID){
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("r.AutoID,r.ReqNo,sum(ConvertedAmount) as Total,r.CreatedDate,r.Status");
	// 	$this->db->from('Request as r');
	// 	$this->db->join('BillDetails as b', 'b.ReqID=r.AutoID');
	// 	$where=['UserID'=> $UserID];
	// 	$this->db->where($where);
	// 	$this->db->group_by('r.AutoID,r.ReqNo,r.CreatedDate,r.Status');
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('r.ReqNo', $keyword);
	// 		$this->db->or_like('r.CreatedDate', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	if($data['status']==""){
	// 	}
	// 	elseif($status>=0){
	// 		$this->db->where('r.Status', $data['status']); 
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
	// 	$Requestlist = $query->result();
	// 	$Requestlist = json_decode(json_encode($Requestlist),true);
	// 	$draw = $this->input->post('draw');
		
	// 	if($data['status']==""){
	// 		$total = $this->db->where($where)->count_all_results('Request');
	// 	}
	// 	elseif($data['status']>=0){
	// 		$total = $this->db->where(['Status'=>$data['status'],'UserID'=>$UserID])->count_all_results('Request');
	// 	}
	// 	$totalFilter = count($Requestlist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Requestlist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Requestlist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
 //    }

	// public function Servicelist($data){
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("AutoID,Service,Priority");
	// 	$this->db->from('ServiceMst');
	// 	$this->db->where('Status', 1);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('Service', $keyword);
	// 		$this->db->or_like('Priority', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
		
	// 	$Servicelist = $query->result();
	// 	$Servicelist = json_decode(json_encode($Servicelist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['Status'=>1])->count_all_results('ServiceMst');
	// 	$totalFilter = count($Servicelist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Servicelist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Servicelist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
 //    }

	// public function Headlist($data){
	// 	$keyword = trim($data["keyword"]);
	// 	$query=$this->db->select("AutoID,Head,Priority,HeadNo");
	// 	$this->db->from('HeadMst');
	// 	$this->db->where('Status', 1);
	// 	if(!empty($keyword)) {
	// 		$this->db->group_start();
	// 		$this->db->like('Head', $keyword);
	// 		$this->db->or_like('Priority', $keyword);
	// 		$this->db->group_end();
	// 	}
	// 	$this->db->limit($data['length']);
	// 	$this->db->offset($data['start']);
	// 	$query=$this->db->get();
		
	// 	$Headlist = $query->result();
	// 	$Headlist = json_decode(json_encode($Headlist),true);
	// 	$draw = $this->input->post('draw');
	// 	$total = $this->db->where(['Status'=>1])->count_all_results('HeadMst');
	// 	$totalFilter = count($Headlist);
	// 	if(!empty($keyword)) {
	// 		$totalFilter = count($Headlist);
	// 	}
	// 	$contents = array("msg"=>"data found",
	// 		"data"=>$Headlist,
	// 		"draw"=>$draw,
	// 		"recordsTotal"=>$total,
	// 		"recordsFiltered"=>$total
	// 	);
	// 	return $contents;
 //    }


}
