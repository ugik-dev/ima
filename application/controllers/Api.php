<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'ApiModel'));
        $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }
    public function index($key = '', $act = '', $parm = '')
    {
        // echo '2';
        try {
            if (empty($key)) {
                throw new UserException('Keys yang anda masukkan tidak ditemukan', UNAUTHORIZED_CODE);
            } else {
            }
            $data = $this->SecurityModel->apiKeyGuard($key);
            if (!empty($act)) {
                if ($act == 'faktur') {
                    $data = $this->ApiModel->getFaktur($parm);
                }
                if ($act == 'push') {
                    $data = $this->input->post();
                    if (!empty($data['no_invoice']) && !empty($data['no_faktur'])) {
                        $data = $this->ApiModel->post_faktur($data);
                        $data = 'post_success';
                    }
                }
            }

            echo json_encode(array('error' => false, 'response' => $data));
            // $this->SecurityModel->apiKeyGuard();
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function inv($token, $id)
    {
        $this->load->model('ApiModel');
        $data['dataContent'] = $this->ApiModel->getInvoice($token, $id);
        // echo json_encode($data['dataContent']);
        // die();
        $data['title'] = 'API - PT Indometal Asia';

        // DEFINES PAGE TITLE
        $data['site_title'] = 'Invoice';

        // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
        // $data['page_add_button_name'] = 'Tambah Login';

        // DEFINES WHICH PAGE TO RENDER
        // $this->load->view('loginnew', $data);
        if (!empty($data['dataContent'])) {
            $this->load->view('apiinfo', $data);
        } else {
            $data['message'] = 'Data Not FOUND !!';
            $this->load->view('errors/error-1', $data['message']);
        }
    }
}
