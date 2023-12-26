<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';

use Com\Tecnick\Barcode\Barcode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Assetmanagement extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
	  parent::__construct();
	  $username = $this->session->userdata('username');
	  $userid = $this->session->userdata('userid');
	  if (!isset($username) && !isset($userid)) { 
	   redirect('Login');
	  } 
      $this->load->library('form_validation');
	  $this->load->model('Planmodel');
	  $this->load->model('Commonmodel');
	  $this->load->model('Mastermodel');
	  $this->load->model('Materialmodel');
	  $this->load->model('Usermodel');
      $this->load->model('Assetmodel');
	  $this->load->model('Companymodel');
	  $this->load->library('phpmailer_lib');
	  $this->load->helper('referenceno_helper');
	  $this->load->helper('quarters_helper');
	  $this->load->library('upload');
	}
	public function assetform_list(){
        $data['page_title'] = 'Asset List';
		$data['page_name'] = "List of Asset ";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('parentid');
		if($this->session->userdata('GroupID')!='1'){
		 $parentid = $this->session->userdata('parentid');
		}
		$data['type'] = $this->Assetmodel->getassettype($parentid);
		$data['material'] = $this->Materialmodel->get_material($parentid);
		$data['cat'] = $this->Assetmodel->getassetcat($parentid);
		$data['subcat'] = $this->Assetmodel->getassetsubcat($parentid);
		$data['currency'] = $this->Mastermodel->getcurrency($parentid);

		$data['incharge'] = $this->Usermodel->get_incharge($parentid);
		$data['supervisor'] = $this->Usermodel->get_supervisor($parentid);
		
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$data['warranty'] = $this->Assetmodel->getwarantytype($parentid);

		$data['clocation'] = $this->Assetmodel->getlocation($parentid);
	
		$this->load->view('superadmin/asset_list',$data);
		$this->load->view('include/admin-footer');
	}
		
		
	public function getasset_list(){
        $parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parentid = $this->session->userdata('parentid');
		}

		$result = $this->Assetmodel->getasset_list($parentid);
		$json_data['data'] = $result;
		// $json_data['role'] = null;

		// $Isauditor=$this->session->userdata("userdata")['Isauditor'];
		// $issupervisor=$this->session->userdata("userdata")['issupervisor'];
		// $IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
		// if($IsAdmin){
		// 	$json_data['role'] = 'admin';
		// }else{
		// 	if($Isauditor){
		// 		$json_data['role'] = 'auditor';
		// 	}
		// 	else{
		// 		$json_data['role'] = 'supervisor';
		// 	}
		// }
		// print_r($result);
		echo  json_encode($json_data);

	}
	
	public function addasset_save(){
		$this->form_validation->set_rules('assetowner_id','Owner','required');
		$this->form_validation->set_rules('assetman_type','Asset Type','required');
		$this->form_validation->set_rules('assetman_cat','Asset Category','required');
		$this->form_validation->set_rules('assetment_subcat','Asset Subcategory','required');
		$this->form_validation->set_rules('depreciation_rate','Depreciation Rate', 'required');
		$this->form_validation->set_rules('assetment_condition','Assetment Condition','required');
		$this->form_validation->set_rules('assetman_auditor','Assetmant Auditor','required');
		$this->form_validation->set_rules('asstman_incharge','Asstman Incharge','required');
		$this->form_validation->set_rules('assetman_supervisor','Assetman Supervisor','required');
		if ($this->form_validation->run() == FALSE){
			// echo validation_errors();
			// die();
			echo json_encode(array('status' => 0));
		}else{

			$FourDigitRandomNumber = rand(1000000000,9999999999);
			$assetowner_id  = $this->input->post('assetowner_id');
			$assetman_type  = $this->input->post('assetman_type');
			$vendor_email  = $this->input->post('vendor_email');
			$vendor_mobile  = $this->input->post('vendor_mobile');
			$depreciation_rate  = $this->input->post('depreciation_rate');
			$assetman_cat  = $this->input->post('assetman_cat');
			$assetment_subcat  = $this->input->post('assetment_subcat');
			$assetment_UIN  = $this->input->post('assetment_UIN');
			$assetment_purchaseprice  = $this->input->post('assetment_purchaseprice');
			$currency_type  = $this->input->post('currency_type');					
			$purchased_date  = $this->input->post('purchased_date');
			$vendor_name  = $this->input->post('vendor_name');
			$vendor_address  = $this->input->post('vendor_address');
			$purchased_date  = $this->input->post('purchased_date');
			$assetment_dimenson  = $this->input->post('assetment_dimenson');
			$assetment_condition  = $this->input->post('assetment_condition');
			$valid_till  = $this->input->post('valid_till');
			$assetman_auditor  = $this->input->post('assetman_auditor');
			$asstman_incharge  = $this->input->post('asstman_incharge');
			$assetman_supervisor  = $this->input->post('assetman_supervisor');
			$picture_title  = $this->input->post('picture_title');
			$warrantly_covered_for  = $this->input->post('warrantly_covered_for');
			$insurance_valid_upto  = $this->input->post('insurance_valid_upto');
			$warranty_contact_mobile  = $this->input->post('warranty_contact_mobile');
			$warranty_contact_email  = $this->input->post('warranty_contact_email');
			$VerificationInterval  = $this->input->post('VerificationInterval');

			
			$asset_title  = $this->input->post('asset_title');
			$asset_qty  = $this->input->post('asset_qty');

			$measurements  = $this->input->post('measurements');

			$company_location  = $this->input->post('company_location');
			$current_location  = $this->input->post('current_location');
			
			
			$config['upload_path']   = './upload/asset/'; 
			$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			
			
			if($this->session->userdata('GroupID')!='1'){
			  $parent_id = $this->session->userdata('parentid');
			}else{
				$parent_id = $this->session->userdata('userid');
			}

			$where = array(
				'ParentID'=>$parent_id,
				'AssetOwner'=>$assetowner_id,
		   	);

			
			$response = $this->Commonmodel->allreadycheck('AssetMst',$where);
			$shortcode= $this->Commonmodel->getshortcode($parent_id,$assetowner_id);
			//$fc = strtoupper(substr($shortcode->CompanyName,0,3));
			$fc =$shortcode->CompanyShortCode;
			
			if($response === 0){
				$prev_create_date_row=$this->Commonmodel->getlast_row($parent_id,$assetowner_id);
				$prv_year_month=date('Ym', strtotime($prev_create_date_row));
				$now_year_month=date('Ym');
				
				if($prv_year_month == $now_year_month){
					//for existing month
					$prv_month=date('m', strtotime($prev_create_date_row));
					$prv_year=date('Y', strtotime($prev_create_date_row));

					$oldshortcode= $this->Commonmodel->last_companycode($parent_id,$assetowner_id,$prv_month,$prv_year);
					
					/**
					 * sushanta
					 * check qrcode sequnce pre generated qr code sequence
					 * description: check QRcodeHeadMst to pre generate qrcode through asset owner id
				 	*/
					$pregen_sequence_no =pre_generate_qrcode_sequence($assetowner_id,$now_year_month);
					$new_sequence_no =$oldshortcode + $pregen_sequence_no;
					$ref=create_refno($new_sequence_no+1,$fc);

				}else{
					//for new month
					/**
					 * sushanta
					 * check qrcode sequnce pre generated qr code sequence
					 * description: check QRcodeHeadMst to pre generate qrcode through asset owner id
				 	*/
					$now_year_month=date('Ym');
					$pregen_sequence_no =pre_generate_qrcode_sequence($assetowner_id,$now_year_month);
					$ref=create_refno($pregen_sequence_no+1,$fc);
				}
			}else{

				/**
				 * sushanta
				 * check qrcode sequnce pre generated qr code sequence
				 * description: check QRcodeHeadMst to pre generate qrcode through asset owner id
				 */
				$now_year_month=date('Ym');
				$pregen_sequence_no =pre_generate_qrcode_sequence($assetowner_id,$now_year_month);
				$ref=create_refno($pregen_sequence_no+1,$fc);
			}
		
			
			$parent_id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
				$parent_id = $this->session->userdata('parentid');
			}

			$data = array(
				'AssetOwner'=>$assetowner_id,
				'AssetType'=>$assetman_type,	
				'VendorMobile'=>$vendor_mobile,	
				'VendorEmail'=>$vendor_email,	
				'DepreciationRate'=>$depreciation_rate,	
				'AssetCat'=>$assetman_cat,
				'AssetSubcat'=>$assetment_subcat,
				'UIN'=>$assetment_UIN,	
				'VendorName'=>$vendor_name,
				'VendorAddress'=>$vendor_address,
				'DimensionOfAsset'=>$assetment_dimenson,
				'AssetCondition'=>$assetment_condition,
				'Auditor'=>$assetman_auditor,
				'Incharge'=>$asstman_incharge,
				'Supervisor'=>$assetman_supervisor,
				'UniqueRefNumber'=>$ref,
				'WarrantyCoverdfor'=>$warrantly_covered_for,
				'WarrantyContactPersonMobile'=>$warranty_contact_mobile,
				'WarrantyContactPersonEmail'=>$warranty_contact_email,
				'AssetTitle'=>$asset_title,
				'AssetQuantity'=>$asset_qty,
				'Location'=>$company_location,
				'CurrentLocation'=>$current_location,
				'ParentID'=>$parent_id,
				'Measurement'=>$measurements,
				'CreatedBy'=>$this->session->userdata('userid'),
				'VerificationDate'=>date('Y-m-d'),
				'CreatedDate'=>date('Y-m-d'),
				'CurrencyType'=>$currency_type,
			);
				
			if($assetment_purchaseprice!='' && $assetment_purchaseprice!='NaN'){
				$data['PurchasePrice'] = $assetment_purchaseprice;
			}

			if($purchased_date!=''){
				$purchase_date = explode("-",$purchased_date);
				$insert_purchase = $purchase_date[0]."-".$purchase_date[1]."-".$purchase_date[2];
				$data['PurchaseDate'] = $insert_purchase;
			}
		   
			
			if($valid_till!=''){
				$valid_till = explode("-",$valid_till);
				$insert_valid = $valid_till[0]."-".$valid_till[1]."-".$valid_till[2];
				$data['ValidTil'] = $insert_valid;
			}

			if($insurance_valid_upto!=''){
				$insurance_valid_upto = explode("-",$insurance_valid_upto);
				$insert_insurance = $insurance_valid_upto[0]."-".$insurance_valid_upto[1]."-".$insurance_valid_upto[2];
				$data['InsuranceValidUpto'] = $insert_insurance;
			}


			$resultId = $this->Commonmodel->common_insert('AssetMst',$data);
			$picture = [];
			$picture_count = count($_FILES['picture']['name']);
		
			for($p=0;$p<$picture_count;$p++){
				if(!empty($_FILES['picture']['name'][$p])){
				  	$_FILES['file']['name'] = $_FILES['picture']['name'][$p];
				  	$_FILES['file']['type'] = $_FILES['picture']['type'][$p];
				  	$_FILES['file']['tmp_name'] = $_FILES['picture']['tmp_name'][$p];
				  	$_FILES['file']['error'] = $_FILES['picture']['error'][$p];
				  	$_FILES['file']['size'] = $_FILES['picture']['size'][$p];
				  	if($this->upload->do_upload('file')){
						$pictureData = $this->upload->data();
						$pic_filename = $pictureData['file_name'];
						$picdata = array(
							'AssetID'=>$resultId,
							'ImageName'=>$pic_filename,
							'DocType'=>1,
							'CreatedBy'=>$this->session->userdata('userid'),
							'CreatedDate'=>date('Y-m-d')
						);
						if(($picture_title[$p]??'')!=''){
							$picdata['ImageTitle']=$picture_title[$p];
							
						}
						$picid = $this->Commonmodel->common_insert('AssetFileMst',$picdata);
				  	}
				}
			}
			$data = [];
			if(!empty($_FILES['bill'])){
			  	$count = count($_FILES['bill']['name']);
			  	for($i=0;$i<$count;$i++){
				  	if(!empty($_FILES['bill']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['bill']['name'][$i];
						$_FILES['file']['type'] = $_FILES['bill']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['bill']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['bill']['error'][$i];
						$_FILES['file']['size'] = $_FILES['bill']['size'][$i];
						if($this->upload->do_upload('file')){
						  	$uploadData = $this->upload->data();
						  	$filename = $uploadData['file_name'];
							$billdata = array(
							  	'AssetID'=>$resultId,
							  	'ImageName'=>$filename,
							  	'DocType'=>2,
							  	'CreatedBy'=>$this->session->userdata('userid'),
							  	'CreatedDate'=>date('Y-m-d')
							);
							$vendorid = $this->Commonmodel->common_insert('AssetFileMst',$billdata);
						}
				  	}
				}
			}
			if(!empty($_FILES['warranty'])){
				$wara_data = [];
				$count1 = count($_FILES['warranty']['name']);
				for($i=0;$i<$count1;$i++){
					if(!empty($_FILES['warranty']['name'][$i])){
					  	$_FILES['file']['name'] = $_FILES['warranty']['name'][$i];
					  	$_FILES['file']['type'] = $_FILES['warranty']['type'][$i];
					  	$_FILES['file']['tmp_name'] = $_FILES['warranty']['tmp_name'][$i];
					  	$_FILES['file']['error'] = $_FILES['warranty']['error'][$i];
					  	$_FILES['file']['size'] = $_FILES['warranty']['size'][$i];
					  	if($this->upload->do_upload('file')){
							$uploadData1 = $this->upload->data();
							$filename = $uploadData1['file_name'];
							$wardata = array(
								'AssetID'=>$resultId,
								'ImageName'=>$filename,
								'DocType'=>3,
								'CreatedBy'=>$this->session->userdata('userid'),
								'CreatedDate'=>date('Y-m-d')
							);
							$warantyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

					  	}
					}
				}
			}
			if($resultId){
				// $code = $this->input->post('code');
				$this->load->library('myLibrary');
				$this->mylibrary->generate($ref);
			   echo json_encode(array('status' => 1));
			}else{
			    echo json_encode(array('status' => 0));
			}
		
		}
	}

	function assetexist(){
		$assetment_UIN  = $this->input->post('assetment_UIN');
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		 	$parent_id = $this->session->userdata('parentid');
		}
		$where = array(
			'ParentID'=>$parent_id,
			'UIN'=>$assetment_UIN,
			'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('AssetMst',$where);
		if ($res == 0){
			return FALSE;
		}else{
			return TRUE;
		}

	}


	public function getoneasset(){
		$id = $this->input->post('id');
		$resultId = $this->Assetmodel->getoneasset($id);
		$respictures = $this->Assetmodel->getpictures($id);
		$Picture_array = array();
		$pic_autoid = "";
		$pic_title = "";
		foreach($respictures as $pic){
			$pic_autoid.= $pic['AutoID'].",";
			$pic_title.= $pic['ImageTitle'].",";
			$Picture_array[] = $pic['ImageName'];
		}
		
		$pictures = implode(",",$Picture_array);
		$resbill = $this->Assetmodel->getbils($id);

		$resbill_array = array();
		$res_autoid = "";
		foreach($resbill as $bill){
			$res_autoid.= $bill['AutoID'].",";	
			$resbill_array[] = $bill['ImageName'];
		}

		$bills = implode(",",$resbill_array);

		$warbill = $this->Assetmodel->getwaranty($id);
		$war_array = array();
		$war_autoid = "";
		foreach($warbill as $war){
		$war_autoid.= $war['AutoID'].",";	   
		$war_array[] = $war['ImageName'];
		}
		$his = $this->Assetmodel->getHistory($id);
		$war = implode(",",$war_array);

		$waranty = $this->Assetmodel->getwarrant_basedonsubcat($resultId->AssetSubcat);

		$measurement_list = $this->Assetmodel->getmeasuremnt_basedonsubcat($resultId->subcatmeaurement);

		$fromdate = $resultId->PurchaseDate;
		$todate = date('Y-m-d');


		$quarters = get_quarters($fromdate,$todate);


		$i=1;
		$dep_his = array();
		$temp = '';
		foreach($quarters as $res_quarters){
		$dep_his[$i]['period'] = $res_quarters->period;
		$dep_his[$i]['start'] = $res_quarters->period_start;
		$dep_his[$i]['end'] = $res_quarters->period_end;
		$dep_his[$i]['dep'] = $resultId->DepreciationRate;
		if($i==1){
			$price = $resultId->PurchasePrice;
			$temp = $price;
		}else{
			$quar_per = $resultId->DepreciationRate/4;
			$price = (int)$temp - ((int)$temp*$quar_per/100);
			$temp = $price;
		}
		
		$dep_his[$i]['price'] =round($price,2);
		$i++;

		}
		$response = array(
			"Assetid" => $resultId->Assetid,
			"AssetOwner" => $resultId->AssetOwner,
			"Assetownerid" => $resultId->Assetownerid,
			"AssetType" => $resultId->AssetType,
			"AsseTypeName" => $resultId->AsseTypeName,
			"AsseCatName" => $resultId->AsseCatName,
			"AssetCat" => $resultId->AssetCat,
			"AssetSubcat" => $resultId->AssetSubcat,
			"AssetSubcatName" => $resultId->AssetSubcatName,
			"UIN" => $resultId->UIN,
			"PurchasePrice" => $resultId->PurchasePrice,
			"PurchaseDate" => $resultId->PurchaseDate,
			"ValidTil" => $resultId->ValidTil,
			"VendorName" => $resultId->VendorName,
			"VendorEmail" => $resultId->VendorEmail,
			"VendorMobile" => $resultId->VendorMobile,
			"VendorAddress" => $resultId->VendorAddress,
			"DimensionOfAsset" => $resultId->DimensionOfAsset,
			"DepreciationRate" => $resultId->DepreciationRate, 
			"ConditionName" => $resultId->ConditionName,
			"AssetCondition" => $resultId->AssetCondition,
			"Pictureid" => rtrim($pic_autoid,','),
			"VendorBilliid" => rtrim($res_autoid,','),
			"WarrantyCardid" => rtrim($war_autoid,','),
			"pic_title" => rtrim($pic_title,','),
			"Picture" => $pictures,
			"VendorBill" => $bills,
			"WarrantyCard" => $war,
			"auditor" => $resultId->auditor,
			"incharge" => $resultId->incharge,
			"supervisor" => $resultId->supervisor,
			"auditorid" => $resultId->Auditorid,
			"inchargeid" => $resultId->Inchargeid,
			"supervisorid" => $resultId->Supervisorid,
			"titleStatus" => $resultId->titleStatus,
			"WarrantyCoverdfor" => $resultId->WarrantyCoverdfor,
			"InsuranceValidUpto" => $resultId->InsuranceValidUpto,
			"WarrantyContactPersonMobile" => $resultId->WarrantyContactPersonMobile,
			"WarrantyContactPersonEmail" => $resultId->WarrantyContactPersonEmail,
			"AssetTitle" => $resultId->AssetTitle,
			"AssetQuantity" => $resultId->AssetQuantity,
			"Warrantyselect" =>json_encode($waranty),
			"WarrantyCoverdid" => $resultId->WarrantyCoverdfor,
			"measurementselect" =>json_encode($measurement_list),
			"measurement" =>$resultId->Measurement,
			"his" =>json_encode($his),
			"dep_his"=>$dep_his,
			"Location"=>$resultId->Location,
			"Location_id"=>$resultId->Lid,
			"CurrentLocation"=>$resultId->CurrentLocation,
			"CurrencyType"=>$resultId->CurrencyType,
			"UniqueRefNumber"=>$resultId->UniqueRefNumber,
		);
	
		echo json_encode( array("status" => 1,"data" => $response) );

		
		}


		/////////////////asset import/////////////////
		public function asset_import(){
		$this->load->library('myLibrary');
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		$parent_id = $this->session->userdata('parentid');
		}

		$upload_file=$_FILES['asset_file']['name'];
		$extension=pathinfo($upload_file,PATHINFO_EXTENSION);
		if($extension=='csv')
		{
		$reader= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else if($extension=='xls')
		{
		$reader= new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else
		{
		$reader= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$spreadsheet=$reader->load($_FILES['asset_file']['tmp_name']);
		$sheetdata=$spreadsheet->getActiveSheet()->toArray();
		$sheetcount=count($sheetdata);
		
				
		if($sheetcount>1)
		{
			$data=array();
			for ($i=1; $i < $sheetcount; $i++) { 

				$assetowner_id= $this->Commonmodel->getid_byname('CompanyName',trim($sheetdata[$i][0]),'CompanyMst');
				$where = array('ParentID'=>$parent_id,'AssetOwner'=>$assetowner_id);

				
				$response = $this->Commonmodel->allreadycheck('AssetMst',$where);
					$shortcode= $this->Commonmodel->getshortcode($parent_id,$assetowner_id);
					
						
					$fc = strtoupper(substr($shortcode->CompanyName,0,3));
					
					if($response==0){
						$prev_create_date_row=$this->Commonmodel->getlast_row($parent_id,$assetowner_id);
						$prv_year_month=date('Ym', strtotime($prev_create_date_row));
						$now_year_month=date('Ym');

						if($prv_year_month == $now_year_month){
							//for existing month
							$prv_month=date('m', strtotime($prev_create_date_row));
							$prv_year=date('Y', strtotime($prev_create_date_row));

						$oldshortcode= $this->Commonmodel->last_companycode($parent_id,$assetowner_id,$prv_month,$prv_year);
						$ref=create_refno($oldshortcode+1,$fc);

						}else{
							//for new month
							$ref=create_refno(1,$fc);
						}
					}
					else{
						$ref=create_refno(1,$fc);
					}
				

				// $FourDigitRandomNumber = rand(1000000000,9999999999);
				$data['AssetOwner']  = $assetowner_id;
				$data['AssetTitle']  = trim($sheetdata[$i][1]);
				$data['Location']  = $this->Commonmodel->getid_byname('Name',trim($sheetdata[$i][2]),'LocationMst');
				// $current_location']  = $this->input->post('current_location');
				$data['AssetType']  =$this->Commonmodel->getid_byname('AsseTypeName',trim($sheetdata[$i][3]),'AssettypeMST');
				$data['AssetCat']  = $this->Commonmodel->getid_byname('AsseCatName',trim($sheetdata[$i][4]),'AssetCatMST');
				$data['AssetSubcat']  = $this->Commonmodel->getid_byname('AssetSubcatName',trim($sheetdata[$i][5]),'AssetSubcatMST');
				$subcatdata = $this->Assetmodel->getoneassetsubcat($data['AssetSubcat']);
				$data['Measurement']=$this->Commonmodel->getid_byname('UomName',trim($sheetdata[$i][6]),'UomMST');
				$data['DimensionOfAsset']  = trim($sheetdata[$i][7]);
				$data['AssetQuantity']  = trim($sheetdata[$i][8]);
				$data['UIN']  = trim($sheetdata[$i][9]);
				$data['CurrencyType']  = $this->Commonmodel->getid_byname('CurrencyCode',trim($sheetdata[$i][10]),'CurrencyMST'); //new added
				$assetprices=trim($sheetdata[$i][11]);
				$data['PurchasePrice']  = $assetprices==''?'NaN':$assetprices;
				$data['PurchaseDate']  = date_format(date_create(trim($sheetdata[$i][12])),"Y-m-d");
				$data['VendorName']=trim($sheetdata[$i][13]);					
				$data['VendorEmail']  = trim($sheetdata[$i][14]);
				$data['VendorMobile']  = trim($sheetdata[$i][15]);
				$data['VendorAddress']  = trim($sheetdata[$i][16]);
				$data['DepreciationRate']  = $subcatdata->DepreciationRate;
				$data['AssetCondition']  =  $this->Commonmodel->getid_byname('ConditionName',trim($sheetdata[$i][17]),'MaterialMST');
				$data['ValidTil']  =  date_format(date_create(trim($sheetdata[$i][18])),"Y-m-d");
				$data['Auditor']  = $subcatdata->auditor;
				$data['Incharge']  = $this->Commonmodel->getid_byname('Name',trim($sheetdata[$i][19]),'RegisterMST');//asset user
				$data['Supervisor']  = $this->Commonmodel->getid_byname('Name',trim($sheetdata[$i][20]),'RegisterMST');
				$fetch_warranty_id=array();
				$warrantyArray = explode(',', trim($sheetdata[$i][21]));
				foreach($warrantyArray as $value) {
					$wid=$this->Commonmodel->getid_byname('WarrantyTypeName',$value,'WarrantyTypeMST');
					array_push($fetch_warranty_id,$wid);
					}
				$data['WarrantyCoverdfor']  = implode(',', $fetch_warranty_id);
				
				$data['WarrantyContactPersonMobile']  = trim($sheetdata[$i][22]);
				$data['WarrantyContactPersonEmail']  = trim($sheetdata[$i][23]);
				$data['InsuranceValidUpto']  = trim($sheetdata[$i][24]);
				$data['CreatedBy']  = $this->session->userdata('userid');
				$data['VerificationDate']  = date('Y-m-d');
				$data['CreatedDate']  = date('Y-m-d');
				$data['ParentID']  = $parent_id;
				$data['UniqueRefNumber']=$ref;

				
				
				$insert=$this->Commonmodel->common_insert('AssetMst',$data);
				if($insert){					
				$this->mylibrary->generate($ref);
				}
				
				
			}
			echo json_encode(array('status' => 1));
		}else{
			echo json_encode(array('status' => 0));
		}

	}

	//////////////////// export template

	public function asset_templatedownload(){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="assets_list.xlsx"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Asset Owner');
		$sheet->setCellValue('B1', 'Asset Title');
		$sheet->setCellValue('C1', 'Company Location');
		$sheet->setCellValue('D1', 'Asset Type');
		$sheet->setCellValue('E1', 'Asset Category');
		$sheet->setCellValue('F1', 'Asset Sub Category');
		$sheet->setCellValue('G1', 'Measurement');
		$sheet->setCellValue('H1', 'Dimension of Asset');
		$sheet->setCellValue('I1', 'Asset Quantity');
		$sheet->setCellValue('J1', 'Asset Unique Identification Number');
		$sheet->setCellValue('K1', 'Currency Type');
		$sheet->setCellValue('L1', 'Asset Purchase price');
		$sheet->setCellValue('M1', 'Asset Purchased on');
		$sheet->setCellValue('N1', 'Asset purchased from(vendor name)');
		$sheet->setCellValue('O1', 'Asset purchased from(vendor email id)');
		$sheet->setCellValue('P1', 'Asset purchased from(vendor mobile no)');
		$sheet->setCellValue('Q1', 'Asset purchased from(vendor address)');
		// $sheet->setCellValue('00', 'Depreciation rate (%)');
		$sheet->setCellValue('R1', 'Asset condition');
		$sheet->setCellValue('S1', 'Warranty valid until');
		// $sheet->setCellValue('00', 'Asset Auditor');
		$sheet->setCellValue('T1', 'Asset User');
		$sheet->setCellValue('U1', 'Asset Supervisor');
		$sheet->setCellValue('V1', 'Warranty Covered for');
		$sheet->setCellValue('W1', 'Warranty contact person mobile');
		$sheet->setCellValue('X1', 'Warranty contact person email');
		$sheet->setCellValue('Y1', 'Insurance valid upto');
		

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");

	}

	//////////////////////////end expot template

	///////////////////////end asset import


		public function delete_assetimg(){
		$id = $this->input->post('id');
		$data = array(
				'IsDelete'=>1,
				'DeleteBy'=>$this->session->userdata('userid'),
				'DeleteDate'=>date('Y-m-d')	
			);
			$where = array(
				'AutoID'=>$id,
			);
	
			$resultId = $this->Commonmodel->common_update('AssetFileMst',$where,$data);
		echo TRUE;
	}

	public function addasset_update(){
		
	
		$update_assetid  = $this->input->post('update_assetid');
		$update_assetownerid  = $this->input->post('update_assetownerid');
		$update_assettype  = $this->input->post('update_assettype');
		$update_vendoremail  = $this->input->post('update_vendoremail');
		$update_vendormobile  = $this->input->post('update_vendormobile');
		$update_depreciationrate  = $this->input->post('update_depreciationrate');
		$up_assetmancat  = $this->input->post('up_assetmancat');
		$up_assetmentsubcat  = $this->input->post('up_assetmentsubcat');
		$update_assetmentUIN  = $this->input->post('update_assetmentUIN'); 
		$update_assetorginalprice = $this->input->post('update_assetorginalprice');
		$update_currency_type  = $this->input->post('update_currency');
		$update_purchaseddate  = $this->input->post('update_purchaseddate');
		$update_vendorname  = $this->input->post('update_vendorname');
		$update_vendoraddress  = $this->input->post('update_vendoraddress');
		
		$update_assetdimenson  = $this->input->post('update_assetdimenson');
		$update_assetcondition  = $this->input->post('update_assetcondition');
		$update_assetmanauditor  = $this->input->post('update_assetmanauditor');
		$update_assetmansupervisor  = $this->input->post('update_assetmansupervisor');
		$update_asstmanincharge  = $this->input->post('update_asstmanincharge');
		$update_validtill  = $this->input->post('update_validtill');
		$update_picturetitle  = $this->input->post('update_picturetitle');
		$up_warrantly_covered_for  = $this->input->post('up_warrantly_covered_for');
		$up_insurance_valid_upto  = $this->input->post('up_insurance_valid_upto');
		$up_warranty_contact_mobile  = $this->input->post('up_warranty_contact_mobile');
		$up_warranty_contact_email  = $this->input->post('up_warranty_contact_email');
		$up_measurements  = $this->input->post('up_measurements');

		$update_assettitle  = $this->input->post('update_assettitle');
		$update_assetqty  = $this->input->post('update_assetqty');

		$update_company_location  = $this->input->post('update_company_location');
		$update_current_location  = $this->input->post('update_current_location');

		$update_UniqueRefNumber  = $this->input->post('update_UniqueRefNumber');
		$update_UniqueRefNumber_old  = $this->input->post('update_UniqueRefNumber_old');

	
	
		$config['upload_path']   = './upload/asset/'; 
		$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		$IsAdmin=$this->session->userdata("userdata")['IsAdmin'];
		if($update_UniqueRefNumber == $update_UniqueRefNumber_old){
		$data = array(
			'AssetOwner'=>$update_assetownerid,
			'AssetType'=>$update_assettype,	
			'VendorMobile'=>$update_vendormobile,	
			'VendorEmail'=>$update_vendoremail,	
			'DepreciationRate'=>$update_depreciationrate,	
			'AssetCat'=>$up_assetmancat,
			'AssetSubcat'=>$up_assetmentsubcat,
			'UIN'=>$update_assetmentUIN,	
			'PurchasePrice'=>$update_assetorginalprice,
			'PurchaseDate'=>$update_purchaseddate,
			'VendorName'=>$update_vendorname,
			'VendorAddress'=>$update_vendoraddress,
			'DimensionOfAsset'=>$update_assetdimenson,
			'AssetCondition'=>$update_assetcondition,
			'ValidTil'=>$update_validtill,
			'Auditor'=>$update_assetmanauditor,
			'Incharge'=>$update_asstmanincharge,
			'Supervisor'=>$update_assetmansupervisor,
			'WarrantyCoverdfor'=>$up_warrantly_covered_for,
			'InsuranceValidUpto'=>$up_insurance_valid_upto,
			'WarrantyContactPersonMobile'=>$up_warranty_contact_mobile,
			'WarrantyContactPersonEmail'=>$up_warranty_contact_email,
			'AssetTitle'=>$update_assettitle,
			'AssetQuantity'=>$update_assetqty,
			// 'Measurement'=>$up_measurements,
			'CurrencyType'=>$update_currency_type,
			'ModifyBy'=>$this->session->userdata('userid'),
			'ModifyDate'=>date('Y-m-d'),
			'Location'=>$update_company_location,
			'CurrentLocation'=>$update_current_location,
			);
		}else{
			$checkduplicate_UniqueRefNumber=$this->Assetmodel->check_UniqueRefNumber_exists($update_UniqueRefNumber);
			if($checkduplicate_UniqueRefNumber > 0){
				echo json_encode(array('status' => 0));
				return 0;
			}else{
			if($IsAdmin==1){
				$data = array(
					'AssetOwner'=>$update_assetownerid,
					'AssetType'=>$update_assettype,	
					'VendorMobile'=>$update_vendormobile,	
					'VendorEmail'=>$update_vendoremail,	
					'DepreciationRate'=>$update_depreciationrate,	
					'AssetCat'=>$up_assetmancat,
					'AssetSubcat'=>$up_assetmentsubcat,
					'UIN'=>$update_assetmentUIN,	
					'PurchasePrice'=>$update_assetorginalprice,
					'PurchaseDate'=>$update_purchaseddate,
					'VendorName'=>$update_vendorname,
					'VendorAddress'=>$update_vendoraddress,
					'DimensionOfAsset'=>$update_assetdimenson,
					'AssetCondition'=>$update_assetcondition,
					'ValidTil'=>$update_validtill,
					'Auditor'=>$update_assetmanauditor,
					'Incharge'=>$update_asstmanincharge,
					'Supervisor'=>$update_assetmansupervisor,
					'WarrantyCoverdfor'=>$up_warrantly_covered_for,
					'InsuranceValidUpto'=>$up_insurance_valid_upto,
					'WarrantyContactPersonMobile'=>$up_warranty_contact_mobile,
					'WarrantyContactPersonEmail'=>$up_warranty_contact_email,
					'AssetTitle'=>$update_assettitle,
					'AssetQuantity'=>$update_assetqty,
					// 'Measurement'=>$up_measurements,
					'CurrencyType'=>$update_currency_type,
					'ModifyBy'=>$this->session->userdata('userid'),
					'ModifyDate'=>date('Y-m-d'),
					'Location'=>$update_company_location,
					'CurrentLocation'=>$update_current_location,
					'UniqueRefNumber'=>$update_UniqueRefNumber,
					);
					
					$this->load->library('myLibrary');
					$this->mylibrary->generate($update_UniqueRefNumber);
			}
			else{
				echo json_encode(array('status' => 0));
				return 0;
			}
			}
		}
	
			$where = array(
				'AutoID'=>$update_assetid,
			);

			$resultId = $this->Commonmodel->common_update('AssetMst',$where,$data);
			
			if(!empty($_FILES['update_picture'])){
				
				$picture = [];

			$picture_count = count($_FILES['update_picture']['name']);

			for($p=0;$p<$picture_count;$p++){

				if(!empty($_FILES['update_picture']['name'][$p])){
			
					$_FILES['file']['name'] = $_FILES['update_picture']['name'][$p];
					$_FILES['file']['type'] = $_FILES['update_picture']['type'][$p];
					$_FILES['file']['tmp_name'] = $_FILES['update_picture']['tmp_name'][$p];
					$_FILES['file']['error'] = $_FILES['update_picture']['error'][$p];
					$_FILES['file']['size'] = $_FILES['update_picture']['size'][$p];
			
			
					if($this->upload->do_upload('file')){
					$pictureData = $this->upload->data();
					$pic_filename = $pictureData['file_name'];

					$picdata = array(
						'AssetID'=>$update_assetid,
						'ImageName'=>$pic_filename,
						'DocType'=>1,
						'ModifyBy'=>$this->session->userdata('userid'),
						'ModifyDate'=>date('Y-m-d')
						);

						if(isset($update_picturetitle[$p])){
							$picdata['ImageTitle']=$update_picturetitle[$p];
						}
						$picid = $this->Commonmodel->common_insert('AssetFileMst',$picdata);
			
					
					}
				}
			
				}
			}  

			if(!empty($_FILES['updatebill'])){

			$data = [];

			$count = count($_FILES['updatebill']['name']);

			for($i=0;$i<$count;$i++){

				if(!empty($_FILES['updatebill']['name'][$i])){
			
					$_FILES['file']['name'] = $_FILES['updatebill']['name'][$i];
					$_FILES['file']['type'] = $_FILES['updatebill']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['updatebill']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['updatebill']['error'][$i];
					$_FILES['file']['size'] = $_FILES['updatebill']['size'][$i];
			
			
					if($this->upload->do_upload('file')){
					$uploadData = $this->upload->data();
					$filename = $uploadData['file_name'];

						$billdata = array(
						'AssetID'=>$update_assetid,
						'ImageName'=>$filename,
						'DocType'=>2,
						'ModifyBy'=>$this->session->userdata('userid'),
						'ModifyDate'=>date('Y-m-d')
						);

						$vendorid = $this->Commonmodel->common_insert('AssetFileMst',$billdata);
					}
				}
			
				}
			} 

			if(!empty($_FILES['updatewarranty'])){

				$wara_data = [];

			$count1 = count($_FILES['updatewarranty']['name']);

			for($i=0;$i<$count1;$i++){

				if(!empty($_FILES['updatewarranty']['name'][$i])){
			
					$_FILES['file']['name'] = $_FILES['updatewarranty']['name'][$i];
					$_FILES['file']['type'] = $_FILES['updatewarranty']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['updatewarranty']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['updatewarranty']['error'][$i];
					$_FILES['file']['size'] = $_FILES['updatewarranty']['size'][$i];
			
			
					if($this->upload->do_upload('file')){
					$uploadData1 = $this->upload->data();
					$filename = $uploadData1['file_name'];
					$wardata = array(
						'AssetID'=>$update_assetid,
						'ImageName'=>$filename,
						'DocType'=>3,
						'ModifyBy'=>$this->session->userdata('userid'),
						'ModifyDate'=>date('Y-m-d')
						);

						$warantyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

					}
				}
			
				}
			}  
				

			echo json_encode(array('status' => 1));

		

		}

		public function qrgenerate(){

		$this->load->library('myLibrary');

		$this->mylibrary->generate('test');

		// $code = $this->input->post('code');
		// $barcode = new Barcode();
		// $targetPath = "./upload/qr-code/";
		// $text = $code;
		// $simple_string = $code;
		// 	// Store the cipher method
		// $ciphering = "AES-128-CTR";
		// // Use OpenSSl Encryption method
		// $iv_length = openssl_cipher_iv_length($ciphering);
		// $options = 0;
		// // Non-NULL Initialization Vector for encryption
		// $encryption_iv = '1234567891011121';
		// // Store the encryption key
		// $encryption_key = "GeeksforGeeks";
		// // Use openssl_encrypt() function to encrypt the data
		// $encryption = openssl_encrypt($simple_string, $ciphering,
		// $encryption_key, $options, $encryption_iv);
		// $url_text = base_url()."Assetmanagement/ViewAssetDetails?ref_no=".$encryption;
		// if (! is_dir($targetPath)) {
		// 	mkdir($targetPath, 0777, true);
		// }
		// $bobj = $barcode->getBarcodeObj('QRCODE,H',$url_text ,-4,-4, 'black', array(
		// 	- 2,
		// 	- 2,
		// 	- 2,
		// 	- 2
		// ))->setBackgroundColor('#f0f0f0');
		// $imageData = $bobj->getPngData();
		// ///$timestamp = time();
		// file_put_contents($targetPath.$code.'.png', $imageData);
		// $file = $code.'.png';
		// echo json_encode(array('status' => 1,'filename' => $file));
			

		}
		public function qr_form(){

			$data['page_title'] = 'Asset List';
			$data['page_name'] = "List of Asset ";
			$this->load->view('include/admin-header',$data);
			$this->load->view('include/sidebar');
			$this->load->view('include/topbar');
			$data['type'] = $this->Assetmodel->getassettype();
			$data['material'] = $this->Materialmodel->get_material();
			$data['cat'] = $this->Assetmodel->getassetcat();
			$data['subcat'] = $this->Assetmodel->getassetsubcat();
			$data['currency'] = $this->Mastermodel->getcurrency();
			$this->load->view('superadmin/qrform',$data);
			$this->load->view('include/admin-footer');

		}


		
		
	public function ViewAssetDetails(){

	$enc = $_GET['ref_no'];

	if(isset($_GET['type'])){
		$type = $_GET['type'];
	}else{
		$type = 0;
	}
	
	

	if($type=='1' || $type=='2'){
		$decryption = $enc;
	}else{

		$ciphering = "AES-128-CTR";
		$options = 0;
		$decryption_iv = '1234567891011121';
		// Store the decryption key
		$decryption_key = "dahliatech";
		// Use openssl_decrypt() function to decrypt the data
		$decryption=openssl_decrypt ($enc, $ciphering,$decryption_key, $options, $decryption_iv);

	}
	$data['page_title'] = 'Asset List';
	$data['page_name'] = "List of Asset ";
	$this->load->view('include/admin-header',$data);
	$this->load->view('include/sidebar');
	$this->load->view('include/topbar');
	$data['asset_details'] = $this->Assetmodel->get_assetforqr($decryption);
	if(!empty($data)){
		$assetid = $data['asset_details'][0]['Assetid'];
	}
	$parentid = $this->session->userdata('userid');
	if($this->session->userdata('GroupID')!='1'){
		$parentid = $this->session->userdata('parentid');
	}
	$data['material'] = $this->Materialmodel->get_material($parentid);
	$data['assetpictures'] = $this->Assetmodel->getpictures($assetid);
	$data['assetbill'] = $this->Assetmodel->getbils($assetid);
	$data['assetwaranty'] = $this->Assetmodel->getwaranty($assetid);
	$data['verifypic'] = $this->Assetmodel->getverifiypic($assetid);
	$data['removepic'] = $this->Assetmodel->getremovepic($assetid);
	$data['His'] = $this->Assetmodel->getHistory($assetid);
	$data['verify_type'] = $type;
	$data['veryfy_exists']=$this->Assetmodel->check_veryfy_data_exists($assetid);
	$this->load->view('superadmin/assetdetails',$data);
	$this->load->view('include/admin-footer');

}

	public function getqrcode(){

	$assmentid = $this->input->post('assmentid');
	$resultqr = $this->Assetmodel->getoneasset($assmentid);
	echo json_encode(array('status' => 1,'filename' => $resultqr->UniqueRefNumber));

	}


	function verify_asset(){

		$old_qnt = $this->input->post('old_qnt');
		$new_qnt = $this->input->post('new_qnt');
	if($old_qnt != $new_qnt){
		$remark = $this->input->post('remark');
	}
	
	

	$view_assetid = $this->input->post('view_assetid');
	$verify_condition = $this->input->post('verify_condition');
	$verify_address = $this->input->post('verify_address');
	$verifyinterval = $this->input->post('verifyinterval');
	$createdDate = $this->input->post('createdDate');
	$location = $this->input->post('location');
	$VerificationDate = $this->input->post('VerificationDate');
	$verify_picturetitle = $this->input->post('verify_picturetitle');



	$effectiveDate = date('Y-m-d', strtotime("+$verifyinterval months", strtotime($VerificationDate)));
	$config['upload_path']   = './upload/asset/'; 
	$config['allowed_types'] = 'jpg|png|jpeg|pdf'; 
	$this->load->library('upload',$config);
	$this->upload->initialize($config);

	if($old_qnt != $new_qnt){
		$data = array(
			'isVerify'=>1,
			'VerifyCondition'=>$verify_condition,	
			'VerifiedLocation'=>json_encode($location),	
			'VerifiedBy'=>$this->session->userdata('userid'),
			'VerificationDate'=>$effectiveDate,
			'VerifiedDatetime'=>date("Y-m-d H:i:s"),
			'AssetQuantity'=>$new_qnt,
		);
		$his_data = array(
			'AssetID'=>$view_assetid,	
			'type'=>1,	
			'VerifyCON'=>$verify_condition,	
			'VerifiedOrRemoveBY'=>$this->session->userdata('userid'),
			'VerifiedOrRemoveDate'=>date("Y-m-d H:i:s"),
			'prev_Asset_Qnt'=>$old_qnt,
			'curr_Asset_Qnt'=>$new_qnt,
			'Remark'=>$remark,
			);
			
	}else{
		$data = array(
			'isVerify'=>1,
			'VerifyCondition'=>$verify_condition,	
			'VerifiedLocation'=>json_encode($location),	
			'VerifiedBy'=>$this->session->userdata('userid'),
			'VerificationDate'=>$effectiveDate,
			'VerifiedDatetime'=>date("Y-m-d H:i:s")
			);
			$his_data = array(
				'AssetID'=>$view_assetid,	
				'type'=>1,	
				'VerifyCON'=>$verify_condition,	
				'VerifiedOrRemoveBY'=>$this->session->userdata('userid'),
				'VerifiedOrRemoveDate'=>date("Y-m-d H:i:s")
				);	
	}

	// print_r($data);
	// 		print_r($his_data);
	// 		die();
	$where = array(
	'AutoID'=>$view_assetid,
	);

	$resultId = $this->Commonmodel->common_update('AssetMst',$where,$data);
	$resulthis = $this->Commonmodel->common_insert('VerifyHST',$his_data);

	if(!empty($_FILES['verifypicture'])){

		$wara_data = [];

		$count1 = count($_FILES['verifypicture']['name']);

		for($i=0;$i<$count1;$i++){

			if(!empty($_FILES['verifypicture']['name'][$i])){
		
			$_FILES['verify']['name'] = $_FILES['verifypicture']['name'][$i];
			$_FILES['verify']['type'] = $_FILES['verifypicture']['type'][$i];
			$_FILES['verify']['tmp_name'] = $_FILES['verifypicture']['tmp_name'][$i];
			$_FILES['verify']['error'] = $_FILES['verifypicture']['error'][$i];
			$_FILES['verify']['size'] = $_FILES['verifypicture']['size'][$i];
	
		
			if($this->upload->do_upload('verify')){
				$uploadData1 = $this->upload->data();
				$filename = $uploadData1['file_name'];
				$wardata = array(
					'HisID'=>$resulthis,
					'AssetID'=>$view_assetid,
					'ImageName'=>$filename,
					'DocType'=>4,
					'ModifyBy'=>$this->session->userdata('userid'),
					'ModifyDate'=>date('Y-m-d')
					);

					if(isset($verify_picturetitle[$i])){
					$wardata['ImageTitle']=$verify_picturetitle[$i];
					}

					$verifyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

			}
			}
		
		}
		}  

		echo true;

	}

		
	function remove_asset(){
		$view_uin = $this->input->post('view_uin');			
		$view_assetid = $this->input->post('view_assetid');
		$remove_condition = $this->input->post('remove_condition');
		$remove_status = $this->input->post('remove_status');
		$remove_address = $this->input->post('remove_address');

		$removepicturetitle = $this->input->post('removepicturetitle');
	
		$config['upload_path']   = './upload/asset/'; 
		$config['allowed_types'] = 'jpg|png'; 
		$this->load->library('upload',$config);
		$this->upload->initialize($config);

		$data = array(
		'isRemove'=>1,
		'RemovedLocation'=>$remove_address,	
		'RemovedCondition'=>$remove_condition,	
		'RemovedBy'=>$this->session->userdata('userid'),
		'RemovedDatetime'=>date("Y-m-d H:i:s")
		);

		$where = array(
		'AutoID'=>$view_assetid,
		);

		$resultId = $this->Commonmodel->common_update('AssetMst',$where,$data);

		$remove_hisdata = array(
			'AssetID'=>$view_assetid,	
			'RemoveStatus'=>$remove_status,	
			'type'=>2,	
			'VerifyCON'=>$remove_condition,	
			'VerifiedOrRemoveBY'=>$this->session->userdata('userid'),
			'VerifiedOrRemoveDate'=>date("Y-m-d H:i:s")
			);

		$resulthis = $this->Commonmodel->common_insert('VerifyHST',$remove_hisdata);


		if(!empty($_FILES['removepicture'])){

			$wara_data = [];

			$count1 = count($_FILES['removepicture']['name']);

			for($i=0;$i<$count1;$i++){

				if(!empty($_FILES['removepicture']['name'][$i])){
			
					$_FILES['remove']['name'] = $_FILES['removepicture']['name'][$i];
					$_FILES['remove']['type'] = $_FILES['removepicture']['type'][$i];
					$_FILES['remove']['tmp_name'] = $_FILES['removepicture']['tmp_name'][$i];
					$_FILES['remove']['error'] = $_FILES['removepicture']['error'][$i];
					$_FILES['remove']['size'] = $_FILES['removepicture']['size'][$i];
			
				
					if($this->upload->do_upload('remove')){
						$uploadData1 = $this->upload->data();
						$filename = $uploadData1['file_name'];
						$wardata = array(
							'AssetID'=>$view_assetid,
							'HisID'=>$resulthis,
							'ImageName'=>$filename,
							'DocType'=>5,
							'ModifyBy'=>$this->session->userdata('userid'),
							'ModifyDate'=>date('Y-m-d')
							);
							if(isset($removepicturetitle[$i])){
							$wardata['ImageTitle']=$removepicturetitle[$i];
							}

							$verifyid = $this->Commonmodel->common_insert('AssetFileMst',$wardata);

					}
				}
			
			}
		}
			
			

		$mail = $this->phpmailer_lib->load();
		$from = 'testing@dahlia.tech';

		$removeasset_array = $this->Assetmodel->get_removeassetdetails($view_assetid);

		foreach($removeasset_array as $remove_result){

			$remove_address = $remove_result['RemovedLocation'];
			$remove_on = $remove_result['RemovedDatetime'];
			$remove_by = $remove_result['Rname'];
			$remove_condition = $remove_result['removecond'];
			$supervisoremail = $remove_result['supervisoremail'];

		}


	

		$maildata = array(
			'uin'=>$view_uin,	
			'RemovedLocation'=>$remove_address,	
			'RemovedCondition'=>$remove_condition,	
			'RemovedBy'=>$remove_by,
			'RemovedDatetime'=>$remove_on
			);

			$mail->isSMTP();
			//$mail->isSendmail();
			$mail->Host     = 'smtp.office365.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'testing@dahlia.tech';
			$mail->Password = 'Vur14262';
			$mail->SMTPSecure = 'tls';
			$mail->Port     = 587;

			$mail->addAddress('kalaivanan.s@dahlia.tech');
			// Email subject
			$mail->Subject = 'Remove Asset';
			// Set email format to HTML
			$mail->isHTML(true);
			// Email body content
			// $mailContent = $this->load->view($email['template'],$data,TRUE);
			$mailContent = $this->load->view('mailtemplate_remove',$maildata,TRUE);
			$mail->Body = $mailContent;
			$mail->send();

			// Send email
			if(!$mail->send()){
				$mail->ErrorInfo;
			}else{
				$message = "Mail send successfully";
			}


			echo true;

		}

		
		public function downloadqr(){
		$uniqueref = $this->input->post('assetuniq');
		$qr_count = $this->input->post('qr_count');
		require_once (APPPATH.'helpers/TCPDF/tcpdf.php');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT,false, 'UTF-8', false);
		$pdf->setTitle("Pdf Sample");
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$imagepath =  base_url()."upload/qr-code/".$uniqueref.".png";
		$toolcopy = '';
		for($i=0;$i<$qr_count;$i++){
		$toolcopy .= '<img src="'.$imagepath.'"  width="130" height="130">';
		}
		$pdf->writeHTML($toolcopy,0,0,0,0);
		$download_name = $uniqueref.".pdf";
		$pdf->Output($download_name,'I');

		}
		
		public function view_verifyassest(){

		$data['page_title'] = 'Verify List';
		$data['page_name'] = "List of Assets";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$data['type'] = $this->Assetmodel->getassettype($parentid);
		$data['material'] = $this->Materialmodel->get_material($parentid);
		$data['cat'] = $this->Assetmodel->getassetcat($parentid);
		$data['subcat'] = $this->Assetmodel->getassetsubcat($parentid);
		$data['currency'] = $this->Mastermodel->getcurrency($parentid);
		$data['incharge'] = $this->Usermodel->get_incharge($parentid);
		$data['supervisor'] = $this->Usermodel->get_supervisor($parentid);
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$this->load->view('superadmin/verify_assestform',$data);
		$this->load->view('include/admin-footer');

		}
		public function getassetfor_verify(){

		$this->load->library('myLibrary');
		$asset_no  = $this->input->post('assetno');
		$asset_details = $this->Assetmodel->get_assetforverify($asset_no);
			$i=0;   
			$table_row= "";
		if(count($asset_details)>0){
			foreach($asset_details as $ad){

				$url = $this->mylibrary->ref_enc($ad['UniqueRefNumber']);
				$i++;
				$ref = $ad['UniqueRefNumber'];
				if($ad['isVerify']==1){
					$button="<select onchange='assetdetail(this.id)' id='$ref' class='assetdetail'><option value=''>Select</option><option value='".$ref."/1'>Verify</option><option value='".$ref."/2'>Remove</option></select>";
				}else{
					$button="<select onchange='assetdetail(this.id)'id='$ref' class='assetdetail'><option value=''>Select</option><option value='".$ref."/1'>Verify</option></select>";
				}
				
				$table_row.= "<tr>";
				$table_row.= "<td>".$i."</td><td>".$ad['UniqueRefNumber']."</td><td>".$ad['UIN']."</td><td>".$ad['CompanyName']."</td><td>".$ad['AsseCatName']."</td><td>".$ad['AssetSubcatName']."</td><td>".$ad['VendorName']."</td><td>".$ad['PurchasePrice']."</td><td>".$button."</td>";
				$table_row.= "</tr>";
				
			}
		}else{
			$table_row.= "<tr>";
			$table_row.= "<td colspan='9'><span class='badge bg-danger text-center'>Invalid URN/UIN Number</span></td>";
			$table_row.= "</tr>";
		}
		echo $table_row;
		
		}
		public function getassetfor_remove(){

		$this->load->library('myLibrary');
		$asset_no  = $this->input->post('assetno');
		$asset_details = $this->Assetmodel->getassetfor_remove($asset_no);
			$i=0;   
			$table_row= "";

		
			
			foreach($asset_details as $ad){
				$url = $this->mylibrary->ref_enc($ad['UniqueRefNumber']);
				$i++;
				$table_row.= "<tr>";
				$table_row.= "<td>".$i."</td><td>".$ad['CompanyName'] ."</td><td>".$ad['UIN']."</td><td>".$ad['AsseCatName']."</td><td>".$ad['AssetSubcatName']."</td><td>".$ad['VendorName']."</td><td>".$ad['PurchasePrice']."</td><td>".$ad['UniqueRefNumber']."</td><td><a href='".$url."'><button class='btn print_qr bg-secondary'><i class='fe fe-trash'></i></button></a></td>";
				$table_row.= "</tr>";
			}
		
		
		echo $table_row;
		
		}

		public function view_removeassest(){

		$data['page_title'] = 'Remove List';
		$data['page_name'] = "List of Assets";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$data['type'] = $this->Assetmodel->getassettype($parentid);
		$data['material'] = $this->Materialmodel->get_material($parentid);
		$data['cat'] = $this->Assetmodel->getassetcat($parentid);
		$data['subcat'] = $this->Assetmodel->getassetsubcat($parentid);
		$data['currency'] = $this->Mastermodel->getcurrency($parentid);
		$data['incharge'] = $this->Usermodel->get_incharge($parentid);
		$data['supervisor'] = $this->Usermodel->get_supervisor($parentid);
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$this->load->view('superadmin/remove_assetform',$data);
		$this->load->view('include/admin-footer');

		}

		public function test(){

		echo $str = "select * from AssetMst where VerificationDate between DateAdd(DD,-7,GETDATE()) and GETDATE()";

		}

		public function assetnotification_list()
	{
		$data['page_title'] = 'Asset List';
		$data['page_name'] = "Asset To Be Verify";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$data['type'] = $this->Assetmodel->getassettype($parentid);
		$data['material'] = $this->Materialmodel->get_material($parentid);
		$data['cat'] = $this->Assetmodel->getassetcat($parentid);
		$data['subcat'] = $this->Assetmodel->getassetsubcat($parentid);
		$data['currency'] = $this->Mastermodel->getcurrency($parentid);
		$data['incharge'] = $this->Usermodel->get_incharge($parentid);
		$data['supervisor'] = $this->Usermodel->get_supervisor($parentid);
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$data['warranty'] = $this->Assetmodel->getwarantytype($parentid);
		$this->load->view('superadmin/assestnotifi_list',$data);
		$this->load->view('include/admin-footer');


	}

	public function getnotification_asset(){
		//$from = date('Y-m-d');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$from =  date('Y-m-d');
		$to = date('Y-m-d', strtotime("+7 days", strtotime($from)));
		$result = $this->Assetmodel->getassetlist_notify($from,$to,$parentid);
		$json_data['data'] = $result;
		echo  json_encode($json_data);
	}
	//sushanta code print qr code
	function single_print_qrcode(){
		$noof_copy =$this->input->post('noof_copy');
		$qrcode_ids =$this->input->post('qrcode_id');
		if(!empty($noof_copy) && !empty($qrcode_ids)){
			$qrcodes_data =$this->Assetmodel->getoneassetdata($qrcode_ids); //$this->Assetmodel->getassettype($qrcode_ids);  
			$this->single_qrcode_pdf_generate($noof_copy,$qrcodes_data );
			//echo "<pre>";
			//print_r($qrcodes_data);
		}
	}
	function print_barcode_label(){
		$data['page_title'] = 'Barcode Label List';
		$data['page_name'] = "Barcode Label List";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$data['clocation'] = $this->Assetmodel->getlocation($parentid);
		
		$this->load->view('superadmin/print_barcode_label',$data);
		$this->load->view('include/admin-footer');
	}
	function get_assets_by_location_id(){
		$location =$this->input->post('location');
		if(!empty($location)){
			$assets= $this->Assetmodel->get_asset_by_location($location);
			$html="";
			if(count($assets)>0){
				
				foreach($assets as $data){
					$html.='<tr>';
						$html.='<td><input type="checkbox" name="qrcodes" class="checkbox" value="'.$data->AutoID.'"></td>';
						$html.='<td>'.$data->UniqueRefNumber.'</td>';
						$html.='<td>'.$data->CompanyName.'</td>';
						
						$html.='<td>'.$data->AssetTitle.'</td>';
						$html.='<td>'.$data->AsseCatName.'</td>';
						$html.='<td>'.$data->AssetSubcatName.'</td>';
						$html.='<td>'.date("d-m-Y",strtotime($data->CreatedDate)).'</td>';
						$html.='<td><a href="#"  onclick="printAssetQrcode2('.$data->AutoID.')"><i class="fa fa-qrcode fa-lg" aria-hidden="true"></i></a></td>';
					$html.='/<tr>';
				}
				echo json_encode(["status" =>200, "data" =>$html]);
			}else{
				echo json_encode(["status" =>400, "data" =>$html]);
			}
			
			
		}
	}
	function single_qrcode_pdf_generate($noof_copy,$qrcodes_data){	
		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];
		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];
			
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [104, 25],  
			'orientation' => 'P',
			'margin_left' =>2, 
			'margin_right' => -1,
			'margin_top' => 3, 
			'margin_bottom' => -13, 
			'margin_header' => 0, 
			'margin_footer' => 0, 
			'fontDir' => array_merge($fontDirs, [
				__DIR__ . '/custom/font/directory',
			]),			
			'fontdata' => $fontData + [
				'arial' => [
					'R' => 'arial.ttf',
					'I' => 'arial.ttf',
				],
				'Frank' => [
					'R' => 'Frank-Black.otf',
					'I' => 'Frank-Black.otf',
				],
			],
			'default_font' => 'arial',
			//'mode' => 'c' 
		]);
		$mpdf->autoLangToFont = true;		
		$mpdf->showImageErrors = true;
		$mpdf->curlAllowUnsafeSslRequests = true;
		$mpdf->AddPage();

		$inner_html='';
		if($noof_copy ==1){
			$inner_html.='
				<tr>
					<td>
						<table style="width:100%">
							<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$qrcodes_data->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->Name.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetSubcatName.'</td>
										</tr>
									</table>
								</td>
							</tr>
							
						</table>
					</td>
					<td>
						<table style="width:100%; display:none;">
							<tr style="display:none;">
								<td width="30%"></td>
								<td width="60%">
									<p style="font-size:35px; color:white"><b>'.$qrcodes_data->UniqueRefNumber.'</b></p>
									<p style="font-size:55px;color:white">.</p>
								</td>
							</tr>
							
						</table>
					</td>
				';
			
		}else if($noof_copy == 2){
			$inner_html.='
				<tr >
					<td>
						<table style="width:100%">
							<tr>
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data->UniqueRefNumber).'.png" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->Name.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetSubcatName.'</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width:100%">
							<tr>
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data->UniqueRefNumber).'.png" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->Name.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetSubcatName.'</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>			
				</tr>';
		}else{
			for($i=0; $i < $noof_copy/2; $i++){
				$inner_html.='
				<tr >
					<td>
						<table style="width:100%">
							<tr>
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data->UniqueRefNumber).'.png" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->Name.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetSubcatName.'</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width:100%">
							<tr>
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data->UniqueRefNumber).'.png" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->Name.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data->AssetSubcatName.'</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
					</td>			
				</tr>';
			}
		}
		
		$html='
			<table style="width:100%">
				'.$inner_html.'	
			</table>
		';
	
		//$html = $this->load->view('html_to_pdf_qrcode',[],true);
		$mpdf->WriteHTML($html);
		$mpdf->Output(); // opens in browser
		//$mpdf->Output('arjun.pdf','D');
	}
	function print_qrcode(){
		$noof_copy =$this->input->post('noof_copy');
		$qrcode_ids =$this->input->post('qrcode_ids');
		if(!empty($noof_copy) && !empty($qrcode_ids)){
			$qrcodes_data =$this->Assetmodel->get_asset_details_ids($qrcode_ids);
			$this->qrcode_pdf_generate($noof_copy,$qrcodes_data );
		}
	}
	function qrcode_pdf_generate($noof_copy,$qrcodes_data){	
		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];
		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];
			
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [104, 25],  
			'orientation' => 'P',
			'margin_left' =>2, 
			'margin_right' => -1,
			'margin_top' => 3, 
			'margin_bottom' => -13, 
			'margin_header' => 0, 
			'margin_footer' => 0, 
			'fontDir' => array_merge($fontDirs, [
				__DIR__ . '/custom/font/directory',
			]),			
			'fontdata' => $fontData + [
				'arial' => [
					'R' => 'arial.ttf',
					'I' => 'arial.ttf',
				],
				'Frank' => [
					'R' => 'Frank-Black.otf',
					'I' => 'Frank-Black.otf',
				],
			],
			'default_font' => 'arial',
			//'mode' => 'c' 
		]);

		$mpdf->autoLangToFont = true;		
		$mpdf->showImageErrors = true;
		$mpdf->curlAllowUnsafeSslRequests = true;
		$mpdf->AddPage();

		$inner_html='';
		if($noof_copy ==1){
			for($i=0; $i < count($qrcodes_data); $i++){
				if($i %2 === 0){
					if($i == 0 && count($qrcodes_data) == 1){
						$inner_html.='<tr><td>
						<table style="width:100%">
							<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->UniqueRefNumber.'</b></p>
									<table width="100%">
										<tr>
											<td style="font-size:18px;letter-spacing:2px"><strong>Name</strong> </td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->Name.'</td>
										</tr>
										<tr>
											<td  style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AssetSubcatName.'</td>
										</tr>
									</table>	
								</td>
							</tr>
							
						</table>
					</td>
					<td>
						<table style="width:100%; display:none;">
							<tr style="display:none;">
								<td width="30%"></td>
								<td width="60%">
									<p style="font-size:35px; color:white"><b>'.$qrcodes_data[$i]->UniqueRefNumber.'</b></p>
									<p style="font-size:55px;color:white">.</p>
								</td>
							</tr>
							
						</table>
					</td>
					';
					}else{
					$inner_html.='<tr><td>
						<table style="width:100%">
							<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->UniqueRefNumber.'</b></p>
									<table width="100%">
										<tr>
											<td style="font-size:18px;letter-spacing:2px"><strong>Name</strong> </td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->Name.'</td>
										</tr>
										<tr>
											<td  style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AssetSubcatName.'</td>
										</tr>
									</table>	
								</td>
							</tr>
						</table>
					</td>';
					}
				}else{
					$inner_html.='<td>
						<table style="width:100%">
							<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->UniqueRefNumber.'</b></p>
									<table width="100%">
										<tr>
											<td style="font-size:18px;letter-spacing:2px"><strong>Name</strong> </td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AssetTitle.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->Name.'</td>
										</tr>
										<tr>
											<td  style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AsseCatName.'</td>
										</tr>
										<tr >
											<td  style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td  style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td  style="font-size:18px;letter-spacing:2px">'.$qrcodes_data[$i]->AssetSubcatName.'</td>
										</tr>
									</table>	
									
								</td>
							</tr>
						</table>
					</td></tr>';
				}
			}
			
		}else if($noof_copy == 2){
			foreach($qrcodes_data as $data){
				$inner_html.='
					<tr >
						<td>
							<table style="width:100%">
								<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$data->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetTitle.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->Name.'</td>
										</tr>
										<tr>
											<td style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AsseCatName.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Sub Cat</strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetSubcatName.'</td>
										</tr>
									</table>	
								</td>
							</tr>
							</table>
						</td>
						<td>
							<table style="width:100%">
								<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$data->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetTitle.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->Name.'</td>
										</tr>
										<tr>
											<td style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AsseCatName.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetSubcatName.'</td>
										</tr>
									</table>	
								</td>
							</tr>
							</table>
						</td>			
					</tr>';
			}
		}else{
			foreach($qrcodes_data as $data){
				for($i=0; $i < $noof_copy; $i++){
					$inner_html.='
					<tr >
						<td>
							<table style="width:100%">
								<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$data->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetTitle.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->Name.'</td>
										</tr>
										<tr>
											<td style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AsseCatName.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetSubcatName.'</td>
										</tr>
									</table>	
								</td>
							</tr>
							</table>
						</td>
						<td>
							<table style="width:100%">
								<tr>
								<td width="30%">
									<img src="'.base_url('upload/qr-code/'.$data->UniqueRefNumber).'.png" style="height:300px;width:300px;" >
								</td>
								<td width="60%">
									<p style="font-size:30px;letter-spacing:3px"><b>'.$data->UniqueRefNumber.'</b></p>
									<table>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Name </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetTitle.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Location </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->Name.'</td>
										</tr>
										<tr>
											<td style="font-size:18px;letter-spacing:2px" ><strong>Category </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AsseCatName.'</td>
										</tr>
										<tr >
											<td style="font-size:18px;letter-spacing:2px"><strong>Sub Cat </strong></td>
											<td style="font-size:18px;letter-spacing:2px"><strong>:</strong></td>
											<td style="font-size:18px;letter-spacing:2px">'.$data->AssetSubcatName.'</td>
										</tr>
									</table>	
								</td>
							</tr>
							</table>
						</td>			
					</tr>';
				}
			}
		}
		
		
		$html='
			<table style="width:100%">
				'.$inner_html.'	
			</table>
		';
	
		//$html = $this->load->view('html_to_pdf_qrcode',[],true);
		$mpdf->WriteHTML($html);
		$mpdf->Output(); // opens in browser
		//$mpdf->Output('arjun.pdf','D');
	}

		  

		  

 
  
}