<?php
/*

*/
class NeracaSaldoModel extends CI_Model
{
    public function get_not_akumulation($filter = [], $sheet)
    {
        if ($filter['periode'] == 'tahunan') {
            $QUERY = 'SELECT
                        @names := SUBSTR(mp_head.name, 1, 3) as pars,nature as title,
                        COALESCE((
                        SELECT
                            ROUND(
                                SUM(
                                      IF(SUBSTR(mp_head.name, 2, 1) in (1,5),
                                            (IF(mp_sub_entry.type = 0,mp_sub_entry.amount,-mp_sub_entry.amount)),
                                            (IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)))
                                ),2
                            ) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_sub_entry.parent_id = " -' . $filter['tahun'] . '"
                        ),0) saldo_sebelum,
                       COALESCE((
                        SELECT
                            ROUND(SUM(
                                     IF(mp_sub_entry.parent_id > 0,
                                        IF(SUBSTR(mp_head.name, 2, 1) in (1,5),
                                            (IF(mp_sub_entry.type = 0,mp_sub_entry.amount,-mp_sub_entry.amount)),
                                            (IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)))
                                           ,0)
                            ),2) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_sub_entry.parent_id > 0 AND
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date >= "' . $filter['tahun'] . '-1-1" AND 			mp_generalentry.date <="' . $filter['tahun'] . '-12-31"
                        ),0)  mutasi,
                    mp_head.id,
                    mp_head.name
                    FROM
                        `mp_head`
                    WHERE
                    (
                            SUBSTRING_INDEX(
                                SUBSTRING_INDEX(mp_head.name, ".", -3),
                                "]",
                                1
                            ) = "00.000.000" 
                        ) 
                        AND mp_head.nature in (' . $filter['nature'] . ')
                    GROUP BY
                        SUBSTR(mp_head.name, 1, 5)
            ORDER BY mp_head.name
            ';
        } else if ($filter['bulan'] != 1) {
            $QUERY = 'SELECT
                        @names := SUBSTR(mp_head.name, 1, 3) as pars,nature as title,
                        COALESCE((
                        SELECT
                            ROUND(SUM(
                                    IF(SUBSTR(mp_head.name, 2, 1) in (1,5),
                                            (IF(mp_sub_entry.type = 0,mp_sub_entry.amount,-mp_sub_entry.amount)),
                                            (IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)))
                                        
                                ),2) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date >= "' . $filter['tahun'] . '-1-1"
                        ),0) saldo_sebelum,
                       COALESCE((
                        SELECT
                            ROUND(SUM(
                                IF(SUBSTR(mp_head.name, 2, 1) in (1,5),
                                            (IF(mp_sub_entry.type = 0,mp_sub_entry.amount,-mp_sub_entry.amount)),
                                            (IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)))
                                        ),2) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date >= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date <="' . $filter['tahun'] . '-' . $filter['bulan'] . '-31"
                        ),0)  mutasi,
                    mp_head.id,
                    mp_head.name
                    FROM
                        `mp_head`
                    WHERE
                    (
                            SUBSTRING_INDEX(
                                SUBSTRING_INDEX(mp_head.name, ".", -3),
                                "]",
                                1
                            ) = "00.000.000" 
                        ) 
                        AND mp_head.nature in (' . $filter['nature'] . ')
                    GROUP BY
                        SUBSTR(mp_head.name, 1, 5)
            ORDER BY mp_head.name
            ';
        } else {
            $QUERY = 'SELECT
                        @names := SUBSTR(mp_head.name, 1, 3) as pars,nature as title,
                        COALESCE((
                        SELECT
                            ROUND(
                                SUM(
                                    IF(mp_sub_entry.parent_id < 0,
                                      IF(SUBSTR(mp_head.name, 2, 1) in (1,5),
                                            (IF(mp_sub_entry.type = 0,mp_sub_entry.amount,-mp_sub_entry.amount)),
                                            (IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)))
                                          ,0)
                                ),2
                            ) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date = "' . $filter['tahun'] . '-01-01"
                        ),0) saldo_sebelum,
                       COALESCE((
                        SELECT
                            ROUND(SUM(
                                     IF(mp_sub_entry.parent_id > 0,
                               IF(SUBSTR(mp_head.name, 2, 1) in (1,5),
                                            (IF(mp_sub_entry.type = 0,mp_sub_entry.amount,-mp_sub_entry.amount)),
                                            (IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)))
                                           ,0)
                            ),2) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date >= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date <="' . $filter['tahun'] . '-' . $filter['bulan'] . '-31"
                        ),0)  mutasi,
                    mp_head.id,
                    mp_head.name
                    FROM
                        `mp_head`
                    WHERE
                    (
                            SUBSTRING_INDEX(
                                SUBSTRING_INDEX(mp_head.name, ".", -3),
                                "]",
                                1
                            ) = "00.000.000" 
                        ) 
                        AND mp_head.nature in (' . $filter['nature'] . ')
                    GROUP BY
                        SUBSTR(mp_head.name, 1, 5)
            ORDER BY mp_head.name
            ';
        }

        $res = $this->db->query($QUERY);
        $res = $res->result();
        $i = 0;
        $sheetrow = 7;
        foreach ($res as $re) {

            // $sheet->setCellValue('A' . $sheetrow, substr($re->title, 0, 12));
            $sheet->mergeCells("B" . $sheetrow . ":E" . $sheetrow)->setCellValue('B' . $sheetrow, $re->title);
            $sheet->setCellValue('F' . $sheetrow,  $re->saldo_sebelum);
            $sheet->setCellValue('G' . $sheetrow,  $re->mutasi);
            $sheet->setCellValue('H' . $sheetrow, ($re->saldo_sebelum + $re->mutasi));
            $sheetrow++;
            $sheet->mergeCells("A" . $sheetrow . ":H" . $sheetrow);
            $sheetrow++;
            if (
                $re->saldo_sebelum != 0 or $re->mutasi != 0
            ) {
                if ($filter['periode'] == 'tahunan') {
                    $res2 =  $this->query_count_tahunan($filter, $re->pars, $re->id, 5, -2, '000.000');
                } else if ($filter['bulan'] != 1) {
                    $res2 =  $this->query_count_more_1($filter, $re->pars, $re->id, 5, -2, '000.000');
                } else {
                    $res2 =  $this->query_count_month_1($filter, $re->pars, $re->id, 5, -2, '000.000');
                }
                $k = 0;
                foreach ($res2 as $re2) {
                    if ($re2->saldo_sebelum != 0 or $re2->mutasi != 0) {
                        $sheet->setCellValue('A' . $sheetrow, substr($re2->name, 0, 14));
                        $sheet->mergeCells("C" . $sheetrow . ":E" . $sheetrow)->setCellValue('C' . $sheetrow, substr($re2->name, 15, 25));
                        $sheet->setCellValue('F' . $sheetrow, $re2->saldo_sebelum);
                        $sheet->setCellValue('G' . $sheetrow, $re2->mutasi);
                        $sheet->setCellValue('H' . $sheetrow, ($re2->saldo_sebelum + $re2->mutasi));
                        $sheetrow++;
                        // ===LEVEL 3
                        if ($filter['periode'] == 'tahunan') {
                            $res3 =  $this->query_count_tahunan($filter, $re2->pars, $re2->id, 9, -1, '000');
                        } else if ($filter['bulan'] != 1) {
                            $res3 =  $this->query_count_more_1($filter, $re2->pars, $re2->id, 9, -1, '000');
                        } else {
                            $res3 =  $this->query_count_month_1($filter, $re2->pars, $re2->id, 9, -1, '000');
                        }


                        foreach ($res3 as $re3) {
                            if ($re3->saldo_sebelum != 0 or $re3->mutasi != 0) {
                                $sheet->setCellValue('A' . $sheetrow, substr($re3->name, 1, 12));
                                $sheet->mergeCells("D" . $sheetrow . ":E" . $sheetrow)->setCellValue('D' . $sheetrow, substr($re3->name, 15, 25));
                                $sheet->setCellValue('F' . $sheetrow,  $re3->saldo_sebelum);
                                $sheet->setCellValue('G' . $sheetrow,  $re3->mutasi);
                                $sheet->setCellValue('H' . $sheetrow, ($re3->saldo_sebelum + $re3->mutasi));
                                $sheetrow++;
                                //  LVL 4
                                {

                                    if ($filter['periode'] == 'tahunan') {
                                        $res4 =  $this->query_count_tahunan($filter, $re3->pars, $re3->id, 13, -1, '');
                                    } else if ($filter['bulan'] != 1) {
                                        $res4 =  $this->query_count_more_1($filter, $re3->pars, $re3->id, 13, -1, '');
                                    } else {
                                        $res4 =  $this->query_count_month_1($filter, $re3->pars, $re3->id, 13, -1, '');
                                    }

                                    foreach ($res4 as $re4) {
                                        if ($re4->saldo_sebelum != 0 or $re4->mutasi != 0) {
                                            $sheet->setCellValue('A' . $sheetrow, substr($re4->name, 1, 12));
                                            $sheet->setCellValue('E' . $sheetrow, substr($re4->name, 15, 20));
                                            $sheet->setCellValue('F' . $sheetrow, $re4->saldo_sebelum);
                                            $sheet->setCellValue('G' . $sheetrow,  $re4->mutasi);
                                            $sheet->setCellValue('H' . $sheetrow, ($re4->saldo_sebelum + $re4->mutasi));
                                            $sheetrow++;
                                        }
                                    }
                                }
                                //  END LVL 4
                            }
                        }
                        // ===END LVL 3
                    }
                    if ($re2->saldo_sebelum != 0 or $re2->mutasi != 0) {
                        $sheet->mergeCells("A" . $sheetrow . ":H" . $sheetrow);
                        $sheetrow++;
                    }
                }
            }
            if (
                $re->saldo_sebelum != 0 or $re->mutasi != 0
            ) {
                $sheet->mergeCells("A" . $sheetrow . ":H" . $sheetrow);
                $sheetrow++;
            }
        }
    }
}
