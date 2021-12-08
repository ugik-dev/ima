<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Bank extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('SecurityModel', 'Bank_model', 'General_model'));
		// $this->load->helper(array('DataStructure'));
		$this->db->db_debug = TRUE;
	}

	public function getAllPayee()
	{
		try {
			$filter = $this->input->get();
			// $filter['nature'] = 'Assets';
			$data = $this->Bank_model->getAllPayee($filter);
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function getBankTransaction()
	{
		try {
			$filter = $this->input->get();
			// $filter['nature'] = 'Assets';
			$data = $this->Bank_model->getBankTransaction($filter);
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function getBank()
	{
		try {
			$filter = $this->input->get();
			// $filter['nature'] = 'Assets';
			$accounts = $this->Bank_model->getAllBank($filter);
			echo json_encode(array('error' => false, 'data' => $accounts));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function bank_list()
	{
		try {
			// $crud = $this->SecurityModel->Aksessbility_VCRUD('bank', 'bank_list', 'view');
			$data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Assets'));

			$data['title'] = 'Bagan Akun';
			$data['table_name'] = 'BAGAN AKUN';
			$data['main_view'] = 'bank/daftar_bank';
			// $data['vcrud'] = $crud;
			$data['vcrud'] = array();
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function addBank()
	{
		try {
			// $this->SecurityModel->Aksessbility_VCRUD('bank', 'bank_list', 'create', true);
			$data = $this->input->post();
			$accounts = $this->Bank_model->addBank($data);
			$data = $this->Bank_model->getAllBank(array('id' => $accounts, 'by_id' => true))[$accounts];


			echo json_encode(array('error' => false, 'data' => $data));
			// $this->load->view('accounting/accounts_modal');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function editBank()
	{
		try {
			// $this->SecurityModel->Aksessbility_VCRUD('bank', 'bank_list', 'update', true);
			$data = $this->input->post();
			$accounts = $this->Bank_model->editBank($data);
			$data = $this->Bank_model->getAllBank(array('id' => $accounts, 'by_id' => true))[$accounts];
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function deposito()
	{
		try {
			// $crud = $this->SecurityModel->Aksessbility_VCRUD('bank', 'deposito', 'view');
			$data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true));
			$data['payee'] = $this->General_model->getAllPayee(array('by_id' => true));
			$data['banks'] = $this->General_model->getAllBank(array('by_id' => true));

			$data['title'] = 'Bagan Akun';
			$data['table_name'] = 'BAGAN AKUN';
			$data['main_view'] = 'bank/deposito';
			// $data['vcrud'] = $crud;
			$data['vcrud'] = array('parent_id' => 1, 'id_menulist' => 2);
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function addDeposito()
	{
		try {
			// $this->SecurityModel->Aksessbility_VCRUD('bank', 'deposito', 'create', true);
			$data = $this->input->post();
			$data['transaction_type'] = 'recieved';
			$data['amount'] =
				number_format(
					str_replace(',', '.', preg_replace('#[^,0-9-]+#i', '', $data['amount'])),
					2,
					'.',
					''
				);
			$id = $this->Bank_model->addBankTrans($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $id, 'by_id' => true, 'transaction_type' => 'recieved'))[$id];
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function setorkan()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'deposito', 'create', true);
			$id = $this->input->get('id');
			$data = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $id, 'transaction_type' => 'recieved'))[$id];
			if ($data['transaction_status'] != 0) {
				throw new UserException('Data sudah disetorkan!');
			}
			$data['bank_data'] = $this->Bank_model->getAllBank(array('by_id' => true, 'id', $data['bank_id']))[$data['bank_id']];
			$data['generalentry'] = array(
				'customer_id' => $data['payee_id'],
				'date' => $data['date'],
				'naration' => $data['naration'],
				'generated_source' => 'deposit',
				'user_update' => $this->session->userdata('user_id')['id'],
			);
			$data['sub_entry'][0] = array('parent_id' => '', 'accounthead' => $data['relation_head'], 'type' => 0, 'amount' => $data['amount'], 'sub_keterangan' => 'Deposito Bank');
			$data['sub_entry'][1] = array('parent_id' => '', 'accounthead' => $data['account_to'], 'type' => 1, 'amount' => $data['amount'], 'sub_keterangan' => $data['naration']);
			$this->Bank_model->deposito_post($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $data['id'], 'by_id' => true, 'transaction_type' => 'recieved'));
			echo json_encode(array('error' => false, 'data' => $data));
			// $this->load->view('accounting/accounts_modal');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function batal_setor()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'deposito', 'create', true);
			$id = $this->input->get('id');
			$data = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $id, 'transaction_type' => 'recieved'))[$id];
			if ($data['transaction_status'] != 1) {
				throw new UserException('Status belum disetorkan!');
			}
			$this->Bank_model->batal_setor($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $data['id'], 'by_id' => true, 'transaction_type' => 'recieved'));
			echo json_encode(array('error' => false, 'data' => $data));
			// $this->load->view('accounting/accounts_modal');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function editDeposito()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'deposito', 'update', true);
			$data = $this->input->post();
			$data_old = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $data['id'], 'transaction_type' => 'recieved'))[$data['id']];
			if ($data_old['transaction_status'] != 0) {
				throw new UserException('Data Sudah disetor, batalkan terlebih dahulu!');
			}

			$this->Bank_model->editBankTrans($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $data_old['id'], 'by_id' => true, 'transaction_type' => 'recieved'))[$data_old['id']];
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function deleteDeposito()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'deposito', 'delete', true);
			$data = $this->input->get();
			$data_old = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $data['id'], 'transaction_type' => 'recieved'))[$data['id']];
			if ($data_old['transaction_status'] != 0) {
				throw new UserException('Data Sudah disetor, batalkan terlebih dahulu!');
			}
			$this->Bank_model->deleteTransaction($data);

			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}


	public function deleteCheque()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'cheque', 'delete', true);
			$data = $this->input->get();
			$data_old = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $data['id'], 'transaction_type' => 'paid'))[$data['id']];
			if ($data_old['transaction_status'] != 0) {
				throw new UserException('Data Sudah disetor, batalkan terlebih dahulu!');
			}
			$this->Bank_model->deleteTransaction($data);

			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}


	function cheque()
	{
		try {
			$crud = $this->SecurityModel->Aksessbility_VCRUD('bank', 'cheque', 'view');
			$data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true));
			$data['payee'] = $this->General_model->getAllPayee(array('by_id' => true));
			$data['banks'] = $this->General_model->getAllBank(array('by_id' => true));

			$data['title'] = 'CEK BANK';
			$data['table_name'] = 'CEK BANK';
			$data['main_view'] = 'bank/cheque';
			$data['vcrud'] = $crud;
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}


	public function addCheque()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'cheque', 'create', true);
			$data = $this->input->post();
			$data['transaction_type'] = 'paid';
			$data['amount'] =
				number_format(
					str_replace(',', '.', preg_replace('#[^,0-9-]+#i', '', $data['amount'])),
					2,
					'.',
					''
				);
			$id = $this->Bank_model->addBankTrans($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $id, 'by_id' => true, 'transaction_type' => 'paid'))[$id];
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function paid()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'cheque', 'create', true);
			$id = $this->input->get('id');
			$data = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $id, 'transaction_type' => 'paid'))[$id];
			if ($data['transaction_status'] != 0) {
				throw new UserException('Data sudah disetorkan!');
			}
			$data['bank_data'] = $this->Bank_model->getAllBank(array('by_id' => true, 'id', $data['bank_id']))[$data['bank_id']];
			$data['generalentry'] = array(
				'customer_id' => $data['payee_id'],
				'date' => $data['date'],
				'naration' => $data['naration'],
				'generated_source' => 'paid',
				'user_update' => $this->session->userdata('user_id')['id'],
			);
			$data['sub_entry'][0] = array('parent_id' => '', 'accounthead' => $data['relation_head'], 'type' => 1, 'amount' => $data['amount'], 'sub_keterangan' => 'Cek Bank');
			$data['sub_entry'][1] = array('parent_id' => '', 'accounthead' => $data['account_to'], 'type' => 0, 'amount' => $data['amount'], 'sub_keterangan' => $data['naration']);
			$this->Bank_model->deposito_post($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $data['id'], 'by_id' => true, 'transaction_type' => 'paid'));
			echo json_encode(array('error' => false, 'data' => $data));
			// $this->load->view('accounting/accounts_modal');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function unpaid()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'cheque', 'create', true);
			$id = $this->input->get('id');
			$data = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $id, 'transaction_type' => 'paid'))[$id];
			if ($data['transaction_status'] != 1) {
				throw new UserException('Status belum disetorkan!');
			}
			$this->Bank_model->batal_setor($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $data['id'], 'by_id' => true, 'transaction_type' => 'paid'));
			echo json_encode(array('error' => false, 'data' => $data));
			// $this->load->view('accounting/accounts_modal');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function editCheque()
	{
		try {
			$this->SecurityModel->Aksessbility_VCRUD('bank', 'cheque', 'update', true);
			$data = $this->input->post();
			$data_old = $this->Bank_model->getBankTransaction(array('by_id' => true, 'id' => $data['id'], 'transaction_type' => 'paid'))[$data['id']];
			if ($data_old['transaction_status'] != 0) {
				throw new UserException('Data Sudah disetor, batalkan terlebih dahulu!');
			}

			$this->Bank_model->editBankTrans($data);
			$data = $this->Bank_model->getBankTransaction(array('id' => $data_old['id'], 'by_id' => true, 'transaction_type' => 'paid'))[$data_old['id']];
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}


	// OLD CODE
	//Bank
	public function index()
	{
		$this->bank_list();
	}
	// public function index()
	// {
	// 	// DEFINES PAGE TITLE
	// 	$data['title'] = 'Bank';

	// 	// DEFINES NAME OF TABLE HEADING
	// 	$data['table_name'] = 'DAFTAR BANK:';

	// 	// DEFINES WHICH PAGE TO RENDER
	// 	$data['main_view'] = 'bank';

	// 	// DEFINES THE TABLE HEAD
	// 	$data['table_heading_names_of_coloums'] = array(
	// 		'Nama Bank',
	// 		'Cabang',
	// 		'Kode Cabang',
	// 		'Nama Akun',
	// 		'Nomor Rekening',
	// 		'Status',
	// 		'Aksi'
	// 	);
	// 	$this->load->model('Crud_model');
	// 	$result = $this->Crud_model->fetch_record('mp_banks', NULL);
	// 	$data['bank_list'] = $result;

	// 	// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
	// 	$this->load->view('main/index.php', $data);
	// }
}
