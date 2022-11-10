<div class="card card-custom position-relative overflow-hidden" id="print-section">
    <?php

    use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Floor;

    ?>
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-9">
            <div class="d-flex font-size-sm flex-wrap">
                <?php
                if ($dataContent['status_shp'] == '1') {
                    echo '
                        <a href="' . base_url('pembayaran/show/' . $dataContent['id_pembayaran']) . '">
                    <div class="alert alert-custom alert-outline-2x alert-outline-primary fade show mr-3" style="padding:  5px; margin: 2px" role="alert">
                                <div class="alert-icon"><i class="flaticon2-checkmark"></i></div>
                                <div class="alert-text mr-2">Sudah Terbit Pembayaran<br> <small>klik untuk lihat pembayaran</small></div>
                            </div>

                        ';
                } else if ($dataContent['status_shp'] == '0') {
                    echo '<div class="alert alert-custom alert-outline-2x alert-outline-danger fade show mr-3" style="padding-bottom:  0px;padding-top:  0px; margin: 2px" role="alert">
                                <div class="alert-icon"><i class="flaticon2-exclamation"></i></div>
                                <div class="alert-text mr-2">Belum ada Pembayaran</div>
                            </div>
                        ';
                }
                ?>

                <!-- <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1" onclick="printDiv('print-section')">Print Invoice</button> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle py-3 mr-3 mr-sm-14 my-1 font-weight-bolder" style="width : 200px" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">File</button>
                    <div class="dropdown-menu">
                        <a type="button" href="<?= base_url('shp/pdf/') . $dataContent['id_shp'] ?>" class="dropdown-item"> <i class="fa fa-download mr-2" aria-hidden="true"></i> PDF</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle py-3 mr-3 mr-sm-14 my-1 font-weight-bolder" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                    <div class="dropdown-menu">
                        <a type="button" href="<?php echo base_url() . 'pembayaran/create_pembayaran_shp/' . $dataContent['id_shp'] ?>" class="dropdown-item"><i class="fas fa-pencil-alt mr-2"></i> Buatkan Pembayaran</a>
                        <a type="button" href="<?php echo base_url() . 'invoice/create_shp/' . $dataContent['id_shp'] ?>" class="dropdown-item"><i class="fas fa-pencil-alt mr-2"></i> Buatkan Invoice</a>
                        <a type="button" href="<?php echo base_url() . 'invoice/create_def_shp/' . $dataContent['id_shp'] ?>" class="dropdown-item"><i class="fas fa-pencil-alt mr-2"></i> Buatkan Invoice Definitif</a>
                        <?php if (!empty($dataContent['id_pembayaran'])) { ?>
                            <a type="button" href="<?php echo base_url() . 'pembayaran/show/' . $dataContent['id_pembayaran'] ?>" class="dropdown-item"><i class="fas fa-pencil-alt mr-2"></i> Lihat Pembayaran</a>
                            <a type="button" href="<?php echo base_url() . 'statements/show/' . $dataContent['id_jurnal'] ?>" class="dropdown-item"><i class="fas fa-pencil-alt mr-2"></i> Lihat Jurnal Pembayaran</a>
                        <?php    } else { ?>
                            <a type="button" href="<?php echo base_url() . 'shp/edit/' . $dataContent['id_shp'] ?>" class="dropdown-item"><i class="fas fa-pencil-alt mr-2"></i> Edit</a>
                            <a type="button" href="<?php echo base_url() . 'shp/copy/' . $dataContent['id_shp'] ?>" class="dropdown-item"><i class="fas fa-copy mr-2"> </i> Copy</a>
                            <a type="button" class="dropdown-item" href="<?= base_url() . 'shp/delete/' . $dataContent['id_shp']   ?>"><i class="fa fa-trash mr-2"></i> Delete </a>
                        <?php } ?>
                    </div>
                </div>
                <!-- <a type="button" href="<?= base_url('shp') ?>" class="btn btn-light-primary font-weight-bolder mr-3 my-1"><i class="fas fa-reply mr-3 my-1"> </i>Create New Invoice</a> -->
            </div>
        </div>
    </div>
    <div class="row justify-content-center py-12 px-12 py-md-12 px-md-0">
        <div class="col-md-11">
            <!--begin::Invoice body-->
            <div class="row pb-4">
                <div class="col-md-3 border-right-md pr-md-10 py-md-10">
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Agent</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['agentname'] ?>
                        <hr>
                    </div>
                    <div class="text-dark font-size-lg font-weight-bold mb-3">
                        <h4>Data Mitra</h4>
                    </div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Nama</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['customer_name'] ?>
                        <br /><?= $dataContent['cus_address'] ?>
                    </div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">KTP</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['ktp'] ?> </div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">NPWP</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['npwp'] ? $dataContent['npwp'] : '-' ?></div>
                    <!--begin::Invoice No-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Zona </div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['nama_zona']  ?></div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Wilayah </div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['nama_wilayah']  ?></div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Lokasi</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['lokasi'] ?></div>
                    <!--end::Invoice No-->
                    <!--begin::Invoice Date-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Metode Pengujian</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['metode_pengujian'] ?></div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Tanggal Penerimaan</div>
                    <div class="font-size-lg font-weight-bold mb-3"><?= $dataContent['date_penerimaan'] ?></div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-1">Tanggal Analisis</div>
                    <div class="font-size-lg font-weight-bold"><?= $dataContent['date_analisis'] ?></div>
                    <!--end::Invoice Date-->
                </div>
                <div class="col-md-9 py-10 pl-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">Kode Biji Timah</th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Kadar Sn</th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Berat (Kg)</th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Harga</th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $total_qyt = 0;
                                if ($dataContent['child']  != NULL) {
                                    foreach ($dataContent['child'] as $item) {
                                        $total = $total + ($item['amount']);
                                        $total_qyt =  $total_qyt + ($item['berat']);;

                                ?>
                                        <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                            <td class="border-top-0 pl-0 pl-md-5 py-4 d-flex align-items-center">
                                                <span class="navi-icon mr-2">
                                                    <i class="fa fa-genderless text-primary font-size-h2"></i>
                                                </span><?= $item['kode_timah'] ?>
                                            </td>
                                            <td class="border-top-0 text-center py-4"><?= floatval($item['kadar']) ?></td>
                                            <td class="border-top-0 text-center py-4"><?= floatval($item['berat']) ?></td>
                                            <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-bolder text-right"><?= number_format(($item['harga']), 0, ',', '.') ?></td>
                                            <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-bolder text-right"><?= number_format(($item['amount']), 0, ',', '.')  ?></td>
                                        </tr>
                                <?php }
                                } ?>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder  font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-center pr-0 font-weight-bolder  font-size-lg text-uppercase"><?= $total_qyt ?></th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-boldest text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 pr-0 text-right font-weight-boldest  font-size-lg text-uppercase"><?= number_format(($total), 0, ',', '.') ?></th>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-md-7  float-right">
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
                                    <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($dataContent['sub_total']), 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <br>
                            <div class="bg-warning rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
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
                                <div class="font-weight-boldest font-size-h5">Transaksi Sebelumnya</div>
                                <div class="text-right d-flex flex-column">
                                    <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($dataContent['tx_sebelumnya']), 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <br>
                            <div class="bg-warning rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
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
                                <div class="font-weight-boldest font-size-h5">Total Transaksi</div>
                                <div class="text-right d-flex flex-column">
                                    <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($dataContent['tx_sebelumnya'] + $dataContent['sub_total']), 0, ',', '.') ?></span>
                                </div>
                            </div> <?php
                                    if ($dataContent['percent_pph_21'] > 0) {
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
                                    <div class="font-weight-boldest font-size-h5">PPh <?= floatval($dataContent['percent_pph_21']) ?>%</div>
                                    <div class="text-right d-flex flex-column">
                                        <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format($dataContent['am_pph_21'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php
                                    }
                            ?>
                            <?php
                            if ($dataContent['percent_oh'] > 0) {
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
                                    <div class="font-weight-boldest font-size-h5">OH <?= floatval($dataContent['percent_oh']) ?>%</div>
                                    <div class="text-right d-flex flex-column">
                                        <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format($dataContent['am_oh'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <?php
                            if ($dataContent['percent_profit'] > 0) {
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
                                    <div class="font-weight-boldest font-size-h5">Profit IMA <?= floatval($dataContent['percent_profit']) ?>%</div>
                                    <div class="text-right d-flex flex-column">
                                        <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format($dataContent['am_profit'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php
                            }
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
                                    <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($dataContent['total_final']), 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- begin: Invoice action-->

    <!-- end: Invoice action-->
</div>
<div class="card card-custom">
    <div class="card-body">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Transaksi Sebelumnya </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>PPh 21 (%)</th>
                                    <th>PPh 21 (Rp) </th>
                                    <th>Transaksi (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_tr = 0;
                                $total_pph = 0;
                                foreach ($riwayat as $r) {
                                    $total_tr = $total_tr + $r['sub_total_2'];
                                    $total_pph = $total_pph + $r['am_pph_21'];
                                ?>
                                    <tr>
                                        <td><?= $r['date'] ?></td>
                                        <td><?= floatval($r['percent_pph_21']) ?></td>
                                        <td class="text-right"><?= number_format($r['am_pph_21'], 0, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format($r['sub_total_2'], 0, ',', '.') ?></td>
                                        <td><?= '<a target="_blank" href=' . base_url('pembayaran/show/') . $r['id'] . '>Check<a>' ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td></td>
                                    <td class="text-right"><?= number_format($total_pph, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($total_tr, 0, ',', '.') ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-custom">
    <div class="card-body">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Dokumen Lainnya </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th>Agent</th>
                                    <th>PPh 21 (Rp) </th>
                                    <th>Transaksi (Rp)</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                    <td><b>Pembayaran Mitra</b></td>
                                    <td><?=$dataContent['agentname']?></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td><?= '<a target="_blank" href=' . base_url('pembayaran/show/') . $dataContent['id_pembayaran'] . '>Lihat<a>' ?></td>
                                     </tr>   <?php
                                $total_tr = 0;
                                $total_pph = 0;
                                foreach ($invoice as $r) {
                                   ?>
                                    <tr>
                                        <td><b><?=$r['jenis_invoice'] == '6'? 'Invoice Angsuran':'Invoice Definitif'?></b><br><?= $r['date'] ?></td>
                                        <td><?= $r['acc_0'] ?></td>
                                        <td class="text-right"><?= number_format($r['sub_total'], 0, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format($r['total_final'], 0, ',', '.') ?></td>
                                        <td><?= '<a target="_blank" href=' . base_url('invoice/show/') . $r['id'] . '>Lihat<a>' ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pelunasan_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="pelunasan_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <div class="row"> -->
                    <div class="form-group">
                        <input name="id" id="id" value="" type="hidden" />
                        <input name="parent_id" id="parent_id" value="<?= $dataContent['id'] ?>" type="hidden" required />
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="date_pembayaran" id="date_pembayaran" required />
                    </div>
                    <div class="row">
                        <div class="col-lg-6">

                            <label>Metode</label>
                            <div class="form-group">
                                <select name="payment_metode" id="payment_metode" class="form-control input-lg">
                                    <?php
                                    foreach ($ref_account as $ji) {
                                        echo '<option value="' . $ji['ref_id'] . '">' . $ji['ref_text'] . '</option>';
                                    } ?>
                                    <!-- <option value="2" selected> Transfer Mandiri A (112-0098146017) </option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label>Nominal</label>
                                <input type="text" class="form-control mask" name="nominal" id="nominal" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="">
                        <a class="btn btn-light my-1 mr-sm-2" id="btn_add_potongan"><strong>Tambahkan Potongan</strong></a>
                    </div>
                    <div class="col-lg-12" id="freame_potongan">

                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Disetujui</label>
                                    <select name="acc_1" id="acc_1" class="form-control">
                                        <option value="0"> ----- </option>
                                        <option value="7"> SETIAWAN R </option>
                                        <option value="14"> RONY MALINO </option>
                                        <option value="15"> DUDY </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id='label_kendaraan'>
                                    <label>Diverifikasi</label>
                                    <select name="acc_2" id="acc_2" class="form-control">
                                        <option value="0"> ----- </option>
                                        <option value="8"> PURWADI </option>
                                        <option value="10"> RAHMAT </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id='label_kendaraan'>
                                    <label>Dibuat</label>
                                    <select name="acc_3" id="acc_3" class="form-control">
                                        <option value="0"> ----- </option>
                                        <option value="9"> A SISWANTO </option>
                                        <option value="12"> DEFRYANTO </option>
                                        <option value="11"> NURHASANAH </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id='label_kendaraan'>
                                    <label>Dibukukan</label>
                                    <input type="text" disabled id="acc_0" class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Add Data</strong></button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Save Change</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#menu_id_6').addClass('menu-item-active menu-item-open menu-item-here"');
    $('#submenu_id_13').addClass('menu-item-active');
    $(document).ready(function() {
        var add_pelunasan = $('#add_pelunasan');
        var btn_print_kwitansi = $('#btn_print_kwitansi');
        var btn_print_dokumen = $('#btn_print_dokumen');
        var freame_potongan = $('#freame_potongan');
        var btn_add_potongan = $('#btn_add_potongan');

        var row_num = 1;

        function add_row(dat = false) {


            var layout_potongan = `
                            <hr>
                            <h2>Potongan ke ${row_num}</h2>
                            <div class="row" id="row_pelunasan_${row_num}">
                            <div class="form-group col-lg-6">
                             <label> Akun Potongan </label>
                             <select name="ac_potongan[]" id="ac_potongan_${row_num}" ${dat ? 'value="'+dat['ac_potongan']+'"' : ''} class="form-control select2">
                                 <?php
                                    foreach ($accounts as $lv1) {
                                        foreach ($lv1['children'] as $lv2) {
                                            echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                            foreach ($lv2['children'] as $lv3) {
                                                if (empty($lv3['children'])) {
                                                    echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                    echo '</option>';
                                                } else {
                                                    echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                                                    foreach ($lv3['children'] as $lv4) {
                                                        echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                                        echo '</option>';
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                            echo '</optgroup>';
                                        }
                                    }
                                    ?>
                             </select>
                         </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label>Nominal Potongan</label>
                                <input type="text" class="form-control mask" name="ac_nominal[]" id="ac_nominal_${row_num}" ${dat ? 'value="'+dat['ac_nominal']+'"' : ''}  />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Keterangn Potongan</label>
                            <input type="text" class="form-control" name="ac_desk[]" id="ac_desk_${row_num}"  ${dat ? 'value="'+dat['ac_desk']+'"' : ''} />
                        </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                            <label>Nomor Bukti Potongan</label>
                            <input type="text" class="form-control" name="no_bukti[]" id="no_bukti_${row_num}" ${dat ? 'value="'+dat['no_bukti']+'"' : ''}  />
                        </div>
                        </div>
                     </div>
                </div>
                    `;
            freame_potongan.append(layout_potongan);
            // freame_potongan.select2();
            $('#ac_potongan_' + row_num).select2()
            if (dat) $('#ac_potongan_' + row_num).val(dat['ac_potongan']).change();
            $('.mask').mask('000.000.000.000.000,00', {
                reverse: true
            });
            row_num++;
        }
        btn_add_potongan.on('click', () => {
            console.log('adds')
            add_row()
        })
        var dataPayments = [];
        var PelunasanModal = {
            'self': $('#pelunasan_modal'),
            'info': $('#pelunasan_modal').find('.info'),
            'form': $('#pelunasan_modal').find('#pelunasan_form'),
            'addBtn': $('#pelunasan_modal').find('#add_btn'),
            'saveEditBtn': $('#pelunasan_modal').find('#save_edit_btn'),
            'id': $('#pelunasan_modal').find('#id'),
            'parent_id': $('#pelunasan_modal').find('#parent_id'),
            'date_pembayaran': $('#pelunasan_modal').find('#date_pembayaran'),
            'nominal': $('#pelunasan_modal').find('#nominal'),
            'acc_1': $('#pelunasan_modal').find('#acc_1'),
            'acc_2': $('#pelunasan_modal').find('#acc_2'),
            'acc_3': $('#pelunasan_modal').find('#acc_3'),
            'acc_0': $('#pelunasan_modal').find('#acc_0'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            deferRender: false,
            order: false

        });


        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
            reverseButtons: true
        };

        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };

        add_pelunasan.on('click', (e) => {
            PelunasanModal.form.trigger('reset');
            PelunasanModal.self.modal('show');
            PelunasanModal.addBtn.show();
            PelunasanModal.saveEditBtn.hide();
            form_reset()
        });

        function form_reset() {
            freame_potongan.html('');
            PelunasanModal.id.val('');
            PelunasanModal.nominal.val('');
            PelunasanModal.date_pembayaran.val('<?= date('Y-m-d') ?>');
        }
        getAllPelunsan()

        function getAllPelunsan() {
            swal.fire({
                title: 'Loading Invoice...',
                allowOutsideClick: false
            });
            swal.showLoading();
            return $.ajax({
                url: `<?php echo base_url('General/getAllPelunasanInvoice') ?>`,
                'type': 'GET',
                data: {
                    'parent_id': '<?= $dataContent['id'] ?>',
                    'by_id': true,
                    'get_potongan': true
                },
                success: function(data) {
                    swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataPayments = json['data'];
                    renderPayments(dataPayments);
                },
                error: function(e) {}
            });
        }


        function renderPayments(data) {
            if (data == null || typeof data != "object") {
                return;
            }
            var i = 0;

            var renderData = [];
            <?php if (!empty($dataContent['general_id_ppn'])) { ?>
                link = '<a href="<?= base_url() ?>statements/show/<?= $dataContent['general_id_ppn'] ?>"> PPN <?= $dataContent['no_jurnal_ppn'] ?> </a>'
                renderData.push(['<?= $dataContent['gen_ppn_date'] ?>', '<?= number_format(0, 2, ',', '.') ?>', '<?= $dataContent['acc_0'] ?>', link, '']);
            <?php   } ?>
            link = '<a href="<?= base_url() ?>statements/show/<?= $dataContent['general_id'] ?>"> <?= $dataContent['no_jurnal'] ?> </a>'
            renderData.push(['<?= $dataContent['gen_date'] ?>', '<?= number_format(0, 2, ',', '.') ?>', '<?= $dataContent['acc_0'] ?>', link, '']);
            total = 0;
            Object.values(data).forEach((d) => {
                link = `<a href="<?= base_url() ?>statements/show/${d['general_id']}"> ${d['no_jurnal']}</a>`;
                var editButton = `
                <button type="button" class="edit btn btn-primary  btn-icon" data-id='${d['id']}' title="Edit"><i class='la la-pencil-alt'></i></button>
                `;
                var deleteButton = `
                <button  type="button" class="delete btn btn-danger btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                `;
                var printButton = `
                <a  type="button" class="print btn btn-light btn-icon" target="_blank" href='<?= base_url() ?>shp/print_kwitansi_pembayaran/<?= $dataContent['id'] ?>/${d['id']}'   title="Print"><i class='la la-print'></i></a>
                `;

                // <button type="button" class="btn btn-outline-secondary btn-icon"><i class="la la-file-text-o"></i></button>
                // <button type="button" class="btn btn-outline-secondary btn-icon"><i class="la la-bold"></i></button>
                // <button type="button" class="btn btn-outline-secondary btn-icon"><i class="la la-paperclip"></i></button>

                var button = `   <div class="btn-group mr-2" role="group" aria-label="...">  ${ printButton+ editButton + deleteButton  }    </div> `;
                renderData.push([d['date_pembayaran'], formatRupiah2(d['sum_child']), d['agentname'], link, button]);
                total = parseFloat(total) + parseFloat(d['sum_child']);
                // console.log(d['nominal'])
            });
            renderData.push(['<b>Total Dibayarkan</b>', '<b> Rp. ' + formatRupiah2(total) + '</b>', '', '', '']);
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function formatRupiah2(angka, prefix) {
            var number_string = angka.toString();
            expl = number_string.split(".", 2);
            // console.log("ex");
            if (expl[1] == undefined) {
                expl[1] = "00";
            } else {
                if (expl[1].length == 1) expl[1] = expl[1] + "0";
                else expl[1] = expl[1].slice(0, 2);
            }

            sisa = expl[0].length % 3;
            (rupiah = expl[0].substr(0, sisa)),
            (ribuan = expl[0].substr(sisa).match(/\d{3}/gi));

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = expl[1] != undefined ? rupiah + "," + expl[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }


        FDataTable.on('click', '.edit', function() {
            form_reset();
            PelunasanModal.form.trigger('reset');
            PelunasanModal.self.modal('show');
            PelunasanModal.addBtn.hide();
            PelunasanModal.saveEditBtn.show();
            var currentData = dataPayments[$(this).data('id')];
            console.log($(this).data('id'))
            console.log(currentData);
            PelunasanModal.id.val(currentData['id']);
            PelunasanModal.acc_1.val(currentData['acc_1']);
            PelunasanModal.acc_2.val(currentData['acc_2']);
            PelunasanModal.acc_3.val(currentData['acc_3']);
            PelunasanModal.acc_0.val(currentData['acc_0']);
            PelunasanModal.date_pembayaran.val(currentData['date_pembayaran']);
            PelunasanModal.nominal.val(formatRupiah2(currentData['nominal']));
            currentData['data_potongan'].forEach((child) => {
                console.log(child)
                add_row(child);
            })
        })

        // FDataTable.on('click', '.print', function() {
        //     var currentData = dataPayments[$(this).data('id')];
        //     print_kwitansi(currentData['nominal'], currentData['date_pembayaran'], '')
        // })


        function print_kwitansi(nominal, date, item) {
            // getss = `to=<?= !empty($dataContent['name_acc_1']) ? $dataContent['name_acc_1'] : 'PT Indometal Asia' ?>&from=<?= !empty($customer_data[0]['customer_name']) ? $customer_data[0]['customer_name']  : '' ?>&date=${date}&nominal=${nominal}&description=<?= $dataContent['description'] ?>${item}`;
            // url = "<?= base_url('shp/kwitansi_print/' . $dataContent['id']) ?>?" + getss;
            // window.open(url, "_blank");
        };

        btn_print_kwitansi.on('click', () => {
            url = "<?= base_url('shp/kwitansi_print/' . $dataContent['id']) ?>?";
            window.open(url, "_blank");
        });

        btn_print_dokumen.on('click', () => {
            url = "<?= base_url('shp/print/' . $dataContent['id']) ?>";
            window.open(url, "_blank");
        });

        PelunasanModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = PelunasanModal.addBtn.is(':visible');
            var url = "<?= base_url('shp/') ?>";
            url += isAdd ? "addPelunasan" : "editPelunasan";
            var button = isAdd ? PelunasanModal.addBtn : PelunasanModal.saveEditBtn;

            Swal.fire(swalSaveConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                swal.fire({
                    title: 'Loading ...',
                    allowOutsideClick: false
                });
                swal.showLoading();
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(PelunasanModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        swal.fire("Simpan Berhasil", "", "success");

                        location.reload();
                        //  return;
                        // var d = json['data']
                        // dataPayments[d['id']] = d;
                        // renderPayments(dataPayments);
                        // PelunasanModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        FDataTable.on('click', '.delete', function() {
            var currentData = $(this).data('id');
            Swal.fire(swalDeleteConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                $.ajax({
                    url: "<?= base_url('shp/deletePelunasan') ?>",
                    'type': 'post',
                    data: {
                        'id': currentData
                    },

                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Delete Gagal", json['message'], "error");
                            return;
                        }
                        //  return;
                        swal.fire("Delete Berhasil", "", "success");
                        location.reload();

                        // renderPayments(dataPayments);
                        // PaymentModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });

        })

        $('.mask').mask('000.000.000.000.000,00', {
            reverse: true
        });
    });
</script>