<div class="card card-custom position-relative overflow-hidden" id="print-section">
    <!--begin::Shape-->
    <div class="container">
        <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">

            <?php
            $attributes = array('id' => 'leadgerAccounst', 'method' => 'post', 'class' => 'form col-lg-12');
            ?>
            <?php echo form_open_multipart('statements/leadgerAccounst', $attributes); ?>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <!-- <div class="col-lg-3"> -->
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <?php
                        $data = array('class' => 'btn btn-default btn-outline-primary  mr-2', 'type' => 'button', 'id' => 'btn_export_excel', 'value' => 'true', 'content' => '<i class="fa fa-download" aria-hidden="true"></i> Export Excel');
                        echo form_button($data);
                        ?>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="col-lg-3"> -->
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <a onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary  mr-2"><i class="fa fa-print  pull-left"></i> Cetak</a>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo form_label('Akun'); ?>
                            <select name="account_head" id="account_head" class="form-control select2 input-lg">
                                <?php echo $accounts_records; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="form-group">
                            <?php echo form_label('Dari Tanggal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'id' => 'from', 'name' => 'from', 'reqiured' => '', 'value' => $from);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="form-group">
                            <?php
                            echo $from;
                            echo form_label('Sampai Tanggal'); ?>
                            <?php
                            $data = array('class' => 'form-control input-lg', 'type' => 'date', 'id' => 'to', 'name' => 'to', 'reqiured' => '', 'value' => $to);
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3"> -->
                    <div class="form-group" style="margin-top: 24px; float: right">
                        <button class="btn btn-info btn-flat mr-2" type="submit" name="btn_submit_customer" value="true"> <i class=" fa fa-search pull-left"></i> Buat Statement</button>

                    </div>
                    <!-- </div> -->
                </div>
                <?php form_close(); ?>
            </div>
        </div>
        <?php form_close(); ?>
    </div>
</div>
<div class="card card-custom col-lg-12" id="print-section">
    <div class="card-body">

        <!-- <div class="row"> -->
        <!-- <div class="col-lg-3"></div> -->
        <div class="col-lg-12">
            <h2 style="text-align:center">BUKU BESAR </h2>
            <h3 style="text-align:center">
                <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'];
                ?>
            </h3>
            <h4 style="text-align:center"><b> Dari </b> <?php echo $from; ?> <b> Sampai </b> <?php echo $to; ?></h4>
            <h4 style="text-align:center"><b> Dibuat </b> <?php echo Date('Y-m-d'); ?> </h4>
        </div>
        <!-- <div class="col-lg-3"></div> -->
        <!-- </div> -->
        <div>
            <?php
            echo $ledger_records;
            ?>
        </div>
    </div>
</div>
<!-- </div> -->

<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_60').addClass('menu-item-active')

    $('#btn_export_excel').on('click', function() {
        console.log('s')
        from = $('#from').val()
        to = $('#to').val()
        account_head = $('#account_head').val()
        url = `<?= base_url('statements/export_excel_ledger?from=') ?>` + from + '&to=' + to + '&account_head=' + account_head;
        location.href = url;
    })
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php');
if (!empty($account_head)) {
?>
    <script>
        $('#account_head').val('<?= $account_head ?>')
    </script>
<?php
}
?>
<!-- Bootstrap model  ends-->