<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DirectionController extends CI_Controller
{
    function index()
    {
    }

    function approv_direktur()
    {
        $this->SecurityModel->roleOnlyGuard('direktur');
        $id = html_escape($this->input->post('id'));
        $keputusan   = html_escape($this->input->post('keputusan'));
        $catatan   = html_escape($this->input->post('catatan'));


        $this->load->model('Transaction_model');
        $res = $this->Transaction_model->check_lock($id);
        if ($res == 'Y') {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Sudah di Kunci! ',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
            redirect('statements/show/' . $id);
            return;
        }

        $res = $this->Transaction_model->check_direktur(array('id' => $id, 'acc_1' => $this->session->userdata('user_id')['id']));
        // var_dump($res);
        if ($res['acc_1'] != $this->session->userdata('user_id')['id']) {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Bukan hak anda! ',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
            redirect('statements/show/' . $id);
            return;
        }
        $res = $this->Transaction_model->approv_process(array('id' => $id, 'keputusan' => $keputusan, 'catatan' => $catatan, 'acc_1' => $this->session->userdata('user_id')['id']));
        $array_msg = array(
            'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i>  Success Approved Data! ',
            'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
        redirect('statements/show/' . $id);








        // var_dump($data);
    }


    function popup($page_name = '', $param = '')
    {
        $this->load->model('Crud_model');
        if ($page_name  == 'direktur') {
            // echo $page_name;
            // die();
            //USED TO REDIRECT LINK
            $data['link'] = 'DirectionController/approv_direktur';
            $data['param'] = $param;
            // $data['single_customer'] = $this->Crud_model->fetch_record_by_id('mp_payee', $param);
            //model name available in admin models folder
            $this->load->view('admin_models/action_model/approv_direktur.php', $data);
        } else if ($page_name  == 'add_cars_model') {
            //USED TO REDIRECT LINK
            $data['link'] = 'patners/add_cars';
            $this->load->model('Statement_model');
            $data['cars_record'] = $this->Statement_model->patners_cars_list();
            //model name available in admin models folder
            $this->load->view('admin_models/add_models/add_cars_model.php', $data);
        } else if ($page_name  == 'edit_cars_model') {
            //USED TO REDIRECT LINK
            $data['link'] = 'patners/edit_cars';
            $this->load->model('Statement_model');
            $data['cars_record'] = $this->Statement_model->patners_cars_list();
            $data['single_cars'] = $this->Crud_model->fetch_cars_record('patners', NULL, $param)[0];
            // echo json_encode($data);
            // die();
            //model name available in admin models folder
            $this->load->view('admin_models/edit_models/edit_cars_model.php', $data);
        } else if ($page_name  == 'add_patner_model') {
            //USED TO REDIRECT LINK
            $data['link'] = 'patners/add_patner';
            //model name available in admin models folder
            $this->load->view('admin_models/add_models/add_patner_model.php', $data);
        } else if ($page_name  == 'add_csv_model') {
            $data['path'] = 'customers/upload_csv';
            //model name available in admin models folder
            $this->load->view('admin_models/add_models/add_csv_model.php', $data);
        } else if ($page_name  == 'add_customer_payment_model') {
            //DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
            $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');

            $data['customer_list'] = $this->Crud_model->fetch_payee_record('customer', NULL);
            $this->load->view('admin_models/add_models/add_customer_payment_model.php', $data);
        } else if ($page_name  == 'edit_customer_payment_model') {
            //DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
            $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');

            $data['customer_list'] = $this->Crud_model->fetch_payee_record('customer', NULL);

            $data['customer_payments'] = $this->Crud_model->fetch_record_by_id('mp_customer_payments', $param);
            $this->load->view('admin_models/edit_models/edit_customer_payment_model.php', $data);
        }
    }
}
