<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->library('pagination');
        // if (!$this->userdata) {
        //     redirect(base_url('/'),'refresh');
        // }
    }

    public function index()
    {

        $config = array();
        $config['base_url'] = base_url() . "product";
        $config['total_rows'] = $this->Product_model->get_count();
        $config['per_page'] = 12;
        $config['uri_segment'] = 2;

        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $q = null;
        if ($this->input->get('q')) {
            $q = $this->input->get('q');
        }
        $where = null;
        if ($this->input->get('katalog')) {
            $where['category_id'] = $this->input->get('katalog');
        }


        $data['links'] = $this->pagination->create_links();
        $data['product'] = $this->Product_model->get_product($config['per_page'], $page, $where , $q);
        $data['category'] = $this->Category_model->get_all([]);

        
        $data['title'] = 'Daftar Product';
        $data['isi'] = 'home/product';
        $this->load->view('layout/wrapper', $data);
    }

}
