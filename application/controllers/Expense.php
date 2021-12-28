<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Expense extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('SecurityModel',  'Expense_model', 'General_model'));
		// $this->load->helper(array('DataStructure'));
		$this->db->db_debug = TRUE;
	}

	public function getAllPayee()
	{
		try {
			$filter = $this->input->get();
			// $filter['nature'] = 'Assets';
			$data = $this->Expense_model->getAllPayee($filter);
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function getExpense()
	{
		try {
			$filter = $this->input->get();
			// $filter['nature'] = 'Assets';
			$accounts = $this->Expense_model->getAllExpense($filter);
			echo json_encode(array('error' => false, 'data' => $accounts));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function index()
	{
		try {
			// $crud = $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'create');
			$data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Expense'));
			$data['payment_method'] = $this->General_model->getAllRefAccount(array('ref_type' => 'payment_method'));
			$data['payee'] = $this->General_model->getAllPayee();
			$data['title'] = 'Expense';
			$data['form_url'] = 'expense/addExpense';
			$data['main_view'] = 'expense/form_expense';
			// $data['vcrud'] = $crud;
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function edit($id)
	{
		try {
			// $crud = $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'update');
			$res = $this->Expense_model->getAllExpense(array('id' => $id));
			if (empty($res)) {
				throw new UserException('Data Tidak Ditemukan!', UNAUTHORIZED_CODE);
			}
			$data['return'] = $res[0];
			$data['payment_method'] = $this->General_model->getAllRefAccount(array('ref_type' => 'payment_method'));
			// echo json_encode($data);
			// die();
			$data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Expense'));
			$data['payee'] = $this->General_model->getAllPayee();
			$data['title'] = 'Expense';
			$data['form_url'] = 'expense/editExpense';
			$data['main_view'] = 'expense/form_expense';
			// $data['vcrud'] = $crud;
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function show($id)
	{
		try {
			// $crud = $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'view');
			$res = $this->Expense_model->getAllExpense(array('id' => $id));
			if (empty($res)) {
				throw new UserException('Data Tidak Ditemukan!', UNAUTHORIZED_CODE);
			}
			$data['main_view'] = 'expense/detail';
			$data['return'] = $res[0];
			// $data['vcrud'] = $crud;
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}


	public function history()
	{
		try {
			// $crud = $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'view');
			$data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Expense'));

			$data['title'] = 'Expense';
			$data['main_view'] = 'expense/list_expense.php';
			// $data['vcrud'] = $crud;
			$this->load->view('main/index2.php', $data);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}


	public function addExpense()
	{
		try {
			// $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'create', true);
			$data = $this->input->post();
			$data['amount'] = substr(preg_replace("/[^0-9]/", "", $data['amount']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['amount']), -2);
			$jp = $this->General_model->getAllRefAccount(array('ref_id' => $data['method']))[0];
			$data['generalentry'] = array(
				'date' => $data['date'],
				'customer_id' => $data['payee_id'],
				'naration' => $data['description'],
				'generated_source' => 'expense',
				// 'user_update' => $this->session->userdata('user_id')['id'],
				'no_jurnal' => $this->General_model->gen_number($data['date'], 'AK')
			);
			$data['sub_entry'][0] = array(
				'accounthead' => $data['head_id'],
				'type' => 0,
				'sub_keterangan' => $data['description'],
				'amount' => $data['amount'],
			);
			$data['sub_entry'][1] = array(
				'accounthead' => $jp['ref_account'],
				'type' => 1,
				'sub_keterangan' => $data['description'],
				'amount' => $data['amount'],
			);
			$id = $this->Expense_model->addExpense($data);
			echo json_encode(array('error' => false, 'data' => $id));
			// $this->load->view('accounting/accounts_modal');
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function editExpense()
	{
		try {
			// $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'update', true);
			$data = $this->input->post();

			$data['old'] = $this->Expense_model->getAllExpense(array('id' => $data['id'], 'by_id' => true))[$data['id']];
			$data['amount'] = substr(preg_replace("/[^0-9]/", "", $data['amount']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['amount']), -2);

			$jp = $this->General_model->getAllRefAccount(array('ref_id' => $data['method']))[0];

			$data['generalentry'] = array(
				'date' => $data['date'],
				'customer_id' => $data['payee_id'],
				'naration' => $data['description'],
				'generated_source' => 'expense',
				// 'user_update' => $this->session->userdata('user_id')['id'],
			);

			if (substr($data['old']['date'], 0, -3) != substr($data['date'], 0, -3))
				$data['generalentry']['no_jurnal'] = $this->General_model->gen_number($data['date'], 'AK');

			$data['sub_entry'][0] = array(
				'accounthead' => $data['head_id'],
				'type' => 0,
				'amount' => $data['amount'],
			);
			$data['sub_entry'][1] = array(
				'accounthead' => $jp['ref_account'],
				'type' => 1,
				'amount' => $data['amount'],
			);


			// 	'user_update' => $this->session->userdata('user_id')['id'],
			// );
			// if (substr($data['old']['date'], 0, -3) != substr($data['date'], 0, -3))
			// 	$data['generalentry']['ref_number'] = $this->General_model->gen_number($data['date'], 'AK');
			$accounts = $this->Expense_model->editExpense($data);
			echo json_encode(array('error' => false, 'data' => $data['id']));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function delete($id, $ajax = false)
	{
		try {
			// $this->SecurityModel->Aksessbility_VCRUD('expense', '', 'delete', true);
			// $id = $this->input->post();

			$data = $this->Expense_model->getAllExpense(array('id' => $id, 'by_id' => true))[$id];;
			$accounts = $this->Expense_model->deleteExpense($data);
			if ($ajax) {
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Delete  Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('expense/history');
				return;
			}
			echo json_encode(array('error' => false, 'data' => $data));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}
}
