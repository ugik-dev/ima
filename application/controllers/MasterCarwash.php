<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class MasterCarwash extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'CarWashModel', 'General_model'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->MultiplerolesGuard('Master Carwash');

        $this->db->db_debug = TRUE;
    }

    public function getAllPriceList()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->CarWashModel->getAllPriceList($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllTransaksi()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->CarWashModel->getAllTransaksi($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getAllPegawai()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->CarWashModel->getAllPegawai($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getAllPriceList2()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->CarWashModel->getAllPriceList2($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getBankTransaction()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->CarWashModel->getBankTransaction($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getBank()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $accounts = $this->CarWashModel->getAllBank($filter);
            echo json_encode(array('error' => false, 'data' => $accounts));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function transaksi()
    {
        try {
            $crud = $this->SecurityModel->MultiplerolesGuard('Master Carwash');
            $data['title'] = 'Transaksi';
            $data['main_view'] = 'mastercarwash/transaksi';
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function pegawai()
    {
        try {
            $crud = $this->SecurityModel->MultiplerolesGuard('Master Carwash');
            // $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Assets'));

            $data['title'] = 'Pegawai';
            $data['main_view'] = 'mastercarwash/pegawai';
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function edit()
    {
        $data = $this->input->post();
        // $data['id_petugas'] = $this->session->userdata('user_id')['id'];
        $id =  $this->CarWashModel->edit($data);
        $dataLog = [
            'id_carwash' => $id,
            'nama' => $this->session->userdata('user_id')['name'],
            'keterangan' => "Edit Data "
        ];

        $this->CarWashModel->add_log($dataLog);

        $data = $this->CarWashModel->getAll(['id_carwash' => $id])[$id];
        echo json_encode(['error' => false, 'data' => $data]);
    }

    public function delete()
    {
        $data = $this->input->get();
        // $data['id_petugas'] = $this->session->userdata('user_id')['id'];
        $id =  $this->CarWashModel->delete($data);
        echo json_encode(['error' => false, 'data' => $data]);
    }
    public function actPegawai($act)
    {
        try {
            // $this->SecurityModel->Aksessbility_VCRUD('bank', 'pricelist', 'create', true);
            $data = $this->input->post();
            if ($act == 'add')
                $id = $this->CarWashModel->addPegawai($data);
            else if ($act == 'edit')
                $id = $this->CarWashModel->editPegawai($data);
            else if ($act == 'del') {
                $this->CarWashModel->delPegawai($data);
                echo json_encode(array('error' => false, 'data' => []));
                return;
            }
            $data = $this->CarWashModel->getAllPegawai(array('id_ref' => $id))[$id];

            echo json_encode(array('error' => false, 'data' => $data));
            // $this->load->view('accounting/accounts_modal');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function pricelist2()
    {
        try {
            $crud = $this->SecurityModel->MultiplerolesGuard('Master Carwash');
            // $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Assets'));

            $data['title'] = 'Price List 2';
            $data['main_view'] = 'mastercarwash/pricelist2';
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function actPriceList2($act)
    {
        try {
            // $this->SecurityModel->Aksessbility_VCRUD('bank', 'pricelist', 'create', true);
            $data = $this->input->post();
            if ($act == 'add')
                $id = $this->CarWashModel->addPriceList2($data);
            else if ($act == 'edit')
                $id = $this->CarWashModel->editPriceList2($data);
            else if ($act == 'del') {
                $this->CarWashModel->delPriceList2($data);
                echo json_encode(array('error' => false, 'data' => []));
                return;
            }
            $data = $this->CarWashModel->getAllPriceList2(array('id_ref' => $id))[$id];

            echo json_encode(array('error' => false, 'data' => $data));
            // $this->load->view('accounting/accounts_modal');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function pricelist()
    {
        try {
            $crud = $this->SecurityModel->MultiplerolesGuard('Master Carwash');
            // $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true, 'nature' => 'Assets'));

            $data['title'] = 'Price List';
            $data['main_view'] = 'mastercarwash/pricelist';
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function actPriceList($act)
    {
        try {
            // $this->SecurityModel->Aksessbility_VCRUD('bank', 'pricelist', 'create', true);
            $data = $this->input->post();
            if ($act == 'add')
                $id = $this->CarWashModel->addPriceList($data);
            else if ($act == 'edit')
                $id = $this->CarWashModel->editPriceList($data);
            else if ($act == 'del') {
                $this->CarWashModel->delPriceList($data);
                echo json_encode(array('error' => false, 'data' => []));
                return;
            }
            $data = $this->CarWashModel->getAllPriceList(array('id_ref' => $id))[$id];

            echo json_encode(array('error' => false, 'data' => $data));
            // $this->load->view('accounting/accounts_modal');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
