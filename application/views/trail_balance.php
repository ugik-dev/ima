<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <div class="container">
        <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <!-- <div class="col-lg-3"> -->
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <?php
                        // $data = array('class' => 'btn btn-default btn-outline-primary  mr-2', 'type' => 'button', 'id' => 'btn_export_excel', 'value' => 'true', 'content' => '<i class="fa fa-download" aria-hidden="true"></i> Export Excel');
                        // echo form_button($data);
                        ?>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="col-lg-3"> -->
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <a onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary  mr-2"><i class="fa fa-print  pull-left"></i> Cetak</a>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="row col-lg-12">
                    <?php
                    $attributes = array('id' => 'leadgerAccounst', 'method' => 'post', 'class' => 'col-lg-12');
                    ?>
                    <?php echo form_open_multipart('statements/trail_balance', $attributes); ?>
                    <div class="row">
                        <!-- <div class="col-lg-3"> -->
                        <div class="form-group mr-2">
                            <?php echo form_label('Pilih Tahun Priodik'); ?>
                        </div>
                        <!-- </div> -->
                        <div class="form-group mr-2">
                            <select class="form-control input-lg" name="year">
                                <option value="2019"> 2019</option>
                                <option value="2020"> 2020</option>
                                <option value="2021"> 2021</option>
                                <option value="2022"> 2022</option>
                                <option value="2023"> 2023</option>
                                <option value="2024"> 2024</option>
                                <option value="2025"> 2025</option>
                                <option value="2026"> 2026</option>
                            </select>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-lg-3"> -->
                        <div class="form-group mr-2">
                            <?php
                            $data = array('class' => 'btn btn-info btn-flat btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Buat Statement');
                            echo form_button($data);
                            ?>
                            <!-- </div> -->
                        </div>
                    </div>
                    <?php form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body box-bg ">
            <div class="make-container-center">

            </div>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <h2 style="text-align:center">NERACA SALDO </h2>
                    <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'];
                        ?>
                    </h3>
                    <h4 style="text-align:center">Hingga : <?php echo $year; ?> <b>
                    </h4>
                    <h4 style="text-align:center">Dibuat : <?php echo Date('Y-m-d'); ?> <b>
                    </h4>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="balancesheet-header">
                                <th class="col-lg-10">NAMA AKUN</th>
                                <!-- <th class="col-lg-3">NO JURNAL</th> -->
                                <th class="col-lg-1">DEBIT</th>
                                <th class="col-lg-1">KREDIT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $trail_records; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>
<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_61').addClass('menu-item-active')

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
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
</script>
<?php $this->load->view('bootstrap_model.php'); ?>