<?php
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
	    $this->tokenHandler = new TokenHandler();
		$this->load->model('api_model');
		$this->load->library('Authtoken');
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
		$username=$data['username'];
		$password=$data['password'];
		$mobile=$data['mobile'];
		$resend=$data['resend'];
		$countrycode=$data['countrycode'];
		if (empty($username) && empty($password)) {
			if( !empty($mobile) ){
				//save otp and previous otp delete and send otp
				//check mobile no
				
				$mobilenowithcountrycode = $countrycode.$mobile;
				$response=$this->Login_model->validateUserMobile($mobilenowithcountrycode);
				if($response){
					//after validate send otp and save
					$random_number=rand(100000,999999);
					$res =send_otp($mobilenowithcountrycode,$resend,$random_number);
					if($res){
						$userdata['message']="OTP Sent!";
						return $this->set_response($userdata, REST_Controller::HTTP_OK);	
					}
			
				}else{
					$userdata['message'] = "User not found";
					$userdata['status']=false;
					return $this->set_response($userdata, 401);
				}
			}else{
				$userdata['message'] = "username and password empty";
				$userdata['status']=false;
				return $this->set_response($userdata, 422);
			}
		
		}
		elseif (empty($username)) {
			$userdata['message'] = "username  empty";
			$userdata['status']=false;
			return $this->set_response($userdata, 422);
		}
		elseif (empty($password)) {
			$userdata['message'] = "password empty";
			$userdata['status']=false;
			return $this->set_response($userdata, 422);
		}
		else{
			$result = $this->Login_model->validateUser($username);
			if(!empty($result['Email'])){
					if(password_verify($password,$result['Password'])){
						if($result['IsDelete']==1){
							$userdata['message'] = "User Deleted";
							$userdata['status']=false;
							return $this->set_response($userdata, 422);
						}
						else{
							
							// if ($result['isApprove'] != 1 && $result['isApprove'] != 2) {

							// 	$userdata['message'] = "User Notapprove";
							// 	$userdata['status']=false;
							// 	return $this->set_response($userdata, 403);
							// }
							if($result['isActive'] != 1){
								$userdata['message'] = "User Notactive";
								$userdata['status']=false;
								return $this->set_response($userdata, 403);
							}
							else{
								// print_r($result);
								$token['AutoID']=$result['AutoID'];
								$token['Email']=$result['Email'];
								$token['ParentID']=$result['ParentID'];
								$token['UserRole']=$result['UserRole'];
								$token['GroupID']=$result['GroupID'];
								$token['CompanyName']=$result['CompanyName'];
								$token['IsAdmin']=$result['IsAdmin'];
								$token['Isauditor']=$result['Isauditor'];
								$token['issupervisor']=$result['issupervisor'];
								$userdata['token'] = $this->tokenHandler->GenerateToken($token);

								$userdata['ParentID']=$result['ParentID'];
								$userdata['UserRole']=$result['UserRole'];
								$userdata['Name']=$result['Name'];
								$userdata['Email']=$result['Email'];
								$userdata['CompanyName']=$result['CompanyName'];
								$userdata['ProfileIMG']='upload/profile/'.$result['ProfileIMG'];
								$userdata['IsAdmin']=$result['IsAdmin'];
								$userdata['Isauditor']=$result['Isauditor'];
								$userdata['issupervisor']=$result['issupervisor'];
								$userdata['message'] = "User authenticated successfully";
								$userdata['status']=true;
								return $this->set_response($userdata, REST_Controller::HTTP_OK);
							}
						}
					}
					else{
						$userdata['message'] = "Wrong Password";
						$userdata['status']=false;
						return $this->set_response($userdata, 403);
					}
			}
			else{
				$userdata['message'] = "User not found";
				$userdata['status']=false;
				return $this->set_response($userdata, 401);
			}
			// return $this->set_response($result);
		}		
	}
	
	public function CheckOTP_post() {
        $data=$this->request->body;
        $otp=$data['otp'];
		$mobile=$data['mobile'];
		$mnowithcountrycode=$data['countrycode'].$mobile;
		$result=$this->Login_model->CheckOTP($mnowithcountrycode,$otp);
		if($result){
			$result = $this->Login_model->validateUserMobile($mnowithcountrycode);
			$token['AutoID']=$result['AutoID'];
			$token['Email']=$result['Email'];
			$token['ParentID']=$result['ParentID'];
			$token['UserRole']=$result['UserRole'];
			$token['GroupID']=$result['GroupID'];
			$token['CompanyName']=$result['CompanyName'];
			$token['IsAdmin']=$result['IsAdmin'];
			$token['Isauditor']=$result['Isauditor'];
			$token['issupervisor']=$result['issupervisor'];
			$userdata['token'] = $this->tokenHandler->GenerateToken($token);

			$userdata['ParentID']=$result['ParentID'];
			$userdata['UserRole']=$result['UserRole'];
			$userdata['Name']=$result['Name'];
			$userdata['Email']=$result['Email'];
			$userdata['CompanyName']=$result['CompanyName'];
			$userdata['ProfileIMG']='upload/profile/'.$result['ProfileIMG'];
			$userdata['IsAdmin']=$result['IsAdmin'];
			$userdata['Isauditor']=$result['Isauditor'];
			$userdata['issupervisor']=$result['issupervisor'];
			$userdata['message'] = "User authenticated successfully";
			$userdata['status']=true;
			return $this->set_response($userdata, REST_Controller::HTTP_OK);
		}else{
			$userdata['message'] = "Authentication Error!.";
			$userdata['status']=false;
			return $this->set_response($userdata, 403);
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
			if (!empty($headers['Token'])) {
				try {
						$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
						$userid=$arrdata['AutoID'];

							$profile_companyname = $this->input->post('company_name');
							$profile_address = $this->input->post('profile_address');
							$profile_city = $this->input->post('city_id');
							$profile_state = $this->input->post('state_id');
							$profile_pincode = $this->input->post('profile_pincode');
							$profile_country = $this->input->post('country_id');
							$profile_pan = $this->input->post('profile_pan');
							$profile_tax = $this->input->post('profile_tax');
							$profile_gst = $this->input->post('profile_gst');
							$profile_contactperson = $this->input->post('profile_contactperson');
							$profile_emailid = $this->input->post('profile_emailid');
							$profile_office = $this->input->post('profile_office');
							$profile_mobile = $this->input->post('profile_mobile');
							$data_id = $this->input->post('data_id');

							 if(!empty($_FILES['profile_image']['name'])){
										$config['upload_path']   = '../upload/profile/'; 
										$config['allowed_types'] = 'jpg|png|jpeg'; 
										$this->load->library('upload',$config);
										$this->upload->initialize($config);
										if($this->upload->do_upload('profile_image')){
							                $uploadData = $this->upload->data();
							                $picture = $uploadData['file_name'];
									      }
									      else
									      { $picture = '';  }
								}else{
           						 $picture = '';
        							}

					if($picture != ''){
							$data = array(
								'CompanyName'=>$profile_companyname,
								'Address'=>$profile_address,
								'City'=>$profile_city,
								'State'=>$profile_state,
								'Pincode'=>$profile_pincode,
								'Country'=>$profile_country,
								'GstNo'=>$profile_gst,
								'TaxID'=>$profile_tax,
								'Pan'=>$profile_pan,
								'Email'=>$profile_emailid,
								'ContactPersonName'=>$profile_contactperson,
								'OfficePhoneNumber'=>$profile_office,
								'ContactPersonMobile'=>$profile_mobile,
								'ModifyBy'=>$userid,
								'ModifyDate'=>date('Y-m-d'),
								'ProfileIMG'=>$picture
								);
							}else{
								$data = array(
								'CompanyName'=>$profile_companyname,
								'Address'=>$profile_address,
								'City'=>$profile_city,
								'State'=>$profile_state,
								'Pincode'=>$profile_pincode,
								'Country'=>$profile_country,
								'GstNo'=>$profile_gst,
								'TaxID'=>$profile_tax,
								'Pan'=>$profile_pan,
								'Email'=>$profile_emailid,
								'ContactPersonName'=>$profile_contactperson,
								'OfficePhoneNumber'=>$profile_office,
								'ContactPersonMobile'=>$profile_mobile,
								'ModifyBy'=>$userid,
								'ModifyDate'=>date('Y-m-d'),
								);
							}
							
							$where = array(
								'AutoID'=>$data_id,
							);

							$this->Commonmodel->common_update('RegisterMST',$where,$data);
						    $result['message'] = "success";
						    $result['status']=true;
						    return $this->set_response($result, REST_Controller::HTTP_OK);
					} catch (\Exception $e) 
						{ 
		   					 $result['message'] = "Invalid Token";
							$result['status']=false;
							return $this->set_response($result, 401);
						}
			}
			else{
				$result['message'] = "Token not Found";
				$result['status']=false;
				return $this->set_response($result, 400);

			}
		}

	//change password

	public function change_password_post() {

		$body=$this->request->body;
		$headers = apache_request_headers();

		if (!empty($headers['Token']) && !empty($body['newpassword']) && !empty($body['oldpassword']) && !empty($body)) {
		
			try {
					$arrdata=$this->tokenHandler->DecodeToken($headers['Token']);
					$username=$arrdata['Email'];
					$oldpassword=$body['oldpassword'];
					$newpassword=password_hash($body['newpassword'],PASSWORD_DEFAULT);
					$user = $this->Login_model->validateUser($username);
					if ($user) {
						
						if (password_verify($oldpassword,$user['Password'])) {
							 $this->Login_model->chnage_password($username,$newpassword);
							$result['message'] = "success";
					        $result['status']=true;
					   		return $this->set_response($result, REST_Controller::HTTP_OK);
						}else{
							$result['message'] = "Wrong Password";
							$result['status']=false;
						return $this->set_response($result, 403);

						}
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
	
	
}
