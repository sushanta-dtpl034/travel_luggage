<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

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
	  $this->load->model('Commonmodel');
	  $this->load->model('Mastermodel');
      $this->load->model('Servicemodel');
	  $this->load->library('phpmailer_lib');
	}
	
    public function services_list()
	{

		
        $data['page_title'] = 'Services List';
		$data['page_name'] = "List of Services";
		$this->load->view('include/admin-header',$data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$this->load->view('sysadmin/service_list');
		$this->load->view('include/admin-footer');
	}
	public function service_save(){

		$service_name= $this->input->post('service_name');
        $service_Active = $this->input->post('service_Active');    
		$this->form_validation->set_rules('service_name', 'Service Name', 'required|is_unique[ServiceMST.ServiceName]');
        $this->form_validation->set_rules('service_Active', 'Service Active', 'required');
		if ($this->form_validation->run() == FALSE)
		{
		  echo json_encode(array('status' => 0));
		}
		else
		{

			$data = array(
			'ServiceName'=>$service_name,
			'isActive'=>$service_Active,
			'CreatedBy'=>$this->session->userdata('userid'),
			'CreatedDate'=>date('Y-m-d'),
			);
			$resultId = $this->Commonmodel->common_insert('ServiceMST',$data);
			if($resultId){
			echo json_encode(array('status' => 1));
			}else{
			echo json_encode(array('status' => 0));
			}

		}

	}
	public function getservices(){

		$result = $this->Servicemodel->getservices();
		$json_data['data'] = $result;
		echo  json_encode($json_data);

	}

	
	public function update_service(){

        $up_servicename = $this->input->post('up_servicename');
        $up_serviceactive = $this->input->post('up_serviceactive');
	      $updateid = $this->input->post('updateid');
			$this->form_validation->set_rules('up_servicename', 'Service Name', 'required');
			if ($this->form_validation->run() == FALSE)
			{
			  return FALSE;
			}
			else
			{

				$data = array(
				'ServiceName'=>$up_servicename,
                'isActive'=>$up_serviceactive,
				'ModifyBy'=>$this->session->userdata('userid'),
				'ModifyDate'=>date('Y-m-d'),
				);


				$where = array(
					'AutoID'=>$updateid,
				);


				$resultId = $this->Commonmodel->common_update('ServiceMST',$where,$data);
				if($resultId){
				   echo json_encode(array('status' => 1));
				}else{
				   echo json_encode(array('status' => 0));
				}

			}

}
public function delete_service(){
	$id = $this->input->post('id');
	$data = array(
			'IsDelete'=>1,
			'DeleteBy'=>$this->session->userdata('userid'),
			'DeleteDate'=>date('Y-m-d')	
		);
		$where = array(
			'AutoID'=>$id,
		);

		$resultId = $this->Commonmodel->common_update('ServiceMST',$where,$data);
	echo TRUE;
}


public function getoneservice(){
    $id = $this->input->post('id');
    $result = $this->Servicemodel->getoneservice($id);
    
    $response = array(
        "ServiceName" => $result->ServiceName,
        "active" => $result->isActive,
        "id" => $result->AutoID
     );

     echo json_encode( array("status" => 1,"data" => $response) );
    
  }
 
  
}