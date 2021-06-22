<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Hak Akses</h4>
</div>
<div class="modal-body">
    <!-- <div class="row"> -->
    <div class="box box-danger">
        <div class="box-body">
            <!-- <div class="col-lg-12"> -->
            <?php
            $attributes = array('id' => 'multiple_roles_form', 'method' => 'post', 'class' => 'form-horizontal');
            ?>
            <?php echo form_open('multiple_roles/edit_role', $attributes); ?>
            <div class="form-group col-lg-12">
                <input type="hidden" name="user_id" value="<?= $result_roles[0]->id ?>">
                <?php
                if ($user_list != NULL) {
                    foreach ($user_list as $obj_user_list) {
                        if ($obj_user_list->id == $result_roles[0]->id)
                            echo 'Nama : ' . $obj_user_list->user_name . ' | Email : ' . $obj_user_list->user_email;
                ?>
                <?php
                    }
                } else {
                    echo "No User Record Found";
                }
                ?>
            </div>
            <hr />
            <div class="row">
                <?php
                if ($result_roles != NULL) {
                    foreach ($result_roles as $obj_result_roles) {
                ?>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_label($obj_result_roles->menu_name . $obj_result_roles->roleid . '  :'); ?>
                                <?php
                                $data = array('class' => '', 'type' => 'hidden', 'value' => $obj_result_roles->menu_id, 'name' => 'menu_id[]', 'reqiured' => '');
                                echo form_input($data);
                                if ($obj_result_roles->roleid == NULL) { ?>
                                    <select class="form-control input-lg" name="role_id[]" style="width: 100%;">
                                        <option value="0" selected> Tidak</option>
                                        <option value="1"> Ya</option>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control input-lg" name="role_id[]" style="width: 100%;">
                                        <option value="0"> Tidak</option>
                                        <option value="1" selected> Ya</option>
                                    </select>
                                <?php } ?>

                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "No Menu Items Found";
                }
                ?>
            </div>
            <div class="form-group">
                <?php
                $data = array('class' => 'btn btn-info btn-outline-primary', 'type' => 'submit', 'name' => 'btn_submit_category', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Perbarui Hak Akses');
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