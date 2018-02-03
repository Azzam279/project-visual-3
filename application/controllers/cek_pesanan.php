<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_pesanan extends CI_Controller {

	public function index()
	{
		redirect('/');
	}

	public function cek($nmr)
	{
		if (empty($nmr)) {
			redirect('/');
		}else{
			$data['cek'] = $this->model1->selectWhere("order_produk", array("id_order" => $nmr));
			$this->load->view("pesanan_saya", $data);
		}
	}

}

/* End of file cek_pesanan.php */
/* Location: ./application/controllers/cek_pesanan.php */