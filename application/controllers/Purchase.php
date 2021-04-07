<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends CI_Controller
{
	// Purchase
	public function index()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Daftar Pembelian';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'DAFTAR PEMBELIAN :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'purchase';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'ID Transaksi ',
			'No Bill',
			'Tanggal',
			'Supplier',
			'Total',
			'Total Dibayar',
			'Sisa',
			'Metode',
			'Tanggal Pembayaran',
			'Status',
			'Aksi'
		);

		//FETCHING DATES FROM TEXT FIELDS 
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));	

		if($date1 == NULL AND $date2 == NULL)
		{
			//ASSIGNING DEFAULT DATES 
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_purchased(0,$date1,$date2);
		$data['purchase_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}	

	//USED TO LIST THE PURCHASE RETURN
	//Purchase/return_list
	public function return_list()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Retur Pembelian';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'DAFTAR RETUR PEMBELIAN :';


		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'purchase_return';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'ID Transaksi ',
			'No Bill',
			'Tanggal',
			'Supplier',
			'Total',
			'Total Diterima',
			'Penerimaan',
			'Metode',
			'Tanggal Pembayaran',
			'Status',
			'Aksi'
		);

		//FETCHING DATES FROM TEXT FIELDS 
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));	

		if($date1 == NULL AND $date2 == NULL)
		{
			//ASSIGNING DEFAULT DATES 
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_purchased(1,$date1,$date2);
		$data['purchase_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO SHOW PURCHASE RETURN 
	function return_purchase()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Retur Pembelian';

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_payee_record('supplier','status');
		$data['supplier_list'] = $result;

		$result = $this->Crud_model->fetch_record('mp_stores', NULL);
		$data['store_list'] = $result;

		//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'return_purchase';

		
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	//USED TO CREATE Purchase
	//Purchase/create_purchase
	function create_purchase()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Tambah Pembelian';

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_payee_record('supplier','status');
		$data['supplier_list'] = $result;

		$result = $this->Crud_model->fetch_record('mp_stores', NULL);
		$data['store_list'] = $result;

		//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'create_purchase';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO ADD PURCHASE INTO DATAABASE
	//	Purchase/add_purchase
	public function add_purchase()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$this->load->model('Transaction_model');

		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$pur_supplier 	 = html_escape($this->input->post('pur_supplier'));
		$pur_store 		 = html_escape($this->input->post('pur_store'));
		$pur_invoice 	 = html_escape($this->input->post('pur_invoice'));
		$pur_total 		 = html_escape($this->input->post('pur_total'));
		$pur_method 	 = html_escape($this->input->post('pur_method'));
		$pur_date 		 = html_escape($this->input->post('pur_date'));
		$total_paid 		 = html_escape($this->input->post('pur_paid'));
		$pur_description = html_escape($this->input->post('pur_description'));
		$bank_id = html_escape($this->input->post('bank_id'));
		$ref_no = html_escape($this->input->post('ref_no'));
		$save_available_balance = html_escape($this->input->post('save_available_balance'));
		$picture = $this->Crud_model->do_upload_picture("pur_picture", "./uploads/purchase/");
		$status = html_escape($this->input->post('status'));


		//USED TO REDIRECT TO LOCATION DEFINED
		if($status == 0)
		{
			$redirect = 'purchase';
		}
		else
		{
			$redirect = 'purchase/return_list';
		}

		if(($save_available_balance-$total_paid) <= 0 AND $pur_method == 'Cheque' AND $status == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Saldo tidak mencukupi ',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'date' => date('Y-m-d'),
				'supplier_id' => $pur_supplier,
				'store' => $pur_store,
				'invoice_id' => $pur_invoice,
				'total_amount' => $pur_total,
				'payment_type_id' => $pur_method,
				'payment_date' => $pur_date,
				'cash' => $total_paid,
				'description' => $pur_description,
				'cus_picture' => $picture,
				'status' => $status,
				'bank_id' => $bank_id,
				'credithead' => ($pur_method == 'Cash' ? '2' : '16'),
				'ref_no' => $ref_no
			);

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Transaction_model->purchase_transaction($args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be added',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}	

		redirect($redirect);
	}

	// Customer/Delete
	function delete($args)
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS

		$this->load->model('Crud_model');

		// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID

		$this->Crud_model->delete_image('./uploads/customers/', $args, 'mp_customer');

		// DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID

		$result = $this->Crud_model->delete_record('mp_customer', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Customer record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Customer record cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('customers');
	}

	// Customers/Edit
	function edit()
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$edit_customer_id = html_escape($this->input->post('edit_customer_id'));
		$edit_customer_name = html_escape($this->input->post('edit_customer_name'));
		$edit_customer_email = html_escape($this->input->post('edit_customer_email'));
		$edit_customer_address = html_escape($this->input->post('edit_customer_address'));
		$edit_customer_contatc1 = html_escape($this->input->post('edit_customer_contatc1'));
		$edit_customer_contact_two = html_escape($this->input->post('edit_customer_contact_two'));
		$edit_customer_company = html_escape($this->input->post('edit_customer_company'));
		$edit_customer_city = html_escape($this->input->post('edit_customer_city'));
		$edit_customer_country = html_escape($this->input->post('edit_customer_country'));
		$edit_customer_description = html_escape($this->input->post('edit_customer_description'));
		$edit_picture = $this->Crud_model->do_upload_picture("edit_customer_picture_name", "./customers/");

		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_customer',
			'id' => $edit_customer_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		// DEFINES IF NO IMAGES IS SELECTED SO PRIVIOUS PICTURE REMAINS SAME
		if ($edit_picture == "default.jpg")
		{
			$data = array(
				'customer_name' => $edit_customer_name,
				'cus_email' => $edit_customer_email,
				'cus_address' => $edit_customer_address,
				'cus_contact_1' => $edit_customer_contatc1,
				'cus_contact_2' => $edit_customer_contact_two,
				'cus_company' => $edit_customer_company,
				'cus_city' => $edit_customer_city,
				'cus_country' => $edit_customer_country,
				'cus_description' => $edit_customer_description
			);
		}
		else
		{

			// DEFINES IF  IMAGES IS SELECTED SO UPDATE PRIVIOUS PICTURE
			$data = array(
				'customer_name' => $edit_customer_name,
				'cus_email' => $edit_customer_email,
				'cus_address' => $edit_customer_address,
				'cus_contact_1' => $edit_customer_contatc1,
				'cus_contact_2' => $edit_customer_contact_two,
				'cus_company' => $edit_customer_company,
				'cus_description' => $edit_customer_description,
				'cus_picture' => $edit_picture
			);

			// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
			$this->Crud_model->delete_image('./uploads/customers/', $edit_customer_id, 'mp_customer');
		}

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Customer Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Customer Category cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('customers');
	}

	//Customer/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'view_purchase_detail')
		{
			$data['single_purchase'] = $this->Crud_model->fetch_record_by_id('mp_purchase',$param);
			//model name available in admin models folder
			$this->load->view( 'admin_models/view_purchase_detail.php',$data);
		}		
	}

	// Customer/change_status/id/status
	function change_status($id, $status)
	{
		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_customer',
			'id' => $id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'cus_status' => $status
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Status changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Status cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('customers');
	}
}