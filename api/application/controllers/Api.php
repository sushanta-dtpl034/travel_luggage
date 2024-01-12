<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->database();
	    $this->tokenHandler = new TokenHandler();
		$this->load->model('api_model');
		$this->load->library(array('form_validation', 'Authtoken'));
		$this->load->model('Commonmodel');
		$this->load->model('Login_model');
		header('Content-Type: application/json');
		
	}
	public function test_get()
	{
		$status = 200;
		$response = array("message"=>"this is a post api");
		print_r($response);
	}
	//Send the OTP to user using this API. Parameter: LoginID . Value: Mobile/Email
	public function login_post() {
		$data=$this->request->body;
		//Password Login
		if($data['type'] == 1){
			$this->form_validation->set_data($data);
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
				return $this->set_response(["status"=>406,"errors"=>$errors], 406);                
			}else{
				$username=$data['username'];
				$password=$data['password'];
				$result = $this->Login_model->validateUser($username);
				if($result){
					if(password_verify($password,$result['Password'])){
						$token['AutoID']	=$result['AutoID'];
						$token['Email']		=$result['Email'];
						$token['IsAdmin']	=$result['IsAdmin'];

						$userdata['token'] 	= $this->tokenHandler->GenerateToken($token);
						$userdata['AutoID']	=$result['AutoID'];
						$userdata['Suffix']	=$result['Suffix'];
						$userdata['Name']	=$result['Name'];
						$userdata['CountryCode']=$result['CountryCode'];
						$userdata['Mobile']	=$result['Mobile'];
						$userdata['Email']	=$result['Email'];
						$userdata['Address']=$result['Address'];
						$userdata['AdressTwo']=$result['AdressTwo'];
						$userdata['ProfileIMG']='upload/profile/'.$result['ProfileIMG'];
						$userdata['IsAdmin']=$result['IsAdmin'];
						$userdata['message'] = "User authenticated successfully";
						$userdata['status']=200;
						return $this->set_response($userdata, REST_Controller::HTTP_OK);						
					}else{
						return $this->set_response(["status"=>401,"errors"=>"Username or Password are Wrong. Try Again. "], 401);
					}
				}else{
					return $this->set_response(["status"=>401,"errors"=>"Username or Password are Wrong. Try Again. "], 401);
				}
			}
		}
		//Otp Login
		if($data['type'] == 2){
			$this->form_validation->set_data($data);
			$this->form_validation->set_rules('mobile', 'Mobile No', 'required|trim');
			$this->form_validation->set_rules('countrycode', 'Country Code', 'required|trim');
			$this->form_validation->set_rules('resend', 'Resend', 'required|trim');
			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
				return $this->set_response(["status"=>406,"errors"=>$errors], 406);                
			}else{
				$mobile=$data['mobile'];
				$resend=$data['resend'];
				$countrycode=$data['countrycode'];
				$response=$this->Login_model->validateUserMobile($mobile);
				if($response){
					//after validate send otp and save
					$random_number=rand(100000,999999);
					//$random_number='898989';
					$mobilenowithcountrycode = $countrycode.$mobile;
					
					$res =send_otp($mobilenowithcountrycode,$resend,$random_number);
					if($res){
						//$userdata['otp']=$random_number;
						$userdata['message']="OTP Sent!";
						return $this->set_response(["status"=>200,"message"=>"OTP Sent!"], REST_Controller::HTTP_OK);	
					}
			
				}else{
					return $this->set_response(["status"=>401,"errors"=>"User not found."], 401);
				}
			}			
		}
	}
	
	public function CheckOTP_post() {
        $data=$this->request->body;
        $otp=$data['otp'];
		$mobile=$data['mobile'];
		$mnowithcountrycode=$data['countrycode'].$mobile;
		$isOtpVerified=$this->Login_model->CheckOTP($mnowithcountrycode,$otp);
		if($isOtpVerified){
			$result = $this->Login_model->validateUserMobile($mobile);
			if($result){
				$token['AutoID']=$result['AutoID'];
				$token['Email']=$result['Email'];
				$token['IsAdmin']=$result['IsAdmin'];
	
				$userdata['token'] = $this->tokenHandler->GenerateToken($token);
				$userdata['AutoID']	=$result['AutoID'];
				$userdata['Suffix']	=$result['Suffix'];
				$userdata['Name']	=$result['Name'];
				$userdata['CountryCode']=$result['CountryCode'];
				$userdata['Mobile']	=$result['Mobile'];
				$userdata['Email']	=$result['Email'];
				$userdata['Address']=$result['Address'];
				$userdata['AdressTwo']=$result['AdressTwo'];
				$userdata['ProfileIMG']='upload/profile/'.$result['ProfileIMG'];
				$userdata['IsAdmin']=$result['IsAdmin'];
				$userdata['message'] = "User authenticated successfully";
				$userdata['status']=200;
				return $this->set_response($userdata, REST_Controller::HTTP_OK);
			}else{
				return $this->set_response(["status"=>401,"errors"=>"Authentication Error!."], 401);
			}
			
		}else{
			return $this->set_response(["status"=>401,"errors"=>"Authentication Error!."], 401);
		}
	}

	public function ViewProfile_post()
	{
		$headers = apache_request_headers();

		if (!empty($headers['Token'])) {
		
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$userid=$arrdata['AutoID'];

					$user = $this->Login_model->getuserdata_byid($userid);
					if ($user) {
							$result['userdata'] = $user;
							$result['message'] = "success";
					        $result['status']=true;
					   		return $this->set_response($result, REST_Controller::HTTP_OK);
					}
					else{
					$userdata['message'] = "User not found";
				$userdata['status']=false;
				return $this->set_response($userdata, 401);
					}
				} catch (\Exception $e) 
					{ 
	   					 $result['message'] = "Invalid Token";
						$result['status']=false;
						return $this->set_response($result, 401);
					}
		}
		else{
			$result['message'] = "Token or oldpasswor / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}
		
	}

	public function profileupdate_post(){
		$headers = apache_request_headers();
		$input_data=$this->input->post();
		if (!empty($headers['Token'])) {
			try {
				$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
				$userid=$arrdata['AutoID'];

				$picture = '';
				if(!empty($_FILES['ProfileIMG']['name'])){
					if (!file_exists('../upload/profile')) {
						mkdir('../upload/profile', 0777, true);
					}
					
					$config['upload_path']   = '../upload/profile/'; 
					$config['allowed_types'] = 'jpg|png|jpeg'; 
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('ProfileIMG')){
						$uploadData = $this->upload->data();
						$picture ="upload/profile/".$uploadData['file_name'];
					}else{ 
						$picture = '';  
					}
				}

				if(!empty($input_data['OldProfileIMG'])){
					if (file_exists('../'.$input_data['OldProfileIMG'])){
						if (unlink('../'.$input_data['OldProfileIMG'])) {   
						}   
					} 
				} 

				$data = array(
					'Suffix'			=>strip_tags($input_data['Suffix']),
					'Name'				=>strip_tags($input_data['Name']),
					'Email'				=>strip_tags($input_data['Email']),
					'Gender'			=>strip_tags($input_data['Gender']),
					'Address'			=>strip_tags($input_data['Address']),
					'AdressTwo'			=>strip_tags($input_data['AdressTwo']),
					'Landmark'			=>strip_tags($input_data['Landmark']),
					'CountryCode'		=>strip_tags($input_data['CountryCode']),
					'Mobile'			=>strip_tags($input_data['Mobile']),
					'WhatsAppCountryCode'=>strip_tags($input_data['WhatsAppCountryCode']),
					'WhatsappNumber'	=>strip_tags($input_data['WhatsappNumber']),
					'isActive'			=>1,
					'IsDelete'			=>0,
					'ModifyBy'			=>$userid,
					'ModifyDate'		=>date('Y-m-d H:i:s'),
				);
				$data_id =$this->input->post('data_id');

				if(!empty($picture)){
					$data['ProfileIMG'] =$picture;
				}
				$where = array(
					'AutoID'=>$data_id,
				);

				$response = $this->Commonmodel->common_update('RegisterMST',$where,$data);
				if($response){
					$result['message'] = "success";
					$result['status']=200;
					return $this->set_response($result, REST_Controller::HTTP_OK);
				}else{
					$result['message'] = "Something went wrong!.";
					$result['status']=500;
					return $this->set_response($result, 500);
				}

			} catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=401;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token not Found";
			$result['status']=400;
			return $this->set_response($result, 400);
		}
	}

	//change password

	public function change_password_post() {
		$body=$this->request->body;
		$headers = apache_request_headers();
		if (!empty($headers['Token'])) {
            try {
				$this->form_validation->set_data($body);
				$this->form_validation->set_rules('oldpassword', 'Current Password', 'required|trim');
				$this->form_validation->set_rules('newpassword', 'New Password', 'required|trim');
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();
					return $this->set_response(["status"=>406,"errors"=>$errors], 406);                
				}else{
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$userid=$arrdata['AutoID'];

					$oldpassword=$body['oldpassword'];
					$newpassword=password_hash($body['newpassword'],PASSWORD_DEFAULT);
					$user = $this->Login_model->getuserdata_byid($userid);
					if($user){
						if (password_verify($oldpassword,$user->Password)) {
							$this->Login_model->chnage_password($userid,$newpassword);
							$result['message'] = "success";
					        $result['status']=true;
					   		return $this->set_response($result, REST_Controller::HTTP_OK);
						}else{
							$result['message'] = "Current Password is Wrong.";
							$result['status']=false;
							return $this->set_response($result, 403);
						}
					}
				}
			} catch (Exception $e) { 
				$result['message'] = "Invalid Token";
				$result['status']=false;
				return $this->set_response($result, 401);
			}
		}else{
			$result['message'] = "Token or oldpasswor / newpassword not Found";
			$result['status']=false;
			return $this->set_response($result, 400);

		}

	}
	

	public function PasswordRecoveryEmail_post(){
		 // error_reporting(0);
		$body=$this->request->body;
		if (!empty($body['Email'])) {
			
		$email = $body['Email'];
		$result = $this->Login_model->validateUser($email);
		
		// print_r(base_url());
		// die();
		if(!is_null($result)){
		    
			 $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();
            $mail->ClearAddresses();
            $mail->ClearAttachments();
            $mail->isSMTP();
            $mail->Host     = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'OTP@india-dahlia.com';
            $mail->Password = 'Huv199342';
            $mail->SMTPSecure = 'tls';
            $mail->Port     = 587;
            $mail->setFrom('OTP@india-dahlia.com', 'Barcode Recovery Password');
            $mail->addReplyTo('OTP@india-dahlia.com', 'Barcode Recovery Password');
            $mail->addAddress('sanjeev@dahlia.tech');

			$mail->setFrom('OTP@india-dahlia.com', 'Barcode Recovery Password');
			// Add a recipient
			$mail->addAddress($email);
			$mail->Subject = "Please reset your password";
			$mail->isHTML(true);
			$url = base_url()."login/ResetPassword";
			$id = $result['AutoID'];
			$url = base_url()."login/ResetPassword?value=".$id;


     		$message = '
									<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				
				
				</head>
				<body style="margin: 0; padding: 0;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
						<tr>
							<td style="padding: 10px 0 30px 0;">
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
									<tr>
										<td align="center" bgcolor="#70bbd9" style="padding: 15px 0 15px 0;
					color: #fff;
					font-size: 22px; font-weight: bold; font-family: Arial, sans-serif;">
											Password Change
										
										</td>
									</tr>
									<tr>
										<td bgcolor="#ffffff" style="padding: 10px 30px 40px 30px;">
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												
												<tr>
													<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px;">
														
								                         
								                         
														  You can use the following link to reset your password:

														  <a class="btn btn-primary" href="'.$url.'" role="button">Reset Password</a>
														   
														  
														  
														  Thanks,
														  The DTPL Team
														  
														  
								
					

													</td>
												</tr>
												<tr>
													<td>
													
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
														&reg; Wilh Loesch 2021<br/>
														
													</td>
													<td align="right" width="25%">
														<table border="0" cellpadding="0" cellspacing="0">
															<tr>
																<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
																	
																</td>
																<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
																<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</body>
				</html>
				';
				$mail->Body = $message;
						if(!$mail->send()){
							// echo 'Message could not be sent.';
							// echo 'Mailer Error: ' . $mail->ErrorInfo;
							$userdata['message'] = $mail->ErrorInfo;
							$userdata['status']=false;
							return $this->set_response($userdata, 401);

						}else{
							//echo 'Message has been sent';
							$userdata['message'] = "Message has been sent";
							$userdata['status']=true;
							return $this->set_response($userdata, 200);
						}

		}else{
			$userdata['message'] = "User not found";
				$userdata['status']=false;
				return $this->set_response($userdata, 401);
		}

		}else{
			$userdata['message'] = "Emailid is empty";
			$userdata['status']=false;
			return $this->set_response($userdata, 422);
		}

	}
	function Sendsms($mobile,$message){ 

		$strUserName="7208419652";
		$strPassword="WLISMS321";
		$strSenderId="WLGPWD";
		$strMobile=$mobile;
	
	   
		$postData = array(
				'mobile' => $strUserName,
				'pass' => $strPassword,
				'senderid' => $strSenderId,
				'to' => $strMobile,
				'msg' => $message
		);
		$url="https://www.smsidea.co.in/smsstatuswithid.aspx";/* API URL*/
		$ch = curl_init();/* init the resource */
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);/* Ignore SSL certificate verification */
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$output = curl_exec($ch);/* get response */
	   
		curl_close($ch);					
	}
	

	/**
	 * Registration User API
	 */
	function sendOtp_post(){
		$input_data=$this->request->body;
		$this->form_validation->set_data($input_data);
		$this->form_validation->set_rules('PhoneCountryCode', 'Country Code', 'required|trim');
		$this->form_validation->set_rules('PhoneNumber', 'Phone Number', 'required|trim|callback_mobile_check');//
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$this->output
			->set_status_header(406)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(["status"=>406,"errors"=>$errors]));                    
		}else{
			$mobile=$input_data['PhoneNumber'];
			$resend=$input_data['Resend'];
			$countrycode=$input_data['PhoneCountryCode'];
			//$random_number='898989';
			$random_number=rand(100000,999999);
			$mobilenowithcountrycode = $countrycode.$mobile;
			$res =send_otp($mobilenowithcountrycode,$resend,$random_number);
			if($res){
				//$userdata['otp']=$random_number;
				$userdata['message']="OTP Sent!";
				return $this->set_response(["status"=>200,"message"=>"OTP Sent!"], REST_Controller::HTTP_OK);	
			}else{
				return $this->set_response(["status"=>500,"errors"=>"Something went wrong."], 500);
			}
		}
	}
	function userRegistration_post(){
		$input_data=$this->request->body;
		$this->form_validation->set_data($input_data);
		$this->form_validation->set_rules('TitlePrefix', 'Title Prefix', 'required|trim');
		$this->form_validation->set_rules('Name', 'Name', 'required|trim');
		$this->form_validation->set_rules('PhoneCountryCode', 'Country Code', 'required|trim');
		$this->form_validation->set_rules('PhoneNumber', 'Phone Number', 'required|trim|callback_mobile_check');
		$this->form_validation->set_rules('Password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$this->output
			->set_status_header(406)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode(["status"=>406,"errors"=>$errors]));                    
		}else{
			$otp=$input_data['Otp'];
			$mnowithcountrycode=$input_data['PhoneCountryCode'].$input_data['PhoneNumber'];
			$isOtpVerified=$this->Login_model->CheckOTP($mnowithcountrycode,$otp);
			if($isOtpVerified){
				$data = array(
					'Suffix'   			=>$input_data['TitlePrefix'],
					'Name'          	=>trim($input_data['Name']),
					'CountryCode'		=>trim($input_data['PhoneCountryCode']),
					'Mobile'			=>trim($input_data['PhoneNumber']),
					'Email'				=>strip_tags($input_data['Email']),
					'Gender'			=>strip_tags($input_data['Gender']),
					'Address'			=>strip_tags($input_data['Address']),
					'AdressTwo'			=>strip_tags($input_data['Address2']),
					'Landmark'			=>strip_tags($input_data['Landmark']),
					'WhatsAppCountryCode'=>strip_tags($input_data['WhatsAppCountryCode']),
					'WhatsappNumber'	=>strip_tags($input_data['WhatsAppNumber']),
					'Password'			=>password_hash(strip_tags($input_data['Password']),PASSWORD_DEFAULT),
					'IsAdmin'			=>0,
					'isActive'			=>1,
					'IsDelete'			=>0,
					
				);
				
				$data['CreatedDate'] =date('Y-m-d H:i:s');
				$response =$this->Commonmodel->common_insert('RegisterMST',$data);
				if($response){
					$result = $this->Login_model->getUserByID($response);
					if($result){
						$token['AutoID']=$result['AutoID'];
						$token['Email']=$result['Email'];
						$token['IsAdmin']=$result['IsAdmin'];
			
						$userdata['token'] = $this->tokenHandler->GenerateToken($token);
						$userdata['AutoID']	=$result['AutoID'];
						$userdata['Suffix']	=$result['Suffix'];
						$userdata['Name']	=$result['Name'];
						$userdata['CountryCode']=$result['CountryCode'];
						$userdata['Mobile']	=$result['Mobile'];
						$userdata['Email']	=$result['Email'];
						$userdata['Address']=$result['Address'];
						$userdata['AdressTwo']=$result['AdressTwo'];
						$userdata['ProfileIMG']='upload/profile/'.$result['ProfileIMG'];
						$userdata['IsAdmin']=$result['IsAdmin'];
						$userdata['message'] = "User authenticated successfully";
						$userdata['status']=200;
						return $this->set_response($userdata, REST_Controller::HTTP_OK);
					}else{
						return $this->set_response(["status"=>401,"errors"=>"Authentication Error!."], 401);
					}
					// $result['message'] ="User registration successfully.";
					// $result['status']=201;
					// $status = 201;
				}else{
					$result['message'] ="Something went wrong.";
					$result['status']=500;
					$status = 500;
					$this->output
					->set_status_header($status)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));

				}

				
			}else{
				$result['message'] = "Incorrect OTP. ";
				$result['status']=400;

				$this->output
					->set_status_header(400)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($result));
			}
		}
	}
	function mobile_check($str){
		$response =checkDuplicate('RegisterMST', 'Mobile',$str,["IsDelete"=>0]);
		if ($response){
			$this->form_validation->set_message('mobile_check', 'The Phone Number field must be unique.');
			return FALSE;
		}else{
            return TRUE;
        }
	}
	
}
