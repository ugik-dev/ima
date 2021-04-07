<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends CI_Controller
{
    //Backup
    public function index()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Backup Database';

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'backup';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    public function take_backup() 
    {
        $tables  = array(
            'mp_banks',
            'mp_bank_opening',
            'mp_bank_transaction',
            'mp_barcode',
            'mp_brand',
            'mp_brand_sector',
            'mp_category',
            'mp_contactabout',
            'mp_customer_payments',
            'mp_drivers',
            'mp_expense',
            'mp_generalentry',
            'mp_head',
            'mp_invoices',
            'mp_langingpage',
            'mp_productslist',
            'mp_menu',
            'mp_menulist',
            'mp_multipleroles',
            'mp_payee',
            'mp_printer',
            'mp_purchase',
            'mp_region',
            'mp_return',
            'mp_return_list',
            'mp_sales',
            'mp_stock',
            'mp_stores',
            'mp_sub_entry',
            'mp_supplier_payments',
            'mp_supply',
            'mp_temp_barcoder_invoice',
            'mp_todolist',
            'mp_town',
            'mp_units',
            'mp_users',
            'mp_vehicle'
        );

        $this->load->dbutil();
            $db_name = $this->db->database . '_' . date('Y-m-d_H-i-s', time()) . '_backup.txt';
           $prefs = array(
            'tables' => $tables, 
            'ignore' => array(),
            'format' => 'txt',
            'filename' => $db_name ,
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n",
            'foreign_key_checks' => FALSE
        );

        $sql = $this->dbutil->backup($prefs);

        $data = $sql;

        $backup_path = './assets/db_backup/'.$prefs['filename'];

        if (write_file($backup_path, $data)) 
        {
            // Load the download helper and send the file to your desktop
            $this->load->helper('download');
            force_download($db_name,$data);

            return true;  
        } 
        else 
        {
            return false;
        }
    }

    //backup/restore
    public function restore() 
    {
        
        $this->load->model('Transaction_model');
        $result = $this->Transaction_model->backup_restore_transaction();
        
        if($result != '')
        {
            $array_msg = array(
                    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Data berhasil dipulihkan',
                    'alert' => 'info'
                );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Pemulihan data gagal',
                    'alert' => 'danger'
                );
            $this->session->set_flashdata('status', $array_msg);
        }
        redirect('homepage');
    }
    

    function upload_restore()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Restore Database';

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'restore_backup';
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    function format()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Restore Database';

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'format_transaksi';
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    function format_entri()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_sub_entry');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_invoice()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_invoices');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_penjualan()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_sales');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_retur()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_return');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_isi_retur()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_return_list');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_pembelian()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_purchase');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_pembayaran_customer()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_customer_payments');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_pembayaran_supplier()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_supplier_payments');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_expense()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_all('mp_expense');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }

    function format_jurnal()
    {
        
        $this->load->model('Crud_model');
        $result = $this->Crud_model->delete_jurnal('mp_generalentry');
        if ($result == 1 OR $result != 1 )
            {
                $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Berhasil mengosongkan data',
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

  redirect('backup/format');
    }
}