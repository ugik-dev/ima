<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body box-bg ">
            <div class="make-container-center">
            <?php
                $attributes = array('id'=>'general_journal','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements',$attributes); ?>
            <div class="row no-print">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php echo form_label('Dari Tanggal'); ?>
                        <?php
                            $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'from','reqiured'=>'');
                            echo form_input($data);
                        ?>
                    </div>
                </div>                    
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php echo form_label('Sampai Tanggal'); ?>
                        <?php
                            $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'to','reqiured'=>'');
                            echo form_input($data);
                        ?>
                    </div>
                </div>
                <div class="col-md-3 ">
                <div class="form-group" style="margin-top: 16px;">
                        <?php
                            $data = array('class'=>'btn btn-info btn-flat margin btn-lg ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Buat Statement');
                            echo form_button($data);
                         ?>  
                    </div>
                </div>      
            <?php form_close(); ?>
        </div>
        <?php 
        if($transaction_records != NULL)
        {
        ?>
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                   <h2 style="text-align:center">JURNAL UMUM </h2>
                   <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                        ?>
                    </h3>
                   <h4 style="text-align:center"><b>Dari</b> <?php echo $from; ?> <b> Sampai </b> <?php echo $to; ?>
                   </h4>
                   <h4 style="text-align:center">Dibuat <?php echo Date('Y-m-d'); ?> 
                   </h4>
                </div>
            <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <table class="table table-hover table-responsive" id="dataTable">
                <thead class="ledger_head">
                     <th class="col-md-2">TANGGAL</th>
                     <th class="col-md-8">NAMA AKUN DAN TRANSAKSI</th>
                     
                     <th class="col-md-1">DEBIT</th>
                     <th class="col-md-1">KREDIT</th>
                </thead>
                <tbody>   
                        <?php echo $transaction_records; ?>
                </tbody>
            </table>
        </div>
        <?php 
            }
            else
            {
                echo '<p class="text-center"> No record found</p>';
            }
        ?>
    </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 