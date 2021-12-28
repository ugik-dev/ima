<html>

<head>
    <title>Print SK</title>
    <style type="text/css">
        .lead {
            font-family: "Verdana";
            /* font-weight: bold; */
            margin-right: 25px;
        }

        .terbilang {
            font-family: "Verdana";
            font-style: italic;
            margin-right: 25px;
        }

        .value {
            font-family: "Verdana";
            margin-left: 25px;
        }

        .value-bold {
            font-family: "Verdana";
            font-weight: bold;
            /* margin-left: 50px; */
        }

        .value-big {
            font-family: "Verdana";
            font-weight: bold;
            font-size: large;
        }

        .mr-1 {
            margin-right: 20px;
        }

        .ml-1 {
            margin-left: 20px;
        }

        .prl-1 {
            padding-left: 10px;
            padding-right: 10px;
            /* font-size: 12px; */
        }

        table {
            font-family: "Verdana";
            font-size: 12px;
        }

        .table-item {
            border: 1px solid black;
            border-collapse: collapse;
        }

        /* @page { size: with x height */
        /*@page { size: 20cm 10cm; margin: 0px; }*/
        @page {
            size: A4;
            margin: 2cm;
        }

        /*		@media print {
			  html, body {
			  	width: 210mm;
			  }
			}*/
        /*body { border: 2px solid #000000;  }*/
    </style>

</head>

