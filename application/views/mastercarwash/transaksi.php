<div class="card card-custom">
    <div class="card-body">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <input class="form-control mr-sm-2" type="date" name="req_tanggal_start" id="req_tanggal_start" value="<?= date('Y-01-01') ?>">
                    <input class="form-control mr-sm-2" type="date" name="req_tanggal_end" id="req_tanggal_end" value="<?= date('Y-12-31') ?>">
                    <select class="form-control mr-sm-2" name="status" id="status">
                        <option value="">Semua</option>
                        <option value="1|2|3">Belum Check-in / Dalam Antrian / Sedang di Cuci</option>
                        <option value="1">Belum Check-in</option>
                        <option value="2">Dalam Antrian</option>
                        <option value="3">Sedang di cuci</option>
                        <option value="4">Selesai</option>
                        <option value="5">Di Batalkan</option>
                    </select>


                    <!-- <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn"><i class="fas fa-plus"></i> Tambah Jenis Dokumen</button> -->
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; text-align:center!important">Waktu Request (Client)</th>
                                        <th style="width: 5%; text-align:center!important">Waktu Perkiraan (Petugas)</th>
                                        <th style="width: 24%; text-align:left!important">Info Pemesanan</th>
                                        <th style="width: 24%; text-align:left!important">Info Pembayaran</th>
                                        <th style="width: 7%; text-align:left!important">Margin</th>
                                        <th style="width: 7%; text-align:left!important">Fee</th>
                                        <th style="width: 7%; text-align:left!important">Petugas</th>
                                        <th style="width: 7%; text-align:left!important">Admin</th>
                                        <th style="width: 7%; text-align:left!important">Status</th>
                                        <th style="width: 7%; text-align:left!important">Pembayaran</th>
                                        <th style="width: 5%; text-align:center!important">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="car_wash_modal" tabindex="-1" opd="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Aksi</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="form_carwash" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_carwash" name="id_carwash">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select type="text" class="form-control" id="status" name="status" required="required">
                                        <!-- <option value="1"></option> -->
                                        <option value="1">Menunggu dijadwalkan petugas</option>
                                        <option value="2">Dijadwalkan</option>
                                        <option value="3">Sedang di Cuci</option>
                                        <option value="4">Selesai</option>
                                        <option value="5">Di Batalkan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="service_1">Layanan 1</label>
                                    <select type="text" class="form-control" id="service_1" name="service_1" required="required">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="service_2">Layanan 2</label>
                                    <select type="text" class="form-control" id="service_2" name="service_2" required="required">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="req_tanggal">Tanggal Pencucian : </label>
                                    <input type="date" name="req_tanggal" id="req_tanggal" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="est_time">Waktu Pencucian : </label>
                                    <input type="time" name="est_time" id="est_time" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="plat">Plat : </label>
                                    <input type="text" name="plat" id="plat" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_pemesan">Nama Pemesan : </label>
                                    <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_driver">Nama Driver : </label>
                                    <input type="text" name="nama_driver" id="nama_driver" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="notelp">No Telp : </label>
                                    <input type="text" name="notelp" id="notelp" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <strong>Pembayaran</strong>
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="status">Metode Pembayaran</label>
                                        <select type="text" class="form-control" id="pembayaran_metode" name="pembayaran_metode" required="required">
                                            <option value="1">Cash</option>
                                            <option value="2">Transfer</option>
                                            <option value="2">Cashless</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="status">Petugas Cuci</label>
                                        <select type="text" class="form-control" id="id_petugas_cuci" name="id_petugas_cuci" required="required">
                                            <option value="">-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="est_time_layout">
                                        <label for="est_time">Jumlah Tagihan : </label>
                                        <input readonly type="text" name="pembayaran_tagihan" id="pembayaran_tagihan" class="mask form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group" id="est_time_layout">
                                        <label for="est_time">Jumlah di Bayarkan : <span class="text-danger" id="notif_pembayaran"></span></label>
                                        <input type="text" name="pembayaran_dibayarkan" onkeyup="count()" id="pembayaran_dibayarkan" class="mask form-control" required="required" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="est_time_layout">
                                        <label for="est_time">Kembalian : </label>
                                        <input readonly type="text" name="pembayaran_kembalian" id="pembayaran_kembalian" class="mask form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group" id="">
                                        <label for="">Margin:</label>
                                        <input type="text" name="margin" id="margin" class="mask form-control" required="required" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="">
                                        <label for="">fee : </label>
                                        <input readonly type="text" name="fee" id="fee" class="mask form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="id_petugas_jemput_layout">
                            <div class="form-group">
                                <label for="status">Petugas Penjemputan</label>
                                <select type="text" class="form-control" id="id_petugas_jemput" name="id_petugas_jemput" required="required">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<!-- </div> -->

