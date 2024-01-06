<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Usercontroller extends CI_Controller
{

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
		// Prevent caching
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");

		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');
		if (!isset($username) && !isset($userid)) {
			redirect('Login');
		}
		$this->load->library('form_validation');
		$this->load->model('Planmodel');
		$this->load->model('Commonmodel');
		$this->load->model('Mastermodel');
		$this->load->model('Usermodel');
		$this->load->library('phpmailer_lib');
		$this->load->library('phpspreadsheet_lib');
		$this->load->model('Assetmodel');
		$this->load->library('upload');
	}



	public function user_list()
	{
		$data['page_title'] = 'User List';
		$data['page_name'] = "List of Users";
		$this->load->view('include/admin-header', $data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$data['group'] = $this->Commonmodel->get_groupid();
		$this->load->view('user_list', $data);
		$this->load->view('include/admin-footer');
	}

	public function user_list_admin()
	{
		$data['page_title'] = 'User List';
		$data['page_name'] = "List of Users";
		$this->load->view('include/admin-header', $data);
		$this->load->view('include/sidebar');
		$this->load->view('include/topbar');
		$data['group'] = $this->Commonmodel->get_groupid();
		$this->load->view('superadmin/user_list_admin', $data);
		$this->load->view('include/admin-footer');
	}


	public function get_users()
	{
		// $parentid = $this->session->userdata('userid'); 
		// if($this->session->userdata('userrole')=='3' || $this->session->userdata('userrole')=='4'){
		// 	$parentid = $this->session->userdata('parentid');
		// }
		$parentid = $this->session->userdata('parentid');
		if ($this->session->userdata('GroupID') != '1') {
			$parentid = $this->session->userdata('parentid');
		}
		$result = $this->Usermodel->get_users($parentid);
		$json_data['data'] = $result;
		echo json_encode($json_data);

	}

	public function user_save()
	{

		$user_type = $this->input->post('user_type');
		$name = $this->input->post('name');
		$prefix = $this->input->post('prefix');
		$emailid = $this->input->post('emailid');
		$mobile_number = $this->input->post('mobile_number');
		$employee_code = $this->input->post('employee_code');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user_status = $this->input->post('user_status');
		$userpro_image = $this->input->post('userpro_image');
		$admin_status = $this->input->post('admin_status');
		$auditor_status = $this->input->post('auditor_status');
		$supervisor_status = $this->input->post('supervisor_status');
		$groupid = $this->input->post('group_id');
		$this->form_validation->set_rules('user_type', 'User Type', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('emailid', 'Emailid', 'required|trim');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|trim');
		$this->form_validation->set_rules('employee_code', 'Employee Code', 'required|trim');

		// $data=;
		// {
		// 	echo json_encode(array('status' => 0));
		// }

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('status' => 0));
		} else {

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$parent_id = $this->session->userdata('userid');
			if ($this->session->userdata('GroupID') != '1') {
				$parent_id = $this->session->userdata('parentid');
			}
			$data = array(
				'UserGroupID' => '4',
				'Name' => $name,
				'Email' => $emailid,
				'Mobile' => $mobile_number,
				'EmployeeCode' => $employee_code,
				'UserName' => $username,
				'Password' => $hashed_password,
				'isActive' => $user_status,
				'UserRole' => 3,
				'IsAdmin' => $admin_status,
				'Isauditor' => $auditor_status,
				'issupervisor' => $supervisor_status,
				'CreatedBy' => $this->session->userdata('userid'),
				'GroupID' => $groupid,
				'Suffix' => $prefix,
				'ParentID' => $parent_id,
				'CreatedDate' => date('Y-m-d'),
			);

			if (!empty($_FILES['userpro_image']['name'])) {

				$config['upload_path'] = './upload/profile/';
				$config['allowed_types'] = 'jpg|png';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('userpro_image')) {
					$error = array('error' => $this->upload->display_errors());
				} else {
					$file_details = array('upload_data' => $this->upload->data());
					foreach ($file_details as $f) {
						$filename = $f['file_name'];
					}
					$data["ProfileIMG"] = $filename;
				}


			}
			if ($this->userexist($emailid, $mobile_number, $employee_code, $username) == 0) {
				$resultId = $this->Commonmodel->common_insert('RegisterMST', $data);
				if ($resultId) {
					echo json_encode(array('status' => 1));
				} else {
					// echo json_encode(array('status' => 0));
				}
			} else {
				echo json_encode(array('status' => 0));
			}

		}
	}

	function userexist($email, $mobilenumber, $empcode, $username)
	{
		$parent_id = $this->session->userdata('userid');
		if ($this->session->userdata('GroupID') != '1') {
			$parent_id = $this->session->userdata('parentid');
		}

		$mobile = $this->Commonmodel->allreadycheck('RegisterMST', array('ParentID' => $parent_id, 'Mobile' => $mobilenumber));
		$email = $this->Commonmodel->allreadycheck('RegisterMST', array('ParentID' => $parent_id, 'Email' => $email));
		$empcode = $this->Commonmodel->allreadycheck('RegisterMST', array('ParentID' => $parent_id, 'EmployeeCode' => $empcode));
		$username = $this->Commonmodel->allreadycheck('RegisterMST', array('ParentID' => $parent_id, 'UserName' => $username));

		if ($mobile == 1 && $email == 1 && $empcode == 1 && $username == 1) {

			return 0;
		} else {

			return 1;
		}
	}




	public function user_update()
	{

		$user_type = $this->input->post('user_type');
		$name = $this->input->post('name');
		$emailid = $this->input->post('emailid');
		$mobile_number = $this->input->post('mobile_number');
		$employee_code = $this->input->post('employee_code');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user_status = $this->input->post('user_status');
		$userpro_image = $this->input->post('userpro_image');
		$user_updateid = $this->input->post('user_updateid');
		$admin_status = $this->input->post('admin_status');
		$auditor_status = $this->input->post('auditor_status');
		$supervisor_status = $this->input->post('supervisor_status');
		$up_groupid = $this->input->post('up_group_id');
		$update_prefix = $this->input->post('update_prefix');

		$this->form_validation->set_rules('user_type', 'User Type', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('emailid', 'Emailid', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
		$this->form_validation->set_rules('employee_code', 'Employee Code', 'required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('status' => 0));
		} else {
			$parent_id = $this->session->userdata('userid');
			if ($this->session->userdata('GroupID') != '1') {
				$parent_id = $this->session->userdata('parentid');
			}
			if ($password != "") {
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$data = array(
					'UserGroupID' => $user_type,
					'Name' => $name,
					'Email' => $emailid,
					'Mobile' => $mobile_number,
					'EmployeeCode' => $employee_code,
					'UserName' => $username,
					'isActive' => $user_status,
					'UserRole' => 3,
					'GroupID' => $up_groupid,
					'ParentID' => $parent_id,
					'IsAdmin' => $admin_status,
					'Isauditor' => $auditor_status,
					'issupervisor' => $supervisor_status,
					'Suffix' => $update_prefix,
					'ModifyBy' => $this->session->userdata('userid'),
					'ModifyDate' => date('Y-m-d'),
					'Password' => $hashed_password,
				);
			} else {
				$data = array(
					'UserGroupID' => $user_type,
					'Name' => $name,
					'Email' => $emailid,
					'Mobile' => $mobile_number,
					'EmployeeCode' => $employee_code,
					'UserName' => $username,
					'isActive' => $user_status,
					'UserRole' => 3,
					'GroupID' => $up_groupid,
					'ParentID' => $parent_id,
					'IsAdmin' => $admin_status,
					'Isauditor' => $auditor_status,
					'issupervisor' => $supervisor_status,
					'Suffix' => $update_prefix,
					'ModifyBy' => $this->session->userdata('userid'),
					'ModifyDate' => date('Y-m-d'),
				);
			}

			if (!empty($_FILES['userupdate_file']['name'])) {
				$config['upload_path'] = './upload/profile/';
				$config['allowed_types'] = 'jpg|png';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('userupdate_file')) {
					$error = array('error' => $this->upload->display_errors());
				} else {
					$file_details = array('upload_data' => $this->upload->data());
					foreach ($file_details as $f) {
						$filename = $f['file_name'];
					}
				}

				$data['ProfileIMG'] = $filename;
			}
			// if(!empty($password)){
			// 	$data['Password'] = $hashed_password;
			// }
			$where = array(
				'AutoID' => $user_updateid,
			);

			$resultId = $this->Commonmodel->common_update('RegisterMST', $where, $data);
			if ($resultId) {
				echo json_encode(array('status' => 1));
			} else {
				echo json_encode(array('status' => 0));
			}

		}
	}



	public function delete_user()
	{
		$id = $this->input->post('id');
		$data = array(
			'IsDelete' => 1,
			'DeleteBy' => $this->session->userdata('userid'),
			'DeleteDate' => date('Y-m-d')
		);
		$where = array(
			'AutoID' => $id,
		);

		$resultId = $this->Commonmodel->common_update('RegisterMST', $where, $data);
		echo TRUE;
	}


	function get_user()
	{

		$id = $this->input->post('id');
		$result = $this->Usermodel->get_user($id);

		$response = array(
			"AutoID" => $result->AutoID,
			"UserGroupID" => $result->UserGroupID,
			"Name" => $result->Name,
			"Mobile" => $result->Mobile,
			"EmployeeCode" => $result->EmployeeCode,
			"Email" => $result->Email,
			"UserName" => $result->UserName,
			"isActive" => $result->isActive,
			"ProfileIMG" => $result->ProfileIMG,
			"IsAdmin" => $result->IsAdmin,
			"Isauditor" => $result->Isauditor,
			"issupervisor" => $result->issupervisor,
			"Suffix" => $result->Suffix,
		);

		echo json_encode(array("status" => 1, "data" => $response));

	}
	public function usertemplate_download()
	{

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="user_list.xlsx"');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Name');
		$sheet->setCellValue('B1', 'Email');
		$sheet->setCellValue('C1', 'Mobile Number');
		$sheet->setCellValue('D1', 'Role');
		$sheet->setCellValue('E1', 'Employee Code');
		$sheet->setCellValue('F1', 'User Name');
		$sheet->setCellValue('G1', 'Password');
		$sheet->setCellValue('H1', 'Status');

		$sheet->setCellValue('A2', '');
		$sheet->setCellValue('B2', '');
		$sheet->setCellValue('C2', '');
		$sheet->setCellValue('D2', 'Admin');
		$sheet->setCellValue('E2', '');
		$sheet->setCellValue('F2', '');
		$sheet->setCellValue('G2', '');
		$sheet->setCellValue('H2', 'Active');
		$sheet->setCellValue('A3', '');
		$sheet->setCellValue('B3', '');
		$sheet->setCellValue('C3', '');
		$sheet->setCellValue('D3', 'Auditor');
		$sheet->setCellValue('E3', '');
		$sheet->setCellValue('F3', '');
		$sheet->setCellValue('G3', '');
		$sheet->setCellValue('H3', 'Active');
		$sheet->setCellValue('A4', '');
		$sheet->setCellValue('B4', '');
		$sheet->setCellValue('C4', '');
		$sheet->setCellValue('D4', 'Incharge');
		$sheet->setCellValue('E4', '');
		$sheet->setCellValue('F4', '');
		$sheet->setCellValue('G4', '');
		$sheet->setCellValue('H4', 'Active');
		$sheet->setCellValue('A5', '');
		$sheet->setCellValue('B5', '');
		$sheet->setCellValue('C5', '');
		$sheet->setCellValue('D5', 'Incharge');
		$sheet->setCellValue('E5', '');
		$sheet->setCellValue('F5', '');
		$sheet->setCellValue('G5', '');
		$sheet->setCellValue('H5', 'Active');
		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");

	}
	public function user_import()
	{

		$upload_file = $_FILES['userfile']['name'];
		$extension = pathinfo($upload_file, PATHINFO_EXTENSION);
		if ($extension == 'csv') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else if ($extension == 'xls') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
		$sheetdata = $spreadsheet->getActiveSheet()->toArray();
		$sheetcount = count($sheetdata);
		if ($sheetcount > 1) {


			$data = array();
			for ($i = 1; $i < $sheetcount; $i++) {

				$name = $sheetdata[$i][0];
				$emailid = $sheetdata[$i][1];
				$mobile_number = $sheetdata[$i][2];
				$role = $sheetdata[$i][3];
				$employee_code = $sheetdata[$i][4];
				$username = $sheetdata[$i][5];
				$password = $sheetdata[$i][6];
				$status = $sheetdata[$i][7];

				if (trim(strtolower($role)) == "admin") {
					$role_id = 2;
				} else if (trim(strtolower($role)) == "auditor") {
					$role_id = 3;
				} else if (trim(strtolower($role)) == "incharge") {
					$role_id = 4;
				} else if (trim(strtolower($role)) == "supervisor") {
					$role_id = 5;
				}

				if ($status == "Active") {
					$active_id = 1;
				} else if ($status == "Inactive") {
					$active_id = 2;
				}

				$hashed_password = password_hash($password, PASSWORD_DEFAULT);


				if ($name != '' && $emailid != '' && $mobile_number != '' && $role_id != '' && $employee_code != '' && $username != '' && $password != '' && $active_id != '') {


					$valid = $this->Usermodel->user_exists($emailid, $mobile_number, $employee_code);
					if ($valid) {
						$parent_id = $this->session->userdata('userid');
						if ($this->session->userdata('GroupID') != '1') {
							$parent_id = $this->session->userdata('parentid');
						}
						$data = array(
							'UserGroupID' => $role_id,
							'Name' => $name,
							'Email' => $emailid,
							'Mobile' => $mobile_number,
							'EmployeeCode' => $employee_code,
							'UserName' => $username,
							'Password' => $hashed_password,
							'isActive' => $active_id,
							'UserRole' => 3,
							'from_status' => 'excel',
							'CreatedBy' => $this->session->userdata('userid'),
							'ParentID' => $parent_id,
							'CreatedDate' => date('Y-m-d'),
						);

						$resultId = $this->Commonmodel->common_insert('RegisterMST', $data);
					}


				}



			}
			echo json_encode(array('status' => 1));

		} else {
			echo json_encode(array('status' => 0));
		}

	}

}