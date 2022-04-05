<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <div class="">
                <?php
                $attributes = array('id' => 'invoice', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open('invoice/create_invoice', $attributes); ?>
                <div class="">
                    <div class="row no-print invoice">
                        <h4 class=""> <i class="fa fa-check-circle"></i>
                            Entri Invoice
                        </h4>
                        <div class="col-lg-12">
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <?php echo form_label('No Invoice'); ?>
                                        <?php
                                        $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_invoice', 'id' => 'no_invoice');
                                        echo form_input($data);
                                        ?>
                                    </div>
                                    <div class="form-group" id='label_kendaraan' style="display: none">
                                        <label>Kendaraan</label>
                                        <div class="row">
                                            <div class="col-lg-10" id='layer_cars'>
                                            </div>
                                            <div class="col-lg-2">
                                                <button type="button" style="display:none" class="btn btn-primary" id="addcars"> <i class="fa fa-plus-circle"></i> </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <?php echo form_label('Tanggal'); ?>
                                        <?php
                                        $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'id' => 'date', 'reqiured' => '', 'value' => Date('d/m/Y'));
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <?php echo form_label('Rincian Transaksi'); ?>
                                        <?php
                                        $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'id' => 'description', 'reqiured' => '');
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <?php echo form_label('Metode Pembayaran'); ?>
                                        <select name="payment_metode" id="payment_metode" class="form-control input-lg">
                                            <option value="2" selected> Transfer Mandiri A (112-0098146017) </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row invoice">
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-striped table-hover  ">
                                <thead>
                                    <tr>
                                        <th style="width:  400px">Keterangan</th>
                                        <th style="width:  200px">Tanggal</th>
                                        <th style="width:  120px">Satuan</th>
                                        <th style="width: 80px">Qyt</th>
                                        <th style="width:  200px">Harga</th>
                                        <th style="width:  200px" class="">Qyt*Harga</th>
                                        <!-- <th class="">Keterangan</th> -->
                                    </tr>
                                </thead>
                                <tbody id="transaction_table_body">
                                    <tr>
                                        <td>
                                            <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. Logam 2 btg / BN 9999 QV" />
                                        </td>
                                        <td>
                                            <input type="text" name="date_item[]" value="" placeholder="eg. 3 Mar sd 27 Feb" class="form-control input-lg" />
                                        </td>
                                        <td>
                                            <select name="satuan[]" id="satuan" class="form-control">
                                                <option value="thn"> thn </option>
                                                <option value="bln"> bln </option>
                                                <option value="hari"> hari </option>
                                                <option value="trip"> trip </option>
                                                <option value="unit"> unit </option>
                                                <option value="pcs"> pcs </option>
                                                <option value="pkt"> pkt </option>
                                            </select>
                                        </td>
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'name' => 'qyt[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_total()');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg mask',  'name' => 'amount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_total()');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = array('name' => 'qyt_amount[]', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>

                                        </td>
                                    </tr>

                                    <?php if ($data_return != NULL) {
                                        $count_rows = count($data_return['amount']);
                                        for ($i = 0; $i < $count_rows - 1; $i++) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. Logam 2 btg / BN 9999 QV" />
                                                </td>
                                                <td>
                                                    <input type="text" name="date_item[]" value="" placeholder="eg. 3 Mar sd 27 Feb" class="form-control input-lg" />
                                                </td>
                                                <td>
                                                    <select name="satuan[]" id="satuan" class="form-control">
                                                        <option value="bln"> bln </option>
                                                        <option value="hari"> hari </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                    $data = array('class' => 'form-control input-lg', 'name' => 'qyt[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_total()');
                                                    echo form_input($data);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $data = array('class' => 'form-control input-lg mask',  'name' => 'amount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_total()');
                                                    echo form_input($data);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $data = array('name' => 'qyt_amount[]', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
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
                                            <button type="button" class="btn btn-primary" name="addline" onclick="add_new_row('<?php echo base_url() . 'invoice/popup/new_row'; ?>')"> <i class="fa fa-plus-circle"></i> Tambah Baris </button>
                                        </td>
                                        <td id="row_loading_status"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="2">Total: </th>
                                        <th>
                                        </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'sub_total', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);

                                            if ($data_return != NULL) {
                                                if ($data_return['ppn_pph'] == '1') {
                                                    $checked = 'checked="checked"';
                                                } else {
                                                    $checked = '';
                                                }
                                            } else {
                                                $checked = '';
                                            }

                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="2">PPN 11%: </th>
                                        <th colspan="1">
                                            <div class="col-3">
                                                <span class="switch switch-icon">
                                                    <label>
                                                        <input type="checkbox" <?= $checked ?> name="ppn_pph" onclick='count_total()' />
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'ppn_pph_count', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th colspan="2">Total Final: </th>
                                        <th>
                                        </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'total_final', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>
                                        </th>
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
                                            <option value="14"> RONY MALINO </option>
                                            <option value="15"> DUDY </option>
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

                        <div class="col-lg-12 ">
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
</div>

<script src="<?php echo base_url(); ?>assets/dist/js/backend/invoice.js?v=0.2"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    $('#menu_id_6').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_36').addClass('menu-item-active')
    no_invoice = $('#no_invoice');
    description = $('#description');
    date_jurnal = $('#date');
    acc_1 = $('#acc_1');
    acc_2 = $('#acc_2');
    acc_3 = $('#acc_3');
    var keterangan_item = document.getElementsByName('keterangan_item[]');
    var date_item = document.getElementsByName('date_item[]');
    var qyt = document.getElementsByName('qyt[]');
    var amount = document.getElementsByName('amount[]');
    var satuan = document.getElementsByName('satuan[]');


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
        no_invoice.val('<?= $data_return['no_invoice'] ?>');
        id_custmer.val('<?= $data_return['customer_id'] ?>');
        date_jurnal.val('<?= $data_return['date'] ?>');
        description.val('<?= $data_return['description'] ?>');
        acc_1.val('<?= $data_return['acc_1'] ?>');
        acc_2.val('<?= $data_return['acc_2'] ?>');
        acc_3.val('<?= $data_return['acc_3'] ?>');
        <?php
        $count_rows = count($data_return['amount']);

        for ($i = 0; $i < $count_rows; $i++) { ?>
            amount[<?= $i ?>].value = '<?= $data_return['amount'][$i] ?>';
            qyt[<?= $i ?>].value = '<?= $data_return['qyt'][$i] ?>';
            date_item[<?= $i ?>].value = '<?= $data_return['date_item'][$i] ?>';
            keterangan_item[<?= $i ?>].value = '<?= $data_return['keterangan_item'][$i] ?>';
            satuan[<?= $i ?>].value = '<?= $data_return['satuan'][$i] ?>';

    <?php
        }
    }  ?>

    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });

    count_total(true);
</script>
<?php $this->load->view('bootstrap_model.php'); ?>