<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Wlguserlist Library
 *
 * @package libraries
 * @subpackage Wlguserlist
 * @since 01-03-2023
 * @link application\libraries\Wlguserlist.php
 * @author Dahlia Technologies Private Ltd.
 */
class Wlguserlist
{
    private $CI;
    public function __construct()
    {
        $this->CI = & get_instance();
    }

    /**
     * Get Token
     *
     * @return void
     */
    function getDirectoryToken()
    {
        // $appsettingsdata = $this->CI->Users_model->getAppSettings('directory');
        $response = "Settings not enabled";
        // $config['directory_endpoint'] = 'https://wilhloesch.com/directory/api/index.php/Userapi/UserList';

        // $config['directory_endpoint_login'] = 'https://wilhloesch.com/directory/api/index.php/Login/validate_login';

        // $config['directory_UserID'] = 'superadmin';

        // $config['directory_Password'] = '123456';
        $userId = 'superadmin';//$this->CI->config->item('directory_UserID');
        $password = '123456';//$this->CI->config->item('directory_Password');
        $params['url'] = 'https://wilhloesch.com/directory/api/index.php/Login/validate_login';//$directory_endpoint;
        $params['method'] = 'POST';
        $params['post_data'] =  array('UserEmail' => $userId,'Password' => $password);
        $response = $this->commonCurlResponse($params);
        return $response;
    }


   /**
     * Gre user data
     * @return string
     */
    function getUserData($token = '',$pageNumber = 1)
    {
        $calledFirstTime = 0;
        if(empty($token)){
            $directorytoken = $this->getDirectoryToken();
            if(empty($directorytoken) || !isset(json_decode($directorytoken)->token)){
                return false;
            }
            $token =  json_decode($directorytoken)->token;
            $calledFirstTime = 1;
        }

        $params['token'] = $token;
        $params['url'] = 'https://wilhloesch.com/directory/api/index.php/Userapi/UserList';
        $params['method'] = "POST";
		$params['post_data'] = array('pageSize' => '200','pageNumber' => $pageNumber,'keyword' => '');
        $userdata =  $this->commonCurlResponse($params);
        if(empty($userdata)){
            return false;
        }
        $userarr = json_decode($userdata,true);
        return $userarr;
    }

    /**
     * Update User's data
     *
     * @return void
     */
    function updateUsersData($token = '',$pageNumber = 1){    

        $userarr = $this->getUserData($token,$pageNumber);
        // echo "<br><br> ============== PAGE ".$pageNumber." ==================================<br><br>";
        // pr( $userarr,1);
        return $userarr;
    }

    /**
    * Common cURL Response
    */
    function commonCurlResponse($params = [])
    {
        $post_data = !empty($params['post_data']) ? $params['post_data'] : '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $params['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $params['method']);
        if(isset($params['token']) && !empty($params['token'])){
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Auth-Token: '.$params['token']]);
        }
        
        if(!empty($post_data )){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
 
    /**
     * Save LOG
     */
    function saveLog($data)
    {
        $file_name = 'file_'.date("Y-m-d").'.html';
        $file_path = './upload/cron_log/ad_' . $file_name;
        if (is_writable($file_path) || 1) {
            if (!$handle = fopen($file_path, 'a')) {
               // echo "Cannot open file ($file_path)";
                exit;
            }
            if (fwrite($handle, $data . "\n") === FALSE) {
               // echo "Cannot write to file ($file_path)";
                exit;
            }
            fclose($handle);
        } else {
          //  echo "The file $file_name is not writable";
        }
        return true;
    }

}