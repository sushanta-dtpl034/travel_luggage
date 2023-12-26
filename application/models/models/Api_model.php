<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
	// constructor
	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//$this->load->library('session');
	}
	// Login Function
	public function getuserdetails($data) {
	    $LoginID=$data['LoginID'];
		$this->db->select('u.*,p.VendorCode');
		$this->db->from('UserMst as u');
		$this->db->join('ProfileMst as p', 'u.AutoID=p.UserID', 'LEFT');
		$where = "Phone='$LoginID'";
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}


	public function SystemDetails(){
		$this->db->select('*');
		$this->db->from('SystemMst');
		$query = $this->db->get();
		return $query->row();
	}

	public function getotp($phone){
		$this->db->select('*');
		$this->db->from('OTP');
		$this->db->where('Phone',$phone);
		$query = $this->db->get();
		return $query->row();
	}

	public function SaveOTP($data){
		$this->db->insert('OTP',$data);
	    if($this->db->insert_id()>0){
			return true;
		}
		else{
			return false;
		}
	}

	public function DeletePreviousOTP($loginid){
		$this->db->where('Phone',$loginid);
		$this->db->delete('OTP');
		return true;
	}

	public function CheckOTP($loginid,$OTP){
		$this->db->select('*');
		$this->db->from('OTP');
		$this->db->where('Phone',$loginid);
		$this->db->where('OTP',$OTP);
		return $num_results = $this->db->count_all_results();
	}

	public function SaveUser($data){
		$this->db->insert('UserMst',$data);
		return $this->db->insert_id();
	}

	public function checkDuplicateMobile($mobile) {
			$this->db->where('Phone', $mobile);
			$query = $this->db->get('UserMst');
			$count_row = $query->num_rows();
			if ($count_row > 0) {
			//if count row return any row; that means you have already this email address in the database. so you must set false in this sense.
				return TRUE; // here I change TRUE to false.
			} else {
			// doesn't return any row means database doesn't have this email
				return FALSE; // And here false to TRUE
			}
	}

	public function checkDuplicateEmail($email) {
		$this->db->where('Email', $email);
		$query = $this->db->get('UserMst');
		$count_row = $query->num_rows();

		if ($count_row > 0) {
		//if count row return any row; that means you have already this email address in the database. so you must set false in this sense.
			return TRUE; // here I change TRUE to false.
		} else {
		// doesn't return any row means database doesn't have this email
			return FALSE; // And here false to TRUE
		}
	}

	public function checkuser($mobile) {
		$this->db->where('Phone', $mobile);
		$query = $this->db->get('UserMst');
		$count_row = $query->num_rows();
		if ($count_row > 0) {
		//if count row return any row; that means you have already this email address in the database. so you must set false in this sense.
			return TRUE; // here I change TRUE to false.
		} else {
		// doesn't return any row means database doesn't have this email
			return FALSE; // And here false to TRUE
		}
	}

	public function logout($data)
	{
		$users_id = $data['UserID'];
		$datalogout['IsActive'] = $data['IsActive'];
		$datalogout['LogoutDate'] = $data['LogoutDate'];	
		//$this->session->sess_destroy();
		$this->db->where('UserID', $users_id)->where('IsActive',0)->update('Users_Authentication',$datalogout);
		return array('status' => 200, 'message' => 'Successfully logout.');
	}

	public function getmaxid()
    {
    	$this->db->select_max('AutoID');
		$query = $this->db->get('SystemMst');
		return $query->row();
    }
	public function CheckRecord($id){
		$this->db->select('*');
		$this->db->from('SystemMst');
		$this->db->where('AutoID',$id);
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

	public function GetSystemSetting(){
	   $query=$this->db->select("*");
	   $this->db->from('SystemMst');
	   $query=$this->db->get();
	   $Requestlist = $query->result();
	   return $Requestlist;
   }

}
