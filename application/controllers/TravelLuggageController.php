<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TravelLuggageController extends CI_Controller {
    function __construct(){
        parent::__construct();
        // Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
        
        
        $this->load->library('form_validation');
		$this->load->library('upload');
        $this->load->model('Commonmodel');
        $this->load->model('TravelLuggageModel');
        $this->load->model('Qrcodemodel');
    }
    function index(){
       $username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
        if (!isset($username) && !isset($userid)) {
			redirect('Login');
		}
        $data['page_title'] = 'Travel Luggage  List';
		$data['page_name'] = "Travel Luggage  List";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/travel_luggage_list',$data);
		$this->load->view('include/admin-footer');
    }
    function getTravelLuggageList(){
        $IsAdmin = $this->session->userdata('userisadmin');
		$data['data'] = $this->TravelLuggageModel->getTravelLuggageList();
		echo  json_encode($data);
    }
    /**
     * QR code after Scan caller want to call luggage owner
     */
    function updateCallerInfo(){
        $qrcode=$this->input->post('qrcode');
        $alertuserid=$this->input->post('alertuserid');
        $status=$this->input->post('status');
        $name=$this->input->post('name');
        $countryCode= $this->input->post('CountryCode');
        $mobileNo= $this->input->post('mobileNo');
        $latitude =$this->input->post('latitude');
        $longitude =$this->input->post('longitude');
        $ipaddress =$this->input->post('ipaddress');
        if(!empty($latitude) && !empty($longitude)){
            $google_address= getGoogleAddressByLatLong($latitude,$longitude);
        }else{
            $google_address=null;
        }
        //status => 1-Scan, 2-Call on owner, 3- Call in Whatsapp,4-Email
        $scanned_data=[
			'TravelDetailID'    =>$alertuserid,
			'QrcodeNo'          =>$qrcode,
			'CallerName'        =>$name,
			'CallerMobile'      =>$countryCode.' '.$mobileNo,
			'Status'            =>$status,
			'ScanedBy'          =>0,
			'Lattitude'         =>$latitude,
			'Longitude'         =>$longitude,
			'Ipaddress'         =>$ipaddress,
			'CreatedBy'         =>0,
			'CreatedDate'       =>date('Y-m-d H:i:s'),
			'Address'           =>$google_address
		];
		$this->Commonmodel->common_insert('QRScanHistory',$scanned_data);
		echo json_encode(['status' =>200]);
    }
    function update_scan_history(){
		$Lattitude =$this->input->post('Lattitude');
        $Longitude =$this->input->post('Longitude');
        $clientIP =$this->input->post('clientIP');
        $qrCode =$this->input->post('qrCode');
	/* 	$ciphering = "AES-128-CTR";
		$options = 0;
		$decryption_iv = '1234567891011121';
		// Store the decryption key
		$decryption_key = "dahliatech";
		$refno=openssl_decrypt ($refNo, $ciphering,$decryption_key, $options, $decryption_iv)??0;
		 */
        $qrcode_data =$this->Qrcodemodel->getid_from_qrdata($qrCode);
        if(!empty($Lattitude) && !empty($Longitude)){
            $google_address= getGoogleAddressByLatLong($Lattitude,$Longitude);
        }else{
            $google_address=null;
        }

		//status => 1-Scan, 2-Call on owner, 3- Call in Whatsapp,4-Email
		//Qr Code scanned record add
		$scanned_data=[
			'TravelDetailID'    =>$qrcode_data->alertedUserId,
			'ScanedBy'          =>0,
			'Lattitude'         =>$Lattitude,
			'Longitude'         =>$Longitude,
			'Ipaddress'         =>$clientIP,
            'QrcodeNo'          =>$qrCode,
            'Status'            =>1,
			'CreatedBy'         =>0,
			'CreatedDate'       =>date('Y-m-d H:i:s'),
			'Address'           =>$google_address
		];
        $timeDifferenceInHour = $this->TravelLuggageModel->getTimeDifference();//
        if($timeDifferenceInHour > 1){
            $this->Commonmodel->common_insert('QRScanHistory',$scanned_data);
            echo json_encode(['status' =>201]);
        }else{
            echo json_encode(['status' =>400]);
        }
	    
	}
}