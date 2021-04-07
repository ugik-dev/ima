<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Bank </h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
		 <?php
				$attributes = array('id'=>'bank_form','method'=>'post','class'=>'form-horizontal');
		?>
		<?php echo form_open('bank/add_bank',$attributes); ?>  
          <div class="form-group">    
			<?php
					echo form_label('Nama Bank:');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'bankname','placeholder'=>'e.g Standard chartered','reqiured'=>'');
					echo form_input($data);							
			?>           
          </div>	  
          <div class="form-group">  
				<?php
					echo form_label('Nama Cabang :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'branch','placeholder'=>'e.g Standard Chartered Bank Hill Park Branch','reqiured'=>'');
					echo form_input($data);	
				 ?>	
		  </div>          
		  <div class="form-group">  
				<?php
					echo form_label('Kode Cabang :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'branchcode','placeholder'=>'e.g 0051','reqiured'=>'');
					echo form_input($data);	
				 ?>	
		  </div>
		  <div class="form-group">  
				<?php
					echo form_label('Nama Akun :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'title','placeholder'=>'e.g Gigabyte Ltd','reqiured'=>'');
					echo form_input($data);	
				 ?>	
		  </div>
		  <div class="form-group">  
				<?php
					echo form_label('Nomor Akun :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'accountno','placeholder'=>'e.g 02051305326','reqiured'=>'');
					echo form_input($data);	
				 ?>	
		  </div>	
		  <div class="form-group">  
				<?php
					echo form_label('Jenis Akun :');
				 ?>	
				 <select name="account_type"  class="form-control input-lg">
				 	<option value="0" >Akun Baru</option>
				 	<option value="1" >Yang Sudah Ada</option>
				 </select>
		  </div>
  		  <div id="existing_account">	 	  
				  <div class="form-group">  
						<?php
							echo form_label('Tanggal Akhir Statement :');
							$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'ending_date','reqiured'=>'');
							echo form_input($data);	
						 ?>	
				  </div> 
				  <div class="form-group">  
						<?php
							echo form_label('Saldo Akhir Statement :');
							$data = array('class'=>'form-control input-lg','type'=>'number','step'=>'.01','name'=>'ending_balance','placeholder'=>'e.g 5000','reqiured'=>'');
							echo form_input($data);	
						 ?>	
				  </div>
			  </div>	
			  <div class="form-group">  				
				<?php
					$data = array('class'=>'btn btn-info btn-outline-primary','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');
					
					echo form_button($data);	
				 ?>    
	          </div>
          </div>	
		<?php echo form_close(); ?>			    		
        </div>				  
	    </div>
	</div>
</div>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>
<script type="text/javascript">
	function show_opening_balance(val)
	{
		if(val == 1)
		{
			$('#existing_account').css('display','block');	
		}
		else
		{
			$('#existing_account').css('display','none');
		}
	}
</script>