<html>

<head>
    <title>Print kwitansi</title>
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
                <table border=1 cellpadding="4" width="100%">
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
                            <div class="value-bold"><?php //
                                                    // !empty($from) ? $from : 'PT INDOMETAL ASIA' 
                                                    ?></div>
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
                            <div class="terbilang"> <?php // $terbilang 
                                                    ?></div>
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
                            <div class="lead"> <?php // $description 
                                                ?></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <?php // if (!empty($item)) {
                    ?>
                    <tr>
                        <td style="text-align: center; margin-right: 100px"></td>
                        <td width="60%">

                            <table border="0" style="margin-left : 50px" width="400">
                                <?php //
                                // $i = 0;
                                // foreach ($item as $it) {
                                ?>
                                <tr>
                                    <td width="200px" class="value" style="margin-right: 2px;"><?php // $item[$i] 
                                                                                                ?></td>
                                    <td width='' class="value" style="text-align: right; margin-right: 0"><?php // number_format((int)$price[$i], 0, ',', '.') 
                                                                                                            ?></td>
                                </tr>
                                <?php //
                                //     $i++;
                                // } 
                                ?>
                                <tr style="height:1px !important">
                                    <td style="height:1px !important"> </td>
                                    <td style="height:1px !important">
                                        <hr style=" border-top: 1px solid black; margin: 0; padding: 0">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" style="margin-right: 2px;"></td>
                                    <td width='' class="value-bold" style="text-align: right"> <?php // $nominal 
                                                                                                ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="height: 2px !important">
                        <td class="" style="height: 2px !important"> &nbsp;</td>
                    </tr>
                    <?php // } 
                    ?>
                    <tr>
                        <td class="value-big" style="padding-bottom: 50px: ; padding-left: 50px"> <?php // $nominal 
                                                                                                    ?></td>
                        <td width="50%">

                            <table width="100%">
                                <tr>
                                    <td width='100%' class="value" style="text-align: center;"><?php // $date 
                                                                                                ?></td>
                                </tr>

                                <tr style="height:100px !important">
                                    <td style="height:100px !important"> </td>
                                </tr>
                                <tr>
                                    <td width='100%' class="value-bold" style="text-align: center; text-weight: bold"><?php // $to 
                                                                                                                        ?></td>
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

    <script src="<?= base_url() ?>assets/plugins/jQuery/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // window.print();
            // var beforePrint = function() {};
            // var afterPrint = function() {
            //     window.close();
            //     console.log('re')
            // };

            // if (window.matchMedia) {
            //     var mediaQueryList = window.matchMedia('print');
            //     mediaQueryList.addListener(function(mql) {
            //         if (mql.matches) {
            //             beforePrint();
            //         } else {
            //             afterPrint();
            //         }
            //     });
            // }

            // window.onbeforeprint = beforePrint;
            // window.onafterprint = afterPrint;
        });
    </script>

</body>

</html>