<div class="row">
    <div class="col-md-12 ">
        <?php
            $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
            $attributes = array('id'=>'invoice_form','method'=>'post',);
        ?>
        <?php echo form_open('invoice/manage',$attributes); ?>
            <div class="col-md-3 ">
                <div class="form-group margin ">
                    <?php echo form_label('Dari Tanggal:'); ?>
                    <div class="input-group date ">
                        <div class="input-group-addon   ">
                            <i class="fa fa-calendar "></i>
                        </div>
                        <?php
                            $data = array('class'=>'form-control  input-lg','type'=>'date','id'=>'datepicker','name'=>'date1','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                            echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin">
                    <?php echo form_label('Sampai Tanggal:'); ?>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                                $data = array('class'=>'form-control  input-lg' ,'type'=>'date','id'=>'datepicker','name'=>'date2','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group margin ">
                    <?php echo form_label('Atau Masukan No Invoice:'); ?>
                    <?php
                     $data = array('class'=>'form-control input-lg' ,'type'=>'number','name'=>'invoice_no','reqiured'=>'');
                        echo form_input($data);
                    ?>
                </div>
            </div>
            <div class="col-md-2" style="margin-top:27px;">
                <?php
                    $data = array('class'=>'btn btn-info btn-outline-secondary margin  pull-right input-lg','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari');
                    echo form_button($data);
                 ?>
            </div>
            <?php echo form_close(); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 ">
        <h4  class="purchase-heading" >  
            <i class="fa fa-hand-o-right" aria-hidden="true"></i> 
            DAFTAR INVOICE
        </h4>
    </div>
</div>
<?php
    for($i = 0; $i < count($Sales_Record); $i++)
    {
?>
    <section class="invoice" id="<?php echo $Sales_Record[$i][0]->id; ?>">
        <div class="row no-print">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                  <button class="btn btn-primary  btn-flat  pull-right"  onclick="show_modal_page('<?php echo base_url().'invoice/popup/edit_invoice_model/'.$invoices_Record[$i]->id ?>')"><i class="fa fa-pencil pull-left"></i> 
                  Edit</button> 
                  <button class="btn btn-default  btn-flat  pull-right"  onclick="printDiv(<?php echo $Sales_Record[$i][0]->id; ?>)" ><i class="fa fa-print pull-left"></i> 
                  Cetak 
                  </button>
            </div>
        </div>
        <div class="row">
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <b>
            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
            </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Telepon : </b><?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['phone_number'] ;?>
               </b>
            </div>
             <?php
                if($invoices_Record[$i]->cus_id != 0)
                {
                   $customer_arr =  $this->db->get_where('mp_payee', array('id' => $invoices_Record[$i]->cus_id))->result_array();
                   if($customer_arr != NULL)
                   {   
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Tagihan Untuk : <?php echo $customer_arr[0]['customer_name'];  ?></b>
            </div>            
            <?php        
                    }
                 }
            ?>         
            <div class="col-md-12 col-sm-12 col-xs-12">
                <b> No Tagihan # <?php echo $invoices_Record[$i]->id; ?> </b>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Tanggal Tagihan : </b> <?php echo $invoices_Record[$i]->date; ?>
            </div>
             <div class="col-md-12 col-sm-12 col-xs-12">
                 <b >
                    <?php
                       if($invoices_Record[$i]->status == 1)
                       {
                    ?>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <?php
                        echo "Editted";
                      } 
                    ?>
                </b>    
            </div>
        </div>
         <div class="col-md-3 col-sm-3 col-xs-12  ">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <b> Agen : </b><?php echo $invoices_Record[$i]->agentname; ?>
                </div>
              <?php
                if($invoices_Record[$i]->driver_id != 0)
                {
                   $result =  $this->db->get_where('mp_drivers', array('id' => $invoices_Record[$i]->driver_id))->result_array();
                   if($result != NULL)
                   {   
                ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Sopir : <?php echo $result[0]['name'];  ?></b>
            </div>            
            <?php        
                    }
                 }
            ?>        
            <?php
            if($invoices_Record[$i]->vehicle_id != 0)
            {
               $result =  $this->db->get_where('mp_vehicle', array('id' => $invoices_Record[$i]->vehicle_id))->result_array();
               if($result != NULL)
               {   
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Kendaraan : <?php echo $result[0]['name'];  ?></b>
            </div>            
            <?php        
                    }
                 }
            ?>        
            <?php
                if($invoices_Record[$i]->region_id != 0)
                {
                   $result =  $this->db->get_where('mp_town', array('id' => $invoices_Record[$i]->region_id))->result_array();
                   if($result != NULL)
                   {   
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Region : <?php echo $result[0]['region'].' / '.$result[0]['name'];  ?></b>
            </div>            
            <?php        
                    }
                 }
            ?>
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
                //       print "<pre>";
                //    print_r($Sales_Record);
                    while( $counter < count($Sales_Record[$i]))
                    {
                       // echo $Sales_Record[$i]['total_bill'].'<br/>';
                        
                        $subtotal = 0;
                        $subtotal = $Sales_Record[$i][$counter]->price*$Sales_Record[$i][$counter]->qty;
                        $total = $total+$subtotal;
                        $total_tax += $Sales_Record[$i][$counter]->tax*$Sales_Record[$i][$counter]->qty;
                    ?>
                        <tr style="border-bottom:2px solid #ccc;">
                            <td>
                                <?php echo $counter+1; ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->product_no; ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->product_name; ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->mg.' '.$Sales_Record[$i][$counter]->unit_type; ?>
                            </td>
                            <td>
                                <?php echo number_format($Sales_Record[$i][$counter]->price,'2','.',''); ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->qty; ?>
                            </td>
                            <td>
                                <?php 
                                //echo number_format($subtotal,'2','.','');
                                echo number_format($subtotal,'2','.','');
                                
                                ?>
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
                            <th style="width:50%">Diskon (<?php echo $currency;?>):</th>
                            <td class="text-center">
                              <?php echo number_format($invoices_Record[$i]->discount,'2','.',''); ?>
                            </td>
                        </tr>
                        <?php 
                          $total_after_dis = $total-$invoices_Record[$i]->discount;
                      ?>  
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th  style="width:50%">Setelah Diskon(
                            <?php echo $currency;?> ):</th>
                        <td class="text-center">
                            <?php echo number_format($total_after_dis,2,'.',''); ?>
                        </td>
                    </tr>
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th style="width:50%">Pajak (
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
                    <?php
                    if($invoices_Record[$i]->status == 1 OR $invoices_Record[$i]->source == 1)
                    {
                    ?>
                    <tr  style="border-bottom: 2px dotted #eee;">
                        <td colspan="7" >
                            <b>Deskripsi : </b> <?php echo $invoices_Record[$i]->description; ?>
                        </td>
                    </tr>
                    <?php 
                        }
                     ?>
                    <tr  style="border-bottom: 2px dotted #eee;">
                        <td colspan="7"  >[
                        <b>  Metode Pembayaran: </b>
                            <?php  
                            if($invoices_Record[$i]->payment_method == 0)
                            {
                                echo "Tunai";
                            }
                            elseif($invoices_Record[$i]->payment_method == 1)
                            {
                                echo "Cek";
                            }
                            else if($invoices_Record[$i]->payment_method == 2)
                            {
                                echo "Kredit";
                            }
                             ?> 
                             ] [ 
                             <b> Jumlah Diterima:</b> <?php echo $invoices_Record[$i]->bill_paid; ?> /- ] [ <b>  Sisa:</b> <?php echo $invoices_Record[$i]->total_bill-$invoices_Record[$i]->bill_paid; ?> /- ]
                        </td>
                    </tr>
                    </table>                    
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
        <?php
            }
        ?>
        <?php 
                    // print "<pre>";
                    // print_r($invoices_Record);
                    ?>
 <!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 