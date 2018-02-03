<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_finish extends CI_Controller {

	public function index()
	{
		$name = "id_customer";
		$val = $_SESSION['id_customer'];
		//mengambil data order produk berdasarkan id customer
		$this->db->order_by("id_order","DESC");
		$data['select'] = $this->model1->selectWhere("order_produk", array($name => $val));
		$this->load->view("order-finish", $data);
	}

}

/* End of file order_finish.php */
/* Location: ./application/controllers/order_finish.php */