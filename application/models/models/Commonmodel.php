<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Commonmodel extends CI_Model{
	public function __construct(){
        $this->load->library('session');
		parent::__construct();
		$this->load->database();
        
	}
	public function ManageCrud($params = []){
		if($params['type']==1){
			$result =$this->db->insert($params['tableName'],$params['data']);
			if($result){
				return $this->db->insert_id();
			}else{
				$error = $this->db->error(); // Get the error information
				log_message('error','Error Generated Url : '.GetFullUrl());
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Database Error Message :'.$error['message']);
				return FALSE;
			}
			
		}
		elseif($params['type']==2){
			$this->db->where($params['columnName'], $params['columnValue']);
			$result = $this->db->update($params['tableName'], $params['data']);
			if($result){
				return TRUE;
			}else{
				$error = $this->db->error(); 
				log_message('error','Error Generated Url : '.GetFullUrl());
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Database Error Message :'.$error['message']);
				return FALSE;
			}
		}
		elseif($params['type']==3){
			$this->db->where($params['columnName'], $params['columnValue']);
			$result = $this->db->update($params['tableName'], $params['data']);
			if($result){
				return TRUE;
			}else{
				$error = $this->db->error(); 
				log_message('error','Error Generated Url : '.GetFullUrl());
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Database Error Message :'.$error['message']);
				return FALSE;
			}
		
		}
	}
     
	public function getCiti(){
		$result = $this->db->get('CityMST');
		return $result->result_array();
	}
			
	public function getStatedetails($city){
		$this->db->select('CityMST.CitiName as city,CityMST.AutoID citiId,StateMST.AutoID as stateId,StateMST.StateName as state,
		CountryMST.AutoID as countryId,CountryMST.CoutryName as countryName,CountryMST.phoneCode as pCode');    
		$this->db->from('CityMST');
		$this->db->join('StateMST', 'CityMST.StateID = StateMST.AutoID');
		$this->db->join('CountryMST', 'CityMST.CountryID = CountryMST.AutoID');
		$this->db->where('CityMST.AutoID',$city); // Produces: WHERE name = 'Joe'
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		return $query->row();

	}
	public function getCurrencydetails(){
		$this->db->select('AutoID,CurrencyName,CurrencyCode,CurrencySymbole');    
		$this->db->from('CurrencyMST');
		$query = $this->db->get();
		return $query->result_array();

	}
	public function getoneCountrydetails($id){
		$this->db->select('AutoID,CoutryName,CurrencyName,CurrencyCode,CurrencySymbol');    
		$this->db->from('CountryMST');
		$this->db->where('AutoID',$id);
		$query = $this->db->get();
		return $query->result_array();

	}
	public function common_insert($table_name, $data){
		$result =$this->db->insert($table_name, $data);
		//$this->db->last_query();
		if($result){
			return $this->db->insert_id();
		}else{
			$error = $this->db->error(); // Get the error information
			log_message('error','Error Generated Url : '.GetFullUrl());
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Database Error Message :'.$error['message']);
			return FALSE;
		}
	}
	public function common_update($table_name, $where, $data){
		$this->db->where($where);
		$result=$this->db->update($table_name, $data);
		if($result){
			return TRUE;
		}else{
			$error = $this->db->error(); 
			log_message('error','Error Generated Url : '.GetFullUrl());
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Database Error Message :'.$error['message']);
			return FALSE;
		}
	}
	public function get_groupid(){
		$this->db->select('AutoID,Name');    
		$this->db->from('UserGrouMSt');
		$this->db->where('AutoID !=',1);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function allreadycheck($table,$where){
		$this->db->where($where);
		// $this->db->where('IsDelete IS NULL');
		$this->db->where('IsDelete',0);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		//die();
		if ($query->num_rows() > 0){
			return 0;
		}
		else{
			return 1;
		}

	}
	public function companyallreadycheck($table,$where){
		$this->db->where($where);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0){
			return 0;
		}
		else{
			return 1;
		}

	}


	// public function check_data_exits($table,$where){

	//   $this->db->where($where);
	//   $this->db->where('IsDelete is NULL');
	//   $this->db->or_where('IsDelete',0);
	//   $query = $this->db->get($table);
	//   // echo $this->db->last_query();
	//   // die();
	//   if ($query->num_rows() > 0){
	//     return 0;
	//   }
	//   else{
	//     return 1;
	//   }

	// }


	public function getshortcode($parent_id,$assetowner_id){
		$this->db->select('CompanyName,CompanyShortCode,AutoID');
		$this->db->from('CompanyMst');
		$this->db->where('ParentID',$parent_id);
		$this->db->where('AutoID',$assetowner_id);
		$query = $this->db->get();
		return $query->row();
	}
	public function last_companycode($parent_id,$pre_month,$pre_year){
		// $this->db->where('ParentID',$parent_id);
		// $this->db->where('AssetOwner',$assetowner_id);
		// $this->db->where('MONTH(CreatedDate)',$pre_month); 
		// $this->db->where('YEAR(CreatedDate)', $pre_year); 
		$query = $this->db->get('QRCodeDetailsMst');
		return $query->num_rows();
	}

	public function getlast_row($parent_id){
		$row= $this->db->select('*')->order_by('AutoID',"desc")->limit(1)->get('QRCodeHeadMst')->row();
		return $row->CreatedDate;	
	}


	public function getid_byname($coloumname,$value,$table)
	{
		$this->db->where($coloumname,$value);
		// $this->db->where('IsDelete',0);
		// $this->db->or_where('IsDelete IS NULL');
		$this->db->where("(IsDelete = 0 OR IsDelete IS NULL)");

		$query = $this->db->get($table);
		return $query->row()->AutoID ?? null;      
	}
		public function getAssettransferdetails($uid){
		


		$this->db->select('fc.CompanyName as fromcompany,tc.CompanyName as tocompany,fu.Name as fromuser,tu.Name as touser,asset.UniqueRefNumber as urn,cb.Name as Transferby,convert(varchar,AssettransferHIS.TransferDatetime,22) as TransferDatetime,AssettransferHIS.Type');    
		$this->db->from('AssettransferHIS');
		$this->db->join('CompanyMst as fc','AssettransferHIS.FromCompany = fc.AutoID','left');
		$this->db->join('CompanyMst as tc','AssettransferHIS.ToCompany = tc.AutoID','left');
		$this->db->join('RegisterMST as fu','AssettransferHIS.FromUser = fu.AutoID','left');
		$this->db->join('RegisterMST as tu','AssettransferHIS.ToUser = tu.AutoID','left');
		$this->db->join('AssetMst as asset','AssettransferHIS.AssetID = asset.AutoID','left');
		$this->db->join('RegisterMST as cb','AssettransferHIS.CreatedBy = cb.AutoID','left');
		$this->db->where('AssettransferHIS.CreatedBy',$uid); // Produces: WHERE name = 'Joe'
		$query = $this->db->get();
		return $query->result_array();
		

	}
	function DownloadFileCurl($url)
	{
		$data = file_get_contents($url);
		$new = 'profile_image_'.rand(10, 3000000).'.jpg';
		file_put_contents('./upload/profile/'.$new, $data);
		return basename($new);
	}
    
}


?>