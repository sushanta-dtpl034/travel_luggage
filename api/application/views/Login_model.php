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

        $this->db->where('UserName',$username);
        $this->db->or_where('Email',$username);
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
}