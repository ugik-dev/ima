<style type="text/css">
	.modal-backdrop
	{
		z-index: 0 !important;
	}
</style>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-key" aria-hidden="true"></i>  Ganti Kata Sandi
	</h4>
</div> 
<div class="modal-body"> 
	<?php
			$attributes = array('id'=>'change_password_Model_Admin','method'=>'post');
	?>
	<?php echo form_open('profile/change_password',$attributes); ?>
	<div class="form-group">
		<?php echo form_label('Kata Sandi Lama :'); ?>
		<?php
			$data = array('class'=>'form-control','id'=>'old_password','type'=>'password','name'=>'old_password','placeholder'=>'Masukkan Kata Sandi lama','reqiured'=>'');
			echo form_input($data);
		?>
	</div>
	<div class="form-group">
		<?php echo form_label('Kata Sandi Baru :'); ?>
		<?php
		
			$data = array('class'=>'form-control','id'=>'new_password','type'=>'password','name'=>'new_password','placeholder'=>'Masukkan Kata Sandi baru','reqiured'=>'');
			echo form_input($data);
		?>
	</div>  
	<div class="form-group">
		<?php echo form_label('Ulangi Kata Sandi :'); ?>
		<?php
			$data = array('class'=>'form-control','id'=>'confirm_password','type'=>'password','name'=>'confirm_password','placeholder'=>'Konfirmasi Kata Sandi','reqiured'=>'');
			echo form_input($data);
	?>
	</div>
	<div class="form-group">	
		<?php
			$data = array('class'=>'btn btn-info  btn-set btn-lg','name'=>'btn_submit_login','value'=>'Ganti Kata Sandi');
			
			echo form_submit($data);
		 ?> 
	</div> 
		<br />		  
	<?php echo form_close(); ?>		
</div>   
