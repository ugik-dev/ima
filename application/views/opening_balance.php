<section class="">
    <div class="box" id="print-section">
        <div class="box-body">
            <div class="">
            <?php
                $attributes = array('id'=>'open_balance_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open('statements/add_new_balance',$attributes); ?>
            <div class="">
                <div class="">
                    <div class="col-md-12 ">
                        <h4  class="purchase-heading" > <i class="fa fa-check-circle"></i>   Saldo Pembukaan 
                            
                        </h4>
                        <div class="form-group">
                            <?php echo form_label('Nama Akun'); ?>
                              <select name="account_head" class="form-control select2 input-lg">
                                    <?php 
                                      foreach ($heads_record as $single_head) {
                                    ?>
                                         <option value="<?php echo $single_head->id ?>">
                                          <?php echo $single_head->name ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>  
                          <div class="form-group">
                            <?php echo form_label('Tipe Akun'); ?>
                              <select name="user_type" class="form-control input-lg user_type">
                                  <option value="1"> Customer </option> 
                                  <option value="2"> Supplier </option> 
                                  <option value="3"> Karyawan </option> 
                              </select>
                        </div>
                        <script>
                            $("document").ready(function(){
                                $(".user_type").change(function(){
                                    var id = $(this).val();
                                    if(id == 2){
                                         $('.customer_id').hide();
                                        $('.supplier_id').show();                                       
                                        $('.employee_id').hide();

                                    }else  if(id == 3){
                                        $('.customer_id').hide();
                                        $('.supplier_id').hide();
                                        $('.employee_id').show();
                                        

                                    }else{
                                        $('.customer_id').show();
                                        $('.supplier_id').hide();
                                        $('.employee_id').hide();
                                    }
                                });
                            });
                        </script>

                         <div class="form-group customer_id">
                            <?php echo form_label('Pilih Customer'); ?>
                                <select name="customer_id" class="form-control select2 input-lg">
                                    <?php 
                                    foreach ($customer_list as $single_customer) 
                                    {
                                    ?>
                                        <option value="<?php echo $single_customer->id; ?>">
                                            <?php //echo $single_customer->customer_name; ?>  
                                             <?php echo 'Nama : '.$single_customer->customer_name.' - '.$single_customer->cus_company.' - '.$single_customer->cus_contact_2.' - '.$single_customer->cus_type.' - '.$single_customer->cus_region;

                                         ?>   
                                        </option>
                                    <?php 
                                     }
                                    ?>
                                </select>
                        </div>  
                         <div class="form-group supplier_id" style="display:none">
                            <?php echo form_label('Pilih Supplier'); ?>
                                <select name="supplier_id" class="form-control select2 input-lg">
                                    <?php 
                                    foreach ($supplier_list as $single_supplier) {
                                    ?>
                                        <option value="<?php echo $single_supplier->id; ?>">
                                            <?php //echo $single_supplier->customer_name; ?>  
                                             <?php echo 'Nama : '.$single_supplier->customer_name.' - '.$single_supplier->cus_company.' - '.$single_supplier->cus_contact_2.' - '.$single_supplier->cus_type.' - '.$single_supplier->cus_region;

                                         ?>   
                                        </option>
                                    <?php 
                                     }
                                    ?>
                                </select>
                        </div>  
                         <div class="form-group employee_id" style="display:none">
                            <?php echo form_label('Pilih Karyawan'); ?>
                                <select name="employee_id" class="form-control select2 input-lg">
                                    <?php 
                                    foreach ($employee_list as $single_employee) {
                                    ?>
                                        <option value="<?php echo $single_employee->id; ?>">
                                            <?php //echo $single_employee->customer_name; ?>  
                                             <?php echo 'Nama : '.$single_employee->customer_name.' - '.$single_employee->cus_company.' - '.$single_employee->cus_contact_2.' - '.$single_employee->cus_type.' - '.$single_employee->cus_region;

                                         ?>   
                                        </option>
                                    <?php 
                                     }
                                    ?>
                                </select>
                        </div>  

                        <div class="form-group">
                            <?php echo form_label('Jenis Transaksi Akun'); ?>
                              <select name="account_nature" class="form-control input-lg">
                                  <option value="0"> Debit </option> 
                                  <option value="1"> Kredit </option> 
                              </select>
                        </div>    
                        <div class="form-group">
                            <?php echo form_label('Jumlah'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'amount','reqiured'=>'','step'=>'.01');
                                echo form_input($data);
                            ?>
                        </div>
                                     
                        <div class="form-group">
                            <?php echo form_label('Tanggal'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date','reqiured'=>'','value'=>Date('d/m/Y'));
                                echo form_input($data);
                            ?>
                        </div>                    
                        <div class="form-group">
                            <?php echo form_label('Keterangan'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>                    
                    </div>
                        <div class="form-group">
                          <?php
                              $data = array('class'=>'btn btn-info  margin btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_balance','value'=>'true','id'=>'btn_save_transaction','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                  Simpan ');
                              echo form_button($data);
                           ?>  
                        </div>    
                  </div>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>