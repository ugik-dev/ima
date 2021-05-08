<div class="card card-custom">
    <div class="card-body">
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

                    <?php if (!empty($acc)) {
                        // var_dump($acc->acc_1);
                    } ?>
                    <div class="col-lg-12 ">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo form_label('Patner'); ?>
                                    <select name="customer_id" id="customer_id" class="form-control select2 input-lg">
                                        <option value="0"> ------- </option>
                                        <?php echo $patner_record; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" id='label_kendaraan' style="display: none">
                                    <label>Kendaraan</label>
                                    <div class="row">
                                        <div class="col-lg-10" id='layer_cars'>
                                            <?php
                                            if (!empty($new_arr)) {

                                                foreach ($new_arr as $v) {
                                            ?>
                                                    <select name="id_cars[]" id="id_cars" class="form-control select2 input-lg">
                                                        <option value=0> ------- </option>
                                                        <?= $lst ?>
                                                    </select>
                                            <?php
                                                };
                                            };
                                            ?>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" style="display:none" class="btn btn-primary" id="addcars"> <i class="fa fa-plus-circle"></i> </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

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
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-hover  ">
                            <thead>
                                <tr>
                                    <th class="col-lg-5 ">Akun</th>
                                    <th class="col-lg-2">Debit</th>
                                    <th class="col-lg-2">Kredit</th>
                                    <!-- <th class="col-lg-3">Keterangan</th> -->
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
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row col-lg-12">
                                                <div class="col-lg-10">
                                                    <?php


                                                    $data = array('class' => 'ket_val form-control input-lg', 'type' => 'text', 'name' => 'sub_keterangan[]');
                                                    echo form_input($data);
                                                    ?>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php
                                                    $data = array('class' => 'sub_id form-control input-lg', 'type' => 'hidden', 'name' => 'sub_id[]');
                                                    echo form_input($data);
                                                    ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" data-row="1" name="delete_row[<?= $i ?>]" id="delete_row[<?= $i ?>]" onchange="delete_row(<?= $i ?>)">
                                                        <label class="form-check-label" for="delete_row[<?= $i ?>]">
                                                            Delete
                                                        </label>
                                                    </div>
                                                </div>

                                                <hr>
                                                <hr>
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
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Disetujui</label>
                                    <select name="acc_1" id="acc_1" class="form-control select2 input-lg">
                                        <option value="0"> ----- </option>
                                        <option value="7"> SETIAWAN R </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id='label_kendaraan'>
                                    <label>Diverifikasi</label>
                                    <select name="acc_2" id="acc_2" class="form-control select2 input-lg">
                                        <option value="0"> ----- </option>
                                        <option value="8"> PURWADI </option>
                                        <option value="10"> RAHMAT </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id='label_kendaraan'>
                                    <label>Dibuat</label>
                                    <select name="acc_3" id="acc_3" class="form-control select2 input-lg">
                                        <option value="0"> ----- </option>
                                        <option value="9"> A SISWANTO </option>
                                        <option value="12"> DEFRYANTO </option>
                                        <option value="11"> NURHASANAH </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id='label_kendaraan'>
                                    <label>Dibukukan</label>
                                    <input type="text" disabled id="dibukukan" class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-lg-12 ">
                        <div class=" form-group">
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

<script src="<?php echo base_url(); ?>assets/dist/js/backend/journal_voucher.js?v=0.2"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_59').addClass('menu-item-active')
    data_cars = [];
    id_custmer = $('#customer_id');
    id_cars = $('#id_cars');
    layer_cars = $('#layer_cars');
    array_cars = <?php echo json_encode($new_arr); ?>;
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

    var sub_head = document.getElementsByClassName('sub_head')
    var debit_val = document.getElementsByClassName('debit_val')
    var kredit_val = document.getElementsByClassName('kredit_val')
    var ket_val = document.getElementsByClassName('ket_val')
    var sub_id = document.getElementsByClassName('sub_id')
    id_custmer.val('<?= $parent->customer_id ?>')
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
    <?php if (!empty($parent->customer_id)) {
    ?>
        getData()
        $('[name="id_cars[]"]').each(function() {
            $(this).val(array_cars[m]);
            m++;
        });
    <?php } ?>
    m = 0;

    function getData() {

        $.ajax({
            url: '<?= base_url() ?>Statements/getListCars',
            type: "get",
            data: {
                id_patner: '<?= $parent->customer_id ?>'

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
                document.getElementById("label_kendaraan").style.display = "block";
                addcars.style.display = 'block';
            },
            error: function(e) {}
        });

    }


    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });

    // kredit_val[0].trigger('change');
    count_debits(true);

    <?php if (!empty($acc)) {
    ?>
        document.getElementById("acc_1").value = '<?= $acc->acc_1 ?>';
        document.getElementById("acc_2").value = '<?= $acc->acc_2 ?>';
        document.getElementById("acc_3").value = '<?= $acc->acc_3 ?>';
        document.getElementById("dibukukan").value = '<?= $acc->acc_0 ?>';
    <?php  } ?>
</script>
<?php $this->load->view('bootstrap_model.php'); ?>