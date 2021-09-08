<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\Writer\Word2007;

class Pembayaran extends CI_Controller
{
    function index($data_return = NULL)
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
        $data['main_view'] = 'pembayaran/create';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
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

    function delete_item_temporary($item_id)
    {
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');

        //FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
        $result = $this->Crud_model->fetch_record_by_id('mp_temp_barcoder_pembayaran', $item_id);

        //FETCH THE ITEM FROM STOCK TABLE 
        $result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist', $result[0]->product_id);

        // TABLENAME AND ID FOR DATABASE Actions
        $args = array(
            'table_name' => 'mp_productslist',
            'id' => $result[0]->product_id
        );

        $data = array(
            'quantity' => $result_stock[0]->quantity + $result[0]->qty
        );

        // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
        $this->Crud_model->edit_record_id($args, $data);

        // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
        $this->Crud_model->delete_record('mp_temp_barcoder_pembayaran', $item_id);

        //USER ID
        $user_name = $this->session->userdata('user_id');

        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);

        $this->load->view('pembayaran_template.php', $data);
    }

    public function delete($id)
    {
        try {
            $this->load->model(array('SecurityModel', 'InvoiceModel'));
            $this->SecurityModel->MultiplerolesStatus(array('Akuntansi', 'Invoice'), TRUE);
            $dataContent = $this->InvoiceModel->getAllPembayaran(array('id' =>  $id))[0];
            if ($dataContent['agen_id'] != $this->session->userdata('user_id')['id'])
                throw new UserException('Sorry, Yang dapat mengahapus dan edit hanya agen yang bersangkutan', UNAUTHORIZED_CODE);

            $this->InvoiceModel->delete_pembayaran($id);
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

    //pembayaran/clear_temp_pembayaran
    //USED TO CLEAR TEMP INVOICE
    function clear_temp_pembayaran()
    {
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');

        //GET THE CURRENT USER
        $user_name = $this->session->userdata('user_id');

        //FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
        $result = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);

        if ($result  != NULL) {

            foreach ($result as $single_item) {
                //FETCH THE ITEM FROM STOCK TABLE 
                $result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist', $single_item->product_id);

                // TABLENAME AND ID FOR DATABASE Actions
                $args = array(
                    'table_name' => 'mp_productslist',
                    'id' => $single_item->product_id
                );


                $data = array(
                    'quantity' => $result_stock[0]->quantity + $single_item->qty
                );

                // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
                $this->Crud_model->edit_record_id($args, $data);
            }

            $this->Crud_model->delete_record_by_userid('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);
        }

        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);

        $this->load->view('pembayaran_template.php', $data);
    }

    //pembayaran/add_barcode_item
    //USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
    function add_barcode_item($barcode)
    {
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');

        $user_name = $this->session->userdata('user_id');

        $result = $this->Crud_model->fetch_attr_record_by_id('mp_productslist', 'barcode', $barcode);
        if ($result != NULL) {

            $check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_pembayaran', 'barcode', $barcode, $user_name['id'], 'pos');

            if ($result[0]->quantity > 0) {
                $stockargs   = array(
                    'table_name' => 'mp_productslist',
                    'id' => $result[0]->id,
                );

                $stockdata = array(
                    'quantity' => $result[0]->quantity - 1
                );

                $this->Crud_model->edit_record_id($stockargs, $stockdata);

                if ($check_item_in_temp != NULL) {
                    $qty = '';

                    $qty = $check_item_in_temp[0]->qty + 1;

                    $args = array(
                        'table_name' => 'mp_temp_barcoder_pembayaran',
                        'id' => $check_item_in_temp[0]->id
                    );

                    $data = array(
                        'qty' => $qty
                    );

                    $this->Crud_model->edit_record_id($args, $data);
                } else {
                    $tax_amount = ($result[0]->tax / 100) * $result[0]->retail;

                    // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
                    $temp_data = array(
                        'barcode' => $result[0]->barcode,
                        'product_no' => $result[0]->sku,
                        'product_id' => $result[0]->id,
                        'product_name' => $result[0]->product_name,
                        'mg' => $result[0]->mg,
                        'price' => $result[0]->retail,
                        'purchase' => $result[0]->purchase,
                        'qty' => 1,
                        'tax' => $tax_amount,
                        'agentid' => $user_name['id'],
                        'source' => 'pos'
                    );

                    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
                    $result = $this->Crud_model->insert_data('mp_temp_barcoder_pembayaran', $temp_data);
                }
            }
        }
        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);
        // echo json_encode($data);
        // $this->load->view('pembayaran_template.php', $data);
    }

    //pembayaran/add_selected_item
    //USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
    function add_selected_item($id)
    {
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');
        $user_name = $this->session->userdata('user_id');

        if ($id != '') {
            $result = $this->Crud_model->fetch_record_by_id('mp_productslist', $id);

            $check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_pembayaran', 'product_id', $id, $user_name['id'], 'pos');


            if ($result[0]->quantity >= 0) {
                $stockargs   = array(
                    'table_name' => 'mp_productslist',
                    'id' => $result[0]->id,
                );

                $stockdata = array(
                    'quantity' => $result[0]->quantity - 1
                );

                $this->Crud_model->edit_record_id($stockargs, $stockdata);

                if ($check_item_in_temp != NULL) {
                    $qty = $check_item_in_temp[0]->qty + 1;

                    $args = array(
                        'table_name' => 'mp_temp_barcoder_pembayaran',
                        'id' => $check_item_in_temp[0]->id
                    );

                    $data = array(
                        'qty' => $qty
                    );

                    $this->Crud_model->edit_record_id($args, $data);
                } else {
                    if ($result != NULL) {
                        $tax_amount = ($result[0]->tax / 100) * $result[0]->retail;

                        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
                        $args = array(
                            'barcode' => $result[0]->barcode,
                            'product_no' => $result[0]->sku,
                            'product_id' => $result[0]->id,
                            'product_name' => $result[0]->product_name,
                            'mg' => $result[0]->mg,
                            'price' => $result[0]->retail,
                            'purchase' => $result[0]->purchase,
                            'qty' => 1,
                            'tax' => $tax_amount,
                            'agentid' => $user_name['id'],
                            'source' => 'pos'
                        );
                        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
                        $result = $this->Crud_model->insert_data('mp_temp_barcoder_pembayaran', $args);
                    }
                }
            }
            //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
            $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);
            // echo json_encode(array('error' => false, 'data' => $id));
            $this->load->view('pembayaran_template.php', $data);
        }
    }

    //pembayaran/search_result_manual
    //USED TO SEARCH MANUAL ITEMS
    function search_result_manual($search_result)
    {
        if ($search_result != NULL) {
            // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
            $this->load->model('Crud_model');

            $result = $this->Crud_model->search_items_stock($search_result);
            //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
            $data['search_result'] = $result;
            $this->load->view('search_list.php', $data);
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
            $item = count($dataContent['item']);
            for ($i = 0; $i < $item; $i++) {
                // if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                // 	$status = TRUE;
                $dataContent['amount'][$i] = preg_replace("/[^0-9]/", "", $dataContent['item'][$i]->amount);
                $dataContent['date_item'][$i] =  $dataContent['item'][$i]->date_item;
                $dataContent['keterangan_item'][$i] =  $dataContent['item'][$i]->keterangan_item;
                $dataContent['satuan'][$i] =  $dataContent['item'][$i]->satuan;

                $dataContent['qyt'][$i] =  $dataContent['item'][$i]->qyt;
                // $dataContent['qyt'][$i] = preg_replace("/[^0-9]/", "", $dataContent['item'][$i]->qyt);
            }
        } else {
            echo 'ngapain cok';
            return;
        }
        // echo json_encode($item);
        // echo json_encode($dataContent);
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


            // if ($dataContent['par_am'] > 0) {
            //     $table->addRow();
            //     $table->addCell(200, $cellColSpan)->addText($dataContent['par_label'], 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            //     if (stripos(strtolower($dataContent['par_label']), 'lebih') !== false) {
            //         $total = $total - $dataContent['par_am'];
            //     } else {
            //         $total = $total + $dataContent['par_am'];
            //         $table->addCell(500, $cellVCentered)->addText('' . number_format($dataContent['par_am'], '0', ',', '.'), 'paragraph_bold', array('align' => 'right', 'spaceAfter' => 0));
            //     }
            // }

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
        $freame5->addCell(7000, $cellVCentered)->addText($this->terbilang($kw_terbilang) . ' Rupiah', 'paragraph_italic', array('spaceAfter' => 0));

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
        // if ($dataContent['par_am'] > 0) {
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
        foreach ($dataContent['item'] as $item) {

            $freame7->addRow();
            $current_data = ($item->amount * $item->qyt);
            $current_jasa = ceil($dataContent['percent_jasa'] / 100 * $current_data);
            // $current_pph = ($dataContent['percent_pph'] / 100 * ($current_data - $current_jasa));
            $current_total = $current_data - $current_jasa;
            $kw_total = $kw_total + $current_total;

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
                $freame7->addCell(3400, $cellVCentered)->addText($item->nopol ? $item->nopol : $item->description, 'paragraph', array('spaceAfter' => 0));
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
        $freame7->addCell(1600, $cellVCentered)->addText(number_format($total_kwitansi, '0', ',', '.'), 'paragraph_bold', array('spaceAfter' => 0, 'align' => 'right',));
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
        $filename = 'PMT_' . $dataContent['id'];
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
    public function show($pembayaran_no)
    {

        // DEFINES PAGE TITLE
        $data['title'] = 'Invoice';

        $collection = array();

        // DEFINES TO LOAD THE MODEL
        $this->load->model('InvoiceModel');
        if ($pembayaran_no != NULL) {
            $result = $this->InvoiceModel->getAllPembayaran(array('id' =>  $pembayaran_no));

            if (empty($result)) {
                $data['main_view'] = 'error-5';
                $data['message'] = 'Sepertinya data yang anda cari tidak ditemukan atau sudah di hapus.';
            } else {

                $data['dataContent'] = $result[0];
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
            $data['accounts_records'] = $this->Statement_model->chart_list();
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

    //pembayaran/add_auto_pembayaran
    //USED TO ADD AUTOMATIC INVOICE
    function add_auto_pembayaran()
    {

        $this->load->model('Transaction_model');
        $customer_id      = html_escape($this->input->post('customer_id'));
        $discountfield      = html_escape($this->input->post('discountfield'));
        $total_bill      = html_escape($this->input->post('total_bill'));
        $bill_paid           = html_escape($this->input->post('bill_paid'));
        $date              = date('Y-m-d');
        $status          = 0;
        $user_name          = $this->session->userdata('user_id');
        $agent              = $user_name['name'];

        $this->load->model('Crud_model');
        $result = $this->Crud_model->fetch_attr_record_by_id('mp_temp_barcoder_pembayaran', 'agentid', $user_name['id']);

        $customer_previous = $this->return_previous_cus_balance($customer_id);

        if ($result != NULL) {
            //ASSIGNING DATA TO ARRAY
            $data1  = array(
                'discount' => $discountfield,
                'date' => $date,
                'status' => $status,
                'agentname' => $agent,
                'cus_id' => $customer_id,
                'total_bill' => $total_bill,
                'bill_paid' => $bill_paid,
                'cus_previous' => ''
            );

            //USED TO CREATE A TRANSACTION FOR SALE AND ACCOUNTS
            $data = $this->Transaction_model->single_pos_transaction($data1);

            if ($data != NULL) {
                //CUSTOMER NAME
                $result = $this->Crud_model->fetch_record_by_id('mp_payee', $customer_id);
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

					//UN COMMENT THE BELOW LINE WHEN CONNETED RO PRINTER 
				    $this->load->library('printer');
				    $printer_result =  $this->printer->generate_print($general_info,$data);
				}

				if($printer_result != 'success')
				{
					$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Faktur berhasil tetapi tidak ada printer yang ditemukan',
					'alert' => 'info'
					);
				}
				else
				{
					$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created successfully',
					'alert' => 'info'
					);
				}
				*/


                $array_msg = array(
                    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created successfully',
                    'alert' => 'info'
                );

                $this->session->set_flashdata('status', $array_msg);
            } else {
                $array_msg = array(
                    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be added',
                    'alert' => 'danger'
                );
                $this->session->set_flashdata('status', $array_msg);
            }
        } else {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry no items selected',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }

        redirect('pembayaran');
    }

    //USED TO SEARCH CUSTOMERS PRIVIOUS BALANCE 
    //Invoice/search_previous_cus_balance
    function search_previous_cus_balance($cus_id)
    {
        $this->load->model('Accounts_model');
        $result = $this->Accounts_model->previous_balance($cus_id);
        echo $result;
    }

    //USED TO SEARCH CUSTOMERS PRIVIOUS BALANCE 
    //Invoice/search_previous_cus_balance
    function return_previous_cus_balance($cus_id)
    {
        $this->load->model('Accounts_model');
        return $this->Accounts_model->previous_balance($cus_id);
    }

    //USED TO UPDATE QUANTITY 
    //Invoice/update_qty
    function update_qty($val = '', $id = '', $customprice = null)
    {

        $this->load->model('Crud_model');
        $this->load->model('Pos_transaction_model');
        $user_name = $this->session->userdata('user_id');
        $val = intval($val);

        if ($val != '' and $id != '' and  $val > -1) {

            $result = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_pembayaran', 'id', $id, $user_name['id'], 'pos');

            $result_stk = $this->Crud_model->fetch_record_by_id('mp_productslist', $result['0']->product_id);

            $bal = 0;
            $new_qty = 0;

            if ($result[0]->qty > $val) {

                $bal = $result[0]->qty - $val;
                $new_qty = $result_stk[0]->quantity + $bal;
            } else if ($result[0]->qty < $val) {
                $bal = $val - $result[0]->qty;
                $new_qty = $result_stk[0]->quantity - $bal;
            }

            if ($result[0]->qty != $val and $new_qty >= 0) {
                $new_args = array(
                    'table_name' => 'mp_productslist',
                    'id' => $result['0']->product_id
                );

                $new_data = array(
                    'quantity' => $new_qty
                );

                $temp_args = array(
                    'table_name' => 'mp_temp_barcoder_pembayaran',
                    'id' => $id
                );


                $temp_data = array(
                    'qty' => $val
                );



                $this->Pos_transaction_model->general_pos_transaction($new_args, $new_data, $temp_args, $temp_data);
            }
        }
        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);

        $this->load->view('pembayaran_template.php', $data);
    }

    //USED TO UPDATE QUANTITY 
    //Invoice/update_qty
    function update_price($val = '', $id = '')
    {

        $this->load->model('Crud_model');
        $this->load->model('Pos_transaction_model');
        $user_name = $this->session->userdata('user_id');
        $val = intval($val);

        if ($val != '' and $id != '' and  $val > -1) {

            $result = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_pembayaran', 'id', $id, $user_name['id'], 'pos');

            $result_stk = $this->Crud_model->fetch_record_by_id('mp_productslist', $result['0']->product_id);

            $bal = 0;
            $new_qty = 0;

            if ($result[0]->qty > $val) {

                $bal = $result[0]->qty - $val;
                $new_qty = $result_stk[0]->quantity + $bal;
            } else if ($result[0]->qty < $val) {
                $bal = $val - $result[0]->qty;
                $new_qty = $result_stk[0]->quantity - $bal;
            }

            if ($result[0]->qty != $val and $new_qty >= 0) {
                $new_args = array(
                    'table_name' => 'mp_productslist',
                    'id' => $result['0']->product_id
                );

                $new_data = array(
                    'quantity' => $new_qty
                );

                $temp_args = array(
                    'table_name' => 'mp_temp_barcoder_pembayaran',
                    'id' => $id
                );

                $temp_data = array(
                    'price' => $val
                );


                $this->Pos_transaction_model->general_pos_transaction($new_args, $new_data, $temp_args, $temp_data);
            }
        }
        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_pembayaran', 'pos', $user_name['id']);

        $this->load->view('pembayaran_template.php', $data);
    }



    //USED TO SHOW THE DETAIL OF  RETURN INVOICE 
    //Invoice/single_pembayaran/ID
    function single_pembayaran($return_id)
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Invoice';

        $this->load->model('Accounts_model');
        $data['pembayaran_data'] = $this->Accounts_model->fetch_single_pembayaran_items($return_id);

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'single_pembayaran';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    function create_pembayaran()
    {
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
        $data['am_pph'] = preg_replace("/[^0-9]/", "", $data['am_pph']);
        $data['am_jasa'] = preg_replace("/[^0-9]/", "", $data['am_jasa']);


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

            $result = $this->Transaction_model->pembayaran_entry($data);
            $this->Crud_model->insert_data('notification', array('notification_url' => 'pembayaran/show/' . $result['order_id'], 'parent_id' => $result['order_id'], 'to_role' => '23', 'status' => 0, 'deskripsi' => 'Pembayaran Mitra', 'agent_name' => $this->session->userdata('user_id')['name']));

            // die();
            if ($result != NULL) {
                // $this->addQRCode('inv/', $result['order_id'], $result['token']);
                // $this->Transaction_model->activity_edit($result, $acc);
                $array_msg = array(
                    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
                    'alert' => 'info'
                );
                $this->session->set_flashdata('status', $array_msg);
                redirect('pembayaran/show/' . $result['order_id']);
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

    function edit_process_pembayaran()
    {
        $status = FALSE;
        $data = $this->input->post();
        // echo json_encode($data);
        // die();
        if ($data['manual_math'] == 'on') {
            if (empty($data['manual_math'])) {
                $data['manual_math'] = 'off';
            }
            $data['manual_math'] = 1;
        } else {
            $data['manual_math'] = 0;
        }
        $data['am_pph'] = preg_replace("/[^0-9]/", "", $data['am_pph']);
        $data['am_jasa'] = preg_replace("/[^0-9]/", "", $data['am_jasa']);
        $data['par_am'] = preg_replace("/[^0-9]/", "", $data['par_am']);


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
}