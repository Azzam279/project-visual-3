<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index()
	{
		if (isset($_POST['proses'])) {
			$cari = $_POST['cari'];
			$data['cari'] = $this->model1->selectQuery2("SELECT * FROM produk WHERE nama_produk LIKE '%$cari%'");
			$data['pencarian'] = $_POST['cari'];
			$this->load->view("hasil_cari", $data);
		}else{
			redirect('/');
		}
	}

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */