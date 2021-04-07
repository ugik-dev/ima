<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box " >
                <div class="box-header box-title">
                    <h4 ><i class="fa fa-pencil" aria-hidden="true"></i> 
                        Rincian Produk
                    </h4>
                </div>
                <?php
                    $attributes = array('id'=>'update_product_form','method'=>'post','class'=>'');
                ?>
                <?php echo form_open_multipart('product/edit',$attributes); ?>
                <div class="box-body bg-setting-product">
                    <?php 
                        $data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'edit_product_id','value'=>$product[0]->id);
                     echo form_input($data);
                     ?>
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i>  Informasi Produk</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Nama Produk :'); ?>
                                <?php           
                                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_product_name','value'=>$product[0]->product_name,'reqiured'=>'');
                                echo form_input($data);         
                                ?> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('SKU:'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_sku','value'=>$product[0]->sku,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Barcode:'); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_barcode','value'=>$product[0]->barcode,'reqiured'=>'');
                                        echo form_input($data);
                                ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Type:'); ?>
                                <?php 
                                    $type_options = array(
                                        'Finished Products'  => ' Produk Jadi',
                                        'Raw Product'  => 'Produk Mentah',
                                        'Service'  => 'Jasa',
                                        'Ticket'  => 'Tiket'
                                          );
                                   
                                     $extra = array(
                                      'id'       => '',
                                      'onChange' => '',
                                      'class'=>'form-control select2'
                                    );

                                    echo form_dropdown('edit_type', $type_options, array($product[0]->type),$extra); 
                                     ?>   
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_label('Deskripsi Produk :'); ?>
                                <textarea name="edit_description" class="form-control" rows="5">
                                    <?php echo $product[0]->description; ?>
                                </textarea>  
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Upload gambar:</label>
                                    <div class="input-group">
                                        <input type="file" name="edit_product_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required" >
                                    </div>
                            </div>
                            <small>Pilih gambar yang menerangkan produk ?</small>
                        </div>                        
                        <div class="col-md-4">
                            <img class="img-circle" width="80" height="80" src="<?php echo base_url('uploads/products/'.$product[0]->image)?>" />
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i> Pengelompokan </h4>
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Merk:</label>                
                                    <?php
                                    if($brand != NULL)
                                      {
                                        foreach ($brand as $single_brand)
                                        {
                                            $brand_options[$single_brand->id] = $single_brand->name;
                                        } 
                                      }
                                      else
                                      {
                                        $brand_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }
                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('brand_id', $brand_options, array($product[0]->brand_id),$extra); 
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Sektor Merk:</label>                
                                    <?php
                                        if($brandsector != NULL)
                                      {
                                        foreach ($brandsector as $single_sector)
                                        {
                                            $sector_options[$single_sector->id] = $single_sector->sector;
                                        } 
                                      }
                                      else
                                      {
                                        $sector_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }

                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('sector_id', $sector_options, array($product[0]->brand_sector_id),$extra); 
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Kategori: </label>                
                                     <?php
                                        if($catagory != NULL)
                                      {
                                        foreach ($catagory as $single_catagory)
                                        {
                                            $catagory_options[$single_catagory->id] = $single_catagory->category_name;
                                        } 
                                      }
                                      else
                                      {
                                        $catagory_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }

                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('edit_category_id', $catagory_options, array($product[0]->category_id),$extra); 
                                    ?>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="box-body bg-setting-product">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i> Unit dan Bobot: </h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Jenis Unit: </label>    
                                    <?php
                                     if($units != NULL)
                                      {
                                        foreach ($units as $single_unit)
                                        {
                                            $unit_options[$single_unit->symbol] = $single_unit->name.' '.$single_unit->symbol;
                                        } 
                                      }
                                      else
                                      {
                                        $unit_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }

                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('unit', $unit_options, array($product[0]->unit_type),$extra); 
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Bobot Unit: '); ?>
                                <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'product_mg','name'=>'edit_mg','value'=>$product[0]->mg,'reqiured'=>'');
                                     echo form_input($data);         
                                 ?>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Total Bobot: '); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'net_weight','value'=>$product[0]->net_weight,'reqiured'=>'');
                                    echo form_input($data);
                                ?>  
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="box-body">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i> Stok dan Masa Kadaluarsa</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Minimum level stok:'); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_min_stock','value'=>$product[0]->min_stock,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Tanggal Produksi:'); ?>
                                <?php                
                                    $data = array('class'=>'form-control input-lg','type'=>'date','id'=>'manufacturing','name'=>'edit_manufacturing_date','value'=>$product[0]->manufacturing,'reqiured'=>'');
                                    echo form_input($data);         
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <?php echo form_label('Tanggal Kadaluarsa:'); ?>
                            <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'date','id'=>'datepicker','name'=>'edit_expiry_date','value'=>$product[0]->expire,'reqiured'=>'');
                                echo form_input($data);         
                            ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Efek Samping:'); ?>
                                <?php               
                                    $data = array('class'=>'form-control input-lg','type'=>'text','id'=>'sideeffects','name'=>'edit_side_effects','value'=>$product[0]->sideeffects,'reqiured'=>'');
                                    echo form_input($data);         
                                ?>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="box-body bg-setting-product">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i>  Harga dan Biaya</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Jumlah Stok (Tersedia) :'); ?>
                                <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'number','disabled'=>'disabled','name'=>'edit_quantity','value'=>$product[0]->quantity,'reqiured'=>'');
                                echo form_input($data);             
                                ?>
                            </div>
                            <small>Total stok untuk produk tunggal ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <?php echo form_label('Harga Eceran Unit:'); ?>
                            <?php
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'unit_selling_price','onkeyup'=>'calculate_selling()','name'=>'edit_retail','value'=>$product[0]->retail,'step'=>'.01','reqiured'=>'');
                                echo form_input($data);

                                $data = array('type'=>'hidden','id'=>'edit_packsize','name'=>'edit_packsize','value'=>$product[0]->packsize,'reqiured'=>'');
                                 echo form_input($data);          
                            ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Harga Beli Unit:'); ?>
                                <?php               
                                  $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'unit_cost_price','name'=>'edit_purchase','onkeyup'=>'calculate_cost()','value'=>$product[0]->purchase,'step'=>'.01','reqiured'=>'');
                                echo form_input($data);         
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Harga Eceran per Pak:'); ?>
                                <?php
                                $packsizedata = ($product[0]->packsize)?$product[0]->packsize : 0;
                                        $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'total_selling','name'=>'total_retail','value'=>$packsizedata*$product[0]->retail,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <?php echo form_label('Harga Beli per Pak:'); ?>
                            <?php 
                                       
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'total_purchase','name'=>'total_cost','value'=>$packsizedata*$product[0]->purchase,'reqiured'=>'');
                                echo form_input($data);         
                            ?>
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Harga Grosir:'); ?>
                                <?php
                                                    
                                    $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'wholesale','name'=>'whole_sale','value'=>$product[0]->whole_sale,'reqiured'=>'');
                                    echo form_input($data);         
                                ?>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Pajak Penjualan (%) :'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_tax','value'=>$product[0]->tax,'step'=>'.01','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Lokasin Unit: '); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_location','value'=>$product[0]->location,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                        </div>        
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                    $data = array('class'=>'btn btn-info btn-outline-primary pull-right','type' => 'submit','name'=>'btn_submit_product','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Perbarui Produk');
                                    
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
<script src="<?php echo base_url(); ?>assets/dist/js/backend/product_details.js"></script>