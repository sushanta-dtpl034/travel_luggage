<?php
class Usermodel extends CI_Model
{


  public function get_users($parentid)
  {


    $this->db->select('RegisterMST.AutoID,GroupID,RegisterMST.Name,Mobile,EmployeeCode,Email,UserName,isActive,ProfileIMG,UserGrouMSt.Name AS groupname,import_status,IsAdmin,Isauditor,issupervisor,Suffix');
    $this->db->from('RegisterMST');
    $this->db->join('UserGrouMSt', 'RegisterMST.UserGroupID = UserGrouMSt.AutoID');
    $this->db->where('ParentID', $parentid);
    //$this->db->where('UserRole',3); 
    // $this->db->where('"IsDelete" IS NULL');
    $this->db->order_by('EmployeeCode', 'asc');
    $this->db->where_not_in("RegisterMST.IsDelete", 1);
    $query = $this->db->get();
    return $query->result_array();

  }
  public function get_user($id)
  {
    $this->db->select('AutoID,UserGroupID,Name,Mobile,EmployeeCode,Email,UserName,isActive,ProfileIMG,IsAdmin,Isauditor,issupervisor,Suffix');
    $this->db->from('RegisterMST');
    $this->db->where('AutoID', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function getuser_byname($name)
  {
    $this->db->select('AutoID,Name');
    $this->db->from('RegisterMST');
    $this->db->where('Name', $name);
    $query = $this->db->get();
    return $query->row();
  }


  public function get_activecount()
  {


    $this->db->select('RegisterMST.AutoID,GroupID,RegisterMST.Name,Mobile,EmployeeCode,Email,UserName,isActive,ProfileIMG,UserGrouMSt.Name AS groupname,');
    $this->db->from('RegisterMST');
    $this->db->join('UserGrouMSt', 'RegisterMST.UserGroupID = UserGrouMSt.AutoID');
    $this->db->where('UserRole', 3);
    $this->db->where('RegisterMST.isActive', 1);
    $this->db->where_not_in("RegisterMST.IsDelete", 1);
    $query = $this->db->get();
    return $query->num_rows();

  }
  public function get_inactivecount()
  {


    $this->db->select('RegisterMST.AutoID,GroupID,RegisterMST.Name,Mobile,EmployeeCode,Email,UserName,isActive,ProfileIMG,UserGrouMSt.Name AS groupname,');
    $this->db->from('RegisterMST');
    $this->db->join('UserGrouMSt', 'RegisterMST.UserGroupID = UserGrouMSt.AutoID');
    $this->db->where('UserRole', 3);
    $this->db->where('RegisterMST.isActive', 2);
    $this->db->where_not_in("RegisterMST.IsDelete", 1);
    $query = $this->db->get();
    return $query->num_rows();

  }

  function user_exists($emailid, $mobile_number, $employee_code)
  {
    $this->db->where("(Email='$emailid' OR Mobile='$mobile_number' OR EmployeeCode='$employee_code')");
    $query = $this->db->get('RegisterMST');
    if ($query->num_rows() > 0) {
      return false;
    } else {
      return true;
    }
  }

  public function get_audtior($parentid)
  {
    $this->db->select('AutoID,Name');
    $this->db->from('RegisterMST');
    $this->db->where('Isauditor', 1);
    $this->db->where_not_in("RegisterMST.IsDelete", 1);
    $this->db->order_by("Name", "asc");
    $this->db->where('ParentID', $parentid);
    $query = $this->db->get();
    return $query->result_array();
  }
  public function get_incharge($parentid)
  {
    $this->db->select('AutoID,Name');
    $this->db->from('RegisterMST');
    // $this->db->where('UserGroupID',4);
    $this->db->where_not_in("RegisterMST.IsDelete", 1);
    $this->db->order_by("Name", "asc");
    $this->db->where('isActive', 1);
    $this->db->where('ParentID', $parentid);
    $query = $this->db->get();
    return $query->result_array();
  }
  public function get_supervisor($parentid)
  {
    $this->db->select('AutoID,Name');
    $this->db->from('RegisterMST');
    $this->db->where_not_in("RegisterMST.IsDelete", 1);
    $this->db->where('issupervisor', 1);
    $this->db->order_by("Name", "asc");
    $this->db->where('isActive', 1);
    $this->db->where('ParentID', $parentid);
    $query = $this->db->get();
    return $query->result_array();
  }
  public function getuser_byEmployeeCode($ecode)
  {
    $this->db->select('AutoID,Name');
    $this->db->from('RegisterMST');
    $this->db->where('EmployeeCode', $ecode);
    $query = $this->db->get();
    return $query->num_rows();

  }

}
?>