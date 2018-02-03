<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jasa_servis extends CI_Controller {

	public function index()
	{
		$data['servis'] = $this->model1->selectData("servis");

		$this->load->view("jasa-servis", $data);
	}

}

/* End of file jasa_servis.php */
/* Location: ./application/controllers/jasa_servis.php */