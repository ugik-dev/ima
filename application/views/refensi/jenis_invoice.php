 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="col-md-12">
             <div class="pull pull-right">

                 <!-- Button trigger modal-->
                 <button type="button" class="btn btn-primary" id="add_new_data_btn" data-toggle="modal" data-target="#exampleModalLong">
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Jenis
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
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Jenis Invoice </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Nama Invoice</th>
                                     <th>Akun Pendapatan</th>
                                     <th>Akun Piutang</th>
                                     <th>Akun PPN</th>
                                     <th>No Jurnal</th>
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
                     <h5 class="modal-title" id="exampleModalLabel">Form</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                 </div>
                 <div class="modal-body">
                     <!-- <div class="row"> -->
                     <div class="row">
                         <div class="form-group col-sm-6">
                             <input name="id" id="id" type="hidden" />
                             <?php
                                echo form_label('Nama Jenis :');
                                $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'jenis_invoice', 'id' => 'jenis_invoice', 'placeholder' => 'e.g Timah', 'reqiured' => '');
                                echo form_input($data);
                                ?>
                         </div>
                         <div class="col-lg-12">
                             <h4>Format Invoice</h4>
                             <div class="row">
                                 <div class="form-group col-sm-6">
                                     <label>Kepada Yth. </label>
                                     <input class="form-control" type="text" name="to_jabatan" id="to_jabatan" placeholder="e.g. Kepala Divisi Eksplorasi" />
                                 </div>
                                 <div class="form-group col-sm-6">
                                     <label>Sub Tujuan</label>
                                     <input class="form-control" type="text" name="to_divisi" id="to_divisi" placeholder="e.g. u.p Ka Akuntansi Utang/Pajak" />
                                 </div>
                                 <div class="form-group col-sm-6">
                                     <label>Nomor Jurnal saat Terbit Invoice</label>
                                     <input class="form-control" type="text" name="ref_nojur" id="ref_nojur" />
                                 </div>
                                 <div class="form-group col-sm-6">
                                     <label>Nomor Jurnal saat Invoice Dibayar</label>
                                     <input class="form-control" type="text" name="ref_nojur_pel" id="ref_nojur_pel" />
                                 </div>
                                 <div class="form-group col-lg-12">
                                     <label>(Invoice) FORMAT Paragraph 1 pada Surat</label>
                                     <textarea class="form-control" id="paragraph_1" name="paragraph_1" rows=3></textarea>
                                 </div>
                                 <div class="form-group col-lg-12">
                                     <label>(Invoice) FORMAT Untuk Pembayaran pada Kwitansi </label>
                                     <textarea class="form-control" id="text_kwitansi" name="text_kwitansi" rows=3></textarea>
                                 </div>
                             </div>
                             <hr>
                             <hr>
                         </div>

                         <div class="col-lg-12">
                             <h4>Format Pembayaran</h4>
                             <div class="row">
                                 <div class="form-group col-sm-6">
                                     <label>Nomor Jurnal saat Terbit Pembayaran Mitra</label>
                                     <input class="form-control" type="text" name="ref_nojur_pembayaran" id="ref_nojur_pembayaran" />
                                 </div>
                                 <div class="form-group col-sm-6">
                                     <label>Nomor Jurnal saat Pembayaran Mitra Dibayar</label>
                                     <input class="form-control" type="text" name="ref_nojur_pel_pembayaran" id="ref_nojur_pel_pembayaran" />
                                 </div>
                             </div>
                             <hr>
                         </div>
                         <div class="form-group col-sm-6">
                             <label>Text tambahan untuk jurnal :</label>
                             <input class="form-control" type="text" name="text_jurnal" id="text_jurnal" />
                         </div>
                     </div>

                     <!-- <div class="row"> -->
                     <!-- <div class="col-sm-12">
                         <h4>Akun Pendapatan</h4>
                     </div> -->
                     <div class="form-group col-sm-3" hidden>
                         <label>Posisi</label>
                         <select name="ac_paid_type" id='ac_paid_type' class="form-control input-lg">
                             <option value="0">Debit</option>
                             <option value="1">Kredit</option>
                         </select>

                     </div>
                     <div class="form-group col-sm-12">
                         <label> Akun Beban / HPP</label>
                         <select name="ac_expense" id='ac_expense' class="form-control select2 input-lg">
                             <?php
                                foreach ($accounts as $key => $lv1) {

                                    // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                    if ($key == 5)
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
                                }
                                ?>
                         </select>
                     </div>
                     <div class="form-group col-sm-12">
                         <label> Akun Pendapatan</label>
                         <select name="ac_paid" id='ac_paid' class="form-control select2 input-lg">
                             <?php
                                foreach ($accounts as $key => $lv1) {
                                    // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                    if ($key == 4)
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
                                }
                                ?>
                         </select>
                     </div>
                     <div class="form-group col-sm-12">
                         <label> Akun Hutang</label>
                         <select name="ac_hutang" id='ac_hutang' class="form-control select2 input-lg">
                             <?php
                                foreach ($accounts as $key => $lv1) {
                                    // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                                    if ($key == 2)
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
                                }
                                ?>
                         </select>
                     </div>
                     <div class="col-sm-12">
                         <hr>
                     </div>
                     <div class="form-group col-sm-3" hidden>
                         <label>Posisi</label>
                         <select name="ac_unpaid_type" id='ac_unpaid_type' class="form-control input-lg">
                             <option value="0">Debit</option>
                             <option value="1">Kredit</option>
                         </select>

                     </div>

                     <div class="form-group col-sm-12">
                         <label> Akun Piutang </label>
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
                     <!-- </div> -->

                     <!-- <div class="row" hidden> -->
                     <!-- <div class="col-sm-12">
                         <h4>Case Piutang</h4>
                     </div> -->
                     <div class="form-group col-sm-3" hidden>
                         <label>Posisi</label>
                         <input name="ac_ppn_type" value="0" />
                         <input name="ac_ppn" value="0" />
                         <select name="ac_ppn_type" id='ac_ppn_type' class="form-control">
                             <option value="0">Debit</option>
                             <option value="1">Kredit</option>
                         </select>

                     </div>
                     <div class="row">
                         <div class="form-group col-sm-6">
                             <label> Akun PPN Piutang</label>
                             <select name="ac_ppn_piut" id='ac_ppn_piut' class="form-control select2">
                                 <?php
                                    foreach ($accounts as $lv1) {
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
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="form-group col-sm-6">
                             <label> Akun PPN </label>
                             <select name="ac_ppn" id='ac_ppn' class="form-control select2">
                                 <?php
                                    foreach ($accounts as $lv1) {
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
                                    }
                                    ?>
                             </select>
                         </div>
                     </div>
                     <div class="col-sm-12">
                         <hr>
                     </div>
                     <!-- </div> -->

                     <!-- </div> -->
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                     <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Data</strong></button>
                     <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <script>
     $('#menu_id_33').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_91').addClass('menu-item-active')
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
             'jenis_invoice': $('#accounts_modal').find('#jenis_invoice'),
             'ac_expense': $('#accounts_modal').find('#ac_expense'),
             'ac_hutang': $('#accounts_modal').find('#ac_hutang'),
             'ac_unpaid': $('#accounts_modal').find('#ac_unpaid'),
             'ac_unpaid_type': $('#accounts_modal').find('#ac_unpaid_type'),
             'ac_paid_type': $('#accounts_modal').find('#ac_paid_type'),
             'ac_paid': $('#accounts_modal').find('#ac_paid'),
             'ac_ppn_type': $('#accounts_modal').find('#ac_ppn_type'),
             'ac_ppn': $('#accounts_modal').find('#ac_ppn'),
             'ac_ppn_piut': $('#accounts_modal').find('#ac_ppn_piut'),
             'to_divisi': $('#accounts_modal').find('#to_divisi'),
             'to_jabatan': $('#accounts_modal').find('#to_jabatan'),
             'paragraph_1': $('#accounts_modal').find('#paragraph_1'),
             'text_kwitansi': $('#accounts_modal').find('#text_kwitansi'),
             'ref_nojur': $('#accounts_modal').find('#ref_nojur'),
             'ref_nojur_pel': $('#accounts_modal').find('#ref_nojur_pel'),
             'ref_nojur_pembayaran': $('#accounts_modal').find('#ref_nojur_pembayaran'),
             'ref_nojur_pel_pembayaran': $('#accounts_modal').find('#ref_nojur_pel_pembayaran'),
             'text_jurnal': $('#accounts_modal').find('#text_jurnal'),
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
             PaymentModal.id.val('');
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
                 url: `<?php echo base_url('General/getAllJenisInvoice?by_id=true') ?>`,
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
                 var copyButton = `
                 <button type="button" class="copy btn btn-success  btn-icon" data-id='${d['id']}' title="Copy"><i class='la la-copy'></i></button>
                 `;
                 var editButton = `
                 <button type="button" class="edit btn btn-primary  btn-icon" data-id='${d['id']}' title="Edit"><i class='la la-pencil-alt'></i></button>
                 `;
                 var deleteButton = `
                 <button  type="button" class="delete btn btn-warning btn-icon" data-id='${d['id']}' title="Delete"><i class='la la-trash'></i></button>
                 `;
                 //  var button = `    ${vcrud['hk_update'] == 1 ? editButton : ''}  ${vcrud['hk_delete'] == 1 ? deleteButton : ''}`;
                 var button = `    ${ copyButton+ editButton + deleteButton} `;


                 renderData.push([d['id'], d['jenis_invoice'], d['name_paid'], d['name_unpaid'], d['name_ppn'] + '<br>' + d['name_ppn_piut'], d['ref_nojur'] + ', ' + d['ref_nojur_pel'] + ', ' + d['ref_nojur_pembayaran'] + ', ' + d['ref_nojur_pel_pembayaran'], button]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
         }

         FDataTable.on('click', '.edit', function() {
             PaymentModal.form.trigger('reset');
             PaymentModal.self.modal('show');
             PaymentModal.addBtn.hide();
             PaymentModal.saveEditBtn.show();
             var currentData = dataPayments[$(this).data('id')];
             PaymentModal.id.val('');
             PaymentModal.id.val(currentData['id']);
             PaymentModal.to_divisi.val(currentData['to_divisi']);
             PaymentModal.to_jabatan.val(currentData['to_jabatan']);

             PaymentModal.paragraph_1.val(currentData['paragraph_1']);
             PaymentModal.text_kwitansi.val(currentData['text_kwitansi']);

             PaymentModal.ref_nojur.val(currentData['ref_nojur']);
             PaymentModal.ref_nojur_pel.val(currentData['ref_nojur_pel']);
             PaymentModal.ref_nojur_pembayaran.val(currentData['ref_nojur_pembayaran']);
             PaymentModal.ref_nojur_pel_pembayaran.val(currentData['ref_nojur_pel_pembayaran']);
             PaymentModal.text_jurnal.val(currentData['text_jurnal']);

             PaymentModal.jenis_invoice.val(currentData['jenis_invoice']);
             PaymentModal.ac_unpaid_type.val(currentData['ac_unpaid_type']).change();
             PaymentModal.ac_expense.val(currentData['ac_expense']).change();
             PaymentModal.ac_hutang.val(currentData['ac_hutang']).change();

             PaymentModal.ac_paid_type.val(currentData['ac_paid_type']).change();
             PaymentModal.ac_unpaid.val(currentData['ac_unpaid']).change();
             PaymentModal.ac_paid.val(currentData['ac_paid']).change();
             PaymentModal.ac_ppn_type.val(currentData['ac_ppn_type']).change();
             PaymentModal.ac_ppn.val(currentData['ac_ppn']).change();
             PaymentModal.ac_ppn_piut.val(currentData['ac_ppn_piut']).change();
         })

         FDataTable.on('click', '.copy', function() {
             PaymentModal.form.trigger('reset');
             PaymentModal.self.modal('show');
             PaymentModal.addBtn.show();
             PaymentModal.saveEditBtn.hide();
             var currentData = dataPayments[$(this).data('id')];
             PaymentModal.id.val('');
             PaymentModal.to_divisi.val(currentData['to_divisi']);
             PaymentModal.to_jabatan.val(currentData['to_jabatan']);

             PaymentModal.paragraph_1.val(currentData['paragraph_1']);
             PaymentModal.text_kwitansi.val(currentData['text_kwitansi']);

             PaymentModal.ref_nojur.val(currentData['ref_nojur']);
             PaymentModal.ref_nojur_pel.val(currentData['ref_nojur_pel']);
             PaymentModal.ref_nojur_pembayaran.val(currentData['ref_nojur_pembayaran']);
             PaymentModal.ref_nojur_pel_pembayaran.val(currentData['ref_nojur_pel_pembayaran']);
             PaymentModal.text_jurnal.val(currentData['text_jurnal']);

             PaymentModal.jenis_invoice.val(currentData['jenis_invoice']);
             PaymentModal.ac_unpaid_type.val(currentData['ac_unpaid_type']).change();
             PaymentModal.ac_expense.val(currentData['ac_expense']).change();
             PaymentModal.ac_hutang.val(currentData['ac_hutang']).change();

             PaymentModal.ac_paid_type.val(currentData['ac_paid_type']).change();
             PaymentModal.ac_unpaid.val(currentData['ac_unpaid']).change();
             PaymentModal.ac_paid.val(currentData['ac_paid']).change();
             PaymentModal.ac_ppn_type.val(currentData['ac_ppn_type']).change();
             PaymentModal.ac_ppn.val(currentData['ac_ppn']).change();
             PaymentModal.ac_ppn_piut.val(currentData['ac_ppn_piut']).change();
         })


         FDataTable.on('click', '.delete', function() {
             var currentData = $(this).data('id');
             Swal.fire(swalDeleteConfigure).then((result) => {
                 if (result.isConfirmed == false) {
                     return;
                 }
                 $.ajax({
                     url: "<?= base_url('invoice/deleteJenisPembayaran') ?>",
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
             var url = "<?= site_url('invoice/') ?>";
             url += isAdd ? "addJenisInvoice" : "editJenisInvoice";
             var button = isAdd ? PaymentModal.addBtn : PaymentModal.saveEditBtn;

             Swal.fire(swalSaveConfigure).then((result) => {
                 if (result.isConfirmed == false) {
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