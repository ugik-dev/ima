<div class="card card-custom">
    <div class="card-body">
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
<script>
    $(document).ready(function() {
        $('#menu_id_31').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_84').addClass('menu-item-active')

        var dataDokumen = [];
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });



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
                renderData.push([d['id_dokumen'], d['nama_dokumen'], d['nama_jenis_dokumen'], masa, d['last_update'], show]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');


        }


    });
</script>