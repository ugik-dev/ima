<?php
/*

*/
class ShpModel extends CI_Model
{


    public function getAll($filter = [])
    {

        $this->db->select('ap.*, ,z.* ,w.* ,ba.customer_name, customer_nationalid as ktp, cus_address ,npwp, agentname, title_user as agent_title');
        $this->db->select('apc.kode_timah, apc.id_shp_child, apc.kadar, apc.berat, apc.harga, apc.amount, apc.terak');
        $this->db->from('app_shp ap');
        $this->db->join('app_shp_child as apc', 'apc.id_shp = ap.id_shp', 'LEFT');
        $this->db->join('mp_users as u', 'u.id = ap.id_agent', 'LEFT');
        $this->db->join('mp_payee as ba', 'ba.id = ap.id_mitra', 'LEFT');
        $this->db->join('ref_zona as z', 'z.id_zona = ap.zona', 'LEFT');
        $this->db->join('ref_wilayah as w', 'w.id_wilayah = ap.wilayah', 'LEFT');
        if (!empty($filter['id_shp'])) $this->db->where('ap.id_shp', $filter['id_shp']);

        $query = $this->db->get();
        $ret = DataStructure::groupByRecursive2(
            $query->result_array(),
            ['id_shp'],
            ['id_shp_child'],
            [
                [
                    'id_shp', 'id_pembayaran', 'id_jurnal', 'status_shp', 'id_mitra', 'date_penerimaan', 'date_analisis', 'metode_pengujian', 'sub_total', 'tx_sebelumnya', 'percent_pph_21', 'am_pph_21', 'percent_oh', 'am_oh', 'agentname', 'agent_title',
                    'percent_profit', 'am_profit', 'total_final', 'lokasi', 'zona', 'id_zona', 'sp_shp', 'wilayah', 'nama_wilayah', 'nama_zona', 'customer_name', 'ktp', 'cus_address', 'npwp'
                ],
                ['id_shp_child', 'kode_timah', 'ket', 'kadar', 'berat', 'terak', 'harga', 'amount']
            ],
            ['child'],
            true
        );
        return $ret;
        // if (!empty($filter['by_id'])) {
        //     return DataStructure::keyValue($query->result_array(), 'id');
        // }
        $res = $query->result_array();
        return $res;
    }


    public function add_reference($data)
    {
        $this->db->insert(
            'ref_rab',
            DataStructure::slice(
                $data,
                [
                    'date_rab', 'id_agent'
                ],
            )
        );
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Refensi", "Referensi");
        $id_rab = $this->db->insert_id();



        for ($i = 40; $i <= 70; $i++) {
            // $status = TRUE;
            // $data['harga'][$i] =  preg_replace("/[^0-9]/", "", $data['harga'][$i]);
            // $data['amount'][$i] =  substr(preg_replace("/[^0-9]/", "", $data['amount'][$i]), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['amount'][$i]), -2);

            $cur_data = [
                'id_rab' => $id_rab,
                'percent' => $i,
                'harga' => preg_replace("/[^0-9]/", "", $data['percent_' . $i])
            ];

            $this->db->insert(
                'ref_rab_child',
                $cur_data
            );
        }


        return $id_rab;
    }

    public function edit_reference($data)
    {
        $this->db->where('id_rab', $data['id_rab']);
        $this->db->update(
            'ref_rab',
            DataStructure::slice(
                $data,
                [
                    'date_rab', 'id_agent'
                ],
            )
        );
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Refensi", "Referensi");
        $id_rab = $data['id_rab'];



        for ($i = 40; $i <= 70; $i++) {

            $cur_data = [
                'percent' => $i,
                'harga' => preg_replace("/[^0-9]/", "", $data['percent_' . $i])
            ];

            $this->db->where('id_rab_child', $data['id_rab_child_' . $i]);
            $this->db->where('id_rab', $data['id_rab']);
            $this->db->update(
                'ref_rab_child',
                $cur_data
            );
        }


        return $id_rab;
    }



