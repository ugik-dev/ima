<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Kendaraan
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="">
            <div class="box-body">
                <?php
                $attributes = array('id' => 'Customer_form', 'method' => 'post', 'class' => '');
                ?>
                <?php
                echo form_open_multipart($link, $attributes); ?>
                <div class="col-md-12">
                    <?php
                    $data = array('class' => 'form-control', 'type' => 'hidden', 'name' => 'id', 'value' => $single_cars->id);
                    echo form_input($data);
                    ?>
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
                                    <select id="id_customer" name="id_customer" class="form-control select2 input-lg" value="<?= $single_cars->id_customer ?>">
                                        <?php echo $cars_record ?>
                                    </select>
                                </div>
                            </div>
                            <!--------------------- Customer Kendaraane ------------------>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Jenis :'); ?>
                                    <select name="jenis" class="form-control input-lg" id="jenis">
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
                                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_cars', 'value' => $single_cars->no_cars);
                                    echo form_input($data);

                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Nama Kendaraan :'); ?>
                                    <?php
                                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'name_cars', 'placeholder' => '', 'value' => $single_cars->name_cars);
                                    echo form_input($data);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 field-agjust">
                                <div class="form-group">
                                    <?php echo form_label('Keterangan Lain-lain:'); ?>
                                    <?php
                                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'placeholder' => 'Keterangan lanjut ', 'value' => $single_cars->description);
                                    echo form_input($data);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 field-agjust">
                        <!-- <div class="col-md-5 field-agjust"> -->
                        <h4>
                            <label class="box-label"><b>FOTO KENDARAAN</b></label>
                        </h4>
                        <div class="col-md-5 field-agjust">
                            <div class="form-group">
                                <label>Upload Foto Kendaraan (Optional)</label>
                                <div class="input-group">
                                    <input type="file" name="cars_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 field-agjust ">
                            <div class="form-group margin">
                                <img src="<?php echo base_url('uploads/cars_picture/' . $single_cars->cars_picture); ?>" class="img-circle" width="70" height="70" name="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <?php
                        $data = array('class' => 'btn btn-info btn-outline-primary ', 'type' => 'submit', 'name' => 'btn_submit_cars', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Perbarui Customer');

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
<script>
    $('#id_customer').val('<?= $single_cars->id_customer ?>')
    $('#jenis').val('<?= $single_cars->jenis ?>')
</script>
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js">
</script>