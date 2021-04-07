<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <a href="<?php echo base_url('supply/create_new_supply'); ?>"  class="btn btn-primary btn-outline-primary" ><i class="fa fa-plus-square" aria-hidden="true"></i>  Pengiriman Baru
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> DAFTAR PENGIRIMAN CUSTOMER</h3>
                    <br>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php
                            $attributes = array('id'=>'supply_form','method'=>'post',);
                        ?>
                        <?php echo form_open('supply',$attributes); ?>
                        <div class="col-md-3 ">
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
                                        $data = array('class'=>'btn btn-info input-lg btn-outline-primary margin ','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari Pengiriman');
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
                                if($supply_list != NULL)
                                {
                                    foreach ($supply_list as $single_supply)
                                    {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $single_supply->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_supply->date; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_supply->townname.' / '.$single_supply->townregion; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($single_supply->payment_method == 0)
                                                {
                                                    echo 'Tunai';
                                                }
                                                else if($single_supply->payment_method == 1)
                                                {
                                                    echo 'Cek';
                                                }
                                                else if($single_supply->payment_method == 2)
                                                {
                                                    echo 'Kredit';
                                                }   
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $single_supply->total_bill+$single_supply->discount; ?>
                                        </td>
                                         <td>
                                            <?php echo $single_supply->discount; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_supply->bill_paid; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_supply->total_bill-$single_supply->bill_paid; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_supply->customer_name; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_supply->agentname; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group pull no-print pull-right">
                                                <button type="button" class="btn btn-info btn-flat">Tindakan</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url('invoice/manage/'); ?>">
                                                             <i class="fa fa-pencil"></i> Lihat
                                                        </a>
                                                    </li>
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
