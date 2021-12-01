<?php
/*

*/
class General_model extends CI_Model
{

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
            return DataStructure::TreeAccountsIMA(
                $query->result_array(),
                ['id'],
                ['page_id'],
                [
                    ['parent_id', 'name', 'link', 'icon'],
                    ['page_id', 'sub_name', 'sub_link']
                ],
                ['children'],
                false
            );
        }
        $res = $query->result_array();
        return $res;
    }

    public function getAllPayee($filter = [])
    {
        $this->db->from('mp_payee');
        if (!empty($filter['id'])) $this->db->where('getAllPayee.id', $filter['id']);

        $query = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }

        $res = $query->result_array();
        return $res;
    }


    public function getAllRefAccount($filter = [])
    {
        // $this->db->select('*');
        $this->db->from('ref_account');
        if (!empty($filter['ref_id'])) $this->db->where('ref_id', $filter['ref_id']);
        if (!empty($filter['ref_type'])) $this->db->where('ref_type', $filter['ref_type']);

        $query = $this->db->get();

        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($query->result_array(), 'id');
        }

        if (!empty($filter['by_type'])) {
            return DataStructure::keyValue($query->result_array(), 'ref_type');
        }

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
        $this->db->from('ref_jenis_pembayaran');
        // echo 'sds';
        if (!empty($filter['id'])) $this->db->where('ref_jenis_pembayaran.id', $filter['id']);

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
}
