<html>

<head>
    <title>Print kwitansi</title>
    <style type="text/css">
        .lead {
            font-family: "Verdana";
            /* font-weight: bold; */
            margin-right: 50px;
        }

        .terbilang {
            font-family: "Verdana";
            font-style: italic;
            margin-right: 50px;
        }

        .value {
            font-family: "Verdana";
            margin-left: 50px;
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

        .td * {
            vertical-align: "top";
        }

        /* @page { size: with x height */
        /*@page { size: 20cm 10cm; margin: 0px; }*/
        @page {
            size: A4;
            margin: 0px;
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

    <table border="1px" width="100%">
        <tr>
            <!-- <td width="80px"></td> -->
            <td>
                <table cellpadding="4" width="100%">
                    <tr>
                        <td colspan="3"><img style="margin : 10px" src="<?= base_url('assets/img/') . logo ?>" width="300px" /></td>
                    </tr>
                    <tr>
                        <td colspan="3" style=" text-align: center;" width="200px">
                            <div class="value-big">KWITANSI
                        </td>
                        <!-- <td> -->
                        <!-- <div class="value">{{k.kwitansiNo}}</div> -->
                        <!-- </td> -->
                    </tr>
                    <tr style="height: 2px !important">
                        <td class="" style="height: 2px !important"> &nbsp;</td>
                    </tr>
                    <tr>
                        <td width="200px">
                            <div class="value">Sudah terima dari</div>
                        </td>
                        <td width="10px">
                            <div class="">:</div>
                        </td>
                        <td>
                            <div class="value-bold"><?= !empty($from) ? $from : 'PT INDOMETAL ASIA' ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px" style="vertical-align:  top">
                            <div class="value">Sejumlah</div>
                        </td>
                        <td width="10px" style="vertical-align:  top">
                            <div class="">:</div>
                        </td>
                        <td style="vertical-align:  top">
                            <div class="terbilang"> <?= $terbilang ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="210px" style="vertical-align:  top">
                            <div class="value">Untuk Pembayaran</div>
                        </td>
                        <td width="10px" style="vertical-align:  top">
                            <div class="">:</div>
                        </td>
                        <td style="vertical-align:  top">
                            <div class="lead"> <?= $description ?></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </table>
                <table width="100%">
                    <?php if (!empty($item)) {
                    ?>
                        <tr>
                            <td style="text-align: center; margin-right: 100px"></td>
                            <td width="50%">

                                <table style="margin-left : 100px">
                                    <?php
                                    $i = 0;
                                    foreach ($item as $it) {
                                    ?>
                                        <tr>
                                            <td class="" class="value" style="margin-right: 4px;"><?= $item[$i] ?></td>
                                            <td width='200px' class="value" style="text-align: right;"><?= number_format($price[$i], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr style="height:1px !important">
                                        <td style="height:1px !important"> </td>
                                        <td style="height:1px !important">
                                            <hr style=" border-top: 1px solid black; margin: 0; padding: 0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="" style="margin-right: 4px;"></td>
                                        <td width='200px' class="value-bold" style="text-align: right"> <?= $nominal ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="height: 2px !important">
                            <td class="" style="height: 2px !important"> &nbsp;</td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="value-big" style="padding-bottom: 50px: ; padding-left: 50px"> <?= $nominal ?></td>
                        <td width="50%">

                            <table width="100%">
                                <tr>
                                    <td width='100%' class="value" style="text-align: center;"><?= $date ?></td>
                                </tr>

                                <tr style="height:100px !important">
                                    <td style="height:100px !important"> </td>
                                </tr>
                                <tr>
                                    <td width='100%' class="value-bold" style="text-align: center; text-weight: bold"><?= $to ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="height: 2px !important">
                        <td class="" style="height: 2px !important"> &nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
            // window.close();
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