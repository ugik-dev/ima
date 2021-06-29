<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administration extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'AdministrationModel'));
        $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    // Statements
    //USED TO GENERATE GENERAL JOURNAL 
    public function index()
    {

        $this->SecurityModel->MultiplerolesGuard('Administration');

        // DEFINES PAGE TITLE
        $data['title'] = 'Administration';

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'administration/dokumen';

        $this->load->model('Statement_model');
        // $data['transaction_records'] = $this->Statement_model->fetch_transasctions($filter);
        // echo json_encode($data['transaction_records']);
        // die();

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    public function getJenisDokumen()
    {
        try {

            $filter = $this->input->get();
            $data = $this->AdministrationModel->getJenisDokumen($filter);
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getDokumen()
    {
        try {

            $filter = $this->input->get();
            $data = $this->AdministrationModel->getDokumen($filter);
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function document($id)
    {
        try {

            $dataContent = $this->AdministrationModel->getDokumen(array('id_dokumen' => $id))[$id];

            $data['title'] = 'Administration';

            // DEFINES WHICH PAGE TO RENDER
            $data['main_view'] = 'administration/detail_dokumen';
            $data['dataContent'] = $dataContent;
            $this->load->model('Statement_model');
            // $data['transaction_records'] = $this->Statement_model->fetch_transasctions($filter);
            // echo json_encode($data['transaction_records']);
            // die();

            // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
            $this->load->view('main/index.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function jenis_dokumen()
    {

        $data['title'] = 'Draft Jurnal Umum';
        $data['main_view'] = 'administration/jenis_dokumen';
        if (empty($no_jurnal)) {
            $no_jurnal = '';
        }
        // $filter['from'] = $from;
        // $filter['to'] = $to;
        // $filter['no_jurnal'] = $no_jurnal;
        $filter['draft'] = true;
        $this->load->model('Statement_model');
        $data['transaction_records'] = $this->Statement_model->fetch_transasctions($filter);
        // echo json_encode($data['transaction_records']);
        // die();
        // $data['from'] = $from;
        // $data['to'] = $to;
        $data['no_jurnal'] = $no_jurnal;

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    public function show($id, $draft = false)
    {

        // DEFINES PAGE TITLE

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'journal_voucher_detail';

        $from      = html_escape($this->input->post('from'));
        $to      = html_escape($this->input->post('to'));
        $data['id'] = $id;
        // $filter['draft'] = $draft;
        $data['draft'] = $draft;
        $this->load->model('Statement_model');
        $data['transaction'] = $this->Statement_model->detail_fetch_transasctions($data);
        $data['acc'] = $this->Statement_model->get_acc($id, true, $draft);
        // echo json_encode($data);
        // die();
        $new_arr = [];
        if (empty($data['transaction'])) {
            $data['main_view'] = 'error-5';
            $data['message'] = 'Sepertinya data yang anda cari tidak ditemukan atau sudah di hapus.';
        } else {
            $arr = explode(']', $data['transaction']['parent']->arr_cars);
            foreach ($arr as $dat) {
                if (!empty($dat)) {
                    $tmp = '';
                    $tmp = $this->Statement_model->find_cars(str_replace('[', '', $dat));
                    if (!empty($tmp)) array_push($new_arr, $tmp);
                }
            }
            $data['transaction']['new_arr'] = $new_arr;
            $data['title'] = $data['transaction']['parent']->no_jurnal;
        }
        // echo json_encode($data);
        // var_dump($data['transaction']['sub']);
        // die();
        $this->load->view('main/index.php', $data);
    }

    public function addJenisDokumen()
    {
        try {
            $this->SecurityModel->MultiplerolesGuard('Administration');

            $input = $this->input->post();
            $data['id_jenis_dokumen'] = $this->AdministrationModel->addJenisDokumen($input);
            $data['nama_jenis_dokumen'] = $input['nama_jenis_dokumen'];
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function editJenisDokumen()
    {
        try {
            $this->SecurityModel->MultiplerolesGuard('Administration');

            $input = $this->input->post();
            $data['id_jenis_dokumen'] = $this->AdministrationModel->editJenisDokumen($input);
            $data['nama_jenis_dokumen'] = $input['nama_jenis_dokumen'];
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function deleteJenisDokumen()
    {
        try {
            $this->SecurityModel->MultiplerolesGuard('Administration');

            $input = $this->input->post();
            $data['id_jenis_dokumen'] = $this->AdministrationModel->deleteJenisDokumen($input);
            // $data['nama_jenis_dokumen'] = $input['nama_jenis_dokumen'];
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function addDokumen()
    {
        try {
            $this->SecurityModel->MultiplerolesGuard('Administration');

            $data = $this->input->post();
            $data['file_dokumen'] = FileIO::genericUpload('file_dokumen', array('png', 'jpeg', 'jpg', 'pdf', 'doc', 'docx', 'xls'), NULL, $data);
            $data['id_dokumen'] = $this->AdministrationModel->addDokumen($data);
            $newData = $this->AdministrationModel->getDokumen(array('id_dokumen' => $data['id_dokumen']))[$data['id_dokumen']];
            // $data['nama_dokumen'] = $input['nama_jenis_dokumen'];
            echo json_encode(array("data" => $newData));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function editDokumen()
    {
        try {
            $this->SecurityModel->MultiplerolesGuard('Administration');

            $data = $this->input->post();
            $data['file_dokumen'] = FileIO::genericUpload('file_dokumen', array('png', 'jpeg', 'jpg', 'pdf', 'doc', 'docx', 'xls'), NULL, $data);
            // $data['id_dokumen'] = $this->AdministrationModel->addDokumen($data);
            $oldData = $this->AdministrationModel->getDokumen(array('id_dokumen' => $data['id_dokumen']))[$data['id_dokumen']];
            $data['id_dokumen'] = $this->AdministrationModel->editJenisDokumen($data);
            $newData = $this->AdministrationModel->getDokumen(array('id_dokumen' => $data['id_dokumen']))[$data['id_dokumen']];
            if (!empty($data['file_dokumen'])) {
                unlink('./uploads/file_dokumen/' . $oldData['file_dokumen']);
            }
            // $data['nama_dokumen'] = $input['nama_jenis_dokumen'];
            echo json_encode(array("data" => $newData));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function deleteDokumen()
    {
        try {
            $this->SecurityModel->MultiplerolesGuard('Administration');

            $input = $this->input->post();
            $data['id_dokumen'] = $this->AdministrationModel->deleteDokumen($input);
            // $data['nama_jenis_dokumen'] = $input['nama_jenis_dokumen'];
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
