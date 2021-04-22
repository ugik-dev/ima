<section class="content">
    <div class="box" id="print-section">
        <div class="box-body ">
            <div class="">
                <?php
                $attributes = array('id' => 'journal_voucher', 'method' => 'post', 'class' => '');
                ?>


                <?php echo form_open('statements/edit_journal_voucher', $attributes); ?>
                <div class="">
                    <div class="row no-print invoice">
                        <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i>
                            Edit Jurnal Transaksi
                        </h4>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <?php echo form_label('No Jurnal'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'hidden', 'name' => 'id', 'value' => $parent->transaction_id);
                                echo form_input($data);

                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_jurnal', 'value' => $parent->no_jurnal);
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Rincian Transaksi'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'reqiured' => '', 'value' => $parent->naration);
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Tanggal'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'reqiured' => '', 'value' => $parent->date);
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row invoice">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-hover  ">
                                <thead>
                                    <tr>
                                        <th class="col-md-5 ">Akun</th>
                                        <th class="col-md-2">Debit</th>
                                        <th class="col-md-2">Kredit</th>
                                        <th class="col-md-3">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="transaction_table_body">
                                    <?php
                                    $i = 0;
                                    foreach ($sub_parent as $sub_parents) { ?>

                                        <tr>
                                            <td>
                                                <select name="account_head[]" class="sub_head form-control select2 input-lg">
                                                    <?php echo $accounts_records; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php
                                                $data = array('class' => 'debit_val form-control input-lg mask', 'name' => 'debitamount[]', 'reqiured' => '', 'onkeyup' => 'count_debits()');
                                                echo form_input($data);
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $data = array('class' => 'kredit_val form-control input-lg mask',  'name' => 'creditamount[]', 'reqiured' => '', 'onkeyup' => 'count_credits()');
                                                echo form_input($data);
                                                ?>
                                            </td>
                                            <td>

                                                <?php


                                                $data = array('class' => 'ket_val form-control input-lg', 'type' => 'text', 'name' => 'sub_keterangan[]');
                                                echo form_input($data);
                                                $data = array('class' => 'sub_id form-control input-lg', 'type' => 'hidden', 'name' => 'sub_id[]');
                                                echo form_input($data);
                                                ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" data-row="1" name="delete_row[<?= $i ?>]" id="delete_row[<?= $i ?>]" onchange="delete_row(<?= $i ?>)">
                                                    <label class="form-check-label" for="delete_row[<?= $i ?>]">
                                                        Delete
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1">
                                            <button type="button" class="btn btn-primary" name="addline" onclick="add_new_row('<?php echo base_url() . 'statements/popup/new_row'; ?>')"> <i class="fa fa-plus-circle"></i> Tambah Baris </button>
                                        </td>
                                        <td id="row_loading_status"></td>
                                    </tr>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>Total: </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'total_debit_amount', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>
                                        </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'total_credit_amount',  'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="transaction_validity" id="transaction_validity">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <?php
                                $data = array('class' => 'btn btn-info  margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'id' => 'btn_save_transaction', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Simpan ');
                                echo form_button($data);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/dist/js/backend/journal_voucher.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    var sub_head = document.getElementsByClassName('sub_head')
    var debit_val = document.getElementsByClassName('debit_val')
    var kredit_val = document.getElementsByClassName('kredit_val')
    var ket_val = document.getElementsByClassName('ket_val')
    var sub_id = document.getElementsByClassName('sub_id')
    <?php
    $i = 0;
    foreach ($sub_parent as $sub_parents) { ?>
        sub_head[<?= $i ?>].value = '<?= $sub_parents->accounthead ?>';
        ket_val[<?= $i ?>].value = '<?= $sub_parents->sub_keterangan ?>';
        sub_id[<?= $i ?>].value = '<?= $sub_parents->id ?>';


        <?php if ($sub_parents->type == 0) { ?>
            debit_val[<?= $i ?>].value = '<?= $sub_parents->amount ?>';
        <?php } else { ?>
            kredit_val[<?= $i ?>].value = '<?= $sub_parents->amount ?>';
    <?php
        }
        $i++;
    } ?>

    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });
    // kredit_val[0].trigger('change');
    count_debits(true);
    // count_credits();
    // for (var i = 0; i < sub_head.length; i++) {
    //     sub_head[i].value = 10;
    // elements[i].innerHTML = formatRupiah(elements[i].innerHTML);
    // }
    // $('#sub_head').val(10);
</script>
<?php $this->load->view('bootstrap_model.php'); ?>