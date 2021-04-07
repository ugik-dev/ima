<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller
{
  //CONSTRUCTOR
  function __construct() 
  {
      parent::__construct();

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
       $this->load->model('Crud_model');
  }

 // Product
 public function index()
 {

  // DEFINES PAGE TITLE
  $data['title'] = 'Daftar Produk';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'Daftar Produk :';

  // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
  $data['page_add_button_name'] = 'Tambah Produk';

  // DEFINES THE TITLE NAME OF THE POPUP
  $data['page_title_model'] = 'Tambah Produk';

  // DEFINES THE TITLE NAME OF THE POPUP ADD STOCK
  $data['page_stock_button_name'] = 'Tambah Stok';

  // DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
  $data['page_title_model_button_save'] = 'Simpan Produk';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'product';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'No',
   'Nama Produk',
   'Barcode',
   'Kategori',
   'Gambar',
   'Terjual',
   'Stok',
   'Harga Beli',
   'Harga Eceran',
   'Harga Grosir',
   'Pajak(%)',
   'Tindakan'
  );

  // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
  $this->load->model('Crud_model');
  $product_record = $this->Crud_model->fetch_record_product('all');
  $data['product_record_list'] = $product_record;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USED TO ADD productS 
 //product/add_new_product
 function add_new_product()
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Daftar Produk';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Daftar Produk :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'add_product';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['catagory']  = $this->Crud_model->fetch_record('mp_category', 'status');
   
    $data['brand']  = $this->Crud_model->fetch_record('mp_brand',NULL);

    $data['brandsector']  = $this->Crud_model->fetch_record('mp_brand_sector',NULL);

    $data['units']  = $this->Crud_model->fetch_record('mp_units',NULL);

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }

 //USED TO SHOW DETAILS OF SINGLE PRODUCT 
 //product/product_details 
 function product_details($item_id)
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Daftar Produk';
    
    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'product_detail';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['product']  = $this->Crud_model->fetch_record_by_id('mp_productslist',$item_id);

    $data['catagory']  = $this->Crud_model->fetch_record('mp_category', 'status');
   
    $data['brand']  = $this->Crud_model->fetch_record('mp_brand',NULL);

    $data['brandsector']  = $this->Crud_model->fetch_record('mp_brand_sector',NULL);

    $data['units']  = $this->Crud_model->fetch_record('mp_units',NULL);

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }

 //USED TO SHOW DETAILS OF STOCK 
 //product/product_details 
 function productStock()
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Daftar Stok';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'No',
     'Nama Produk',
     'SKU',
     'Weight',
     'Terjual',
     'Retur',
     'Stok',
     'Purchase',
     'Eceran',
     'Worth',
     'Grosir',
     'Pajak(%)',
     'Lokasi'
    );
   
    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'product_stock_list';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['product']  = $this->Crud_model->fetch_record_product(0);

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }


 // product/add_stock_item
 public function add_stock_item()
 {

  // DEFINES READ Return_items details FORM Return_items FORM
  $item_id   = html_escape($this->input->post('item_id'));
  $manufacturing  = html_escape($this->input->post('manufacturing'));
  $expiry   = html_escape($this->input->post('expiry'));
  $edit_quantity  = html_escape($this->input->post('quantity'));
  $note    = html_escape($this->input->post('note'));
  $date = date('Y-m-d');
  $user_name = $this->session->userdata('user_id');
  $added_by = $user_name['name'];

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
   
  // TABLENAME AND ID FOR DATABASE Actions
  $data = array(
   'mid'    => $item_id,
   'manufacturing' => $manufacturing,
   'expiry'  => $expiry,
   'qty'    => $edit_quantity,
   'description' => $note,
   'date'   => $date, 
   'added'   => $added_by 
  );

  if($item_id != NULL)
  {
     // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
     $result_edit = $this->Crud_model->insert_data('mp_stock',$data);
  }

  
  if ($result_edit == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Stok berhasil ditambah',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Maaf item tidak dapat ditambah',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/pending_stock');
 }

 //product/pending_stock
 //USED TO GET THE LIST OF PENDING STOCK
 function pending_stock()
 {

  // DEFINES PAGE TITLE
  $data['title'] = 'Pending stok';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'Daftar Pending Stok :';

  // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
  $data['page_stock_button_name'] = 'Tambah Stok Baru';

  // DEFINES WHICH PAGE TO RENDER
$data['main_view'] = 'stock_list';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'No',
   'Nama Produk',
   'Weight',
   'Manufaktur',
   'Kadaluarsa',
   'Quantity',
   'Deskripsi',
   'Tanggal',
   'User',
   'Tindakan'
  );

  //  FETCH ALL PENDING STOCK
  $this->load->model('Crud_model');
  $result = $this->Crud_model->fetch_stock_list();
  $data['stock_list'] = $result;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USE FOR UPLOADING CSV FILE
 //product/upload_csv
 function upload_csv()
 {
   $this->load->model('Crud_model');

   $user_name = $this->session->userdata('user_id');
   $added_by = $user_name['name'];

   //FETCHING THE CSV FILE TO UPLOAD RECORD INTO DATABASE TABLE
   $filename = $_FILES['upload_file']['tmp_name'];

  if($_FILES["upload_file"]["size"] > 0)
  {
   $file = fopen($filename, "r");
   while (($importdata = fgetcsv($file)))
   {
    $productid = $importdata[0];
    $data = array(
       'category_id' => $importdata[1],  
       'product_name' => $importdata[2], 
       'mg' => $importdata[3],   
       'quantity' => $importdata[4],  
       'purchase' => $importdata[5],  
       'retail' => $importdata[6],
       'expire' => $importdata[7],  
       'manufacturing' => $importdata[8],  
       'sideeffects' => $importdata[9],  
       'description' => $importdata[10],
       'barcode' => $importdata[11], 
       'min_stock' => $importdata[12], 
       'total_units' => $importdata[13], 
       'packsize' => $importdata[14],   
       'sku' => $importdata[15],  
       'location' => $importdata[16],   
       'tax' => $importdata[17],   
       'type' => $importdata[18],   
       'brand_id' => $importdata[19],   
       'brand_sector_id' => $importdata[20],   
       'unit_type' => $importdata[21],   
       'net_weight' => $importdata[22],   
       'whole_sale' => $importdata[23]  

    );

    if(!empty($productid)){
      $this->db->where('id', $productid);
     $insert_result = $this->db->update('mp_productslist',$data); 
    }else{
      $insert_result =  $this->Crud_model->insert_data('mp_productslist',$data);      
    }


    }
    fclose($file);

    if ($insert_result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> '.'uploaded_successfully',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.'error_in_uploading',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
   }
   else
   {
    $array_msg = array(
         'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.'empty_file',
         'alert' => 'danger'
        );   
    $this->session->set_flashdata('status', $array_msg);
   }

   redirect('product');
 }

 // product/export
 //USED FOR EXPORTING DATA INTO CSV FORMAT
 public function export()
 {
    $args_fileheader  = array(
       'ID product_stock_list', 
       'ID Kategori', 
       'Nama Produk',
       'Mg',   
       'Quantity',   
       'Purchase',  
       'Eceran',  
       'Kadaluarsa',  
       'Manufaktur',
       'Efek samping',
       'Deskripsi', 
       'Barcode', 
       'Minimum Level', 
       'Total Unit', 
       'Packsize',   
       'SKU',   
       'Lokasi',  
       'Pajak(%)',   
       'Tipe Produk',   
       'ID Merk',   
       'Sektor Merk',   
       'Unit',   
       'Net Weight', 
       'Harga Grosir'   
      );

    $args_table_header  = array(
       'id',  
       'category_id',  
       'product_name',
       'mg',   
       'quantity',  
       'purchase',  
       'retail',
       'expire',  
       'manufacturing',  
       'sideeffects',  
       'description',
       'barcode', 
       'min_stock', 
       'total_units', 
       'packsize',   
       'sku',  
       'location',   
       'tax',   
       'type',   
       'brand_id',   
       'brand_sector_id',   
       'unit_type',   
       'net_weight',   
       'whole_sale'   
    );

    //DEFINED IN HELPER FOLDER
    export_csv('products_list',$args_fileheader,$args_table_header,'mp_productslist');

    redirect('product');

 }

 // product/add_catagory
  public function add_catagory()
  {
    // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
    $category_name = html_escape($this->input->post('category_name'));
    $category_description = html_escape($this->input->post('category_description'));
    $date = date('Y-m-d');
    $user_name = $this->session->userdata('user_id');
    $added_by = $user_name['name'];

    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
    $args = array(
      'category_name' => $category_name,
      'description' => $category_description,
      'register_date' => $date,
      'added_by' => $added_by
    );

    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->insert_data('mp_category', $args);
    if ($result == 1)
    {
      $array_msg = array(
        'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Category added Successfully',
        'alert' => 'info'
      );
      $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
      $array_msg = array(
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
        'alert' => 'danger'
      );
      $this->session->set_flashdata('status', $array_msg);
    }

    redirect('product/add_new_product');
  }

 //product/popup
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
    else if($page_name  == 'edit_stock_model')
    {

     // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
     $product_record = $this->Crud_model->fetch_record_product(0);
     $data['product_record_list'] = $product_record;

     $data['single_stock'] = $this->Crud_model->fetch_record_by_id('mp_stock',$param);

     //model name available in admin models folder
     $this->load->view( 'admin_models/edit_models/edit_stock_model.php',$data);
    }
    else if($page_name  == 'add_csv_model')
    {
     $data['path'] = 'product/upload_csv';
     //model name available in admin models folder
     $this->load->view('admin_models/add_models/add_csv_model.php',$data);
    }  
    else if($page_name  == 'add_barcode_model')
    {
     //model name available in admin models folder
     $this->load->view('admin_models/add_models/add_barcode_model.php');
    }  
    else if($page_name  == 'edit_barcode')
    {
     $data['single_product'] = $this->Crud_model->fetch_record_by_id('mp_barcode',$param);
     //model name available in admin models folder
     $this->load->view('admin_models/edit_models/edit_barcode_model.php',$data);
    } 
    else if($page_name  == 'add_brand_model')
    {
     //USED TO ADD DATA
     $data['link'] = 'product/add_brand'; 

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_brand_model.php',$data);
    }   
    else if($page_name  == 'add_brand_sector')
    {

     //USED TO ADD DATA
     $data['link'] = 'product/add_brand_sector';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_brand_sector.php',$data);
    }        
    else if($page_name  == 'add_unit_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'initilization/add_unit';

      //model name available in admin models folder
      $this->load->view( 'admin_models/add_models/add_unit_model.php',$data);
    }  
    else if($page_name  == 'add_category_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'product/add_catagory';
      
      //model name available in admin models folder
      $this->load->view( 'admin_models/add_models/add_category_model.php',$data);
    }
  
 }


 //product/add_product
 public function add_product()
 {

  // DEFINES READ product details FORM product FORM
  $category_id = html_escape($this->input->post('category_id'));
  $product_name = html_escape($this->input->post('product_name'));
  $product_mg = html_escape($this->input->post('product_mg'));
  $stock_quantity = html_escape($this->input->post('stock_quantity'));
  $barcode = html_escape($this->input->post('barcode'));
  $min_stock = html_escape($this->input->post('min_stock'));
  $company_name = html_escape($this->input->post('company_name'));
  $supplier_id = html_escape($this->input->post('supplier_id'));
  $purchase = html_escape($this->input->post('purchase'));
  $retail = html_escape($this->input->post('retail'));
  $discount = html_escape($this->input->post('discount'));
  $total_units = html_escape($this->input->post('total_units'));
  $packsize = html_escape($this->input->post('packsize'));
  $sku = html_escape($this->input->post('sku'));
  $location = html_escape($this->input->post('location'));
  $tax = html_escape($this->input->post('tax'));
  $expiry_date = html_escape($this->input->post('expiry_date'));
  $manufacturing_date = html_escape($this->input->post('manufacturing_date'));
  $side_effects = html_escape($this->input->post('side_effects'));
  $description = html_escape($this->input->post('description'));

  $type = html_escape($this->input->post('type'));
  $brand_id = html_escape($this->input->post('brand_id'));
  $sector_id = html_escape($this->input->post('sector_id'));
  $unit_symbol = html_escape($this->input->post('unit_symbol'));
  $net_weight = html_escape($this->input->post('net_weight'));
  $whole_sale = html_escape($this->input->post('whole_sale'));
  $product_picture = $this->Crud_model->do_upload_picture("product_picture", "./uploads/products/");
  // $picture = html_escape($this->input->post('picture'));
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
  $args = array(
   'category_id' => $category_id,
   'product_name' => $product_name,
   'mg' => $product_mg,
   'quantity' => $stock_quantity,
   'purchase' => $purchase,
   'retail' => $retail,
   'total_units' => $total_units,
   'packsize' => $packsize,
   'sku' => $sku,
   'location' => $location,
   'tax' => $tax,
   'expire' => $expiry_date,
   'manufacturing' => $manufacturing_date,
   'sideeffects' => $side_effects,
   'barcode' => $barcode,
   'min_stock' => $min_stock,
   'description' => $description,
   'type' => $type,
   'image' => $product_picture,
   'brand_id' => $brand_id,
   'brand_sector_id' => $sector_id,
   'unit_type' => $unit_symbol,
   'net_weight' => $net_weight,
   'whole_sale' => $whole_sale
  );

  $check_barcode_exist = $this->Crud_model->fetch_attr_record_by_id('mp_productslist','barcode',$barcode);
  if($check_barcode_exist == NULL OR $barcode == NULL)
  {
    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->insert_data('mp_productslist', $args);
    if ($result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Berhasil Ditambahkan',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error product cannot be added',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
  }
  else
  {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Barcode already exists',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
  }
  redirect('product/add_new_product');
 }

function random_number() 
{
	$result = '';

	for($i = 0; $i < 10; $i++) 
	{
		$result .= mt_rand(0,9);
	}

	//LOADING MODEL CLASS
    $this->load->model('Crud_model');
    $brand_check =  $this->Crud_model->fetch_attr_record_by_id('mp_barcode','random_no',$result);
    if($brand_check == NULL)
    {

    }
    else
    {
    	 $this->random_number(); 
    }

	return $result;
}

 //product/add_barcode
 public function add_barcode()
 {

    $barcode_no = $this->random_number();
  	// DEFINES READ product details FORM product FORM
  	$product_name = html_escape($this->input->post('product_name'));
  	$product_description = html_escape($this->input->post('product_description'));
  
	//USED TO CHECK BRAND ALREADY EXISITS OR NOT 
   
	// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
	 $args = array(
		'barcode' => $product_name,
		'random_no' =>$barcode_no,
		'description' => $product_description
		);

   	// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
   	$this->load->model('Crud_model');

   	// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
   	$result = $this->Crud_model->insert_data('mp_barcode', $args);
   	if ($result == 1)
   	{
    	$array_msg = array(
     	'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Berhasil Ditambahkan',
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

  	redirect('product/generate_barcode');

 }


 // product/delete
 public function delete($args)
 {

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
  $result = $this->Crud_model->delete_record('mp_productslist', $args);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Product record removed',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Product cannot be deleted, it may exists in sales',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product');
 } 

 //product/update_to_stock
 //USED TO UPDATE PENDING STOCK TO FINAL STOCK
 function update_to_stock($stock_id = '')
 {

   if($stock_id != '')
   {

   // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
   $this->load->model('Crud_model');

   // FETCHING THE Item QTY THOUGH ITS ID FROM Item TABLE
   $stock_pending = $this->Crud_model->fetch_record_by_id('mp_stock', $stock_id);
   $fetched_pend_qty = $stock_pending[0]->qty;
   $fetched_mid = $stock_pending[0]->mid;
   $fetched_manufacturing = $stock_pending[0]->manufacturing;
   $fetched_expiry = $stock_pending[0]->expiry;

  

   // FETCHING THE Item QTY THOUGH ITS ID FROM Item TABLE
   $item_fetch = $this->Crud_model->fetch_record_by_id('mp_productslist', $fetched_mid);
   $fetched_qty = $item_fetch[0]->quantity;
   $new_qty = $fetched_pend_qty + $fetched_qty;

   // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
   $data_edit = array(
    'manufacturing' => $fetched_manufacturing,
    'expire'   => $fetched_expiry,
    'quantity'  => $new_qty
   );

   // TABLENAME AND ID FOR DATABASE Actions
   $args_edit = array(
    'table_name' => 'mp_productslist',
    'id' => $fetched_mid
   );

   // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
   $result_edit = $this->Crud_model->edit_record_id($args_edit, $data_edit);
   if ($result_edit == 1)
   {
    $array_msg = array(
     'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Stock added',
     'alert' => 'info'
    );

    $this->session->set_flashdata('status', $array_msg);

     $this->Crud_model->delete_record('mp_stock',$stock_id);

   }
   else
   {
    $array_msg = array(
     'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Sorry stock cannot be added',
     'alert' => 'danger'
    );

    $this->session->set_flashdata('status', $array_msg);
   }
  }

  redirect('product/pending_stock');
 }


 // product/delete_stock
 public function delete_stock($args)
 {

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
  $result = $this->Crud_model->delete_record('mp_stock', $args);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> stock record removed',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error stock record cannot be changed',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/pending_stock');
 }

 //product/edit
 public function edit()
 {

  // RETRIEVING UPDATED VALUES FROM FORM product FORM

  $edit_product_id = html_escape($this->input->post('edit_product_id'));
  $edit_category_id = html_escape($this->input->post('edit_category_id'));
  $edit_product_name = html_escape($this->input->post('edit_product_name'));
  $edit_mg = html_escape($this->input->post('edit_mg'));
  $edit_purchase = html_escape($this->input->post('edit_purchase'));
  $edit_retail = html_escape($this->input->post('edit_retail'));

  $edit_total_units = html_escape($this->input->post('edit_total_units'));
  $edit_packsize = html_escape($this->input->post('edit_packsize'));
  $edit_sku = html_escape($this->input->post('edit_sku'));
  $edit_location = html_escape($this->input->post('edit_location'));
  $edit_tax = html_escape($this->input->post('edit_tax'));
  $edit_expiry_date = html_escape($this->input->post('edit_expiry_date'));
  $edit_manufacturing_date = html_escape($this->input->post('edit_manufacturing_date'));
  $edit_side_effects = html_escape($this->input->post('edit_side_effects'));
  $edit_description = html_escape($this->input->post('edit_description'));
  $edit_barcode = html_escape($this->input->post('edit_barcode'));
  $edit_min_stock = html_escape($this->input->post('edit_min_stock'));
  $edit_type = html_escape($this->input->post('edit_type'));
  $brand_id = html_escape($this->input->post('brand_id'));
  $sector_id = html_escape($this->input->post('sector_id'));
  $unit = html_escape($this->input->post('unit'));
  $net_weight = html_escape($this->input->post('net_weight'));
  $whole_sale = html_escape($this->input->post('whole_sale'));
  $edit_picture = $this->Crud_model->do_upload_picture("edit_product_picture", "./uploads/products/");
    
   $check_barcode_exist = $this->Crud_model->fetch_attr_record_by_id('mp_productslist','barcode',$edit_barcode);

  //print_r($check_barcode_exist);
  if($check_barcode_exist != NULL OR $edit_barcode != NULL)
  {  

    // TABLENAME AND ID FOR DATABASE Actions
    $args = array(
     'table_name' => 'mp_productslist',
     'id' => $edit_product_id
    );

    // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
    if($edit_picture == "default.jpg")
    {
          $data = array(
       'category_id' => $edit_category_id,
       'product_name' => $edit_product_name,
       'mg' => $edit_mg,
       'purchase' => $edit_purchase,
       'retail' => $edit_retail,
       'total_units' => $edit_total_units,
       'packsize' => $edit_packsize,
       'sku' => $edit_sku,
       'location' => $edit_location,
       'tax' => $edit_tax,
       'expire' => $edit_expiry_date,
       'manufacturing' => $edit_manufacturing_date,
       'sideeffects' => $edit_side_effects,
       'min_stock' => $edit_min_stock,
       'barcode' => $edit_barcode,
       'type' => $edit_type,
       'brand_id' => $brand_id,
       'brand_sector_id' => $sector_id,
       'unit_type' => $unit,
       'net_weight' => $net_weight,
       'whole_sale' => $whole_sale
      );
    }
    else
    {
              $data = array(
       'category_id' => $edit_category_id,
       'product_name' => $edit_product_name,
       'mg' => $edit_mg,
       'purchase' => $edit_purchase,
       'retail' => $edit_retail,
       'total_units' => $edit_total_units,
       'packsize' => $edit_packsize,
       'sku' => $edit_sku,
       'location' => $edit_location,
       'tax' => $edit_tax,
       'expire' => $edit_expiry_date,
       'manufacturing' => $edit_manufacturing_date,
       'sideeffects' => $edit_side_effects,
       'min_stock' => $edit_min_stock,
       'barcode' => $edit_barcode,
       'type' => $edit_type,
       'image' => $edit_picture,
       'brand_id' => $brand_id,
       'brand_sector_id' => $sector_id,
       'unit_type' => $unit,
       'net_weight' => $net_weight,
       'whole_sale' => $whole_sale
      );

      // DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
      $this->Crud_model->delete_image('./uploads/products/', $edit_product_id, 'mp_productslist');         
    }


    // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
    $result = $this->Crud_model->edit_record_id($args, $data);
    if ($result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> product editted',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Editted',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }  

  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error barcode does not exists',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product');
 }

 //product/edit_stock
 public function edit_stock()
 {

  // RETRIEVING UPDATED VALUES FROM FORM product FORM
  $edit_stock_id = html_escape($this->input->post('edit_stock_id'));
  $edit_product_id = html_escape($this->input->post('edit_product_id'));
  $edit_manufacturing = html_escape($this->input->post('edit_manufacturing'));
  $edit_expiry = html_escape($this->input->post('edit_expiry'));
  $edit_qty = html_escape($this->input->post('edit_qty'));
  $edit_description = html_escape($this->input->post('edit_description'));
  

  // TABLENAME AND ID FOR DATABASE Actions

  $args = array(
   'table_name' => 'mp_stock',
   'id' => $edit_stock_id
  );

  // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
  $data = array(
   'mid' => $edit_product_id,
   'manufacturing' => $edit_manufacturing,
   'expiry' => $edit_expiry,
   'qty' => $edit_qty,
   'description' => $edit_description
  );

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
  $result = $this->Crud_model->edit_record_id($args, $data);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Stock editted',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error stock cannot be editted',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/pending_stock');
 }

 // product/change_status/id/status
 public function change_status($id, $status)
 {

    // TABLENAME AND ID FOR DATABASE Actions
    $args = array(
     'table_name' => 'mp_productslist',
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

    redirect('product');
 }

 //USED TO DELETE BARCODE
 function delete_barcode($args)
 {
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
  $result = $this->Crud_model->delete_record('mp_barcode', $args);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Brand removed',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be changed',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/generate_barcode');
 }

 //USED TO UPDATE BARCODE
 function edit_barcode()
 {

  // RETRIEVING UPDATED VALUES FROM FORM product FORM

  $edit_barcode_id = html_escape($this->input->post('edit_barcode_id'));
  $product_name = html_escape($this->input->post('product_name'));
  $product_description = html_escape($this->input->post('product_description'));
   
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  //USED TO CHECK BRAND ALREADY EXISITS OR NOT 
   $brand_check =  $this->Crud_model->fetch_attr_record_by_id('mp_barcode','barcode',$brand_name);
   
   // TABLENAME AND ID FOR DATABASE Actions
   $args = array(
    'table_name' =>'mp_barcode',
    'id'    => $edit_barcode_id
   );

   // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
   $data = array(
    'barcode' => $product_name,
    'description' => $product_description
   );

   

   // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
   $result = $this->Crud_model->edit_record_id($args, $data);
   if ($result == 1)
   {
    $array_msg = array(
     'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Product editted',
     'alert' => 'info'
    );
    $this->session->set_flashdata('status', $array_msg);
   }
   else
   {
    $array_msg = array(
     'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be editted',
     'alert' => 'danger'
    );
    $this->session->set_flashdata('status', $array_msg);
   }


  redirect('product/generate_barcode');
 }


 //USED TO SAVE BARCODES
 function generate_barcode()
 {
  // DEFINES PAGE TITLE
  $data['title'] = 'Daftar Barcode';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'Daftar Barcode :';

  // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
  $data['page_add_button_name'] = 'Buat Kode';

  // DEFINES THE TITLE NAME OF THE POPUP
  $data['page_title_model'] = 'Tambah Barcode';

  // DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
  $data['page_title_model_button_save'] = 'Simpan Barcode';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'barcodelist';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'Nama Produk',
   'Barcode',
   'Deskripsi',
   'Tindakan'
  );

  // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
  $this->load->model('Crud_model');
  $barcode_record = $this->Crud_model->fetch_record('mp_barcode',NULL);
  $data['barcode_record_list'] = $barcode_record;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }
 

 //USED TO PRINT ON PAPER
 function print_barcode($barcode_id,$qty)
 { 
	$this->load->model('Crud_model');

    // FETCHING THE Item QTY THOUGH ITS ID FROM Item TABLE
    $brand_fetch = $this->Crud_model->fetch_record_by_id('mp_barcode', $barcode_id);
    $brand_serial = $brand_fetch[0]->random_no;


    //CALLING A BARCODE LIBRARY
    $this->load->library('barcode');
  
    $data['barcode'] = $this->barcode->generate_bar128(stripcslashes($brand_serial));

    $data['barcode_qty'] = $qty;

    $data['brand_name'] = $brand_fetch[0]->barcode;

   	// DEFINES WHICH PAGE TO RENDER
 	 $data['main_view'] = 'barcodeprintlist';

 	// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  	$this->load->view('main/index.php', $data);

   }

  //USED TO LIST THE EXPIRED product 
  //product/expired_list 
   function expired_list()
   {
      // DEFINES PAGE TITLE
      $data['title'] = 'Produk Kadaluarsa';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Produk Kadaluarsa :';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'expired_list';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Nama Produk',
       'Weight',
       'Manufaktur',
       'Kadaluarsa',
       'Qty',
       'Purchase',
       'Eceran',
       'Worth',
       'Lokasi',
       'Tindakan'
      );

      // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
      $this->load->model('Crud_model');
      $data['expire_result'] = $this->Crud_model->fetch_expired_record();
      

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
   }

  //USED TO LIST THE EXPIRED product IN STOCK 
  //product/expired_list 
   function expired_stock()
   {
      // DEFINES PAGE TITLE
      $data['title'] = 'Stok Kadaluarsa';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Stok Kadaluarsa :';

      // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'expired_stock';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Merk',
       'Weight',
       'Manufaktur',
       'Kadaluarsa',
       'Qty',
       'Purchase',
       'Eceran',
       'Worth',
       'Lokasi',
       'Tindakan'
      );

      // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
      $this->load->model('Crud_model');
      $data['expire_result'] = $this->Crud_model->fetch_record_product(2);
      

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
   }

   //USED TO ADD BRAND INTO DATABASE
   //Product/add_brand
   function add_brand()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $brand_name = html_escape($this->input->post('brand_name'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'name' => $brand_name
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_brand', $args);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
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

      redirect('product/add_new_product');
   } 


    //USED TO ADD BRAND SECTOR INTO DATABASE
   //Product/add_brand_sector
   function add_brand_sector()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $brandSector = html_escape($this->input->post('brand_sector_name'));
      $status = html_escape($this->input->post('status'));
      $created = date('Y-m-d');
      $updated = date('Y-m-d');

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'sector' => $brandSector,
        'created' => $created,
        'updated' => $updated
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_brand_sector', $args);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
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

      redirect('product/add_new_product');
   }

}