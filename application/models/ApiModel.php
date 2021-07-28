<?php
/*

*/
class ApiModel extends CI_Model
{
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
