<div class="row">
    <div class="col-md-12 ">
        <h4  class="purchase-heading" >  
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> 
            RINCIAN INVOICE
            <small>Invoice dihasilkan dari transaksi POS.</small>
        </h4>
    </div>
</div>
    <section class="invoice" id="<?php echo $invoice_data[0]->id; ?>">
        <div class="row">
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <b>

            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
            ?>
            </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Telepon : </b><?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['phone_number'] ;?>
               </b>
            </div>
         
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Kepada : <?php echo $invoice_data[0]->customer_name;  ?></b>
            </div>                    
            <div class="col-md-12 col-sm-12 col-xs-12">
                <b> No Invoice # <?php echo $invoice_data[0]->id; ?> </b>
            </div>            
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Tanggal Invoice : </b> <?php echo $invoice_data[0]->date; ?>
            </div>
        </div>
         <div class="col-md-3 col-sm-3 col-xs-12  ">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <b> Agen : </b><?php echo $invoice_data[0]->agentname; ?>
            </div>        
         </div>
     </div>
    <div class="row table-responsive">
        <div class="col-xs-12 ">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Weight</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 0;
                    $total = 0;
                    $total_tax = 0; 
                    foreach ($invoice_data as $single_item) 
                    {

                        $subtotal = 0;

                        $subtotal = $single_item->price*$single_item->qty;

                        $total = $total+$subtotal;

                        $total_tax += $single_item->tax*$single_item->qty;
                    ?>
                        <tr style="border-bottom:2px solid #ccc;">
                            <td>
                                <?php echo $counter+1; ?>
                            </td>
                            <td>
                                <?php echo $single_item->product_no; ?>
                            </td>
                            <td>
                                <?php echo $single_item->product_name; ?>
                            </td>
                            <td>
                                <?php echo $single_item->mg; ?>
                            </td>
                            <td>
                                <?php echo number_format($single_item->price,'2','.',''); ?>
                            </td>
                            <td>
                                <?php echo $single_item->qty; ?>
                            </td>
                            <td>
                                <?php echo number_format($subtotal,'2','.','');?>
                            </td>
                        </tr>
                    <?php
                        $counter++; 
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table">
                        <tr class="text-left" style="border-bottom: 2px dotted #eee;">
                            <th  style="width:50%">Subtotal (<?php echo $currency;?>):</th>
                            <td class="text-center">
                                <?php echo number_format($total,'2','.',''); ?>
                            </td>
                        </tr>
                         <tr  style="border-bottom: 2px dotted #eee;">
                            <th style="width:50%"> Diskon (<?php echo $currency;?>):</th>
                            <td class="text-center">
                              <?php echo number_format($invoice_data[0]->discount,'2','.',''); ?>
                            </td>
                        </tr>
                        <?php 
                          $total_after_dis = $total-$invoice_data[0]->discount;
                          $total_after_dis = number_format($total_after_dis,2,'.','');
                      ?>  
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th  style="width:50%">Setelah Diskon(
                            <?php echo $currency;?> ):</th>
                        <td class="text-center">
                            <?php echo $total_after_dis; ?>
                        </td>
                    </tr>
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th style="width:50%">Tax (
                            <?php echo $currency ;?>):</th>
                        <td class="text-center">
                            <?php echo number_format($total_tax,'2','.',''); ?>
                        </td>
                    </tr>    
                        <?php
                              $new_amount = $total_after_dis+$total_tax;
                          ?>
                    <tr  style="border-bottom: 2px dotted #eee;">
                        <th>Total (
                            <?php echo $currency ;?>):</th>
                        <td class="text-center">
                            <?php echo number_format($new_amount,'2','.',''); ?>
                        </td>
                    </tr>
                                
                                <tr  style="border-bottom: 2px dotted #eee;">
                                    <td colspan="7"  >
                                         <b> Total Diterima :</b> <?php echo $invoice_data[0]->bill_paid; ?> /- ] [ <b>  Sisa:</b> <?php echo number_format($new_amount-$invoice_data[0]->bill_paid,'2','.',''); ?> /- ]
                                    </td>
                                </tr>
                              
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div> 