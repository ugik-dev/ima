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
        $data['margin'] = 0.65 * $data['pembayaran_tagihan'];
        $data['fee'] = 0.35 * $data['pembayaran_tagihan'];
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

            // echo json_encode($data_carwash);
            // die();


            $total = 0;
            $margin = 0;
            $pegawai = [];
            $data['id_carwash'] = [];
            foreach ($data_carwash as $key => $dc) {
                $total = $total + $dc['margin'] + $dc['fee'];
                $margin = $margin + $dc['margin'];
                if (empty($pegawai[$dc['id_petugas_cuci']])) {
                    $pegawai[$dc['id_petugas_cuci']]['nama'] = $dc['nama_petugas_cuti'];
                    $pegawai[$dc['id_petugas_cuci']]['fee'] = $dc['fee'];
                } else {
                    $pegawai[$dc['id_petugas_cuci']]['fee'] = $pegawai[$dc['id_petugas_cuci']]['fee'] + $dc['fee'];
                }
                $data['id_carwash'][] = $dc['id_carwash'];
            }
            // echo json_encode([$pegawai, $margin, $total]);
            // die();

            $data['generalentry'] = array(
                'date' => date('Y-m-d'),
                'naration' =>  'Tutup buku Car Wash per ' . date('Y-m-d'),
                'no_jurnal' => $this->General_model->gen_number(date('Y-m-d'), 'APP'),
                // 'customer_id' => $data['customer_id'],
                'generated_source' => 'Carwash App'
            );

            $data['sub_entry'][0] = array(
                'accounthead' =>  8,
                'type' => 0,
                'amount' => $margin,
                'sub_keterangan' => "Pendapatan IMA CAR WASH Per " . date('d My'),
            );

            $i = 1;
            foreach ($pegawai as $p) {
                $data['sub_entry'][$i] = array(
                    'accounthead' =>  1585,
                    'type' => 0,
                    'amount' => $p['fee'],
                    'sub_keterangan' => "By Gaji TK Lepas " . date('d My') . ' ' . $p['nama'],
                );
                $i++;
            }
            // $
            $ppn = $total * 0.10;
            // $total = $total * 0.0998;
            $data['sub_entry'][$i] = array(
                'accounthead' =>  1579,
                'type' => 1,
                'amount' => $total - $ppn,
                'sub_keterangan' => "Pendapatan IMA CAR WASH Per " . date('d My'),
            );
            $data['sub_entry'][$i + 1] = array(
                'accounthead' =>  183,
                'type' => 1,
                'amount' => $ppn,
                'sub_keterangan' => "PPN Pendapatan IMA CAR WASH Per " . date('d My'),
            );

            $id =  $this->CarWashModel->close_book($data);
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
