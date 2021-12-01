<?php
$company = $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0];
?>
<table style="font-size: 17px;width: 100%" border="1">
    <tr>
        <td style="width: 50%" class=" align-items-center">
            <a href="#" class="mb-5 max-w-200px">
                <img alt="Logo" style="max-width : 100% " src="<?= base_url() . 'assets/img/' . $company['logo'] ?>">
            </a> <!-- <img style="heigt: 100px; width : 80%" src="<?= base_url() . 'assets/img/' . $company['logo'] ?>" alt="" class="center"><br> -->
            <span><?= $company['town'] . ', ' . $company['address']; ?>
            </span>
        </td>
        <td style="width: 50%">
            <h3 style="text-align:center">INVOICE</h3>
        </td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td>
            <img alt="Logo" style="max-width : 100% " src="<?= base_url() . 'assets/img/' . $company['logo'] ?>">
        </td>
        <td>
    </tr>
</table>
<div class="card card-custom card-shadowless">
    <div class="card-body p-0">
        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <div class="d-flex flex-column px-0 order-2 order-md-1 align-items-center align-items-md-start">
                        <!--begin::Logo-->
                        <a href="#" class="mb-5 max-w-200px">
                            <img alt="Logo" style="max-width : 100% " src="<?= base_url() . 'assets/img/' . $company['logo'] ?>">
                        </a>
                        <!--end::Logo-->
                        <span class="d-flex flex-column font-size-h5 font-weight-bold text-muted align-items-center align-items-md-start">
                            <span><?= $company['title1']; ?>
                            </span>
                            <span><?= $company['town'] . ', ' . $company['address']; ?>
                            </span>
                    </div>
                    <h1 class="display-3 font-weight-boldest order-1 order-md-2 mb-5 mb-md-0">INVOICE</h1>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--end::Invoice header-->
<!--begin::Invoice Body-->
<div class="position-relative">
    <!--begin::Background Rows-->
    <div class="bgi-size-cover bgi-position-center bgi-no-repeat h-65px" style="background-image: url(<?= base_url() ?>assets/metronic/media/svg/shapes/abstract-7.svg);"></div>
    <div class="bg-white h-65px"></div>
    <div class="bg-light h-65px"></div>
    <div class="bg-white h-65px"></div>
    <div class="bg-light h-65px"></div>
    <!--end::Background Rows-->
    <!--begin:Table-->
    <div class="container position-absolute top-0 left-0 right-0">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="font-weight-boldest text-white h-65px">
                                <td class="align-middle font-size-h4 pl-0 border-0">NAMA ITEM</td>
                                <td class="align-middle font-size-h4 text-right border-0">PRICE</td>
                                <td class="align-middle font-size-h4 text-right border-0">QYT</td>
                                <td class="align-middle font-size-h4 text-right pr-0 border-0">TAX</td>
                                <td class="align-middle font-size-h4 text-right pr-0 border-0">TOTAL</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tax_stat = false;
                            foreach ($transaction['children'] as $chil) {
                                if (!empty($child['tax'])) $tax_stat = true;
                            ?>
                                <tr class="font-size-lg font-weight-bolder h-65px">
                                    <td class="align-middle pl-0 border-0"><?= $chil['product_name'] ?></td>
                                    <td class="align-middle text-right border-0">Rp <?= number_format($chil['price'], 2, ',', '.') ?></td>
                                    <td class="align-middle text-right border-0"><?= $chil['qyt'] . ' ' . $chil['name_unit'] ?></td>
                                    <td class="align-middle text-right border-0">Rp <?= number_format($chil['tax'], 2, ',', '.') ?></td>
                                    <td class="align-middle text-right text-danger font-weight-boldest font-size-h5 pr-0 border-0">Rp <?= number_format($chil['price'] * $chil['qyt'], 2, ',', '.') ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end:Table-->
    <!--begin::Total-->
    <div class="container">
        <div class="row justify-content-center pt-0 pb-20">
            <div class="col-md-9">
                <div class="rounded d-flex align-items-center text-white justify-content-between max-w-425px position-relative ml-auto px-7 py-5 bgi-no-repeat bgi-size-cover bgi-position-center" style="background-image: url(<?= base_url() ?>assets/metronic/media/svg/shapes/abstract-9.svg);">
                    <div class="font-weight-boldest font-size-h5">GRAND TOTAL</div>
                    <div class="text-right d-flex flex-column">
                        <span class="font-weight-boldest font-size-h3 line-height-sm">Rp <?= number_format($transaction['total_gross'] + $transaction['total_tax'], 2, ',', '.') ?></span>
                        <span class="font-size-sm">Taxes included</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Total-->
</div>
<!--end::Invoice Body-->
<!--begin::Invoice Footer-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex flex-column flex-md-row">
                        <div class="d-flex flex-column">
                            <?php if (!empty($transaction['bankname'])) {
                            ?>
                                <div class="font-weight-bold font-size-h6 mb-3">BANK TRANSFER</div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Nama Bank:</span>
                                    <span class="text-right"><?= $transaction['bankname'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Nama Rekening:</span>
                                    <span class="text-right"><?= $transaction['bank_title'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Nomor Rekening:</span>
                                    <span class="text-right"><?= $transaction['bank_number'] ?></span>
                                </div>
                            <?php } else { ?>
                                <div class="font-weight-bold font-size-h6 mb-3">PEMBAYARAN CASH</div>
                            <?php   } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-7 mt-md-0">
                    <!--begin::Invoice To-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3 text-right">INVOICE TO.</div>
                    <div class="font-size-lg font-weight-bold mb-10 text-right"><?= $transaction['customer_name'] ?>.
                        <br><?= $transaction['cus_address'] ?>.
                    </div>
                    <!--end::Invoice To-->
                    <!--begin::Invoice No-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3 text-right">INVOICE NO.</div>
                    <div class="font-size-lg font-weight-bold mb-10 text-right"><?= str_pad($transaction['id_parent'], 6, '0', STR_PAD_LEFT) ?>
                    </div>
                    <!--end::Invoice No-->
                    <!--begin::Invoice Date-->
                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3 text-right">DATE</div>
                    <div class="font-size-lg font-weight-bold text-right">12 May, 2020</div>
                    <!--end::Invoice Date-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Invoice Footer-->
<!-- begin: Invoice action-->
<div class="container">
    <div class="row justify-content-center py-8 px-8 py-md-28 px-md-0">
        <div class="col-md-9">
            <div class="d-flex font-size-sm flex-wrap">
                <button type="button" class="btn btn-danger font-weight-bolder py-4 mr-3 mr-sm-14 my-1 px-7" onclick="window.print();">Print Invoice</button>
                <!-- <button type="button" class="btn btn-primary font-weight-bolder ml-sm-auto my-1 px-7">Create Invoice</button> -->
            </div>
        </div>
    </div>
</div>
<!-- end: Invoice action-->
<!--end::Invoice-->
</div>
</div>