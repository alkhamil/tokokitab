<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->userdata) {
            redirect(base_url('/'),'refresh');
        }
    }

    public function index()
    {
        $data['title'] = 'Cart | '.$this->userdata->name;
        $data['isi'] = 'home/cart';
        $this->load->view('layout/wrapper', $data);
    }

}
