<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index()
	{
		if (isset($_GET['ajax'])) {
			$data = array(
				"id_kontak" => null,
				"nama" => trim($_POST['name']),
				"email" => $_POST['email'],
				"subjek" => trim($_POST['subject']),
				"pesan" => htmlentities($_POST['message']),
				"tgl" => time()
				);
			$sql = $this->model1->insertData("kontak", $data);
			if ($sql == 1) {
				echo "<div class='alert alert-success' id='alert-slideUp'><b>Pesan terkirim!</b></div>";
			}else{
				echo "<div class='alert alert-danger' id='alert-slideUp'><b>Pesan gagal terkirim!</b></div>";
			}
		}else{
			redirect('/');
		}
	}

}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */