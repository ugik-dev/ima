<?php
/*

*/
class Statement_model extends CI_Model
{
    //USED TO FETCH TRANSACTIONS FOR GENERAL JOURNAL
    public function getSingelJurnal($filter = [])
    {

        $total_debit = 0;
        $total_credit = 0;
        $form_content = '';

        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.customer_id,mp_generalentry.arr_cars,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal, gen_lock");
        if (!empty($filter['draft'])) {
            if ($filter['draft'] == 'draft')
                $this->db->from('draft_generalentry as mp_generalentry');
            else
                $this->db->from('mp_generalentry');
        } else {

            $this->db->from('mp_generalentry');
        }
        // if (!empty($filter['id']))
        $this->db->where('id', $filter['id']);
        // $this->db->where('date >=', $date1);
        // $this->db->where('date <=', $date2);
        $this->db->order_by('mp_generalentry.id', 'DESC');
        $query = $this->db->get();
        $transaction_records =  $query->result()['0'];
        if ($transaction_records  != NULL) {
            $this->db->select("mp_sub_entry.*,mp_head.name");
            if (!empty($filter['draft'])) {
                if ($filter['draft'] == 'draft')
                    $this->db->from('draft_sub_entry as mp_sub_entry');
                else
                    $this->db->from('mp_sub_entry');
            } else {

                $this->db->from('mp_sub_entry');
            }
            // $this->db->from('mp_sub_entry');
            $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
            $this->db->where('mp_sub_entry.parent_id =', $transaction_records->transaction_id);
            $sub_query = $this->db->get();
            // var_dump($sub_query);
            // die();
            if ($sub_query->num_rows() > 0) {
                $sub_query =  $sub_query->result();
            }
        }
        $data['parent'] = $transaction_records;
        $data['sub_parent'] = $sub_query;
        // echo json_encode($filter);
        // die();
        return $data;
    }

