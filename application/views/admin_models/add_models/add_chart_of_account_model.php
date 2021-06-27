<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
		Tambah Akun
	</h4>
</div>
<div class="modal-body">
	<!-- <div class="row"> -->
	<div class="box box-danger">
		<div class="box-body">
			<div class="col-md-6">
				<?php
				$attributes = array('id' => 'chart_of_accounts_form', 'method' => 'post', 'class' => 'form-horizontal');
				?>
				<?php echo form_open($link, $attributes); ?>
				<div class="form-group">
					<?php echo form_label('Nama Akun:'); ?>
					<?php
					$data = array('class' => 'form-control input-lg mask_account_name', 'type' => 'text', 'name' => 'name', 'placeholder' => '[_.__.___.___] Nama Akun', 'reqiured' => '');
					echo form_input($data);
					?>
				</div>
				<div class="form-group">
					<label>Kelompok Akun:</label>
					<select class="form-control input-lg" onchange="visible_expense(this.value)" name="nature" id="nature" style="width: 100%;">
						<option value="Assets">Assets</option>
						<option value="Liability">Liability</option>
						<option value="Equity">Equity</option>
						<option value="Expense">Expense</option>
						<option value="Revenue">Revenue</option>
					</select>
				</div>
				<div class="form-group">
					<label>Tipe Akun :</label>
					<select class="form-control input-lg" name="type" id="type" style="width: 100%;">
						<option value="Lancar">Lancar (Current)</option>
						<option value="Tetap">Tetap (Fixed)</option>
					</select>
				</div>
				<div class="form-group" id="expense-type-id">
					<label>Jenis Beban :</label>
					<select class="form-control select2 input-lg" name="expense_type" id="expense_type">
						<option value="Beban Kas">Beban Kas</option>
						<option value="Beban Non Kas">Beban Non Kas</option>
						<option value="Beban Barang">Beban Barang</option>
					</select>
				</div>
				<div class="form-group">
					<?php
					$data = array('class' => 'btn btn-info btn-outline-primary', 'type' => 'submit', 'name' => 'btn_submit_medicine', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan Akun ');

					echo form_button($data);
					?>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<!-- </div> -->
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>
<script type="text/javascript">
	$('.mask_account_name').mask('[0.00.000.000] #################################################################################', {
		translation: {

			'#': {
				pattern: /[ a-zA-Z0-9]/
			},
			placeholder: "__/__/____"
		}
	});
	//USED TO VISIBLE EXPENSE TYPE 
	function visible_expense(value) {
		if (value == 'Expense') {
			$('#expense-type-id').css('display', 'block');
		} else {
			$('#expense-type-id').css('display', 'none');
		}

	}
</script>