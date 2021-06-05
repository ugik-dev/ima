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
            <?php echo form_open_multipart('statements/income_statement', $attributes); ?>
            <div class="row no-print">
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

                    <div id="jstree1">
                        <div id="jstree"></div>
                    </div>
                    <script type="text/javascript">
                        // $(document).ready(function() {
                        // tree data
                        var data = <?= json_encode($accounts_records) ?>;

                        // load jstree
                        $("div#jstree").jstree({
                            plugins: ["table", "dnd", "contextmenu", "sort"],
                            core: {
                                data: data,
                                check_callback: true
                            },
                            // configure tree table
                            table: {
                                columns: [{
                                        width: 500,
                                        header: "Name"
                                    },
                                    {
                                        width: 300,
                                        value: "amount",
                                        header: "Amount (Rp)",
                                        // format: function(v) {
                                        //     if (v) {
                                        //         return '' + v.toFixed(2)
                                        //     }
                                        // }
                                    },
                                    // {
                                    //     width: 15000,
                                    //     value: "quantity",
                                    //     header: "Qty"
                                    // }
                                ],
                                resizable: true,
                                draggable: true,
                                contextmenu: true,
                                width: 1000,
                                // height: 2000
                            }
                        });
                        // });
                    </script>

                    <!-- <div id="jstree"></div> -->
                    <!-- <div id="jstree_demo_div"></div> -->
                    <!-- <div id="jstree"> -->
                    <!-- <ul> -->
                    <?php
                    // echo $accounts_records
                    ?>
                    <!-- <li>
                                Root node 1
                                <ul>
                                    <li data-jstree='{ "selected" : true }'>
                                        <a href="javascript:;">
                                            Initially selected </a>
                                    </li>
                                    <li data-jstree='{ "icon" : "flaticon2-analytics text-success " }'>
                                        custom icon URL
                                    </li>
                                    <li data-jstree='{ "opened" : true }'>
                                        initially open
                                        <ul>
                                            <li data-jstree='{ "disabled" : true }'>
                                                Disabled Node
                                            </li>
                                            <li data-jstree='{ "type" : "file" }'>
                                                Another node
                                            </li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{ "icon" : "flaticon2-user text-danger" }'>
                                        Custom icon class (bootstrap)
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree='{ "type" : "file" }'>
                                <a href="https://keenthemes.com/">
                                    Clickable link node </a>
                            </li> -->
                    <!-- </ul> -->
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- </section> -->
<script>
    $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_79').addClass('menu-item-active')
</script>

<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->