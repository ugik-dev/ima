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
        $this->db->where('eks.req_time >=', $filter);
        $this->db->where('eks.req_time <=', $filter . ' 23.59.59');
        $res = $this->db->get();
        $res = $res->result_array();
        return $res[0]['antrian'] + 1;
        // return $res;
        // var_dump($res);
        // die();
    }
    public function getAll($filter = [])
    {
        $this->db->select('eks.* ,jk.*');
        $this->db->select('cu.nama, cu.email, cu.no_telp, cu.alamat');
        $this->db->select('au.user_name as nama_petugas');

        $this->db->from("carwash as eks");
        $this->db->join("ref_jenis_kendaraan as jk", "jk.id_ref_jk = eks.jenis_kendaraan");
        $this->db->join("mp_user_customer as cu", "cu.id_user = eks.id_user");
        $this->db->join("mp_users as au", "au.id = eks.id_petugas", 'LEFT');
        $this->db->Order_by('id_carwash', 'ASC');
        if (!empty($filter['id_carwash'])) $this->db->where('eks.id_carwash', $filter['id_carwash']);
        if (!empty($filter['status'])) {
            $status = explode('|', $filter['status']);
            $this->db->where_in('eks.status', $status);
        }
        if (!empty($filter['id_user'])) $this->db->where('eks.id_user', $filter['id_user']);
        if (!empty($filter['req_time'])) $this->db->where('DATE(eks.req_time)', $filter['req_time']);
        if (!empty($filter['req_time_start'])) $this->db->where('DATE(eks.req_time) >= "'  . $filter['req_time_start'] . '"');
        if (!empty($filter['req_time_end'])) $this->db->where('DATE(eks.req_time) <= "'  . $filter['req_time_end'] . '"');
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
        // $this->db->where('req_time < "' . $filter['req_time'] . '"');
        $this->db->where('nomor_antrian < "' . $filter['nomor_antrian'] . '"');
        $this->db->where('eks.req_time >=', explode(' ', $filter['req_time'])[0]);
        $this->db->where('eks.req_time <=', $filter['req_time'] . ' 23.59.59');
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
        $this->db->insert('carwash', DataStructure::slice($data, ['id_user', 'req_time', 'reg_time', 'plat', 'jenis_kendaraan', 'nomor_antrian', 'id_petugas']));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Pemesanan gagal", "carwash");

        return $this->db->insert_id();
    }

    public function edit($data)
    {
        $this->db->where('id_carwash', $data['id_carwash']);
        $this->db->update('carwash', DataStructure::slice($data, ['id_user', 'req_time', 'reg_time', 'plat', 'jenis_kendaraan', 'status', 'nomor_antrian', 'id_petugas'], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Edit CarWash gagal", "carwash");

        return $data['id_carwash'];
    }

    public function delete($data)
    {
        $this->db->where('id_carwash', $data['id_carwash']);
        $this->db->delete('carwash');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus CarWash gagal", "carwash");
    }
}
