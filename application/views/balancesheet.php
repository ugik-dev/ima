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
                $attributes = array('id'=>'balance_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements/balancesheet',$attributes); ?>
            <div class="row no-print">
                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo form_label('Pilih Tahun'); ?>
                        <select class="form-control input-lg" name="year">
                            <option  value="2019"> 2019</option>
                            <option  value="2020"> 2020</option>
                            <option  value="2021"> 2021</option>
                            <option  value="2022"> 2022</option>
                            <option  value="2023"> 2023</option>
                            <option  value="2024"> 2024</option>
                            <option  value="2025"> 2025</option>
                            <option  value="2026"> 2026</option>
                        </select>
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
                    <h2 style="text-align:center"> NERACA KEUANGAN (BALANCE SHEET) </h2>
                    <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                        ?>
                    </h3>
                 
                   <h4 style="text-align:center">Hingga : <?php echo $to; ?> <b>
                   </h4>
                   <h4 style="text-align:center">Dibuat : <?php echo Date('Y-m-d'); ?> <b>
                   </h4>
                </div>
                <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <div class="col-md-12">
                 <table class="table table-striped table-hover">
                     <thead>
                       <tr >
                           <th colspan="2" class="balancesheet-header">AKTIVA LANCAR / CURRENT ASSET</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php echo $balance_records['current_assets']; ?>
                     </tbody>
                 </table>
                 <table class="table table-striped table-hover">
                     <thead>
                       <tr>
                           <th colspan="2" class="balancesheet-header">AKTIVA TETAP / FIXED ASSET</th>
                       </tr>
                     </thead>
                     <tbody>
                        <?php echo $balance_records['noncurrent_assets']; ?>
                     </tbody>
                 </table>                 
                 <table class="table table-striped table-hover">
                     <tbody>
                      <?php echo $balance_records['total_assets']; ?>
                     </tbody>
                 </table>
            </div>
            <div class="col-md-12">
                 <table class="table table-striped table-hover">
                     <thead>
                       <tr>
                           <th colspan="2" class="balancesheet-header">KEWAJIBAN / LIABILITY</th>
                       </tr>
                     </thead>
                     <tbody>
                         <?php echo $balance_records['current_libility']; ?>
                     </tbody>
                 </table>
                 <table class="table table-striped table-hover">
                     <thead>
                       <tr>
                          <th colspan="2" class="balancesheet-header">KEWAJIBAN / LIABILITY OTHER</th>
                       </tr>
                     </thead>
                     <tbody>
                        <?php echo $balance_records['noncurrent_libility']; ?>
                        <?php echo $balance_records['total_currentnoncurrent_libility']; ?>
                     </tbody>
                 </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                 <table class="table table-striped table-hover">
                     <thead>
                       <tr>
                           <th colspan="2" class="balancesheet-header">MODAL / EQUITY</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php echo $balance_records['equity']; ?>
                     </tbody>
                 </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                 <table class="table table-striped table-hover">
                     <tbody>                           
                      <?php echo $balance_records['total_libility_equity']; ?>
                     </tbody>
                 </table>
            </div>
        </div>
            </div>
        </div>
    </div>
</section>