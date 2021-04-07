<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>expense/popup/add_expense_model')" class="btn btn-info btn-outline-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                    <?php echo $page_add_button_name; ?>
                </button>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary pull-right "><i class="fa fa-print pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box " id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body">
                    <?php
                            $attributes = array('id'=>'Sales_form','method'=>'post');
                    ?>
                        <?php echo form_open('expense/generate_expense',$attributes); ?>
                            <div class="col-md-12 no-print">
                               <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Dari Tanggal:'); ?>
                                        <?php $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date1');
                                        echo form_input($data); ?>
                                </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Sampai Tanggal:'); ?>
                                        <?php $data1 = array('class'=>'form-control input-lg','type'=>'date','name'=>'date2');
                                        echo form_input($data1); ?>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                
                                    <?php
                                        $data = array('class'=>'btn btn-info input-lg btn-outline-primary','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari');
                                        echo form_button($data);
                                    ?>
                                </div>
                                </div>
                            </div>
                         <?php echo form_close(); ?> 
                         <div class="col-md-12 table-responsive">
                            <table id="" class="table table-bordered table-striped">
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
                    				if($expense_record_list != NULL)
                                    {
                                        $counter = 1;
                                        $total_bill = 0;
                                        $total_paid = 0;
                    					foreach ($expense_record_list as $single_expense)
                                        {
                                             $total_bill =  $total_bill + $single_expense->total_bill;
                                             $total_paid =  $total_paid + $single_expense->total_paid;
                    				?>
                                    <tr>
                                        <td>
                                            <?php echo $counter; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_expense->head_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_expense->customer_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_expense->method; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_expense->date; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_expense->user; ?>
                                        </td>
                                        <td>
                                            <?php echo substr($single_expense->description,0,30); ?>
                                        </td>
                                         <td>
                                            <?php echo $single_expense->total_bill; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_expense->total_paid; ?>
                                        </td>
                                        
                                    </tr>
                                    <?php
                                        $counter++;
                    					}
                    				?>
                                    <tr>
                                        <th colspan="7">Total</th>
                                        <th><?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?> <?php echo number_format($total_bill,'2','.','') ?></th>
                                        <th ><?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?> <?php echo number_format($total_paid,'2','.','') ?></th>
                                    </tr>
                                    <?php 
                                        }
                                        else
                                        {
                                    ?>
                                            <tr  class="text-center">
                                                <td colspan="9"><b>Mohon maaf, tidak ditemukan data expense</b></td>
                                            </tr>
                                    <?php
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
