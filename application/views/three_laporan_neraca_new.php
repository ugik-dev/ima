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
            $attributes = array('id' => 'leadgerAccounst', 'method' => 'get', 'class' => '');
            ?>
            <?php echo form_open_multipart('statements/' . $url_form, $attributes); ?>
            <div class="row no-print">
                <div class="col-md-2">
                    <div class="form-group">
                        <?php echo form_label('Periode'); ?>
                        <select class="form-control input-lg" name="periode" id="periode">
                            <option value="tahunan"> Tahunan</option>
                            <option value="bulanan"> Bulanan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?php echo form_label('Tahun'); ?>
                        <select class="form-control input-lg" name="tahun" id="tahun">
                            <option value="2011"> 2011</option>
                            <option value="2012"> 2012</option>
                            <option value="2013"> 2013</option>
                            <option value="2014"> 2014</option>
                            <option value="2015"> 2015</option>
                            <option value="2016"> 2016</option>
                            <option value="2017"> 2017</option>
                            <option value="2018"> 2018</option>
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
                <div class="col-md-2">
                    <div class="form-group">
                        <?php echo form_label('Bulan'); ?>
                        <select class="form-control input-lg" name="bulan" id="bulan">
                            <option value="0"> -------- </option>
                            <option value="1"> Januari (1)</option>
                            <option value="2"> Februari (2)</option>
                            <option value="3"> Maret (3)</option>
                            <option value="4"> April (4)</option>
                            <option value="5"> Mei (5)</option>
                            <option value="6"> Juni (6)</option>
                            <option value="7"> Juli (7)</option>
                            <option value="8"> Agustus (8)</option>
                            <option value="9"> September (9)</option>
                            <option value="10"> Oktober (10)</option>
                            <option value="11"> November (11)</option>
                            <option value="12"> Desember (12)</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="col-md-2"> -->
                <div class="form-group" style="margin-top:20px;">
                    <?php
                    $data = array('class' => 'btn btn-info btn-flat margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Buat Statement');
                    echo form_button($data);
                    ?>
                    <!-- </div> -->
                </div>
                <!-- <div class="col-md-2"> -->
                <div class="form-group" style="margin-top:20px;">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-info btn-flat margin btn-lg pull-right ml-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download" aria-hidden="true"></i> Excel
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item btn btn-info btn-flat margin btn-lg pull-right ml-2" href="<?= base_url() . 'download/xls_neraca_saldo?' . (!empty($xls) ? 'laba_rugi=true&' : '') . 'periode=' . $filter['periode'] . '&tahun=' . $filter['tahun'] . '&bulan=' . $filter['bulan'] ?>"> Format 1</a>
                            <a class="dropdown-item btn btn-info btn-flat margin btn-lg pull-right ml-2" href="<?= base_url() . 'download/xls_neraca_saldo?' . (!empty($xls) ? 'laba_rugi=true&' : '') . 'periode=' . $filter['periode'] . '&tahun=' . $filter['tahun'] . '&bulan=' . $filter['bulan'] ?>&template=2"> Format 2</a>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- </div> -->

            </div>
            <script>
                $('#periode').on('change', () => {
                    if ($('#periode').val() == 'tahunan') {
                        $('#bulan').prop('disabled', true)
                    } else {
                        $('#bulan').prop('disabled', false)
                        console.log('change periode');
                    }
                })

                filter = <?= json_encode($filter) ?>

                $('#bulan').val(filter['bulan']);
                $('#tahun').val(filter['tahun']);
                $('#periode').val(filter['periode']);
            </script>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h3 style="text-align:center"><?= $title ?> </h3>
                    <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'];
                        ?>
                    </h3>
                    <h4 style="text-align:center"> per <?php
                                                        if ($filter['periode'] == 'bulanan') {
                                                            $namaBulan = array("Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                            echo  '1 '  . $namaBulan[(int)$filter['bulan'] - 1] . ' ' . $filter['tahun'] . ' s/d 31 '  . $namaBulan[(int)$filter['bulan'] - 1] . ' ' . $filter['tahun'];
                                                        } else {
                                                            echo '1 Januari ' . $filter['tahun'] . ' s/d ' . '31 Desember '  . $filter['tahun'];
                                                        }
                                                        ?> <b>
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
                        console.log(data);
                        $("div#jstree").jstree({
                            plugins: ["table", "dnd", "contextmenu", "search",
                                "state", "types", "wholerow"
                            ],
                            core: {
                                "animation": 1,
                                "check_callback": true,
                                "themes": {
                                    "stripes": true
                                },

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
                                        value: "saldo_s",
                                        header: "Saldo Periode Sebelum (Rp)",
                                    },
                                    {
                                        width: 180,
                                        value: "mutasi",
                                        header: "Mutasi (Rp)",
                                    },
                                    // {
                                    //     width: 180,
                                    //     value: "debit",
                                    //     header: "Debit (Rp)",
                                    // },
                                    {
                                        width: 180,
                                        value: "saldo",
                                        header: "Saldo Sekarang (Rp)",
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
    $('#submenu_id_<?= $submenu_id ?>').addClass('menu-item-active')

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
        mapInput2.value = "<?= $filter['tahun'] . '-' . $filter['bulan'] . '-01' ?>";
        mapForm.append(mapInput2);

        var mapInput3 = document.createElement("input");
        mapInput3.type = "text";
        mapInput3.name = "to";
        mapInput3.value = "<?= $filter['tahun'] . '-' . $filter['bulan'] . '-31' ?>";
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