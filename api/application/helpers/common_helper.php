<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 5.1.6 or newer
*
* @package		CodeIgniter
* @author		ExpressionEngine Dev Team
* @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
* @license		http://codeigniter.com/user_guide/license.html
* @link		http://codeigniter.com
* @since		Version 1.0
* @filesource
*/

if (! function_exists('get_settings')) {
    function get_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key', $key);
        $result = $CI->db->get('settings')->row('value');
        return $result;
    }
}

if (! function_exists('currency')) {
    function currency($price = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($price != "") {
            $CI->db->where('key', 'system_currency');
            $currency_code = $CI->db->get('settings')->row()->value;

            $CI->db->where('code', $currency_code);
            $symbol = $CI->db->get('currency')->row()->symbol;

            $CI->db->where('key', 'currency_position');
            $position = $CI->db->get('settings')->row()->value;

            if ($position == 'right') {
                return $price.$symbol;
            }elseif ($position == 'right-space') {
                return $price.' '.$symbol;
            }elseif ($position == 'left') {
                return $symbol.$price;
            }elseif ($position == 'left-space') {
                return $symbol.' '.$price;
            }
        }
    }
}

if (! function_exists('currency_code_and_symbol')) {
    function currency_code_and_symbol($type = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->where('key', 'system_currency');
        $currency_code = $CI->db->get('settings')->row()->value;

        $CI->db->where('code', $currency_code);
        $symbol = $CI->db->get('currency')->row()->symbol;
        if ($type == "") {
            return $symbol;
        }else {
            return $currency_code;
        }

    }
}

if (! function_exists('get_frontend_settings')) {
    function get_frontend_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key', $key);
        $result = $CI->db->get('frontend_settings')->row()->value;
        return $result;
    }
}

if ( ! function_exists('slugify'))
{
    function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('get_video_extension'))
{
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url) {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

if ( ! function_exists('ellipsis'))
{
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30) {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character)."..." : $long_string;
        return $short_string;
    }
}

// This function helps us to decode the theme configuration json file and return that array to us
if ( ! function_exists('themeConfiguration'))
{
    function themeConfiguration($theme, $key = "")
    {
        $themeConfigs = [];
        if (file_exists('assets/frontend/'.$theme.'/config/theme-config.json')) {
            $themeConfigs = file_get_contents('assets/frontend/'.$theme.'/config/theme-config.json');
            $themeConfigs = json_decode($themeConfigs, true);
            if ($key != "") {
                if (array_key_exists($key, $themeConfigs)) {
                    return $themeConfigs[$key];
                } else {
                    return false;
                }
            }else {
                return $themeConfigs;
            }
        } else {
            return false;
        }
    }
}

// Human readable time
if ( ! function_exists('readable_time_for_humans')){
    function readable_time_for_humans($duration) {
        if ($duration) {
            $duration_array = explode(':', $duration);
            $hour   = $duration_array[0];
            $minute = $duration_array[1];
            $second = $duration_array[2];
            if ($hour > 0) {
                $duration = $hour.' '.get_phrase('hr').' '.$minute.' '.get_phrase('min');
            }elseif ($minute > 0) {
                if ($second > 0) {
                    $duration = ($minute+1).' '.get_phrase('min');
                }else{
                    $duration = $minute.' '.get_phrase('min');
                }
            }elseif ($second > 0){
                $duration = $second.' '.get_phrase('sec');
            }else {
                $duration = '00:00';
            }
        }else {
            $duration = '00:00';
        }
        return $duration;
    }
}

