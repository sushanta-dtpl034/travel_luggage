<?php
class Crud_model extends CI_Model 
{
	/*Insert*/
	/*Insert*/
	function saverecords($data)
	{
          $this->db->insert('contact',$data);
          return $this->db->insert_id();
	}
	
}