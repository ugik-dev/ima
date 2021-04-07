<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
	Tambah Sopir 
</h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
			<?php
				$attributes = array('id'=>'driver_form','method'=>'post','class'=>'form-horizontal');
			?>
			<?php echo form_open_multipart('supply/add_driver',$attributes); ?>
	          <div class="form-group">	
				 <?php echo form_label('Nama Sopir:'); ?>
				 <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'driver_name','placeholder'=>'Masukkan Nama Sopir');
					echo form_input($data);
				?>
	          </div>
			   <div class="form-group">
				<?php echo form_label('Nomor Kontak:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'contact_no','placeholder'=>'e.g 3472394224');
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Alamat :'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'address','placeholder'=>'e.g Jl. Apa Saja - 5656.');
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Nomor SIM:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'lisence','placeholder'=>'e.g 4220118099878');
					echo form_input($data);
				?>
	          </div>
	           <div class="form-group">
				<?php echo form_label('Referensi:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'reference','placeholder'=>'e.g Mobil Kontener');
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Tanggal:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date');
					echo form_input($data);
				?>
	          </div>
			   <div class="form-group">
	            <label>Upload Foto </label>
					<div class="input-group">
	      				<input type="file" class="form-control input-lg" name="supply_picture" data-validate="required" data-message-required="Value Required" >
	            	</div>
	          </div>
			  <div class="form-group">  				
				<?php
					$data = array('class'=>'btn btn-info btn-outline-primary margin','type' => 'submit','id'=>'','name'=>'btn_submit_Testamonial','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');
					echo form_button($data);
				 ?>   
	          </div>
		<?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>
