<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-lg btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body box-bg ">
            <div class="make-container-center">
            <?php
                $attributes = array('id'=>'leadgerAccounst','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements/leadgerAccounst',$attributes); ?>
            <div class="row no-print">
                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo form_label('Dari Tanggal'); ?>
                        <?php
                            $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'from','reqiured'=>'');
                            echo form_input($data);
                        ?>
                    </div>
                </div>                    
                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo form_label('Sampai Tanggal'); ?>
                        <?php
                            $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'to','reqiured'=>'');
                            echo form_input($data);
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top:16px;">
                        <?php
                            $data = array('class'=>'btn btn-info btn-flat margin btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Buat Statement');
                            echo form_button($data);
                         ?>  
                    </div>
                </div>      
            <?php form_close(); ?>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2 style="text-align:center">BUKU BESAR </h2>
                    <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                        ?>
                    </h3>
                   <h4 style="text-align:center"><b> Dari </b> <?php echo $from; ?> <b> Sampai </b> <?php echo $to; ?></h4>
                   <h4 style="text-align:center"><b> Dibuat  </b> <?php echo Date('Y-m-d'); ?> </h4>
                </div>
            <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <?php echo $ledger_records; ?>
        </div>
    </section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 