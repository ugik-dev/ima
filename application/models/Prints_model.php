<?php
/*

*/
class Prints_model extends CI_Model
{
    public function single_jurnal($id)
    {

        $form_content = '';
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_generalentry.no_jurnal");
        $this->db->from('mp_generalentry');
        $this->db->where('mp_generalentry.id =', $id);
        $this->db->order_by('mp_generalentry.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $transaction_records =  $query->result();

            if ($transaction_records  != NULL) {

                foreach ($transaction_records as $transaction_record) {
                    $debit_amt = NULL;
                    $credit_amt = NULL;

                    $this->db->select("mp_sub_entry.*,mp_head.name");
                    $this->db->from('mp_sub_entry');
                    $this->db->join('mp_head', 'mp_head.id = mp_sub_entry.accounthead');
                    $this->db->where('mp_sub_entry.parent_id =', $transaction_record->transaction_id);
                    $sub_query = $this->db->get();
                    if ($sub_query->num_rows() > 0) {
                        $sub_query =  $sub_query->result();
                        if ($sub_query != NULL) {
                            foreach ($sub_query as $single_trans) {
                                if ($single_trans->type == 0) {
                                    $form_content .= '<tr>
                            <td>' . $transaction_record->date . '</td>
                            <td>
                            <a >' . $single_trans->name . '</a>
                            </td>
                            <td>
                            <a >' . $single_trans->sub_keterangan . '</a>
                                </td>
                            <td>
                                <a  class="currency">' . $single_trans->amount . '</a>
                            </td>
                            <td>
                                <a ></a>
                            </td>          
                            </tr>';
                                } else if ($single_trans->type == 1) {
                                    $form_content .= '<tr>
                            <td>' . $transaction_record->date . '</td><td ><a class="general-journal-credit" >' . $single_trans->name . '</a>
                            </td>
                            <td>
                            <a >' . $single_trans->sub_keterangan . '</a>
                                </td>
                            <td>
                                <a ></a>
                            </td>
                            <td>
                                <a  class="currency">' . $single_trans->amount . '</a>
                            </td>           
                            </tr>';
                                }
                            }
                        }
                    }
                    $form_content .= '<tr class="narration" >
                    <td class="border-bottom-journal" colspan="5"><small> <i> - ' . $transaction_record->naration . '</i>
                        </small>
                        <br>
                       <a href="' . base_url('prints/single_jurnal?id=') . $transaction_record->transaction_id . '"> <small> <i> No Jurnal : ' . $transaction_record->no_jurnal . '</i>
                        </small> </a>
                        </td>
                        
                        </tr>';
                }
            }
        }
        return $form_content;
    }
    // 
}