<div class="modal inmodal" id="pembayaran_modal" tabindex="-1" opd="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Konfirmasi Pembayaran</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="form_pembayaran" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_carwash" name="id_carwash">
                    <div class="form-group">
                        <label for="status">Metode Pembayaran</label>
                        <select type="text" class="form-control" id="pembayaran_metode" name="pembayaran_metode" required="required">
                            <option value="1">Cash</option>
                            <option value="2">Transfer</option>
                            <option value="2">Cashless</option>
                        </select>
                    </div>
                    <div class="form-group" id="est_time_layout">
                        <label for="est_time">Jumlah Tagihan : </label>
                        <input readonly type="text" name="pembayaran_tagihan" id="pembayaran_tagihan" class="mask form-control" />
                    </div>
                    <div class="form-group" id="est_time_layout">
                        <label for="est_time">Jumlah di Bayarkan : <span class="text-danger" id="notif_pembayaran"></span></label>
                        <input type="text" name="pembayaran_dibayarkan" onkeyup="count()" id="pembayaran_dibayarkan" class="mask form-control" />
                    </div>
                    <div class="form-group" id="est_time_layout">
                        <label for="est_time">Kembalian : </label>
                        <input readonly type="text" name="pembayaran_kembalian" id="pembayaran_kembalian" class="mask form-control" />
                    </div>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#menu_id_36').addClass('menu-item-active menu-item-open menu-item-here')
        $('#submenu_id_100').addClass('menu-item-active')

        var toolbar = {
            'form': $('#toolbar_form'),
            'status': $('#toolbar_form').find('#status'),
            'req_tanggal_end': $('#toolbar_form').find('#req_tanggal_end'),
            'req_tanggal_start': $('#toolbar_form').find('#req_tanggal_start'),
            'newBtn': $('#new_btn'),
        }

        $('.mask').mask('000.000.000.000.000', {
            reverse: true
        });

        var dataCarwash = [];
        var dataPetugas = [];
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [{
                    targets: [0, 1, 2],
                    className: 'dt-body-left'
                },

            ],
            responsive: true,
            deferRender: true,
            "order": [
                [4, "desc"]
            ]
        });

        var CarwashModal = {
            'self': $('#car_wash_modal'),
            'info': $('#car_wash_modal').find('.info'),
            'form': $('#car_wash_modal').find('#form_carwash'),
            'saveEditBtn': $('#car_wash_modal').find('#save_edit_btn'),
            'id_carwash': $('#car_wash_modal').find('#id_carwash'),
            'status': $('#car_wash_modal').find('#status'),
            'id_petugas_jemput': $('#car_wash_modal').find('#id_petugas_jemput'),
            'id_petugas_jemput_layout': $('#car_wash_modal').find('#id_petugas_jemput_layout'),
            'service_1': $('#car_wash_modal').find('#service_1'),
            'service_2': $('#car_wash_modal').find('#service_2'),
            'plat': $('#car_wash_modal').find('#plat'),
            'req_tanggal': $('#car_wash_modal').find('#req_tanggal'),
            'nama_pemesan': $('#car_wash_modal').find('#nama_pemesan'),
            'nama_driver': $('#car_wash_modal').find('#nama_driver'),
            'notelp': $('#car_wash_modal').find('#notelp'),
            // pay
            'id_petugas_cuci': $('#car_wash_modal').find('#id_petugas_cuci'),
            'pembayaran_metode': $('#car_wash_modal').find('#pembayaran_metode'),
            'pembayaran_tagihan': $('#car_wash_modal').find('#pembayaran_tagihan'),
            'pembayaran_dibayarkan': $('#car_wash_modal').find('#pembayaran_dibayarkan'),
            'pembayaran_kembalian': $('#car_wash_modal').find('#pembayaran_kembalian'),
            'margin': $('#car_wash_modal').find('#margin'),
            'fee': $('#car_wash_modal').find('#fee'),
            // endpay
            'est_time': $('#car_wash_modal').find('#est_time'),
            'est_time_layout': $('#car_wash_modal').find('#est_time_layout'),
        }


        var PembayaranModal = {
            'self': $('#pembayaran_modal'),
            'info': $('#pembayaran_modal').find('.info'),
            'form': $('#pembayaran_modal').find('#form_pembayaran'),
            'saveEditBtn': $('#pembayaran_modal').find('#save_edit_btn'),
            'id_carwash': $('#pembayaran_modal').find('#id_carwash'),
            'pembayaran_metode': $('#pembayaran_modal').find('#pembayaran_metode'),
            'pembayaran_tagihan': $('#pembayaran_modal').find('#pembayaran_tagihan'),
            'pembayaran_dibayarkan': $('#pembayaran_modal').find('#pembayaran_dibayarkan'),
            'pembayaran_kembalian': $('#pembayaran_modal').find('#pembayaran_kembalian'),
            'notif_pembayaran': $('#pembayaran_modal').find('#notif_pembayaran'),

        }

        toolbar.newBtn.on('click', (e) => {
            CarwashModal.id_carwash.val('');
            CarwashModal.nama_jenis_dokumen.val('');
            CarwashModal.saveEditBtn.hide();
        });

        toolbar.status.on('change', () => {
            getAllList();
        });
        toolbar.req_tanggal_end.on('change', () => {
            getAllList();
        });
        toolbar.req_tanggal_start.on('change', () => {
            getAllList();
        });
        // var x = setInterval(function() {
        //     getAllList();
        // }, 3000);
        getAllService1();
        getAllService2();
        getPetugas()

        function getAllList() {
            return $.ajax({
                url: `<?php echo site_url('CarWash/getAll') ?>`,
                'type': 'GET',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataCarwash = json['data'];
                    renderTransaksi(dataCarwash);
                },
                error: function(e) {}
            });
        }

        function getPetugas() {
            return $.ajax({
                url: `<?php echo site_url('CarWash/getPetugas') ?>`,
                'type': 'GET',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataPetugas = json['data'];
                    renderPetugas(dataPetugas);
                    getAllList();
                },
                error: function(e) {}
            });
        }

        function getAllService1() {
            swal.fire({
                title: 'Loading PriceList...',
                allowOutsideClick: false
            });
            swal.showLoading();
            return $.ajax({
                url: `<?php echo base_url('MasterCarwash/getAllPriceList?by_id=true') ?>`,
                'type': 'GET',
                data: {},
                success: function(data) {
                    swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    renderSelectService1(data);
                },
                error: function(e) {}
            });
        }

        function renderSelectService1(data) {
            if (data == null || typeof data != "object") {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }

            Object.values(data).forEach((d) => {
                CarwashModal.service_1.append($('<option>', {
                    value: d['id_ref'],
                    text: d['label'] + ' :: ' + formatRupiah2(d['price'])
                }))
            });
        }


        function getAllService2() {
            swal.fire({
                title: 'Loading PriceList...',
                allowOutsideClick: false
            });
            swal.showLoading();
            return $.ajax({
                url: `<?php echo base_url('MasterCarwash/getAllPriceList2?by_id=true') ?>`,
                'type': 'GET',
                data: {},
                success: function(data) {
                    swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    renderSelectService2(data);
                },
                error: function(e) {}
            });
        }

        function renderSelectService2(data) {
            if (data == null || typeof data != "object") {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }
            Object.values(data).forEach((d) => {
                CarwashModal.service_2.append($('<option>', {
                    value: d['id_ref'],
                    text: d['label'] + ' :: ' + formatRupiah2(d['price'])
                }))
            });
        }

        function renderPetugas(data) {
            if (data == null || typeof data != "object") {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }
            var i = 0;

            Object.values(data).forEach((d) => {
                CarwashModal.id_petugas_jemput.append($('<option>', {
                    value: d['id_cw_petugas'],
                    text: d['nama_petugas']
                }))

                CarwashModal.id_petugas_cuci.append($('<option>', {
                    value: d['id_cw_petugas'],
                    text: d['nama_petugas']
                }))
            });


        }

        function renderTransaksi(data) {
            if (data == null || typeof data != "object") {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }
            var i = 0;
            message_custom = encodeURIComponent(`Halo ini admin IMA Carwash,\nkami menginformasikan bahwa : \n`)
            message_cancle = encodeURIComponent(`Halo ini admin IMA Carwash,\nkami menginformasikan bahwa pesanan anda hari ini tidak dapat diprosess dikarnakan \n \nKami Mohon agar dapat dimaklumi dan terimakasih sudah menggunakan layanan IMA Carwash, silahkan order lagi besok ya :) ..`)

            var renderData = [];
            Object.values(data).forEach((d) => {
                if (d['notelp'].substring(0, 2) == '08') {
                    console.log(d['notelp']);
                    d['notelp'] = '628' + d['notelp'].substring(2);
                } else if (d['notelp'].substring(0, 3) == '+62') {
                    console.log(d['notelp']);
                    d['notelp'] = '62' + d['notelp'].substring(3);
                }

                info = 'Nama Pemesan : ' + d['nama_pemesan'] +
                    '<br>No Telp : ' + d['notelp'] +
                    '<br>Nama Driver : ' + d['nama_driver'] +
                    '<br>Plat : ' + d['plat'] +
                    '<br>Waktu Entri : ' + d['reg_time'];
                var delButton = `<a  class="delete btn btn-danger" data-id='${d['id_carwash']}'><i class="fas fa-trash" aria-hidden="true"></i>Hapus</a>`;
                var editButton = `<a  class="edit btn btn-primary" data-id='${d['id_carwash']}'><i class="fas fa-pencil-alt" aria-hidden="true"></i>Edit Data</a>`;
                var pembayaranButton = `<a  class="konfirmasi_bayar btn btn-warning btn-sm" data-id='${d['id_carwash']}'><i class="fa fa-money-bill" aria-hidden="true"></i>Pembayaran</a>`;
                // var mapsButton = `<a href="https://www.google.com/maps/dir/?api=1&destination=${d['latitude']},${d['longitude']}" target="_blank" class="btn btn-secondary btn-sm" data-id='${d['id_carwash']}'><i class="fa fa-map" aria-hidden="true"></i>Maps</a>`;
                var deleteButton = `<a class="delete danger btn-sm" data-id='${d['id_carwash']}'><i class='fa fa-trash text-danger'></i></a>`;
                message1 = encodeURIComponent(`Halo ini admin IMA Carwash,\nkami menginformasikan bahwa status pesanan anda sudah dijadwalkan pada jam ${d['est_time']}`)
                var wa1 = `<a class="" href="https://api.whatsapp.com/send?phone=${d['notelp']}&text=${message1}"'><i class='fa fa-whatsapp text-danger mr-5'></i> Send </a>`;
                var wa2 = '';
                // if (d['service_2'] == 2 && d['id_petugas_jemput'] != null) {
                //     messagemaps = 'Silahkan melakukan penjemputkan dengan \nNama Pemesan : ' + d['nama_pemesan'] +
                //         '\nNama Driver : ' + d['nama_driver'] +
                //         '\nPlat : ' + d['plat'] +
                //         '\nTelp : ' + d['notelp'] +
                //         '\nNo Antrian : ' + d['nomor_antrian'] +
                //         `\nLokasi : https://www.google.com/maps/dir/?api=1&destination=${d['latitude']},${d['longitude']}`;

                //     console.log(send_wa(dataPetugas[d['id_petugas_jemput']]['no_wa'], messagemaps));
                //     wa2 = `<a class="dropdown-item" href="${send_wa(dataPetugas[d['id_petugas_jemput']]['no_wa'],messagemaps)}">ke Petugas</a>`;
                // }
                // console.log(dataPetugas[d['id_petugas_jemput']]);
                whatsapp = `<div class="btn-group">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class='fa fa-phone'></i> Kirim Pesan
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="https://api.whatsapp.com/send?phone=${d['notelp']}&text=${message_custom}" target="_blank"> Custom  </a>     
                                                                            <a class="dropdown-item" href="https://api.whatsapp.com/send?phone=${d['notelp']}&text=${message1}" target="_blank"> Informasi Jadwal  </a>     
                                                                            <a class="dropdown-item" href="https://api.whatsapp.com/send?phone=${d['notelp']}&text=${message_cancle}" target="_blank"> Informasi Pembatalan  </a>     
                                                                            ${wa2}
                                                                            </div>
                                                                    </div>`;
                var button = `
                                <div class="btn-group-vertical" role="group" aria-label="">
                                    ${editButton}
                                    ${delButton}
                                    ${pembayaranButton}
                                    ${whatsapp}
                                </div>`;

                infopembayaran = `
                                        <div class="clearfix">
                                            <div class="pull-left text-left">1. ${d['s1_label']}</div>
                                            <div class="pull-right">${number_format(d['s1_price'])}</div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left text-left">2. ${d['s2_label']}</div>
                                            <div class="pull-right">${number_format(d['s2_price'])}</div>
                                        </div>
                                        <hr>
                                        <div class="clearfix">
                                            <div class="pull-left text-left"><b>Total</b></div>
                                            <div class="pull-right">${number_format(parseInt( d['s2_price'])+parseInt(d['s1_price']))}</div>
                                      </div>
                                        <div class="clearfix">
                                            <div class="pull-left text-left"><b>Diterima</b></div>
                                            <div class="pull-right">${number_format(d['pembayaran_dibayarkan'])}</div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="pull-left text-left"><b>Kembalian</b></div>
                                            <div class="pull-right">${number_format(d['pembayaran_kembalian'])}</div>
                                        </div>

                                        `;

                infomargin = `
                                      <div class="clearfix">
                                          <div class="pull-left text-left"><b>Margin</b></div>
                                          <div class="pull-right">${number_format(d['margin'])}</div>
                                      </div>
                                      <div class="clearfix">
                                          <div class="pull-left text-left"><b>Fee</b></div>
                                          <div class="pull-right">${number_format(d['fee'])}</div>
                                      </div>
                                      `;
                filePembayaran = '';
                if (d['pembayaran_file'] != '') {
                    filePembayaran = `
                    <br>
                    <div class="clearfix">
                                            <div class="pull-left text-left"><b>refensi : </b></div>
                                            <div class="pull-right">${d['pembayaran_ref']}</div>
                                        </div>
                                        <a class="btn btn-info" href='http://indometalasia.com/store/uploads/file_pembayaran/${d['pembayaran_file']}'>Lihat Bukti Pembayaran</a>`
                }
                renderData.push([
                    d['req_tanggal'],
                    d['est_time'],
                    info,
                    infopembayaran,
                    number_format(d['margin']),
                    number_format(d['fee']),
                    // d['nomor_antrian'],
                    d['nama_petugas_cuci'],
                    d['nama_petugas'],
                    statusAntrian(d['status']), statusPembayaran(d['status_pembayaran']) + filePembayaran,
                    button
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function statusAntrian(status) {
            if (status == "1")
                return `<i class='fa fa-edit text-warning'> Menunggu dijadwalkan petugas</i>`;
            else if (status == "2")
                return `<i class='fa fa-hourglass-start text-primary'> Sudah dijadwalkan</i>`;
            else if (status == "3")
                return `<i class='fa fa-hourglass-start text-success'> Sedang di Cuci</i>`;
            else if (status == "4")
                return `<i class='fa fa-check text-success'> Selesai </i>`;
            else if (status == "5")
                return `<i class='fa fa-times text-danger'> Di Batalkan</i>`;
        }

        function statusPembayaran(status) {
            if (status == "1")
                return `<i class='fa fa-edit text-danger'> Belum bayar</i>`;
            else if (status == "2")
                return `<i class='fa fa-hourglass-start text-primary'> Pembayaran menunggu konfirmasi petugas</i>`;
            else if (status == "5")
                return `<i class='fa fa-check text-success'> Sudah bayar </i>`;
        }
        var Loading = {
            title: 'Loading',
            // html: 'Yakin simpan data? .. ', // add html attribute if you want or remove
            showConfirmButton: false,
            // confirmButtonText: "Ya Simpan!",

            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        }

        // CarwashModal.status.on('change', () => {
        //     if (CarwashModal.status.val() == 2) {
        //         CarwashModal.est_time.prop('disabled', false);
        //         CarwashModal.est_time_layout.prop('hidden', false);
        //     } else {
        //         CarwashModal.est_time.prop('disabled', true);
        //         CarwashModal.est_time_layout.prop('hidden', true);
        //     }
        // });

        CarwashModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= site_url('MasterCarWash/edit') ?>";
            Swal.fire({
                title: 'Konfirmasi',
                html: 'Yakin simpan data? .. ', // add html attribute if you want or remove
                showCancelButton: true,
                confirmButtonText: "Ya Simpan!",
                allowOutsideClick: false,
            }).then(function(result) {
                if (!result.value) {
                    // console.log('false')
                    return;
                }
                Swal.fire(Loading)
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: CarwashModal.form.serialize(),
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire({
                                title: 'Gagal',
                                icon: 'error',
                                html: json['message'], // add html attribute if you want or remove
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: "Ok!",
                                allowOutsideClick: true,
                            })
                            return;
                        }
                        var data = json['data']
                        dataCarwash[data['id_carwash']] = data;
                        renderTransaksi(dataCarwash);
                        CarwashModal.self.modal('hide');
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            html: '', // add html attribute if you want or remove
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "Ok!",
                            allowOutsideClick: true,
                        })
                    },
                    error: function(e) {}
                });
            });
        });

        PembayaranModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= site_url('CarWash/pembayaran_process') ?>";

            Swal.fire({
                title: 'Konfirmasi',
                html: 'Yakin simpan data? .. ', // add html attribute if you want or remove
                showCancelButton: true,
                confirmButtonText: "Ya Simpan!",
                allowOutsideClick: false,
            }).then(function(result) {
                if (!result.value) {
                    // console.log('false')
                    return;
                }
                Swal.fire(Loading)
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: PembayaranModal.form.serialize(),
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire({
                                title: 'Gagal',
                                icon: 'error',
                                html: json['message'], // add html attribute if you want or remove
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: "Ok!",
                                allowOutsideClick: true,
                            })
                            return;
                        }
                        var data = json['data']
                        dataCarwash[data['id_carwash']] = data;
                        renderTransaksi(dataCarwash);
                        PembayaranModal.self.modal('hide');
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            html: '', // add html attribute if you want or remove
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "Ok!",
                            allowOutsideClick: true,
                        })
                    },
                    error: function(e) {}
                });
            });
        });

        FDataTable.on('click', '.edit', function() {
            CarwashModal.self.modal('show');
            CarwashModal.saveEditBtn.show();
            var currentData = dataCarwash[$(this).data('id')];
            console.log(currentData)
            CarwashModal.id_carwash.val(currentData['id_carwash']);
            CarwashModal.status.val(currentData['status']);
            CarwashModal.req_tanggal.val(currentData['req_tanggal']);
            CarwashModal.est_time.val(currentData['est_time']);
            CarwashModal.nama_driver.val(currentData['nama_driver']);
            CarwashModal.nama_pemesan.val(currentData['nama_pemesan']);
            CarwashModal.service_1.val(currentData['service_1']);
            CarwashModal.service_2.val(currentData['service_2']);
            CarwashModal.notelp.val(currentData['notelp']);
            CarwashModal.id_petugas_cuci.val(currentData['id_petugas_cuci']);
            CarwashModal.plat.val(currentData['plat']);
            CarwashModal.pembayaran_metode.val(currentData['pembayaran_metode']);
            CarwashModal.pembayaran_tagihan.val(currentData['pembayaran_tagihan']);
            CarwashModal.pembayaran_dibayarkan.val(currentData['pembayaran_dibayarkan']);
            CarwashModal.pembayaran_kembalian.val(currentData['pembayaran_kembalian']);
            CarwashModal.margin.val(currentData['margin']);
            CarwashModal.fee.val(currentData['fee']);
            if (currentData['service_2'] == 2) {
                CarwashModal.id_petugas_jemput_layout.prop('hidden', false);
                CarwashModal.id_petugas_jemput.prop('disabled', false);
                CarwashModal.id_petugas_jemput.val(currentData['id_petugas_jemput'])
            } else {
                CarwashModal.id_petugas_jemput_layout.prop('hidden', true);
                CarwashModal.id_petugas_jemput.prop('disabled', true);

            }
        });

        FDataTable.on('click', '.konfirmasi_bayar', function() {
            PembayaranModal.pembayaran_dibayarkan.trigger('onkeyup');
            PembayaranModal.self.modal('show');
            PembayaranModal.saveEditBtn.show();
            var currentData = dataCarwash[$(this).data('id')];
            PembayaranModal.id_carwash.val(currentData['id_carwash']);
            console.log(currentData['s1_price'] + currentData['s2_price'])
            PembayaranModal.pembayaran_tagihan.val(number_format(Number(currentData['s1_price']) + Number(currentData['s2_price'])));
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                html: 'Yakin menghapus data ini? .. ', // add html attribute if you want or remove
                showCancelButton: true,
                confirmButtonText: "Ya Hapus!",
                allowOutsideClick: false,
            }).then((result) => {
                Swal.fire(Loading)

                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('MasterCarwash/Delete') ?>",
                    'type': 'get',
                    data: {
                        'id_carwash': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire({
                                title: 'Gagal',
                                icon: 'error',
                                html: json['message'], // add html attribute if you want or remove
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: "Ok!",
                                allowOutsideClick: true,
                            });
                            return;
                        }
                        delete dataCarwash[id];
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            html: 'data berhasil dihapus', // add html attribute if you want or remove
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "Ok!",
                            allowOutsideClick: true,
                        });
                        renderTransaksi(dataCarwash);
                    },
                    error: function(e) {}
                });
            });
        });


    });

    function count() {
        console.log('count');
        console.log($('#pembayaran_tagihan').val().replace(/\D/g, ''));
        console.log($('#pembayaran_dibayarkan').val().replace(/\D/g, ''));
        kembalian = Number($('#pembayaran_dibayarkan').val().replace(/\D/g, '')) - Number($('#pembayaran_tagihan').val().replace(/\D/g, ''));
        console.log(kembalian);
        if (kembalian >= 0) {
            $('#notif_pembayaran').html('');
            $('#pembayaran_modal').find('#save_edit_btn').prop('disabled', false)
            $('#pembayaran_kembalian').val(number_format(kembalian))
        } else {
            $('#pembayaran_modal').find('#save_edit_btn').prop('disabled', true)

            $('#notif_pembayaran').html('*nominal kurang');
            $('#pembayaran_kembalian').val(0);
        }
    }
</script>