<body>

    <table border="0px" width="100%">
        <tr>
            <!-- <td width="80px"></td> -->
            <td>
                <table border=0 cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3"><img style="margin : 10px" src="<?= base_url('assets/img/') . (Company_Profile()['logo'])  ?>" width="300px" /></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="vertical-align: top;" width="200px">
                            <table border=0 cellpadding="0" style=" vertical-align: top;" width="100%">
                                <tr>
                                    <td style=" vertical-align: top;">

                                        <table border=0 cellpadding="2" width="100%">
                                            <tr>
                                                <td width="20px !important"> Nomor </td>
                                                <td width="10px" class="prl-1 "> : </td>
                                                <td> <?= $transaction['no_invoice'] ?></td>
                                            </tr>
                                            <tr>
                                                <td> Tanggal </td>
                                                <td width="10px" class="prl-1 "> : </td>
                                                <td> <?= $transaction['date'] ?></td>
                                            </tr>
                                            <tr>
                                                <td> Lampiran </td>
                                                <td width="10px" class="prl-1 "> : </td>
                                                <td> 1 (satu) berkas</td>
                                            </tr>
                                            <tr>
                                                <td> Perihal </td>
                                                <td width="10px" class="prl-1 "> : </td>
                                                <td> Permohonan Bayar</td>
                                            </tr>
                                        </table>

                                    </td>

                                    <td width="35%">

                                        <table cellpadding="2" width="100%">
                                            <tr>
                                                <td> Kepada Yth </td>
                                            </tr>
                                            <?php if (!empty($template['to_jabatan'])) { ?>
                                                <tr>
                                                    <td> <?= $template['to_jabatan'] ?> </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td> <?= $transaction['customer_name'] ?> </td>
                                            </tr>
                                            <?php if (!empty($template['to_divisi'])) { ?>
                                                <tr>
                                                    <td> <?= $template['to_divisi'] ?> </td>
                                                </tr>
                                            <?php } ?>
                                            <?php if (!empty($transaction['cus_address'])) { ?>
                                                <tr>
                                                    <td> <?= $transaction['cus_address'] ?> </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td> di </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 50px"> <?= $transaction['cus_town'] ?> </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="height: 2px !important">
                        <td class="" style="height: 2px !important"> &nbsp;</td>
                    </tr>
                    <tr cellpadding="4">
                        <td colspan=4 cellpadding="4" style="text-align: justify">
                            <p>Dengan hormat,</p>
                            <p><?= $p1 ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style=" padding : 10px">
                            <table border="1px solid black" class="table-item" style="" width="100%">
                                <tr>
                                    <th>KETERANGAN</th>
                                    <th>TANGGAL</th>
                                    <th>QYT</th>
                                    <th>HARGA (Rp)</th>
                                    <th>SUB TOTAL (Rp)</th>
                                </tr>
                                <?php
                                $nopol = false;
                                foreach ($transaction['items'] as $item) {
                                    if (!empty($item['nopol'])) $nopol = true;
                                }
                                foreach ($transaction['items'] as $item) {

                                ?>
                                    <tr>
                                        <td style="padding: 4px"><?= $item['keterangan_item'] ?></td>
                                        <td style="padding: 4px"><?= $item['date_item'] ?></td>
                                        <td style="padding: 4px ; text-align: center"><?= $item['qyt'] ?></td>
                                        <!-- <td><?= $item['amount'] ?></td> -->
                                        <td style="padding: 4px; text-align: right;"><?= number_format($item['amount'], 2, '.', ',') ?></td>
                                        <td style="padding: 4px;text-align: right;"><?= number_format($item['amount'] * $item['qyt'], 2, '.', ',') ?></td>
                                    </tr>
                                <?php
                                    // var_dump()
                                } ?>
                                <tr>
                                    <td style="padding: 4px; text-align: right;" colspan="4"> <b>JUMLAH</b></td>
                                    <td style="padding: 4px; text-align: right;"><b><?= number_format($transaction['sub_total'], 2, '.', ',') ?></b></td>
                                </tr>
                                <?php if ($transaction['ppn_pph'] == 1) { ?>
                                    <tr>
                                        <td style="padding: 4px; text-align: right;" colspan="4"> <b>PPN 10%</b></td>
                                        <td style="padding: 4px; text-align: right;"><b><?= number_format(0.1 * $transaction['sub_total'], 2, '.', ',') ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px; text-align: right;" colspan="4"> <b>TOTAL</b></td>
                                        <td style="padding: 4px; text-align: right;"><b><?= number_format($transaction['total_final'], 2, '.', ',') ?></b></td>
                                    </tr>
                                <?php  } ?>
                            </table>
                        </td>
                    </tr>
                    <tr cellpadding="4">
                        <td colspan=4 cellpadding=" 4" style="text-align: justify;">
                            <p>Terbilang : <b><?= $terbilang ?></b></p>
                            <?php if (!empty($payment['bankname'])) {
                            ?>
                                <p>Pembayaran kami harapkan dapat di transfer ke rekening kami nomor : <?= $payment['accountno'] ?><br>Atas nama :
                                    <ins><?= $payment['title'] ?></ins> pada <?= $payment['bankname'] ?> <?= $payment['branch'] ?>.
                                </p>
                            <?php } else { ?>
                                <p>Pembayaran dapat bayarkan secara cash tunai.</p>
                            <?php    } ?>
                            <p>Demikian disampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.</p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" style="vertical-align: top;" width="200px">
                            <table border=0 cellpadding="0" style=" vertical-align: top;" width="100%">
                                <tr>
                                    <td style=" vertical-align: center;">



                                    </td>

                                    <td width="35%">

                                        <table cellpadding="2" width="100%">
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"> <b> <?= (Company_Profile()['title1']) ?></b></td>
                                            </tr>
                                            <?php if (!empty($transaction['acc_1_title'])) { ?>
                                                <tr>
                                                    <td style="text-align: center;"> <b><?= $transaction['acc_1_title'] ?> <b></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"> <b><ins><?= $transaction['acc_1_name'] ?></ins></b> </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <script src="<?= base_url() ?>assets/plugins/jQuery/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
            var beforePrint = function() {};
            var afterPrint = function() {
                window.close();
                console.log('re')
            };

            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(function(mql) {
                    if (mql.matches) {
                        beforePrint();
                    } else {
                        afterPrint();
                    }
                });
            }

            window.onbeforeprint = beforePrint;
            window.onafterprint = afterPrint;
        });
    </script>

</body>

</html>