<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <div class="container">
        <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
            <?php
            $attributes = array('id' => 'general_journal', 'method' => 'post', 'class' => 'form col-lg-12');
            ?>
            <?php echo form_open_multipart('statements', $attributes); ?>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <!-- <div class="col-lg-3"> -->
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <?php
                        $data = array('class' => 'btn btn-default btn-outline-primary  mr-2', 'type' => 'button', 'id' => 'btn_export_excel', 'value' => 'true', 'content' => '<i class="fa fa-download" aria-hidden="true"></i> Export Excel');
                        echo form_button($data);
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
                    <div class="col-lg-3">
                        <div class="form-group">
                            <?php echo form_label('No Jurnal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'id' => 'no_jurnal', 'name' => 'no_jurnal', 'reqiured' => '', 'value' => $no_jurnal);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="form-group">
                            <?php echo form_label('Dari Tanggal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'id' => 'from', 'name' => 'from', 'reqiured' => '', 'value' => $from);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="form-group">
                            <?php echo form_label('Sampai Tanggal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'id' => 'to', 'name' => 'to', 'reqiured' => '', 'value' => $to);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3"> -->
                    <div class="form-group" style="margin-top: 24px; float: right">
                        <button class="btn btn-info btn-flat mr-2" type="submit" name="btn_submit_customer" value="true"> <i class=" fa fa-search pull-left"></i> Buat Statement</button>

                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <?php form_close(); ?>
        </div>
        <div class="card card-custom" id="print-section">
            <div class="card-body">
                <?php
                if ($transaction_records != NULL) {
                ?>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
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
                        <div class="col-lg-12">
                            <table class="datatable-table" style="width : 100%" id="">
                                <thead class="ledger_head" style="width : 30%">
                                    <th style="width: 108px;">TANGGAL</th>
                                    <th class="">AKUN</th>
                                    <th class="">KETERANGAN</th>
                                    <th class="">DEBIT</th>
                                    <th class="">KREDIT</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($transaction_records as $transaction_record) {
                                        foreach ($transaction_record['data_sub'] as $single_trans) {
                                            // echo json_encode($transaction_record);

                                            if ($single_trans['type'] == 0) {
                                                // echo '2';
                                                // }
                                                echo '<tr>
                                            <td>' . $transaction_record['date'] . '</td>
                                            <td>
                                            <p>' . $single_trans['name'] . '</p>
                                            </td>
                                            <td>
                                            <p>' . $single_trans['sub_keterangan'] . '</p>
                                                </td>
                                            <td>
                                                <p>' . number_format($single_trans['amount'], 2, ',', '.') . '</p>
                                            </td>
                                            <td>
                                            </td>          
                                            </tr>';
                                            } else if ($single_trans['type'] == 1) {
                                                echo '<tr>
                                            <td>' . $transaction_record['date'] . '</td>
                                            <td>
                                            <p>' . $single_trans['name'] . '</p>
                                            </td>
                                            <td>
                                            <p>' . $single_trans['sub_keterangan'] . '</p>
                                                </td>
                                            <td>
                                            </td>
                                            <td>
                                            <p >' . number_format($single_trans['amount'], 2, ',', '.')  . '</p>
                                            </td>          
                                            </tr>';
                                            }
                                        }
                                        if ($transaction_record['gen_lock'] == 'N') {
                                            $btn_lock = ' 
                                    <a href="' . base_url() . 'statements/delete_jurnal/' . $transaction_record['transaction_id'] . '" class="btn btn-default btn-outline-danger mr-1 my-1 no-print" style="float: right"><i class="fa fa-trash  pull-left"></i> Delete </a>
                                            <a href="' . base_url() . 'statements/edit_jurnal/' . $transaction_record['transaction_id'] . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-list-alt pull-left"></i> Edit</a> 
                                            ';
                                        } else {
                                            $btn_lock = ' ';
                                        }

                                        echo '<tr class="narration" >
                                        <td class="border-bottom-journal" colspan="5">
                                        <h6">' . (empty($transaction_record['naration']) ? '-' : $transaction_record['naration']) . '</h6>
                                        
                                        <h7> No Jurnal : ' . $transaction_record['no_jurnal'] . '</h7> 
                                        <br>
                                        ' .  $btn_lock . '
                                        <a href="' . base_url() . 'statements/show/' . $transaction_record['transaction_id'] . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-eye  pull-left"></i> Show </a>
                                        <a href="' . base_url() . 'statements/copy_jurnal/' . $transaction_record['transaction_id'] . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-copy  pull-left"></i> Copy </a>
                                        </td>
                                        </tr>';
                                    }
                                    // echo $transaction_records;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="col-lg-3"></div> -->
                    </div>
                <?php
                } else {
                    echo '<p class="text-center"> No record found</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>


<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_59').addClass('menu-item-active')

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
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->