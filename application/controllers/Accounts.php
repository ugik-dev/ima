<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Accounts extends CI_Controller
{
     // Accounts
     public function index()
     {

      // DEFINES PAGE TITLE
      $data['title'] = 'Daftar Akun';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Daftar Akun :';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'chart_of_accounts';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Nama Akun',
       'Kelompok',
       'Tipe',
       'Relasi',
       'Jenis Beban',
       'Tindakan'
      );

      // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
      $this->load->model('Crud_model');
      $result = $this->Crud_model->fetch_record('mp_head', NULL);
      $data['chart_list'] = $result;

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
     }

     //USED TO ADD CHART OF ACCOUNT
     //Accounts/chart_of_account
     public function chart_of_account()
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // DEFINES READ MEDICINE details FORM MEDICINE FORM
      $name = html_escape($this->input->post('name'));
     echo $nature = html_escape($this->input->post('nature'));
      $type = html_escape($this->input->post('type'));
     // $relation = html_escape($this->input->post('relation'));
      echo $expense_type = html_escape($this->input->post('expense_type'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
       'name' => $name,
       'nature' => $nature,
       'type' => $type,
       //'relation_id' => $relation,
       'expense_type' => ($nature == 'Expense' ? $expense_type : '-')
      );

      // CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
      $result = $this->Crud_model->check_email_address('mp_head', 'name', $name);
      if ($result == NULL)
      {
          // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
          $result = $this->Crud_model->insert_data('mp_head', $args);
         
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
           'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cannot be added',
           'alert' => 'danger'
          );
          $this->session->set_flashdata('status', $array_msg);
         }
       }
      else
      {
         $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>Sorry already exists !',
          'alert' => 'danger'
         );
         $this->session->set_flashdata('status', $array_msg);
      }
      redirect('accounts');
     }

     // Accounts/delete
     function delete($args)
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
      $result = $this->Crud_model->delete_record('mp_head', $args);
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

      redirect('accounts');

     }

     // Accounts/Edit
     function edit_charts()
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
      $head_id = html_escape($this->input->post('head_id'));
      $name = html_escape($this->input->post('name'));
      $edit_nature = html_escape($this->input->post('edit_nature'));
      $edit_type = html_escape($this->input->post('edit_type'));
      $relation = html_escape($this->input->post('relation'));
      $expense_type = html_escape($this->input->post('expense_type'));

      // TABLENAME AND ID FOR DATABASE Actions
      $args = array(
       'table_name' => 'mp_head',
       'id' => $head_id
      );

      
       // DEFINES IF  IMAGES IS SELECTED SO UPDATE PRIVIOUS PICTURE
       $data = array(
        'name' => $name,
        'nature' => $edit_nature,
        'type' => $edit_type,
         'expense_type' => ($edit_nature == 'Expense' ? $expense_type : '-')
       );

      // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
       $array_msg = array(
        'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Head editted',
        'alert' => 'info'
       );
       $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
       $array_msg = array(
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Head cannot be editted',
        'alert' => 'danger'
       );
       $this->session->set_flashdata('status', $array_msg);
      }
      redirect('accounts');
     }

     //Customer/popup
     //DEFINES A POPUP MODEL OG GIVEN PARAMETER
     function popup($page_name = '',$param = '')
     {
      $this->load->model('Crud_model');

      if($page_name  == 'edit_customer_model')
      {
       $data['single_customer'] = $this->Crud_model->fetch_record_by_id('mp_customer',$param);
       //model name available in admin models folder
       $this->load->view( 'admin_models/edit_models/edit_customer_model.php',$data);
      } 
      else if($page_name  == 'add_chart_of_accounts')
      {
       //USED TO REDIRECT LINK
       $data['link'] = 'Accounts/chart_of_account';

       //model name available in admin models folder
       $this->load->view( 'admin_models/add_models/add_chart_of_account_model.php',$data);
      }
      else if($page_name  == 'edit_chart_of_accounts')
      {
       
        $data['head_data'] = $this->Crud_model->fetch_record_by_id('mp_head',$param );
        $this->load->view( 'admin_models/edit_models/edit_chart_of_accounts',$data);
      }  
      else if($page_name  == 'edit_customer_payment_model')
      {
       
       $data['customer_list'] = $this->Crud_model->fetch_record('mp_customer', NULL);

       $data['customer_payments'] = $this->Crud_model->fetch_record_by_id('mp_customer_payments',$param );
       
       $this->load->view( 'admin_models/edit_models/edit_customer_payment_model.php',$data);
      }
      
     }

     //USED TO ADD Accounts PAYMENTS 
     //Customer/add_customer_payments
     function add_customer_payments()
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // DEFINES READ MEDICINE details FORM MEDICINE FORM
      $customer_id = html_escape($this->input->post('customer_id'));
      $amount = html_escape($this->input->post('amount'));
      $method = html_escape($this->input->post('method'));
      $description = html_escape($this->input->post('description'));
      $user_date = Date('Y-m-d');
      $user_name = $this->session->userdata('user_id');

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
       'customer_id' => $customer_id,
       'method' => $method,
       'date' => $user_date,
       'description' => $description,
       'agentname' => $user_name['name']
      );

       // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
       $result = $this->Crud_model->insert_data('mp_customer_payments', $args);
       if ($result == 1)
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
      

      redirect('Accounts/payment_list');
     }

     //USED TO UPDATE CUSTOMER PAYMENTS 
     //customer/edit_customer_payments
     function edit_customer_payments()
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // USER'S ACTIVE SESSION
      $user_name = $this->session->userdata('user_id');

      // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
      $post_id = html_escape($this->input->post('post_id'));
      $customer_id = html_escape($this->input->post('customer_id'));
      $amount = html_escape($this->input->post('amount'));
      $method = html_escape($this->input->post('method'));
      $description = html_escape($this->input->post('description'));
      

      // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
      $data = array(
       'customer_id' => $customer_id,
       'amount' => $amount,
       'method' => $method,
       'description' => $description
      );
       
      
      // TABLENAME AND ID FOR DATABASE Actions
      $args = array(
       'table_name' => 'mp_customer_payments',
       'id' => $post_id
      );

      // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
       $array_msg = array(
        'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> Payment Editted',
        'alert' => 'info'
       );
       $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
       $array_msg = array(
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Payment cannot be editted',
        'alert' => 'danger'
       );
       $this->session->set_flashdata('status', $array_msg);
      }

      redirect('Accounts/payment_list');
     }

     // Customer/change_status/id/status
     function change_status($id, $status)
     {

      // TABLENAME AND ID FOR DATABASE Actions
      $args = array(
       'table_name' => 'mp_customer',
       'id' => $id
      );

      // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
      $data = array(
       'cus_status' => $status
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

      redirect('Accounts');
     }


     //USED TO CALCULATE THE CUSTOMER LADGER 
     function ledger()
     {
     
      // DEFINES PAGE TITLE
      $data['title'] = 'Buku Besar Customer';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Buku Besar Customer :';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'customer_ledger';

      $this->load->model('Crud_model');
      $result = $this->Crud_model->fetch_record('mp_customer','status');
      $data['customer_list'] = $result;

      $data['ledger'] = '';

      $data['return_data'] = '';

      $data['recieved_payments'] = '';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Tanggal',
       'Diskon(%)',
       'Total Tagihan',
       'Total Dibayar',
       'Sisa',
       'No Invoice'
      );

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
      
     }

     //USED TO CREATE LEDGER
     function create_ledger()
     {
      // RETRIEVING  VALUES FROM FORM CUSTOMER LEDGER FORM
       $customer_id = html_escape($this->input->post('customer_id'));
      $ledger_data = '';
      $this->load->model('Accounts_model');
      $this->load->model('Crud_model');

      $ledger_data = $this->Accounts_model->fetch_customer_ledger($customer_id);

      $data['ledger'] = $ledger_data;

      // DEFINES PAGE TITLE
      $data['title'] = 'Buku Besar Customer';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Buku Besar Customer :';
      if($ledger_data != NULL)
      {
       $data['heading'] = $ledger_data[0]->customer_name.' Ledger';

       $data['email_phone'] = $ledger_data[0]->cus_email.' | '.$ledger_data[0]->cus_contact_1;
      }

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'customer_ledger';
      
      $result = $this->Crud_model->fetch_record('mp_customer','status');

      $data['customer_list'] = $result;
      
      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Tanggal',
       'Diskon(%)',
       'Total Tagihan',
       'Total Dibayar',
       'Sisa',
       'No Invoice'
      );  

      // DEFINES THE TABLE HEAD FOR RETURN ITEMS
      $data['table_heading_names_of_coloums_retun'] = array(
       'Tanggal',
       'Nama Item',
       'Total Tagihan',
       'Total Dibayar',
       'Sisa',
       'No Invoice'
      );  

      // DEFINES THE TABLE HEAD FOR PAID ITEMS BY Accounts
      $data['table_heading_names_of_coloums_recieved'] = array(
       'Tanggal',
       'Metode',
       'Diterima oleh',
       'Diterima Kas',
       'Keterangan'
      );

      $data['return_data'] = $this->Crud_model->fetch_attr_record_by_id('mp_return_item','cus_id',$customer_id );

      $data['recieved_payments'] = $this->Crud_model->fetch_attr_record_by_id('mp_customer_payments','customer_id',$customer_id );

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
     }

     //USED TO LIST THE CUSTOMER PAYMENT 
     //Customer/payment_list 
     function payment_list()
     {
      // DEFINES PAGE TITLE
      $data['title'] = 'Pembayaran Customer';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Pembayaran Customer:';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'customer_payment_list';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'ID Transaksi',
       'Nama Customer',
       'Jumlah',
       'Metode',
       'Tanggal',
       'Keterangan',
       'Aksi'
      );
      
      // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
      $this->load->model('Crud_model');
      $result = $this->Crud_model->fetch_record('mp_customer_payments', NULL);
      $data['customer_payment'] = $result;

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
     }
}