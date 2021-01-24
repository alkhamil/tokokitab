<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function auth()
    {
        $type = $this->input->post('type', true);
        if ($type == 'daftar') {
            $savedata['name'] = $this->input->post('name', true);
            $savedata['email'] = $this->input->post('email', true);
            $savedata['password'] = password_hash($this->input->post('password', true), PASSWORD_BCRYPT);
            $savedata['phone'] = $this->input->post('phone', true);
            $savedata['type'] = 'mitra';
            $savedata['created_date'] = date('Y-m-d H:i:s');
            $this->daftar($savedata);
        }else{
            $data['email'] = $this->input->post('email', true);
            $data['password'] = $this->input->post('password', true);
            $this->login($data);
        }
    }

    public function daftar($savedata)
    {
        $this->db->trans_begin();
        $this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[m_customer.email]',
            array(
                'valid_email' => 'Format email tidak benar!',
                'is_unique' => 'Email sudah pernah digunakan'
            ),
        );

        if ($this->form_validation->run()) {
            $id = $this->Auth_model->insert($savedata, true);
            // email send
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

    public function login($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $where['email'] = $email;
        $user = $this->Auth_model->get($where);
        if ($user) {
            if (password_verify($password, $user->password)) {
                $this->session->set_userdata('userdata', $user);
                $response = array(
                    'type' => 'success',
                    'msg' => 'Login berhasil',
                );
            }else{
                $response = array(
                    'type' => 'error',
                    'msg' => 'Password tidak cocok.',
                );
            }
        }else{
            $response = array(
                'type' => 'error',
                'msg' => 'User tidak ditemukan.',
            );
        }
        echo json_encode($response);
    }

    public function logout()
    {
        $this->session->unset_userdata('userdata');
        redirect(base_url('/'),'refresh');
    }

}
