<?php
class Loginmodel extends CI_Model{

	public function validateUser($username){
		$this->db->where('UserName',$username);
		$this->db->or_where('Email',$username);
		$this->db->or_where('Mobile',$username);
		$this->db->where("IsDelete",0);
		$result = $this->db->get('RegisterMST');
		return $result->row();
	}
	public function UpdatePassword($email,$data){
		$this->db->where('Email',$email);
		$this->db->update('RegisterMST',$data);
		return true;
	}
	public function validateUserforpasswordreset($username){
		$this->db->where('UserName',$username);
		$this->db->or_where('Email',$username);
		$this->db->where("RegisterMST.IsDelete",0);
		$result = $this->db->get('RegisterMST');
		$data['result'] = $result->result_array();
		// Get the number of rows
		$data['num_rows'] = $result->num_rows();
		return $data;
	}
	public function UpdateresetPassword($uid,$data){
		$this->db->where('AutoID',$uid);
		$this->db->update('RegisterMST',$data);
		return true;
	}
	function validateUserMobile($mobile){
		$this->db->where('isActive',1);
		$this->db->where('Mobile',$mobile);
		$query = $this->db->get('RegisterMST');
		return $query->row(); 
	}
	function CheckOTP($mobile,$otp){
		$this->db->where('Phone',$mobile);
		$this->db->where('OTP',$otp);
		$query = $this->db->get('OTP');
		$result =$query->row();
		return ($result)?true :false;
	}


}
?>