    public function add($data)
    {
        $this->db->insert(
            'app_shp',
            DataStructure::slice(
                $data,
                [
                    'id_mitra', 'date_penerimaan', 'date_analisis', 'metode_pengujian', 'lokasi', 'zona', 'id_agent',
                    'percent_oh', 'percent_pph_21', 'percent_profit', 'wilayah',
                    'am_oh', 'am_pph_21', 'am_profit',
                    'sub_total', 'tx_sebelumnya', 'total_final'
                ],
            )
        );
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Shp", "Shp");
        $id_shp = $this->db->insert_id();

        $count_rows = count($data['amount']);


        for ($i = 0; $i < $count_rows; $i++) {
            $status = TRUE;
            $data['harga'][$i] =  substr(preg_replace("/[^0-9]/", "", $data['harga'][$i]), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['harga'][$i]), -2);
            $data['amount'][$i] =  substr(preg_replace("/[^0-9]/", "", $data['amount'][$i]), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['amount'][$i]), -2);

            $data['child'][$i] = [
                'id_shp' => $id_shp,
                'kode_timah' => $data['kode_timah'][$i],
                'kadar' => $data['kadar'][$i],
                'terak' => $data['terak'][$i],
                'berat' => $data['berat'][$i],
                'harga' => $data['harga'][$i],
                'amount' => $data['amount'][$i],
            ];

            $this->db->insert(
                'app_shp_child',
                DataStructure::slice(
                    $data['child'][$i],
                    [
                        'id_shp', 'kode_timah', 'ket', 'kadar', 'berat', 'terak', 'harga', 'amount'

                    ],
                )
            );
        }


        return $id_shp;
    }

    public function edit($data)
    {
        $this->db->where('id_shp', $data['id_shp']);
        $this->db->update(
            'app_shp',
            DataStructure::slice(
                $data,
                [
                    'id_mitra', 'date_penerimaan', 'date_analisis', 'metode_pengujian', 'lokasi', 'zona', 'id_agent',
                    'percent_oh', 'percent_pph_21', 'percent_profit', 'wilayah',
                    'am_oh', 'am_pph_21', 'am_profit',
                    'sub_total', 'tx_sebelumnya', 'total_final'
                ],
            )
        );
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Shp", "Shp");
        $id_shp = $this->db->insert_id();

        $count_rows = count($data['amount']);


        for ($i = 0; $i < $count_rows; $i++) {
            $status = TRUE;
            $data['harga'][$i] =  substr(preg_replace("/[^0-9]/", "", $data['harga'][$i]), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['harga'][$i]), -2);
            $data['amount'][$i] =  substr(preg_replace("/[^0-9]/", "", $data['amount'][$i]), 0, -2) . '.' . substr(preg_replace("/[^0-9]/", "", $data['amount'][$i]), -2);

            $data['child'][$i] = [
                'id_shp' =>  $data['id_shp'],
                'kode_timah' => $data['kode_timah'][$i],
                'kadar' => $data['kadar'][$i],
                'terak' => $data['terak'][$i],
                'berat' => $data['berat'][$i],
                'harga' => $data['harga'][$i],
                'amount' => $data['amount'][$i],
            ];

            if (!empty($data['id_shp_child'][$i])) {
                $this->db->where('id_shp_child', $data['id_shp_child'][$i]);
                $this->db->update(
                    'app_shp_child',
                    DataStructure::slice(
                        $data['child'][$i],
                        [
                            'id_shp', 'kode_timah', 'ket', 'kadar', 'berat', 'terak', 'harga', 'amount'

                        ],
                    )
                );
            } else {

                $this->db->insert(
                    'app_shp_child',
                    DataStructure::slice(
                        $data['child'][$i],
                        [
                            'id_shp', 'kode_timah', 'ket', 'kadar', 'berat', 'terak', 'harga', 'amount'

                        ],
                    )
                );
            }
        }

        return $data['id_shp'];
    }

    public function delete($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('mp_banks');
        ExceptionHandler::handleDBError($this->db->error(), "Delete Shp", "Shp");
        return $data['id'];
    }
}
