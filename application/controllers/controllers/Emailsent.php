<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailsent extends CI_Controller {

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
     $this->load->library('form_validation');
     $this->load->library('phpmailer_lib');
	  $this->load->model('Loginmodel');
    $this->load->model('Assetmodel');
	}
    // public function getNotificationassetfrommail(){
    //   //$from = date('Y-m-d');
    //   $parentid = $this->session->userdata('userid');
    //   if($this->session->userdata('GroupID')!='1'){
    //     $parentid = $this->session->userdata('parentid');
    //   }
    //   $today =  date('Y-m-d');
    //   $from = date('Y-m-d', strtotime("-4 days", strtotime($today)));
    //   $to = date('Y-m-d', strtotime("+7 days", strtotime($today)));
    //   $result = $this->Assetmodel->getUserslistfornotify($from,$to);
    //   // print_r($result);
    //   // die();
    //   foreach($result as $res_data){
    //     $userid = $res_data['userid'];
    //     $email = $res_data['Email'];
    //     $userResult = $this->Assetmodel->getDetailsforverification($from,$to,$userid);
    //     error_reporting(0);
    //     $email =  $res_data['Email'];
    //     $mail = $this->phpmailer_lib->load();
    //     $fromaddress = 'testing@dahlia.tech';
    //     //$to = 'kvanan2429@gmail.com';
    //     // SMTP configuration
    //     $mail->isSMTP();
    //     //$mail->isSendmail();
    //     $mail->Host     = 'smtp.office365.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'testing@dahlia.tech';
    //     $mail->Password = 'tldyrjjpwbdvzljl';
    //     $mail->SMTPSecure = 'tls';
    //     $mail->Port     = 587;
    //     $mail->setFrom($fromaddress);
    //     $data['result'] = $userResult;
    //     $data['username'] = $res_data['UserName'];
    //     // Add a recipient
    //     $mail->addAddress($email);
    //     // Email subject
    //     $mail->Subject ="Reminder Message";
    //     // Set email format to HTML
    //     $mail->isHTML(true);
    //     // Email body content
    //     $mailContent = $this->load->view('remindertemplate',$data,TRUE);
    //     // print_r($mailContent);
    //     // die();
    //     $mail->Body = $mailContent;
    //     $mail->send();
    //     // Send email
    //     if(!$mail->send()){
    //       echo $mail->ErrorInfo;
    //     }else{
    //        $message = "Mail send successfully";
    //     }
    //   }

      
    // }
    public function getNotificationassetfrommail(){

       $today = date('Y-m-d');
       // Calculate reminder dates
       $reminder_date[0] = date('Y-m-d', strtotime("+7 days", strtotime($today)));
       $reminder_date[1] = date('Y-m-d', strtotime("-1 days", strtotime($today)));
          $result = $this->Assetmodel->getUserslistfornotify($reminder_date);
          foreach($result as $res_data){
              $userid = $res_data['userid'];
              $email = $res_data['Email'];
              $userResult = $this->Assetmodel->getDetailsforverification($reminder_date,$userid);
              error_reporting(0);
              $email =  $res_data['Email'];
              $mail = $this->phpmailer_lib->load();
              $fromaddress = 'testing@dahlia.tech';
              //$to = 'kvanan2429@gmail.com';
              // SMTP configuration
              $mail->isSMTP();
              //$mail->isSendmail();
              $mail->Host     = 'smtp.office365.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'testing@dahlia.tech';
              $mail->Password = 'tldyrjjpwbdvzljl';
              $mail->SMTPSecure = 'tls';
              $mail->Port     = 587;
              $mail->setFrom($fromaddress);
              $data['result'] = $userResult;
              $data['username'] = $res_data['UserName'];
              // Add a recipient
              $mail->addAddress($email);
              // Email subject
              $mail->Subject ="Reminder Message";
              // Set email format to HTML
              $mail->isHTML(true);
              // Email body content
              $mailContent = $this->load->view('remindertemplate',$data,TRUE);
              // print_r($mailContent);
              // die();
              $mail->Body = $mailContent;
              // Send email
              if(!$mail->send()){
                echo $mail->ErrorInfo;
              }else{
                $message = "Mail send successfully";
              }
              // $mail->clear();
        }
    }
	
}
