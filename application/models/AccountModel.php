<?php
/*

*/
class AccountModel extends CI_Model
{
    public function chart_of_account($sheet)
    {

        $this->db->select('*');
        $this->db->from('mp_head');
        $this->db->where('SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, ".", -3),"]",1 ) = "00.000.000"');

        $res = $this->db->get();
        $res = $res->result();
        $i = 0;
        $sheetrow = 7;
        foreach ($res as $re) {

            $sheet->setCellValue('A' . $sheetrow, substr($re->name, 1, 12));
            $sheet->mergeCells("B" . $sheetrow . ":E" . $sheetrow)->setCellValue('B' . $sheetrow, explode("]",  $re->name)[1]);
            $sheet->setCellValue('F' . $sheetrow,  $re->nature);
            $sheet->setCellValue('G' . $sheetrow,  $re->type);
            $sheetrow++; {
                $res2 =  $this->query_find_account(substr($re->name, 0, 2), $re->id, 5, -2, '000.000');
                foreach ($res2 as $re2) {
                    $sheet->setCellValue('A' . $sheetrow, substr($re2->name, 1, 12));
                    $sheet->mergeCells("C" . $sheetrow . ":E" . $sheetrow)->setCellValue('C' . $sheetrow, explode("]",  $re2->name)[1]);
                    $sheet->setCellValue('F' . $sheetrow,  $re2->nature);
                    $sheet->setCellValue('G' . $sheetrow,  $re2->type);
                    $sheetrow++;
                    // ===LEVEL 3
                    $res3 =  $this->query_find_account(substr($re2->name, 0, 6), $re2->id, 9, -1, '000');
                    foreach ($res3 as $re3) {
                        $sheet->setCellValue('A' . $sheetrow, substr($re3->name, 1, 12));
                        $sheet->mergeCells("D" . $sheetrow . ":E" . $sheetrow)->setCellValue('D' . $sheetrow, explode("]",  $re3->name)[1]);
                        $sheet->setCellValue('F' . $sheetrow,  $re3->nature);
                        $sheet->setCellValue('G' . $sheetrow,  $re3->type);
                        $sheetrow++;
                        $res4 =  $this->query_find_account(substr($re2->name, 0, 12), $re3->id, 13, -1, '');
                        foreach ($res4 as $re4) {
                            $sheet->setCellValue('A' . $sheetrow, substr($re4->name, 1, 12));
                            $sheet->mergeCells("E" . $sheetrow . ":E" . $sheetrow)->setCellValue('E' . $sheetrow, explode("]",  $re4->name)[1]);
                            $sheet->setCellValue('F' . $sheetrow,  $re4->nature);
                            $sheet->setCellValue('G' . $sheetrow,  $re4->type);
                            $sheetrow++;
                        }
                    }
                    // ===END LVL 3

                }
            }
        }
        // die();
    }

    function query_find_account($pars, $id, $leng, $var1, $var2)
    {

        // $res = $this->db->query($QUERY);

        $this->db->select('*');
        $this->db->from('mp_head');
        $this->db->order_by('name');
        $this->db->where(' SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, "]", 1),"[",-1),"." ,' . $var1 . ') ' . ($var2 == '' ? ('!= "000') : ('= "' . $var2))  . '" 
                                        AND mp_head.name like "' . $pars . '%"
                                        AND mp_head.id !=  "' . $id . '"');

        $res = $this->db->get();
        // $res = $res->result();

        return $res->result();
    }
}
