<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Description of Utility Library
 *
 * @category libraries
 * 
 * @package libraries
 *
 * @module Utility
 * 
 * @class Utility.php
 * 
 * @path application\libraries\Utility.php
 */
class Utility{
    private $CI;
    public function __construct(){
        $this->CI = &get_instance();
    }

    

    /**
     * Add update delete custom fields for category, subcategory & further classification
     *
     * @param integer $is_inserted
     * @param integer $CategoriesType
     * @return void
     */
    function manageCustomFieldsForCategories($is_inserted = 0, $CategoriesType = 0){
        $FieldName_new = $this->CI->input->post('FieldName_new', TRUE);
        $FieldType_new = $this->CI->input->post('FieldType_new', TRUE);
        $SubFieldType_new = $this->CI->input->post('SubFieldType_new', TRUE);
        $MasterTypeID_new = $this->CI->input->post('MasterTypeID_new', TRUE);
        $Currency_new = $this->CI->input->post('Currency_new', TRUE);
        $CurrencyUniCode_new = $this->CI->input->post('CurrencyUniCode_new', TRUE);
        $Optiontype_new = $this->CI->input->post('Optiontype_new', TRUE);
        $AdvanceSearch_new = $this->CI->input->post('AdvanceSearch_new', TRUE);
        $OptionName_new = $this->CI->input->post('OptionName_new', TRUE);
        $Thirdpartyapi_new = $this->CI->input->post('Thirdpartyapi_new', TRUE);
        $IsRequired_new = $this->CI->input->post('IsRequired_new', TRUE);
        $CustomField_ID = $this->CI->input->post('CustomField_ID', TRUE);
        $custFieldAutoId = $this->CI->input->post('custFieldAutoId', TRUE);
        $addToCustomLibrary = $this->CI->input->post('addToCustomLibrary', TRUE);

        $position = 1;
        $final_data = array();
        $batchUpdateCF = array();
        $counter = 0;



        if (is_array($FieldName_new) && !empty($FieldName_new)) {
            foreach ($FieldName_new as $field_11s) {
                if (isset($custFieldAutoId) && is_array($custFieldAutoId) && isset($custFieldAutoId[$counter]) && $custFieldAutoId[$counter] > 0) {
                    //if update counter
                    $arr = array(
                        'AutoID' => $custFieldAutoId[$counter],
                        'position' => $position
                    );
                    array_push($batchUpdateCF, $arr);
                } else {

                    $optName = '';
                    
                    if (isset($OptionName_new[$counter]) && !empty($OptionName_new[$counter]) && $OptionName_new[$counter] != 'null') {
                        $optName = str_replace('#####', "'", $OptionName_new[$counter]);
                        $optName = "[" . str_replace(',', '","', json_encode($optName)) . "]";
                    }

                    //common insert array for custom fields & master tabels
                    $commonFieldsArr = [];
                    $commonFieldsArr = [
                        'FieldName' => $FieldName_new[$counter],
                        'FieldType' => $FieldType_new[$counter],
                        'FieldSubType' => $SubFieldType_new[$counter],
                        'MasterTypeID' => (int) $MasterTypeID_new[$counter],
                        'Type' => !empty($Optiontype_new[$counter]) && $Optiontype_new[$counter] != 'null' ? $Optiontype_new[$counter] : '',
                        'Options' => $optName,
                        'AdvanceSearch' => !empty($AdvanceSearch_new[$counter]) && $AdvanceSearch_new[$counter] != 'null' ? $AdvanceSearch_new[$counter] : '',
                        'Currency' => !empty($Currency_new[$counter]) && $Currency_new[$counter] != 'null' ? $Currency_new[$counter]: '',
                        'CurrencyUniqueCode' => !empty($CurrencyUniCode_new[$counter]) && $CurrencyUniCode_new[$counter] != 'null' ? $CurrencyUniCode_new[$counter]: '',
                        'Thirdpartyapi' => (int) $Thirdpartyapi_new[$counter],
                        'IsRequired' => (int) $IsRequired_new[$counter],
                        'IsDelete' => 0,
                    ];

                    $CustomFieldsMstID = isset($CustomField_ID[$counter]) && $CustomField_ID[$counter] > 0 ? $CustomField_ID[$counter] : 0;
                    //Add update records in custom fields master table, only if "Add to Library" checkbox is checked
                    if ($CustomFieldsMstID < 1 && isset($addToCustomLibrary[$counter]) && $addToCustomLibrary[$counter] > 0) {
                        $CustomFieldsMstID = $this->addUpdateCustomFieldMaster($commonFieldsArr);
                    }

                    //insert new field
                    $arrCFExtra = array(
                        'CategoriesTypeID' => $is_inserted,
                        'CategoriesType' => $CategoriesType,
                        'position' => $position,
                        'CustomFieldsMstID' => $CustomFieldsMstID,
                    );

                    $insCustomFieldArr = array_merge($commonFieldsArr, $arrCFExtra);
                    array_push($final_data, $insCustomFieldArr);
                }

                $counter++;
                $position++;
            } //foreach

            if (is_array($final_data) && count($final_data) > 0) {
                $this->CI->db->insert_batch('CustomFields', $final_data);
            }

            if (is_array($batchUpdateCF) && count($batchUpdateCF) > 0) {
                $this->CI->db->update_batch('CustomFields', $batchUpdateCF, 'AutoID');
            }
        } //if post value exists
    }

