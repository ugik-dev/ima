<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body box-bg ">
            <div class="make-container-center">
                <?php
                $attributes = array('id' => 'leadgerAccounst', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open_multipart('statements/income_statement', $attributes); ?>
                <div class="row no-print">
                    <!-- <div class="col-md-3 ">
                        <div class="form-group">
                            <label>Periode</label>
                            <select class="form-control input-lg" name="periode" id="periode">
                                <option value="tahun"> Tahun</option>
                                <option value="custom"> Periode</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="ly_tahunan">
                        <div class="form-group">
                            <label>Pilih Tahun</label>
                            <select class="form-control input-lg" name="year" id="year">
                                <option value="2019"> 2019</option>
                                <option value="2020"> 2020</option>
                                <option value="2021"> 2021</option>
                                <option value="2022"> 2022</option>
                                <option value="2023"> 2023</option>
                                <option value="2024"> 2024</option>
                                <option value="2025"> 2025</option>
                                <option value="2026"> 2026</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-md-3" id="ly_from">
                        <div class="form-group">
                            <label>Dari</label>
                            <input type="date" class="form-control" name="from" id="form" value="<?= $from ?>">
                        </div>
                    </div>
                    <div class="col-md-3" id="ly_to">
                        <div class="form-group">
                            <label>Sampai</label>
                            <input type="date" class="form-control" id="to" name="to" value="<?= $to ?>">
                        </div>
                    </div>

                    <!-- <script>
                        periode = $('#periode');
                        ly_from = $('#ly_from');
                        ly_to = $('#ly_to');
                        ly_tahunan = $('#ly_tahunan');

                        periode.on('change', function() {
                            console.log('change')
                            if (periode.val() == 'custom') {
                                ly_tahunan.hide();
                                ly_tahunan.val('');
                                ly_from.show();
                                ly_to.show();
                            } else {
                                ly_to.hide();
                                ly_to.val('');
                                ly_from.hide();
                                ly_from.val('');
                                ly_tahunan.show();
                            }
                        })
                    </script> -->

                    <div class="col-md-3 ">
                        <div class="form-group" style="margin-top:16px;">
                            <?php
                            $data = array('class' => 'btn btn-info btn-flat margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Buat Statement');
                            echo form_button($data);
                            ?>
                        </div>
                    </div>
                    <?php form_close(); ?>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <h3 style="text-align:center">LAPORAN LABA RUGI </h3>
                        <h3 style="text-align:center">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'];
                            ?>
                        </h3>
                        <h4 style="text-align:center"> Tahun Periodik: <?php echo $from . ' to ' . $to; ?> <b>
                        </h4>
                        <h4 style="text-align:center"> Dibuat <?php echo Date('Y-m-d'); ?> <b>
                        </h4>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <?php echo $income_records; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_62').addClass('menu-item-active')
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->