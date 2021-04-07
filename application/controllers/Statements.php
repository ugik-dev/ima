<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Statements extends CI_Controller
{
	// Statements
	//USED TO GENERATE GENERAL JOURNAL 
	public function index()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Jurnal Umum';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'generaljournal';

		$from 	 = html_escape($this->input->post('from'));
		$to 	 = html_escape($this->input->post('to'));
		
		if($from == NULL AND $to == NULL)
		{
			$from = date('Y-m-'.'1');
			$to =  date('Y-m-'.'31');
		}

		$this->load->model('Statement_model');
		$data['transaction_records'] = $this->Statement_model->fetch_transasctions($from,$to);

		$data['from'] = $from; 
		$data['to'] = $to; 

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}	

	//USED TO GENERATE LEDGER ACCOUNTS 
	//Statements/general_journal
	function leadgerAccounst()
	{
		//$ledger
		$from = html_escape($this->input->post('from'));
		$to   = html_escape($this->input->post('to'));

		if($from == NULL OR $to == NULL)
		{
			
			$from = date('Y-m-').'1';
			$to =  date('Y-m-').'31';

		}

		$data['from'] = $from; 

		$data['to'] = $to;

		// DEFINES PAGE TITLE
		$data['title'] = 'Buku Besar';

		$this->load->model('Crud_model');

		$this->load->model('Statement_model');
		$data['ledger_records'] = $this->Statement_model->the_ledger($from,$to);

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'ledger';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE TRAIL BALANCE 
	//Statements/trail_balance 
	public function trail_balance()
	{
		$year = html_escape($this->input->post('year'));
		if($year == NULL)
		{
			$year = date('Y').'-12-31';
		}
		else
		{
			$year = $year.'-12-31';
		}
		
		$data['year'] = $year; 

		// DEFINES PAGE TITLE
		$data['title'] = 'Neraca Saldo';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'trail_balance';

		$this->load->model('Statement_model');
		$data['trail_records'] = $this->Statement_model->trail_balance($year); 

	
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE INCOME STATEMENT 
	public function income_statement()
	{
		$year = html_escape($this->input->post('year'));
		if($year == NULL)
		{
			$startyear = date('Y').'-1-1';
			$endyear = date('Y').'-12-31';
		}
		else
		{
			$startyear = $year.'-1-1';
			$endyear =   $year.'-12-31';
		}

		$data['from'] = $startyear;

		$data['to'] = $endyear; 

		// DEFINES PAGE TITLE
		$data['title'] = 'Laporan Untung Rugi';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'incomestatement';

		$this->load->model('Statement_model');
		$data['income_records'] = $this->Statement_model->income_statement($startyear,$endyear); 

	
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}	

	//USED TO GENERATE BALANCE SHEET 
	public function balancesheet()
	{
		$year = html_escape($this->input->post('year'));
		if($year == NULL)
		{
			
			$endyear = date('Y').'-12-31';
		}
		else
		{
			
			$endyear =   $year.'-12-31';
		}

		$data['to'] = $endyear; 

		// DEFINES PAGE TITLE
		$data['title'] = 'Neraca Keuangan';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'balancesheet';

		$this->load->model('Statement_model');
		$data['balance_records'] = $this->Statement_model->balancesheet($endyear); 

	
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

		//USED TO GENERATE JOURNAL VOUCHER 
	//Vouchers/journal_voucher
	function journal_voucher()
	{

		$this->load->model('Crud_model');
		
		$data['currency'] = $this->Crud_model->fetch_record_by_id('mp_langingpage',1)[0]->currency;

		//$ledger
		$from = html_escape($this->input->post('from'));
		$to   = html_escape($this->input->post('to'));

		if($from == NULL OR $to == NULL)
		{
			
			$from = date('Y-m-').'1';
			$to =  date('Y-m-').'31';

		}

		// DEFINES PAGE TITLE
		$data['title'] = 'Entri Jurnal';

		$this->load->model('Statement_model');
		$data['accounts_records'] = $this->Statement_model->chart_list();

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'journal_voucher';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO ADD STARTING BALANCES 
	function opening_balance()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Pembukaan Saldo';

		$this->load->model('Crud_model');
		$data['heads_record'] = $this->Crud_model->fetch_record('mp_head',NULL);
		$result =  $this->Crud_model->fetch_payee_record('customer','status');
		$supplierresult =  $this->Crud_model->fetch_payee_record('supplier','status');
		$employeeresult =  $this->Crud_model->fetch_payee_record('employee','status');
		$data['customer_list'] = $result;
		$data['supplier_list'] = $supplierresult;
		$data['employee_list'] = $employeeresult;

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'opening_balance';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO ADD INTO OPENING BALANCE 
	function add_new_balance()
	{
		
		$account_head = html_escape($this->input->post('account_head'));
		$account_nature   = html_escape($this->input->post('account_nature'));
		$amount   = html_escape($this->input->post('amount'));
		$date   = html_escape($this->input->post('date'));
		$description   = html_escape($this->input->post('description'));
		$customer_id   = html_escape($this->input->post('customer_id'));
		$employee_id   = html_escape($this->input->post('employee_id'));
		$supplier_id   = html_escape($this->input->post('supplier_id'));
		$user_type   = html_escape($this->input->post('user_type'));
		if($user_type == 2){
			$supplier_id = $supplier_id;
		}else if($user_type == 2){
			$supplier_id = $employee_id;
		}else{
			$supplier_id = $customer_id;
		}
	
		$data = array(
		  'head' => $account_head, 
		  'nature' => $account_nature, 
		  'amount' => $amount, 
		  'date' => $date, 
		  'description' => $description, 
		  'customer_id' => $customer_id
		);

		$this->load->model('Transaction_model');
		$result = $this->Transaction_model->opening_balance($data);

		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('statements/opening_balance');
	}
	//Statements/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'new_row')
		{
			$this->load->model('Statement_model');
			$data['accounts_records'] = $this->Statement_model->chart_list();

			//model name available in admin models folder
			$this->load->view( 'admin_models/accounts/new_row.php',$data);
		}	
		
	}

	//USED TO CREATE JOURNAL ENTRY 
	//Statements/create_journal_voucher
	function create_journal_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$date   = html_escape($this->input->post('date'));	
		$account_head   = html_escape($this->input->post('account_head'));		
		$debitamount   = html_escape($this->input->post('debitamount'));	
		$creditamount   = html_escape($this->input->post('creditamount'));	

		if($date == NULL)
		{
			$date = date('Y-m-d');
		}	

		$count_rows = count($account_head);
		$status = TRUE;

		for($i = 0; $i < $count_rows; $i++)
        {
        	if((($debitamount[$i] > 0 AND $creditamount[$i] == 0) OR ($creditamount[$i] > 0 AND $debitamount[$i] == 0)) AND $account_head[$i] != 0)
        	{

        	}
        	else
        	{
        		$status = FALSE;
        	}

			
		}

		$data = array(
			'description' => $description, 
			'date' => $date, 
			'account_head' => $account_head ,  
			'debitamount' => $debitamount, 
			'creditamount' => $creditamount, 
		);

		if($status)
		{
			
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->journal_voucher_entry($data);

			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);

				redirect('statements/journal_voucher');
			}
		}
		else
		{
			$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
					'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('vouchers/journal_voucher');
		}
		redirect('statements');
	}
}