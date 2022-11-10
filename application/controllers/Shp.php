<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Shp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('General_model', 'Statement_model', 'ShpModel', 'General_model'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    public function getAll()
    {
        try {
            $filter = $this->input->get();
            echo json_encode(array('error' => false, 'data' => $this->ShpModel->getAll($filter)));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function index()
    {
        // $data['patner_record'] = $this->Statement_model->patners_cars_list();

        $data['main_view'] = 'shp/list';
        $data['form_url'] = 'add_process';
        $this->load->view('main/index.php', $data);
    }

    public function add()
    {
        $data['mitra'] = $this->General_model->searchMitra();
        $data['ref_rab'] = $this->General_model->RABTerbaru();
        // echo json_encode($data['ref_rab']);
        // die();
        $data['ref_zona'] = $this->General_model->getZona();

        $data['main_view'] = 'shp/form';
        $data['form_url'] = 'add_process';
        $this->load->view('main/index.php', $data);
    }

    function add_reference_process()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();

            $data['id_agent'] = $this->session->userdata('user_id')['id'];
            $id =   $this->ShpModel->add_reference($data);
            echo json_encode(['error' => false, 'url' => 'shp/rab_show/' . $id]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    function edit_reference_process()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();

            $data['id_agent'] = $this->session->userdata('user_id')['id'];
            $id =   $this->ShpModel->edit_reference($data);
            echo json_encode(['error' => false, 'url' => 'shp/rab_show/' . $id]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    function add_process()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();

            $data['am_pph_21'] = substr(preg_replace("/[^0-9]/", "", $data['am_pph_21']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_pph_21']), -2);
            $data['am_oh'] = substr(preg_replace("/[^0-9]/", "", $data['am_oh']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_oh']), -2);
            $data['am_profit'] = substr(preg_replace("/[^0-9]/", "", $data['am_profit']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_profit']), -2);
            $data['tx_sebelumnya'] = substr(preg_replace("/[^0-9]/", "", $data['tx_sebelumnya']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['tx_sebelumnya']), -2);
            $data['ts_sub'] = substr(preg_replace("/[^0-9]/", "", $data['ts_sub']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['ts_sub']), -2);
            $data['total_final'] = substr(preg_replace("/[^0-9]/", "", $data['total_final']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['total_final']), -2);
            $data['sub_total'] = substr(preg_replace("/[^0-9]/", "", $data['sub_total']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['sub_total']), -2);
            if (!empty($data['pembulatan'])) $data['pembulatan'] = substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), -2);

            if (empty($data['date'])) {
                $data['date'] = date('Y-m-d');
            }

            $data['id_agent'] = $this->session->userdata('user_id')['id'];
            $id =   $this->ShpModel->add($data);
            echo json_encode(['error' => false, 'id_shp' => $id]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function edit_process()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();

            $data['am_pph_21'] = substr(preg_replace("/[^0-9]/", "", $data['am_pph_21']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_pph_21']), -2);
            $data['am_oh'] = substr(preg_replace("/[^0-9]/", "", $data['am_oh']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_oh']), -2);
            $data['am_profit'] = substr(preg_replace("/[^0-9]/", "", $data['am_profit']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_profit']), -2);
            $data['tx_sebelumnya'] = substr(preg_replace("/[^0-9]/", "", $data['tx_sebelumnya']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['tx_sebelumnya']), -2);
            $data['ts_sub'] = substr(preg_replace("/[^0-9]/", "", $data['ts_sub']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['ts_sub']), -2);
            $data['total_final'] = substr(preg_replace("/[^0-9]/", "", $data['total_final']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['total_final']), -2);
            $data['sub_total'] = substr(preg_replace("/[^0-9]/", "", $data['sub_total']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['sub_total']), -2);
            if (!empty($data['pembulatan'])) $data['pembulatan'] = substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), -2);

            if (empty($data['date'])) {
                $data['date'] = date('Y-m-d');
            }

            $data['id_agent'] = $this->session->userdata('user_id')['id'];
            $id = $this->ShpModel->edit($data);
            echo json_encode(['error' => false, 'id_shp' => $id]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function show($id)
    {

        $data['title'] = 'Pengangkutan Sisa Hasil Pengolahan (SHP)';

        $collection = array();

        // DEFINES TO LOAD THE MODEL
        // $this->load->model('InvoiceModel');
        if ($id != NULL) {
            $result = $this->ShpModel->getAll(array('id_shp' =>  $id))[$id];

            if (empty($result)) {
                $data['main_view'] = 'error-5';
                $data['message'] = 'Sepertinya data yang anda cari tidak ditemukan atau sudah di hapus.';
            } else {
                $data['dataContent'] = $result;
                $data['riwayat'] = $this->General_model->searchPembayaran(['id_custmer' => $result['id_mitra'], 'date_penerimaan' => $result['date_penerimaan']]);
              $this->load->model('Invoice_model');
                $data['invoice'] = $this->Invoice_model->getAllInvoice(['id_shp' => $result['id_shp']]);
                $data['main_view'] = 'shp/detail';
            }
            // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
            $this->load->view('main/index.php', $data);
            return;
        } else {
            echo 'NOT FOUND';
            return;
        }
    }

    public function edit($id)
    {

        $data['title'] = 'Edit SHP';
        $collection = array();
        if ($id != NULL) {
            $result = $this->ShpModel->getAll(array('id_shp' =>  $id))[$id];
            // echo json_encode($result);
            // die();
            if (empty($result)) {
                $data['main_view'] = 'error-5';
                $data['message'] = 'Sepertinya data yang anda cari tidak ditemukan atau sudah di hapus.';
            } else {
                $data['data_return'] = $result;
                $data['ref_rab'] = $this->General_model->RABTerbaru();

                $data['riwayat'] = $this->General_model->searchPembayaran(['id_custmer' => $result['id_mitra'], 'date_penerimaan' => $result['date_penerimaan']]);
                $data['mitra'] = $this->General_model->searchMitra();
                $data['ref_zona'] = $this->General_model->getZona();

                $data['main_view'] = 'shp/form';
                $data['form_url'] = 'edit_process';
            }
            // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
            $this->load->view('main/index.php', $data);
            return;
        } else {
            echo 'NOT FOUND';
            return;
        }
    }
    public function rab()
    {
        $data['rab'] = $this->General_model->searchRab();
        // $data['ref_zona'] = $this->General_model->getZona();

        $data['main_view'] = 'shp/rab';
        // $data['form_url'] = 'add_process';
        $this->load->view('main/index.php', $data);
    }
    public function add_rab()
    {

        $data['title'] = 'Tambah RAB';
        $data['main_view'] = 'shp/form_referensi';
        $data['form_url'] = 'add_reference_process';
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    public function rab_show($id)
    {

        $data['title'] = 'RAB';
        $data['data_return'] = $this->General_model->getRabDetail($id)[$id];
        // echo json_encode($data['data_return']);
        // die();
        $data['main_view'] = 'shp/form_referensi';
        $data['form_url'] = 'edit_reference_process';
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    function head_invoice($pdf, $dataContent)
    {
        $pdf->Image(base_url() . "assets/img/ima.jpg", 12, 6, 80, 13);
        $pdf->SetXY(20, 25);
    }

    public function pdf($id, $format = 1)
    {

        if ($id != NULL) {

            $dataContent = $this->ShpModel->getAll(array('id' =>  $id))[$id];
            // echo json_encode($dataContent);
            // die();
        } else {
            echo 'ERROR';
            return;
        }
        // $data['transaction'] = $this->Invoice_model->getAllInvoiceDetail(array('id' => $id))[$id];
        require('assets/fpdf/mc_table.php');
        $pdf = new PDF_MC_Table('p', 'mm', 'A4');
        $pdf->SetMargins(10, 4, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 13);
        // 
        $this->head_invoice($pdf, $dataContent);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(170, 7, 'KOMPENSASI BORONGAN PEKERJAAN PENGANGKUTAN SISA HASIL PENGOLAHAN', 0, 1, 'C');
        // $pdf->Cell(10, 7, '', 0, 0, 'C');
        $pdf->Cell(190, 7, '(SHP)', 0, 1, 'C');
        // $pdf->SetTextColor(107, 104, 104);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(5, 2, '', 0, 1, 'C');

        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'Zona / Wilayah Operasi', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, $dataContent['nama_zona'] . ' / ' . $dataContent['nama_wilayah'], 0, 1);

        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'Nama Mitra', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, $dataContent['customer_name'], 0, 1);

        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'NIK', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, $dataContent['ktp'], 0, 1);


        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'NPWP', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, $dataContent['npwp'], 0, 1);

        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'Lokasi', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, $dataContent['lokasi'], 0, 1);

        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'Kirim Tanggal', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, tanggal_indonesia($dataContent['date_penerimaan']), 0, 1);
        $pdf->Cell(5, 2, '', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(190, 7, 'Parameter Utama Penilaian Kompensasi SHP Biji Timah Kering (Dry Ore)', 0, 1, 'C');
        $pdf->Cell(3, 2, '', 0, 1, 'C');

        // $pdf->Cell(5, 6, '', 0, 0, 'C');
        // $pdf->MultiCell(40, 6, $dataContent['cus_address'], 0, 1);
        // $pdf->Cell(5, 6, '', 0, 1);
        $total_berat = 0;
        $total_harga = 0;
        foreach ($dataContent['child'] as $child) {
            $total_berat = $total_berat + $child['berat'];
            $total_harga = $total_harga + $child['amount'];
        }

        // $pdf->Cell(3, 2, '', 0, 0, 'C');
        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->Cell(45, 6, 'Berat Kering (Kg)', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0, 'C');
        $pdf->MultiCell(120, 6, $total_berat, 0, 1);
        $pdf->Cell(5, 7, '', 0, 1, 'C');


        // $pdf->SetTextColor(107, 104, 104);
        $cur_x = $pdf->GetX();
        $cur_y = $pdf->GetY();

        // style ori
        // $pdf->Cell(30, 7, '', 0, 0, 'C');
        // $pdf->MultiCell(40, 7, "Real SHP \n (Kg Ore)", 1, 'C');
        // $pdf->SetXY($cur_x + 70, $cur_y);
        // $pdf->MultiCell(20, 7, "Kadar\nSn", 1, 'C');
        // $pdf->SetXY($cur_x + 90, $cur_y);
        // $pdf->MultiCell(45, 7, "Harga \nRp/Kg Ore", 1, 'C');
        // $pdf->SetXY($cur_x + 135, $cur_y);
        // $pdf->MultiCell(50, 7, "Harga \nRp/Kg Ore", 1, 'C');


        $pdf->Cell(30, 7, '', 0, 0, 'C');
        $pdf->MultiCell(30, 7, "Kode Biji Timah", 1, 'C');
        $pdf->SetXY($cur_x + 60, $cur_y);
        $pdf->MultiCell(20, 7, "Real SHP (Kg Ore)", 1, 'C');
        $pdf->SetXY($cur_x + 80, $cur_y);
        $pdf->MultiCell(20, 7, "Kadar\nSn", 1, 'C');
        $pdf->SetXY($cur_x + 100, $cur_y);
        $pdf->MultiCell(20, 14, "Terak", 1, 'C');
        $pdf->SetXY($cur_x + 120, $cur_y);
        $pdf->MultiCell(32, 7, "Harga \nRp/Kg Ore", 1, 'C');
        $pdf->SetXY($cur_x + 152, $cur_y);
        $pdf->MultiCell(33, 7, "Harga \nRp/Kg Ore", 1, 'C');

        // $pdf->SetTextColor(20, 20, 20);
        // $pdf->MultiCell(40, 6,  $dataContent['no_invoice'], 0, 1);
        // $pdf->Cell(5, 6, '', 0, 1);

        // $pdf->SetTextColor(107, 104, 104);
        // $pdf->Cell(40, 6, 'TANGGAL', 0, 1);
        // $pdf->SetTextColor(20, 20, 20);
        // $pdf->Cell(5, 6, '', 0, 0, 'C');
        // $pdf->MultiCell(40, 6, tanggal_indonesia($dataContent['date_penerimaan']), 0, 1);
        foreach ($dataContent['child'] as $child) {
            // $pdf->row_shp($child);
            $pdf->row_shp2($child);
        }
        $cur_x2 = $pdf->GetX() + 30;
        $cur_y2 = $pdf->GetY();

        $pdf->Rect($cur_x + 5, $cur_y, 25, $cur_y2 - $cur_y);
        $pdf->SetXY($cur_x, $cur_y + 6);
        $pdf->Cell(5, 7, '', 0, 0, 'C');
        $pdf->MultiCell(25, 5, "Terima Kering", 0, 'C');
        $pdf->SetXY($cur_x, $cur_y2);
        // $pdf->SetXY($cur_x, $cur_y + 6);
        $pdf->Cell(5, 7, '', 0, 1, 'C');
        $pdf->Cell(25, 7, '', 0, 0, 'C');
        $pdf->Cell(110, 7, 'Total Transaksi (Rp)     :   ' . number_format($dataContent['tx_sebelumnya'], 0, ',', '.'), 0, 0, 'L');
        $pdf->SetFillColor(183, 183, 188);
        $pdf->Cell(48, 7, number_format($dataContent['tx_sebelumnya'] + $dataContent['sub_total'], 0, ',', '.'), 0, 0, 'R', 1);
        $pdf->Cell(5, 10, '', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 0, 'C');
        $pdf->Cell(110, 7, 'Pengurangan  :', 0, 1, 'L');
        $pdf->Cell(5, 7, '', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(20, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, 'PPh Pasal 21  ', 0, 0, 'L');
        $pdf->Cell(23, 6, floatval($dataContent['percent_pph_21']) . '%', 0, 0, 'C');
        $pdf->Cell(6, 6, 'x', 0, 0, 'C');
        $pdf->Cell(48, 6, number_format($dataContent['sub_total'], 0, ',', '.'), 0, 0, 'R', 0);
        $pdf->Cell(48, 6, number_format($dataContent['am_pph_21'], 0, ',', '.'), 0, 1, 'R', 0);

        $pdf->Cell(20, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, 'OH  ', 0, 0, 'L');
        $pdf->Cell(23, 6, floatval($dataContent['percent_oh']) . '%', 0, 0, 'C');
        $pdf->Cell(6, 6, 'x', 0, 0, 'C');
        $pdf->Cell(48, 6, number_format($dataContent['sub_total'], 0, ',', '.'), 0, 0, 'R', 0);
        $pdf->Cell(48, 6, number_format($dataContent['am_oh'], 0, ',', '.'), 0, 1, 'R', 0);
        $pdf->Cell(20, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, 'Profit IMA  ', 0, 0, 'L');
        $pdf->Cell(23, 6, floatval($dataContent['percent_profit']) . '%', 0, 0, 'C');
        $pdf->Cell(6, 6, 'x', 0, 0, 'C');
        $pdf->Cell(48, 6, number_format($dataContent['sub_total'], 0, ',', '.'), 0, 0, 'R', 0);
        $pdf->Cell(48, 6, number_format($dataContent['am_profit'], 0, ',', '.'), 0, 1, 'R', 0);
        $pdf->SetLineWidth(0.5);
        $pdf->Line($pdf->GetX() + 130, $pdf->GetY(), $pdf->GetX() + 175, $pdf->GetY());
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(127, 6, '', 0, 0, 'C');
        $pdf->Cell(48, 6, number_format($dataContent['am_pph_21'] + $dataContent['am_oh'] + $dataContent['am_profit'], 0, ',', '.'), 0, 1, 'R', 0);
        $pdf->Cell(2, 8, '', 0, 1, 'C');
        $pdf->SetLineWidth(0.1);
        $pdf->Rect($cur_x2 - 25, $cur_y2, 180, $pdf->GetY() - $cur_y2);
        $pdf->Cell(135, 7, '         Total Jumlah Yang di Bayar', 0, 0, 'L', 0);
        $pdf->SetFillColor(244, 244, 149);
        $pdf->Cell(48, 8, number_format($dataContent['total_final'], 0, ',', '.'), 0, 0, 'R', 1);
        $pdf->Cell(2, 8, '', 0, 1, 'R', 1);
        $pdf->Rect($pdf->GetX() + 5, $pdf->GetY() - 8, 180, 8);

        // $pdf->Cell(2, 7, '', 0, 1, 'L',);
        $pdf->Cell(2, 7, '', 0, 1, 'L',);
        $pdf->Cell(5, 7, '', 0, 0, 'L',);
        $pdf->Cell(100, 7, 'Keterangan', 0, 1, 'L',);
        $sisa =  ($dataContent['total_final'] % 1000);
        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(10, 7, '', 0, 0, 'L',);
        $pdf->Cell(100, 7, 'Nilai yang dibayarkan Rp ' . number_format($dataContent['total_final'] - $sisa, 0, ',', '.'), 0, 1, 'L',);
        if ($sisa > 0) {
            $pdf->Cell(10, 7, '', 0, 0, 'L',);
            $pdf->Cell(100, 7, 'Pembualatan Rp -' . number_format($sisa, 0, ',', '.'), 0, 1, 'L',);
        }
        $pdf->Cell(90, 7, '', 0, 0, 'L',);
        $pdf->MultiCell(90, 7, $dataContent['agent_title'], 0, 'C',);

        $pdf->Cell(90, 30, '', 0, 1, 'L',);
        $pdf->Cell(90, 7, '', 0, 0, 'L',);
        $pdf->MultiCell(90, 7, $dataContent['agentname'], 0, 'C',);
        // $pdf
        $pdf->Rect(10, 4, 190, $pdf->GetY());





        // $pdf->SetTextColor(107, 104, 104);
        // $pdf->SetTextColor(20, 20, 20);
        // $pdf->Cell(5, 6, '', 0, 0, 'C');
        // $pdf->MultiCell(40, 6,  $dataContent['description'], 0, 1);
        // // $pdf->Cell(5, 6, '', 0, 1);
        // // $pdf->Cell(5, 6, '', 1, 1);

        // $cur_x = $pdf->GetX();
        // $cur_y = $pdf->GetY();
        // $f1_y = $pdf->GetY();

        // $pdf->SetXY(12, 65);
        // $pdf->Cell(50, 6, '', 0, 0, 'C');
        // $pdf->SetTextColor(107, 104, 104);
        // $pdf->SetDrawColor(107, 104, 104);
        // if ($date_item) {
        //     $pdf->Cell(48, 6, 'KETERANGAN', 0, 0, 'C');
        //     $pdf->Cell(29, 6, 'TANGGAL', 0, 0, 'C');
        //     $pdf->Cell(12, 6, 'QYT', 0, 0, 'C');
        //     $pdf->Cell(25, 6, 'HARGA', 0, 0, 'C');
        //     $pdf->Cell(25, 6, 'SUB TOTAL', 0, 0, 'C');
        //     $pdf->Cell(1, 8, '', 0, 0, 'C');
        //     $pdf->SetLineWidth(0.5);
        //     $pdf->Line(68, 72.5, 197, 72.5);

        //     $pdf->SetTextColor(20, 20, 20);
        //     $pdf->Cell(50, 6, '', 0, 1, 'C');
        //     $image1 = base_url() . "assets/img/blue_dot.jpg";
        //     if ($dataContent['item']  != NULL) {
        //         foreach ($dataContent['item'] as $item) {
        //             $pdf->SetX(60);

        //             $x = $pdf->GetX();
        //             $y = $pdf->GetY();
        //             $tmp_y = $pdf->GetY();
        //             $pdf->Cell(4, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY() + 1.6, 4), 0, 0);
        //             $pdf->MultiCell(45, 8, $item->keterangan_item, 0, 1);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 49, $y);
        //             $pdf->MultiCell(28, 8, $item->date_item, 0, 1);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 77, $y);
        //             $pdf->MultiCell(12, 8, $item->qyt . '' . $item->satuan, 0, 'C',     0);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 89, $y);
        //             $pdf->MultiCell(24, 8, number_format(floor($item->amount), '0', ',', '.'), 0, 'R', 0);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 113, $y);
        //             $pdf->MultiCell(24, 8, number_format($item->qyt * floor($item->amount), '0', ',', '.'), 0, 'R', 0);
        //             $pdf->SetXY(62, $tmp_y);
        //             $pdf->SetLineWidth(0.1);
        //             $pdf->Line(68, $tmp_y, 197, $tmp_y);
        //         }

        //         $pdf->Cell(76, 8, '', 0, 0, 'C');
        //         $pdf->Cell(15, 8, $total_qyt, 0, 0, 'C');
        //         $pdf->Cell(10, 8, '', 0, 0, 'C');
        //         $pdf->SetFont('Arial', '', 10);
        //         $pdf->Cell(35, 8, 'Rp ' . number_format($total, '0', ',', '.'), 0, 1, 'R');
        //     }
        // } else {
        //     $pdf->Cell(60, 6, 'KETERANGAN', 0, 0, 'C');
        //     $pdf->Cell(14, 6, 'QYT', 0, 0, 'C');
        //     $pdf->Cell(30, 6, 'HARGA', 0, 0, 'C');
        //     $pdf->Cell(30, 6, 'SUB TOTAL', 0, 0, 'C');
        //     $pdf->Cell(1, 8, '', 0, 0, 'C');
        //     $pdf->SetLineWidth(0.5);
        //     $pdf->Line(68, 72.5, 197, 72.5);

        //     $pdf->SetTextColor(20, 20, 20);
        //     $pdf->Cell(50, 6, '', 0, 1, 'C');
        //     $image1 = base_url() . "assets/img/blue_dot.jpg";
        //     if ($dataContent['item']  != NULL) {
        //         foreach ($dataContent['item'] as $item) {
        //             $pdf->SetX(60);
        //             $x = $pdf->GetX();
        //             $y = $pdf->GetY();

        //             $tmp_y = $pdf->GetY();
        //             $pdf->Cell(4, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY() + 1.7, 4), 0, 0);
        //             $pdf->MultiCell(56, 8, $item->keterangan_item, 0, 1);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 60, $y);
        //             $pdf->MultiCell(14, 8, $item->qyt . '' . $item->satuan, 0, 'C',     0);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 74, $y);
        //             $pdf->MultiCell(30, 8, number_format(floor($item->amount), '0', ',', '.'), 0, 'R', 0);
        //             if ($pdf->GetY() > $tmp_y)
        //                 $tmp_y = $pdf->GetY();
        //             $pdf->SetXY($x + 104, $y);
        //             $pdf->MultiCell(30, 8, number_format($item->qyt * floor($item->amount), '0', ',', '.'), 0, 'R', 0);
        //             $pdf->SetXY(62, $tmp_y);
        //             $pdf->SetLineWidth(0.1);
        //             $pdf->Line(68, $tmp_y, 197, $tmp_y);
        //         }

        //         $pdf->Cell(60, 8, '', 0, 0, 'C');
        //         $pdf->Cell(15, 8, $total_qyt, 0, 0, 'C');
        //         $pdf->Cell(25, 8, '', 0, 0, 'C');
        //         $pdf->SetFont('Arial', '', 10);
        //         $pdf->Cell(35, 8, 'Rp ' . number_format($total, '0', ',', '.'), 0, 1, 'R');
        //     }
        // }
        // if ($pdf->GetY() < $f1_y) {
        //     $pdf->Line(20, $f1_y + 5, 110, $f1_y + 5);
        //     $pdf->Line(60, 65, 60, $f1_y);
        //     $pdf->SetXY(20, $f1_y);
        // } else {
        //     $pdf->Line(20, $pdf->GetY() + 2, 110, $pdf->GetY() + 2);
        //     $pdf->Line(60, 65, 60, $pdf->GetY() - 2);
        // }
        // $cur_y =  $pdf->GetY();
        // $pdf->SetLineWidth(0.5);
        // // $pdf->Line(60, 75, 60, $cur_y);
        // $crop = 0;
        // $crop2 = 0;
        // $crop3 = 0;
        // $pdf->AliasNbPages();
        // if ($cur_y > 165) {
        //     $crop = -5;
        //     $crop2 = -2;
        //     $crop3 = -1;
        // }
        // $pdf->Cell(30, 10 + $crop, '', 0, 1, 'C');
        // $pdf->SetTextColor(40, 41, 40);
        // $pdf->SetFont('Arial', 'B', 10);
        // $cur_y =  $pdf->GetY();
        // $cur_x =  $pdf->GetX();

        // if ($dataContent['payment_metode'] != 99) {
        //     $pdf->Cell(5, 7 + $crop2, '', 0, 0, 'C');
        //     $pdf->Cell(50, 7 + $crop2, 'BANK TRANSFER', 0, 1, 'C');
        //     $pdf->Cell(5, 7 + $crop2, '', 0, 0, 'C');
        //     $pdf->Cell(15, 7, 'Bank :', 0, 0, 'L');
        //     $pdf->MultiCell(60, 7 + $crop2, $dataContent['bank_name'], 0, 'R');

        //     $pdf->Cell(5, 7, '', 0, 0, 'C');
        //     $pdf->Cell(30, 7, 'Account Name :', 0, 0, 'L');
        //     $pdf->MultiCell(45, 7 + $crop2, $dataContent['title_bank'], 0, 'R');

        //     $pdf->Cell(5, 7, '', 0, 0, 'C');
        //     $pdf->Cell(35, 7, 'Account Number :', 0, 0, 'L');
        //     $pdf->MultiCell(40, 7 + $crop2, $dataContent['bank_number'], 0, 'R');
        // }
        // $bank_xy = array($pdf->GetX(), $pdf->GetY());
        // $pdf->SetXY($cur_x + 120, $cur_y);

        // if ($dataContent['ppn_pph'] == 1) {
        //     $date_inv = new DateTime($dataContent['date']);
        //     $date_ppn11  = new DateTime('2022-04-01');
        //     if ($date_inv >= $date_ppn11) {
        //         $var_ppn = 11;
        //         $tmp1 = 11 / 100 * $total;
        //     } else {
        //         $tmp1 = 10 / 100 * $total;
        //         $var_ppn = 10;
        //     }

        //     $pdf->Cell(40, 17 + $crop, $pdf->Image(base_url() . "assets/img/bg-3.jpg", 120, $pdf->GetY(), 77, 14 + $crop2), 0, 1, 'C');
        //     $pdf->Cell(40, 17 + $crop, $pdf->Image(base_url() . "assets/img/bg-2.jpg", 120, $pdf->GetY(), 77, 14 + $crop2), 0, 1, 'C');
        //     $pdf->Cell(40, 17 + $crop, $pdf->Image(base_url() . "assets/img/bg-1.jpg", 120, $pdf->GetY(), 77, 14 + $crop2), 0, 1, 'C');
        //     $pdf->SetXY($cur_x + 100, $cur_y);
        //     $pdf->Cell(10, 17, '', 0, 0);
        //     $pdf->SetTextColor(255, 255, 255);
        //     $pdf->SetFont('Arial', 'B', 13);

        //     $pdf->Cell(30, 14 + $crop2, 'SUB TOTAL', 0, 0, 'L');
        //     $pdf->Cell(42, 14 + $crop2, 'Rp ' . number_format(floor($total), '0', ',', '.'), 0, 1, 'R');
        //     $pdf->Cell(1, 3 + $crop2, '', 0, 1);
        //     $pdf->Cell(110, 14, '', 0, 0);
        //     $pdf->Cell(25, 14 + $crop, 'PPN ' . $var_ppn . '%', 0, 0, 'L');
        //     $pdf->Cell(47, 14 + $crop, 'Rp ' . number_format(floor($tmp1), '0', ',', '.'), 0, 1, 'R');
        //     $pdf->Cell(1, 3 + $crop3, '', 0, 1);
        //     $pdf->Cell(110, 14 + $crop2, '', 0, 0);
        //     $pdf->Cell(22, 14 + $crop2, 'TOTAL', 0, 0, 'L');
        //     $pdf->Cell(50, 14 + $crop2, 'Rp ' . number_format(floor($tmp1) + floor($total)), 0, 1, 'R');
        //     $terbilang = floor($tmp1) + floor($total);
        // } else {
        //     $pdf->Cell(40, 17, $pdf->Image(base_url() . "assets/img/bg-1.jpg", 120, $pdf->GetY(), 77, 14), 0, 1, 'C');
        //     $pdf->SetXY($cur_x + 100, $cur_y);
        //     $pdf->Cell(10, 17, '', 0, 0);
        //     $pdf->SetTextColor(255, 255, 255);
        //     $pdf->SetFont('Arial', 'B', 13);
        //     $pdf->Cell(30, 14, 'TOTAL', 0, 0, 'L');
        //     $pdf->Cell(42, 14, 'Rp ' . number_format(floor($total), '0', ',', '.'), 0, 1, 'R');
        //     $terbilang = floor($total);
        // }

        // $cur_y = $pdf->GetY();
        // $pdf->SetXY($bank_xy[0], $bank_xy[1] + $crop);
        // $pdf->SetTextColor(40, 41, 40);
        // $pdf->SetFont('Arial', 'B', 10);
        // $pdf->Cell(5, 6 + $crop3, '', 0, 1);
        // $pdf->Cell(5, 8, '', 0, 0);

        // $pdf->Cell(100, 8, 'Terbilang : ', 0, 1);
        // $pdf->Cell(5, 8, '', 0, 0);
        // $pdf->SetFont('Arial', 'I', 10);
        // $pdf->MultiCell(88, 6 + $crop2, terbilang($terbilang) . ' Rupiah', 0, 1);
        // // $pdf->MultiCell(88, 6 + $crop2, 'QR HERE', 0, 1);
        // // echo base_url() . 'uploads/qrcode/' . $dataContent['inv_key'] . '_' . $dataContent['id'] . '.png';
        // if (file_exists('uploads/qrcode/' . $dataContent['inv_key'] . '_' . $dataContent['id'] . '.png')) {
        //     $pdf->Cell(40, 40, $pdf->Image(base_url() . 'uploads/qrcode/' . $dataContent['inv_key'] . '_' . $dataContent['id'] . '.png', 30, $pdf->GetY(), 40, 40), 0, 1, 'R');
        // } else {
        //     // echo "The file does not exist";
        // }



        $filename = 'INV_' .
            $dataContent['id_shp'] . '.pdf';

        $pdf->Output('', $filename, false);
    }

    public function history()
    {

        // DEFINES PAGE TITLE
        $data['title'] = 'Invoice';

        $collection = array();

        // DEFINES TO LOAD THE MODEL
        $this->load->model('Accounts_model');
        $filter['first_date'] = html_escape($this->input->post('date1'));
        $filter['second_date'] = html_escape($this->input->post('date2'));
        $filter['no_invoice'] = html_escape($this->input->post('invoice_no'));

        if ($filter['first_date'] == NULL && $filter['second_date'] == NULL) {
            $filter['first_date'] = date('Y-m-01');
            $filter['second_date'] = date('Y-m-31');

            // FETCH SALES RECORD FROM invoices TABLE
            // $result_invoices = $this->Accounts_model->get('mp_invoices', $first_date, $second_date);
        }
        $data['filter'] = $filter;
        $this->load->model(array('InvoiceModel'));
        // $this->SecurityModel->rolesOnlyGuard(array('accounting'), TRUE);

        $result_invoices = $this->InvoiceModel->getAllUsaha($filter);
        // echo json_encode($result_invoices);
        // die();

        // if ($result_invoices != NULL) {
        $count = 0;
        // print "<pre>";
        // print_r($result_invoices);
        // foreach ($result_invoices as $obj_result_invoices) {

        // 	// FETCH SALES RECORD FROM SALES TABLE
        // 	$result_sales = $this->Accounts_model->fetch_record_sales('mp_sales', 'order_id', $obj_result_invoices->id);
        // 	if ($result_sales != NULL) {
        // 		$collection[$count] = $result_sales;
        // 		$count++;
        // 	}
        // }
        // // print "<pre>";
        // print_r($collection);
        // ASSIGNED THE FETCHED RECORD TO DATA ARRAY TO VIEW
        // $data['Sales_Record'] = $collection;
        $data['Model_Title'] = "Edit invoice";
        $data['Model_Button_Title'] = "Update invoices";
        $data['invoices_Record'] = $result_invoices;

        $data['main_view'] = 'sales_invoices_v2_usaha';
        $this->load->view('main/index.php', $data);
        // } else {
        // 	// DEFINES WHICH PAGE TO RENDER
        // 	$data['main_view'] = 'main/error_invoices.php';
        // 	$data['actionresult'] = "invoice/manage";
        // 	$data['heading1'] = "Tidak ada faktur yang tersedia. ";
        // 	$data['heading2'] = "Ups! Maaf tidak ada catatan faktur yang tersedia di detail yang diberikan";
        // 	$data['details'] = "Kami akan segera memperbaikinya. Sementara itu, Anda dapat kembali atau mencoba menggunakan formulir pencarian.";
        // 	// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        // 	$this->load->view('main/index.php', $data);
        // }
    }
}
