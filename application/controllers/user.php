<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class user extends CI_Controller
{
    // Accounts
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel'));
        $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    public function getNotification()
    {
        try {

            // $filter = $this->input->get();
            // $data = $this->AdministrationModel->getJenisDokumen($filter);
            $data = $this->UserModel->getNotification();
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function notification()
    {

        // $this->load->model('Accounts_model');

        // $data['banks'] = $this->Accounts_model->getAllBank();
        // // DEFINES PAGE TITLE
        // $data['title'] = 'Entry Pembayaran';
        // $data['data_return'] = $data_return;
        // $this->load->model('Statement_model');
        // $data['accounts_records'] = $this->Statement_model->chart_list();
        // $data['patner_record'] = $this->Statement_model->patners_cars_list();

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'user/notification';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index2.php', $data);
    }
}
