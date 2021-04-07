<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class StockAlertReport extends CI_Controller
{
	// stockAlertReport
	public function index()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Laporan Stok Habis';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'LAPORAN STOK HABIS :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'stockAlertReport';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Nama Produk',
			'Weight',
			'Quantity',
			'Min level',
			'Harga Eceran',
			'Pending'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Crud_model');

	   // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$product_record = $this->Crud_model->fetch_record_product_alert();

		$data['product_record_list'] = $product_record;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
		
	}

	//stockAlertReport/popup
	 //DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');
		if($page_name  == 'add_stock_model')
		{
		   // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		   $product_record = $this->Crud_model->fetch_record_product(0);
		   $data['product_record_list'] = $product_record;
		   //model name available in admin models folder
		   $this->load->view( 'admin_models/add_models/add_stock_model.php',$data);
		} 
	 }
}