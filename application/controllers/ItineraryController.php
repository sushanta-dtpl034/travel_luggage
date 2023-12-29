<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItineraryController extends CI_Controller {
    function __construct(){
        parent::__construct();
        $username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
        $this->load->library('form_validation');
		$this->load->library('upload');
        $this->load->model('Commonmodel');
        $this->load->model('ItineraryModel');
    }
    function index(){
        $data['page_title'] = 'Itinerary  List';
		$data['page_name'] = "Itinerary  List";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/itinerary_list',$data);
		$this->load->view('include/admin-footer');
    }

}