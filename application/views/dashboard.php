     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

     <div class="card card-custom" id="print-section">
         <div class="card-body">

             <div class="row">
                 <div class="col-lg-4 bg-light-warning px-6 py-8 rounded-xl mr-4 ml-4 mb-4">
                     <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                 <rect x="0" y="0" width="24" height="24"></rect>
                                 <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                 <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                 <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                 <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                             </g>
                         </svg>
                         <!--end::Svg Icon-->
                     </span>

                     <h3><?php
                            if ($cash_in_hand < 0) {
                                echo 'Rp (' . number_format(-$cash_in_hand, 2, ',', '.') . ')';
                            } else {
                                echo 'Rp ' . number_format($cash_in_hand, 2, ',', '.');
                            }
                            ?>
                     </h3>
                     <h4 class="paragraph">Saldo Setara Kas </h4>
                     <a href="<?php echo base_url('statements/leadgerAccounst'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
                 </div>
                 <div class="col-lg-3 bg-light-danger px-6 py-8 rounded-xl mr-4 ml-4 mb-4">
                     <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                 <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                 <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
                                 <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
                             </g>
                         </svg>
                         <!--end::Svg Icon-->
                     </span>
                     <h3>
                         <?php if ($payables < 0) {
                                echo 'Rp (' . number_format(-$payables, 2, ',', '.') . ')';
                            } else {
                                echo 'Rp ' . number_format($payables, 2, ',', '.');
                            }   ?>
                     </h3>

                     <h4 class="text-danger font-weight-bold font-size-h6 mt-2">Hutang Usaha (AP) <?php echo $currency; ?></h4>
                     <a href="<?php echo base_url('statements/leadgerAccounst'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
                 </div>
                 <div class="col-lg-4 bg-light-success px-6 py-8 rounded-xl mr-4 ml-4 mb-4">
                     <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Urgent-mail.svg-->
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                 <rect x="0" y="0" width="24" height="24"></rect>
                                 <path d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z" fill="#000000" opacity="0.3"></path>
                                 <path d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z" fill="#000000"></path>
                             </g>
                         </svg>
                         <!--end::Svg Icon-->
                     </span>
                     <!-- <div class="inner"> -->
                     <h3><?php
                            if ($account_recieveble < 0) {
                                echo 'Rp (' . number_format(-$account_recieveble, 2, ',', '.') . ')';
                            } else {
                                echo 'Rp ' . number_format($account_recieveble, 2, ',', '.');
                            }   ?></h3>

                     <!-- <h4 class="paragraph">Piutang Usaha (AR) <?php echo $currency; ?></h4> -->
                     <!-- </div> -->
                     <h4 class="text-success font-weight-bold font-size-h6 mt-2">Piutang Usaha (AR)</h4>
                     <a href="<?php echo base_url('statements/leadgerAccounst'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>

                 </div>

                 <!-- <div class="col-lg-4 bg-light-success px-6 py-8 rounded-xl mr-4 ml-4 mb-4">
                 <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                         <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                             <rect x="0" y="0" width="24" height="24"></rect>
                             <path d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z" fill="#000000" opacity="0.3"></path>
                             <path d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z" fill="#000000"></path>
                         </g>
                     </svg>
                 </span>
                 <h3><?php echo $product_Count; ?></h3>
                 <h4 class="text-success font-weight-bold font-size-h6 mt-2">Stok Product</h4>
                 <a href="<?php echo base_url('product/productStock'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
             </div> -->
             </div>

             <div class="row">
                 <div class="col-lg-4 order-1 order-xxl-1">
                     <!--begin::List Widget 1-->
                     <div class="card card-custom card-stretch gutter-b">
                         <!--begin::Header-->
                         <div class="card-header border-0 pt-5">
                             <h3 class="card-title align-items-start flex-column">
                                 <span class="card-label font-weight-bolder text-dark">Tasks Overview</span>
                             </h3>

                         </div>
                         <div class="card-body pt-8">
                             <!--begin::Item-->
                             <div class="d-flex align-items-center mb-10">
                                 <!--begin::Symbol-->
                                 <div class="symbol symbol-40 symbol-light-primary mr-5">
                                     <span class="symbol-label">
                                         <span class="svg-icon svg-icon-xl svg-icon-primary">
                                             <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                     <rect x="0" y="0" width="24" height="24"></rect>
                                                     <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"></path>
                                                     <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
                                                 </g>
                                             </svg>
                                             <!--end::Svg Icon-->
                                         </span>
                                     </span>
                                 </div>
                                 <!--end::Symbol-->
                                 <!--begin::Text-->
                                 <div class="d-flex flex-column font-weight-bold">
                                     <a href="<?php base_url() ?>accounts" class="text-dark text-hover-primary mb-1 font-size-lg">Bagan Akun</a>
                                     <span class="text-muted">Daftar kode akun</span>
                                 </div>
                                 <!--end::Text-->
                             </div>
                             <!--end::Item-->
                             <!--begin::Item-->
                             <div class="d-flex align-items-center mb-10">
                                 <!--begin::Symbol-->
                                 <div class="symbol symbol-40 symbol-light-warning mr-5">
                                     <span class="symbol-label">
                                         <span class="svg-icon svg-icon-lg svg-icon-warning">
                                             <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                     <rect x="0" y="0" width="24" height="24"></rect>
                                                     <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                                                     <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                 </g>
                                             </svg>
                                             <!--end::Svg Icon-->
                                         </span>
                                     </span>
                                 </div>
                                 <!--end::Symbol-->
                                 <!--begin::Text-->
                                 <div class="d-flex flex-column font-weight-bold">
                                     <a href="<?php base_url() ?>statements" class="text-dark-75 text-hover-primary mb-1 font-size-lg">Jurnal Umum</a>
                                     <!-- <span class="text-muted">Art Director</span> -->
                                 </div>
                                 <!--end::Text-->
                             </div>
                             <!--end::Item-->
                             <!--begin::Item-->
                             <div class="d-flex align-items-center mb-10">
                                 <!--begin::Symbol-->
                                 <div class="symbol symbol-40 symbol-light-success mr-5">
                                     <span class="symbol-label">
                                         <span class="svg-icon svg-icon-lg svg-icon-success">
                                             <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                     <rect x="0" y="0" width="24" height="24"></rect>
                                                     <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"></path>
                                                     <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"></path>
                                                 </g>
                                             </svg>
                                             <!--end::Svg Icon-->
                                         </span>
                                     </span>
                                 </div>
                                 <!--end::Symbol-->
                                 <!--begin::Text-->
                                 <div class="d-flex flex-column font-weight-bold">
                                     <a href="<?php base_url() ?>statements/leadgerAccounst" class="text-dark text-hover-primary mb-1 font-size-lg">Buku Besar</a>
                                     <!-- <span class="text-muted">Lead Developer</span> -->
                                 </div>
                                 <!--end::Text-->
                             </div>
                             <!--end::Item-->
                             <!--begin::Item-->
                             <div class="d-flex align-items-center mb-10">
                                 <!--begin::Symbol-->
                                 <div class="symbol symbol-40 symbol-light-danger mr-5">
                                     <span class="symbol-label">
                                         <span class="svg-icon svg-icon-lg svg-icon-danger">
                                             <!--begin::Svg Icon | path:assets/media/svg/icons/General/Attachment2.svg-->
                                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                     <rect x="0" y="0" width="24" height="24"></rect>
                                                     <path d="M11.7573593,15.2426407 L8.75735931,15.2426407 C8.20507456,15.2426407 7.75735931,15.6903559 7.75735931,16.2426407 C7.75735931,16.7949254 8.20507456,17.2426407 8.75735931,17.2426407 L11.7573593,17.2426407 L11.7573593,18.2426407 C11.7573593,19.3472102 10.8619288,20.2426407 9.75735931,20.2426407 L5.75735931,20.2426407 C4.65278981,20.2426407 3.75735931,19.3472102 3.75735931,18.2426407 L3.75735931,14.2426407 C3.75735931,13.1380712 4.65278981,12.2426407 5.75735931,12.2426407 L9.75735931,12.2426407 C10.8619288,12.2426407 11.7573593,13.1380712 11.7573593,14.2426407 L11.7573593,15.2426407 Z" fill="#000000" opacity="0.3" transform="translate(7.757359, 16.242641) rotate(-45.000000) translate(-7.757359, -16.242641)"></path>
                                                     <path d="M12.2426407,8.75735931 L15.2426407,8.75735931 C15.7949254,8.75735931 16.2426407,8.30964406 16.2426407,7.75735931 C16.2426407,7.20507456 15.7949254,6.75735931 15.2426407,6.75735931 L12.2426407,6.75735931 L12.2426407,5.75735931 C12.2426407,4.65278981 13.1380712,3.75735931 14.2426407,3.75735931 L18.2426407,3.75735931 C19.3472102,3.75735931 20.2426407,4.65278981 20.2426407,5.75735931 L20.2426407,9.75735931 C20.2426407,10.8619288 19.3472102,11.7573593 18.2426407,11.7573593 L14.2426407,11.7573593 C13.1380712,11.7573593 12.2426407,10.8619288 12.2426407,9.75735931 L12.2426407,8.75735931 Z" fill="#000000" transform="translate(16.242641, 7.757359) rotate(-45.000000) translate(-16.242641, -7.757359)"></path>
                                                     <path d="M5.89339828,3.42893219 C6.44568303,3.42893219 6.89339828,3.87664744 6.89339828,4.42893219 L6.89339828,6.42893219 C6.89339828,6.98121694 6.44568303,7.42893219 5.89339828,7.42893219 C5.34111353,7.42893219 4.89339828,6.98121694 4.89339828,6.42893219 L4.89339828,4.42893219 C4.89339828,3.87664744 5.34111353,3.42893219 5.89339828,3.42893219 Z M11.4289322,5.13603897 C11.8194565,5.52656326 11.8194565,6.15972824 11.4289322,6.55025253 L10.0147186,7.96446609 C9.62419433,8.35499039 8.99102936,8.35499039 8.60050506,7.96446609 C8.20998077,7.5739418 8.20998077,6.94077682 8.60050506,6.55025253 L10.0147186,5.13603897 C10.4052429,4.74551468 11.0384079,4.74551468 11.4289322,5.13603897 Z M0.600505063,5.13603897 C0.991029355,4.74551468 1.62419433,4.74551468 2.01471863,5.13603897 L3.42893219,6.55025253 C3.81945648,6.94077682 3.81945648,7.5739418 3.42893219,7.96446609 C3.0384079,8.35499039 2.40524292,8.35499039 2.01471863,7.96446609 L0.600505063,6.55025253 C0.209980772,6.15972824 0.209980772,5.52656326 0.600505063,5.13603897 Z" fill="#000000" opacity="0.3" transform="translate(6.014719, 5.843146) rotate(-45.000000) translate(-6.014719, -5.843146)"></path>
                                                     <path d="M17.9142136,15.4497475 C18.4664983,15.4497475 18.9142136,15.8974627 18.9142136,16.4497475 L18.9142136,18.4497475 C18.9142136,19.0020322 18.4664983,19.4497475 17.9142136,19.4497475 C17.3619288,19.4497475 16.9142136,19.0020322 16.9142136,18.4497475 L16.9142136,16.4497475 C16.9142136,15.8974627 17.3619288,15.4497475 17.9142136,15.4497475 Z M23.4497475,17.1568542 C23.8402718,17.5473785 23.8402718,18.1805435 23.4497475,18.5710678 L22.0355339,19.9852814 C21.6450096,20.3758057 21.0118446,20.3758057 20.6213203,19.9852814 C20.2307961,19.5947571 20.2307961,18.9615921 20.6213203,18.5710678 L22.0355339,17.1568542 C22.4260582,16.76633 23.0592232,16.76633 23.4497475,17.1568542 Z M12.6213203,17.1568542 C13.0118446,16.76633 13.6450096,16.76633 14.0355339,17.1568542 L15.4497475,18.5710678 C15.8402718,18.9615921 15.8402718,19.5947571 15.4497475,19.9852814 C15.0592232,20.3758057 14.4260582,20.3758057 14.0355339,19.9852814 L12.6213203,18.5710678 C12.2307961,18.1805435 12.2307961,17.5473785 12.6213203,17.1568542 Z" fill="#000000" opacity="0.3" transform="translate(18.035534, 17.863961) scale(1, -1) rotate(45.000000) translate(-18.035534, -17.863961)"></path>
                                                 </g>
                                             </svg>
                                             <!--end::Svg Icon-->
                                         </span>
                                     </span>
                                 </div>
                                 <!--end::Symbol-->
                                 <!--begin::Text-->
                                 <div class="d-flex flex-column font-weight-bold">
                                     <a href="<?php base_url() ?>statements/balancesheet" class="text-dark text-hover-primary mb-1 font-size-lg">Neraca</a>
                                     <!-- <span class="text-muted">DevOps</span> -->
                                 </div>
                                 <!--end::Text-->
                             </div>
                             <!--end::Item-->
                             <!--begin::Item-->
                             <div class="d-flex align-items-center mb-2">
                                 <!--begin::Symbol-->
                                 <div class="symbol symbol-40 symbol-light-info mr-5">
                                     <span class="symbol-label">
                                         <span class="svg-icon svg-icon-lg svg-icon-info">
                                             <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                     <rect x="0" y="0" width="24" height="24"></rect>
                                                     <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
                                                     <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"></path>
                                                     <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"></path>
                                                 </g>
                                             </svg>
                                             <!--end::Svg Icon-->
                                         </span>
                                     </span>
                                 </div>
                                 <!--end::Symbol-->
                                 <!--begin::Text-->
                                 <div class="d-flex flex-column font-weight-bold">
                                     <a href="<?php base_url() ?>dashboard/document" class="text-dark text-hover-primary mb-1 font-size-lg">Document</a>

                                 </div>
                                 <!--end::Text-->
                             </div>
                             <!--end::Item-->
                         </div>
                         <!--end::Body-->
                     </div>
                     <!--end::List Widget 1-->
                 </div>

                 <div class="col-lg-8 order-1 order-xxl-1">
                     <div class="card card-custom card-stretch gutter-b">
                         <div class="card-header border-0 pt-5">
                             <h3 class="card-title align-items-start flex-column">
                                 <i class="fa fa-money" aria-hidden="true"></i> Total Revenue & Modal Tahun Ini <?php echo $currency; ?>

                                 <!-- <span class="card-label font-weight-bolder text-dark">Tasks Overview</span> -->
                             </h3>
                             <div class="box-tools pull-right">
                                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                 </button>
                                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                             </div>
                         </div>
                         <div class="card-body pt-8">

                             <div class=" box-body">
                                 <div class="chart">
                                     <canvas id="areaChart" width="400" height="200"></canvas>
                                 </div>
                             </div>
                         </div>
                         <!-- </di> -->
                     </div>
                 </div>

                 <div class="col-xxl-8 order-2 order-xxl-1">
                     <!--begin::Advance Table Widget 2-->
                     <div class="card card-custom card-stretch gutter-b">
                         <!--begin::Header-->
                         <div class="card-header border-0 pt-5">
                             <h3 class="card-title align-items-start flex-column">
                                 <span class="card-label font-weight-bolder text-dark">Activity Today</span>
                                 <!-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> -->
                             </h3>
                             <div class="card-toolbar">
                                 <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                     <li class="nav-item">
                                         <a class="nav-link py-2 px-4" data-toggle="tab" id="btn_act_bulan" href="#kt_tab_pane_11_1">Month</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link py-2 px-4" data-toggle="tab" id="btn_act_minggu" href="#kt_tab_pane_11_1">Week</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link py-2 px-4 active" data-toggle="tab" id="btn_act_hari" href="#kt_tab_pane_11_1">Day</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>


                         <div class="card-body pt-2 pb-0 mt-n3">
                             <div class="tab-content mt-5" id="myTabTables11">
                                 <!--begin::Tap pane-->
                                 <div class="tab-pane show active fade" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                                     <!--begin::Table-->
                                     <div class="table-responsive">
                                         <table id="FDataTable" class=" table table-borderless table-vertical-center">
                                             <thead>
                                                 <tr>
                                                     <!-- <th class="p-0 w-40px"></th> -->
                                                     <th class="p-0 min-w-200px"></th>
                                                     <th class="p-0 min-w-100px"></th>
                                                     <th class="p-0 min-w-125px"></th>
                                                     <th class="p-0 min-w-110px"></th>
                                                     <th class="p-0 min-w-150px"></th>
                                                 </tr>
                                             </thead>
                                             <tbody id="body_tab_act">
                                                 <?php
                                                    if (!empty($activity_today)) {
                                                        foreach ($activity_today as $act_today) {

                                                    ?>
                                                         <tr>
                                                             <td class="pl-0">
                                                                 <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?= $act_today['user_name'] ?></a>
                                                             </td>
                                                             <td class="text-right">
                                                                 <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?= $act_today['date_activity'] ?></span>
                                                             </td>
                                                             <td class="text-right">
                                                                 <span class="text-muted font-weight-500"><?= $act_today['desk'] ?></span>
                                                             </td>
                                                             <td class="text-right">
                                                                 <?php if ($act_today['jenis'] == '1') {
                                                                        echo '  <span class="label label-lg label-light-success label-inline">Enty Jurnal</span>';
                                                                        $url = base_url() . 'statements/show/' . $act_today['sub_id'];
                                                                    } else if ($act_today['jenis'] == '2') {
                                                                        $url = base_url() . 'statements/show/' . $act_today['sub_id'];
                                                                        echo '  <span class="label label-lg label-light-primary label-inline">Edit Jurnal</span>';
                                                                    } else if ($act_today['jenis'] == '3') {
                                                                        $url = '#';
                                                                        echo '  <span class="label label-lg label-light-danger label-inline">Delete Jurnal</span>';
                                                                    } else if ($act_today['jenis'] == '4') {
                                                                        $url = base_url() . 'invoice/show/' . $act_today['sub_id'];
                                                                        echo '  <span class="label label-lg label-light-success label-inline">Enty Invoice</span>';
                                                                    } else if ($act_today['jenis'] == '5') {
                                                                        $url = base_url() . 'invoice/show/' . $act_today['sub_id'];
                                                                        echo '  <span class="label label-lg label-light-primary label-inline">Edit Invoice</span>';
                                                                    } else if ($act_today['jenis'] == '6') {
                                                                        $url = '#';
                                                                        echo '  <span class="label label-lg label-light-danger label-inline">Delete Invoice</span>';
                                                                    } else {
                                                                        $url = $act_today['url_activity'];
                                                                        echo '  <span class="label label-lg label-light-' . $act_today['color'] . ' label-inline"> Entry </span>';
                                                                    }  ?>
                                                             </td>
                                                             <td class="text-right pl-0">
                                                                 <a href="<?= $url ?>" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                     <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                         <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                 <rect x="0" y="0" width="24" height="24"></rect>
                                                                                 <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
                                                                                 <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
                                                                             </g>
                                                                         </svg>
                                                                         <!--end::Svg Icon-->
                                                                     </span>
                                                                 </a>

                                                             </td>
                                                         </tr>
                                                 <?php
                                                        }
                                                    } ?>
                                             </tbody>
                                         </table>
                                     </div>
                                     <!--end::Table-->
                                 </div>
                                 <!--end::Tap pane-->

                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </div>
     <div class="card card-custom">
         <div class="card-header">
             <div class="card-title">
                 <h3 class="card-label">
                     Calendar
                 </h3>
             </div>
             <div class="card-toolbar">
                 <button onclick="show_modal_page('<?php echo base_url() . 'dashboard/popup/add_event/'; ?>')" type="button" class="btn btn-light-primary font-weight-bold">
                     <i class="ki ki-plus "></i> Add E-Note
                 </button>
             </div>
         </div>
         <div class="card-body">
             <div id="kt_calendar"></div>
         </div>
     </div>
     <?php $this->load->view('bootstrap_model.php'); ?>


     <style>
         .small-box>.inner {
             padding: 20px;
         }

         @media (min-width: 992px) {
             .col-md-10 {
                 width: 85.333333%;
             }
         }
     </style>
     <?php
        $this->load->view('script/dashboard_script.php');
        ?>