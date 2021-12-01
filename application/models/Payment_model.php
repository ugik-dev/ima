<?php
/*

*/
class Payment_model extends CI_Model
{

    function search_items_stock($data)
    {
        $this->db->select("*");
        $this->db->from('dt_jenis_pembayaran');
        $this->db->or_like(['product_name' => $data]);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function getDetailTransaction($filter = [], $keys = true)
    {
        $this->db->select('gen.*, sub.*, prod.product_name, ru.name_unit, pay.customer_name, pay.cus_address, bn.bankname, bn.title as bank_title, bn.accountno as bank_number');
        $this->db->from('dt_transaction as gen');
        $this->db->join('dt_transaction_item as sub', "gen.id = sub.id_parent", 'LEFT');
        $this->db->join('mp_payee as pay', "gen.customer_id = pay.id", 'LEFT');
        $this->db->join('dt_jenis_pembayaran as prod', "sub.id_product = prod.id", 'LEFT');
        $this->db->join('ref_unit as ru', "ru.id_unit = prod.default_unit", 'LEFT');
        $this->db->join('ref_account as ra', "ra.ref_id = gen.payment_id", 'LEFT');
        $this->db->join('mp_banks as bn', "bn.relation_head = ra.ref_account", 'LEFT');
        if (!empty($filter['id'])) $this->db->where('gen.id', $filter['id']);
        if (!empty($filter['id_parent1'])) $this->db->where('gen.id', $filter['id']);
        $this->db->order_by('gen.status, gen.id,  sub.id_item ', 'DESC');
        $res = $this->db->get();

        $ret = DataStructure::groupByRecursive2(
            $res->result_array(),
            ['id_parent'],
            ['id_item'],
            [
                ['id_parent', 'bankname', 'cus_address', 'bank_title', 'bank_number', 'customer_name', 'status', 'id_parent1', 'id_parent2', 'total_gross', 'total_tax', 'discount', 'amount_received_1', 'amount_received_2', 'amount_back_1', 'amount_back_2', 'date_1', 'date_2'],
                ['id_item', 'id_product', 'price', 'tax', 'qyt', 'product_name', 'name_unit']
            ],
            ['children'],
            $keys
        );

        return $ret;
    }

    public function getAllPayment($filter = [])
    {
        $this->db->select('dt.* , head.name as head_name, ru.name_unit');
        $this->db->from('dt_jenis_pembayaran as dt');
        $this->db->join('ref_unit as ru', 'ru.id_unit = dt.default_unit', 'LEFT');
        $this->db->join('mp_head as head', 'head.id = dt.revenue_account', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('dt.id', $filter['id']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        $res = $query->result_array();
        return $res;
    }

    public function getAllTransactions($filter = [])
    {

        $this->db->select('dt.* , pa.customer_name');
        $this->db->from('dt_transaction as dt');
        $this->db->join('mp_payee as pa', 'pa.id = dt.customer_id', 'LEFT');
        // $this->db->join('dt_head as head', 'head.id = dt.revenue_account', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('dt.id', $filter['id']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        $res = $query->result_array();
        return $res;
    }


    public function addPayment($data)
    {
        $this->db->insert('dt_jenis_pembayaran', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Payment", "Payment");
        $id_ins = $this->db->insert_id();
        return $id_ins;
    }

    public function editPayment($data)
    {
        $this->db->where('id', $data['id']);

        $this->db->update('dt_jenis_pembayaran', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Edit Payment", "Payment");
        return $data['id'];
    }
    public function deletePayment($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('dt_jenis_pembayaran');
        ExceptionHandler::handleDBError($this->db->error(), "Delete Payment", "Payment");
        return $data['id'];
    }

    public function addPaymentTrans($data)
    {
        $this->db->insert('dt_bank_transaction', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Transaksi", "Payment");
        $id_ins = $this->db->insert_id();
        return $id_ins;
    }

    public function editPaymentTrans($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('dt_bank_transaction', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Edit Payment", "Payment");
        return $data['id'];
    }
    public function deleteTransaction($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('dt_bank_transaction');
        ExceptionHandler::handleDBError($this->db->error(), "Delete Payment", "Payment");
        return $data['id'];
    }

    public  function deposito_post($data)
    {
        // $this->db->trans_begin();
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
            ExceptionHandler::handleDBError($this->db->error(), "Delete Payment", "Payment");
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
            ExceptionHandler::handleDBError($this->db->error(), "Delete Payment", "Payment");
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
        } else if ($data['generated_source'] == 'invoice') {
            $s2 = 'INV';
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

    public  function addInvoice($data, $trans)
    {
        $this->db->trans_begin();
        // $data['generalentry']['ref_number'] = $this->gen_number($data['generalentry']);
        // $this->db->insert('dt_generalentry', $data['generalentry']);

        // $order_id = $this->db->insert_id();
        // $i = 0;
        // foreach ($data['sub_entry'] as $sub) {
        //     $data['sub_entry'][$i]['parent_id'] = $order_id;
        //     $this->db->insert('mp_sub_entry', $data['sub_entry'][$i]);
        //     $i++;
        // }

        $kembalian = $trans['amount_recieved'] - ($trans['total_gross_amt'] + $trans['total_tax_amt'] - $trans['discountfield']);
        if ($kembalian < 0) {
            $status = 'unpaid';
        } else {
            $status = 'paid';
        }
        $data_trans = array(
            // 'id_parent1' => $order_id,
            'source' => 'invoice',
            'customer_id' => $trans['customer_id'],
            'total_gross' => $trans['total_gross_amt'],
            'total_tax' => $trans['total_tax_amt'],
            'discount' => $trans['discountfield'],
            'amount_received_1' => $trans['amount_recieved'],
            'amount_back_1' => $kembalian,
            'status' => $status,
            'date_1' => $trans['date'],
            'payment_id' => $trans['payment_id']

        );

        $this->db->insert('dt_transaction', $data_trans);
        $id_trans = $this->db->insert_id();
        // $order_id = $this->db->insert_id();
        $i = 0;
        foreach ($trans['row_price'] as $sub) {
            if (!empty($trans['row_price'][$i]) && !empty($trans['row_qyt'][$i]) && !empty($trans['item_id'][$i])) {
                $data_trans = array(
                    'id_parent' => $id_trans,
                    'id_product' => $trans['item_id'][$i],
                    'price' => $trans['row_price'][$i],
                    'tax' => $trans['fix_tax'][$i],
                    'qyt' => $trans['row_qyt'][$i]
                );
                $this->db->insert('dt_transaction_item', $data_trans);
            }
            $i++;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            ExceptionHandler::handleDBError($this->db->error(), "Delete Bank", "Bank");
        } else {

            $this->db->trans_commit();
            return $id_trans;
        }
    }
}
