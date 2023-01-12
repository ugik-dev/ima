  <div class="card card-custom" id="print-section">
      <div class="card-body">
          <div class="box-body ">
              <div class="">
                  <?php
                    $attributes = array('id' => 'journal_voucher', 'method' => 'post', 'class' => '');
                    ?>
                  <?php echo form_open('statements/create_journal_voucher', $attributes); ?>
                  <div class="">
                      <div class="row no-print invoice">
                          <h4 class="ml-3"> <i class="fa fa-check-circle mr-2 ml-2"></i>
                              <?= $transaction['parent']->no_jurnal ?>
                          </h4>

                          <div class="col-md-12 ">
                              <div class="row">
                                  <div class="col-md-6">
                                      <label>Nama Mitra</label>

                                      <h4><strong id="mitra_name"><?= $transaction['parent']->customer_name ?> </strong></h4>
                                      <hr>
                                  </div>
                                  <div class="col-md-6">
                                      <?php if (!empty($transaction['new_arr'])) { ?>
                                          <label>Nama Kendaraan</label>
                                          <h4><strong id="arr_cars">
                                                  <?php
                                                    $i = 0;
                                                    foreach ($transaction['new_arr'] as $value) {
                                                        if ($i == 0) {
                                                            echo $value['no_cars'] . ' (' . $value['name_cars'] . ')';
                                                            $i = 1;
                                                        } else {
                                                            echo ' - ' . $value['no_cars'] . ' (' . $value['name_cars'] . ')';
                                                        }
                                                    } ?>

                                              </strong></h4>
                                          <hr>
                                      <?php } ?>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <label>No Jurnal</label>
                                      <h4><strong id="no_jurnal"><?= $transaction['parent']->no_jurnal ?></strong></h4>
                                      <hr>
                                  </div>
                                  <div class="col-md-6">
                                      <label>Tanggal</label>
                                      <h4><strong id="transaction_date"><?= explode('-', $transaction['parent']->date)[2] . '-' . explode('-', $transaction['parent']->date)[1] . '-' . explode('-', $transaction['parent']->date)[0] ?></strong></h4>
                                      <hr>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label>Deskripsi</label>
                                  <h4><strong id="naration"><?= $transaction['parent']->naration ?></strong></h4>
                                  <hr>
                              </div>
                          </div>
                      </div>
                      <div class="row invoice">
                          <div class="col-md-12 table-responsive">
                              <table class="table table-striped table-hover  ">
                                  <thead>
                                      <tr>
                                          <th class="">Akun</th>
                                          <th class="">Debit</th>
                                          <th class="">Kredit</th>
                                          <th class="">Keterangan</th>
                                      </tr>
                                  </thead>
                                  <tbody id="transaction_table_body">
                                      <?php
                                        $totdeb = 0;
                                        $totkredit = 0;
                                        $i = 0;
                                        $doc = false;
                                        foreach ($transaction['sub'] as  $key => $sub_parents) {

                                            if ($sub_parents['accounthead'] == '13') {
                                                $doc = true;
                                            }
                                        ?>

                                          <tr>
                                              <td class="rinc_name"><?= $sub_parents['name'] ?> </td>
                                              <?php if ($sub_parents['type'] == '0') {
                                                    $totdeb = $totdeb + floatval($sub_parents['amount']);
                                                ?>
                                                  <td class="currency rinc_debit"><?= $sub_parents['amount'] ?></td>
                                                  <td class="rinc_kredit"></td>
                                              <?php } else {
                                                    $totkredit = $totkredit + $sub_parents['amount'];
                                                ?>
                                                  <td class="rinc_debit"></td>
                                                  <td class="currency rinc_kredit"><?= $sub_parents['amount'] ?></td>
                                              <?php } ?>
                                              <td class="rinc_ket"><?= $sub_parents['sub_keterangan'] ?> </td>
                                          </tr>
                                      <?php } ?>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <!-- <th></th> -->
                                          <th>Total: </th>
                                          <th>
                                              <p class='currency_rp'><?= $totdeb ?></p>
                                          </th>
                                          <th>
                                              <p class='currency_rp'><?= $totkredit ?></p>
                                          </th>
                                          <th>
                                          </th>
                                      </tr>
                                      <tr>
                                          <td colspan="4" class="transaction_validity" id="transaction_validity">
                                          </td>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div>
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label>Disetujui</label>
                                          <h4 id="acc_1" class="form-control input-lg"> </h4>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group" id='label_kendaraan'>
                                          <label>Diverifikasi</label>
                                          <h4 id="acc_2" class="form-control input-lg"> </h4>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group" id='label_kendaraan'>
                                          <label>Dibuat</label>
                                          <h4 id="acc_3" class="form-control input-lg"> </h4>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group" id='label_kendaraan'>
                                          <label>Dibukukan</label>
                                          <h4 id="dibukukan" class="form-control input-lg"> </h4>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-12 ">
                              <div class="form-group">
                                  <?php
                                    if (!empty($transaction['parent']->url)) {
                                        echo '<div class="col-md-12 "> url :  <a href="' . base_url() . $transaction['parent']->url . '"> ' . base_url() . $transaction['parent']->url . '</a> </div> ';
                                    }

                                    if ($doc) {
                                    ?>
                                      <a href="<?= base_url() . 'statements/export_doc/' . $transaction['parent']->transaction_id ?>" class="btn btn-secondary  margin btn-lg pull-right" style="float: right"> <i class="fa fa-download" aria-hidden="true"></i>
                                          DoC</a>
                                  <?php } ?>
                                  <a onclick="printSingleJurnal2()" class="btn btn-secondary  margin btn-lg pull-right" style="float: right"> <i class="fa fa-print" aria-hidden="true"></i>
                                      Print</a>
                                  <?php
                                    if ($accounting_role) {
                                    ?>
                                      <a href="<?= base_url() . 'statements/edit_jurnal/' . $transaction['parent']->transaction_id . ($draft ? '/draft' : '') ?>" class="btn btn-info  margin btn-lg pull-right" style="float: right"> <i class="fa fa-list-alt" aria-hidden="true"></i>
                                          Edit</a>
                                  <?php } ?>

                              </div>
                          </div>
                      </div>
                  </div>
                  <?php form_close(); ?>
              </div>
          </div>
      </div>
  </div>
  <script src="<?php echo base_url(); ?>assets/dist/js/backend/journal_voucher.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

  <script>
      $('#menu_id_24').addClass('menu-item-active menu-item-open menu-item-here"')
      <?php if ($draft == false) { ?>
          $('#submenu_id_59').addClass('menu-item-active')
      <?php } else { ?>
          $('#submenu_id_83').addClass('menu-item-active')
      <?php } ?>

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


      var elements = document.getElementsByClassName('currency')

      for (var i = 0; i < elements.length; i++) {
          elements[i].innerHTML = formatRupiah(elements[i].innerHTML);
      }

      var currency_rp = document.getElementsByClassName('currency_rp')

      for (var i = 0; i < currency_rp.length; i++) {
          currency_rp[i].innerHTML = formatRupiah(currency_rp[i].innerHTML, true);
      }

      $('.mask').mask('000.000.000.000.000,00', {
          reverse: true
      });

      id_custmer = $('#id_customer');
      id_cars = $('#id_cars');
      id_custmer.on('change', function() {
          console.log('s')
          $.ajax({
              url: '<?= base_url() ?>Statements/getListCars',
              type: "get",
              data: {
                  id_patner: id_custmer.val()
              },
              success: function(data) {
                  var json = JSON.parse(data);
                  if (json['error'] == true) {
                      console.log('data_kosong')
                      id_cars.prop('disabled', 'true')
                      id_cars.val('')
                      id_cars.html('')
                      return;
                  }
                  console.log(json)
                  id_cars.prop('disabled', '')
                  id_cars.html('<option value="0"> ------- </option>' +
                      json['data'])

              },
              error: function(e) {}
          });
          // });

      });

      function printSingleJurnal2(id) {
          var acc_1 = document.getElementById("acc_1").innerHTML;
          var acc_2 = document.getElementById("acc_2").innerHTML;
          var acc_3 = document.getElementById("acc_3").innerHTML;
          var dibukukan = document.getElementById("dibukukan").innerHTML;
          var naration = document.getElementById("naration").innerHTML;
          var no_jurnal = document.getElementById("no_jurnal").innerHTML;
          //   return;
          //   var arr_cars = document.getElementById("arr_cars").innerHTML;
          var mitra_name = document.getElementById("mitra_name").innerHTML;
          var name = document.getElementsByClassName("rinc_name");
          var ket = document.getElementsByClassName("rinc_ket");
          var debit = document.getElementsByClassName("rinc_debit");
          var kredit = document.getElementsByClassName("rinc_kredit");
          var date = document.getElementById("transaction_date").innerHTML;
          console.log(name)
          isi = "";
          var consdebit = 0;
          var show = 0;
          var conskredit = 0;
          var displyhide = true
          var tpe = no_jurnal.split("/")[1];
          if (tpe == 'AM' || tpe == 'KM' || tpe == 'DM') {
              tpe = 'AM'
          } else if (tpe == 'AK' || tpe == 'KK' || tpe == 'DK') {
              tpe = 'AK'
          }
          if (tpe == undefined) {
              tpe = ''
          }

          console.log(tpe)
          arus_kas_debit = 0;
          arus_kas_kredit = 0;
          no_rek = '112-0098146017';
          for (var i = 0; i < name.length; i++) {
              if (name[i].innerHTML.substring(1, 7) == '1.11.1' ||
                  name[i].innerHTML.substring(1, 7) == '1.11.2' ||
                  name[i].innerHTML.substring(1, 7) == '1.11.3') {
                  arus_kas_debit = parseInt(debit[i].innerHTML.replace(/[^0-9]/g, ""));
                  arus_kas_kredit = parseInt(kredit[i].innerHTML.replace(/[^0-9]/g, ""));
                  <?php if ($draft == false) { ?>
                  <?php } else { ?>
                      if (arus_kas_debit > 0) {
                          tpe = 'AM';
                      }
                      if (arus_kas_kredit > 0) tpe = 'AK';
                  <?php } ?>

                  if (tpe == 'AM') {
                      displyhide = false
                      show =
                          show +
                          (debit[i].innerHTML ?
                              parseInt(debit[i].innerHTML.replace(/[^0-9]/g, "")) :
                              0);
                  } else if (tpe == 'AK') {
                      displyhide = false
                      show =
                          show +
                          (kredit[i].innerHTML ?
                              parseInt(kredit[i].innerHTML.replace(/[^0-9]/g, "")) :
                              0);
                  }
              }
              if (name[i].innerHTML.substring(1, 9) == '1.11.240') {
                  no_rek = '169-00-0207756-5';
              }

              <?php if ($draft == false) { ?>
              <?php } else { ?>
                  if (arus_kas_debit > 0) {
                      tpe = 'AM';
                  }
                  if (arus_kas_kredit > 0) tpe = 'AK';
              <?php } ?>

              isi += `
            <tr style="height : 10px">
                <td style="text-align:center; padding-left : 5px ">${name[i].innerHTML.substring(0, 14)}</td>
                <td style="text-align:left; padding-left : 5px ">${ket[i].innerHTML}</td>
                <td style="text-align:right ; padding-right : 5px">${
                debit[i].innerHTML
                }</td>
                <td style="text-align:right ; padding-right : 5px">${kredit[i].innerHTML}</td>
                </tr>
                `;
              last = i;
              console.log(debit[i].innerHTML.replace(/[^0-9]/g, ""));
              consdebit =
                  consdebit +
                  (debit[i].innerHTML ?
                      parseInt(debit[i].innerHTML.replace(/[^0-9]/g, "")) :
                      0);
              conskredit =
                  conskredit +
                  (kredit[i].innerHTML ?
                      parseInt(kredit[i].innerHTML.replace(/[^0-9]/g, "")) :
                      0);
              // fixdate = date[i].innerHTML();
          }
          // console.log(fixdate)
          for (var j = last; j < 7; j++) {
              isi += `<tr  style="height : 22px; padding : 10px">
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            </tr>
            `;
          }
          isi += `<tr  style="height : 22px; padding : 10px">
            <td colspan="2"><strong>Jumlah</strong> </td>
        
            <td style="text-align:right ; padding-right : 5px"><strong>${formatRupiah(consdebit)}</strong> </td>
            <td style="text-align:right ; padding-right : 5px"><strong>${formatRupiah(conskredit)}</strong> </td>
            </tr>
            `;

          var printContents = `
            <table style="font-size: 17px;width: 100%" border="0">
                <tr>
                    <td style="width: 50%"><img style="heigt: 100px; width : 80%" src="<?= base_url() ?>assets/img/header_ima.png" alt="Paris" class="center"></td>                 
                    <td style="width: 50%">
                                <h3 style="text-align:center">${tpe == 'AM' ? 'VOUCHER PENERIMAAN' : (tpe == 'AK' || tpe == "EK" ? 'VOUCHER PENGELUARAN' : 'JURNAL UMUM')}</h3>    
                    </td>                 
                </tr>
            </table>   
            <br>
                    <table style="font-size: 15px;" border="0">
                              <tr>
                            <td ${displyhide ? '' : ''} style=";text-align:left ;width: 100px">${tpe == 'AM' ? 'Diterima dari' : (tpe == 'AK' || tpe == "EK" ? 'Dibayar kepada' : '')}</td>
                            <td style=;width: 10px">${displyhide ? '' : ':'}</td>
                            <td style=";text-align:left ;width: 400px"> ${displyhide ? '' : mitra_name} </td>
                            <td style="text-align:left ;width: 100px">No Voucher</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left; width: 200px ${tpe == 'AM' ? '; color: red':''} ">${no_jurnal}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left ;width: 100px"> Deskripsi</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">${ naration}</td>
                            <td style="text-align:left ;width: 100px">Tanggal</td>
                            <td style="width: 10px">:</td>
                            <?php if ($draft == false) { ?>
                                <td style="text-align:left; width: 200px  ${tpe == 'AM' ? '; color: red':''}">${date}</td>
                           
                            <?php } else { ?>
                                <td style="text-align:left; width: 200px  ${tpe == 'AM' ? '; color: red':''}"></td>
                            <?php } ?>
                        </tr>
                            <tr style="${displyhide ? 'display: none' : ''} ;">
                            <td style="text-align:left ;width: 100px">Sejumlah</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px">Rp. ${formatRupiah(show)}</td>
                            
                        </tr>
                            <tr style="${displyhide ? 'display: none' : ''} ;">
                            <td style="text-align:left ;width: 100px">Terbilang</td>
                            <td style="width: 10px">:</td>
                            <td style="text-align:left ;width: 400px;font-style: italic;">${terbilang(show.toString())}</td>
                        
                        </tr>
                    </table>
                   <br>
                    <table style="font-size: 15; width : 990px" border="1" cellspacing="0">
                        <tr>
                            <td style="width: 100px ;text-align:center">No Akun</td>
                            <td style="width: 390px ; text-align:center">Keterangan</td>
                            <td style="width: 130px ; text-align:center">Debit (Rp)</td>
                            <td style="width: 130px; text-align:center">Kredit  (Rp)</td>
                        </tr>
                        ${isi}
                        
                    </table>
                    <br>
                    <table style="font-size: 15; width: 100%" border="0" cellspacing="0">
                        <tr>
                            <td style="width: 400 ;text-align:left; padding : 0px">
                            
                                <table style="" border="1" cellspacing="0">
                                    <tr>
                                        <td style="width: 130 ;text-align:left; padding : 3px">Pengeluaran Berupa</td>
                                        <td style="width: 130 ; text-align:left ; padding : 3px">Kas/Cek/Trans*)</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 130 ;text-align:left; padding : 3px">Nomor</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 130 ;text-align:left; padding : 3px">Tanggal</td>
                                        <td ></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 130 ;text-align:left; padding : 3px">A/C No.</td>
                                        <td style="width: 130 ; text-align:left ; padding : 3px">${no_rek}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 160 ; align:right ; padding : 0px">
                                <table style="float: right"  border="1" cellspacing="0">
                                    <tr>
                                        <td style="width: 130px ;text-align:center">Disetujui</td>
                                        <td style="width: 130px ; text-align:center">Diverifikasi</td>
                                        <td style="width: 130px ; text-align:center">Dibuat Oleh</td>
                                        <td style="width: 130px ; text-align:center">Diterima</td>
                                        <td style="width: 130px ; text-align:center">Dibukukan</td>
                                    </tr>
                                    <tr style="height: 90px">
                                        <td style="vertical-align: bottom; text-align:center">${acc_1}</td>
                                        <td style="vertical-align: bottom; text-align:center">${acc_2}</td>
                                        <td style="vertical-align: bottom; text-align:center">${acc_3}</td>
                                        <td></td>
                                        <td style="vertical-align: bottom; text-align:center">${dibukukan}</td>
                                    
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; margin-right: 1px">Tgl</td>
                                        <td style="text-align:left">Tgl</td>
                                        <td style="text-align:left">Tgl</td>
                                        <td style="text-align:left">Tgl</td>
                                        <td style="text-align:left">Tgl : <?php if (!empty($acc->date_acc_0)) echo explode('-', $acc->date_acc_0)[2] . '-' . explode('-', $acc->date_acc_0)[1] . '-' . explode('-', $acc->date_acc_0)[0]; ?></td>                             
                                    </tr>
                            
                                </table>
                            </td>
                        </tr>
                    </table>
             `;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          setTimeout(() => {
              window.print();
              document.body.innerHTML = originalContents;
          }, 4000);
      }

      <?php if (!empty($acc)) {

        ?>
          document.getElementById("acc_1").innerHTML = '<?= $acc->name_1 ?>';
          document.getElementById("acc_2").innerHTML = '<?= $acc->name_2 ?>';
          document.getElementById("acc_3").innerHTML = '<?= $acc->name_3 ?>';
          document.getElementById("dibukukan").innerHTML = '<?= $acc->acc_0 ?>';
      <?php  } ?>
  </script>
  <?php $this->load->view('bootstrap_model.php'); ?>