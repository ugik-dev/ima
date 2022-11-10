<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <!-- <div class="col-lg-12"> -->
            <table id="FDataTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center!important">Tanggal<br>Penerimaan</th>
                        <th style=" text-align:center!important">Nama Mitra</th>
                        <th style=" text-align:center!important">Zona</th>
                        <th style=" text-align:center!important">Lokasi</th>
                        <th style="text-align:center!important">Total</th>
                        <th style="width: 5%; text-align:center!important">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <!-- </div> -->
        </div>
    </div>
</div>

<script>
    var timmer;

    function count(edit = false) {
        clearTimeout(timmer);
        count_val = 0;
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

            i = 0;
            $('input[name="harga[]"]').each(function() {
                val1 = 0;
                if (
                    // berat[i].value != "" &&
                    // berat[i].value != "0" &&
                    // harga[i].value != "" &&
                    // harga[i].value != "0"
                    amount[i].value != "" &&
                    amount[i].value != "0"
                ) {
                    // val1 = parseFloat(harga[i].value.replace(/[^0-9]/g, "")) * berat[i].value;
                    console.log(amount[i].value.replaceAll('.', '').replace(',', '.'))
                    val1 = parseFloat(amount[i].value.replaceAll('.', '').replace(',', '.'));
                    count_val = count_val + val1;
                    console.log(val1);
                    // amount[i].value = formatRupiah(val1);
                } else {
                    amount[i].value = "";
                }
                i++;
            });

            if (count_val != "" && count_val != "0") {
                $('input[name="sub_total"]').val(formatRupiahComa(count_val));
                ts = $('#tx_sebelumnya').val().replaceAll('.', '').replace(',', '.');
                console.log(ts);
                if (ts != '' && ts != '0')
                    $('input[name="ts_sub"]').val(formatRupiahComa(parseFloat(ts) + count_val));
                else
                    $('input[name="ts_sub"]').val(formatRupiahComa(count_val));
            } else {
                $('input[name="sub_total"]').val(0);
            }
            total_final = total_final + count_val;

            console.log(percent_oh);
            if (percent_pph_21 != '' && percent_pph_21 != '0') {
                am_pph_21.val(formatRupiah2(Math.floor(percent_pph_21 / 100 * count_val)));
                total_final = total_final - (Math.floor(percent_pph_21 / 100 * count_val));
            }

            if (percent_oh != '' && percent_oh != '0') {
                // console.log(count_val);
                am_oh.val(formatRupiah2(Math.floor(percent_oh / 100 * count_val)));
                total_final = total_final - (Math.floor(percent_oh / 100 * count_val));
            }

            if (percent_profit != '' && percent_profit != '0') {
                am_profit.val(formatRupiah2(Math.floor(percent_profit / 100 * count_val)));
                total_final = total_final - (Math.floor(percent_profit / 100 * count_val));
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
        // $("#kt_body").addClass('aside-minimize');
        $('#menu_id_34').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_94').addClass('menu-item-active')

        trans_table = $('#transaction_table_body');
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [{
                targets: [1, 3],
                className: 'text-right'
            }],
            responsive: true,
            deferRender: true,
            paging: true,
            ordering: true,
            info: true,
            searching: true,
        });


        $.ajax({
            url: '<?= base_url() ?>Shp/getAll',
            type: "get",
            data: {},
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

        function renderTransTable(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            // ttl_sub = 0;
            // ttl_pph21 = 0;
            Object.values(data).forEach((user) => {
                // ttl_sub = parseFloat(ttl_sub) + parseFloat(user['sub_total_2']);
                // ttl_pph21 = parseFloat(ttl_pph21) + parseFloat(user['am_pph_21']);
                // console.log(ttl_sub)
                renderData.push([user['date_penerimaan'], user['customer_name'], user['nama_zona'], user['lokasi'], formatRupiah2(user['total_final']), `<a target="_blank" href='<?= base_url() ?>shp/show/${user['id_shp']}'>Show<a>`]);
            });
            // renderData.push(['<b>TOTAL</b>', formatRupiah2(ttl_sub), '', formatRupiah2(ttl_pph21), '']);
            // $('#tx_sebelumnya').val(formatRupiah2(ttl_sub));
            // $('#tx_sebelumnya').trigger('onkeyup');
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        $('.mask').mask('000.000.000.000.000,00', {
            reverse: true
        });

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