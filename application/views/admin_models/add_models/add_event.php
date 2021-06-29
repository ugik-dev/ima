<!-- Select2 -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
        Add E-Note
    </h4>
</div>
<div class="modal-body">
    <!-- <div class="row"> -->
    <div class="box box-danger">
        <div class="box-body">
            <div class="col-lg-12">
                <?php
                $attributes = array('id' => 'event', 'method' => 'post', 'class' => 'form-horizontal');
                ?>
                <?php echo form_open($link, $attributes); ?>
                <div class="form-group">
                    <label>Label</label>
                    <div class="checkbox-inline">
                        <label class="checkbox checkbox-rounded">
                            <input type="radio" checked="checked" name="label_event" id="label_event" value="info">
                            <span></span>
                            <div class="alert alert-primary mr-5" style="width: 100px" role="alert">Info </div>
                        </label>

                        <label class="checkbox checkbox-rounded">
                            <input type="radio" name="label_event" id="label_event" value="warning">
                            <span></span>
                            <div class="alert alert-warning mr-5" style="width: 100px" role="alert">Note </div>
                        </label>
                        <label class="checkbox checkbox-rounded">
                            <input type="radio" name="label_event" id="label_event" value="danger">
                            <span></span>
                            <div class="alert alert-danger mr-5" style="width: 100px" role="alert">Warning </div>
                        </label>
                        <label class="checkbox checkbox-rounded">
                            <input type="radio" name="label_event" id="label_event" value="success">
                            <span></span>
                            <div class="alert alert-success mr-5" style="width: 100px" role="alert">Meeting </div>
                        </label>
                        <label class="checkbox checkbox-rounded">
                            <input type="radio" name="label_event" id="label_event" value="secondary">
                            <span></span>
                            <div class="alert alert-secondary mr-5" style="min-width: 100px" role="alert">Coffe Break </div>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="url" class="form-label">Nama Note</label>
                    <div class="">
                        <input class="form-control" type="text" value="" name="nama_event" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="desk" class="form-label">Keterangan</label>
                    <div class="">
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="url" class="form-label">URL</label>
                    <div class="">
                        <input class="form-control" type="url" value="" name="url">
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="url" class="form-label">Start</label>
                        <div class="">
                            <input class="form-control" type="datetime-local" value="" name="start_event" required="required">
                        </div>
                    </div>

                    <div class="form-group  col-md-6">
                        <label for="url" class="form-label">End</label>
                        <div class="">
                            <input class="form-control" type="datetime-local" value="" name="end_event" required="required">
                        </div>
                    </div>

                </div>
                <div class="form-group">
                </div>
                <div class="form-group">
                    <?php
                    $data = array('class' => 'btn btn-info btn-outline-primary', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan Akun ');

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
    //USED TO VISIBLE EXPENSE TYPE 
    function visible_expense(value) {
        if (value == 'Expense') {
            $('#expense-type-id').css('display', 'block');
        } else {
            $('#expense-type-id').css('display', 'none');
        }
    }
</script>