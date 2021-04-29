<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Form Keputusan</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="box box-danger">
            <div class="box-body">
                <div class="col-md-12">
                    <?php
                    $attributes = array('id' => 'keputusan_form', 'method' => 'post', 'class' => 'form-horizontal');
                    ?>
                    <?php echo form_open_multipart($link, $attributes); ?>
                    <div class="form-group">
                        <label>Keputusan</label>
                        <input name="id" value="<?= $param ?>" />
                        <select name="keputusan" id="keputusan" class="form-control select2 input-lg">
                            <option value=0> ------- </option>
                            <option value="1">Diterima</option>
                            <option value="2">Tidak Diterima</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control select2 input-lg" name="catatan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <?php
                        $data = array('class' => 'btn btn-info btn-outline-primary ', 'type' => 'submit', 'name' => 'btn_submit_category', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan ');
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