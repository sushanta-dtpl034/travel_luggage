<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	public function __construct(){
	  	parent::__construct();
	  	// Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");

	  	$username = $this->session->userdata('username');
	  	$userid = $this->session->userdata('userid');
	  /*
		if (!isset($username) && !isset($userid)) { 
			redirect('Login');
		} 
		else { 
			redirect('Invoice');
		} */
      $this->load->library('form_validation');
	  $this->load->model('Loginmodel');
	  $this->load->model('Mastermodel');
	  $this->load->library('phpmailer_lib');
	  $this->load->helper("Common");
	}
	public function index(){
		$page_data['page_title'] = 'Login';
		$page_data['page_name'] = "Signin to Your Account";
		$this->load->view('header',$page_data);
        $this->load->view('login',$page_data);
        $this->load->view('footer');
	}
	public function forgot(){
		$page_data['page_title'] = 'Forgot Password';
		$this->load->view('header',$page_data);
        $this->load->view('forgot');
        $this->load->view('footer');
	}
	public function sendResetlink(){
		$email = $this->input->post('email');
		$validate=$this->Loginmodel->validateUserforpasswordreset($email);
		if(is_array($validate)){
			foreach( $validate['result'] as $res_reset){
                $userautoid = $res_reset['AutoID'];
				
			}
			$parentid = $res_reset['AutoID'];
			if($res_reset['GroupID']!='1'){
				$parentid = $res_reset['ParentID'];
			}
			$logodata = $this->Mastermodel->getsystemsetting($parentid);
			if($logodata){
				$fromaddress = $logodata->RecieveEmailAddress;
				$Username = $logodata->EmailID;
				$Password = $logodata->EmaillPassword;
				$Port = $logodata->EmailPort;
				$Host = $logodata->EmailHost;
				$fromname = $logodata->EmailAddressName;
			}
			

			if($validate['num_rows']>0){
				$mail = $this->phpmailer_lib->load();
				$fromaddress = $fromaddress;
				//$to = 'kvanan2429@gmail.com';
				// SMTP configuration
				$mail->isSMTP();
				//$mail->isSendmail();
				$mail->Host     = $Host;
				$mail->SMTPAuth = true;
				$mail->Username = $Username;
				$mail->Password = $Password;
				$mail->SMTPSecure = 'tls';
				$mail->Port     = $Port;
				$mail->setFrom($fromaddress,$fromname);
				// Add a recipient
				//$email = 'kalaivanan.s@dahlia.tech';
				$mail->addAddress($email);
				// Email subject
				$mail->Subject ="Password Reset";
				// Set email format to HTML
				$mail->isHTML(true);
				// Email message
				// $key = 'dtpl';
				// $iv = openssl_random_pseudo_bytes(16);
				// $encrypteduser = openssl_encrypt($userautoid, 'aes-256-cbc', $key, 0, $iv);
				$reset_link = base_url()."Resetpassword?token=".$userautoid;
				$message = "<!DOCTYPE html>
				<html>
					<head>
					   <title>Password Reset</title>
					</head>
					<body>
					<p>Hello,</p>
					<p>We received a request to reset your password. To proceed, click the link below:</p>
					<a href=\"$reset_link\">Reset Password</a>
					<p>If you did not request a password reset, you can ignore this email.</p>
					<p>Thank you</p>
					</body>
				</html>
				";
				$mail->Body = $message;
				// Send email
				if(!$mail->send()){
				    $mail->ErrorInfo;
				}else{
					$response = array("status"=>1);
					echo json_encode($response);
				}
				
				// $mail->clear();
	
			}else{
				$response = array("status"=>2);
				echo json_encode($response);
			}
		}
	}
	public function reset(){
		$this->load->view('header');
        $this->load->view('reset');
        $this->load->view('footer');
	}
	public function validateOTP(){
	    $otp = $this->input->post('otp');
	    $oldOTP = $this->session->userdata('otp');
		if($otp==$oldOTP){
			echo 1;
			$this->session->set_userdata('emailStatus','Verified');
			return true;
		}else{
         	return false;
		}
	}
	
	public function validateUser(){
		$username = $this->input->post('username');
		$password = $this->input->post('passwoord');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('passwoord', 'Password', 'required');
		if($this->form_validation->run() == FALSE){
			$status=200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode("error"));
		}else{
			$result = $this->Loginmodel->validateUser($username);
			if($result){
				if(password_verify($password,$result->Password)){  // Authentication successful - redirect or proceed to the authenticated area
					$this->session->set_userdata('userid',$result->AutoID);
					$this->session->set_userdata('username',$result->UserName);
					$this->session->set_userdata('userisadmin',$result->IsAdmin);
					$this->session->set_userdata('name',$result->Name);
					$this->session->set_userdata('profile',$result->ProfileIMG);
					$this->session->set_userdata('mobile',$result->Mobile);
					$this->session->set_userdata('Suffix',$result->Suffix);
					$this->session->set_userdata('userdata',$result);
					
					/*logo setting*/
					if($result->IsAdmin == 1){
						$logodata = $this->Mastermodel->getsystemsetting($result->AutoID);
						if($logodata){
							$this->session->set_userdata('height',$logodata->Height);
							$this->session->set_userdata('width',$logodata->Width);
							$this->session->set_userdata('logo',$logodata->Logoname);
						}else{
							$this->session->set_userdata('height',80);
							$this->session->set_userdata('width',80);
							$this->session->set_userdata('logo','assets/img/logo3.png');
						}
					}
					$status=200;
						$this->output
						->set_status_header($status)
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode(["status" => 200, "isadmin" =>$result->IsAdmin]));
				
					
				}else{  // Authentication failed - display an error message
					$status=200;
					$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(["status" => 500, "error" =>"Incorrect username or password. Please try again."]));
				}
			}else{  // Authentication failed - display an error message
				$status=200;
				$this->output
				->set_status_header($status)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode(["status" => 500, "error" =>"Incorrect username or password. Please try again."]));
			}
		}

	}
	public function resetPassword(){
		$password = $this->input->post('password');
		$hashed_password = password_hash($password,PASSWORD_DEFAULT);
		$email = $this->session->userdata('email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() == FALSE){
			echo "password is empty";
		}else{
			$data = array(
				'Password'=>$hashed_password,
			);
			$res = $this->Loginmodel->UpdatePassword($email,$data);
			if($res){
			  $this->session->sess_destroy();
			   redirect('Login');
			}else{
				echo "Database error";
			}
		}


	}
	public function logout(){
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
                $this->session->unset_userdata($key);
        }
       $this->session->sess_destroy();
	   $url = base_url();
	   redirect($url);
	}
	function otpsent(){
		$mobile =$this->input->post('mobile');
		if(!empty($mobile) ){
			//save otp and previous otp delete and send otp
			//check mobile no
			$resend = 0;
			$response=$this->Loginmodel->validateUserMobile($mobile);
			if($response){
				//after validate send otp and save
				$random_number=698698;//rand(100000,999999);
				$res = send_otp($mobile,$resend,$random_number);
				if($res){
					$userdata['message'] = "OTP Sent!";
					$userdata['message'] = "OTP Sent!";
					$userdata['status'] = "succcess";
					echo json_encode($userdata);	
				}
			}else{
				$userdata['message'] = "User not found";
				$userdata['status'] = "failure";
				echo json_encode($userdata);
			}
		}else{
			$userdata['message'] = "Mobile No Required";
			$userdata['status'] = "failure";
			echo json_encode($userdat);
		}

	}
	public function CheckOTP() {
        $otp=$this->input->post('otp');
		$mobile=$this->input->post('mobile');
		$result=$this->Loginmodel->CheckOTP($mobile,$otp);
		if($result){
			$result = $this->Loginmodel->validateUser($mobile);
			$this->session->set_userdata('userid',$result->AutoID);
			$this->session->set_userdata('username',$result->UserName);
			$this->session->set_userdata('userisadmin',$result->IsAdmin);
			$this->session->set_userdata('name',$result->Name);
			$this->session->set_userdata('profile',$result->ProfileIMG);
			$this->session->set_userdata('mobile',$result->Mobile);
			$this->session->set_userdata('Suffix',$result->Suffix);
			$this->session->set_userdata('userdata',$result);

			/*logo setting*/
			if($result->IsAdmin == 1){
				$logodata = $this->Mastermodel->getsystemsetting($result->AutoID);
				if($logodata){
					$this->session->set_userdata('height',$logodata->Height);
					$this->session->set_userdata('width',$logodata->Width);
					$this->session->set_userdata('logo',$logodata->Logoname);
				}else{
					$this->session->set_userdata('height',80);
					$this->session->set_userdata('width',80);
					$this->session->set_userdata('logo','assets/img/logo3.png');
				}
			}
			$redirect_url = $this->session->userdata('redirect_url') ?? base_url('Dashboard/superadmin_dasboard');
			$status=200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(["status" => 200, "isadmin" =>$result->IsAdmin,"return_url"=>$redirect_url]));
			
		}else{
			$status=200;
			$this->output
			->set_status_header($status)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(["status" => 500, "error" =>"Incorrect username or password. Please try again."]));
		}
	}
	
	function getuser($id=""){
		if(!empty($id)){
			$resultData = $this->db->query("select * from RegisterMST WHERE AutoID=$id")->result();
		}else{
			$resultData = $this->db->query("select * from RegisterMST")->result();
		}
		echo "<pre>";
		print_r($resultData);exit; 
	}
}
