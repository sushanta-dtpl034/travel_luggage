
<?php 
class Authenticate
{

    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();

        if(!isset($this->CI->session)){  //Check if session lib is loaded or not
              $this->CI->load->library('session');  //If not loaded, then load it here
        }
    }

   function loginCheck()
   {
            $session_userdata = $this->CI->session->userdata('logged_in');
            if($session_userdata['uid']=="XYZ")
            {
              echo "Valid User"; //it wont get inside this if
            }
      
    }
}
?>