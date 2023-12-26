<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CurrencyModel extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->tableName = tbl_currency;
		$this->tableAlias = tbl_currency;
		$this->primaryKey = "AutoID";    
	}
	/**
	 * Function to build List column settings
	 */
	function listColumnSettings($return = "all"){
		$config["CurrencyName"] = [
			"data" 				=> "CurrencyName", //this is same as select column alias name  
			"langLabel" 		=> 'Currency Name', //this will go in column name        
			"search" 			=> "Yes",
			"export" 			=> "Yes",
			"hidden" 			=> "No",
			"sort" 				=> "String",
			"filter" 			=> "Input",
			"filterSettings" 	=> array("elemid" => "", "elemclass" => "", "ajaxcall" => ""),
			"filterCol" 		=> $this->tableAlias . ".CurrencyName", //while filter which table filed should be considered. we can use sql functions here
			"cssclass" 			=> ""
		];
		//User this for select query while fetching list data
		$queryConfig["CurrencyName"] = $filterConfig["CurrencyName"] = $this->tableAlias . '.CurrencyName';

		$config["CurrencyCode"] = [
			"data" 				=> "CurrencyCode", //this is same as select column alias name  
			"langLabel" 		=> 'Currency Code', //this will go in column name        
			"search" 			=> "Yes",
			"export" 			=> "Yes",
			"hidden" 			=> "No",
			"sort" 				=> "String",
			"filter" 			=> "Input",
			"filterSettings" 	=> array("elemid" => "", "elemclass" => "", "ajaxcall" => ""),
			"filterCol" 		=> $this->tableAlias . ".CurrencyCode", //while filter which table filed should be considered. we can use sql functions here
			"cssclass" 			=> ""
		];
		//User this for select query while fetching list data
		$queryConfig["CurrencyCode"] = $filterConfig["CurrencyCode"] = $this->tableAlias . '.CurrencyCode';
		
		$config["CurrencySymbole"] = [
			"data" 				=> "CurrencySymbole", //this is same as select column alias name  
			"langLabel" 		=> 'Country Symbol', //this will go in column name        
			"search" 			=> "Yes",
			"export" 			=> "Yes",
			"hidden" 			=> "No",
			"sort" 				=> "String",
			"filter" 			=> "Input",
			"filterSettings" 	=> array("elemid" => "", "elemclass" => "", "ajaxcall" => ""),
			"filterCol" 		=> $this->tableAlias . ".CurrencySymbole", //while filter which table filed should be considered. we can use sql functions here
			"cssclass" 			=> ""
		];
		//User this for select query while fetching list data
		$queryConfig["CurrencySymbole"] = $filterConfig["CurrencySymbole"] = $this->tableAlias . '.CurrencySymbole';
		
		

		if ($return == "column_config") {
			return $config;
		} else if ($return == "query_fields") {
			return $queryConfig;
		} else {
			return array("config" => $config, "queryConfig" => $queryConfig, "filterConfig" => $filterConfig);
		}
	}
	
	/**
	 * Controller => Advancepayment, ExpenseLog, SystemSetting
	 */
	public function getAllCurrency(){
		$this->db->select('*');
		$this->db->from('CurrencyMst');
		//$this->db->where('Status',1);
		$query = $this->db->get();
		return $query->result('array');
        
	}


}