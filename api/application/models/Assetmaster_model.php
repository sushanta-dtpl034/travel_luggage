<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assetmaster_model extends CI_Model {
	// constructor
	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//$this->load->library('session');
	}

    public function ManageCRUD($data,$tableName,$type,$id=""){
		if($type==1){
			$this->db->insert($tableName,$data);
			return $this->db->insert_id();
		}
		elseif($type==2){
			$this->db->where('AutoID',$id);
            return $this->db->update($tableName, $data);
		}
		elseif($type==3){
			$this->db->where('AutoID',$id);
            return $this->db->update($tableName, $data);
		}
		
	}

    // Material Condition

    function CheckMaterialCondition($ConditionName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('MaterialMST');
		$this->db->where('ConditionName',$ConditionName);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function getmaterial($parent_id){
         
        $this->db->select('*');
        $this->db->from('MaterialMST');
        $this->db->where('MaterialMST.ParentID',$parent_id);
        $this->db->where('MaterialMST.IsDelete',0);
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function MaterialConditionList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("MaterialMST.AutoID,MaterialMST.ConditionName,MaterialMST.ParentID");
        $this->db->from('MaterialMST');
        //$this->db->join('RegisterMST as rg','rg.AutoID = MaterialMST.ParentID','LEFT');
        $this->db->where('IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AutoID', $keyword);
            $this->db->or_like('ConditionName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('MaterialMST.ConditionName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('MaterialMST');
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
    
    // Asset Type

    function CheckAssetType($AsseTypeName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('AssettypeMST');
		$this->db->where('AsseTypeName',$AsseTypeName);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function AssetTypeList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("AssettypeMST.AutoID,AssettypeMST.AsseTypeName");
        $this->db->from('AssettypeMST');
        $this->db->where('IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AutoID', $keyword);
            $this->db->or_like('AsseTypeName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('AssettypeMST.AsseTypeName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('AssettypeMST');
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

    // Measurement Master

    function CheckMeasurement($UomName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('UomMST');
		$this->db->where('UomName',$UomName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function MeasurementList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("UomMST.AutoID,UomMST.UomName,UomMST.UomShortName");
        $this->db->from('UomMST');
        $this->db->where('IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('UomMST.AutoID', $keyword);
            $this->db->or_like('UomName', $keyword);
            $this->db->or_like('UomShortName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('UomMST.UomName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('UomMST');
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


    // Asset Category Master

    function CheckAssetCategory($AsseCatName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('AssetCatMST');
		$this->db->where('AsseCatName',$AsseCatName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}
    
    public function AssetCategoryList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("AssetCatMST.AutoID,AssetCatMST.AsseCatName,AssetCatMST.AssetType,AssetCatMST.AssetCatIMG");
        $this->db->from('AssetCatMST');
        $this->db->join('AssettypeMST as at','at.AutoID = AssetCatMST.AssetType','LEFT');
        $this->db->where('AssetCatMST.IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AssetCatMST.AutoID', $keyword);
            $this->db->or_like('AsseCatName', $keyword);
            $this->db->or_like('AssetType', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('AssetCatMST.AsseCatName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('AssetCatMST');
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

    // Company Master

    function CheckCompany($CompanyName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('CompanyMst');
		$this->db->where('CompanyName',$CompanyName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}
    
    public function update($table_name, $where, $data)
    {
      $this->db->where($where);
      $this->db->update($table_name, $data);
      return true;
    }
    public function disablecompany($id){
        $this->db->where('AutoID !=',$id);
        $this->db->update('CompanyMST', array('IsCompany'=>0));
        return true;
    }

    public function CompanyList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("CompanyMst.AutoID,CompanyMst.CompanyName,
                                  CompanyMst.CompanCurrency,CompanyMst.CompanyLogo,
                                  CompanyMst.CompanyStamp,CompanyMst.CompanyAddress,CompanyMst.BankDetails,CompanyMst.IsCompany");
        $this->db->from('CompanyMst');
        $this->db->join('CurrencyMST as cu','cu.AutoID = CompanyMst.CompanCurrency','LEFT');
        $this->db->where('CompanyMst.IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('CompanyMst.AutoID', $keyword);
            $this->db->or_like('CompanyName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('CompanyMst.CompanyName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('CompanyMst');
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

     // Asset User Master

     function CheckAssetUser($Name,$AutoID=0){
		$this->db->select('*');
		$this->db->from('RegisterMST');
		$this->db->where('Name',$Name);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function AssetUserList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("RegisterMST.AutoID,RegisterMST.Name,
                                  RegisterMST.Email,RegisterMST.Mobile,
                                  RegisterMST.EmployeeCode,RegisterMST.UserName,
                                  RegisterMST.Password,RegisterMST.isActive,RegisterMST.IsAdmin,
                                  RegisterMST.Isauditor,RegisterMST.issupervisor,RegisterMST.ProfileIMG");
        $this->db->from('RegisterMST');
        // $this->db->join('');
        $this->db->where('RegisterMST.IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('RegisterMST.AutoID', $keyword);
            $this->db->or_like('Name', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('RegisterMST.Name','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('RegisterMST');
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

     // Sub Category Master

     function CheckSubCategory($AssetSubcatName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('AssetSubcatMST');
		$this->db->where('AssetSubcatName',$AssetSubcatName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function SubCategoryList($data,$logged_in_user_details){

        $id = $logged_in_user_details['AutoID'];
        if($logged_in_user_details['UserRole']!='1'){
          $id = $logged_in_user_details['ParentID'];
        }
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("AssetSubcatMST.AutoID,AssetSubcatMST.AssetCatName,
                                  AssetSubcatMST.AssetSubcatName,AssetSubcatMST.Measurement,
                                  AssetSubcatMST.NumberOfPicture,AssetSubcatMST.titleStatus,
                                  AssetSubcatMST.VerificationInterval,AssetSubcatMST.DepreciationRate,
                                  AssetSubcatMST.auditor,AssetSubcatMST.AssetSubCatIMG");
        $this->db->from('AssetSubcatMST');
        $this->db->join('AssetCatMST as ac','ac.AutoID = AssetSubcatMST.AssetCatName','LEFT');
        $this->db->where('AssetSubcatMST.ParentID',$id);
        $this->db->where('"AssetSubcatMST.IsDelete" IS NULL');
      
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AssetSubcatMST.AutoID', $keyword);
            $this->db->or_like('AssetSubcatName', $keyword);
            $this->db->group_end();
        } 
        $this->db->order_by('AssetSubcatMST.AssetSubcatName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('AssetSubcatMST');
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

    // Currency

    function CheckCurrency($CurrencyName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('CurrencyMST');
		$this->db->where('CurrencyName',$CurrencyName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}


    public function CurrencyList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("CurrencyMST.AutoID,CurrencyMST.CurrencyName,
                                  CurrencyMST.CurrencyCode,CurrencyMST.CurrencySymbole,CurrencyMST.CurrencyUnicode");
        $this->db->from('CurrencyMST');
        $this->db->where('IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AutoID', $keyword);
            $this->db->or_like('CurrencyName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('CurrencyMST.CurrencyName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('CurrencyMST');
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

    // Quarterly

    function CheckQuarterly($QuarterlyName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('QuarterMst');
		$this->db->where('QuarterlyName',$QuarterlyName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function QuarterlyList($data){
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("QuarterMst.AutoID,QuarterMst.QuarterlyName,
                                  QuarterMst.Fromdate,QuarterMst.Todate,QuarterMst.ParentID");
        $this->db->from('QuarterMst');
        $this->db->where('IsDelete',0);
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AutoID', $keyword);
            $this->db->or_like('QuarterlyName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('QuarterMst.QuarterlyName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $total = $this->db->where('IsDelete',0)->count_all_results('QuarterMst');
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

    // Location

    function CheckLocation($Name,$AutoID=0){
		$this->db->select('*');
		$this->db->from('LocationMst');
		$this->db->where('Name',$Name);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function LocationList($data,$logged_in_user_details){

  
        $id = $logged_in_user_details['AutoID'];
        if($logged_in_user_details['UserRole']!='1'){
          $id = $logged_in_user_details['ParentID'];
        }
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("LocationMst.AutoID,LocationMst.CompanyID,LocationMst.Name,
                                  LocationMst.ContactPerson,LocationMst.Email,LocationMst.Phone,LocationMst.ParentID");
        $this->db->from('LocationMst');
        $this->db->where('LocationMst.ParentID',$id);
        $this->db->where('LocationMst.IsDelete is NULL');
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AutoID', $keyword);
            $this->db->or_like('Name', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('LocationMst.Name','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $array = array('LocationMst.IsDelete =' => NULL, 'LocationMst.ParentID' => $id);
        $total = $this->db->where($array)->count_all_results('LocationMst');
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

    // Warranty

    function CheckWarranty($WarrantyTypeName,$AutoID=0){
		$this->db->select('*');
		$this->db->from('WarrantyTypeMST');
		$this->db->where('WarrantyTypeName',$WarrantyTypeName);
        $this->db->where('IsDelete',0);
		if ($AutoID>0) {
			$this->db->where('AutoID !=',$AutoID);
		}
		$num_results = $this->db->count_all_results();
		if($num_results>0){
			return true;
		}
		else{
			return false;
		}
	}

    public function WarrantyList($data,$logged_in_user_details){
        $id = $logged_in_user_details['AutoID'];
        if($logged_in_user_details['UserRole']!='1'){
          $id = $logged_in_user_details['ParentID'];
        }
        $keyword = trim($data["keyword"]);
        $query=$this->db->select("WarrantyTypeMST.AutoID,WarrantyTypeMST.AssetCat,
                                  WarrantyTypeMST.AssetSubCat,WarrantyTypeMST.WarrantyTypeName,WarrantyTypeMST.ParentID");
        $this->db->from('WarrantyTypeMST');
        $this->db->where('WarrantyTypeMST.ParentID',$id);
        $this->db->where('"IsDelete" IS NULL');
        if(!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('AutoID', $keyword);
            $this->db->like('WarrantyTypeName', $keyword);
            $this->db->group_end();
        } 
        
        $this->db->order_by('WarrantyTypeMST.WarrantyTypeName','asc');
        $this->db->limit($data['length']);
        $this->db->offset($data['start']);
        $query=$this->db->get();
        $Requestlist = $query->result();
        $Requestlist = json_decode(json_encode($Requestlist),true);
        $draw = $this->input->post('draw');
        $array = array('WarrantyTypeMST.IsDelete =' => NULL, 'WarrantyTypeMST.ParentID' => $id);
        $total = $this->db->where($array)->count_all_results('WarrantyTypeMST');
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
}