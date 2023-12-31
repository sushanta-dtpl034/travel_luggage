<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';

use Com\Tecnick\Barcode\Barcode;

class Qrcode extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
		if (!isset($username) && !isset($userid)) { 
		redirect('Login');
		} 
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->helper('referenceno_helper');
		$this->load->helper('quarters_helper');

		$this->load->model('Qrcodemodel');
		$this->load->model('Assetmodel');
		$this->load->model('Companymodel');

		$this->load->model('Commonmodel');
	}
    function index(){
        $data['page_title'] = 'QR Code List';
		$data['page_name'] = "List of QR Code";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('parentid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$data['qrcode'] = $this->Qrcodemodel->get_qrcode_data();
	
		$this->load->view('superadmin/qrcode_list',$data);
		$this->load->view('include/admin-footer');
    }
	public function getactiveqrcodes(){
		$data['data'] = $this->Qrcodemodel->get_qrcode_data();
		echo  json_encode($data);
	}

	function qrcode_save(){
		$this->load->library('myLibrary');
		if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		}else{
			$parent_id = $this->session->userdata('userid');
		}


		$company_id= $this->input->post('company_id');
		$company_code=string_ucword($this->input->post('company_code'));
		$noof_qrcode= $this->input->post('noof_qrcode');
		
		$insert_data=[
			'CompanyID'		=>$company_id,
			'ShortCode'		=>$company_code,
			'NoofQRCode'	=>$noof_qrcode,
			'CreatedBy'		=>$this->session->userdata('userid'),
			'CreatedDate'	=>date('Y-m-d H:i:s'),
			'IsDelete'		=>0
		];
	
		$last_insert_id=$this->Qrcodemodel->qrcode_head_save($insert_data);
		if($last_insert_id){
			if(intval($noof_qrcode) > 0){
				//check previous month in assetMst table
				$prev_create_date_row=$this->Commonmodel->getlast_row($parent_id,$company_id);
				$prv_year_month=date('Ym', strtotime($prev_create_date_row));
				$current_year_month= date('Ym');
				if($prv_year_month == $current_year_month){
					//for existing month
					$prv_month=date('m', strtotime($prev_create_date_row));
					$prv_year=date('Y', strtotime($prev_create_date_row));
					$old_sequence_no_assets= $this->Commonmodel->last_companycode($parent_id,$company_id,$prv_month,$prv_year);
					$prev_sequence_no =get_previous_qrcode_sequence($last_insert_id,$company_id,$current_year_month);
					$total_sequence_no =$old_sequence_no_assets + $prev_sequence_no;
					
					for($i=1; $i <= intval($noof_qrcode); $i++ ){
						$refno=$total_sequence_no+$i; 
						$details_data=[
							'QRCodeId'		=>$last_insert_id,
							'QRCodeText'	=>create_refno($refno,$company_code),
							'QRCodeImage'	=>create_refno($refno,$company_code).'.png',
							'IsUsed'		=>0
						];
						$this->Qrcodemodel->qrcode_details_save($details_data);
						$this->mylibrary->generate(create_refno($refno,$company_code));
					}

				}else{
					$prev_sequence_no =get_previous_qrcode_sequence($last_insert_id,$company_id,$current_year_month);
					for($i=1; $i <= intval($noof_qrcode); $i++ ){
						$refno=$prev_sequence_no+$i; 
						$details_data=[
							'QRCodeId'		=>$last_insert_id,
							'QRCodeText'	=>create_refno($refno,$company_code),
							'QRCodeImage'	=>create_refno($refno,$company_code).'.png',
							'IsUsed'		=>0
						];
						$this->Qrcodemodel->qrcode_details_save($details_data);
						$this->mylibrary->generate(create_refno($refno,$company_code));
					}
		
				}

				echo json_encode(array('status' => 1));
			}else{
				echo json_encode(array('status' => 0));
			}
		}
		
	}
	public function get_qrcode_details($id){
		$data['company_name'] = $this->Qrcodemodel->get_qrcode_companyDetails($id);
		$data['qrcode_data'] = $this->Qrcodemodel->get_qrcode_details($id);		

		$data['page_title'] = 'QR Code Details';
		$data['page_name'] = "List of QR Code";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$parentid = $this->session->userdata('parentid');
		if($this->session->userdata('GroupID')!='1'){
			$parentid = $this->session->userdata('parentid');
		}
		$data['company'] = $this->Companymodel->getcompany($parentid);
		$data['qrcode'] = $this->Qrcodemodel->get_qrcode_data();
	
		$this->load->view('superadmin/qrcode_detail_view',$data);
		$this->load->view('include/admin-footer');

	}
	function print_qrcode(){
		$noof_copy =$this->input->post('noof_copy');
		//$qrcode_ids =implode(',',$this->input->post('qrcode_ids'));
		$qrcode_ids =$this->input->post('qrcode_ids');
		if(!empty($noof_copy) && !empty($qrcode_ids)){
			$qrcodes_data = $this->Qrcodemodel->get_qrcode_details_ids($qrcode_ids);
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
			'margin_left' =>3, 
			'margin_right' =>-1,
			'margin_top' => 3, 
			'margin_bottom' => -9, 
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
										<img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->QRCodeImage).'" style="height:300px;width:300px;" >
									</td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$qrcodes_data[$i]->CompanyName.'</b></p>		
									</td>
								</tr>
								
							</table>
						</td>
						<td>
							<table style="width:100%; display:none;">
								<tr style="display:none;">
									<td width="30%"></td>
									<td width="60%">
										<p style="font-size:35px; color:white"><b>'.$qrcodes_data[$i]->QRCodeText.'</b></p>
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
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->QRCodeImage).'" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:22px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
									<br>
									<p style="font-size:20px;letter-spacing:2px"><b>'.$qrcodes_data[$i]->CompanyName.'</b></p>	
								</td>
							</tr>
						</table>
					</td>';
					}
				}else{
					$inner_html.='<td>
						<table style="width:100%">
							<tr>
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->QRCodeImage).'" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:22px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
									<br>
									<p style="font-size:20px;letter-spacing:2px"><b>'.$qrcodes_data[$i]->CompanyName.'</b></p>	
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
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table style="width:100%">
								<tr>
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
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
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table style="width:100%">
								<tr>
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
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

	function single_print_qrcode(){		
		$noof_copy =$this->input->post('noof_copy');
		$qrcode_ids =$this->input->post('qrcode_id');
		if(!empty($noof_copy) && !empty($qrcode_ids)){
			$qrcodes_data = $this->Qrcodemodel->get_qrcode_details_ids($qrcode_ids);
			$this->single_qrcode_pdf_generate($noof_copy,$qrcodes_data );
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
			'margin_left' =>3, 
			'margin_right' =>-1,
			'margin_top' => 3, 
			'margin_bottom' => -9, 
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
											<img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->QRCodeImage).'" style="height:300px;width:300px;" >
										</td>
										<td width="60%">
											<p style="font-size:22px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
											<br>
											<p style="font-size:20px;letter-spacing:2px"><b>'.$qrcodes_data[$i]->CompanyName.'</b></p>	
										</td>
									</tr>
									
								</table>
							</td>
							<td>
								<table style="width:100%; display:none;">
									<tr style="display:none;">
										<td width="30%"></td>
										<td width="60%">
											<p style="font-size:35px; color:white"><b>'.$qrcodes_data[$i]->QRCodeText.'</b></p>
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
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$qrcodes_data[$i]->CompanyName.'</b></p>	
									</td>
								</tr>
							</table>
						</td>';
					}
				}else{
					$inner_html.='<td>
						<table style="width:100%">
							<tr>
								<td width="30%"><img src="'.base_url('upload/qr-code/'.$qrcodes_data[$i]->QRCodeImage).'" style="height:300px;width:300px;" ></td>
								<td width="60%">
									<p style="font-size:22px;letter-spacing:3px"><b>'.$qrcodes_data[$i]->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
									<br>
									<p style="font-size:20px;letter-spacing:2px"><b>'.$qrcodes_data[$i]->CompanyName.'</b></p>		
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
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table style="width:100%">
								<tr>
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
									</td>
								</tr>
							</table>
						</td>			
					</tr>';
			}
		}else{
			foreach($qrcodes_data as $data){
				for($i=0; $i < $noof_copy/2; $i++){
					$inner_html.='
					<tr >
						<td>
							<table style="width:100%">
								<tr>
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table style="width:100%">
								<tr>
									<td width="30%"><img src="'.base_url('upload/qr-code/'.$data->QRCodeImage).'" style="height:300px;width:300px;" ></td>
									<td width="60%">
										<p style="font-size:22px;letter-spacing:3px"><b>'.$data->QRCodeText.'</b><span style="font-size:45px;margin-right:10px;padding:0px;font-weight:900"><b><sup>&bull;</sup></b></span></p>
										<br>
										<p style="font-size:20px;letter-spacing:2px"><b>'.$data->CompanyName.'</b></p>	
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





	function updateqrcode(){		
		$this->load->library('myLibrary');
		$id= $this->input->post('id');
		$company_id= $this->input->post('company_id');
		$company_code=string_ucword($this->input->post('company_code'));
		$noof_qrcode= $this->input->post('noof_qrcode');
		
		$insert_data=[
			'AutoID'		=>$id,
			'CompanyID'		=>$company_id,
			'ShortCode'		=>$company_code,
			'NoofQRCode'	=>$noof_qrcode,
			'ModifyBy'		=>$this->session->userdata('userid'),
			'ModifyDate'	=>date('Y-m-d H:i:s'),
			'IsDelete'		=>0
		];
		//$response=$this->Qrcodemodel->qrcode_head_update($insert_data);
		// if($response){

		// }
		print_r($insert_data);
	}



	/** TESTING SECTION */
	function qrcode_generate_testing(){	
		if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		}else{
			$parent_id = $this->session->userdata('userid');
		}

		$current_year_month= date('Ym');
		$company_id=2;
		//check previous month
		$prev_create_date_row=$this->Commonmodel->getlast_row($parent_id,$company_id);
		$prv_year_month=date('Ym', strtotime($prev_create_date_row));

		if($prv_year_month == $current_year_month){
			//for existing month
			$prv_month=date('m', strtotime($prev_create_date_row));
			$prv_year=date('Y', strtotime($prev_create_date_row));
			$old_sequence_no_assets= $this->Commonmodel->last_companycode($parent_id,$company_id,$prv_month,$prv_year);
			$prev_sequence_no =get_previous_qrcode_sequence($company_id,$current_year_month);
			$total_sequence_no =$old_sequence_no_assets + $prev_sequence_no;

			for($i=1; $i <=5; $i++ ){
				$refno=create_refno($total_sequence_no+$i,'DAH');
				echo $refno."\n";
			}
		}else{
			$prev_sequence_no =get_previous_qrcode_sequence($company_id,$current_year_month);
			for($i=1; $i <=5; $i++ ){
				$refno=create_refno($prev_sequence_no+$i,'DAH');
				echo $refno."\n";
			}

		}
		
		$prev_sequence_no =get_previous_qrcode_sequence($company_id,$current_year_month);
		for($i=1; $i <=5; $i++ ){
			$refno=create_refno($prev_sequence_no+$i,'DAH');
			echo $refno."\n";
		}
		
		
		$assetowner_id=3;
		$CompanyName='Dahlia Technology';
		$companyShortCode = strtoupper(substr($CompanyName,0,3));
		if($this->session->userdata('GroupID')!='1'){
			$parent_id = $this->session->userdata('parentid');
		}else{
			$parent_id = $this->session->userdata('userid');
		}
		$prev_create_date_row=$this->Commonmodel->getlast_row($parent_id,$assetowner_id);
		//2022-06-30
		$prv_year_month=date('Ym', strtotime($prev_create_date_row));
    	$current_year_month=date('Ym');
		if($prv_year_month !== $current_year_month){
			//for existing month
			$prv_month=date('m', strtotime($prev_create_date_row));
			$prv_year=date('Y', strtotime($prev_create_date_row));
	
			$oldshortcode= $this->Commonmodel->last_companycode($parent_id,$assetowner_id,$prv_month,$prv_year);
			$refno=create_refno($oldshortcode+1,$companyShortCode);
	
		}else{
			//for new month
			$refno=create_refno(1,$companyShortCode);
		}
	}
	function mpdftest(){
		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

			
		$mpdf = new \Mpdf\Mpdf([
		'tempDir' => __DIR__ . '/../tmp',
		'mode' => 'utf-8',
		'format' => [500, 90],  
		'orientation' => 'P',
		'margin_left' =>24, 
		'margin_right' => -34,
		'margin_top' => 3, 
		'margin_bottom' => -19, 
		'margin_header' => 0, 
		'margin_footer' => 0, 
		'fontDir' => array_merge($fontDirs, [
			__DIR__ . '/custom/font/directory',
		]),
		'fontdata' => $fontData + [
			'OpenSans' => [
				'R' => 'Roboto-Regular.ttf',
				'I' => 'Roboto-Regular.ttf',
			]
		],
			
		'default_font' => 'OpenSans',
		'mode' => 'c' 
		]);

		$mpdf->autoLangToFont = true;
		$mpdf->AddPage();
		$mpdf->showImageErrors = true;

		
		$html = $this->load->view('html_to_pdf_qrcode',[],true);
		$mpdf->WriteHTML($html);
		$mpdf->Output(); // opens in browser
		//$mpdf->Output('arjun.pdf','D');
	}
	function qrcodetest(){
		$this->load->library('myLibrary');
		$this->mylibrary->generate('sushanta');
	}



}