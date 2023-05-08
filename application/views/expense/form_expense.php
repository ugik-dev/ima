<div class="modal-content">
    <form opd="form" id="accounts_form" onsubmit="return false;" type="multipart" autocomplete="off">
        <div class="modal-header">
            <h5 class="modal-title">Form Expense</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-lg-8">
                    <input type="hidden" id="id" name="id">
                    <label><i class="fa fa-check-circle"></i> Nama </label>
                    <select onchange="" name="payee_id" id="payee_id" class="form-control select2 ">
                        <option value="NULL">---</option>
                        <?php
                        foreach ($payee as $pa) {
                            echo '<option value="' . $pa['id'] . '">' . $pa['customer_name'] . ' :: ' . $pa['cus_town']  . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Akun Beban</label>
                    <select name="head_id" id='head_id' class="form-control select2 " required>
                        <option>---</option>
                        <?php
                        foreach ($accounts as $lv1) {
                            foreach ($lv1['children'] as $lv2) {
                                echo '<optgroup label="[' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                foreach ($lv2['children'] as $lv3) {
                                    echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                    echo '</option>';
                                }
                                echo '</optgroup>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Metode Pembayaran </label>
                    <select onchange="" name="method" id="method" class="form-control select2 " required>
                        <!-- <option>---</option> -->
                        <?php
                        foreach ($payment_method as $pa) {
                            echo '<option value="' . $pa['ref_id'] . '">' . $pa['ref_text'] . ' :: Saldo ' . $pa['amount']  . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Tanggal</label>
                    <?php

                    $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'id' => 'date', 'reqiured' => '', 'value' => Date('Y-m-d'));
                    echo form_input($data);
                    ?>
                </div>
                <div class="form-group col-lg-6">
                    <?php echo form_label(''); ?>
                    <label><i class="fa fa-check-circle"></i> Nomor Bukti</label>
                    <?php
                    $data = array('class' => 'form-control ', 'type' => 'text', 'name' => 'ref_no', 'id' => 'ref_no', 'reqiured' => '');
                    echo form_input($data);
                    ?>
                </div>
            </div>


            <div class="row">
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Jumlah</label>
                    <?php
                    $data = array('class' => 'form-control  mask', 'type' => 'text', 'name' => 'amount', 'id' => 'amount', 'required' => 'required');
                    echo form_input($data);
                    ?>
                </div>
                <div class="form-group col-lg-6">
                    <label><i class="fa fa-check-circle"></i> Rincian Transaksi</label>
                    <?php
                    $data = array('class' => 'form-control  ', 'type' => 'text', 'name' => 'description', 'id' => 'description', 'reqiured' => '', 'placeholder' => 'e.g Pembayaran ke supplier.');
                    echo form_input($data);
                    ?>
                </div>
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

            <!-- </div> -->

        </div>
        <div class="modal-footer">
            <button class="btn btn-success my-1 mr-sm-2" type="submit" id="submit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
        </div>
    </form>
</div>

<script>
    $('#menu_id_27').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_29').addClass('menu-item-active')
    $(document).ready(function() {
        var dataExpenses = [];
        var dataDeposito = [];
        var FormModal = {
            'form': $('#accounts_form'),
            'submit_btn': $('#accounts_form').find('#submit_btn'),
            'id': $('#accounts_form').find('#id'),
            'bank_id': $('#accounts_form').find('#bank_id'),
            'payee_id': $('#accounts_form').find('#payee_id'),
            'method': $('#accounts_form').find('#method'),
            'head_id': $('#accounts_form').find('#head_id'),
            'total_paid': $('#accounts_form').find('#amount'),
            'description': $('#accounts_form').find('#description'),
            'ref_no': $('#accounts_form').find('#ref_no'),
            'date': $('#accounts_form').find('#date'),
            'acc_1': $('#accounts_form').find('#acc_1'),
            'acc_2': $('#accounts_form').find('#acc_2'),
            'acc_3': $('#accounts_form').find('#acc_3'),
            'dibukukan': $('#accounts_form').find('#dibukukan'),
        }
        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
            reverseButtons: true
        };


        var swalSuccessConfigure = {
            title: "Simpan berhasil",
            icon: "success",
            timer: 500
        };



        FormModal.form.submit(function(event) {
            event.preventDefault();
            Swal.fire(swalSaveConfigure).then((result) => {
                if (result.isConfirmed == false) {
                    return;
                }
                swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false
                });
                swal.showLoading();
                $.ajax({
                    url: "<?= site_url() . $form_url ?>",
                    'type': 'POST',
                    data: new FormData(FormModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        //  return;
                        var d = json['data']
                        // dataDeposito[d['id']] = d;
                        swal.fire(swalSuccessConfigure);
                        // renderDeposito(dataDeposito);
                        // FormModal.self.modal('hide');
                        window.location = '<?= base_url() ?>expense/show/' + d;

                    },
                    error: function(e) {}
                });
            });
        });

        $('.mask').mask('000.000.000.000.000,00', {
            reverse: true
        });

        <?php if (!empty($return)) { ?>
            FormModal.id.val('<?= $return['id'] ?>');
            FormModal.payee_id.val('<?= $return['payee_id'] ?>');
            FormModal.head_id.val('<?= $return['head_id'] ?>');
            FormModal.method.val('<?= $return['method'] ?>');
            FormModal.total_paid.val('<?= $return['total_paid'] ?>');
            FormModal.description.val('<?= $return['description'] ?>');
            FormModal.date.val('<?= $return['date'] ?>');
            FormModal.ref_no.val('<?= $return['ref_no'] ?>');
            FormModal.acc_1.val('<?= $return['acc_1'] ?>');
            FormModal.acc_2.val('<?= $return['acc_2'] ?>');
            FormModal.acc_3.val('<?= $return['acc_3'] ?>');
            FormModal.dibukukan.val('<?= $return['acc_0'] ?>');


        <?php } ?>
    });
</script>
<!-- Bootstrap model  -->
<?php
//  $this->load->view('bootstrap_model.php'); 
?>
<!-- Bootstrap model  ends-->