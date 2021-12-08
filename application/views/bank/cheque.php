 <div class="card card-custom" id="print-section">
     <div class="card-body">
         <div class="col-md-12">
             <div class="pull pull-right">
                 <button type="button" class="btn btn-primary" id="add_new_data_btn" data-toggle="modal" data-target="#exampleModalLong">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Buat CEK Baru
                 </button>
                 <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
             </div>
         </div>
     </div>
 </div>
 <div class="card card-custom">
     <div class="card-body">
         <div class="col-xs-12">
             <div class="box" id="print-section">
                 <div class="box-header">
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Daftar Cek </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>Tanggal</th>
                                     <th>Nama Bank</th>
                                     <th>Diterima oleh</th>
                                     <th>Jumlah</th>
                                     <th>No Ref</th>
                                     <th>Status</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade" id="accounts_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <form opd="form" id="accounts_form" onsubmit="return false;" type="multipart" autocomplete="off">
                 <div class="modal-header">
                     <h5 class="modal-title">Form Deposito / Setoran Bank</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                 </div>
                 <div class="modal-body">
                     <span hidden class="pull-right bank-balance">Saldo Tersedia: <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency']; ?> <span id="available_balance">0</span> </span>
                     <div class="row">
                         <div class="form-group col-lg-12">
                             <label><i class="fa fa-check-circle"></i> Bank</label>
                             <select onchange="" name="bank_id" id="bank_id" class="form-control select2 "> </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-6">
                             <label><i class="fa fa-check-circle"></i> Akun</label>
                             <select name="account_to" id='account_to' class="form-control select2 ">
                                 <option>---</option>
                                 <?php
                                    foreach ($accounts as $lv1) {
                                        echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                        foreach ($lv1['children'] as $lv2) {
                                            echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                            foreach ($lv2['children'] as $lv3) {
                                                echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                echo '</option>';
                                            }
                                            echo '</optgroup>';
                                        }
                                        echo '</optgroup>';
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-6">
                             <label><i class="fa fa-check-circle"></i> Diterima dari</label>
                             <select onchange="" name="payee_id" id="payee_id" class="form-control select2 ">
                                 <option>---</option>
                                 <?php
                                    foreach ($payee as $pa) {
                                        echo '<option value="' . $pa['id'] . '">' . $pa['customer_name'] . ' :: .' . $pa['cus_town']  . '</option>';
                                    }
                                    ?>
                             </select>
                         </div>
                     </div>
                     <div class="row">

                         <div class="form-group col-lg-6">
                             <input name="id" id="id" class="hidden" hidden />
                             <label><i class="fa fa-check-circle"></i> Tanggal</label>
                             <?php

                                $data = array('class' => 'form-control input-lg', 'type' => 'date', 'name' => 'date', 'id' => 'date', 'reqiured' => '', 'value' => Date('Y-m-d'));
                                echo form_input($data);
                                ?>
                         </div>
                         <div class="form-group col-lg-6">
                             <?php echo form_label(''); ?>
                             <label><i class="fa fa-check-circle"></i> Nomor Cek</label>
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
                                $data = array('class' => 'form-control  mask', 'type' => 'text', 'name' => 'amount', 'id' => 'amount', 'placeholder' => 'e.g 4.400,00');
                                echo form_input($data);
                                ?>
                         </div>
                         <div class="form-group col-lg-6">
                             <label><i class="fa fa-check-circle"></i> Transaksi</label>
                             <?php
                                $data = array('class' => 'form-control  ', 'type' => 'text', 'name' => 'naration', 'id' => 'naration', 'reqiured' => '', 'placeholder' => 'e.g Pembayaran ke supplier.');
                                echo form_input($data);
                                ?>

                         </div>

                     </div>
                     <!-- </div> -->

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                     <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Add Data</strong></button>
                     <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Save Change</strong></button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <script>
     $('#menu_id_<?= $vcrud['parent_id'] ?>').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_<?= $vcrud['id_menulist'] ?>').addClass('menu-item-active')
     $(document).ready(function() {
         var dataBanks = [];
         var dataDeposito = [];
         var vcrud = <?= json_encode($vcrud) ?>;
         console.log(vcrud)
         var add_new_data_btn = $('#add_new_data_btn');
         vcrud['hk_create'] == 0 ? add_new_data_btn.prop('hidden', true) : add_new_data_btn.prop('hidden', false);
         var DepositoModal = {
             'self': $('#accounts_modal'),
             'info': $('#accounts_modal').find('.info'),
             'form': $('#accounts_modal').find('#accounts_form'),
             'addBtn': $('#accounts_modal').find('#add_btn'),
             'saveEditBtn': $('#accounts_modal').find('#save_edit_btn'),
             'id': $('#accounts_modal').find('#id'),
             'bank_id': $('#accounts_modal').find('#bank_id'),
             'payee_id': $('#accounts_modal').find('#payee_id'),
             'ref_no': $('#accounts_modal').find('#ref_no'),
             'account_to': $('#accounts_modal').find('#account_to'),
             'amount': $('#accounts_modal').find('#amount'),
             'naration': $('#accounts_modal').find('#naration'),
             'date': $('#accounts_modal').find('#date'),
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

         var swalDeleteConfigure = {
             title: "Konfirmasi hapus",
             text: "Yakin akan menghapus data ini?",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Ya, Hapus!",
         };

         var swalBatalSetor = {
             title: "Konfirmasi batal posting!",
             text: "Yakin membatalkan postingan? \n Data jurnal akan ikut terhapus!",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Ya, Batalkan setor!",
         };

         var swalSuccessConfigure = {
             title: "Simpan berhasil",
             icon: "success",
             timer: 500
         };

         var swalSuccessConfigure = {
             title: "Simpan berhasil",
             icon: "success",
             timer: 500
         };


         function FormReset() {
             //  DepositoModal.head_number.mask('0.00.000', {});
         }
         //   DepositoModal.self.mod   al('show');
         add_new_data_btn.on('click', (e) => {
             DepositoModal.form.trigger('reset');
             DepositoModal.self.modal('show');
             DepositoModal.addBtn.show();
             DepositoModal.saveEditBtn.hide();
         });
         var FDataTable = $('#FDataTable').DataTable({
             'columnDefs': [],
             deferRender: true,
             "order": [
                 [0, "desc"]
             ]
         });

         $.when(getBank()).then((e) => {}).fail((e) => {
             console.log(e)
         });

         function getBank() {
             swal.fire({
                 title: 'Loading Data...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Bank/getBank?by_id=true') ?>`,
                 'type': 'GET',
                 data: {},
                 success: function(data) {
                     swal.close();
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     dataBanks = json['data'];
                     rendeBank(dataBanks);
                 },
                 error: function(e) {}
             });
         }

         function rendeBank(data) {
             DepositoModal.bank_id.empty();
             DepositoModal.bank_id.append($('<option>', {
                 value: "",
                 text: "---"
             }));
             Object.values(data).forEach((d) => {
                 DepositoModal.bank_id.append($('<option>', {
                     value: d['id'],
                     text: d['bankname'] + ' :: ' + d['accountno'],
                 }));
             });
             DepositoModal.bank_id.select2();
         }

         function getAllDeposito() {
             swal.fire({
                 title: 'Loading Data...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Bank/getBankTransaction?by_id=true&transaction_type=paid') ?>`,
                 'type': 'GET',
                 data: {},
                 success: function(data) {
                     swal.close();
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     dataDeposito = json['data'];
                     renderDeposito(dataDeposito);
                 },
                 error: function(e) {}
             });
         }


         function renderDeposito(data) {
             if (data == null || typeof data != "object") {
                 return;
             }
             var i = 0;

             var renderData = [];
             Object.values(data).forEach((d) => {
                 var setorButton = `
                 <div class="dropdown mb-1">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Jadikan
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item setorkan" onclick="setorkan(${d['id']})">Sudah Posting</a>
                    </div>
                </div>
                 `;

                 var editButton = `
                 <button type="button" class="edit btn btn-primary  btn-icon" data-id='${d['id']}' title="Edit"><i class='la la-pencil-alt'></i></button>
                 `;
                 var deleteButton = `
                 <button  type="button" class="delete btn btn-warning btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                 `;
                 if (d['transaction_status'] == 0) {

                     var button = `  ${vcrud['hk_create'] == 1 ? setorButton : ''}  ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;
                 } else {
                     var button = `
                        <button class="btn btn-warning batal_setor" data-id="${d['id']}">Batal Posting</button>
                `;
                 }


                 renderData.push([d['date'], d['bankname'], d['customer_name'], d['amount'], d['ref_no'], (d['transaction_status'] == 0 ? 'Belum Posting' : 'Sudah Posting'), button]);
             });

             FDataTable.clear().rows.add(renderData).draw('full-hold');


         }



         FDataTable.on('click', '.edit', function() {
             DepositoModal.form.trigger('reset');
             DepositoModal.self.modal('show');
             DepositoModal.addBtn.hide();
             DepositoModal.saveEditBtn.show();
             var currentData = dataDeposito[$(this).data('id')];
             console.log(currentData)
             DepositoModal.id.val(currentData['id']);
             DepositoModal.bank_id.val(currentData['bank_id']).change();
             DepositoModal.payee_id.val(currentData['payee_id']).change();
             DepositoModal.account_to.val(currentData['account_to']).change();
             DepositoModal.ref_no.val(currentData['ref_no']);
             DepositoModal.amount.val(currentData['amount']);
             DepositoModal.naration.val(currentData['naration']);
             DepositoModal.date.val(currentData['date']);

         })
         FDataTable.on('click', '.dropdown .dropdown-menu .setorkan', function() {
             console.log('set')

         });
         FDataTable.on('click', '.delete', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalDeleteConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('bank/deleteCheque') ?>",
                     'type': 'get',
                     data: {
                         'id': currentData
                     },

                     success: function(data) {
                         var json = JSON.parse(data);
                         if (json['error']) {
                             swal("Simpan Gagal", json['message'], "error");
                             return;
                         }
                         //  return;
                         //  var d = json['data']
                         //  delete dataBanks[d['id']];
                         //  swal.fire("Simpan Berhasil", "", "success");
                         //  renderBanks(dataBanks);
                         DepositoModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });
         })

         FDataTable.on('click', '.batal_setor', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalBatalSetor).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('bank/unpaid') ?>",
                     'type': 'get',
                     data: {
                         'id': currentData
                     },

                     success: function(data) {
                         var json = JSON.parse(data);
                         if (json['error']) {
                             swal("Simpan Gagal", json['message'], "error");
                             return;
                         }
                         //  return;
                         var d = json['data']
                         dataDeposito[currentData] = d[currentData];
                         swal.fire("Berhasil Dibatalkan", "", "success");
                         renderDeposito(dataDeposito);
                     },
                     error: function(e) {}
                 });
             });
         })

         DepositoModal.form.submit(function(event) {
             event.preventDefault();
             var isAdd = DepositoModal.addBtn.is(':visible');
             var url = "<?= site_url('bank/') ?>";
             url += isAdd ? "addCheque" : "editCheque";
             var button = isAdd ? DepositoModal.addBtn : DepositoModal.saveEditBtn;

             Swal.fire(swalSaveConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: url,
                     'type': 'POST',
                     data: new FormData(DepositoModal.form[0]),
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
                         dataDeposito[d['id']] = d;
                         swal.fire(swalSuccessConfigure);
                         renderDeposito(dataDeposito);
                         DepositoModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });
         });
         getAllDeposito();
         $('.mask').mask('000.000.000.000.000,00', {
             reverse: true
         });
     });



     function setorkan(id) {
         console.log('s')
         Swal.fire({
             title: "Konfirmasi Posting",
             text: "Ubah status menjadi Sudah Posting?",
             icon: "info",
             showCancelButton: true,
             confirmButtonColor: "#18a689",
             confirmButtonText: "Ya!",
             reverseButtons: true
         }).then((result) => {
             if (result.isConfirmed == false) {
                 return;
             }
             $.ajax({
                 url: "<?= base_url('bank/paid') ?>",
                 'type': 'get',
                 data: {
                     'id': id
                 },

                 success: function(data) {
                     var json = JSON.parse(data);
                     if (json['error']) {
                         swal("Simpan Gagal", json['message'], "error");
                         return;
                     }
                     //  return;
                     var d = json['data']
                     //  delete dataBanks[d['id']];
                     swal.fire("Simpan Berhasil", "", "success");

                     location.reload();
                 },
                 error: function(e) {}
             });
         });

     }
 </script>
 <!-- Bootstrap model  -->
 <?php
    //  $this->load->view('bootstrap_model.php'); 
    ?>
 <!-- Bootstrap model  ends-->