<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['kategori'] = $this->model1->selectData("kategori");
		$time = time();
		$data['produk'] = $this->model1->selectQuery2("SELECT * FROM produk INNER JOIN promo ON produk.id_promo = promo.id_promo AND promo.lama_promo > $time ORDER BY produk.no_produk DESC LIMIT 0,8");
		$this->load->view("main", $data);
	}

}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
?>