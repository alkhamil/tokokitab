<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Order_model');
        $this->load->model('Order_detail_model');
        if (!$this->userdata) {
            redirect(base_url('/'),'refresh');
        }
    }

    public function index()
    {
        $where = [];
        if ($this->input->get('order_id')) {
            $where['t_order.id'] = $this->input->get('order_id');
        }
        $data['title'] = 'Order | '.$this->userdata->name;
        $data['isi'] = 'home/order';
        $data['order'] = $this->get_order($where);
        $data['bank'] = $this->db->get('m_bank')->result_array();
        // echo json_encode($data);exit;
        $this->load->view('layout/wrapper', $data);
    }

    public function get_order($where)
    {
        $select = "
            t_order.*, 
            m_customer.name, 
            m_customer.address, 
            m_customer.province_name,
            m_customer.city_name,
            m_customer.postal_code,
        ";
        $join = [
            [
                'table' => 'm_customer',
                'on'    => 'm_customer.id = t_order.customer_id'
            ]
        ];
        $data = $this->Order_model->get($where, $select, $join);
        $row = [];
        if ($data) {
            $row['id'] = $data->id;
            $row['code'] = $data->code;
            $row['name'] = $data->name;
            $row['address'] = $data->address;
            $row['province_name'] = $data->province_name;
            $row['city_name'] = $data->city_name;
            $row['postal_code'] = $data->postal_code;
            $row['created_date'] = $data->created_date;
            $row['is_paid'] = $data->is_paid;
            $row['bukti_tf'] = $data->bukti_tf;
            $row['grand_total'] = $data->grand_total;
            $row['courier_price'] = $data->courier_price;
            $row['final_total'] = $data->final_total;
            $row['detail'] = $this->get_detail($data->id);
        }
        return $row;
    }

    public function get_detail($id)
    {
        $where['order_id'] = $id;
        $select = "
            t_order_detail.*,
            m_product.name,
            m_product.code,
        ";
        $join = [
            [
                'table' => 'm_product',
                'on' => 'm_product.id = t_order_detail.product_id',
            ]
        ];
        $data = $this->Order_detail_model->get_all($where, $select, $join);
        return $data;
    }

    public function confirm_payment()
    {   
        $bukti_tf = null;
        // bukti_tf
        if($_FILES['bukti_tf']['tmp_name']) {
            $bukti_tf_data = $this->upload_data('bukti_tf');
            if(isset($bukti_tf_data['type']) && $bukti_tf_data['type'] == 'error') {
                $msg = $bukti_tf_data;
                echo json_encode($msg);
                exit;
            }
            $bukti_tf = base_url('assets/uploads/').$bukti_tf_data['file_name'];
        }
        $this->db->trans_begin();
        $where['id'] = $this->input->post('order_id');
        $update_data['is_paid'] = 1;
        $update_data['status'] = 'sedang dalam pengecekan';

        if ($bukti_tf) {
            $update_data['bukti_tf'] = $bukti_tf;
        }
        $this->Order_model->update($update_data, $where);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response = array(
                'type' => 'error',
                'msg' => 'Gagal melakukan konfirmasi pembayaran',
            );
        }else {
            $this->db->trans_commit();
            $response = array(
                'type' => 'success',
                'msg' => 'Terimakasih sudah melakukan konfirmasi pembayaran, kami akan mengecek pesanan anda',
            );
        }
        echo json_encode($response);
    }

    public function order_received()
    {
        $this->db->trans_begin();
        $where['id'] = $this->input->get('id');
        $update_data['status'] = 'diterima';
        $this->Order_model->update($update_data, $where);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response = array(
                'type' => 'error',
                'msg' => 'Gagal melakukan konfirmasi',
            );
        }else {
            $this->db->trans_commit();
            $response = array(
                'type' => 'success',
                'msg' => 'Terimakasih sudah melakukan konfirmasi',
            );
        }
        echo json_encode($response);
    }

    public function upload_data($field_name)
    {
        $config['upload_path']          = './assets/uploads';
        $config['allowed_types']        = 'png|jpg|jpeg';
        $config['max_size']             = 2048; // 2mb

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload($field_name)) {
            $error = [
                'error' => $this->upload->display_errors()
            ];
            return [
                'type' => 'error',
                'msg' => strip_tags($error['error'])
            ];
        }else {
            return $this->upload->data();
        }
    }

}
