<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Expense extends CI_Controller
{
	// Expense
	function index($date1 = '', $date2 = '')
	{
		$date1 = date('Y-m').'-1';

		$date2 = date('Y-m').'-31';

		// DEFINES PAGE TITLE
		$data['title'] = 'Daftar Expense';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Laporan Expense dari '.$date1.' sampai '.$date2;

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Tambah Expense';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Tambah Expense';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Simpan Expense';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'expenselist';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Expense',
			'Penerima Pembayaran',
			'Metode',
			'Tanggal',
			'Pengguna',
			'Keterangan',
			'Total Tagihan',
			'Total Dibayar'
		);

		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$this->load->model('Crud_model');
		$data['expense_record_list'] = $this->Crud_model->fetch_record_expense($date1,$date2);

		$data['payee_list'] = $this->Crud_model->fetch_record('mp_payee',NULL);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	function generate_expense()
	{
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));

		// DEFINES PAGE TITLE
		$data['title'] = 'Daftar Expense';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Laporan Expense dari '.$date1.' sampai '.$date2;

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Tambah Expense';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Tambah Expense';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Simpan Expense';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'expenselist';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Akun',
			'Penerima Pembayaran',
			'Metode',
			'Tanggal',
			'Pengguna',
			'Keterangan',
			'Total Tagihan',
			'Total Dibayar'
		);

		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$this->load->model('Crud_model');
		$expense_record = $this->Crud_model->fetch_record_expense($date1,$date2);
		$data['expense_record_list'] = $expense_record;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	
	//Expense/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_expense_model')
		{
			 
			// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
			$data['head_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_head','nature','Expense');
			//DEFINE TO FETCH THE LIST OF SUPPLIER
			$data['payee_list'] = $this->Crud_model->fetch_record('mp_payee',NULL);

			//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_expense_model.php',$data);
		}	
	}

	//Expense/add_expense
	function add_expense()
	{	

		$credithead = 0;
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];

		// DEFINES READ medicine details FORM medicine FORM
		$head_id = html_escape($this->input->post('head_id'));
		$method_id = html_escape($this->input->post('payment_id'));
		$total_bill = html_escape($this->input->post('bill_total'));
		$total_paid = html_escape($this->input->post('bill_paid'));
		$date = html_escape($this->input->post('date'));
		$description = html_escape($this->input->post('description'));
		$bank_id = html_escape($this->input->post('bank_id'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$ref_no = html_escape($this->input->post('ref_no'));
		$save_available_balance = html_escape($this->input->post('save_available_balance'));

		if(($save_available_balance-$total_paid) <= 0 AND $method_id == 'Cheque' )
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Saldo tidak mencukupi ',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			// $picture = html_escape($this->input->post('picture'));
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Transaction_model');

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'head_id' => $head_id,
				'method' => $method_id,
				'total_bill' => $total_bill,
				'total_paid' => $total_paid,
				'date' => $date,
				'description' => $description,
				'user' => $added_by,
				'payee_id' => $payee_id,
				'bank_id' => $bank_id,
				'credithead' => ($method_id == 'Cash' ? '2' : '16'),
				'ref_no' => $ref_no
			);

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Transaction_model->add_expense_transaction($args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Expense added Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error expense cannot be added',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}

		redirect('expense');
	}
}