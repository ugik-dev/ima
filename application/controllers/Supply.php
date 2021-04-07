<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Supply extends CI_Controller
{
  //CONSTRUCTOR
  function __construct()
  {
    parent::__construct();
     // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
       $this->load->model('Crud_model');
  }

 // Supply
 public function index()
 {

  // DEFINES PAGE TITLE
  $data['title'] = 'Daftar Pengiriman : ';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'DAFTAR PENGIRIMAN :';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'supply_list';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'Invoice',
   'Tanggal',
   'Region',
   'Metode',
   'Total',
   'Diskon',
   'Diterima',
   'Sisa',
   'Customer',
   'Agen',
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
    

  $result = $this->Crud_model->fetch_supply($date1,$date2);

  $data['supply_list'] = $result;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USED TO CREATE NEW SUPPLY 
 //Supply/create_new_supply
 function create_new_supply()
 {
    $user_name = $this->session->userdata('user_id');

    // DEFINES PAGE TITLE
    $data['title'] = 'PENGIRIMAN : ';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'create_supply';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['vehicle_list'] = $this->Crud_model->fetch_record('mp_vehicle',NULL);

    $data['town_list'] = $this->Crud_model->fetch_record('mp_town',NULL);

    // DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
    $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

    $data['drivers_list'] = $this->Crud_model->fetch_record('mp_drivers',NULL);

    $data['customer_list'] = $this->Crud_model->fetch_payee_record('customer','status');

    // LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
    $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);

    $data['temp_view'] = 'supply_invoice_template';

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }

 //USED TO CREATE A SUPPLY 
 //Supply/supply_create 
 function supply_create()
 {
    // DEFINES PAGE TITLE
  $data['title'] = 'PENGIRIMAN BARU ';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'create_supply';

  // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
  $this->load->model('Crud_model');
  $result = $this->Crud_model->fetch_record('mp_purchase', NULL);
  $data['purchase_list'] = $result;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USED TO SHOW THE LIST OF DRIVERS
 //Supply/drivers
 function drivers()
 {
  // DEFINES PAGE TITLE
  $data['title'] = 'Daftar Sopir';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'DAFTAR SOPIR :';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'driver';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'Nama',
   'Kontak',
   'Alamat',
   'No SIM',
   'Referensi',
   'Tanggal',
   'Foto',
   'Status',
   'Aksi'
  );

  // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
  $this->load->model('Crud_model');
  $result = $this->Crud_model->fetch_record('mp_drivers', NULL);
  $data['driver_list'] = $result;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USED TO CREATE DRIVER
 //supply/add_driver
 function add_driver()
 {

  // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
  $this->load->model('Crud_model');
  // DEFINES READ MEDICINE details FORM MEDICINE FORM
  $driver_name = html_escape($this->input->post('driver_name'));
  $contact_no = html_escape($this->input->post('contact_no'));
  $address = html_escape($this->input->post('address'));
  $lisence = html_escape($this->input->post('lisence'));
  $reference = html_escape($this->input->post('reference'));
  $date = html_escape($this->input->post('date'));
  $picture = $this->Crud_model->do_upload_picture("supply_picture", "./uploads/drivers/");
  // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
  $args = array(
   'name' => $driver_name,
   'contact' => $contact_no,
   'address' => $address,
   'lisence' => $lisence,
   'ref' => $reference,
   'date' => $date,
   'cus_picture' =>$picture
  );

  // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
  $result = $this->Crud_model->insert_data('mp_drivers', $args);
  if ($result == 1)
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

  redirect('supply/drivers');

 }

 //USED TO EDIT DRIVER DETAILS 
 //Supply/edit_driver 
 function edit_driver()
 {
    $driver_id = html_escape($this->input->post('driver_id'));
    $driver_name = html_escape($this->input->post('driver_name'));
    $contact_no = html_escape($this->input->post('contact_no'));
    $address = html_escape($this->input->post('address'));
    $lisence = html_escape($this->input->post('lisence'));
    $reference = html_escape($this->input->post('reference'));
    $date = html_escape($this->input->post('date'));
    $picture = $this->Crud_model->do_upload_picture("supply_picture", "./uploads/drivers/");

    // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
    $args = array(
      'table_name'=>'mp_drivers',
      'id' => $driver_id
    );


    // DEFINES IF  IMAGES IS SELECTED SO UPDATE PRIVIOUS PICTURE
    if ($picture == "default.jpg")
    {
      $data = array(
       'name' => $driver_name,
       'contact' => $contact_no,
       'address' => $address,
       'lisence' => $lisence,
       'ref' => $reference,
       'date' => $date
      );
    }
    else
    {
     $data = array(
     'name' => $driver_name,
     'contact' => $contact_no,
     'address' => $address,
     'lisence' => $lisence,
     'ref' => $reference,
     'date' => $date,
     'cus_picture' => $picture
    );
      
      // DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
      $this->Crud_model->delete_image('./uploads/drivers/', $driver_id, 'mp_drivers');   
    }

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      redirect('supply/drivers');
}

 //USED TO LIST VEHICLE 
 //supply/vehicle
 function vehicle()
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Daftar Kendaraan';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'DAFTAR KENDARAAN :';

    // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
    $data['page_add_button_name'] = 'Tambah Kendaraan';

    // DEFINES THE TITLE NAME OF THE POPUP
    $data['page_title_model'] = 'Tambah Kendaraan';

    // DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
    $data['page_title_model_button_save'] = 'Simpan';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'vehicle';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Nama Kendaraan',
     'Nomor Polisi',
     'ID Kendaraan',
     'Nomor Rangka',
     'Nomor Mesin',
     'Tanggal',
     'Status',
     'Aksi'
    );

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $this->load->model('Crud_model');
    $result = $this->Crud_model->fetch_record('mp_vehicle', NULL);
    $data['vehicle_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }

 //USED TO CREATE VEHICLE
 //supply/add_vehicle
 function add_vehicle()
 {
    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $this->load->model('Crud_model');
    // DEFINES READ MEDICINE details FORM MEDICINE FORM
    $vehicle_name = html_escape($this->input->post('vehicle_name'));
    $vehicle_no = html_escape($this->input->post('vehicle_no'));
    $vehicle_id = html_escape($this->input->post('vehicle_id'));
    $vehicle_chase = html_escape($this->input->post('vehicle_chase'));
    $vehicle_engine = html_escape($this->input->post('vehicle_engine'));
    $date = html_escape($this->input->post('date'));

    // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
    $args = array(
     'name' => $vehicle_name,
     'number' => $vehicle_no,
     'vehicle_id' => $vehicle_id,
     'chase_no' => $vehicle_chase,
     'engine_no' => $vehicle_engine,
     'date' => $date
    );

    
    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->insert_data('mp_vehicle', $args);
    if ($result == 1)
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

    redirect('supply/vehicle');

 }

 //USED TO EDIT VEHICLE 
 //Supply/edit_vehicle 
 function edit_vehicle()
 {

    $vehicle_id = html_escape($this->input->post('vehicle_id'));
    $vehicle_name = html_escape($this->input->post('vehicle_name'));
    $vehicle_no = html_escape($this->input->post('vehicle_no'));
    $vehicle_model = html_escape($this->input->post('vehicle_model'));
    $vehicle_chase = html_escape($this->input->post('vehicle_chase'));
    $vehicle_engine = html_escape($this->input->post('vehicle_engine'));
    $date = html_escape($this->input->post('date'));
    

    // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
    $args = array(
      'table_name'=>'mp_vehicle',
      'id' => $vehicle_id
    );


    $data = array(
     'name' => $vehicle_name,
     'number' => $vehicle_no,
     'vehicle_id' => $vehicle_model,
     'chase_no' => $vehicle_chase,
     'engine_no' => $vehicle_engine,
     'date' => $date
    );

  // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->edit_record_id($args, $data);
    if ($result == 1)
    {
      $array_msg = array(
        'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
        'alert' => 'info'
      );
      $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
      $array_msg = array(
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
        'alert' => 'danger'
      );
      $this->session->set_flashdata('status', $array_msg);
    }

    redirect('supply/vehicle');
 }

 //USED TO CREATE Purchase
 //Purchase/create_purchase
 function create_purchase()
 {
  // DEFINES PAGE TITLE
  $data['title'] = 'Tambah Pembelian';

  // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
  $this->load->model('Crud_model');
  $result = $this->Crud_model->fetch_record('mp_supplier', NULL);
  $data['supplier_list'] = $result;

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'create_purchase';

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }


 //USED TO ADD PURCHASE INTO DATAABASE
 // Purchase/add_purchase
 function add_purchase()
 {
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  // DEFINES READ MEDICINE details FORM MEDICINE FORM
  $pur_date = html_escape($this->input->post('pur_date'));
  $pur_supplier = html_escape($this->input->post('pur_supplier'));
  $pur_store = html_escape($this->input->post('pur_store'));
  $pur_invoice = html_escape($this->input->post('pur_invoice'));
  $pur_total = html_escape($this->input->post('pur_total'));
  $pur_tax = html_escape($this->input->post('pur_tax'));
  $pur_method = html_escape($this->input->post('pur_method'));
  $pur_date = html_escape($this->input->post('pur_date'));
  $pur_paid = html_escape($this->input->post('pur_paid'));
  $pur_balance = html_escape($this->input->post('pur_balance'));
  $pur_description = html_escape($this->input->post('pur_description'));
  $picture = $this->Crud_model->do_upload_picture("pur_picture", "./uploads/purchase/");

  // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
  $args = array(
   'date' => $pur_date,
   'supplier_id' => $pur_supplier,
   'store' => $pur_store,
   'invoice_id' => $pur_invoice,
   'total_amount' => $pur_total,
   'tax' => $pur_tax,
   'payment_type_id' => $pur_method,
   'payment_date' => $pur_date,
   'cash_paid' => $pur_paid,
   'balance' => $pur_balance,
   'description' => $pur_description
  );

  
   // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
   $result = $this->Crud_model->insert_data('mp_purchase', $args);
   if ($result == 1)
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


   redirect('purchase/create_purchase');
 }

 //Supply/delete
 function delete($para,$args)
 {

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS

  $this->load->model('Crud_model');

  $table = 'mp_'.$para;

  if($para == 'drivers')
  {
    $redirect = 'supply/drivers';
  }  
  else if($para == 'vehicle')
  {
    $redirect = 'supply/vehicle';
  }

  // DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
  $this->Crud_model->delete_image('./uploads/'.$para.'/', $args, $table);

  // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID

  $result = $this->Crud_model->delete_record($table , $args);
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
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Record cannot be changed',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect($redirect);
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

    if($page_name  == 'edit_drivers_model')
    {
     $data['single_driver'] = $this->Crud_model->fetch_record_by_id('mp_drivers',$param);
     //model name available in admin models folder
     $this->load->view( 'admin_models/edit_models/edit_drivers_model.php',$data);
    } 
    else if($page_name  == 'edit_vehicle_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'supply/edit_vehicle';

     $data['single_veh'] = $this->Crud_model->fetch_record_by_id('mp_vehicle',$param);
     //model name available in admin models folder
     $this->load->view( 'admin_models/edit_models/edit_vehicle_model.php',$data);
    }   
    else if($page_name  == 'add_driver_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'supply/add_driver';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_driver_model.php',$data);
    } 
    else if($page_name  == 'add_vehicle_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'supply/add_vehicle';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_vehicle_model.php',$data);
    }   
  
 }

   // Customer/change_status/id/status
   function change_status($table, $id, $status)
   {

    $table = 'mp_'.$table;

    // TABLENAME AND ID FOR DATABASE Actions
    $args = array(
     'table_name' => $table,
     'id' => $id
    );

    // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
    $data = array(
     'status' => $status
    );

    if($table == 'mp_drivers')
    {
      $redirect = 'supply/drivers';
    }
    else if($table == 'mp_vehicle')
    {
      $redirect = 'supply/vehicle';
    }
    
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

    redirect( $redirect);
   }


  //Supply/add_selected_item
  //USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
  function add_selected_item($id)
  {
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');
    $user_name = $this->session->userdata('user_id');

    if($id != '')
    {
      $result = $this->Crud_model->fetch_record_by_id('mp_productslist',$id);

      if($result != NULL)
      {

      $check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','product_id',$id,$user_name['id'],'supply');


        if(($result[0]->quantity-$result[0]->packsize) >= 0)
        {
          $stockargs   = array(
            'table_name' =>'mp_productslist', 
            'id' =>$result[0]->id, 
          );

          $stockdata = array(
            'quantity' => $result[0]->quantity-$result[0]->packsize
          );

          $this->Crud_model->edit_record_id($stockargs, $stockdata);

          if($check_item_in_temp != NULL)
          {
            $qty = $check_item_in_temp[0]->qty+$result[0]->packsize;
            $pack = $check_item_in_temp[0]->pack+1;

            $args = array(
              'table_name' => 'mp_temp_barcoder_invoice',
              'id' => $check_item_in_temp[0]->id
            );

            $data = array(
              'qty' => $qty,
              'pack' => $pack
            );

            $this->Crud_model->edit_record_id($args, $data);
          }
          else
          {
             //CALCULATING TAX USING EACH ITEMS
              $tax_amount = ($result[0]->tax/100)*$result[0]->retail;

              // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
                $args = array(
                  'barcode' => $result[0]->barcode,
                  'product_no' => $result[0]->sku,
                  'product_id' => $result[0]->id,
                  'product_name' => $result[0]->product_name,
                  'mg' => $result[0]->mg,
                  'price' => $result[0]->whole_sale,
                  'purchase' => $result[0]->purchase,
                  'qty' => $result[0]->packsize,
                  'tax' => $tax_amount,
                  'agentid' => $user_name['id'],
                  'source' => 'supply',
                  'pack' => 1
                );

                // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
                $result = $this->Crud_model->insert_data('mp_temp_barcoder_invoice', $args);
        }

      }
    }

          // DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
          $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

          //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
          $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);

        $this->load->view('supply_invoice_template.php',$data);
    }
  }

    //USED TO UPDATE CHARGES 
    //Supply/update_price
    function update_price($val = '' , $id = '')
    {
       $user_name = $this->session->userdata('user_id');
       
      if($val != '' AND $id != '' )
      {
        $args = array(
            'table_name' => 'mp_temp_barcoder_invoice',
            'id' => $id
          );

              $data = array(
                'price' => $val
              );

              $this->Crud_model->edit_record_id($args, $data);

      }

       //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
          $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);

        $this->load->view('supply_invoice_template.php',$data);

    }    

    //USED TO UPDATE QUANTITY 
    //Supply/update_qty
    function update_qty($requested_qty = '' , $id = '')
    {

        $this->load->model('Pos_transaction_model'); 
          
        $requested_qty = intval($requested_qty);
        $user_name = $this->session->userdata('user_id');

        if($requested_qty != '' AND $id != '' AND  $requested_qty > -1)
        {

            $temp_invoice = $this->Crud_model->fetch_record_by_id('mp_temp_barcoder_invoice',$id);
            $productStock = $this->Crud_model->fetch_record_by_id('mp_productslist',$temp_invoice[0]->product_id);

            $bal = 0;
            $new_qty = 0;

            if($temp_invoice[0]->pack > $requested_qty)
            {
              $pack = $temp_invoice[0]->pack - $requested_qty;

              $temp_qty = $temp_invoice[0]->qty - ($pack*$productStock[0]->packsize);

              $new_qty = $productStock[0]->packsize * $pack;

              $new_qty = $productStock[0]->quantity + $new_qty;

              $pack = $requested_qty;
            }
            else if($temp_invoice[0]->pack < $requested_qty)
            {
               $pack =  $requested_qty - $temp_invoice[0]->pack;

               $new_qty = $productStock[0]->quantity - ($pack*$productStock[0]->packsize);

               $pack = $pack + $temp_invoice[0]->pack;

               $temp_qty = $pack * $productStock[0]->packsize;
            }

            if($temp_invoice[0]->qty != $requested_qty AND $new_qty >= 0)
            {
               $new_args = array(
                'table_name' => 'mp_productslist',
                'id' => $temp_invoice[0]->product_id
               );

              $new_data = array(
                'quantity' => $new_qty
              );

              

              $temp_args = array(
                  'table_name' => 'mp_temp_barcoder_invoice',
                  'id' => $id
              );

              $temp_data = array(
                'qty' => $temp_qty,
                'pack' => $pack
              );

              $this->Pos_transaction_model->general_whole_transaction($new_args,$new_data , $temp_args, $temp_data);
          }

      }

       //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
          $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);
        $this->load->view('supply_invoice_template.php',$data);

    }

    //USED TO CREATE INVOICE VOUCHER
    // Supply/add_supply_invoice
    public function add_supply_invoice()
    {
      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');
      $this->load->model('Transaction_model');
      $driver_id = html_escape($this->input->post('driver_id'));
      $vehicle_id = html_escape($this->input->post('vehicle_id'));
      $region_id = html_escape($this->input->post('region_id'));
      $customer_id = html_escape($this->input->post('customer_id'));
      $payment_method = html_escape($this->input->post('payment_method'));
      $cash_recieved = html_escape($this->input->post('cash_recieved'));
      $total_bill = html_escape($this->input->post('total_bill'));
      $supply_description = html_escape($this->input->post('supply_description'));
      $bank_id = html_escape($this->input->post('bank_id'));
      $ref_no = html_escape($this->input->post('ref_no'));
      $save_available_balance = html_escape($this->input->post('save_available_balance'));

      //SOURCE ID 1 FOR SUPPLY
      $source = html_escape($this->input->post('source'));
      $discountfield = html_escape($this->input->post('discountfield'));
      $user_name = $this->session->userdata('user_id');
      $date = date('Y-m-d');
      $status = 0;

      $data  = array(
          'discount'       => $discountfield, 
          'date'           => $date, 
          'status'         => $status, 
          'agentname'      => $user_name['name'], 
          'driver_id'      => $driver_id, 
          'vehicle_id'     => $vehicle_id, 
          'region_id'      => $region_id, 
          'payment_method' => $payment_method, 
          'total_bill'     => $total_bill,  
          'bill_paid'      => $cash_recieved, 
          'description'    => $supply_description, 
          'source'         => $source, 
          'cus_id'         => $customer_id,
          'bank_id'        => $bank_id,
          'credithead'     => ($payment_method == 0 ? '2' : '16'),
          'ref_no'         => $ref_no
        );
    

    $temp_data = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);
    
    if($temp_data != NULL)
      {
          $result_status = $this->Transaction_model->single_supply_transaction($data);


          if ($result_status != NULL)
          {

            $array_msg = array(
              'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created successfully',
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
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry no item seleted',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      } 

      redirect('supply/create_new_supply');
    }  

  //supply/clear_temp_invoice
  //USED TO CLEAR TEMP INVOICE
  function clear_temp_invoice()
  {
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    //GET THE CURRENT USER
    $user_name = $this->session->userdata('user_id');

    //FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
    $result = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);

    if($result  != NULL)
    {

      foreach ($result as $single_item) 
      {
        //FETCH THE ITEM FROM STOCK TABLE 
        $result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist',$single_item->product_id);

        // TABLENAME AND ID FOR DATABASE Actions
        $args = array(
          'table_name' => 'mp_productslist',
          'id' => $single_item->product_id
        );


        $data = array(
          'quantity' => $result_stock[0]->quantity+$single_item->qty
        );

        // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
        $this->Crud_model->edit_record_id($args, $data);

      }

      $this->Crud_model->delete_record_by_userid('mp_temp_barcoder_invoice','supply',$user_name['id']);
    }

      //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
      $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);

      $this->load->view('supply_invoice_template.php',$data);
  } 

  //supply/delete_item_temporary
  //USED TO DELETE AN ITEM FROM TEMPORARY TABLE OF BARCODE ITEMS
  function delete_item_temporary($item_id)
  { 
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    //FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
    $result = $this->Crud_model->fetch_record_by_id('mp_temp_barcoder_invoice',$item_id);   

    //FETCH THE ITEM FROM STOCK TABLE 
    $result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist',$result[0]->product_id);

    // TABLENAME AND ID FOR DATABASE Actions
    $args = array(
      'table_name' => 'mp_productslist',
      'id' => $result[0]->product_id
    );

    $data = array(
      'quantity' => $result_stock[0]->quantity+$result[0]->qty
    );

    // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
    $this->Crud_model->edit_record_id($args, $data);

    // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
    $this->Crud_model->delete_record('mp_temp_barcoder_invoice', $item_id);
    
    //USER ID
    $user_name = $this->session->userdata('user_id');

    //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
    $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','supply',$user_name['id']);
    
    // DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
    $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');


    $this->load->view('supply_invoice_template.php',$data);
  } 

}