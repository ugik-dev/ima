 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="row">
             <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
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

                 <h4><?php echo number_format($cash_in_hand, 0, '.', ''); ?></h4>
                 <h4 class="paragraph">Saldo Kas <?php echo $currency; ?></h4>
                 <a href="<?php echo base_url('statements/leadgerAccounst'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
             </div>
             <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
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
                 <?php
                    if ($payables < 0) {
                        $payables = '(' . - (number_format($payables, 0, '.', '')) . ')';
                    }

                    ?>
                 <h3><?php echo $payables; ?></h3>

                 <h4 class="text-danger font-weight-bold font-size-h6 mt-2">Hutang Usaha (AP) <?php echo $currency; ?></h4>
                 <a href="<?php echo base_url('statements/leadgerAccounst'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
             </div>
             <div class="col-lg-3 col-xs-6">
                 <div class="small-box bg-green ">
                     <div class="inner">
                         <h3><label class="label"><?php echo number_format($account_recieveble, 0, '.', ''); ?></label></h3>

                         <h4 class="paragraph">Piutang Usaha (AR) <?php echo $currency; ?></h4>
                     </div>
                     <div class="icon">
                         <i class="fa fa-lemon-o"></i>
                     </div>
                     <a href="<?php echo base_url('statements/leadgerAccounst'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
                 </div>
             </div>
             <div class="col-lg-3 col-xs-6">
                 <div class="small-box custom-bg-color-second">
                     <div class="inner">
                         <h3><label class="label"><?php echo $product_Count; ?></label></h3>

                         <h4 class="paragraph">Stok Produk</h4>
                     </div>
                     <div class="icon">
                         <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                     </div>
                     <a href="<?php echo base_url('product/productStock'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-3">
                 <div class="box box-success">
                     <div class="info-box">
                         <!-- Apply any bg-* class to to the icon to color it -->
                         <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
                         <div class="info-box-content">
                             <span class="info-box-text">
                                 <h4>Bagan Akun</h4>
                             </span>
                             <span class="info-box-number"><a href="<?php base_url() ?>accounts">Lihat</a></span>
                         </div><!-- /.info-box-content -->
                     </div><!-- /.info-box -->

                 </div>
             </div>
             <div class="col-md-3">
                 <div class="box box-success">
                     <div class="info-box">
                         <!-- Apply any bg-* class to to the icon to color it -->
                         <span class="info-box-icon bg-blue"><i class="fa fa-list-alt"></i></span>
                         <div class="info-box-content">
                             <span class="info-box-text">
                                 <h4>Jurnal Umum</h4>
                             </span>
                             <span class="info-box-number"><a href="<?php base_url() ?>statements">Lihat</a></span>
                         </div><!-- /.info-box-content -->
                     </div><!-- /.info-box -->

                 </div>
             </div>
             <div class="col-md-3">
                 <div class="box box-success">
                     <div class="info-box">
                         <!-- Apply any bg-* class to to the icon to color it -->
                         <span class="info-box-icon bg-yellow"><i class="fa fa-calendar-plus-o"></i></span>
                         <div class="info-box-content">
                             <span class="info-box-text">
                                 <h4>Buku Besar</h4>
                             </span>
                             <span class="info-box-number"><a href="<?php base_url() ?>statements/leadgerAccounst">Lihat</a></span>
                         </div><!-- /.info-box-content -->
                     </div><!-- /.info-box -->

                 </div>
             </div>
             <div class="col-md-3">
                 <div class="box box-success">
                     <div class="info-box">
                         <!-- Apply any bg-* class to to the icon to color it -->
                         <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                         <div class="info-box-content">
                             <span class="info-box-text">
                                 <h4>Neraca</h4>
                             </span>
                             <span class="info-box-number"><a href="<?php base_url() ?>statements/balancesheet">Lihat</a></span>
                         </div><!-- /.info-box-content -->
                     </div><!-- /.info-box -->

                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-3 col-xs-6">
                 <div class="small-box custom-bg-color">
                     <div class="inner">
                         <h3><label class="label"><?php echo $Sales_today_count; ?></label></h3>
                         <h4 class="paragraph">Penjualan Hari Ini</h4>
                     </div>
                     <div class="icon">
                         <i class="fa fa-bar-chart "></i>
                     </div>
                     <a href="<?php echo base_url('salesreport'); ?>" class="small-box-footer"><span class="dashboard_text"> Tot <?php echo $sales_today_amount[0]; ?> | Mo <?php echo $sales_today_amount[1]; ?> | Pr <?php echo $sales_today_amount[0] - $sales_today_amount[1]; ?></a>
                 </div>
             </div>
             <div class="col-lg-3 col-xs-6">
                 <div class="small-box custom-bg-color">
                     <div class="inner">
                         <h3><label class="label"><?php echo $Sales_month_count; ?></label></h3>

                         <h4 class="paragraph">Penjualan Bulan Ini</h4>
                     </div>
                     <div class="icon">
                         <i class="fa fa-area-chart "></i>
                     </div>
                     <a href="<?php echo base_url('salesreport'); ?>" class="small-box-footer"> <span class="dashboard_text"> Tot <?php echo $sales_month_amount[0]; ?> | <span class="expense_das">Mod <?php echo $sales_month_amount[1]; ?></span> | Pr <?php echo $sales_month_amount[0] - $sales_month_amount[1]; ?> </span></a>
                 </div>
             </div>
             <div class="col-lg-3 col-xs-6">
                 <div class="small-box custom-bg-color-second">
                     <div class="inner">
                         <h3><label class="label"><?php echo number_format($purchase_amount, 0, '.', ''); ?></label></h3>
                         <h4 class="paragraph">Pembelian Bulan Ini <?php echo $currency; ?></h4>
                     </div>
                     <div class="icon">
                         <i class="fa fa-cubes"></i>
                     </div>
                     <a href="<?php echo base_url('purchase'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
                 </div>
             </div>
             <div class="col-lg-3 col-xs-6">
                 <div class="small-box custom-bg-color-second">
                     <div class="inner">
                         <h3><label class="label"><?php echo number_format($expense_amount, 0, '.', ''); ?></label></h3>
                         <h4 class="paragraph">Pengeluaran Bulan Ini <?php echo $currency; ?></h4>

                     </div>
                     <div class="icon">
                         <i class="fa fa-rocket" aria-hidden="true"></i>
                     </div>
                     <a href="<?php echo base_url('expense'); ?>" class="small-box-footer">Lihat <i class="fa fa-hand-o-right"></i></a>
                 </div>
             </div>
         </div>
         </section>
         <div class="row">
             <section class="col-lg-7 connectedSortable">
                 <div class="box box-primary">
                     <div class="box-header with-border">
                         <h3 class="box-title"><i class="fa fa-money" aria-hidden="true"></i> Total Revenue & Modal Tahun Ini <?php echo $currency; ?></h3>
                         <div class="box-tools pull-right">
                             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                             </button>
                             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                         </div>
                     </div>
                     <div class="box-body">
                         <div class="chart">
                             <canvas id="areaChart" style="height:250px"></canvas>
                         </div>
                     </div>
                 </div>
             </section>
             <section class="col-lg-5 connectedSortable">
                 <div class="box box-primary ">
                     <div class="box-header with-border">
                         <h3 class="box-title"> <i class="ion ion-stats-bars "></i> Profit Penjualan Tahun Ini <?php echo $currency; ?> </h3>
                         <div class="box-tools pull-right">
                             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                             </button>
                             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                         </div>
                     </div>
                     <div class="box-body">
                         <div class="chart">
                             <canvas id="lineChart" style="height:249px"></canvas>
                         </div>
                     </div>
                 </div>

             </section>


         </div>
     </div>
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