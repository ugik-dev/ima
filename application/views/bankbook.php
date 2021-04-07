<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content" id="print-section">
    <div class="row no-print">
        <div class="col-md-12 ">
        <?php
            $attributes = array('id'=>'bank_form','method'=>'post',);
        ?>
        <?php echo form_open('bank/bank_book',$attributes); ?>
            <div class="col-md-3">
                <div class="form-group ">
                    <?php echo form_label('Dari Tanggal:'); ?>
                        <div class="input-group date ">
                            <div class="input-group-addon   ">
                                <i class="fa fa-calendar "></i>
                            </div>
                            <?php
                                $data = array('class'=>'form-control  input-lg','type'=>'date','id'=>'datepicker','name'=>'date1','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group ">
                    <?php echo form_label('Sampai Tanggal:'); ?>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                                $data = array('class'=>'form-control  input-lg' ,'type'=>'date','id'=>'datepicker','name'=>'date2','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <?php echo form_label('Pilih Bank:'); ?>
                    <select name="bank_id" class="form-control input-lg">
                        <?php 
                          foreach ($bank_list as $single_bank) 
                          {
                        ?>
                             <option value="<?php echo $single_bank->id ?>">
                              <?php echo $single_bank->bankname.' | '.$single_bank->branch.' | '.$single_bank->branchcode.' | '.$single_bank->title.' | '.$single_bank->accountno;  ?>
                              </option>
                        <?php   
                          }
                        ?>   
                    </select>
                </div>
            </div>
            <div class="col-md-2">
            <div class="form-group" style="margin-top:16px">
                <?php
                    $data = array('class'=>'btn btn-info btn-outline-primary margin  input-lg','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Generate Buku Bank');
                    echo form_button($data);
                 ?>
            </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <?php 
        if($bank != '')
        {
     ?>
    <div class="row">
        <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 style="text-align:center"> BUKU BANK </h2>
                <h3 style="text-align:center">
                    <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                    ?>
                </h3>
                <h4 style="text-align:center"> <b><?php echo $bankname[0]->bankname; ?> </b>
                </h4>
                <h4 style="text-align:center">Hingga : <b><?php echo $to; ?> </b>
                </h4>
                <h4 style="text-align:center">Dibuat : <b><?php echo Date('Y-m-d'); ?> </b>
                </h4>
            </div>
            <div class="col-md-3"></div>  
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header balancesheet-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body">
                <div class="col-md-12 table-responsive">
                    <table id="" class="table  table-striped">
                        <thead>
                            <tr>
                                <?php
                                foreach ($table_heading_names_of_coloums as $table_head)
                                {

                                ?>
                                    <th>
                                        <?php echo $table_head; ?>
                                    </th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total_deposits = 0;
                                if($deposit_list != NULL)
                                {
                                    foreach ($deposit_list as $deposit)
                                    {
                                        $total_deposits = $total_deposits + $deposit->cheque_amount;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $deposit->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->method; ?>
                                    </td> 
                                    <td>
                                        <?php echo $deposit->ref_no; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->cheque_amount; ?>
                                    </td>
                                </tr>

                                <?php
                                        }
                                    }
                                 ?>
                                 <tr class="balancesheet-row">
                                     <td  colspan="4"> Total Deposito </td>
                                     <td ><b><?php echo number_format($total_deposits,'2','.',''); ?></b></td>
                                 </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header balancesheet-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name2; ?></h3>
                </div>
                <div class="box-body">
                <div class="col-md-12 table-responsive">
                    <table id="" class="table  table-striped">
                        <thead>
                            <tr>
                                <?php
                                foreach ($table_heading_names_of_coloums as $table_head)
                                {

                                ?>
                                    <th>
                                        <?php echo $table_head; ?>
                                    </th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total_cheque = 0;
                                if($cheque_list != NULL)
                                {
                                    foreach ($cheque_list as $cheque)
                                    {
                                        $total_cheque = $total_cheque + $cheque->cheque_amount;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $cheque->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->method; ?>
                                    </td> 
                                    <td>
                                        <?php echo $cheque->ref_no; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->cheque_amount; ?>
                                    </td>
                                </tr>

                                <?php
                                        }
                                    }
                                 ?>
                                 <tr class="balancesheet-row">
                                     <td  colspan="4"> Total Cek Tertulis </td>
                                     <td ><b><?php echo number_format($total_cheque,'2','.',''); ?></b></td>
                                 </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
         ?>
</section>