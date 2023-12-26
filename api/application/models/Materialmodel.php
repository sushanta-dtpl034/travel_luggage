<?php
  class Materialmodel extends CI_Model{
    
      public function get_material($parentid){
        $this->db->select('AutoID,ConditionName');
        $this->db->where('ParentID',$parentid);
        $this->db->where('IsDelete',0);
        $result = $this->db->get('MaterialMST');
        return $result->result_array();
      }
      public function savematerial($data){
        $this->db->insert("MaterialMST",$data);
        return $this->db->insert_id();
        
      }
      public function getmaterial_edit($id)
      {
        $this->db->select('AutoID,ConditionName');
        $this->db->from('MaterialMST');
        $this->db->where('AutoID',$id);
        $query = $this->db->get();
        return $query->row();
      }
      public function updatematerial($data,$update_id){
        $this->db->where('AutoID',$update_id);
        $this->db->update('MaterialMST',$data);
        return $this->db->affected_rows();
      }
      public function deletematerial($id,$data)
      {
        $this->db->where('AutoID',$id);
        $this->db->update('MaterialMST',$data);
        return $this->db->affected_rows();
      }
        
  }
?>