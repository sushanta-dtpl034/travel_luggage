<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH.'vendor/autoload.php';


class Asset extends CI_Controller {

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
      $this->load->model('Assetmodel');
	  $this->load->model('Companymodel');
	  $this->load->model('Usermodel');
	  $this->load->library('phpmailer_lib');
	  $this->load->library('upload');
	}
	
    public function assettype_list()
	{

        $data['page_title'] = 'Asset Type List';
		$data['page_name'] = "List of Asset Type";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/assettype_list');
		$this->load->view('include/admin-footer');
	}
	
	public function assettype_save(){

	
		$this->form_validation->set_rules('assettype_name', 'Assettype_name', 'required|trim|callback_already_exist');
	    if ($this->form_validation->run() == FALSE)
		{
		  echo json_encode(array('status' => 0));
		}
		else
		{
	
			$assettype_name = $this->input->post('assettype_name');
			
			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			 $parentid = $this->session->userdata('parentid');
			}

			$data = array(
			'AsseTypeName'=>strip_tags($assettype_name),
			'CreatedBy'=>$this->session->userdata('userid'),
			'ParentID'=>$parentid,
			'CreatedDate'=>date('Y-m-d'),
			);
			$resultId = $this->Commonmodel->common_insert('AssettypeMST',$data);
			if($resultId){
			echo json_encode(array('status' => 1));
			}else{
			echo json_encode(array('status' => 0));
			}

		}

	}
	function already_exist($key)
	{
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		 }
		$where = array(
			'ParentID'=>$parent_id,
			'AsseTypeName'=>$key,
			'IsDelete'=>0,
		);
	 $res =  $this->Commonmodel->allreadycheck('AssettypeMST',$where);

	  if ($res == 0)
	  {
		  return FALSE;
	  }
	  else
	  {
		  return TRUE;
		  
	  }
	  
	}
	public function getassettype(){

		$id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$id = $this->session->userdata('parentid');
		 }
		$result = $this->Assetmodel->getassettype($id);
		$json_data['data'] = $result;
		echo  json_encode($json_data);

	}
	public function getassetcat(){
       
		$id = $this->session->userdata('userid'); 
		if($this->session->userdata('GroupID')!='1'){
		 $id = $this->session->userdata('parentid');
		}
		$result = $this->Assetmodel->getassetcat($id);
		$json_data['data'] = $result;
		echo  json_encode($json_data);

	}
	
	
	public function update_assettype(){
       	$updateid = $this->input->post('updateid');
		$this->form_validation->set_rules('up_asseytype', 'Asset Type Name', 'required|trim');
		if ($this->form_validation->run() == FALSE)
		{
		  return FALSE;
		}
		else
		{
			$up_asseytype = $this->input->post('up_asseytype');

			$data = array(
			'AsseTypeName'=>strip_tags($up_asseytype),
          	'ModifyBy'=>$this->session->userdata('userid'),
			'ModifyDate'=>date('Y-m-d'),
			);


			$where = array(
				'AutoID'=>$updateid,
			);


			$resultId = $this->Commonmodel->common_update('AssettypeMST',$where,$data);
			if($resultId){
			   echo json_encode(array('status' => 1));
			}else{
			   echo json_encode(array('status' => 0));
			}

		}

	}
	public function delete_assettype(){
		$id = $this->input->post('id');
		$data = array(
				'IsDelete'=>1,
				'DeleteBy'=>$this->session->userdata('userid'),
				'DeleteDate'=>date('Y-m-d')	
			);
			$where = array(
				'AutoID'=>$id,
			);

			$resultId = $this->Commonmodel->common_update('AssettypeMST',$where,$data);
		echo TRUE;
	}


	public function getoneassettype(){
	    $id = $this->input->post('id');
	    $result = $this->Assetmodel->getoneassettype($id);
	    
	    $response = array(
	        "AsseTypeName" => $result->AsseTypeName,
	        "id" => $result->AutoID
	     );

	     echo json_encode( array("status" => 1,"data" => $response) );
	    
	}
	public function getoneassetcat(){
	    $id = $this->input->post('id');
	    $result = $this->Assetmodel->getoneassetcat($id);
	    
	    $response = array(
			"AssetCatIMG" => $result->AssetCatIMG,
			"AsseCatName" => $result->AsseCatName,
			"AssetType" => $result->AssetType,
	        "id" => $result->AutoID
	     );

	     echo json_encode( array("status" => 1,"data" => $response) );
	    
	}
  
  	public function assetcat_list(){		
        $data['page_title'] = 'Asset Type Category';
		$data['page_name'] = "List of Asset Category";

		$id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
			$id = $this->session->userdata('parentid');
		 }
		$data['type'] = $this->Assetmodel->getassettype($id);
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/assetcat_list');
		$this->load->view('include/admin-footer');
	}
	
	public function assetcat_save(){

		
		$asset_type = $this->input->post('asset_type');
		$this->form_validation->set_rules('assetcat_name', 'Asset Catgory', 'required|trim|callback_cat_alreadyexist');
		$this->form_validation->set_rules('asset_type', 'Asset type', 'required');
		if ($this->form_validation->run() == FALSE)
		{
		  echo json_encode(array('status' => 0));
		}
		else
		{

			if (!empty($_FILES['assetcat_image']['name'])) {
			
			$config['upload_path']   = './upload/asset_cat/'; 
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			
			if (!$this->upload->do_upload('assetcat_image')) {
			 $error = array('error' => $this->upload->display_errors()); 
			}
			else { 
				$file_details = array('upload_data' => $this->upload->data()); 
				foreach($file_details as $f){
					$filename = $f['file_name']; 				
				}
			}	
			
		
		}
		    $assetcat_name = $this->input->post('assetcat_name');
			$parentid = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			   $parentid = $this->session->userdata('parentid');
			}
			$data = array(
				'AssetCatIMG'=>$filename,		
				'AsseCatName'=>strip_tags($assetcat_name),
				'AssetType'=>$asset_type,
				'CreatedBy'=>$this->session->userdata('userid'),
				'ParentID'=>$parentid,
				'CreatedDate'=>date('Y-m-d'),
			);
			$resultId = $this->Commonmodel->common_insert('AssetCatMST',$data);
			if($resultId){
			echo json_encode(array('status' => 1));
			}else{
			echo json_encode(array('status' => 0));
			}

		}
	}

	function cat_alreadyexist($key)
	{
		   $asset_type = $this->input->post('asset_type');
			$parent_id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			 $parent_id = $this->session->userdata('parentid');
			}
			$where = array(
			'ParentID'=>$parent_id,
			'AssetType'=>$asset_type,
			'AsseCatName'=>$key,
			'IsDelete'=>0,
			);
			$res =  $this->Commonmodel->allreadycheck('AssetCatMST',$where);
			if ($res == 0)
			{
			  return FALSE;
			}
			else
			{
			 return TRUE;
			}
	  
	}

		public function update_assetcat(){

			

		
			$up_assettype = $this->input->post('up_assettype');
			$old_catimg = $this->input->post('old_catimg');

			// if(isset($old_catimg)){
			// 	$url = "./upload/asset_cat/".$old_catimg;
			// 	if (file_exists($url)) {
			// 		unlink($url);
			// 	}
				
			// }
			$updateid = $this->input->post('updateid');
		
			 $this->form_validation->set_rules('up_assettype', 'Asset Type', 'required');
			 $this->form_validation->set_rules('up_assetcatname', 'Asset Catgory', 'required|trim');
			 if ($this->form_validation->run() == FALSE)
			 {
			   return FALSE;
			 }
			 else
			 {
				$up_assetcatname = $this->input->post('up_assetcatname');
				$data = array(
					'AsseCatName'=>strip_tags($up_assetcatname),
					'AssetType'=>$up_assettype,
					  'ModifyBy'=>$this->session->userdata('userid'),
					'ModifyDate'=>date('Y-m-d'),
					);

				if (!empty($_FILES['updatecat_file']['name'])) {
					
					$config['upload_path']   = './upload/asset_cat/'; 
					$config['allowed_types'] = 'jpg|png|jpeg'; 
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
		
					
					
					if (!$this->upload->do_upload('updatecat_file')) {
					 $error = array('error' => $this->upload->display_errors()); 
					}
					else { 
						$file_details = array('upload_data' => $this->upload->data()); 
						foreach($file_details as $f){
							$filename = $f['file_name']; 				
						}
					}	

					$data['AssetCatIMG'] = $filename;
					
				}
 
				
 
 
				 $where = array(
					 'AutoID'=>$updateid,
				 );

				
				 $resultId = $this->Commonmodel->common_update('AssetCatMST',$where,$data);
				 if($resultId){
					echo json_encode(array('status' => 1));
				 }else{
					echo json_encode(array('status' => 0));
				 }
 
			 }

		}

		public function delete_assetcat(){
			$id = $this->input->post('id');
			$data = array(
					'IsDelete'=>1,
					'DeleteBy'=>$this->session->userdata('userid'),
					'DeleteDate'=>date('Y-m-d')	
				);
				$where = array(
					'AutoID'=>$id,
				);
		
				$resultId = $this->Commonmodel->common_update('AssetCatMST',$where,$data);
			echo TRUE;
		}
		
		public function uom_list()
		{
	
			$data['page_title'] = 'UOM List';
			$data['page_name'] = "List of Measurement";
			$this->load->view('include/admin-header',$data);
			$this->load->view('include/sidebar');
			$this->load->view('include/topbar');
			$this->load->view('superadmin/uom_list');
			$this->load->view('include/admin-footer');
		}
		

		public function getuom(){
            $id = $this->session->userdata('userid'); 
			if($this->session->userdata('GroupID')!='1'){
			 $id = $this->session->userdata('parentid');
			}
			$result = $this->Assetmodel->getuom($id);
			$json_data['data'] = $result;
			echo  json_encode($json_data);
	
		}
		
		public function uom_save(){
	
			
			$this->form_validation->set_rules('uom_name', 'Name', 'required|trim|callback_uomexist');
			$this->form_validation->set_rules('uom_shortname', 'Short name', 'required|trim');
			if ($this->form_validation->run() == FALSE)
			{
			  echo json_encode(array('status' => 0));
			}
			else
			{

				$uom_name  = $this->input->post('uom_name');
				$uom_shortname = $this->input->post('uom_shortname');

				$parent_id = $this->session->userdata('userid');
				if($this->session->userdata('GroupID')!='1'){
				 $parent_id = $this->session->userdata('parentid');
				}
				
	
				$data = array(
				'UomName'=>strip_tags($uom_name),
				'UomShortName'=>strip_tags($uom_shortname),
				'ParentID'=>$parent_id,
				'CreatedBy'=>$this->session->userdata('userid'),
				'CreatedDate'=>date('Y-m-d'),
				);
				$resultId = $this->Commonmodel->common_insert('UomMST',$data);
				if($resultId){
				echo json_encode(array('status' => 1));
				}else{
				echo json_encode(array('status' => 0));
				}
	
			}
		}
			function uomexist($key)
			{
				$uom_shortname = $this->input->post('uom_shortname');
				$parent_id = $this->session->userdata('userid');
					if($this->session->userdata('GroupID')!='1'){
					 $parent_id = $this->session->userdata('parentid');
					}
					$where = array(
					'ParentID'=>$parent_id,
					'UomName'=>$key,
					'UomShortName'=>$uom_shortname,
					'IsDelete'=>0,
					);
				$res =  $this->Commonmodel->allreadycheck('UomMST',$where);
				if ($res == 0)
				{
				 return FALSE;
				}
				else
				{
				 return TRUE;
				}

			}
	
			public function update_uom(){
	
		
			$updateid = $this->input->post('updateid');
			$this->form_validation->set_rules('up_uomname', 'UOM name', 'required|trim');
			$this->form_validation->set_rules('up_uomshortname', 'Short name', 'required|trim');
				 if ($this->form_validation->run() == FALSE)
				 {
				   return FALSE;
				 }
				 else
				 {
					$uom_name  = $this->input->post('up_uomname');
					$uom_shortname = $this->input->post('up_uomshortname');
	 
					 $data = array(
						'UomName'=>strip_tags($uom_name),
						'UomShortName'=>strip_tags($uom_shortname),
					   'ModifyBy'=>$this->session->userdata('userid'),
					 'ModifyDate'=>date('Y-m-d'),
					 );
	 
	 
					 $where = array(
						 'AutoID'=>$updateid,
					 );
	 
	 
					 $resultId = $this->Commonmodel->common_update('UomMST',$where,$data);
					 if($resultId){
						echo json_encode(array('status' => 1));
					 }else{
						echo json_encode(array('status' => 0));
					 }
	 
				 }
	
			}
	
			public function delete_uom(){
				$id = $this->input->post('id');
				$data = array(
						'IsDelete'=>1,
						'DeleteBy'=>$this->session->userdata('userid'),
						'DeleteDate'=>date('Y-m-d')	
					);
					$where = array(
						'AutoID'=>$id,
					);
			
					$resultId = $this->Commonmodel->common_update('UomMST',$where,$data);
				echo TRUE;
			}

			public function getoneuom(){
				$id = $this->input->post('id');
				$result = $this->Assetmodel->getoneuom($id);
				
				$response = array(
					"Name" => $result->UomName,
					"ShortName" => $result->UomShortName,
					"id" => $result->AutoID
				 );
			
				 echo json_encode( array("status" => 1,"data" => $response) );
				
			  }

			  public function assetsubcat_list()
		{
	        $data['page_title'] = 'Asset Sub Category List';
			$data['page_name'] = "List of Asset Sub Category";
			$this->load->view('include/admin-header',$data);
			$this->load->view('include/sidebar');
			$this->load->view('include/topbar');
			$id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			  $id = $this->session->userdata('parentid');
			}
			$data['cat'] = $this->Assetmodel->getassetcat($id);
			$data['mes'] = $this->Assetmodel->getuom($id);

			$data['audit'] = $this->Usermodel->get_audtior($id);
			$data['incharge'] = $this->Usermodel->get_incharge($id);
			$data['supervisor'] = $this->Usermodel->get_supervisor($id);
			$this->load->view('superadmin/assetsubcat_list',$data);
			$this->load->view('include/admin-footer');
		}

		public function myassets_list()
		{
	        $data['page_title'] = 'My Asset List';
			$data['page_name'] = "My Assets";
			$this->load->view('include/admin-header',$data);
			$this->load->view('include/sidebar');
			$this->load->view('include/topbar');
			$id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			  $id = $this->session->userdata('parentid');
			}
			$ids=$this->Assetmodel->getasset_ids($id);
			foreach($ids as $data){
				$asetsid[]=$data['AutoID'];
			}
			
			$data['sliders'] = $this->Assetmodel->getpictures_assetids($asetsid ?? null);
			$data['myassets'] = $this->Assetmodel->getmyasset_list($id);
			$this->load->view('myassets_list',$data);
			$this->load->view('include/admin-footer');
		}
		
		
		public function getassetsubcat(){
			$id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			 $id = $this->session->userdata('parentid');
			}
			$result = $this->Assetmodel->getassetsubcat($id);
			$json_data['data'] = $result;
			echo  json_encode($json_data);
	
		}
		
		public function assetsubcat_save(){
	
			$assetcat_name  = $this->input->post('assetcat_name');
			$measurement  = $this->input->post('measurement');
			// print_r($measurement);
			// die();
			$auditor  = $this->input->post('auditor');
			$depreciation_rate  = $this->input->post('depreciation_rate');
			// $incharge  = $this->input->post('incharge');
			// $supervisor  = $this->input->post('supervisor');
			$sub_numberpic  = $this->input->post('sub_numberpic');
			$verification_interval  = $this->input->post('verification_interval');
			$title  = $this->input->post('title');
							
			$this->form_validation->set_rules('assetcat_name', 'Asset Category Name', 'required');
			$this->form_validation->set_rules('measurement', 'Measurement', 'required');
			$this->form_validation->set_rules('auditor', 'Auditor', 'required');
			$this->form_validation->set_rules('depreciation_rate', 'Depreciation Rate', 'required');
			$this->form_validation->set_rules('assetsubcat_name', 'Asset Sub Category Name', 'required|trim|callback_subcat_alreadyexist');
			if ($this->form_validation->run() == FALSE)
			{
			  echo json_encode(array('status' => 0));
			}
			else
			{
				$config['upload_path']   = './upload/asset_subcat/'; 
				$config['allowed_types'] = 'jpg|png|jpeg'; 
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				$assetsubcat_name = $this->input->post('assetsubcat_name');
				 
				$parent_id = $this->session->userdata('userid');
				if($this->session->userdata('GroupID')!='1'){
				$parent_id = $this->session->userdata('parentid');
				}

				$data = array(
					'AssetCatName'=>$assetcat_name,
					'AssetSubcatName'=>strip_tags($assetsubcat_name),
					'Measurement'=>$measurement,
					'auditor'=>$auditor,
					'NumberOfPicture'=>$sub_numberpic,
					'titleStatus'=>$title,
					'DepreciationRate'=>$depreciation_rate,
					'VerificationInterval'=>$verification_interval,
					'CreatedBy'=>$this->session->userdata('userid'),
					'ParentID'=>$parent_id,
					'CreatedDate'=>date('Y-m-d'),
					);
					$resultId = $this->Commonmodel->common_insert('AssetSubcatMST',$data);

					

				$sub_count = count($_FILES['sub_catimage']['name']);

				for($i=0;$i<$sub_count;$i++){

					if(!empty($_FILES['sub_catimage']['name'][$i])){
				
					  $_FILES['subcat']['name'] = $_FILES['sub_catimage']['name'][$i];
					  $_FILES['subcat']['type'] = $_FILES['sub_catimage']['type'][$i];
					  $_FILES['subcat']['tmp_name'] = $_FILES['sub_catimage']['tmp_name'][$i];
					  $_FILES['subcat']['error'] = $_FILES['sub_catimage']['error'][$i];
					  $_FILES['subcat']['size'] = $_FILES['sub_catimage']['size'][$i];
						  
				
					  if($this->upload->do_upload('subcat')){
						$uploadData = $this->upload->data();
						$subimage = $uploadData['file_name'];

							$billdata = array(
							'AssetID'=>$resultId,
							'ImageName'=>$subimage,
							'DocType'=>2,
							'CreatedBy'=>$this->session->userdata('userid'),
							'CreatedDate'=>date('Y-m-d')
							);

							$vendorid = $this->Commonmodel->common_insert('AssetSubcatFileMst',$billdata);
					  }else{
						echo $this->upload->display_errors();
					  }
					}
			   
				  }

			

				
				
				if($resultId){
				echo json_encode(array('status' => 1));
				}else{
				echo json_encode(array('status' => 0));
				}
	
			}
		}

	function subcat_alreadyexist($key)
	{
  		   $assetcat_name  = $this->input->post('assetcat_name');
			$parent_id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			 $parent_id = $this->session->userdata('parentid');
			}

			$where = array(
			'ParentID'=>$parent_id,
			'AssetCatName'=>$assetcat_name,
			'AssetSubcatName'=>$key,
			'IsDelete'=>NULL,
			);
			$res =  $this->Commonmodel->allreadycheck('AssetSubcatMST',$where);
			if ($res == 0)
			{
			  return FALSE;
			}
			else
			{
			 return TRUE;
			}
	  
	}
	
			public function update_assetsubcat(){


	
			$assetcat_name  = $this->input->post('up_assetcatname');
			$up_depreciation_rate = $this->input->post('up_depreciation_rate');
			$measurement = $this->input->post('measurement');
			$updateid = $this->input->post('updateid');
			$up_auditor = $this->input->post('up_auditor');
			$up_incharge = $this->input->post('up_incharge');
			$up_supervisor = $this->input->post('up_supervisor');

			$up_subnumberpic = $this->input->post('up_subnumberpic');
			$up_subtitle = $this->input->post('up_subtitle');
			$up_verificationinterval = $this->input->post('up_verificationinterval');

			
			$this->form_validation->set_rules('up_depreciation_rate', 'Depreciation Rate', 'required');	
			$this->form_validation->set_rules('up_assetcatname', 'Asset Category Name', 'required');
			$this->form_validation->set_rules('up_assetsubcatname', 'Asset Sub Category', 'required|trim');
				 if ($this->form_validation->run() == FALSE)
				 {
				   return FALSE;
				 }
				 else
				 {

					$config['upload_path']   = './upload/asset_subcat/'; 
				$config['allowed_types'] = 'jpg|png|jpeg'; 
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				

				$assetsubcat_name = $this->input->post('up_assetsubcatname');
						$data = array(
							'AssetCatName'=>$assetcat_name,
							'Measurement'=>$measurement,
							'VerificationInterval'=>$up_verificationinterval,
							'AssetSubcatName'=>strip_tags($assetsubcat_name),
							'auditor'=>$up_auditor,
							'DepreciationRate'=>$up_depreciation_rate,
							'NumberOfPicture'=>$up_subnumberpic,
							'titleStatus'=>$up_subtitle,
							'ModifyBy'=>$this->session->userdata('userid'),
							'ModifyDate'=>date('Y-m-d'),
						);

						

					

				 if(isset($_FILES['up_subcatimage'])){

					$up_subcount = count($_FILES['up_subcatimage']['name']);
		
				for($i=0;$i<$up_subcount;$i++){

					if(!empty($_FILES['up_subcatimage']['name'][$i])){
				
					  $_FILES['upsubcat']['name'] = $_FILES['up_subcatimage']['name'][$i];
					  $_FILES['upsubcat']['type'] = $_FILES['up_subcatimage']['type'][$i];
					  $_FILES['upsubcat']['tmp_name'] = $_FILES['up_subcatimage']['tmp_name'][$i];
					  $_FILES['upsubcat']['error'] = $_FILES['up_subcatimage']['error'][$i];
					  $_FILES['upsubcat']['size'] = $_FILES['up_subcatimage']['size'][$i];
						  
				
					  if($this->upload->do_upload('upsubcat')){
						$uploadData = $this->upload->data();
						$subimage = $uploadData['file_name'];

							$billdata = array(
							'AssetID'=>$updateid,
							'ImageName'=>$subimage,
							'DocType'=>2,
							'CreatedBy'=>$this->session->userdata('userid'),
							'CreatedDate'=>date('Y-m-d')
							);

							$vendorid = $this->Commonmodel->common_insert('AssetSubcatFileMst',$billdata);
					  }else{
					   $this->upload->display_errors();
					
					
					  }
					}
			   
				  }
				} 
	 			
					 $where = array(
						 'AutoID'=>$updateid,
					 );


					 
	 
					 $resultId = $this->Commonmodel->common_update('AssetSubcatMST',$where,$data);
					 if($resultId){
						echo json_encode(array('status' => 1));
						}else{
						echo json_encode(array('status' => 0));
						}
				 }
	
			}
	
			public function delete_assetsubcat(){
				$id = $this->input->post('id');
				$data = array(
						'IsDelete'=>1,
						'DeleteBy'=>$this->session->userdata('userid'),
						'DeleteDate'=>date('Y-m-d')	
					);
					$where = array(
						'AutoID'=>$id,
					);
			
					$resultId = $this->Commonmodel->common_update('AssetSubcatMST',$where,$data);
				echo TRUE;
			}

			  public function get_oneassetsubcat(){
				$id = $this->input->post('id');
				$result = $this->Assetmodel->getoneassetsubcat($id);
				
				$subpic = $this->Assetmodel->getsubpictures($id)??0;
				$waranty = $this->Assetmodel->getwarrant_basedonsubcat($id)??0;
				// echo $result->Measurement;
				// echo $mess = (int)$result->Measurement;
				// die();
				$measurement_list = $this->Assetmodel->getmeasuremnt_basedonsubcat($result->Measurement ?? 0) ?? 0;

							
				

				$Subpicture_array = array();
				$subpic_autoid = "";
				foreach($subpic as $sub_pic){
					$subpic_autoid.= $sub_pic['AutoID'].",";
					$Subpicture_array[] = $sub_pic['ImageName'];
				}
				$subpictures = implode(",",$Subpicture_array);

				
				$response = array(
					"AssetSubCatIMG" => $subpictures,
					"AssetSubCatId" => rtrim($subpic_autoid,','),
					"Measurement_Sub" => $result->Measurement ?? '',
					"catname" => $result->AssetCatName ?? '',
					"subcatname" => $result->AssetSubcatName ?? '',
					"auditor" => $result->auditor ?? '',
					"auditorname" => $result->auditorname ?? '',
					"update_assetsubcat" => $result->supervisor ?? '',
					"NumberOfPicture" => $result->NumberOfPicture ?? '',
					"titleStatus" => $result->titleStatus ?? '',
					"DepreciationRate" => $result->DepreciationRate ?? '',
					"VerificationInterval" => $result->VerificationInterval ?? '',
					"warranty" =>json_encode($waranty),
					"Measurement" =>json_encode($measurement_list),
					"id" => $result->AutoID ?? ''
				 );
			
				 echo json_encode( array("status" => 1,"data" => $response) );
				
			  }

			public function get_subcat_basedoncatid(){
		
						$assetman_catid = $this->input->post('id');
						$result = $this->Assetmodel->get_subcat_basedoncatid($assetman_catid);
					  echo  json_encode($result);
			}

			public function get_cat_basedontypeid(){

				$assetman_type = $this->input->post('id');
				$result = $this->Assetmodel->get_cat_basedontypeid($assetman_type);
				echo  json_encode($result);
			}
			public function delete_subcatimg(){
				$id = $this->input->post('id');
				$data = array(
						'IsDelete'=>1,
						'DeleteBy'=>$this->session->userdata('userid'),
						'DeleteDate'=>date('Y-m-d')	
					);
					$where = array(
						'AutoID'=>$id,
					);
			
					$resultId = $this->Commonmodel->common_update('AssetSubcatFileMst',$where,$data);
				echo TRUE;
			}
			public function assetpic_update(){
		
				$pic_title = $this->input->post('pic_title');
				$asset_id = $this->input->post('asset_id');
	
				// if(isset($old_catimg)){
				// 	$url = "./upload/asset_cat/".$old_catimg;
				// 	if (file_exists($url)) {
				// 		unlink($url);
				// 	}
					
				// }
				 $this->form_validation->set_rules('pic_title', 'Picture Title', 'required');
				 $this->form_validation->set_rules('asset_id', 'Assest Id', 'required|trim');
				 if ($this->form_validation->run() == FALSE)
				 {
				   return FALSE;
				 }
				 else
				 {
					$up_assetcatname = $this->input->post('up_assetcatname');
					$data = array(
						'ImageTitle'=>strip_tags($pic_title),
						  'ModifyBy'=>$this->session->userdata('userid'),
						'ModifyDate'=>date('Y-m-d'),
						);
	
					if (!empty($_FILES['assetpic_image']['name'])) {
						
						$config['upload_path']   = './upload/asset/'; 
						$config['allowed_types'] = 'jpg|png|jpeg'; 
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						
						if (!$this->upload->do_upload('assetpic_image')) {
						 $error = array('error' => $this->upload->display_errors()); 
						}
						else { 
							$file_details = array('upload_data' => $this->upload->data()); 
							foreach($file_details as $f){
								$filename = $f['file_name']; 				
							}
						}	
	
						$data['ImageName'] = $filename;
						
					}
	 
					
	 
	 
					 $where = array(
						 'AutoID'=>$asset_id,
					 );
	
					
					 $resultId = $this->Commonmodel->common_update('AssetFileMst',$where,$data);
					 if($resultId){
						echo true;
					 }else{
						echo false;
					 }
	 
				 }
	
				}
				public function supervisor_assetsubcat_list()
				{
					$data['page_title'] = 'Asset Sub Category List';
					$data['page_name'] = "List of Asset Sub Category";
					$this->load->view('include/admin-header',$data);
					$this->load->view('include/sidebar');
					$this->load->view('include/topbar');
					$id = $this->session->userdata('userid');
					if($this->session->userdata('GroupID')!='1'){
					  $id = $this->session->userdata('parentid');
					}
					$data['cat'] = $this->Assetmodel->getassetcat($id);
					$data['mes'] = $this->Assetmodel->getuom($id);
		
					$data['audit'] = $this->Usermodel->get_audtior($id);
					$data['incharge'] = $this->Usermodel->get_incharge($id);
					$data['supervisor'] = $this->Usermodel->get_supervisor($id);
					$this->load->view('superadmin/supervisor_assetsubcat_list',$data);
					$this->load->view('include/admin-footer');
				}
				
				public function cat_templatedownload(){

					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="category_list.xlsx"');
					$spreadsheet = new Spreadsheet();
					$sheet = $spreadsheet->getActiveSheet();
					$sheet->setCellValue('A1', 'Asset Type');
					$sheet->setCellValue('B1', 'Asset Catgory');
					$writer = new Xlsx($spreadsheet);
					$writer->save("php://output");
	
				}
				public function cat_import(){	
					$upload_file=$_FILES['cat_file']['name'];
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
					$spreadsheet=$reader->load($_FILES['cat_file']['tmp_name']);
					$sheetdata=$spreadsheet->getActiveSheet()->toArray();
					$sheetcount=count($sheetdata);
					if($sheetcount>1)
					{
						$data=array();
						for ($i=1; $i < $sheetcount; $i++) { 
	
								$type = trim($sheetdata[$i][0]);
								$cat =  trim($sheetdata[$i][1]);
								if($type!='' && $cat!=''){
                                    $resultId = $this->Assetmodel->getassettype_byname($type);  
									$parent_id = $this->session->userdata('userid');
									if($this->session->userdata('GroupID')!='1'){
									 $parent_id = $this->session->userdata('parentid');
									}
									$where = array(
										'ParentID'=>$parent_id,
										'AssetType'=>$resultId->AutoID,
										'AsseCatName'=>$cat,
										'IsDelete'=>0,
										);
										$res =  $this->Commonmodel->allreadycheck('AssetCatMST',$where);
										if($res){
											$data = array(
												'AssetType'=>$resultId->AutoID,	
												'AsseCatName'=>$cat,
												'CreatedBy'=>$this->session->userdata('userid'),
												'ParentID'=>$parent_id,
												'CreatedDate'=>date('Y-m-d'),
											);
											$resultId = $this->Commonmodel->common_insert('AssetCatMST',$data);

										}
								}
							
						}
						echo json_encode(array('status' => 1));
					}else{
						echo json_encode(array('status' => 0));
					}
	
				}
				public function subcat_templatedownload(){

					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="subcategory_list.xlsx"');
					$spreadsheet = new Spreadsheet();
					$sheet = $spreadsheet->getActiveSheet();
					$sheet->setCellValue('A1', 'Catgory');
					$sheet->setCellValue('B1', 'Sub Category');
					$sheet->setCellValue('C1', 'Number Of Picture');
					$sheet->setCellValue('D1', 'Title');
					$sheet->setCellValue('E1', 'Verification Interval');
					$sheet->setCellValue('F1', 'Auditor');
					$sheet->setCellValue('A2', '');
					$sheet->setCellValue('B2', '');
					$sheet->setCellValue('C2', '');
					$sheet->setCellValue('D2', 'Yes');
					$sheet->setCellValue('E2', '');
					$sheet->setCellValue('F2', '');
					$writer = new Xlsx($spreadsheet);
					$writer->save("php://output");
	
				}
				public function subcat_import(){
	
					$upload_file=$_FILES['subcat_file']['name'];
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
					$spreadsheet=$reader->load($_FILES['subcat_file']['tmp_name']);
					$sheetdata=$spreadsheet->getActiveSheet()->toArray();
					$sheetcount=count($sheetdata);
					if($sheetcount>1)
					{
						$data=array();
						for ($i=1; $i < $sheetcount; $i++) { 
	
								$assetcat = trim($sheetdata[$i][0]);
								$assetsubcat =  trim($sheetdata[$i][1]);
								$numberofpicture =  $sheetdata[$i][2];
								$title =  $sheetdata[$i][3];
								$verification =  $sheetdata[$i][4];
								$auditor =  $sheetdata[$i][5];

								if($title=='Yes'){
									$title_status = 1;
								}else{
									$title_status = 0;
								}

								if($assetcat!='' && $assetsubcat!='' && $numberofpicture && $title!='' && $verification!='' && $auditor!=''){
                                    $resultId = $this->Assetmodel->getassetcat_byname($assetcat);
									$auditor = $this->Usermodel->getuser_byname($auditor); 
									$parent_id = $this->session->userdata('userid');
									if($this->session->userdata('GroupID')!='1'){
									 $parent_id = $this->session->userdata('parentid');
									}   
									$where = array(
										'ParentID'=>$parent_id,
										'AssetCatName'=>$resultId->AutoID,
										'AssetSubcatName'=>$assetsubcat,
										'IsDelete'=>0,
										);
										$res =  $this->Commonmodel->allreadycheck('AssetSubcatMST',$where);
										if($res){
											$data = array(
												'AssetCatName'=>$resultId->AutoID,
												'AssetSubcatName'=>$assetsubcat,
												'NumberOfPicture'=>$numberofpicture,
												'titleStatus'=>$title_status,
												'VerificationInterval'=>$verification,
												'auditor'=>$auditor->AutoID,
												'CreatedBy'=>$this->session->userdata('userid'),
												'ParentID'=>$parent_id,
												'CreatedDate'=>date('Y-m-d'),
											);
											$resultId = $this->Commonmodel->common_insert('AssetSubcatMST',$data);

										}
								}
							
						}
						echo json_encode(array('status' => 1));
					}else{
						echo json_encode(array('status' => 0));
					}
	
				}


				


		public function getwarrantytype(){

			$id = $this->session->userdata('userid');
			if($this->session->userdata('GroupID')!='1'){
			 $id = $this->session->userdata('parentid');
			}
			$result = $this->Assetmodel->getwarantytype($id);
			$json_data['data'] = $result;
			echo  json_encode($json_data);

		}		

	public function warranty_list()
	{


	$data['page_title'] = 'Warranty Type List';
	$data['page_name'] = "List of Warranty Type";
	$this->load->view('include/admin-header',$data);
	$this->load->view('include/sidebar');
	$this->load->view('include/topbar');
	$parentid = $this->session->userdata('userid');
	if($this->session->userdata('GroupID')!='1'){
	 $parentid = $this->session->userdata('parentid');
	}
	$data['cat'] = $this->Assetmodel->getassetcat($parentid);
	$data['subcat'] = $this->Assetmodel->getassetsubcat($parentid);
	$this->load->view('superadmin/warrantytype_list',$data);
	$this->load->view('include/admin-footer');
	}
   
	public function warranty_save(){
			$this->form_validation->set_rules('warr_assetmancat', 'Catgory Name', 'required');
			$this->form_validation->set_rules('warr_assetment_subcat', 'Sub Catgory Name', 'required');	
			$this->form_validation->set_rules('warrantytype_name', 'Warrantytype Name', 'required|trim|callback_warranty_alreadyexist');
			if ($this->form_validation->run() == FALSE)
			{
			   echo json_encode(array('status' => 0));
			}
			else
			{
				$warrantytype_name = $this->input->post('warrantytype_name');
				$warr_assetmancat = $this->input->post('warr_assetmancat');
				$warr_assetment_subcat = $this->input->post('warr_assetment_subcat');
				$parentid = $this->session->userdata('userid');
				if($this->session->userdata('GroupID')!='1'){
				$parentid = $this->session->userdata('parentid');
				}
				$data = array(
				'WarrantyTypeName'=>strip_tags($warrantytype_name),
				'AssetCat'=>$warr_assetmancat,
				'AssetSubCat'=>$warr_assetment_subcat,
				'CreatedBy'=>$this->session->userdata('userid'),
				'ParentID'=>$parentid,
				'CreatedDate'=>date('Y-m-d'),
				);
				$resultId = $this->Commonmodel->common_insert('WarrantyTypeMST',$data);
				if($resultId){
				   echo json_encode(array('status' => 1));
				}else{
				  echo json_encode(array('status' => 0));
				}

			}

	}

	function warranty_alreadyexist($key)
	{
		
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parent_id = $this->session->userdata('parentid');
		}
		$where = array(
		'ParentID'=>$parent_id,
		'WarrantyTypeName'=>$key,
		'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('WarrantyTypeMST',$where);

		if ($res == 0)
		{
		return FALSE;
		}
		else
		{
		return TRUE;
		}

	}

	public function update_warrantype(){
	$updateid = $this->input->post('updateid');
	$this->form_validation->set_rules('up_warrantytype', 'Warrantytype Type Name', 'required|trim');
	$this->form_validation->set_rules('up_warrassetmancat', 'Assest Cat', 'required');
	$this->form_validation->set_rules('up_warrassetmentsubcat', 'Assest Sub Cat', 'required');
	if ($this->form_validation->run() == FALSE)
	{
	return FALSE;
	}
	else
	{
	$up_warrantytype = $this->input->post('up_warrantytype');
	$up_warrassetmancat = $this->input->post('up_warrassetmancat');
	$up_warrassetmentsubcat = $this->input->post('up_warrassetmentsubcat');

	$data = array(
	'WarrantyTypeName'=>strip_tags($up_warrantytype),
	'AssetCat'=>$up_warrassetmancat,
	'AssetSubCat'=>$up_warrassetmentsubcat,
	'ModifyBy'=>$this->session->userdata('userid'),
	'ModifyDate'=>date('Y-m-d'),
	);


	$where = array(
	'AutoID'=>$updateid,
	);


	$resultId = $this->Commonmodel->common_update('WarrantyTypeMST',$where,$data);
	if($resultId){
	echo json_encode(array('status' => 1));
	}else{
	echo json_encode(array('status' => 0));
	}

	}

	}
	

	

	

	public function delete_warrantype(){
	$id = $this->input->post('id');
	$data = array(
	'IsDelete'=>1,
	'DeleteBy'=>$this->session->userdata('userid'),
	'DeleteDate'=>date('Y-m-d')	
	);
	$where = array(
	'AutoID'=>$id,
	);

	$resultId = $this->Commonmodel->common_update('WarrantyTypeMST',$where,$data);
	echo TRUE;
	}

	public function getonewarrantytype(){
		$id = $this->input->post('id');
		$result = $this->Assetmodel->getonewarrantytype($id);
		
		$response = array(
			"WarrantyTypeName" => $result->WarrantyTypeName,
			"AssetCat" => $result->AssetCat,
			"AssetSubCat" => $result->AssetSubCat,
			"id" => $result->AutoID
		 );
	
		 echo json_encode( array("status" => 1,"data" => $response) );
		
	  }
				

	  //////////////////location///////////
	  public function get_location_bycompanyid(){

		$cid = $this->input->post('id');
		$result = $this->Assetmodel->get_location_bycompanyid($cid);
		echo  json_encode($result);
	}
	 /* Asset transfer */
	 public function assetransfer_list()
	 {
		 
		 $data['page_title'] = 'Transfer Asset List';
		 $data['page_name'] = "List of Transfer Asset";
		 $this->load->view('include/admin-header',$data);
		 $this->load->view('include/sidebar');
		 $this->load->view('include/topbar');
		 $parentid = $this->session->userdata('userid');
		 if($this->session->userdata('GroupID')!='1'){
		   $parentid = $this->session->userdata('parentid');
		 }
		$data['assetlist'] = $this->Assetmodel->getasset_urn($parentid,2);
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$data['incharge'] = $this->Usermodel->get_incharge($parentid);
		$data['urn'] = $this->Assetmodel->getasset_basedonuserrole($parentid);
		$this->load->view('superadmin/assettransfer_list',$data);
		$this->load->view('include/admin-footer');
	 }
 
	 public function assettransfer_save(){
 
		 $transfertype  = $this->input->post('transfertype');
		 $asset_urn  = $this->input->post('asset_urn');
		 $from_company = $this->input->post('from_company');
		 $to_company = $this->input->post('to_company');
		 $from_user = $this->input->post('from_user');
		 $to_user = $this->input->post('to_user');
		 $remarks = $this->input->post('remarks');
		 $asset_urn = $this->input->post('asset_urn');
 
		 if($transfertype==1){
			 $from_company = $this->input->post('from_company');
			 $to_company = $this->input->post('to_company');
			 $from_user = "";
			 $to_user = "";
		 }else{
			 $from_company = "";
			 $to_company = "";
			 $from_user = $this->input->post('from_user');
			 $to_user = $this->input->post('to_user');
		 }
 
		 foreach($asset_urn as $res_asseturn){
			 
			 date_default_timezone_set("Asia/Calcutta"); 
				 $data = array(
						 'AssetID'=>$res_asseturn,
						 'FromCompany'=>$from_company,
						 'ToCompany'=>$to_company,
						 'FromUser'=>$from_user,
						 'ToUser'=>$to_user,
						 'Type'=>$transfertype,
						 'Remarks'=>$remarks,
						 'CreatedBy'=>$this->session->userdata('userid'),
						 'TransferDatetime'=>date('Y-m-d h:i:s'),
					 );
					 $resultId = $this->Commonmodel->common_insert('AssettransferHIS',$data);

					 $where =  $data = array(
						'AutoID'=>$res_asseturn,
					);
					if($transfertype==1){
						$updateData = array(
							'AssetOwner'=>$to_company,
						);
					}else{
						$updateData = array(
							'Incharge'=>$to_user,
						);	
					} 
					 $updateId = $this->Commonmodel->common_update('AssetMst',$where,$updateData);
 
		 }
		if($resultId){
			  echo json_encode(array('status' => 1));
		}else{
			 echo json_encode(array('status' => 0));
		}
 
	 }
	 
	 public function getAssettranferdetails(){
			 $id = $this->session->userdata('userid');
			 // echo $this->session->userdata('GroupID');
			 // die();
			 // if($this->session->userdata('GroupID')!='1'){
			 // 	$id = $this->session->userdata('parentid');
			 // }
			 $result = $this->Commonmodel->getAssettransferdetails($id);
			 $json_data['data'] = $result;
			 echo  json_encode($json_data);
	   }


	   public function assetransfertest_list()
	   {
		   
		   $data['page_title'] = 'Transfer Asset List';
		   $data['page_name'] = "List of Transfer Asset";
		   $this->load->view('include/admin-header',$data);
		   $this->load->view('include/sidebar');
		   $this->load->view('include/topbar');
		   $parentid = $this->session->userdata('userid');
		   if($this->session->userdata('GroupID')!='1'){
			 $parentid = $this->session->userdata('parentid');
		   }
		   //$data['assetlist'] = $this->Assetmodel->getasset_urn($parentid);
		   $data['company'] = $this->Companymodel->getcompany($parentid);
		   $data['incharge'] = $this->Usermodel->get_incharge($parentid);
		   $this->load->view('superadmin/assettransfertest_list',$data);
		   $this->load->view('include/admin-footer');
	   }

	   public function get_asseturn(){
		$ownerid = $this->input->post('id');
		$ownerType = $this->input->post('ownerType');
		$result = $this->Assetmodel->getasset_urn($ownerid,$ownerType);
		echo  json_encode($result);
	}

	//reminder setting//
	public function getremindersetting(){

		$id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		 $id = $this->session->userdata('parentid');
		}
		$result = $this->Assetmodel->getremindersetting($id);
		$json_data['data'] = $result;
		echo  json_encode($json_data);

	}		
	public function remnindersetting_list()
	{


		$data['page_title'] = 'Reminder Setting List';
		$data['page_name'] = "List of Reminder Setting";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parentid = $this->session->userdata('parentid');
		}
		$data['cat'] = $this->Assetmodel->getassetcat($parentid);
		$data['subcat'] = $this->Assetmodel->getassetsubcat($parentid);
		$this->load->view('superadmin/remindersetting_list',$data);
		$this->load->view('include/admin-footer');
	}
   
	public function remnindersetting_save(){
			$this->form_validation->set_rules('rs_assetmancat', 'Catgory Name', 'required');
			$this->form_validation->set_rules('rs_assetment_subcat', 'Sub Catgory Name', 'required');	
			$this->form_validation->set_rules('reminder_days', 'Reminder Days', 'required|trim|callback_remnindersetting_alreadyexist');
			if ($this->form_validation->run() == FALSE)
			{
			   echo json_encode(array('status' => 0));
			}
			else
			{
				$rs_assetmancat = $this->input->post('rs_assetmancat');
				$rs_assetment_subcat = $this->input->post('rs_assetment_subcat');
				$reminder_days = $this->input->post('reminder_days');
				$parentid = $this->session->userdata('userid');
				if($this->session->userdata('GroupID')!='1'){
				   $parentid = $this->session->userdata('parentid');
				}
				$data = array(
				'Reminderdays'=>$reminder_days,
				'AssetCat'=>$rs_assetmancat,
				'AssetSubCat'=>$rs_assetment_subcat,
				'CreatedBy'=>$this->session->userdata('userid'),
				'ParentID'=>$parentid,
				'IsDelete'=>0,
				'CreatedDate'=>date('Y-m-d'),
				);
				$resultId = $this->Commonmodel->common_insert('RemindersettingMST',$data);
				if($resultId){
				   echo json_encode(array('status' => 1));
				}else{
				  echo json_encode(array('status' => 0));
				}

			}

	}

	function remnindersetting_alreadyexist($key)
	{
		
		$parent_id = $this->session->userdata('userid');
		if($this->session->userdata('GroupID')!='1'){
		  $parent_id = $this->session->userdata('parentid');
		}
		$assetcat = $this->input->post('rs_assetmancat');
		$assetsubcat = $this->input->post('rs_assetment_subcat');
		$where = array(
		'ParentID'=>$parent_id,
		'AssetCat'=>$assetcat,
		'AssetSubCat'=>$assetsubcat,
		'IsDelete'=>0,
		);
		$res =  $this->Commonmodel->allreadycheck('RemindersettingMST',$where);

		if ($res == 0)
		{
		return FALSE;
		}
		else
		{
		return TRUE;
		}

	}

	public function update_remindersetting(){
	$updateid = $this->input->post('updateid');
	$this->form_validation->set_rules('up_reminder_days', 'Warrantytype Type Name', 'required|trim');
	$this->form_validation->set_rules('up_warrassetmancat', 'Assest Cat', 'required');
	$this->form_validation->set_rules('up_warrassetmentsubcat', 'Assest Sub Cat', 'required');
	if ($this->form_validation->run() == FALSE)
	{
	   return FALSE;
	}
	else
	{
	
	$up_reminder_days = $this->input->post('up_reminder_days');
	$up_warrassetmancat = $this->input->post('up_warrassetmancat');
	$up_warrassetmentsubcat = $this->input->post('up_warrassetmentsubcat');

	$data = array(
	'Reminderdays'=>$up_reminder_days,
	'AssetCat'=>$up_warrassetmancat,
	'AssetSubCat'=>$up_warrassetmentsubcat,
	'ModifyBy'=>$this->session->userdata('userid'),
	'ModifyDate'=>date('Y-m-d'),
	);


	$where = array(
	'AutoID'=>$updateid,
	);


	$resultId = $this->Commonmodel->common_update('RemindersettingMST',$where,$data);
	if($resultId){
	echo json_encode(array('status' => 1));
	}else{
	echo json_encode(array('status' => 0));
	}

	}

	}
	

	

	

	public function delete_remindersetting(){
		$id = $this->input->post('id');
		$data = array(
		'IsDelete'=>1,
		'DeleteBy'=>$this->session->userdata('userid'),
		'DeleteDate'=>date('Y-m-d')	
		);
		$where = array(
		'AutoID'=>$id,
		);

		$resultId = $this->Commonmodel->common_update('RemindersettingMST',$where,$data);
		echo TRUE;
	}

	public function getonereminderseeting(){
		$id = $this->input->post('id');
		$result = $this->Assetmodel->getonRemindersetting($id);
		
		$response = array(
			"remindardays" => $result->Reminderdays,
			"AssetCat" => $result->AssetCat,
			"AssetSubCat" => $result->AssetSubCat,
			"id" => $result->AutoID
		 );
	
		 echo json_encode( array("status" => 1,"data" => $response) );
		
	  }
	  public function excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'NAME', 'SHORT NAME');
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$data = $this->Assetmodel->getuom();
		//  echo '<pre>';
        // print_r($data);
        // echo '</pre>';
		//  die();
		

		$serialNo = 1; // Initialize serial number
		foreach ($data as &$subArray) {
	
			unset($subArray['AutoID']);
			$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
			$serialNo++;
		}
		
	
		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');
	
		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:C1');
		$headerStyle->getFont()->setBold(true);
		
	
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Measurment.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	public function Assettype_excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'ASSET TYPE');
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$data = $this->Assetmodel->getassettype();
		//  echo '<pre>';
        // print_r($data);
        // echo '</pre>';
		//  die();
		

		$serialNo = 1; // Initialize serial number
		foreach ($data as &$subArray) {
	
			unset($subArray['AutoID']);
			$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
			$serialNo++;
		}
		
	
		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');
	
		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:B1');
		$headerStyle->getFont()->setBold(true);
		
	
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Assettype.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	public function Assetcat_excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'ASSET TYPE','ASEET CATEGORY');
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$data = $this->Assetmodel->getassetcat();
		//  echo '<pre>';
        // print_r($data);
        // echo '</pre>';
		//  die();
		
 
		$serialNo = 1; // Initialize serial number
		foreach ($data as &$subArray) {
	
			unset($subArray['AutoID']);
			$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
			$serialNo++;
		}
		
	
		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');
	
		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:C1');
		$headerStyle->getFont()->setBold(true);
		
	
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Assetcat.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	public function Assetsubcat_excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'ASSET CATEGORY','ASEET SUB CATEGORY','INTERVAL(MONTH)','AUDITOR','NO OF IMAGE','TITLE','DEPRECIATION RATE(%)');
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$data = $this->Assetmodel->getassetsubcat();
		 echo '<pre>';
        print_r($data);
        echo '</pre>';
		 die();
		
 
		$serialNo = 1; // Initialize serial number
		foreach ($data as &$subArray) {
	
			unset($subArray['AutoID']);
			$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
			$serialNo++;
		}
		
	
		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');
	
		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:H1');
		$headerStyle->getFont()->setBold(true);
		
	
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'Assetsubcat.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	public function Warrantytype_excel_export() {
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
	
		// Define the header row data
		$headerData = array('S.NO', 'WARRANTY TYPE',);
	
		// Apply header data to the worksheet
		$worksheet->fromArray([$headerData], null, 'A1');
	
		// Get the dynamic data
		$data = $this->Assetmodel->getwarantytype();
		//  echo '<pre>';
        // print_r($data);
        // echo '</pre>';
		//  die();
		
 
		$serialNo = 1; // Initialize serial number
		foreach ($data as &$subArray) {
	
			unset($subArray['AutoID']);
			$subArray = ['S.no' => $serialNo] + $subArray; // Move 'S.no' to the beginning
			$serialNo++;
		}
		
	
		// Populate the spreadsheet with dynamic data (starting from row 2)
		$worksheet->fromArray($data, null, 'A2');
	
		// Apply style to header row (green color and bold)
		$headerStyle = $worksheet->getStyle('A1:B1');
		$headerStyle->getFont()->setBold(true);
		
	
		// Create a writer and save the spreadsheet
		$writer = new Xlsx($spreadsheet);
		$filename = 'warrantytype.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
 
  
}