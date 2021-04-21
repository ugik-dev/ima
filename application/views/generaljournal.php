<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body box-bg ">
            <div class="make-container-center">
                <?php
                // if ($from == NULL and $to == NULL) {
                //     $tfrom = date('Y-m-' . '01');
                //     $tto =  date('Y-m-' . '31');
                // } else {
                //     $tform = $from;
                //     $to = $to;
                // } // echo $to;
                $attributes = array('id' => 'general_journal', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open_multipart('statements', $attributes); ?>
                <div class="row no-print">
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <?php echo form_label('Dari Tanggal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'id' => 'from', 'name' => 'from', 'reqiured' => '', 'value' => $from);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <?php echo form_label('Sampai Tanggal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'id' => 'to', 'name' => 'to', 'reqiured' => '', 'value' => $to);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="margin-top: 16px;">
                            <?php
                            $data = array('class' => 'btn btn-info btn-flat margin btn-lg ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Buat Statement');
                            echo form_button($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="margin-top: 16px;">
                            <?php
                            $data = array('class' => 'btn btn-info btn-flat margin btn-lg ', 'type' => 'button', 'id' => 'btn_export_excel', 'value' => 'true', 'content' => '<i class="fa fa-download" aria-hidden="true"></i> 
                               Export Excel');
                            echo form_button($data);
                            ?>
                        </div>
                    </div>
                    <?php form_close(); ?>
                </div>
                <?php
                if ($transaction_records != NULL) {
                ?>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h2 style="text-align:center">JURNAL UMUM </h2>
                            <h3 style="text-align:center">
                                <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'];
                                ?>
                            </h3>
                            <h4 style="text-align:center"><b>Dari</b> <?php echo $from; ?> <b> Sampai </b> <?php echo $to; ?>
                            </h4>
                            <h4 style="text-align:center">Dibuat <?php echo Date('Y-m-d'); ?>
                            </h4>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                        <table class="table table-hover table-responsive" id="dataTable">
                            <thead class="ledger_head">
                                <th class="col-md-2">TANGGAL</th>
                                <th class="col-md-4">AKUN</th>
                                <th class="col-md-4">KETERANGAN</th>
                                <th class="col-md-1">DEBIT</th>
                                <th class="col-md-1">KREDIT</th>
                            </thead>
                            <tbody>
                                <?php echo $transaction_records; ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                    echo '<p class="text-center"> No record found</p>';
                }
                ?>
            </div>
</section>
<script>
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

    $('#btn_export_excel').on('click', function() {
        console.log('s')
        from = $('#from').val()
        to = $('#to').val()
        url = `<?= base_url('statements/export_excel?from=') ?>` + from + '&to=' + to;
        location.href = url;

    })


    function printSingleJurnal2(id) {
        var naration = document.getElementById("naration_" + id).innerHTML;
        var no_jurnal = document.getElementById("no_jurnal_" + id).innerHTML;
        var name = document.getElementsByClassName("rinc_name_" + id);
        var ket = document.getElementsByClassName("rinc_ket_" + id);
        var debit = document.getElementsByClassName("rinc_debit_" + id);
        var kredit = document.getElementsByClassName("rinc_kredit_" + id);
        var date = document.getElementById("date_" + id).innerHTML;
        console.log(date)
        isi = "";
        var consdebit = 0;
        var conskredit = 0;
        console.log(name[0].innerHTML);
        for (var i = 0; i < name.length; i++) {
            isi += `<tr style="height : 10px">
                <td>${name[i].innerHTML.substring(1, 13)}</td>
                <td>${ket[i].innerHTML}</td>
                <td style="text-align:right ; padding-right : 5px">${
                debit[i].innerHTML
                }</td>
                <td style="text-align:right ; padding-right : 5px">${kredit[i].innerHTML}</td>
                </tr>
                `;
            last = i;
            console.log(debit[i].innerHTML.replace(/[^0-9]/g, ""));
            consdebit =
                consdebit +
                (debit[i].innerHTML ?
                    parseInt(debit[i].innerHTML.replace(/[^0-9]/g, "")) :
                    0);
            conskredit =
                conskredit +
                (kredit[i].innerHTML ?
                    parseInt(kredit[i].innerHTML.replace(/[^0-9]/g, "")) :
                    0);
            // fixdate = date[i].innerHTML();
        }
        // console.log(fixdate)
        for (var j = last; j < 7; j++) {
            isi += `<tr  style="height : 22px; padding : 10px">
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            </tr>
            `;
        }
        isi += `<tr  style="height : 22px; padding : 10px">
            <td colspan="2"><bold>Jumlah</bold> </td>
        
            <td style="text-align:right ; padding-right : 10px">${formatRupiah(consdebit)} </td>
            <td style="text-align:right ; padding-right : 10px">${formatRupiah(conskredit)} </td>
            </tr>
            `;
        // <div class="box-body box-bg ">
        // <div class="make-container-center">

        var printContents = `
                            <div class="col-md-12">
                                            <h2 style="text-align:center">Jurnal Voucher</h2>
                                            <h3 style="text-align:center">PT. Indometal Asia </h3>
                           </div>
                            <div class="col-md-12" style="font-size: 11px;">
                            <table style="" border="0">
                        <tr>
                            <td style="width: 100px">Deskripsi</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">${naration}</td>
                            <td style="text-align:left ;width: 100px">No Voucher</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left; width: 200px">${no_jurnal}</td>
                        </tr>
                            <tr>
                            <td style="width: 100px">Sejumlah</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">${formatRupiah(conskredit)}</td>
                            <td style="text-align:left ;width: 100px">Tanggal</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left; width: 200px">${date}</td>
                        </tr>
                            <tr>
                            <td style="width: 100px">Terbilang</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">${terbilang(conskredit.toString())}</td>
                        
                        </tr>
                        <tr>
                        </tr>
                    </table>
                    <br>
                    <table style="" border="1" cellspacing="0">
                        <tr>
                            <td style="width: 200px ;text-align:center">No Akun</td>
                            <td style="width: 350px ; text-align:center">Keterangan</td>
                            <td style="width: 100px ; text-align:center">Debit</td>
                            <td style="width: 100px; text-align:center">Kredit</td>
                        </tr>
                        ${isi}
                    </table>
                    <br>
                    <table style="font-size: 11px; width: 100%" border="0" cellspacing="0">
                        <tr>
                            <td style="width: 400 ;text-align:left; padding : 3px">
                            
                             <table style="" border="1" cellspacing="0">
                                <tr>
                                    <td style="width: 130 ;text-align:left; padding : 3px">Pengeluaran Berupa</td>
                                    <td style="width: 130 ; text-align:left ; padding : 3px">Kas/Cek/Trans*)</td>
                                </tr>
                                <tr>
                                    <td style="width: 130 ;text-align:left; padding : 3px">Nomor</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="width: 130 ;text-align:left; padding : 3px">Tanggal</td>
                                    <td ></td>
                                </tr>
                                <tr>
                                    <td style="width: 130 ;text-align:left; padding : 3px">A/C No.</td>
                                    <td style="width: 130 ; text-align:left ; padding : 3px">112-0098146017</td>
                                </tr>
                            </table>
                    

                            </td>
                            <td style="width: 130 ; align:right ; padding : 3px">
                    <table style="float: right"  border="1" cellspacing="0">
                        <tr>
                            <td style="width: 90px ;text-align:center">Disetujui</td>
                            <td style="width: 90px ; text-align:center">Diverifikasi</td>
                            <td style="width: 90px ; text-align:center">Dibuat Oleh</td>
                            <td style="width: 90px ; text-align:center">Diterima</td>
                            <td style="width: 90px ; text-align:center">Dibukukan</td>
                        </tr>
                        <tr style="height: 70px">
                            <td style="width: 90px ; text-align:center">SETIAWAN R</td>
                            <td></td>
                            <td style="width: 90px ; text-align:center"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; margin-right: 1px">Tgl</td>
                            <td style="text-align:left">Tgl</td>
                            <td style="text-align:left">Tgl</td>
                            <td style="text-align:left">Tgl</td>
                            <td style="text-align:left">Tgl</td>
                        
                        </tr>
                
                    </table>
                            </td>
                        </tr>
                        </table>
             </div>
             `;
        // console.log(printContents);
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->