<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <div class="">
                <?php
                $acc_role = accounting_role($this->session->userdata('user_id')['id']);

                ?>

                <form opd="form" id="pembayaran_form" onsubmit="return false;" type="multipart" autocomplete="off">

                    <div class="">
                        <div class="row no-print pembayaran">
                            <h4 class=""> <i class="fa fa-check-circle"></i>
                                Entri Pebayaran Mitra
                            </h4>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'type' => 'hidden', 'name' => 'id', 'value' => (!empty($data_return['id']) ? $data_return['id'] : ''));
                                            echo form_input($data);
                                            echo form_label('Patner'); ?>
                                            <select name="customer_id" id="customer_id" class="form-control select2 input-lg">
                                                <option value="0"> ------- </option>
                                                <?php echo $patner_record; ?>
                                            </select>
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
                                    <div class="col-lg-3">

                                        <div class="form-group">
                                            <label>Jenis Pembayaran</label> <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control">
                                                <?php foreach ($jenis_pembayaran as $st) {
                                                    echo '<option value="' . $st['id'] . '"> ' . $st['jenis_pembayaran'] . ' </option>';
                                                } ?>
                                            </select>
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

                                            <select name="payment_method" id="payment_method" class="form-control">
                                                <?php foreach ($ref_account as $st) {
                                                    echo '<option value="' . $st['ref_id'] . '"> ' . $st['ref_text'] . ' </option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row pembayaran">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-striped table-hover  ">
                                    <thead>
                                        <tr>
                                            <th style="width:  400px">Keterangan</th>
                                            <th style="width:  200px" id="head_col_2">No Polisi</th>
                                            <th style="width:  200px" id="head_col_3">Tanggal</th>
                                            <th style="width:  120px">Satuan</th>
                                            <th style="width: 80px">Qyt</th>
                                            <th style="width:  200px">Harga</th>
                                            <th style="width:  200px" class="">Qyt*Harga</th>
                                            <!-- <th class="">Keterangan</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="transaction_table_body">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="1">
                                                <button type="button" class="btn btn-primary" id="addline"> <i class="fa fa-plus-circle"></i> Tambah Baris </button>
                                            </td>
                                            <td id="row_loading_status"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th colspan="2">Sub Total I: </th>
                                            <th>
                                            </th>
                                            <th>
                                                <input name="sub_total" value="0" readonly class="accounts_total_amount" />
                                                <?php

                                                ?>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th colspan="3"></th>
                                            <th colspan="2">Pembulatan Sub Total I: </th>
                                            <th>
                                            </th>
                                            <th>
                                                <input name="pembulatan" value="0" readonly class="accounts_total_amount" />
                                                <?php

                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th colspan="2">Biaya Jasa : </th>
                                            <th>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control percent_jasa" value="<?= (!empty($data_return['percent_jasa']) ? (float) $data_return['percent_jasa'] : '')  ?>" name="percent_jasa" id="percent_jasa" min="0" step="0.00001" max="100" onchange='count_total()' placeholder="" aria-label="" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> %</span>
                                                    </div>
                                                </div>
                                                <!-- <input type="number" name="percentage_jasa" class="form-control" min="0" step="0.00001" max="100" onchange='count_total()' /> -->
                                            </th>
                                            <th>
                                                <input name="am_jasa" id="jasa_count" value="<?= (!empty($data_return['am_jasa']) ? $data_return['am_jasa'] : '')  ?>" class=" form-control mask" required onchange='count_total()' />
                                            </th>
                                        </tr>
                                        <tr <?= $acc_role == false ? 'hidden' : '' ?>>
                                            <th colspan="3"></th>
                                            <th colspan="2">Sub Total II: </th>
                                            <th>
                                            </th>
                                            <th>
                                                <input name="sub_total_2" value="0" readonly class="accounts_total_amount" />
                                            </th>
                                        </tr>

                                        <tr <?= $acc_role == false ? 'hidden' : '' ?>>
                                            <th colspan="3"></th>
                                            <th colspan="2">PPh 23 : </th>
                                            <th>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" min="0" max="5" step="0,0001" id="percent_pph" value="<?= (!empty($data_return['percent_pph']) ? (float) $data_return['percent_pph']  : '')  ?>" name="percent_pph" onchange='count_total()' placeholder="" aria-label="" aria-describedby=" basic-addon2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> %</span>
                                                    </div>
                                                </div>
                                                <!-- <input type="number" name="percentage_jasa" class="form-control" min="0" step="0.00001" max="100" onchange='count_total()' /> -->
                                            </th>
                                            <th>
                                                <input name="am_pph" id="pph_count" value="<?= (!empty($data_return['am_pph']) ? $data_return['am_pph']  : '') ?>" class="form-control mask" required onchange='count_total()' />
                                            </th>
                                        </tr>
                                        <tr <?= $acc_role == false ? 'hidden' : '' ?>>
                                            <th colspan="3">
                                                <div id="lebih_ac_layout" style="display: none;">
                                                    <select name="lebih_bayar_ac" id='lebih_bayar_ac' class="form-control select2">
                                                        <option value=""> --- </option>
                                                        <?php
                                                        foreach ($accounts as $lv1) {
                                                            // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                                            foreach ($lv1['children'] as $lv2) {
                                                                echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                                                foreach ($lv2['children'] as $lv3) {
                                                                    if (empty($lv3['children'])) {
                                                                        echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                                        echo '</option>';
                                                                    } else {
                                                                        echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                                                                        foreach ($lv3['children'] as $lv4) {
                                                                            echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                                                            echo '</option>';
                                                                        }
                                                                        echo '</optgroup>';
                                                                    }
                                                                }
                                                                echo '</optgroup>';
                                                            }
                                                            // echo '</optgroup>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </th>
                                            <th colspan="3">
                                                <input type="text" class="form-control" id="lebih_bayar_ket" value="<?= (!empty($data_return['lebih_bayar_ket']) ? $data_return['lebih_bayar_ket']  : '') ?>" name="lebih_bayar_ket" placeholder="Keterangan Lebih Bayar">
                                            </th>
                                            <th>
                                                <!-- <input name="pph_count" value="0" disabled class="accounts_total_amount" /> -->
                                                <input name="lebih_bayar_am" id="lebih_bayar_am" value="<?= (!empty($data_return['lebih_bayar_am']) ? $data_return['lebih_bayar_am']  : '') ?>" class="form-control mask" onchange='count_total()' />
                                            </th>
                                        </tr>

                                        <tr <?= $acc_role == false ? 'hidden' : '' ?>>
                                            <th colspan="3">
                                                <div id="kurang_ac_layout" style="display: none;">
                                                    <select name="kurang_bayar_ac" id='kurang_bayar_ac' class="form-control select2">
                                                        <option value=""> --- </option>
                                                        <?php
                                                        foreach ($accounts as $lv1) {
                                                            // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                                            foreach ($lv1['children'] as $lv2) {
                                                                echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                                                foreach ($lv2['children'] as $lv3) {
                                                                    if (empty($lv3['children'])) {
                                                                        echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                                        echo '</option>';
                                                                    } else {
                                                                        echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                                                                        foreach ($lv3['children'] as $lv4) {
                                                                            echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                                                            echo '</option>';
                                                                        }
                                                                        echo '</optgroup>';
                                                                    }
                                                                }
                                                                echo '</optgroup>';
                                                            }
                                                            // echo '</optgroup>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </th>
                                            <th colspan="3">
                                                <input type="text" class="form-control" id="kurang_bayar_ket" value="<?= (!empty($data_return['kurang_bayar_ket']) ? $data_return['kurang_bayar_ket']  : '')  ?>" name="kurang_bayar_ket" placeholder="Keterangan Kurang Bayar">
                                            </th>
                                            <th>
                                                <!-- <input name="pph_count" value="0" disabled class="accounts_total_amount" /> -->
                                                <input name="kurang_bayar_am" id="kurang_bayar_am" value="<?= (!empty($data_return['kurang_bayar_am']) ? $data_return['kurang_bayar_am']  : '') ?>" class="form-control mask" onchange='count_total()' />
                                            </th>
                                        </tr>

                                        <tr>
                                            <th> <?php
                                                    if ($data_return != NULL) {
                                                        if ($data_return['manual_math'] == '1') {
                                                            $checked = 'checked="checked"';
                                                        } else {
                                                            $checked = '';
                                                        }
                                                    } else {
                                                        $checked = '';
                                                    }
                                                    ?>
                                                <div class="col-3">
                                                    <span class="switch switch-icon">
                                                        <label>
                                                            <input type="checkbox" <?= $checked ?> name="manual_math" onclick='count_total()' />
                                                            <span></span>
                                                        </label>
                                                        manual
                                                    </span>
                                                </div>
                                            </th>
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
                                        <tr>
                                            <th> </th>
                                            <th colspan="2"></th>
                                            <th colspan="2">Uang yang bayarkan : </th>
                                            <th>
                                            </th>
                                            <th>
                                                <input name="payed" id="payed" value="0,00" class="form-control mask" required />
                                            </th>
                                        </tr>
                                        <!-- <tr>
                                            <th> </th>
                                            <th colspan="2"></th>
                                            <th colspan="2">Status Pembayaran: </th>
                                            <th>
                                            </th>
                                            <th>
                                                <select name="payed" id="payed" class="form-control input-lg">
                                                    <option value="paid"> Sudah di bayar (Akun Beban)</option>
                                                    <option value="unpaid"> Belum dibayar (Akun Hutang) </option>
                                                </select>
                                            </th>
                                        </tr> -->
                                    </tfoot>
                                </table>
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

<!-- <script src="<?php echo base_url(); ?>assets/dist/js/backend/pembayaran.js?v=2.001"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>
<script>
    <?php
    // $this->load->view()
    ?>
    var timmer;
    $('#menu_id_32').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_87').addClass('menu-item-active')
    payment_method = $('#payment_method');
    description = $('#description');
    jenis_pembayaran = $('#jenis_pembayaran');
    date_jurnal = $('#date');
    kurang_bayar_ac = $('#kurang_bayar_ac');
    lebih_bayar_ac = $('#lebih_bayar_ac');


    payed = $("#payed");
    var pembayaran_form = $('#pembayaran_form');

    var id_item = document.getElementsByName('id_item[]');
    var keterangan_item = document.getElementsByName('keterangan_item[]');
    var date_item = document.getElementsByName('date_item[]');
    var qyt = document.getElementsByName('qyt[]');
    var amount = document.getElementsByName('amount[]');
    var nopol = document.getElementsByName('nopol[]');
    var satuan = document.getElementsByName('satuan[]');
    var transaction_table_body = $('#transaction_table_body');
    var addline = $('#addline');
    var new_row_html = `                                   <tr class="row_item[]">
                                        <td>
                                            <input type="text" name="id_item[]" value="" class="form-control input-lg" hidden />

                                            <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. Logam 2 btg / Toyota AVZ" />
                                        </td>
                                        <td>
                                            <input type="text" name="nopol[]" value="" step="0.002" class="form-control input-lg nopol" />
                                        </td>
                                        <td>
                                            <input type="text" name="date_item[]" value="" class="form-control input-lg date_item" />
                                        </td>
                                        <td>
                                            <select name="satuan[]" id="satuan" class="form-control">
                                                <?php foreach ($satuan as $st) {
                                                    echo '<option value="' . $st['name_unit'] . '"> ' . $st['name_unit'] . ' </option>';
                                                } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control input-lg" name="qyt[]" value="" onkeyup="count_total()" required />
                                        </td>
                                        <td>
                                            <input class="form-control input-lg mask" name="amount[]" value="" onkeyup="count_total()" required />
                                        </td>
                                        <td>
                                            <div class="row">
                                                <input class="form-control input-lg mask accounts_total_amount" name="qyt_amount[]" value="0" onkeyup="count_total()" disabled />
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" data-row="1" name="delete_row[]" id="delete_row[]" onchange="delete_row(this)">
                                                    <label class="form-check-label" for="delete_row[]">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`;
    transaction_table_body.append(new_row_html)
    addline.on('click', () => {
        transaction_table_body.append(new_row_html);
    });

    function count_total(edit = false) {
        clearTimeout(timmer);
        count_val = 0;
        label_jasa = $("#jasa_count");
        label_pph = $("#pph_count");

        lebih_bayar_ket = $("#lebih_bayar_ket").val();
        lebih_bayar_am = parseFloat(
            $("#lebih_bayar_am").val().replaceAll(".", "").replaceAll(",", ".")
        );
        kurang_bayar_am = parseFloat(
            $("#kurang_bayar_am").val().replaceAll(".", "").replaceAll(",", ".")
        );

        timmer = setTimeout(function callback() {
            if ($('input[name="manual_math"]').is(":checked") == true) {
                manual_math = true;
                label_jasa.prop("readonly", false);
                label_pph.prop("readonly", false);
            } else {
                manual_math = false;
                label_jasa.prop("readonly", true);
                label_pph.prop("readonly", true);
            }

            p_jasa = $('input[name="percent_jasa"]').val();
            p_jasa = p_jasa.replace(",", ".");
            $("#percent_jasa").val(p_jasa);

            if (p_jasa == "") p_jasa = 0;
            p_pph = $('input[name="percent_pph"]').val();
            if (p_pph == "") p_pph = 0;

            var total_debit = 0;
            qyt = $('input[name="qyt[]"]');
            amount = $('input[name="amount[]"]');
            qyt_amount = $('input[name="qyt_amount[]"]');

            tmp_jasa = $("#jasa_count").val();
            tmp_pph = $("#pph_count").val();
            i = 0;
            $('input[name="qyt[]"]').each(function() {
                val1 = 0;
                ppn_pph = 0;
                if (
                    qyt[i].value != "" &&
                    qyt[i].value != "0" &&
                    amount[i].value != "" &&
                    amount[i].value != "0"
                ) {
                    val1 =
                        parseFloat(amount[i].value.replaceAll(".", "").replaceAll(",", ".")) *
                        qyt[i].value;
                    count_val = count_val + val1;

                    qyt_amount[i].value = formatRupiah2(val1);
                } else {
                    qyt_amount[i].value = "";
                }

                i++;
            });

            $('input[name="sub_total"]').val(formatRupiah2(count_val));
            // console.log(jenis_pembayaran.val())
            if (jenis_pembayaran.val() == 2) {
                count_val = Math.floor(count_val / 100) * 100;
                $('input[name="pembulatan"]').val(formatRupiah2(count_val));
            }
            biaya_jasa = 0;
            biaya_pph = 0;
            if (manual_math && (tmp_jasa != "0" || tmp_jasa != "0,00")) {
                biaya_jasa = parseFloat(
                    tmp_jasa.replaceAll(".", "").replaceAll(",", ".")
                );
            } else {
                if (p_jasa != "" && p_jasa != "0") {
                    biaya_jasa = Math.ceil((p_jasa / 100) * count_val);
                    $('input[name="am_jasa"]').val(formatRupiah2(biaya_jasa));
                } else {
                    $('input[name="am_jasa"]').val(0);
                }
            }
            $('input[name="sub_total_2"]').val(formatRupiah2(count_val - biaya_jasa));
            setela_jasa = (count_val - biaya_jasa).toFixed(2);
            if (manual_math && (tmp_pph != "0" || tmp_pph != "0,00")) {
                biaya_pph = parseFloat(tmp_pph.replaceAll(".", "").replaceAll(",", "."));
            } else {
                if (count_val != "" && count_val != "0") {
                    biaya_pph = Math.floor((p_pph / 100) * setela_jasa);
                    $('input[name="am_pph"]').val(formatRupiah2(biaya_pph));
                } else {
                    $('input[name="am_pph"]').val(0);
                }
            }
            total_final = (setela_jasa - biaya_pph).toFixed(2);

            if (lebih_bayar_am > 0) {
                total_final = parseFloat(total_final) - parseFloat(lebih_bayar_am);
                document.getElementById("lebih_ac_layout").style.display = "block";
            } else {
                document.getElementById("lebih_ac_layout").style.display = "none";
            }

            if (kurang_bayar_am > 0) {
                total_final = parseFloat(total_final) + parseFloat(kurang_bayar_am);
                document.getElementById("kurang_ac_layout").style.display = "block";
            } else {
                document.getElementById("kurang_ac_layout").style.display = "none";
            }

            if (total_final != "" && total_final != "0") {
                $('input[name="total_final"]').val(formatRupiah2(total_final));
            } else {
                $('input[name="total_final"]').val(0);
            }
        }, 800);
    }

    function formatRupiah2(angka, prefix) {
        var number_string = angka.toString();
        expl = number_string.split(".", 2);
        // console.log("ex");
        if (expl[1] == undefined) {
            expl[1] = "00";
        } else {
            if (expl[1].length == 1) expl[1] = expl[1] + "0";
            else expl[1] = expl[1].slice(0, 2);
        }

        sisa = expl[0].length % 3;
        (rupiah = expl[0].substr(0, sisa)),
        (ribuan = expl[0].substr(sisa).match(/\d{3}/gi));

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = expl[1] != undefined ? rupiah + "," + expl[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }

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


    pembayaran_form.submit(function(event) {
        event.preventDefault();
        // var isAdd = BankModal.addBtn.is(':visible');
        var url = "<?= site_url('pembayaran/' . $form_url) ?>";
        // url += isAdd ? "addBank" : "editBank";
        // var button = isAdd ? BankModal.addBtn : BankModal.saveEditBtn;

        Swal.fire(swalSaveConfigure).then((result) => {
            if (result.isConfirmed == false) {
                return;
            }
            // swal.fire({
            //     title: 'Loading Payment...',
            //     allowOutsideClick: false
            // });
            // swal.showLoading();
            $.ajax({
                url: url,
                'type': 'POST',
                data: new FormData(pembayaran_form[0]),
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
                    window.location = '<?= base_url() ?>pembayaran/show/' + d;
                },
                error: function(e) {}
            });
        });
    });

    function delete_row(row) {
        // idx = row.index(this);
        // console.log(idx)
        var cur_keterangan_item = document.getElementsByName('keterangan_item[]');
        var cur_date_item = document.getElementsByName('date_item[]');
        var cur_qyt = document.getElementsByName('qyt[]');
        var cur_amount = document.getElementsByName('amount[]');
        var cur_nopol = document.getElementsByName('nopol[]');
        var cur_satuan = document.getElementsByName('satuan[]');
        var row_item = document.getElementsByClassName('row_item[]');
        i = 0;
        $('input[name="delete_row[]"]').each(function(index) {
            // alert(index);
            // $('input[name="amount[]"]').val('123123')
            if ($(this).prop("checked") == true) {
                console.log('this true = ' + index)
                cur_keterangan_item[index].value = '';
                cur_date_item[index].value = '';
                cur_qyt[index].value = 0;
                cur_amount[index].value = 0;
                cur_satuan[index].value = '';
                row_item[index].style.display = 'none';
                console.log(cur_keterangan_item[index].value);
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



    jenis_pembayaran.on('change', function() {
        if (jenis_pembayaran.val() == '1') {
            console.log('jenis 1')
            $('#head_col_2').html('No Polisi')
            $('#head_col_3').html('Tanggal')
            $('.date_item').unmask();
            $('.nopol').prop('type', 'text');
        } else if (jenis_pembayaran.val() == '2') {
            $('#head_col_2').html('PO Qyt')
            $('#head_col_3').html('PO Harga')
            $('.date_item').mask('000.000.000.000.000,00', {
                reverse: true
            });
            $('.nopol').prop('type', 'number');
        }
        count_total();
    })


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
        <option value="0"> ------- </option>` + data_cars + `
    </select>`)
        $('.select2').select2();
    }

    <?php if ($data_return != NULL) {    ?>
        id_custmer.val('<?= $data_return['customer_id'] ?>');
        date_jurnal.val('<?= $data_return['date'] ?>');
        description.val('<?= $data_return['description'] ?>');
        payment_method.val('<?= $data_return['payment_metode'] ?>');
        jenis_pembayaran.val('<?= $data_return['jenis_pembayaran'] ?>');
        lebih_bayar_ac.val('<?= $data_return['lebih_bayar_ac'] ?>');
        kurang_bayar_ac.val('<?= $data_return['kurang_bayar_ac'] ?>');
        payed.val('<?= $data_return['payed'] ?>');
        jenis_pembayaran.trigger('change');
        <?php
        $count_rows = count($data_return['amount']);
        for ($i = 0; $i < $count_rows - 1; $i++) { ?>
            transaction_table_body.append(new_row_html)
            // add_new_row('<?php echo base_url() . 'pembayaran/popup/new_row'; ?>');

        <?php
        }
        for ($i = 0; $i < $count_rows; $i++) { ?>
            id_item[<?= $i ?>].value = '<?= $data_return['id_item'][$i] ?>';
            amount[<?= $i ?>].value = '<?= $data_return['amount'][$i] ?>';
            qyt[<?= $i ?>].value = '<?= $data_return['qyt'][$i] ?>';
            nopol[<?= $i ?>].value = '<?php
                                        // $data_return['nopol'][$i] 
                                        ?>';
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