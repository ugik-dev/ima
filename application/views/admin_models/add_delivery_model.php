<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
    Tambah Rincian Deliveri</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">
                    <?php
        					$attributes = array('id'=>'Deliverd_form','method'=>'post','class'=>'form-horizontal');
        			?>
                        <?php echo form_open('Orders/add_deliverd_details/',$attributes); ?>
                            <div class="form-group">
                                <?php
                						echo form_label('Deliveri Ke :');

                						$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_invoice_Id','value'=>'');
                						echo form_input($data);	

                						$data = array('class'=>'form-control','type'=>'text','name'=>'delivered_to','placeholder'=>'');
                						echo form_input($data);		

                				?>
                            </div>
                            <div class="form-group">
                                <?php
                						echo form_label('Dikirim Oleh :');

                						$data = array('class'=>'form-control','type'=>'text','name'=>'delivered_by','placeholder'=>' ');
                						echo form_input($data);
                				?>
                            </div>
                            <div class="form-group">
                                <?php
                						echo form_label('Tanggal Deliveri :');
                						$data = array('class'=>'form-control','type'=>'date','name'=>'delivered_date');
                						echo form_input($data);
                				?>
                            </div>
                            <div class="form-group">
                                <?php
                						echo form_label('Keterangan :');
                						$data = array('class'=>'form-control','type'=>'text','name'=>'delivered_description','placeholder'=>'Enter delivered descripton');
                						echo form_input($data);
                				?>
                            </div>
                            <div class="form-group">
                                <?php
                					$data = array('class'=>'btn btn-info btn-flat margin ','type' => 'submit','name'=>'btn_delivered','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');
                					echo form_button($data);
                				 ?>
                            </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