    /**
     * Add / Update custom field master records
     *
     * @param array $commonFieldsArr
     * @return void
     */
    function addUpdateCustomFieldMaster($commonFieldsArr = []){

        $FieldName = $commonFieldsArr['FieldName'];
        $FieldType = $commonFieldsArr['FieldType'];

        //check if records with same field name field type alreday exists in master table
        $CustomFieldsMstID = $this->checkCustomFieldMasterAlreadyExists($FieldName, $FieldType);
        if ($CustomFieldsMstID > 0) {
            //record exists hence update
            $arrMstExtra = [];
            $arrMstExtra['ModifyDate'] = date("Y-m-d H:i:s");
            $arrMstExtra['ModifyUserID'] = $this->CI->session->userdata['logged_in']['AutoID'];
            $updCustomFieldMaster = array_merge($commonFieldsArr, $arrMstExtra);
            //update custom fields
            $this->CI->db->where('AutoID', $CustomFieldsMstID);
            $insCfm = $this->CI->db->update('CustomFieldsMST', $updCustomFieldMaster);
        } else {
            //record do not exists hence, insert into Custom Field Master Table
            $arrMstExtra = [];
            $arrMstExtra['CreatedDate'] = date("Y-m-d H:i:s");
            $arrMstExtra['ModifyDate'] = date("Y-m-d H:i:s");
            $arrMstExtra['CreatedBy'] = $this->CI->session->userdata['logged_in']['AutoID'];
            $arrMstExtra['ModifyUserID'] = $this->CI->session->userdata['logged_in']['AutoID'];
            $insCustomFieldMaster = array_merge($commonFieldsArr, $arrMstExtra);
            $insCfm = $this->CI->db->insert('CustomFieldsMST', $insCustomFieldMaster);
            if ($insCfm) {
                $CustomFieldsMstID = $this->CI->db->insert_id();
            }
        }

        return $CustomFieldsMstID;
    }

    //Check if custom field master already exists
    function checkCustomFieldMasterAlreadyExists($FieldName = '-1', $FieldType = '-1'){
        $this->CI->db->select('AutoID');
        $this->CI->db->where('FieldName', $FieldName);
        $this->CI->db->where('FieldType', $FieldType);
        $cfmquery = $this->CI->db->get('CustomFieldsMST');
        if ($cfmquery->num_rows() > 0) {
            return $cfmquery->row()->AutoID;
        }
        return 0;
    }
	
