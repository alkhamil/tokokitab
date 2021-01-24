<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Order_model');
        $this->load->model('Raja_ongkir_model');
        if (!$this->userdata) {
            redirect(base_url('/'),'refresh');
        }
    }

    public function index()
    {
        $data['title'] = 'Mitra | '.$this->userdata->name;
        $data['isi'] = 'home/mitra';
        $data['tab_home'] = base_url('mitra/tab_home');
        $data['tab_pesanan'] = base_url('mitra/tab_pesanan');
        $data['tab_profile'] = base_url('mitra/tab_profile');
        $data['tab_address'] = base_url('mitra/tab_address');

        $data['get_profile'] = base_url('mitra/get_profile');
        $this->load->view('layout/wrapper', $data);
    }

    public function tab_home()
    {
        $this->load->view('_partials/tab_home');
    }

    public function tab_pesanan()
    {
        $data['order'] = $this->Order_model->get_all(['customer_id'=>$this->userdata->id]);
        $this->load->view('_partials/tab_pesanan', $data);
    }

    public function tab_profile()
    {
        $data['update_profile'] = base_url('mitra/update_profile');
        $data['update_password'] = base_url('mitra/update_password');
        $this->load->view('_partials/tab_profile', $data);
    }

    public function tab_address()
    {
        $data['update_address'] = base_url('mitra/update_address');
        $data['select_province'] = base_url('mitra/select_province');
        $data['select_city'] = base_url('mitra/select_city');
        $this->load->view('_partials/tab_address', $data);
    }

    public function get_profile()
    {
        $where['id'] = $this->userdata->id;
        $data = $this->Auth_model->get($where);
        echo json_encode($data);
    }

    public function update_profile()
    {   
        $avatar = null;
        // avatar
        if($_FILES['avatar']['tmp_name']) {
            $avatar_data = $this->upload_data('avatar');
            if(isset($avatar_data['type']) && $avatar_data['type'] == 'failed') {
                $msg = $avatar_data;
                echo json_encode($msg);
                exit;
            }
            $avatar = base_url('assets/uploads/').$avatar_data['file_name'];
        }
        

        $this->db->trans_begin();
        $where['id'] = $this->userdata->id;
        $updatedata['name'] = $this->input->post('name', true);
        $updatedata['phone'] = $this->input->post('phone', true);
        $updatedata['birthday'] = $this->input->post('birthday', true);

        $customer = $this->Auth_model->get(['id'=>$this->userdata->id]);
        if ($avatar) {
            $avatar_path = substr($customer->avatar, strlen(base_url()));
            if (file_exists($avatar_path)) {
                unlink($avatar_path);
            }
            $updatedata['avatar'] = $avatar;
        }else {
            $updatedata['avatar'] = $customer->avatar;
        }
        
        $this->Auth_model->update($updatedata, $where);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response = array(
                'type' => 'error',
                'msg' => 'Data gagal disimpan.',
            );
        }else {
            $this->db->trans_commit();
            $response = array(
                'type' => 'success',
                'msg' => 'Data berhasil disimpan.',
            );
        }
        echo json_encode($response);
    }

    public function update_password()
    {
        $this->db->trans_begin();

        $this->form_validation->set_rules('password', 'Password', 'required',
            [
                'required' => 'Password tidak boleh kosong',
            ]
        );
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]',
            [
                'required' => 'Konfirmasi password tidak boleh kosong',
                'matches' => 'Konfirmasi password tidak sama dengan password'
            ]
        );

        $where['id'] = $this->userdata->id;
        $updatedata['password'] = password_hash($this->input->post('password', true), PASSWORD_BCRYPT);
        // echo json_encode($updatedata);exit;

        if ($this->form_validation->run()) {
            $this->Auth_model->update($updatedata, $where);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $response = array(
                    'type' => 'error',
                    'msg' => 'Data gagal disimpan.',
                );
            }else {
                $this->db->trans_commit();
                $response = array(
                    'type' => 'success',
                    'msg' => 'Data berhasil disimpan.',
                );
            }
        }else {
            $response = array(
                'type' => 'error',
                'msg' => validation_errors(),
            );
        }
        echo json_encode($response);
    }

    public function update_address()
    {
        $this->db->trans_begin();
        $where['id'] = $this->userdata->id;
        $updatedata['province_id'] = $this->input->post('province_id', true);
        $updatedata['province_name'] = $this->input->post('province_name', true);
        $updatedata['city_id'] = $this->input->post('city_id', true);
        $updatedata['city_name'] = $this->input->post('city_name', true);
        $updatedata['address'] = $this->input->post('address', true);
        $updatedata['postal_code'] = $this->input->post('postal_code', true);
        
        $this->Auth_model->update($updatedata, $where);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response = array(
                'type' => 'error',
                'msg' => 'Data gagal disimpan.',
            );
        }else {
            $this->db->trans_commit();
            $response = array(
                'type' => 'success',
                'msg' => 'Data berhasil disimpan.',
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

    public function select_province()
    {
        $data = $this->Raja_ongkir_model->province();
        echo json_encode($data);
    }

    public function select_city()
    {   
        $params = '';
        if ($this->input->get('province_id', true)) {
            $params.= 'province='.$this->input->get('province_id', true);
        }
        if ($this->input->get('city_id', true)) {
            $params.= '&id='.$this->input->get('city_id', true);
        }
        $data = $this->Raja_ongkir_model->city($params);
        echo json_encode($data);
    }
}
