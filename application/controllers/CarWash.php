<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class CarWash extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'CarWashModel', 'General_model'));
        $this->SecurityModel->MultiplerolesGuard('Car Wash', true);
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    public function getAll()
    {
        $filter = $this->input->get();
        // $filter['id_user'] = $this->session->userdata('id_user');
        $data = $this->CarWashModel->getAll($filter);
        echo json_encode(['error' => false, 'data' => $data]);
    }

    public function getAllRekap()
    {
        $filter = $this->input->get();
        // $filter['id_user'] = $this->session->userdata('id_user');
        $data = $this->CarWashModel->getAllRekap($filter);
        echo json_encode(['error' => false, 'data' => $data]);
    }

    public function getPetugas()
    {
        $filter = $this->input->get();
        // $filter['id_user'] = $this->session->userdata('id_user');
        $data = $this->CarWashModel->getPetugas($filter);
        echo json_encode(['error' => false, 'data' => $data]);
    }
    public function edit()
    {
        $data = $this->input->post();
        $data['id_petugas'] = $this->session->userdata('user_id')['id'];
        $id =  $this->CarWashModel->edit($data);
        $dataLog = [
            'id_carwash' => $id,
            'nama' => $this->session->userdata('user_id')['name'],
            // 'keterangan' => "Order dijadwalkan jam " . $data['est_time']
        ];
        if ($data['status'] == 2)
            $dataLog['keterangan'] = "Order dijadwalkan jam " . $data['est_time'];
        else if ($data['status'] == 3)
            $dataLog['keterangan'] = "Order sedang dicuci ";
        else if ($data['status'] == 4)
            $dataLog['keterangan'] = "Order selesai dicuci";
        else if ($data['status'] == 5)
            $dataLog['keterangan'] = "Order dibatalkan / ditolak ";

        $this->CarWashModel->add_log($dataLog);

        $data = $this->CarWashModel->getAll(['id_carwash' => $id])[$id];
        echo json_encode(['error' => false, 'data' => $data]);
    }
    public function pembayaran_process()
    {
        $data = $this->input->post();

        $data['pembayaran_id_petugas'] = $this->session->userdata('user_id')['id'];
        $data['status_pembayaran'] = 5;
        $data['pembayaran_dibayarkan'] =   preg_replace('/[^0-9\-]/', '', $data['pembayaran_dibayarkan']);
        $data['pembayaran_tagihan'] =   preg_replace('/[^0-9\-]/', '', $data['pembayaran_tagihan']);
        $data['pembayaran_kembalian'] =   preg_replace('/[^0-9\-]/', '', $data['pembayaran_kembalian']);
        $id =  $this->CarWashModel->edit($data);

        $dataLog = [
            'id_carwash' => $id,
            'nama' => $this->session->userdata('user_id')['name'],
            'keterangan' => "Pembayaran diterima oleh " . $this->session->userdata('user_id')['name']
        ];


        $this->CarWashModel->add_log($dataLog);

        $data = $this->CarWashModel->getAll(['id_carwash' => $id])[$id];
        echo json_encode(['error' => false, 'data' => $data]);
    }


    public function lihat_rekap($id)
    {
        try {
            // $data = $this->input->post();
            $dataContent = $this->CarWashModel->getAllRekap(['id_carwash_close' => $id]);

            if (empty($dataContent)) {
                throw new UserException("Data untuk diposting tidak ditemukan", USER_NOT_FOUND_CODE);
            } else {
                $dataContent = $dataContent[$id];
            }

            $this->load->model('Statement_model');

            $data['jurnal'] = $this->Statement_model->detail_fetch_transasctions(['id' => $dataContent['jurnal_id'], 'draft' => false]);
            // echo json_encode($data);
            // die();
            $data['accounting_role'] = $this->SecurityModel->MultiplerolesStatus('Akuntansi');


            // die();
            $data['transaction'] = $this->CarWashModel->getAllTransaksi(['book' => $dataContent['id_carwash_close']]);
            $data['main_view'] = 'aplikasi/carwash_rekap';
            $data['dataContent'] = $dataContent;
            // $data['privileges'] = $privileges;
            $this->load->view('main/index2.php', $data);

            // echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function close_process()
    {
        try {
            $data = $this->input->post();
            $data_carwash = $this->CarWashModel->getAllTransaksi(['close_book' => true]);

            if (empty($data_carwash)) {
                throw new UserException("Data untuk diposting tidak ditemukan", USER_NOT_FOUND_CODE);
            }


            $total = 0;
            $data['id_carwash'] = [];
            foreach ($data_carwash as $key => $dc) {
                $total = $total + $dc['pembayaran_tagihan'];
                $data['id_carwash'][] = $dc['id_carwash'];
            }

            $data['generalentry'] = array(
                'date' => date('Y-m-d'),
                'naration' =>  'Tutup buku Car Wash per tanggal ' . date('Y-m-d'),
                'no_jurnal' => $this->General_model->gen_number(date('Y-m-d'), 'APP'),
                // 'customer_id' => $data['customer_id'],
                'generated_source' => 'Carwash App'
            );

            $data['sub_entry'][0] = array(
                'accounthead' =>  5,
                'type' => 0,
                'amount' => $total,
                'sub_keterangan' => "Pendapatan IMA CAR WASH Per Tanggal " . date('Y-m-d'),
            );
            // $
            $ppn = $total * 0.0998;
            // $total = $total * 0.0998;
            $data['sub_entry'][1] = array(
                'accounthead' =>  1579,
                'type' => 1,
                'amount' => $total - $ppn,
                'sub_keterangan' => "Pendapatan IMA CAR WASH Per Tanggal " . date('Y-m-d'),
            );
            $data['sub_entry'][2] = array(
                'accounthead' =>  183,
                'type' => 1,
                'amount' => $ppn,
                'sub_keterangan' => "PPN Pendapatan IMA CAR WASH Per Tanggal " . date('Y-m-d'),
            );

            $id =  $this->CarWashModel->close_book($data);
            // 5
            //     $i++;
            // }

            // echo $total;
            // die();
            // $data['pembayaran_id_petugas'] = $this->session->userdata('user_id')['id'];

            // $dataLog = [
            //     'id_carwash' => $id,
            //     'nama' => $this->session->userdata('user_id')['name'],
            //     'keterangan' => "Pembayaran diterima oleh " . $this->session->userdata('user_id')['name']
            // ];


            // $this->CarWashModel->add_log($dataLog);

            // $data = $this->CarWashModel->getAll(['id_carwash' => $id])[$id];
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function index()
    {
        try {
            // $this->SecurityModel->MultiplerolesGuard('Car Wash', true);
            $master = $this->SecurityModel->MultiplerolesStatus('Master Carwash');
            $data['title'] = 'Carwash Apps';
            $data['table_name'] = 'Carwash Apps';
            $data['master'] = $master;
            $data['main_view'] = 'aplikasi/carwash';
            // $data['vcrud'] = $crud;
            // $data['privileges'] = $privileges;
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function close()
    {
        try {
            // $this->SecurityModel->MultiplerolesGuard('Car Wash', true);
            $master = $this->SecurityModel->MultiplerolesStatus('Master Carwash');
            $data['main_view'] = 'aplikasi/carwash_close';
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
