<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <!-- <div class="container"> -->
    <div class="alert alert-custom alert-white" role="alert">
        <?php
        $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
        $attributes = array('id' => 'pembayaran_form', 'method' => 'post', 'class' => 'form col-lg-12');
        ?>
        <?php echo form_open('pembayaran/manage', $attributes); ?>
        <div class="row col-lg-12">

            <div class="col-lg-3 ">
                <div class="form-group margin ">
                    <?php echo form_label('Dari Tanggal:'); ?>
                    <div class="input-group date ">
                        <div class="input-group-addon   ">
                            <i class="fa fa-calendar "></i>
                        </div>
                        <?php
                        // echo $filter['first_date'];
                        $data = array('class' => 'form-control  input-lg', 'type' => 'date', 'id' => 'datepicker', 'name' => 'date1', 'value' => $filter['first_date'], 'reqiured' => '');
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
                        $data = array('class' => 'form-control  input-lg', 'type' => 'date', 'id' => 'datepicker', 'name' => 'date2', 'value' => $filter['second_date'], 'reqiured' => '');
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group margin ">
                    <?php echo form_label('Search'); ?>
                    <?php
                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'search', 'value' => !empty($filter['search']) ? $filter['search'] : '',);
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
    <!-- </div> -->
</div>

<!-- <div class="card card-custom position-relative overflow-hidden">
    <div class="row">
        <div class="col-lg-12 ">
            <h4 class="purchase-heading">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                DAFTAR INVOICE
            </h4>
        </div>
    </div>
</div> -->
<?php
$cur_user = $this->session->userdata('user_id')['id'];
for ($i = 0; $i < count($pembayarans_Record); $i++) {
?>
    <hr>

    <div class="card card-custom position-relative overflow-hidden" id="<?php echo $pembayarans_Record[$i]['id']; ?>">
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="row col-lg-12">
                <div class=" col-lg-7"></div>
                <div class="col-lg-5">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle mr-1 mr-sm-14 my-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download File</button>
                        <div class="dropdown-menu">
                            <a type="button" href="<?= base_url('pembayaran/download_word/') . $pembayarans_Record[$i]['id'] ?>" class="btn mr-3 my-1">Document</a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle mr-1 mr-sm-14 my-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu">
                            <?php
                            echo  $cur_user == $pembayarans_Record[$i]['agen_id'] ? (' <a class="btn" href="' . base_url() . 'pembayaran/edit/' . $pembayarans_Record[$i]['id'] . '"><i class="fas fa-pencil-alt pull-left"></i> Edit </a>
                                <a class="btn" href="' . base_url() . 'pembayaran/delete/' . $pembayarans_Record[$i]['id'] . '"><i class="fa fa-trash pull-left"></i> Delete </a>
                                
                                ') : '';
                            ?>

                            <a class="btn" href="<?php echo base_url() . 'pembayaran/copy/' . $pembayarans_Record[$i]['id'] ?>"><i class="fa fa-copy pull-left"></i>
                                Copy</a>
                        </div>
                    </div>
                    <a class="btn btn-info mr-1 mr-sm-14 my-1" href="<?php echo base_url() . 'pembayaran/show/' . $pembayarans_Record[$i]['id'] ?>"><i class="fa fa-eye pull-left"></i>

                        Show </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-sm-9 col-xs-12">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b>
                        <?= $pembayarans_Record[$i]['customer_name'] ?>
                    </b>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    </b>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b> No Tagihan # <?= $pembayarans_Record[$i]['no_pembayaran'] ?> </b>
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b> Tanggal Tagihan : </b><?= $pembayarans_Record[$i]['date'] ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b>Deskripsi : </b> <?php echo $pembayarans_Record[$i]['description']; ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">

                    <b> Metode Pembayaran: </b>
                    <?php
                    if ($pembayarans_Record[$i]['payment_metode'] != 99) {
                        echo $pembayarans_Record[$i]['bank_name'] . ' ' . $pembayarans_Record[$i]['bank_number'];
                    } else {
                        echo "Cash";
                    }
                    ?>


                    <b>
                    </b>
                </div>
            </div>
            <div class="col-lg-3 col-sm-3 col-xs-12  ">
                <div class="col-lg-12 col-sm-12 col-xs-12 ">
                    <b> Agen : </b><?= $pembayarans_Record[$i]['acc_0'] ?>
                </div>

            </div>
        </div>
        <div class="row table-responsive container-fluid">
            <div class="col-xs-12">
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
                        foreach ($pembayarans_Record[$i]['item'] as $item) {
                            $total = $total + ceil($item->amount) * $item->qyt;
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
                                <td class="text-right">
                                    <?= number_format(ceil($item->amount), '0', ',', '.') ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format(ceil($item->amount) * $item->qyt, '0', ',', '.') ?>

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
        <div class="row container-fluid">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table">
                        <tr class="text-left" style="border-bottom: 2px dotted #eee;">
                            <th style="width:50%">Sub Total :</th>
                            <td class="text-right">
                                <?php echo number_format($total, '2', ',', '.'); ?>
                            </td>
                        </tr>
                        <?php if ($pembayarans_Record[$i]['percent_jasa'] != '0') {
                            echo '<tr class="text-left" style="border-bottom: 2px dotted #eee;"> <th style="width:50%">Biaya ' . floatval($pembayarans_Record[$i]['percent_jasa']) . '% : </th><td class="text-right"> -' . number_format((($pembayarans_Record[$i]['percent_jasa'] / 100) * $total), '2', ',', '.') . '</td></tr>
                            <tr style="border-bottom: 2px dotted #eee;">
                            <th>Sub Total :</th>
                            <td class="text-right">';
                            $total = $total - ($pembayarans_Record[$i]['percent_jasa'] / 100) * $total;
                            echo number_format($total, '2', ',', '.') . '</td></tr>';
                        }
                        if ($pembayarans_Record[$i]['percent_pph'] != '0') {
                            echo '<tr class="text-left" style="border-bottom: 2px dotted #eee;"> <th style="width:50%">Biaya ' . floatval($pembayarans_Record[$i]['percent_pph']) . '% : </th><td class="text-right"> -' . number_format((($pembayarans_Record[$i]['percent_pph'] / 100) * $total), '2', ',', '.') . '</td></tr>
                            <tr style="border-bottom: 2px dotted #eee;">
                            <th>Sub Total :</th>
                            <td class="text-right">';
                            $total = $total - ($pembayarans_Record[$i]['percent_pph'] / 100) * $total;
                            echo number_format($total, '2', ',', '.') . '</td></tr>';
                        }
                        ?>
                        <?php
                        ?>
                        <tr style="border-bottom: 2px dotted #eee;">
                            <th>Total (Rp)
                            <td class="text-right">
                                <?php echo number_format($total, '2', ',', '.'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

<?php
}
?>
<script>
    $('#menu_id_32').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_87').addClass('menu-item-active')
</script>
<?php
// print "<pre>";
// print_r($pembayarans_Record);
?>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->