	function whatsappsms($params = []){
		$resultCnt =  $this->CI->db->query("select WhatsappAccess, whatsappToken, whatsappSecret, whatsappKey, whatsappTs, whatsappUrl, whatsappChType from SystemMst")->row();
		if($resultCnt->WhatsappAccess > 0){
			$mobilewithcountrycode = isset($params['mobilewithcountrycode']) ? $params['mobilewithcountrycode'] : '';
			$random_number = isset($params['random_number']) ? $params['random_number'] : '';

			if(empty($mobilewithcountrycode) || empty($random_number)){
				return false;
			}
			//WhatsApp API Call for OTP
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $resultCnt->whatsappUrl,
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
				"channel_type": "'.$resultCnt->whatsappChType.'",
				"send_now": "true",
				"event_name": "OTP",
				"to": "'.$mobilewithcountrycode.'",
				"context_variables": {
					"name": "Sir/Madam",
					"otp_for":"IRP",
					"otp":"'.$random_number.'",
					"teamname":"IRP"
				}
			}
			',
			CURLOPT_HTTPHEADER => array(
					'Input-token: '.$resultCnt->whatsappToken,
					'access-secret: '.$resultCnt->whatsappSecret,
					'access-key: '.$resultCnt->whatsappKey,
					'ts: '.$resultCnt->whatsappTs,
					'Content-Type: application/json'
				),
			));
			$output = curl_exec($curl);
			curl_close($curl);
            if($output){
                return true;
            }else{
                log_message('error','Error Generated Url : '.GetFullUrl());
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Whats App Error Message :'.$output);
                return false; 
            }
		}else{
            log_message('error','Error Generated Url : '.GetFullUrl());
			log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Whats App Error Message :Whats App Access Denied!.Ask Enable to Admin');
			return false;
		}
    }

    /**
     * Send Mail
     */
    function sendMail($params = []){
		$resultCnt =  $this->CI->db->query("select EmailHost, EmailAddress, EmailPass, EmailPort, EmailAddName, EmailAccess from SystemMst")->row();
		if($resultCnt->EmailAccess > 0){
			if (!isset($params['emailID']) || empty($params['emailID']) || !isset($params['message']) || empty($params['message']) || !isset($params['subject']) || empty($params['subject'])) {
				return FALSE;
			}
			$this->CI->load->library('phpmailer_lib');
			$emailID = $params['emailID'];
			//$message = $this->CI->config->item('email_header');
			$message .= $params['message'];
			//$message .= $sysresponse->EmailFooter;
			//$message .= $this->CI->config->item('email_footer');
			$subject = $params['subject'];
			$mail = $this->CI->phpmailer_lib->load();
			$mail->isSMTP();
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			$mail->Host     = $resultCnt->EmailHost;
			$mail->SMTPAuth = false;
			$mail->Username = $resultCnt->EmailAddress;
			$mail->Password = $resultCnt->EmailPass;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Port     = $resultCnt->EmailPort;
			$mail->setFrom($resultCnt->EmailAddress, $resultCnt->EmailAddName);
			$mail->addReplyTo($resultCnt->EmailAddress, $resultCnt->EmailAddName);
			$mail->addAddress($emailID);

			//this code is to debug on sandbox
			/* if(strpos(base_url(), 'ngrok.io') !== false || strpos(base_url(), 'sandbox') !== false || strpos(base_url(), 'localhost') !== false){
				//$mail->addCC('sisir.behura@dahlia.tech');
				$expurl = explode("//", base_url());
				if(count($expurl) > 0 && isset($expurl[1])){
					$subject .= " - ".$expurl[1];
				} else {
					$subject .= " - ".$expurl[0];
				}
			} */

			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $message;

			if (!$mail->send()) {
				$message = 'not_sent';
				if(isset($params['sendErrorInfo'])){
					return $mail->ErrorInfo;
				}
				//we need to log this error message instead of throwning error to user
				'Mailer Error: ' . $mail->ErrorInfo;
                log_message('error','Error Generated Url : '.GetFullUrl());
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => Mailer Error Message :'.$mail->ErrorInfo);
			} else {
				$message = 'sent';
			}
			return $message;
		}else{
			return false;
		}
    }
	
	function Sendsms($mobile,$message){ 
		$resultCnt =  $this->CI->db->query("select SMSURL, SMSUserID, SMSPass, SMSSender, SmsAccess from SystemMst")->row();
		if($resultCnt->SmsAccess > 0){
			$strUserName=$resultCnt->SMSSender;
			$strPassword=$resultCnt->SMSPass;
			$strSenderId=$resultCnt->SMSUserID;
			$strMobile=$mobile;
			$strMessage=$message;
			$postData = array(
				'mobile' => $strUserName,
				'pass' => $strPassword,
				'senderid' => $strSenderId,
				'to' => $strMobile,
				'msg' => $strMessage
			);
			$url= $resultCnt->SMSURL;/* API URL*/
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
                log_message('error','Error Generated Url : '.GetFullUrl());
				log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => SMS Error Message :'.$output);
                return false; 
            }
		}else{
            log_message('error','Error Generated Url : '.GetFullUrl());
            log_message('error','File Name: ' . basename(__FILE__) . ', Function Name: ' . __FUNCTION__ .', => SMS Error Message : SMS Access Denied!. Enabled to Admin');
			return false;
		}
	}
	//for upload image
	function uploadImage($params = []){
		$config['upload_path'] = $params['path'];
		$config['allowed_types'] = $params['type'];
		$new_name = time();
		$config['file_name'] = $new_name.$p;
		if(!empty($params['max_size'])){ $config['max_size'] = $params['max_size']; }
		if(!empty($params['max_width'])){ $config['max_width'] = $params['max_width']; }
		if(!empty($params['max_height'])){ $config['max_height'] = $params['max_height']; }
		// load upload library
		$this->CI->load->library('upload', $config);
		// check new file is exit
		if(!empty($params['new_file'])){
			// get delete old file if exit
			if(!empty($params['old_file'])){
				$delete_file = $params['path'].$params['old_file'];
				unlink($delete_file);
			}
			// get upload
			if ( ! $this->CI->upload->do_upload($params['field'])){
				$this->CI->session->set_flashdata('error', $this->CI->upload->display_errors());
			}else{
				$file_data = $this->CI->upload->data();
				$file = $file_data['file_name'];
			}
		}else{
			// Set old file if new file not choose.
			$file = $params['old_file'];
		}
		return  $file;
	}
	
	//convert Currency
	function convertCurrency($amount,$taxamount,$from_currency,$to_currency){
		$apikey = '79dc90d28be247dcad4dabce8190c857';
		$from_Currency = urlencode($from_currency);
		$to_Currency = urlencode($to_currency);
		$query =  "{$from_Currency}_{$to_Currency}";
		// change to the free URL if you're using the free version
		$json = file_get_contents("https://api.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
		$obj = json_decode($json, true);
		$val = floatval($obj["$query"]);
		$total = $val * ($amount+$taxamount);
		$exchangeRate= number_format($total, 3, '.', '');
		$convertedAmount = ($amount+$taxamount)*$val;
		$data = array('exhangeRate' => $val,'convertedAmount' =>$convertedAmount,'fromCurrency' => strtoupper($from_Currency), 'toCurrency' => strtoupper($to_Currency));
		return $convertedAmount;
	}
	
	function getRecords($params = []){
        if (!isset($params['table'])) {
            return FALSE;
        }
        $fields = '*';
        if (isset($params['fields'])) {
            if (is_array($params['fields'])) {
                $fields = implode(',', $params['fields']);
            } else {
                $fields = $params['fields'];
            }
        }
        $this->CI->db->select($fields, FALSE);//throwing error when adding distinct in query hence added FALSE in secind param.
        $this->setWhere($params);
        if (isset($params['groupBy']) && !empty($params['groupBy'])) {
            $this->CI->db->group_by($params['groupBy']);
        }

        if (isset($params['orderBy']) && !empty($params['orderBy']) && isset($params['sortOrder']) && !empty($params['sortOrder'])) {
            $this->CI->db->order_by($params['orderBy'], $params['sortOrder']);
        }
        if (isset($params['orderByMulti']) && !empty($params['orderByMulti'])) {   
            $this->CI->db->order_by($params['orderByMulti']);
        }

        if (isset($params['length']) && $params['length'] > 0) {
            $this->CI->db->limit($params['length']);
        }
        if (isset($params['start'])) {
            $this->CI->db->offset($params['start']);
        }
       
        $outerjoin = '';
        if (isset($params['outerjoinmain'])) {
            $outerjoin = " ".$params['outerjoinmain'];
        }
        $tableName = $params['table'];
        $query = $this->CI->db->get($tableName.$outerjoin);        
        //echo $this->CI->db->last_query(); 
        if( $this->CI->input->post('dq',TRUE) > 0 || $this->CI->input->get('dq',TRUE) > 0){
            echo $this->CI->db->last_query(); 
            if ($this->CI->input->post('dq',TRUE) == 1 || $this->CI->input->get('dq',TRUE) == 1) {
                exit;
            }
        }

        if ($query !== FALSE && isset($params['returncount'])) {
            return $query->num_rows();
        }

        //echo $this->CI->db->last_query();
        if ($query !== FALSE && $query->num_rows() > 0) {
            if (isset($params['return']) && $params['return'] == 'row') {
                return $query->row();
            } else if (isset($params['return']) && $params['return'] == 'row_array') {
                return $query->row_array();
            }
            return $query->result_array();
        }
        return FALSE;
    }
	
	function getRecordsCounts($params = []){
        if (!isset($params['table'])) {
            return FALSE;
        }
        $fields = '*';
        if (isset($params['fields'])) {
            if (is_array($params['fields'])) {
                $fields = implode(',', $params['fields']);
            } else {
                $fields = $params['fields'];
            }
        }
        $this->CI->db->select($fields, FALSE);//throwing error when adding distinct in query hence added FALSE in secind param.
        $this->setWhere($params);
        if (isset($params['groupBy']) && !empty($params['groupBy'])) {
            $this->CI->db->group_by($params['groupBy']);
        }
       
        $outerjoin = '';
        if (isset($params['outerjoinmain'])) {
            $outerjoin = " ".$params['outerjoinmain'];
        }
        $tableName = $params['table'];
        $query = $this->CI->db->get($tableName.$outerjoin);        
        //echo $this->CI->db->last_query(); 
        if( $this->CI->input->post('dq',TRUE) > 0 || $this->CI->input->get('dq',TRUE) > 0){
            echo $this->CI->db->last_query(); 
            if ($this->CI->input->post('dq',TRUE) == 1 || $this->CI->input->get('dq',TRUE) == 1) {
                exit;
            }
        }
        if ($query !== FALSE && $query->num_rows() > 0) {
            return $query->num_rows();
        }
        return FALSE;
    }

    /**
     * Set where condition
     */
    function setWhere($params){
        /* ex: $params['joins']['country'] = ['joinon' => 'country.country_id = state.country_id','type' => 'left']; */
        if (isset($params['joins']) && is_array($params['joins']) && !empty($params['joins'])) {
            foreach ($params['joins'] as $key => $value) {
                if (isset($value['type'])) {
                    $this->CI->db->join($key, $value['joinon'], $value['type']);
                } else {
                    $this->CI->db->join($key, $value['joinon']);
                }
            }
        }
        if (!isset($params['ignoreDelete'])) {
            $deleteColumn = (isset($params['tableAlias']) ? $params['tableAlias'] . '.' : '') . 'IsDelete';
            $this->CI->db->group_start();
            $this->CI->db->where($deleteColumn,0);
            $this->CI->db->or_where($deleteColumn.' IS NULL', NULL, FALSE);
            $this->CI->db->group_end();
        }

        if (isset($params['AutoID']) && $params['AutoID'] > 0) {
            $this->CI->db->where((isset($params['tableAlias']) ? $params['tableAlias'] . '.' : '') . 'AutoID', $params['AutoID']);
        }

        if (isset($params['where']) && !empty($params['where'])) {
            $this->CI->db->where($params['where'], NULL, false);
        }

        if(isset($params['multiple_where'])){
            foreach($params['multiple_where'] as $fld => $val){
                $this->CI->db->where($fld,$val);
            }
        }

        if(isset($params['multiple_where_in'])){
            foreach($params['multiple_where_in'] as $fld => $val){
                $this->CI->db->where_in($fld,$val);
            }
        }

        if(isset($params['multiple_where_not_in'])){
            foreach($params['multiple_where_not_in'] as $fld => $val){
                $this->CI->db->where_not_in($fld,$val);
            }
        }

        if(isset($params['multiple_or_where'])){
            $this->CI->db->group_start();
            $v=1;
            foreach($params['multiple_or_where'] as $fld => $val){
                if($v==1){
                    $this->CI->db->where($fld,$val);
                } else{

                }
                $this->CI->db->or_where($fld,$val);
                $v++;
            }
            $this->CI->db->group_end();
        } 

        if(isset($params['multiple_or_where_in'])){
            $this->CI->db->group_start();
            $v=1;
            foreach($params['multiple_or_where_in'] as $fld => $val){
                if($v==1){
                    $this->CI->db->where_in($fld,$val);
                } else{

                }
                $this->CI->db->or_where_in($fld,$val);
                $v++;
            }
            $this->CI->db->group_end();
        } 
       
        if ( isset($params['keyword']) && !empty($params['keyword']) && isset($params['searchFields']) && !empty($params['searchFields'])) {
            $keyword = $params['keyword'];
            //ex ['s.Name', 's.Type', 'c.Subtype'];
            $searchFields = $params['searchFields'];   
            $key = 0;
            $this->CI->db->group_start();
            foreach ($searchFields as $val) {
                if ($key != 0) {                   
                    $this->CI->db->or_like($val,$keyword);
                } else {
                    $this->CI->db->like($val,$keyword);
                }               
                $key++;
            }            
            $this->CI->db->group_end();
        }

        if (isset($params['having']) && !empty($params['having'])) {
            $this->CI->db->having($params['having']);
        }
    }

    /**
     * Return datatable response
     * @param array $params array for list data.
     * @return array to build datatable
     */
    function getDataTableList($params = []){
        $params['search'] = $this->CI->input->post('search', TRUE);
        $params['length'] = intval($this->CI->input->post('length', TRUE));
        $params['start'] = intval($this->CI->input->post('start', TRUE));
        $params['keyword'] = isset($params["search"]["value"]) ? trim($params["search"]["value"]) : '';
        $order = $this->CI->input->post('order', TRUE);
        $columns = $this->CI->input->post('columns', TRUE);
        //print_r($params['orderBy']);exit;
        if($params['orderBy'] == '' || $this->CI->input->post('draw', TRUE) != 1){
            $this->setOrderBy($order, $columns, $params['searchFields']); //calling automatically but user pass manually not override
        }
        $result = $this->getRecords($params);
        if($this->CI->input->post('dq',TRUE) == 1 || $this->CI->input->get('dq',TRUE) == 1){
            //echo "<br>". $this->CI->db->last_query();
        }
        if ($result === FALSE) {
            $result = [];
        }

        //if url encryption is ON
        if ($this->CI->config->item('url_encryption_on') && count($result) > 0) {
            foreach ($result as $key => $val) {
                if (isset($val['AutoID'])) {
                    $result[$key]['AutoID'] = $this->utility_encrypt->encodeParam($val['AutoID']);
                } else {
                    //if we dont have primary key in query fields
                    break;
                }
            }
        }

        $draw = $this->CI->input->post('draw');
        $tableName = $params['table'];
		$sqlTotal = explode('ORDER', $this->CI->db->last_query())[0];
        //get total record
        //$this->setWhere($params);
        //$total = $this->CI->db->count_all_results($tableName);
		$total = $this->CI->db->query($sqlTotal)->num_rows();
		//$total = $this->getRecordsCounts($params);
        return [
            "msg" => "data found",
            "data" => $result,
            "draw" => $draw,
            "recordsTotal" => $total > 0 ? $total : 0,
            "recordsFiltered" => $total > 0 ? $total : 0
        ];
    }
	function outPutJson($params = [], $status = 200){
        //Keep this code. Needed when we turn on csrf token.            
        $this->CI->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($params));
    }
	function setOrderBy($order = [],$columns =[],$orderFieldName = []){
        if(is_array($order) && count($order) > 0) {
            foreach($order as $o)
            {                
                $columnNo = $o['column'];
                $dir = $o['dir'];
                //get datatable column name
                if(!empty($columns[$columnNo]['data'])) {
                    $tableColumnKey = strtolower($columns[$columnNo]['data']);
                    $orderFieldName = array_change_key_case($orderFieldName, CASE_LOWER);
                    if (isset($orderFieldName[$tableColumnKey])) {
                        $field = "(".$orderFieldName[$tableColumnKey].") ".$dir;
                        $this->CI->db->order_by($field);//
                        //$this->CI->db->order_by('CAST('.$field.' AS NVARCHAR(255)');
                    }                    
                }                
            }//foreach
        }        
    }
	public function SystemConfig(){
		$this->CI->db->select('*');
		$this->CI->db->from('SystemMst');
		$this->CI->db->where('CreatedBy', 1);
		$query = $this->CI->db->get();
		return $query->row();
	}
	public function GetRecordByID($id = '', $tblName = ''){
		$this->CI->db->select('*');
		$this->CI->db->from($tblName);
		$this->CI->db->where('AutoID', $id);
		$query = $this->CI->db->get();
		return $query->row();
	}
	public function GetRecordByColumnName($ClmnName = '', $ClmnVal = '', $tblName = ''){
		$this->CI->db->select('*');
		$this->CI->db->from($tblName);
		$this->CI->db->where($ClmnName, $ClmnVal);
		$query = $this->CI->db->get();
		return $query->row();
	}
	public function GetAllRecord($tblName = ''){
		$this->CI->db->select('*');
		$this->CI->db->from($tblName);
		$this->CI->db->where('IsDelete', 0);
		$query = $this->CI->db->get();
		return $query->result('array');
	}
	public function GetCurrencyById($id = ''){
		if($id != ''){
			$this->CI->db->select('Name');
			$this->CI->db->from(cUrrency);
			$this->CI->db->where('AutoID', $id);
			$query = $this->CI->db->get()->row();
			return $query->Name;
		}
	}
	public function GetAutoIdFromClmnName($ClmnName = '' , $tblName = ''){
		if($ClmnName != '' && $tblName != ''){
			$this->CI->db->select('AutoID');
			$this->CI->db->from($tblName);
			$this->CI->db->where('Name', $ClmnName);
			$query = $this->CI->db->get()->row();
			return $query->AutoID;
		}
	}
	
	public function getSelectedCurrency($id){
        $CurrencyID = implode(',',(array_values(json_decode($id))));
        $this->CI->db->select('AutoID,Name,Symbol');
        $this->CI->db->from(cUrrency);
        $where = "AutoID IN ($CurrencyID)";
        $this->CI->db->where($where);
        $query = $this->CI->db->get();
        return $query->result('array');
    }
   
}