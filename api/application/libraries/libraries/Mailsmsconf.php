<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mailsmsconf
{

    public function __construct()
    {
        $this->CI = &get_instance();
       
        //$this->CI->load->library('pushnotification');
       
        $this->CI->load->model('Templatemodel');
        $this->CI->load->model('SystemSettingModel');
        

    }

    // public function mailsms($send_for, $sender_details, $template)
    // {
        
    //         if (($send_for == "create_ticket")) {
    //                 $this->sentCreatTicketNotification($sender_details['InchargeID'],$sender_details['TicketID'],$template);
    //         }

    // }

    // public function sentCreatTicketNotification($sendtoid,$ticketid,$template) {
    //     $result = $this->CI->api_model->getUserProfile($sendtoid);
    //     $msg = $this->getTicketDetails($sendtoid, $ticketid, $template);
    //     $push_array = array(
    //         'title' => 'Ticket Created',
    //         'body' => $msg
    //     );
    //      if ($result['app_key'] != "") {
    //          $this->CI->pushnotification->send($result['app_key'], $push_array);
    //      }
    // }

    //  public function getTicketDetails($sendtoid, $ticketid, $templateid)
    // {
        
    //     $UserDetails = $this->CI->api_model->getUserProfileById($sendtoid);
    //     $TicketDetails = $this->CI->api_model->getTicketId($ticketid);
    //     $templatedata = $this->CI->api_model->getTemplateDetails($templateid);

    //         $Name=$UserDetails->username;
    //         $Email=$UserDetails->email;
    //         $ContactNo=$UserDetails->contactNo;
    //         $Password=$UserDetails->password;
    //         $Password=$UserDetails->password;
    //         $Designation=$UserDetails->designation;
    //        // $TemplateID= $templateid;
    //         $TicketNO = $TicketDetails->TicketNo;

    //         $tokens = array(
    //             'Name' => "$Name",
    //             'UserEmail'=>"$Email",
    //             'UserPhone'=>"$ContactNo",
    //             'Designation'=>"$Designation",
    //             'Password'=>"$Password",
    //             'TicketNo'=>"$TicketNO"
    //         );
    //         $pattern = '[[%s]]';

    //         $map = array();
    //         foreach($tokens as $var => $value)
    //         {
    //             $map[sprintf($pattern, $var)] = $value;
    //         }
    //         $template = $templatedata->Content;
    //         $msg= strtr($template, $map);
    //         //$msg = strip_tags($message);
    //         $message  = str_replace("&nbsp;", " ", strip_tags($msg));
    //         // print_r($msg);
    //         // exit();
    //     return $message;
    // }


    public function mailsmsweb($send_for,$sender_details,$templateID_user,$templateID_inc,$templateID_audi)
    {
        
            if ($send_for == "create_ticket") {
                    $this->SendMailCreateTicket($sender_details,$templateID_user,$templateID_inc,$templateID_audi);
            }

            if ($send_for == "process_ticket") {
                $this->SendMailTicketStatus($sender_details,$templateID_user);
            }

            if ($send_for == "feedback_ticket") {
                $this->SendMailTicketFeedback($sender_details,$templateID_inc);
            }

            if ($send_for == "user_registration") {
                $this->SendMailUserRegistration($sender_details,$templateID_user);
             
            }
            if ($send_for == "user_registration_admin") {

                $this->SendMailForAdmin($sender_details,$templateID_user);
            }
        
            if ($send_for == "registration_approved") {
                $this->SendMailRegistrationApproved($sender_details,$templateID_user);
            }

            if ($send_for == "assign_ticket") {
                $this->SendMailAssignTickets($sender_details,$templateID_user);
            }

    }


    public function SendMailCreateTicket($sender_details,$templateID_user,$templateID_inc,$templateID_audi)
    {

        $Userdata= $this->CI->Templatemodel->UserDetails($sender_details['UserID']);
        $Ticketdata= $this->CI->Templatemodel->TicketDetails($sender_details['TicketID']);
      
        $Name = $Userdata->username;
        $UserEmail = $Userdata->email;
        $UserPhone = $Userdata->contactNo;
        $language_user = $Userdata->PreferredLanguage;

        $inchargeID = $Ticketdata->InchargeID;
        $auditorID = $Ticketdata->AuditorID;
        $inchargeName = $Ticketdata->incharge_name;
        $inchargeEmail = $Ticketdata->incharge_email;
        $inchargePhone = $Ticketdata->incharge_phone;
        $language_incharge = $Ticketdata->incharge_language;

        $auditorName = $Ticketdata->auditor_name;
        $auditorEmail = $Ticketdata->auditor_email;
        $auditorPhone = $Ticketdata->auditor_phone;
        $language_auditor = $Ticketdata->auditor_language;

        $TicketNo = $Ticketdata->TicketNo;
        $Title = $Ticketdata->Title;
        $Description = $Ticketdata->Description;
        $Status = $Ticketdata->Status;
        $Remark = $Ticketdata->Remark;
        $CreatedDate = $Ticketdata->CreatedDate;
        $ExpectedDate = $Ticketdata->ExpectedDate;

        $d = new DateTime($CreatedDate);
        $createdate = $d->format('d F, Y H:i a');

        $de = new DateTime($ExpectedDate);
        $expectedate = $de->format('d F, Y');
        if ($templateID_user > 0) {
                $tokens = array(
                'Name' => "$Name",
                'TicketNo' => "$TicketNo",
                'Title' => "$Title",
                'Description' => "$Description",
                'CreatedDate'=>"$createdate",
                'ExpectedDate'=>"$expectedate",
                'Remark'=>"$Remark",
                'UserEmail'=>"$UserEmail",
                'UserPhone'=>"$UserPhone",
            );
            $this->sendmessageresolver($tokens,$templateID_user,$UserEmail,$language_user,$sender_details['UserID'],$sender_details['TicketID'],1);
        }
        
       if ($templateID_inc > 0) {
            $tokens = array(
                'Name' => "$inchargeName",
                'TicketNo' => "$TicketNo",
                'Title' => "$Title",
                'Description' => "$Description",
                'CreatedDate'=>"$createdate",
                'ExpectedDate'=>"$expectedate",
                'Remark'=>"$Remark",
                'UserEmail'=>"$inchargeEmail",
                'UserPhone'=>"$inchargePhone",
            );
            $this->sendmessageresolver($tokens,$templateID_inc,$inchargeEmail,$language_incharge,$inchargeID,$sender_details['TicketID'],1);
        }

         if ($templateID_audi > 0) {
            $tokens = array(
                'Name' => "$auditorName",
                'TicketNo' => "$TicketNo",
                'Title' => "$Title",
                'Description' => "$Description",
                'CreatedDate'=>"$createdate",
                'ExpectedDate'=>"$expectedate",
                'Remark'=>"$Remark",
                'UserEmail'=>"$auditorEmail",
                'UserPhone'=>"$auditorPhone",
            );
            $this->sendmessageresolver($tokens,$templateID_audi,$auditorEmail,$language_auditor,$auditorID,$sender_details['TicketID'],1);
        } 
        
    }

    public function SendMailAssignTickets($sender_details,$templateID_user)
    {

        $Ticketdata= $this->CI->Templatemodel->TicketDetails($sender_details['TicketID']);
        $Userdata= $this->CI->Templatemodel->UserDetails($sender_details['UserID']);
        $Activitydata= $this->CI->Templatemodel->ActivityUserDetails($sender_details['ActivityID']);
        $Name = $Userdata->username;
        $UserEmail = $Ticketdata->user_email;
        $UserPhone = $Ticketdata->user_phone;
        $language_user = $Ticketdata->user_language;
        $TicketNo = $Ticketdata->TicketNo;
        $ActivityName = $Activitydata->Name;
        $ticketStatus = $sender_details['Status'];
        if($ticketStatus==1)
        {
         $Status = "Processing" ;
        }elseif ($ticketStatus == 2) {
           $Status = "Completed" ;
        }elseif ($ticketStatus == 3) {
            $Status = "Rejected" ;
        }else {
            $Status = "Pending" ;
        }

        $Remark = $sender_details['Remark'];
        $CreatedDate = $Ticketdata->CreatedDate;
        $d = new DateTime($CreatedDate);
        $createdate = $d->format('d F, Y H:i a');

        $ExpectedDate =$sender_details['ActivityDate'];
        $de = new DateTime($ExpectedDate);
        $expectedate = $de->format('d F, Y');

        if ($templateID_user > 0) {
                $tokens = array(
                'Name' => "$Name",
                'ActivityName' => "$ActivityName",
                'TicketNo' => "$TicketNo",
                'CreatedDate'=>"$createdate",
                'ExpectedDate'=>"$expectedate",
                'Remark'=>"$Remark",
                'Status'=>"$Status",
                'UserEmail'=>"$Userdata->email",
                'UserPhone'=>"$UserPhone",
            );
            $this->sendmessageresolver($tokens,$templateID_user,$Userdata->email,$language_user,$sender_details['UserID'],$sender_details['TicketID'],2);
        }
    }

    public function SendMailTicketStatus($sender_details,$templateID_user)
    {

        //$Userdata= $this->CI->Templatemodel->UserDetails($sender_details['UserID']);
        // print_r($Userdata);
        // exit();
        $Ticketdata= $this->CI->Templatemodel->TicketDetails($sender_details['TicketID']);
        // print_r($Ticketdata);
        // exit();

        $Name = $Ticketdata->user_name;
        $UserEmail = $Ticketdata->user_email;
        $UserPhone = $Ticketdata->user_phone;
        $language_user = $Ticketdata->PreferredLanguage;

        // $inchargeName = $Ticketdata->incharge_name;
        // $inchargeEmail = $Ticketdata->incharge_email;
        // $inchargePhone = $Ticketdata->incharge_phone;

        // $auditorName = $Ticketdata->auditor_name;
        // $auditorEmail = $Ticketdata->auditor_email;
        // $auditorPhone = $Ticketdata->auditor_phone;

        $TicketNo = $Ticketdata->TicketNo;

        $ticketStatus = $sender_details['Status'];

        if($ticketStatus==1)
        {
         $Status = "Processing" ;
        }elseif ($ticketStatus == 2) {
           $Status = "Completed" ;
        }elseif ($ticketStatus == 3) {
            $Status = "Rejected" ;
        }else {
            $Status = "Pending" ;
        }
        $Remark = $sender_details['Remark'];
        $CreatedDate = $Ticketdata->CreatedDate;
        $d = new DateTime($CreatedDate);
        $createdate = $d->format('d F, Y H:i a');
        $ExpectedDate = $Ticketdata->ExpectedDate;

        $de = new DateTime($ExpectedDate);
        $expectedate = $de->format('d F, Y');

        if ($templateID_user > 0) {
                $tokens = array(
                'Name' => "$Name",
                'TicketNo' => "$TicketNo",
                'CreatedDate'=>"$createdate",
                'ExpectedDate'=>"$expectedate",
                'Remark'=>"$Remark",
                'Status'=>"$Status",
                'UserEmail'=>"$UserEmail",
                'UserPhone'=>"$UserPhone",
            );
            $this->sendmessage($tokens,$templateID_user,$UserEmail,$language_user);
        }
        
    }

    public function SendMailTicketFeedback($sender_details,$templateID_inc)
    {

        
        $Ticketdata= $this->CI->Templatemodel->TicketDetails($sender_details['TicketID']);
       
        // $Name = $Ticketdata->user_name;
        // $UserEmail = $Ticketdata->user_email;
        // $UserPhone = $Ticketdata->user_phone;

        $inchargeName = $Ticketdata->incharge_name;
        $inchargeEmail = $Ticketdata->incharge_email;
        $inchargePhone = $Ticketdata->incharge_phone;
        $language_incharge = $Ticketdata->incharge_language;

        // $auditorName = $Ticketdata->auditor_name;
        // $auditorEmail = $Ticketdata->auditor_email;
        // $auditorPhone = $Ticketdata->auditor_phone;

        $TicketNo = $Ticketdata->TicketNo;

        $ticketStatus = $sender_details['Status'];

        if($ticketStatus==1)
        {
         $Status = "Processing" ;
        }elseif ($ticketStatus == 2) {
           $Status = "Completed" ;
        }elseif ($ticketStatus == 3) {
            $Status = "Rejected" ;
        }else {
            $Status = "Pending" ;
        }
        $Remark = $sender_details['Remark'];
        $Rating = $sender_details['Rating'];

        $CreatedDate = $Ticketdata->CreatedDate;
        $d = new DateTime($CreatedDate);
        $createdate = $d->format('d F, Y H:i a');

        $ExpectedDate = $Ticketdata->ExpectedDate;
        $de = new DateTime($ExpectedDate);
        $expectedate = $de->format('d F, Y');
        if ($templateID_inc > 0) {
                $tokens = array(
                'Name' => "$inchargeName",
                'TicketNo' => "$TicketNo",
                'CreatedDate'=>"$createdate",
                'ExpectedDate'=>"$expectedate",
                'Remark'=>"$Remark",
                'Rating'=>"$Rating",
                'UserEmail'=>"$inchargeEmail",
                'UserPhone'=>"$inchargePhone",
            );
            $this->sendmessage($tokens,$templateID_inc,$inchargeEmail,$language_incharge);
        }
        
    }

    public function SendMailUserRegistration($sender_details,$templateID_user)
    {

        $Userdata= $this->CI->Templatemodel->UserDetails($sender_details['UserID']);
     
        $Name = $Userdata->username;
        $UserEmail = $Userdata->email;
        $UserPhone = $Userdata->contactNo;
        $language_user = $Userdata->PreferredLanguage;
        if ($templateID_user > 0) {
            $tokens = array(
                'Name' => "$Name",
                'UserEmail'=>"$UserEmail",
                'UserPhone'=>"$UserPhone",
            );
            $this->sendmessage($tokens,$templateID_user,$UserEmail,$language_user);
        }
        
    }

    public function SendMailRegistrationApproved($sender_details,$templateID_user)
    {

        $Userdata= $this->CI->Templatemodel->UserDetails($sender_details['UserID']);
     
        $Name = $Userdata->username;
        $UserEmail = $Userdata->email;
        $UserPhone = $Userdata->contactNo;
        $language_user = $Userdata->PreferredLanguage;
        if ($templateID_user > 0) {
            $tokens = array(
                'Name' => "$Name",
                'UserEmail'=>"$UserEmail",
                'UserPhone'=>"$UserPhone",
            );
            $this->sendmessage($tokens,$templateID_user,$UserEmail,$language_user);
        }
        
    }

    public function translate($api_key,$text,$target)
    {
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $api_key . '&q=' . rawurlencode($text);
        $url .= '&target='.$target;
        // if($source)
        // $url .= '&source='.$source;
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);    
        $response = curl_exec($ch);
        curl_close($ch);
        $obj =json_decode($response,true); 
        return $obj;
    } 

    public function sendmessage($tokens,$templateID,$send_to_email,$language){

        $id = 1;
        if (!empty($language)) {
           $language_code = $language;
        }else{
            $language_code ="en";
        }
        $mailSMSsetting = $this->CI->SystemSettingModel->getSystemSetting($id);
        $pattern = '[[%s]]';
        $map = array();
        foreach($tokens as $var => $value)
        {
            $map[sprintf($pattern, $var)] = $value;
        }
       // echo $templateID;
        $data = $this->CI->Templatemodel->GetTemplateDetails($templateID);
        $template = $data->Content;
        $template .= $data->FooterContent;
        $message_template= strtr($template, $map);
        // print_r($data->FooterContent);
        // exit();
        $this->CI->load->library('phpmailer_lib');
        $mail = $this->CI->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->ClearAddresses();
        $mail->ClearAttachments();
       // $mail->Host     = 'smtp.office365.com';
        $mail->Host     = $mailSMSsetting->EmailHost;
        $mail->SMTPAuth = true;
       // $mail->Username = 'OTP@india-dahlia.com';
        $mail->Username = $mailSMSsetting->EmailAddress;
        //$mail->Password = 'Huv199342';
        $mail->Password = $mailSMSsetting->EmailPass;;
        $mail->SMTPSecure = 'tls';
       // $mail->Port     = 587;
        $mail->Port     = $mailSMSsetting->EmailPort;
        // $mail->setFrom('OTP@india-dahlia.com', "Solution Manager");
        // $mail->addReplyTo('OTP@india-dahlia.com', "Solution Manager");
        $mail->setFrom($mailSMSsetting->ReceiveEmail , $mailSMSsetting->EmailAddName);
        $mail->addReplyTo($mailSMSsetting->ReceiveEmail, $mailSMSsetting->EmailAddName);
        $mail->addAddress($send_to_email);
        $mail->CharSet = 'UTF-8';   
        $mail->isHTML(true);
       
        $mail->Subject = $data->Title;

        $api_key = 'AIzaSyBTIp1i82RO0Zl6hj2mEckpohK9SbmYFJQ';
        $text = $message_template;
       // $source="";
        $target=$language_code;
        $obj = $this->translate($api_key,$text,$target);
        if($obj != null)
        {
            if(isset($obj['error']))
            {
                echo "Error is : ".$obj['error']['message'];
            }
            else
            {
                //echo "Orginal Text: ".$text.'<br>';
               $message_content = " ".$obj['data']['translations'][0]['translatedText'];
               $message=$message_content;
                
            }
        }
        else{
            echo "UNKNOW ERROR";
        }
        $mail->Body = $message;
        // print_r($message);
        // exit();
        
        if(!$mail->send()){

         echo  $status='Mailer Error: ' . $mail->ErrorInfo;
        }
        else{
            
            $status='sent';
        }
    }

    public function sendmessageresolver($tokens,$templateID,$send_to_email,$language="",$userID,$TicketID,$type){

        $id = 1;
        if ($language!="") {
           $language_code = $language;
        }else{
            $language_code ="en";
        }
        //$mailSMSsetting = $this->CI->SystemSettingModel->getSystemSetting($id);
        $pattern = '[[%s]]';
        $map = array();
        foreach($tokens as $var => $value)
        {
            $map[sprintf($pattern, $var)] = $value;
        }
        $data = $this->CI->Templatemodel->GetTemplateDetails($templateID);

        $template = $data->Content;
        $template .= $data->FooterContent;
        $message_template= strtr($template, $map);
        $api_key = 'AIzaSyBTIp1i82RO0Zl6hj2mEckpohK9SbmYFJQ';
        $text = $message_template;
        // print_r($text);
        // exit();
        $target=$language_code;
        $obj = $this->translate($api_key,$text,$target);
        if($obj != null)
        {
            if(isset($obj['error']))
            {
                echo "Error is : ".$obj['error']['message'];
            }
            else
            {
                //echo "Orginal Text: ".$text.'<br>';
               $message_content = " ".$obj['data']['translations'][0]['translatedText'];
               $message=$message_content;
            }
        }
        else{
            echo "UNKNOW ERROR";
        }
        
        $EmailData = array(
            'TicketID' =>$TicketID,
            'UserID'=>$userID,
            'Email'=>$send_to_email,
            "Subject"=>$data->Title,
            "Message"=>$message,
            "IsSent"=>0,
            "CreatedDate"=> date("Y-m-d H:i:s"),
            "EmailType"=>$type
        );
        $insertID = $this->CI->Templatemodel->ManageEmailhistory($EmailData,1);
        $this->CI->Templatemodel->EmailhistoryUpdate($message,$insertID);
      
    }

    function SendSMSMessage($phone) 
    {
        $url = "https://smsidea.com/api/mt/SendSMS?user=9920281868&password=9920281868&senderid=WLGPWD&channel=Normal&DCS=0&flashsms=0&number=91'".$phone."'&text=Your%20one%20time%20verification%20code%20for%20login%20is%20:%201234";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    public function SendMailForAdmin($sender_details,$templateID_user)
    {

        $Userdata= $this->CI->Templatemodel->UserDetails($sender_details['UserID']);
        $UserdataAdmin= $this->CI->Templatemodel->UserDetails(1);

        $Name = $UserdataAdmin->username;
        $emailto = $UserdataAdmin->email;
        
        $RegisterName = $Userdata->username;
        $RegisterEmail = $Userdata->email;
        $RegisterPhone = $Userdata->contactNo;
        $language_user = $UserdataAdmin->PreferredLanguage;

        if ($templateID_user > 0) {
            $tokens = array(
                'Name'=>$Name,
                'UserRegisterName' => "$RegisterName",
                'UserRegisterEmail'=>"$RegisterEmail",
                'UserRegisterPhone'=>$RegisterPhone 
            );
            $this->sendmessage($tokens,$templateID_user,$emailto,$language_user);
        }
        
    }

}