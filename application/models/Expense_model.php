<?php
/*

*/
class Expense_model extends CI_Model
{

    public function getAllExpense($filter = [])
    {
        $this->db->select('bt.*, pa.customer_name, hd.name as head_name, re.ref_text  as payment_name');
        $this->db->from('mp_expense as bt');
        $this->db->join('ref_account as re', 're.ref_id = bt.method', 'LEFT');
        $this->db->join('mp_payee as pa', 'pa.id = bt.payee_id', 'LEFT');
        $this->db->join('mp_head as hd', 'hd.id = bt.head_id', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('bt.id', $filter['id']);
        // $this->db->where('bt.transaction_type', $filter['transaction_type']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }
        $res = $query->result_array();
        return $res;
    }


    public function addExpense($data)
    {
        $this->db->trans_start();

        $this->db->insert('mp_generalentry', $data['generalentry']);
        $gen_id = $this->db->insert_id();
        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $gen_id;
            $this->db->insert('mp_sub_entry', $sub);
        }

        $trans = array(
            'head_id' => $data['head_id'],
            'transaction_id' => $gen_id,
            'date' => $data['date'],
            'total_paid' => $data['amount'],
            'user' => $this->session->userdata('user_id')['id'],
            'method' => $data['method'],
            'description' => $data['description'],
            'ref_no' => $data['ref_no'],
            'payee_id' => $data['payee_id'],
        );


        $this->db->insert('mp_expense', $trans);
        $id_ins = $this->db->insert_id();
        $url = 'expense/show/' . $id_ins;

        $this->db->set('url', $url);
        $this->db->where('id', $gen_id);
        $this->db->update('mp_generalentry');

        // return $id_ins;
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
            return $id_ins;
        }
    }

    public function editExpense($data)
    {
        $this->db->trans_start();
        $this->db->where('id', $data['old']['transaction_id']);
        $this->db->update('mp_generalentry', $data['generalentry']);

        $this->db->where('parent_id', $data['old']['transaction_id']);
        $this->db->delete('mp_sub_entry');

        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $data['old']['transaction_id'];
            $this->db->insert('mp_sub_entry', $sub);
        }

        $trans = array(
            'head_id' => $data['head_id'],
            'date' => $data['date'],
            'total_paid' => $data['amount'],
            'user' => $this->session->userdata('user_id')['id'],
            'method' => $data['method'],
            'description' => $data['description'],
            'ref_no' => $data['ref_no'],
            'payee_id' => $data['payee_id'],
        );


        $this->db->where('id', $data['id']);
        $this->db->update('mp_expense', $trans);


        // return $id_ins;
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
            // return $id_ins;
        }
    }


    public function deleteExpense($data)
    {
        // $this->db->trans_start();

        $this->db->trans_start();
        $this->db->where('id', $data['id']);
        $this->db->delete('mp_expense');
        $this->db->where('parent_id', $data['transaction_id']);
        $this->db->delete('mp_sub_entry');


        $this->db->where('id', $data['transaction_id']);
        $this->db->delete('mp_generalentry');


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
            return $data['id'];
        }
    }
}
