<div class="card card-custom">
    <div class="card-body">
        <div class="col-xl-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Hak Aksess</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
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
                                                <?php if ($vcrud['hk_update'] == '1') { ?>
                                                    <div class="btn-group pull pull-right">
                                                        <a class="btn btn-info btn-flat" href="<?php echo base_url(); ?>administrator/edit_hak_aksess/<?= $privileges_obj->user_id ?>"><i class="fas fa-pencil-alt"></i> Edit
                                                        </a>
                                                    </div>
                                                <?php } ?>
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
<script>
    $('#menu_id_<?= $vcrud['parent_id'] ?>').addClass('menu-item-active menu-item-open menu-item-here"')
    $('#submenu_id_<?= $vcrud['id_menulist'] ?>').addClass('menu-item-active')
</script>