<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	// constructor
	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//$this->load->library('session');
	}
	public function validateUser($username){
        $this->db->where('IsDelete',0);
		$this->db->where('IsAdmin',1);
		$this->db->group_start();
        $this->db->where('UserName',$username);
        $this->db->or_where('Email',$username);
		$this->db->group_end();
        $result = $this->db->get('RegisterMST');
        return $result->row_array();
    }

    public function getuserdata_byid($userid){
       	$this->db->select('*');
        $this->db->where('AutoID',$userid);
        $this->db->from('RegisterMST');
        $query = $this->db->get();
		return $query->row();
    }

    public function chnage_password($username,$password){
        $this->db->where('UserName',$username);
        $this->db->or_where('Email',$username);
        $this->db->update('RegisterMST',array('Password' => $password));
        // $result = $this->db->get('RegisterMST');
          return 1;
    }
	
	/**
	*Sushanta 
	*User Login through OTP
	*/
	function validateUserMobile($mobile){
		$this->db->where('IsDelete',0);
		$this->db->where('IsAdmin',0);
		$this->db->where('Mobile',$mobile);
		$query = $this->db->get('RegisterMST');
        return $query->row_array();
	}
	function CheckOTP($mobile,$otp){
		$this->db->where('Phone',$mobile);
        $this->db->where('OTP',$otp);
		$query = $this->db->get('OTP');
		$result =$query->row();
		return ($result)?true :false;
	}
	
	function getUserByID($id){
		$this->db->where('IsDelete',0);
		$this->db->where('IsAdmin',0);
		$this->db->where('AutoID',$id);
		$query = $this->db->get('RegisterMST');
        return $query->row_array();
	}
	
	
}