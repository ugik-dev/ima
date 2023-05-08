<div class="card card-custom">
    <div class="card-body">
        <div class="box-body ">
            <div class="">
                <?php
                $attributes = array('id' => 'journal_voucher', 'method' => 'post', 'class' => '');
                ?>
                <?php echo form_open('', $attributes); ?>
                <div class="">
                    <div class="row no-print invoice">
                        <h4 class=""> <i class="fa fa-check-circle"></i>
                            Entri Jurnal Transaksi
                        </h4>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo form_label('Patner'); ?>
                                        <select name="customer_id" id="customer_id" class="form-control select2 input-lg">
                                            <option value="0"> ------- </option>
                                            <?php echo $patner_record; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" id='label_kendaraan' style="display: none">
                                        <label>Kendaraan</label>
                                        <div class="row">
                                            <div class="col-lg-10" id='layer_cars'>
                                            </div>
                                            <div class="col-lg-2">
                                                <button type="button" style="display:none" class="btn btn-primary" id="addcars"> <i class="fa fa-plus-circle"></i> </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo form_label('No Jurnal');
                                        $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'no_jurnal', 'id' => 'no_jurnal');
                                        echo form_input($data);
                                        $data = array('class' => 'hidden', 'type' => 'hidden', 'name' => 'url', 'id' => 'url', 'value' => '');
                                        echo form_input($data);
                                        // if (!empty($data_return['notif_id'])) {
                                        //     $data = array('class' => 'hidden', 'type' => 'hidden', 'name' => 'notif_id', 'id' => 'notif_id', 'value' => $data_return['notif_id']);
                                        //     echo form_input($data);
                                        // }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo form_label('Tanggal');
                                        $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'id' => 'date', 'reqiured' => '', 'value' => Date('Y-m-d'));
                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Rincian Transaksi');
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'description', 'id' => 'description', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="row invoice">
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-striped table-hover  ">
                                <thead>
                                    <tr>
                                        <th class="col-lg-2">Akun</th>
                                        <th class="">Debit</th>
                                        <th class="">Kredit</th>
                                        <!-- <th class="">Keterangan</th> -->
                                    </tr>
                                </thead>
                                <tbody id="transaction_table_body">
                                    <tr>
                                        <td>
                                            <select name="account_head[]" class="form-control select2 input-lg">
                                                <?php echo $accounts_records; ?>
                                            </select>
                                        </td>
                                        <!-- <td>
                                        </td> -->
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg mask', 'name' => 'debitamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_debit_credit()');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = array('class' => 'form-control input-lg mask',  'name' => 'creditamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_debit_credit()');
                                            echo form_input($data);
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <?php
                                            $data = array('class' => 'form-control input-lg', 'placeholder' => 'keterangan', 'type' => 'text', 'name' => 'sub_keterangan[]', 'id' => 'sub_keterangan[]', 'value' => '');
                                            echo form_input($data);
                                            ?>
                                        </td>
                                    </tr>

                                    <?php if ($data_return != NULL) {
                                        $count_rows = count($data_return['account_head']);
                                        for ($i = 0; $i < $count_rows - 1; $i++) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <select name="account_head[]" class="form-control select2 input-lg">
                                                        <?php echo $accounts_records; ?>
                                                    </select>
                                                </td>
                                                <!-- <td>
                                        </td> -->
                                                <td>
                                                    <?php
                                                    $data = array('class' => 'form-control input-lg mask', 'name' => 'debitamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_debit_credit()');
                                                    echo form_input($data);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $data = array('class' => 'form-control input-lg mask',  'name' => 'creditamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_debit_credit()');
                                                    echo form_input($data);
                                                    ?>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <?php
                                                    $data = array('class' => 'form-control input-lg sub_keterangan', 'type' => 'text', 'placeholder' => 'keterangan', 'name' => 'sub_keterangan[]', 'id' => 'sub_keterangan[]', 'value' => '');
                                                    echo form_input($data);
                                                    ?>
                                                </td>
                                            </tr>

                                    <?php }
                                    }  ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1">
                                            <button type="button" class="btn btn-primary" name="addline" onclick="add_new_row('<?php echo base_url() . 'statements/popup/new_row'; ?>')"> <i class="fa fa-plus-circle"></i> Tambah Baris </button>
                                        </td>
                                        <td id="row_loading_status"></td>
                                    </tr>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th>Total: </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'total_debit_amount', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>
                                        </th>
                                        <th>
                                            <?php
                                            $data = array('name' => 'total_credit_amount',  'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
                                            echo form_input($data);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="transaction_validity" id="transaction_validity">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Disetujui</label>
                                        <select name="acc_1" id="acc_1" class="form-control select2 input-lg">
                                            <option value="0"> ----- </option>
                                            <option value="7"> SETIAWAN R </option>
                                            <option value="14"> RONY MALINO </option>
                                            <option value="15"> DUDY </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Diverifikasi</label>
                                        <select name="acc_2" id="acc_2" class="form-control select2 input-lg">
                                            <option value="0"> ----- </option>
                                            <option value="8"> PURWADI </option>
                                            <option value="10"> RAHMAT </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Dibuat</label>
                                        <select name="acc_3" id="acc_3" class="form-control select2 input-lg">
                                            <option value="0"> ----- </option>
                                            <option value="18"> EVA MAHDALENA </option>
                                            <option value="9"> A SISWANTO </option>
                                            <option value="12"> DEFRYANTO </option>
                                            <option value="11"> NURHASANAH </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group" id='label_kendaraan'>
                                        <label>Dibukukan</label>
                                        <input type="text" disabled id="dibukukan" class="form-control input-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="draft_value" name="draft_value">

                        <div class="col-lg-12 ">
                            <div class="form-group">
                                <?php
                                // $data = array('class' => 'btn btn-info  margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'id' => 'btn_save_transaction', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                // Simpan ');
                                // echo form_button($data);
                                ?>
                                <a class="btn btn-info margin btn-lg pull-right mr-1" id="btn_save_fix"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan </a>
                                <a class="btn btn-warning margin btn-lg pull-right mr-1" id="btn_draft"><i class="fa fa-floppy-o" aria-hidden="true"></i> Draft </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/dist/js/backend/journal_voucher.js?v=2.4"></script>
<script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script>
    $('#menu_id_23').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_64').addClass('menu-item-active')
    btn_save = $('#btn_save_fix');
    draft_value = $('#draft_value');
    form_journal_voucher = $('#journal_voucher');
    btn_draft = $('#btn_draft');
    no_jurnal = $('#no_jurnal');
    url_jour = $('#url');
    description = $('#description');
    date_jurnal = $('#date');
    acc_1 = $('#acc_1');
    acc_2 = $('#acc_2');
    acc_3 = $('#acc_3');
    var sub_keterangan = document.getElementsByName('sub_keterangan[]');
    var account_head = document.getElementsByName('account_head[]');
    var debitamount = document.getElementsByName('debitamount[]');
    var creditamount = document.getElementsByName('creditamount[]');

    btn_draft.on('click', (ev) => {
        draft_value.val(true)
        form_journal_voucher.submit();
    })

    btn_save.on('click', (ev) => {
        draft_value.val(false)
        form_journal_voucher.submit();
    })


    form_journal_voucher.submit(function(event) {
        event.preventDefault();
        // var isAdd = UserModal.addBtn.is(':visible');
        var url = "<?= base_url('statements/create_journal_voucher') ?>";
        // url += isAdd ? "addUser" : "editUser";
        // var button = isAdd ? UserModal.addBtn : UserModal.saveEditBtn;
        Swal.fire({
            title: 'Please Wait !',
            html: 'Data Uploading .. ', // add html attribute if you want or remove
            showConfirmButton: false,
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajax({
            url: url,
            'type': 'POST',
            data: form_journal_voucher.serialize(),
            success: function(data) {
                // buttonIdle(button);
                var json = JSON.parse(data);
                if (json['error']) {
                    // 
                    Swal.fire({
                        text: json['message'],
                        icon: "error",
                        buttonsStyling: true,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary",
                        },
                    })
                    // swal("Simpan Gagal", json['message'], "error");
                    return;
                }
                var res_data = json['data']
                Swal.fire({
                    text: json['message'],
                    icon: "success",
                    buttonsStyling: true,
                    confirmButtonText: "Ok!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                })
                if (res_data['draft'] == 'true') {
                    location.replace("<?= base_url('statements/show/') ?>" + res_data['id'] + '/draft')
                } else {
                    location.replace("<?= base_url('statements/show/') ?>" + res_data['id'])
                }
                // dataUser[user['id_user']] = user;
                // swal("Simpan Berhasil", "", "success");
                // renderUser(dataUser);
                // UserModal.self.modal('hide');
            },
            error: function(e) {}
        });
    });


    id_custmer = $('#customer_id');
    id_cars = $('#id_cars');
    layer_cars = $('#layer_cars');
    id_custmer.on('change', function() {
        $.ajax({
            url: '<?= base_url() ?>Statements/getListCars',
            type: "get",
            data: {
                id_patner: id_custmer.val()
            },
            success: function(data) {
                var json = JSON.parse(data);
                if (json['error'] == true) {
                    layer_cars.html('');
                    addcars.style.display = 'none';
                    document.getElementById("label_kendaraan").style.display = "none";

                    return;
                }
                data_cars = json['data'];
                add_cars();
                document.getElementById("label_kendaraan").style.display = "block";
                addcars.style.display = 'block';
            },
            error: function(e) {}
        });
    });


    $('#addcars').on('click', function() {
        add_cars()
    })

    function add_cars() {
        layer_cars.append(`<select name="id_cars[]" id="id_cars" class="form-control select2 input-lg">                                          
                                 <option value="0"> ------- </option>` + data_cars + `</select>`)
        $('.select2').select2();
    }

    <?php if ($data_return != NULL) {    ?>
        no_jurnal.val('<?= $data_return['no_jurnal'] ?>');
        id_custmer.val('<?= $data_return['customer_id'] ?>');
        date_jurnal.val('<?= $data_return['date'] ?>');
        description.val('<?= $data_return['description'] ?>');
        <?php if (!empty($data_return['url'])) echo "url_jour.val('" . $data_return['url'] . "');" ?>
        acc_1.val('<?= $data_return['acc'][1] ?>');
        acc_2.val('<?= $data_return['acc'][2] ?>');
        acc_3.val('<?= $data_return['acc'][3] ?>');
        <?php
        $count_rows = count($data_return['account_head']);

        for ($i = 0; $i < $count_rows; $i++) { ?>
            sub_keterangan[<?= $i ?>].value = '<?= $data_return['sub_keterangan'][$i] ?>';
            account_head[<?= $i ?>].value = '<?= $data_return['account_head'][$i] ?>';
            debitamount[<?= $i ?>].value = '<?= $data_return['debitamount'][$i] ?>';
            creditamount[<?= $i ?>].value = '<?= $data_return['creditamount'][$i] ?>';

    <?php
        }
    }  ?>

    $('.mask').mask('000.000.000.000.000,00', {
        reverse: true
    });

    count_debit_credit(true);
</script>
<?php $this->load->view('bootstrap_model.php'); ?>