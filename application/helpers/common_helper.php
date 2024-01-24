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

if ( ! function_exists('slugify')){
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

if ( ! function_exists('get_video_extension')){
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

if ( ! function_exists('ellipsis')){
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30) {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character)."..." : $long_string;
        return $short_string;
    }
}

// This function helps us to decode the theme configuration json file and return that array to us
if ( ! function_exists('themeConfiguration')){
    function themeConfiguration($theme, $key = ""){
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

if ( ! function_exists('trimmer')){
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

if ( ! function_exists('lesson_progress')){
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

if ( ! function_exists('course_progress')){
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
			send_otp_whatsapp($mobile,$random_number);
			Sendsms($mobile,$message);
			
		}else{
			$CI->db->where('Phone',$mobile);
			$CI->db->delete('OTP'); 	
			
			$CI->db->insert('OTP',$insert_otp); 
			send_otp_whatsapp($mobile,$random_number);
			Sendsms($mobile,$message);
		}
		return true;
	}else{
		//send old otp
		$CI->db->where('Phone',$mobile);
		$query =$CI->db->get('OTP'); 
		$result =$query->row();
		$otp =$result->OTP;
		
		$message="Dear User, Your OTP for login to AMT is $otp. Please do not share this OTP.Regards, WLG Team";
		send_otp_whatsapp($mobile,$otp);
		Sendsms($mobile,$message);			
		return true;
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
}

// ------------------------------------------------------------------------
/* End of file common_helper.php */
/* Location: ./system/helpers/common.php */



/**
 * Get Single column value passing multiple condition
 * Ex => GetColumnValue('CurrencyMst','Name',['AutoId'=>1,"status"=>1]);
 */

 if (!function_exists('GetColumnValue')) {
	function GetColumnValue($table,$column,$condition){
		$ci=& get_instance();
		$ci->load->database();
		$columnValue="";
		if($condition && count($condition) && $column){
			if ($ci->db->table_exists($table)){
				$ci->db->select($column); 
				$ci->db->where($condition); 
				$query =$ci->db->get($table);
				if($query){
					$result=$query->row();
					$columnValue= $result->$column;
				}
			}else{
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Table does not exist -- '.$table);
			}
		}else{
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Table does not exist -- '.$table);
		}
		return $columnValue;
	}
}
/**
 * Get Single column value passing multiple condition
 * Ex => GetColumnsValue('CurrencyMst','Name',['AutoId'=>1,"status"=>1]);
 */
if (!function_exists('GetColumnsValue')) {
	function GetColumnsValue($table,$column,$condition,$return_type=0){
		$ci=& get_instance();
		$ci->load->database();
		$result=[];
		if($condition && count($condition) && $column){
			if ($ci->db->table_exists($table)){
				$ci->db->select($column); 
				$ci->db->where($condition); 
				$query =$ci->db->get($table);
				//echo $ci->db->last_query();
				if($query){
					$result=$return_type == 1?$query->row() : $query->result();
				}
			}else{
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Table does not exist -- '.$table);
			}
		}else{
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Table does not exist -- '.$table);
		}
		return $result;
	}
}
/*
** primary_table => Required Field
** select_column => Required Field (Array and you can not pass "*")
*condition  => Optional Field (Array)
*join_table OR like_query=> Optional Field (Array)
*order_by 	=> Optional Field (Array)
$params=[
  	"primary_table" =>"UserMst",
	"select_column" =>['AutoId','Name','Email','Phone'],
  	"condition"     =>['AutoId'=>4332,"status"=>1],
    "join_table"    =>[
        "table" =>[
            'Request'       =>['AutoId','ReqNo','Name','Email','CompanyName'],
            'BillDetails'   =>['AutoId','BillNumber','BillDate','Amount','PONumber','BilledCompany'],
        ],
        "on_condition" =>[
            'Request'       =>["condition" =>"UserMst.AutoID = Request.UserID","join_type"=>"inner"],
            'BillDetails'   =>["condition" =>"Request.AutoID = BillDetails.ReqID","join_type"=>"inner"],
        ],
    ],
    "like_query"    =>[
        "column_name"   =>['Phone','Name'],
        "column_value"  =>['9811154793','Sanwar Kanoria'],
    ],
    "order_by"  =>["UserMst.Phone"=>"asc","UserMst.Name"=>"desc"],
	"other_condition"     =>['UserMst.is_active'=>0,"UserMst.IsStatus"=>1],
];
$response= GetMultipleColumnValues($params,$return_type=0);
*/

if (!function_exists('GetMultipleColumnValues')) {
	function GetMultipleColumnValues($params=[],$return_type=0){
		$ci=& get_instance();
		$ci->load->database();
		$result=[];
		//check params are avaliable or not
		if($params && count($params) > 0){
			$primary_table				=$params['primary_table'];

			$primary_condition_arr=[];
			foreach($params['condition'] as $column => $value){
				$primary_condition_arr[$primary_table.'.'.$column] =$value;
			}
			$primary_column_arr	=$params['select_column'];
			$primary_columns	="";

			foreach($primary_column_arr as $primary_column){
				$primary_columns.=$primary_table.'.'.$primary_column.' as '.$primary_table.'_'.$primary_column.',';
			}
			$primary_columns	= rtrim($primary_columns,',');

			$join_query_arr 	=$params['join_table'];
			$like_query_arr 	=$params['like_query'];
			$order_by_arr 		=$params['order_by'];

			if($primary_table &&  $primary_columns){
				if ($ci->db->table_exists($primary_table)){
					//join table selected column name
					if($join_query_arr && count($join_query_arr) > 0 && $join_query_arr['table'] && count($join_query_arr['table']) > 0 && count($join_query_arr['table']) ==  count($join_query_arr['on_condition']) && count($like_query_arr) != 2){
						$primary_columns .=joinQueryColumnNameAlish($join_query_arr);
					}
					$ci->db->select($primary_columns); 
					$ci->db->from($primary_table);

					//join table condition query
					if($join_query_arr && count($join_query_arr) > 0  && $join_query_arr['on_condition'] && count($join_query_arr['on_condition']) > 0 && count($join_query_arr['table']) ==  count($join_query_arr['on_condition'])  && count($like_query_arr) != 2){
						foreach($join_query_arr['on_condition'] as $table_name => $condition){
							$ci->db->join($table_name, $condition['condition'],$condition['join_type']);
						}
					}
					//Primary table  condition with Like query
					if(count($like_query_arr) == 2){
						if(count($like_query_arr['column_name']) > 0 && count($like_query_arr['column_value']) > 0){
							$ci->db->like($like_query_arr['column_name'][0], $like_query_arr['column_value'][0]);
							for($i=1; $i < count($like_query_arr['column_name']); $i++){
								$ci->db->or_like($like_query_arr['column_name'][$i], $like_query_arr['column_value'][$i]);
							}
						}
					}

					if(count($primary_condition_arr) > 0){
						$ci->db->where($primary_condition_arr); 
					}
					if(count($params['other_condition']) > 0){
						$ci->db->where($params['other_condition']); 
						
					}
					if(count($params['or_condition']) > 0){
						$ci->db->or_where($params['or_condition']); 
						
					}
					//Orderby query
					if(count($order_by_arr) > 0){
						foreach($order_by_arr as $column => $orderby_type){
							$ci->db->order_by($column, $orderby_type);
						}
					}
					try {
						$query =$ci->db->get();
						//echo $ci->db->last_query();
						if($query){
							$result=$return_type == 1?$query->row() : $query->result();
						}else{
							log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Executed Query : '. $ci->db->last_query());
						}
					} catch (Exception $e) {
						echo "Error message: " . $e->getMessage();
					}
					
					
				}
			}
		
		}else{
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Params Missing');
		}

		return $result;
		
	}
}

/**
 * Get Total record found
 * table name is required
 * condition is optional
 * Ex => GetTotalRecords('UserMst',['AutoId'=>4332,"status"=>1]);
 */
if (!function_exists('GetTotalRecords')) {
	function GetTotalRecords($table,$condition=[]){
		$ci=& get_instance();
		$ci->load->database();
		$count=0;
		if ($ci->db->table_exists($table)){
			$ci->db->select('*');
			if(count($condition) > 0){
				$ci->db->where($condition); 
			}
			$q =$ci->db->get($table);
			$count=$q->num_rows();
			//echo $ci->db->last_query();
		}else{
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Error Message : Table does not exist -- '.$table);
		}
		return $count;
	}
}
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
if (!function_exists('checkIsUsed')) {
	function checkIsUsed($table,$column,$value,$condition=[]){
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

if (!function_exists('GetAllRecord')) {
	function GetAllRecord($tblName = '', $whereArr = []){
		$ci=&get_instance();
		$ci->load->library('session');
		$ci->load->database(); 
		$ci->db->select('*');
		$ci->db->from($tblName);
		//$ci->db->where('IsDelete', 0);
		if(count($whereArr) > 0){
			$ci->db->where($whereArr);
		}
		$query = $ci->db->get();
		return $query->result('array');
	}
}

if (!function_exists('delete_directory')) {
	function delete_directory($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				else
					delete_directory($dirname.'/'.$file);    
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}
}
function getQRScanHistory($travelId){
	$ci=&get_instance();
	$ci->load->database(); 
	$query=$ci->db->select("qsh.*,rm.Name as ScanedByName ");
	$ci->db->where('TravelDetailID',$travelId);
	$ci->db->from('QRScanHistory as qsh');
	$ci->db->join('RegisterMST as rm','rm.AutoID = qsh.ScanedBy','LEFT');
	$query=$ci->db->get();
	if($query){
		return $query->result();
	}else{
		return false;
	}
}
/**
 * QR Code Use - name
 */
function QrCodeUsesUserName($qrcode){
	$ci=&get_instance();
	$ci->load->database(); 
	$ci->db->select('Name');
	$ci->db->from('TravelDetails');
	$ci->db->where('QrCodeNo', $qrcode);
	$query=$ci->db->get();
	if($query){
		$row=$query->row();
		return $row->Name;
	}else{
		return '';
	}
}
function getTravelsData($id,$type){
	$ci=&get_instance();
	$ci->load->database(); 
	$ci->db->select('td.*');
	$ci->db->from('TravelHead as th');
	$ci->db->join('TravelDetails as td','th.AutoID = td.TravelHeadId','LEFT');
	$ci->db->where('th.AutoID', $id);
	$ci->db->where('td.Type', $type);
	$query=$ci->db->get();
	if($query){
		return $query->result();
	}else{
		return false;
	}
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
        CURLOPT_SSL_VERIFYHOST => 0,/* Ignore SSL certificate verification */
		CURLOPT_SSL_VERIFYPEER => 0,
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    if($response){
        $responseData = json_decode($response);
        if($responseData->status == 'OK'){
            return $responseData->results[0]->formatted_address;
        }else{
            return $responseData->error_message;
        }
    }else{
        return NULL;
    }
   

}

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

function masking($value,$start){
	$replacementString = str_repeat("x", $start);
  	$mask_number =  substr_replace($value, $replacementString, 0, $start);
    return $mask_number;
}

function pushNotification($to, $title, $message, $img = "", $datapayload = ""){
	$msg = urlencode($message);
	$data = array(
		'title'=>$title,
		'sound' => "default",
		'msg'=>$msg,
		'data'=>$datapayload,
		'body'=>$message,
		'color' => "#79bc64"
	);
	if($img){
		$data["image"] = $img;
		$data["style"] = "picture";
		$data["picture"] = $img;
	}
	$fields = array(
		'to'=>$to,
		'notification'=>$data,
		'data'=>$datapayload,
		"priority" => "high",
	);
	//for test push-notificaction(firebase)
	$SERVER_API_KEY='AAAAvq1M-T0:APA91bHRP2spXd3hFyh87Y13Y90_LX7r_SPOcKNqc2SMKHRauL2--hC4nnTaoGPJ9IeWOvVRdCLXT-jNhzyMtvrh8W-CKzeIBp3OJEaYwCYMhtP6FVnp-z5ihiX3c2ltI68PmQxyPLfE'; 

	$headers = array(
		'Authorization: key='.$SERVER_API_KEY,
		'Content-Type: application/json'
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	curl_close( $ch );
	return $result;
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