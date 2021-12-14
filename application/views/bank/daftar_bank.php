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
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Tambah Bank </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>Nama Bank</th>
                                     <th>Cabang</th>
                                     <th>Akun</th>
                                     <th>Nomor Rekening</th>
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
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form opd="form" id="accounts_form" onsubmit="return false;" type="multipart" autocomplete="off">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                         <?php
                            echo form_label('Nama Bank:');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'bankname', 'id' => 'bankname', 'placeholder' => 'e.g Standard chartered', 'reqiured' => '');
                            echo form_input($data);
                            $data = array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'placeholder' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Nama Cabang :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'branch', 'id' => 'branch',  'placeholder' => 'e.g Standard Chartered Bank Hill Park Branch', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Kode Cabang :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'branchcode', 'id' => 'branchcode',  'placeholder' => 'e.g 0051', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Nama di Label  :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'title', 'id' => 'title', 'placeholder' => 'e.g Gigabyte Ltd', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Nomor Akun :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'id' => 'accountno', 'name' => 'accountno', 'placeholder' => 'e.g 02051305326', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Jenis Akun :');
                            ?>
                         <select name="relation_head" id='relation_head' class="form-control select2 input-lg">
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
     $('#menu_id_18').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_31').addClass('menu-item-active')
     $(document).ready(function() {
         var dataBanks = [];
         //  var vcrud = <?= json_encode($vcrud) ?>;
         var add_new_data_btn = $('#add_new_data_btn');
         //  vcrud['hk_create'] == 0 ? add_new_data_btn.prop('hidden', true) : add_new_data_btn.prop('hidden', false);
         var BankModal = {
             'self': $('#accounts_modal'),
             'info': $('#accounts_modal').find('.info'),
             'form': $('#accounts_modal').find('#accounts_form'),
             'addBtn': $('#accounts_modal').find('#add_btn'),
             'saveEditBtn': $('#accounts_modal').find('#save_edit_btn'),
             'id': $('#accounts_modal').find('#id'),
             'relation_head': $('#accounts_modal').find('#relation_head'),
             'bankname': $('#accounts_modal').find('#bankname'),
             'branch': $('#accounts_modal').find('#branch'),
             'branchcode': $('#accounts_modal').find('#branchcode'),
             'title': $('#accounts_modal').find('#title'),
             'accountno': $('#accounts_modal').find('#accountno'),
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


         var swalDeleteConfigure = {
             title: "Konfirmasi hapus",
             text: "Yakin akan menghapus data ini?",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Ya, Hapus!",
         };



         function FormReset() {
             //  BankModal.head_number.mask('0.00.000', {});
         }
         //   BankModal.self.mod   al('show');
         add_new_data_btn.on('click', (e) => {
             BankModal.form.trigger('reset');
             BankModal.self.modal('show');
             BankModal.addBtn.show();
             BankModal.saveEditBtn.hide();
         });
         var FDataTable = $('#FDataTable').DataTable({
             'columnDefs': [],
             deferRender: true,
             "order": [
                 [0, "desc"]
             ]
         });

         function getAllBaganAkun() {
             swal.fire({
                 title: 'Loading Bank...',
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
                     renderBanks(dataBanks);
                 },
                 error: function(e) {}
             });
         }


         function renderBanks(data) {
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
                 var button = `    ${editButton }  ${deleteButton }`;


                 renderData.push([d['bankname'], d['branch'], d['akun_name'], d['accountno'], button]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
         }

         FDataTable.on('click', '.edit', function() {
             BankModal.form.trigger('reset');
             BankModal.self.modal('show');
             BankModal.addBtn.hide();
             BankModal.saveEditBtn.show();
             var currentData = dataBanks[$(this).data('id')];
             BankModal.id.val(currentData['id']);
             BankModal.relation_head.val(currentData['relation_head']).change();
             BankModal.bankname.val(currentData['bankname']);
             BankModal.branch.val(currentData['branch']);
             BankModal.branchcode.val(currentData['branchcode']);
             BankModal.title.val(currentData['title']);
             BankModal.accountno.val(currentData['accountno']);

         })

         FDataTable.on('click', '.delete', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalDeleteConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('bank/deleteBank') ?>",
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
                         delete dataBanks[d['id']];
                         swal.fire("Simpan Berhasil", "", "success");
                         renderBanks(dataBanks);
                         BankModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });

         })

         BankModal.form.submit(function(event) {
             event.preventDefault();
             var isAdd = BankModal.addBtn.is(':visible');
             var url = "<?= site_url('bank/') ?>";
             url += isAdd ? "addBank" : "editBank";
             var button = isAdd ? BankModal.addBtn : BankModal.saveEditBtn;

             Swal.fire(swalSaveConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: url,
                     'type': 'POST',
                     data: new FormData(BankModal.form[0]),
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
                         dataBanks[d['id']] = d;
                         swal.fire(swalSuccessConfigure);
                         renderBanks(dataBanks);
                         BankModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });
         });
         getAllBaganAkun()
     });
 </script>
 <!-- Bootstrap model  -->
 <?php
    //  $this->load->view('bootstrap_model.php'); 
    ?>
 <!-- Bootstrap model  ends-->