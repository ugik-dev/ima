<div class="card card-custom">
    <div class="card-body">
        <div class="box-body">
            <div class="">
                <?php
                $attributes = array('id' => 'invoice', 'method' => 'post', 'class' => '');
                ?>
                <?php
                //  echo form_open('usaha/add_record_car_wash', $attributes); 
                ?>
                <form id="shp_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <div class="">
                        <div class="row no-print invoice">
                            <h4 class=""> <i class="fa fa-check-circle"></i>
                                RAB
                            </h4>
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <?php echo form_label('Tanggal Berlaku'); ?>
                                            <input type="hidden" name="id_rab" value="<?= !empty($data_return['id_rab']) ? $data_return['id_rab'] : '' ?>" />
                                            <input type="date" name="date_rab" class="form-control" value="<?= !empty($data_return['date_rab']) ? $data_return['date_rab'] : date('Y-m-d') ?>" />

                                        </div>

                                        <div class="col-md-12 ">
                                            <div class="form-group">
                                                <?php
                                                $data = array('class' => 'btn btn-info  margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'id' => 'btn_save_transaction', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                ' . (empty($data_return['id_rab']) ? 'Tambah' : 'Perbaarui'));
                                                echo form_button($data);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <table id="FDataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center!important">Persentase (%)</th>
                                                    <th style=" text-align:center!important">Harga (Rp)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 40; $i <= 70; $i++) { ?>
                                                    <tr>
                                                        <td style="text-align:center!important"><?= $i ?>%</td>
                                                        <td style=" text-align:center!important">
                                                            <input type="hidden" value="<?= !empty($data_return['child'][$i]['id_rab_child']) ? $data_return['child'][$i]['id_rab_child'] : '' ?>" name="id_rab_child_<?= $i ?>" class="mask form-control text-right">
                                                            <input type="text" value="<?= !empty($data_return['child'][$i]['harga']) ? number_format($data_return['child'][$i]['harga'], 0, ',', '.') : '' ?>" name="percent_<?= $i ?>" class="mask form-control text-right">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script src="<?php echo base_url(); ?>assets/dist/js/backend/invoice.js?v=0.2"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {

        // $("#kt_body").addClass('aside-minimize');
        $('#menu_id_34').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_95').addClass('menu-item-active')


        shp_form = $('#shp_form');


        $('.mask').mask('000.000.000.000.000', {
            reverse: true
        });

        shp_form.submit(function(event) {
            event.preventDefault();
            // var isAdd = BankModal.addBtn.is(':visible');
            var url = "<?= base_url('shp/' . $form_url) ?>";

            Swal.fire(swalSaveConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(shp_form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        //  return;
                        var d = json['url']

                        swal.fire(swalSuccessConfigure);

                        window.location = '<?= base_url() ?>' + d;
                    },
                    error: function(e) {}
                });
            });
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
<?php $this->load->view('bootstrap_model.php'); ?>