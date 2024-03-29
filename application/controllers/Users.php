<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Users extends CI_Controller
{
	// Accounts
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('SecurityModel'));
		$this->load->helper(array('DataStructure'));
		$this->db->db_debug = TRUE;
		// $this->SecurityModel->('')
	}
	// Users

	public function index()
	{

		try {
			$this->SecurityModel->MultiplerolesStatus(array('Admin', 'Users'), TRUE);

			// $this->SecurityModel->MultiplerolesGuard('Users', true);
			// DEFINES PAGE TITLE
			$data['title'] = 'Daftar Pengguna';

			// DEFINES NAME OF TABLE HEADING
			$data['table_name'] = 'DAFTAR PENGGUNA :';

			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'users';

			// DEFINES THE TABLE HEAD
			$data['table_heading_names_of_coloums'] = array(
				'Nama',
				'Email',
				'Jabatan',
				'Alamat',
				'Nomor HP',
				'Foto',
				'Status',
				'Agen',
				'Aksi'
			);

			// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
			$this->load->model('Crud_model');
			$result = $this->Crud_model->fetch_record('mp_users', NULL);
			$data['user_list'] = $result;

			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	//	Userss/add_user
	public function add_user()
	{
		try {
			// $this->SecurityModel->MultiplerolesGuard('Users', true);
			$this->SecurityModel->MultiplerolesStatus(array('Admin', 'Users'), TRUE);

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');
			// DEFINES READ MEDICINE details FORM MEDICINE FORM
			$users_name = html_escape($this->input->post('user_name'));
			$title_user = html_escape($this->input->post('title_user'));
			$users_email = html_escape($this->input->post('user_email'));
			$users_address = html_escape($this->input->post('User_Address'));
			$users_contatc1 = html_escape($this->input->post('User_Contatc1'));
			$users_contatc2 = html_escape($this->input->post('User_Contatc2'));
			$users_description = html_escape($this->input->post('User_description'));
			$login_customer = html_escape($this->input->post('user_password'));
			$user_password = sha1($login_customer);
			$user_Date = Date('Y-m-d');
			$picture = $this->Crud_model->do_upload_picture("User_Picture", "./uploads/users/");
			$user_name = html_escape($this->input->post('user_name'));

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'user_name' => $users_name,
				'user_email' => $users_email,
				'title_user' => $title_user,
				'user_address' => $users_address,
				'user_contact_1' => $users_contatc1,
				'user_contact_2' => $users_contatc2,
				'user_description' => $users_description,
				'user_password' => $user_password,
				'user_date' => $user_Date,
				'cus_picture' => $picture,
				'agentname' => $user_name['name']
			);

			// CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
			$email_record_data = $this->Crud_model->check_email_address('mp_users', 'user_email', $users_email);
			if ($email_record_data == NULL) {

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_users', $args);
				if ($result == 1) {
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> User added Successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				} else {
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> User Category cannot be added',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			} else {
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>Sorry Email already exists !',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}

			redirect('Users');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	// Users/delete
	public function delete($args)
	{
		$this->SecurityModel->MultiplerolesStatus(array('Admin', 'Users'), TRUE);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
		$this->Crud_model->delete_image('./uploads/users/', $args, 'mp_users');
		$result = $this->Crud_model->delete_record('mp_users', $args);
		if ($result == 1) {
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"/> Users record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error Users record cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('Users');
	}

	// Users/edit
	public function edit()
	{
		$this->SecurityModel->MultiplerolesStatus(array('Admin', 'Users'), TRUE);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// USER'S ACTIVE SESSION
		$user_name = html_escape($this->input->post('Edit_user_name'));

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$title_user = html_escape($this->input->post('title_user'));
		$edit_users_id = html_escape($this->input->post('Edit_user_id'));
		$edit_users_name = html_escape($this->input->post('Edit_user_name'));
		$edit_users_email = html_escape($this->input->post('Edit_user_email'));
		$edit_users_address = html_escape($this->input->post('Edit_User_Address'));
		$edit_users_contatc1 = html_escape($this->input->post('Edit_User_Contatc1'));
		$edit_users_contatc2 = html_escape($this->input->post('Edit_User_Contatc2'));
		$edit_users_description = html_escape($this->input->post('Edit_User_description'));
		$edit_picture = $this->Crud_model->do_upload_picture("edit_user_picture", "./uploads/users/");

		if ($edit_picture == "default.jpg") {
			$data = array(
				'user_name' => $edit_users_name,
				'user_email' => $edit_users_email,
				'title_user' => $title_user,
				'user_address' => $edit_users_address,
				'user_contact_1' => $edit_users_contatc1,
				'user_contact_2' => $edit_users_contatc2,
				'user_description' => $edit_users_description,
				'agentname' => $user_name
			);
		} else {
			// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
			$data = array(
				'user_name' => $edit_users_name,
				'title_user' => $title_user,
				'user_email' => $edit_users_email,
				'user_address' => $edit_users_address,
				'user_contact_1' => $edit_users_contatc1,
				'user_contact_2' => $edit_users_contatc2,
				'user_description' => $edit_users_description,
				'agentname' => $user_name,
				'cus_picture' => $edit_picture
			);

			// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
			$this->Crud_model->delete_image('./uploads/users/', $edit_users_id, 'mp_users');
		}

		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_users',
			'id' => $edit_users_id
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1) {
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> User Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error User cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('Users');
	}

	// Users/change_status/id/status
	public function change_status($id, $status)
	{

		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_users',
			'id' => $id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'status' => $status
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1) {
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Status changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error Status cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('Users');
	}


	//Users/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');

		if ($page_name  == 'add_user_model') {
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_user_model.php');
		} else if ($page_name  == 'edit_user_model') {
			$data['single_user'] = $this->Crud_model->fetch_record_by_id('mp_users', $param);
			//model name available in admin models folder
			$this->load->view('admin_models/edit_models/edit_user_model.php', $data);
		}
	}
}
