<?php
/*

*/
class Invoice_model extends CI_Model
{
    function check_no_invoice($data, $id = '')
    {
        $this->db->select("count(id) as count");
        $this->db->from('mp_invoice_v2');
        if (!empty($id)) $this->db->where('id <> "' . $id . '"');
        $this->db->where('no_invoice', $data);
        $query = $this->db->get();
        return $query->result_array()[0]['count'];
    }

    public function getAllInvoice($filter = [])
    {
        $this->db->select('mpp.* , gen.no_jurnal');
        $this->db->from('mp_invoice_v2 mpp');
        $this->db->join('mp_generalentry gen', 'gen.id = mpp.general_id', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        // if (!empty($filter['id_parent1'])) $this->db->where('gen.id', $filter['id']);
        // $this->db->order_by('gen.status, gen.id,  sub.id_item ', 'DESC');
        $res = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($res->result_array(), 'id');
        }
        $res = $res->result_array();
        return $res;
    }

    public function getAllInvoiceWithItem($filter = [])
    {
        $this->db->select('mpp.* , gen.no_jurnal,sub.id as item_id, sub.parent_id as parent_item, amount, qyt, date_item, keterangan_item, satuan, nopol');
        $this->db->from('mp_invoice mpp');
        $this->db->join('mp_generalentry gen', 'gen.id = mpp.general_id', 'LEFT');
        $this->db->join('mp_sub_invoice sub', 'mpp.id = sub.parent_id', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        // if (!empty($filter['id_parent1'])) $this->db->where('gen.id', $filter['id']);
        // $this->db->order_by('gen.status, gen.id,  sub.id_item ', 'DESC');
        $res = $this->db->get();
        $ret = DataStructure::groupByRecursive2(
            $res->result_array(),
            ['id'],
            ['item_id'],
            [
                [
                    'id', 'no_jurnal', 'id', 'input_date', 'agen_id', 'acc_0', 'acc_1', 'acc_2', 'acc_3', 'date',
                    'description', 'customer_id', 'payment_metode', 'ppn_pph', 'no_invoice', 'inv_key', 'percent_jasa', 'percent_pph',
                    'am_jasa', 'am_pph', 'manual_math', 'par_label', 'par_am', 'sub_total', 'sub_total_2', 'jenis_invoice',
                    'lebih_bayar_ket', 'lebih_bayar_am', 'kurang_bayar_ket', 'kurang_bayar_am', 'pembulatan', 'payed', 'am_back', 'status_invoice', 'general_id'
                ],
                ["item_id", "amount", "qyt", "date_item", 'nopol', "keterangan_item", "satuan"]
            ],
            ['items']
        );
        // $res = $res->result_array();
        return $ret;
    }

    public function getAllInvoiceItem($filter = [])
    {
        $this->db->select("mp_sub_invoice.*");
        $this->db->from('mp_sub_invoice');
        $this->db->where('mp_sub_invoice.parent_id =', $filter['parent_id']);
        $sub_query = $this->db->get();
        if ($sub_query->num_rows() > 0) {
            $sub_query =  $sub_query->result_array();
            $sub_query;
        }
    }
    public function getAllPelunasan($filter = [])
    {
        $this->db->select('mpp.* , us.agentname , gen.no_jurnal');
        $this->db->from('dt_pelunasan_invoice mpp');
        $this->db->join('mp_users us', 'mpp.agen_id = us.id', 'LEFT');
        $this->db->join('mp_generalentry gen', 'gen.id = mpp.general_id', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('mpp.id', $filter['id']);
        if (!empty($filter['parent_id'])) $this->db->where('mpp.parent_id', $filter['parent_id']);
        if (!empty($filter['ex_id'])) $this->db->where('mpp.id <> ' . $filter['ex_id']);
        // if (!empty($filter['id_parent1'])) $this->db->where('gen.id', $filter['id']);
        // $this->db->order_by('gen.status, gen.id,  sub.id_item ', 'DESC');
        $res = $this->db->get();
        if (!empty($filter['by_id'])) {
            return DataStructure::keyValue($res->result_array(), 'id');
        }
        $res = $res->result_array();
        return $res;
    }


    public function getDetailTransaction($filter = [], $keys = true)
    {
        $this->db->select('gen.*, sub.*, prod.product_name, ru.name_unit, pay.customer_name, pay.cus_address, bn.bankname, bn.title as bank_title, bn.accountno as bank_number');
        $this->db->from('dt_transaction as gen');
        $this->db->join('dt_transaction_item as sub', "gen.id = sub.id_parent", 'LEFT');
        $this->db->join('mp_payee as pay', "gen.customer_id = pay.id", 'LEFT');
        $this->db->join('dt_jenis_invoice as prod', "sub.id_product = prod.id", 'LEFT');
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
        $this->db->from('dt_jenis_invoice as dt');
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


    // public function addPayment($data)
    // {
    //     $this->db->insert('dt_jenis_invoice', $data);
    //     ExceptionHandler::handleDBError($this->db->error(), "Tambah Payment", "Payment");
    //     $id_ins = $this->db->insert_id();
    //     return $id_ins;
    // }

    // public function editPayment($data)
    // {
    //     $this->db->where('id', $data['id']);

    //     $this->db->update('dt_jenis_invoice', $data);
    //     ExceptionHandler::handleDBError($this->db->error(), "Edit Payment", "Payment");
    //     return $data['id'];
    // }

    public function editJenisInvoice($data)
    {
        $this->db->where('id', $data['id']);

        $this->db->update('ref_jenis_invoice', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Edit Payment", "Payment");
        return $data['id'];
    }

    public function editRefAccount($data)
    {
        $this->db->where('ref_id', $data['ref_id']);

        $this->db->update('ref_account', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Edit Payment", "Payment");
        return $data['ref_id'];
    }



    public function deletePayment($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('dt_jenis_invoice');
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

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }


    function invoice_entry($data)
    {
        $this->db->trans_start();

        $generateRandomString = $this->generateRandomString(32);

        $trans_data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'customer_id' => $data['customer_id'],
            'no_invoice' => $data['no_invoice'],
            'payment_metode' => $data['payment_metode'],
            'ppn_pph' => $data['ppn_pph'],
            'inv_key' => $generateRandomString,
            'status' => $data['status'],
            'jenis_invoice' => $data['jenis_invoice'],
            'sub_total' => $data['sub_total'],
            'total_final' => $data['total_final'],
            'acc_1' => $data['acc_1'],
            'acc_2' => $data['acc_2'],
            'acc_3' => $data['acc_3'],
            'acc_0' => $this->session->userdata('user_id')['name'],
            'agen_id' => $this->session->userdata('user_id')['id'],
        );

        $this->db->insert('mp_invoice_v2', $trans_data);
        $order_id = $this->db->insert_id();
        // $order_id = $this->db->insert_id();
        $total_heads = count($data['amount']);

        for ($i = 0; $i < $total_heads; $i++) {

            if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                $trans_data  = array(
                    'parent_id'   => $order_id,
                    'qyt' => $data['qyt'][$i],
                    'satuan' => $data['satuan'][$i],
                    'date_item' => $data['date_item'][$i],
                    'keterangan_item' => $data['keterangan_item'][$i],
                    'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                );
                $this->db->insert('mp_sub_invoice', $trans_data);
            }
        }

        $data['generalentry']['url'] = 'invoice/show/' . $order_id;
        $this->db->insert('mp_generalentry', $data['generalentry']);

        $gen_id = $this->db->insert_id();

        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $gen_id;
            $this->db->insert('mp_sub_entry', $sub);
        }

        $this->db->set('general_id', $gen_id);
        $this->db->where('id', $order_id);
        $this->db->update('mp_invoice_v2');
        // 'acc_1' => $data['acc_1'],
        //             'acc_2' => $data['acc_2'],
        //             'acc_3' => $data['acc_3'],
        $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
        $this->db->set("date_acc_0", date('Y-m-d'));
        $this->db->set("id_transaction", $gen_id);
        $this->db->set("acc_1", $data['acc_1']);
        $this->db->set("acc_2", $data['acc_2']);
        $this->db->set("acc_3", $data['acc_3']);
        $this->db->insert('mp_approv');

        $this->record_activity(array('jenis' => '0', 'color' => 'primary', 'url_activity' => 'invoice/show/' . $order_id, 'sub_id' => $order_id, 'desk' => 'Entry Invoice'));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
        }
        return $order_id;
    }

    function invoice_edit($data)
    {
        $this->db->trans_start();

        $generateRandomString = $this->generateRandomString(32);

        $trans_data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'customer_id' => $data['customer_id'],
            'no_invoice' => $data['no_invoice'],
            'payment_metode' => $data['payment_metode'],
            'ppn_pph' => $data['ppn_pph'],
            'inv_key' => $generateRandomString,
            'status' => $data['status'],
            'jenis_invoice' => $data['jenis_invoice'],
            'sub_total' => $data['sub_total'],
            'total_final' => $data['total_final'],
            'acc_1' => $data['acc_1'],
            'acc_2' => $data['acc_2'],
            'acc_3' => $data['acc_3'],
            'acc_0' => $this->session->userdata('user_id')['name'],
            'agen_id' => $this->session->userdata('user_id')['id'],
        );

        $this->db->where('id', $data['id']);
        $this->db->update('mp_invoice_v2', $trans_data);
        // $order_id = $this->db->insert_id();
        // $order_id = $this->db->insert_id();
        $total_heads = count($data['amount']);

        for ($i = 0; $i < $total_heads; $i++) {
            if (!empty($data['id_item'][$i])) {
                if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                    $trans_data  = array(
                        'parent_id'   => $data['id'],
                        'qyt' => $data['qyt'][$i],
                        'satuan' => $data['satuan'][$i],
                        'date_item' => $data['date_item'][$i],
                        'keterangan_item' => $data['keterangan_item'][$i],
                        'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                    );
                    $this->db->where('id', $data['id_item'][$i]);
                    $this->db->update('mp_sub_invoice', $trans_data);
                } else {
                    $this->db->where('id', $data['id_item'][$i]);
                    $this->db->delete('mp_sub_invoice');
                }
            } else {
                if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
                    $trans_data  = array(
                        'parent_id'   => $data['id'],
                        'qyt' => $data['qyt'][$i],
                        'satuan' => $data['satuan'][$i],
                        'date_item' => $data['date_item'][$i],
                        'keterangan_item' => $data['keterangan_item'][$i],
                        'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
                    );
                    $this->db->insert('mp_sub_invoice', $trans_data);
                }
            }
        }

        // $data['generalentry']['url'] = 'invoice/show/' . $order_id;
        $this->db->where('id', $data['generalentry']['id']);
        $this->db->update('mp_generalentry', $data['generalentry']);

        $this->db->where('parent_id', $data['generalentry']['id']);
        $this->db->delete('mp_sub_entry');

        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $data['generalentry']['id'];
            $this->db->insert('mp_sub_entry', $sub);
        }

