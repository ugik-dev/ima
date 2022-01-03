 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="col-md-12">
             <div class="pull pull-right">

                 <!-- Button trigger modal-->
                 <button type="button" class="btn btn-primary" id="add_new_data_btn" data-toggle="modal" data-target="#exampleModalLong">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Buat Pengguna Baru
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
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Daftar Pengguna </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>Nama</th>
                                     <th>Jabatan</th>
                                     <th>Email</th>
                                     <th>Alamat</th>
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
 <div class="modal fade" id="user_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Form Pengguna</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                         <?php
                            echo form_label('Nama:');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'agentname', 'id' => 'agentname', 'placeholder' => '', 'reqiured' => '');
                            echo form_input($data);
                            $data = array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'placeholder' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Jabatan :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'title_user', 'id' => 'title_user',  'placeholder' => 'e.g Diretur / ka Akuntansi', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <?php
                            echo form_label('Email :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'user_email', 'id' => 'user_email',  'placeholder' => '', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>

                     <div class="form-group">
                         <?php
                            echo form_label('Alamat :');
                            $data = array('class' => 'form-control input-lg', 'type' => 'text', 'id' => 'user_address', 'name' => 'user_address', 'placeholder' => '', 'reqiured' => '');
                            echo form_input($data);
                            ?>
                     </div>
                     <div class="form-group">
                         <label for="status">Status :</label>
                         <select class="form-control" name="status" id="status">
                             <option value="0">Active</option>
                             <option value="1">Non Active</option>
                         </select>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Password</label>
                                 <input type="password" id="password" name="password" class="form-control">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Re-Password</label>
                                 <input type="password" id="repassword" name="repassword" class="form-control">
                             </div>
                         </div>
                         <small>
                             <span>*kosongkan jika tidak berubah</span>
                         </small>
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
         var dataUsers = [];
         var vcrud = <?= json_encode($vcrud) ?>;
         var add_new_data_btn = $('#add_new_data_btn');
         vcrud['hk_create'] == 0 ? add_new_data_btn.prop('hidden', true) : add_new_data_btn.prop('hidden', false);
         var UserModal = {
             'self': $('#user_modal'),
             'info': $('#user_modal').find('.info'),
             'form': $('#user_modal').find('#user_form'),
             'addBtn': $('#user_modal').find('#add_btn'),
             'saveEditBtn': $('#user_modal').find('#save_edit_btn'),
             'id': $('#user_modal').find('#id'),
             'agentname': $('#user_modal').find('#agentname'),
             'title_user': $('#user_modal').find('#title_user'),
             'user_email': $('#user_modal').find('#user_email'),
             'password': $('#user_modal').find('#password'),
             'repassword': $('#user_modal').find('#repassword'),
             'user_address': $('#user_modal').find('#user_address'),
             'status': $('#user_modal').find('#status'),
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


         function FormReset() {
             //  UserModal.head_number.mask('0.00.000', {});
         }
         //   UserModal.self.mod   al('show');
         add_new_data_btn.on('click', (e) => {
             UserModal.form.trigger('reset');
             UserModal.self.modal('show');
             UserModal.addBtn.show();
             UserModal.saveEditBtn.hide();
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
                 title: 'Loading Users...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Administrator/getAllUsers') ?>`,
                 'type': 'GET',
                 data: {
                     'by_id': true
                 },
                 success: function(data) {
                     swal.close();
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     dataUsers = json['data'];
                     renderUsers(dataUsers);
                 },
                 error: function(e) {}
             });
         }


         function renderUsers(data) {
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
                 var button = `    ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;


                 renderData.push([d['agentname'], d['title_user'], d['user_email'], d['user_address'], d['status'] == 0 ? 'Active' : 'Non Active', button]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
         }

         FDataTable.on('click', '.edit', function() {
             UserModal.form.trigger('reset');
             UserModal.self.modal('show');
             UserModal.addBtn.hide();
             UserModal.saveEditBtn.show();
             var currentData = dataUsers[$(this).data('id')];
             UserModal.id.val(currentData['id']);
             UserModal.agentname.val(currentData['agentname']);
             UserModal.title_user.val(currentData['title_user']);
             UserModal.user_email.val(currentData['user_email']);
             UserModal.user_address.val(currentData['user_address']);
             UserModal.status.val(currentData['status']);

         })

         FDataTable.on('click', '.delete', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalDeleteConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('admnistrator/deleteUsers') ?>",
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
                         delete dataUsers[d['id']];
                         swal.fire("Simpan Berhasil", "", "success");
                         renderUsers(dataUsers);
                         UserModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });

         })

         UserModal.form.submit(function(event) {
             event.preventDefault();
             var isAdd = UserModal.addBtn.is(':visible');
             var url = "<?= site_url('administrator/') ?>";
             url += isAdd ? "addUser" : "editUser";
             var button = isAdd ? UserModal.addBtn : UserModal.saveEditBtn;

             Swal.fire(swalSaveConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: url,
                     'type': 'POST',
                     data: new FormData(UserModal.form[0]),
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
                         dataUsers[d['id']] = d;
                         swal.fire(swalSuccessConfigure);
                         renderUsers(dataUsers);
                         UserModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });
         });
         getAllBaganAkun()
     });
 </script>