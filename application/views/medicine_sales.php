<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body ">
                    <?php
						$attributes = array('id'=>'Sales_form','method'=>'post','class'=>'form-horizontal');
					?>
                        <?php echo form_open('salesreport/',$attributes); ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Dari Tanggal:'); ?>
                                    <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date1');
										echo form_input($data); 
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Sampai Tanggal:'); ?>
                                    <?php $data1 = array('class'=>'form-control input-lg','type'=>'date','name'=>'date2');
										echo form_input($data1); 
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php echo form_label('Pilih Customer.'); ?>
                                        <select name="customer_id" class="form-control select2 input-lg">
                                            <?php 
                                            foreach ($customer_list as $single_customer) 
                                            {
                                            ?>
                                                <option value="<?php echo $single_customer->id; ?>">
                                                    <?php //echo $single_customer->customer_name; ?>  
                                                    <?php echo 'Nama: '.$single_customer->customer_name.' - '.$single_customer->cus_company.' - '.$single_customer->cus_contact_2.' - '.$single_customer->cus_type.' - '.$single_customer->cus_region;

                                                ?>   
                                                </option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
                                </div> 
                                
                                <div class="form-group">
                                    <?php
										$data = array('class'=>'btn btn-info  btn-outline-primary pull-right','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Cari Penjualan');
										echo form_button($data);
									?>
                                </div>
                            </div>
                         <?php echo form_close(); ?> 
                            <div class=" no-print">
                                <div class="col-md-12">
                                    <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary  pull-right "><i class="fa fa-print pull-left"></i> Cetak</button>
                                </div>
                            </div>
                </div>
                <div id="print-section ">
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

    			            $sno = 1;
    			            $total_revenue =0;
                            $discount_offered = 0;
                            $total_expense = 0;
    			            $total_items_sold = 0;

        					for($i = 0; $i < count($Sales_collection); $i++)
                            {

    						    $counter = 0;
    							while( $counter < count($Sales_collection[$i]))
                                {
        							$total = 0;
        				            $subtotal = 0;
        							 $subtotal = $Sales_collection[$i][$counter]->price*$Sales_collection[$i][$counter]->qty;
                                    $total_expense = $total_expense + ($Sales_collection[$i][$counter]->purchase*$Sales_collection[$i][$counter]->qty); 
                                    $total = $total+$subtotal;  
                                    $new_amount = $total-$invoices_record[$i]->discount;     
                                    $total_revenue = $total_revenue+$total;    
                                    $discount_offered  = $discount_offered+($total-$new_amount);      
                                    $totalprofit = $total_revenue-$total_expense;
        				        ?>
                        <tr>
                            <td>
                                <?php echo $sno; ?>
                            </td>
                            <td>
                                <?php echo $invoices_record[$i]->id; ?>
                            </td>
                            <td>
                                <?php echo $invoices_record[$i]->date; ?>
                            </td>
                            <td>
                                <?php echo $Sales_collection[$i][$counter]->product_name; ?>
                            </td>
                            <td>
                                <?php echo $Sales_collection[$i][$counter]->mg.' '.$Sales_collection[$i][$counter]->unit_type; ?>
                            </td>
                            <td>
                                <?php echo $Sales_collection[$i][$counter]->price; ?>
                            </td>
                            <td>
                                <?php echo $Sales_collection[$i][$counter]->qty; ?>
                            </td>
                            <td>
                                <?php echo $subtotal; ?>
                            </td>
                        </tr>
                    <?php
                            $total_items_sold += $Sales_collection[$i][$counter]->qty;
        			         $counter++;		
        		          $sno++;
        					}
        						
        				}
		          ?>
            </tbody>
        </table>
    </div>
        <section class="content" style="background-color:#fff;">
            <div class="row">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Laporan Penjualan</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Jumlah Item Terjual </td>
                        <td class="text-right">
                                <?php echo $total_items_sold; ?>
                        </td>
                    </tr>                    
                    <tr>
                        <td>Total jumlah penjualan (Tanpa diskon)</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $total_revenue; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Total Modal / Pengeluaran</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $total_expense; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Laba / Rugi</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $totalprofit; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Total Diskon yang ditawarkan</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $discount_offered; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Laba / Rugi bersih</td>
                        <td class="text-right ">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $totalprofit-$discount_offered; ?> /- </td>
                    </tr>
                </table>
            </div>
        </section>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->