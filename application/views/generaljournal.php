<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>

        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form opd="form" id="print_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_data">
                    <div class="form-group">
                        <label for="name1">Diterima / Diberikan Kepada</label>
                        <input type="text" placeholder="" class="form-control" id="name1">
                    </div>
                    <div class="form-group">
                        <label for="name2">Dibuat Oleh:</label>
                        <input type="text" placeholder="" class="form-control" id="name2">
                    </div>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" data-loading-text="Loading..."><strong><i class="fa fa-print  pull-left"></i> Print</strong></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close_modal_print" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="box" id="print-section">
        <div class="box-body box-bg ">
            <div class="make-container-center">
                <?php
                $attributes = array('id' => 'general_journal', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open_multipart('statements', $attributes); ?>
                <div class="row no-print">
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <?php echo form_label('No Jurnal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'id' => 'no_jurnal', 'name' => 'no_jurnal', 'reqiured' => '', 'value' => $no_jurnal);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
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
            split = number_string.split("."),
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


    function printSingleJurnal2(id, name1 = '', name2 = '') {
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
        var show = 0;
        var conskredit = 0;
        var displyhide = true

        var tpe = no_jurnal.split("/")[1];
        if (tpe == 'AM' || tpe == 'KM' || tpe == 'DM') {
            tpe = 'AM'
        } else if (tpe == 'AK' || tpe == 'KK' || tpe == 'DK') {
            tpe = 'AK'
        }
        if (tpe == undefined) {

            tpe = ''
        }
        console.log(tpe)
        for (var i = 0; i < name.length; i++) {
            if (name[i].innerHTML.substring(1, 5) == '1.11') {
                if (tpe == 'AM') {
                    show =
                        show +
                        (debit[i].innerHTML ?
                            parseInt(debit[i].innerHTML.replace(/[^0-9]/g, "")) :
                            0);
                    displyhide = false
                } else if (tpe == 'AK') {
                    displyhide = false

                    show =
                        show +
                        (kredit[i].innerHTML ?
                            parseInt(kredit[i].innerHTML.replace(/[^0-9]/g, "")) :
                            0);
                }
            }
            console.log(tpe)
            console.log(displyhide)
            isi += `
            
            <tr style="height : 10px">
                <td style="text-align:left; padding-left : 5px ">${name[i].innerHTML.substring(0, 35)}</td>
                <td style="text-align:left; padding-left : 5px ">${ket[i].innerHTML}</td>
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
            <td colspan="2"><strong>Jumlah</strong> </td>
        
            <td style="text-align:right ; padding-right : 10px"><strong>${formatRupiah(consdebit)}</strong> </td>
            <td style="text-align:right ; padding-right : 10px"><strong>${formatRupiah(conskredit)}</strong> </td>
            </tr>
            `;

        var printContents = `
                            <div class="col-md-12">
                            <h4 style="text-align:center">PT. Indometal Asia </h4>
                                            <h5 style="text-align:center">${tpe == 'AM' ? 'VOUCHER PENERIMAAN' : (tpe == 'AK' ? 'VOUCHER PENGELUARAN' : 'JURNAL UMUM')}</h5>
                           </div>
                            <div class="col-md-12" style="font-size: 11px;">
                            <table style="" border="0">
                              <tr>
                            <td ${displyhide ? '' : ''} style=";text-align:left ;width: 100px">${tpe == 'AM' ? 'Diterima dari' : (tpe == 'AK' ? 'Dibayar kepada' : '')}</td>
                            <td style=;width: 10px">${displyhide ? '' : ':'}</td>
                            <td style=";text-align:left ;width: 400px"> ${displyhide ? '' : name1} </td>
                            <td style="text-align:left ;width: 100px">No Voucher</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left; width: 200px">${no_jurnal}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left ;width: 100px"> Deskripsi</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">${ naration}</td>
                            <td style="text-align:left ;width: 100px">Tanggal</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left; width: 200px">${date.split('-')[2]}-${date.split('-')[1]}-${date.split('-')[0]}</td>
                        </tr>
                            <tr style="${displyhide ? 'display: none' : ''} ;">
                            <td style="text-align:left ;width: 100px">Sejumlah</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">Rp. ${formatRupiah(show)}</td>
                            
                        </tr>
                            <tr style="${displyhide ? 'display: none' : ''} ;">
                            <td style="text-align:left ;width: 100px">Terbilang</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px;font-style: italic;">${terbilang(show.toString())}</td>
                        
                        </tr>
                        <tr>
                        </tr>
                    </table>
                    <br>
                    <table style="" border="1" cellspacing="0">
                        <tr>
                            <td style="width: 200px ;text-align:center">No Akun</td>
                            <td style="width: 350px ; text-align:center">Keterangan</td>
                            <td style="width: 100px ; text-align:center">Debit (Rp)</td>
                            <td style="width: 100px; text-align:center">Kredit  (Rp)</td>
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
                            <td style=" vertical-align: bottom; text-align:center">SETIAWAN R</td>
                            <td></td>
                            <td style="vertical-align: bottom; text-align:center">${name2}</td>
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

    var PrintForm = {
        'self': $('#printModal'),
        'form': $('#printModal').find('#print_form'),
        'id_data': $('#printModal').find('#id_data'),
        'name1': $('#printModal').find('#name1'),
        'name2': $('#printModal').find('#name2'),
        'close': $('#printModal').find('#close_modal_print'),
    }

    PrintForm.form.submit(function(event) {
        // PrintForm.self.modal('hide')
        event.preventDefault();
        printSingleJurnal2(PrintForm.id_data.val(), PrintForm.name1.val(), PrintForm.name2.val())
    })

    $('#close_modal_print').on('click', function() {
        PrintForm.self.modal('hide')
    })



    $('.print_act').on('click', function() {
        var currentData = $(this).data('id');
        console.log(currentData)
        PrintForm.self.modal('show')
        PrintForm.id_data.val(currentData)
    })
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->