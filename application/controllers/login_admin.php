<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['admin'])) {
			redirect('admin');
		}else{
			$this->load->view("admin-room/login");
		}
	}

}

/* End of file login-admin.php */
/* Location: ./application/controllers/login-admin.php */