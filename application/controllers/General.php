<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class General extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('General_model', 'Payment_model'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }


    public function getAllProduct()
    {
        try {
            $filter = $this->input->get();
            $data = $this->Payment_model->getAllProduct($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllPaymentMethod()
    {
        try {
            $filter = $this->input->get();
            $data = $this->Payment_model->getAllPaymentMethod($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllJenisPembayaran()
    {
        try {
            $filter = $this->input->get();
            // $filter
            $data = $this->General_model->getAllJenisPembayaran($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllRefAccounts()
    {
        try {
            $filter = $this->input->get();
            $data = $this->General_model->getAllRefAccount($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function product_search($search_result)
    {
        if ($search_result != NULL) {
            $result = $this->Production_model->search_items_stock($search_result);
            $data['search_result'] = $result;
            $this->load->view('production/search_list.php', $data);
        }
    }

    public function payment_search($search_result)
    {
        if ($search_result != NULL) {
            $result = $this->Payment_model->search_items_stock($search_result);
            $data['search_result'] = $result;
            $this->load->view('payment/search_list.php', $data);
        }
    }


    public function getAllUnit()
    {
        try {
            $filter = $this->input->get();
            echo json_encode(array('error' => false, 'data' => $this->General_model->getAllUnit($filter)));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
