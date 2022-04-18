<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <div class="">
                <?php
                $attributes = array('id' => 'invoice', 'method' => 'post', 'class' => '');
                ?>
                <form opd="form" id="invoice_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <div class="">
                        <div class="row no-print invoice">
                            <h4 class=""> <i class="fa fa-check-circle"></i>
                                Entri Invoice
                            </h4>
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="hidden" id="id_transaction" name="id">
                                            <?php echo form_label('Patner'); ?>
                                            <select name="customer_id" id="customer_id" class="form-control select2 input-lg">
                                                <option value="0"> ------- </option>
                                                <?php echo $patner_record; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php echo form_label('No Invoice'); ?>
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_invoice', 'id' => 'no_invoice');
                                            echo form_input($data);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <?php echo form_label('Tanggal Invoice'); ?>
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'onchange' => 'count_total()', 'name' => 'date', 'id' => 'date', 'reqiured' => '', 'value' => Date('Y-m-d'));
                                            echo form_input($data);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <?php echo form_label('Tanggal Kegiatan'); ?>
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date2', 'id' => 'date2', 'reqiured' => '', 'value' => Date('Y-m-d'));
                                            echo form_input($data);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenis Invoice</label>
                                            <select name="jenis_invoice" id="jenis_invoice" class="form-control">
                                                <?php
                                                foreach ($jenis_invoice as $ji) {
                                                    echo '<option value="' . $ji['id'] . '">' . $ji['jenis_invoice'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <?php echo form_label('Metode Pembayaran'); ?>
                                            <select name="payment_metode" id="payment_metode" class="form-control input-lg">
                                                <?php
                                                foreach ($ref_account as $ji) {
                                                    echo '<option value="' . $ji['ref_id'] . '">' . $ji['ref_text'] . '</option>';
                                                } ?>
                                                <!-- <option value="2" selected> Transfer Mandiri A (112-0098146017) </option> -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row"> -->
                                <div class="col-lg-12*">

                                    <div class="form-group">
                                        <?php echo form_label('Rincian Transaksi'); ?>
                                        <?php
                                        $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'id' => 'description', 'reqiured' => '');
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="row invoice">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-striped table-hover  ">
                                    <thead>
                                        <tr>
                                            <th style="width:  400px" id="head_col_1" class="kol1">Keterangan</th>
                                            <th style="width:  200px" id="head_col_2" class="kol2">Tanggal</th>
                                            <!-- <th style="width:  200px" id="kol3" class="kol3">Tanggal</th> -->
                                            <th style="width: 80px" class="fil_1">Realisasi Produksi (Ore)</th>
                                            <th style="width: 80px" class="fil_2">Kadar Sn</th>
                                            <th style="width: 80px" class="fil_3">Realisasi Produksi KgSn Taksasi</th>
                                            <th style="width: 80px" class="fil_4">Biaya Kompensasi</th>
                                            <th style="width:  120px" class="fil_satuan">Satuan</th>
                                            <th style="width: 80px" class="fil_qyt">Qyt</th>
                                            <th style="width:  200px">Harga</th>
                                            <th style="width:  200px" class="fil_qyt_x_harga">Qyt*Harga</th>
                                            <!-- <th class="">Keterangan</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="transaction_table_body"> </tbody>
                                    <tfoot>

                                        <tr>
                                            <td colspan="1">
                                                <a class="btn btn-primary" id="btn_add_row"> <i class="fa fa-plus-circle"></i> Tambah Baris </a>
                                                <!-- <button type="button" class="btn btn-primary" name="addline" onclick="add_new_row('<?php echo base_url() . 'invoice/popup/new_row'; ?>')"> <i class="fa fa-plus-circle"></i> Tambah Baris </button> -->
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
                                                $data = array('name' => 'sub_total', 'value' => '0', 'readonly' => 'readonly', 'class' => 'accounts_total_amount', 'reqiured' => '');
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
                                            <th colspan="2" id="label_ppn">
                                                PPN 11%
                                            </th>
                                            <th colspan="1">
                                                <!-- <input type="number" name="percent_ppn" class="form-control" onclick='count_total()' /> % -->
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
                                                $data = array('name' => 'ppn_pph_count', 'value' => '0', 'readonly' => 'readonly', 'class' => 'accounts_total_amount', 'reqiured' => '');
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
                                                $data = array('name' => 'total_final', 'value' => '0', 'readonly' => 'readonly', 'class' => 'accounts_total_amount', 'reqiured' => '');
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
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/dist/js/backend/invoice.js?v=0.3.7"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    var invoice_html_row = `                <tr class="row_item[]">
                                            <td>
                                                <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. Logam 2 btg / BN 9999 QV" />
                                                <input type="hidden" name="id_item[]" value="" />
                                            </td>
                                            <td>
                                                <input type="text" name="date_item[]" value="" placeholder="eg. 3 Mar sd 27 Feb" class="form-control input-lg" />
                                            </td>
                                            <td class="fil_satuan">
                                                <select name="satuan[]" id="satuan" class="form-control">   
                                                <option value=""> -- </option>
                                                <?php
                                                foreach ($satuan as $sat) {
                                                    echo '<option value="' . $sat['name_unit'] . '">' . $sat['name_unit'] . '</option>';
                                                }
                                                ?>
                                                </select>
                                            </td>
                                            <td class="fil_1" style="display: none">
                                                <input class="form-control input-lg fil_1" name='fil_1[]' value='' required onkeyup="" />
                                            </td>
                                            <td class="fil_2" style="display: none">
                                                <input class="form-control input-lg fil_2" name='fil_2[]' value='' required onkeyup="count_total()" />
                                            </td>
                                            <td class="fil_3" style="display: none">
                                                <input class="form-control input-lg fil_3" name='fil_3[]' value='' required onkeyup="count_total()" />
                                            </td>
                                            <td class="fil_4" style="display: none">
                                                <input class="form-control input-lg fil_4" name='fil_4[]' value='' required onkeyup="count_total()" />
                                            </td>
                                            <td class="fil_qyt">
                                                 <input class="form-control input-lg" name='qyt[]' value='1' required onkeyup="count_total()" />
                                             </td>
                                            <td class="fil_amount">
                                                <input class="form-control input-lg mask" name='amount[]' value='' required onkeyup="count_total()" />
                                            </td>
                                            <td class="fil_qyt_x_harga">
                                                <input class="form-control input-lg accounts_total_amount" name='qyt_amount[]' value='' disabled onkeyup="count_total()" />
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" data-row="1" name="delete_row[]" id="delete_row[]" onchange="delete_row(this)">
                                                    <label class="form-check-label" for="delete_row[]">
                                                        Delete
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>`;


    $('#menu_id_6').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_36').addClass('menu-item-active')
    no_invoice = $('#no_invoice');
    description = $('#description');
    date_jurnal = $('#date');
    date2 = $('#date2');
    invoice_form = $('#invoice_form');
    acc_1 = $('#acc_1');
    acc_2 = $('#acc_2');
    acc_3 = $('#acc_3');
    percent_ppn = $('#percent_ppn');

    jenis_invoice = $('#jenis_invoice');
    payment_metode = $('#payment_metode');


    var btn_add_row = $('#btn_add_row');
    var id_transaction = $('#id_transaction');
    var transaction_table_body = $('#transaction_table_body');
    var keterangan_item = document.getElementsByName('keterangan_item[]');
    var fil_1 = document.getElementsByName('fil_1[]');
    var fil_2 = document.getElementsByName('fil_2[]');
    var fil_3 = document.getElementsByName('fil_3[]');
    var fil_4 = document.getElementsByName('fil_4[]');
    var date_item = document.getElementsByName('date_item[]');
    var qyt = document.getElementsByName('qyt[]');
    var amount = document.getElementsByName('amount[]');
    var satuan = document.getElementsByName('satuan[]');
    var id_item = document.getElementsByName('id_item[]');

    jenis_invoice.on('change', function() {
        // if (jenis_invoice.val() == '1') {
        //     console.log('jenis 1')
        //     // $('#head_col_2').html('Keterangan')
        //     // $('#head_col_3').html('Tanggal')
        //     // $('.date_item').unmask();
        //     // $('.nopol').prop('type', 'text');
        // } else if (jenis_invoice.val() == '4') {
        //     // $('#head_col_1').html('PO Qyt')
        //     $('#head_col_2').html('PO Number')
        // }
        if (jenis_invoice.val() == '6') {
            console.log('jenis 1')
            $('#head_col_1').html('Uraian')
            $('#head_col_2').html('PO Number')
            // $('#head_col_3').html('Tanggal')
            $('.fil_1').show();
            $('.fil_2').show();
            $('.fil_3').show();
            $('.fil_4').show();
            $('.fil_satuan').hide();
            $('.fil_qyt').hide();
            $('.fil_qyt_x_harga').hide();

            // $('.nopol').prop('type', 'text');
        } else {
            $('#head_col_1').html('Keterangan')
            $('#head_col_2').html('Tanggal')

            $('.fil_1').hide();
            $('.fil_2').hide();
            $('.fil_3').hide();
            $('.fil_4').hide();
            $('.fil_satuan').show();
            $('.fil_qyt').show();
            $('.fil_qyt_x_harga').show();

        }
        // count_total();
    })

    jenis_invoice.trigger('change')


    btn_add_row.on('click', () => {
        add_new_row();
    })

    function add_new_row() {
        transaction_table_body.append(invoice_html_row);
        $('.mask').mask('000.000.000.000.000,00', {
            reverse: true
        });
    };
    add_new_row()
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

    function delete_row(row) {
        // idx = row.index(this);
        // console.log(idx)
        keterangan_item = document.getElementsByName('keterangan_item[]');
        date_item = document.getElementsByName('date_item[]');
        qyt = document.getElementsByName('qyt[]');
        amount = document.getElementsByName('amount[]');
        satuan = document.getElementsByName('satuan[]');
        row_item = document.getElementsByClassName('row_item[]');
        i = 0;
        $('input[name="delete_row[]"]').each(function(index) {
            // alert(index);
            // $('input[name="amount[]"]').val('123123')
            if ($(this).prop("checked") == true) {
                console.log('this true = ' + index)
                keterangan_item[index].value = '';
                date_item[index].value = '';
                qyt[index].value = 0;
                amount[index].value = 0;
                satuan[index].value = '';
                row_item[index].style.display = 'none';

            }
        });

        $('input[name="amount[]"]').each(function() {
            if (row == i) {
                if ($('input[name="delete_row[' + row + ']"]').prop("checked") == true) {
                    $(this).val("");
                    $(this).prop("readonly", true);
                } else if (
                    $('input[name="delete_row[' + row + ']"]').prop("checked") == false
                ) {
                    $(this).prop("readonly", false);
                }
            }
            i++;
        });

        count_total(true);
    }

    function add_cars() {
        layer_cars.append(`<select name="id_cars[]" id="id_cars" class="form-control select2 input-lg">                                          
                                 <option value="0"> ------- </option>` + data_cars + `</select>`)
        $('.select2').select2();
    }

    <?php if ($data_return != NULL) {
        $count_rows = count($data_return['amount']);
        for ($i = 1; $i < $count_rows; $i++) {
            echo 'add_new_row();';
        }
    ?>
        id_transaction.val('<?= $data_return['id'] ?>');
        no_invoice.val('<?= $data_return['no_invoice'] ?>');
        id_custmer.val('<?= $data_return['customer_id'] ?>');
        date_jurnal.val('<?= $data_return['date'] ?>');
        date2.val('<?= $data_return['date2'] ?>');
        payment_metode.val('<?= $data_return['payment_metode'] ?>');


        jenis_invoice.val('<?= $data_return['jenis_invoice'] ?>');
        description.val('<?= $data_return['description'] ?>');
        acc_1.val('<?= $data_return['acc_1'] ?>');
        acc_2.val('<?= $data_return['acc_2'] ?>');
        acc_3.val('<?= $data_return['acc_3'] ?>');
        percent_ppn.val('<?= $data_return['percent_ppn'] ?>');

        <?php

        for ($i = 0; $i < $count_rows; $i++) { ?>
            amount[<?= $i ?>].value = '<?= number_format($data_return['amount'][$i], 2, ',', '.') ?>';
            qyt[<?= $i ?>].value = '<?= $data_return['qyt'][$i] ?>';
            date_item[<?= $i ?>].value = '<?= $data_return['date_item'][$i] ?>';
            keterangan_item[<?= $i ?>].value = '<?= $data_return['keterangan_item'][$i] ?>';
            satuan[<?= $i ?>].value = '<?= $data_return['satuan'][$i] ?>';
            fil_1[<?= $i ?>].value = '<?= $data_return['fil_1'][$i] ?>';
            fil_2[<?= $i ?>].value = '<?= $data_return['fil_2'][$i] ?>';
            fil_3[<?= $i ?>].value = '<?= $data_return['fil_3'][$i] ?>';
            fil_4[<?= $i ?>].value = '<?= $data_return['fil_4'][$i] ?>';
            id_item[<?= $i ?>].value = '<?= !empty($data_return['id_item'][$i]) ? $data_return['id_item'][$i] : '' ?>';
    <?php
        }
    }  ?>
    jenis_invoice.trigger('change')

    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });

    count_total(true);

    var swalSaveConfigure = {
        title: "Konfirmasi simpan",
        text: "Yakin akan menyimpan data ini?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#18a689",
        confirmButtonText: "Ya, Simpan!",
        reverseButtons: true
    };

    var swalSuccessConfigure = {
        title: "Simpan berhasil",
        icon: "success",
        timer: 500
    };


    invoice_form.submit(function(event) {
        event.preventDefault();
        // var isAdd = BankModal.addBtn.is(':visible');
        var url = "<?= base_url('invoice/' . $form_url) ?>";
        // url += isAdd ? "addBank" : "editBank";
        // var button = isAdd ? BankModal.addBtn : BankModal.saveEditBtn;

        Swal.fire(swalSaveConfigure).then((result) => {
            if (result.isConfirmed == false) {
                return;
            }
            swal.fire({
                title: 'Loading...',
                allowOutsideClick: false
            });
            swal.showLoading();
            $.ajax({
                url: url,
                'type': 'POST',
                data: new FormData(invoice_form[0]),
                contentType: false,
                processData: false,
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        swal.fire("Simpan Gagal", json['message'], "error");
                        return;
                    }
                    //  return;
                    var d = json['data']

                    swal.fire(swalSuccessConfigure);
                    window.location = '<?= base_url() ?>invoice/show/' + d;
                },
                error: function(e) {}
            });
        });
    });
</script>
<?php
// $this->load->view('bootstrap_model.php'); 
?>