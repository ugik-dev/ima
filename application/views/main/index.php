<!--begin::Body-->

<?php
if ($this->session->userdata('user_id') == "") {
    redirect('login');
} else {
    $user_id = $this->session->userdata('user_id');
    //TO AVOID USER TO ACCESS THE UNASSIGNED LINKS
    if (Authenticate_Url($user_id['id'], $this->uri->segment(1)) != NULL) {
    } else {
        redirect('profile');
    }

    $this->load->view('main/header.php'); ?>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

    <?php
    $this->load->view('main/header_mobile.php');
    $this->load->view('main/page1.php');
    $this->load->view('main/kt_quick_user.php');
    // $this->load->view('main/kt_quick_cart.php');
    // $this->load->view('main/kt_quick_panel.php');
    // $this->load->view('main/kt_chat_modal.php');
    // $this->load->view('main/kt_scrolltop.php');
    // $this->load->view('main/sticky-toolbar.php');
    $this->load->view('main/footer.php');
}
