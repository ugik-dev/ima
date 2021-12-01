 <ul class="search_result">
     <li onclick="close_search_result()" class="cross_search_result"><i class="fa fa-times" aria-hidden="true"></i></li>
     <?php
        if ($search_result != NULL) {
            foreach ($search_result as $single_item) {
        ?>
             <li onclick="add_search_item_invoice('<?php echo $single_item->id; ?>')"><?php echo $single_item->product_name . ' | ' . $single_item->default_price  ?>
             </li>
     <?php
            }
        } else {
            echo '<p class="text-center">' . 'No result found' . '</p>';
        }
        ?>
 </ul>