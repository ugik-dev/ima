<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\Writer\Word2007;

class Referensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('General_model', 'InvoiceModel', 'Statement_model', 'Invoice_model'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }


    public function editJenisInvoice()
    {
        try {
            $this->load->model(array('SecurityModel', 'InvoiceModel'));
            $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);
            $data = $this->input->post();
            $this->Invoice_model->editJenisInvoice($data);
            $data = $this->General_model->getAllJenisInvoice(array('id' =>  $data['id'], 'by_id' => true))[$data['id']];
            echo json_encode(array("error" => false, "data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function addJenisInvoice()
    {
        try {
            $this->load->model(array('SecurityModel', 'InvoiceModel'));
            $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);
            $data = $this->input->post();
            $id = $this->Invoice_model->addJenisInvoice($data);
            $data = $this->General_model->getAllJenisInvoice(array('id' =>  $id, 'by_id' => true))[$id];
            echo json_encode(array("error" => false, "data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function jenis_invoice_pembayaran()
    {
        try {
            // $crud = $this->SecurityModel->Aksessbility_VCRUD('pembayaran', 'jenis_pembayaran', 'view');
            $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true));
            // echo json_encode($data['accounts'][5]);
            // die();
            $data['title'] = 'List Jenis Invoice';
            $data['main_view'] = 'refensi/jenis_invoice';
            // $data['vcrud'] = $crud;
            $data['vcrud'] = array('parent_id' => 32, 'id_menulist' => 89);
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