if ( ! function_exists('trimmer'))
{
    function trimmer($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('lesson_progress'))
{
    function lesson_progress($lesson_id = "", $user_id = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($user_id == "") {
            $user_id = $CI->session->userdata('user_id');
        }
        $user_details = $CI->user_model->get_all_user($user_id)->row_array();
        $watch_history_array = json_decode($user_details['watch_history'], true);
        for ($i = 0; $i < count($watch_history_array); $i++) {
            $watch_history_for_each_lesson = $watch_history_array[$i];
            if ($watch_history_for_each_lesson['lesson_id'] == $lesson_id) {
                return $watch_history_for_each_lesson['progress'];
            }
        }
        return 0;
    }
}
if ( ! function_exists('course_progress'))
{
    function course_progress($course_id = "", $user_id = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($user_id == "") {
            $user_id = $CI->session->userdata('user_id');
        }
        $user_details = $CI->user_model->get_all_user($user_id)->row_array();

        // this array will contain all the completed lessons from different different courses by a user
        $completed_lessons_ids = array();

        // this variable will contain number of completed lessons for a certain course. Like for this one the course_id
        $lesson_completed = 0;

        // User's watch history
        $watch_history_array = json_decode($user_details['watch_history'], true);
        // desired course's lessons
        $lessons_for_that_course = $CI->crud_model->get_lessons('course', $course_id);
        // total number of lessons for that course
        $total_number_of_lessons = $lessons_for_that_course->num_rows();
        // arranging completed lesson ids
        for ($i = 0; $i < count($watch_history_array); $i++) {
            $watch_history_for_each_lesson = $watch_history_array[$i];
            if ($watch_history_for_each_lesson['progress'] == 1) {
                array_push($completed_lessons_ids, $watch_history_for_each_lesson['lesson_id']);
            }
        }

        foreach ($lessons_for_that_course->result_array() as $row) {
            if (in_array($row['id'], $completed_lessons_ids)) {
                $lesson_completed++;
            }
        }

        if ($lesson_completed > 0 && $total_number_of_lessons > 0) {
            // calculate the percantage of progress
            $course_progress = ($lesson_completed / $total_number_of_lessons) * 100;
            return $course_progress;
        }else{
            return 0;
        }

    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('random')) {
    function random($length_of_string) {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('phpFileUploadErrors')) {
    function phpFileUploadErrors($error_code) {
        $phpFileUploadErrorsArray = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        return $phpFileUploadErrorsArray[$error_code];
    }
}

function send_otp($mobile,$resend,$random_number){
	$CI =&  get_instance();
    $CI->load->database();
	//save otp and previous otp delete and send otp
	// 0=>new Otp, any other => old otp
	if(intval($resend) === 0){
		$message="Dear User, Your OTP for login to AMT is $random_number. Please do not share this OTP.Regards, WLG Team";
		$insert_otp['OTP']=$random_number;
		$insert_otp['Phone']=$mobile;
	
		//send new otp and delete previous otp
		$sql="SELECT COUNT(*) as TOTAL FROM OTP WHERE Phone='$mobile'";
		$query=$CI->db->query($sql);
		$total =$query->row()->TOTAL;
		if($total === 0){
			$CI->db->insert('OTP',$insert_otp); 
			//send_otp_whatsapp($mobile,$random_number);
            $sendingResponse=Sendsms($mobile,$message);	
            if($sendingResponse){
                return true;
            }		
            return false;
			
		}else{
			$CI->db->where('Phone',$mobile);
			$CI->db->delete('OTP'); 	
			
			$CI->db->insert('OTP',$insert_otp); 
			//send_otp_whatsapp($mobile,$random_number);
			$sendingResponse=Sendsms($mobile,$message);	
            if($sendingResponse){
                return true;
            }		
            return false;
		}
	}else{
		//send old otp
		$CI->db->where('Phone',$mobile);
		$query =$CI->db->get('OTP'); 
		$result =$query->row();
		$otp =$result->OTP;
		
		$message="Dear User, Your OTP for login to AMT is $otp. Please do not share this OTP.Regards, WLG Team";
		send_otp_whatsapp($mobile,$otp);
		$sendingResponse=Sendsms($mobile,$message);	
        if($sendingResponse){
            return true;
        }		
		return false;
	}
}
function send_otp_whatsapp($mobile,$random_number){
	// WhatsApp API Call for OTP
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://apibotify.girnarsoft.com/api/v1/botify/send-event-message',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_POST => true,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_SSL_VERIFYHOST => 0,/* Ignore SSL certificate verification */
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"company_handle": "919920787777",
			"channel_type": "WA_VALUE_FIRST",
			"send_now": "true",
			"event_name": "OTP",
			"to": "'.$mobile.'",
			"context_variables": {
				"name": "Sir/Madam",
				"otp_for":"AMT",
				"otp":"'.$random_number.'",
				"teamname":"AMT"
			}
		}',
		CURLOPT_HTTPHEADER => array(
			'Input-token: f8b541b5fc1343667ba3d6bb3e28c5952f4e50e7bce597f2e2af6e2938b92a4a0706b58a977938991d8c656c39a30644b7aab3c3ff76afb85a4b245d60d8bd2d',
			'access-secret: F3LNLIK5s3QNSKvOOlYO232SHrXND5uQom1Rtf0DUJqklpKloFGGFw9ZxXY71DoKQOSnQF4rXG2i5yn1',
			'access-key: cEJZ7YNztirBEKDRWnpmYN9JogwJOdgUOLAcwdcp',
			'ts: 1647928957476',
			'Content-Type: application/json'
		),
	));
	$response = curl_exec($curl);
	curl_close($curl);
}

