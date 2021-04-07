<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Salesreport extends CI_Controller
{
	//salesreport
	public function index()
	{
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Laporan Penjualan';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'LAPORAN PENJUALAN :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'medicine_sales';
		$result =  $this->Crud_model->fetch_payee_record('customer','status');
		$data['customer_list'] = $result;
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'No Invoice',
			'Tanggal',
			'Nama Produk',
			'Weight',
			'Harga',
			'Qty',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		// FECHING VALUES FROM DATE FIELDS
		$first_date = html_escape($this->input->post('date1'));
		$second_date = html_escape($this->input->post('date2'));
		$customer_id = html_escape($this->input->post('customer_id'));
		if ($first_date == NULL OR $second_date == NULL)
		{
			$first_date = date('Y-m-d');
			$second_date = date('Y-m-d');
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_date('mp_invoices', $first_date, $second_date, $customer_id);
		}
		else
		{
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_date('mp_invoices', $first_date, $second_date);
		}

		if ($result_invoices != NULL)
		{
		// print "<pre>";
		// print_r($result_invoices);
		// die;
			$count = 0;
			foreach($result_invoices as $obj_result_invoices)
			{

				// FETCH SALES RECORD FROM SALES TABLE
				$result_sales = $this->Accounts_model->fetch_record_sales('mp_sales', 'order_id', $obj_result_invoices->id);
				if ($result_sales != NULL)
				{
					$collection[$count] = $result_sales;
					$count++;
				}
			}

			// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
			$data['invoices_record'] = $result_invoices;

			// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
			$data['Sales_collection'] = $collection;

			// print_r($result_invoices);
			// print_r($collection);
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
		else
		{
	    	$this->load->model('Crud_model');
			$result =  $this->Crud_model->fetch_payee_record('customer','status');
	    	$data['customer_list'] = $result;
			
			// INCASE OF ERROR OR PAGE NOT FOUND
			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'main/error_invoices.php';
			$data['actionresult'] = "salesreport/";
			$data['heading1'] = "No sales available. ";
			$data['heading2'] = "Oops! Sorry no sales record available in the given details";
			$data['details'] = "We will work on fixing that right away. Meanwhile, you may return or try using the search form.";

			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
	}

	//salesreport/returnitemreport
	function returnitemreport()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Laporan Retur Penjualan';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'LAPORAN RETUR PENJUALAN :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'product_return';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'No Invoice',
			'Tanggal',
			'Nama Customer',
			'Agen',
			'Total Tagihan',
			'Potongan Diskon',
			'Dibayar Kembali',
			'Sisa',
			'Aksi'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		// FECHING VALUES FROM DATE FIELDS
		$first_date = html_escape($this->input->post('date1'));
		$second_date = html_escape($this->input->post('date2'));

		if ($first_date == NULL OR $second_date == NULL)
		{
			$first_date = date('Y-m-d');
			$second_date = date('Y-m-d');
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->return_items_date('mp_return_list', $first_date, $second_date);
		}
		else
		{
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->return_items_date('mp_return_list', $first_date, $second_date);
		}

			$data['return_data'] = $result_invoices;
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
	}
}