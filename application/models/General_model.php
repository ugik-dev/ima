<?php
/*

*/
class General_model extends CI_Model
{

    // function getAllGeneralenral($id)
    // {
    //     $this->db->select("gen_lock as gen_lock");
    //     $this->db->from('mp_generalentry');
    //     $this->db->where('id',  $id);
    //     $query = $this->db->get();
    //     return $query->result_array()[0]['gen_lock'];
    // }

    public function getJurnalUmum($filter)
    {
        $this->db->select('gen.* ,sub.id as sub_id, sub.type,sub.amount,accounthead,sub_keterangan, head.name as head_name');
        $this->db->from('mp_generalentry gen');
        $this->db->join('mp_sub_entry sub', 'gen.id = sub.parent_id', 'LEFT');
        $this->db->join('mp_head head', 'sub.accounthead = head.id', 'LEFT');

        // if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        if (!empty($filter['from'])) $this->db->where('gen.date >=', $filter['from']);
        if (!empty($filter['to'])) $this->db->where('gen.date <=', $filter['to']);

        // $this->db->limit(20);
        // $this->db->order_by('gen.status, gen.id,  sub.id_item ', 'DESC');
        $res = $this->db->get();
        $res = DataStructure::groupByRecursive2(
            $res->result_array(),
            ['id'],
            ['sub_id'],
            [
                [
                    'id', 'no_jurnal', 'id', 'customer_id', 'date', 'naration', 'generated_source'
                ],
                ["sub_id", "type", "amount", "accounthead", 'sub_keterangan', 'head_name']
            ],
            ['children'],
            false
        );
        // $res = $res->result_array();
        // echo json_encode($res);
        // die();
        return $res;
    }

    function getAllPelunasanInvoice($filter = [])
    {
        $this->db->select('mpp.* , us.agentname , gen.no_jurnal ,nominal+COALESCE(sum(ac_nominal),0) as sum_child');
        $this->db->from('dt_pelunasan_invoice mpp');
        $this->db->join('dt_pel_inv_potongan as potongan', 'mpp.id = potongan.id_pelunasan', 'LEFT');
        $this->db->join('mp_users us', 'mpp.agen_id = us.id', 'LEFT');
        $this->db->join('mp_generalentry gen', 'gen.id = mpp.general_id', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        if (!empty($filter['parent_id'])) $this->db->where('mpp.parent_id', $filter['parent_id']);
        if (!empty($filter['ex_id'])) $this->db->where('mpp.id <> ' . $filter['ex_id']);
        // if (!empty($filter['id_parent1'])) $this->db->where('gen.id', $filter['id']);
        // $this->db->order_by('gen.status, gen.id,  sub.id_item ', 'DESC');
        $this->db->group_by('mpp.id');
        $res = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($res->result_array(), 'id');
        }

        $res = $res->result_array();
        return $res;
    }

