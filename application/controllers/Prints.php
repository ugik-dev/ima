<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class Prints extends CI_Controller
{
    // Statements
    //USED TO GENERATE GENERAL JOURNAL 
    public function single_jurnal()
    {
        // echo $this->input->get()['id'];
        $this->load->model('Prints_model');
        echo         $this->Prints_model->single_jurnal($this->input->get()['id']);
    }
}
