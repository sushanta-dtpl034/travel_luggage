<?php 
class Crud extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	/*load Model*/
	$this->load->model('Crud_model');
	}
        /*Insert*/
	public function savedata()
	{
		/*load registration view form*/
		$this->load->view('insert');
	
		/*Check submit button */
		if($this->input->post('save'))
		{
		    $data['name']=$this->input->post('name');
			$data['age']=$this->input->post('age');
			$data['email']=$this->input->post('email');
			$user=$this->Crud_model->saverecords($data);
			if($user>0){
			    echo "Records Saved Successfully";
			}
			else{
			    echo "Insert error !";
			}
		}
	}
	
	
}
?>