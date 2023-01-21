<?php
/*

*/
class Bank_model extends CI_Model
{


    public function getAllBank($filter = [])
    {
        $this->db->select('bt.*, ba.name as akun_name');
        $this->db->from('mp_banks as bt');
        $this->db->join('mp_head as ba', 'ba.id = bt.relation_head', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('bt.id', $filter['id']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        $res = $query->result_array();
        return $res;
    }
    public function getBankTransaction($filter = [])
    {
        $this->db->select('bt.* , ba.bankname,ba.relation_head, ba.accountno as bank_number, pa.customer_name');
        $this->db->from('dt_bank_transaction as bt');
        $this->db->join('mp_banks as ba', 'ba.id = bt.bank_id', 'LEFT');
        $this->db->join('mp_payee as pa', 'pa.id = bt.payee_id', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('bt.id', $filter['id']);
        $this->db->where('bt.transaction_type', $filter['transaction_type']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        $res = $query->result_array();
        return $res;
    }

    public function getAllJournalVoucher($filter = [])
    {
        $this->db->select("gen.id as parent_id, sub.id as sub_id,gen.ref_number,gen.date,gen.naration,gen.customer_id,gen.user_update,sub.accounthead,sub.amount,sub.type,sub.sub_keterangan,head.name as head_name, head_number    ");
        $this->db->from('dt_generalentry as gen');
        $this->db->join('mp_sub_entry as sub', "gen.id = sub.parent_id", 'LEFT');
        $this->db->join('dt_head as head', "head.id = sub.accounthead", 'LEFT');
        if (!empty($filter['id'])) $this->db->where('gen.id', $filter['id']);
        // $this->db->order_by('mp_menu.order_number');
        $res = $this->db->get();
        // echo json_encode(DataStructure::groupBy2($query->result_array(), 'parent_id', 'parent_id', ['parent_id', 'name', 'order_number'], 'items'));
        $ret = DataStructure::groupByRecursive2(
            $res->result_array(),
            ['parent_id'],
            ['sub_id'],
            [
                ['parent_id', 'ref_number', 'date', 'naration', 'customer_id', 'user_update'],
                ['sub_id', 'accounthead', 'head_name', 'amount', 'type', 'sub_keterangan', 'head_number']
            ],
            ['children']
        );
        return $ret;
    }

    public function clear_hak_aksess($data)
    {
        $this->db->where('id_user', $data['user_id']);
        $this->db->delete('hak_aksess');
    }
    public function update_hak_aksess($data)
    {
        $sub_data  = array(
            'id_menulist'   => $data['id_menulist'],
            'id_user'   => $data['user_id'],
        );

        if (!empty($data['view'])) $sub_data['view'] = $data['view'];
        if (!empty($data['create'])) $sub_data['hk_create'] = $data['create'];
        if (!empty($data['update'])) $sub_data['hk_update'] = $data['update'];
        if (!empty($data['delete'])) $sub_data['hk_delete'] = $data['delete'];
        $this->db->insert('hak_aksess', $sub_data);
    }

    public function addBank($data)
    {
        $this->db->insert('mp_banks', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Bank", "Bank");
        $id_ins = $this->db->insert_id();
        return $id_ins;
    }

    public function editBank($data)
    {
        $this->db->where('id', $data['id']);

        $this->db->update('mp_banks', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Edit Bank", "Bank");
        return $data['id'];
    }

    public function deleteBank($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('mp_banks');
        ExceptionHandler::handleDBError($this->db->error(), "Delete Bank", "Bank");
        return $data['id'];
    }

    public function addBankTrans($data)
    {
        $this->db->insert('dt_bank_transaction', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Transaksi", "Bank");
        $id_ins = $this->db->insert_id();
        return $id_ins;
    }

    public function editBankTrans($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('dt_bank_transaction', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Edit Bank", "Bank");
        return $data['id'];
    }
    public function deleteTransaction($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('dt_bank_transaction');
        ExceptionHandler::handleDBError($this->db->error(), "Delete Bank", "Bank");
        return $data['id'];
    }

    public  function deposito_post($data)
    {
        $this->db->trans_begin();
        $data['generalentry']['ref_number'] = $this->gen_number($data['generalentry']);
        $this->db->insert('dt_generalentry', $data['generalentry']);

        $order_id = $this->db->insert_id();

        $data['sub_entry'][0]['parent_id'] = $order_id;
        $data['sub_entry'][1]['parent_id'] = $order_id;
        $this->db->insert('mp_sub_entry', $data['sub_entry'][0]);
        $this->db->insert('mp_sub_entry', $data['sub_entry'][1]);

        $this->db->where('id', $data['id']);
        $this->db->set('transaction_status	', 1);
        $this->db->set('transaction_id', $order_id);
        $this->db->update('dt_bank_transaction');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            ExceptionHandler::handleDBError($this->db->error(), "Delete Bank", "Bank");
        } else {
            $this->db->trans_commit();
        }
    }

    public  function batal_setor($data)
    {
        $this->db->trans_begin();
        $this->db->where('id', $data['transaction_id']);
        $this->db->delete('dt_generalentry');

        // $order_id = $this->db->insert_id();
        $this->db->where('parent_id', $data['transaction_id']);
        $this->db->delete('mp_sub_entry');

        $this->db->where('id', $data['id']);
        $this->db->set('transaction_status	', 0);
        $this->db->set('transaction_id', 0);
        $this->db->update('dt_bank_transaction');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            ExceptionHandler::handleDBError($this->db->error(), "Delete Bank", "Bank");
        } else {
            $this->db->trans_commit();
        }
    }



    public function gen_number($data = [])
    {
        $this->db->from('dt_generalentry');
        // $this->db->from('limit', 1);
        $this->db->limit(1);
        $this->db->order_by('date,id', 'DESC');

        // if (!empty($filter['account_head'])) $this->db->where('dt_head.id', $filter['account_head']);
        // if (!empty($filter['id'])) $this->db->where('dt_head.id', $filter['id']);
        $this->db->where('generated_source', $data['generated_source']);
        $this->db->where('MONTH(DATE)', explode('-', $data['date'])[1]);
        $this->db->where('YEAR(DATE)', explode('-', $data['date'])[0]);
        $query = $this->db->get();
        // if (!empty($filter['by_id'])) {
        $res =  $query->result_array();
        if ($data['generated_source'] == 'deposit') {
            $s2 = 'DEP';
        } else if ($data['generated_source'] == 'paid') {
            $s2 = 'CEK';
        } else {
            $s2 = 'JV';
        }
        $number = explode('-', $data['date'])[0] . '/' . $s2 . '/' . $this->getRomawi((int)explode('-', $data['date'])[1]) . '/';

        if (!empty($res)) {
            $res = $res[0];

            if (!empty(explode('/', $res['ref_number'])[3])) {
                $res_num =  (int)explode('/', $res['ref_number'])[3] + 1;
                $numlength = strlen((string)$res_num);
                if ($numlength == 1) {
                    $res_num = '00' . $res_num;
                } else if ($numlength == 2) {
                    $res_num = '0' . $res_num;
                }
            } else {
                $res_num = '001';
            }
            // echo $numlength;
            // echo $number;
            // die();
        } else {
            $res_num = '001';
        }
        $number .= $res_num;
        return $number;
        // }
        // MONTH(happened_at) = 1 and YEAR(happened_at) = 2009
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
