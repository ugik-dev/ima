 <div class="card card-custom">
     <div class="card-body">
         <div class="col-md-12">
             <div class="pull pull-right">
                 <a type="" class="btn btn-primary mr-2" href="<?= base_url() ?>expense/">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Expense
                 </a>
                 <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
             </div>
         </div>
     </div>
 </div>
 <div class="card card-custom">
     <div class="card-body">
         <div class="col-xs-12" id="print-section">
             <div class="box" id="">
                 <div class="box-header">
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Daftar Expense </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>Tanggal</th>
                                     <th>Nama Expense</th>
                                     <th>Metode</th>
                                     <th>Jumlah</th>
                                     <th>No Ref</th>
                                     <th>Penerima</th>
                                     <th class="no-print">Action</th>
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
     $('#menu_id_27').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_92').addClass('menu-item-active')
     $(document).ready(function() {
         var dataExpenses = [];
         var dataDeposito = [];
         var vcrud = {
             'hk_create': '1',
             'hk_update': '1',
             'hk_delete': '1',
         };
         console.log(vcrud)
         var add_new_data_btn = $('#add_new_data_btn');
         vcrud['hk_create'] == 0 ? add_new_data_btn.prop('hidden', true) : add_new_data_btn.prop('hidden', false);


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



         var FDataTable = $('#FDataTable').DataTable({
             "columnDefs": [{
                 className: "no-print",
                 "targets": [6]
             }],
             deferRender: true,
             "order": [
                 [0, "desc"]
             ]
         });

         $.when(getExpense()).then((e) => {}).fail((e) => {
             console.log(e)
         });

         function getExpense() {
             swal.fire({
                 title: 'Loading Data...',
                 allowOutsideClick: false
             });
             swal.showLoading();
             return $.ajax({
                 url: `<?php echo base_url('Expense/getExpense?by_id=true') ?>`,
                 'type': 'GET',
                 data: {},
                 success: function(data) {
                     swal.close();
                     var json = JSON.parse(data);
                     if (json['error']) {
                         return;
                     }
                     dataExpenses = json['data'];
                     rendeExpense(dataExpenses);
                 },
                 error: function(e) {}
             });
         }



         function rendeExpense(data) {
             if (data == null || typeof data != "object") {
                 return;
             }
             var i = 0;

             var renderData = [];
             Object.values(data).forEach((d) => {
                 var viewButton = `
                 <a type="button" class="edit btn btn-primary  btn-icon" href='<?= base_url() ?>expense/show/${d['id']}' title="Edit"><i class='la la-eye'></i></a>
                 `;
                 var editButton = `
                 <a type="button" class="edit btn btn-primary  btn-icon" href='<?= base_url() ?>expense/edit/${d['id']}' title="Edit"><i class='la la-pencil-alt'></i></a>
                 `;
                 var deleteButton = `
                 <button  type="button" class="delete btn btn-warning btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                 `;

                 var button = ` ${vcrud['view'] == 1 ? viewButton : ''}   ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;


                 renderData.push([d['date'], d['head_name'], d['payment_name'], formatRupiah2(d['total_paid']), d['ref_no'], d['customer_name'], button]);
             });

             FDataTable.clear().rows.add(renderData).draw('full-hold');


         }

         function formatRupiah2(angka, prefix) {
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
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: `<?= base_url('expense/delete') ?>/${currentData}`,
                     'type': 'post',
                     data: {},

                     success: function(data) {
                         var json = JSON.parse(data);
                         if (json['error']) {
                             swal("Simpan Gagal", json['message'], "error");
                             return;
                         }
                         //  return;
                         //  var d = json['data']
                         delete dataExpenses[currentData];
                         swal.fire("Delete Berhasil", "", "success");
                         rendeExpense(dataExpenses);
                     },
                     error: function(e) {}
                 });
             });
         })
     });
 </script>
 <!-- Bootstrap model  -->
 <?php
    //  $this->load->view('bootstrap_model.php'); 
    ?>
 <!-- Bootstrap model  ends-->