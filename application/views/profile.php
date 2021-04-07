<div class="content-wrapper">
    <section class="content-header">
         <h4  class="purchase-heading text-center" >
            <i class="fa fa-user" aria-hidden="true"></i>  
            PROFIL PENGGUNA
            <small>Informasi Pengguna Sistem</small>
        </h4>
    </section>
        <?php
         if($User_profile != NULL)
         {
        ?>
        <section class="content">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <span onclick="show_modal_page('<?php echo base_url();?>profile/popup/picture_model')">
                            <?php echo img(array('width'=>'40','height'=>'40','class'=>'profile-user-img img-responsive img-circle','alt'=>'<?php echo $User_profile[0]->user_name; ?>','src'=>'uploads/users/'.$User_profile[0]->cus_picture)); ?>

                                <h3 class="profile-user_name text-center"><?php echo $User_profile[0]->user_name; ?></h3>
                            </span>    
                        </div>
                        <div class="box-body box-profile ">
							<!---#passwordModel -->
                            <p class="text-center passwordset " onclick="show_modal_page('<?php echo base_url();?>profile/popup/password_model')" >    
							   <i class="fa fa-key" aria-hidden="true" /></i><u> Ubah Kata Sandi </u> </p>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tentang Saya</h3>
                        </div>
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> Email</strong>
                            <p class="text-muted">
                                <?php echo $User_profile[0]->user_email; ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                            <p class="text-muted">
                                <?php echo $User_profile[0]->user_address; ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Kontak 1</strong>
                            <p class="text-muted">
                                <?php echo $User_profile[0]->user_contact_1; ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Kontak 2 </strong>
                            <p class="text-muted">
                                <?php echo $User_profile[0]->user_contact_2; ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Tanggal Bergabung</strong>

                            <p class="text-muted">
                                <?php echo $User_profile[0]->user_date; ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Deskripsi </strong>

                            <p class="text-muted">
                                <?php echo $User_profile[0]->user_description; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </section>
        <?php
            }
        ?>
</div>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 