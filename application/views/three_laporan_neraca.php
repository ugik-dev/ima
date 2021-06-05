<!-- <section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section> -->
<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <div class="container">
        <div class="make-container-center">
            <?php
            $attributes = array('id' => 'leadgerAccounst', 'method' => 'post', 'class' => '');
            ?>
            <?php echo form_open_multipart('statements/three_laporan_neraca', $attributes); ?>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <?php
                        $data = array('class' => 'btn btn-default btn-outline-primary  mr-2', 'type' => 'button', 'id' => 'btn_export_excel', 'value' => 'true', 'content' => '<i class="fa fa-download" aria-hidden="true"></i> Export Excel');
                        echo form_button($data);
                        ?>
                    </div>
                    <div style="float: right" class="form-group" style="margin-top: 16px;">
                        <a onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary  mr-2"><i class="fa fa-print  pull-left"></i> Cetak</a>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="row col-lg-12">
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
                            <?php echo form_label('Sampai Tanggal'); ?>
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
            </div>

            <!-- <div class="row no-print">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php echo form_label('Pilih Tahun'); ?>
                        <select class="form-control input-lg" name="year" id="year">
                            <option value="2019"> 2019</option>
                            <option value="2020"> 2020</option>
                            <option value="2021" selected> 2021</option>
                            <option value="2022"> 2022</option>
                            <option value="2023"> 2023</option>
                            <option value="2024"> 2024</option>
                            <option value="2025"> 2025</option>
                            <option value="2026"> 2026</option>
                        </select>
                    </div>
                </div>
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
            </div> -->
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

                    <div id="jstree1">
                        <div id="jstree"></div>
                    </div>
                    <script type="text/javascript">
                        var data = <?= json_encode($accounts_records) ?>;
                        $("div#jstree").jstree({
                            plugins: ["table", "dnd", "contextmenu", "sort"],
                            core: {
                                data: data,
                                check_callback: true
                            },
                            table: {
                                columns: [{
                                        width: 500,
                                        header: "Name"
                                    },
                                    {
                                        width: 300,
                                        value: "credit",
                                        header: "Credit (Rp)",
                                    },
                                    {
                                        width: 300,
                                        value: "debit",
                                        header: "Debit (Rp)",
                                    },
                                ],
                                resizable: true,
                                draggable: true,
                                contextmenu: true,
                                width: 1000,
                            }
                        });
                    </script>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- </div> -->
<!-- </section> -->
<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_80').addClass('menu-item-active')
</script>

<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->