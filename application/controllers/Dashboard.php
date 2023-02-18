<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	// Homepage
	public function index()
	{
		// echo "1";
		$filter = $this->input->get();
		if (empty($filter['year'])) $filter['year'] = date('Y');

		// DEFINES TO LOAD THE CATEGORY RECORD FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$this->load->model('Statement_model');
		$this->load->model('Accounts_model');
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		// DEFINES PAGE TITLE
		$data['title'] = 'Dashboard';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'product Category List :';

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Add New Category';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Add New Category';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Category Name';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'dashboard';
		// echo "2";

		// DIFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Category Name',
			'description',
			'Date',
			'Added By',
			'Status',
			'Actions'
		);

		// DEFINES FETCH THE productS RECORD FROM TABLE mp_productslist WITH LIMIT OF ONLY 6 RECORD
		$data['productList_records'] = $this->Crud_model->fetch_limit_record('mp_productslist', 6);
		echo "<br>52";
		var_dump($data['productList_records']);

		// DEFINES FETCH THE CUSTOMER RECORD FROM TABLE MP_CUSTOMER WITH LIMIT OF ONLY 8 RECORD
		$data['total_retial_cost'] = $this->Crud_model->result_retail_cost();

		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$data['product_Count'] = $this->Crud_model->count_product('mp_productslist', 'status', 0);

		//USED TO SHOW THE LIST OF STOCK SHORTAGE ITEMS DEFINED BY USER
		$data['product_alert_limit'] = $this->Crud_model->fetch_record_product_alert_limit(8);
		echo "<br>63";
		// var_dump($data);
		//CASH IN HAND
		$data['cash_in_hand'] = $this->Statement_model->count_current_time(array('acc_number' => '1.11.000.000'));

		//ACCOUNT RECEIVABLE
		$data['account_recieveble'] = $this->Statement_model->count_current_time(array('acc_number' => '1.13.000.000'));

		//CASH IN BANK
		$data['cash_in_bank'] = $this->Statement_model->count_head_amount_by_id(16);
		echo "<br>76<br>";
		var_dump($data);

		//PAYABLES
		$data['payables'] = $this->Statement_model->count_current_time(array('acc_number' => '2.11.000.000'));

		$data['activity_today'] = $this->Statement_model->my_activity(array('from' => date('Y-m-d'), 'to' => date('Y-m-d') . ' 23.59.59'));

		//STOCK ALERT
		$data['out_of_stock'] = $this->Accounts_model->out_of_stock();

		//RETURN AMOUNT 
		$data['amount_return'] = $this->Accounts_model->amount_return();

		//EXPENSE AMOUNT 
		$data['expense_amount'] = $this->Accounts_model->expense_amount();
		//EXPENSE AMOUNT 
		$data['purchase_amount'] = $this->Accounts_model->purchase_amount();

		$data['customers_count'] = $this->Crud_model->count_product('mp_payee', 'type', 'customer');

		//Count Suppliers
		$data['suppliers_count'] = $this->Crud_model->count_product('mp_payee', 'type', 'supplier');

		//SUPPLIERS
		$data['result_supplier'] = $this->Crud_model->fetch_payee_record('supplier', NULL);

		//CUSTOMER
		$data['result_customer'] = $this->Crud_model->fetch_payee_record('customer', NULL);

		//CURRENCY 
		$data['currency'] = '( RP )';

		// $data['Sales_today_count'] = $this->Crud_model->count_sales('mp_invoices', date('Y-m-d'), date('Y-m-d'));
		// $data['Sales_month_count'] = $this->Crud_model->count_sales('mp_invoices', date('Y-m') . '-1', date('Y-m') . '-30');

		// COUNTING THE TODO LIST FOR THIS MONTH IN Todolist TABLE
		// $data['Todos_count'] = $this->Crud_model->count_sales('mp_todolist', date('Y-m') . '-1', date('Y-m') . '-30');

		// AFTER COUNTING FETCHING THE TODO RECORED FROM GIVEN DATE
		// $data['result_todo'] = $this->Crud_model->fetch_todo_record('mp_todolist', date('Y-m') . '-1', date('Y-m') . '-30');

		$this->load->model('Accounts_model');
		//COUNT AMOUNT OF SALES TODAY AND EXPENSE
		// $data['sales_today_amount'] =  $this->Accounts_model->Statistics_sales_with_date(date('Y-m-d'), date('Y-m-d'));

		// $data['sales_month_amount'] = $this->Accounts_model->Statistics_sales_with_date(date('Y-m' . '-1'), date('Y-m' . '-31'));


		// DEFINES TO LOAD THE MODEL Accounts_model
		$this->load->model('Accounts_model');

		// FETCHING THE EXPENSE AND REVENUE FOR GRAPH
		$result_sales_this_year_and_total_profit = $this->Accounts_model->statistics_sales_this_year();
		$data['result_sales_arr'] = $this->Statement_model->statistics_sales_this_year(array('acc_number' => '4.00.000.000', 'tahun' => $filter['year'], 'bulan' => 12), 2);
		$data['result_expense_this_year'] = $this->Statement_model->statistics_sales_this_year(array('acc_number' => '5.00.000.000', 'tahun' => $filter['year'], 'bulan' => 12), 2, true);

		$data['result_profit_this_year'] = json_encode($result_sales_this_year_and_total_profit[1]);

		echo json_encode($data);
		die();
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$data['filter']  = $filter;
		$this->load->view('main/index.php', $data);
	}

	// Homepage/sign_out
	public function sign_out()
	{
		$this->session->unset_userdata('user_id');
		redirect('/Login');
	}

	public function getActivity()
	{
		$filter = $this->input->get();
		if (!empty($filter['bulanan'])) {
			$filter['from'] = date('Y-m-d' . ' 00.00.00', strtotime('-30 days'));
			$filter['to'] =  date('Y-m-d' . ' 23.59.59');
		} else if (!empty($filter['mingguan'])) {
			$filter['from'] = date('Y-m-d' . ' 00.00.00', strtotime('-7 days'));
			$filter['to'] =  date('Y-m-d' . ' 23.59.59');
		} else if (!empty($filter['harian'])) {
			$filter['from'] = date('Y-m-d' . ' 00.00.00');
			$filter['to'] =  date('Y-m-d' . ' 23.59.59');
		}
		$this->load->model('Statement_model');
		$data = $this->Statement_model->my_activity($filter);
		echo json_encode(array('data' => $data));
		// $this->load->model('Statement_model');
	}

	public function getEvent()
	{
		$filter = $this->input->get();
		if (!empty($filter['bulanan'])) {
			$filter['from'] = date('Y-m-d' . ' 00.00.00', strtotime('-30 days'));
			$filter['to'] =  date('Y-m-d' . ' 23.59.59');
		} else if (!empty($filter['mingguan'])) {
			$filter['from'] = date('Y-m-d' . ' 00.00.00', strtotime('-7 days'));
			$filter['to'] =  date('Y-m-d' . ' 23.59.59');
		} else if (!empty($filter['harian'])) {
			$filter['from'] = date('Y-m-d' . ' 00.00.00');
			$filter['to'] =  date('Y-m-d' . ' 23.59.59');
		}
		$this->load->model('Statement_model');
		$data1 = $this->Statement_model->getEvent($filter);
		$data2 = $this->Statement_model->getEventNotif($filter);
		if (!empty($data1) && !empty($data2))
			$data = array_merge($data1, $data2);
		else if (!empty($data1)) {
			$data = $data1;
		} else if (!empty($data2)) {
			$data = $data2;
		}
		echo json_encode(array('data' => $data));
		// $this->load->model('Statement_model');
	}

	public function document()
	{

		$this->SecurityModel->MultiplerolesGuard('Administration');

		// DEFINES PAGE TITLE
		$data['title'] = 'Administration';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'administration/dokumen_list';

		$this->load->model('Statement_model');
		// $data['transaction_records'] = $this->Statement_model->fetch_transasctions($filter);
		// echo json_encode($data['transaction_records']);
		// die();

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}



	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');
		if ($page_name  == 'add_event') {
			//USED TO REDIRECT LINK
			$data['link'] = 'dashboard/add_event';
			// $data['single_customer'] = $this->Crud_model->fetch_record_by_id('mp_payee', $param);
			//model name available in admin models folder
			$this->load->view(
				'admin_models/add_models/add_event.php',
				$data
			);
		}
	}

	public function add_event()
	{
		$data = $this->input->post();
		$this->load->model('Crud_model');
		$data['user_input'] = $this->session->userdata('user_id')['id'];
		if (!empty($data['label_event']) && !empty($data['nama_event']) && !empty($data['start_event']) && !empty($data['end_event']))
			$this->Crud_model->insert_data('mp_event', $data);
		echo json_encode(array('error' => false, 'data' => $data));
		redirect('dashboard');
	}
}
