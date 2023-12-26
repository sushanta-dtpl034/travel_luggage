<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Currency extends CI_Controller {
    public $pageModelName   = 'CurrencyModel';
    public $module          = 'Currency';
    protected $MenuCode     = 'Currency';

    public function __construct(){
		parent::__construct();
		$this->load->database();
		$username = $this->session->userdata('username');
        $userid = $this->session->userdata('userid');
        if (!isset($username) && !isset($userid)) { 
            redirect('Login');
        } 
        $this->load->library(array('phpmailer_lib', 'phpspreadsheet_lib'));

        $this->load->library(array('form_validation', 'utility'));
        $this->load->model('Commonmodel');
		$this->load->model('CurrencyModel');

        $this->load->model('Planmodel');
        $this->load->model('Mastermodel');
        $this->load->model('Assetmodel');
	}
    function index(){
        $data['page_css'] 		    = ['list','form','other'];
        $data['page_js'] 		    = ['list','form','other'];
        $data['page_title'] 		= 'Currency';
		$data['breadcrumb_Module'] 	= 'Asset Master';
		$data['breadcrumb_Page'] 	= 'Currency Master';
		$data['breadcrumb_link'] 	= 'Currency';
		$data['breadcrumb_ActivePage'] = 'View Currency';
		$data['page_name'] 		    = "currency/view_currency";

        $listColumnSettings 	= $this->CurrencyModel->listColumnSettings();
		$listExtraParams 		= [];
		$data['actionsSettings'] = ['add' => 'popup',  'addpopupID' => 'currencymodal', 'edit' => 'popup','editpopupID' => 'up_currencymodal','delete'=>'',];
		if(!empty($listExtraParams)) {
			$data['listExtraParams'] = $listExtraParams;
		}
        $data['columnsHeading'] = isset($listColumnSettings['config']) ? $listColumnSettings['config'] : [];
		$data['module'] = $this->module;
        $data['sortOrder'] = "asc";
        
		$this->load->view('admin/index',$data);
    }
    function getRecords(){  
		$listColumnSettings = $this->CurrencyModel->listColumnSettings();
		$queryConfig = $listColumnSettings['queryConfig'];
		$params['tableAlias'] = $this->CurrencyModel->tableAlias;
		$params['table'] = $this->CurrencyModel->tableName;
		$params['fields'] = implode(',', $queryConfig).','.$this->CurrencyModel->tableAlias.'.AutoID';
		$params['searchFields'] = $listColumnSettings['filterConfig'];
		$params['orderBy'] = $this->CurrencyModel->tableAlias.".AutoID";
		$params['sortOrder'] = "asc";
		$result = $this->utility->getDataTableList($params);
		$this->utility->outPutJson($result);
    }

	
    public function currency_list(){
        $data['page_title'] = 'Currencies  List';
		$data['page_name'] = "List of Currencies";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$data['country'] = $this->Commonmodel->getCurrencydetails();
		$this->load->view('superadmin/currency_list',$data);
		$this->load->view('include/admin-footer');
	}
	
	public function currency_save(){		
		$this->form_validation->set_rules('currency_name', 'Currency Name', 'required|trim');
		$this->form_validation->set_rules('currency_code', 'Currency Code', 'required|trim|callback_currency_exist');
		$this->form_validation->set_rules('currency_symbole', 'Currency Symbole', 'required');
		$this->form_validation->set_rules('currency_unicode', 'Currency Unicode', 'required');
      
		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			$parent_id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			    $parent_id = $this->session->userdata('parentid');
			}
		
			$data = array(
				'CurrencyName'      =>strip_tags($this->input->post('currency_name')),
				'CurrencyCode'      =>strip_tags($this->input->post('currency_code')),
				'CurrencySymbole'   =>$this->input->post('currency_symbole'),
				'CurrencyUnicode'   =>$this->input->post('currency_unicode'),
				'ParentID'          =>$parent_id,
				'CreatedBy'         =>$this->session->userdata('userid'),
				'CreatedDate'       =>date('Y-m-d'),
			);

            $params['tableName'] = tbl_currency;
            $params['type'] 	= 1;
            $params['data'] 	= $data;
            $response=$this->Commonmodel->ManageCrud($params);
			if($response){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}
		}	
	}
	function currencyexist($key){
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID') != '1'){
		    $parent_id = $this->session->userdata('parentid');
		}
		$where = array(
			'ParentID'=>$parent_id,
			'CurrencyCode'=>$key,
			'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('CurrencyMST',$where);
		if ($res == 0){
			return FALSE;
		}else{
			return TRUE;
		}

	} 
    function currency_exist($str,$AutoID=""){
        $parent_id = $this->session->userdata('userid');
        if($this->session->userdata('GroupID') != '1'){
		    $parent_id = $this->session->userdata('parentid');
		}

        if(!empty($AutoID)){
			$response =checkDuplicate(tbl_currency, 'CurrencyCode',$str,["AutoId !="=>$AutoID,"IsDelete"=>0,"ParentID" =>$parent_id]);
		}else{
			$response =checkDuplicate(tbl_currency, 'CurrencyCode',$str,["IsDelete"=>0,"ParentID" =>$parent_id]);
		}
		if ($response){
			$this->form_validation->set_message('currency_exist', 'The Currency Code field  must contain a unique value.');
			return FALSE;
		}else{
            return TRUE;
        }
    }   
	public function getonecurrecny(){
		$id = $this->input->post('id');
		$result = $this->Mastermodel->getonecurrecny($id);
		$response = array(
			"AutoID" => $result->AutoID,
			"CurrencyName" => $result->CurrencyName,
			"CurrencyCodeame" => $result->CurrencyCode,
			"CurrencySymbole" => $result->CurrencySymbole,
			"CurrencyUnicode" => $result->CurrencyUnicode,
		);
		echo json_encode( array("status" => 1,"data" => $response) );

	}
	public function updatecurrency(){
        extract($this->input->post());

		$this->form_validation->set_rules('up_currencyname', 'Currency Name', 'required|trim');
		$this->form_validation->set_rules('up_currencycode', 'Currency Code', 'required|trim|callback_currency_exist['.$cur_updateid.']');
		$this->form_validation->set_rules('up_currencysymbole', 'Currency Symbole', 'required');
		$this->form_validation->set_rules('up_currencyunicode', 'Currency Unicode', 'required');

		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}else{
			$data = array(
				'CurrencyName'      =>strip_tags($up_currencyname),
				'CurrencyCode'      =>strip_tags($up_currencycode),
				'CurrencySymbole'   =>$up_currencysymbole,
				'CurrencyUnicode'   =>$up_currencyunicode,
				'ModifyBy'          =>$this->session->userdata('userid'),
				'ModifyDate'        =>date('Y-m-d'),
			);

            $params['tableName'] 	= tbl_currency;
            $params['type'] 		= 2;
            $params['columnName'] 	= 'AutoID';
            $params['columnValue'] 	= $cur_updateid;
            $params['data'] 		= $data;
            
            $response=$this->Commonmodel->ManageCrud($params);
			if($response){
				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}

		}
	}

	public function delete_currency(){
		$id = $this->input->post('id');
		$data = array(
			'IsDelete'  =>1,
			'DeleteBy'  =>$this->session->userdata('userid'),
			'DeleteDate'=>date('Y-m-d')	
		);
        
        $params['tableName'] 	= tbl_currency;
        $params['type'] 		= 3;
        $params['columnName'] 	= 'AutoID';
        $params['columnValue'] 	= $id;
        $params['data'] 		= $data;
        
        $response=$this->Commonmodel->ManageCrud($params);
        if($response){
		    echo TRUE;
        }else{
            echo FALSE;
        }
	}

	public function excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();

		// Define the header row data
		$headerData = array('S.NO', 'NAME', 'CODE', 'SYMBOL');

		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');

		// Get the dynamic data
		$data = $this->Commonmodel->getCurrencydetails();

		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');

		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:D1');
		$headerStyle->getFont()->setBold(true);
		

		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Currencies.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}


}