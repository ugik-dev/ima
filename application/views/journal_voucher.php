<section class="content">
    <div class="box" id="print-section">
        <div class="box-body ">
            <div class="">
                <?php
                var_dump($data_return);
                $attributes = array('id' => 'journal_voucher', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open('statements/create_journal_voucher', $attributes); ?>
                <div class="">
                    <div class="row no-print invoice">
                        <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i>
                            Entri Jurnal Transaksi
                        </h4>
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo form_label('Patner'); ?>
                                        <select name="customer_id" id="customer_id" class="form-control select2 input-lg">
                                            <option value="0"> ------- </option>
                                            <?php echo $patner_record; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id='label_kendaraan' style="display: none">
                                        <label>Kendaraan</label>
                                        <div class="row">
                                            <div class="col-md-10" id='layer_cars'>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" style="display:none" class="btn btn-primary" id="addcars"> <i class="fa fa-plus-circle"></i> </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('No Jurnal'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_jurnal', 'id' => 'no_jurnal');
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Rincian Transaksi'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'id' => 'description', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Tanggal'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'id' => 'date', 'reqiured' => '', 'value' => Date('d/m/Y'));
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
                                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'sub_keterangan[]', 'id' => 'sub_keterangan[]', 'value' => '');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                    </tr>

                                    <?php if ($data_return != NULL) {
                                        $count_rows = count($data_return['account_head']);
                                        for ($i = 0; $i < $count_rows - 1; $i++) {
                                    ?>
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
                                                    $data = array('class' => 'form-control input-lg sub_keterangan', 'type' => 'text', 'name' => 'sub_keterangan[]', 'id' => 'sub_keterangan[]', 'value' => '');
                                                    echo form_input($data);
                                                    ?>
                                                </td>
                                            </tr>

                                    <?php }
                                    }  ?>
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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Disetujui</label>
                                        <select name="acc_1" id="acc_1" class="form-control select2 input-lg">
                                            <option value="0"> ----- </option>
                                            <option value="7"> SETIAWAN R </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Diverifikasi</label>
                                        <select name="acc_2" id="acc_2" class="form-control select2 input-lg">
                                            <option value="0"> ----- </option>
                                            <option value="8"> PURWADI </option>
                                            <option value="10"> RAHMAT </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Dibuat</label>
                                        <select name="acc_3" id="acc_3" class="form-control select2 input-lg">
                                            <option value="0"> ----- </option>
                                            <option value="9"> A SISWANTO </option>
                                            <option value="11"> NURHASANAH </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Dibukukan</label>
                                        <input type="text" disabled id="dibukukan" class="form-control input-lg">
                                    </div>
                                </div>
                            </div>
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
    no_jurnal = $('#no_jurnal');
    description = $('#description');
    date_jurnal = $('#date');
    acc_1 = $('#acc_1');
    acc_2 = $('#acc_2');
    acc_3 = $('#acc_3');
    var sub_keterangan = document.getElementsByName('sub_keterangan[]');
    var account_head = document.getElementsByName('account_head[]');
    var debitamount = document.getElementsByName('debitamount[]');
    var creditamount = document.getElementsByName('creditamount[]');


    // sub_keterangan = $('.sub_keterangan');
    // sub_keterangan[1].val('2');
    // console.log(sub_keterangan)
    // sub_keterangan[0].val('s');
    id_custmer = $('#customer_id');
    id_cars = $('#id_cars');
    layer_cars = $('#layer_cars');
    id_custmer.on('change', function() {
        $.ajax({
            url: '<?= base_url() ?>Statements/getListCars',
            type: "get",
            data: {
                id_patner: id_custmer.val()
            },
            success: function(data) {
                var json = JSON.parse(data);
                if (json['error'] == true) {
                    layer_cars.html('');
                    addcars.style.display = 'none';
                    document.getElementById("label_kendaraan").style.display = "none";

                    return;
                }
                data_cars = json['data'];
                add_cars();
                document.getElementById("label_kendaraan").style.display = "block";
                addcars.style.display = 'block';
            },
            error: function(e) {}
        });
    });
    $('#addcars').on('click', function() {
        add_cars()
    })

    function add_cars() {
        layer_cars.append(`<select name="id_cars[]" id="id_cars" class="form-control select2 input-lg">                                          
                                 <option value="0"> ------- </option>` + data_cars + `</select>`)
        $('.select2').select2();
    }

    <?php if ($data_return != NULL) {    ?>
        no_jurnal.val('<?= $data_return['no_jurnal'] ?>');
        id_custmer.val('<?= $data_return['customer_id'] ?>');
        date_jurnal.val('<?= $data_return['date'] ?>');
        description.val('<?= $data_return['description'] ?>');
        <?php
        $count_rows = count($data_return['account_head']);

        for ($i = 0; $i < $count_rows; $i++) { ?>
            sub_keterangan[<?= $i ?>].value = '<?= $data_return['sub_keterangan'][$i] ?>';
            account_head[<?= $i ?>].value = '<?= $data_return['account_head'][$i] ?>';
            debitamount[<?= $i ?>].value = '<?= $data_return['debitamount'][$i] ?>';
            creditamount[<?= $i ?>].value = '<?= $data_return['creditamount'][$i] ?>';

    <?php
        }
    }  ?>

    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });
</script>
<?php $this->load->view('bootstrap_model.php'); ?>