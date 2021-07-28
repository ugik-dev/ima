<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function inv($token, $id)
    {
        $this->load->model('ApiModel');
        $data['dataContent'] = $this->ApiModel->getInvoice($token, $id);
        // echo json_encode($data['dataContent']);
        // die();
        $data['title'] = 'PT Indometal Asia';

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
