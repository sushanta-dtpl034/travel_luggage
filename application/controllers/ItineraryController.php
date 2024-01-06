<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItineraryController extends CI_Controller {
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
    function getItineraryList(){
        $IsAdmin = $this->session->userdata('userisadmin');
		$data['data'] = $this->ItineraryModel->getItineraryList();
		echo  json_encode($data);
    }

    /**
     * Itinerary Details list Section
     */
    function itineraryDetailList($itineraryHeadId){
        $data['page_title'] = 'Itinerary Detail List';
		$data['page_name'] = "Itinerary Detail List";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('superadmin/itinerary_detail_list',$data);
		$this->load->view('include/admin-footer');
    }
    function getItineraryDetailList($itineraryHeadId){
        $IsAdmin = $this->session->userdata('userisadmin');
		$data['data'] = $this->ItineraryModel->getItineraryDetailList($itineraryHeadId);
		echo  json_encode($data);
    }
}