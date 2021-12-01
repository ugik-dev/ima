   <tr>
       <td>
           <input type="text" name="keterangan_item[]" value="" class="form-control input-lg" placeholder="eg. Logam 2 btg / Toyota AVZ" />
       </td>
       <td>
           <input type="text" name="nopol[]" value="" placeholder="eg. BN 1010 XX / 2018" class="form-control input-lg" />
       </td>
       <td>
           <input type="text" name="date_item[]" value="" placeholder="eg. 3 Mar sd 27 Feb" class="form-control input-lg" />
       </td>
       <td>
           <select name="satuan[]" id="satuan" class="form-control">
               <?php foreach ($satuan as $st) {
                    echo '<option value="' . $st['name_unit'] . '"> ' . $st['name_unit'] . ' </option>';
                } ?>

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