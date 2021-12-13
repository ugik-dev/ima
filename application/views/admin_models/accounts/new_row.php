<tr>
    <td>
        <select name="account_head[]" class="form-control select2 input-lg">
            <option value=""> ---------------------------------------------------- </option>
            <?php

            use function PHPSTORM_META\type;

            foreach ($accounts_records as $lv1) {
                // echo '<optgroup label="[' . $lv1['head_number'] . '] ' . $lv1['name'] . '">';
                foreach ($lv1['children'] as $lv2) {
                    echo '<optgroup label="&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '] ' . $lv2['name'] . '">';
                    foreach ($lv2['children'] as $lv3) {
                        if (empty($lv3['children'])) {
                            echo '<option value="' . $lv3['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '';
                            echo '</option>';
                        } else {
                            echo '<optgroup label="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '] ' . $lv3['name'] . '">';
                            foreach ($lv3['children'] as $lv4) {
                                echo '<option value="' . $lv4['id_head'] . '">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp [' . $lv1['head_number'] . '.' . $lv2['head_number'] . '.' . $lv3['head_number'] . '.' . $lv4['head_number']  . '] ' . $lv4['name'] . '';
                                echo '</option>';
                            }
                            echo '</optgroup>';
                        }
                    }
                    echo '</optgroup>';
                }
            } ?>
        </select>
    </td>
    <td>
        <?php
        $data = array('class' => 'form-control input-lg mask', 'name' => 'debitamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_debits()');
        echo form_input($data);
        ?>
    </td>
    <td>
        <?php
        $data = array('class' => 'form-control input-lg mask', 'name' => 'creditamount[]', 'value' => '', 'reqiured' => '', 'onkeyup' => 'count_credits()');
        echo form_input($data);
        ?>
    </td>

</tr>
<tr>
    <td colspan="3">
        <?php
        $data = array('class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'keterangan', 'name' => 'sub_keterangan[]', 'value' => '');
        echo form_input($data);
        ?>
        </tdc>
</tr>