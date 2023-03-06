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

    public function index()
    {
        try {
            $this->SecurityModel->MultiplerolesStatus(array('Aplikasi', 'CarWash'), False);

            $master = $this->SecurityModel->MultiplerolesStatus('Master Carwash');
            // echo json_encode($master);
            // die();
            // $privileges = $this->CarWashModel->getAllUser();
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
}
