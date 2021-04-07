<div class="col-md-6 set-no-padding">
 <table class="table table-striped table-bordered table_height_set">
    <thead>
        <tr> 
            <th>Item</th>
            <th>Weight</th>
            <th>Harga Grosir</th>
            <th>Pak</th>
            <th>Qty</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
 <?php    
    $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency']; 
    $total_tax = 0;  
    $total_gross = 0;
    $single_tax = 0; 
if($temp_data != NULL)
{
    foreach ($temp_data as $single_val) 
    {
        $sub_total_tax = $single_val->qty * $single_val->tax;
        $total_tax = number_format($total_tax + $sub_total_tax,2,'.','');
        $total_gross = number_format($total_gross+($single_val->price*$single_val->pack),2,'.','');
 ?>
    <tr > 
        <td><?php echo $single_val->product_name; ?></td>
        <td><?php echo $single_val->mg.' '.$single_val->unit_type; ?></td>
         <td>
            <input type="number" onkeyup="amend_amount(this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" step=".01" value="<?php echo $single_val->price; ?>" name="supply_amount" id="supply_amount">
        </td>   
         <td>
            <input type="number" onkeyup="amend_qty(this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" value="<?php echo $single_val->pack; ?>" name="supply_qty" id="supply_qty" />
        </td>         
        <td>
            <?php echo $single_val->qty; ?>
        </td>
        <td >
            <a onclick="delete_item('<?php echo $single_val->id; ?>')" ><i class="fa fa-trash margin" aria-hidden='true'></i>
            </a>  
        </td>
    </tr>
     <?php 
       } 
    } 
      ?> 
    </tbody>
 </table>  
