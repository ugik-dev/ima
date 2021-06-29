<div class="card card-custom">
    <div class="card-body">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                    <select class="form-control mr-sm-2" name="id_jenis_perusahaan" id="id_jenis_perusahaan"></select>
                    <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn"><i class="fas fa-plus"></i> Tambah Jenis Dokumen</button>
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
                                        <th style="width: 7%; text-align:center!important">ID</th>
                                        <th style="width: 24%; text-align:center!important">Nama Dokumen</th>
                                        <th style="width: 24%; text-align:center!important">Jenis Dokumen</th>
                                        <th style="width: 24%; text-align:center!important">Masa Aktif </th>
                                        <th style="width: 24%; text-align:center!important">Last Update </th>
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
                <h4 class="modal-title">Kelola Dokumen</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="dokumen_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_dokumen" name="id_dokumen">
                    <div class="form-group">
                        <label for="nama_dokumen">Nama Dokumen</label>
                        <input type="text" placeholder="Nama Dokumen" class="form-control" id="nama_dokumen" name="nama_dokumen" required="required">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="id_jenis_dokumen">Jenis Dokumen</label>
                            <select type="text" placeholder="Jenis Dokumen" class="form-control" id="id_jenis_dokumen" name="id_jenis_dokumen" required="required">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="id_jenis_dokumen">Mulai Masa Aktif</label>
                            <input type="date" placeholder="Nama Dokumen" class="form-control" id="date_start" name="date_start">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="id_jenis_dokumen">Akhir Masa Aktif</label>
                            <input type="date" placeholder="Nama Dokumen" class="form-control" id="date_end" name="date_end">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Notifikasi</label>
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" value="0" id="notif_disable" name="notification" required="required" />
                                        <span></span>
                                        Matikan
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="30" id="notif_1bulan" name="notification" />
                                        <span></span>
                                        Hidupkan <small> (30 hari sebelum)</small>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="14" id="notif_2minggu" name="notification" />
                                        <span></span>
                                        Hidupkan <small> (14 hari sebelum)</small>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="7" id="notif_1minggu" name="notification" />
                                        <span></span>
                                        Hidupkan <small> (7 hari sebelum)</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Keterangan / Deskripsi</label>
                                <textarea rows="3" placeholder="" class="form-control" id="deskripsi" name="deskripsi"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_jenis_dokumen">File</label>
                        <p class="no-margins"><span id="file_dokumen">-</span></p>

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
        $('#submenu_id_84').addClass('menu-item-active')

        var toolbar = {
            'form': $('#toolbar_form'),
            'id_jenis_perusahaan': $('#toolbar_form').find('#id_jenis_perusahaan'),
            'id_opd': $('#toolbar_form').find('#id_opd'),
            'newBtn': $('#new_btn'),
        }
        var dataDokumen = [];
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
            'form': $('#jenis_dokumen_modal').find('#dokumen_form'),
            'addBtn': $('#jenis_dokumen_modal').find('#add_btn'),
            'saveEditBtn': $('#jenis_dokumen_modal').find('#save_edit_btn'),
            'id_dokumen': $('#jenis_dokumen_modal').find('#id_dokumen'),
            'id_jenis_dokumen': $('#jenis_dokumen_modal').find('#id_jenis_dokumen'),
            'date_start': $('#jenis_dokumen_modal').find('#date_start'),
            'date_end': $('#jenis_dokumen_modal').find('#date_end'),
            'deskripsi': $('#jenis_dokumen_modal').find('#deskripsi'),
            'nama_dokumen': $('#jenis_dokumen_modal').find('#nama_dokumen'),
            'notif_disable': $('#jenis_dokumen_modal').find('#notif_disable'),
            'notif_1bulan': $('#jenis_dokumen_modal').find('#notif_1bulan'),
            'notif_1minggu': $('#jenis_dokumen_modal').find('#notif_1minggu'),
            'notif_2minggu': $('#jenis_dokumen_modal').find('#notif_2minggu'),
            'file_dokumen': new FileUploader($('#jenis_dokumen_modal').find('#file_dokumen'), "", "file_dokumen", ".xls ,.docx , .doc, .png , .jpeg , .jpg , .pdf", false, false),

        }

        toolbar.newBtn.on('click', (e) => {
            resetForm();
            DokumenPerusahaanModal.self.modal('show');
            DokumenPerusahaanModal.addBtn.show();
            DokumenPerusahaanModal.saveEditBtn.hide();
        });

        getAllJenisDokumen();

        function getAllJenisDokumen() {
            return $.ajax({
                url: `<?php echo site_url('Administration/getJenisDokumen/') ?>`,
                'type': 'GET',
                data: {},
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    jenisDokumen = json['data'];
                    renderJenisDokumen(jenisDokumen);
                },
                error: function(e) {}
            });
        }


        getAllDokumen();

        function getAllDokumen() {
            return $.ajax({
                url: `<?php echo site_url('Administration/getDokumen/') ?>`,
                'type': 'GET',
                data: {},
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataDokumen = json['data'];
                    renderDokumen(dataDokumen);
                },
                error: function(e) {}
            });
        }

        function renderJenisDokumen(data) {
            DokumenPerusahaanModal.id_jenis_dokumen.append($('<option>', {
                value: "",
                text: "-- Pilih Jenis Dokumen --"
            }));
            Object.values(data).forEach((d) => {
                DokumenPerusahaanModal.id_jenis_dokumen.append($('<option>', {
                    value: d['id_jenis_dokumen'],
                    text: d['nama_jenis_dokumen']
                }));
            })
        }

        function renderDokumen(data) {
            if (data == null || typeof data != "object") {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {
                var show = `
                    <a class="primary dropdown-item" href='<?= base_url() ?>Administration/document/${d['id_dokumen']}'><i class='far fa-eye text-info mr-1'></i>  Lihat </a>
                `;
                var editButton = `
                    <a class="edit dropdown-item primary" data-id='${d['id_dokumen']}'><i class='fas fa-pencil-alt text-primary mr-1'></i>  Edit </a>
                `;
                var deleteButton = `
                        <a class="delete danger dropdown-item" data-id='${d['id_dokumen']}'><i class='fa fa-trash text-danger mr-1'></i>  Hapus </a>
                    `;
                var button = `
                        <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div id="action_table" class="action_table dropdown-menu" aria-labelledby="dropdownMenuButton">
                    ${show}
                    ${editButton}
                      ${deleteButton}</div></div>                `;
                var masa = `Dari : ${d['date_start']} ${(d['date_end'] ? '<br>Sampai : '+d['date_end'] : '' ) }`
                renderData.push([d['id_dokumen'], d['nama_dokumen'], d['nama_jenis_dokumen'], masa, d['last_update'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');


            $('.action_table').on('click', '.edit', function() {
                resetForm();
                DokumenPerusahaanModal.self.modal('show');
                DokumenPerusahaanModal.addBtn.hide();
                DokumenPerusahaanModal.saveEditBtn.show();
                var currentData = dataDokumen[$(this).data('id')];
                console.log(currentData)
                DokumenPerusahaanModal.id_jenis_dokumen.val(currentData['id_jenis_dokumen']);
                DokumenPerusahaanModal.id_dokumen.val(currentData['id_dokumen']);
                DokumenPerusahaanModal.nama_dokumen.val(currentData['nama_dokumen']);
                DokumenPerusahaanModal.date_start.val(currentData['date_start']);
                DokumenPerusahaanModal.date_end.val(currentData['date_end']);
                DokumenPerusahaanModal.deskripsi.val(currentData['deskripsi']);
                // DokumenPerusahaanModal.notif_1bulan.checked = true
                currentData['notification'] == '30' ? document.getElementById("notif_1bulan").checked = true : '';
                currentData['notification'] == '14' ? document.getElementById("notif_2minggu").checked = true : '';
                currentData['notification'] == '7' ? document.getElementById("notif_1minggu").checked = true : '';
                currentData['notification'] == '0' ? document.getElementById("notif_disable").checked = true : '';
            })
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

        function resetForm() {
            DokumenPerusahaanModal.id_jenis_dokumen.val('');
            DokumenPerusahaanModal.nama_dokumen.val('');
            DokumenPerusahaanModal.date_start.val('');
            DokumenPerusahaanModal.date_end.val('');
            DokumenPerusahaanModal.deskripsi.val('');
            document.getElementById("notif_1bulan").checked = false;
            document.getElementById("notif_2minggu").checked = false;
            document.getElementById("notif_1minggu").checked = false;
            document.getElementById("notif_disable").checked = false;
            DokumenPerusahaanModal.file_dokumen.resetState();
        }

        DokumenPerusahaanModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = DokumenPerusahaanModal.addBtn.is(':visible');
            var url = "<?= site_url('Administration/') ?>";
            url += isAdd ? "addDokumen" : "editDokumen";
            var button = isAdd ? DokumenPerusahaanModal.addBtn : DokumenPerusahaanModal.saveEditBtn;

            Swal.fire({
                title: 'Konfirmasi',
                html: 'Yakin simpan data? .. ', // add html attribute if you want or remove
                showCancelButton: true,
                confirmButtonText: "Ya Simpan!",
                allowOutsideClick: false,
            }).then(function(result) {
                Swal.fire(Loading)
                if (!result.value) {
                    console.log('cancel')
                    return;
                }
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(DokumenPerusahaanModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log('sb')
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
                        dataDokumen[data['id_dokumen']] = data;
                        renderDokumen(dataDokumen);
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

        $('.action_table').on('click', function() {
            console.log('as');
        })
        FDataTable.on('click', '.edit', function() {
            resetForm();
            DokumenPerusahaanModal.self.modal('show');
            DokumenPerusahaanModal.addBtn.hide();
            DokumenPerusahaanModal.saveEditBtn.show();
            var currentData = dataDokumen[$(this).data('id')];
            console.log(currentData)
            DokumenPerusahaanModal.id_jenis_dokumen.val(currentData['id_jenis_dokumen']);
            DokumenPerusahaanModal.id_dokumen.val(currentData['id_dokumen']);
            DokumenPerusahaanModal.nama_dokumen.val(currentData['nama_dokumen']);
            DokumenPerusahaanModal.date_start.val(currentData['date_start']);
            DokumenPerusahaanModal.date_end.val(currentData['date_end']);
            DokumenPerusahaanModal.deskripsi.val(currentData['deskripsi']);
            // DokumenPerusahaanModal.notif_1bulan.checked = true
            currentData['notification'] == '1bulan' ? document.getElementById("notif_1bulan").checked = true : '';
            currentData['notification'] == 'disable' ? document.getElementById("notif_disable").checked = true : '';

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
                    url: "<?= site_url('Administration/deleteDokumen') ?>",
                    'type': 'POST',
                    data: {
                        'id_dokumen': id
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
                        delete dataDokumen[id];
                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            html: 'data berhasil dihapus', // add html attribute if you want or remove
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "Ok!",
                            allowOutsideClick: true,
                        });
                        renderDokumen(dataDokumen);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>