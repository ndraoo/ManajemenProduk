<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        $this->load->library('session');
		
    }

    public function index() {
        $data['products'] = $this->product_model->get_all_products() ?: array();
        $this->load->view('products/index', $data);
    }

    public function add() {
        $this->form_validation->set_rules('name', 'Nama product', 'required|min_length[2]');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('stock', 'Jumlah Stock', 'required|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['products'] = $this->product_model->get_all_products();
            $this->load->view('products/index', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'stock' => $this->input->post('stock'),
                'is_sell' => $this->input->post('status') === 'Sold' ? 1 : 0
            );
            $this->product_model->add($data);
            $this->session->set_flashdata('success', 'Product berhasil ditambahkan.');
            redirect('products');
        }
    }

    public function edit($id) {
        $data['product'] = $this->product_model->get_by_id($id);
        if (!$data['product']) {
            $this->session->set_flashdata('error', 'Product tidak ditemukan.');
            redirect('products');
        }
        $data['products'] = $this->product_model->get_all_products();
        $this->load->view('products/index', $data);
    }

    public function update($id) {
        $this->form_validation->set_rules('name', 'Nama Product', 'required|min_length[2]');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('stock', 'Jumlah Stock', 'required|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['product'] = $this->product_model->get_by_id($id);
            if (!$data['product']) {
                $this->session->set_flashdata('error', 'Product tidak ditemukan.');
                redirect('products');
            }
            $data['products'] = $this->product_model->get_all_products();
            $this->load->view('products/index', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'stock' => $this->input->post('stock'),
                'is_sell' => $this->input->post('status') === 'Sold' ? 1 : 0
            );
            $this->product_model->update($id, $data);
            $this->session->set_flashdata('success', 'Product berhasil diupdate.');
            redirect('products');
        }
    }

    public function delete($id) {
        $this->product_model->delete($id);
        $this->session->set_flashdata('success', 'Product berhasil dihapus.');
        redirect('products');
    }
}
