<div class="card card-custom">
    <div class="card-body">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <!-- <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <input type="hidden" id="is_not_self" name="is_not_self" value="1">
                    <select class="form-control mr-sm-2" name="id_jenis_perusahaan" id="id_jenis_perusahaan"></select>
                    <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn"><i class="fas fa-plus"></i> Tambah Dokumen</button>
                </form> -->
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
                                        <th style="text-align:center!important">Tanggal </th>
                                        <th style="text-align:center!important">Agent Name</th>
                                        <th style="text-align:center!important">Deskripsi</th>
                                        <th style="text-align:center!important">Status</th>
                                        <th style="text-align:center!important">Action</th>
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

        function html_status(status) {
            if (status == 0) return '<span class="label label-lg label-light-danger label-inline">Not Complete</span>';
            if (status == 1) return '<span class="label label-lg label-light-success label-inline">Complete</span>';
        }

        toolbar.newBtn.on('click', (e) => {
            resetForm();
            DokumenPerusahaanModal.self.modal('show');
            DokumenPerusahaanModal.addBtn.show();
            DokumenPerusahaanModal.saveEditBtn.hide();
        });


        getAllDokumen();

        function getAllDokumen() {
            return $.ajax({
                url: `<?php echo site_url('user/getNotification/') ?>`,
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

        function renderDokumen(data) {
            if (data == null) {
                console.log("Jenis Dokumen::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {
                var show = `
                    <a class="btn btn-primary" href='<?= base_url() ?>${d['notification_url']}'><i class='far fa-eye text-info mr-1'></i>  Lihat </a>
                `;
                renderData.push([d['date_notification'], d['agent_name'], d['deskripsi'], html_status(d['status']), show]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }
    });
</script>