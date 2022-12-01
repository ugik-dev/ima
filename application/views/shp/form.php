<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <div class="">
                <?php
                $attributes = array('id' => 'invoice', 'method' => 'post', 'class' => '');
                ?>
                <?php
                //  echo form_open('usaha/add_record_car_wash', $attributes); 
                ?>
                <form id="shp_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <div class="">
                        <div class="row no-print invoice">
                            <h4 class=""> <i class="fa fa-check-circle"></i>
                                Form SHP
                            </h4>
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <?php echo form_label('Mitra'); ?>
                                            <input type="hidden" name="id_shp" value="<?= !empty($data_return['id_shp']) ? $data_return['id_shp'] : '' ?>" />
                                            <!-- <select class="js-data-example-ajax"></select> -->
                                            <select name="id_mitra" id="id_mitra" required class=" required form-control select2 input-lg">
                                                <option value=""> ------- </option>
                                                <?php
                                                foreach ($mitra as $m) {
                                                    if (!empty($data_return['id_mitra'])) {
                                                        echo "<option value='{$m['id']}' " . ($m['id'] == $data_return['id_mitra'] ? 'selected' : '') . "> {$m['text']} </option>";
                                                    } else
                                                        echo "<option value='{$m['id']}'> {$m['text']} </option>";
                                                }
                                                // echo $patner_record; 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <table id="FDataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center!important">Tanggal</th>
                                                    <th style=" text-align:center!important">Transaksi</th>
                                                    <th style=" text-align:center!important">PPh21 (%)</th>
                                                    <th style="text-align:center!important">PPh21 (Rp)</th>
                                                    <th style="width: 5%; text-align:center!important">Action</th>
                                                    <!-- <th style="width: 5%; text-align:center!important">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <h2>Hasil Penimbangan & Analisis GCA dan/atau XRF</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Tanggal Penerimaan Control'); ?>
                                        <?php
                                        $data = array('class' => 'form-control input-lg', 'value' => ((!empty($data_return['date_penerimaan'])) ? $data_return['date_penerimaan'] : date('Y-m-d')), 'type' => 'date', 'name' => 'date_penerimaan', 'id' => 'date_penerimaan', 'reqiured' => '');
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Tanggal Analisis'); ?>
                                        <?php
                                        $data = array('class' => 'form-control input-lg', 'value' => ((!empty($data_return['date_analisis'])) ? $data_return['date_analisis'] : date('Y-m-d')), 'type' => 'date', 'name' => 'date_analisis', 'id' => 'date_analisis', 'reqiured' => '');
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Metoda Pengujian'); ?>
                                        <select name="metode_pengujian" id="metode_pengujian" required class="form-control input-lg">
                                            <option value=""> - </option>
                                            <option value="GCA" <?= !empty($data_return['metode_pengujian']) ? ($data_return['metode_pengujian'] == 'GCA' ? 'selected' : '') : '' ?>> GCA </option>
                                            <option value="XRF" <?= !empty($data_return['metode_pengujian']) ? ($data_return['metode_pengujian'] == 'XRF' ? 'selected' : '') : '' ?>> XRF </option>
                                            <option value="Kimia" <?= !empty($data_return['metode_pengujian']) ? ($data_return['metode_pengujian'] == 'Kimia' ? 'selected' : '') : '' ?>> Kimia </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Zona'); ?>
                                        <!-- <input type="text" name="lokasi" class="form-control"> -->
                                        <select name="zona" id="zona" required class="form-control input-lg">
                                            <option value=""> - </option>
                                            <?php foreach ($ref_zona as $zona) {
                                                if (!empty($data_return['zona'])) {
                                                    echo "<option value='{$zona['id_zona']}'" . ($zona['id_zona'] == $data_return['zona'] ? 'selected' : '') . "> {$zona['nama_zona']} </option>";
                                                } else
                                                    echo "<option value='{$zona['id_zona']}' >{$zona['nama_zona']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Wilayah'); ?>
                                        <select name="wilayah" id="wilayah" required disabled class="form-control input-lg">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Lokasi'); ?>
                                        <input type="text" id="lokasi" name="lokasi" value="<?= !empty($data_return['lokasi']) ? $data_return['lokasi'] : '' ?>" required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row invoice">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-striped table-hover  ">
                                    <thead>
                                        <tr>
                                            <th style="width:  300px">Kode Biji Timah</th>
                                            <!-- <th style="width:  200px">Tanggal</th> -->
                                            <!-- <th style="width:  250px">Keterangan</th> -->
                                            <th style="width:  120px">Berat</th>
                                            <th style="width: 120px">Kadar Sn</th>
                                            <th style="width:  120px" class="">Terak</th>
                                            <th style="width:  250px">Harga<br> Rp/Kg Ore</th>
                                            <th style="width:  250px">Total<br> (Rp)</th>
                                            <!-- <th class="">Keterangan</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="transaction_table_body">

                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <td colspan="5">
                                                <button type="button" class="btn btn-primary" id="addline"> <i class="fa fa-plus-circle"></i> Tambah Baris </button>
                                            </td>
                                            <td id="row_loading_status"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Sub Total : </th>
                                            <th></th>
                                            <th>
                                                <?php
                                                $data = array('name' => 'sub_total', 'value' => '0', 'readonly' => 'readonly', 'class' => 'form-control text-right', 'reqiured' => '');
                                                echo form_input($data);

                                                // if ($data_return != NULL) {
                                                //     if ($data_return['ppn_pph'] == '1') {
                                                //         $checked = 'checked="checked"';
                                                //     } else {
                                                //         $checked = '';
                                                //     }
                                                // } else {
                                                //     $checked = '';
                                                // }

                                                ?>
                                            </th>
                                        </tr>
                                        <tr>

                                            <th colspan="4" class="text-right">Transaksi Sebelumnya : </th>
                                            <th></th>
                                            <th>
                                                <input name="tx_sebelumnya" id="tx_sebelumnya" onkeyup="count()" value="<?= (!empty($data_return['tx_sebelumnya']) ? $data_return['tx_sebelumnya']  : '') ?>" class="form-control mask text-right" onchange='count()' />
                                            </th>
                                        </tr>
                                        <tr>

                                            <th colspan="4" class="text-right">Total Transaksi : </th>
                                            <th></th>
                                            <th>
                                                <input name="ts_sub" id="ts_sub" readonly onkeyup="count()" value="<?= (!empty($data_return['ts_sub']) ? $data_return['ts_sub']  : '') ?>" class="form-control mask text-right" onchange='count()' />
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">PPh 21 : </th>
                                            <th>
                                                <div class="input-group mb-3">
                                                    <input type="number" step=".000001" class="form-control" onkeyup="count()" name="percent_pph_21" id="percent_pph_21" value="<?= (!empty($data_return['percent_pph_21']) ? (float) $data_return['percent_pph_21']  : '')  ?>" name="percent_pph_21" onchange='count()' placeholder="" aria-label="" aria-describedby=" basic-addon2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> %</span>
                                                    </div>
                                                </div>
                                                <!-- <input type="number" name="percentage_jasa" class="form-control" min="0" step="0.00001" max="100" onchange='count_total()' /> -->
                                            </th>
                                            <th>
                                                <input name="am_pph_21" id="am_pph_21" readonly onkeyup="count()" value="<?= (!empty($data_return['am_pph_21']) ? $data_return['am_pph_21']  : '') ?>" class="form-control mask text-right" required onchange='count()' />
                                            </th>
                                        </tr>

                                        <tr>
                                            <th colspan="4" class="text-right">OH : </th>
                                            <th>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" onkeyup="count()" name="percent_oh" id="percent_oh" value="<?= (!empty($data_return['percent_oh']) ? (float) $data_return['percent_oh']  : '')  ?>" name="percent_oh" onchange='count()' placeholder="" aria-label="" aria-describedby=" basic-addon2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> %</span>
                                                    </div>
                                                </div>
                                                <!-- <input type="number" name="percentage_jasa" class="form-control" min="0" step="0.00001" max="100" onchange='count_total()' /> -->
                                            </th>
                                            <th>
                                                <input name="am_oh" id="am_oh" readonly onkeyup="count()" value="<?= (!empty($data_return['am_oh']) ? $data_return['am_oh']  : '') ?>" class="form-control mask text-right" required onchange='count()' />
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Profit IMA : </th>
                                            <th>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" onkeyup="count()" name="percent_profit" id="percent_profit" value="<?= (!empty($data_return['percent_profit']) ? (float) $data_return['percent_profit']  : '')  ?>" name="percent_profit" onchange='count()' placeholder="" aria-label="" aria-describedby=" basic-addon2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> %</span>
                                                    </div>
                                                </div>
                                                <!-- <input type="number" name="percentage_jasa" class="form-control" min="0" step="0.00001" max="100" onchange='count_total()' /> -->
                                            </th>
                                            <th>
                                                <input name="am_profit" id="am_profit" readonly value="<?= (!empty($data_return['am_profit']) ? $data_return['am_profit']  : '') ?>" class="form-control mask text-right" required onchange='count()' />
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Total Final: </th>
                                            <th>
                                            </th>
                                            <th>
                                                <?php
                                                $data = array('name' => 'total_final', 'value' => '0', 'readonly' => 'readonly', 'class' => 'form-control text-right', 'reqiured' => '');
                                                echo form_input($data);
                                                ?>
                                            </th>
                                        </tr>

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
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script src="<?php echo base_url(); ?>assets/dist/js/backend/invoice.js?v=0.2"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    dataRab = JSON.parse(`<?= json_encode($ref_rab) ?>`);

    function getHarga(row, persen) {
        console.log(dataRab[persen]);
        if (dataRab[persen] != undefined) {
            document.getElementById('harga_' + row).value = formatRupiah2(dataRab[persen]['harga']);
            count();
        }
    }

    var timmer;

    function count(edit = false) {
        clearTimeout(timmer);
        sub_total = 0;
        timmer = setTimeout(function callback() {
            var total_final = 0;
            berat = $('input[name="berat[]"]');
            // harga = $('input[name="harga"]').val();
            harga = $('input[name="harga[]"]');
            amount = $('input[name="amount[]"]');
            percent_pph_21 = $('#percent_pph_21').val();
            am_pph_21 = $('#am_pph_21');
            am_oh = $('#am_oh');
            am_profit = $('#am_profit');
            percent_profit = $('#percent_profit').val();
            percent_oh = $('#percent_oh').val();
            // const d5 = new Date(date).getTime();
            // const d6 = new Date("2022-04-01").getTime();

            // if (d5 >= d6) {
            //     var_ppn = 0.11;
            //     console.log("PPH 11");
            //     $("#label_ppn").html("PPN 11%");
            // } else {
            //     var_ppn = 0.1;
            //     $("#label_ppn").html("PPN 10%");
            //     console.log("PPH 10");
            // }

            // amount = $('input[name="amount[]"]');
            // qyt_amount = $('input[name="qyt_amount[]"]');
            i = 0;
            $('input[name="harga[]"]').each(function() {
                jumlah = 0;
                if (
                    berat[i].value != "" &&
                    berat[i].value != "0" &&
                    harga[i].value != "" &&
                    harga[i].value != "0"
                    // amount[i].value != "" &&
                    // amount[i].value != "0"
                ) {
                    jumlah = parseFloat(harga[i].value.replaceAll('.', '').replace(',', '.')) * berat[i].value;
                    pengurangan = (7.75 / 100) * jumlah
                    // jumlah = jumlah - pengurangan;
                    // val1 = parseFloat(amount[i].value.replaceAll('.', '').replace(',', '.'));
                    sub_total = sub_total + jumlah;
                    console.log(pengurangan);
                    amount[i].value = formatRupiah2(jumlah);
                } else {
                    amount[i].value = "";
                }
                i++;
            });

            if (sub_total != "" && sub_total != "0") {
                $('input[name="sub_total"]').val(formatRupiahComa(sub_total));
                ts = $('#tx_sebelumnya').val().replaceAll('.', '').replace(',', '.');
                console.log(ts);
                if (ts != '' && ts != '0')
                    $('input[name="ts_sub"]').val(formatRupiahComa(parseFloat(ts) + sub_total));
                else
                    $('input[name="ts_sub"]').val(formatRupiahComa(sub_total));
            } else {
                $('input[name="sub_total"]').val(0);
            }
            total_final = total_final + sub_total;

            console.log(percent_oh);
            if (percent_pph_21 != '' && percent_pph_21 != '0') {
                am_pph_21.val(formatRupiah2(Math.floor(percent_pph_21 / 100 * sub_total)));
                total_final = total_final - (Math.floor(percent_pph_21 / 100 * sub_total));
            }

            if (percent_oh != '' && percent_oh != '0') {
                am_oh.val(formatRupiah2(Math.floor(percent_oh / 100 * sub_total)));
                total_final = total_final - (Math.floor(percent_oh / 100 * sub_total));
            }

            if (percent_profit != '' && percent_profit != '0') {
                am_profit.val(formatRupiah2(Math.floor(percent_profit / 100 * sub_total)));
                total_final = total_final - (Math.floor(percent_profit / 100 * sub_total));
            }
            if (total_final != "" && total_final != "0") {
                $('input[name="total_final"]').val(formatRupiahComa(total_final));
            } else {
                $('input[name="total_final"]').val(0);
            }
            // console.log(ppn_pph);
            // }
        }, 800);
    }
    $(document).ready(function() {

        $("#kt_body").addClass('aside-minimize');
        $('#menu_id_34').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_93').addClass('menu-item-active')

        dataZona = JSON.parse(`<?= json_encode($ref_zona) ?>`);
        zona = $('#zona');
        wilayah = $('#wilayah');
        description = $('#description');
        date_jurnal = $('#date');
        shp_form = $('#shp_form');
        var row_num = 1;
        <?php
        if (!empty($data_return['zona'])) {
            echo "def_wilayah = '{$data_return['wilayah']}';";
        } else
            echo "def_wilayah = '';";

        ?>

        zona.on('change', function() {
            if (zona.val() != '') {
                wilayah.prop('disabled', false);
                wilayah.empty();
                wilayah.append($('<option>', {
                    value: "",
                    text: "--"
                }));
                Object.values(dataZona[zona.val()]['child']).forEach((d) => {

                    // } else
                    wilayah.append($('<option>', {
                        value: d['id_wilayah'],
                        text: d['nama_wilayah'],
                        selected: (d['id_wilayah'] == def_wilayah ? true : false),
                    }));
                });

            } else {
                wilayah.prop('disabled', true);
                wilayah.empty();
            }
            console.log(dataZona[zona.val()])

        })


        acc_1 = $('#acc_1');
        acc_2 = $('#acc_2');
        acc_3 = $('#acc_3');
        addLine = $('#addline');
        trans_table = $('#transaction_table_body');
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [{
                targets: [1, 3],
                className: 'text-right'
            }],
            responsive: true,
            deferRender: false,
            paging: false,
            ordering: false,
            info: false,
            searching: false,

        });

        addLine.on('click', function() {
            addLines();
        });

        function addLines(ch_id = '', ch_kd = '', ch_berat = '', ch_kadar = '', ch_terak = '', ch_harga = '', ch_amount = '') {
            // <td>
            //     <input type="text" name="ket[]" value="" class="form-control input-lg" />
            // </td>
            htmlRow = `             <tr>
                                       
                                        <td>
                                            <input type="hidden" name="id_shp_child[]" value="${ch_id}" class="" />
                                            <input type="text" name="kode_timah[]" value="${ch_kd}" class="form-control input-lg" />
                                        </td>
                                        <td>
                                             <input type="number" step="0.001" name="berat[]" onkeyup="count()" value="${ch_berat}" class="form-control input-lg" />
                                         </td>                                      
                                        <td>
                                            <input type="number" min="40" step="1" max="70" onkeyup="getHarga(${row_num}, this.value)" name="kadar[]" value="${ch_kadar}" class="form-control input-lg" />
                                        </td>
                                            <td>
                                            <select name="terak[]" id="terak" class="form-control">
                                                <option> - </option>
                                                <option value="Y" ${ch_terak == 'Y' ? 'selected' : ''}> ADA </option>
                                                <option value="N" ${ch_terak == 'N' ? 'selected' : ''}> TIDAK </option>
                                            </select>
                                        </td>
                                      
                                        <td>
                                            <input type="text" name="harga[]" id="harga_${row_num}" value="${ch_harga}" onkeyup="count()" class="mask form-control input-lg text-right" />
                                        </td>
                                        <td>
                                            <input type="text" name="amount[]" value="${ch_amount}" onkeyup="count()" class="mask form-control input-lg text-right" />
                                        </td>
                                    </tr>
                        `;
            trans_table.append(htmlRow);
            $('.mask').mask('000.000.000.000.000,00', {
                reverse: true
            });
            row_num++;
        }


        id_custmer = $('#id_mitra');
        date_penerimaan = $('#date_penerimaan');
        layer_cars = $('#layer_cars');
        id_custmer.on('change', function() {
            $.ajax({
                url: '<?= base_url() ?>General/searchPembayaran',
                type: "get",
                data: {
                    date_penerimaan: date_penerimaan.val(),
                    id_custmer: id_custmer.val(),
                    jenis_pembayaran: 6
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error'] == true) {
                        layer_cars.html('');
                        return;
                    }
                    var data_tr_customer = json['data'];
                    renderTransTable(data_tr_customer);
                    // add_cars();
                    // document.getElementById("label_kendaraan").style.display = "block";
                    // addcars.style.display = 'block';
                },
                error: function(e) {}
            });
        });

        function renderTransTable(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            ttl_sub = 0;
            ttl_pph21 = 0;
            Object.values(data).forEach((user) => {
                ttl_sub = parseFloat(ttl_sub) + parseFloat(user['sub_total_2']);
                ttl_pph21 = parseFloat(ttl_pph21) + parseFloat(user['am_pph_21']);
                console.log(ttl_sub)
                renderData.push([user['date'], formatRupiah2(user['sub_total_2']), parseFloat(user['percent_pph_21']).toFixed(2), formatRupiah2(user['am_pph_21']), `<a target="_blank" href='<?= base_url() ?>pembayaran/show/${user['id']}'>Check<a>`]);
            });
            renderData.push(['<b>TOTAL</b>', formatRupiah2(ttl_sub), '', formatRupiah2(ttl_pph21), '']);
            $('#tx_sebelumnya').val(formatRupiah2(ttl_sub));
            $('#tx_sebelumnya').trigger('onkeyup');
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        $('.mask').mask('000.000.000.000.000,00', {
            reverse: true
        });


        shp_form.submit(function(event) {
            event.preventDefault();
            // var isAdd = BankModal.addBtn.is(':visible');
            var url = "<?= base_url('shp/' . $form_url) ?>";

            Swal.fire(swalSaveConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(shp_form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        //  return;
                        var d = json['id_shp']

                        swal.fire(swalSuccessConfigure);
                        window.location = '<?= base_url() ?>shp/show/' + d;
                    },
                    error: function(e) {}
                });
            });
        });
        <?php
        if (empty($data_return))
            echo 'addLines();';

        if (!empty($data_return['zona'])) {
            echo "zona.trigger('change');";
        }
        if (!empty($data_return['id_mitra'])) {
            echo "id_custmer.trigger('change');";
        }
        if (!empty($data_return['child'])) {
            foreach ($data_return['child'] as $c) {
                echo "addLines({$c['id_shp_child']} , '{$c['kode_timah']}' , '" . floatval($c['berat']) . "' , '" . floatval($c['kadar']) . "' , '{$c['terak']}' , '{$c['harga']}' , '{$c['amount']}' );";
            }
        }

        ?>

    })


    function formatRupiahhr(angka, prefix) {
        // nom_arr = nom.split('.');
        // console.log(nom_arr);
        // angka = nom_arr[0];
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
<?php $this->load->view('bootstrap_model.php'); ?>