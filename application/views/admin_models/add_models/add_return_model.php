<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		
        <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo $page_title_model; ?></h4>
      </div>

      <div class="modal-body">

		   <div class="row">

          <div class="box box-danger">

            <div class="box-body">
   
				 <div class="col-md-12">
			<?php
					$attributes = array('id'=>'Return_items_form','method'=>'post','class'=>'form-horizontal');
			?>

			<?php echo form_open('Return_items/add_return_item',$attributes); ?>
			  
			   <div class="form-group"> 
			   <?php echo form_label('Nama Produk:'); ?>
					<select class="form-control" name="medicine_Id"  style="width: 100%;">
						<?php
								if($medicine_list != NULL){
									
								
									foreach ($medicine_list as $obj_catagory_list){
											
							?>
									
									  <option value="<?php echo $obj_catagory_list->id; ?>" ><?php echo 'Nama : '.$obj_catagory_list->medicine_name.' | Mg '.$obj_catagory_list->mg.' | Perusahaan : '.$obj_catagory_list->company.' | Formula '.$obj_catagory_list->formula.' | Jumlah: '.$obj_catagory_list->quantity; ?> </option>
									 
					<?php
								
							
									}
								}else{
									echo "No Record Found";
								}
						
				?>
							 
					</select>
              </div>

			   <div class="form-group">
			   
			   <?php echo form_label('Quantity:'); ?>
              
               <?php
					
						$data = array('class'=>'form-control','type'=>'number','name'=>'quantity','placeholder'=>'e.g 10','reqiured'=>'');
						echo form_input($data);
				
			  ?>
                </div>

			  
			  <div class="form-group">
				
				    <?php echo form_label('Deskripsi:'); ?>
     
                   <?php
					
						$data = array('class'=>'form-control','type'=>'text','id'=>'description','name'=>'description','placeholder'=>'Tambahkan Keterangan','reqiured'=>'');
						echo form_input($data);
				
					?>
              </div>
			  
			  <div class="form-group">  				
				
				<?php
					
					
					$data = array('class'=>'btn btn-info btn-flat margin ','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');
					
					echo form_button($data);
				 ?>   
				 
              </div> 
			<?php echo form_close(); ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>

  </div>
</div>
</div>
</div>
</div>