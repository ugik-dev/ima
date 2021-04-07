<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
	 Tambah Printer Thermal 
	</h4>
</div>
<div class="modal-body">
	<div class="row">
 	 	<div class="box box-danger">
        	<div class="box-body">
	         	<div class="col-md-12">
				 <?php
					$attributes = array('id'=>'printer_form','method'=>'post','class'=>'form-horizontal');
				  ?>
					<?php echo form_open('printer_settings/add_printer',$attributes); ?>  
			         <div class="form-group">    
						<?php
							echo form_label('Nama Printer:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'printer_name','placeholder'=>'e.g Epson T56','reqiured'=>'');
							echo form_input($data);							
						?>           
			         </div>			         
			         <div class="form-group">    
						<?php
							echo form_label('Font Size:');
							$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'font_size','placeholder'=>'e.g 2','reqiured'=>'');
							echo form_input($data);							
						?>           
			         </div>	    
					 <div class="form-group">  				
						<?php
							$data = array('class'=>'btn btn-info btn-outline-primary','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan Printer');
							
							echo form_button($data);	
						 ?>    
			         </div>
						<?php echo form_close(); ?>			    		
	        	</div>	
     		</div>				  
		</div>
	</div>
</div>