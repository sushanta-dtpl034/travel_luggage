<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RequestModel extends CI_Model {

	public function __construct()
    {
		parent::__construct();
		$this->load->database();
        
	}

	public function ManageRequest($data){
		
		$this->db->insert('Request',$data);
		return $this->db->insert_id();
	}
	public function create_remark($remark) {
		$this->db->insert('requestremark',$remark);
		return $this->db->insert_id();
	}
	function CompanyView(){
		$this->db->where('Status','1');
		$this->db->order_by('Name','asc');
		$query=$this->db->get('CompanyMst');
		return $query->result();
	}

	function POView(){
		$this->db->select('*');
		$this->db->from('POMst');
		$this->db->where('VendorID', $this->session->userdata('VendorCode'));
		$query = $this->db->get();
		$ponumber = $query->result();
		return $ponumber;
	}

	function POAccess(){
		$this->db->select('POAccess');
		$this->db->from('UserMst');
		$this->db->where('UserType', 4);
		$this->db->where('AutoID', $this->session->userdata('UserID'));
		$query = $this->db->get();
		return $query->row();
		/* return $ponumber; */
	}

	function HeadView(){
		$this->db->select('h.*');
		$this->db->from('HeadMst as h');
		$this->db->join('HeadAccess as ha', 'ha.HeadID = h.AutoID');
		$this->db->where('ha.VendorID', $this->session->userdata('UserID'));
		$query = $this->db->get();
		$headnumber = $query->result();
		return $headnumber;
	}

    function ServiceView(){
		$this->db->where('Status','1');
		$this->db->order_by('Service','asc');
		$query=$this->db->get('ServiceMst');
		return $query->result();
	}

    function ReadContact($keyword){
		$this->db->like('Name', $keyword);
		$this->db->order_by('Name','asc');
		$query=$this->db->get('ContactMst');
		$data=$query->result();
		if($data){
			$data= json_encode($data);
		}
		return $data;
		
	}

	

	public function RequestList($status){
		$data = $this->input->post();
		$keyword = trim($data["search"]["value"]);
		$query=$this->db->select("r.AutoID,r.ReqNo,sum(ConvertedAmount) as Total,r.CreatedDate,r.Status");
		$this->db->from('Request as r');
		$this->db->join('BillDetails as b', 'b.ReqID=r.AutoID');
		//$this->db->join('CurrencyMst as c', 'b.CurrencyID=c.AutoID');
		$where=['UserID'=> $this->session->userdata('UserID')];
		$this->db->where($where);
		$this->db->group_by('r.AutoID,r.ReqNo,r.CreatedDate,r.Status');
		if(!empty($keyword)) {
			$this->db->group_start();
			$this->db->like('r.ReqNo', $keyword);
			$this->db->or_like('r.CreatedDate', $keyword);
			$this->db->group_end();
		}
		if($status==""){
		}
		elseif($status>=0){
			$this->db->where('r.Status', $status); 
		}
		$this->db->limit($data['length']);
		$this->db->offset($data['start']);
		$query=$this->db->get();
		$Requestlist = $query->result();
		$Requestlist = json_decode(json_encode($Requestlist),true);
		$draw = $this->input->post('draw');
		//$total = $this->db->where(['UserID'=>$this->session->userdata('UserID')])->count_all_results('Request');
		if($status==""){
			$total = $this->db->where($where)->count_all_results('Request');
		}
		elseif($status>=0){
			$total = $this->db->where(['Status'=>$status,'UserID'=>$this->session->userdata('UserID')])->count_all_results('Request');
		}
		$totalFilter = count($Requestlist);
		if(!empty($keyword)) {
			$totalFilter = count($Requestlist);
		}
		$contents = array("msg"=>"data found",
			"data"=>$Requestlist,
			"draw"=>$draw,
			"recordsTotal"=>$total,
			"recordsFiltered"=>$total
		);
		return $contents;
    }

	public function last_request_id($UserID){
		$this->db->select("*");
		$this->db->from("Request");
		$this->db->limit(1);
		$this->db->order_by('AutoID',"DESC");
		$this->db->where('UserID',$UserID);
		$query = $this->db->get();
		$request_id = $query->row();
		return $request_id;
	}

	public function RequestDetailsByID($id){
		$this->db->select('*');
		$this->db->from('Request');
		$this->db->where('AutoID', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function ManageBillDetailsByID($id){
		$this->db->select('b.*, s.Service,h.Head,p.PONumber, cu.Symbol');
		$this->db->from('BillDetails as b');
		//$this->db->join('CompanyMst as c', 'b.BilledCompany = c.AutoID','LEFT');
		$this->db->join('ServiceMst as s', 'b.ServiceProvided = s.AutoID','LEFT');
		$this->db->join('HeadMst as h', 's.HeadID = h.AutoID','LEFT');
		$this->db->join('POMst as p', 'b.POID = p.AutoID','LEFT');
		$this->db->join('CurrencyMst as cu', 'b.CurrencyID = cu.AutoID','LEFT');
		$this->db->where('ReqID', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function ManageRemarksByID($id){
		$this->db->select('r.*, rq.Name,u.Name as FinanceName, r.CreatedDate');
		$this->db->from('RequestRemark as r');
		$this->db->join('Request as rq', 'r.ReqID=rq.AutoID');
		$this->db->join('UserMst as u', 'r.UserID=u.AutoID');
		$this->db->where('ReqID', $id);
		$this->db->order_by("r.CreatedDate", "asc");
		$query = $this->db->get();
		return $query->result();
	}

	public function ManageFilesByID($id){
		$this->db->select('f.*,f.FileName,rq.CreatedDate');
		$this->db->from('FileDetails as f');
		$this->db->join('Request as rq', 'f.ReqID=rq.AutoID');
		$this->db->where('ReqID', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function GetPODetailsByNo($id){
		$this->db->select('*');
		$this->db->from('POMst');
		$this->db->where('AutoID', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function GetBillAmountByPO($id){
		$this->db->select_sum('Amount');
		$this->db->from('BillDetails');
		$this->db->where('POID', $id);
		$query= $this->db->get();
		$data= $query->row();
		return $data->Amount;
	}

	public function GetTaxAmountByPO($id){
		$this->db->select_sum('taxAmount');
		$this->db->from('BillDetails');
		$this->db->where('POID', $id);
		$query= $this->db->get();
		$data= $query->row();
		return $data->taxAmount;
	}

	public function last_request_no(){
		$this->db->select("*");
		$this->db->from("Request");
		$this->db->limit(1);
		$this->db->order_by('AutoID',"DESC");
		//$this->db->where('UserID',$this->session->userdata('UserID'));
		$query = $this->db->get();
		$request_id = $query->row();
		return $request_id;
	}
	public function profile_info(){
		$this->db->select("u.*,p.*");
		$this->db->from('UserMst as u');
		$this->db->join('Profilemst p', 'u.AutoID = p.UserID', 'left');
		$this->db->where('u.AutoID',$this->session->userdata('UserID'));
		$query = $this->db->get();
		$request_id = $query->row();
		return $request_id;
		/* $this->db->select("*");
		$this->db->from("UserMst");
		$this->db->where('AutoID',$this->session->userdata('UserID'));
		$query = $this->db->get();
		$request_id = $query->row();
		return $request_id; */
	}

	public function RequestCount($status,$type){
		$this->db->select('*');
		$this->db->from('Request');
		if($type==0){						//If User specific
			$this->db->where(['UserID'=>$this->session->userdata('UserID')]);
		}
		$this->db->where('Status',$status);
		$num_results = $this->db->count_all_results();
		return $num_results;
	}

	public function TransactionCount(){
		$this->db->select('AutoID');
		$this->db->from('Request');
		
		$this->db->where('ATxnNo','');
		//$this->db->where('Status', 1);
		$num_results = $this->db->count_all_results();
		return $num_results;
	}

	public function PriorityCount(){

		$this->db->select('r.AutoID');
		$this->db->from('Request as r');
		$this->db->join('BillDetails as b', 'r.AutoID=b.ReqID');
		$this->db->join('ServiceMst as s', 's.AutoID=b.ServiceProvided');

		$this->db->where('s.Priority', 1);
		$num_results = $this->db->count_all_results();
		return $num_results;
	}

	public function create_file($RequestID,$FileName,$Status) {
		
		$query="insert into FIleDetails (ReqID,FileName,Status)values($RequestID,'$FileName',$Status)";
		$this->db->query($query);
	}

	public function GetLastRequest($RequestID){
		$this->db->select('ReqNo');
		$this->db->from('Request');
		$this->db->where('AutoID', $RequestID);
		$query = $this->db->get();
		$last_request = $query->row();
		return $last_request;
	}
    public function getCompanyByPO($POCODE){
		$this->db->select('CName');
		$this->db->from('POMst');
		$this->db->where('AutoID', (int)$POCODE);
		$query1 = $this->db->get();
		$po = $query1->row();
		return $po->CName;

	}

	public function getCompanyByUser($UserID){
		$query = $this->db->select("CompanyID");
        $this->db->from('ProfileMst');
		$this->db->where('UserID', $UserID);
		$query = $this->db->get();
		$po = $query->row();
		return $po->CompanyID;
		//return json_decode(json_encode($query->result()), true);
	}

	public function getServiceByHead($HeadNo){
		$query = $this->db->select("s.AutoID,s.Service");
		$this->db->from('ServiceMst as s');
        $this->db->join('HeadMst as h', 's.HeadID=h.HeadNo');
		$this->db->where('h.Status', 1);
		$this->db->where('h.HeadNo',$HeadNo );
		$query = $this->db->get();
		return json_decode(json_encode($query->result()), true);
	}

	public function CurrencyView(){
		$this->db->select('c.*');
		$this->db->from('CurrencyMst as c');
		$this->db->join('CurrencyAccess as ca', 'ca.CurrencyID=c.AutoID');
		$this->db->where('ca.VendorID', $this->session->userdata('UserID'));
		$query = $this->db->get();
		$currencynumber = $query->result();
		return $currencynumber;
	}

	public function getCurrencyNameByID($Currency){
		$this->db->select('Symbol');
		$this->db->from('CurrencyMst');
		$this->db->where('AutoID', $Currency);
		$query = $this->db->get();
		$currency_name = $query->row();
		return $currency_name->Symbol;
	}

}