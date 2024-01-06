<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
	  	// Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
		$this->load->library('form_validation');
		$this->load->model('Registermodel');
		$this->load->model('Commonmodel');
		$this->load->library('phpmailer_lib');
		$this->load->model('Planmodel');	
		$this->load->library('upload');
	}
	public function index()
	{
		$data['page_title'] = 'Register';
		$this->load->view('header',$data);
		$data['city'] = $this->Commonmodel->getCiti();
		$planid = $this->uri->segment(3);
		$data['plan'] = $this->Planmodel->getsingleplan($planid);
        $this->load->view('register',$data);
        $this->load->view('footer');
     
	}
	public function saveRegister(){

		$company_name = $this->input->post('company_name');
		$address= $this->input->post('address');
		$city = $this->input->post('cityid');
		$state = $this->input->post('stateid');
		$pincode = $this->input->post('pincode');
		$country = $this->input->post('countryid');
		$pan = $this->input->post('pan');
		$tax_id = $this->input->post('tax_id');
		$gst_no = $this->input->post('gst_no');
        $contactperson_name = $this->input->post('contactperson_name');
		$contact_emailid = $this->input->post('contact_emailid');
		$office_phone_no = $this->input->post('office_phone_no');
		$contactperson_mobileno = $this->input->post('contactperson_mobileno');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$planid= $this->input->post('planid');
		$planname= $this->input->post('planname');
		$planprice= $this->input->post('planprice');


		

		$companycode_data = $this->Registermodel->last_companycode();
		$CompanyCode = $companycode_data->CompanyCode;

		

		$words = explode(" ", $company_name);
		$acronym = "";
		foreach ($words as $w) {
		 $acronym .= $w[0];
		}
		$com = strtoupper($acronym);
		if(!empty($CompanyCode)){
			$numbers = preg_replace('/[^0-9]/', '', $CompanyCode);
			$n2 = str_pad($numbers + 1,3, 0, STR_PAD_LEFT);
			$companycode = 	$com.$n2; 
		}else{
			$companycode = $com."001";
		}
				
		$database = $companycode;
		$datauser = $companycode;
		$datapass = $com.date('y-m-d');

		

		$this->form_validation->set_rules('contact_emailid', 'Email', 'required|trim|valid_email|is_unique[RegisterMST.Email]');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[RegisterMST.UserName]');
		$this->form_validation->set_rules('contactperson_mobileno', 'Mobile No', 'required|is_unique[RegisterMST.ContactPersonMobile]');
		
		

		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors(); 
			$url = base_url()."Register/index/missing";
			echo $url;
		}
		else
		{

			

			if (!empty($_FILES['logo']['name'])) {
			
				$config['upload_path']   = './upload/profile/'; 
				$config['allowed_types'] = 'jpg|png'; 
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
						
				
				if (!$this->upload->do_upload('logo')) {
				 $error = array('error' => $this->upload->display_errors()); 
				}
				else { 
					$file_details = array('upload_data' => $this->upload->data()); 
					foreach($file_details as $f){
						$filename = $f['file_name']; 				
					}
				}	

			
			}
			$data = array(
				'CompanyName'=>$company_name,
				'ProfileIMG'=>$filename,
				'Address'=>$address,
				'City'=>$city,
				'State'=>$state,
				'Pincode'=>$pincode,
				'Country'=>$country,
				'GstNo'=>$gst_no,
				'Email'=>$contact_emailid,
				'ContactPersonName'=>$contactperson_name,
				'OfficePhoneNumber'=>$office_phone_no,
				'ContactPersonMobile'=>$contactperson_mobileno,
				'UserName'=>$username,
				'Password'=>password_hash($password,PASSWORD_DEFAULT),
				'isApprove'=>0,
				'isActive'=>0,
				'PlanId'=>$planid,
				'CompanyCode'=>$companycode,
				'DatabaseName'=>$database,
				'DatabaseUser'=>$datauser,
				'DatabasePass'=>$datapass,
				'UserRole'=>2,
				'CreatedDate'=>date('Y-m-d'),
				'CreatedBy'=>1
				);
			$registerId = $this->Registermodel->saveRegister($data);
			if($registerId){

			$mail = $this->phpmailer_lib->load();
			$from = 'testing@dahlia.tech';
			//$to = 'kvanan2429@gmail.com';

            // SMTP configuration
           $mail->isSMTP();
		   //$mail->isSendmail();
		   $mail->Host     = 'smtp.office365.com';
		   $mail->SMTPAuth = true;
		   $mail->Username = 'testing@dahlia.tech';
		   $mail->Password = 'Vur14262';
		   $mail->SMTPSecure = 'tls';
		   $mail->Port     = 587;


			$maildetails = array(
				"0" => array('email'=>$contact_emailid,'message'=>"Welcome Message from Dahlia",'template'=> "mailtemplate_user"),
				"1" => array('email'=>'kvanan2429@gmail.com','message'=>"New subscription Details",'template'=>"mailtemplate_admin")
			);

            $mail->setFrom($from);

			$data['customername'] = $contactperson_name;
            $data['planname'] = $planname;
			$data['amount'] = $planprice;
			$data['customeremail'] = $contact_emailid;


			foreach($maildetails as $email){

				// Add a recipient
				$mail->addAddress($email['email']);
				// Email subject
				$mail->Subject = $email['message'];
				// Set email format to HTML
				$mail->isHTML(true);
				// Email body content
				$mailContent = $this->load->view($email['template'],$data,TRUE);
				$mail->Body = $mailContent;
				$mail->send();

				// Send email
				if(!$mail->send()){
					echo $mail->ErrorInfo;
				}else{
					$message = "Mail send successfully";
				}

			}
           
			$url = base_url()."Register/succees";
			echo $url;
          
			}else{
			     $url = base_url()."Register/index/dberror";
				echo $url;
			}
		}
	}
	public function succees(){

		$this->load->view('header');
		$this->load->view('success');
		$this->load->view('footer');
		
	}
}
