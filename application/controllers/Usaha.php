<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Usaha extends CI_Controller
{
    // Users
    public function index()
    {

        // echo 's';
        // die();
        // DEFINES PAGE TITLE
        $data['title'] = 'Usaha';

        // DEFINES NAME OF TABLE HEADING
        // $data['table_name'] = 'DAFTAR PENGGUNA :';

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'car_wash_app';
        $this->load->model('Accounts_model');
        $data['banks'] = $this->Accounts_model->getAllBank();

        $this->load->view('main/index.php', $data);
    }

    function add_record_car_wash()
    {
        $status = FALSE;
        $data = $this->input->post();
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

        for (
            $i = 0;
            $i < $count_rows;
            $i++
        ) {
            if (!empty($data['amount'][$i]) && !empty($data['qyt'][$i]))
                $status = TRUE;
            $data['amount'][$i] = preg_replace("/[^0-9]/", "", $data['amount'][$i]);
        }

        if ($status) {
            $this->load->model('Transaction_model');
            // // if (!empty($data['no_jurnal'])) {
            $res = $this->Transaction_model->check_last_transaction_usaha();
            $data['no_invoice'] = " IMA/CW/" . date('y') . "/" . date('m') . "/" . (string)($res + 1);
            // var_dump($data);
            // die();
            // // die();
            // if ($res != 0) {
            //     $array_msg = array(
            //         'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nomor Invoice Sudah Ada',
            //         'alert' => 'danger'
            //     );
            //     $this->session->set_flashdata('status', $array_msg);
            //     $this->index($data);
            //     return;
            //     // redirect('statements/journal_voucher');
            // }
            // }
            $result = $this->Transaction_model->invoice_entry_usaha($data);
            // die();
            if ($result != NULL) {
                // $this->Transaction_model->activity_edit($result, $acc);
                $array_msg = array(
                    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
                    'alert' => 'info'
                );
                $this->session->set_flashdata('status', $array_msg);
                redirect('usaha/show/' . $result);
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
        redirect('usaha');
    }

    public function show($invoice_no)
    {

        // DEFINES PAGE TITLE
        $data['title'] = 'Invoice';

        $collection = array();

        // DEFINES TO LOAD THE MODEL
        $this->load->model('InvoiceModel');
        if ($invoice_no != NULL) {
            $result = $this->InvoiceModel->getAllUsaha(array('id' =>  $invoice_no));

            if (empty($result)) {
                $data['main_view'] = 'error-5';
                $data['message'] = 'Sepertinya data yang anda cari tidak ditemukan atau sudah di hapus.';
            } else {

                $data['dataContent'] = $result[0];
                $data['main_view'] = 'invoice_detail_usaha';
            }
            // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
            $this->load->view('main/index.php', $data);
            return;
        } else {
            echo 'NOT FOUND';
            return;
        }
    }
    function popup($page_name = '', $param = '')
    {
        $this->load->model('Crud_model');
        if ($page_name  == 'new_row_car_wash') {
            // $this->load->model('Statement_model');
            // $data['accounts_records'] = $this->Statement_model->chart_list();
            $this->load->view('admin_models/accounts/new_row_car_wash.php');
        } else		if ($page_name  == 'add_patner_model') {
            //USED TO REDIRECT LINK
            $data['link'] = 'patners/add_patner';

            //model name available in admin models folder
            $this->load->view('admin_models/add_models/add_patner_model.php', $data);
        } else if ($page_name  == 'edit_invoice_model') {
            // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
            $this->load->model('Accounts_model');

            // GET THE ROW FROM DATABASE FROM TABLE ID
            $data['invoice_data'] = $this->Accounts_model->get_by_id("mp_invoices", "mp_sales", $param);

            //model name available in admin models folder
            $this->load->view('admin_models/edit_models/edit_invoice_model.php', $data);
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

    public function cetak_nota($invoice_no)
    {
        // $this->SecurityModel->userOnlyGuard(TRUE);
        $this->load->model('InvoiceModel');
        $nota = $this->InvoiceModel->getAllUsaha(array('id' =>  $invoice_no))[0];
        // echo json_encode($nota['date']);
        // die();
        require('assets/fpdf/fpdf.php');


        $pdf = new FPDF('P', 'mm', array(58, 200));

        $pdf->AddPage();
        $pdf->SetMargins(3, 0, -10);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(
            1,
            1,
            '',
            0,
            1,
            'C'
        );

        $image1 = base_url('assets/img/yumna-bw.png');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(4, 1, '', 0, 0, 'C');

        $pdf->Cell(
            38,
            5,
            $pdf->Image('assets/img/ima.jpg', $pdf->GetX(), $pdf->GetY(), 30),
            0,
            1,
            'C',
            false
        );
        $pdf->Cell(
            32,
            1,
            '',
            0,
            1,
            'C'
        );
        $pdf->Cell(
            38,
            3,
            'CAR WASH INDOMETAL',
            0,
            1,
            'C'
        );
        // $pdf->Cell(
        //     38,
        //     3,
        //     'No. 9 Air Ruai',
        //     0,
        //     1,
        //     'C'
        // );

        // $pdf->Cell(
        //     38,
        //     3,
        //     '(Depan Griya Air Ruai) Sungailiat',
        //     0,
        //     1,
        //     'C'
        // );
        // $pdf->Cell(38, 3, 'WA +62 812 9702 8367', 0, 1, 'C');

        // $pdf->Cell(80,7,'',0,0);
        // $pdf->Cell(30,7,'Tgl',0,0);
        $pdf->Cell(38, 3, $nota['date'], 0, 1, 'C');
        $pdf->Cell(38, 3, $nota['no_invoice'], 0, 1, 'C');
        $pdf->Cell(38, 3, '', 0, 1, 'C');

        // $pdf->Cell(38, 3, $nota['nama_pembeli'], 0, 1, 'C');
        // $pdf->Cell(38, 3, 'No RM : ' . $nota['no_rm'], 0, 1, 'C');

        // $pdf->Cell(52, 3, '', 0, 1, 'C');
        $total = 0;
        foreach ($nota['item'] as $value) {
            // var_dump($value->keterangan_item);
            // die;
            // // if ($value['diskon'] > 0) {
            //     $nama_produk = $value['nama_product'] . ' diskon ' . $value['diskon'] . '%';
            //     $harga_produk = $value['harga_jual'] - ($value['diskon'] / 100 * $value['harga_jual']);
            // } else {
            // $nama_produk = $value['keterangan_item'];
            // $harga_produk = $value['harga_jual'];
            // }
            $xs = $pdf->GetX();
            $ys = $pdf->GetY();
            //Draw the border
            // $pdf->Rect($x,$y,30,4);
            //Print the text
            $pdf->MultiCell(22, 3, $value->keterangan_item . ' ' . $value->qyt . 'x', 0, 'L');
            // $pdf->MultiCell(30,3,'vefse sef sefs adawd awdaw awdaw',1,'L');
            //Put the position to the right of the cell
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->SetXY($xs + 15, $ys);
            // $pdf->MultiCell(30, 3, 'adsas asd asdsd asda asdas asdas', 1, 'L', false);
            $pdf->Cell(
                22,
                3,
                number_format($value->amount * $value->qyt),
                0,
                1,
                'R'
            );
            $total = $total + ($value->amount * $value->qyt);
            $pdf->SetXY($x, $y);
            $pdf->Cell(
                22,
                3,
                '-----------------------------------------',
                0,
                1,
                'L'
            );
            // $pdf->Cell(50, 7, $this->rupiah($value['jumlah']*$value['harga_jual']), 1, 1, 'R');
        }
        // // $pdf->Cell(50, 7, '', 0, 0);
        // // $pdf->Cell(, 7, '', 0, 0);
        // // $pdf->Cell(50, 7, 'Total Belanja', 0, 0);
        // $pdf->Cell(
        //     32,
        //     2,
        //     '',
        //     0,
        //     1
        // );
        // if ($nota['diskon_total'] > 0) {
        //     $pdf->Cell(20, 3, 'Total :', 0, 0, 'R');
        //     $pdf->Cell(
        //         4,
        //         3,
        //         'Rp',
        //         0,
        //         0,
        //         'R'
        //     );
        //     $pdf->Cell(
        //         14,
        //         3,
        //         $this->rupiah($nota['total_belanja'], true),
        //         0,
        //         1,
        //         'R'
        //     );
        //     $pdf->Cell(20, 3, 'Diskon :', 0, 0, 'R');
        //     $pdf->Cell(18, 3, $nota['diskon_total'] . ' %', 0, 1, 'R');
        // } else {
        $pdf->Cell(19, 3, 'Total :', 0, 0, 'R');
        $pdf->Cell(
            4,
            3,
            'Rp',
            0,
            0,
            'R'
        );
        $pdf->Cell(14, 3, number_format($total), 0, 1, 'R');
        // }
        // $pdf->Cell(20, 3, 'Pembayaran :', 0, 0, 'R');
        // $pdf->Cell(
        //     4,
        //     3,
        //     'Rp',
        //     0,
        //     0,
        //     'R'
        // );
        // $pdf->Cell(
        //     14,
        //     3,
        //     $this->rupiah($nota['pembayaran'], true),
        //     0,
        //     1,
        //     'R'
        // );
        // $pdf->Cell(
        //     20,
        //     3,
        //     'Kembalian :',
        //     0,
        //     0,
        //     'R'
        // );

        // $pdf->Cell(4, 3, 'Rp', 0, 0, 'R');
        // $pdf->Cell(
        //     14,
        //     3,
        //     $this->rupiah($nota['kembalian_pembayaran'] * (-1), true),
        //     0,
        //     1,
        //     'R'
        // );
        // $pdf->Cell(52, 3, '', 0, 1, 'c');
        $pdf->Cell(52, 3, '', 0, 1, 'c');
        $pdf->Cell(38, 3, '** Terima Kasih **', 0, 1, 'C');


        // $pdf->Cell(10, 7, '', 0, 1);
        // $pdf->Cell(5, 7, '', 0, 0);
        // $pdf->Cell(80, 7, 'Tanda Terima', 0, 0, 'C');
        // $pdf->Cell(15, 7, '', 0, 0);
        // $pdf->Cell(80, 7, 'Hormat Hami,', 0, 1,'C');
        // $pdf->Cell(10, 7, '', 0, 1);
        // $pdf->Cell(10, 7, '', 0, 1);
        // $pdf->Cell(5, 7, '', 0, 0);
        // $pdf->Cell(80, 7, $nota['nama_pasien'], 0, 0, 'C');
        // $pdf->Cell(15, 7, '', 0, 0);
        // $pdf->Cell(80, 7, $nama_petugas[0], 0, 1,'C');

        // $pdf->Cell(50, 7, $this->rupiah($nota['kembalian_pembayaran']*(-1)), 0, 1, 'R');



        $filename = 'Nota ';
        $pdf->Output('', $filename, false);
    }
}
