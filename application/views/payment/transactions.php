 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="col-md-12">
             <div class="pull pull-right">
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
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Riwayat Transaksi </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Tanggal</th>
                                     <th>Total NET</th>
                                     <th>Nama Customer</th>
                                     <th>Status</th>
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
 <!-- <div class="modal fade" id="accounts_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <form opd="form" id="accounts_form" onsubmit="return false;" type="multipart" autocomplete="off">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Form Product / Jasa</h5>
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
 </div> -->
 <script>
     $('#menu_id_<?= $vcrud['parent_id'] ?>').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_<?= $vcrud['id_menulist'] ?>').addClass('menu-item-active')
     $(document).ready(function() {
         var dataProducts = [];
         var vcrud = <?= json_encode($vcrud) ?>;
         var add_new_data_btn = $('#add_new_data_btn');
         vcrud['hk_create'] == 0 ? add_new_data_btn.prop('hidden', true) : add_new_data_btn.prop('hidden', false);
         //  var ProductModal = {
         //      'self': $('#accounts_modal'),
         //      'info': $('#accounts_modal').find('.info'),
         //      'form': $('#accounts_modal').find('#accounts_form'),
         //      'addBtn': $('#accounts_modal').find('#add_btn'),
         //      'saveEditBtn': $('#accounts_modal').find('#save_edit_btn'),
         //      'id': $('#accounts_modal').find('#id'),
         //      'type': $('#accounts_modal').find('#type'),
         //      'product_name': $('#accounts_modal').find('#product_name'),
         //      'default_price': $('#accounts_modal').find('#default_price'),
         //      'default_unit': $('#accounts_modal').find('#default_unit'),
         //      'tax': $('#accounts_modal').find('#tax'),
         //      'revenue_account': $('#accounts_modal').find('#revenue_account'),
         //  }

         //  ProductModal.default_price.mask('000.000.000.000.000,00', {
         //      reverse: true
         //  });

         //  var swalSaveConfigure = {
         //      title: "Konfirmasi simpan",
         //      text: "Yakin akan menyimpan data ini?",
         //      icon: "info",
         //      showCancelButton: true,
         //      confirmButtonColor: "#18a689",
         //      confirmButtonText: "Ya, Simpan!",
         //      reverseButtons: true
         //  };

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


         //  add_new_data_btn.on('click', (e) => {
         //      ProductModal.form.trigger('reset');
         //      ProductModal.self.modal('show');
         //      ProductModal.addBtn.show();
         //      ProductModal.saveEditBtn.hide();
         //  });

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
         //          ProductModal.default_unit.append($('<option>', {
         //              value: d['id_unit'],
         //              text: d['name_unit']
         //          }))
         //      });
         //  }


         function getAllProduct() {
             swal.fire({
                 title: 'Loading Product...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Production/getAllTransactions?by_id=true') ?>`,
                 'type': 'GET',
                 data: {},
                 success: function(data) {
                     swal.close();
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     dataProducts = json['data'];
                     renderProducts(dataProducts);
                 },
                 error: function(e) {}
             });
         }


         function renderProducts(data) {
             if (data == null || typeof data != "object") {
                 return;
             }
             var i = 0;

             var renderData = [];
             Object.values(data).forEach((d) => {
                 var seeButton = `<a href="<?= base_url() ?>production/transaction/${d['id']}" class="edit btn btn-primary  btn-icon"> <i class='la la-eye'> </i> </a>`
                 var editButton = `
                 `;
                 var deleteButton = `
                 <button  type="button" class="delete btn btn-warning btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                 `;
                 var button = ` ${seeButton}  ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;


                 renderData.push([d['id'], d['date_1'], formatRupiah(parseFloat(d['total_gross']) + parseFloat(d['total_tax'])), d['customer_name'], status_paid(d['status']), button]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
         }

         function status_paid(a) {
             if (a == 'paid') {
                 return '<p class="alert alert-primary"> PAID </p>'
             } else {
                 return '<p class="alert alert-danger"> UNPAID </p>'

             }
         }

         //  FDataTable.on('click', '.edit', function() {
         //      ProductModal.form.trigger('reset');
         //      ProductModal.self.modal('show');
         //      ProductModal.addBtn.hide();
         //      ProductModal.saveEditBtn.show();
         //      var currentData = dataProducts[$(this).data('id')];
         //      ProductModal.id.val(currentData['id']);
         //      ProductModal.type.val(currentData['type']).change();
         //      ProductModal.product_name.val(currentData['product_name']);
         //      ProductModal.default_price.val(formatRupiah(currentData['default_price']));
         //      ProductModal.default_unit.val(currentData['default_unit']).change();
         //      ProductModal.tax.val(currentData['tax']);
         //      ProductModal.revenue_account.val(currentData['revenue_account']).change();
         //  })

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

             //  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
             return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
         }

         FDataTable.on('click', '.delete', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalDeleteConfigure).then((result) => {
                 if (result.dismiss === "cancel") {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('production/deleteProduct') ?>",
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
                         delete dataProducts[d['id']];
                         swal.fire("Simpan Berhasil", "", "success");
                         renderProducts(dataProducts);
                         ProductModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });

         })

         //  ProductModal.form.submit(function(event) {
         //      event.preventDefault();
         //      var isAdd = ProductModal.addBtn.is(':visible');
         //      var url = "<?= site_url('production/') ?>";
         //      url += isAdd ? "addProduct" : "editProduct";
         //      var button = isAdd ? ProductModal.addBtn : ProductModal.saveEditBtn;

         //      Swal.fire(swalSaveConfigure).then((result) => {
         //          if (result.dismiss === "cancel") {
         //              return;
         //          }
         //          $.ajax({
         //              url: url,
         //              'type': 'POST',
         //              data: new FormData(ProductModal.form[0]),
         //              contentType: false,
         //              processData: false,
         //              success: function(data) {
         //                  var json = JSON.parse(data);
         //                  if (json['error']) {
         //                      swal.fire("Simpan Gagal", json['message'], "error");
         //                      return;
         //                  }
         //                  //  return;
         //                  var d = json['data']
         //                  dataProducts[d['id']] = d;
         //                  swal.fire(swalSuccessConfigure);
         //                  renderProducts(dataProducts);
         //                  ProductModal.self.modal('hide');
         //              },
         //              error: function(e) {}
         //          });
         //      });
         //  });
         getAllProduct()
     });
 </script>