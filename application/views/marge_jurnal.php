<section class="content">
    <div class="box" id="print-section">
        <div class="box-body ">
            <div class="">
                <?php
                $attributes = array('id' => 'journal_voucher', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open('statements/marge_jurnal_process', $attributes); ?>
                <div class="">
                    <div class="row no-print invoice">
                        <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i>
                            Marge Jurnal Transaksi
                        </h4>
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>No Jurnal</label>
                                        <div class="row">
                                            <div class="col-md-10" id='layer_cars'>
                                                <input type="text" class="form-control input-lg" name="no_jurnal[]">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary" id="addmarge"> <i class="fa fa-plus-circle"></i> </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <?php
                                $data = array('class' => 'btn btn-info  margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'id' => 'btn_save_transaction', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Process ');
                                echo form_button($data);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>

<script>
    no_jurnal = $('#no_jurnal');
    description = $('#description');
    date_jurnal = $('#date');
    acc_1 = $('#acc_1');
    acc_2 = $('#acc_2');
    acc_3 = $('#acc_3');
    var sub_keterangan = document.getElementsByName('sub_keterangan[]');
    var account_head = document.getElementsByName('account_head[]');
    var debitamount = document.getElementsByName('debitamount[]');
    var creditamount = document.getElementsByName('creditamount[]');


    // sub_keterangan = $('.sub_keterangan');
    // sub_keterangan[1].val('2');
    // console.log(sub_keterangan)
    // sub_keterangan[0].val('s');
    id_custmer = $('#customer_id');
    id_cars = $('#id_cars');
    layer_cars = $('#layer_cars');

    $('#addmarge').on('click', function() {
        add_cars()
    })

    function add_cars() {
        layer_cars.append(`     <input type="text" class="form-control input-lg" name="no_jurnal[]"> `)
    }
</script>
<?php $this->load->view('bootstrap_model.php'); ?>