<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <!-- <div class="col-lg-12"> -->
            <table id="FDataTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center!important">Tanggal<br>Penerimaan</th>
                        <th style=" text-align:center!important">Status</th>
                        <th style=" text-align:center!important">Nama Mitra</th>
                        <th style=" text-align:center!important">Nama Agent</th>
                        <th style=" text-align:center!important">Zona Wilaya / Lokasi</th>
                        <!-- <th style=" text-align:center!important">Nilai Transaksi</th> -->
                        <th style="text-align:center!important">Nilai Transaksi</th>
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
    $(document).ready(function() {
        // $("#kt_body").addClass('aside-minimize');
        $('#menu_id_32').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_96').addClass('menu-item-active')

        trans_table = $('#transaction_table_body');
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [{
                targets: [5],
                className: 'text-right'
            }, {
                targets: [0, 2, 3, 4],
                className: 'text-left'
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
                renderData.push([user['date_penerimaan'], user['status_shp'], user['customer_name'], user['agentname'], user['nama_zona'] + '<br>' + user['nama_wilayah'] + '<br>' + user['lokasi'], formatRupiah2(user['total_final']), `<a target="" href='<?= base_url() ?>pembayaran/shp_show/${user['id_shp']}'>Show<a>`]);
            });
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