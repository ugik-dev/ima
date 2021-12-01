 <div class="card card-custom" id="print-section">
     <div class="card-body">
         <div class="col-md-6">
             <div class="form-group">
                 <label><i class="fa fa-barcode" aria-hidden="true"></i> SCAN BARCODE ATAU CARI ITEM</label>
                 <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
                 <div id="search_id_result_manual"></div>
             </div>
         </div>


     </div>
 </div>
 <div class="card card-custom">
     <div class="card-body">
         <form opd="form" id="pos_form" onsubmit="return false;" type="multipart" autocomplete="off">
             <div class="col-lg-12">
                 <div class="row">
                     <div class="col-md-4">
                         <div class="form-group row">
                             <label class="col-4 col-form-label"> Tanggal :</label>
                             <div class="col-8">
                                 <input type="date" class="form-control input-lg " id="date" name="date" value="<?= Date('Y-m-d') ?>">
                             </div>

                         </div>
                     </div>
                     <div class="col-md-8">

                         <div class="form-group row">
                             <label class="col-2 col-form-label"> Customer : </label>
                             <div class="col-10">

                                 <select name="customer_id" id='customer_id' class="form-control select2">
                                     <?php
                                        foreach ($customers as $lv2) {
                                            echo '<option value="' . $lv2['id'] . '">' . $lv2['customer_name'] . ' | ' . $lv2['cus_town'] . '</option>';
                                            // echo '</option>';
                                        }
                                        ?>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-xs-12">
                 <div class="col-xs-12 set-no-padding">
                     <table class="table table-striped table-bordered table_height_set">
                         <thead>
                             <tr>
                                 <th>Item</th>
                                 <th style="width: 90px">Unit</th>
                                 <th style="width: 250px">Harga</th>
                                 <th style="width: 90px">Qty</th>
                                 <th style="width: 90px">Tindakan</th>
                             </tr>
                         </thead>
                         <tbody id="row_items">
                             <?php
                                $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
                                $total_tax   = 0;
                                $total_gross = 0;
                                $single_tax  = 0;
                                ?>
                         </tbody>
                     </table>
                 </div>
                 <div class="col-xs-12">
                     <div class="row total-grid-values">
                         <div class="col-md-4 col-sm-12 col-xs-12">
                             Total Gross (<?php echo $currency; ?>) :
                             <input type="text" name="total_gross_amt" id="total_gross_amt" class=" amount-box  text-right outline-cls" value="0" readonly />
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                             Total Pajak (<?php echo $currency; ?>):
                             <input type="text" class=" amount-box text-right outline-cls" name="total_tax_amt" id="total_tax_amt" readonly value="<?php echo $total_tax; ?>" />
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                             Diskon (<?php echo $currency; ?>) :
                             <input type="text" onkeyup="invoice_count()" name="discountfield" id="discountfield" class=" amount-box text-right mask2" value="0,00" />
                         </div>
                     </div>
                     <div class="row total-grid-values">
                         <div class="col-md-4 total_amount_area">
                             <div class="">
                                 <p> Grand Total (<?php echo $currency; ?>) </p>
                                 <h4 id="net_total_amount"> <?php echo number_format($total_tax + $total_gross, '2', '.', ''); ?>
                                 </h4>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                             Uang Diterima :
                             <input type="text" onkeyup="invoice_count()" name="amount_recieved" id="amount_recieved" class=" amount-box  text-right mask" value="0" />
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12  ">
                             Kembali :
                             <span id="amount_back">0</span>
                         </div>
                     </div>

                     <div class="row total_amount_area_row">
                         <div class="col-md-4 col-sm-12 col-xs-12">
                             Metode Pembayaran :
                             <select name="payment_id" id='payment_id' class="form-control">
                                 <?php
                                    foreach ($payment_method as $lv2) {
                                        echo '<option value="' . $lv2['ref_id'] . '">' . $lv2['ref_text']  . '</option>';
                                        // echo '</option>';
                                    }
                                    ?>
                             </select>
                         </div>
                     </div>
                     <div class="row total_amount_area_row">
                     </div>

                     <div class="row row-buttons text-center">
                         <!-- <button type="button" onclick="clear_invoice()" class="btn btn-primary btn-outline-primary btn-left-side-invoice">
                         <i class="fa fa-paper-plane" aria-hidden="true"></i> INVOICE BARU
                     </button>
                     <a href="<?php echo base_url('return_items'); ?>" class="btn btn-warning btn-outline-primary btn-left-side-invoice">
                         <i class="fa fa-arrow-left" aria-hidden="true"></i> RETUR ITEM
                     </a>
                     <button type="submit" id="submit_btn" class="btn btn-danger btn-outline-primary btn-left-side-invoice">
                         <i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN DAN CETAK
                     </button> -->
                         <button id="btn_create_bill" class="btn btn-warning btn-outline-primary btn-left-side-invoice mr-2">
                             <i class="fa fa-arrow-left" aria-hidden="true"></i> BUAT TAGIHAN
                         </button>

                         <button id="btn_create_invoice" class="btn btn-danger btn-outline-primary btn-left-side-invoice">
                             <i class="fa fa-floppy-o" aria-hidden="true"></i> BUAT INVOICE
                         </button>
                         <!-- <img src="<?php echo base_url(); ?>/uploads/ban.jpg" width="700px" /> -->
                     </div>
                 </div>
             </div>
         </form>
         <script type="text/javascript">
             $('#menu_id_<?= $vcrud['parent_id'] ?>').addClass('menu-item-active menu-item-open menu-item-here"')
             $('#submenu_id_<?= $vcrud['id_menulist'] ?>').addClass('menu-item-active')
         </script>
     </div>
 </div>

 <?php $this->load->view('ajax/payment.php'); ?>