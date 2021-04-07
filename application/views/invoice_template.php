<div class="col-md-6 set-no-padding">
    <table class="table table-striped table-bordered table_height_set">
        <thead>
            <tr>
                <th>Item</th>
                <th>Weight</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
            $total_tax   = 0;
            $total_gross = 0;
            $single_tax  = 0;
            if ($temp_data != NULL) {
                // print "<pre>";
                // print_r($temp_data);
                foreach ($temp_data as $single_val) {
                    $sub_total_tax = $single_val->qty * $single_val->tax;
                    $total_tax = number_format($total_tax + $sub_total_tax, 2, '.', '');
                    $total_gross = number_format($total_gross + ($single_val->price * $single_val->qty), 2, '.', '');
            ?>
                    <tr>
                        <td><?php echo $single_val->product_name; ?></td>
                        <td><?php echo $single_val->mg . ' ' . $single_val->unit_type; ?></td>
                        <td>
                            <input type="number" onkeyup="amend_price(this.value,'<?php echo $single_val->id; ?>')" value="<?php echo $single_val->price; ?>" />

                        </td>
                        <td>
                            <input type="number" onkeyup="amend_qty(this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" value="<?php echo $single_val->qty; ?>" name="supply_qty" id="supply_qty">
                        </td>
                        <td>
                            <a onclick="delete_item('<?php echo $single_val->id; ?>')"><i class="fa fa-trash margin" aria-hidden='true'></i>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<div class="col-md-6">
    <div class="row total-grid-values">
        <div class="col-md-4 col-sm-12 col-xs-12">
            Total Gross (<?php echo $currency; ?>) :
            <input type="number" name="total_gross_amt" id="total_gross_amt" disabled="disabled" class=" amount-box  text-center outline-cls" value="<?php echo $total_gross; ?>" />
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            Total Pajak (<?php echo $currency; ?>):
            <input type="number" class=" amount-box text-right outline-cls" name="total_tax_amt" id="total_tax_amt" disabled="disabled" value="<?php echo $total_tax; ?>" />
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            Diskon (<?php echo $currency; ?>) :
            <input type="number" onkeyup="checkDiscount(this.value)" name="discountfield" id="discountfield" step=".01" class=" amount-box text-right" value="0" />
        </div>
    </div>
    <div class="row total-grid-values">
        <div class="col-md-4 privious_balance">
            Hutang Sebelumnya (<?php echo $currency; ?>):
            <input type="number" disabled="disabled" name="privious_balance" id="privious_balance" class="text-center" step=".01" value="0.00" /> <br>
            <small><a onclick="open_payment_model()" href="javascript:void(0)">Bayar Hutang sebelumnya</a></small>
        </div>
        <div class="col-md-4 total_amount_area">
            <div class="">
                <p> Grand Total (<?php echo $currency; ?>) </p>
                <h4 id="net_total_amount"> <?php echo number_format($total_tax + $total_gross, '2', '.', ''); ?>
                </h4>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            Tagihan yg dibayar (<?php echo $currency; ?>):
            <input type="number" name="bill_paid" id="bill_paid" class=" amount-box  text-center" value="<?php echo $total_tax + $total_gross; ?>" />
            <input type="hidden" name="total_bill" id="total_bill" value="<?php echo $total_tax + $total_gross; ?>" />
        </div>
    </div>
    <div class="row total_amount_area_row">
        <div class="col-md-4 col-sm-12 col-xs-12">
            Uang Diterima :
            <input type="number" onkeyup="amount_refund(this.value)" name="amount_recieved" id="amount_recieved" class=" amount-box  text-center" value="0" />
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12  ">
            Kembali :
            <span id="cash_given_to_customer">0</span>
        </div>
    </div>
    <div class="row row-buttons text-center">
        <button type="button" onclick="clear_invoice()" class="btn btn-primary btn-outline-primary btn-left-side-invoice">
            <i class="fa fa-paper-plane" aria-hidden="true"></i> INVOICE BARU
        </button>
        <a href="<?php echo base_url('return_items'); ?>" class="btn btn-warning btn-outline-primary btn-left-side-invoice">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> RETUR ITEM
        </a>
        <button type="submit" id="submit_btn" class="btn btn-danger btn-outline-primary btn-left-side-invoice">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN DAN CETAK
        </button>
        <!-- <img src="<?php echo base_url(); ?>/uploads/ban.jpg" width="700px" /> -->
    </div>
</div>
</div>
<script type="text/javascript">
    //USED TO DELETE AN ITEM FROM DATABASE TEMP TABLE
    function delete_item(item_id) {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('invoice/delete_item_temporary/'); ?>' + item_id,
            success: function(response) {
                jQuery('#inner_invoice_area').html(response);
                $('#barcode_scan_area').val('');

            }
        });

        $('#barcode_scan_area').focus();
    }

    var discounttimmer;
    //USED TO CALCUATE DISCOUNT AMOUT
    function checkDiscount(dis_amt) {

        clearTimeout(discounttimmer);
        discounttimmer = setTimeout(function callback() {
            var total_gross_amt = $('#total_gross_amt').val();
            var total_tax_amt = $('#total_tax_amt').val();
            if (dis_amt > 0) {
                var newamt = parseFloat(total_gross_amt - dis_amt) + parseFloat(total_tax_amt);
                $('#net_total_amount').html(newamt.toFixed(2));
                $('#bill_paid').val(newamt.toFixed(2));
                $('#total_bill').val(newamt.toFixed(2));
            } else {
                var pre_val = parseFloat(total_gross_amt) + parseFloat(total_tax_amt);
                $('#net_total_amount').html(pre_val.toFixed(2));
                $('#bill_paid').val(pre_val.toFixed(2));
                $('#total_bill').val(pre_val.toFixed(2));
            }
        }, 500)
    }

    //USED TO CALCULATE HOW MUCH AMOUNT SHOULD RETURN TO CUSTOMER
    function amount_refund(amt) {
        var netamt = $('#net_total_amount').html();

        var cash_given = amt - parseFloat(netamt);
        $('#cash_given_to_customer').html(cash_given.toFixed(2));
    }

    //USED TO OPEN CUSTOMER PAYMENT MODEL 
    function open_payment_model() {
        var cus_id = $('#customer_id').val();
        show_modal_page('<?php echo base_url('invoice/popup/add_customer_payment_pos_model/'); ?>' + cus_id)
    }
</script>