<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <div class="container">

        <div class="card card-custom" id="print-section">
            <div class="card-body">
                <?php
                if ($transaction_records != NULL) {
                ?>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <h2 style="text-align:center">DRAFT JURNAL UMUM </h2>
                            <h3 style="text-align:center">
                            </h3>
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
                                        if ($accounting_role) {
                                            $btn_lock = ' 
                                            <a href="' . base_url() . 'statements/delete_jurnal_draft/' . $transaction_record['transaction_id'] . '" class="btn btn-default btn-outline-danger mr-1 my-1 no-print" style="float: right"><i class="fa fa-trash  pull-left"></i> Delete </a>
                                            <a href="' . base_url() . 'statements/edit_jurnal/' . $transaction_record['transaction_id'] . '/draft" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-list-alt pull-left"></i> Edit</a> 
                                             <a href="' . base_url() . 'statements/show/' . $transaction_record['transaction_id'] . '/draft" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-eye  pull-left"></i> Show </a>
                                         ';
                                        } else {
                                            $btn_lock = '        <a href="' . base_url() . 'statements/show/' . $transaction_record['transaction_id'] . '/draft" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-eye  pull-left"></i> Show </a> ';
                                        }



                                        echo '<tr class="narration" >
                                        <td class="border-bottom-journal" colspan="5">
                                        <h6">' . (empty($transaction_record['naration']) ? '-' : $transaction_record['naration']) . '</h6>
                                        
                                        <h7> No Jurnal : ' . $transaction_record['no_jurnal'] . '</h7> 
                                        <br>
                                        ' .  $btn_lock . '
                                       </td>
                                        </tr>';
                                    }
                                    // <a href="' . base_url() . 'statements/copy_jurnal/' . $transaction_record['transaction_id'] . '" class="btn btn-default btn-outline-primary  mr-1 my-1  no-print" style="float: right"><i class="fa fa-copy  pull-left"></i> Copy </a>
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
    $('#submenu_id_83').addClass('menu-item-active')

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