<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_model');
        $this->load->model('Invoice_detail_model');
        $this->load->model('Item_model');
    }

    public function list_invoice()
    {
        $data['title'] = 'List Invoice';
        $data['isi'] = 'invoice/list_invoice';
        $data['data'] = base_url('invoice/data');
        $data['get'] = base_url('invoice/get_data');
        $data['hapus'] = base_url('invoice/hapus');
        $data['print'] = base_url('invoice/print');
        // echo json_encode($data);exit;
        $this->load->view('layout/wrapper', $data);
    }

	public function create_invoice()
	{
        $data['title'] = 'Create Invoice';
        $data['isi'] = 'invoice/create_invoice';
        $data['simpan'] = base_url('invoice/simpan');
        $data['generate_code'] = base_url('invoice/generate_code');
        $data['select_item'] = base_url('item/select');
        $this->load->view('layout/wrapper', $data);
    }

    public function edit_invoice()
    {
        $data['title'] = 'Edit Invoice';
        $data['isi'] = 'invoice/edit_invoice';
        $data['simpan'] = base_url('invoice/simpan');
        $data['get'] = base_url('invoice/get_data');
        $data['select_item'] = base_url('item/select');
        $this->load->view('layout/wrapper', $data);
    }


    public function data()
    {
        $temp_data = [];
        $where = [];
        $no = $this->input->post('start');
        $list = $this->Invoice_model->lists(
            't_invoice.*,',
            $where, 
            $this->input->post('length'), 
            $this->input->post('start')
        );
		if($list) {
			foreach ($list as $ls) {
				$no++;
				$row = array();
                $row['no'] = $no;
				$row['code'] = $ls['code'];
				$row['subject'] = $ls['subject'];
				$row['grand_total'] = $ls['grand_total'];
				$row['issue_date'] = date('d/m/Y', strtotime($ls['issue_date']));
				$row['due_date'] = date('d/m/Y', strtotime($ls['due_date']));
				$row['id'] = $ls['id'];
	
				$temp_data[] = (object)$row;
			}
		}
		
		$data['draw'] = $this->input->post('draw');
		$data['recordsTotal'] = $this->Invoice_model->list_count($where, true);
		$data['recordsFiltered'] = $this->Invoice_model->list_count($where, true);
        $data['data'] = $temp_data;
        echo json_encode($data);
    }

    public function get_data()
    {
        $id = $this->input->get('id');
        $where['t_invoice.id'] = $id;
        $select = "t_invoice.*";
        $invoice = $this->Invoice_model->get($where, $select);

        // echo json_encode($selling);exit;

        if ($invoice) {
            $row = array();
            $row['code'] = $invoice->code;
            $row['subject'] = $invoice->subject;
            $row['from'] = $invoice->from;
            $row['to'] = $invoice->to;
            $row['grand_total'] = $invoice->grand_total;
            $row['issue_date'] = date('Y-m-d', strtotime($invoice->issue_date));
            $row['due_date'] = date('Y-m-d', strtotime($invoice->due_date));
            $row['detail'] = $this->get_invoice_detail($invoice->id);
            $row['id'] = $invoice->id;
        }

        $data['invoice'] = (object)$row;
        echo json_encode($data);
    }



    public function simpan()
    {
        $savedata['code'] = $this->input->post('code', TRUE);
        $savedata['subject'] = $this->input->post('subject', TRUE);
        $savedata['from'] = $this->input->post('from', TRUE);
        $savedata['to'] = $this->input->post('to', TRUE);
        $savedata['grand_total'] = $this->input->post('grand_total', TRUE);
        $savedata['issue_date'] = $this->input->post('issue_date', TRUE);
        $savedata['due_date'] = $this->input->post('due_date', TRUE);
        
        // echo json_encode($savedata);exit;
        $invoice_detail = json_decode($this->input->post('invoice_detail', TRUE));

        
        $this->db->trans_begin();
        if($this->input->post('id')) { 
            // edit
            $invoice_id = $this->input->post('id', TRUE);
            $where['id'] = $invoice_id;
            $this->Invoice_model->update($savedata, $where);
            $this->Invoice_detail_model->delete(['invoice_id'=>$invoice_id]);

            if ($invoice_id) {
                foreach ($invoice_detail as $key => $sd) {
                    // insert detail
                    $savedata_detail['invoice_id'] = $invoice_id;
                    $savedata_detail['item_id'] = $sd->item_id;
                    $savedata_detail['desc'] = $sd->desc;
                    $savedata_detail['qty'] = $sd->qty;
                    $savedata_detail['unit_price'] = $sd->unit_price;
                    $savedata_detail['amount'] = $sd->amount;
                    $this->Invoice_detail_model->insert($savedata_detail);
                }
            }

        } else { 
            //create
            $invoice_id = $this->Invoice_model->insert($savedata, true);
            if ($invoice_id) {
                foreach ($invoice_detail as $key => $sd) {
                    // insert detail
                    $savedata_detail['invoice_id'] = $invoice_id;
                    $savedata_detail['item_id'] = $sd->item_id;
                    $savedata_detail['desc'] = $sd->desc;
                    $savedata_detail['qty'] = $sd->qty;
                    $savedata_detail['unit_price'] = $sd->unit_price;
                    $savedata_detail['amount'] = $sd->amount;
                    $this->Invoice_detail_model->insert($savedata_detail);
                }
            }
        }

        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $msg = array(
                'type' => 'error',
                'msg' => 'Data not found',
            );
        }else {
            $this->db->trans_commit();
            $msg = array(
                'type' => 'success',
                'msg' => ($this->input->post('id')) ? 'Data has been updated' : 'Data has been added',
            );
        }
        $this->session->set_flashdata('msg', $msg);

        redirect(base_url('invoice/list_invoice'), 'refresh');
    }

    public function hapus()
    {
        $where['id'] = $this->input->get('id', TRUE);
        $this->db->trans_begin();
        $this->Invoice_model->delete($where);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $msg = array(
                'type' => 'error',
                'msg' => 'Data not found',
            );
        }else{
            $this->db->trans_commit();
            $msg = array(
                'type' => 'success',
                'msg' => 'Data has been deleted',
            );
        }
        echo json_encode($msg);
    }

    public function print()
    {
        $id = $this->input->get('id');
        $where['t_invoice.id'] = $id;
        $select = "t_invoice.*";
        $invoice = $this->Invoice_model->get($where, $select);

        // echo json_encode($selling);exit;

        if ($invoice) {
            $row = array();
            $row['code'] = $invoice->code;
            $row['subject'] = $invoice->subject;
            $row['from'] = $invoice->from;
            $row['to'] = $invoice->to;
            $row['grand_total'] = $invoice->grand_total;
            $row['issue_date'] = date('d/m/Y', strtotime($invoice->issue_date));
            $row['due_date'] = date('d/m/Y', strtotime($invoice->due_date));
            $row['detail'] = $this->get_invoice_detail($invoice->id);
            $row['id'] = $invoice->id;
        }

        $data['title'] = (isset($invoice->code)) ? $invoice->code : '';
        $data['invoice'] = (object)$row;
        $this->load->library('pdf');

    
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->filename = $data['title'];
        $this->pdf->load_view('invoice/print', $data);
    }

    public function get_invoice_detail($invoice_id)
    {
        $where['t_invoice_detail.invoice_id'] = $invoice_id;
        $select = "
                    t_invoice_detail.*, 
                    m_item.desc as item_desc,
                    m_item.type as item_type,
                ";
        $join = [
            [
                'table' => 'm_item',
                'on'    => 'm_item.id = t_invoice_detail.item_id'
            ],
        ];
        $invoice_detail = $this->Invoice_detail_model->get_all($where, $select, $join);
        return $invoice_detail;
    }

    public function generate_code()
    {
        $tahun = $this->db->order_by('id', 'desc')->limit(1)->get('t_invoice')->row_array();
        if ($tahun) {
            $tahun = date('Y', strtotime($tahun['issue_date']));
            if ($tahun != date('Y')) {
                $code = 0;
            }else{
                $code = count($this->db->get('t_invoice')->result_array());
            }
        }else{
            $code = count($this->db->get('t_invoice')->result_array());
        }
        $result = str_pad($code + 1, 4, "0", STR_PAD_LEFT);
        echo json_encode($result);
    }

}
