<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CarWashModel extends CI_Model
{

    public function getNomorAntri($filter)
    {
        // var_dump($filter);
        // die();
        $this->db->select('count(*) as antrian');
        $this->db->from("carwash as eks");
        // $this->db->join("ref_jenis_kendaraan as jk", "jk.id_ref_jk = eks.jenis_kendaraan");
        $this->db->where('eks.req_tanggal >=', $filter);
        $this->db->where('eks.req_tanggal <=', $filter . ' 23.59.59');
        $res = $this->db->get();
        $res = $res->result_array();
        return $res[0]['antrian'] + 1;
        // return $res;
        // var_dump($res);
        // die();
    }
    // public function getAllTransaksi($filter = [])
    // {
    //     $this->db->from("carwash as eks");
    //     if (!empty($filter['id_carwash'])) $this->db->where('id_carwash', $filter['id_carwash']);
    //     $res = $this->db->get();
    //     // return $res->result_array();
    //     return DataStructure::keyValue($res->result_array(), 'id_carwash');
    // }
    public function getAllTransaksi($filter = [])
    {
        $this->db->select('eks.*, s1.label s1_label, s1.price s1_price,s2.label s2_label, s2.price s2_price');
        $this->db->select('au.user_name as nama_petugas,ac.nama_petugas as nama_petugas_cuti, DATE_FORMAT(est_time, "%H:%i") est_time');

        $this->db->from("carwash as eks");
        $this->db->join("ref_cw_service1 as s1", "s1.id_ref = eks.service_1");
        $this->db->join("ref_cw_service2 as s2", "s2.id_ref = eks.service_2");
        $this->db->join("mp_users as au", "au.id = eks.id_petugas", 'LEFT');
        $this->db->join("carwash_petugas as ac", "ac.id_cw_petugas = eks.id_petugas_cuci", 'LEFT');
        // $this->db->Order_by('id_carwash', 'ASC');
        if (!empty($filter['id_carwash'])) $this->db->where('eks.id_carwash', $filter['id_carwash']);
        if (!empty($filter['notelp'])) $this->db->where('eks.notelp', $filter['notelp']);
        if (!empty($filter['book'])) $this->db->where('eks.book', $filter['book']);
        if (!empty($filter['date1'])) $this->db->where('eks.req_tanggal >=' .  $filter['date1']);
        // if (!empty($filter['id_user'])) $this->db->where('eks.id_user', $filter['id_user']);
        // if (!empty($filter['req_time'])) $this->db->where('DATE(eks.req_time)', $filter['req_time']);
        if (!empty($filter['onprogress'])) {
            $this->db->where('eks.status != 4');
        }
        if (!empty($filter['close_book'])) {
            $this->db->where('eks.status_pembayaran = 5 AND  book is null');
        }

        // $this->db->limit(2);
        $this->db->order_by('id_carwash', 'DESC');
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_carwash');
        // return $res->result_array();
        // return DataStructure::keyValue($res->result_array(), 'id_carwash');
    }

    public function getAllPriceList($filter = [])
    {
        $this->db->from("ref_cw_service1 as eks");
        $res = $this->db->get();
        // return $res->result_array();
        if (!empty($filter['id_ref'])) $this->db->where('id_ref', $filter['id_ref']);
        return DataStructure::keyValue($res->result_array(), 'id_ref');
    }

    public function getAllPriceList2($filter = [])
    {
        $this->db->from("ref_cw_service2 as eks");
        $res = $this->db->get();
        // return $res->result_array();
        if (!empty($filter['id_ref'])) $this->db->where('id_ref', $filter['id_ref']);
        return DataStructure::keyValue($res->result_array(), 'id_ref');
    }

    public function getAllRekap($filter = [])
    {
        $this->db->select('eks.*, u.user_name, gen.*');
        $this->db->from("carwash_close as eks");
        $this->db->join("mp_users as u", 'u.id = eks.user_id');
        $this->db->join("mp_generalentry as gen", 'gen.id = eks.jurnal_id');
        if (!empty($filter['id_carwash_close'])) $this->db->where('id_carwash_close', $filter['id_carwash_close']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_carwash_close');
    }

    public function getAllPegawai($filter = [])
    {
        $this->db->from("carwash_petugas as eks");
        $res = $this->db->get();
        // return $res->result_array();
        if (!empty($filter['id_cw_petugas'])) $this->db->where('id_cw_petugas', $filter['id_cw_petugas']);
        return DataStructure::keyValue($res->result_array(), 'id_cw_petugas');
    }

    public function getPetugas($filter = [])
    {
        $this->db->from("carwash_petugas as eks");
        $res = $this->db->get();
        // return $res->result_array();
        return DataStructure::keyValue($res->result_array(), 'id_cw_petugas');
    }
    public function getAll($filter = [])
    {
        // $this->db->select('eks.* ,jk.*');
        $this->db->select('eks.*, s1.label s1_label, s1.price s1_price,s2.label s2_label, s2.price s2_price, DATE_FORMAT(est_time, "%H:%i") est_time');

        $this->db->select('cu.nama, cu.email, cu.no_telp, cu.alamat');
        $this->db->select('au.user_name as nama_petugas');
        $this->db->select('ac.nama_petugas as nama_petugas_cuci');

        $this->db->from("carwash as eks");
        $this->db->join("ref_cw_service1 as s1", "s1.id_ref = eks.service_1");
        $this->db->join("ref_cw_service2 as s2", "s2.id_ref = eks.service_2");
        // $this->db->join("ref_jenis_kendaraan as jk", "jk.id_ref_jk = eks.jenis_kendaraan");
        $this->db->join("mp_user_customer as cu", "cu.id_user = eks.id_user", 'LEFT');
        $this->db->join("mp_users as au", "au.id = eks.pembayaran_id_petugas", 'LEFT');
        $this->db->join("carwash_petugas as ac", "ac.id_cw_petugas = eks.id_petugas_cuci", 'LEFT');
        $this->db->Order_by('id_carwash', 'ASC');
        if (!empty($filter['id_carwash'])) $this->db->where('eks.id_carwash', $filter['id_carwash']);
        if (!empty($filter['status'])) {
            $status = explode('|', $filter['status']);
            $this->db->where_in('eks.status', $status);
        }
        if (!empty($filter['id_user'])) $this->db->where('eks.id_user', $filter['id_user']);
        if (!empty($filter['req_tanggal'])) $this->db->where('DATE(eks.req_tanggal)', $filter['req_tanggal']);
        if (!empty($filter['req_tanggal_start'])) $this->db->where('DATE(eks.req_tanggal) >= "'  . $filter['req_tanggal_start'] . '"');
        if (!empty($filter['req_tanggal_end'])) $this->db->where('DATE(eks.req_tanggal) <= "'  . $filter['req_tanggal_end'] . '"');
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_carwash');
    }

    public function check_antrian($filter = [])
    {
        $this->db->select('*');
        $this->db->from("carwash as eks");
        $this->db->join("ref_jenis_kendaraan as jk", "jk.id_ref_jk = eks.jenis_kendaraan");
        // $this->db->Order_by('id_carwash', 'ASC');
        $this->db->where('status != 2');
        // $this->db->where('req_tanggal < "' . $filter['req_tanggal'] . '"');
        $this->db->where('nomor_antrian < "' . $filter['nomor_antrian'] . '"');
        $this->db->where('eks.req_tanggal >=', explode(' ', $filter['req_tanggal'])[0]);
        $this->db->where('eks.req_tanggal <=', $filter['req_tanggal'] . ' 23.59.59');
        // $this->db->where('eks.id_carwash', $filter['id_carwash']);
        // if (!empty($filter['id_user'])) $this->db->where('eks.id_user', $filter['id_user']);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get($id = NULL)
    {
        $row = $this->getAll(['id_carwash' => $id]);
        if (empty($row)) {
            throw new UserException("Jenis Mutu yang kamu cari tidak ditemukan", USER_NOT_FOUND_CODE);
        }
        return $row[$id];
    }

    public function add($data)
    {
        $this->db->insert('carwash', DataStructure::slice($data, ['id_user', 'req_tanggal', 'reg_time', 'plat', 'jenis_kendaraan', 'nomor_antrian', 'id_petugas']));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Pemesanan gagal", "carwash");

        return $this->db->insert_id();
    }
    public function add_log($data)
    {
        $this->db->insert('carwash_log', $data);
        // ExceptionHandler::handleDBError($this->db->error(), "Tambah Pemesanan gagal", "carwash");
        return $this->db->insert_id();
    }



    public function edit($data)
    {
        $this->db->where('id_carwash', $data['id_carwash']);
        $this->db->update('carwash', DataStructure::slice($data, [
            'id_user',
            'req_tanggal', 'est_time', 'reg_time', 'plat', 'jenis_kendaraan', 'notelp', 'id_petugas_cuci', 'margin', 'fee',
            'status', 'nomor_antrian', 'id_petugas', 'id_petugas_jemput', 'plat', 'nama_pemesan', 'nama_driver', 'service_1', 'service_2',
            'pembayaran_metode', 'pembayaran_tagihan', 'pembayaran_dibayarkan', 'pembayaran_kembalian', 'status_pembayaran', 'pembayaran_id_petugas'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Edit CarWash gagal", "carwash");
        return $data['id_carwash'];
    }

    public function addPriceList($data)
    {
        $this->db->insert('ref_cw_service1', DataStructure::slice($data, [
            'label', 'price', 'active',
        ], TRUE));
        // ExceptionHandler::handleDBError($this->db->error(), "Tambah Pemesanan gagal", "carwash");
        return $this->db->insert_id();
    }
    public function editPriceList($data)
    {
        $this->db->where('id_ref', $data['id_ref']);
        $this->db->update('ref_cw_service1', DataStructure::slice($data, [
            'label', 'price', 'active',
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Edit Price List gagal", "carwash");
        return $data['id_ref'];
    }
    public function delPriceList($data)
    {
        $this->db->where('id_ref', $data['id_ref']);
        $this->db->delete('ref_cw_service1');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Price List gagal", "carwash");
    }
    public function addPriceList2($data)
    {
        $this->db->insert('ref_cw_service2', DataStructure::slice($data, [
            'label', 'price', 'active',
        ], TRUE));
        // ExceptionHandler::handleDBError($this->db->error(), "Tambah Pemesanan gagal", "carwash");
        return $this->db->insert_id();
    }
    public function editPriceList2($data)
    {
        $this->db->where('id_ref', $data['id_ref']);
        $this->db->update('ref_cw_service2', DataStructure::slice($data, [
            'label', 'price', 'active',
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Edit Price List gagal", "carwash");
        return $data['id_ref'];
    }
    public function delPriceList2($data)
    {
        $this->db->where('id_ref', $data['id_ref']);
        $this->db->delete('ref_cw_service2');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Price List gagal", "carwash");
    }
    public function addPegawai($data)
    {
        $this->db->insert('carwash_petugas', DataStructure::slice($data, [
            'nama_petugas', 'no_wa', 'active', 'no_sk', 'file_sk', 'nik', 'alamat', 'photo_file'
        ], TRUE));
        // ExceptionHandler::handleDBError($this->db->error(), "Tambah Pemesanan gagal", "carwash");
        return $this->db->insert_id();
    }
    public function editPegawai($data)
    {
        $this->db->where('id_cw_petugas', $data['id_cw_petugas']);
        $this->db->update('carwash_petugas', DataStructure::slice($data, [
            'nama_petugas', 'no_wa', 'active', 'no_sk', 'file_sk', 'nik', 'alamat', 'photo_file'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Edit Pegawai gagal", "carwash");
        return $data['id_cw_petugas'];
    }
    public function delPegawai($data)
    {
        $this->db->where('id_cw_petugas', $data['id_cw_petugas']);
        $this->db->delete('carwash_petugas');
        ExceptionHandler::handleDBError($this->db->error(), "Hapus Pegawai gagal", "carwash");
    }

    public function delete($data)
    {
        $this->db->where('id_carwash', $data['id_carwash']);
        $this->db->delete('carwash');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus CarWash gagal", "carwash");
    }

    function close_book($data)
    {
        $this->db->trans_start();
        $trans_data = array(
            'tanggal' => date('Y-m-d'),
            'user_id' => $this->session->userdata('user_id')['id'],
            'total' => $data['sub_entry'][0]['amount'],
            'pendapatan' => $data['sub_entry'][1]['amount'],
            'ppn' => $data['sub_entry'][2]['amount'],
        );

        $this->db->insert('carwash_close', $trans_data);
        $book_id = $this->db->insert_id();

        $data['generalentry']['url'] = 'CarWash/rekap/' . $book_id;
        $this->db->insert('mp_generalentry', $data['generalentry']);

        $gen_id = $this->db->insert_id();

        foreach ($data['sub_entry'] as $sub) {
            $sub['parent_id'] = $gen_id;
            $this->db->insert('mp_sub_entry', $sub);
        }

        $this->db->set('jurnal_id', $gen_id);
        $this->db->where('id_carwash_close', $book_id);
        $this->db->update('carwash_close');

        $this->db->set('book', $book_id);
        $this->db->where_in('id_carwash', $data['id_carwash']);
        $this->db->update('carwash');

        $this->db->set("acc_0", $this->session->userdata('user_id')['name']);
        $this->db->set("date_acc_0", date('Y-m-d'));
        $this->db->set("id_transaction", $gen_id);
        $this->db->insert('mp_approv');

        // $this->record_activity(array('jenis' => '0', 'color' => 'primary', 'url_activity' => 'pembayaran/show/' . $book_id, 'sub_id' => $book_id, 'desk' => 'Entry Pembayaran'));

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = NULL;
            return NULL;
        } else {
            $this->db->trans_commit();
        }


        return array('book_id' => $book_id, 'parent2_id' => $gen_id);
    }
}
