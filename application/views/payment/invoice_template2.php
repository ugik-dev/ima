<?php $company = $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]; ?>
<div class="card card-custom" id="printableArea">
    <div class="card-body p-0">
        <!-- begin: Invoice-->
        <!-- begin: Invoice header-->
        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <!--begin::Logo-->
                        <a href="#" class="mb-5 max-w-300px">
                            <img alt="Logo" style="max-width : 100% " src="<?= base_url() . 'assets/img/' . $company['logo'] ?>">
                        </a>
                        <!--end::Logo-->
                        <span class="d-flex flex-column align-items-md-end ">
                            <!-- <span><?= $company['title1']; ?>
                        </span> -->
                            <span><?= $company['town'] . ', ' . $company['address']; ?>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="border-bottom w-100"></div>
                <div class="d-flex justify-content-between pt-6">
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">DATE.</span>
                        <span class=""><?= $transaction['date_1'] ?></span>
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                        <span class=""><?= str_pad($transaction['id_parent'], 6, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">INVOICE TO.</span>
                        <span class=""><?= $transaction['customer_name'] ?>
                            <br><?= $transaction['cus_address'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Invoice header-->
        <!-- begin: Invoice body-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="pl-0 font-weight-bold  text-uppercase">Description</th>
                                <th class="text-right font-weight-bold  text-uppercase">Price</th>
                                <th class="text-right font-weight-bold  text-uppercase">QYT</th>
                                <th class="text-right pr-0 font-weight-bold  text-uppercase">TAX</th>
                                <th class="text-right pr-0 font-weight-bold  text-uppercase">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tax_stat = false;
                            foreach ($transaction['children'] as $chil) {
                                if (!empty($child['tax'])) $tax_stat = true;
                            ?>
                                <tr class="font-weight-boldest">
                                    <td class="text-left pl-0 pt-7"><?= $chil['product_name'] ?></td>
                                    <td class="text-right pt-7">Rp <?= number_format($chil['price'], 2, ',', '.') ?></td>
                                    <td class="text-center pt-7"><?= $chil['qyt'] . ' ' . $chil['name_unit'] ?></td>
                                    <td class="text-right pt-7">Rp <?= number_format($chil['tax'], 2, ',', '.') ?></td>
                                    <td class="text-danger pr-0 pt-7 text-right">Rp <?= number_format($chil['price'] * $chil['qyt'], 2, ',', '.') ?></td>
                                </tr>
                            <?php } ?>

                            <tr class="pt-0 pb-0 mt-0 mb-0" style="height: 0px;">
                                <td class=" pt-0 pb-0 mt-0 mb-0" colspan="5" style="height: 0px;">
                                    <hr>
                                    <hr>
                                </td>
                            </tr>
                            <tr class="font-weight-boldest">
                                <td class="text-left pl-0 pt-7"></td>
                                <td class="text-right pt-7"></td>
                                <td class="text-center pt-7"></td>
                                <td class="text-right pt-7">Rp <?= number_format($transaction['total_tax'], 2, ',', '.') ?></td>
                                <td class="text-danger pr-0 pt-7 text-right">Rp <?= number_format($transaction['total_gross'], 2, ',', '.') ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- end: Invoice body-->
        <!-- begin: Invoice footer-->
        <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="table-responsive">
                    <?php if (!empty($transaction['bankname'])) {
                    ?>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold  text-uppercase">BANK</th>
                                    <th class="font-weight-bold  text-uppercase">REK NAME.</th>
                                    <th class="font-weight-bold  text-uppercase">REK NUMBER</th>
                                    <th class="font-weight-bold  text-uppercase">TOTAL AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-weight-bolder">
                                    <td><?= $transaction['bankname'] ?></td>
                                    <td><?= $transaction['bank_title'] ?></td>
                                    <td><?= $transaction['bank_number'] ?></td>
                                    <td class="text-danger font-size-h3 font-weight-boldest">Rp <?= number_format($transaction['total_gross'] + $transaction['total_tax'], 2, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-uppercase">CASH METHOD PAYMENT</th>
                                    <th class="font-weight-bold  text-uppercase"></th>
                                    <th class="font-weight-bold  text-uppercase"></th>
                                    <th class="font-weight-bold text-uppercase">TOTAL AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-weight-bolder">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-danger font-size-h3 font-weight-boldest">Rp <?= number_format($transaction['total_gross'] + $transaction['total_tax'], 2, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- end: Invoice footer-->
        <!-- begin: Invoice action-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0 no-print">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <!-- <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button> -->
                    <button type="button" class="btn btn-primary font-weight-bold" onclick="printDiv('printableArea');">Print Invoice</button>
                </div>
            </div>
        </div>
        <!-- end: Invoice action-->
        <!-- end: Invoice-->
    </div>
</div>
<script>
    $('#menu_id_<?= $vcrud['parent_id'] ?>').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_<?= $vcrud['id_menulist'] ?>').addClass('menu-item-active')
</script>