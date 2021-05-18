<?php
defined('BASEPATH') or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class Statements extends CI_Controller
{
	// Statements
	//USED TO GENERATE GENERAL JOURNAL 
	public function index()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Jurnal Umum';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'generaljournal';

		$from 	 = html_escape($this->input->post('from'));
		$no_jurnal 	 = html_escape($this->input->post('no_jurnal'));
		$to 	 = html_escape($this->input->post('to'));

		if ($from == NULL and $to == NULL) {
			$from = date('Y-m-' . '01');
			$to = date('Y-m-' . date('t', strtotime($from)));
		}

		if (empty($no_jurnal)) {
			$no_jurnal = '';
		}
		$filter['from'] = $from;
		$filter['to'] = $to;
		$filter['no_jurnal'] = $no_jurnal;

		$this->load->model('Statement_model');
		$data['transaction_records'] = $this->Statement_model->fetch_transasctions($filter);

		$data['from'] = $from;
		$data['to'] = $to;
		$data['no_jurnal'] = $no_jurnal;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	public function show($id)
	{

		// DEFINES PAGE TITLE

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'journal_voucher_detail';

		$from 	 = html_escape($this->input->post('from'));
		$to 	 = html_escape($this->input->post('to'));

		$this->load->model('Statement_model');
		$data['transaction'] = $this->Statement_model->detail_fetch_transasctions($id);
		$data['acc'] = $this->Statement_model->get_acc($id, true);
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

	public function copy_jurnal($id)
	{

		$this->load->model('Statement_model');
		$res_detail = $this->Statement_model->detail_fetch_transasctions($id);
		$res_acc = $this->Statement_model->get_acc($id, true);
		$countsub = count($res_detail['sub']);
		for ($i = 0; $i < $countsub; $i++) {
			$accounthead[$i] = $res_detail['sub'][$i]['accounthead'];
			$sub_keterangan[$i] = $res_detail['sub'][$i]['sub_keterangan'];
			if ($res_detail['sub'][$i]['type'] == 0) {
				$creditamount[$i] = '';
				$debitamount[$i] = $res_detail['sub'][$i]['amount'];
			} else {
				$creditamount[$i] = $res_detail['sub'][$i]['amount'];
				$debitamount[$i] = '';
			}
		}
		// echo json_encode($res_detail['sub']);
		// die();
		if (!empty($res_acc)) {

			$acc[1] = $res_acc->acc_1;
			$acc[2] = $res_acc->acc_2;
			$acc[3] = $res_acc->acc_3;
		} else {
			$acc[1] = '';
			$acc[2] = '';
			$acc[3] = '';
		}
		$new_arr = [];
		$arr = explode(']', $res_detail['parent']->arr_cars);
		foreach ($arr as $dat) {
			if (!empty($dat)) {
				$tmp = '';
				$tmp = $this->Statement_model->find_cars(str_replace('[', '', $dat));
				if (!empty($tmp)) array_push($new_arr, $tmp);
			}
		}
		$data = array(
			'description' => $res_detail['parent']->naration,
			'date' => $res_detail['parent']->date,
			'customer_id' => $res_detail['parent']->customer_id,
			'arr_cars' => $res_detail['parent']->arr_cars,
			'no_jurnal' => $res_detail['parent']->no_jurnal,
			'account_head' => $accounthead,
			'debitamount' => $debitamount,
			'creditamount' => $creditamount,
			'sub_keterangan' => $sub_keterangan,
			'acc' => $acc
		);
		$this->journal_voucher($data);
	}



	public function export_excel()
	{

		$from = $this->input->get()['from'];
		$to = $this->input->get()['to'];
		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(37);
		$sheet->getColumnDimension('D')->setWidth(37);
		$sheet->getColumnDimension('E')->setWidth(23);
		$sheet->getColumnDimension('F')->setWidth(23);
		$spreadsheet->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal('center')->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

		$sheet->getStyle('E:F')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

		$this->load->model('Statement_model');
		$data['transaction_records'] = $this->Statement_model->export_excel($from, $to, $sheet);
		$sheet->mergeCells("A1:F1");
		$sheet->mergeCells("A2:F2");
		$sheet->mergeCells("A3:F3");
		$sheet->setCellValue('A1', 'PT INDOMETAL ASIA');
		$sheet->setCellValue('A2', 'Jurnal Umum');
		$sheet->setCellValue('A3', 'Periode : ' . $from . ' s.d. ' . $to);

		$sheet->setCellValue('A5', 'TANGGAL');
		$sheet->setCellValue('B5', 'NO JURNAL');
		$sheet->setCellValue('C5', 'NO AKUN');
		$sheet->setCellValue('D5', 'KETERANGAN');
		$sheet->setCellValue('E5', 'DEBIT');
		$sheet->setCellValue('F5', 'KREDIT');
		// $sheet->setCellValue('E5', 'DEBIT');


		$writer = new Xlsx($spreadsheet);

		$filename = 'jurnal_umum_' . $from . '_sd_' . $to;

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); // download file 
	}


	public function export_excel_ledger()
	{

		$filter = $this->input->get();
		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(37);
		$sheet->getColumnDimension('D')->setWidth(23);
		$sheet->getColumnDimension('E')->setWidth(23);
		$sheet->getColumnDimension('F')->setWidth(23);
		$spreadsheet->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal('center')->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFont()->setSize(13)->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13)->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

		$sheet->getStyle('D:F')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

		$this->load->model('Statement_model');
		$data['transaction_records'] = $this->Statement_model->export_excel_ledger($filter, $sheet, $spreadsheet);
		$sheet->mergeCells("A1:F1");
		$sheet->mergeCells("A2:F2");
		$sheet->mergeCells("A3:F3");
		$sheet->setCellValue('A1', 'PT INDOMETAL ASIA');
		$sheet->setCellValue('A2', 'Buku Besar');
		$sheet->setCellValue('A3', 'Periode : ' . $filter['from'] . ' s.d. ' . $filter['to']);

		$sheet->setCellValue('A5', 'TANGGAL');
		$sheet->setCellValue('B5', 'NO JURNAL');
		// $sheet->setCellValue('C5', 'NO AKUN');
		$sheet->setCellValue('C5', 'KETERANGAN');
		$sheet->setCellValue('D5', 'DEBIT');
		$sheet->setCellValue('E5', 'KREDIT');
		$sheet->setCellValue('F5', 'SALDO');


		$writer = new Xlsx($spreadsheet);

		$filename = 'jurnal_umum_' . $filter['from'] . '_sd_' . $filter['to'];

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); // download file 
	}


	public function export_word2()
	{
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$section = $phpWord->addSection();
		$header = array('size' => 16, 'bold' => true);

		// 1. Basic table

		$rows = 10;
		$cols = 5;
		$section->addText('Basic table', $header);

		$table = $section->addTable();
		for ($r = 1; $r <= $rows; $r++) {
			$table->addRow();
			for ($c = 1; $c <= $cols; $c++) {
				$table->addCell(1750)->addText("Row {$r}, Cell {$c}");
			}
		}

		// 2. Advanced table

		$section->addTextBreak(1);
		$section->addText('Fancy table', $header);

		$fancyTableStyleName = 'Fancy Table';
		$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 50);
		$fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
		$fancyTableCellStyle = array('valign' => 'center');
		$fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
		$fancyTableFontStyle = array('bold' => true);
		$phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
		$table = $section->addTable($fancyTableStyleName);
		$table->addRow(900);
		$table->addCell(2000, $fancyTableCellStyle)->addText('Row 1', $fancyTableFontStyle);
		$table->addCell(2000, $fancyTableCellStyle)->addText('Row 2', $fancyTableFontStyle);
		$table->addCell(2000, $fancyTableCellStyle)->addText('Row 3', $fancyTableFontStyle);
		$table->addCell(2000, $fancyTableCellStyle)->addText('Row 4', $fancyTableFontStyle);
		$table->addCell(500, $fancyTableCellBtlrStyle)->addText('Row 5', $fancyTableFontStyle);
		for ($i = 1; $i <= 8; $i++) {
			$table->addRow();
			$table->addCell(2000)->addText("Cell {$i}");
			$table->addCell(2000)->addText("Cell {$i}");
			$table->addCell(2000)->addText("Cell {$i}");
			$table->addCell(2000)->addText("Cell {$i}");
			$text = (0 == $i % 2) ? 'X' : '';
			$table->addCell(500)->addText($text);
		}



		$section->addPageBreak();
		$section->addText('Table with colspan and rowspan', $header);

		$styleTable = array('borderSize' => 6, 'borderColor' => '999999');
		$phpWord->addTableStyle('Colspan Rowspan', $styleTable);
		$table = $section->addTable('Colspan Rowspan');

		$row = $table->addRow();
		$row->addCell(1000, array('vMerge' => 'restart'))->addText('A');
		$row->addCell(1000, array('gridSpan' => 2, 'vMerge' => 'restart'))->addText('B');
		$row->addCell(1000)->addText('1');

		$row = $table->addRow();
		$row->addCell(1000, array('vMerge' => 'continue'));
		$row->addCell(1000, array('vMerge' => 'continue', 'gridSpan' => 2));
		$row->addCell(1000)->addText('2');

		$row = $table->addRow();
		$row->addCell(1000, array('vMerge' => 'continue'));
		$row->addCell(1000)->addText('C');
		$row->addCell(1000)->addText('D');
		$row->addCell(1000)->addText('3');

		// 5. Nested table

		$section->addTextBreak(2);
		$section->addText('Nested table in a centered and 50% width table.', $header);

		$table = $section->addTable(array('width' => 50 * 50, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
		$cell = $table->addRow()->addCell();
		$cell->addText('This cell contains nested table.');
		$innerCell = $cell->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER))->addRow()->addCell();
		$innerCell->addText('Inside nested table');

		// 6. Table with floating position

		$section->addTextBreak(2);
		$section->addText('Table with floating positioning.', $header);


		$writer = new Word2007($phpWord);

		$filename = 'simple';

		header('Content-Type: application/msword');
		header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	public function export_word()
	{
		// require_once 'bootstrap.php';

		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		// $from = $this->input->get()['from'];
		// $to = $this->input->get()['to'];
		// $phpWord = new PhpWord();
		// $section->addText('Hello World !');
		$phpWord->addFontStyle('h3', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
		$phpWord->addFontStyle('paragraph', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'spaceAfter' => 0));
		// $PHPWord->addParagraphStyle('p3Style', array('align'=>'center', 'spaceAfter'=>100));
		$phpWord->addFontStyle('paragraph_bold', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
		$phpWord->addFontStyle('paragraph_bold_c', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
		$phpWord->addFontStyle('paragraph2', array(
			'name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single'
		));
		$phpWord->addFontStyle('paragraph3', array(
			'name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true, 'underline' => 'single'
		));
		$phpWord->addFontStyle('paragraph4', array(
			'name' => 'Times New Roman', 'size' => 13, 'color' => '000000', 'bold' => true, 'underline' => 'single'
		));
		$noSpace = array('spaceAfter' => 0);
		$noSpaceTables = array('spaceAfter' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\VerticalJc::TOP);
		$noSpace_center = array('spaceAfter' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

		$fancyTableStyle = array('lineStyle' => 'no border', 'borderColor' => 'no border', 'height' => 800, 'cellMargin' => 50);
		$cellVCentered = array('valign' => 'center', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
		$spanTableStyleName = 'Colspan Rowspan';

		$section = $phpWord->addSection();
		$section = $phpWord->addSection(array(
			'colsNum' => 2,
			'colsSpace' => 500,
			'breakType' => 'continuous'
		));
		$table = $section->addTable($spanTableStyleName);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Nomor', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(5000, $cellVCentered)->addText('189/UM/IA-A0000/2021-S4', 'paragraph', $noSpace);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Tanggal', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(2000, $cellVCentered)->addText('', 'paragraph', $noSpace);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Lampiran', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(5000, $cellVCentered)->addText('', 'paragraph', $noSpace);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Perihal', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(5000, $cellVCentered)->addText('', 'paragraph', $noSpace);

		$section->addTextBreak();

		$section->addText("\tKepada Yth. :");
		$section->addText("\tPT Bank Mandiri (Persero) Tbk. ", 'paragraph', $noSpace);
		$section->addText("\tKantor Cabang Pangkalpinang", 'paragraph', $noSpace);
		$section->addText("\tUp. Kepala Bagian Kas", 'paragraph', $noSpace);
		$section->addText("\tJl. Jendral Sudirman no.31", 'paragraph');
		// $section->addTextBreak();
		$textrun = $section->addTextRun();
		$textrun->addText("\t");

		$textrun->addText("PANGKALPINANG", array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'spaceAfter' => 0, 'bold' => false, 'underline' => 'single'));


		// Normal
		$section = $phpWord->addSection(array('breakType' => 'continuous'));
		$section->addTextBreak();
		$section->addTextBreak();

		$section->addText('Mohon bantuan melakukan transfer dana dari rekening :');

		$table = $section->addTable();

		$table->addRow(450);
		$table->addCell(2000, array('vMerge' => 'restart'))->addText('Atas Nama', 'paragraph', $noSpace);
		$table->addCell(300, array('vMerge' => 'restart'))->addText(':', 'paragraph', $noSpace);
		$table->addCell(8000, array('vMerge' => 'restart'))->addText(
			'PT INDOETAL ASIA',
			'paragraph',
			$noSpace
		);

		$table->addRow(450);
		$table->addCell(2000, array('vMerge' => 'restart'))->addText('Nomor Rekening', 'paragraph', $noSpace);
		$table->addCell(300, array('vMerge' => 'restart'))->addText(':', 'paragraph', $noSpace);
		$table->addCell(8000, array('vMerge' => 'restart'))->addText(
			'112-0098146017',
			'paragraph',
			$noSpace
		);


		$table->addRow(450);
		$table->addCell(2000, array('vMerge' => 'restart'))->addText('Jumlah', 'paragraph', $noSpace);
		$table->addCell(300, array('vMerge' => 'restart'))->addText(':', 'paragraph', $noSpace);
		$table->addCell(8000, array('vMerge' => 'restart'))->addText(
			'Rp. 123.12391283.2318 (a asd asdjasd asdjasd asdjasd asdjsad asdhasd asdhasdasd adshasdhh asdh asdh asdkjasd asd jasd jasd jasd )',
			'paragraph',
			$noSpace

		);

		$section->addText('Table with colspan and rowspan');

		// $styleTable = array('borderSize' => 0, 'borderColor' => '999999');
		// $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
		$table = $section->addTable('Colspan Rowspan');

		$row = $table->addRow();
		$row->addCell(1000, array('vMerge' => 'restart'))->addText('A');
		$row->addCell(1000, array('gridSpan' => 2, 'vMerge' => 'restart'))->addText('B');
		$row->addCell(1000)->addText('1');

		$row = $table->addRow();
		$row->addCell(1000, array('vMerge' => 'continue'));
		$row->addCell(
			1000,
			array('vMerge' => 'continue', 'gridSpan' => 2)
		);
		$row->addCell(1000)->addText('2');

		$row = $table->addRow();
		$row->addCell(1000, array('vMerge' => 'continue'));
		$row->addCell(1000)->addText('C');
		$row->addCell(1000)->addText('D');
		$row->addCell(1000)->addText('3');



		$section->addTextBreak();
		// $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);



		// $writer = new Word2007($phpWord);
		$writer = new Word2007($phpWord);

		$filename = 'simple';

		header('Content-Type: application/msword');
		header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function export_doc($id)
	{

		$this->load->model('Statement_model');
		$res_detail = $this->Statement_model->detail_fetch_transasctions($id);
		$res_acc = $this->Statement_model->get_acc($id, true);
		$countsub = count($res_detail['sub']);
		$bank = '112-0098146017';

		for ($i = 0; $i < $countsub; $i++) {
			// 1575 Mandiri C rek = 169-00-0207756-5
			// 8 Mandiri A rek = 112-0098146017 
			// 1311 Mandiri B rek = 
			// 
			if ($res_detail['sub'][$i]['accounthead'] == 13) {
				$nominal = $res_detail['sub'][$i]['amount'];
				$nominal = number_format($nominal, 2, ',', '.');
				$angka = $res_detail['sub'][$i]['amount'];;
				$terbilang = $this->terbilang($angka);
			}

			if ($res_detail['sub'][$i]['accounthead'] == 8) {
				$bank = '112-0098146017';
			} else if ($res_detail['sub'][$i]['accounthead'] == 1575) {
				$bank = '169-00-0207756-5';
			} else if ($res_detail['sub'][$i]['accounthead'] = 1311) {
				$bank = '-';
			} else {
				$bank = '-';
			}
		}
		// echo json_encode($res_detail['sub']);
		// die();
		if (!empty($res_acc)) {

			$acc[1] = $res_acc->acc_1;
			$acc[2] = $res_acc->acc_2;
			$acc[3] = $res_acc->acc_3;
		} else {
			$acc[1] = '';
			$acc[2] = '';
			$acc[3] = '';
		}
		$new_arr = [];
		$arr = explode(']', $res_detail['parent']->arr_cars);
		foreach ($arr as $dat) {
			if (!empty($dat)) {
				$tmp = '';
				$tmp = $this->Statement_model->find_cars(str_replace('[', '', $dat));
				if (!empty($tmp)) array_push($new_arr, $tmp);
			}
		}


		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		// $from = $this->input->get()['from'];
		// $to = $this->input->get()['to'];
		// $phpWord = new PhpWord();
		// $section->addText('Hello World !');
		$phpWord->addFontStyle('h3', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
		$phpWord->addFontStyle('paragraph', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'spaceAfter' => 0));
		// $PHPWord->addParagraphStyle('p3Style', array('align'=>'center', 'spaceAfter'=>100));
		$phpWord->addFontStyle('paragraph_bold', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true));
		$phpWord->addFontStyle('paragraph_bold_c', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true, 'spaceAfter' => 0));
		$phpWord->addFontStyle('paragraph2', array(
			'name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'underline' => 'single'
		));
		$phpWord->addFontStyle('paragraph3', array(
			'name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'bold' => true, 'underline' => 'single'
		));
		$phpWord->addFontStyle('paragraph4', array(
			'name' => 'Times New Roman', 'size' => 13, 'color' => '000000', 'bold' => true, 'underline' => 'single'
		));
		$noSpace = array('spaceAfter' => 0);
		$noSpaceTables = array('spaceAfter' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\VerticalJc::TOP);
		$noSpace_center = array('spaceAfter' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

		$fancyTableStyle = array(
			'lineStyle' => 'no border', 'borderColor' => 'no border', 'height' => 800, 'cellMargin' => 50
		);
		$cellVCentered = array('valign' => 'center', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
		$spanTableStyleName = 'Colspan Rowspan';

		$section = $phpWord->addSection();
		$section = $phpWord->addSection(array(
			'colsNum' => 2,
			'colsSpace' => 500,
			'breakType' => 'continuous'
		));
		$table = $section->addTable($spanTableStyleName);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Nomor', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(5000, $cellVCentered)->addText('189/UM/IA-A0000/2021-S4', 'paragraph', $noSpace);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Tanggal', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(2000, $cellVCentered)->addText('', 'paragraph', $noSpace);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Lampiran', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(5000, $cellVCentered)->addText('', 'paragraph', $noSpace);

		$table->addRow(450);
		$table->addCell(2000, $cellVCentered)->addText('Perihal', 'paragraph', $noSpace);
		$table->addCell(150, $cellVCentered)->addText(':', 'paragraph', $noSpace);
		$table->addCell(5000, $cellVCentered)->addText('Penerbitan Deposito On Call', 'paragraph_bold', $noSpace);

		$section->addTextBreak();

		$section->addText("\tKepada Yth. ", 'paragraph', $noSpace);
		$section->addText("\tPimpinan Cabang", 'paragraph', $noSpace);
		$section->addText("\tPT Bank Mandiri (Persero) Tbk. ", 'paragraph', $noSpace);
		$section->addText("\tKantor Cabang Pangkalpinang", 'paragraph', $noSpace);
		$section->addText("\tUp. Kepala Bagian Kas", 'paragraph', $noSpace);
		$section->addText("\tJl. Jendral Sudirman no.31", 'paragraph');
		// $section->addTextBreak();
		$textrun = $section->addTextRun();
		$textrun->addText("\t");

		$textrun->addText("PANGKALPINANG", array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'spaceAfter' => 0, 'bold' => false, 'underline' => 'single'));


		// Normal
		$section = $phpWord->addSection(array('breakType' => 'continuous'));
		$section->addTextBreak();
		$section->addTextBreak();
		$textrun = $section->addTextRun();
		// $textrun->addText("\t");
		$textrun->addText('Dengan ini kami mohon bantuan kepada Bank Mandiri untuk menerbitkan Deposito on Call dengan jangka waktu 12 hari TMT. 30 April 2021 sebesar');
		$textrun->addText(' Rp ' . $nominal, array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'spaceAfter' => 0, 'bold' => true,));
		$textrun->addText(' ( ' . $terbilang . ' rupiah )', array('name' => 'Times New Roman', 'size' => 11, 'color' => '000000', 'spaceAfter' => 0, 'bold' => true, 'italic' => true));
		$textrun->addText('dengan Debet Rekening PT. Indometal Asia No. ' . $bank);

		$section->addText('Pencairan Deposito On Call beserta bunganya agar di kreditkan ke Rekening atas nama PT. Indometal Asia seperti tercantum di atas.');
		$section->addText('Demikian disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih');
		$section->addTextBreak(2);
		$table = $section->addTable();

		$table->addRow();
		$table->addCell(4000)->addText(
			'',
			'paragraph_bold_c',
			$noSpace_center
		);;
		$table->addCell(4000)->addText(
			'PT INDOETAL ASIA',
			'paragraph_bold_c',
			$noSpace_center
		);

		$table->addRow();
		$table->addCell(4000)->addText(
			'',
			'paragraph_bold_c',
			$noSpace_center
		);;
		$table->addCell(4000)->addText(
			'Direktur',
			'paragraph_bold_c',
			$noSpace_center
		);

		$section->addTextBreak();
		// $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
		// $writer = new Word2007($phpWord);
		$writer = new Word2007($phpWord);

		$filename = 'simple';

		header('Content-Type: application/msword');
		header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}


	public function v2()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Jurnal Umum';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'generaljournal2';

		$from 	 = html_escape($this->input->post('from'));
		$to 	 = html_escape($this->input->post('to'));

		if ($from == NULL and $to == NULL) {
			$from = date('Y-m-' . '1');
			$to =  date('Y-m-' . '31');
		}

		$this->load->model('Statement_model');
		$data['transaction_records'] = $this->Statement_model->fetch_transasctions($from, $to);

		$data['from'] = $from;
		$data['to'] = $to;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	public function edit_jurnal($uri1)
	{
		// echo $uri1;
		// $this->load->model('St')
		$this->load->model('Crud_model');
		$this->load->model('Statement_model');
		$data = $this->Statement_model->getSingelJurnal(array('id' => $uri1));
		$data['currency'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1)[0]->currency;
		$data['lst'] = $this->Statement_model->getListCars(array('id_patner' => $data['parent']->customer_id));
		$data['accounts_records'] = $this->Statement_model->chart_list();
		$data['patner_record'] = $this->Statement_model->patners_cars_list();
		$data['acc'] = $this->Statement_model->get_acc($uri1);
		$new_arr = [];
		$arr = explode(']', $data['parent']->arr_cars);
		foreach ($arr as $dat) {
			if (!empty($dat)) array_push($new_arr, str_replace('[', '', $dat));
		}
		// var_dump($data['acc']);
		// die;
		$data['new_arr'] = $new_arr;



		// DEFINES PAGE TITLE
		$data['title'] = 'Edit Jurnal';


		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'journal_voucher_edit';
		// var_dump($data);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE LEDGER ACCOUNTS 
	//Statements/general_journal
	function leadgerAccounst()
	{
		//$ledger
		$from = html_escape($this->input->post('from'));
		$to   = html_escape($this->input->post('to'));
		$data['account_head']   = html_escape($this->input->post('account_head'));

		if ($from == NULL or $to == NULL) {
			$from = date('Y-m-') . '01';
			$to = date('Y-m-' . date('t', strtotime($from)));
		}

		$data['from'] = $from;

		$data['to'] = $to;

		// DEFINES PAGE TITLE
		$data['title'] = 'Buku Besar';

		$this->load->model('Crud_model');

		$this->load->model('Statement_model');
		$data['accounts_records'] = $this->Statement_model->chart_list();
		$data['ledger_records'] = $this->Statement_model->the_ledger($data);

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'ledger';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE TRAIL BALANCE 
	//Statements/trail_balance 
	public function trail_balance()
	{
		$year = html_escape($this->input->post('year'));
		if ($year == NULL) {
			$year = date('Y') . '-12-31';
		} else {
			$year = $year . '-12-31';
		}

		$data['year'] = $year;

		// DEFINES PAGE TITLE
		$data['title'] = 'Neraca Saldo';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'trail_balance';

		$this->load->model('Statement_model');
		$data['trail_records'] = $this->Statement_model->trail_balance($year);


		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE INCOME STATEMENT 
	public function income_statement()
	{
		$year = html_escape($this->input->post('year'));
		if ($year == NULL) {
			$startyear = date('Y') . '-1-1';
			$endyear = date('Y') . '-12-31';
		} else {
			$startyear = $year . '-1-1';
			$endyear =   $year . '-12-31';
		}

		$data['from'] = $startyear;

		$data['to'] = $endyear;

		// DEFINES PAGE TITLE
		$data['title'] = 'Laporan Untung Rugi';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'incomestatement';

		$this->load->model('Statement_model');
		$data['income_records'] = $this->Statement_model->income_statement($startyear, $endyear);


		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE BALANCE SHEET 
	public function balancesheet()
	{
		$year = html_escape($this->input->post('year'));
		if ($year == NULL) {

			$endyear = date('Y') . '-12-31';
		} else {

			$endyear =   $year . '-12-31';
		}

		$data['to'] = $endyear;

		// DEFINES PAGE TITLE
		$data['title'] = 'Neraca Keuangan';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'balancesheet';

		$this->load->model('Statement_model');
		$data['balance_records'] = $this->Statement_model->balancesheet($endyear);


		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO GENERATE JOURNAL VOUCHER 
	//Vouchers/journal_voucher
	function journal_voucher($data_return = NULL)
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

		// DEFINES PAGE TITLE
		$data['title'] = 'Entri Jurnal';
		$data['data_return'] = $data_return;
		$this->load->model('Statement_model');
		$data['accounts_records'] = $this->Statement_model->chart_list();
		$data['patner_record'] = $this->Statement_model->patners_cars_list();

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'journal_voucher';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	function marge_jurnal()
	{
		$data['title'] = 'Entri Jurnal';
		$data['main_view'] = 'marge_jurnal';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	function marge_jurnal_process()
	{
		$no_jurnal  = html_escape($this->input->post('no_jurnal'));

		// var_dump($no_jurnal);
		// die();
		$count_rows = count($no_jurnal);
		$j = 0;
		// echo 'row =  ' . $count_rows;
		for ($i = 0; $i < $count_rows; $i++) {
			// echo "\n i=" . $i;
			$res_detail = NULL;
			if (!empty($no_jurnal[$i])) {
				$this->load->model('Statement_model');
				$res_detail = $this->Statement_model->detail_fetch_transasctions_filter(array('no_jurnal' => $no_jurnal[$i]));
				$countsub = count($res_detail['sub']);
				for ($k = 0; $k < $countsub; $k++) {
					$accounthead[$j] = $res_detail['sub'][$k]['accounthead'];
					$sub_keterangan[$j] = $res_detail['sub'][$k]['sub_keterangan'];
					if ($res_detail['sub'][$k]['type'] == 0) {
						$creditamount[$j] = '';
						$debitamount[$j] = $res_detail['sub'][$k]['amount'];
					} else {
						$creditamount[$j] = $res_detail['sub'][$k]['amount'];
						$debitamount[$j] = '';
					}
					$j++;
				}
			}
		}
		$acc[1] = '';
		$acc[2] = '';
		$acc[3] = '';

		$data = array(
			'description' => '',
			'date' => '',
			'customer_id' => '',
			'arr_cars' => '',
			'no_jurnal' => '',
			'account_head' => $accounthead,
			'debitamount' => $debitamount,
			'creditamount' => $creditamount,
			'sub_keterangan' => $sub_keterangan,
			'acc' => $acc
		);
		// echo json_encode($data);
		// die();
		$this->journal_voucher($data);
	}


	//USED TO ADD STARTING BALANCES 
	function opening_balance()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Pembukaan Saldo';

		$this->load->model('Crud_model');
		$data['heads_record'] = $this->Crud_model->fetch_record('mp_head', NULL);
		$result =  $this->Crud_model->fetch_payee_record('customer', 'status');
		$supplierresult =  $this->Crud_model->fetch_payee_record('supplier', 'status');
		$employeeresult =  $this->Crud_model->fetch_payee_record('employee', 'status');
		$data['customer_list'] = $result;
		$data['supplier_list'] = $supplierresult;
		$data['employee_list'] = $employeeresult;

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'opening_balance';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO ADD INTO OPENING BALANCE 
	function add_new_balance()
	{

		$account_head = html_escape($this->input->post('account_head'));
		$account_nature   = html_escape($this->input->post('account_nature'));
		$amount   = html_escape($this->input->post('amount'));
		$date   = html_escape($this->input->post('date'));
		$description   = html_escape($this->input->post('description'));
		$customer_id   = html_escape($this->input->post('customer_id'));
		$employee_id   = html_escape($this->input->post('employee_id'));
		$supplier_id   = html_escape($this->input->post('supplier_id'));
		$user_type   = html_escape($this->input->post('user_type'));
		if ($user_type == 2) {
			$supplier_id = $supplier_id;
		} else if ($user_type == 2) {
			$supplier_id = $employee_id;
		} else {
			$supplier_id = $customer_id;
		}

		$data = array(
			'head' => $account_head,
			'nature' => $account_nature,
			'amount' => $amount,
			'date' => $date,
			'description' => $description,
			'customer_id' => $customer_id
		);

		$this->load->model('Transaction_model');
		$result = $this->Transaction_model->opening_balance($data);

		if ($result != NULL) {
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('statements/opening_balance');
	}
	//Statements/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');

		if ($page_name  == 'new_row') {
			$this->load->model('Statement_model');
			$data['accounts_records'] = $this->Statement_model->chart_list();
			$this->load->view('admin_models/accounts/new_row.php', $data);
		}
	}

	//USED TO CREATE JOURNAL ENTRY 
	//Statements/create_journal_voucher
	function create_journal_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$date   = html_escape($this->input->post('date'));
		$account_head   = html_escape($this->input->post('account_head'));
		$debitamount   = html_escape($this->input->post('debitamount'));
		$creditamount   = html_escape($this->input->post('creditamount'));
		$no_jurnal   = html_escape($this->input->post('no_jurnal'));
		$sub_keterangan   = html_escape($this->input->post('sub_keterangan'));

		$customer_id   = html_escape($this->input->post('customer_id'));
		$id_cars   = html_escape($this->input->post('id_cars'));

		$acc[1]   = html_escape($this->input->post('acc_1'));
		$acc[2]   = html_escape($this->input->post('acc_2'));
		$acc[3]  = html_escape($this->input->post('acc_3'));

		if ($date == NULL) {
			$date = date('Y-m-d');
		}
		$count_rows = count($account_head);

		if (!empty($id_cars)) {
			$count_cars = count($id_cars);
		} else {
			$count_cars = 0;
		}
		$status = TRUE;
		$cars = '';
		for ($i = 0; $i < $count_cars; $i++) {
			if (!empty($id_cars[$i])) $cars .= '[' . $id_cars[$i] . ']';
		}


		for ($i = 0; $i < $count_rows; $i++) {
			$creditamount[$i] = preg_replace("/[^0-9]/", "", $creditamount[$i]);
			$debitamount[$i] = preg_replace("/[^0-9]/", "", $debitamount[$i]);
			if ((($debitamount[$i] > 0 and $creditamount[$i] == 0) or ($creditamount[$i] > 0 and $debitamount[$i] == 0) or ($account_head[$i] == 0 and $debitamount[$i] == 0 and $creditamount[$i] == 0))) {
			} else {
				$status = FALSE;
			}
		}

		$data = array(
			'description' => $description,
			'date' => $date,
			'customer_id' => $customer_id,
			'arr_cars' => $cars,
			'account_head' => $account_head,
			'debitamount' => $debitamount,
			'creditamount' => $creditamount,
			'no_jurnal' => $no_jurnal,
			'sub_keterangan' => $sub_keterangan,
			'acc' => $acc
		);

		// var_dump($data);
		// var_dump($status);
		// die();

		if ($status) {
			$this->load->model('Transaction_model');
			if (!empty($data['no_jurnal'])) {
				$res = $this->Transaction_model->check_no_jurnal($data['no_jurnal']);
				if ($res != 0) {
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nomor Jurnal Sudah Ada',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
					$this->journal_voucher($data);
					return;
					// redirect('statements/journal_voucher');
				}
			}
			$result = $this->Transaction_model->journal_voucher_entry($data);
			if ($result != NULL) {
				$this->Transaction_model->activity_edit($result, $acc);
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			} else {
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				$this->journal_voucher($data);
				return;
				// redirect('statements/journal_voucher');
			}
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			$this->journal_voucher($data);
			return;
			// redirect('statements/journal_voucher');
		}
		redirect('statements');
	}

	function edit_journal_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$date   = html_escape($this->input->post('date'));
		$account_head   = html_escape($this->input->post('account_head'));
		$debitamount   = html_escape($this->input->post('debitamount'));
		$creditamount   = html_escape($this->input->post('creditamount'));
		$no_jurnal   = html_escape($this->input->post('no_jurnal'));
		$sub_keterangan   = html_escape($this->input->post('sub_keterangan'));
		$id   = html_escape($this->input->post('id'));
		$sub_id   = html_escape($this->input->post('sub_id'));
		$customer_id   = html_escape($this->input->post('customer_id'));
		$id_cars   = html_escape($this->input->post('id_cars'));

		$acc[1]   = html_escape($this->input->post('acc_1'));
		$acc[2]   = html_escape($this->input->post('acc_2'));
		$acc[3]  = html_escape($this->input->post('acc_3'));

		if ($date == NULL) {
			$date = date('Y-m-d');
		}

		$count_rows = count($account_head);

		if (!empty($id_cars)) {
			$count_cars = count($id_cars);
		} else {
			$count_cars = 0;
		}
		$status = TRUE;
		$cars = '';
		for ($i = 0; $i < $count_cars; $i++) {
			if (!empty($id_cars[$i])) $cars .= '[' . $id_cars[$i] . ']';
		}

		for ($i = 0; $i < $count_rows; $i++) {
			$creditamount[$i] = preg_replace("/[^0-9]/", "", $creditamount[$i]);
			$debitamount[$i] = preg_replace("/[^0-9]/", "", $debitamount[$i]);
			// $sub_id[$i] = $sub_
			// if ((($debitamount[$i] > 0 and $creditamount[$i] == 0) or ($creditamount[$i] > 0 and $debitamount[$i] == 0)) and $account_head[$i] != 0) {
			// } else {
			// 	$status = FALSE;
			// }
		}
		$data = array(
			'id' => $id,
			'customer_id' => $customer_id,
			'arr_cars' => $cars,
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'debitamount' => $debitamount,
			'creditamount' => $creditamount,
			'no_jurnal' => $no_jurnal,
			'sub_keterangan' => $sub_keterangan,
			'sub_id' => $sub_id
		);
		if ($status) {
			$this->load->model('Transaction_model');
			if (!empty($data['no_jurnal'])) {
				$res = $this->Transaction_model->check_no_jurnal($data['no_jurnal'], $id);
				if ($res != 0) {
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nomor Jurnal Sudah Ada !',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
					redirect('statements/edit_jurnal/' . $data['id']);
				}
			}

			$res = $this->Transaction_model->check_lock($id);
			// var_dump($res);
			// die();
			if ($res == 'Y') {
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Sudah di Kunci! ',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('statements/edit_jurnal/' . $data['id']);
			}

			$result = $this->Transaction_model->journal_voucher_edit($data);
			$this->Transaction_model->activity_edit($id, $acc);

			if ($result != NULL) {
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Edit Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			} else {
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);

				redirect('statements/show/' . $data['id']);
			}
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('statements/edit_jurnal/' . $data['id']);
			// redirect('vouchers/journal_voucher');
		}
		redirect('statements/show/' . $data['id']);
		// redirect('statements');
	}

	public function delete_jurnal($id)
	{
		$this->load->model('Transaction_model');
		if (!empty($id)) {
			$res = $this->Transaction_model->check_lock($id);
			// var_dump($res);
			// die();
			if ($res == 'Y') {
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Sudah di Kunci! ',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('statements');
				return;
			}
		}

		$this->Transaction_model->delete_jurnal($id);
		$array_msg = array(
			'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Delet Successfully',
			'alert' => 'info'
		);
		$this->session->set_flashdata('status', $array_msg);
		redirect('statements');
		// $this->Transaction_model->activity_edit($id, $acc);
	}

	public function getListCars()
	{
		$data = $this->input->get();
		$this->load->model('Statement_model');
		$data = $this->Statement_model->getListCars($data);
		if ($data != NULL) {
			echo json_encode(array('error' => false, 'data' => $data));
			return;
		} else {
			echo json_encode(array('error' => true, 'data' => $data));
			return;
		}
		echo ($data);
	}


	function penyebut($nilai)
	{
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = $this->penyebut($nilai - 10) . " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
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
}
