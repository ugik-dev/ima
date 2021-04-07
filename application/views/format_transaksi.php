<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> FORMAT DATA</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 table-responsive">
                        <div class="alert alert-warning" role="alert">
                            Memformat data akan mengosongkan semua data pada daftar data-data dibawah ini. Pastikan anda telah melakukan <a href="<?php echo base_url();?>backup">Backup Database</a> Terlebih dahulu. Lakukan format data secara berurutan dari atas sampai bawah.
                        </div>
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_entri')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Entri Jurnal</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_invoice')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Invoice</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_penjualan')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Penjualan</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_retur')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Retur</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_isi_retur')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Isi Retur</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_pembelian')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Pembelian</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_pembayaran_customer')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Pembayaran Customer</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_pembayaran_supplier')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Pembayaran Supplier</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_expense')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Exspense</a>
                        <hr />
                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url();?>backup/format_jurnal')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Kosongkan Data Jurnal Umum</a>
                         </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 