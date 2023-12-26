<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateModel extends CI_Model {

	public function __construct()
    {
		parent::__construct();
		$this->load->database();
        
	}
	public function ManageTemplate($data,$type,$id=""){
		if($type==1){
			$this->db->insert('TemplateContentMST',$data);
			return $this->db->insert_id();
		}
		elseif($type==2){
			$this->db->where('AutoID', $id);
            return $this->db->update('TemplateContentMST', $data);
		}
		elseif($type==3){
			$this->db->where('AutoID', $id);
            return $this->db->update('TemplateContentMST', $data);
		}
	}

	public function ManageEmailhistory($data,$type,$id=""){
		if($type==1){
			$this->db->insert('EmailHistory',$data);
			return $this->db->insert_id();
		}
		elseif($type==2){
			$this->db->where('AutoID', $id);
            return $this->db->update('EmailHistory', $data);
		}
		elseif($type==3){
			$this->db->where('AutoID', $id);
            return $this->db->update('EmailHistory', $data);
		}
	}

		public function EmailhistoryUpdate($message,$AutoID)
	    {
	        if($AutoID) {
	            $insert_id = $AutoID;
				$query = $this->db->query("UPDATE EmailHistory SET Message = N'".$message."' WHERE EmailHistory.AutoID = '".$AutoID."'");
	            return  $insert_id;
	        }
	    }

	function VariableView(){
		$this->db->where('IsDelete',0);
		$query=$this->db->get('legalvariablemst');
		return $query->result();
	}

	function SendTemplateList(){
		$this->db->select('*');
		$this->db->where('IsDelete',0);
		$query=$this->db->get('TemplateMST');
		return $query->result();
	}
	
	public function templatelist(){
		$data = $this->input->post();
		$keyword = trim($data["search"]["value"]);
		$query=$this->db->select("AutoID,Title");
		$this->db->from('TemplateContentMST');
		$this->db->where('IsDelete', 0);
		if(!empty($keyword)) {
			$this->db->group_start();
			$this->db->like('Title', $keyword);
			$this->db->group_end();
		}
		$this->db->limit($data['length']);
		$this->db->offset($data['start']);
		$query=$this->db->get();
		$teamlist = $query->result();
		$teamlist = json_decode(json_encode($teamlist),true);
		$draw = $this->input->post('draw');
		$total = $this->db->where('IsDelete', 0)->count_all_results('TemplateContentMST');
		$totalFilter = count($teamlist);
		$contents = array("msg"=>"data found",
			"data"=>$teamlist,
			"draw"=>$draw,
			"recordsTotal"=>$total,
			"recordsFiltered"=>$total
		);
		return $contents;
    }

	public function ManageTemplateByID($id){
		$this->db->select('*');
		$this->db->from('TemplateContentMST');
		$this->db->where('AutoID', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function GetTemplateDetails($id){
		$this->db->select('TemplateContentMST.*,TemplateMST.Name');
		$this->db->from('TemplateContentMST');
		$this->db->join('TemplateMST','TemplateMST.AutoID =TemplateContentMST.TemplateID','LEFT');
		$this->db->where('TemplateContentMST.TemplateID', $id);
		$query = $this->db->get();
		return $query->row();
	}	


	public function TeamDetails($TeamID){
		$data = $this->input->post();
		$query=$this->db->select("um.AutoID,dm.Name,tm.TeamName,um.DesignationID,um.UserName,um.UserEmail,um.UserMobile,pm.FullName");
		$this->db->from('UserMst um');
		$this->db->join('profilemst pm','pm.UserID=um.AutoID', 'left');
		$this->db->join('TeamMst tm','tm.AutoID=um.TeamID', 'left');
		$this->db->join('DesignationMst dm','dm.AutoID=um.DesignationID', 'left');
		$this->db->where('UserGroupID', 3);
		$this->db->where('um.IsDelete',0);
		$this->db->where('um.TeamID', $TeamID);
		$this->db->limit($data['length']);
		$this->db->offset($data['start']);
		$query=$this->db->get();
		$userlist = $query->result();
		$userlist = json_decode(json_encode($userlist),true);
		$draw = $this->input->post('draw');
		$where = ['TeamID'=> $TeamID,'IsDelete'=>0];
		$total = $this->db->where($where)->count_all_results('UserMst');
		$totalFilter = count($userlist);
		$contents = array("msg"=>"data found",
			"data"=>$userlist,
			"draw"=>$draw,
			"recordsTotal"=>$total,
			"recordsFiltered"=>$total
		);
		return $contents;
	}

	function TicketDetails($ticket_id){
		$this->db->select('TicketMST.*,user.username as user_name,user.email as user_email,user.PreferredLanguage as user_language,user.contactNo as user_phone,incharge.username as incharge_name,incharge.email as incharge_email,incharge.contactNo as incharge_phone,incharge.PreferredLanguage as incharge_language,auditor.username as auditor_name,auditor.email as auditor_email,auditor.contactNo as auditor_phone,auditor.PreferredLanguage as auditor_language,TicketRemark.Remark,TicketRemark.Status');
		$this->db->join('TicketRemark','TicketMST.AutoID = TicketRemark.TicketID',"LEFT");
		$this->db->join('users_app2 as incharge', 'incharge.AutoID = TicketMST.InchargeID',"LEFT");
		$this->db->join('users_app2 as auditor', 'auditor.AutoID = TicketMST.AuditorID',"LEFT");
		$this->db->join('users_app2 as user', 'user.AutoID = TicketMST.UserID',"LEFT");
		$this->db->where('TicketMST.AutoID',$ticket_id);
		$query=$this->db->get('TicketMST');
		return $query->row();
	}

	function getTemplateid($TemString){
		$this->db->select('TemplateMST.AutoID');
		$this->db->where('TemplateID',$TemString);
		$query=$this->db->get('TemplateMST');
		return $query->row();
	}

	function UserDetails($user_id){
		$this->db->select('*');
		$this->db->where('AutoID',$user_id);
		//$this->db->where('IsDelete',0);
		$query=$this->db->get('users_app2');
		return $query->row();
	}

	function ActivityUserDetails($activity_id){
		$this->db->select("Name");
		$this->db->where('AutoID',$activity_id);
		$query=$this->db->get('ActivityMST');
		return $query->row();
	}
		
}