<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		redirect('/');
	}

	public function p($no,$title)
	{
		if (empty($no) || empty($title)) {
			redirect('/');
		}
		$where = array("id_promo" => $no);
		$promo = $this->model1->selectWhere("promo", $where);
		$data['promo'] = $promo->result()[0];
		$data['sql_promo'] = $this->model1->selectWhere("produk", $where);
		$this->load->view("promo", $data);
	}

}

/* End of file promo.php */
/* Location: ./application/controllers/promo.php */