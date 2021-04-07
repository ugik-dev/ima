<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
	Edit Kendaraan
</h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
			<?php
				$attributes = array('id'=>'vehicle_form','method'=>'post','class'=>'form-horizontal');
			?>
			<?php echo form_open_multipart($link,$attributes); ?>
	          <div class="form-group">	
				 <?php echo form_label('Nama Kendaraan:'); ?>
				 <?php
					$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'vehicle_id','value'=>$single_veh[0]->id);
					echo form_input($data);

						$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'vehicle_name','value'=>$single_veh[0]->name);
					echo form_input($data);
				?>
	          </div>
			   <div class="form-group">
				<?php echo form_label('Nomor Polisi:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'vehicle_no','value'=>$single_veh[0]->number);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Merk / Model:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'vehicle_model','value'=>$single_veh[0]->vehicle_id);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Nomor Rangka:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'vehicle_chase','value'=>$single_veh[0]->chase_no);
					echo form_input($data);
				?>
	          </div>
	           <div class="form-group">
				<?php echo form_label('Nomor Mesin:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'vehicle_engine','value'=>$single_veh[0]->engine_no);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Tanggal :'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date','value'=>$single_veh[0]->date);
					echo form_input($data);
				?>
	          </div>	          
			  <div class="form-group">  				
				<?php
					$data = array('class'=>'btn btn-info btn-outline-primary margin','type' => 'submit','id'=>'','name'=>'btn_submit_Testamonial','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Perbarui Kendaraan');
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
