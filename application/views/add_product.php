<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box " id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-plus" aria-hidden="true"></i> 
                        Tambah Produk
                    </h3>
                </div>
                <?php
                    $attributes = array('id'=>'product_form','method'=>'post','class'=>'');
                ?>
                <?php echo form_open_multipart('product/add_product',$attributes); ?>
                <div class="box-body ">
                    <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i> Informasi Produk</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Nama Produk:'); ?>
                                <?php           
                                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product_name','placeholder'=>'Nama Produk','reqiured'=>'');
                                echo form_input($data);         
                                ?> 
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('SKU:'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'sku','placeholder'=>'e.g SKU','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Barcode:'); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'barcode','placeholder'=>'e.g 000025444255658','reqiured'=>'');
                                        echo form_input($data);
                                ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Type:'); ?>
                                <select class="form-control select2" name="type" id="category_id"  style="width: 100%;">
                                    <option value="Finished Products">
                                        Produk Jadi
                                    </option>
                                    <option value="Raw Product">
                                        Produk Mentah
                                    </option>
                                    <option value="Service">
                                        Jasa
                                    </option>
                                    <option value="Ticket">
                                        Tiket / Vocer
                                    </option>
                                </select>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_label('Deskripsi Produk:'); ?>
                                <textarea name="description" class="form-control" rows="5">
                                </textarea>  
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Upload Gambar:</label>
                                    <div class="input-group">
                                        <input type="file" name="medicine_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required" >
                                    </div>
                            </div>
                            <small>Pilih gambar yang menerangkan produk ?</small>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i> Pengelompokan</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Merk: <a onclick="show_modal_page('<?php echo base_url();?>product/popup/add_brand_model')" href="javascript:void(0)"> (Tambah Merk)</a></label>                
                                <select class="form-control select2" name="brand_id" id="category_id"  style="width: 100%;">
                                    <?php
                                    //category_names from mp_category table;
                                    if($brand != NULL)
                                    {       
                                        foreach ($brand as $single_brand)
                                        {
                                    ?>
                                            <option value="<?php echo $single_brand->id; ?>" >
                                                <?php echo $single_brand->name; ?> 
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Sektor Merk: <a onclick="show_modal_page('<?php echo base_url();?>product/popup/add_brand_sector')" href="javascript:void(0)"> (Tambah Sektor)</a></label>                
                                <select class="form-control select2" name="sector_id" id="category_id"  style="width: 100%;">
                                    <?php
                                    //category_names from mp_category table;
                                    if($brandsector != NULL)
                                    {       
                                        foreach ($brandsector as $single_brandsector)
                                            {
                                    ?>
                                             <option value="<?php echo $single_brandsector->id; ?>" ><?php echo $single_brandsector->sector; ?> 
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Kategori: <a onclick="show_modal_page('<?php echo base_url();?>product/popup/add_category_model')" href="javascript:void(0)"> (Tambah Kategori)</a></label>                
                                <select class="form-control select2" name="category_id" id="category_id"  style="width: 100%;">
                                    <?php
                                    //category_names from mp_category table;
                                    if($catagory != NULL)
                                    {       
                                            foreach ($catagory as $obj_catagory_list){
                                    ?>
                                             <option value="<?php echo $obj_catagory_list->id; ?>" ><?php echo $obj_catagory_list->category_name; ?> </option>
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
                </div>
                <div class="box-body bg-setting-product">
                    <h4 class="purchase-heading" ><i class="fa fa-check-circle"></i> Unit dan Bobot: </h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Jenis Unit: <a onclick="show_modal_page('<?php echo base_url();?>initilization/popup/add_unit_model')" href="javascript:void(0)"> (Tambah unit)</a></label>  
                                    <select class="form-control input-lg" name="unit_symbol" ><?php
                                        //category_names from mp_category table;
                                        if($units != NULL)
                                        {       
                                            foreach ($units as $single_unit)
                                            {
                                    ?>
                                             <option value="<?php echo $single_unit->symbol; ?>" ><?php echo $single_unit->name.' '.$single_unit->symbol; ?> 
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
                                    <small>Satuan produk ? </small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Unit Bobot: '); ?>
                                <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'','name'=>'product_mg','placeholder'=>'e.g 250','reqiured'=>'');
                                     echo form_input($data);         
                                 ?>  
                            </div>
                            <small>Satuan takaran produk ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Total Bobot: '); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'net_weight','placeholder'=>'e.g 800','reqiured'=>'');
                                    echo form_input($data);
                                ?>  
                            </div>
                            <small>Total bobot dalam satu pak ? </small>
                        </div>
                    </div>                    
                </div>
                <div class="box-body">
                    <h4 class="purchase-heading" ><i class="fa fa-check-circle"></i> Stok dan Masa Kadaluarsa </h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Minimum level stok:'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'min_stock','placeholder'=>'e.g 20','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            <small>Minimun stok  ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Tanggal Pembuatan:'); ?>
                                <?php
                                                    
                                    $data = array('class'=>'form-control input-lg','type'=>'date','id'=>'manufacturing','name'=>'manufacturing_date','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                    echo form_input($data);         
                                ?>
                            </div>
                            <small>Kapan produk dibuat ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <?php echo form_label('Tanggal Kadaluarsa:'); ?>
                            <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'date','id'=>'datepicker','name'=>'expiry_date','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                echo form_input($data);         
                            ?>
                            </div>
                            <small>Kapan produk kadaluarsa ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Efek Samping:'); ?>
                                <?php               
                                    $data = array('class'=>'form-control input-lg','type'=>'text','id'=>'sideeffects','name'=>'side_effects','placeholder'=>'e.g avoid childrens','reqiured'=>'');
                                    echo form_input($data);         
                                ?> 
                            </div>
                            <small>Untuk obat dan kesehatan ? </small>
                        </div>
                    </div>                    
                </div>
                <div class="box-body bg-setting-product">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i> Harga dan Biaya </h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Total Unit:'); ?>
                                <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'total_units','name'=>'total_units','placeholder'=>'e.g 10','reqiured'=>'');
                                echo form_input($data);             
                                ?>
                            </div>
                             
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Unit Per Pack: '); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'unit_per_pack','onkeyup'=>'calculate_quantity()','name'=>'packsize','placeholder'=>'e.g 12','reqiured'=>'');
                                        echo form_input($data);
                                ?>  
                            </div>
                            
                        </div>                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Jumlah Stok: '); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'stock_quantity','name'=>'stock_quantity','reqiured'=>'');
                                    echo form_input($data);
                                ?>  
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <?php echo form_label('Harga Eceran:'); ?>
                            <?php
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'unit_selling_price','onkeyup'=>'calculate_selling()','name'=>'retail','placeholder'=>'e.g 200','step'=>'.01','reqiured'=>'');
                                echo form_input($data);
                            ?>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Harga Beli:'); ?>
                                <?php               
                                  $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'unit_cost_price','name'=>'purchase','onkeyup'=>'calculate_cost()','placeholder'=>'e.g 150','step'=>'.01','reqiured'=>'');
                                echo form_input($data);         
                                ?>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Harga Eceran / Pak:'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'total_selling','name'=>'total_retail','placeholder'=>'e.g 12000','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <?php echo form_label('Harga Beli / Pak:'); ?>
                            <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'total_purchase','name'=>'total_cost','placeholder'=>'e.g 10800','reqiured'=>'');
                                echo form_input($data);         
                            ?>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Harga Grosir / Pak:'); ?>
                                <?php
                                                    
                                    $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'whole_sale_rate','name'=>'whole_sale','placeholder'=>'e.g 145','reqiured'=>'');
                                    echo form_input($data);         
                                ?>
                            </div>
                            
                        </div> 
                    </div>                    
                    <div class="row">                     
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Pajak (%) :'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'tax','value'=>'0','step'=>'.01','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Lokasi: '); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'location','placeholder'=>'Top right corner','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            
                        </div>

                    </div>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                    $data = array('class'=>'btn btn-info btn-outline-primary pull-right','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan Produk');
                                    
                                    echo form_button($data);
                                ?>
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->

<!-- product calculations  -->
<script src="<?php echo base_url(); ?>assets/dist/js/backend/product.js"></script>