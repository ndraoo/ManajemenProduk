<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
		$this->load->helper(['url', 'form']);
	}

    public function index() {
        $data['products'] = $this->product_model->get_all_products() ?: array();
        $this->load->view('products/index', $data);
    }

}