        // $this->db->set('general_id', $gen_id);
        // $this->db->where('id', $order_id);
        // $this->db->update('mp_invoice_v2');
        // 'acc_1' => $data['acc_1'],
        //             'acc_2' => $data['acc_2'],
        //             'acc_3' => $data['acc_3'],
        $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
        $this->db->set("date_acc_0", date('Y-m-d'));
        $this->db->set("acc_1", $data['acc_1']);
        $this->db->set("acc_2", $data['acc_2']);
        $this->db->set("acc_3", $data['acc_3']);
        $this->db->where("id_transaction", $data['generalentry']['id']);
        $this->db->update('mp_approv');

        $this->record_activity(array('jenis' => '0', 'color' => 'primary', 'url_activity' => 'invoice/show/' . $data['id'], 'sub_id' => $data['id'], 'desk' => 'Edit Invoice'));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
        }
        // return array('order_id' => $order_id, 'parent2_id' => $gen_id);
    }

    // function invoice_edit($data)
    // {

    //     $trans_data = array(
    //         'date' => $data['date'],
    //         'description' => $data['description'],
    //         'customer_id' => $data['customer_id'],
    //         'payment_metode' => $data['payment_method'],
    //         'ppn_pph' => $data['ppn_pph'],
    //         'percent_jasa' => $data['percent_jasa'],
    //         'percent_pph' => $data['percent_pph'],
    //         'manual_math' => $data['manual_math'],
    //         'am_jasa' => $data['am_jasa'],
    //         'am_pph' => $data['am_pph'],
    //         'lebih_bayar_am' => $data['lebih_bayar_am'],
    //         'kurang_bayar_am' => $data['kurang_bayar_am'],
    //         'lebih_bayar_ket' => $data['lebih_bayar_ket'],
    //         'kurang_bayar_ket' => $data['kurang_bayar_ket'],
    //         'jenis_invoice' => $data['jenis_invoice'],
    //         'sub_total' => $data['sub_total'],
    //         'sub_total_2' => $data['sub_total_2'],
    //         'pembulatan' => $data['pembulatan'],
    //         'status_invoice' => $data['status_invoice'],
    //         'lebih_bayar_ac' => $data['lebih_bayar_ac'],
    //         'kurang_bayar_ac' => $data['kurang_bayar_ac'],
    //         'payed' => $data['payed'],
    //         'acc_0' => $this->session->userdata('user_id')['name'],
    //         'agen_id' => $this->session->userdata('user_id')['id'],
    //     );

    //     $this->db->trans_start();
    //     $this->db->where('id', $data['id']);
    //     $this->db->update('mp_invoice', $trans_data);
    //     $total_heads = count($data['amount']);

    //     for ($i = 0; $i < $total_heads; $i++) {
    //         if (!empty($data['id_item'][$i])) {
    //             if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
    //                 $trans_data  = array(
    //                     'qyt' => $data['qyt'][$i],
    //                     'satuan' => $data['satuan'][$i],
    //                     'date_item' => $data['date_item'][$i],
    //                     'nopol' => $data['nopol'][$i],
    //                     'keterangan_item' => $data['keterangan_item'][$i],
    //                     'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
    //                 );
    //                 $this->db->where(
    //                     'mp_sub_invoice.id',
    //                     $data['id_item'][$i]
    //                 );
    //                 $this->db->where('mp_sub_invoice.parent_id', $data['id']);
    //                 $this->db->update('mp_sub_invoice', $trans_data);
    //             } else {
    //                 $this->db->where(
    //                     'mp_sub_invoice.id',
    //                     $data['id_item'][$i]
    //                 );
    //                 // $this->db->where('mp_sub_invoice.parent_id', $data['id']);
    //                 $this->db->delete('mp_sub_invoice');
    //             }
    //         } else if (!empty($data['amount'][$i] && !empty($data['qyt'][$i]))) {
    //             $trans_data  = array(
    //                 'parent_id'   => $data['id'],
    //                 'satuan' => $data['satuan'][$i],
    //                 'qyt' => $data['qyt'][$i],
    //                 'date_item' => $data['date_item'][$i],
    //                 'keterangan_item' => $data['keterangan_item'][$i],
    //                 'amount'      => substr($data['amount'][$i], 0, -2) . '.' . substr($data['amount'][$i], -2),
    //             );
    //             $this->db->insert('mp_sub_invoice', $trans_data);
    //         }
    //     }

    //     // UPDATE GENERAL ENTRY 
    //     $this->db->where('id', $data['old_data']['general_id']);
    //     $this->db->update('mp_generalentry', $data['generalentry']);

    //     $this->db->where('parent_id', $data['old_data']['general_id']);
    //     $this->db->delete('mp_sub_entry');

    //     foreach ($data['sub_entry'] as $sub) {
    //         $sub['parent_id'] = $data['old_data']['general_id'];
    //         $this->db->insert('mp_sub_entry', $sub);
    //     }


    //     $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
    //     $this->db->set("date_acc_0", date('Y-m-d'));
    //     $this->db->where("id_transaction", $data['old_data']['general_id']);
    //     $this->db->update('mp_approv');

    //     $this->record_activity(array('jenis' => '0', 'color' => 'primary', 'url_activity' => 'invoice/show/' . $data['id'], 'sub_id' => $data['id'], 'desk' => 'Edit Invoice'));


    //     $this->db->trans_complete();
    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         $data = NULL;
    //         return NULL;
    //     } else {
    //         $this->db->trans_commit();
    //         $this->record_activity(array('jenis' => 8, 'sub_id' => $data['id'], 'desk' => 'Edit Invoice'));
    //     }

    //     return $data['id'];
    // }

    function add_pelunasan($data)
    {
        $this->db->trans_start();
        $trans_data = array(
            'parent_id' => $data['parent_id'],
            'date_pembayaran' => $data['date_pembayaran'],
            'nominal' => $data['nominal'],
            'agen_id' => $this->session->userdata('user_id')['id'],
        );

        $this->db->insert('dt_pelunasan_invoice', $trans_data);
        $order_id = $this->db->insert_id();

        $data['generalentry']['url'] = 'invoice/show/' . $data['parent_id'];
        $this->db->insert('mp_generalentry', $data['generalentry']);

        $gen_id = $this->db->insert_id();

        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $gen_id;
            $this->db->insert('mp_sub_entry', $sub);
        }


        $this->db->set('general_id', $gen_id);
        $this->db->where('id', $order_id);
        $this->db->update('dt_pelunasan_invoice');

        $this->db->set("status", $data['status']);
        $this->db->where("id", $data['parent_id']);
        $this->db->update('mp_invoice_v2');

        $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
        $this->db->set("date_acc_0", date('Y-m-d'));
        $this->db->set("id_transaction", $gen_id);
        $this->db->insert('mp_approv');

        $this->record_activity(array('jenis' => '0', 'color' => 'primary', 'url_activity' => 'invoice/show/' . $data['parent_id'], 'sub_id' => $order_id, 'desk' => 'Entry Invoice'));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
        }
        return array('order_id' => $order_id, 'parent2_id' => $gen_id);
    }

    function edit_pelunasan($data)
    {
        $this->db->trans_start();
        $trans_data = array(
            'parent_id' => $data['parent_id'],
            'date_pembayaran' => $data['date_pembayaran'],
            'nominal' => $data['nominal'],
            'agen_id' => $this->session->userdata('user_id')['id'],
        );

        $this->db->where('id', $data['id']);
        $this->db->update('dt_pelunasan_invoice', $trans_data);
        // $order_id = $this->db->insert_id();

        // $data['generalentry']['url'] = 'invoice/show/' . $data['parent_id'];
        $this->db->where('id', $data['generalentry']['id']);
        $this->db->update('mp_generalentry', $data['generalentry']);

        // $gen_id = $this->db->insert_id();
        $this->db->where('parent_id', $data['generalentry']['id']);
        $this->db->delete('mp_sub_entry');

        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $data['generalentry']['id'];
            $this->db->insert('mp_sub_entry', $sub);
        }


        // $this->db->set('general_id', $gen_id);
        // $this->db->where('id', $order_id);
        // $this->db->update('dt_pelunasan_invoice');


        $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
        $this->db->set("date_acc_0", date('Y-m-d'));
        $this->db->where("id_transaction", $data['generalentry']['id']);
        $this->db->update('mp_approv');

        $this->db->set("status", $data['status']);
        $this->db->where("id", $data['parent_id']);
        $this->db->update('mp_invoice');


        $this->record_activity(array('jenis' => '0', 'color' => 'primary', 'url_activity' => 'invoice/show/' . $data['parent_id'], 'sub_id' => $data['parent_id'], 'desk' => 'Edit Invoice'));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
        }
        return array('order_id' => $data['parent_id'], 'parent2_id' => $data['parent_id']);
    }

    function delete_pelunasan($data)
    {
        $this->db->trans_start();


        $this->db->where('id', $data['id']);
        $this->db->delete('dt_pelunasan_invoice');
        // $order_id = $this->db->insert_id();

        // $data['generalentry']['url'] = 'invoice/show/' . $data['parent_id'];
        $this->db->where('id', $data['self_data']['general_id']);
        $this->db->delete('mp_generalentry');

        // $gen_id = $this->db->insert_id();
        $this->db->where('parent_id', $data['self_data']['general_id']);
        $this->db->delete('mp_sub_entry');

        // $this->db->set('general_id', $gen_id);
        // $this->db->where('id', $order_id);
        // $this->db->update('dt_pelunasan_invoice');

        $this->db->where("id_transaction", $data['self_data']['general_id']);
        $this->db->delete('mp_approv');

        $this->db->set("status", $data['status']);
        $this->db->where("id", $data['old_data']['id']);
        $this->db->update('mp_invoice_v2');


        $this->record_activity(array('jenis' => '0', 'color' => 'primary',  'desk' => 'Delelte Invoice'));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
        }
        // return array('order_id' => $data['parent_id'], 'parent2_id' => $data['parent_id']);
    }




    function record_activity($data)
    {
        // $sub_data  = array(
        $data['user_id']  = $this->session->userdata('user_id')['id'];
        //     'jenis'   => $data['jenis'],
        //     'desk'   => $data['desk'],
        //     'sub_id'   => $data['sub_id']
        // );

        $this->db->insert('mp_activity', $data);
    }
}
