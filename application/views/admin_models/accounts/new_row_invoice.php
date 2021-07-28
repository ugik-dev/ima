   <tr>
       <td>
           <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. Logam 2 btg / BN 9999 QV" />
       </td>
       <td>
           <input type="text" name="date_item[]" value="" placeholder="eg. 3 Mar sd 27 Feb" class="form-control input-lg" />
       </td>
       <td>
           <select name="satuan[]" id="satuan" class="form-control">
               <option value="bln"> bln </option>
               <option value="hari"> hari </option>
               <option value="trip"> trip </option>
               <option value="unit"> unit </option>
               <option value="pcs"> pcs </option>
           </select>
       </td>
       <td>
           <?php
            $data = array('class' => 'form-control input-lg', 'name' => 'qyt[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_total()');
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