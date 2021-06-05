   <tr>
       <td>
           <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. BN 9999 QV" />
       </td>
       <td>
           <select name="satuan[]" id="satuan" class="form-control">
               <option value="unit"> unit </option>
               <option value="bln"> bln </option>
               <option value="hari"> hari </option>
           </select>
       </td>
       <td>
           <?php
            $data = array('class' => 'form-control input-lg', 'name' => 'qyt[]', 'value' => '1', 'reqiured' => '', 'onkeyup' => 'count_total()');
            echo form_input($data);
            ?>
       </td>
       <td>
           <?php
            $data = array('class' => 'form-control input-lg mask',  'name' => 'amount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_total()');
            echo form_input($data);
            ?>
       </td>
       <td>
           <?php
            $data = array('name' => 'qyt_amount[]', 'value' => '0', 'disabled' => 'disabled', 'class' => 'accounts_total_amount', 'reqiured' => '');
            echo form_input($data);
            ?>

       </td>
   </tr>