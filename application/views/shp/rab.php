<div class="card card-custom">
    <div class="card-body">
        <div class="ibox">
            <div class="ibox-content">
                <a class="btn btn-primary mb-5" href="<?= base_url('shp/add_rab') ?>"><i class="fa fa-plus"></i>Tambah RAB Baru</a>
                <div class="col-lg-12">

                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%; text-align:center!important">ID</th>
                                    <th style="width: 24%; text-align:center!important">Tanggal</th>
                                    <th style="width: 24%; text-align:center!important">Agent</th>
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
<script>
    $(document).ready(function() {
        $('#menu_id_34').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_95').addClass('menu-item-active')

        var dataDokumen = [];
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [1, "desc"]
            ]
        });



        getAllDokumen();

        function getAllDokumen() {
            return $.ajax({
                url: `<?php echo site_url('General/serachRab/') ?>`,
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
                    <a class="primary dropdown-item" href='<?= base_url() ?>shp/rab_show/${d['id_rab']}'><i class='far fa-eye text-info mr-1'></i>  Lihat </a>
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
                renderData.push([d['id_rab'], d['date_rab'], d['id_agent'], show]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');


        }


    });
</script>