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
        $this->db->from('mp_generalentry');
        // if (!empty($filter['id']))
        $this->db->where('id', $filter['id']);
        // $this->db->where('date >=', $date1);
        // $this->db->where('date <=', $date2);
        $this->db->order_by('mp_generalentry.id', 'DESC');
        $query = $this->db->get();
        $transaction_records =  $query->result()['0'];
        if ($transaction_records  != NULL) {
            $this->db->select("mp_sub_entry.*,mp_head.name");
            $this->db->from('mp_sub_entry');
            $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
            $this->db->where('mp_sub_entry.parent_id =', $transaction_records->transaction_id);
            $sub_query = $this->db->get();
            if ($sub_query->num_rows() > 0) {
                $sub_query =  $sub_query->result();
            }
        }
        $data['parent'] = $transaction_records;
        $data['sub_parent'] = $sub_query;
        // echo json_encode($data);
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
        $this->db->from('mp_generalentry');
        if (!empty($filter['no_jurnal']))
            $this->db->where('no_jurnal like "%' . $filter['no_jurnal'] . '%"');
        $this->db->where('date >=', $filter['from']);
        $this->db->where('date <=', $filter['to']);

        $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        $i = 0;
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result_array();
            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $return_data[$i] = $transaction_record;
                    $this->db->select("mp_sub_entry.*,mp_head.name");
                    $this->db->from('mp_sub_entry');
                    $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
                    $this->db->where('mp_sub_entry.parent_id =', $transaction_record['transaction_id']);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result_array();
                        if ($sub_query != NULL) {
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
    public function detail_fetch_transasctions($id)
    {

        $total_debit = 0;
        $total_credit = 0;
        $form_content = '';

        $this->db->select("mp_generalentry.id as transaction_id,mp_payee.customer_name,mp_generalentry.date,mp_generalentry.customer_id,arr_cars,mp_generalentry.naration,mp_generalentry.no_jurnal, gen_lock");
        $this->db->from('mp_generalentry');
        // $this->db->where('date >=', $date1);
        $this->db->join('mp_payee', 'mp_payee.id = mp_generalentry.customer_id', 'LEFT');
        $this->db->where('mp_generalentry.id', $id);
        $this->db->order_by('mp_generalentry.id', 'DESC');
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

    //USED TO GET THE LEDGER USING NATURE 
    public function get_ledger_transactions($head_id, $date1, $date2)
    {
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.no_jurnal,mp_generalentry.naration,mp_generalentry.no_jurnal,mp_head.name,mp_head.nature,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
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
    public function the_ledger($date1, $date2)
    {
        $accounts_types = array('Assets', 'Liability', 'Equity', 'Revenue', 'Expense');
        $form_content = '';
        for ($i = 0; $i  < count($accounts_types); $i++) {
            $form_content .= '<h4 class=""><b>' . $accounts_types[$i] . ' : </b></h4>';
            $this->db->select('mp_head.*');
            $this->db->from('mp_head');
            $this->db->order_by('mp_head.name');
            $this->db->where(['mp_head.nature' => $accounts_types[$i]]);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $heads_record =  $query->result();
                foreach ($heads_record as $single_head) {
                    $data_leadger = $this->get_ledger_transactions($single_head->id, $date1, $date2);
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
                        <td>' . $single_ledger->date . '</td><td>' . $single_ledger->no_jurnal . '</td><td><a >' . $single_ledger->sub_keterangan . '</a></td><td>
                            <a  class="currency">' .
                                (!empty($debitamount) ? number_format($debitamount, 2, ',', '.') : '') .
                                '</a>
                        </td>
                        <td>
                            <a   class="currency">' .
                                (!empty($creditamount) ? number_format($creditamount, 2, ',', '.') : '')
                                . '</a>
                        </td>
                        <td  >' . ($total_ledger < 0 ? '( <a class="currency">' . number_format(-$total_ledger, 2, ',', '.') . '</a>)' : '<a class="currency">' . $total_ledger . '</a>') . '</td>            
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
                        $from_creator .= '<tr><td><h4>' . $single_head->name . '</h4></td><td class="pull-right"><h4>' . number_format($amount, '2', '.', '') . '</h4></td></tr>';
                    }
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
                    $amount =  $this->count_head_amount($single_head->id, $date1, $date2);
                    if ($amount != 0) {
                        $total_expense = $total_expense + $amount;
                        $from_creator .= '<tr><td><h4>' . $single_head->name . '</h4></td><td class="pull-right"><h4>' . number_format($amount, '2', '.', '') . '</h4></td></tr>';
                    }
                }
                $from_creator .= '<tr><td> Total Expense </td><td class="pull-right">' . number_format($total_expense, '2', '.', '') . '</td></tr>';

                $from_creator .= '<tr class=" total-income"><td> Total Net Lost / Profit </td><td class="pull-right">' . number_format($total_revenue - $total_expense, '2', '.', '') . '</td></tr>';
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

    public function get_acc($id, $name = false)
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
        $this->db->where('mp_payee.type', 'patners');
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
        // die();
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

    //COUNT HEAD AMOUNT USING HEAD ID 
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
}
