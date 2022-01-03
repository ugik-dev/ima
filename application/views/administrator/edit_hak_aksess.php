<div class="card card-custom">
    <!-- <div class="row"> -->
    <div class="card-body">
        <div class="col-xl-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Hak Aksess</h3>
                </div>
                <div class="box-body">
                    <?php
                    $attributes = array('id' => 'multiple_roles_form', 'method' => 'post', 'class' => 'form-horizontal');
                    ?>
                    <form opd="form" id="role_form" onsubmit="return false;" type="multipart" autocomplete="off">
                        <div hidden class="form-group col-lg-12">
                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                            <input type="hidden" name="selected_value" id="selected_value" value="">

                        </div>
                        <!-- NEW -->
                        <hr />
                        <div class="row">
                            <div id="jstree1">
                                <div id="kt_tree_3" class="tree-demo"></div>
                            </div>
                        </div>
                        <!-- END NEW -->
                        <hr />
                        <div class="form-group">
                            <?php
                            $data = array('class' => 'btn btn-info btn-outline-primary', 'type' => 'submit', 'name' => 'btn_submit_category', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Perbarui Hak Akses');
                            echo form_button($data);
                            ?>

                        </div>
                        <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <style>
    .custom_row ul {
        /* background-color: red !important; */
        /* display: inline !important; */
        display: flex !important;

        list-style: block !important;
        /* width: 100px !important; */

    }

    .custom_row ul div {
        /* background-color: black !important; */
        /* display: inline !important; */
        display: flex !important;

        list-style: block !important;
        /* width: 100px !important; */

    }

    .custom_row .jstree-wholerow-clicked {
        /* background-color: red !important; */
        /* display: inline !important; */
        display: flex !important;

        list-style: block !important;
        width: 100px !important;

    }
</style> -->
<script type="text/javascript">
    var data = <?= json_encode($result_roles) ?>;

    $('#kt_tree_3').jstree({
        "plugins": ["wholerow", "checkbox", "types"],
        "checkbox": {
            "keep_selected_style": false,
            "cascade_to_disabled": true
        },
        "core": {
            "themes": {
                "responsive": false
            },
            "data": data
        },
        "types": {
            "default": {
                "icon": "fa fa-folder text-warning"
            },
            "file": {
                "icon": "fa fa-file  text-warning"
            }
        },
    });
    var selected_value = $('#selected_value');
    var form = $('#role_form');
    $('#kt_tree_3').on("changed.jstree", function(e, data) {
        console.log(data.selected);
        selected_value.val(data.selected)
    });

    var swalSaveConfigure = {
        title: "Konfirmasi simpan",
        text: "Yakin akan menyimpan data ini?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#18a689",
        confirmButtonText: "Ya, Simpan!",
    };
    form.submit(function(event) {
        var checked_ids = [];

        event.preventDefault();
        var url = "<?= base_url('Administrator/hak_aksess_update') ?>";

        Swal.fire({
            title: "Are you sure?",
            text: "You wont be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            // if (!result.value) {
            //     return;
            // }
            // buttonLoading(button);
            $.ajax({
                url: url,
                'type': 'POST',
                data: form.serialize(),
                success: function(data) {
                    // buttonIdle(button);
                    var json = JSON.parse(data);
                    // if (json['error']) {
                    //     swal("Simpan Gagal", json['message'], "error");
                    //     return;
                    // }
                    // var user = json['data']
                    // dataUser[user['id_user']] = user;
                    // swal("Simpan Berhasil", "", "success");
                    // renderUser(dataUser);
                    window.location = '<?= base_url() ?>administrator/hak_aksess';

                    // UserModal.self.modal('hide');
                },
                error: function(e) {}
            });
        });
    });
</script>