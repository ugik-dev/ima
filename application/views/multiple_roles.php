<div class="card card-custom">
    <div class="card-body">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url(); ?>multiple_roles/popup/add_multipleroles_model')" class="btn btn-info btn-outline-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                    Tambah Hak Akses
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card card-custom">
    <div class="card-body">
        <!-- <div class="row"> -->
        <div class="col-xl-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($table_heading_names_of_coloums as $table_head) {
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
                                $counter = 1;
                                if ($privileges != NULL) {
                                    foreach ($privileges as $privileges_obj) {
                                ?>
                                        <tr>
                                            <td>
                                                <?php echo $counter; ?>
                                            </td>
                                            <td>
                                                <?php echo $privileges_obj->user_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $privileges_obj->user_email; ?>
                                            </td>
                                            <td>
                                                <?php echo $privileges_obj->user_description; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group pull pull-right">
                                                    <a class="btn btn-info btn-flat" onclick=" show_modal_page('<?php echo base_url(); ?>multiple_roles/popup/edit_multipleroles_model/<?= $privileges_obj->user_id ?> ')" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                        $counter++;
                                    }
                                } else {
                                    echo "No privileges Found";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->