<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authtoken
{


    public function __construct()
    {
        $this->CI = &get_instance();
		$this->tokenHandler = new TokenHandler();
    }

   public function token_data_get($auth_token)
  	{
		if (isset($auth_token)) {
		try
		{

			$jwtData = $this->tokenHandler->DecodeToken($auth_token);
			return json_encode($jwtData);
		}
		catch (Exception $e)
		{
			echo 'catch';
			http_response_code('401');
			echo json_encode(array( "status" => false, "message" => $e->getMessage()));
			exit;
		}
		}else{
		echo json_encode(array( "status" => false, "message" => "Invalid Token"));
		}
  	}

}
