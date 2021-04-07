<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller
{
	//Bank
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Bank';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'DAFTAR BANK:';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'bank';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Nama Bank',
			'Cabang',
			'Kode Cabang',
			'Nama Akun',
			'Nomor Rekening',
			'Status',
			'Aksi'
		);
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record('mp_banks',NULL);
		$data['bank_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Bank/add_bank
	function add_bank()
	{
		$this->load->model('Crud_model');
		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$bankname = html_escape($this->input->post('bankname'));
		$branch = html_escape($this->input->post('branch'));
		$branchcode = html_escape($this->input->post('branchcode'));
		$title = html_escape($this->input->post('title'));
		$accountno = html_escape($this->input->post('accountno'));
		$account_type = html_escape($this->input->post('account_type'));
		$ending_date = html_escape($this->input->post('ending_date'));
		$ending_balance = html_escape($this->input->post('ending_balance'));

		$result = $this->Crud_model->fetch_attr_record_by_id('mp_banks','accountno',$accountno);

		if($result == '')
		{
			
			if($account_type == 1)
			{
				$this->load->model('Transaction_model');
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
					'bankname' => $bankname,
					'branch' => $branch,
					'branchcode' => $branchcode,
					'title' => $title,
					'accountno' => $accountno,
					'end_date' => $ending_date,
					'end_balance' => $ending_balance
				);

				$result = $this->Transaction_model->bank_transaction($args);

			}
			else
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
					'bankname' => $bankname,
					'branch' => $branch,
					'branchcode' => $branchcode,
					'title' => $title,
					'accountno' => $accountno
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_banks', $args);

				if ($result != NULL)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			}
		}
		else
		{
			$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Account already exisits',
						'alert' => 'danger'
					);
			$this->session->set_flashdata('status', $array_msg);
		}
		
		redirect('bank');
	}
	
	//bank/edit
	public function edit()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$bank_id = html_escape($this->input->post('bank_id'));
		$bankname = html_escape($this->input->post('bankname'));
		$branch = html_escape($this->input->post('branch'));
		$branchcode = html_escape($this->input->post('branchcode'));
		$title = html_escape($this->input->post('title'));
		$accountno = html_escape($this->input->post('accountno'));
		
		
		
		$data = array(
			'bankname' => $bankname,
			'branch' => $branch,
			'branchcode' => $branchcode,
			'title' => $title,
			'accountno' => $accountno
		);

		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_banks',
			'id' => $bank_id
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> Bank Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('bank');
	}

	// supplier/change_status/id/status
	public function change_status($id, $status)
	{

		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_banks',
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
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/>  Changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('bank');
	}

	//Bank/change_cheque_status
	//USED TO CHANGE BANK CHEQUE STATUS
	function change_cheque_status($trans_id,$status)
	{
		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_bank_transaction',
			'id' => $trans_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'transaction_status' => $status
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/>  Changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('bank/written_cheque');
	}

	//Bank/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		if($page_name  == 'add_bank_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_bank_model.php');
		}
		else if($page_name  == 'edit_bank_model')
		{
			$this->load->model('Crud_model');
			$data['bank_list'] = $this->Crud_model->fetch_record_by_id('mp_banks',$param );
			
			$this->load->view( 'admin_models/edit_models/edit_bank_model.php',$data);
		}
		
	}

	//Bank/cheque
	//USED TO CREATE A CHEQUE 
	function cheque()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Cek';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'cheque';

		$this->load->model('Crud_model');

		//USED TO FETCH BANKS
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks',NULL);

		//USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee','cus_status','0');	

		//USED TO FETCH ACCOUNT HEADS
		$data['head_list'] = $this->Crud_model->fetch_record('mp_head',NULL);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}	

	//Bank/add_cheque
	//USED TO CREATE A CHEQUE 
	function add_cheque()
	{
		$this->load->model('Transaction_model');

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$cheque_id = html_escape($this->input->post('cheque_id'));
		$bank_id = html_escape($this->input->post('bank_id'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$account_head = html_escape($this->input->post('account_head'));
		$amount = html_escape($this->input->post('amount'));
		$description = html_escape($this->input->post('description'));

		if($date == NULL)
		{
			$date = date('Y-m-d');
		}

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'date' => $date,
			'cheque_id' => $cheque_id,
			'bank_id' => $bank_id,
			'payee_id' => $payee_id,
			'account_head' => $account_head,
			'amount' => $amount,
			'description' => $description
		);

		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$result = $this->Transaction_model->create_cheque($args);
		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		
		redirect('bank/written_cheque');
	}

	//Bank/written_cheque
	//USED TO LIST THE WRITTEN CHECKS 
	function written_cheque()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Cek Tertulis';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'CEK TERTULIS:';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'written_cheques';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Tanggal',
			'Bank',
			'Nama Akun',
			'Penerima Pembayaran',
			'Jumlah',
			'Nomor Cek',
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

 		$this->load->model('Accounts_model');
		$data['cheque_list'] = $this->Accounts_model->written_cheques($date1,$date2);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Bank/cheque
	//USED TO CREATE A DEPOSIT IN BANK 
	function deposit()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Deposit';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'deposit';

		$this->load->model('Crud_model');

		//USED TO FETCH BANKS
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		//USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee','cus_status','0');

		//USED TO FETCH ACCOUNT HEADS
		$data['head_list'] = $this->Crud_model->fetch_record('mp_head',NULL);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}	


	//Bank/add_deposit
	//USED TO CREATE A DEPOSIT 
	function add_deposit()
	{
		$this->load->model('Transaction_model');

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$date = html_escape($this->input->post('deposit_date'));
		$bank_id = html_escape($this->input->post('bank_id'));
		$customer_id = html_escape($this->input->post('customer_id'));
		$account_head = html_escape($this->input->post('account_head'));
		$amount = html_escape($this->input->post('amount'));
		$method = html_escape($this->input->post('method'));
		$refno = html_escape($this->input->post('refno'));
		$memo = html_escape($this->input->post('memo'));

		if($date == NULL)
		{
			$date = date('Y-m-d');
		}
		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'date' => $date,
			'bank_id' => $bank_id,
			'payee_id' => $customer_id,
			'account_head' => $account_head,
			'amount' => $amount,
			'method' => $method,
			'refno' => $refno,
			'memo' => $memo
		);

		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$result = $this->Transaction_model->create_deposit($args);
		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		
		redirect('bank/deposit_list');
	}

	//Bank/deposit_list
	//USED TO LIST THE WRITTEN CHECKS 
	function deposit_list()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Daftar Setoran';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'SETORAN BANK:';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'depositedlist';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Tanggal',
			'Bank',
			'Nama Akun',
			'Diterima',
			'Jumlah',
			'Ref No',
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

 		$this->load->model('Accounts_model');
		$data['deposit_list'] = $this->Accounts_model->bank_deposits($date1,$date2);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Bank/change_deposit_status
	//USED TO CHANGE DEPOSIT CHEQUE STATUS
	function change_deposit_status($trans_id,$status)
	{
		// TABLENAME AND ID FOR DATABASE Actions
		$args = array(
			'table_name' => 'mp_bank_transaction',
			'id' => $trans_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'transaction_status' => $status
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/>  Changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('bank/deposit_list');
	}

	//Bank/bank_book
	//USED TO GENERATE BANK BOOK
	function bank_book()
	{

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));
		$bank_id = html_escape($this->input->post('bank_id'));

		// DEFINES PAGE TITLE
		$data['title'] = 'Buku Bank';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Deposit:';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name2'] = 'Cek Tertulis:';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'bankbook';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Tanggal',
			'Jenis',
			'No',
			'Nama',
			'Jumlah'
		);		

		if($date1 == '' AND $date2 == '')
		{
			$date1 = date('Y-m-').'1';
			$date2 = date('Y-m-').'31';
		}
		
		$data['to'] = $date1.' -to- '.$date2;
		$this->load->model('Crud_model');

		$data['bank'] = $bank_id;

		//FETCH BANK NAME BY BANK ID
		$data['bankname'] = $this->Crud_model->fetch_record_by_id('mp_banks',$bank_id);

 		$this->load->model('Accounts_model');
 		
		$data['deposit_list'] = $this->Accounts_model->bank_book($date1,$date2,'recieved',$bank_id);
			
		$data['cheque_list']  =  $this->Accounts_model->bank_book($date1,$date2,'paid',$bank_id);

		$data['bank_list']  =  $this->Crud_model->fetch_record('mp_banks','status');

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}


	//USED TO FIND CURRENT AVAILABLE BALANCE IN BANK 
	function check_available_balance($bank_id)
	{
		$total_available = 0;

		$this->load->model('Crud_model');
		$opening = $this->Crud_model->fetch_attr_record_by_id('mp_bank_opening','bank_id',$bank_id);	
		if($opening != NULL)
		{
			 $total_available = $total_available + $opening[0]->amount;
		}

		$result = $this->Crud_model->fetch_attr_record_by_id('mp_bank_transaction','bank_id',$bank_id);

		if($result != NULL)
		{
			foreach ($result as $single_transaction) 
			{
				$result = $this->Crud_model->fetch_attr_record_by_id('mp_sub_entry','parent_id',$single_transaction->transaction_id);

				if($single_transaction->transaction_status == 0)
				{
					$total_available = $total_available + $result[0]->amount; 
				}
				else if($single_transaction->transaction_status == 1)
				{
					$total_available = $total_available - $result[0]->amount;
				}
			}
		}
		
		echo $total_available;
	}

	//USED TO DELETE THE BANK 
	function delete($bank_id)
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$result = $this->Crud_model->delete_record('mp_banks', $bank_id);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cannot delete, it may exist in another records',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('bank');
	}
}	