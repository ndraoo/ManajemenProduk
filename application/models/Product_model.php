<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_products() {
        $query = $this->db->get('products');
        return $query->result();
    }

    public function get_by_id($id) {
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->row();
    }

    public function add($data) {
        return $this->db->insert('products', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    public function delete($id) {
		$this->db->delete('products', array('id' => $id));
    }
}
