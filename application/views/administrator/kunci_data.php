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
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Data </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>Tahun</th>
                                     <th>ACTION</th>
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

 <script>
     $('#menu_id_25').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_74').addClass('menu-item-active')
     $(document).ready(function() {
         var dataUsers = [];
         var swalSaveConfigure = {
             title: "Konfirmasi simpan",
             text: "Yakin akan menyimpan data ini?",
             icon: "info",
             showCancelButton: true,
             confirmButtonColor: "#18a689",
             confirmButtonText: "Ya, Simpan!",
             reverseButtons: true
         };

         var swalUnlockConfigure = {
             title: "Konfirmasi Buka Data",
             text: "Yakin akan membuka data ini?",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Ya, Buka!",
         };


         var swalLockConfigure = {
             title: "Konfirmasi Kunci Data",
             text: "Yakin akan mengunci data ini?",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Ya, Kunci Data!",
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
         var FDataTable = $('#FDataTable').DataTable({
             'columnDefs': [],
             deferRender: true,
             "order": [
                 [0, "desc"]
             ]
         });
         getKunciData()

         function getKunciData() {
             swal.fire({
                 title: 'Loading...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Administrator/getKunciData') ?>`,
                 'type': 'GET',
                 data: {},
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
                 if (d['gen_lock'] == 'Y')
                     var button = `
                 <button type="button" class="lock btn btn-danger" data-year='${d['year']}' data-genlock='N'  title=""><i class='la la-unlock'></i> Buka Data</button>
                 `;
                 else
                     var button = `
                 <button  type="button" class="lock btn btn-warning" data-year='${d['year']}' data-genlock='Y'  title=""><i class='la la-lock'></i> Kunci Data</button>
                 `;
                 //  var button = `    ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;


                 renderData.push([d['year'], button]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
         }
         FDataTable.on('click', '.lock', function() {
             //  var currentData = $(this).data('id');
             var year = $(this).data('year');
             var gen_lock = $(this).data('genlock');
             Swal.fire(gen_lock == 'N' ? swalUnlockConfigure : swalLockConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('Administrator/set_genlock') ?>",
                     'type': 'get',
                     data: {
                         'year': year,
                         'gen_lock': gen_lock
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
                         location.reload();
                         //  renderUsers(dataUsers);
                         //  UserModal.self.modal('hide');
                     },
                     error: function(e) {}
                 });
             });

         })

     });
 </script>