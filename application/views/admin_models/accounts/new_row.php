<tr>
    <td>
        <select name="account_head[]" class="form-control select2 input-lg">
            <?php

            use function PHPSTORM_META\type;

            echo $accounts_records; ?>
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
    <td>
        <?php
        $data = array('class' => 'form-control input-lg', 'type' => 'text', 'name' => 'sub_keterangan[]', 'value' => '');
        echo form_input($data);
        ?>
    </td>
</tr>