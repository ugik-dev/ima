<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
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
        $data['main_view'] = 'user/notification';
        $this->load->view('main/index2.php', $data);
    }
}
