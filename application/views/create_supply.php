<section class="content">
    <div class="box" id="print-section">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-hand-o-right" aria-hidden="true"></i>        Buat Pengiriman
            </h3>
            <small>
                <br />
                Catatan : Dalam pembelian grosir, harga yang digunakan adalah harga grosir.   
            </small>
        </div>
        <div class="box-body box-bg ">
            <?php
                $attributes = array('id'=>'create_supply_form', 'autocomplete'=>'off','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('supply/add_supply_invoice',$attributes); ?>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Informasi Umum :
                      <small >Isi informasi pengiriman berikut.</small>    
                    </h4>   
                </div>           
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>Nama Sopir (<a onclick="show_modal_page('<?php echo base_url().'supply/popup/add_driver_model'; ?>')" href="#">Tambah Sopir</a>)
                        </label>
                        <select name="driver_id" class="form-control input-lg">
                            <?php 
                            if($drivers_list != NULL)
                            {
                                foreach ($drivers_list as $single_driver) 
                                {
                            ?>
                                <option value="<?php echo $single_driver->id; ?>">
                                    <?php echo $single_driver->name; ?>  
                                       
                                </option>
                            <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>    
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>Kendaraan (<a onclick="show_modal_page('<?php echo base_url().'supply/popup/add_vehicle_model'; ?>')" href="#">Tambah kendaraan</a>)
                        </label>
                        <select name="vehicle_id" class="form-control input-lg">
                            <?php 
                            if($vehicle_list != NULL)
                            {
                                foreach ($vehicle_list as $single_vehicle) 
                                {
                                ?>
                                    <option value="<?php echo $single_vehicle->id; ?>">
                                        <?php echo $single_vehicle->name; ?>     
                                    </option>
                                <?php 
                                 }
                            }
                            ?>
                        </select>
                    </div>
                </div> 
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label>Region/Kota (<a onclick="show_modal_page('<?php echo base_url().'initilization/popup/add_town_model'; ?>')" href="#">Tambah kota</a>)
                        </label>
                        <select name="region_id" class="form-control select2 input-lg">
                            <?php 
                            if($town_list != NULL)
                            {
                                foreach ($town_list as $single_town) 
                                {
                                ?>
                                    <option value="<?php echo $single_town->id; ?>">
                                        <?php echo ' Region '.$single_town->region.' | Kota '.$single_town->name; ?>     
                                    </option>
                                <?php 
                                 }
                            }
                            ?>
                        </select>
                        
                    </div>
                </div>            
            </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Buat Item Pengiriman :
                 <small >Buat Invoice untuk penjualan grosir.</small>   
                </h4>  

            </div>
            <div class="col-md-6 ">
                <div class="form-group">
                    <label ><i class="fa fa-search"  aria-hidden="true"></i> <b>CARI PRODUK :</b></label>
                    <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
                    <div id="search_id_result_manual"></div>
                     
                 </div>                   
            </div>        
            <div class="col-md-6 ">
                <div class="form-group">
                    <label>Customer (<a onclick="show_modal_page('<?php echo base_url().'invoice/popup/add_customer_model'; ?>')" href="#">Tambah customer</a>)
                    </label>
                     <select name="customer_id" onchange="search_customer_payments(this.value)" class="form-control select2" id="customer_id">
                        <?php
                            if($customer_list != NULL)
                            {
                                foreach ($customer_list as $single_customer)
                                {
                        ?>
                             <option value="<?php echo $single_customer->id; ?>">
                                <?php //echo 'Name : '.$single_customer->customer_name;  ?>
                                 <?php echo 'Nama: '.$single_customer->customer_name.' - '.$single_customer->cus_company.' - '.$single_customer->cus_contact_2.' - '.$single_customer->cus_type.' - '.$single_customer->cus_region;

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
        </div>
        <div class="row">
            <div class="col-md-12 ">      
                <div  id="inner_invoice_area">
                    <?php $this->load->view($temp_view,$temp_data); ?> 
                </div>    
            </div>
        </div>
    <?php form_close(); ?>
      </div>
  </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>

<!-- Bootstrap model  ends--> 
<?php $this->load->view('ajax/supply_invoice_script.php'); ?>