    function getChildrenPelunasan($filter = [])
    {
        $this->db->select('*');
        $this->db->from('dt_pel_inv_potongan mpp');
        if (!empty($filter['id_pelunasan'])) $this->db->where('mpp.id_pelunasan', $filter['id_pelunasan']);
        $res = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($res->result_array(), 'id');
        }
        $res = $res->result_array();
        return $res;
    }

    function getAllGeneralentry($filter = [])
    {
        $this->db->from('mp_generalentry mpp');
        if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        $res = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($res->result_array(), 'id');
        }
        $res = $res->result_array();
        return $res;
    }


    public function getAllBaganAkun($filter = [])
    {
        $this->db->from('mp_head');
        if (!empty($filter['account_head'])) $this->db->where('mp_head.id', $filter['account_head']);
        if (!empty($filter['id'])) $this->db->where('dt_mp_headhead.id', $filter['id']);
        if (!empty($filter['nature'])) {
            if (is_array($filter['nature'])) {
                $this->db->where_in('mp_head.nature', $filter['nature']);
            } else
                $this->db->where('mp_head.nature', $filter['nature']);
        }
        $this->db->order_by('mp_head.name', 'ASC');
        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        // echo json_encode($query->result_array());
        // die();
        if (!empty($filter['by_DataStructure'])) {
            return DataStructure::TreeAccountsIMA($query->result_array());
        }
        if (!empty($filter['by_DataStructure2'])) {
            return DataStructure::TreeAccountsIMA2($query->result_array());
        }
        $res = $query->result_array();
        return $res;
    }

    public function getAllPayee($filter = [])
    {
        $this->db->from('mp_payee');
        if (!empty($filter['id'])) $this->db->where('id', $filter['id']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }

        $res = $query->result_array();
        return $res;
    }


    public function getAllRefAccount($filter = [])
    {
        $this->db->select('ref.*, head.name as ref_account_name, banks.*');
        $this->db->from('ref_account ref');
        $this->db->join('mp_head as head', 'head.id = ref.ref_account', 'LEFT');
        $this->db->join('mp_banks as banks', 'banks.relation_head = head.id', 'LEFT');

        if (!empty($filter['ref_id'])) $this->db->where('ref_id', $filter['ref_id']);
        if (!empty($filter['ref_type'])) $this->db->where('ref_type', $filter['ref_type']);


        if (!empty($filter['by_id'])) {
            $query = $this->db->get();
            return DataStructure::keyValue($query->result_array(), 'ref_id');
        }

        if (!empty($filter['by_type'])) {
            $query = $this->db->get();
            return DataStructure::keyValue($query->result_array(), 'ref_type');
        }

        $this->db->order_by('order_number');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }

    public function getAllPaymentMethod($filter = [])
    {

        $this->db->select('id_payment_method, payment_text,payment_account');
        $this->db->from('dt_payment_method');
        $this->db->order_by('order_number');
        if (!empty($filter['id_payment_method'])) $this->db->where('id_payment_method', $filter['id_payment_method']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id_payment_method');
        }

        $res = $query->result_array();
        return $res;
    }

    public function getAllBank($filter = [])
    {
        $this->db->from('mp_banks');
        if (!empty($filter['id'])) $this->db->where('mp_banks.id', $filter['id']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        $res = $query->result_array();
        return $res;
    }

    public function getAllUnit($filter = [])
    {
        $this->db->from('ref_unit');
        // echo 'sds';
        if (!empty($filter['id_unit'])) $this->db->where('ref_unit.id_unit', $filter['id_unit']);

        $query = $this->db->get();
        // var_dump($query);
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id_unit');
        }

        $res = $query->result_array();
        return $res;
    }
    public function getAllJenisPembayaran($filter = [])
    {

        $this->db->select('ref.*, head_paid.name as name_paid, head_unpaid.name as name_unpaid ,head_piutang.name as name_piutang');
        $this->db->from('ref_jenis_pembayaran as ref');
        $this->db->join('mp_head as head_paid', 'head_paid.id = ref.ac_paid', 'LEFT');
        $this->db->join('mp_head as head_unpaid', 'head_unpaid.id = ref.ac_unpaid', 'LEFT');
        $this->db->join('mp_head as head_piutang', 'head_piutang.id = ref.ac_piutang', 'LEFT');
        // echo 'sds';
        if (!empty($filter['id'])) $this->db->where('ref.id', $filter['id']);

        $query = $this->db->get();
        // var_dump($query);
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }

        $res = $query->result_array();
        return $res;
    }

    public function getAllJenisInvoice($filter = [])
    {

        $this->db->select('ref.*,head_ppn.name as name_ppn ,head_ppn_piut.name as name_ppn_piut,head_paid.name as name_paid, head_unpaid.name as name_unpaid ,head_piutang.name as name_piutang');
        $this->db->from('ref_jenis_invoice as ref');
        $this->db->join('mp_head as head_paid', 'head_paid.id = ref.ac_paid', 'LEFT');
        $this->db->join('mp_head as head_unpaid', 'head_unpaid.id = ref.ac_unpaid', 'LEFT');
        $this->db->join('mp_head as head_piutang', 'head_piutang.id = ref.ac_piutang', 'LEFT');
        $this->db->join('mp_head as head_ppn', 'head_ppn.id = ref.ac_ppn', 'LEFT');
        $this->db->join('mp_head as head_ppn_piut', 'head_ppn_piut.id = ref.ac_ppn_piut', 'LEFT');
        // echo 'sds';
        if (!empty($filter['id'])) $this->db->where('ref.id', $filter['id']);

        $query = $this->db->get();
        // var_dump($query);
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }

        $res = $query->result_array();
        return $res;
    }


    public function profit_monthly()
    {
        $filter['year'] = date('Y');
        for ($i = 1; $i <= 12; $i++) {
            $filter['month'] = $i;
            $data['revenue'][$i - 1] = -$this->get_trail_balance('Revenue', $filter);
            $data['expense'][$i - 1] = $this->get_trail_balance('Expense', $filter);
        }
        return $data;
        // echo json_encode($data);
        // die;
    }

    public function get_trail_balance($head_id, $filter = [])
    {
        $count_total_amt = 0;
        $this->db->select('ROUND(sum(IF(mp_sub_entry.type = 0,  mp_sub_entry.amount,-mp_sub_entry.amount)),2) as amount');
        // $this->db->select("dt_generalentry.id as transaction_id,dt_generalentry.date,dt_generalentry.naration,dt_generalentry.ref_number,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('dt_generalentry', 'dt_generalentry.id = mp_sub_entry.parent_id');
        $this->db->join('dt_head', 'dt_head.id = mp_sub_entry.accounthead');
        $this->db->where('dt_head.nature', $head_id);
        if (!empty($filter['year'])) $this->db->where('YEAR(dt_generalentry.date)', $filter['year']);
        if (!empty($filter['month'])) $this->db->where('MONTH(dt_generalentry.date)', $filter['month']);

        $query = $this->db->get();
        return  $query->result_array()[0]['amount'] ?  $query->result_array()[0]['amount'] : 0;
    }

    public function gen_number($date, $type)
    {
        $this->db->from('mp_generalentry');
        // var_dump($date);
        // die();
        // $this->db->from('limit', 1);
        $this->db->limit(1);
        $this->db->order_by("no_jurnal", 'DESC');

        // if (!empty($filter['account_head'])) $this->db->where('dt_head.id', $filter['account_head']);
        // if (!empty($filter['id'])) $this->db->where('dt_head.id', $filter['id']);
        // SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -2), ']', 1)
        $this->db->where(
            "SUBSTRING_INDEX(SUBSTRING_INDEX(no_jurnal, '/', 2),'/',-1) = '" . $type . "'"
        );
        $this->db->where('MONTH(DATE)', explode('-', $date)[1]);
        $this->db->where('YEAR(DATE)', explode('-', $date)[0]);
        $query = $this->db->get();
        $res =  $query->result_array();
        if (!empty($res)) {
            $res = $res[0];

            if (!empty(explode('/', $res['no_jurnal'])[0])) {
                $res_num =  (int)explode('/', $res['no_jurnal'])[0] + 1;
                $numlength = strlen((string)$res_num);
                if ($numlength == 1) {
                    $res_num = '00' . $res_num;
                } else if ($numlength == 2) {
                    $res_num = '0' . $res_num;
                }
            } else {
                $res_num = '001';
            }
        } else {
            $res_num = '001';
        }
        $number = $res_num . '/' . $type . '/' . $this->getRomawi((int)explode('-', $date)[1]) . '/' . substr(explode('-', $date)[0], -2);
        // var_dump($number);
        // die();
        // $number .= $res_num;
        return $number;
        // }
        // MONTH(happened_at) = 1 and YEAR(happened_at) = 2009
    }

    public function gen_numberABC($date, $type, $sources)
    {
        $this->db->from('mp_generalentry');
        // $this->db->from('limit', 1);
        $this->db->limit(1);
        $this->db->order_by("no_jurnal", 'DESC');

        // if (!empty($filter['account_head'])) $this->db->where('dt_head.id', $filter['account_head']);
        // if (!empty($filter['id'])) $this->db->where('dt_head.id', $filter['id']);
        // SUBSTRING_INDEX(SUBSTRING_INDEX(mp_head.name, '.', -2), ']', 1)
        $this->db->where(
            "SUBSTRING_INDEX(SUBSTRING_INDEX(no_jurnal, '/', 2),'/',-1) = '" . $type . "'"
        );

        $this->db->where(
            "generated_source",
            $sources
        );
        $this->db->where('MONTH(DATE)', explode('-', $date)[1]);
        $this->db->where('YEAR(DATE)', explode('-', $date)[0]);
        $query = $this->db->get();
        $res =  $query->result_array();

        if (!empty($res)) {
            $x = substr($res[0]['no_jurnal'], -1);
            $x = is_numeric($x);
            if ($x) {
                $x = $res[0]['no_jurnal'] . 'B';
            } else {
                if (substr($res[0]['no_jurnal'], -1) != 'Z') {
                    $letter = substr($res[0]['no_jurnal'], -1);
                    $letterAscii = ord($letter);
                    $letterAscii++;
                    $letter = chr($letterAscii);
                    $x = substr($res[0]['no_jurnal'], 0, -1) . $letter;
                } else {
                    $x = substr($res[0]['no_jurnal'], 0, -1) . 'AA';
                }
            }
            return $x;
        } else {
            return $this->gen_number($date, $type) . 'A';
        }
    }

    public function neraca_saldo($data, $filter)
    {
        // echo json_encode($data);
        // die();
        foreach ($data as $key1 => $lv1) {
            $res = $this->sum_debit_and_credit($lv1['head_number'], $filter);
            if ($res['debit'] > 0 or $res['kredit'] > 0) {
                $data[$key1]['datas'] = $res;
                $data[$key1]['open'] = true;

                if (!empty($lv1['children']))
                    foreach ($lv1['children'] as $key2 => $lv2) {
                        if (empty($lv2['head_number'])) {
                            echo json_encode($lv2);
                            die();
                        }
                        $res = $this->sum_debit_and_credit($lv2['head_number'], $filter);
                        if ($res['debit'] > 0 or $res['kredit'] > 0) {
                            $data[$key1]['children'][$key2]['datas'] = $res;
                            $data[$key1]['children'][$key2]['open'] = true;

                            if (!empty($lv2['children']))
                                foreach ($lv2['children'] as $key3 => $lv3) {
                                    if (empty($lv3['head_number'])) {
                                        echo json_encode($lv3);
                                        die();
                                    }
                                    $res = $this->sum_debit_and_credit($lv3['head_number'], $filter);

                                    if ($res['debit'] > 0 or $res['kredit'] > 0) {
                                        $data[$key1]['children'][$key2]['children'][$key3]['datas'] = $res;
                                        $data[$key1]['children'][$key2]['children'][$key3]['open'] = true;

                                        if (!empty($lv3['children']))
                                            foreach ($lv3['children'] as $key4 => $lv4) {
                                                $res = $this->sum_debit_and_credit($lv4['head_number'], $filter);
                                                if ($res['debit'] > 0 or $res['kredit'] > 0) {
                                                    $data[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['datas'] = $res;
                                                    $data[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['open'] = true;
                                                }
                                            }
                                    }
                                }
                        }
                    }
            }
        }
        return $data;
    }

    function sum_debit_and_credit($head_id, $filter)
    {
        $count_total_amt = 0;
        $this->db->select("COALESCE(sum(if(mp_sub_entry.type=0,amount,0)),0) as debit, COALESCE(sum(if(mp_sub_entry.type=1,amount,0)),0) as kredit");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
        $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
        $this->db->where('mp_head.name like "[' . $head_id . '%"');
        $this->db->where('mp_generalentry.date >=', $filter['from']);
        $this->db->where('mp_generalentry.date <=', $filter['to']);

        $res = $this->db->get();
        // $res
        return $res->result_array()[0];
    }


    function getRomawi($bln)
    {
        switch ($bln) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
