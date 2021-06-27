<div class="card card-custom">
    <div class="card-body">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                    <select hidden class="form-control mr-sm-2" name="id_jenis_perusahaan" id="id_jenis_perusahaan"></select>
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
                                        <th style="width: 24%; text-align:center!important">Nama Jenis Dokumen</th>
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
                <h4 class="modal-title">Kelola DokumenPerusahaan</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="jenis_dokumen_perusahaan_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_jenis_dokumen" name="id_jenis_dokumen">
                    <div class="form-group">
                        <label for="nama_jenis_dokumen">Nama Dokumen</label>
                        <input type="text" placeholder="Nama Dokumen" class="form-control" id="nama_jenis_dokumen" name="nama_jenis_dokumen" required="required">
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
            'id_jenis_perusahaan': $('#toolbar_form').find('#id_jenis_perusahaan'),
            'id_opd': $('#toolbar_form').find('#id_opd'),
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
            'form': $('#jenis_dokumen_modal').find('#jenis_dokumen_perusahaan_form'),
            'addBtn': $('#jenis_dokumen_modal').find('#add_btn'),
            'saveEditBtn': $('#jenis_dokumen_modal').find('#save_edit_btn'),
            'id_jenis_dokumen': $('#jenis_dokumen_modal').find('#id_jenis_dokumen'),
            'nama_jenis_dokumen': $('#jenis_dokumen_modal').find('#nama_jenis_dokumen'),
        }

        toolbar.newBtn.on('click', (e) => {
            // resetDokumenPerusahaanModal();
            DokumenPerusahaanModal.id_jenis_dokumen.val('');
            DokumenPerusahaanModal.nama_jenis_dokumen.val('');
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
            Object.values(data).forEach((jenis_dokumen_perusahaan) => {
                var editButton = `
        <a class="edit " data-id='${jenis_dokumen_perusahaan['id_jenis_dokumen']}'><i class='fas fa-pencil-alt text-primary mr-5'></i>  </a>
      `;
                var deleteButton = `
        <a class="delete danger" data-id='${jenis_dokumen_perusahaan['id_jenis_dokumen']}'><i class='fa fa-trash text-danger mr-5'></i>  </a>
      `;
                var button = `
         ${editButton}
            ${deleteButton}
          
      `;
                renderData.push([jenis_dokumen_perusahaan['id_jenis_dokumen'], jenis_dokumen_perusahaan['nama_jenis_dokumen'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
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
            var url = "<?= site_url('Administration/') ?>";
            url += isAdd ? "addJenisDokumen" : "editJenisDokumen";
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
                    console.log('false')
                    return;
                }
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
                        JenisDokumen[data['id_jenis_dokumen']] = data;
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
            DokumenPerusahaanModal.id_jenis_dokumen.val(currentData['id_jenis_dokumen']);
            DokumenPerusahaanModal.nama_jenis_dokumen.val(currentData['nama_jenis_dokumen']);
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
                    url: "<?= site_url('Administration/deleteJenisDokumen') ?>",
                    'type': 'POST',
                    data: {
                        'id_jenis_dokumen': id
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