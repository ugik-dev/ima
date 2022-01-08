<?php
/*

*/
class ApiModel extends CI_Model
{
    public function getApiKey($key)
    {
        $this->db->select('*');
        $this->db->from('*');
        $this->db->select('*');
    }

    public function post_faktur($data)
    {
        $this->db->set('no_faktur', $data['no_faktur']);
        $this->db->where('no_invoice', $data['no_invoice']);

        $this->db->update('mp_invoice_v2');
        ExceptionHandler::handleDBError($this->db->error(), "Post Fakur", "Faktur");
        // return $data['id'];
    }

    public function getFaktur($parm = '')
    {
        $this->db->select("mp_invoice_v2.date,
        mp_invoice_v2.date2 as date_kegiatan,
        mp_invoice_v2.description,
        mp_invoice_v2.no_invoice,
        mp_invoice_v2.status,
        mp_invoice_v2.sub_total,
        mp_invoice_v2.total_final,
        mp_payee.customer_name, cus_address as customer_address,
        mp_payee.npwp as customer_npwp,
         branch as bank_name, 
         accountno as bank_number,
         title as title_bank,
         mp_users.title_user as approval_postion,
         mp_users.agentname as approval_name");
        $this->db->from('mp_invoice_v2');

        if (!empty($parm)) $this->db->where('mp_invoice_v2.id', $parm);
        // $this->db->where('mp_invoice_v2.inv_key', $token);

        $this->db->join('mp_banks', 'mp_banks.id = mp_invoice_v2.payment_metode', 'LEFT');
        $this->db->join('mp_payee', 'mp_payee.id = mp_invoice_v2.customer_id');
        $this->db->join('mp_users', 'mp_users.id = mp_invoice_v2.acc_1', 'LEFT');
        // $this->db->where('date >=', $date1);
        // $this->db->where('date <=', $date2);
        $this->db->order_by('mp_invoice_v2.id', 'DESC');
        $query = $this->db->get();
        $transaction_records =  $query->result_array();
        // if ($query->num_rows() > 0) {
        //     $transaction_records =  $query->result_array();
        $i = 0;
        // if ($transaction_records  != NULL) {
        //     $this->db->select("mp_sub_invoice.*");
        //     $this->db->from('mp_sub_invoice');
        //     $this->db->where('mp_sub_invoice.parent_id =', $transaction_records[0]['id']);
        //     $sub_query = $this->db->get();
        //     if ($sub_query->num_rows() > 0) {
        //         $sub_query =  $sub_query->result();
        //         $transaction_records[0]['item'] = $sub_query;
        //     }
        // } else {
        //     return  NULL;
        // }
        return $transaction_records;
    }
    public function getInvoice($token, $id)
    {
        $this->db->select("mp_invoice_v2.*, mp_payee.customer_name, cus_address , branch as bank_name, accountno as bank_number,title as title_bank,mp_users.title_user as title_acc_1,mp_users.agentname as name_acc_1");
        $this->db->from('mp_invoice_v2');
        $this->db->where('mp_invoice_v2.id', $id);
        $this->db->where('mp_invoice_v2.inv_key', $token);

        $this->db->join('mp_banks', 'mp_banks.id = mp_invoice_v2.payment_metode', 'LEFT');
        $this->db->join('mp_payee', 'mp_payee.id = mp_invoice_v2.customer_id');
        $this->db->join('mp_users', 'mp_users.id = mp_invoice_v2.acc_1', 'LEFT');
        // $this->db->where('date >=', $date1);
        // $this->db->where('date <=', $date2);
        $this->db->order_by('mp_invoice_v2.id', 'DESC');
        $query = $this->db->get();
        $transaction_records =  $query->result_array();
        // if ($query->num_rows() > 0) {
        //     $transaction_records =  $query->result_array();
        $i = 0;
        if ($transaction_records  != NULL) {
            $this->db->select("mp_sub_invoice.*");
            $this->db->from('mp_sub_invoice');
            $this->db->where('mp_sub_invoice.parent_id =', $transaction_records[0]['id']);
            $sub_query = $this->db->get();
            if ($sub_query->num_rows() > 0) {
                $sub_query =  $sub_query->result();
                $transaction_records[0]['item'] = $sub_query;
            }
        } else {
            return  NULL;
        }
        return $transaction_records[0];
    }
}
