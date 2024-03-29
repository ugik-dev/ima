<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?= (!empty($return_data) ? 'Edit Patners' : 'Tambah Patners') ?>
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
                        <div class="col-sm-12">

                            <!-- <div class="col-md-12">
                                <div class="col-md-6"> -->
                            <h4><label class="box-label"><b>INFORMASI PATNER</b></label></h4>
                            <!-- </div> -->
                            <div class="col-md-6" hidden>
                                <div class="col-md-8 pull-right row">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-size:20px;">Jenis Customer: </label>
                                        <div class="col-sm-9">
                                            <select name="customer_type" class="form-control input-lg">
                                                <option value="Walk in"> Walk-in</option>
                                                <option value="Regular"> Regular</option>
                                                <option value="Reseller"> Reseller</option>
                                                <option value="Higher Purchase"> Higher Purchase</option>
                                                <option value="Distributor"> Distributor</option>
                                                <option value="Corporate"> Corporate</option>
                                                <option value="Friends"> Friends</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Nama Customer:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->customer_name : ''), 'name' => 'customer_name', 'placeholder' => 'Masukkan Nama Customer', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <!--------------------- Customer Mobile ------------------>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('NPWP :'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'number', 'value' => (!empty($return_data) ? $return_data->npwp : ''), 'name' => 'npwp', 'placeholder' => 'e.g 00659855487', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Nomor HP :'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'number', 'value' => (!empty($return_data) ? $return_data->cus_contact_2 : ''), 'name' => 'customer_contact_two', 'placeholder' => 'e.g 00659855487', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Alamat Email:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'email', 'value' => (!empty($return_data) ? $return_data->cus_email : ''), 'name' => 'customer_email', 'placeholder' => 'example@gmail.com');
                                echo form_input($data);

                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Head Label:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->head_label : ''), 'name' => 'head_label', 'placeholder' => 'Direktur / Direktur Utama / HRD');
                                echo form_input($data);

                                ?>
                            </div>
                        </div>

                        <!--------------------- Customer Phone ------------------>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Nomor Telepon:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'number', 'value' => (!empty($return_data) ? $return_data->cus_contact_1 : ''), 'name' => 'customer_contatc1', 'placeholder' => 'e.g 00659855487', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('NIK / KTP:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->customer_nationalid : ''), 'name' => 'customer_cnic', 'placeholder' => 'e.g 5248222154', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>

                        <!--------------------- address ------------------>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Alamat Customer:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->cus_address : ''), 'name' => 'customer_address', 'placeholder' => 'e.g Jl. Apa Saja - 5566', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>


                        <!---------------------  Company ------------------>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Perusahaan:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->cus_company : ''), 'name' => 'customer_company', 'placeholder' => 'e.g Pertamina', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>

                        <!---------------------  Region ------------------>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Region:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->cus_region : ''), 'name' => 'customer_region', 'placeholder' => 'e.g Jawa Barat', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <!---------------------  Town ------------------>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Kota:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->cus_town : ''), 'name' => 'customer_town', 'placeholder' => 'e.g Karawang ', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label('Lokasi GBTL / GBT:'); ?>
                                <?php
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->cus_town : ''), 'name' => 'customer_town', 'placeholder' => 'e.g Karawang ', 'reqiured' => '');
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
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'value' => (!empty($return_data) ? $return_data->cus_description : ''), 'name' => 'customer_description', 'placeholder' => 'Keterangan lanjut ', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12 field-agjust">
                            <div class="col-md-5 field-agjust">
                                <div class="form-group">
                                    <label>Upload Foto Customer (Optional)</label>
                                    <div class="input-group">

                                        <input type="file" name="customer_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required">
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($return_data)) { ?>
                                <input hidden name="edit_customer_id" value="<?= $return_data->id ?>">
                                <div class=" col-md-4 field-agjust ">
                                    <div class=" form-group margin">
                                        <img src="<?php echo base_url('uploads/customers/' . $return_data->cus_picture); ?>" class="img-circle" width="70" height="70" name="" />
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <?php
                                    $data = array('class' => 'btn btn-info btn-outline-primary ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan');

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
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>