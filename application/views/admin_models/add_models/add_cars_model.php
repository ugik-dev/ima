<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Kendaraan
    </h4>
</div>
<style>
    .modal-dialog {
        width: 90% !important
    }

    .modal-body {
        height: 100% !important;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="">
            <div class="box-body">
                <div class="col-md-12">
                    <?php
                    $attributes = array('id' => 'Customer_form', 'method' => 'post', 'class' => '');
                    ?>
                    <?php echo form_open_multipart($link, $attributes); ?>
                    <div class="row box box-default">
                        <div class="row margin">

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <h4><label class="box-label"><b>INFORMASI KENDARAAN</b></label></h4>
                                </div>

                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Pemilik:'); ?>
                                    <select name="id_customer" class="form-control select2 input-lg">
                                        <?php echo $cars_record ?>
                                    </select>
                                </div>
                            </div>
                            <!--------------------- Customer Kendaraane ------------------>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Jenis :'); ?>
                                    <select name="jenis" class="form-control input-lg">
                                        <option value="Bus"> Bus</option>
                                        <option value="Mini Bus"> Mini Bus</option>
                                        <option value="SUV"> SUV</option>
                                        <option value="Hatchback"> Hatchback</option>
                                        <option value="Sedan"> Sedan</option>
                                        <option value="Of Road"> Of Road</option>
                                        <option value="Sport"> Sport</option>
                                        <option value="Station Wagon"> Station Wagon</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('No Kendaraan:'); ?>
                                    <?php
                                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'no_cars' => 'no_kendaraan',);
                                    echo form_input($data);

                                    ?>
                                </div>
                            </div>

                            <!--------------------- Customer Phone ------------------>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Nama Kendaraan :'); ?>
                                    <?php
                                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'name_cars', 'placeholder' => '', 'reqiured' => '');
                                    echo form_input($data);
                                    ?>
                                </div>
                            </div>
                            <!-- <h4>
	              			  <label class="box-label"><b>CUSTOMER IMAGE</b></label>
	              			</h4> -->
                            <div class="col-md-12 field-agjust">
                                <div class="form-group">
                                    <?php echo form_label('Keterangan Lain-lain:'); ?>
                                    <?php
                                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'placeholder' => 'Keterangan lanjut ', 'reqiured' => '');
                                    echo form_input($data);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 field-agjust">
                                <div class="col-md-5 field-agjust">
                                    <div class="form-group">
                                        <label>Upload Foto Kendaraan (Optional)</label>
                                        <div class="input-group">

                                            <input type="file" name="picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <?php
                                        $data = array('class' => 'btn btn-info btn-outline-primary ', 'type' => 'submit', 'name' => 'btn_submit_cars', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');

                                        echo form_button($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Validation -->
<script>
    $('.select2').select2();
</script>
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js">
</script>