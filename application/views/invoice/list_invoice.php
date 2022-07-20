<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <!-- <div class="container"> -->
    <div class="alert alert-custom alert-white" role="alert">
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
                        // echo $filter['first_date'];
                        $data = array('class' => 'form-control  input-lg', 'type' => 'date', 'id' => 'date1', 'name' => 'date1', 'value' => $filter['first_date'], 'reqiured' => '');
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
                        $data = array('class' => 'form-control  input-lg', 'type' => 'date', 'id' => 'date2', 'name' => 'date2', 'value' => $filter['second_date'], 'reqiured' => '');
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group margin ">
                    <?php echo form_label('Search :'); ?>
                    <?php
                    $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'search', 'id' => 'search', 'value' => $filter['search'],);
                    echo form_input($data);
                    ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group margin ">
                    <?php echo form_label('Status:'); ?>
                    <select class="form-control" name="status" value="<?= $filter['status'] ?>">
                        <option value="">Semua Status</option>
                        <option <?= $filter['status'] == 'paid' ? 'selected' : '' ?> value="paid">Lunas</option>
                        <option <?= $filter['status'] == 'unpaid' ? 'selected' : '' ?> value="unpaid">Belum Lunas</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12" style="margin-top:27px;">
                <?php
                $data = array('class' => 'btn btn-info btn-outline-secondary margin  pull-right input-lg', 'type' => 'submit', 'name' => 'searchecord', 'value' => 'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari');
                echo form_button($data);
                ?>

                <a href="<?= base_url('invoice/export/' . $filter['first_date'] . '/' . $filter['second_date']) ?>" class="btn btn-info btn-outline-secondary margin  pull-right input-lg mr-2 "><i class="fa fa-file-export" aria-hidden="true"></i> Export</a>
                <!-- <a id="export_btn" class="btn btn-info btn-outline-secondary margin  pull-right input-lg mr-2 "><i class="fa fa-file-export" aria-hidden="true"></i> Export</a> -->
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

$st_paid = '<div class="btn btn-success font-weight-bold col-lg-9">
    <i class="flaticon2-checkmark"></i> <b>Lunas</b>
</div>
                        ';

$st_unpaid = '<div class="btn btn-danger font-weight-bold col-lg-9">
    <i class="flaticon2-exclamation"></i> <b>Belum Lunas</b>
</div>
                        ';

for ($i = 0; $i < count($invoices_Record); $i++) {
?>
    <hr>

    <div class="card card-custom position-relative overflow-hidden" id="<?php echo $invoices_Record[$i]['id']; ?>">
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="row col-lg-12">
                <div class=" col-lg-7"></div>
                <div class="col-lg-5">
                    <!-- <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle mr-1 mr-sm-14 my-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download File</button>
                        <div class="dropdown-menu">
                            <a type="button" href="<?= base_url('invoice/download_word/') . $invoices_Record[$i]['id'] ?>" class="btn mr-3 my-1">To KA Akuntansi</a>
                            <a type="button" href="<?= base_url('invoice/download_word/') . $invoices_Record[$i]['id'] ?>/2" class="btn mr-3 my-1">To Divisi Eksplorasi</a>
                            <a type="button" href="<?= base_url('invoice/download/') . $invoices_Record[$i]['id'] ?>" class="btn">Invoice PDF</a>
                        </div>
                    </div> -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle mr-1 mr-sm-14 my-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu">
                            <?php
                            echo  $cur_user == $invoices_Record[$i]['agen_id'] ? (' <a class="btn" href="' . base_url() . 'invoice/edit/' . $invoices_Record[$i]['id'] . '"><i class="fas fa-pencil-alt pull-left"></i> Edit </a>
                                <a class="btn" href="' . base_url() . 'invoice/delete/' . $invoices_Record[$i]['id'] . '"><i class="fa fa-trash pull-left"></i> Delete </a>
                                
                                ') : '';
                            ?>
                            <a class="btn" href="<?php echo base_url() . 'invoice/copy/' . $invoices_Record[$i]['id'] ?>"><i class="fa fa-copy pull-left"></i>
                                Copy</a>
                        </div>
                    </div>
                    <a class="btn btn-info mr-1 mr-sm-14 my-1" href="<?php echo base_url() . 'invoice/show/' . $invoices_Record[$i]['id'] ?>"><i class="fa fa-eye pull-left"></i>

                        Show </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-sm-9 col-xs-12">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b>
                        <?= $invoices_Record[$i]['customer_name'] ?>
                    </b>
                </div>
                <!-- <div class="col-lg-12 col-sm-12 col-xs-12">
                    </b>
                </div> -->
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b> Jenis : <?= $invoices_Record[$i]['nama_jenis_invoice'] ?> </b>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b> No Surat # <?= $invoices_Record[$i]['no_invoice'] ?> </b>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b> No Invoice # <?= $invoices_Record[$i]['no_invoice_2'] ?> </b>
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b> Tanggal Tagihan : </b><?= $invoices_Record[$i]['date'] ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <b>Deskripsi : </b> <?php echo $invoices_Record[$i]['description']; ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">

                    <b> Metode Pembayaran: </b>
                    <?php
                    if ($invoices_Record[$i]['payment_metode'] != 99) {
                        echo $invoices_Record[$i]['bank_name'] . ' ' . $invoices_Record[$i]['bank_number'];
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
                    <?= $invoices_Record[$i]['status'] == 'paid' ? $st_paid : $st_unpaid ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12 ">
                    <b> Agen : </b><?= $invoices_Record[$i]['acc_0'] ?>
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
                        foreach ($invoices_Record[$i]['item'] as $item) {
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
                            <th style="width:50%">Subtotal (<?php echo $total; ?>):</th>
                            <td class="text-right">
                                <?php echo number_format($total, '2', ',', '.'); ?>
                            </td>
                        </tr>

                        <th style="width:50%">PPN 11%

                        <td class="text-right">
                            <?php if ($invoices_Record[$i]['ppn_pph'] == '1') {
                                $total_final = $total + ceil(($total * 0.10));
                                echo number_format(ceil($total * 0.10), '2', ',', '.');
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
                            <td class="text-right">
                                <?php echo number_format($total_final, '2', ',', '.'); ?>
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
    $('#menu_id_6').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_13').addClass('menu-item-active')

    $('#export_btn').on('click', () => {
        d1 = $('#date1').val();
        d2 = $('#date2').val();
        srcs = $('#search').val();
        console.log('s')
        return $.ajax({
            url: '<?= base_url('invoice/export') ?>',
            method: 'POST',
            data: {
                date1: d1,
                date2: d2,
                search: srcs
            }
        })
    })
</script>
<?php
// print "<pre>";
// print_r($invoices_Record);
?>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->