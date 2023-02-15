<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelControl extends CI_Controller
{
    function index()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);

        $filename = 'name-of-the-generated-file';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 

    }

    public function neraca_saldo()
    {
        $filter = $this->input->get();
        if (empty($filter['from'])) $filter['from'] = date('Y-m-1');
        if (empty($filter['to'])) $filter['to'] = date('Y-m-t');

        $this->load->model('General_model');
        $data = $this->General_model->getAllBaganAkun(array('by_DataStructure2' => true));
        $data = $this->General_model->neraca_saldo($data, $filter);
        // echo json_encode($data);
        // die();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setWidth(5);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal('center')->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFont()->setSize(12)->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

        $sheet->getStyle('E:F')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

        $this->load->model('Statement_model');
        $sheet->mergeCells("A1:F1");
        $sheet->mergeCells("A2:F2");
        $sheet->mergeCells("A3:F3");
        $sheet->setCellValue('A1', 'PT INDOMETAL ASIA');
        $sheet->setCellValue('A2', 'JURNAL UMUM');
        $sheet->setCellValue('A3', 'Periode : ' . $filter['from'] . ' s.d. ' . $filter['to']);
        $sheet->mergeCells("A5:D5");

        $sheet->setCellValue('A5', 'AKUN');
        // $sheet->setCellValue('B5', 'NO JURNAL');
        // $sheet->setCellValue('C5', 'AKUN');
        // $sheet->setCellValue('D5', 'SUB KETERANGAN');
        $sheet->setCellValue('E5', 'DEBIT');
        $sheet->setCellValue('F5', 'KREDIT');
        $rows = 6;

        foreach ($data as $key1 => $lv1) {
            if (!empty($lv1['datas'])) {
                $sheet->mergeCells("A" . $rows . ":D" . $rows);
                $sheet->setCellValue('A' . $rows, '[' . $lv1['head_number'] . '] ' . $lv1['name']);
                $sheet->setCellValue('E' . $rows, $lv1['datas']['debit']);
                $sheet->setCellValue('F' . $rows, $lv1['datas']['kredit']);
                $rows++;
            }

            if (!empty($data[$key1]['open']) and !empty($lv1['children']))
                foreach ($lv1['children'] as $key2 => $lv2) {
                    if (!empty($lv2['datas'])) {
                        $sheet->mergeCells("B" . $rows . ":D" . $rows);
                        $sheet->setCellValue('B' . $rows, '[' . $lv2['head_number'] . '] ' . $lv2['name']);
                        $sheet->setCellValue('E' . $rows, $lv2['datas']['debit']);
                        $sheet->setCellValue('F' . $rows, $lv2['datas']['kredit']);
                        $rows++;
                    }

                    if (!empty($data[$key1]['children'][$key2]['open']) and !empty($lv2['children']))
                        foreach ($lv2['children'] as $key3 => $lv3) {
                            if (!empty($lv3['datas'])) {
                                $sheet->mergeCells("C" . $rows . ":D" . $rows);
                                $sheet->setCellValue('C' . $rows, '[' . $lv3['head_number'] . '] ' . $lv3['name']);
                                $sheet->setCellValue('E' . $rows, $lv3['datas']['debit']);
                                $sheet->setCellValue('F' . $rows, $lv3['datas']['kredit']);
                                $rows++;
                            }

                            if (!empty($data[$key1]['children'][$key2]['children'][$key3]['open']) and !empty($lv3['children']))
                                foreach ($lv3['children'] as $key4 => $lv4) {
                                    if (!empty($lv4['datas'])) {
                                        $sheet->mergeCells("C" . $rows . ":D" . $rows);
                                        $sheet->setCellValue('C' . $rows, '[' . $lv4['head_number'] . '] ' . $lv4['name']);
                                        $sheet->setCellValue('E' . $rows, $lv4['datas']['debit']);
                                        $sheet->setCellValue('F' . $rows, $lv4['datas']['kredit']);
                                        $rows++;
                                    }
                                }
                        }
                }


            //             $res = $this->sum_debit_and_credit($lv2['head_number'], $filter);
            //             if ($res['debit'] > 0 or $res['kredit'] > 0) {
            //                 $data[$key1]['children'][$key2]['datas'] = $res;
            //                 $data[$key1]['children'][$key2]['open'] = true;

            //                 if (!empty($lv2['children']))
            //                     foreach ($lv2['children'] as $key3 => $lv3) {
            //                         $res = $this->sum_debit_and_credit($lv3['head_number'], $filter);
            //                         if ($res['debit'] > 0 or $res['kredit'] > 0) {
            //                             $data[$key1]['children'][$key2]['children'][$key3]['datas'] = $res;
            //                             $data[$key1]['children'][$key2]['children'][$key3]['open'] = true;

            //                             if (!empty($lv3['children']))
            //                                 foreach ($lv3['children'] as $key4 => $lv4) {
            //                                     $res = $this->sum_debit_and_credit($lv4['head_number'], $filter);
            //                                     if ($res['debit'] > 0 or $res['kredit'] > 0) {
            //                                         $data[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['datas'] = $res;
            //                                         $data[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['open'] = true;
            //                                     }
            //                                 }
            //                         }
            //                     }
            //             }
            //         }
            // }
        }


        // $rows = 6;
        // foreach ($data as $parent) {
        //     $cur_debit = 0;
        //     $cur_kredit = 0;
        //     foreach ($parent['children'] as $child) {
        //         $sheet->setCellValue('A' . $rows, $parent['date']);
        //         $sheet->setCellValue('B' . $rows, $parent['no_jurnal']);
        //         $sheet->setCellValue('C' . $rows, $child['head_name']);
        //         $sheet->setCellValue('D' . $rows, $child['sub_keterangan']);
        //         if ($child['type'] == 0) {
        //             $cur_debit += $child['amount'];
        //             $sheet->setCellValue('E' . $rows, $child['amount']);
        //         } else {
        //             $cur_kredit += $child['amount'];
        //             $sheet->setCellValue('F' . $rows, $child['amount']);
        //         }
        //         $rows++;
        //     }
        //     $sheet->getRowDimension($rows)->setRowHeight(5);
        //     $sheet->mergeCells("E" . $rows . ":F" . $rows)->setCellValue('E' . $rows,  '__________________________________________________');
        //     $rows++;
        //     $sheet->setCellValue('E' . $rows, $cur_debit);
        //     $sheet->setCellValue('F' . $rows, $cur_kredit);
        //     $rows++;
        //     $rows++;
        // }

        $spreadsheet->getActiveSheet()->getStyle('A5:F' . $rows)->getFont()->setSize(9)->setBold(false);

        $writer = new Xlsx($spreadsheet);

        $filename = 'Neraca Saldo ' . $filter['from'] . '_sd_' . $filter['to'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 


    }

    public function jurnal_umum()
    {
        $filter = $this->input->get();

        $this->load->model('General_model');
        if (empty($filter['from'])) $filter['from'] = date('Y-m-1');
        if (empty($filter['to'])) $filter['to'] = date('Y-m-t');

        $data = $this->General_model->getJurnalUmum($filter);
        $spreadsheet = new Spreadsheet();


        $rows = 1;
        if (!empty($filter['format'])) {
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);
            // $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal('center')->setWrapText(true);
            // $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFont()->setSize(12)->setBold(true);
            // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12)->setBold(true);
            // $spreadsheet->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

            $sheet->getStyle('E:F')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

            $this->load->model('Statement_model');
            // $sheet->mergeCells("A1:F1");
            // $sheet->mergeCells("A2:F2");
            // $sheet->mergeCells("A3:F3");
            // $sheet->setCellValue('A1', 'PT INDOMETAL ASIA');
            // $sheet->setCellValue('A2', 'JURNAL UMUM');
            // $sheet->setCellValue('A3', 'Periode : ' . $filter['from'] . ' s.d. ' . $filter['to']);

            // $sheet->setCellValue('A5', 'TANGGAL');
            // $sheet->setCellValue('B5', 'NO JURNAL');
            // $sheet->setCellValue('C5', 'AKUN');
            // $sheet->setCellValue('D5', 'SUB KETERANGAN');
            // $sheet->setCellValue('E5', 'DEBIT');
            // $sheet->setCellValue('F5', 'KREDIT');


            foreach ($data as $parent) {
                // $cur_debit = 0;
                // $cur_kredit = 0;
                foreach ($parent['children'] as $child) {
                    $sheet->setCellValue('A' . $rows, $parent['date']);
                    $sheet->setCellValue('B' . $rows, $parent['no_jurnal']);
                    $sheet->setCellValue('C' . $rows, $child['head_name']);
                    $sheet->setCellValue('D' . $rows, $child['sub_keterangan']);
                    if ($child['type'] == 0) {
                        // $cur_debit += $child['amount'];
                        $sheet->setCellValue('E' . $rows, $child['amount']);
                    } else {
                        // $cur_kredit += $child['amount'];
                        $sheet->setCellValue('F' . $rows, $child['amount']);
                    }
                    $rows++;
                }
                // $sheet->getRowDimension($rows)->setRowHeight(5);
                // $sheet->mergeCells("E" . $rows . ":F" . $rows)->setCellValue('E' . $rows,  '__________________________________________________');
                // $rows++;
                // $sheet->setCellValue('E' . $rows, $cur_debit);
                // $sheet->setCellValue('F' . $rows, $cur_kredit);
                // $rows++;
                // $rows++;
            }
        } else {
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(12);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal('center')->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFont()->setSize(12)->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12)->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

            $sheet->getStyle('E:F')->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

            $this->load->model('Statement_model');
            $sheet->mergeCells("A1:F1");
            $sheet->mergeCells("A2:F2");
            $sheet->mergeCells("A3:F3");
            $sheet->setCellValue('A1', 'PT INDOMETAL ASIA');
            $sheet->setCellValue('A2', 'JURNAL UMUM');
            $sheet->setCellValue('A3', 'Periode : ' . $filter['from'] . ' s.d. ' . $filter['to']);

            $sheet->setCellValue('A5', 'TANGGAL');
            $sheet->setCellValue('B5', 'NO JURNAL');
            $sheet->setCellValue('C5', 'AKUN');
            $sheet->setCellValue('D5', 'SUB KETERANGAN');
            $sheet->setCellValue('E5', 'DEBIT');
            $sheet->setCellValue('F5', 'KREDIT');


            foreach ($data as $parent) {
                $cur_debit = 0;
                $cur_kredit = 0;
                foreach ($parent['children'] as $child) {
                    $sheet->setCellValue('A' . $rows, $parent['date']);
                    $sheet->setCellValue('B' . $rows, $parent['no_jurnal']);
                    $sheet->setCellValue('C' . $rows, $child['head_name']);
                    $sheet->setCellValue('D' . $rows, $child['sub_keterangan']);
                    if ($child['type'] == 0) {
                        $cur_debit += $child['amount'];
                        $sheet->setCellValue('E' . $rows, $child['amount']);
                    } else {
                        $cur_kredit += $child['amount'];
                        $sheet->setCellValue('F' . $rows, $child['amount']);
                    }
                    $rows++;
                }
                $sheet->getRowDimension($rows)->setRowHeight(5);
                $sheet->mergeCells("E" . $rows . ":F" . $rows)->setCellValue('E' . $rows,  '__________________________________________________');
                $rows++;
                $sheet->setCellValue('E' . $rows, $cur_debit);
                $sheet->setCellValue('F' . $rows, $cur_kredit);
                $rows++;
                $rows++;
            }
            $spreadsheet->getActiveSheet()->getStyle('A5:F' . $rows)->getFont()->setSize(9)->setBold(false);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'Jurnal Umum ' . $filter['from'] . '_sd_' . $filter['to'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 
    }
}
