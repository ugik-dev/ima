<?php

class AdministrationModel extends CI_Model
{

    public function getJenisDokumen($filter = [])
    {
        $this->db->select('*');
        $this->db->from('adm_jenis_dokumen');
        if (!empty($filter['id_jenis_dokumen'])) $this->db->where('id_jenis_dokumen', $filter['id_jenis_dokumen']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_jenis_dokumen');
    }


    public function getDokumen($filter = [])
    {
        $this->db->select('*');
        $this->db->from('adm_dokumen');
        $this->db->join('adm_jenis_dokumen', 'adm_dokumen.id_jenis_dokumen = adm_jenis_dokumen.id_jenis_dokumen');
        if (!empty($filter['id_jenis_dokumen'])) $this->db->where('adm_dokumen.id_jenis_dokumen', $filter['id_jenis_dokumen']);
        if (!empty($filter['id_dokumen'])) $this->db->where('adm_dokumen.id_dokumen', $filter['id_dokumen']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_dokumen');
    }

    public function addJenisDokumen($data)
    {
        // ini_set('date.timezone', 'Asia/Jakarta');
        // $data['date_modified'] = date("Y-m-d h:i:s");

        $this->db->insert(
            'adm_jenis_dokumen',
            $data,
            [
                'nama_jenis_dokumen'
            ],
            TRUE
        );
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Jenus Dokumen", "Tambah Jenis Dokumen");

        $id_user = $this->db->insert_id();

        return $id_user;
    }


    public function addDokumen($data)
    {
        // ini_set('date.timezone', 'Asia/Jakarta');
        $data['last_update'] = $this->session->userdata('user_id')['name'] . '|' . date("Y-m-d h:i:s");
        if (empty($data['date_start'])) $data['date_start'] = NULL;
        if (empty($data['date_end'])) $data['date_end'] = NULL;
        if (empty($data['file_dokumen'])) $data['file_dokumen'] = NULL;;
        $this->db->insert(
            'adm_dokumen',
            DataStructure::slice(
                $data,
                [
                    'nama_dokumen', 'id_jenis_dokumen', 'deskripsi', 'notification', 'date_start', 'date_end', 'file_dokumen', 'last_update'
                ],
            )
        );
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Jenus Dokumen", "Tambah Jenis Dokumen");

        $id_user = $this->db->insert_id();

        return $id_user;
    }


    public function editJenisDokumen($data)
    {
        $data['last_update'] = $this->session->userdata('user_id')['name'] . '|' . date("Y-m-d h:i:s");
        if (!empty($data['file_dokumen'])) $this->db->set('file_dokumen', $data['file_dokumen']);

        // ini_set('date.timezone', 'Asia/Jakarta');
        // $data['date_modified'] = date("Y-m-d h:i:s");
        $this->db->where('id_dokumen', $data['id_dokumen']);
        $this->db->update(
            'adm_dokumen',
            DataStructure::slice(
                $data,
                [
                    'nama_dokumen', 'id_jenis_dokumen', 'deskripsi', 'notification', 'date_start', 'date_end', 'last_update'
                ],
            )
        );
        // $this->db->update('adm_jenis_dokumen');
        ExceptionHandler::handleDBError($this->db->error(), "Edit Jenus Dokumen", "Edit Jenis Dokumen");
        return $data['id_dokumen'];
    }

    public function deleteDokumen($data)
    {
        // ini_set('date.timezone', 'Asia/Jakarta');
        // $data['date_modified'] = date("Y-m-d h:i:s");
        $this->db->where('id_dokumen', $data['id_dokumen']);
        $this->db->delete('adm_dokumen');
        ExceptionHandler::handleDBError($this->db->error(), "Delete Jenus Dokumen", "Delete Jenis Dokumen");
        return $data['id_dokumen'];
    }
}
