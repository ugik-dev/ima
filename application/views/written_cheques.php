<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <a type="button" class="btn btn-info btn-outline-primary" href="<?php echo base_url('bank/cheque'); ?>" ><i class="fa fa-plus-square" aria-hidden="true"></i>        Cek Baru
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                     <br>
                </div>
                <div class="box-body">
                    <div class="row">
                    <?php
                        $attributes = array('id'=>'invoice_form','method'=>'post',);
                    ?>
                    <?php echo form_open('bank/written_cheque',$attributes); ?>
                    <div class="col-md-3">
                        <div class="form-group margin ">
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
                        <div class="form-group margin">
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
                        <div class="col-md-3">
                        <div class="form-group margin" style="margin-top:25px;">
                            <?php
                                $data = array('class'=>'btn btn-info btn-outline-primary margin  input-lg','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari Cek');
                                echo form_button($data);
                             ?>
                        </div>
                        </div>
                        <?php echo form_close(); ?>
                </div>   
                <div class="col-md-12 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
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
                                if($cheque_list != NULL)
                                {
                                    foreach ($cheque_list as $cheque)
                                    {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $cheque->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->bankname; ?>
                                    </td> 
                                    <td>
                                        <?php echo $cheque->headname; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->amount; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->ref_no; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($cheque->transaction_status == 0)
                                            {
                                                echo 'Cleared';
                                            }
                                            else
                                            {
                                                echo 'Outstanding';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group pull no-print pull-right">
                                            <button type="button" class="btn btn-info btn-flat">Jadikan</button>
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <?php 
                                                if($cheque->transaction_status == 0)
                                                {   
                                                ?> 
                                                    <li>
                                                        <a onclick="confirmation_alert('make this outstanding  ','<?php echo base_url().'bank/change_cheque_status/'.$cheque->bank_trans_id.'/1'; ?>')"  href="javascript:void(0)"  ><i class="fa fa-times-circle-o"></i> Outstanding
                                                        </a>
                                                    </li>
                                                <?php    
                                                }
                                                else
                                                {
                                                 ?>
                                                    <li>
                                                        <a  onclick="confirmation_alert('make this cleared  ','<?php echo base_url().'bank/change_cheque_status/'.$cheque->bank_trans_id.'/0'; ?>')"  href="javascript:void(0)" ><i class="fa fa-check-circle"></i> Cleared
                                                        </a>
                                                    </li>
                                                <?php 
                                                  }
                                                 ?>   
                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                                <?php

                                        }
                                    }

                                 ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 