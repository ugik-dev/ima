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
            <?php echo form_open_multipart('statements/tree_laporan_neraca', $attributes); ?>
            <div class="row no-print">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php echo form_label('Pilih Tahun'); ?>
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
            </div>
            <?php form_close(); ?>

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
                        $('#year').val('<?= $year ?>');

                        var data = <?= json_encode($accounts_records) ?>;
                        console.log(data);
                        $("div#jstree").jstree({
                            plugins: ["table", "dnd", "contextmenu", "sort"],
                            core: {
                                data: data,
                                check_callback: true
                            },
                            table: {
                                columns: [{
                                        width: 460,
                                        header: "Name"
                                    },
                                    {
                                        width: 180,
                                        value: "credit",
                                        header: "Credit (Rp)",
                                    },
                                    {
                                        width: 180,
                                        value: "debit",
                                        header: "Debit (Rp)",
                                    },
                                    {
                                        width: 180,
                                        value: "saldo",
                                        header: "Saldo (Rp)",
                                    },
                                    {
                                        width: 50,
                                        value: "ins",
                                        header: '<i class="fa fa-search text-warning mr-5"></i>'
                                    }
                                ],
                                resizable: true,
                                draggable: true,
                                contextmenu: true,
                                width: 1100,
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

    function inspect_buku_besar(i) {
        console.log('op');
        var mapForm = document.createElement("form");
        mapForm.target = "Map";
        mapForm.style = "display: none";
        mapForm.method = "POST"; // or "post" if appropriate
        mapForm.action = "<?= site_url('statements/leadgerAccounst') ?>";

        var mapInput = document.createElement("input");
        mapInput.type = "text";
        mapInput.name = "account_head";
        mapInput.value = i;
        mapForm.append(mapInput);

        var mapInput2 = document.createElement("input");
        mapInput2.type = "text";
        mapInput2.name = "from";
        mapInput2.value = "<?= $year . '-01-01' ?>";
        mapForm.append(mapInput2);

        var mapInput3 = document.createElement("input");
        mapInput3.type = "text";
        mapInput3.name = "to";
        mapInput3.value = "<?= $year . '-12-31' ?>";
        mapForm.append(mapInput3);

        document.body.appendChild(mapForm);

        map = window.open("", "Map", "status=0,title=0,height=600,width=800,scrollbars=1");

        if (map) {
            mapForm.submit();
        }
    }
</script>

<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->