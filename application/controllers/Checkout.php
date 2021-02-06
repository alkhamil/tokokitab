<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

    public $origin;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->model('Customer_model');
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->model('Order_detail_model');
        $this->load->model('Raja_ongkir_model');
        $origin = $this->db->get_where('m_config', ['key'=>'ORIGIN'])->row_array();
        $this->origin = ($origin) ? $origin['value'] : '';
        if (!$this->userdata) {
            redirect(base_url('/'),'refresh');
        }
    }

    public function index()
    {
        $data['title'] = 'Checkout | '.$this->userdata->name;
        $data['isi'] = 'home/checkout';
        $data['customer'] = $this->get_customer();
        $this->load->view('layout/wrapper', $data);
    }

    public function payment_proses()
    {
        $this->db->trans_begin();
        $cart = $this->Cart_model->get_all(['customer_id'=>$this->userdata->id]);
        if ($cart) {
            $grand_total = 0;
            $supplier_total = 0;
            foreach ($cart as $key => $c) {
                $grand_total+=$c['total_price'];
                $supplier_total+=$c['supplier_price']*$c['qty'];
            }
            $savedata['customer_id'] = $this->userdata->id;
            $savedata['code'] = 'TRX'.time();
            $savedata['courier_name'] = $this->input->post('courier_name', true);
            $savedata['courier_price'] = $this->input->post('courier_price', true);
            $savedata['supplier_total'] = $supplier_total;
            $savedata['grand_total'] = $grand_total;
            $savedata['profit'] = $grand_total - $supplier_total;
            $savedata['final_total'] = $savedata['courier_price'] + $grand_total;
            $savedata['created_date'] = date('Y-m-d H:i:s');

            // echo json_encode($savedata);exit;

            $order_id = $this->Order_model->insert($savedata, true);
            if ($order_id) {
                foreach ($cart as $key => $item) {
                    $savedata_detail['order_id'] = $order_id;
                    $savedata_detail['product_id'] = $item['product_id'];
                    $savedata_detail['qty'] = $item['qty'];
                    $savedata_detail['weight'] = $item['weight'];
                    $savedata_detail['supplier_price'] = $item['supplier_price'];
                    $savedata_detail['final_price'] = $item['final_price'];
                    $savedata_detail['total_price'] = $item['total_price'];
                    $this->Order_detail_model->insert($savedata_detail);

                    // hapus cart
                    $this->Cart_model->delete(['customer_id'=>$this->userdata->id]);
                }
            }
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $response = array(
                    'type' => 'error',
                    'msg' => 'Gagal melanjutkan pembayaran',
                );
            }else {
                $this->db->trans_commit();
                $response = array(
                    'type' => 'success',
                    'msg' => 'Silahkan lakukan transfer untuk melanjutkan pesanan anda',
                    'order_id' => $order_id
                );
            }
        }else {
            $response = array(
                'type' => 'error',
                'msg' => 'Cart tidak ditemukan',
            );
        }
        
        echo json_encode($response);
    }

    public function get_customer()
    {
        $where['id'] = $this->userdata->id;
        $customer = $this->Customer_model->get($where);
        return $customer;
    }

    public function get_cost()
    {
        $courier = $this->input->get('courier');
        $data = $this->get_cost_courier($courier);
        echo $data;
    }

    public function get_cost_courier($courier)
    {
        $params = "origin=".$this->origin."&destination=".$this->get_customer()->city_id."&weight=".$this->get_weight()."&courier=".$courier."";
        return $this->Raja_ongkir_model->cost($params);
    }

    public function get_weight()
    {
        $where['customer_id'] = $this->userdata->id;
        $cart = $this->Cart_model->get_all($where);
        $weight = 0;
        foreach ($cart as $key => $c) {
            $weight+=$c['weight'];
        }
        return (int)$weight;
    }

}
