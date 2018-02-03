<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function index($path,$dir)
	{
		if (empty($path)) {
			redirect('/');
		}else{
			$this->load->view("$path/$dir");
		}
	}

	public function datatables($path,$dir1,$dir2)
	{
		if (empty($path)) {
			redirect('/');
		}else{
			$this->load->view("$path/$dir1/$dir2");
		}
	}
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */