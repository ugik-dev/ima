<?php
/*

*/
class InvoiceModel extends CI_Model
{
    public function getAllInvoice($filter = [])
    {
        $this->db->select("mp_invoice_v2.*, mp_payee.customer_name, cus_address , branch as bank_name, accountno as bank_number,title as title_bank,mp_users.title_user as title_acc_1,mp_users.agentname as name_acc_1");
        $this->db->from('mp_invoice_v2');
        // if (!empty($filter['id']))
        if (!empty($filter['id'])) $this->db->where('mp_invoice_v2.id', $filter['id']);
        if (!empty($filter['no_invoice'])) {
            $this->db->where('no_invoice like "%' . $filter['no_invoice'] . '%"');
        } else {
            if (!empty($filter['first_date'])) $this->db->where('date >=', $filter['first_date']);
            if (!empty($filter['second_date'])) $this->db->where('date <=', $filter['second_date']);
        }
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
            foreach ($transaction_records as $transaction_record) {
                if ($transaction_record  != NULL) {
                    $this->db->select("mp_sub_invoice.*");
                    $this->db->from('mp_sub_invoice');
                    $this->db->where('mp_sub_invoice.parent_id =', $transaction_record['id']);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result();
                        $transaction_records[$i]['item'] = $sub_query;
                    }
                }
                $i++;
            }
        }
        // if ($transaction_records  != NULL) {
        //     $this->db->select("mp_sub_entry.*,mp_head.name");
        //     $this->db->from('mp_sub_entry');
        //     $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
        //     $this->db->where('mp_sub_entry.parent_id =', $transaction_records->transaction_id);
        //     $sub_query = $this->db->get();
        //     if ($sub_query->num_rows() > 0) {
        //         $sub_query =  $sub_query->result();
        //     }
        // }
        // $data['parent'] = $transaction_records;
        // $data['sub_parent'] = $sub_query;
        // echo json_encode($data);
        // die();
        return $transaction_records;
    }

    public function getAllUsaha($filter = [])
    {
        $this->db->select("mp_invoice_usaha.*, branch as bank_name, accountno as bank_number,title as title_bank");
        $this->db->from('mp_invoice_usaha');
        // if (!empty($filter['id']))
        if (!empty($filter['id'])) $this->db->where('mp_invoice_usaha.id', $filter['id']);
        if (!empty($filter['no_invoice'])) {
            $this->db->where('no_invoice like "%' . $filter['no_invoice'] . '%"');
        } else {
            if (!empty($filter['first_date'])) $this->db->where('date >=', $filter['first_date']);
            if (!empty($filter['second_date'])) $this->db->where('date <=', $filter['second_date']);
        }
        $this->db->join('mp_banks', 'mp_banks.id = mp_invoice_usaha.payment_metode', 'LEFT');
        $this->db->order_by('mp_invoice_usaha.id', 'DESC');
        $query = $this->db->get();
        $transaction_records =  $query->result_array();
        // if ($query->num_rows() > 0) {
        //     $transaction_records =  $query->result_array();
        $i = 0;
        if ($transaction_records  != NULL) {
            foreach ($transaction_records as $transaction_record) {
                if ($transaction_record  != NULL) {
                    $this->db->select("mp_sub_invoice_usaha.*");
                    $this->db->from('mp_sub_invoice_usaha');
                    $this->db->where('mp_sub_invoice_usaha.parent_id =', $transaction_record['id']);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result();
                        $transaction_records[$i]['item'] = $sub_query;
                    }
                }
                $i++;
            }
        }
        // if ($transaction_records  != NULL) {
        //     $this->db->select("mp_sub_entry.*,mp_head.name");
        //     $this->db->from('mp_sub_entry');
        //     $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
        //     $this->db->where('mp_sub_entry.parent_id =', $transaction_records->transaction_id);
        //     $sub_query = $this->db->get();
        //     if ($sub_query->num_rows() > 0) {
        //         $sub_query =  $sub_query->result();
        //     }
        // }
        // $data['parent'] = $transaction_records;
        // $data['sub_parent'] = $sub_query;
        // echo json_encode($data);
        // die();
        return $transaction_records;
    }


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mp_invoice_v2');

        $this->record_activity(array('jenis' => 6, 'sub_id' => $id, 'desk' => 'Delete Invoice'));
    }

    function record_activity($data)
    {
        $sub_data  = array(
            'user_id'   => $this->session->userdata('user_id')['id'],
            'jenis'   => $data['jenis'],
            'desk'   => $data['desk'],
            'sub_id'   => $data['sub_id']
        );

        $this->db->insert('mp_activity', $sub_data);
    }
}
