<div class="card card-custom position-relative overflow-hidden" id="print-section">
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-9">
            <div class="d-flex font-size-sm flex-wrap">
                <a type="button" href="<?= base_url('usaha/cetak_nota/') . $dataContent['id'] ?>" class="btn btn-primary font-weight-bolder py-3 mr-3 mr-sm-14 my-1">Cetak Nota</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-9">
            <div class="row pb-4">
                <div class="col-md-3 border-right-md pr-md-10 py-md-10">
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">INVOICE NO.</div>
                    <div class="font-size-lg font-weight-bold mb-10"><?= $dataContent['no_invoice'] ?></div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">DATE</div>
                    <div class="font-size-lg font-weight-bold"><?= $dataContent['date'] ?></div>
                </div>
                <div class="col-md-9 py-10 pl-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">Keterangan</th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Qyt</th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Harga</th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $total_qyt = 0;
                                if ($dataContent['item']  != NULL) {
                                    foreach ($dataContent['item'] as $item) {
                                        $total = $total + ($item->amount * $item->qyt);
                                        $total_qyt =  $total_qyt + ($item->qyt);;

                                ?>
                                        <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                            <td class="border-top-0 pl-0 pl-md-5 py-4 d-flex align-items-center">
                                                <span class="navi-icon mr-2">
                                                    <i class="fa fa-genderless text-primary font-size-h2"></i>
                                                </span><?= $item->keterangan_item ?>
                                            </td>
                                            <td class="border-top-0 text-right py-4"><?= $item->date_item ?></td>
                                            <td class="border-top-0 text-right py-4"><?= $item->qyt . $item->satuan ?></td>
                                            <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right"><?= number_format(($item->amount), 2, ',', '.') ?></td>
                                            <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right currency"><?= number_format(($item->amount * $item->qyt), 2, ',', '.')  ?></td>
                                        </tr>
                                <?php }
                                } ?>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder  font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder  font-size-lg text-uppercase"><?= $total_qyt ?></th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder  font-size-lg text-uppercase"><?= number_format(($total), 2, ',', '.') ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Invoice body-->
            <!--begin::Invoice footer-->
            <div class="row">
                <div class="col-md-5 border-top pt-14 pb-10 pb-md-10">
                    <?php
                    if ($dataContent['payment_metode'] != 99) {
                    ?>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="d-flex flex-column">
                                <div class="font-weight-bold font-size-h6 mb-3">BANK TRANSFER</div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Bank :</span>
                                    <span class="text-right"><?= $dataContent['bank_name'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Account Name:</span>
                                    <span class="text-right"><?= $dataContent['title_bank'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Account Number:</span>
                                    <span class="text-right"><?= $dataContent['bank_number'] ?></span>
                                </div>
                            </div>
                        </div>

                    <?php
                    } else {
                    ?>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="d-flex flex-column">
                                <div class="font-weight-bold font-size-h6 mb-3">CASH</div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-7 pt-md-25">
                    <div class="bg-primary rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                        <!--begin::Shape-->
                        <div class="position-absolute opacity-30 top-0 right-0">
                            <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
                                <!--begin::Svg Icon | path:assets/media/svg/shapes/abstract-8.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="176" height="165" viewBox="0 0 176 165" fill="none">
                                    <g clip-path="url(#clip0)">
                                        <path d="M-10.001 135.168C-10.001 151.643 3.87924 165.001 20.9985 165.001C38.1196 165.001 51.998 151.643 51.998 135.168C51.998 118.691 38.1196 105.335 20.9985 105.335C3.87924 105.335 -10.001 118.691 -10.001 135.168Z" fill="#AD84FF" />
                                        <path d="M28.749 64.3117C28.749 78.7296 40.8927 90.4163 55.8745 90.4163C70.8563 90.4163 83 78.7296 83 64.3117C83 49.8954 70.8563 38.207 55.8745 38.207C40.8927 38.207 28.749 49.8954 28.749 64.3117Z" fill="#AD84FF" />
                                        <path d="M82.9996 120.249C82.9996 144.964 103.819 165 129.501 165C155.181 165 176 144.964 176 120.249C176 95.5342 155.181 75.5 129.501 75.5C103.819 75.5 82.9996 95.5342 82.9996 120.249Z" fill="#AD84FF" />
                                        <path d="M98.4976 23.2928C98.4976 43.8887 115.848 60.5856 137.249 60.5856C158.65 60.5856 176 43.8887 176 23.2928C176 2.69692 158.65 -14 137.249 -14C115.848 -14 98.4976 2.69692 98.4976 23.2928Z" fill="#AD84FF" />
                                        <path d="M-10.0011 8.37466C-10.0011 20.7322 0.409554 30.7493 13.2503 30.7493C26.0911 30.7493 36.5 20.7322 36.5 8.37466C36.5 -3.98287 26.0911 -14 13.2503 -14C0.409554 -14 -10.0011 -3.98287 -10.0011 8.37466Z" fill="#AD84FF" />
                                        <path d="M-2.24881 82.9565C-2.24881 87.0757 1.22081 90.4147 5.50108 90.4147C9.78135 90.4147 13.251 87.0757 13.251 82.9565C13.251 78.839 9.78135 75.5 5.50108 75.5C1.22081 75.5 -2.24881 78.839 -2.24881 82.9565Z" fill="#AD84FF" />
                                        <path d="M55.8744 12.1044C55.8744 18.2841 61.0788 23.2926 67.5001 23.2926C73.9196 23.2926 79.124 18.2841 79.124 12.1044C79.124 5.92653 73.9196 0.917969 67.5001 0.917969C61.0788 0.917969 55.8744 5.92653 55.8744 12.1044Z" fill="#AD84FF" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Shape-->
                        <div class="font-weight-boldest font-size-h5">TOTAL</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($total), 2, ',', '.') ?></span>
                        </div>
                    </div>
                    <?php
                    if ($dataContent['ppn_pph'] == 1) {
                        $tmp1 = $total * 0.10;
                        $total = $total + $tmp1;
                    } else {
                        $tmp1 = 0;
                    }
                    ?>
                    <br>
                    <div class="bg-info rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                        <!--begin::Shape-->
                        <div class="position-absolute opacity-30 top-0 right-0">
                            <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
                                <!--begin::Svg Icon | path:assets/media/svg/shapes/abstract-8.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="176" height="165" viewBox="0 0 176 165" fill="none">
                                    <g clip-path="url(#clip0)">
                                        <path d="M-10.001 135.168C-10.001 151.643 3.87924 165.001 20.9985 165.001C38.1196 165.001 51.998 151.643 51.998 135.168C51.998 118.691 38.1196 105.335 20.9985 105.335C3.87924 105.335 -10.001 118.691 -10.001 135.168Z" fill="#AD84FF" />
                                        <path d="M28.749 64.3117C28.749 78.7296 40.8927 90.4163 55.8745 90.4163C70.8563 90.4163 83 78.7296 83 64.3117C83 49.8954 70.8563 38.207 55.8745 38.207C40.8927 38.207 28.749 49.8954 28.749 64.3117Z" fill="#AD84FF" />
                                        <path d="M82.9996 120.249C82.9996 144.964 103.819 165 129.501 165C155.181 165 176 144.964 176 120.249C176 95.5342 155.181 75.5 129.501 75.5C103.819 75.5 82.9996 95.5342 82.9996 120.249Z" fill="#AD84FF" />
                                        <path d="M98.4976 23.2928C98.4976 43.8887 115.848 60.5856 137.249 60.5856C158.65 60.5856 176 43.8887 176 23.2928C176 2.69692 158.65 -14 137.249 -14C115.848 -14 98.4976 2.69692 98.4976 23.2928Z" fill="#AD84FF" />
                                        <path d="M-10.0011 8.37466C-10.0011 20.7322 0.409554 30.7493 13.2503 30.7493C26.0911 30.7493 36.5 20.7322 36.5 8.37466C36.5 -3.98287 26.0911 -14 13.2503 -14C0.409554 -14 -10.0011 -3.98287 -10.0011 8.37466Z" fill="#AD84FF" />
                                        <path d="M-2.24881 82.9565C-2.24881 87.0757 1.22081 90.4147 5.50108 90.4147C9.78135 90.4147 13.251 87.0757 13.251 82.9565C13.251 78.839 9.78135 75.5 5.50108 75.5C1.22081 75.5 -2.24881 78.839 -2.24881 82.9565Z" fill="#AD84FF" />
                                        <path d="M55.8744 12.1044C55.8744 18.2841 61.0788 23.2926 67.5001 23.2926C73.9196 23.2926 79.124 18.2841 79.124 12.1044C79.124 5.92653 73.9196 0.917969 67.5001 0.917969C61.0788 0.917969 55.8744 5.92653 55.8744 12.1044Z" fill="#AD84FF" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Shape-->
                        <div class="font-weight-boldest font-size-h5">PPn 10%</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format($tmp1, 2, ',', '.') ?></span>
                        </div>
                    </div>
                    <?php
                    // }
                    ?>
                    <br>
                    <div class="bg-success rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                        <!--begin::Shape-->
                        <div class="position-absolute opacity-30 top-0 right-0">
                            <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
                                <!--begin::Svg Icon | path:assets/media/svg/shapes/abstract-8.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="176" height="165" viewBox="0 0 176 165" fill="none">
                                    <g clip-path="url(#clip0)">
                                        <path d="M-10.001 135.168C-10.001 151.643 3.87924 165.001 20.9985 165.001C38.1196 165.001 51.998 151.643 51.998 135.168C51.998 118.691 38.1196 105.335 20.9985 105.335C3.87924 105.335 -10.001 118.691 -10.001 135.168Z" fill="#AD84FF" />
                                        <path d="M28.749 64.3117C28.749 78.7296 40.8927 90.4163 55.8745 90.4163C70.8563 90.4163 83 78.7296 83 64.3117C83 49.8954 70.8563 38.207 55.8745 38.207C40.8927 38.207 28.749 49.8954 28.749 64.3117Z" fill="#AD84FF" />
                                        <path d="M82.9996 120.249C82.9996 144.964 103.819 165 129.501 165C155.181 165 176 144.964 176 120.249C176 95.5342 155.181 75.5 129.501 75.5C103.819 75.5 82.9996 95.5342 82.9996 120.249Z" fill="#AD84FF" />
                                        <path d="M98.4976 23.2928C98.4976 43.8887 115.848 60.5856 137.249 60.5856C158.65 60.5856 176 43.8887 176 23.2928C176 2.69692 158.65 -14 137.249 -14C115.848 -14 98.4976 2.69692 98.4976 23.2928Z" fill="#AD84FF" />
                                        <path d="M-10.0011 8.37466C-10.0011 20.7322 0.409554 30.7493 13.2503 30.7493C26.0911 30.7493 36.5 20.7322 36.5 8.37466C36.5 -3.98287 26.0911 -14 13.2503 -14C0.409554 -14 -10.0011 -3.98287 -10.0011 8.37466Z" fill="#AD84FF" />
                                        <path d="M-2.24881 82.9565C-2.24881 87.0757 1.22081 90.4147 5.50108 90.4147C9.78135 90.4147 13.251 87.0757 13.251 82.9565C13.251 78.839 9.78135 75.5 5.50108 75.5C1.22081 75.5 -2.24881 78.839 -2.24881 82.9565Z" fill="#AD84FF" />
                                        <path d="M55.8744 12.1044C55.8744 18.2841 61.0788 23.2926 67.5001 23.2926C73.9196 23.2926 79.124 18.2841 79.124 12.1044C79.124 5.92653 73.9196 0.917969 67.5001 0.917969C61.0788 0.917969 55.8744 5.92653 55.8744 12.1044Z" fill="#AD84FF" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Shape-->
                        <div class="font-weight-boldest font-size-h5">TOTAL</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($total), 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Invoice footer-->
        </div>
    </div>
    <!-- begin: Invoice action-->

    <!-- end: Invoice action-->
</div>
<script>
    $('#menu_id_6').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_13').addClass('menu-item-active')
</script>