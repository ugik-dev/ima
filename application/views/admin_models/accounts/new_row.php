<tr>
   <td >
        <select name="account_head[]" class="form-control select2 input-lg">
            <?php echo $accounts_records; ?>
        </select>
   </td>
   <td>
   </td> 
   <td>
        <?php
            $data = array('class'=>'form-control input-lg','step'=>'.01','type'=>'number','name'=>'debitamount[]','value'=>'','reqiured'=>'','onkeyup'=>'count_debits()');
            echo form_input($data);
        ?>
   </td> 
   <td>
        <?php
            $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'creditamount[]','step'=>'.01','value'=>'','reqiured'=>'','onkeyup'=>'count_credits()');
            echo form_input($data);
        ?>
   </td>
</tr>