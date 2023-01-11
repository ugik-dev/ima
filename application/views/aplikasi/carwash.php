<div class="card card-custom">
    <div class="card-body">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <input class="form-control mr-sm-2" type="date" name="req_time_start" id="req_time_start" value="<?= date('Y-m-d') ?>">
                    <input class="form-control mr-sm-2" type="date" name="req_time_end" id="req_time_end" value="<?= date('Y-m-d') ?>">
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
                                        <th style="width: 7%; text-align:center!important">Waktu Request (Client)</th>
                                        <th style="width: 7%; text-align:center!important">Waktu Perkiraan (Petugas)</th>
                                        <th style="width: 24%; text-align:left!important">Info Pemesanan</th>
                                        <th style="width: 24%; text-align:left!important">Plat</th>
                                        <th style="width: 24%; text-align:left!important">Antrian</th>
                                        <th style="width: 24%; text-align:left!important">Layanan</th>
                                        <th style="width: 24%; text-align:left!important">Petugas</th>
                                        <th style="width: 24%; text-align:left!important">Status</th>
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
<div class="modal inmodal" id="jenis_dokumen_modal" tabindex="-1" opd="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Aksi</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="form_petugas_carwash" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_carwash" name="id_carwash">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select type="text" class="form-control" id="status" name="status" required="required">

                            <option value="1">Belum Check-in</option>
                            <option value="2">Dalam Antrian</option>
                            <option value="3">Sedang di Cuci</option>
                            <option value="4">Selesai</option>
                            <option value="5">Di Batalkan</option>
                        </select>
                    </div>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Data</strong></button>
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
        $('#menu_id_31').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_85').addClass('menu-item-active')

        var toolbar = {
            'form': $('#toolbar_form'),
            'status': $('#toolbar_form').find('#status'),
            'req_time_end': $('#toolbar_form').find('#req_time_end'),
            'req_time_start': $('#toolbar_form').find('#req_time_start'),
            'newBtn': $('#new_btn'),
        }
        var JenisDokumen = [];
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var DokumenPerusahaanModal = {
            'self': $('#jenis_dokumen_modal'),
            'info': $('#jenis_dokumen_modal').find('.info'),
            'form': $('#jenis_dokumen_modal').find('#form_petugas_carwash'),
            'addBtn': $('#jenis_dokumen_modal').find('#add_btn'),
            'saveEditBtn': $('#jenis_dokumen_modal').find('#save_edit_btn'),
            'id_carwash': $('#jenis_dokumen_modal').find('#id_carwash'),
            'status': $('#jenis_dokumen_modal').find('#status'),
        }

        toolbar.newBtn.on('click', (e) => {
            // resetDokumenPerusahaanModal();
            DokumenPerusahaanModal.id_carwash.val('');
            DokumenPerusahaanModal.nama_jenis_dokumen.val('');
            DokumenPerusahaanModal.self.modal('show');
            DokumenPerusahaanModal.addBtn.show();
            DokumenPerusahaanModal.saveEditBtn.hide();
        });

        toolbar.status.on('change', () => {
            getAllList();
        });
        toolbar.req_time_end.on('change', () => {
            getAllList();
        });
        toolbar.req_time_start.on('change', () => {
            getAllList();
        });
        getAllList();
        var x = setInterval(function() {
            getAllList();

        }, 2000);

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
                    JenisDokumen = json['data'];
                    renderJenisDokumen(JenisDokumen);
                },
                error: function(e) {}
            });
        }

        function renderJenisDokumen(data) {
            if (data == null || typeof data != "object") {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {
                var editButton = `
        <a class="edit " data-id='${d['id_carwash']}'><i class='fas fa-pencil-alt text-primary mr-5'></i>  </a>
      `;
                var deleteButton = `
        <a class="delete danger" data-id='${d['id_carwash']}'><i class='fa fa-trash text-danger mr-5'></i>  </a>
      `;
                var button = `
         ${editButton}
            ${deleteButton}
          
      `;
                renderData.push([
                    d['reg_time'],
                    d['req_time'],
                    'Nama Pemesan : ' + d['nama'] +
                    '<br>Nama Driver : ' + d['nama_driver'] + '<br>Telp : ' + d['no_telp'] + '<br>Email : ' + d['email'] + '<br>Alamat : ' + d['alamat'],
                    d['plat'],
                    d['nomor_antrian'],
                    d['s1_label'],
                    d['nama_petugas'],
                    statusAntrian(d['status']),
                    button
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function statusAntrian(status) {
            if (status == "1")
                return `<i class='fa fa-edit text-warning'> Belum Check-in</i>`;
            else if (status == "2")
                return `<i class='fa fa-hourglass-start text-primary'> Sedang Dalam Antrian</i>`;
            else if (status == "3")
                return `<i class='fa fa-hourglass-start text-success'> Sedang di Cuci</i>`;
            else if (status == "4")
                return `<i class='fa fa-check text-success'> Selesai </i>`;
            return `<i class='fa fa-times text-danger'> Di Batalkan</i>`;
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

        DokumenPerusahaanModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = DokumenPerusahaanModal.addBtn.is(':visible');
            var url = "<?= site_url('CarWash/') ?>";
            url += isAdd ? "add" : "edit";
            var button = isAdd ? DokumenPerusahaanModal.addBtn : DokumenPerusahaanModal.saveEditBtn;

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
                    data: DokumenPerusahaanModal.form.serialize(),
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
                        JenisDokumen[data['id_carwash']] = data;
                        renderJenisDokumen(JenisDokumen);
                        DokumenPerusahaanModal.self.modal('hide');
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
            DokumenPerusahaanModal.self.modal('show');
            DokumenPerusahaanModal.addBtn.hide();
            DokumenPerusahaanModal.saveEditBtn.show();
            var currentData = JenisDokumen[$(this).data('id')];
            DokumenPerusahaanModal.id_carwash.val(currentData['id_carwash']);
            DokumenPerusahaanModal.status.val(currentData['status']);
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
                    url: "<?= site_url('CarWash/getAll') ?>",
                    'type': 'get',
                    data: {
                        // 'id_carwash': id
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
                        delete JenisDokumen[id];
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            html: 'data berhasil dihapus', // add html attribute if you want or remove
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "Ok!",
                            allowOutsideClick: true,
                        });
                        renderJenisDokumen(JenisDokumen);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>