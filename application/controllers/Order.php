<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Order_model');
        if (!$this->userdata) {
            redirect(base_url('/'),'refresh');
        }
    }

    public function index()
    {
        $where = [];
        if ($this->input->get('order_id')) {
            $where['id'] = $this->input->get('order_id');
        }
        $data['title'] = 'Order | '.$this->userdata->name;
        $data['isi'] = 'home/order';
        $data['order'] = $this->Order_model->get($where);
        $this->load->view('layout/wrapper', $data);
    }

}
