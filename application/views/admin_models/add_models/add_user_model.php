<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Pengguna</h4>
</div>
<div class="modal-body">
   <div class="row">
	  	<div class="box box-danger">
	    	<div class="box-body">
	      		<div class="col-md-12">
		<?php
				$attributes = array('id'=>'User_form','method'=>'post','class'=>'form-horizontal');
		?>
		<?php echo form_open_multipart('Users/add_user',$attributes); ?>
	      <div class="form-group">	
			<?php echo form_label('Nama Pengguna :'); ?>
			<?php
				$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'user_name','placeholder'=>'Masukkan Nama Pengguna','reqiured'=>'');
				echo form_input($data);
			
			?>
	      </div>
		   <div class="form-group">
			<?php echo form_label('Alamat Email:'); ?>
	           <?php
				
					$data = array('class'=>'form-control input-lg','type'=>'email','name'=>'user_email','placeholder'=>'e.g email@gmail.com','reqiured'=>'');
					echo form_input($data);
			
				?>
	      </div>
		   <div class="form-group">
		   	  <?php echo form_label('Alamat:'); ?>
	           <?php
					
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'User_Address','placeholder'=>'Masukkan Alamat','reqiured'=>'');
					echo form_input($data);
				
			  ?>
	        </div>
		   <div class="form-group">
		   <?php echo form_label('Nomor HP:'); ?>
			<?php
					$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'User_Contatc1','placeholder'=>'e.g 00659855487','reqiured'=>'');
					echo form_input($data);
		   ?>
	      </div>
		   <div class="form-group">
		     <?php echo form_label('Nomor Telepon (Optional):'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'User_Contatc2','placeholder'=>'e.g 00659855487','reqiured'=>'');
					echo form_input($data);
				?>
	      </div>
		    <div class="form-group">
			   <?php echo form_label('Rincian:'); ?>
	           <?php
				
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'User_description','placeholder'=>'Tambahkan keterangan ','reqiured'=>'');
					echo form_input($data);
				?>
	      </div>
	      <div class="form-group">
		    <?php echo form_label('Kata Sandi :'); ?>
	        <?php
				$data = array('class'=>'form-control input-lg','id'=>'user_password','type'=>'password','name'=>'user_password','placeholder'=>'e.g xs4kAcd ','reqiured'=>'');
				echo form_input($data);
			?>
	  	</div>
	    <div class="form-group">
		    <?php echo form_label('Ulangi Kata Sansi :'); ?>
	        <?php
				$data = array('class'=>'form-control input-lg','id'=>'User_cpassword','type'=>'password','name'=>'User_cpassword','placeholder'=>'e.g xs4kAcd ','reqiured'=>'');
				echo form_input($data);
			?>
	  </div>
	   <div class="form-group">
	    <label>Upload Foto User (Optional)</label>
		<div class="input-group">
			<input type="file" name="User_Picture" data-validate="required" data-message-required="Value Required" />
	    </div>
	  </div>
	  <div class="form-group">  				
		<?php
			$data = array('class'=>'btn btn-info btn-outline-primary input-lg ','type' => 'submit','name'=>'btn_submit_usertomer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');
			
			echo form_button($data);		
		 ?>    
	  </div> 
		<?php echo form_close(); ?>
	    </div>	
	  </div>
  </div>
</div>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>