</div>
<div class="col-md-6">
        <div class="row total-grid-values">
            <div class="col-md-4 col-sm-12 col-xs-12">
                Gross Total (<?php echo $currency; ?>) :
                <input type="number" name="total_gross_amt" id="total_gross_amt" disabled="disabled" class=" amount-box  text-center outline-cls" value="<?php echo $total_gross; ?>" />
            </div>    
            <div class="col-md-4 col-sm-12 col-xs-12">
                Total Pajak (<?php echo $currency; ?>): 
                <input type="number" class=" amount-box text-right outline-cls" name="total_tax_amt" id="total_tax_amt" disabled="disabled" value="<?php echo $total_tax; ?>" />
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                Total Tagihan (<?php echo $currency; ?>):
                <input disabled="disabled" type="number" name="gross_total_bill" id="gross_total_bill" class=" amount-box  text-center" value="<?php echo number_format($total_tax+$total_gross,'2','.',''); ?>" />
               
            </div>
        </div> 
        <div class="row total-grid-values">            
            <div class="col-md-4 col-sm-12 col-xs-12">
                Diskon (<?php echo $currency; ?>) :
                <input type="number" onkeyup="checkDiscount(this.value)" name="discountfield" id="discountfield" step=".01" class=" amount-box text-right" value="0" />
            </div>  
            <div class="col-md-4 col-sm-12 col-xs-12">
                Total (diskon)  (<?php echo $currency; ?>):
               <h4 class="" id="net_amount"> <?php echo number_format($total_tax+$total_gross,'2','.',''); ?>
               </h4>
                <input type="hidden" id="net_total_amount_input" name="total_bill" step=".01" value="<?php echo number_format($total_tax+$total_gross,'2','.',''); ?>" />
                  
            </div>
            <div class="col-md-4 privious_balance pull-left">
                Sebelumnya (<?php echo $currency; ?>):
                <input type="number" disabled="disabled" name="privious_balance" id="privious_balance" class="text-center" step=".01" value="0.00" /> <br>
                <small><a onclick="open_payment_model()" href="javascript:void(0)">Bayar Saldo Sebelumnya</a></small> 
            </div>
        </div>        
        <div class="row total-grid-values">
            <div class="col-md-12">
                <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Rincian Invoice :
                   <small >Tulis rincian invoice untuk penerima.</small> 
                </h4>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Metode Pembayaran'); ?>
                    <select name="payment_method" id="payment_id" class="form-control input-lg">
                        <option value="0">Tunai</option>
                        <option value="1" > Cek </option>
                    </select>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo form_label('Dibayar'); ?> (<?php echo $currency; ?>)
                    <?php
                        $data = array('class'=>'form-control input-lg','onkeyup'=>'calculate_func(this.value)','type'=>'number','id'=>'cash_recieved','name'=>'cash_recieved','value'=>number_format($total_tax+$total_gross,'2','.',''),'step'=>'.01','reqiured'=>'');
                        echo form_input($data);
                    ?>
                </div>
            </div>               
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo form_label('Sisa'); ?> (<?php echo $currency; ?>)
                    <?php
                        $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'balance_field','value'=>'0','disabled'=>'disabled','name'=>'cash_balance','step'=>'.01','reqiured'=>'');
                        echo form_input($data);
                    ?>
                </div>
            </div> 
            <div class="bank-section-details">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label>Deposit Akun: </label>                
                        <select class="form-control select2" name="bank_id" id="bank_id"  style="width: 100%;">
                            <option value="0"> Akun Bank</option>
                            <?php
                            //category_names from mp_category table;
                            if($bank_list != NULL)
                            {       
                                foreach ($bank_list as $single_bank)
                                {
                            ?>
                                <option value="<?php echo $single_bank->id; ?>" ><?php echo $single_bank->bankname.' | Nama : '.$single_bank->title.' | Akun : '.$single_bank->accountno.' | Cabang : '.$single_bank->branch.' | Kode '.$single_bank->branchcode; ?> 
                                </option>
                            <?php
                                    }
                                }
                                else
                                {
                                    echo "No Record Found";
                                }
                            ?>  
                        </select>
                        <h5>Saldo Tersedia <b id="available_balance"> 0 </b></h5>
                    </div>
                    <div class="form-group " id="bank-cheque-no">
                        <?php echo form_label('Nomor Cek:'); ?>
                        <?php               
                            $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'ref_no','placeholder'=>'e.g CHE-345','reqiured'=>'');
                            echo form_input($data);             
                        ?>
                        <?php               
                            $data = array('type'=>'hidden','id'=>'save_available_balance','name'=>'save_available_balance','value'=>'0','reqiured'=>'');
                            echo form_input($data);             
                        ?>
                    </div>
                </div>
            </div>                              
        </div>
        <div class="row total-grid-values">
            <div class="col-md-12">
                <div class="form-group">
                    <h4>Deskripsi Pengiriman :</h4>
                    <?php
                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'supply_description','placeholder'=>' any description','reqiured'=>'');
                        echo form_input($data);
                        //USED TO SUPPLY TRANSACTION
                        $data = array('type'=>'hidden','name'=>'source','value'=>'1','reqiured'=>'');
                        echo form_input($data);
                    ?>
                    <small>Informasi lebih lanjut mengenai pengiriman.</small>
                </div>
            </div>
        </div>
         <div class="row row-buttons text-center ">
                <button  type="button" onclick="clear_invoice()" class="btn btn-primary btn-outline-primary btn-left-side-invoice"> 
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>  TAMBAH BARU
                </button>                    
                 <button  type="submit" id="submit_btn" class="btn btn-danger btn-outline-primary btn-left-side-invoice"> 
                   <i class="fa fa-floppy-o" aria-hidden="true"></i>  SIMPAN INVOICE
                </button> 
         </div>
    </div>
</div>
<?php $this->load->view('ajax/supply_invoice_template.php'); ?>
<script type="text/javascript">
      $('#payment_id').change(function(){
    var method = $('#payment_id').val();
    if(method == 1)
    {
        $('.bank-section-details').css('display','block');
    }
    else
    {
        $('.bank-section-details').css('display','none');
    }
});

    $('#bank_id').change(function(){
    var bank_id = $('#bank_id').val();

    if(bank_id != 0)
    {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('bank/check_available_balance/'); ?>'+bank_id,
            success: function(response)
            {
                $('#available_balance').html(response);
                $('#save_available_balance').val(response);
            }
        });
        $('#bank-cheque-no').css('display','block');
    }
});
</script>