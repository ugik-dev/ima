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

    public function edit()
    {
        $data = $this->input->post();

        $data['id_petugas'] = $this->session->userdata('user_id')['id'];
        $id =  $this->CarWashModel->edit($data);
        $data = $this->CarWashModel->getAll(['id_carwash' => $id])[$id];
        echo json_encode(['error' => false, 'data' => $data]);
    }

    public function index()
    {
        try {
            $this->SecurityModel->MultiplerolesStatus(array('Aplikasi', 'CarWash'), False);

            // $crud = $this->SecurityModel->Aksessbility_VCRUD('aplikasi', 'carwash', 'view');
            // $privileges = $this->CarWashModel->getAllUser();
            $data['title'] = 'Carwash Apps';
            $data['table_name'] = 'Carwash Apps';
            $data['main_view'] = 'aplikasi/carwash';
            // $data['vcrud'] = $crud;
            // $data['privileges'] = $privileges;
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
