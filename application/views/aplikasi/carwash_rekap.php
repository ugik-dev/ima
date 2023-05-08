<div class="card card-custom" id="print-section">
    <div class="card-body">
        <div class="box-body ">
            <div class="">
                <div class="">
                    <div class="row no-print invoice">
                        <!-- <h4 class="ml-3"> <i class="fa fa-check-circle mr-2 ml-2"></i>
                            <?= $jurnal['parent']->no_jurnal ?>
                        </h4> -->

                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>No Jurnal</label>
                                    <h4><strong id="no_jurnal"><?= $jurnal['parent']->no_jurnal ?></strong></h4>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal</label>
                                    <h4><strong id="jurnal_date"><?= explode('-', $jurnal['parent']->date)[2] . '-' . explode('-', $jurnal['parent']->date)[1] . '-' . explode('-', $jurnal['parent']->date)[0] ?></strong></h4>
                                    <hr>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label>Deskripsi</label>
                                <h4><strong id="naration"><?= $jurnal['parent']->naration ?></strong></h4>
                                <hr>
                            </div> -->
                        </div>
                    </div>
                    <div class="row invoice">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-hover  ">
                                <thead>
                                    <tr>
                                        <th class="">Akun</th>
                                        <th class="">Debit</th>
                                        <th class="">Kredit</th>
                                        <th class="">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="jurnal_table_body">
                                    <?php
                                    $totdeb = 0;
                                    $totkredit = 0;
                                    $i = 0;
                                    $doc = false;
                                    foreach ($jurnal['sub'] as  $key => $sub_parents) {

                                        if ($sub_parents['accounthead'] == '13') {
                                            $doc = true;
                                        }
                                    ?>

                                        <tr>
                                            <td class="rinc_name"><?= $sub_parents['name'] ?> </td>
                                            <?php if ($sub_parents['type'] == '0') {
                                                $totdeb = $totdeb + floatval($sub_parents['amount']);
                                            ?>
                                                <td class="currency rinc_debit"><?= $sub_parents['amount'] ?></td>
                                                <td class="rinc_kredit"></td>
                                            <?php } else {
                                                $totkredit = $totkredit + $sub_parents['amount'];
                                            ?>
                                                <td class="rinc_debit"></td>
                                                <td class="currency rinc_kredit"><?= $sub_parents['amount'] ?></td>
                                            <?php } ?>
                                            <td class="rinc_ket"><?= $sub_parents['sub_keterangan'] ?> </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>Total: </th>
                                        <th>
                                            <p class='currency_rp'><?= $totdeb ?></p>
                                        </th>
                                        <th>
                                            <p class='currency_rp'><?= $totkredit ?></p>
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="jurnal_validity" id="jurnal_validity">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Dibuat</label>
                                        <h4 id="acc_3" class="form-control input-lg"><?= $dataContent['user_name'] ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
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
                                    <th style="width: 7%; text-align:left!important">Petugas</th>
                                    <th style="width: 7%; text-align:left!important">Tagihan</th>
                                    <th style="width: 7%; text-align:left!important">Bukti</th>
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
<script src="<?php echo base_url(); ?>assets/dist/js/backend/journal_voucher.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    $('#menu_id_35').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_101').addClass('menu-item-active')



    function formatRupiah(angka, prefix) {
        var number_string = angka.toString();
        split = number_string.split(".");
        sisa = split[0].length % 3;
        rupiah = split[0].substr(0, sisa);
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }


    var elements = document.getElementsByClassName('currency')

    for (var i = 0; i < elements.length; i++) {
        elements[i].innerHTML = formatRupiah(elements[i].innerHTML);
    }

    var currency_rp = document.getElementsByClassName('currency_rp')

    for (var i = 0; i < currency_rp.length; i++) {
        currency_rp[i].innerHTML = formatRupiah(currency_rp[i].innerHTML, true);
    }

    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });
</script>

<script>
    $(document).ready(function() {

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

        renderTransaksi();

        function renderTransaksi(data) {

            data = <?= json_encode($transaction) ?>;
            var i = 0;

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
                console.log(d)
                renderData.push([
                    d['req_tanggal'],
                    d['est_time'],
                    info,
                    infopembayaran,
                    infomargin,
                    // d['nomor_antrian'],
                    d['nama_petugas'],
                    formatRupiah2(d['pembayaran_tagihan']), filePembayaran
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }
    })
</script>
<?php $this->load->view('bootstrap_model.php'); ?>