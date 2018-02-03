<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (empty($_SESSION['admin'])) {
			redirect('/');
			exit();
		}
	}

	public function index()
	{
		redirect('/');
	}

	public function nota_servis($id)
	{
		if (empty($id)) {
			redirect('admin/servis');
		}else{
			$data['cetak'] = $this->model1->selectWhere("servis", array("id_servis" => $id));
			$this->load->view("admin-room/print-nota", $data);
		}
	}

}

/* End of file print.php */
/* Location: ./application/controllers/print.php */