    public function fetch_transasctions($filter)
    {

        $total_debit = 0;
        $total_credit = 0;
        $form_content = '';
        $return_data = [];

        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal, gen_lock");

        if (!empty($filter['draft']))
            $this->db->from('draft_generalentry as mp_generalentry');
        else
            $this->db->from('mp_generalentry');

        if (!empty($filter['no_jurnal']))
            $this->db->where('no_jurnal like "%' . $filter['no_jurnal'] . '%"');

        if (!empty($filter['from'])) $this->db->where('date >=', $filter['from']);
        if (!empty($filter['to'])) $this->db->where('date <=', $filter['to']);

        $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        $i = 0;
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result_array();
            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $this->db->select("mp_sub_entry.*,mp_head.name");
                    if (!empty($filter['draft']))
                        $this->db->from('draft_sub_entry as mp_sub_entry');
                    else
                        $this->db->from('mp_sub_entry');

                    // $this->db->from('mp_sub_entry');
                    $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
                    $this->db->where('mp_sub_entry.parent_id =', $transaction_record['transaction_id']);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result_array();
                        if ($sub_query != NULL) {
                            $return_data[$i] = $transaction_record;
                            $return_data[$i]['data_sub'] = $sub_query;
                        }
                    }
                    // echo json_encode($return_data);
                    // die();
                    $i++;
                }
            }
        }
        return $return_data;
    }


    public function getEvent($filter)
    {

        $this->db->select("*");
        $this->db->from('mp_event');
        // $this->db->join('mp_users', 'mp_activity.user_id = mp_users.id');
        // if (!empty($filter['no_jurnal']))
        //     $this->db->where('no_jurnal like "%' . $filter['no_jurnal'] . '%"');
        // if (!empty($filter['from'])) $this->db->where('date_activity >=', $filter['from']);
        // if (!empty($filter['to'])) $this->db->where('date_activity <=', $filter['to']);
        // if (!empty($filter['user_id'])) $this->db->where('user_id', $filter['user_id']);

        // $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        $i = 0;
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result_array();
        } else {
            return NULL;
        }
        // echo json_encode($transaction_records);
        // die();
        return $transaction_records;
    }

    public function my_activity($filter)
    {

        $total_debit = 0;
        $total_credit = 0;
        $form_content = '';
        $return_data = [];

        $this->db->select("mp_activity.*, mp_users.agentname as user_name");
        $this->db->from('mp_activity');
        $this->db->join('mp_users', 'mp_activity.user_id = mp_users.id');
        // if (!empty($filter['no_jurnal']))
        //     $this->db->where('no_jurnal like "%' . $filter['no_jurnal'] . '%"');
        if (!empty($filter['from'])) $this->db->where('date_activity >=', $filter['from']);
        if (!empty($filter['to'])) $this->db->where('date_activity <=', $filter['to']);
        if (!empty($filter['user_id'])) $this->db->where('user_id', $filter['user_id']);

        // $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        $i = 0;
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result_array();
        } else {
            return NULL;
        }
        // echo json_encode($transaction_records);
        // die();
        return $transaction_records;
    }


    public function fetch_transasctions_old($filter)
    {

        $total_debit = 0;
        $total_credit = 0;
        $form_content = '';

        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal, gen_lock");
        $this->db->from('mp_generalentry');
        if (!empty($filter['no_jurnal']))
            $this->db->where('no_jurnal like "%' . $filter['no_jurnal'] . '%"');
        $this->db->where('date >=', $filter['from']);
        $this->db->where('date <=', $filter['to']);

        $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result();

            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $this->db->select("mp_sub_entry.*,mp_head.name");
                    $this->db->from('mp_sub_entry');
                    $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
                    $this->db->where('mp_sub_entry.parent_id =', $transaction_record->transaction_id);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result();
                        if ($sub_query != NULL) {
                            foreach ($sub_query as $single_trans) {
                                if ($single_trans->type == 0) {
                                    $form_content .= '<tr>
                            <td id="date_' . $transaction_record->transaction_id . '">' . $transaction_record->date . '</td>
                            <td>
                            <p  class="rinc_name_' . $transaction_record->transaction_id . '">' . $single_trans->name . '</p>
                            </td>
                            <td>
                            <p class="rinc_ket_' . $transaction_record->transaction_id . '">' . $single_trans->sub_keterangan . '</p>
                                </td>
                            <td>
                                <p  class="currency rinc_debit_' . $transaction_record->transaction_id . '">' . $single_trans->amount . '</p>
                            </td>
                            <td>
                                <p class="rinc_kredit_' . $transaction_record->transaction_id . '"></p>
                            </td>          
                            </tr>';
                                } else if ($single_trans->type == 1) {
                                    $form_content .= '<tr>
                            <td>' . $transaction_record->date . '</td><td ><p class="general-journal-credit rinc_name_' . $transaction_record->transaction_id . '" >' . $single_trans->name . '</p>
                            </td>
                            <td>
                            <p class="rinc_ket_' . $transaction_record->transaction_id . '" >' . $single_trans->sub_keterangan . '</p>
                                </td>
                            <td>
                                <p class="rinc_debit_' . $transaction_record->transaction_id . '"></p>
                            </td>
                            <td>
                                <p  class="currency rinc_kredit_' . $transaction_record->transaction_id . '">' . $single_trans->amount . '</p>
                            </td>           
                            </tr>';
                                }
                            }
                        }
                    }
                    if ($this->session->userdata('user_id')['nama_role'] != 'direktur') {
                        $btn_lock = ' 
                        <a href="' . base_url() . 'statements/edit_jurnal/' . $transaction_record->transaction_id . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-list-alt pull-left"></i> Edit</a> 
                          ';
                    } else {
                        $btn_lock = '';
                    };
                    $form_content .= '<tr class="narration" >
                    <td class="border-bottom-journal" colspan="5">
                     <h6 id="naration_' . $transaction_record->transaction_id . '">' . (empty($transaction_record->naration) ? '-' : $transaction_record->naration) . '</h6>
                       
                       <h7> No Jurnal : ' . $transaction_record->no_jurnal . '</h7> 
                       <br>
                       <a href="' . base_url() . 'statements/delete_jurnal/' . $transaction_record->transaction_id . '" class="btn btn-default btn-outline-danger mr-1 my-1 no-print" style="float: right"><i class="fa fa-trash  pull-left"></i> Delete </a>
                      <a href="' . base_url() . 'statements/copy_jurnal/' . $transaction_record->transaction_id . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-copy  pull-left"></i> Copy </a>
                      <a href="' . base_url() . 'statements/show/' . $transaction_record->transaction_id . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-eye  pull-left"></i> Show </a>
                       ' .
                        ($transaction_record->gen_lock != 'Y' ? $btn_lock : '') . '
                        </td>
                        </tr>';
                }
            }
        }
        return $form_content;
    }

    public function find_cars($id)
    {
        $this->db->select('id,id_customer,name_cars,no_cars');
        $this->db->from('mp_cars');
        $this->db->where('id', $id);
        $sub_query = $this->db->get();
        $subs =  $sub_query->result_array();
        if (empty($subs[0])) {
            return;
        }
        return $subs[0];
    }
    public function detail_fetch_transasctions($filter)
    {

        $total_debit = 0;
        $total_credit = 0;
        $form_content = '';

        $this->db->select("mp_g.id as transaction_id,mp_payee.customer_name,mp_g.date,mp_g.customer_id,arr_cars,mp_g.naration,mp_g.no_jurnal, gen_lock");
        if ($filter['draft'])
            $this->db->from('draft_generalentry as mp_g');
        else
            $this->db->from('mp_generalentry as mp_g');
        // $this->db->where('date >=', $date1);
        $this->db->join('mp_payee', 'mp_payee.id = mp_g.customer_id', 'LEFT');
        $this->db->where('mp_g.id', $filter['id']);
        $this->db->order_by('mp_g.id', 'DESC');
        $data = [];
        $query = $this->db->get();
        $transaction_records =  $query->result();
        if (empty($transaction_records[0])) {
            return;
        }
        $data['parent'] = $transaction_records[0];
        if ($query->num_rows() > 0) {

            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $this->db->select("mp_s.*,mp_head.name");
                    if ($filter['draft'])
                        $this->db->from('draft_sub_entry as mp_s');
                    else
                        $this->db->from('mp_sub_entry as mp_s');

                    // $this->db->from('');
                    $this->db->join('mp_head', 'mp_head.id = mp_s.accounthead');
                    // $this->db->order_by('mp_sub_entry.type');

                    $this->db->where('mp_s.parent_id =', $transaction_records[0]->transaction_id);
                    $sub_query = $this->db->get();
                    $subs =  $sub_query->result_array();
                    if (empty($subs[0])) {
                        return;
                    }
                    $data['sub'] = $subs;
                    // $data['transaction'] = $transaction_records[0];
                }
            }
        }
        // echo json_encode($data);
        // die();
        return $data;
    }

    public function detail_fetch_transasctions_filter($filter = [])
    {


        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.customer_id,arr_cars,mp_generalentry.naration,mp_generalentry.no_jurnal, gen_lock");
        $this->db->from('mp_generalentry');
        if (!empty($filter['id'])) $this->db->where('mp_generalentry.id', $filter['id']);
        if (!empty($filter['no_jurnal'])) $this->db->where('mp_generalentry.no_jurnal', $filter['no_jurnal']);
        $this->db->order_by('mp_generalentry.id', 'DESC');
        $data = [];
        $query = $this->db->get();
        $transaction_records =  $query->result();
        if (empty($transaction_records[0])) {
            return NULL;
        }
        $data['parent'] = $transaction_records[0];
        if ($query->num_rows() > 0) {

            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $this->db->select("mp_sub_entry.*,mp_head.name");
                    $this->db->from('mp_sub_entry');
                    $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
                    $this->db->where('mp_sub_entry.parent_id =', $transaction_records[0]->transaction_id);
                    $sub_query = $this->db->get();
                    $subs =  $sub_query->result_array();
                    if (empty($subs[0])) {
                        return;
                    }
                    $data['sub'] = $subs;
                    // $data['transaction'] = $transaction_records[0];
                }
            }
        }
        // echo json_encode($data);
        // die();
        return $data;
    }

    public function export_excel($date1, $date2, $sheet)
    {
        $sheetrow = 6;
        // $sheet->setCellValue('A2', 'Hello from model !');
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal, gen_lock");
        $this->db->from('mp_generalentry');
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
        $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result();

            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $this->db->select("mp_sub_entry.*,mp_head.name");
                    $this->db->from('mp_sub_entry');
                    $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
                    $this->db->where('mp_sub_entry.parent_id =', $transaction_record->transaction_id);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result();
                        if ($sub_query != NULL) {
                            foreach ($sub_query as $single_trans) {
                                $sheet->setCellValue('A' . $sheetrow, $transaction_record->date);
                                $sheet->setCellValue('B' . $sheetrow, $transaction_record->no_jurnal);
                                $sheet->setCellValue('C' . $sheetrow, $single_trans->name);
                                $sheet->setCellValue('D' . $sheetrow, $single_trans->sub_keterangan);

                                if ($single_trans->type == 0) {
                                    $sheet->setCellValue('E' . $sheetrow, $single_trans->amount);
                                } else if ($single_trans->type == 1) {
                                    $sheet->setCellValue('F' . $sheetrow, $single_trans->amount);
                                }
                                $sheetrow++;
                            }
                        }
                    }
                }
            }
        }
    }

    public function export_excel_ledger($filter, $sheet, $spreadsheet)
    {
        $sheetrow = 6;
        $accounts_types = array('Assets', 'Liability', 'Equity', 'Revenue', 'Expense');
        for ($i = 0; $i  < count($accounts_types); $i++) {
            $k = 0;
            $this->db->select('mp_head.*');
            $this->db->from('mp_head');
            $this->db->order_by('mp_head.name');
            if (!empty($filter['account_head'])) $this->db->where('mp_head.id', $filter['account_head']);
            $this->db->where(['mp_head.nature' => $accounts_types[$i]]);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $heads_record =  $query->result();
                foreach ($heads_record as $single_head) {
                    $data_leadger = $this->get_ledger_transactions($single_head->id, $filter['from'], $filter['to']);
                    if ($data_leadger != NULL) {
                        $j = 0;
                        $total_ledger = 0;
                        $ledger_query  = array();
                        foreach ($data_leadger as $single_ledger) {
                            if ($k == 0) {
                                $sheet->mergeCells("A" . $sheetrow . ":F" . $sheetrow);
                                $sheet->setCellValue('A' . $sheetrow, $accounts_types[$i]);
                                $sheet->getRowDimension($sheetrow)->setRowHeight(23);
                                $sheet->getStyle('A' . $sheetrow)->getAlignment()->setVertical('center')->setHorizontal('left')->setWrapText(true);
                                $sheet->getStyle('A' . $sheetrow)->getFont()->setSize(16)->setBold(true);
                                $sheetrow++;
                            }
                            $k++;
                            if ($j == 0) {
                                $sheet->mergeCells("A" . $sheetrow . ":F" . $sheetrow);
                                $sheet->setCellValue('A' . $sheetrow, $single_head->name);
                                // $sheet->getRowDimension('6')->setRowHeight(40);
                                $sheet->getStyle('A' . $sheetrow)->getAlignment()->setVertical('center')->setHorizontal('lefft')->setWrapText(true);
                                $sheet->getStyle('A' . $sheetrow)->getFont()->setBold(true);
                                $sheetrow++;
                            }
                            $j++;
                            $debitamount = '';
                            $creditamount = '';
                            $total_ledger = number_format($total_ledger, '2', '.', '');
                            $sheet->setCellValue('A' . $sheetrow, $single_ledger->date);
                            $sheet->setCellValue('B' . $sheetrow, $single_ledger->no_jurnal);
                            $sheet->setCellValue('C' . $sheetrow, $single_ledger->sub_keterangan);
                            if ($single_ledger->type == 0) {
                                $debitamount = $single_ledger->amount;
                                $sheet->setCellValue('D' . $sheetrow, $single_ledger->amount);
                                $total_ledger = $total_ledger + $debitamount;
                            } else if (
                                $single_ledger->type == 1
                            ) {
                                $creditamount = $single_ledger->amount;
                                $sheet->setCellValue('E' . $sheetrow, $single_ledger->amount);
                                $total_ledger = $total_ledger - $creditamount;
                            }
                            $sheet->setCellValue('F' . $sheetrow, $total_ledger);

                            $sheetrow++;
                        }
                    }
                }
            }
        }
    }


    //USED TO GET THE LEDGER USING NATURE 
    public function get_ledger_transactions($head_id, $date1, $date2)
    {
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.no_jurnal,mp_generalentry.naration,mp_generalentry.no_jurnal,mp_head.name,mp_head.nature,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
        $this->db->order_by('mp_generalentry.date', 'desc');
        // $this->db->order_by('mp_generalentry.no_jurnal', 'asc');
        $this->db->order_by("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_generalentry.no_jurnal, '/', -3), '/', 1) ASC");

        $this->db->where('mp_head.id', $head_id);
        $this->db->where('mp_generalentry.date >=', $date1);
        $this->db->where('mp_generalentry.date <=', $date2);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    //USED TO GET THE LEDGER USING NATURE 
    public function the_ledger($filter)
    {
        // var_dump($filter['account_head']);
        // die();
        $accounts_types = array('Assets', 'Liability', 'Equity', 'Revenue', 'Expense');
        $form_content = '';
        for ($i = 0; $i  < count($accounts_types); $i++) {
            $form_content .= '<h4 class=""><b>' . $accounts_types[$i] . ' : </b></h4>';
            $this->db->select('mp_head.*');
            $this->db->from('mp_head');
            $this->db->order_by('mp_head.name');
            if (!empty($filter['account_head'])) $this->db->where('mp_head.id', $filter['account_head']);
            $this->db->where(['mp_head.nature' => $accounts_types[$i]]);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $heads_record =  $query->result();
                foreach ($heads_record as $single_head) {
                    $data_leadger = $this->get_ledger_transactions($single_head->id, $filter['from'], $filter['to']);
                    if ($data_leadger != NULL) {
                        $total_ledger = 0;
                        $ledger_query  = array();
                        $form_content .= '<hr />                                       
                    
                        <table id="1" class="table table-striped table-hover">
                        <div class=" ledger_row_head" style=" text-transform:uppercase;">
                                <b>' . $single_head->name . '</b>
                        </div>
         
                        <thead class="ledger-table-head">
                             <th class="">TANGGAL</th>
                             <th class="">NO JURNAL</th>
                             <th class="">TRANSAKSI</th>
                             <th class="">DEBIT</th>                
                             <th class="">KREDIT</th>
                             <th class="">SALDO</th>
                        </thead>
                        <tbody>';

                        foreach ($data_leadger as $single_ledger) {
                            $debitamount = '';
                            $creditamount = '';

                            if ($single_ledger->type == 0) {
                                $debitamount = $single_ledger->amount;
                                $total_ledger = $total_ledger + $debitamount;
                            } else if ($single_ledger->type == 1) {
                                $creditamount = $single_ledger->amount;
                                $total_ledger = $total_ledger - $creditamount;
                            } else {
                            }

                            $total_ledger = number_format($total_ledger, '2', '.', '');

                            $form_content .= '<tr>
                        <td>' . $single_ledger->date . '</td><td> <a href="' . base_url('statements/show/') . $single_ledger->parent_id . '">' . $single_ledger->no_jurnal . '</td><td><a >' . $single_ledger->sub_keterangan . '</a></td><td>
                            <a  class="currency">' .
                                (!empty($debitamount) ? number_format($debitamount, 2, ',', '.') : '') .
                                '</a>
                        </td>
                        <td>
                            <a   class="currency">' .
                                (!empty($creditamount) ? number_format($creditamount, 2, ',', '.') : '')
                                . '</a>
                        </td>
                        <td  >' . ($total_ledger < 0 ? '( <a class="currency">' . number_format(-$total_ledger, 2, ',', '.') . '</a>)' : '<a class="currency">' . number_format($total_ledger, 2, ',', '.') . '</a>') . '</td>            
                    </tr>';
                        }
                    }
                    $form_content .= '</tbody></table>';
                }
            }
        }
        return $form_content;
    }



    //USED TO COUNT SINGLE HEAD 
    public function count_head_amount($head_id, $date1, $date2)
    {
        $count_total_amt = 0;
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
        $this->db->where('mp_sub_entry.accounthead', $head_id);
        $this->db->where('mp_generalentry.date >=', $date1);
        $this->db->where('mp_generalentry.date <=', $date2);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            $count_total_amt = 0;
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_ledger) {
                    if ($single_ledger->type == 0) {
                        $count_total_amt = $count_total_amt + $single_ledger->amount;
                    } else {
                        $count_total_amt = $count_total_amt - $single_ledger->amount;
                    }
                }
            }
        }

        if ($count_total_amt == 0) {
            $count_total_amt  = NULL;
        } else {
            $count_total_amt = number_format($count_total_amt, '2', '.', '');
        }

        return $count_total_amt;
    }

    //USED TO GENERATE TRAIL BALANCE 
    public function trail_balance($current_date)
    {
        //ACCOUNTING START DATE
        $date1 = '2019-01-01';

        $date2 = $current_date;

        $total_debit  = 0;
        $total_credit = 0;
        $from_creator = '';

        $this->db->select("h.*");
        $this->db->from('mp_head as h');
        // $this->db->join('mp_generalentrys as g', 'g.id = h.id_parent');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_head) {
                    $debitamt  = 0;
                    $creditamt = 0;
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);

                    if ($amount != NULL) {
                        if ($amount > 0) {
                            $debitamt    = $amount;
                            $total_debit = $total_debit + $amount;
                        } else {
                            $creditamt    = ($amount == 0 ? $amount : -$amount);
                            $total_credit = $total_credit + $creditamt;
                        }

                        $from_creator .= '<tr><td style=text-align:left;><h4>' . $single_head->name . '</h4></td><td><h4 class="currency">' . $debitamt . '</h4></td><td><h4  class="currency">' . $creditamt . '</h4></td></tr>';
                    }
                }

                $from_creator .= '<tr class="balancesheet-row"><td></td><td><h4  class="currency">' . $total_debit . '</h4></td><td><h4  class="currency">' . $total_credit . '</h4></td></tr>';
            }
        }

        return  $from_creator;
    }

    public function income_statement($date1, $date2)
    {
        $total_revenue = 0;
        $total_expense  = 0;
        $from_creator = '';

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Revenue']);
        $this->db->order_by('mp_head.name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $record_data =  $query->result();
            if ($record_data != NULL) {
                $from_creator .= '<h4 class="income-style"><b>- Revenue / Pendapatan</b></h4>';
                $from_creator .= '<tr><td colspan="2"><span class="income-style-sub"><b> Akun </b></span></td></tr>';

                foreach ($record_data as $single_head) {

                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);
                    if ($amount != 0) {

                        $amount = ($amount < 0 ? -$amount  : $amount);
                        $total_revenue = $total_revenue + $amount;
                        $from_creator .= '<tr><td><h4>' . $single_head->name . '</h4></td><td class="pull-right"><h4>' . number_format($amount, '2', ',', '.') . '</h4></td></tr>';
                    }
                }

                $from_creator .= '<tr><td> Total Revenue </td><td class="pull-right"><h4><b>' . number_format($total_revenue, '2', ',', '.') . '</b></h4></td></tr>';
            }
        }

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Expense']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $record_data =  $query->result();
            if ($record_data != NULL) {
                $from_creator .= '<tr><td colspan="2"><h4 class="income-style"><b>- Expense / Pengeluaran</b></h4></tr>';
                $from_creator .= '<tr><td colspan="2"><span class="income-style-sub"><b> Akun </b></span></td></tr>';

                foreach ($record_data as $single_head) {
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);
                    if ($amount != 0) {
                        $total_expense = $total_expense + $amount;
                        $from_creator .= '<tr><td><h4>' . $single_head->name . '</h4></td><td class="pull-right"><h4>' . number_format($amount, '2', ',', '.') . '</h4></td></tr>';
                    }
                }
                $from_creator .= '<tr><td> Total Expense </td><td class="pull-right">' . number_format($total_expense, '2', ',', '.')   . '</td></tr>';

                $from_creator .= '<tr class=" total-income"><td> Total Net Lost / Profit </td><td class="pull-right">' . number_format($total_revenue - $total_expense, '2', ',', '.') . '</td></tr>';
            }
        }

        return  $from_creator;
    }

    //USED TO GENERATE BALANCESHEET 
    public function balancesheet($end_date)
    {
        //ACCOUNTING START DATE
        $date1 = '2019-01-01';

        $date2 = $end_date;

        //CURRENT ASSETS
        $total_current       = 0;
        $current_assets      = '';

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.type' => 'Lancar']);
        $this->db->where(['mp_head.nature' => 'Assets']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_head) {
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);

                    if ($amount > 0) {
                        $amt = $amount;
                    } else {
                        $amt    = - ($amount);
                    }
                    $total_current = $total_current + $amt;

                    $current_assets .= '<tr><td style=text-align:left;><h4>' . $single_head->name . '</h4></td>
                                <td style="text-align:right" ><h4>' . $amt . '</h4></td></tr>';
                }
                $current_assets .= '<tr class="balancesheet-row"><td ><h4><i>Total Aktiva Lancar</i></h4></td><td style="text-align:right;" ><h4><i>' . $total_current . '</i></h4></td></tr>';
            }
        }

        //NON CURRENT ASSETS
        $total_current_nc    = '';
        $noncurrent_assets   = '';
        $total_noncurrent    = 0;
        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.type' => 'Tetap']);
        $this->db->where(['mp_head.nature' => 'Assets']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_head) {
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);

                    if ($amount > 0) {
                        $amt = $amount;
                    } else {
                        $amt    = - ($amount);
                    }

                    $total_noncurrent = $total_noncurrent + $amt;

                    $noncurrent_assets .= '<tr><td><h4>' . $single_head->name . '</h4></td>
                                <td style="text-align:right" ><h4>' . $amt . '</h4></td></tr>';
                }
                $noncurrent_assets .= '<tr class="balancesheet-row"><td><h4><i>Total Aktiva Tetap</i></h4></td><td style=" text-align:right;" ><h4><i>' . $total_noncurrent . '</i></h4></td></tr>';
            }
        }

        $total_current_nc .= '<tr class="balancesheet-row"><td><h4><b><i>Total Aset / Aktiva</i></b></h4></td><td style=" text-align:right;" ><h4><b><i>' . ($total_noncurrent + $total_current) . '</i></b></h4></td></tr>';

        //CURRENT LIBILTY
        $total_cur_libility       = 0;
        $current_libility      = '';

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.type' => 'Lancar']);
        $this->db->where(['mp_head.nature' => 'Liability']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_head) {
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);

                    if ($amount > 0) {
                        $amt = $amount;
                    } else {
                        $amt    = - ($amount);
                    }

                    $total_cur_libility = $total_cur_libility + $amt;

                    $current_libility .= '<tr><td><h4>' . $single_head->name . '</h4></td>
                                <td style="text-align:right" ><h4>' . $amt . '</h4></td></tr>';
                }
                $current_libility .= '<tr class="balancesheet-row"><td><h4><i>Total Kewajiban Lancar</i></h4></td><td style=" text-align:right;" ><h4><i>' . $total_cur_libility . '</i></h4></td></tr>';
            }
        }

        //NON CURRENT LIABILITY
        $total_current_nc_libility    = '';
        $noncurrent_libility   = '';
        $total_noncurrent_libility    = 0;
        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.type' => 'Tetap']);
        $this->db->where(['mp_head.nature' => 'Liability']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_head) {
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);

                    if ($amount > 0) {
                        $amt = $amount;
                    } else {
                        $amt    = - ($amount);
                    }

                    $total_noncurrent_libility = $total_noncurrent_libility + $amt;

                    $noncurrent_libility .= '<tr><td><h4>' . $single_head->name . '</h4></td>
                                <td style="text-align:right" ><h4><i>' . $amt . '</i></h4></td></tr>';
                }
                $noncurrent_libility .= '<tr class="balancesheet-row"><td><h4>Total Kewajiban Jangka Panjang</h4></td><td style="text-align:right;" ><h4><i>' . $total_noncurrent_libility . '</i></h4></td></tr>';
            }
        }

        $total_current_nc_libility .= '<tr class="balancesheet-row"><td><h4><i>Total Liability / Kewajiban </i></h4></td><td style="text-align:right;" ><h4><i>' . ($total_cur_libility + $total_noncurrent_libility) . '</i></h4></td></tr>';

        //EQUITY
        $total_equity              = 0;
        $equity                    = '';
        $total_libility_and_equity = '';
        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Equity']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_head) {
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);

                    if ($amount > 0) {
                        $amt = $amount;
                    } else {
                        $amt    = - ($amount);
                    }

                    $total_equity = $total_equity + $amt;

                    $equity .= '<tr><td><h4><i>' . $single_head->name . '</i></h4></td>
                                <td style="text-align:right" ><h4><i>' . $amt . '</i></h4></td></tr>';
                }
            }
        }

        $retained_earnings = $this->retained_earnings($date1, $date2);
        $total_libility_equity_retained = $total_equity + $total_cur_libility + $total_noncurrent_libility + $retained_earnings;

        $equity .= '<tr><td><h4> Laba Ditahan </h4></td>
                                <td style="text-align:right" ><h4><i>' . $retained_earnings . '</i></h4></td></tr>';
        $equity .= '<tr class="balancesheet-row"><td><h4><i>Total Equity / Modal </i></h4></td><td style="text-align:right;" ><h4><i>' . $total_equity . '</i></h4></td></tr>';

        $total_libility_and_equity .= '<tr class="balancesheet-row"><td ><h4><b><i>Total Kewajiban and Modal</i></b></h4></td><td style=" text-align:right;" ><h4<b><i>' . $total_libility_equity_retained . '</i></b></h4></td></tr>';
        return  array('current_assets' => $current_assets, 'noncurrent_assets' => $noncurrent_assets, 'total_assets' => $total_current_nc, 'current_libility' => $current_libility, 'noncurrent_libility' => $noncurrent_libility, 'total_currentnoncurrent_libility' => $total_current_nc_libility, 'equity' => $equity, 'total_libility_equity' => $total_libility_and_equity);
    }

    public function get_acc($id, $name = false, $draft = false)
    {
        if ($name) {
            $this->db->select('ma.*, u1.user_name as name_1, u2.user_name as name_2 ,u3.user_name as name_3');
            $this->db->join('mp_users as u1', 'ma.acc_1 = u1.id', 'LEFT');
            $this->db->join('mp_users as u2', 'ma.acc_2 = u2.id', 'LEFT');
            $this->db->join('mp_users as u3', 'ma.acc_3 = u3.id', 'LEFT');
            // $this->db->select('*');
            // $this->db->select('*');
        } else {

            $this->db->select('*');
        }
        if ($draft)
            $this->db->from('draft_approv as ma');
        else
            $this->db->from('mp_approv as ma');
        $this->db->where('id_transaction', $id);
        $query = $this->db->get();
        $result =  $query->result();
        if (empty($result)) {
            return NULL;
        }
        return $result[0];
    }
    //USED TO CREATE A CHART OF ACCOUNTS LIST 
    public function patners_cars_list()
    {
        $patner_list = '';

        $this->db->select("*");
        $this->db->from('mp_payee');
        // $this->db->where('mp_payee.type', 'patners');
        $query = $this->db->get();
        $result =  $query->result();
        if ($result != NULL) {
            foreach ($result as $single_head) {
                $patner_list .= '<option value="' . $single_head->id . '">' . $single_head->customer_name . '</option>';
            }
        }
        return $patner_list;
        // die();
    }

    public function getListCars($filter = [])
    {
        $patner_list = '';

        $this->db->select("*");
        $this->db->from('mp_cars');
        $this->db->where('mp_cars.id_customer', $filter['id_patner']);
        $query = $this->db->get();
        $result =  $query->result();
        if ($result != NULL) {
            foreach ($result as $single_head) {
                $patner_list .= '<option value="' . $single_head->id . '">' . $single_head->no_cars . '</option>';
            }
        } else {
            return NULL;
        }
        return $patner_list;
    }

    public function getListCars2($filter = [])
    {
        $patner_list = '';

        $this->db->select("id,id_customer, name_cars, no_cars");
        $this->db->from('mp_cars');
        $this->db->where('mp_cars.id_customer', $filter['id_patner']);
        $query = $this->db->get();
        $result =  $query->result_array();
        if ($result == NULL) {
            return NULL;
        }
        return $result;
        // die();
    }
    public function chart_list()
    {
        $accounts_list = '';
        $accounts_nature  = array('Assets', 'Liability', 'Equity', 'Revenue', 'Expense');
        for ($i = 0; $i < count($accounts_nature); $i++) {
            $accounts_list .= '<option value="0">-------------</option>';
            $accounts_list .= '<optgroup label="' . $accounts_nature[$i] . '">';

            $this->db->select("*");
            $this->db->from('mp_head');
            $this->db->where(['mp_head.nature' => $accounts_nature[$i]]);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $result =  $query->result();
                if ($result != NULL) {
                    foreach ($result as $single_head) {
                        $accounts_list .= '<option value="' . $single_head->id . '">' . $single_head->name . '</option>';
                    }
                }
            }

            $accounts_list .= ' </optgroup>';
        }
        return $accounts_list;
    }

    //USED TO CALCULATE RETAINED EARNINGS 
    public function retained_earnings($start, $end)
    {
        $total_expense = 0;
        $total_revenue = 0;

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Revenue']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result =  $query->result();
            if ($result != NULL) {
                foreach ($result as $single_head) {

                    $amount =  $this->count_head_amount($single_head->id, $start, $end);

                    $total_revenue = $total_revenue + $amount;
                }
            }
        }
        $total_revenue = ($total_revenue < 0 ? -$total_revenue : $total_revenue);
        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Expense']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result =  $query->result();
            if ($result != NULL) {
                foreach ($result as $single_head) {

                    $amount =  $this->count_head_amount($single_head->id, $start, $end);

                    $total_expense = $total_expense + $amount;
                }
            }
        }

        $total_expense = ($total_expense < 0 ? -$total_expense : $total_expense);

        return $total_revenue - $total_expense;
    }

    function count_head_amount_by_id($head_id)
    {
        $count = 0;
        $this->db->select("*");
        $this->db->from('mp_sub_entry');
        $this->db->where(['mp_sub_entry.accounthead' => $head_id]);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result =  $query->result();
            if ($result != NULL) {
                foreach ($result as $single_head) {
                    if ($single_head->type == 0) {
                        $count = $count + $single_head->amount;
                    } else if ($single_head->type == 1) {
                        $count = $count - $single_head->amount;
                    } else {
                    }
                }
            }
        }
        return  $count;
    }

    public function getTreeAccount($filter)
    {
        $total_revenue = 0;
        $total_expense  = 0;
        $from_creator = '';

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Revenue']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $record_data =  $query->result();
            if ($record_data != NULL) {
                $from_creator .= '<h4 class="income-style"><b>- Revenue / Pendapatan</b></h4>';
                $from_creator .= '<tr><td colspan="2"><span class="income-style-sub"><b> Akun </b></span></td></tr>';

                foreach ($record_data as $single_head) {
                }

                $from_creator .= '<tr><td> Total Revenue </td><td class="pull-right"><h4><b>' . number_format($total_revenue, '2', '.', '') . '</b></h4></td></tr>';
            }
        }

        $this->db->select("*");
        $this->db->from('mp_head');
        $this->db->where(['mp_head.nature' => 'Expense']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $record_data =  $query->result();
            if ($record_data != NULL) {
                $from_creator .= '<tr><td colspan="2"><h4 class="income-style"><b>- Expense / Pengeluaran</b></h4></tr>';
                $from_creator .= '<tr><td colspan="2"><span class="income-style-sub"><b> Akun </b></span></td></tr>';

                foreach ($record_data as $single_head) {
                }
                $from_creator .= '<tr><td> Total Expense </td><td class="pull-right">' . number_format($total_expense, '2', '.', '') . '</td></tr>';

                $from_creator .= '<tr class=" total-income"><td> Total Net Lost / Profit </td><td class="pull-right">' . number_format($total_revenue - $total_expense, '2', '.', '') . '</td></tr>';
            }
        }
        return  $from_creator;
    }

    public function count_head_amount_like_name($filter)
    {
        $count_total_amt = 0;
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
        $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
        $this->db->where('mp_head.name like "[' . $filter['name'] . '%"');
        if (!empty($filter['year'])) $this->db->where('mp_generalentry.date like "' . $filter['year'] . '%"');
        if (!empty($filter['filter']['from'])) $this->db->where('mp_generalentry.date >= "' . $filter['filter']['from'] . '"');
        if (!empty($filter['filter']['to'])) $this->db->where('mp_generalentry.date <= "' . $filter['filter']['to'] . '"');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            $count_total_amt = 0;
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_ledger) {
                    if ($single_ledger->type == 0) {
                        $count_total_amt = $count_total_amt + $single_ledger->amount;
                    } else {
                        $count_total_amt = $count_total_amt - $single_ledger->amount;
                    }
                }
            }
        }
        if (
            $count_total_amt == 0
        ) {
            $count_total_amt  = NULL;
        } else {
            if ($count_total_amt < 0)
                $count_total_amt = $count_total_amt * (-1);
            $count_total_amt = number_format($count_total_amt, '2');
        }

        return $count_total_amt;
    }

    public function count_head_amount_like_name_neraca_saldo(
        $filter
    ) {
        $count_total_amt = 0;
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
        $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
        $this->db->where('mp_head.name like "[' . $filter['name'] . '%"');
        // $this->db->where('mp_generalentry.date like "2020%"');
        if (!empty($filter['filter']['from'])) $this->db->where('mp_generalentry.date >= "' . $filter['filter']['from'] . '"');
        if (!empty($filter['filter']['to'])) $this->db->where('mp_generalentry.date <= "' . $filter['filter']['to'] . '"');

        $debit = 0;
        $credit = 0;
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $ledger_data =  $query->result();
            $count_total_amt = 0;
            if ($ledger_data != NULL) {
                foreach ($ledger_data as $single_ledger) {
                    if ($single_ledger->type == 0) {
                        $debit = $debit + $single_ledger->amount;
                    } else {
                        $credit = $credit + $single_ledger->amount;
                    }
                }
            }
        }
        $saldo = $debit - $credit;
        if ($saldo < 0) $saldo = $saldo * (-1);
        $data['debit'] = number_format($debit, '2');
        $data['credit'] = number_format($credit, '2');
        $data['saldo'] = number_format($saldo, '2');
        return $data;
    }



    public function tree_neraca_saldo($filter)
    {
        $this->db->from('mp_head');
        $this->db->order_by('mp_head.name');
        $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -3), ']', 1) = '00.000.000'");
        if (!empty($filter['account_head'])) $this->db->where('mp_head.id', $filter['account_head']);
        $query = $this->db->get();
        $level1 =  $query->result();
        $i = 0;
        $total_credit = 0;
        $total_debit = 0;
        foreach ($level1 as $lv1) {
            $this->db->select('mp_head.*');
            $this->db->from('mp_head');
            $this->db->order_by('mp_head.name');
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -2), ']', 1) = '000.000'");
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 1) = '" . substr($lv1->name, 1, 1) . "'");
            $this->db->where('mp_head.id != "' . $lv1->id . '"');
            $query = $this->db->get();

            $level1[$i]->level2 = $query->result();
            $j = 0;
            $k = 0;
            $val = $this->count_head_amount_like_name_neraca_saldo(array('name' => substr($lv1->name, 1, 1), 'filter' => $filter, 'lvl' => 1));
            $debitamt  = 0;
            $creditamt = 0;
            $tmp[$i] = array(
                'id' => $lv1->id,
                'text' => $lv1->name,
                'data' => $val,
                'state' => ['opened' => false]
            );
            if ($val['debit'] != 0 or $val['credit'] != 0) {
                foreach ($level1[$i]->level2 as $lv2) {

                    $this->db->select('mp_head.*');
                    $this->db->from('mp_head');
                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '[', -1), ']', 1),'.',-1) = '000'");
                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 2) = '" . substr($lv2->name, 1, 4) . "'");
                    $this->db->where('mp_head.id != "' . $lv2->id . '"');
                    $this->db->order_by('mp_head.name');
                    $query = $this->db->get();
                    $level1[$i]->level2[$j]->level3 = $query->result();

                    $val = $this->count_head_amount_like_name_neraca_saldo(array('name' => substr($lv2->name, 1, 4), 'filter' => $filter, 'lvl' => 1));
                    $tmp[$i]['children'][$k] = array(
                        'id' => $lv2->id,
                        'text' => $lv2->name,
                        'data' => $val,
                        'state' => ['opened' => false]
                    );
                    $l = 0;
                    if ($val['debit'] != 0 or $val['credit'] != 0)
                        foreach ($level1[$i]->level2[$j]->level3 as $lv3) {
                            $val = $this->count_head_amount_like_name_neraca_saldo(array('name' => substr($lv3->name, 1, 8), 'filter' => $filter, 'lvl' => 1));
                            $val['ins'] = '<a onclick="inspect_buku_besar(' . $lv3->id . ')"><i class="fa fa-search text-warning mr-5"></i></a>';
                            $tmp[$i]['children'][$k]['children'][$l] = array(
                                'id' => $lv3->id,
                                'text' =>  $lv3->name,
                                'data' => $val,
                                'state' => ['opened' => false]
                            );

                            $l++;
                        }
                    $k++;
                }

                $j++;
            }

            $i++;
        }
        return $tmp;
    }

    public function account_tree($filter)
    {
        $accounts_types = array('Assets', 'Liability', 'Equity', 'Revenue', 'Expense');
        $this->db->from('mp_head');
        $this->db->order_by('mp_head.name');
        $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -3), ']', 1) = '00.000.000'");
        if (!empty($filter['account_head'])) $this->db->where('mp_head.id', $filter['account_head']);
        $query = $this->db->get();
        $level1 =  $query->result();
        $i = 0;
        unset($level1[0]);
        unset($level1[1]);
        unset($level1[2]);
        array_splice($level1, 4, 0);
        foreach ($level1 as $lv1) {
            $this->db->select('mp_head.*');
            $this->db->from('mp_head');
            $this->db->order_by('mp_head.name');
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -2), ']', 1) = '000.000'");
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 1) = '" . substr($lv1->name, 1, 1) . "'");
            $this->db->where('mp_head.id != "' . $lv1->id . '"');
            $query = $this->db->get();
            $level1[$i]->level2 = $query->result();
            $j = 0;
            $m = 0;
            $k = 0;
            $val = $this->count_head_amount_like_name(array('name' => substr($lv1->name, 1, 1), 'filter' => $filter, 'lvl' => 1));
            if ($val != null && $val != 0) {
                $tmp[$i] = array(
                    'id' => $lv1->id,
                    'text' => $lv1->name,
                    'data' => ['amount' => $val],
                    'state' => ['opened' => false]
                );
                foreach ($level1[$i]->level2 as $lv2) {
                    $this->db->select('mp_head.*');
                    $this->db->from('mp_head');
                    $this->db->order_by('mp_head.name');
                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '[', -1), ']', 1),'.',-1) = '000'");
                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 2) = '" . substr($lv2->name, 1, 4) . "'");
                    $this->db->where('mp_head.id != "' . $lv2->id . '"');
                    $query = $this->db->get();
                    $level1[$i]->level2[$j]->level3 = $query->result();
                    $val = $this->count_head_amount_like_name(array('name' => substr($lv2->name, 1, 4), 'filter' => $filter, 'lvl' => 1));

                    if ($val != null && $val != 0) {
                        $tmp[$i]['children'][$k] = array(
                            'id' => $lv2->id,
                            'text' => $lv2->name,
                            'data' => ['amount' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val],
                            'state' => ['opened' => false]
                        );

                        $l = 0;
                        if (!empty($level1[$i]->level2[$j]->level3)) {
                            $m = 0;
                            foreach ($level1[$i]->level2[$j]->level3 as $lv3) {
                                $val = $this->count_head_amount_like_name(array('name' => substr($lv3->name, 1, 8), 'filter' => $filter, 'lvl' => 1));
                                if ($val == null) $val = 0;
                                if (!empty($val)) {
                                    $tmp[$i]['children'][$k]['children'][$m] = array(
                                        'id' => $lv3->id,
                                        'text' => $lv3->name,
                                        'data' => ['amount' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val, 'ins' => '<a onclick="inspect_buku_besar(' . $lv3->id . ')"><i class="fa fa-search text-warning mr-5"></i></a>'],
                                        'state' => ['opened' => false]
                                    );
                                    $lv3amount = $val;

                                    $this->db->select('mp_head.*');
                                    $this->db->from('mp_head');
                                    $this->db->order_by('mp_head.name');
                                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 3) = '" . substr($lv3->name, 1, 8) . "'");
                                    $query = $this->db->get();

                                    $level1[$i]->level2[$j]->level3[$m]->level4 = $query->result();
                                    if (!empty($level1[$i]->level2[$j]->level3[$m]->level4)) {
                                        $n = 0;
                                        foreach ($level1[$i]->level2[$j]->level3[$m]->level4 as $lv4) {
                                            $val = $this->count_head_amount_like_name(array('name' => substr($lv4->name, 1, 12), 'filter' => $filter, 'lvl' => 1));
                                            if ($val == null) $val = 0;
                                            if (!empty($val)) {
                                                if ($n == 0) {
                                                    if ($lv3amount != $val) {

                                                        $tmp[$i]['children'][$k]['children'][$m]['children'][$n] = array(
                                                            'id' => $lv4->id . 'r',
                                                            'text' => $lv4->name,
                                                            'data' => ['amount' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val, 'ins' => '<a onclick="inspect_buku_besar(' . $lv4->id . ')"><i class="fa fa-search text-warning mr-5"></i></a>'],
                                                            'state' => ['opened' => false]
                                                        );
                                                        $n++;
                                                    }
                                                } else {
                                                    $tmp[$i]['children'][$k]['children'][$m]['children'][$n] = array(
                                                        'id' => $lv4->id . 'r',
                                                        'text' => $lv4->name,
                                                        'data' => ['amount' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $val, 'ins' => '<a onclick="inspect_buku_besar(' . $lv4->id . ')"><i class="fa fa-search text-warning mr-5"></i></a>'],
                                                        'state' => ['opened' => false]
                                                    );
                                                    $n++;
                                                }
                                            }
                                        }
                                    }
                                    $m++;
                                }
                            }
                        }
                        $k++;
                    }
                    $j++;
                }
            }
            $i++;
        }
        return $tmp;
    }


    public function periode_neraca_saldo($filter)
    {
        $accounts_types = array('Assets', 'Liability', 'Equity', 'Revenue', 'Expense');

        //     $QUERY = 'SELECT ROW_NUMBER() OVER(PARTITION BY mp_head.name) as row_s,  @name := SUBSTR(mp_head.name, 1, 2) AS nama_akun, YEAR(mp_generalentry.date) as year, MONTH(mp_generalentry.date) as month,
        //         ROUND(sum(IF(mp_sub_entry.type = 1,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) mutasi
        //         ,
        //         (SELECT
        //         ROUND(sum(IF(mp_sub_entry.type = 1,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) saldo_sebelum

        //         from mp_sub_entry
        //         JOIN mp_generalentry on mp_generalentry.id = mp_sub_entry.parent_id
        //         RIGHT JOIN mp_head on mp_head.id = mp_sub_entry.accounthead 
        //         WHERE mp_head.name LIKE CONCAT( @name,"%") AND 
        //         mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND mp_generalentry.date >"' . $filter['tahun'] . '-01-01" )  saldo_sebelum
        //          ,
        //         (SELECT
        //             name 
        //         from mp_head WHERE 
        //         mp_head.name LIKE CONCAT( @name,"%") AND SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, ".", -3), "]", 1) = "00.000.000"  limit 1
        //         )  title
        //         from mp_sub_entry
        //         JOIN mp_generalentry on mp_generalentry.id = mp_sub_entry.parent_id
        //         LEFT JOIN mp_head on mp_head.id = mp_sub_entry.accounthead 
        //         WHERE 
        //         mp_generalentry.date >= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND mp_generalentry.date <= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-31" 
        //         GROUP BY SUBSTR(mp_head.name,1,2)
        //         ORDER BY mp_head.name
        //  ';

        $QUERY = 'SELECT ROW_NUMBER() OVER(PARTITION BY mp_head.name) as row_s,  @name := SUBSTR(mp_head.name, 1, 2) AS nama_akun, YEAR(mp_generalentry.date) as year, MONTH(mp_generalentry.date) as month,
            ROUND(sum(IF(mp_sub_entry.type = 1,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) mutasi
            ,
            (SELECT
            ROUND(sum(IF(mp_sub_entry.type = 1,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) saldo_sebelum
            
            from mp_sub_entry
            JOIN mp_generalentry on mp_generalentry.id = mp_sub_entry.parent_id
            RIGHT JOIN mp_head on mp_head.id = mp_sub_entry.accounthead 
            WHERE mp_head.name LIKE CONCAT( @name,"%") AND 
            mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND mp_generalentry.date >"' . $filter['tahun'] . '-01-01" )  saldo_sebelum
             ,
            (SELECT
                name 
            from mp_head WHERE 
            mp_head.name LIKE CONCAT( @name,"%") AND SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, ".", -3), "]", 1) = "00.000.000"  limit 1
            )  title
            from mp_sub_entry
            JOIN mp_generalentry on mp_generalentry.id = mp_sub_entry.parent_id
            LEFT JOIN mp_head on mp_head.id = mp_sub_entry.accounthead 
            WHERE 
            mp_generalentry.date >= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND mp_generalentry.date <= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-31" 
            GROUP BY SUBSTR(mp_head.name,1,2)
            ORDER BY mp_head.name
     ';


        $QUERY = 'SELECT
                        @names := SUBSTR(mp_head.name, 1, 3) as pars,nature as title,
                        COALESCE((
                        SELECT
                            ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                        FROM
                            mp_sub_entry
                        JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                        JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                        WHERE
                        mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date >= "' . $filter['tahun'] . '-1-1"
                        ),0) saldo_sebelum,
                       COALESCE((
                        SELECT
                            ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
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
                    GROUP BY
                        SUBSTR(mp_head.name, 1, 5)
            ORDER BY mp_head.name
            ';
        $res = $this->db->query($QUERY);
        $res = $res->result();
        $i = 0;
        foreach ($res as $re) {
            $tmp[$i] = array(
                'id' => $re->id,
                'text' => ($i + 1) . ' | ' . $re->title,
                'data' => [
                    'saldo_s' => number_format($re->title == 'Expense' ? - ($re->saldo_sebelum) : $re->saldo_sebelum, 2),
                    'mutasi' => number_format($re->title == 'Expense' ? - ($re->mutasi) : $re->mutasi, 2),
                    'saldo' => number_format($re->title == 'Expense' ? - ($re->saldo_sebelum + $re->mutasi) : ($re->saldo_sebelum + $re->mutasi), 2)
                ],
                'state' => ['opened' => true]
            );
            if ($re->saldo_sebelum != 0 and $re->mutasi != 0) {
                $QUERY = 'SELECT
                                    @names := SUBSTR(mp_head.name, 1, 5) as pars,SUBSTR(mp_head.name, 2, 5) as title,
                                    COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    FROM
                                        mp_sub_entry
                                    JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    WHERE
                                    mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date >= "' . $filter['tahun'] . '-1-1"
                                    ),0) saldo_sebelum,
                                COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
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
                                
                                        SUBSTRING_INDEX(
                                            SUBSTRING_INDEX(mp_head.name, ".", -2),
                                            "]",
                                            1
                                        ) = "000.000" 
                                     AND mp_head.name like "' . $re->pars . '%"
                                     AND mp_head.id !=  "' . $re->id . '"
                                GROUP BY
                                    SUBSTR(mp_head.name, 1, 5)
                        ORDER BY mp_head.name
                        ';
                $res2 = $this->db->query($QUERY);
                $res2 = $res2->result();
                $k = 0;
                foreach ($res2 as $re2) {
                    if ($re2->saldo_sebelum != 0 and $re2->mutasi != 0) {
                        $tmp[$i]['children'][$k] = array(
                            'id' => $re2->id . '-2',
                            'text' => $re2->name,
                            'data' => [
                                'saldo_s' => number_format($re->title == 'Expense' ? -$re2->saldo_sebelum : $re2->saldo_sebelum, 2),
                                'mutasi' => number_format($re->title == 'Expense' ? -$re2->mutasi : $re2->mutasi, 2),
                                'saldo' => number_format($re->title == 'Expense' ? - ($re2->saldo_sebelum + $re2->mutasi) : ($re2->saldo_sebelum + $re2->mutasi), 2),
                                'ins' => '<a onclick="inspect_buku_besar(' . $re2->id . ')"><i class="fa fa-search text-warning mr-5"></i></a>'
                            ],
                            'state' => ['opened' => true]
                        );
                        // ===LEVEL 3
                        $QUERY = 'SELECT
                                    @names := SUBSTR(mp_head.name, 1, 9) as pars,SUBSTR(mp_head.name, 2, 9) as title,
                                    COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    FROM
                                        mp_sub_entry
                                    JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    WHERE
                                    mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date >= "' . $filter['tahun'] . '-1-1"
                                    ),0) saldo_sebelum,
                                COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
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
                                
                                        SUBSTRING_INDEX(
                                            SUBSTRING_INDEX(mp_head.name, ".", -1),
                                            "]",
                                            1
                                        ) = "000" 
                                        AND mp_head.name like "' . $re2->pars . '%"
                                        AND mp_head.id !=  "' . $re2->id . '"
                                  
                        ORDER BY mp_head.name
                        ';
                        $res3 = $this->db->query($QUERY);
                        $res3 = $res3->result();
                        $l = 0;
                        // if ($k == 0) {

                        //     // print_r($this->db->last_query());
                        // echo json_encode($res3);
                        // die();
                        // }
                        foreach ($res3 as $re3) {
                            if ($re3->saldo_sebelum != 0 and $re3->mutasi != 0) {
                                $tmp[$i]['children'][$k]['children'][$l] = array(
                                    'id' => $re3->id . '-3',
                                    'text' => $re3->name,
                                    'data' => [
                                        'saldo_s' => number_format($re->title == 'Expense' ? -$re3->saldo_sebelum : $re3->saldo_sebelum, 2),
                                        'mutasi' => number_format($re->title == 'Expense' ? -$re3->mutasi : $re3->mutasi, 2),
                                        'saldo' => number_format($re->title == 'Expense' ? - ($re3->saldo_sebelum + $re3->mutasi) : ($re3->saldo_sebelum + $re3->mutasi), 2),
                                        'ins' => '<a onclick="inspect_buku_besar(' . $re3->id . ')"><i class="fa fa-search text-warning mr-5"></i></a>'
                                    ],
                                    'state' => ['opened' => true]
                                );

                                //  LVL 4
                                {
                                    // $QUERY = 'SELECT
                                    //                 @names := SUBSTR(mp_head.name, 1, 14) as pars,SUBSTR(mp_head.name, 2, 14) as title,
                                    //                 COALESCE((
                                    //                 SELECT
                                    //                     ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    //                 FROM
                                    //                     mp_sub_entry
                                    //                 JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    //                 JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    //                 WHERE
                                    //                 mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date < "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date >= "' . $filter['tahun'] . '-1-1"
                                    //                 ),0) saldo_sebelum,
                                    //             COALESCE((
                                    //                 SELECT
                                    //                     ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    //                 FROM
                                    //                     mp_sub_entry
                                    //                 JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    //                 JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    //                 WHERE
                                    //                 mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date >= "' . $filter['tahun'] . '-' . $filter['bulan'] . '-1" AND 			mp_generalentry.date <="' . $filter['tahun'] . '-' . $filter['bulan'] . '-31"
                                    //                 ),0)  mutasi,
                                    //             mp_head.id,
                                    //             mp_head.name
                                    //             FROM
                                    //                 `mp_head`
                                    //             WHERE

                                    //                     SUBSTRING_INDEX(
                                    //                         SUBSTRING_INDEX(mp_head.name, ".", -1),
                                    //                         "]",
                                    //                         1
                                    //                     ) != "000" 
                                    //                     AND mp_head.name like "' . $re3->pars . '%"
                                    //                     AND mp_head.id !=  "' . $re3->id . '"           
                                    //     ORDER BY mp_head.name
                                    //     ';
                                    // $res4 = $this->db->query($QUERY);
                                    // $res4 = $res4->result();
                                    // $m = 0;
                                    // // if ($k == 0) {

                                    // // }
                                    // foreach ($res4 as $re4) {
                                    //     // print_r($this->db->last_query());
                                    //     // echo json_encode($res4);
                                    //     // die();
                                    //     if ($re4->saldo_sebelum != 0 and $re4->mutasi != 0) {
                                    //         $tmp[$i]['children'][$k]['children'][$l]['children'][$m] = array(
                                    //             'id' => $re4->id . '-3',
                                    //             'text' => $re4->name,
                                    //             'data' => [
                                    //                 'saldo_s' => number_format($re4->saldo_sebelum, 2),
                                    //                 'mutasi' => number_format($re3->mutasi, 2),
                                    //                 'saldo' => number_format($re4->saldo_sebelum + $re4->mutasi, 2)
                                    //             ],
                                    //             'state' => ['opened' => true]
                                    //         );
                                    //         $m++;
                                    //     }
                                    // }
                                }
                                //  END LVL 4

                                $l++;
                            }
                        }
                        // ===END LVL 3
                        $k++;
                    }
                }
            }
            $i++;
        }
        return $tmp;
    }

    public function count_chart_of_account($filter = [])
    {
        $this->db->from('mp_head');
        $this->db->order_by('mp_head.name');
        $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -3), ']', 1) = '00.000.000'");
        if (!empty($filter['account_head'])) $this->db->where('mp_head.id', $filter['account_head']);
        $query = $this->db->get();
        $level1 =  $query->result();
        $i = 0;
        foreach ($level1 as $lv1) {
            $this->db->select('mp_head.*');
            $this->db->from('mp_head');
            $this->db->order_by('mp_head.name');
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -2), ']', 1) = '000.000'");
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 1) = '" . substr($lv1->name, 1, 1) . "'");
            $this->db->where('mp_head.id != "' . $lv1->id . '"');
            $query = $this->db->get();
            $level1[$i]->level2 = $query->result();
            $j = 0;
            $k = 0;
            $res = $this->count_head_amount_like_name_akumulasi(array('name' => substr($lv1->name, 1, 1), 'filter' => $filter, 'accounthead_id' => $lv1->id));
            if (!$res)
                $this->akumulasi_set_zero(array('name' => substr($lv1->name, 1, 1), 'filter' => $filter));
            else if ($res)
                foreach ($level1[$i]->level2 as $lv2) {

                    $this->db->select('mp_head.*');
                    $this->db->from('mp_head');
                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '[', -1), ']', 1),'.',-1) = '000'");
                    $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 2) = '" . substr($lv2->name, 1, 4) . "'");
                    $this->db->where('mp_head.id != "' . $lv2->id . '"');
                    $this->db->order_by('mp_head.name');
                    $query = $this->db->get();
                    $level1[$i]->level2[$j]->level3 = $query->result();

                    $res = $this->count_head_amount_like_name_akumulasi(array('name' => substr($lv2->name, 1, 4), 'filter' => $filter, 'accounthead_id' => $lv2->id));
                    $m = 0;
                    // if ($res)
                    if (!$res)
                        $this->akumulasi_set_zero(array('name' => substr($lv2->name, 1, 4), 'filter' => $filter));
                    else if ($res)
                        foreach ($level1[$i]->level2[$j]->level3 as $lv3) {
                            $this->db->select('mp_head.*');
                            $this->db->from('mp_head');
                            $this->db->order_by('mp_head.name');
                            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '[', -1), ']', 1),'.',-1) != '000'");
                            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(name, '[', -1), '.', 3) = '" . substr($lv3->name, 1, 8) . "'");
                            $query = $this->db->get();
                            $level1[$i]->level2[$j]->level3[$m]->level4 = $query->result();
                            $res = $this->count_head_amount_like_name_akumulasi(array('name' => substr($lv3->name, 1, 8), 'filter' => $filter, 'accounthead_id' => $lv3->id));
                            if (!$res)
                                $this->akumulasi_set_zero(array('name' => substr($lv3->name, 1, 8), 'filter' => $filter));
                            else if ($res)
                                if (!empty($level1[$i]->level2[$j]->level3[$m]->level4)) {
                                    foreach ($level1[$i]->level2[$j]->level3[$m]->level4 as $lv4) {
                                        $this->count_head_amount_like_name_akumulasi(array('name' => substr($lv4->name, 1, 12), 'filter' => $filter, 'accounthead_id' => $lv4->id));
                                    }
                                }
                            $m++;
                        }
                    $k++;
                }
        }
    }

    public function count_head_amount_like_name_akumulasi($filter)
    {
        // if ($filter['month'] == 1) {
        //     $fx['month'] = 12;
        //     $fx['year'] = $filter['year'] - 1;
        // }
        $c_saldo = 0;
        $mutasi = 0;
        $debit = 0;
        $kredit = 0;
        for ($i = 1; $i <= 12; $i++) {
            $this->db->select("YEAR(mp_generalentry.date) as year, MONTH(mp_generalentry.date) as month,
            ROUND(sum(IF(mp_sub_entry.type = 1,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) mutasi, 
            ROUND(sum(IF(mp_sub_entry.type = 0, mp_sub_entry.amount,'0')),2) debit,
            ROUND(sum(IF(mp_sub_entry.type = 0, ,'0',mp_sub_entry.amount)),2) kredit");
            $this->db->from('mp_sub_entry');
            $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
            $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
            $this->db->where('mp_head.name like "[' . $filter['name'] . '%"');
            if (!empty($filter['filter']['year'])) {
                $filter['filter']['from'] = $filter['filter']['year'] . '-' . $i . '-01';
                $filter['filter']['to'] = $filter['filter']['year'] . '-' . $i . '-31';
            }
            $this->db->where('mp_generalentry.date >= "' . $filter['filter']['from'] . '"');
            $this->db->where('mp_generalentry.date <= "' . $filter['filter']['to'] . '"');
            $query = $this->db->get();
            $res[$i] = $query->result_array();

            // saldo sebelum 

            if ($i == 1) {
                $saldo_sebelum = 0;
                $fx['month'] = 12;
                $fx['year'] = $filter['filter']['year'] - 1;
            } else {
                $this->db->select("*");
                $this->db->from('count_transaction_year_month as ct');
                $fx['month'] = $i - 1;
                $fx['year'] = $filter['filter']['year'];
                $this->db->where('ct.year', $fx['year']);
                $this->db->where('ct.month', $fx['month']);
                $this->db->where('ct.accounthead', $filter['accounthead_id']);
                $query = $this->db->get();
                $saldo_sebelum = $query->result_array();
                if (!empty($saldo_sebelum)) {
                    $saldo_sebelum = $saldo_sebelum[0]['saldo_sebelum'] + $saldo_sebelum[0]['mutasi'];
                } else {
                    $saldo_sebelum = 0;
                }
            }
            $res[$i][0]['accounthead'] = $filter['accounthead_id'];
            $res[$i][0]['saldo_sebelum'] = $saldo_sebelum;
            if (!empty($res[$i][0]['year'])) {
                $debit = $debit + $res[$i][0]['debit'];
                $kredit = $kredit + $res[$i][0]['kredit'];
                $mutasi = $mutasi + $res[$i][0]['mutasi'];
                $c_saldo = $c_saldo + $res[$i][0]['saldo_sebelum'];
            } else {
                $res[$i][0]['year'] = $filter['filter']['year'];
                $res[$i][0]['month'] = $i;
                $res[$i][0]['kredit'] = 0;
                $res[$i][0]['debit'] = 0;
                $res[$i][0]['mutasi'] = 0;
            }
            $res[$i][0]['saldo'] = $res[$i][0]['saldo_sebelum'] + $res[$i][0]['mutasi'];

            $this->rec_data_to_db($res[$i][0]);
            echo json_encode($res);
            die();
        }
        $res[0][0]['year'] = $filter['filter']['year'];
        $res[0][0]['month'] = 0;
        $res[0][0]['accounthead'] = $filter['accounthead_id'];
        $res[0][0]['mutasi'] = $mutasi;
        $res[0][0]['kredit'] = $kredit;
        $res[0][0]['debit'] = $debit;

        $this->db->select("*");
        $this->db->from('count_transaction_year_month as ct');
        // if ($i == 1) {
        //     $fx['month'] = 12;
        //     $fx['year'] = $filter['filter']['year'] - 1;
        // } else {
        //     $fx['month'] = $i - 1;
        //     $fx['year'] = $filter['filter']['year'];
        // }
        $this->db->where('ct.year', ($filter['filter']['year'] - 1));
        $this->db->where('ct.month', '0');
        $this->db->where('ct.accounthead', $filter['accounthead_id']);
        $query = $this->db->get();
        $saldo_sebelum = $query->result_array();
        if (!empty($saldo_sebelum)) {
            $saldo_sebelum = $saldo_sebelum[0]['saldo_sebelum'] + $saldo_sebelum[0]['mutasi'];
        } else {
            $saldo_sebelum = 0;
        }
        $res[0][0]['saldo_sebelum'] = $saldo_sebelum;
        $res[0][0]['saldo'] = $saldo_sebelum - $mutasi;
        $this->rec_data_to_db($res[0][0]);
        // echo json_encode($res);
        // die();
        if ($kredit > 0 or $debit  > 0)
            return true;
        else
            return false;
    }


    public function count_current_time($filter, $cut = 5)
    {
        $QUERY = 'SELECT
                                    @names := SUBSTR(mp_head.name, 1, ' . $cut . ') as pars,SUBSTR(mp_head.name, 2, 5) as title,
                                    COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    FROM
                                        mp_sub_entry
                                    JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    WHERE
                                    mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date < "' . date('Y') . '-' . date('m') . '-1" AND 			mp_generalentry.date >= "' . date('Y')  . '-1-1"
                                    ),0) saldo_sebelum,
                                COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    FROM
                                        mp_sub_entry
                                    JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    WHERE
                                    mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date >= "' . date('Y') . '-' .  date('m') . '-1" AND 			mp_generalentry.date <="' . date('Y') . '-' . date('m') . '-31"
                                    ),0)  mutasi,
                                mp_head.id,
                                mp_head.name
                                FROM
                                    `mp_head`
                                WHERE
                                
                                      mp_head.name like "[' . $filter['acc_number'] . '%"
                                
                        ORDER BY mp_head.name
                        ';
        $res = $this->db->query($QUERY);
        $res = $res->result();
        if (!empty($res[0])) {
            return $res[0]->saldo_sebelum + $res[0]->mutasi;
            echo json_encode($res[0]);
        }
        die();
    }

    public function statistics_sales_this_year($filter, $cut = 5, $min = false)
    {
        if (empty($filter['tahun'])) $filter['tahun'] = date('Y');
        // if (empty($filter['bulan']))
        if ($filter['tahun'] < date('Y'))
            $filter['bulan'] = 12;
        else
            $filter['bulan'] = date('m');
        $c_saldo = 0;
        $mutasi = 0;
        $debit = 0;
        $kredit = 0;
        for ($i = 1; $i <= $filter['bulan']; $i++) {
            $QUERY = 'SELECT
                                    @names := SUBSTR(mp_head.name, 1, ' . $cut . ') as pars,SUBSTR(mp_head.name, 2, 5) as title,
                                    COALESCE((
                                    SELECT
                                        ROUND(SUM(IF(mp_sub_entry.type = 1,mp_sub_entry.amount,-mp_sub_entry.amount)),2) 
                                    FROM
                                        mp_sub_entry
                                    JOIN mp_generalentry ON mp_generalentry.id = mp_sub_entry.parent_id
                                    JOIN mp_head ON mp_head.id = mp_sub_entry.accounthead
                                    WHERE
                                    mp_head.name LIKE CONCAT(@names, "%") AND mp_generalentry.date >= "' . $filter['tahun'] . '-' .  $i . '-1" AND 			mp_generalentry.date <="' . $filter['tahun'] . '-' . $i . '-31"
                                    ),0) mutasi,
                                mp_head.id,
                                mp_head.name
                                FROM
                                    `mp_head`
                                WHERE
                                
                                      mp_head.name like "[' . $filter['acc_number'] . '%"
                                
                        ORDER BY mp_head.name
                        ';
            $res = $this->db->query($QUERY);
            $res = $res->result();
            if (!empty($res[0])) {
                if ($min)
                    $tmp[$i - 1] = -$res[0]->mutasi;
                else
                    $tmp[$i - 1] = $res[0]->mutasi;
            }
        }
        return $tmp;
        // echo json_encode($res);
        // die();
        // echo json_encode($tmp);
        // die();
    }

    public function real_time_akumulasi($filter)
    {
        $c_saldo = 0;
        $mutasi = 0;
        $debit = 0;
        $kredit = 0;
        for ($i = 1; $i <= 12; $i++) {
            $this->db->select("YEAR(mp_generalentry.date) as year, MONTH(mp_generalentry.date) as month,
            ROUND(sum(IF(mp_sub_entry.type = 1,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) mutasi, 
            ROUND(sum(IF(mp_sub_entry.type = 0, mp_sub_entry.amount,'0')),2) debit,
            ROUND(sum(IF(mp_sub_entry.type = 0, ,'0',mp_sub_entry.amount)),2) kredit");
            $this->db->from('mp_sub_entry');
            $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
            $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
            $this->db->where('mp_head.name like "[' . $filter['name'] . '%"');
            if (!empty($filter['filter']['year'])) {
                $filter['filter']['from'] = $filter['filter']['year'] . '-' . $i . '-01';
                $filter['filter']['to'] = $filter['filter']['year'] . '-' . $i . '-31';
            }
            $this->db->where('mp_generalentry.date >= "' . $filter['filter']['from'] . '"');
            $this->db->where('mp_generalentry.date <= "' . $filter['filter']['to'] . '"');
            $query = $this->db->get();
            $res[$i] = $query->result_array();

            // saldo sebelum 

            if ($i == 1) {
                $saldo_sebelum = 0;
                $fx['month'] = 12;
                $fx['year'] = $filter['filter']['year'] - 1;
            } else {
                $this->db->select("*");
                $this->db->from('count_transaction_year_month as ct');
                $fx['month'] = $i - 1;
                $fx['year'] = $filter['filter']['year'];
                $this->db->where('ct.year', $fx['year']);
                $this->db->where('ct.month', $fx['month']);
                $this->db->where('ct.accounthead', $filter['accounthead_id']);
                $query = $this->db->get();
                $saldo_sebelum = $query->result_array();
                if (!empty($saldo_sebelum)) {
                    $saldo_sebelum = $saldo_sebelum[0]['saldo_sebelum'] + $saldo_sebelum[0]['mutasi'];
                } else {
                    $saldo_sebelum = 0;
                }
            }
            $res[$i][0]['accounthead'] = $filter['accounthead_id'];
            $res[$i][0]['saldo_sebelum'] = $saldo_sebelum;
            if (!empty($res[$i][0]['year'])) {
                $debit = $debit + $res[$i][0]['debit'];
                $kredit = $kredit + $res[$i][0]['kredit'];
                $mutasi = $mutasi + $res[$i][0]['mutasi'];
                $c_saldo = $c_saldo + $res[$i][0]['saldo_sebelum'];
            } else {
                $res[$i][0]['year'] = $filter['filter']['year'];
                $res[$i][0]['month'] = $i;
                $res[$i][0]['kredit'] = 0;
                $res[$i][0]['debit'] = 0;
                $res[$i][0]['mutasi'] = 0;
            }
            $res[$i][0]['saldo'] = $res[$i][0]['saldo_sebelum'] + $res[$i][0]['mutasi'];

            $this->rec_data_to_db($res[$i][0]);
            echo json_encode($res);
            die();
        }
        $res[0][0]['year'] = $filter['filter']['year'];
        $res[0][0]['month'] = 0;
        $res[0][0]['accounthead'] = $filter['accounthead_id'];
        $res[0][0]['mutasi'] = $mutasi;
        $res[0][0]['kredit'] = $kredit;
        $res[0][0]['debit'] = $debit;

        $this->db->select("*");
        $this->db->from('count_transaction_year_month as ct');
        // if ($i == 1) {
        //     $fx['month'] = 12;
        //     $fx['year'] = $filter['filter']['year'] - 1;
        // } else {
        //     $fx['month'] = $i - 1;
        //     $fx['year'] = $filter['filter']['year'];
        // }
        $this->db->where('ct.year', ($filter['filter']['year'] - 1));
        $this->db->where('ct.month', '0');
        $this->db->where('ct.accounthead', $filter['accounthead_id']);
        $query = $this->db->get();
        $saldo_sebelum = $query->result_array();
        if (!empty($saldo_sebelum)) {
            $saldo_sebelum = $saldo_sebelum[0]['saldo_sebelum'] + $saldo_sebelum[0]['mutasi'];
        } else {
            $saldo_sebelum = 0;
        }
        $res[0][0]['saldo_sebelum'] = $saldo_sebelum;
        $res[0][0]['saldo'] = $saldo_sebelum - $mutasi;
        $this->rec_data_to_db($res[0][0]);
        // echo json_encode($res);
        // die();
        if ($kredit > 0 or $debit  > 0)
            return true;
        else
            return false;
    }

    public function rec_data_to_db($data)
    {
        $data['date_tmp'] = $data['year'] . '-' . $data['month'] . '-01';
        $this->db->select('*');
        $this->db->from('count_transaction_year_month');
        $this->db->where('year = ' . $data['year'] . ' AND month = ' . $data['month']);
        $this->db->where('accounthead', $data['accounthead']);
        $res = $this->db->get();
        $res = $res->result_array();
        if (!empty($res)) {
            $this->db->where('id', $res[0]['id']);
            $this->db->update('count_transaction_year_month', $data);
        } else {
            $this->db->insert('count_transaction_year_month', $data);
        }
    }

    public function akumulasi_set_zero($data)
    {
        $query = 'UPDATE count_transaction_year_month JOIN mp_head ON mp_head.id = count_transaction_year_month.accounthead
        Set debit = 0 , kredit = 0, saldo_sebelum  = 0 ,mutasi = 0, saldo = 0
        WHERE count_transaction_year_month.year = ' . $data['filter']['year'] . ' AND mp_head.name LIKE "[';
        $query = $query . $data['name'] . '%"';
        // echo $query;
        $this->db->query($query);
    }

    public function recount_akumulasi($data)
    {

        $query = 'UPDATE count_transaction_year_month JOIN mp_head ON mp_head.id = count_transaction_year_month.accounthead
        Set saldo_sebelum  = saldo_sebelum+' . $data['amount'] . ' ,mutasi = mutasi +' . $data['amount'] . ', saldo = saldo +' . $data['amount'] . '
        WHERE count_transaction_year_month.year = ' . $data['year'] . ' AND count_transaction_year_month.month > ' . $data['month'] . ' AND mp_head.name LIKE "[';
        $query = $query . $data['name'] . '%"';
        // echo $query;
        $this->db->query($query);

        $query = 'UPDATE count_transaction_year_month JOIN mp_head ON mp_head.id = count_transaction_year_month.accounthead
        Set mutasi = mutasi +' . $data['amount'] . ', saldo = saldo +' . $data['amount'] . '
        WHERE count_transaction_year_month.year = ' . $data['year'] . ' AND count_transaction_year_month.month = ' . $data['month'] . ' AND mp_head.name LIKE "[';
        $query = $query . $data['name'] . '%"';
        // echo $query;
        $this->db->query($query);
        // var_dump($data);
        // die();
    }
}
