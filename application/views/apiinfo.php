<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../../">
    <meta charset="utf-8" />
    <title>PT INDOMETAL ASIA</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?= base_url() ?>assets/metronic/css/pages/login/classic/login-5.css" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?= base_url() ?>assets/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/metronic/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.png" />
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(<?= base_url() ?>assets/metronic/media/bg/bg-2.jpg);">
                <div class="col-lg-10 text-center text-white p-7 position-relative overflow-hidden">
                    <!--begin::Login Header-->
                    <div class="d-flex flex-center mb-15">
                        <a href="#">
                            <img src="<?= base_url() ?>assets/img/favicon.png" class="h-75px" alt="" />
                        </a>
                    </div>
                    <!--end::Login Header-->
                    <!--begin::Login Sign in form-->
                    <div class="login-signin">
                        <div class="mb-20">
                            <h1 class="opacity-80 font-weight-normal"><strong>PT INDOMETAL ASIA</strong> </h1>
                            <span class="svg-icon svg-icon-primary svg-icon-10x">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Shield-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                        <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <!-- <p class="opacity-40"><?= $site_title ?></p> -->
                        </div>
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <!--begin::Invoice body-->
                                <!-- <div class="row pb-4"> -->
                                <div class="col-md-12 md pr-md-10 py-md-10">
                                    <!--begin::Invoice To-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="text-dark-50 font-size-lg font-weight-bold mb-3 mr-10">INVOICE TO :</div>
                                                <div class="font-size-lg font-weight-bold mb-10"><?= $dataContent['customer_name'] ?>
                                                    <br /><?= $dataContent['cus_address'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Invoice To-->
                                        <!--begin::Invoice No-->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="text-dark-50 font-size-lg font-weight-bold mb-3 mr-10">INVOICE NUMBER :</div>
                                                <div class="font-size-lg font-weight-bold mb-10"><?= $dataContent['no_invoice'] ?></div>
                                            </div>
                                        </div>
                                        <!--end::Invoice No-->
                                        <!--begin::Invoice Date-->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="text-dark-50 font-size-lg font-weight-bold mb-3 mr-10">Date :</div>
                                                <div class="font-size-lg font-weight-bold mb-10"><?= $dataContent['date'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Invoice Date-->
                                </div>
                                <div class="col-md-11 py-10 pl-md-10">
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
                                                            <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right"><?= number_format(($item->amount), 0, ',', '.') ?></td>
                                                            <td class="border-top-0 pr-0 py-4 font-size-h6 font-weight-boldest text-right currency"><?= number_format(($item->amount * $item->qyt), 0, ',', '.')  ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                                <tr>
                                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder  font-size-lg text-uppercase"></th>
                                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder  font-size-lg text-uppercase"><?= $total_qyt ?></th>
                                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase"></th>
                                                    <th class="pt-1 pb-9 text-right font-weight-bolder  font-size-lg text-uppercase"><?= number_format(($total), 0, ',', '.') ?></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- </div> -->
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
                                                    <div class="d-flex justify-content-between font-size-lg mb-8">
                                                        <div class="row">
                                                            <span class="d-flex font-weight-bold col-md-4">Bank :</span>
                                                            <span class="col-md-8"><?= $dataContent['bank_name'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between font-size-lg mb-8">
                                                        <div class="row">
                                                            <span class="font-weight-bold col-lg-4">Account Name:</span>
                                                            <span class="text-right  col-lg-8"><?= $dataContent['title_bank'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between font-size-lg mb-8">
                                                        <div class="row">
                                                            <span class="font-weight-bold col-md-4">Account Number:</span>
                                                            <span class="text-right col-md-8"><?= $dataContent['bank_number'] ?></span>
                                                        </div>
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
                                                <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($total), 0, ',', '.') ?></span>
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
                                            <div class="font-weight-boldest font-size-h5">PPN 10%</div>
                                            <div class="text-right d-flex flex-column">
                                                <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format($tmp1, 0, ',', '.') ?></span>
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
                                                <span class="font-weight-boldest font-size-h3 line-height-sm"><?= number_format(($total), 0, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Invoice footer-->
                            </div>
                        </div>
                        <!-- <div class="mt-10" style="display: none;">
                            <span class="opacity-40 mr-4">Don't have an account yet?</span>
                            <a href="javascript:;" id="kt_login_signup" class="text-white opacity-30 font-weight-normal">Sign Up</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
    <script>
        var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="<?= base_url() ?>assets/metronic/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url() ?>assets/metronic/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?= base_url() ?>assets/metronic/js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="<?= base_url() ?>assets/metronic/js/pages/custom/login/login-general.js"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>