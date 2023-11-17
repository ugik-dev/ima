<div class="card card-custom position-relative overflow-hidden" id="print-section">
    <?php
    // if ($transaction['notif_status'] == 0) {
    //     echo '
    //     <div class="row col bg-light-danger px-10 py-2 rounded-sm ml-0">
    //         <span class="svg-icon svg-icon-2x svg-icon-danger d-block my-0">
    //             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    //                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    //                     <polygon points="0 0 24 0 24 24 0 24"></polygon>
    //                     <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
    //                     <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
    //                 </g>
    //             </svg>
    //             <!--end::Svg Icon-->
    //         </span>
    //         <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">Belum di buatkan jurnal</a>
    //     </div>
    //     ';
    // }
    // if (!empty($transaction['parent2_id'])) {
    //     echo '
    //     <div class="row col bg-light-success px-10 py-2 rounded-sm ml-0">

    //         <span class="svg-icon svg-icon-2x svg-icon-success d-block my-0">
    //             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    //                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    //                     <polygon points="0 0 24 0 24 24 0 24"></polygon>
    //                     <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
    //                     <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
    //                 </g>
    //             </svg>
    //         </span>
    //         <a href="' . base_url() . 'statements/show/' . $transaction['parent2_id'] . '" class="text-success font-weight-bold font-size-h6 mt-2">Klik untuk lihat jurnal</a>
    //     </div>
    //     ';
    // }
    $acc_role = accounting_role($this->session->userdata('user_id')['id']);
    ?>
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-9">
            <div class="d-flex font-size-sm flex-wrap">
                <?php if ($transaction['status_pembayaran'] == 'paid') {
                    echo '<div class="alert alert-custom alert-outline-2x alert-outline-primary fade show mr-3" style="padding:  5px; margin: 2px" role="alert">
                                <div class="alert-icon"><i class="flaticon2-checkmark"></i></div>
                                <div class="alert-text mr-2">Sudah dibayar</div>
                            </div>
                        ';
                } else {
                    echo '<div class="alert alert-custom alert-outline-2x alert-outline-danger fade show mr-3" style="padding:  5px; margin: 2px" role="alert">
                                <div class="alert-icon"><i class="flaticon2-exclamation"></i></div>
                                <div class="alert-text mr-2">Belum dibayar</div>
                            </div>
                        ';
                } ?>

                <button <?= (($transaction['status_pembayaran'] == 'unpaid') ? '' : 'hidden') ?> type="button" class="btn btn-warning  py-3 mr-2  my-1 font-weight-bolde" id="add_pelunasan" data-toggle="modal" data-target="#exampleModalLong">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Buat Pelunasan
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle py-3 mr-2 my-1 font-weight-bolder" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Files</button>
                    <div class="dropdown-menu">
                        <a type="button" id="btn_print_kwitansi" class="dropdown-item"> <i class="fa fa-print mr-2" aria-hidden="true"></i> Print Kwitansi</a>
                        <a type="button" href="<?= base_url('Pembayaran/download_word/') . $transaction['id'] ?>" class="dropdown-item"> <i class="fa fa-download mr-2" aria-hidden="true"></i>Doc Pembayaran Mitra</a>
                        <a type="button" href="<?= base_url('Pembayaran/download_word2/') . $transaction['id'] ?>" class="dropdown-item"> <i class="fa fa-download mr-2" aria-hidden="true"></i> Daftar Kendaraan Insidentil</a>
                        <a type="button" href="<?= base_url('Pembayaran/download_word_reklamasi/') . $transaction['id'] ?>" class="dropdown-item"> <i class="fa fa-download mr-2" aria-hidden="true"></i>Doc Pembayaran Reklamasi</a>
                        <a type="button" href="<?= base_url('Pembayaran/download_word_pengganti_borongan/') . $transaction['id'] ?>" class="dropdown-item"> <i class="fa fa-download mr-2" aria-hidden="true"></i>Doc Nilai Pengganti Borongan</a>
                        <?php if ($transaction['jenis_pembayaran'] == 1) { ?>
                        <?php    } else  if ($transaction['jenis_pembayaran'] == 2) { ?>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($acc_role) { ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle py-3 mr-2  my-1 font-weight-bolder" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Buat Jurnal</button>
                        <div class="dropdown-menu">
                            <a type="button" href="<?= base_url('statements/pembayaran_to_jurnal/') . $transaction['id'] ?>" class="btn mr-3 my-1"> Format 1</a>
                            <a type="button" href="<?= base_url('statements/pembayaran_to_jurnal/') . $transaction['id'] ?>/2" class="btn mr-3 my-1"> Format 2</a>
                        </div>
                    </div>
                <?php } ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle py-3 mr-2 mr-sm-14 my-1 font-weight-bolder" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                    <div class="dropdown-menu">
                        <a type="button" href="<?php echo base_url() . 'Pembayaran/edit/' . $transaction['id'] ?>" class="btn mr-3 my-1"><i class="fas fa-pencil-alt mr-3 my-1"></i> Edit</a>
                        <a type="button" href="<?php echo base_url() . 'Pembayaran/copy/' . $transaction['id'] ?>" class="btn mr-3 my-1"><i class="fas fa-copy mr-3 my-1"> </i> Copy</a>
                        <a type="button" class="dropdown-item" href="<?= base_url() . 'pembayaran/delete/' . $transaction['id']   ?>"><i class="fa fa-trash mr-2"></i> Delete </a>
                        <a type="button" href="<?= base_url('pembayaran') ?>" class="btn mr-3 my-1">Buat Pembayaran Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-9">
            <div class="row pb-4">
                <div class="col-md-3 border-right-md pr-md-10 py-md-10">

                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Pembayaran <?= $transaction['nama_jenis'] ?></div>
                    <div class="font-size-lg font-weight-bold mb-10">

                    </div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Agent.</div>
                    <div class="font-size-lg font-weight-bold mb-10"><?= $transaction['acc_0'] ?>
                    </div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">PEMBAYARAN UNTUK.</div>
                    <div class="font-size-lg font-weight-bold mb-10"><?= !empty($customer_data[0]['customer_name']) ? $customer_data[0]['customer_name']  : '' ?>
                        <br /><?= !empty($customer_data[0]['cus_address']) ? $customer_data[0]['cus_address']  : '' ?>
                    </div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">NUMBER</div>
                    <div class="font-size-lg font-weight-bold mb-10"><?= $transaction['id'] ?></div>
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">TANGGAL</div>
                    <div class="font-size-lg font-weight-bold"><?= $transaction['date'] ?></div>
                </div>
                <div class="col-md-9 py-10 pl-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <?php if ($transaction['jenis_pembayaran'] == 6) { ?>
                                        <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">Nama</th>
                                        <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Lokasi</th>
                                        <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">KG / Kadar</th>
                                        <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Harga</th>
                                        <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Jumlah</th>
                                    <?php } else { ?>
                                        <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">Keterangan</th>
                                        <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase"><?= $transaction['jenis_pembayaran'] == 1 ? '' : 'Pre-Order' ?></th>
                                        <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">Qyt</th>
                                        <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Harga</th>
                                        <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">Jumlah</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $total_qyt = 0;
                                if ($transaction['items']  != NULL) {
                                    foreach ($transaction['items'] as $item) {
                                        $total = $total + ($item['amount'] * $item['qyt']);
                                        $total_qyt =  $total_qyt + ($item['qyt']);
                                        if ($transaction['jenis_pembayaran'] == 6) {

                                ?>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 pl-md-5 py-4 d-flex align-items-center">
                                                    <span class="navi-icon mr-2">
                                                        <i class="fa fa-genderless text-primary font-size-h2"></i>
                                                    </span><?= $item['keterangan_item'] ?>
                                                </td>
                                                <td class="border-top-0 text-right py-4"><?= $item['nopol'] ?></td>
                                                <td class="border-top-0 text-right py-4"><?= $item['date_item']  ?></td>
                                                <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right"><?= number_format(($item['amount']), 0, ',', '.') ?></td>
                                                <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right currency"><?= number_format(($item['amount'] * $item['qyt']), 0, ',', '.')  ?></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 pl-md-5 py-4 d-flex align-items-center">
                                                    <span class="navi-icon mr-2">
                                                        <i class="fa fa-genderless text-primary font-size-h2"></i>
                                                    </span><?= $item['keterangan_item'] ?>
                                                </td>
                                                <td class="border-top-0 text-right py-4"><?= $transaction['jenis_pembayaran'] == 1 ? $item['date_item'] : $item['nopol'] ?></td>
                                                <td class="border-top-0 text-right py-4"><?= floatval($item['qyt']) . ' ' . $item['satuan'] ?></td>
                                                <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right"><?= number_format(($item['amount']), 0, ',', '.') ?></td>
                                                <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right currency"><?= number_format(($item['amount'] * $item['qyt']), 0, ',', '.')  ?></td>
                                            </tr>
                                <?php

                                        }
                                    }
                                } ?>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder  font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder  font-size-lg text-uppercase"><?= $transaction['jenis_pembayaran'] != 6 ? floatval($total_qyt) : '' ?></th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                    <th class="pt-1 pb-9 text-right font-weight-bolder  font-size-lg text-uppercase"><?= number_format(($transaction['sub_total']), 0, ',', '.') ?></th>
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
                    if (!empty($payment_metode['bankname'])) {
                    ?>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="d-flex flex-column">
                                <div class="font-weight-bold font-size-h6 mb-3">BANK TRANSFER</div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Bank : </span>
                                    <span class="text-right"><?= $payment_metode['bankname'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Branch : </span>
                                    <span class="text-right"><?= $payment_metode['branch'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Account Name :</span>
                                    <span class="text-right"><?= $payment_metode['title'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Account Number : </span>
                                    <span class="text-right"><?= $payment_metode['accountno'] ?></span>
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
                        <div class="font-weight-boldest font-size-h5"> SUB TOTAL I</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"> Rp <?= number_format(($total), 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <br>
                    <?php
                    if ($transaction['jenis_pembayaran'] == 2)
                        if (($total % 100) > 0) {
                            $total = (floor($total / 100) * 100)
                    ?>
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
                            <div class="font-weight-boldest font-size-h5"> Pembulatan</div>
                            <div class="text-right d-flex flex-column">
                                <span class="font-weight-boldest font-size-h3 line-height-sm"> Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <br>
                    <?php
                        } ?>
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
                        <div class="font-weight-boldest font-size-h5">Biaya Jasa <?= floatval($transaction['percent_jasa']) ?>%</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"> - Rp <?php
                                                                                                $potongan_jasa = floor($transaction['am_jasa']);
                                                                                                $total = $total - $potongan_jasa;
                                                                                                echo number_format($transaction['am_jasa'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <br>
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
                        <div class="font-weight-boldest font-size-h5"> SUB TOTAL II</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"> Rp <?= number_format(($total), 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <br>
                    <div class="bg-info rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                        <div class="position-absolute opacity-30 top-0 right-0">
                            <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
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
                            </span>
                        </div>
                        <div class="font-weight-boldest font-size-h5">PPH 23 <?= floatval($transaction['percent_pph']) ?>%</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"> - Rp
                                <?php
                                $potongan_pph = floor($transaction['am_pph']);
                                echo number_format($transaction['am_pph'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <br>
                    <div class="bg-info rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                        <div class="position-absolute opacity-30 top-0 right-0">
                            <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
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
                            </span>
                        </div>
                        <div class="font-weight-boldest font-size-h5">PPH 21 <?= floatval($transaction['percent_pph_21']) ?>%</div>
                        <div class="text-right d-flex flex-column">
                            <span class="font-weight-boldest font-size-h3 line-height-sm"> - Rp
                                <?php
                                $potongan_pph_21 = floor($transaction['am_pph_21']);
                                echo number_format($transaction['am_pph_21'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <br>
                    <?php
                    if (($transaction['lebih_bayar_am']) > 0) {
                    ?>
                        <div class="bg-info rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                            <div class="position-absolute opacity-30 top-0 right-0">
                                <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
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
                                </span>
                            </div>
                            <div class="font-weight-boldest font-size-h5">
                                <?= !empty($transaction['lebih_bayar_ket']) ? $transaction['lebih_bayar_ket'] : 'Lebih Bayar';
                                ?>
                            </div>

                            <div class="text-right d-flex flex-column">
                                <span class="font-weight-boldest font-size-h3 line-height-sm">
                                    <?php
                                    // var_dump(stripos(strtolower('LEBIH BAYAR'), 'lebih'));
                                    // if (stripos(strtolower($transaction['par_label']), 'lebih') !== false) {
                                    $total = $total - $transaction['lebih_bayar_am'];
                                    echo '-' . number_format($transaction['lebih_bayar_am'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <br>
                    <?php
                    }


                    if (($transaction['kurang_bayar_am']) > 0) {
                    ?>
                        <div class="bg-info rounded d-flex align-items-center justify-content-between text-white max-w-350px position-relative ml-auto p-7">
                            <div class="position-absolute opacity-30 top-0 right-0">
                                <span class="svg-icon svg-icon-2x svg-logo-white svg-icon-flip">
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
                                </span>
                            </div>
                            <div class="font-weight-boldest font-size-h5">
                                <?= !empty($transaction['kurang_bayar_ket']) ? $transaction['kurang_bayar_ket'] : 'Kurang Bayar';
                                ?>
                            </div>

                            <div class="text-right d-flex flex-column">
                                <span class="font-weight-boldest font-size-h3 line-height-sm">
                                    <?php
                                    // var_dump(stripos(strtolower('LEBIH BAYAR'), 'lebih'));
                                    // if (stripos(strtolower($transaction['par_label']), 'lebih') !== false) {
                                    $total = $total + $transaction['kurang_bayar_am'];
                                    echo '+' . number_format($transaction['kurang_bayar_am'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <br>
                    <?php
                    }
                    ?>

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
                            <span class="font-weight-boldest font-size-h3 line-height-sm"> Rp <?= number_format(($total - $potongan_pph - $potongan_pph_21), 0, ',', '.') ?></span>
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
<div class="card card-custom">
    <div class="card-body">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Data Jurnal </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nominal</th>
                                    <th>Nama Agent </th>
                                    <th>Jurnal </th>

                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pelunasan_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <input name="parent_id" id="parent_id" value="<?= $transaction['id'] ?>" type="hidden" required />
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="date_pembayaran" id="date_pembayaran" required />
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="text" class="form-control mask" name="nominal" id="nominal" required />
                    </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Disetujui</label>
                                <select name="acc_1" id="acc_1" class="form-control">
                                    <option value="0"> ----- </option>
                                    <option value="7"> SETIAWAN R </option>
                                    <option value="19"> Achmad Haspani </option>
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
                                    <option value="21"> AHMAD SYAHFRIADI </option>
                                    <option value="20"> Ahmad Tarmizi </option>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Simpan Data</strong></button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Data</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#menu_id_32').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_87').addClass('menu-item-active')
    $(document).ready(function() {
        var add_pelunasan = $('#add_pelunasan');
        var btn_print_kwitansi = $('#btn_print_kwitansi');
        var PelunasanModal = {
            'self': $('#pelunasan_modal'),
            'info': $('#pelunasan_modal').find('.info'),
            'form': $('#pelunasan_modal').find('#pelunasan_form'),
            'addBtn': $('#pelunasan_modal').find('#add_btn'),
            'saveEditBtn': $('#pelunasan_modal').find('#save_edit_btn'),
            'id': $('#pelunasan_modal').find('#id'),
            'acc_1': $('#pelunasan_modal').find('#acc_1'),
            'acc_2': $('#pelunasan_modal').find('#acc_2'),
            'acc_3': $('#pelunasan_modal').find('#acc_3'),
            'acc_0': $('#pelunasan_modal').find('#dibukukan'),
            'parent_id': $('#pelunasan_modal').find('#parent_id'),
            'date_pembayaran': $('#pelunasan_modal').find('#date_pembayaran'),
            'nominal': $('#pelunasan_modal').find('#nominal'),
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
            PelunasanModal.id.val('');
            PelunasanModal.nominal.val('');
            PelunasanModal.date_pembayaran.val('<?= date('Y-m-d') ?>');
        }
        getAllPelunsan()

        function getAllPelunsan() {
            swal.fire({
                title: 'Loading Payment...',
                allowOutsideClick: false
            });
            swal.showLoading();
            return $.ajax({
                url: `<?php echo base_url('Pembayaran/getAllPelunasan') ?>`,
                'type': 'GET',
                data: {
                    'parent_id': '<?= $transaction['id'] ?>',
                    'by_id': true
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
            <?php if (!empty($transaction['general_id_ppn'])) { ?>
                link = '<a href="<?= base_url() ?>statements/show/<?= $transaction['general_id_ppn'] ?>"> <?= $transaction['no_jurnal_ppn'] ?> </a>'
                renderData.push(['<?= $transaction['date'] ?>', '<?= number_format($transaction['payed'], 2, ',', '.') ?>', '<?= $transaction['acc_0'] ?>', link, '']);

            <?php   } ?>
            link = '<a href="<?= base_url() ?>statements/show/<?= $transaction['general_id'] ?>"> <?= $transaction['no_jurnal'] ?> </a>'
            renderData.push(['<?= $transaction['date'] ?>', '<?= number_format($transaction['payed'], 2, ',', '.') ?>', '<?= $transaction['acc_0'] ?>', link, '']);
            total = <?= $transaction['payed'] ?>;
            Object.values(data).forEach((d) => {
                link = `<a href="<?= base_url() ?>statements/show/${d['general_id']}"> ${d['no_jurnal']}</a>`;
                var editButton = `
                <button type="button" class="edit btn btn-primary  btn-icon" data-id='${d['id']}' title="Edit"><i class='la la-pencil-alt'></i></button>
                `;
                var deleteButton = `
                <button  type="button" class="delete btn btn-danger btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                `;
                var printButton = `
                <button  type="button" class="print btn btn-light btn-icon" data-id='${d['id']}'   title="Print"><i class='la la-print'></i></button>
                `;

                // <button type="button" class="btn btn-outline-secondary btn-icon"><i class="la la-file-text-o"></i></button>
                // <button type="button" class="btn btn-outline-secondary btn-icon"><i class="la la-bold"></i></button>
                // <button type="button" class="btn btn-outline-secondary btn-icon"><i class="la la-paperclip"></i></button>

                var button = `   <div class="btn-group mr-2" role="group" aria-label="...">  ${ printButton+ editButton + deleteButton  }    </div> `;
                renderData.push([d['date_pembayaran'], formatRupiah2(d['nominal']), d['agentname'], link, button]);
                total = parseFloat(total) + parseFloat(d['nominal']);
                console.log(d['nominal'])
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
            PelunasanModal.form.trigger('reset');
            PelunasanModal.self.modal('show');
            PelunasanModal.addBtn.hide();
            PelunasanModal.saveEditBtn.show();
            var currentData = dataPayments[$(this).data('id')];
            PelunasanModal.id.val(currentData['id']);
            PelunasanModal.acc_1.val(currentData['acc_1']);
            PelunasanModal.acc_2.val(currentData['acc_2']);
            PelunasanModal.acc_3.val(currentData['acc_3']);
            PelunasanModal.acc_0.val(currentData['acc_0']);
            PelunasanModal.date_pembayaran.val(currentData['date_pembayaran']);
            PelunasanModal.nominal.val(formatRupiah2(currentData['nominal']));
        })

        FDataTable.on('click', '.print', function() {
            var currentData = dataPayments[$(this).data('id')];
            print_kwitansi(currentData['nominal'], currentData['date_pembayaran'], '')
        })


        function print_kwitansi(nominal, date, item) {
            getss = `from=PT INDOMETAL ASIA&to=<?= !empty($customer_data[0]['customer_name']) ? $customer_data[0]['customer_name']  : '' ?>&date=${date}&nominal=${nominal}&description=<?= $transaction['description'] ?>`;
            url = "<?= base_url('pembayaran/kwitansi_print') ?>?" + getss;
            window.open(url, "_blank");
        }

        btn_print_kwitansi.on('click', () => {
            item = '<?php if ($transaction['items']  != NULL) {
                        $tot_item = 0;
                        foreach ($transaction['items'] as $item) {
                            $curtotal = ($item['amount'] * $item['qyt']);
                            $tot_item = $tot_item + $curtotal;
                            $total_qyt =  $total_qyt + ($item['qyt']);
                            echo '&item[]=' . $item['keterangan_item'] . '&price[]=' . $curtotal;
                        }
                    }
                    if (!empty($transaction['am_jasa'])) {
                        echo '&item[]= - Biaya Jasa&price[]=' . $transaction['am_jasa'];
                    } ?>';
            print_kwitansi(<?= $total ?>, '<?= $transaction['date'] ?>', item);
            // print_kwitansi(<?= $total ?>, '<?= $transaction['date'] ?>', item);
            // print_kwitansi(<?= $total ?>, '<?= $transaction['date'] ?>');
        })

        PelunasanModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = PelunasanModal.addBtn.is(':visible');
            var url = "<?= base_url('pembayaran/') ?>";
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
                    url: "<?= base_url('Pembayaran/deletePelunasan') ?>",
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
    })
</script>