<div class="card card-custom" id="print-section">
    <div class="card-body">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" class="btn btn-primary" id="add_new_data_btn" data-toggle="modal" data-target="#exampleModalLong">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Buat Baru
                </button>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>Tutup Buku </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="accounts_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form opd="form" id="accounts_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Rekap</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?php
                        $data = array('type' => 'hidden', 'name' => 'id_carwash_close', 'id' => 'id_carwash_close', 'placeholder' => '');
                        echo form_input($data);
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg6">
                            <label>Dari Tanggal</label>
                            <input class="form-control" id="dari_tanggal">
                        </div>
                        <div class="col-lg6">
                            <label>Dari Tanggal</label>
                            <input class="form-control" id="sampai_tanggal">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                        echo form_label('Harga:');
                        $data = array('class' => 'form-control input-lg', 'type' => 'number', 'name' => 'price', 'id' => 'price', 'placeholder' => 'e.g 1200000', 'reqiured' => 'reqiured');
                        echo form_input($data);
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control input-lg" name='active' id='active'>
                            <option value="1">Active</option>
                            <option value="2">Non Active</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Add Data</strong></button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Save Change</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#menu_id_35').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_101').addClass('menu-item-active')
    $(document).ready(function() {
        var dataBanks = [];
        var add_new_data_btn = $('#add_new_data_btn');
        var BankModal = {
            'self': $('#accounts_modal'),
            'info': $('#accounts_modal').find('.info'),
            'form': $('#accounts_modal').find('#accounts_form'),
            'addBtn': $('#accounts_modal').find('#add_btn'),
            'saveEditBtn': $('#accounts_modal').find('#save_edit_btn'),
            'id_carwash_close': $('#accounts_modal').find('#id_carwash_close'),
            'label': $('#accounts_modal').find('#label'),
            'price': $('#accounts_modal').find('#price'),
            'active': $('#accounts_modal').find('#active'),
        }
        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
            reverseButtons: true
        };

        var swalSuccessConfigure = {
            title: "Simpan berhasil",
            icon: "success",
            timer: 500
        };


        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };



        function FormReset() {
            //  BankModal.head_number.mask('0.00.000', {});
        }
        //   BankModal.self.mod   al('show');
        add_new_data_btn.on('click', (e) => {
            BankModal.form.trigger('reset');
            BankModal.self.modal('show');
            BankModal.addBtn.show();
            BankModal.saveEditBtn.hide();
        });
        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        function getAllBaganAkun() {
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
                    dataBanks = json['data'];
                    renderBanks(dataBanks);
                },
                error: function(e) {}
            });
        }


        function renderBanks(data) {
            if (data == null || typeof data != "object") {
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {
                var editButton = `
                 <button type="button" class="edit btn btn-primary  btn-icon" data-id='${d['id_carwash_close']}' title="Edit"><i class='la la-pencil-alt'></i></button>
                 `;
                var deleteButton = `
                 <button  type="button" class="delete btn btn-warning btn-icon" data-id='${d['id_carwash_close']}' title="Delete"><i class='la la-trash'></i></button>
                 `;
                //  var button = `    ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;
                var button = `    ${editButton }  ${deleteButton }`;


                renderData.push([d['label'], d['price'], d['active'] == 1 ? 'active' : 'non active', button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.edit', function() {
            BankModal.form.trigger('reset');
            BankModal.self.modal('show');
            BankModal.addBtn.hide();
            BankModal.saveEditBtn.show();
            var currentData = dataBanks[$(this).data('id')];
            BankModal.id_carwash_close.val(currentData['id_carwash_close']);
            BankModal.label.val(currentData['label']).change();
            BankModal.price.val(currentData['price']);
            BankModal.active.val(currentData['active']);
        })

        FDataTable.on('click', '.delete', function() {
            var currentData = $(this).data('id');
            Swal.fire(swalDeleteConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                $.ajax({
                    url: "<?= base_url('MasterCarwash/actPriceList/del') ?>",
                    'type': 'post',
                    data: {
                        'id_carwash_close': currentData
                    },

                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        //  return;
                        var d = json['data']
                        delete dataBanks[currentData];
                        swal.fire("Simpan Berhasil", "", "success");
                        renderBanks(dataBanks);
                        BankModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });

        })

        BankModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = BankModal.addBtn.is(':visible');
            var url = "<?= site_url('MasterCarwash/actPriceList/') ?>";
            url += isAdd ? "add" : "edit";
            var button = isAdd ? BankModal.addBtn : BankModal.saveEditBtn;

            Swal.fire(swalSaveConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(BankModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        //  return;
                        var d = json['data']
                        dataBanks[d['id_carwash_close']] = d;
                        swal.fire(swalSuccessConfigure);
                        renderBanks(dataBanks);
                        BankModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });
        getAllBaganAkun()
    });
</script>
<!-- Bootstrap model  -->
<?php
//  $this->load->view('bootstrap_model.php'); 
?>
<!-- Bootstrap model  ends-->