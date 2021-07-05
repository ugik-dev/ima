<!-- <section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section> -->
<div class="card card-custom position-relative overflow-hidden">
    <!--begin::Shape-->
    <div class="container">
        <div class="make-container-center">
            <?php
            $attributes = array('id' => 'close_book', 'method' => 'get', 'class' => '');
            ?>
            <?php echo form_open_multipart('statements/tree_laporan_neraca', $attributes); ?>
            <div class="row no-print">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <?php echo form_label('Tahun'); ?>
                        <select class="form-control input-lg" name="tahun" id="tahun">
                            <!-- <option value="2011"> 2011</option>
                            <option value="2012"> 2012</option>
                            <option value="2013"> 2013</option>
                            <option value="2014"> 2014</option>
                            <option value="2015"> 2015</option>
                            <option value="2016"> 2016</option>
                            <option value="2017"> 2017</option>
                            <option value="2018"> 2018</option>
                            <option value="2019"> 2019</option>
                            <option value="2020"> 2020</option> -->
                            <option value="2021"> 2021</option>
                            <option value="2022"> 2022</option>
                            <option value="2023"> 2023</option>
                            <option value="2024"> 2024</option>
                            <option value="2025"> 2025</option>
                            <option value="2026"> 2026</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group" style="margin-top:16px;">
                        <?php
                        $data = array('class' => 'btn btn-info btn-flat margin btn-lg pull-right ', 'type' => 'submit', 'name' => 'btn_submit_customer', 'value' => 'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Tutup Buku');
                        echo form_button($data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!-- </section> -->
    <script>
        $('#menu_id_23').addClass('menu-item-active menu-item-open menu-item-here"')
        $('#submenu_id_86').addClass('menu-item-active')
        form_closing = $('#close_book')
        form_closing.submit(function(event) {
            event.preventDefault();
            val = $('#tahun').val();
            Swal.fire({
                title: 'Anda yakin akan menutup buku tahun ' + val + ' ? <br><br> Setelah ditutup data tidak dapat dirubah atau dihapus!',
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Ya Yakin Tutup Buku !`,
                // denyButtonText: `Don't save`,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Data Closing .. ', // add html attribute if you want or remove
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                    var url = "<?= base_url('statements/close_process') ?>";
                    $.ajax({
                        url: url,
                        'type': 'POST',
                        data: form_closing.serialize(),
                        success: function(data) {
                            // buttonIdle(button);
                            var json = JSON.parse(data);
                            if (json['error']) {
                                // 
                                Swal.fire({
                                    text: json['message'],
                                    icon: "error",
                                    buttonsStyling: true,
                                    confirmButtonText: "Ok!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary",
                                    },
                                })
                                // swal("Simpan Gagal", json['message'], "error");
                                return;
                            }
                            var res_data = json['data']
                            Swal.fire({
                                text: 'Closed Success',
                                icon: "success",
                                buttonsStyling: true,
                                confirmButtonText: "Ok!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary",
                                },
                            })
                        },
                        error: function(e) {}
                    });
                }
            })
        })
    </script>

    <!-- Bootstrap model  -->
    <?php $this->load->view('bootstrap_model.php'); ?>
    <!-- Bootstrap model  ends-->