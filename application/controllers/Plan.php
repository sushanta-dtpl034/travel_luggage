<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
	  parent::__construct();
      $this->load->library('form_validation');
	  $this->load->model('Planmodel');
	}
	public function index()
	{
		$data['page_title'] = 'Plan';
		$this->load->view('header',$data);
		$data['result'] = $this->Planmodel->getactiveplan();
		$this->load->view('plan',$data);
		$this->load->view('footer');
     
	}
	public function planList()
	{
		$data['page_title'] = 'Plan List';
		$data['page_name'] = "Plan List";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('planlist',$data);
		$this->load->view('include/admin-footer');
	}
	public function savePlan(){

			$plan_name = $this->input->post('plan_name');
			$amount = $this->input->post('amount');
			$storage = $this->input->post('storage');
			$period = $this->input->post('period');	
			$days = $this->input->post('days');
			$active = $this->input->post('active');

			
	   $this->form_validation->set_rules('plan_name', 'Plan', 'required|is_unique[PlanMST.PlanName]');
	   $this->form_validation->set_rules('amount', 'Amount', 'required');
	   $this->form_validation->set_rules('storage', 'Storage', 'required');
	   $this->form_validation->set_rules('period', 'Period', 'required');
	   $this->form_validation->set_rules('days', 'Days', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array('status' => 0));
		}
		else
		{

			$data = array(
				'PlanName'=>$plan_name,
				'Price'=>$amount,
				'Storage'=>$storage,
				'TimePeriod'=>$period,
				'TotalDays'=>$days,
				'isActive'=>$active,
				'CreatedBy'=>1,
				'CreatedDate'=>date('Y-m-d'),
				);
		   $resultId = $this->Planmodel->savePlan($data);
		   if($resultId){
			     echo json_encode(array('status' => 1));
		   }else{
			    echo json_encode(array('status' => 0));
		   }

		}
	}
	public function getplan(){

	  $result = $this->Planmodel->getplan();
       $json_data['data'] = $result;
	  echo  json_encode($json_data);
	}
	
	public function getsingleplan(){
		$id = $this->input->post('id');
		$result = $this->Planmodel->getsingleplan($id);

		$response = array(
			"planname" => $result->PlanName,
			"amount" => $result->Price,
			"storage" => $result->Storage,
			"month" => $result->TimePeriod,
			"days" => $result->TotalDays,
			"active" => $result->isActive,
			"id" => $result->AutoID
		 );
   
		 echo json_encode( array("status" => 1,"data" => $response) );
		
	  }
	  public function updateplan(){

		$plan_name = $this->input->post('plan_name');
		$amount = $this->input->post('amount');
		$storage = $this->input->post('storage');
		$period = $this->input->post('period');	
		$days = $this->input->post('days');
		$active = $this->input->post('active');
		$updateid = $this->input->post('updateid');

   $this->form_validation->set_rules('plan_name', 'Plan', 'required');
   $this->form_validation->set_rules('amount', 'Amount', 'required');
   $this->form_validation->set_rules('storage', 'Storage', 'required');
   $this->form_validation->set_rules('period', 'Period', 'required');
   $this->form_validation->set_rules('days', 'Days', 'required');
	
	if ($this->form_validation->run() == FALSE)
	{
		   return FALSE;
	}
	else
	{

		$data = array(
			'PlanName'=>$plan_name,
			'Price'=>$amount,
			'Storage'=>$storage,
			'TimePeriod'=>$period,
			'TotalDays'=>$days,
			'isActive'=>$active,
			'ModifyBy'=>1,
			'ModifyDate'=>date('Y-m-d'),
			);
	   $resultId = $this->Planmodel->updateplan($data,$updateid);
	   if($resultId){
			 echo json_encode(array('status' => 1));
	   }else{
			echo json_encode(array('status' => 0));
	   }

	}
}

	public function deleteplan(){
		$id = $this->input->post('id');
		$data = array(
				'IsDelete'=>1,
				'DeleteBy'=>1,
				'DeleteDate'=>date('Y-m-d'),
				'ModifyDate'=>date('Y-m-d'),
			);

		$result = $this->Planmodel->deleteplan($id,$data);
	    echo TRUE;
	}
}
