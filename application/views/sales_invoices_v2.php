<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <div class="container">
        <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
            <?php
            $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
            $attributes = array('id' => 'invoice_form', 'method' => 'post', 'class' => 'form col-lg-12');
            ?>
            <?php echo form_open('invoice/manage', $attributes); ?>
            <div class="row col-lg-12">

                <div class="col-lg-3 ">
                    <div class="form-group margin ">
                        <?php echo form_label('Dari Tanggal:'); ?>
                        <div class="input-group date ">
                            <div class="input-group-addon   ">
                                <i class="fa fa-calendar "></i>
                            </div>
                            <?php
                            $data = array('class' => 'form-control  input-lg', 'type' => 'date', 'id' => 'datepicker', 'name' => 'date1', 'placeholder' => 'e.g 12-08-2018', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group margin">
                        <?php echo form_label('Sampai Tanggal:'); ?>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                            $data = array('class' => 'form-control  input-lg', 'type' => 'date', 'id' => 'datepicker', 'name' => 'date2', 'placeholder' => 'e.g 12-08-2018', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group margin ">
                        <?php echo form_label('Atau Masukan No Invoice:'); ?>
                        <?php
                        $data = array('class' => 'form-control input-lg', 'type' => 'number', 'name' => 'invoice_no', 'reqiured' => '');
                        echo form_input($data);
                        ?>
                    </div>
                </div>
                <div class="col-lg-2" style="margin-top:27px;">
                    <?php
                    $data = array('class' => 'btn btn-info btn-outline-secondary margin  pull-right input-lg', 'type' => 'submit', 'name' => 'searchecord', 'value' => 'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari');
                    echo form_button($data);
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="card card-custom position-relative overflow-hidden">

    <div class="row">
        <div class="col-lg-12 ">
            <h4 class="purchase-heading">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                DAFTAR INVOICE
            </h4>
        </div>
    </div>
    <?php
    for ($i = 0; $i < count($invoices_Record); $i++) {
    ?>
        <section class="invoice" id="<?php echo $invoices_Record[$i]['id']; ?>">
            <div class="row no-print">
                <div class="col-lg-7"></div>
                <div class="col-lg-5">
                    <a class="btn btn-primary  btn-flat  pull-right" href="<?php echo base_url() . 'invoice/edit/' . $invoices_Record[$i]['id'] ?>"><i class="fas fa-pencil-alt pull-left"></i>
                        Edit</a>
                    <a class="btn btn-primary  btn-flat  pull-right" href="<?php echo base_url() . 'invoice/copy/' . $invoices_Record[$i]['id'] ?>"><i class="fa fa-copy pull-left"></i>
                        Copy</a>
                    <a class="btn btn-info  btn-flat  pull-right" href="<?php echo base_url() . 'invoice/show/' . $invoices_Record[$i]['id'] ?>"><i class="fa fa-eye pull-left"></i>
                        Show
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-sm-9 col-xs-12">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <b>
                            <?= $invoices_Record[$i]['customer_name'] ?>
                        </b>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        </b>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <b> No Tagihan # <?= $invoices_Record[$i]['no_invoice'] ?> </b>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <b> Tanggal Tagihan : </b><?= $invoices_Record[$i]['date'] ?>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <b>
                        </b>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-12  ">
                    <div class="col-lg-12 col-sm-12 col-xs-12 ">
                        <b> Agen : </b><?= $invoices_Record[$i]['acc_0'] ?>
                    </div>

                </div>
            </div>
            <div class="row table-responsive">
                <div class="col-xs-12 ">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Qyt</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            $total = 0;
                            $total_qyt = 0;
                            $total_tax = 0;
                            //       print "<pre>";
                            //    print_r($Sales_Record);
                            foreach ($invoices_Record[$i]['item'] as $item) {
                                $total = $total + $item->amount;
                                $total_qyt = $total_qyt + $item->qyt;

                            ?>
                                <tr style="border-bottom:2px solid #ccc;">
                                    <td>
                                        <?php echo $counter; ?>
                                    </td>
                                    <td>
                                        <?= $item->keterangan_item; ?>
                                    </td>
                                    <td>
                                        <?= $item->date_item; ?>
                                    </td>
                                    <td>
                                        <?= $item->qyt; ?> <?= $item->satuan; ?>

                                    </td>
                                    <td>
                                        <?= number_format($item->amount, '2', ',', '.') ?>
                                    </td>
                                    <td>
                                        <?= number_format($item->amount * $item->qyt, '2', ',', '.') ?>

                                    </td>
                                </tr>
                            <?php
                                $counter++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table">
                            <tr class="text-left" style="border-bottom: 2px dotted #eee;">
                                <th style="width:50%">Subtotal (<?php echo $total; ?>):</th>
                                <td class="text-center">
                                    <?php echo number_format($total, '2', ',', '.'); ?>
                                </td>
                            </tr>

                            <th style="width:50%">PPn 10%

                            <td class="text-center">
                                <?php if ($invoices_Record[$i]['ppn_pph'] == '1') {
                                    $total_final = $total + ($total * 0.10);
                                    echo number_format($total * 0.10, '2', ',', '.');
                                } else {
                                    $total_final = $total;
                                    echo '-';
                                }
                                ?>
                                <tr style="border-bottom: 2px dotted #eee;">
                            </td>
                            </tr>
                            <?php
                            ?>

                            <tr style="border-bottom: 2px dotted #eee;">
                                <th>Total (Rp)
                                <td class="text-center">
                                    <?php echo number_format($total_final, '2', '.', ''); ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 2px dotted #eee;">
                                <td colspan="7">
                                    <b>Deskripsi : </b> <?php echo $invoices_Record[$i]['description']; ?>
                                </td>
                            </tr>

                            <tr style="border-bottom: 2px dotted #eee;">
                                <td colspan="7">[
                                    <b> Metode Pembayaran: </b>
                                    <?php
                                    if ($invoices_Record[$i]['payment_metode'] != 99) {
                                        echo $invoices_Record[$i]['bank_name'] . ' ' . $invoices_Record[$i]['bank_number'];
                                    } else {
                                        echo "Kredit";
                                    }
                                    ?>
                                    ]
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <script>
            $('#menu_id_6').addClass('menu-item-active menu-item-open menu-item-here"')
            $('#submenu_id_13').addClass('menu-item-active')
        </script>
    <?php
    }
    ?>
    <?php
    // print "<pre>";
    // print_r($invoices_Record);
    ?>
    <!-- Bootstrap model  -->
    <?php $this->load->view('bootstrap_model.php'); ?>
    <!-- Bootstrap model  ends-->