<section class="invoice">
    <?php
        $attributes = array('id'=>'invoice_form','autocomplete'=>'off','method'=>'post','class'=>'form-horizontal');
    ?>
    <?php echo form_open('return_items/return_auto_invoice',$attributes); ?>
    <!-- title row -->
    <div class="row">
        <div class="col-md-3">
            <h3 >
            <i class="fa fa-globe"></i>  RETUR ITEM
          </h3>
        </div>        
        <div class="col-md-2 pull-right ">
            <a class="pull-right homescreen-icon btn btn-primary" href="<?php echo base_url('homepage'); ?>">   <i class="fa fa-dashboard"></i>    Home screen
            </a>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label><i class="fa fa-barcode"  aria-hidden="true"></i> SCAN BARCODE ATAU CARI ITEM</label>
            <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
            <div id="search_id_result_manual"></div> 
               
        </div>                         
    </div>        
    <div class="col-md-3 ">
        <div class="form-group">
            <label><a onclick="show_modal_page('<?php echo base_url().'invoice/popup/add_customer_model'; ?>')" href="#">Tambah Customer</a></label> <br/>
            <select name="customer_id" onchange="search_customer_payments(this.value)" class="form-control select2" id="customer_id" style="width: 100%;">
            <?php
                if($customer_record != NULL)
                {
                    foreach ($customer_record as $single_customer)
                    {
            ?>
                <option value="<?php echo $single_customer->id; ?>">
                <?php echo 'Nama : '.$single_customer->customer_name;
            ?>
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
        
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label> No Tagihan</label>
            <input type="number" class="form-control input-lg " placeholder="e.g 2"  name="invoice_id" />
        </div>                         
    </div> 
    <div class="row">     
        <div  id="inner_invoice_area" class="col-md-12 ">
            <?php $this->load->view($temp_view,$temp_data); ?>
        </div> 
         <p class="col-md-12">
            <small class="instructions ">
             <b>ESC</b> Invoice Baru <b>F4</b> Retur item & <b>Enter</b> Simpan invoice <b>F2</b> Lihat invoice
            </small>
        </p>   
    </div>
</section>
 <!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 

 <!-- Return  -->
<?php $this->load->view('ajax/return.php'); ?>