<div class="modal-content">
    <form opd="form" id="accounts_form" onsubmit="return false;" type="multipart" autocomplete="off">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-lg-8">
                    <label><i class="fa fa-check-circle"></i> Nama </label>
                    <h5><?= $return['customer_name'] ?></h5>
                </div>
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Akun Beban</label>
                    <h5><?= $return['head_name'] ?></h5>
                </div>
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Metode Pembayaran </label>
                    <h5><?= $return['payment_name'] ?></h5>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Tanggal</label>
                    <h5><?= $return['date'] ?></h5>
                </div>
                <div class="form-group col-lg-6">
                    <?php echo form_label(''); ?>
                    <label><i class="fa fa-check-circle"></i> Nomor Bukti</label>
                    <h5><?= $return['ref_no'] ?></h5>
                </div>
            </div>


            <div class="row">
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Jumlah</label>
                    <h5>Rp <?= number_format($return['total_paid'], 2, '.', ',') ?></h5>
                </div>
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Rincian Transaksi</label>
                    <h5><?= $return['description'] ?></h5>
                </div>

            </div>
            <!-- </div> -->

        </div>
        <div class="modal-footer">
            <?php
            // if (!empty($vcrud['hk_delete'] == 1)) { 
            ?>
            <a class="btn btn-danger my-1 mr-sm-2" href="<?= base_url() . 'expense/delete/' . $return['id'] ?>/true" id="" data-loading-text="Loading..."><i class='la la-trash'></i><strong>Delete</strong></a>
            <?php
            // }
            // if (!empty($vcrud['hk_update'] == 1)) { 
            ?>
            <a class="btn btn-success my-1 mr-sm-2" href="<?= base_url() . 'expense/edit/' . $return['id'] ?>" id="" data-loading-text="Loading..."><i class='la la-pencil-alt'></i><strong>Edit</strong></a>
            <?php
            //  } 
            ?>
            <a class="btn btn-info my-1 mr-sm-2" href="<?= base_url() . 'statements/show/' . $return['transaction_id'] ?>" id="" data-loading-text="Loading..."><i class='la la-eye'></i><strong>Jurnal</strong></a>
        </div>
    </form>
</div>

<script>
    $('#menu_id_27').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_92').addClass('menu-item-active')
</script>