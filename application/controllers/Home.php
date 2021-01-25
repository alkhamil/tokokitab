<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Banner_model');
        $this->load->model('Cart_model');
    }

    public function index()
    {
        $data['title'] = 'Toko Kitab H. Uding';
        $data['isi'] = 'home/index';
        $data['product'] = $this->get_product([]);
        $data['banner'] = $this->get_banner();

        $data['add_cart'] = base_url('home/add_cart');
        $data['get_cart'] = base_url('home/get_cart');

        $data['daftar_modal'] = base_url('home/daftar_modal');
        $data['login_modal'] = base_url('home/login_modal');
        $this->load->view('layout/wrapper', $data);
    }

    public function get_product($where = [])
    {
        $product = $this->Product_model->get_all($where);
        return $product;
    }

    public function get_banner()
    {
        $where = [];
        $banner = $this->Banner_model->get_all($where);
        return $banner;
    }

    public function add_cart()
    {
        $this->db->trans_begin();
        $where['id'] = $this->input->get('product_id');
        $product = $this->Product_model->get($where);
        if ($product) {
            $wherecart = [
                'customer_id'=>$this->userdata->id,
                'product_id'=>$product->id
            ];
            $cart = $this->Cart_model->get($wherecart);
            if ($cart) {
                $updatedata['qty'] = 1 + $cart->qty;
                $updatedata['total_price'] = $updatedata['qty'] * $cart->final_price;
                $this->Cart_model->update($updatedata, $wherecart);
            }else{
                $savedata['customer_id'] = $this->userdata->id;
                $savedata['product_id'] = $product->id;
                $savedata['qty'] = 1;
                $savedata['final_price'] = $product->final_price;
                $savedata['weight'] = $product->weight;
                $savedata['total_price'] = $savedata['qty'] * $product->final_price;
                $this->Cart_model->insert($savedata);
            }
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $response = array(
                    'type' => 'error',
                    'msg' => 'Gagal ditambahkan ke keranjang',
                );
            }else {
                $this->db->trans_commit();
                $response = array(
                    'type' => 'success',
                    'msg' => 'Berhasil ditambahkan ke keranjang',
                );
            }
        }else{
            $response['type'] = 'error';
            $response['msg'] = 'Produk tidak ditemukan';
        }
        echo json_encode($response);
    }

    public function update_cart()
    {
        $this->db->trans_begin();
        
        $where['id'] = $this->input->get('id');
        $cart = $this->Cart_model->get($where);
        if ($cart) {
            $updatedata['qty'] = $this->input->get('qty');
            $updatedata['total_price'] = $updatedata['qty'] * $cart->final_price;
            $this->Cart_model->update($updatedata, $where);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $response = array(
                    'type' => 'error',
                    'msg' => 'Perubahan quantity gagal',
                );
            }else {
                $this->db->trans_commit();
                $response = array(
                    'type' => 'success',
                    'msg' => 'Perubahan quantity berhasil',
                );
            }
        }else{
            $response = array(
                'type' => 'error',
                'msg' => 'Cart tidak ditemukan',
            );
        }
        
        echo json_encode($response);
    }

    public function delete_cart()
    {
        $this->db->trans_begin();
        
        $where['id'] = $this->input->get('id');
        $cart = $this->Cart_model->get($where);
        if ($cart) {
            $this->Cart_model->delete($where);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $response = array(
                    'type' => 'error',
                    'msg' => 'Gagal menghapus item',
                );
            }else {
                $this->db->trans_commit();
                $response = array(
                    'type' => 'success',
                    'msg' => 'Berhasil menghapus item',
                );
            }
        }else{
            $response = array(
                'type' => 'error',
                'msg' => 'Cart tidak ditemukan',
            );
        }
        
        echo json_encode($response);
    }

    public function get_cart()
    {
        $where['customer_id'] = $this->userdata->id;
        $select = "t_cart.*, m_product.image, m_product.name, m_product.code, m_product.desc";
        $join = [
            [
                'table' => 'm_product',
                'on'    => 'm_product.id = t_cart.product_id'
            ]
        ];
        $cart = $this->Cart_model->get_all($where, $select, $join);
        echo json_encode($cart);
    }

    public function daftar_modal()
    {
        $this->load->view('_partials/daftar_modal');
    }

    public function login_modal()
    {
        $this->load->view('_partials/login_modal');
    }

}
