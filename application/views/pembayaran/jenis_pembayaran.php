 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="col-md-12">
             <div class="pull pull-right">

                 <!-- Button trigger modal-->
                 <!-- <button type="button" class="btn btn-primary" id="add_new_data_btn" data-toggle="modal" data-target="#exampleModalLong">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Buat Akun
                 </button> -->

                 <!-- Modal-->

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
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Tambah Payment </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Nama Pembayaran</th>
                                     <th>Akun saat Lunas</th>
                                     <th>Akun saat Hutang</th>
                                     <th>Akun saat Lebih Bayar</th>
                                     <th>Aksi</th>
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
                     <h5 class="modal-title" id="exampleModalLabel">Form Payment / Jasa</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                 </div>
                 <div class="modal-body">
                     <!-- <div class="row"> -->
                     <div class="form-group col-lg-6">
                         <input name="id" id="id" type="hidden" />
                         <?php
                            echo form_label('Nama Jenis Pembayaran :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'jenis_pembayaran', 'id' => 'jenis_pembayaran', 'placeholder' => 'e.g Timah', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>


                     <div class="row">
                         <div class="col-sm-12">
                             <h4>Case Lunas</h4>
                         </div>
                         <div class="form-group col-sm-3">
                             <label>Posisi</label>
                             <select name="ac_paid_type" id='ac_paid_type' class="form-control input-lg">
                                 <option value="0">Debit</option>
                                 <option value="1">Kredit</option>
                             </select>

                         </div>
                         <div class="form-group col-sm-9">
                             <label> Akun Lunas </label>
                             <select name="ac_paid" id='ac_paid' class="form-control select2 input-lg">
                                 <?php
                                    foreach ($accounts as $lv1) {
                                        // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                        foreach ($lv1['children'] as $lv2) {
                                            echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                            foreach ($lv2['children'] as $lv3) {
                                                if (empty($lv3['children'])) {
                                                    echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                    echo '</option>';
                                                } else {
                                                    echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                                                    foreach ($lv3['children'] as $lv4) {
                                                        echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                                        echo '</option>';
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                            echo '</optgroup>';
                                        }
                                        // echo '</optgroup>';
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="col-sm-12">
                             <hr>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-sm-12">
                             <h4>Case Hutang</h4>
                         </div>
                         <div class="form-group col-sm-3">
                             <label>Posisi</label>
                             <select name="ac_unpaid_type" id='ac_unpaid_type' class="form-control input-lg">
                                 <option value="0">Debit</option>
                                 <option value="1">Kredit</option>
                             </select>

                         </div>

                         <div class="form-group col-sm-9">
                             <label> Akun Hutang </label>
                             <select name="ac_unpaid" id='ac_unpaid' class="form-control select2 input-lg">
                                 <?php
                                    foreach ($accounts as $lv1) {
                                        // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                        foreach ($lv1['children'] as $lv2) {
                                            echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                            foreach ($lv2['children'] as $lv3) {
                                                if (empty($lv3['children'])) {
                                                    echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                    echo '</option>';
                                                } else {
                                                    echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                                                    foreach ($lv3['children'] as $lv4) {
                                                        echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                                        echo '</option>';
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                            echo '</optgroup>';
                                        }
                                        // echo '</optgroup>';
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="col-sm-12">
                             <hr>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-sm-12">
                             <h4>Case Piutang</h4>
                         </div>
                         <div class="form-group col-sm-3">
                             <label>Posisi</label>
                             <select name="ac_piutang_type" id='ac_piutang_type' class="form-control input-lg">
                                 <option value="0">Debit</option>
                                 <option value="1">Kredit</option>
                             </select>

                         </div>

                         <div class="form-group col-sm-9">
                             <label> Akun Piutang </label>
                             <select name="ac_piutang" id='ac_piutang' class="form-control select2 input-lg">
                                 <?php
                                    foreach ($accounts as $lv1) {
                                        // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                        foreach ($lv1['children'] as $lv2) {
                                            echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                            foreach ($lv2['children'] as $lv3) {
                                                if (empty($lv3['children'])) {
                                                    echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                    echo '</option>';
                                                } else {
                                                    echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                                                    foreach ($lv3['children'] as $lv4) {
                                                        echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                                        echo '</option>';
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                            echo '</optgroup>';
                                        }
                                        // echo '</optgroup>';
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="col-sm-12">
                             <hr>
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
     //  $('#menu_id_<?= $vcrud['parent_id'] ?>').addClass('menu-item-active menu-item-open menu-item-here"')
     //  $('#submenu_id_<?= $vcrud['id_menulist'] ?>').addClass('menu-item-active')
     $(document).ready(function() {
         var dataPayments = [];
         //  var vcrud = <?= json_encode($vcrud) ?>;
         var add_new_data_btn = $('#add_new_data_btn');
         //  vcrud['hk_create'] == 0 ? add_new_data_btn.prop('hidden', true) : add_new_data_btn.prop('hidden', false);
         var PaymentModal = {
             'self': $('#accounts_modal'),
             'info': $('#accounts_modal').find('.info'),
             'form': $('#accounts_modal').find('#accounts_form'),
             'addBtn': $('#accounts_modal').find('#add_btn'),
             'saveEditBtn': $('#accounts_modal').find('#save_edit_btn'),
             'id': $('#accounts_modal').find('#id'),
             'jenis_pembayaran': $('#accounts_modal').find('#jenis_pembayaran'),
             'ac_unpaid': $('#accounts_modal').find('#ac_unpaid'),
             'ac_unpaid_type': $('#accounts_modal').find('#ac_unpaid_type'),
             'ac_paid_type': $('#accounts_modal').find('#ac_paid_type'),
             'ac_paid': $('#accounts_modal').find('#ac_paid'),
             'ac_piutang_type': $('#accounts_modal').find('#ac_piutang_type'),
             'ac_piutang': $('#accounts_modal').find('#ac_piutang'),
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


         add_new_data_btn.on('click', (e) => {
             PaymentModal.form.trigger('reset');
             PaymentModal.self.modal('show');
             PaymentModal.addBtn.show();
             PaymentModal.saveEditBtn.hide();
         });

         var FDataTable = $('#FDataTable').DataTable({
             'columnDefs': [],
             deferRender: true,
             "order": [
                 [0, "desc"]
             ]
         });

         //  getAllUnit()

         //  function getAllUnit() {
         //      swal.showLoading();
         //      return $.ajax({
         //          url: `<?php echo base_url('General/getAllUnit?by_id=true') ?>`,
         //          'type': 'GET',
         //          data: {},
         //          success: function(data) {
         //              var json = JSON.parse(data);
         //              if (json['error']) {
         //                  return;
         //              }
         //              data = json['data'];
         //              renderUnit(data);
         //          },
         //          error: function(e) {}
         //      });
         //  }


         //  function renderUnit(data) {
         //      Object.values(data).forEach((d) => {
         //          PaymentModal.ac_paid_type.append($('<option>', {
         //              value: d['id_unit'],
         //              text: d['name_unit']
         //          }))
         //      });
         //  }


         function getAllPayment() {
             swal.fire({
                 title: 'Loading Payment...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('General/getAllJenisPembayaran?by_id=true') ?>`,
                 'type': 'GET',
                 data: {},
                 success: function(data) {
                     swal.close();
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     dataPayments = json['data'];
                     renderPayments(dataPayments);
                 },
                 error: function(e) {}
             });
         }


         function renderPayments(data) {
             if (data == null || typeof data != "object") {
                 return;
             }
             var i = 0;

             var renderData = [];
             Object.values(data).forEach((d) => {
                 var editButton = `
                 <button type="button" class="edit btn btn-primary  btn-icon" data-id='${d['id']}' title="Edit"><i class='la la-pencil-alt'></i></button>
                 `;
                 var deleteButton = `
                 <button  type="button" class="delete btn btn-warning btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                 `;
                 //  var button = `    ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;
                 var button = `    ${ editButton + deleteButton} `;


                 renderData.push([d['id'], d['jenis_pembayaran'], d['name_paid'], d['name_unpaid'], d['name_piutang'], button]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
         }

         FDataTable.on('click', '.edit', function() {
             PaymentModal.form.trigger('reset');
             PaymentModal.self.modal('show');
             PaymentModal.addBtn.hide();
             PaymentModal.saveEditBtn.show();
             var currentData = dataPayments[$(this).data('id')];
             PaymentModal.id.val(currentData['id']);
             PaymentModal.jenis_pembayaran.val(currentData['jenis_pembayaran']);
             PaymentModal.ac_unpaid_type.val(currentData['ac_unpaid_type']).change();
             PaymentModal.ac_paid_type.val(currentData['ac_paid_type']).change();
             PaymentModal.ac_unpaid.val(currentData['ac_unpaid']).change();
             PaymentModal.ac_piutang_type.val(currentData['ac_piutang_type']).change();
             PaymentModal.ac_piutang.val(currentData['ac_piutang']).change();
         })


         FDataTable.on('click', '.delete', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalDeleteConfigure).then((result) => {
                 if (result.dismiss === "cancel") {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('payment/deletePayment') ?>",
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
                         delete dataPayments[d['id']];
                         swal.fire("Simpan Berhasil", "", "success");
                         renderPayments(dataPayments);
                         PaymentModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });

         })

         PaymentModal.form.submit(function(event) {
             event.preventDefault();
             var isAdd = PaymentModal.addBtn.is(':visible');
             var url = "<?= site_url('pembayaran/') ?>";
             url += isAdd ? "addPayment" : "editJenisPembayaran";
             var button = isAdd ? PaymentModal.addBtn : PaymentModal.saveEditBtn;

             Swal.fire(swalSaveConfigure).then((result) => {
                 if (result.dismiss === "cancel") {
                     return;
                 }
                 swal.fire({
                     title: 'Loading Payment...',
                     allowOutsideClick: false
                 });
                 swal.showLoading();
                 $.ajax({
                     url: url,
                     'type': 'POST',
                     data: new FormData(PaymentModal.form[0]),
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
                         dataPayments[d['id']] = d;
                         swal.fire(swalSuccessConfigure);
                         renderPayments(dataPayments);
                         PaymentModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });
         });
         getAllPayment()
     });
 </script>