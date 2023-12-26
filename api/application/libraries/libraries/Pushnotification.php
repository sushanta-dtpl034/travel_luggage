<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pushnotification
{

    public $CI;

    //package name: solution manager

    public $API_ACCESS_KEY = "AAAADkcPvJo:APA91bFR8YlolheepYvSMyja2zYavd4aiNqE9d3KCzFU582YrDLUrjwKMhetqlNKhm0-bg2vzbIhmTq9qAwalrRDZf_hw4qQ_gD5tEB5R7aH9nF-09Vdn-NiQY_MwOswjERkibIzvEea";

    public $fcmUrl  = "https://fcm.googleapis.com/fcm/send";

    public function __construct()
    {
        $this->CI = &get_instance();

    }

    public function send($tokens, $msg)

    {
        // print_r($tokens);
        // exit();
        $notificationData = [
            'title'  => $msg['title'],
            'body'   => $msg['body'],
            'data' =>"Test"
           
        ];
        
        $fcmNotification = [

            'to'          => $tokens, //single token
            'collapseKey' => "{$tokens}",
            'notification' => $notificationData,
            

        ];

        $headers = [
            'Authorization: key=' . $this->API_ACCESS_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;

    }

}
