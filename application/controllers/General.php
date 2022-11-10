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


    function getAllBaganAkun()
    {
        try {
            $filter = $this->input->get();
            $data = $this->General_model->getAllBaganAkun($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    function serachRab()
    {
        try {
            $filter = $this->input->get();
            $data = $this->General_model->searchRab($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function getZona()
    {
        try {
            $filter = $this->input->get();
            $data = $this->General_model->getZona($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function getAllPelunasanInvoice()
    {
        try {
            $filter = $this->input->get();
            $data = $this->General_model->getAllPelunasanInvoice($filter);
            if (!empty($filter['get_potongan']))
                foreach ($data as $key => $dt) {
                    $data[$key]['data_potongan'] = $this->General_model->getChildrenPelunasan(array('id_pelunasan' => $dt['id']));
                }
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
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

    public function getYearData()
    {
        try {
            $filter = $this->input->get();
            $data = $this->General_model->getYearData($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getLabaRugi()
    {
        try {
            $filter = $this->input->get();
            if (empty($filter['year'])) $filter['year'] = date('Y');

            // $data = $this->General_model->getYearData($filter);
            $data['result_pendapatan'] = $this->General_model->count_akumulasi(array('acc_number' => '4.00.000.000', 'tahun' =>  $filter['year']), 2);
            $data['result_beban'] = $this->General_model->count_akumulasi(array('acc_number' => '5.00.000.000', 'tahun' =>  $filter['year']), 2);

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

    public function getAllJenisInvoice()
    {
        try {
            $filter = $this->input->get();
            // $filter
            $data = $this->General_model->getAllJenisInvoice($filter);
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

    public function searchMitra()
    {
        try {
            $filter = $this->input->get();
            $result['result'] = $this->General_model->searchMitra($filter);
            // echo json_encode($result);
            echo json_encode(array('error' => false, 'data' => $result));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function searchPembayaran()
    {
        try {
            $filter = $this->input->get();
            // $result = $this->General_model->searchPembayaran($filter);
            // echo json_encode($result);
            echo json_encode(array('error' => false, 'data' =>  $this->General_model->searchPembayaran($filter)));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