function Sendsms($mobile,$message){
	$strUserName='7208419652';
	$strPassword='WLISMS321';
	$strSenderId='WLGPWD';
	$strMobile=$mobile;
	$strMessage=$message;
	$postData = array(
		'mobile' => $strUserName,
		'pass' => $strPassword,
		'senderid' => $strSenderId,
		'to' => $strMobile,
		'msg' => $strMessage
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
    if($output){
		return true;
	}else{
        echo "Send Otp Error : ". $output;
    }
    //else{
	// 	log_message('error','Error Generated Url : '.GetFullUrl());
	// 	log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => MTS Ticket Error Message :'.$response);
	// }                      
}

function getGoogleAddressByLatLong($lat, $long){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&key=AIzaSyDnf3ISxKtpcBw12BJfX6zOFmFdrc-nA5U',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_SSL_VERIFYHOST =>0,
		CURLOPT_SSL_VERIFYPEER =>0,
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    if($response){
        $responseData = json_decode($response);
        if(!empty($responseData->error_message)){
            return NULL;
        }
        if(isset($responseData->results[0])){
            return $responseData->results[0]->formatted_address;
        }else{
            return NULL;
        }
    }else{
        return NULL;
    }
   

}
// ------------------------------------------------------------------------
/* End of file common_helper.php */
/* Location: ./system/helpers/common.php */



if (!function_exists('checkDuplicate')) {
	function checkDuplicate($table,$column,$value,$condition=[]){
		$ci=& get_instance();
		$ci->load->database();
		if ($ci->db->table_exists($table)){
			$ci->db->where($column,$value); 
			if(count($condition) > 0){
				$ci->db->where($condition); 
			}
			$query =$ci->db->get($table);
			$count_row = $query->num_rows();
			//echo $ci->db->last_query();
			if ($count_row > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		}else{
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Table does not exist -- '.$table);
		}
		//select count(*) from CurrencyMst where  Name='Abc' AND AutoID !=3
	}
}

//json encode
if (!function_exists('jsonEncodeIntArr')) { 
	function jsonEncodeIntArr($arr = []){
		return !empty($arr) ? json_encode(array_map('intval',array_values($arr))) : NULL;
	}
}


function sendNotification($params=[]){   
	//for test push-notificaction(firebase)
	$SERVER_API_KEY='AAAAvq1M-T0:APA91bHRP2spXd3hFyh87Y13Y90_LX7r_SPOcKNqc2SMKHRauL2--hC4nnTaoGPJ9IeWOvVRdCLXT-jNhzyMtvrh8W-CKzeIBp3OJEaYwCYMhtP6FVnp-z5ihiX3c2ltI68PmQxyPLfE'; 

	$data = [
		"registration_ids" =>$params['token'],
		"notification" => [
			"title"             => $params['title'],
			"body"              => $params['body'],
			"content_available" => true,
			"priority"          => "high",
		],
		"data"              => $params['data'],
	];
	$dataString = json_encode($data);

	$headers = [
		'Authorization: key=' . $SERVER_API_KEY,
		'Content-Type: application/json',
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
	$response = curl_exec($ch);
	$status =200;
	// Execute post
	if ($response === FALSE) {
		$status =401; 
		die('Curl failed: ' . curl_error($ch));
	}        
	// Close connection
	curl_close($ch);
	// FCM response
	return $status;
	//dd($response);
}

function generate_otp(){
	$OTP 	=	rand(1,9);
	$OTP 	.=	rand(0,9);
	$OTP 	.=	rand(0,9);
	$OTP 	.=	rand(0,9);
	$OTP 	.=	rand(0,9);
	$OTP 	.=	rand(0,9);
	return $OTP;
}