<?php
/*

*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Format extends CI_Controller
{
    //Backup
    public function index()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Format Transaksi';

        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'format_transaksi';

        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }

    
}