<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TravelLuggageController extends CI_Controller {
    function __construct(){
        parent::__construct();
        // Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
        
        $username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
        $this->load->library('form_validation');
		$this->load->library('upload');
        $this->load->model('Commonmodel');
        $this->load->model('TravelLuggageModel');
    }
    function index(){
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

}