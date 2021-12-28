<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\Writer\Word2007;

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('General_model', 'Payment_model', 'Statement_model'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = FALSE;
    }

    function getAllPelunasan()
    {
        try {
            $filter = $this->input->get();
            $data = $this->Payment_model->getAllPelunasan($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function index($data_return = NULL)
    {


        $this->load->model('Crud_model');
        $this->load->model('General_model');
        $data['satuan'] = $this->General_model->getAllUnit();
        $data['jenis_pembayaran'] = $this->General_model->getAllJenisInvoice();
        $data['ref_account'] = $this->General_model->getAllRefAccount(array('ref_type' => 'payment_method'));
        $data['form_url'] = 'create_pembayaran';
        $data['currency'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1)[0]->currency;
        $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true));


        $from = html_escape($this->input->post('from'));
        $to   = html_escape($this->input->post('to'));

        if ($from == NULL or $to == NULL) {

            $from = date('Y-m-') . '1';
            $to =  date('Y-m-') . '31';
        }
        $this->load->model('Accounts_model');

        $data['banks'] = $this->Accounts_model->getAllBank();
        // DEFINES PAGE TITLE
        $data['title'] = 'Entry Pembayaran';
        $data['data_return'] = $data_return;
        $this->load->model('Statement_model');
        $data['accounts_records'] = $this->Statement_model->chart_list();
        $data['patner_record'] = $this->Statement_model->patners_cars_list();

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'pembayaran/edit';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    public function jenis_pembayaran()
    {
        try {
            // $crud = $this->SecurityModel->Aksessbility_VCRUD('pembayaran', 'jenis_pembayaran', 'view');
            $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true));
            $data['title'] = 'List Jenis Pembayaran';
            $data['main_view'] = 'pembayaran/jenis_pembayaran';
            // $data['vcrud'] = $crud;
            $data['vcrud'] = array('parent_id' => 32, 'id_menulist' => 89);
            $this->load->view('main/index2.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }



    function create2($data_return = NULL)
    {

        $this->load->model('Crud_model');

        $data['currency'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1)[0]->currency;

        //$ledger
        $from = html_escape($this->input->post('from'));
        $to   = html_escape($this->input->post('to'));

        if ($from == NULL or $to == NULL) {

            $from = date('Y-m-') . '1';
            $to =  date('Y-m-') . '31';
        }
        $this->load->model('Accounts_model');

        $data['banks'] = $this->Accounts_model->getAllBank();
        // DEFINES PAGE TITLE
        $data['title'] = 'Entry Pembayaran';
        $data['data_return'] = $data_return;
        $this->load->model('Statement_model');
        $data['accounts_records'] = $this->Statement_model->chart_list();
        $data['patner_record'] = $this->Statement_model->patners_cars_list();

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'pembayaran/create2';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }


    public function delete($id)
    {
        try {
            $this->load->model(array('SecurityModel', 'InvoiceModel'));
            $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);
            $dataContent = $this->Payment_model->getAllPembayaran(array('id' =>  $id))[0];
            $dataContent['data_pelunasan'] = $this->Payment_model->getAllPelunasan(array('parent_id' => $id));
            if ($dataContent['agen_id'] != $this->session->userdata('user_id')['id'])
                throw new UserException('Sorry, Yang dapat mengahapus dan edit hanya agen yang bersangkutan', UNAUTHORIZED_CODE);

            $this->Payment_model->delete($id, $dataContent);
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Delete Successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);

            redirect('pembayaran/manage');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function editJenisPembayaran()
    {
        try {
            $this->load->model(array('SecurityModel', 'InvoiceModel'));
            $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);
            $data = $this->input->post();
            $this->Payment_model->editJenisPembayaran($data);
            $data = $this->General_model->getAllJenisPembayaran(array('id' =>  $data['id'], 'by_id' => true))[$data['id']];
            echo json_encode(array("error" => false, "data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }




    // pembayaran/manage
    public function manage()
    {

        // DEFINES PAGE TITLE
        $data['title'] = 'Invoice';

        $collection = array();

        // DEFINES TO LOAD THE MODEL
        $this->load->model('Accounts_model');
        $filter['first_date'] = html_escape($this->input->post('date1'));
        $filter['second_date'] = html_escape($this->input->post('date2'));
        $filter['search'] = html_escape($this->input->post('search'));

        if ($filter['first_date'] == NULL && $filter['second_date'] == NULL) {
            $filter['first_date'] = date('Y-m-01');
            $filter['second_date'] = date('Y-m-31');

            // FETCH SALES RECORD FROM pembayarans TABLE
            // $result_pembayarans = $this->Accounts_model->get('mp_pembayarans', $first_date, $second_date);
        }
        $data['filter'] = $filter;
        $this->load->model(array('InvoiceModel'));
        // $this->SecurityModel->rolesOnlyGuard(array('accounting'), TRUE);

        $result_pembayarans = $this->InvoiceModel->getAllPembayaran($filter);
        $count = 0;

        $data['Model_Title'] = "Edit pembayaran";
        $data['Model_Button_Title'] = "Update pembayarans";
        $data['pembayarans_Record'] = $result_pembayarans;

        $data['main_view'] = 'pembayaran/index';
        $this->load->view('main/index.php', $data);
        // } else {
        // 	// DEFINES WHICH PAGE TO RENDER
        // 	$data['main_view'] = 'main/error_pembayarans.php';
        // 	$data['actionresult'] = "pembayaran/manage";
        // 	$data['heading1'] = "Tidak ada faktur yang tersedia. ";
        // 	$data['heading2'] = "Ups! Maaf tidak ada catatan faktur yang tersedia di detail yang diberikan";
        // 	$data['details'] = "Kami akan segera memperbaikinya. Sementara itu, Anda dapat kembali atau mencoba menggunakan formulir pencarian.";
        // 	// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        // 	$this->load->view('main/index.php', $data);
        // }
    }

    public function edit($id)
    {
        try {

            $this->load->model(array('SecurityModel', 'InvoiceModel'));
            $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
            $acc_role = $this->SecurityModel->MultiplerolesStatus('Akuntansi');
            if ($dataContent['agen_id'] != $this->session->userdata('user_id')['id'] && (!$acc_role))
                throw new UserException('Sorry, Yang dapat mengahapus dan edit hanya agen yang bersangkutan', UNAUTHORIZED_CODE);
            if ($id != NULL) {
                $item = count($dataContent['item']);

                // die();
                for ($i = 0; $i < $item; $i++) {
                    // if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                    // 	$status = TRUE;
                    $dataContent['id_item'][$i] =  $dataContent['item'][$i]->id;
                    $dataContent['amount'][$i] = preg_replace("/[^0-9]/", "", $dataContent['item'][$i]->amount);
                    $dataContent['date_item'][$i] =  $dataContent['item'][$i]->date_item;
                    $dataContent['satuan'][$i] =  $dataContent['item'][$i]->satuan;
                    $dataContent['nopol'][$i] =  $dataContent['item'][$i]->nopol;

                    $dataContent['keterangan_item'][$i] =  $dataContent['item'][$i]->keterangan_item;
                    $dataContent['qyt'][$i] =  $dataContent['item'][$i]->qyt;
                    // $dataContent['qyt'][$i] = preg_replace("/[^0-9]/", "", $dataContent['item'][$i]->qyt);
                }
            } else {
                echo 'ngapain cok';
                return;
            }
            // echo json_encode($item);
            // echo json_encode($dataContent);
            // $this->index($dataContent);
            $this->load->model('Crud_model');

            $data['currency'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1)[0]->currency;

            $this->load->model('Accounts_model');

            $data['banks'] = $this->Accounts_model->getAllBank();
            // DEFINES PAGE TITLE
            $data['title'] = 'Edit Jurnal';
            $data['data_return'] = $dataContent;
            $this->load->model('Statement_model');
            $data['accounts_records'] = $this->Statement_model->chart_list();
            $data['patner_record'] = $this->Statement_model->patners_cars_list();
            $data['satuan'] = $this->General_model->getAllUnit();
            $data['jenis_pembayaran'] = $this->General_model->getAllJenisInvoice();
            $data['form_url'] = 'edit_process_pembayaran';
            $data['ref_account'] = $this->General_model->getAllRefAccount(array('ref_type' => 'payment_method'));
            $data['accounts'] = $this->General_model->getAllBaganAkun(array('by_DataStructure' => true));

            // DEFINES WHICH PAGE TO RENDER
            $data['main_view'] = 'pembayaran/edit';

            // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
            $this->load->view('main/index.php', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function copy($id)
    {
        $this->load->model(array('SecurityModel', 'InvoiceModel'));
        $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);

        if ($id != NULL) {
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
            $dataContent['id'] = '';
            $item = count($dataContent['item']);
            for ($i = 0; $i < $item; $i++) {
                // if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                // 	$status = TRUE;

                $dataContent['id_item'][$i] = '';
                $dataContent['amount'][$i] = preg_replace("/[^0-9]/", "", $dataContent['item'][$i]->amount);
                $dataContent['date_item'][$i] =  $dataContent['item'][$i]->date_item;
                $dataContent['keterangan_item'][$i] =  $dataContent['item'][$i]->keterangan_item;
                $dataContent['satuan'][$i] =  $dataContent['item'][$i]->satuan;
                $dataContent['nopol'][$i] =  $dataContent['item'][$i]->nopol;

                $dataContent['qyt'][$i] =  $dataContent['item'][$i]->qyt;
                // $dataContent['qyt'][$i] = preg_replace("/[^0-9]/", "", $dataContent['item'][$i]->qyt);
            }
        } else {
            echo 'ngapain cok';
            return;
        }
        // echo json_encode($item);
        $dataContent['id'] = '';
        // echo json_encode($dataContent);

        // die();
        $this->index($dataContent);
    }

    function head_pembayaran($pdf, $dataContent)
    {
        $pdf->Image(base_url() . 'assets/img/bg-invoice.jpg', 10, 10, 190, 50);
        $pdf->Image(base_url() . "assets/img/ima-outline-blue.png", 20, 15, 20, 20);
        $pdf->Image(base_url() . "assets/img/ima-text-white.png", 40, 15, 76, 20);

        $pdf->Cell(173, 20, '', 0, 1, 'C');
        $pdf->SetDrawColor(255, 255, 225);
        $pdf->SetTextColor(255, 255, 225);
        $pdf->Cell(10, 30, '', 0, 0, 'C');
        $pdf->Cell(173, 6, 'Jalan Sanggul Dewa No.6 Pangkalpinang', 0, 1);
        $pdf->Cell(10, 30, '', 0, 0, 'C');
        $pdf->Cell(173, 6, 'Bangka Belitung - Indonesia', 0, 1);
        $pdf->SetLineWidth(1);
        $pdf->Line(116, 20, 116, 53);
        $pdf->SetXY(0, 0);
        $pdf->Cell(179, 20, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 30);
        $pdf->Cell(96, 12, '', 0, 0, 'R');
        $pdf->Cell(77, 12, 'INVOICE', 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(96, 6, '', 0, 0, 'R');
        $pdf->Cell(77, 6, 'Number#', 0, 1, 'R');
        $pdf->Cell(96, 6, '', 0, 0, 'R');
        $pdf->Cell(77, 6,  $dataContent['id'], 0, 1, 'R');
        $pdf->SetFont('Arial', 'BI', 14);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetXY(12, 65);
    }

    function tanggal_indonesia($tanggal)
    {
        if (empty($tanggal)) return '';
        $BULAN = [0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $t = explode('-', $tanggal);
        return "{$t[2]} {$BULAN[intval($t[1])]} {$t[0]}";
    }
    public function download_word($id, $format = 1)
    {
        $this->load->model(array('SecurityModel', 'InvoiceModel'));
        // $this->SecurityModel->rolesOnlyGuard(array('accounting'), TRUE);
        $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);

        if ($id != NULL) {
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
        } else {
            echo 'ERROR';
            return;
        }
        $date_item = false;
        $total = 0;
        $total_qyt = 0;
        // var_dump($dataContent);
        // die();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $tanggal = $this->tanggal_indonesia($dataContent['date']);
        // $section->addText("\t\t\t\t\t\t\t\t\tPanngkalpinang, {$tanggal}", "paragraph", array('spaceBefore' => 0));
        $phpWord->addFontStyle('paragraph_bold', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
        $phpWord->addFontStyle('paragraph_italic', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'italic' => true));
        $phpWord->addFontStyle('paragraph_underline', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single'));
        $phpWord->addFontStyle('paragraph_bold_underline', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single', 'bold' => true));
        $phpWord->addFontStyle('paragraph2', array('spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(106), 'name' => 'Times New Roman', 'size' => 11, 'color' => '000000'));

        $pageStyle = [
            'breakType' => 'continuous', 'colsNum' => 2,
            // 'pageSizeW' => $paper->getWidth(),
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1700,
            'marginBottom' => 1000
        ];
        $section = $phpWord->addSection($pageStyle);
        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 1,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1700,
            'marginBottom' => 1000
        ]);

        $section->addText("PEMBAYARAN RENTAL MOBIL KE MITRA", 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addText(strtoupper($dataContent['description']), 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addTextBreak();
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'height' => 100, 'cellMarginButtom' => -100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'cellMarginRight' => 100, 'spaceAfter' => -100);
        $cellVCentered = array('valign' => 'center', 'align' => 'center', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);
        if ($dataContent['item']  != NULL) {
            foreach ($dataContent['item'] as $item) {
                $total = $total + (floor($item->amount) * $item->qyt);
                $total_qyt =  $total_qyt + ($item->qyt);
                if (!empty($item->date_item))
                    $date_item = true;
            }
        }
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'e1e3e1');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        // if ($date_item) {
        $fancyTableCellStyle = array('valign' => 'center');
        $table->addRow();
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('KETERANGAN', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('TANGGAL', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('QYT', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('HARGA (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('SUB TOTAL (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        if ($dataContent['item']  != NULL) {
            foreach ($dataContent['item'] as $item) {
                $table->addRow();
                $table->addCell(3500, $cellVCentered)->addText($item->keterangan_item, null, array('spaceAfter' => 0));
                $table->addCell(1200, $cellVCentered)->addText($item->date_item, null, array('spaceAfter' => 0));
                $table->addCell(1000, $cellVCentered)->addText($item->qyt . ' ' . $item->satuan, null, array('spaceAfter' => 0, 'align' => 'center'));
                $table->addCell(1500, $cellVCentered)->addText(number_format(floor($item->amount), '0', ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
                $table->addCell(1500, $cellVCentered)->addText(number_format($item->qyt * floor($item->amount), '0', ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
            }
            $table->addRow();
            $cellColSpan = array('gridSpan' => 4, 'valign' => 'center');
            $table->addCell(200, $cellColSpan)->addText('Sub Total I    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));

            $potongan_jasa = ($dataContent['am_jasa']);
            $total = $total - $potongan_jasa;
            // echo number_format($potongan_jasa, 0, ',', '.');
            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('Biaya Jasa ' . floatval($dataContent['percent_jasa']) . '%    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($potongan_jasa, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));

            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('Sub Total II    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));

            $total_kwitansi = $total;
            $potongan_pph = ($dataContent['am_pph']);
            $total = $total - $potongan_pph;

            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('PPH 23  ' . floatval($dataContent['percent_pph']) . '%    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($potongan_pph, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));


            if ((float)$dataContent['par_am'] > 0) {
                $table->addRow();
                $table->addCell(200, $cellColSpan)->addText($dataContent['par_label'], 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
                if (stripos(strtolower($dataContent['par_label']), 'lebih') !== false) {
                    $total = $total - $dataContent['par_am'];
                    $par_am = -$dataContent['par_am'];
                } else {
                    $total = $total + $dataContent['par_am'];
                    $par_am = $dataContent['par_am'];
                }
                $table->addCell(500, $cellVCentered)->addText('' . number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            } else {
                $par_am = 0;
            }

            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('TOTAL FINAL   ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $terbilang =  floor($total);
            $kw_terbilang =  floor($total_kwitansi);
        }
        $section->addTextBreak();
        $textrun = $section->addTextRun();
        $textrun->addText("Terbilang : ", 'paragraph');
        $textrun->addText($this->terbilang($terbilang) . ' Rupiah', 'paragraph_bold');


        $section->addTextBreak(1);
        $section->addText("Pangkalpinang, " . $tanggal, 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addTextBreak(2);

        $section->addText($dataContent['customer_name'], 'paragraph_bold_underline', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));

        $section->addTextBreak();
        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 1,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'marginLeft' => 500, 'marginRight' => 500,
            'marginTop' => 500,
            'marginBottom' => 1000
        ]);
        $section->addPageBreak();
        // new
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 2, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 20);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $homekwintansi = $table->addRow()->addCell();

        // end new
        // $section->addText("KWITANSIsaddddddddddd", 'paragraph_bold', array('align' => 'center'));
        $fancyTableStyle = array('height' => 300, 'borderSize' => 1, 'borderColor' => 'ffffff', 'width' => 6000, 'cellMargin' => 10, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $cellVCentered = array('borderColor' => '000000', 'borderSize' => '12', 'valign' => 'top', 'spaceAfter' => 2);
        $spanTableStyleName = 'Freame Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);

        $freame = $homekwintansi->addTable($spanTableStyleName);
        $freame->addRow(1000);
        $freame2 = $freame->addCell(12000, array('valign' => 'top', 'borderBottomColor' => 'ffffff', 'borderBottomSize' => '6', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));

        $freame2->addImage(
            base_url('assets/img/ima-transparent2.png'),
            array(
                'height'           => round(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.3)),
                'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'marginLeft'       => round(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(0.5)),
                'marginTop'        => round(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(0.1)),
            )
        );
        $freame->addRow();
        $freame3 = $freame->addCell(12000, array('valign' => 'top', 'borderBottomColor' => 'ffffff', 'borderBottomSize' => '6', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));


        $freame3->addText("KWITANSI", array('name' => 'Times New Roman', 'size' => 13, 'color' => '000000', 'bold' => true), array('align' => 'center'));
        $fancyTableStyle = array('height' => 300, 'cellMargin' => 40, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $cellVCentered = array('borderColor' => '#ffffff', 'borderSize' => '6', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);

        $freame->addRow();
        $freame4 = $freame->addCell(10000, array('valign' => 'top', 'borderBottomColor' => 'ffffff', 'borderBottomSize' => '6', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
        $freame5 = $freame4->addTable($spanTableStyleName);

        $freame5->addRow();
        $freame5->addCell(100, $cellVCentered)->addText('', 'paragraph', array('spaceAfter' => 0));

        $freame5->addCell(2000, $cellVCentered)->addText('Sudah terima dari', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(1, $cellVCentered)->addText(':', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(7000, $cellVCentered)->addText('PT INDOMETAL ASIA', 'paragraph_bold', array('spaceAfter' => 0));

        $freame5->addRow();
        $freame5->addCell(100, $cellVCentered)->addText('', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(2000, $cellVCentered)->addText('Sejumlah', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(1, $cellVCentered)->addText(':', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(7000, $cellVCentered)->addText($this->terbilang($kw_terbilang + $par_am) . ' Rupiah', 'paragraph_italic', array('spaceAfter' => 0));

        $freame5->addRow();
        $freame5->addCell(100, $cellVCentered)->addText('', 'paragraph', array('spaceAfter' => 3));
        $freame5->addCell(2000, $cellVCentered)->addText('Untuk Pembayaran', 'paragraph', array('spaceAfter' => 3));
        $freame5->addCell(1, $cellVCentered)->addText(':', 'paragraph', array('spaceAfter' => 3));
        $freame5->addCell(8000, $cellVCentered)->addText($dataContent['description'], 'paragraph', array('spaceAfter' => 3));

        $fancyTableStyle = array('leftFromText' => 0, 'height' => 300, 'marginRight' => 4000, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'indentation' => 3000);
        $cellVCentered = array('borderColor' => 'ffffff', 'borderSize' => '6', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Price';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $freame->addRow();
        $freame6 = $freame->addCell(10000, array('valign' => 'top', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
        $freame7 = $freame6->addTable($spanTableStyleName);
        $kw_total = 0;
        $count_row = count($dataContent['item']);
        $i = 1;
        if ((float) $dataContent['par_am'] > 0) {
            $freame7->addRow();
            $freame7->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
            $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
            $freame7->addCell(3400, $cellVCentered)->addText($dataContent['par_label'], 'paragraph', array('spaceAfter' => 0));
            $freame7->addCell(30, $cellVCentered)->addText('Rp', 'paragraph', array('spaceAfter' => 0));
            if (stripos(strtolower($dataContent['par_label']), 'lebih') !== false) {
                $freame7->addCell(1600, $cellVCentered)->addText(number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
                $total = $total - $dataContent['par_am'];
            } else {
                $total = $total + $dataContent['par_am'];
                $table->addCell(500, $cellVCentered)->addText('' . number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            }
            $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        }

        foreach ($dataContent['item'] as $item) {

            $freame7->addRow();
            $current_data = ($item->amount * $item->qyt);
            $current_jasa = ceil($dataContent['percent_jasa'] / 100 * $current_data);
            // $current_pph = ($dataContent['percent_pph'] / 100 * ($current_data - $current_jasa));
            $current_total = $current_data - $current_jasa;
            $kw_total = $kw_total + $current_total;
            // var_dump($item);
            // die();
            if ($i == $count_row) {
                // $current_total = 0;
                $freame7->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
                $freame7->addCell(60, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('', null, array('spaceAfter' => 0));
                $freame7->addCell(3400, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText($item->date_item, 'paragraph', array('spaceAfter' => 0));
                $freame7->addCell(30, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('Rp', 'paragraph', array('spaceAfter' => 0));
                if (number_format($kw_total, '0', ',', '.') != number_format($total_kwitansi, '0', ',', '.'))
                    $freame7->addCell(1600, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('manual', 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
                else
                    $freame7->addCell(1600, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText(number_format($current_total, '0', ',', '.'), 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
                $freame7->addCell(60, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('', null, array('spaceAfter' => 0));
            } else {
                $freame7->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
                $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
                $freame7->addCell(3400, $cellVCentered)->addText($item->nopol ? $item->nopol : '', 'paragraph', array('spaceAfter' => 0));
                $freame7->addCell(30, $cellVCentered)->addText('Rp', 'paragraph', array('spaceAfter' => 0));
                $freame7->addCell(1600, $cellVCentered)->addText(number_format($current_total, '0', ',', '.'), 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
                $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
            }
            $i++;
        }
        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(1400, $cellVCentered)->addText('TOTAL', 'paragraph_bold', array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('Rp', 'paragraph_bold', array('spaceAfter' => 0));
        $freame7->addCell(1600, $cellVCentered)->addText(number_format($total_kwitansi + $par_am, '0', ',', '.'), 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'right',));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 1));
        $freame7->addRow(0.1);
        $freame7->addCell(6000)->addText(' ', array('name' => 'Times New Roman', 'size' => 2, 'color' => '000000', 'bold' => true), array('align' => 'center', 'spaceAfter' => -1));

        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText('Pangkalpinang, ' . $this->tanggal_indo($dataContent['date']), 'paragraph', array('align' => 'center', 'spaceAfter' => -1));

        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText('', 'paragraph', array('spaceAfter' => 0));

        $freame7->addRow(700);
        $freame7->addCell(6000, $cellVCentered)->addText('          Rp. ' . number_format($total_kwitansi, '0', ',', '.'), array('name' => 'Times New Roman', 'size' => 15, 'color' => '000000', 'bold' => true), array('align' => 'left'));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText('', 'paragraph', array('spaceAfter' => 0));

        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText($dataContent['customer_name'], 'paragraph_bold_underline', array('align' => 'center', 'spaceAfter' => -1));
        // if ($dataContent['id'] == 57) {
        // 	echo json_encode($dataContent);
        // } else {
        $writer = new Word2007($phpWord);
        $filename = 'PMT_' . $dataContent['id'];
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        // }
    }

    public function download_word2($id)
    {
        $this->load->model(array('SecurityModel', 'InvoiceModel'));
        // $this->SecurityModel->rolesOnlyGuard(array('accounting'), TRUE);
        $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);

        if ($id != NULL) {
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
        } else {
            echo 'ERROR';
            return;
        }
        $date_item = false;
        $total = 0;
        $total_qyt = 0;

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $tanggal = $this->tanggal_indonesia($dataContent['date']);
        $phpWord->addFontStyle('paragraph_bold', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
        $phpWord->addFontStyle('paragraph_italic', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'italic' => true));
        $phpWord->addFontStyle('paragraph_underline', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single'));
        $phpWord->addFontStyle('paragraph_bold_underline', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single', 'bold' => true));
        $phpWord->addFontStyle('paragraph2', array('spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(106), 'name' => 'Times New Roman', 'size' => 11, 'color' => '000000'));

        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 1,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1700,
            'marginBottom' => 1000,
            'orientation' => 'landscape'
        ]);

        $section->addText("PT INDOMETAL ASIA", 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addText("DAFTAR KENDARAAN INSIDENTIL", 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addText(strtoupper($dataContent['description']), 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addTextBreak();
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'height' => 100, 'cellMarginButtom' => -100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'cellMarginRight' => 100, 'spaceAfter' => -100);
        $cellVCentered = array('valign' => 'center', 'align' => 'center', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);
        if ($dataContent['item']  != NULL) {
            foreach ($dataContent['item'] as $item) {
                $total = $total + (floor($item->amount) * $item->qyt);
                $total_qyt =  $total_qyt + ($item->qyt);
                if (!empty($item->date_item))
                    $date_item = true;
            }
        }
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'e1e3e1');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        // if ($date_item) {
        $fancyTableCellStyle = array('valign' => 'center');
        $table->addRow();
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('KETERANGAN', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('NOPOL', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('TANGGAL', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('QYT', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('HARGA (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('SUB TOTAL (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        if ($dataContent['item']  != NULL) {
            foreach ($dataContent['item'] as $item) {
                $table->addRow();
                $table->addCell(3500, $cellVCentered)->addText($item->keterangan_item, null, array('spaceAfter' => 0));
                $table->addCell(1200, $cellVCentered)->addText($item->nopol, null, array('spaceAfter' => 0));
                $table->addCell(1200, $cellVCentered)->addText($item->date_item, null, array('spaceAfter' => 0));
                $table->addCell(1000, $cellVCentered)->addText($item->qyt . ' ' . $item->satuan, null, array('spaceAfter' => 0, 'align' => 'center'));
                $table->addCell(1500, $cellVCentered)->addText(number_format(floor($item->amount), '0', ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
                $table->addCell(1500, $cellVCentered)->addText(number_format($item->qyt * floor($item->amount), '0', ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
            }
            $table->addRow();
            $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
            $table->addCell(200, $cellColSpan)->addText('Sub Total I    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));



            $terbilang =  floor($total);
            // $kw_terbilang =  floor($total_kwitansi);
        }
        $section->addTextBreak();
        // $textrun = $section->addTextRun();
        // $textrun->addText("Terbilang : ", 'paragraph');
        // $textrun->addText($this->terbilang($terbilang) . ' Rupiah', 'paragraph_bold');

        $pageStyle = [
            'breakType' => 'continuous', 'colsNum' => 2,
            // 'pageSizeW' => $paper->getWidth(),
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'marginLeft' => 1000, 'marginRight' => 1000,
            'marginTop' => 1700,
            'marginBottom' => 1000,
            'orientation' => 'landscape'
        ];
        $section = $phpWord->addSection($pageStyle);
        // $section->addTextBreak();
        // $year = explode("-", $dataContent['input_date'])[0];
        // $section->addText("Tanggal\t: " . $tanggal, 'paragraph', array('spaceAfter' => 100));
        $section->addText("Mengetahui,", 'paragraph', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText("PT INDOMETAL ASIA ", 'paragraph', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText("Direktur", 'paragraph', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        // $section->addText("Mengetahui,", 'paragraph', array('spaceAfter' => 100));
        $section->addTextBreak(3);
        $section->addText("SETIAWAN RAHARJO", 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        // $textrun->addText("Perihal\t\t: ", 'paragraph');
        $section->addTextBreak(1);

        $section->addText('Pangkalpinang, ' . $this->tanggal_indo($dataContent['date']), 'paragraph', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText("PT INDOMETAL ASIA ", 'paragraph', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        $Text_to_Add = htmlentities("Ka. Usaha & Barang/Jasa");
        $section->addText($Text_to_Add, 'paragraph', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        // $section->addText("Mengetahui,", 'paragraph', array('spaceAfter' => 100));
        $section->addTextBreak(3);
        $section->addText($dataContent['acc_0'], 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        // $textrun->addText("Perihal\t\t: ", 'paragraph');
        $textrun = $section->addTextRun();

        $pageStyle = [
            'breakType' => 'continuous', 'colsNum' => 1,
            // 'pageSizeW' => $paper->getWidth(),
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1700,
            'marginBottom' => 1000,
            'orientation' => 'landscape'
        ];
        $section = $phpWord->addSection($pageStyle);


        $writer = new Word2007($phpWord);
        $filename = 'DKI_' . $dataContent['id'];
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        // }
    }

    public function download($id)
    {
        $this->load->model(array('SecurityModel', 'InvoiceModel'));
        // $this->SecurityModel->rolesOnlyGuard(array('accounting'), TRUE);

        if ($id != NULL) {
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
        } else {
            echo 'ngapain cok';
            return;
        }
        $date_item = false;
        $total = 0;
        $total_qyt = 0;
        if ($dataContent['item']  != NULL) {
            foreach ($dataContent['item'] as $item) {
                $total = $total + (floor($item->amount) * $item->qyt);
                $total_qyt =  $total_qyt + ($item->qyt);
                if (!empty($item->date_item))
                    $date_item = true;
            }
        }

        require('assets/fpdf/fpdf.php');
        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->SetMargins(12, 15, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 13);
        // 
        $this->head_pembayaran($pdf, $dataContent);
        $pdf->SetFont('Arial', '', 9.5);

        $pdf->SetTextColor(107, 104, 104);
        $pdf->Cell(40, 6, 'PAYMENT TO. ', 0, 1);
        $pdf->SetTextColor(20, 20, 20);
        $pdf->Cell(5, 6, '', 0, 0, 'C');
        $pdf->MultiCell(40, 6, $dataContent['customer_name'], 0, 1);
        $pdf->Cell(5, 6, '', 0, 0, 'C');
        $pdf->MultiCell(40, 6, $dataContent['cus_address'], 0, 1);
        // $pdf->Cell(5, 6, '', 0, 1);

        $pdf->SetTextColor(107, 104, 104);
        $pdf->Cell(35, 6, 'NO. ', 0, 1);
        $pdf->SetTextColor(20, 20, 20);
        $pdf->Cell(5, 6, '', 0, 0, 'C');
        $pdf->MultiCell(40, 6,  $dataContent['id'], 0, 1);
        // $pdf->Cell(5, 6, '', 0, 1);

        $pdf->SetTextColor(107, 104, 104);
        $pdf->Cell(40, 6, 'TANGGAL', 0, 1);
        $pdf->SetTextColor(20, 20, 20);
        $pdf->Cell(5, 6, '', 0, 0, 'C');
        $pdf->MultiCell(40, 6, $this->tanggal_indo($dataContent['date']), 0, 1);
        // $pdf->Cell(5, 6, '', 0, 1);

        // $pdf->Circle(110, 47, 7, 'F');

        $pdf->SetTextColor(107, 104, 104);
        $pdf->Cell(35, 6, 'DESKRIPSI. ', 0, 1);
        $pdf->SetTextColor(20, 20, 20);
        $pdf->Cell(5, 6, '', 0, 0, 'C');
        $pdf->MultiCell(40, 6,  $dataContent['description'], 0, 1);
        // $pdf->Cell(5, 6, '', 0, 1);
        // $pdf->Cell(5, 6, '', 1, 1);

        $cur_x = $pdf->GetX();
        $cur_y = $pdf->GetY();
        $f1_y = $pdf->GetY();

        $pdf->SetXY(12, 65);
        $pdf->Cell(50, 6, '', 0, 0, 'C');
        $pdf->SetTextColor(107, 104, 104);
        $pdf->SetDrawColor(107, 104, 104);
        if ($date_item) {
            $pdf->Cell(48, 6, 'KETERANGAN', 0, 0, 'C');
            $pdf->Cell(29, 6, 'TANGGAL', 0, 0, 'C');
            $pdf->Cell(12, 6, 'QYT', 0, 0, 'C');
            $pdf->Cell(25, 6, 'HARGA', 0, 0, 'C');
            $pdf->Cell(25, 6, 'SUB TOTAL', 0, 0, 'C');
            $pdf->Cell(1, 8, '', 0, 0, 'C');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(68, 72.5, 197, 72.5);

            $pdf->SetTextColor(20, 20, 20);
            $pdf->Cell(50, 6, '', 0, 1, 'C');
            $image1 = base_url() . "assets/img/blue_dot.jpg";
            if ($dataContent['item']  != NULL) {
                foreach ($dataContent['item'] as $item) {
                    $pdf->SetX(60);

                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $tmp_y = $pdf->GetY();
                    $pdf->Cell(4, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY() + 1.6, 4), 0, 0);
                    $pdf->MultiCell(45, 8, $item->keterangan_item, 0, 1);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 49, $y);
                    $pdf->MultiCell(28, 8, $item->date_item, 0, 1);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 77, $y);
                    $pdf->MultiCell(12, 8, $item->qyt . '' . $item->satuan, 0, 'C',     0);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 89, $y);
                    $pdf->MultiCell(24, 8, number_format(floor($item->amount), '0', ',', '.'), 0, 'R', 0);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 113, $y);
                    $pdf->MultiCell(24, 8, number_format($item->qyt * floor($item->amount), '0', ',', '.'), 0, 'R', 0);
                    $pdf->SetXY(62, $tmp_y);
                    $pdf->SetLineWidth(0.1);
                    $pdf->Line(68, $tmp_y, 197, $tmp_y);
                }

                $pdf->Cell(76, 8, '', 0, 0, 'C');
                $pdf->Cell(15, 8, $total_qyt, 0, 0, 'C');
                $pdf->Cell(10, 8, '', 0, 0, 'C');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(35, 8, 'Rp ' . number_format($total, '0', ',', '.'), 0, 1, 'R');
            }
        } else {
            $pdf->Cell(60, 6, 'KETERANGAN', 0, 0, 'C');
            $pdf->Cell(14, 6, 'QYT', 0, 0, 'C');
            $pdf->Cell(30, 6, 'HARGA', 0, 0, 'C');
            $pdf->Cell(30, 6, 'SUB TOTAL', 0, 0, 'C');
            $pdf->Cell(1, 8, '', 0, 0, 'C');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(68, 72.5, 197, 72.5);

            $pdf->SetTextColor(20, 20, 20);
            $pdf->Cell(50, 6, '', 0, 1, 'C');
            $image1 = base_url() . "assets/img/blue_dot.jpg";
            if ($dataContent['item']  != NULL) {
                foreach ($dataContent['item'] as $item) {
                    $pdf->SetX(60);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();

                    $tmp_y = $pdf->GetY();
                    $pdf->Cell(4, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY() + 1.7, 4), 0, 0);
                    $pdf->MultiCell(56, 8, $item->keterangan_item, 0, 1);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 60, $y);
                    $pdf->MultiCell(14, 8, $item->qyt . '' . $item->satuan, 0, 'C',     0);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 74, $y);
                    $pdf->MultiCell(30, 8, number_format(floor($item->amount), '0', ',', '.'), 0, 'R', 0);
                    if ($pdf->GetY() > $tmp_y)
                        $tmp_y = $pdf->GetY();
                    $pdf->SetXY($x + 104, $y);
                    $pdf->MultiCell(30, 8, number_format($item->qyt * floor($item->amount), '0', ',', '.'), 0, 'R', 0);
                    $pdf->SetXY(62, $tmp_y);
                    $pdf->SetLineWidth(0.1);
                    $pdf->Line(68, $tmp_y, 197, $tmp_y);
                }

                $pdf->Cell(60, 8, '', 0, 0, 'C');
                $pdf->Cell(15, 8, $total_qyt, 0, 0, 'C');
                $pdf->Cell(25, 8, '', 0, 0, 'C');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(35, 8, 'Rp ' . number_format($total, '0', ',', '.'), 0, 1, 'R');
            }
        }
        if ($pdf->GetY() < $f1_y) {
            $pdf->Line(20, $f1_y + 5, 110, $f1_y + 5);
            $pdf->Line(60, 65, 60, $f1_y);
            $pdf->SetXY(20, $f1_y);
        } else {
            $pdf->Line(20, $pdf->GetY() + 2, 110, $pdf->GetY() + 2);
            $pdf->Line(60, 65, 60, $pdf->GetY() - 2);
        }
        $cur_y =  $pdf->GetY();
        $pdf->SetLineWidth(0.5);
        // $pdf->Line(60, 75, 60, $cur_y);
        $crop = 0;
        $crop2 = 0;
        $crop3 = 0;
        $pdf->AliasNbPages();
        if ($cur_y > 165) {
            $crop = -5;
            $crop2 = -2;
            $crop3 = -1;
        }
        $pdf->Cell(30, 10 + $crop, '', 0, 1, 'C');
        $pdf->SetTextColor(40, 41, 40);
        $pdf->SetFont('Arial', 'B', 10);
        $cur_y =  $pdf->GetY();
        $cur_x =  $pdf->GetX();

        if ($dataContent['payment_metode'] != 99) {
            $pdf->Cell(5, 7 + $crop2, '', 0, 0, 'C');
            $pdf->Cell(50, 7 + $crop2, 'BANK TRANSFER', 0, 1, 'C');
            $pdf->Cell(5, 7 + $crop2, '', 0, 0, 'C');
            $pdf->Cell(15, 7, 'Bank :', 0, 0, 'L');
            $pdf->MultiCell(60, 7 + $crop2, $dataContent['bank_name'], 0, 'R');

            $pdf->Cell(5, 7, '', 0, 0, 'C');
            $pdf->Cell(30, 7, 'Account Name :', 0, 0, 'L');
            $pdf->MultiCell(45, 7 + $crop2, $dataContent['title_bank'], 0, 'R');

            $pdf->Cell(5, 7, '', 0, 0, 'C');
            $pdf->Cell(35, 7, 'Account Number :', 0, 0, 'L');
            $pdf->MultiCell(40, 7 + $crop2, $dataContent['bank_number'], 0, 'R');
        }
        $bank_xy = array($pdf->GetX(), $pdf->GetY());
        $pdf->SetXY($cur_x + 120, $cur_y);

        if ($dataContent['ppn_pph'] == 1) {

            $pdf->Cell(40, 17 + $crop, $pdf->Image(base_url() . "assets/img/bg-3.jpg", 120, $pdf->GetY(), 77, 14 + $crop2), 0, 1, 'C');
            $pdf->Cell(40, 17 + $crop, $pdf->Image(base_url() . "assets/img/bg-2.jpg", 120, $pdf->GetY(), 77, 14 + $crop2), 0, 1, 'C');
            $pdf->Cell(40, 17 + $crop, $pdf->Image(base_url() . "assets/img/bg-1.jpg", 120, $pdf->GetY(), 77, 14 + $crop2), 0, 1, 'C');
            $pdf->SetXY($cur_x + 100, $cur_y);
            $pdf->Cell(10, 17, '', 0, 0);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 13);

            $pdf->Cell(30, 14 + $crop2, 'SUB TOTAL', 0, 0, 'L');
            $pdf->Cell(42, 14 + $crop2, 'Rp ' . number_format(floor($total), '0', ',', '.'), 0, 1, 'R');
            $pdf->Cell(1, 3 + $crop2, '', 0, 1);
            $pdf->Cell(110, 14, '', 0, 0);
            $pdf->Cell(25, 14 + $crop, 'PPN 10%', 0, 0, 'L');
            $pdf->Cell(47, 14 + $crop, 'Rp ' . number_format(floor($total * 0.10), '0', ',', '.'), 0, 1, 'R');
            $pdf->Cell(1, 3 + $crop3, '', 0, 1);
            $pdf->Cell(110, 14 + $crop2, '', 0, 0);
            $pdf->Cell(22, 14 + $crop2, 'TOTAL', 0, 0, 'L');
            $pdf->Cell(50, 14 + $crop2, 'Rp ' . number_format(floor($total * 0.10) + floor($total)), 0, 1, 'R');
            $terbilang = floor($total * 0.10) + floor($total);
        } else {
            $pdf->Cell(40, 17, $pdf->Image(base_url() . "assets/img/bg-1.jpg", 120, $pdf->GetY(), 77, 14), 0, 1, 'C');
            $pdf->SetXY($cur_x + 100, $cur_y);
            $pdf->Cell(10, 17, '', 0, 0);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Cell(30, 14, 'TOTAL', 0, 0, 'L');
            $pdf->Cell(42, 14, 'Rp ' . number_format(floor($total), '0', ',', '.'), 0, 1, 'R');
            $terbilang = floor($total);
        }

        $cur_y = $pdf->GetY();
        $pdf->SetXY($bank_xy[0], $bank_xy[1] + $crop);
        $pdf->SetTextColor(40, 41, 40);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(5, 6 + $crop3, '', 0, 1);
        $pdf->Cell(5, 8, '', 0, 0);

        $pdf->Cell(100, 8, 'Terbilang : ', 0, 1);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->MultiCell(88, 6 + $crop2, $this->terbilang($terbilang) . ' Rupiah', 0, 1);


        $filename = 'PMT_' .
            $dataContent['id'] . '.pdf';

        $pdf->Output('', $filename, false);
    }
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " Puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " Ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " Ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " Juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " Milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }

    function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }

    public function download_word_reklamasi($id, $format = 1)
    {
        $this->load->model(array('SecurityModel', 'InvoiceModel'));
        // $this->SecurityModel->rolesOnlyGuard(array('accounting'), TRUE);
        $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);

        if ($id != NULL) {
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
        } else {
            echo 'ERROR';
            return;
        }
        $date_item = false;
        $total = 0;
        $total_qyt = 0;
        // var_dump($dataContent);
        // die();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $tanggal = $this->tanggal_indonesia($dataContent['date']);
        // $section->addText("\t\t\t\t\t\t\t\t\tPanngkalpinang, {$tanggal}", "paragraph", array('spaceBefore' => 0));
        $phpWord->addFontStyle('paragraph_bold', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
        $phpWord->addFontStyle('paragraph_italic', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'italic' => true));
        $phpWord->addFontStyle('paragraph_underline', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single'));
        $phpWord->addFontStyle('paragraph_bold_underline', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single', 'bold' => true));
        $phpWord->addFontStyle('paragraph2', array('spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(106), 'name' => 'Times New Roman', 'size' => 11, 'color' => '000000'));

        // $pageStyle = [
        //     'breakType' => 'continuous', 'colsNum' => 2,
        //     // 'pageSizeW' => $paper->getWidth(),
        //     'pageSizeW' =>
        //     \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
        //     'pageSizeH' =>
        //     \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
        //     'marginLeft' => 1500, 'marginRight' => 1000,
        //     'marginTop' => 1700,
        //     'marginBottom' => 1000
        // ];
        // $section = $phpWord->addSection($pageStyle);
        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 1,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1000,
            'marginBottom' => 1000,
        ]);
        // $section->setOrientation($section::ORIENTATION_LANDSCAPE);
        // $section->addTextBreak();
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'height' => 100, 'cellMarginButtom' => -100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'cellMarginRight' => 100, 'spaceAfter' => -100);
        $cellVCentered = array('valign' => 'center', 'align' => 'center', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Colspan Rowspan';
        $section->addText("Perhitungan Pembayaran Pekerjaan Penataan Lahan PT Indometal Asia", 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addText(($dataContent['description']), 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);
        if ($dataContent['item']  != NULL) {
            foreach ($dataContent['item'] as $item) {
                $total = $total + (floatval($item->amount) * $item->qyt);
                $total_qyt =  $total_qyt + ($item->qyt);
                if (!empty($item->date_item))
                    $date_item = true;
            }
        }
        $original_total = $total;
        $pembulatan = floor($total / 100) * 100;
        $total = floor($total / 100) * 100;

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'e1e3e1');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        // if ($date_item) {
        $fancyTableCellStyle = array('valign' => 'center');
        $table->addRow();
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Rincian', 'paragraph_bold', array('spaceAfter' => 0));
        $cell2 = $table->addCell('', array('gridSpan' => 4, 'valign' => 'center', 'bgColor' => 'e1e3e1'));
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Kontrak', 'paragraph_bold', array('spaceAfter' => 0));
        $cell3 = $table->addCell('', array('gridSpan' => 4, 'valign' => 'center', 'bgColor' => 'e1e3e1'));
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Realisasi', 'paragraph_bold', array('spaceAfter' => 0));
        $table->addRow();
        $table->addCell(3000, $cellRowContinue)->addTextRun($cellHCentered)->addText('Rincian', 'paragraph_bold', array('spaceAfter' => 0));
        // $textrun3 = $cell3->addTextRun($cellHCentered);
        // $textrun1->addText('HARGA (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(800, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Vol', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(800, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Satuan', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(3000, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Harga Satuan (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(3000, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Jumlah (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(800, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Vol', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(800, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Satuan', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(3000, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Harga Satuan (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell4 = $table->addCell(3000, $cellRowSpan);
        $textrun4 = $cell4->addTextRun($cellHCentered);
        $textrun4->addText('Jumlah (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        if ($dataContent['item']  != NULL) {
            $tot_po = 0;
            $tot_qyt_po = 0;
            $tot_qyt = 0;
            foreach ($dataContent['item'] as $item) {
                $po_price = preg_replace("/[^0-9]/", "", $item->date_item);
                $po_price  = (float)substr($po_price, 0, -2) . '.' . substr($po_price, -2);
                $po_tot_price =  $po_price * (float)$item->nopol;
                $tot_po += $po_tot_price;
                $tot_qyt_po += (float)$item->nopol;
                $tot_qyt += (float)$item->qyt;
                $table->addRow();
                $table->addCell(3000, $cellVCentered)->addText($item->keterangan_item, null, array('spaceAfter' => 0));
                $table->addCell('', $cellVCentered)->addText(floatval($item->nopol), null, array('spaceAfter' => 0, 'align' => 'center'));
                $table->addCell('', $cellVCentered)->addText($item->satuan, null, array('spaceAfter' => 0, 'align' => 'center'));
                $table->addCell('', $cellVCentered)->addText(number_format($po_price, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
                $table->addCell('', $cellVCentered)->addText(number_format($po_tot_price, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
                $table->addCell('', $cellVCentered)->addText(floatval($item->qyt), null, array('spaceAfter' => 0, 'align' => 'center'));
                $table->addCell('', $cellVCentered)->addText($item->satuan, null, array('spaceAfter' => 0, 'align' => 'center'));
                $table->addCell('', $cellVCentered)->addText(number_format($item->amount, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
                $table->addCell('', $cellVCentered)->addText(number_format($item->amount * $item->qyt, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
            }
            $table->addRow();
            $table->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
            $table->addCell('', $cellVCentered)->addText(floatval($tot_qyt_po), null, array('spaceAfter' => 0, 'align' => 'center'));
            $table->addCell('', $cellVCentered)->addText('', null, array('spaceAfter' => 0));
            $table->addCell('', $cellVCentered)->addText('', null, array('spaceAfter' => 0, 'align' => 'right'));
            $table->addCell('', $cellVCentered)->addText(number_format($po_tot_price, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
            $table->addCell('', $cellVCentered)->addText(floatval($tot_qyt), null, array('spaceAfter' => 0, 'align' => 'center'));
            $table->addCell('', $cellVCentered)->addText('', null, array('spaceAfter' => 0));
            $table->addCell('', $cellVCentered)->addText('', null, array('spaceAfter' => 0, 'align' => 'right'));
            $table->addCell('', $cellVCentered)->addText(number_format($original_total, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
            $table->addRow();
            $cellColSpan = array('gridSpan' => 8, 'valign' => 'center');
            $table->addCell(200, $cellColSpan)->addText('Pembulatan ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $potongan_jasa = ($dataContent['am_jasa']);
            $total = $total - $potongan_jasa;
            // echo number_format($potongan_jasa, 0, ',', '.');
            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('Biaya Jasa ' . floatval($dataContent['percent_jasa']) . '%    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($potongan_jasa, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));

            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('Sub Total II    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));

            $total_kwitansi = $total;
            $potongan_pph = ($dataContent['am_pph']);
            $total = $total - $potongan_pph;

            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('PPH 23  ' . floatval($dataContent['percent_pph']) . '%    ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($potongan_pph, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));


            if ((float)$dataContent['par_am'] > 0) {
                $table->addRow();
                $table->addCell(200, $cellColSpan)->addText($dataContent['par_label'], 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
                if (stripos(strtolower($dataContent['par_label']), 'lebih') !== false) {
                    $total = $total - $dataContent['par_am'];
                    $par_am = -$dataContent['par_am'];
                } else {
                    $total = $total + $dataContent['par_am'];
                    $par_am = $dataContent['par_am'];
                }
                $table->addCell(500, $cellVCentered)->addText('' . number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph_bold', array('align' => 'left', 'spaceAfter' => 0));
            } else {
                $par_am = 0;
            }

            $table->addRow();
            $table->addCell(200, $cellColSpan)->addText('TOTAL FINAL   ', 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $table->addCell(500, $cellVCentered)->addText('' . number_format($total, '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            $terbilang =  floor($total);
            $kw_terbilang =  floor($total_kwitansi);
        }
        $section->addTextBreak();
        $textrun = $section->addTextRun();
        $textrun->addText("Terbilang : ", 'paragraph');
        $textrun->addText($this->terbilang($terbilang) . ' Rupiah', 'paragraph_bold');


        $section->addTextBreak(1);
        // $section->addText("Pangkalpinang, " . $tanggal, 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        // $section->addTextBreak(2);

        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 2,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1000,
            'marginBottom' => 1000,
        ]);
        $section->addText($dataContent['customer_name'] . ' :', 'paragraph_bold_underline', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText('(                                       )', '', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText('Mitra Usaha :', 'paragraph_bold_underline', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText('( Setiawan Rahardjo )', '', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 1,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1000,
            'marginBottom' => 1000,
        ]);
        // $section->addTextBreak();

        $section->addPageBreak();
        $section->addText("Perhitungan Pembayaran Pekerjaan Penataan Lahan PT Indometal Asia", 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        $section->addText(($dataContent['description']), 'paragraph_bold', array('spaceAfter' => 100, 'align' => 'center'));
        // $section->addPageBreak();
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'e1e3e1');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');

        $table = $section->addTable($spanTableStyleName);
        $fancyTableCellStyle = array('valign' => 'center');
        $table->addRow();
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Keterangan', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Tahun', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Kegiatan', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Nilai', 'paragraph_bold', array('spaceAfter' => 0));
        // new    $cell1 = $table->addCell(3000, $cellRowSpan);
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Nilai Termin Realisasi (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $cell1 = $table->addCell(3000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Nilai yang Harus Dibayar (Rp)', 'paragraph_bold', array('spaceAfter' => 0));
        $table->addRow();
        $table->addCell(3000, array('borderColor' => 'ffffff', 'borderBottomSize' => '11', 'valign' => 'center'))->addText($dataContent['description'], null, array('spaceAfter' => 0));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderBottomSize' => '11', 'valign' => 'center'))->addText(explode('-', $dataContent['date'])[0], null, array('spaceAfter' => 0, 'align' => 'center'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderBottomSize' => '11', 'valign' => 'center'))->addText('Pemeliharaan', null, array('spaceAfter' => 0, 'align' => 'center'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderBottomSize' => '11', 'valign' => 'center'))->addText(floatval($dataContent['percent_jasa']) . '%    ', null, array('spaceAfter' => 0, 'align' => 'center'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderBottomSize' => '11', 'valign' => 'center'))->addText(number_format($pembulatan, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderBottomSize' => '11', 'valign' => 'center'))->addText(number_format($potongan_jasa, 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
        $table->addRow();
        $table->addCell(3000, array('borderColor' => 'ffffff', 'borderTopSize' => '11', 'valign' => 'center'))->addText("", null, array('spaceAfter' => 0));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderTopSize' => '11', 'valign' => 'center'))->addText('', null, array('spaceAfter' => 0, 'align' => 'center'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderTopSize' => '11', 'valign' => 'center'))->addText('', null, array('spaceAfter' => 0, 'align' => 'center'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderTopSize' => '11', 'valign' => 'center'))->addText('', null, array('spaceAfter' => 0, 'align' => 'center'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderTopSize' => '11', 'valign' => 'center'))->addText('', null, array('spaceAfter' => 0, 'align' => 'right'));
        $table->addCell('', array('borderColor' => 'ffffff', 'borderTopSize' => '11', 'valign' => 'center'))->addText(number_format($pembulatan - $potongan_jasa, 2, ',', '.'), 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'right'));
        $table->addRow();
        $cell2 = $table->addCell('', array('gridSpan' => 5, 'valign' => 'center', 'align' => 'left', 'borderColor' => 'ffffff', 'borderBottomSize' => '11'));
        $textrun2 = $cell2->addTextRun();
        $textrun2->addText('Total % = Rp     |     ' . number_format($pembulatan, 2, ',', '.'), null, array('spaceAfter' => 0));
        $textrun2->addText('<w:br/>Luas = ', null, array('spaceAfter' => 0));
        $table->addCell('', array('valign' => 'center', 'align' => 'right', 'borderColor' => 'ffffff', 'borderBottomSize' => '11'));
        $table->addRow();
        $cell2 = $table->addCell('', array('gridSpan' => 5, 'valign' => 'center', 'align' => 'left', 'borderColor' => 'ffffff', 'borderBottomSize' => '11'));
        $textrun2 = $cell2->addTextRun();
        $textrun2->addText('CATATAN :', 'paragraph_bold', array('spaceAfter' => 0));
        // $textrun2->addText('<w:br/>Luas = ', null, array('spaceAfter' => 0));
        $table->addCell('', array('valign' => 'center', 'align' => 'right', 'borderColor' => 'ffffff', 'borderBottomSize' => '11'));
        $table->addRow();
        $cell2 = $table->addCell('', array('gridSpan' => 5, 'valign' => 'center', 'align' => 'left'));
        $textrun2 = $cell2->addTextRun();
        $textrun2->addText('Potongan PPh Pasal 23   ' . $dataContent['percent_pph'] . '% x ' . number_format($pembulatan - $potongan_jasa, 2, ',', '.'), null, array('spaceAfter' => 0));
        // $textrun2->addText('CATATAN :', null, array('spaceAfter' => 0));
        // $textrun2->addText('<w:br/>Luas = ', null, array('spaceAfter' => 0));
        $cell2 = $table->addCell('', array('valign' => 'center', 'align' => 'right'))->addText(number_format($dataContent['am_pph'], 2, ',', '.'), null, array('spaceAfter' => 0, 'align' => 'right'));
        $table->addRow();
        $cell2 = $table->addCell('', array('gridSpan' => 5, 'valign' => 'center', 'align' => 'left'));
        $textrun2 = $cell2->addTextRun();
        $textrun2->addText('JUMLAH DIBAYAR', 'paragraph_bold', array('spaceAfter' => 0));
        // $textrun2->addText('CATATAN :', null, array('spaceAfter' => 0));
        // $textrun2->addText('<w:br/>Luas = ', null, array('spaceAfter' => 0));
        $cell2 = $table->addCell('', array('valign' => 'center', 'align' => 'right'))->addText(number_format($total, 2, ',', '.'), 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'right'));
        // $textrun2 = $cell2->addTextRun();
        // $textrun2->addText('', null, array('spaceAfter' => 0));
        // $table->addRow();
        // $cell2 = $table->addCell('', array('gridSpan' => 5, 'valign' => 'center', 'align' => 'left', 'borderColor' => 'ffffff', 'borderBottomSize' => '11'));
        // $textrun2 = $cell2->addTextRun();
        // $cell2->addText('<w:br/>CATATAN : ', 'paragraph_bold', array('spaceAfter' => 0));
        // $cell2 = $table->addCell('', array('gridSpan' => 5, 'valign' => 'center', 'align' => 'right', 'borderColor' => 'ffffff', 'borderBottomSize' => '11'));
        // $table->addRow();


        $section->addTextBreak(1);
        // $section->addText("Pangkalpinang, " . $tanggal, 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'center', 'indentation' => array('left' => 1000, 'right' => 0)));
        // $section->addTextBreak(2);

        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 2,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1000,
            'marginBottom' => 1000,
        ]);
        $section->addText('Mengetahui', '', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText('Ka.Usaha  Barang/Jasa', 'paragraph_bold', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addTextBreak(2);
        $section->addText('A SISWANTO', 'paragraph_bold', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText('Pangkalpinang, ' . $this->tanggal_indo($dataContent['date']), '', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addText('Ka.Akuntansi', 'paragraph_bold', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section->addTextBreak(2);
        $section->addText('SONDANG BM', 'paragraph_bold', array('spaceAfter' => 0, 'indentation' => array('left' => 1000, 'right' => 0)));
        $section = $phpWord->addSection([
            'breakType' => 'continuous', 'colsNum' => 1,
            'pageSizeW' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(11.7),
            'pageSizeH' =>
            \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.4),
            'marginLeft' => 1500, 'marginRight' => 1000,
            'marginTop' => 1000,
            'marginBottom' => 1000,
        ]);
        // $section->addTextBreak();

        $section->addPageBreak();

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 2, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 20);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $homekwintansi = $table->addRow()->addCell();

        // end new
        // $section->addText("KWITANSIsaddddddddddd", 'paragraph_bold', array('align' => 'center'));
        $fancyTableStyle = array('height' => 300, 'borderSize' => 1, 'borderColor' => 'ffffff', 'width' => 6000, 'cellMargin' => 10, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $cellVCentered = array('borderColor' => '000000', 'borderSize' => '12', 'valign' => 'top', 'spaceAfter' => 2);
        $spanTableStyleName = 'Freame Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);

        $freame = $homekwintansi->addTable($spanTableStyleName);
        $freame->addRow(1000);
        $freame2 = $freame->addCell(12000, array('valign' => 'top', 'borderBottomColor' => 'ffffff', 'borderBottomSize' => '6', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));

        $freame2->addImage(
            base_url('assets/img/ima-transparent2.png'),
            array(
                'height'           => round(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.3)),
                'positioning'      => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                'marginLeft'       => round(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(0.5)),
                'marginTop'        => round(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(0.1)),
            )
        );
        $freame->addRow();
        $freame3 = $freame->addCell(12000, array('valign' => 'top', 'borderBottomColor' => 'ffffff', 'borderBottomSize' => '6', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));


        $freame3->addText("KWITANSI", array('name' => 'Times New Roman', 'size' => 13, 'color' => '000000', 'bold' => true), array('align' => 'center'));
        $fancyTableStyle = array('height' => 300, 'cellMargin' => 40, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $cellVCentered = array('borderColor' => '#ffffff', 'borderSize' => '6', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);

        $freame->addRow();
        $freame4 = $freame->addCell(10000, array('valign' => 'top', 'borderBottomColor' => 'ffffff', 'borderBottomSize' => '6', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
        $freame5 = $freame4->addTable($spanTableStyleName);

        $freame5->addRow();
        $freame5->addCell(100, $cellVCentered)->addText('', 'paragraph', array('spaceAfter' => 0));

        $freame5->addCell(2000, $cellVCentered)->addText('Sudah terima dari', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(1, $cellVCentered)->addText(':', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(7000, $cellVCentered)->addText('PT INDOMETAL ASIA', 'paragraph_bold', array('spaceAfter' => 0));

        $freame5->addRow();
        $freame5->addCell(100, $cellVCentered)->addText('', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(2000, $cellVCentered)->addText('Sejumlah', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(1, $cellVCentered)->addText(':', 'paragraph', array('spaceAfter' => 0));
        $freame5->addCell(7000, $cellVCentered)->addText($this->terbilang($kw_terbilang + $par_am) . ' Rupiah', 'paragraph_italic', array('spaceAfter' => 0));

        $freame5->addRow();
        $freame5->addCell(100, $cellVCentered)->addText('', 'paragraph', array('spaceAfter' => 3));
        $freame5->addCell(2000, $cellVCentered)->addText('Untuk Pembayaran', 'paragraph', array('spaceAfter' => 3));
        $freame5->addCell(1, $cellVCentered)->addText(':', 'paragraph', array('spaceAfter' => 3));
        $freame5->addCell(8000, $cellVCentered)->addText($dataContent['description'], 'paragraph', array('spaceAfter' => 3));

        $fancyTableStyle = array('leftFromText' => 0, 'height' => 300, 'marginRight' => 4000, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'indentation' => 3000);
        $cellVCentered = array('borderColor' => 'ffffff', 'borderSize' => '6', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
        $spanTableStyleName = 'Price';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $freame->addRow();
        $freame6 = $freame->addCell(10000, array('valign' => 'top', 'height' => 200, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
        $freame7 = $freame6->addTable($spanTableStyleName);
        // $kw_total = 0;
        // $count_row = count($dataContent['item']);
        // $i = 1;
        // if ((float) $dataContent['par_am'] > 0) {
        //     $freame7->addRow();
        //     $freame7->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        //     $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        //     $freame7->addCell(3400, $cellVCentered)->addText($dataContent['par_label'], 'paragraph', array('spaceAfter' => 0));
        //     $freame7->addCell(30, $cellVCentered)->addText('Rp', 'paragraph', array('spaceAfter' => 0));
        //     if (stripos(strtolower($dataContent['par_label']), 'lebih') !== false) {
        //         $freame7->addCell(1600, $cellVCentered)->addText(number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
        //         $total = $total - $dataContent['par_am'];
        //     } else {
        //         $total = $total + $dataContent['par_am'];
        //         $table->addCell(500, $cellVCentered)->addText('' . number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
        //     }
        //     $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        // }

        // foreach ($dataContent['item'] as $item) {

        //     $freame7->addRow();
        //     $current_data = ($item->amount * $item->qyt);
        //     $current_jasa = ceil($dataContent['percent_jasa'] / 100 * $current_data);
        //     // $current_pph = ($dataContent['percent_pph'] / 100 * ($current_data - $current_jasa));
        //     $current_total = $current_data - $current_jasa;
        //     $kw_total = $kw_total + $current_total;

        //     if ($i == $count_row) {
        //         // $current_total = 0;
        //         $freame7->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        //         $freame7->addCell(60, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('', null, array('spaceAfter' => 0));
        //         $freame7->addCell(3400, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText($item->date_item, 'paragraph', array('spaceAfter' => 0));
        //         $freame7->addCell(30, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('Rp', 'paragraph', array('spaceAfter' => 0));
        //         if (number_format($kw_total, '0', ',', '.') != number_format($total_kwitansi, '0', ',', '.'))
        //             $freame7->addCell(1600, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('manual', 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
        //         else
        //             $freame7->addCell(1600, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText(number_format($current_total, '0', ',', '.'), 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
        //         $freame7->addCell(60, array('borderColor' => '000000', 'borderBottomSize' => '11', 'valign' => 'top', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)))->addText('', null, array('spaceAfter' => 0));
        //     } else {
        //         $freame7->addCell(3000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        //         $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        //         $freame7->addCell(3400, $cellVCentered)->addText($item->nopol ? $item->nopol : $item->description, 'paragraph', array('spaceAfter' => 0));
        //         $freame7->addCell(30, $cellVCentered)->addText('Rp', 'paragraph', array('spaceAfter' => 0));
        //         $freame7->addCell(1600, $cellVCentered)->addText(number_format($current_total, '0', ',', '.'), 'paragraph', array('spaceAfter' => 0, 'align' => 'right',));
        //         $freame7->addCell(60, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        //     }
        //     $i++;
        // }
        // $freame7->addRow();
        // $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        // $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        // $freame7->addCell(1400, $cellVCentered)->addText('TOTAL', 'paragraph_bold', array('spaceAfter' => 0));
        // $freame7->addCell(30, $cellVCentered)->addText('Rp', 'paragraph_bold', array('spaceAfter' => 0));
        // $freame7->addCell(1600, $cellVCentered)->addText(number_format($total_kwitansi + $par_am, '0', ',', '.'), 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'right',));
        // $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 1));
        // $freame7->addRow(0.1);
        // $freame7->addCell(6000)->addText(' ', array('name' => 'Times New Roman', 'size' => 2, 'color' => '000000', 'bold' => true), array('align' => 'center', 'spaceAfter' => -1));

        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText('Pangkalpinang, ' . $this->tanggal_indo($dataContent['date']), 'paragraph', array('align' => 'center', 'spaceAfter' => -1));

        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText('', 'paragraph', array('spaceAfter' => 0));

        $freame7->addRow(700);
        $freame7->addCell(6000, $cellVCentered)->addText('          Rp. ' . number_format($total_kwitansi, '0', ',', '.'), array('name' => 'Times New Roman', 'size' => 15, 'color' => '000000', 'bold' => true), array('align' => 'left'));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText('', 'paragraph', array('spaceAfter' => 0));

        $freame7->addRow();
        $freame7->addCell(6000, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(30, $cellVCentered)->addText('', null, array('spaceAfter' => 0));
        $freame7->addCell(3060, array('gridSpan' => 4, 'valign' => 'center'))->addText($dataContent['customer_name'], 'paragraph_bold_underline', array('align' => 'center', 'spaceAfter' => -1));
        // if ($dataContent['id'] == 57) {
        // 	echo json_encode($dataContent);
        // } else {
        $writer = new Word2007($phpWord);
        $filename = 'PMT_' . $dataContent['id'];
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        // }
    }

    public function show($pembayaran_no)
    {
        $data['title'] = 'Invoice';
        $collection = array();

        // DEFINES TO LOAD THE MODEL
        $this->load->model('InvoiceModel');
        if ($pembayaran_no != NULL) {
            // $data['payment_metode'] = $this->General_model->getAllRefAccount(array('ref_id' =>  $data['transaction']['payment_metode']));
            $data['transaction'] = $this->Payment_model->getAllPembayaranWithItem(array('id' =>  $pembayaran_no));
            if (empty($data['transaction'])) {
                $data['main_view'] = 'error-5';
                $data['message'] = 'Sepertinya data yang anda cari tidak ditemukan atau sudah di hapus.';
            } else {
                $data['transaction'] = $data['transaction'][$pembayaran_no];
                $data['payment_metode'] = $this->General_model->getAllRefAccount(array('ref_id' => $data['transaction']['payment_metode']))[0];
                $data['customer_data'] = $this->General_model->getAllPayee(array('id' => $data['transaction']['customer_id']));
                // echo json_encode($data);
                // die();
                // $result = $result[0];

                // $data['dataContent'] = $result[0];
                $data['main_view'] = 'pembayaran/detail';
            }
            // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
            $this->load->view('main/index.php', $data);
            return;
        } else {
            echo 'NOT FOUND';
            return;
        }
    }


    //pembayaran/popup
    //DEFINES A POPUP MODEL OG GIVEN PARAMETER
    function popup($page_name = '', $param = '')
    {
        $this->load->model('Crud_model');
        if ($page_name  == 'new_row') {
            $this->load->model('Statement_model');
            // $data['accounts_records'] = $this->Statement_model->chart_list();
            $this->load->model('General_model');
            $data['satuan'] = $this->General_model->getAllUnit();
            $data['jenis_pembayaran'] = $this->General_model->getAllJenisPembayaran();

            $this->load->view('admin_models/accounts/new_row_pembayaran.php', $data);
        } else		if ($page_name  == 'add_patner_model') {
            //USED TO REDIRECT LINK
            $data['link'] = 'patners/add_patner';
            $this->load->view('admin_models/add_models/add_patner_model.php', $data);
        } else if ($page_name  == 'edit_pembayaran_model') {
            $this->load->model('Accounts_model');
            $data['pembayaran_data'] = $this->Accounts_model->get_by_id("mp_pembayarans", "mp_sales", $param);
            $this->load->view('admin_models/edit_models/edit_pembayaran_model.php', $data);
        } else if ($page_name  == 'add_customer_payment_pos_model') {
            $this->load->model('Accounts_model');

            $data['previous_amt'] = $this->Accounts_model->previous_balance($param);

            $data['cus_id'] = $param;

            $data['customer_list'] = $this->Crud_model->fetch_payee_record('customer', NULL);
            //DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
            $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');

            $this->load->view('admin_models/add_models/add_customer_payment_pos_model.php', $data);
        }
    }



    public function edit_pembayaran()
    {

        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');
        $this->load->model('Transaction_model');
        $edit_discount       = html_escape($this->input->post('edit_discount'));
        $edit_pembayaran_id  = html_escape($this->input->post('edit_pembayaran_id'));
        $edit_description = html_escape($this->input->post('edit_description'));
        $total_bill = html_escape($this->input->post('total_bill'));
        $amountpaid  = html_escape($this->input->post('amountpaid'));
        $user_name = $this->session->userdata('user_id');

        $data = array(
            'discount' => $edit_discount,
            'status' => 1,
            'agentname' =>  $user_name['name'],
            'description' =>  $edit_description,
            'total_bill' => $total_bill,
            'bill_paid' =>  $amountpaid
        );

        $result = $this->Transaction_model->edit_pembayaran_transaction($data, $edit_pembayaran_id);
        if ($result != NULL) {

            $product_quantity = html_escape($this->input->post('product_quantity'));

            $edit_product_id = html_escape($this->input->post('edit_product_id'));

            $edit_sales_id = html_escape($this->input->post('edit_sales_id'));

            // DEFINES TO CALCULATE THAT HOW MUCH THE LOOP SHOULD ITERATE
            $i = 0;
            while ($i < count($product_quantity)) {

                // GETTING THE VALUES FROM TEXTFIELD .THE ARRAYS OF VALUES WHICH WE CREATED
                // BY USING DOM
                // FETCHING THE SALES QTY FROM SALES TBLE THROUGH SALES ID
                $get_result = $this->Crud_model->fetch_record_by_id('mp_sales', $edit_sales_id[$i]);
                $get_med_quantity = $get_result[0]->qty;

                //RETURNED STOCK BY CUSTOMER
                $get_med_quantity = $get_med_quantity - $product_quantity[$i];

                // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
                $args1 = array(
                    'table_name' => 'mp_sales',
                    'id' => $edit_sales_id[$i]
                );
                $data1 = array(
                    'qty' => $product_quantity[$i]
                );

                // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
                $result = $this->Crud_model->edit_record_given_field('id', $args1, $data1);

                if ($get_med_quantity > 0) {

                    //UPDATING PARTS STOCK
                    $this->Crud_model->add_return_item_stock($edit_product_id[$i], $get_med_quantity);
                }
                $i++;
            }
        }

        if ($result != NULL) {

            $get_pembayaran_result = $this->Crud_model->fetch_record_by_id('mp_pembayarans', $edit_pembayaran_id);

            //ASSIGNING DATA TO ARRAY
            $data  = array(
                'pembayaran_id' => $edit_pembayaran_id,
                'discount' => $edit_discount,
                'description' => $edit_description,
                'date' => $get_pembayaran_result[0]->date,
                'status' => $get_pembayaran_result[0]->status,
                'agentname' => $user_name['name'],
                'cus_id' => $get_pembayaran_result[0]->cus_id,
                'total_bill' => $total_bill,
                'bill_paid' => $amountpaid,
                'cus_previous' => $this->return_previous_cus_balance($get_pembayaran_result[0]->cus_id)
            );

            //FETCHING UPDATED SALE TO PRINT
            $data['item_data']   =  $this->Crud_model->fetch_attr_record_by_id('mp_sales', 'order_id', $edit_pembayaran_id);

            //CUSTOMER NAME
            $result = $this->Crud_model->fetch_record_by_id('mp_payee', $get_pembayaran_result[0]->cus_id);
            $cus_name = $result[0]->customer_name;

            //COMPANY NAME
            $result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
            $company_name = $result[0]->companyname;

            //PRINTER NAME
            $result = $this->Crud_model->fetch_attr_record_by_id('mp_printer', 'set_default', 1);
            if ($result != NULL) {
                $printer_name = $result[0]->printer_name;
            } else {
                $printer_name = '';
            }

            //ADDRESS 
            $result = $this->Crud_model->fetch_record_by_id('mp_contactabout', 1);
            $address = $result[0]->address;
            /* Hapus Tanda ini jika aplikasi sudah terkoneksi dengan printer Thermal
			if($printer_name != '')
			{
				//BUSINESS AND OTHER INFO THAT MENTIONED ON THE TOP
				$general_info = array(
				'name' => $company_name ,
				'address' => $address,
				'receipt' => $data['pembayaran_id'],
				'date' => date('Y-m-d'),
				'customer' => $cus_name,
				'customer_id' => $customer_id,
				'served' => $agent,
				'thanks' => 'Terima kasih telah mengunjungi kami.',
				'about' => 'Developed by Rumah IT',
				'contact' => ' Kontak 083814305092',
				'printer_name' => $printer_name,
				'text_size' => 1,
				'discount' => $discountfield
				);


			    $this->load->library('printer');
			    $printer_result = $this->printer->generate_print($general_info,$data);
			}
		
			if($printer_result != 'success')
			{
				$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Faktur yang diedit berhasil tetapi tidak ada printer yang dikurangkan',
				'alert' => 'info'
				);
			}
			else
			{
				$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Invoice editted',
				'alert' => 'info'
				);
			}
			*/

            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Invoice editted',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        } else {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error pembayaran cannot be Editted',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }

        redirect('pembayaran/manage/');
    }


    function create_pembayaran()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();
            // echo json_encode($data);
            // die();
            if (empty($data['manual_math'])) {
                $data['manual_math'] = 'off';
            }
            if ($data['manual_math'] == 'on') {
                $data['manual_math'] = 1;
            } else {
                $data['manual_math'] = 0;
            }
            // $data['am_pph'] = preg_replace("/[^0-9]/", "", $data['am_pph']);
            $data['am_pph'] = substr(preg_replace("/[^0-9]/", "", $data['am_pph']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_pph']), -2);
            $data['am_jasa'] = substr(preg_replace("/[^0-9]/", "", $data['am_jasa']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_jasa']), -2);
            $data['lebih_bayar_am'] = substr(preg_replace("/[^0-9]/", "", $data['lebih_bayar_am']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['lebih_bayar_am']), -2);
            $data['kurang_bayar_am'] = substr(preg_replace("/[^0-9]/", "", $data['kurang_bayar_am']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['kurang_bayar_am']), -2);
            $data['total_final'] = substr(preg_replace("/[^0-9]/", "", $data['total_final']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['total_final']), -2);
            $data['sub_total'] = substr(preg_replace("/[^0-9]/", "", $data['sub_total']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['sub_total']), -2);
            $data['sub_total_2'] = substr(preg_replace("/[^0-9]/", "", $data['sub_total_2']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['sub_total_2']), -2);
            $data['payed'] = substr(preg_replace("/[^0-9]/", "", $data['payed']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['payed']), -2);
            if (!empty($data['pembulatan'])) $data['pembulatan'] = substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), -2);

            $count_rows = count($data['amount']);
            // if()
            if (empty($data['ppn_pph'])) {
                $data['ppn_pph'] = '0';
            } else {
                $data['ppn_pph'] = '1';
            }

            if (empty($data['date'])) {
                $data['date'] = date('Y-m-d');
            }

            for ($i = 0; $i < $count_rows; $i++) {
                if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                    $status = TRUE;
                $data['amount'][$i] = preg_replace("/[^0-9]/", "", $data['amount'][$i]);
            }

            if ($status) {
                $this->load->model('Transaction_model');
                $this->load->model('Crud_model');
                $jp = $this->General_model->getAllJenisInvoice(array('by_id' => true, 'id' => $data['jenis_pembayaran']))[$data['jenis_pembayaran']];
                $data['data_jenis_pembayaran'] = $jp;
                $jp = $this->General_model->getAllRefAccount(array('by_id' => true, 'ref_id' => $data['payment_method']))[$data['payment_method']];
                $data['data_payment'] = $jp;
                $data['generalentry'] = array(
                    'date' => $data['date'],
                    'naration' => $data['data_jenis_pembayaran']['ref_nojur_pembayaran'] . ' ' . $data['description'],
                    'customer_id' => $data['customer_id'],
                    'no_jurnal' => $this->General_model->gen_numberABC($data['date'], $data['data_jenis_pembayaran']['ref_nojur_pembayaran'], 'PEMBAYARAN'),
                    'generated_source' => 'Pembayaran'
                );

                $i = 0;

                $sisa_pembayaran = $data['sub_total_2'] - $data['payed'];
                // $sisa_pembayaran = $data['sub_total_2'] - $data['payed'];
                if ($sisa_pembayaran > 0) {
                    $data['status_pembayaran'] = 'unpaid';
                } else {
                    $data['status_pembayaran'] = 'paid';
                }
                if ($data['payed'] == $data['sub_total_2']) {
                    $data['sub_entry'][$i] = array(
                        'accounthead' =>   $data['data_jenis_pembayaran']['ac_expense'],
                        'type' => 0,
                        'amount' => $data['payed'],
                        'sub_keterangan' => "Htg " . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                    );
                    $i++;
                }

                if ($data['payed'] > $data['sub_total_2']) {
                    $data['total_final'] = $data['total_final'] + $data['payed'] - $data['sub_total_2'];
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $data['data_jenis_pembayaran']['ac_piutang'],
                        'type' => 0,
                        'amount' => $data['payed'] - $data['sub_total_2'],
                        'sub_keterangan' => "Piut Htg " . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                    );
                    $i++;
                    // if ($data['payed'] > 0) {
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $$data['data_jenis_pembayaran']['ac_expense'],
                        'type' => 0,
                        'amount' => $data['sub_total_2'],
                        'sub_keterangan' => "Htg " . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                    );
                    $i++;
                    // }
                }

                if ($data['payed'] < $data['sub_total_2']) {
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $data['data_jenis_pembayaran']['ac_hutang'],
                        'type' => 0,
                        'amount' => $data['sub_total_2'] - $data['payed'],
                        'sub_keterangan' => "Htg " . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                    );
                    $i++;
                    if ($data['payed'] > 0) {
                        $data['sub_entry'][$i] = array(
                            'accounthead' => $data['data_jenis_pembayaran']['ac_expense'],
                            'type' => 0,
                            'amount' => $data['payed'],
                            'sub_keterangan' => "Htg " . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                        );
                        $i++;
                    }
                }

                if (!empty($data['am_pph'])) {
                    $jp = $this->General_model->getAllRefAccount(array('ref_type' => 'pph_23'))[0];
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $jp['ref_account'],
                        'type' => 1,
                        'sub_keterangan' => 'Ptg PPh 23' . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                        'amount' => $data['am_pph']
                    );
                    $i++;
                }

                if (!empty($data['lebih_bayar_am'])) {
                    if ((float)$data['lebih_bayar_am'] > 0) {
                        if (empty($data['lebih_bayar_ac']))
                            throw new UserException('Akun Lebih Bayar Harus diisi !!');
                        else
                            $data['sub_entry'][$i] = array(
                                'accounthead' => $data['lebih_bayar_ac'],
                                'type' => 1,
                                'sub_keterangan' => (!empty($data['lebih_bayar_ket']) ? $data['lebih_bayar_ket'] . ' ' : '')  . $data['description'],
                                'amount' => $data['lebih_bayar_am']
                            );
                        $i++;
                    } else {
                        $data['lebih_bayar_ac'] = '';
                    }
                } else {
                    $data['lebih_bayar_ac'] = '';
                }
                if (!empty($data['kurang_bayar_am'])) {
                    if ((float)$data['kurang_bayar_am'] > 0) {
                        if (empty($data['kurang_bayar_ac']))
                            throw new UserException('Akun Kurang Bayar Harus diisi !!');
                        else
                            $data['sub_entry'][$i] = array(
                                'accounthead' => $data['kurang_bayar_ac'],
                                'type' => 0,
                                'sub_keterangan' => (!empty($data['kurang_bayar_ket']) ? $data['kurang_bayar_ket'] . ' ' : '')  . $data['description'],
                                'amount' => $data['kurang_bayar_am']
                            );
                        $i++;
                    } else {
                        $data['kurang_bayar_ac'] = '';
                    }
                } else {
                    $data['kurang_bayar_ac'] = '';
                }

                $data['sub_entry'][$i] = array(
                    'accounthead' => $data['data_payment']['ref_account'] . ' ',
                    'type' => 1,
                    'sub_keterangan' => 'Htg ' . $data['data_jenis_pembayaran']['text_jurnal'] . ' ' . $data['description'],
                    'amount' => $data['total_final']
                );
                $i++;

                $result = $this->Payment_model->pembayaran_entry($data);
                // echo json_encode($data);
                // die();

                // die();
                if ($result != NULL) {
                    // $this->Crud_model->insert_data('notification', array('notification_url' => 'pembayaran/show/' . $result['order_id'], 'parent_id' => $result['order_id'], 'parent2_id' => $result['parent2_id'], 'to_role' => '23', 'status' => 1, 'deskripsi' => 'Pembayaran Mitra', 'agent_name' => $this->session->userdata('user_id')['name']));
                } else {
                    throw new UserException('Please check data!');
                }
            } else {
                throw new UserException('Please check data!');
            }
            echo json_encode(array('error' => false, 'data' => $result['order_id']));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
        // redirect('pembayaran');
    }

    function edit_process_pembayaran()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();
            // echo json_encode($data);
            // die();
            if (empty($data['manual_math'])) {
                $data['manual_math'] = 'off';
            }
            if ($data['manual_math'] == 'on') {
                $data['manual_math'] = 1;
            } else {
                $data['manual_math'] = 0;
            }
            // $data['am_pph'] = preg_replace("/[^0-9]/", "", $data['am_pph']);
            $data['am_pph'] = substr(preg_replace("/[^0-9]/", "", $data['am_pph']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_pph']), -2);
            $data['am_jasa'] = substr(preg_replace("/[^0-9]/", "", $data['am_jasa']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['am_jasa']), -2);
            $data['lebih_bayar_am'] = substr(preg_replace("/[^0-9]/", "", $data['lebih_bayar_am']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['lebih_bayar_am']), -2);
            $data['kurang_bayar_am'] = substr(preg_replace("/[^0-9]/", "", $data['kurang_bayar_am']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['kurang_bayar_am']), -2);
            $data['total_final'] = substr(preg_replace("/[^0-9]/", "", $data['total_final']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['total_final']), -2);
            $data['sub_total'] = substr(preg_replace("/[^0-9]/", "", $data['sub_total']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['sub_total']), -2);
            $data['sub_total_2'] = substr(preg_replace("/[^0-9]/", "", $data['sub_total_2']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['sub_total_2']), -2);
            $data['payed'] = substr(preg_replace("/[^0-9]/", "", $data['payed']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['payed']), -2);
            if (!empty($data['pembulatan'])) $data['pembulatan'] = substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['pembulatan']), -2);

            $count_rows = count($data['amount']);
            // if()
            if (empty($data['ppn_pph'])) {
                $data['ppn_pph'] = '0';
            } else {
                $data['ppn_pph'] = '1';
            }

            if (empty($data['date'])) {
                $data['date'] = date('Y-m-d');
            }

            for ($i = 0; $i < $count_rows; $i++) {
                if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                    $status = TRUE;
                $data['amount'][$i] = preg_replace("/[^0-9]/", "", $data['amount'][$i]);
            }

            if ($status) {
                $this->load->model('Transaction_model');
                $this->load->model('Crud_model');
                $data['generalentry']['no_jurnal'] = $this->General_model->gen_number($data['date'], 'AK');
                $data['generalentry'] = array(
                    'date' => $data['date'],
                    'naration' => $data['description'],
                    'customer_id' => $data['customer_id'],
                    'generated_source' => 'Pembayaran'
                );

                $i = 0;
                $jp = $this->General_model->getAllJenisPembayaran(array('by_id' => true, 'id' => $data['jenis_pembayaran']))[$data['jenis_pembayaran']];
                $sisa_pembayaran = $data['sub_total_2'] - $data['payed'];
                if ($sisa_pembayaran > 0) {
                    $data['status_pembayaran'] = 'unpaid';
                } else {
                    $data['status_pembayaran'] = 'paid';
                }
                if ($data['payed'] == $data['sub_total_2']) {
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $jp['ac_paid'],
                        'type' => $jp['ac_paid_type'],
                        'amount' => $data['payed'],
                        'sub_keterangan' => "Htg " . $data['description'],
                    );
                    $i++;
                }

                if ($data['payed'] > $data['sub_total_2']) {
                    $data['total_final'] = $data['total_final'] + $data['payed'] - $data['sub_total_2'];
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $jp['ac_piutang'],
                        'type' => $jp['ac_piutang_type'],
                        'amount' => $data['payed'] - $data['sub_total_2'],
                        'sub_keterangan' => "Piut Htg " . $data['description'],
                    );
                    $i++;
                    if ($data['payed'] > 0) {
                        $data['sub_entry'][$i] = array(
                            'accounthead' => $jp['ac_paid'],
                            'type' => $jp['ac_paid_type'],
                            'amount' => $data['sub_total_2'],
                            'sub_keterangan' => "Htg " . $data['description'],
                        );
                        $i++;
                    }
                }

                if ($data['payed'] < $data['sub_total_2']) {
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $jp['ac_unpaid'],
                        'type' => $jp['ac_unpaid_type'],
                        'amount' => $data['sub_total_2'] - $data['payed'],
                        'sub_keterangan' => "Htg " . $data['description'],
                    );
                    $i++;
                    if ($data['payed'] > 0) {
                        $data['sub_entry'][$i] = array(
                            'accounthead' => $jp['ac_paid'],
                            'type' => $jp['ac_paid_type'],
                            'amount' => $data['payed'],
                            'sub_keterangan' => "Htg " . $data['description'],
                        );
                        $i++;
                    }
                }

                if (!empty($data['am_pph'])) {
                    $jp = $this->General_model->getAllRefAccount(array('ref_type' => 'pph_23'))[0];
                    $data['sub_entry'][$i] = array(
                        'accounthead' => $jp['ref_account'],
                        'type' => 1,
                        'sub_keterangan' => 'Ptg ' . $data['description'],
                        'amount' => $data['am_pph']
                    );
                    $i++;
                }

                if (!empty($data['lebih_bayar_am'])) {
                    if ((float)$data['lebih_bayar_am'] > 0) {
                        if (empty($data['lebih_bayar_ac']))
                            throw new UserException('Akun Lebih Bayar Harus diisi !!');
                        else
                            $data['sub_entry'][$i] = array(
                                'accounthead' => $data['lebih_bayar_ac'],
                                'type' => 1,
                                'sub_keterangan' => (!empty($data['lebih_bayar_ket']) ? $data['lebih_bayar_ket'] . ' ' : '')  . $data['description'],
                                'amount' => $data['lebih_bayar_am']
                            );
                        $i++;
                    } else {
                        $data['lebih_bayar_ac'] = '';
                    }
                } else {
                    $data['lebih_bayar_ac'] = '';
                }
                if (!empty($data['kurang_bayar_am'])) {
                    if ((float)$data['kurang_bayar_am'] > 0) {
                        if (empty($data['kurang_bayar_ac']))
                            throw new UserException('Akun Kurang Bayar Harus diisi !!');
                        else
                            $data['sub_entry'][$i] = array(
                                'accounthead' => $data['kurang_bayar_ac'],
                                'type' => 0,
                                'sub_keterangan' => (!empty($data['kurang_bayar_ket']) ? $data['kurang_bayar_ket'] . ' ' : '')  . $data['description'],
                                'amount' => $data['kurang_bayar_am']
                            );
                        $i++;
                    } else {
                        $data['kurang_bayar_ac'] = '';
                    }
                } else {
                    $data['kurang_bayar_ac'] = '';
                }
                $jp = $this->General_model->getAllRefAccount(array('by_id' => true, 'ref_id' => $data['payment_method']))[$data['payment_method']];
                $data['sub_entry'][$i] = array(
                    'accounthead' => $jp['ref_account'],
                    'type' => 1,
                    'sub_keterangan' => 'Htg ' . $data['description'],
                    'amount' => $data['total_final']
                );
                $i++;


                $data['old_data'] = $this->Payment_model->getAllPembayaran(array('id' => $data['id'], 'by_id' => true))[$data['id']];
                $result = $this->Payment_model->pembayaran_edit($data);
            } else {
                throw new UserException('Please check data!');
            }
            echo json_encode(array('error' => false, 'data' => $data['id']));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
        // redirect('pembayaran');
    }

    function edit_process_pembayaranold()
    {
        $status = FALSE;
        $data = $this->input->post();
        // echo json_encode($data);
        // die();
        if (!empty($data['manual_math']))
            if ($data['manual_math'] == 'on') {
                if (empty($data['manual_math'])) {
                    $data['manual_math'] = 'off';
                }
                $data['manual_math'] = 1;
            } else {
                $data['manual_math'] = 0;
            }
        else
            $data['manual_math'] = 0;

        $data['am_pph'] = preg_replace("/[^0-9]/", "", $data['am_pph']);
        $data['am_jasa'] = preg_replace("/[^0-9]/", "", $data['am_jasa']);
        $data['par_am'] = preg_replace("/[^0-9]/", "", $data['par_am']);

        $data['lebih_bayar_am'] = preg_replace("/[^0-9]/", "", $data['lebih_bayar_am']);
        $data['kurang_bayar_am'] = preg_replace("/[^0-9]/", "", $data['kurang_bayar_am']);

        $count_rows = count($data['amount']);
        // if()
        $data['acc_role'] = $this->SecurityModel->MultiplerolesStatus('Akuntansi');
        if (empty($data['ppn_pph'])) {
            $data['ppn_pph'] = '0';
        } else {
            $data['ppn_pph'] = '1';
        }
        if (empty($data['date'])) {
            $data['date'] = date('Y-m-d');
        }
        for ($i = 0; $i < $count_rows; $i++) {
            if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                $status = TRUE;
            $data['amount'][$i] = preg_replace("/[^0-9]/", "", $data['amount'][$i]);
        }

        if ($status) {
            $this->load->model('Transaction_model');
            $result = $this->Transaction_model->pembayaran_edit($data);
            // die();
            if ($result != NULL) {
                $array_msg = array(
                    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
                    'alert' => 'info'
                );
                $this->session->set_flashdata('status', $array_msg);
                redirect('pembayaran/show/' . $result);
            } else {
                $array_msg = array(
                    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please check data',
                    'alert' => 'danger'
                );
                $this->session->set_flashdata('status', $array_msg);
                $this->index($data);
                return;
            }
        } else {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please check data',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
            $this->index($data);
            return;
            // redirect('statements/journal_voucher');
        }
        redirect('pembayaran');
    }


    function addPelunasan()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();
            // echo json_encode($data);
            $data['nominal'] = substr(preg_replace("/[^0-9]/", "", $data['nominal']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['nominal']), -2);
            if (empty($data['ppn_pph'])) {
                $data['ppn_pph'] = '0';
            } else {
                $data['ppn_pph'] = '1';
            }

            if (empty($data['date_pembayaran'])) {
                $data['date_pembayaran'] = date('Y-m-d');
            }

            $data['old_data'] = $this->Payment_model->getAllPembayaran(array('id' => $data['parent_id'], 'by_id' => true))[$data['parent_id']];
            $data['data_pelunasan'] = $this->Payment_model->getAllPelunasan(array('parent_id' => $data['parent_id']));
            $total_bayar = $data['old_data']['payed'];
            foreach ($data['data_pelunasan'] as $p) {
                $total_bayar = $total_bayar + $p['nominal'];
            }
            $data['total_bayar'] = $total_bayar;
            if ($total_bayar >= $data['old_data']['sub_total_2']) {
                throw new UserException('Data ini sudah lunas!');
            }
            if ($data['total_bayar'] + $data['nominal'] >= $data['old_data']['sub_total_2']) {
                $data['status_pembayaran'] = 'paid';
            } else {
                $data['status_pembayaran'] = 'unpaid';
            }
            $jp = $this->General_model->getAllJenisInvoice(array('by_id' => true, 'id' => $data['old_data']['jenis_pembayaran']))[$data['old_data']['jenis_pembayaran']];
            $data['gen_old'] = $this->Statement_model->getSingelJurnal(array('id' => $data['old_data']['general_id']))['parent'];
            $data['generalentry'] = array(
                'date' => $data['date_pembayaran'],
                // 'naration' => $data['old_data']['description'],
                'naration' => $data['old_data']['description'] . ' (' . $data['gen_old']->no_jurnal . ')',
                'customer_id' => $data['old_data']['customer_id'],
                'generated_source' => 'Pelunasan Pembayaran'
            );

            $data['generalentry']['no_jurnal'] = $this->General_model->gen_number($data['date_pembayaran'], $jp['ref_nojur_pel_pembayaran']);

            $data['sub_entry'][0] = array(
                'accounthead' => $jp['ac_expense'],
                'type' => 0,
                'amount' => $data['nominal'],
                'sub_keterangan' => "Htg " . (empty($jp['text_jurnal']) ?  '' : $jp['text_jurnal'] . ' ') . $data['old_data']['description'],
            );
            $data['sub_entry'][1] = array(
                'accounthead' => $jp['ac_hutang'],
                'type' => 1,
                'amount' => $data['nominal'],
                'sub_keterangan' => "Htg " . (empty($jp['text_jurnal']) ?  '' : $jp['text_jurnal'] . ' ') . $data['old_data']['description'],
            );


            $result = $this->Payment_model->add_pelunasan($data);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    function editPelunasan()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();
            // echo json_encode($data);
            $data['nominal'] = substr(preg_replace("/[^0-9]/", "", $data['nominal']), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['nominal']), -2);

            if (empty($data['date_pembayaran'])) {
                $data['date_pembayaran'] = date('Y-m-d');
            }

            $data['old_data'] = $this->Payment_model->getAllPembayaran(array('id' => $data['parent_id'], 'by_id' => true))[$data['parent_id']];
            $data['data_pelunasan'] = $this->Payment_model->getAllPelunasan(array('parent_id' => $data['parent_id']));
            $total_bayar = $data['old_data']['payed'];
            foreach ($data['data_pelunasan'] as $p) {
                if ($p['id'] != $data['id']) $total_bayar = $total_bayar + $p['nominal'];
                else {
                    $old_pelunasan = $p;
                }
            }
            $data['total_bayar'] = $total_bayar;
            if ($total_bayar >= $data['old_data']['sub_total_2']) {
                // throw new UserException('Data ini sudah lunas!');
            }
            if ($data['total_bayar'] + $data['nominal'] >= $data['old_data']['sub_total_2']) {
                $data['status_pembayaran'] = 'paid';
            } else {
                $data['status_pembayaran'] = 'unpaid';
            }
            $jp = $this->General_model->getAllJenisPembayaran(array('by_id' => true, 'id' => $data['old_data']['jenis_pembayaran']))[$data['old_data']['jenis_pembayaran']];
            $data['gen_old'] = $this->Statement_model->getSingelJurnal(array('id' => $data['old_data']['general_id']))['parent'];
            $data['generalentry'] = array(
                'id' => $old_pelunasan['general_id'],
                'date' => $data['date_pembayaran'],
                // 'naration' => $data['old_data']['description'],
                'naration' => $data['old_data']['description'] . ' (' . $data['gen_old']->no_jurnal . ')',
                'customer_id' => $data['old_data']['customer_id'],
                'generated_source' => 'Pelunasan Pembayaran'
            );

            // $data['generalentry']['no_jurnal'] = $this->General_model->gen_number($data['date_pembayaran'], 'JMB');

            $data['sub_entry'][0] = array(
                'accounthead' => $jp['ac_paid'],
                'type' => $jp['ac_paid_type'],
                'amount' => $data['nominal'],
                'sub_keterangan' => "Htg " . $data['old_data']['description'],
            );

            $data['sub_entry'][1] = array(
                'accounthead' => $jp['ac_unpaid'],
                'type' => ($jp['ac_unpaid_type'] == 0 ? 1 : 0),
                'amount' => $data['nominal'],
                'sub_keterangan' => "Htg " . $data['old_data']['description'],
            );

            $result = $this->Payment_model->edit_pelunasan($data);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    function deletePelunasan()
    {
        try {
            $status = FALSE;
            $data = $this->input->post();
            // echo json_encode($data);

            $data['self_data'] = $this->Payment_model->getAllPelunasan(array('id' => $data['id']))[0];
            $data['data_pelunasan'] = $this->Payment_model->getAllPelunasan(array('parent_id' => $data['self_data']['parent_id']));
            $data['old_data'] = $this->Payment_model->getAllPembayaran(array('id' => $data['self_data']['parent_id'], 'by_id' => true))[$data['self_data']['parent_id']];
            $total_bayar = $data['old_data']['payed'];
            foreach ($data['data_pelunasan'] as $p) {
                if ($p['id'] != $data['id']) $total_bayar = $total_bayar + $p['nominal'];
                else {
                    $old_pelunasan = $p;
                }
            }
            $data['total_bayar'] = $total_bayar;
            if ($total_bayar >= $data['old_data']['sub_total_2']) {
                // throw new UserException('Data ini sudah lunas!');
            }
            if ($data['total_bayar'] >= $data['old_data']['sub_total_2']) {
                $data['status_pembayaran'] = 'paid';
            } else {
                $data['status_pembayaran'] = 'unpaid';
            }

            $result = $this->Payment_model->delete_pelunasan($data);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function addQRCode($url, $id, $token)
    {
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = false; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '600'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $token . '_' . $id . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = 'https://apps.indometalasia.com/' . $url . $token . '/' . $id; //data yang akan di jadikan QR CODE
        $params['level'] = 'S'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }

    public function kwitansi_print()
    {
        $data = $this->input->get();
        // echo json_encode($data);
        // die();
        if (empty($data['date'])) $data['date'] = date('Y-m-d');
        $data['date'] = 'Pangkalpinang, ' . $this->tanggal_indonesia($data['date']);

        $data['terbilang'] = $this->terbilang((int)$data['nominal']) . ' Rupiah';
        $data['nominal'] = number_format((int)$data['nominal'], 0, ',', '.');
        $this->load->view('pembayaran/print_kwitansi.php', $data);
    }
}
