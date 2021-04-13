<section class="content">
    <div class="box" id="print-section">
        <div class="box-body ">
            <div class="">
                <?php
                $attributes = array('id' => 'journal_voucher', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open('statements/create_journal_voucher', $attributes); ?>
                <div class="">
                    <div class="row no-print invoice">
                        <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i>
                            Entri Jurnal Transaksi
                        </h4>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <?php echo form_label('No Jurnal'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_jurnal',);
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Rincian Transaksi'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Tanggal'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'reqiured' => '', 'value' => Date('d/m/Y'));
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
                                    <tr>
                                        <td>
                                            <select name="account_head[]" class="form-control select2 input-lg">
                                                <?php echo $accounts_records; ?>
                                            </select>
                                        </td>
                                        <!-- <td>
                                        </td> -->
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg mask', 'name' => 'debitamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_debits()');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg mask',  'name' => 'creditamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_credits()');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'sub_keterangan[]', 'value' => '');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                    </tr>
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
    $('.mask').mask('000.000.000.000.000', {
        reverse: true
    });
</script>
<?php $this->load->view('bootstrap_model.php'); ?>