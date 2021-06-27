<div class="card card-custom">
    <div class="card-body">

        <div class="row">
            <div class="col-lg-12">
                <form opd="form" id="dokumen_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_dokumen" name="id_dokumen">
                    <div class="form-group">
                        <label for="nama_dokumen">Nama Dokumen</label>
                        <h5 class="form-control" id="nama_dokumen" name="nama_dokumen"><?= $dataContent['nama_dokumen'] ?> </h5>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="id_jenis_dokumen">Jenis Dokumen</label>
                            <h5 class="form-control" id="nama_dokumen" name="nama_dokumen"><?= $dataContent['nama_jenis_dokumen'] ?> </h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="id_jenis_dokumen">Mulai Masa Aktif</label>
                            <h5 class="form-control" id="nama_dokumen" name="nama_dokumen"><?= $dataContent['date_start'] ?> </h5>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="id_jenis_dokumen">Akhir Masa Aktif</label>
                            <h5 class="form-control" id="nama_dokumen" name="nama_dokumen"><?= $dataContent['date_end'] ? $dataContent['date_end'] : ''  ?> </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Notifikasi</label>
                                <h5 class="form-control" id="nama_dokumen" name="nama_dokumen"><?= $dataContent['notification'] == '1bulan' ? '1 Bulan' : 'Disabled'  ?> </h5>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Keterangan / Deskripsi</label>
                                <textarea readonly='readonly' rows="3" placeholder="" class="form-control" id="deskripsi" name="deskripsi"><?= $dataContent['deskripsi'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_jenis_dokumen">File</label>
                        <br>
                        <?php if (!empty($dataContent['file_dokumen'])) {
                            // echo base_url() . "uploads/file_dokumen/" . $dataContent['file_dokumen'] . '<br>';
                            if (file_exists(FCPATH . "uploads/file_dokumen/" . $dataContent['file_dokumen'])) {
                                $format = explode('.', $dataContent['file_dokumen']);
                                if ($format[1] == 'pdf') {
                                    echo '<iframe style="width : 100%; height : 600px" id="iframepdf" src="' . base_url() . "uploads/file_dokumen/" . $dataContent['file_dokumen'] . '"></iframe>';
                                } else if ($format[1] == 'jpg' || $format[1] == 'jpeg' || $format[1] == 'png') {
                                    echo '<img style="width : 100%; height : auto" id="" src="' . base_url() . "uploads/file_dokumen/" . $dataContent['file_dokumen'] . '"></img>';
                                }
                                echo '<a  download="' . $dataContent['nama_dokumen'] . '" class="btn btn-success my-1 mr-sm-2" href="' . base_url() . "uploads/file_dokumen/" . $dataContent['file_dokumen'] . '"><i class="fas fa-download"></i><strong>Download Dokument</strong></a>';
                                // echo 'file axis';
                                // <iframe id="iframepdf" src="files/example.pdf"></iframe>
                            } else {
                                echo 'File Tidak ditemukan';
                            }
                        } else {
                            echo 'Tidak tersedia !!.';
                        } ?>

                    </div>


                </form>

            </div>
        </div>
    </div>
</div>