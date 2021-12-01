 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="col-md-12">
             <div class="pull pull-right">

                 <!-- Button trigger modal-->
                 <button type="button" class="btn btn-primary" id="add_new_data_btn" data-toggle="modal" data-target="#exampleModalLong">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Buat Akun
                     <!-- Launch demo modal -->
                 </button>

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
                                     <th>Nama Payment</th>
                                     <th>Harga Default</th>
                                     <th>Pajak</th>
                                     <th>Akun Pendapatan</th>
                                     <th>Status</th>
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
                     <div class="row">
                         <div class="form-group col-lg-6">
                             <input name="id" id="id" type="hidden" />
                             <?php
                                echo form_label('Nama :');
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'product_name', 'id' => 'product_name', 'placeholder' => 'e.g Timah', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                         </div>
                         <div class="form-group col-lg-6">
                             <?php
                                echo form_label('Harga Default :');
                                $data = array('class' => 'form-control input-lg mask', 'type' => 'text', 'name' => 'default_price', 'id' => 'default_price',  'placeholder' => 'e.g 1.500,00', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                         </div>
                         <div class="form-group col-lg-6">
                             <Label>Satuan Default</Label>
                             <select name="default_unit" id='default_unit' class="form-control select2 input-lg"></select>

                         </div>
                         <div class="form-group col-lg-6">
                             <?php
                                echo form_label('Pajak %  :');
                                $data = array('class' => 'form-control input-lg', 'type' => 'number', 'name' => 'tax', 'id' => 'tax', 'step' => '0.1', 'placeholder' => 'e.g 10,2 ', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                         </div>
                         <div class="form-group col-lg-6">
                             <label> Akun Pendapatan </label>
                             <select name="revenue_account" id='revenue_account' class="form-control select2 input-lg">
                                 <?php
                                    foreach ($revenue as $lv1) {
                                        // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                        foreach ($lv1['children'] as $lv2) {
                                            echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                                            foreach ($lv2['children'] as $lv3) {
                                                echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                                                echo '</option>';
                                            }
                                            echo '</optgroup>';
                                        }
                                        // echo '</optgroup>';
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-6">
                             <?php
                                echo form_label('Type :');
                                ?>
                             <select name="type" id='type' class="form-control select2 input-lg">
                                 <option value="1"> Barang </option>
                                 <option value="2"> Jasa </option>
                             </select>
                         </div>

                     </div>
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
             'type': $('#accounts_modal').find('#type'),
             'product_name': $('#accounts_modal').find('#product_name'),
             'default_price': $('#accounts_modal').find('#default_price'),
             'default_unit': $('#accounts_modal').find('#default_unit'),
             'tax': $('#accounts_modal').find('#tax'),
             'revenue_account': $('#accounts_modal').find('#revenue_account'),
         }

         PaymentModal.default_price.mask('000.000.000.000.000,00', {
             reverse: true
         });

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

         getAllUnit()

         function getAllUnit() {
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('General/getAllUnit?by_id=true') ?>`,
                 'type': 'GET',
                 data: {},
                 success: function(data) {
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     data = json['data'];
                     renderUnit(data);
                 },
                 error: function(e) {}
             });
         }


         function renderUnit(data) {
             Object.values(data).forEach((d) => {
                 PaymentModal.default_unit.append($('<option>', {
                     value: d['id_unit'],
                     text: d['name_unit']
                 }))
             });
         }


         function getAllPayment() {
             swal.fire({
                 title: 'Loading Payment...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Payment/getAllPayment?by_id=true') ?>`,
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


                 renderData.push([d['product_name'], formatRupiah(d['default_price']), d['tax'], d['head_name'], button]);
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
             PaymentModal.type.val(currentData['type']).change();
             PaymentModal.product_name.val(currentData['product_name']);
             PaymentModal.default_price.val(formatRupiah(currentData['default_price']));
             PaymentModal.default_unit.val(currentData['default_unit']).change();
             PaymentModal.tax.val(currentData['tax']);
             PaymentModal.revenue_account.val(currentData['revenue_account']).change();
         })

         function formatRupiah(angka, prefix) {
             var number_string = angka.toString();
             split = number_string.split(".");
             sisa = split[0].length % 3;
             rupiah = split[0].substr(0, sisa);
             ribuan = split[0].substr(sisa).match(/\d{3}/gi);
             if (ribuan) {
                 separator = sisa ? "." : "";
                 rupiah += separator + ribuan.join(".");
             }

             rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
             return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
         }

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
             var url = "<?= site_url('payment/') ?>";
             url += isAdd ? "addPayment" : "editPayment";
             var button = isAdd ? PaymentModal.addBtn : PaymentModal.saveEditBtn;

             Swal.fire(swalSaveConfigure).then((result) => {
                 if (result.dismiss === "cancel") {
                     return;
                 }
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