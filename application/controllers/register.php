<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (isset($_SESSION['id_customer'])) {
			redirect('/');
		}
	}

	public function index()
	{
		$this->load->view("daftar");
	}

	public function proses_register()
	{
		if ($this->input->post("daftar")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', 'Nama harus di isi.');
				redirect('register');
				exit();
			}else if (empty($this->input->post("email"))) {
				$this->session->set_flashdata('peringatan', 'Email harus di isi.');
				redirect('register');
				exit();
			}else if (empty($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', 'Password harus di isi.');
				redirect('register');
				exit();
			}else if (empty($this->input->post("jkl"))) {
				$this->session->set_flashdata('peringatan', 'Jenis kelamin harus di isi.');
				redirect('register');
				exit();
			}else if (preg_match("/[^a-zA-Z ]/",$this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', 'Nama harus berupa Alfabet.');
				redirect('register');
				exit();
			}else if (!filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
				$this->session->set_flashdata('peringatan', 'Email tidak valid.');
				redirect('register');
				exit();
			}else if (!ctype_alnum($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', 'Password hanya boleh berupa karakter Alfanumerik.');
				redirect('register');
				exit();
			}else if ($this->input->post("pass") != $this->input->post("pass2")) {
				$this->session->set_flashdata('peringatan', 'Password tidak sama! ketik ulang password.');
				redirect('register');
				exit();
			}else{
				//mengambil data email dari table customer
				$select = $this->model1->selectWhere("customer", array("email" => $this->input->post("email")));
				//jika email sudah terdaftar, maka hentikan proses
				if ($select->num_rows() > 0) {
					$this->session->set_flashdata('peringatan', 'Email sudah terdaftar! Gunakan Email lain.');
					redirect('register');
					exit();
				}

				//membuat kode karakter alfanumerik
				$codelength = 25;
				$newcode_length = 0;
				while($newcode_length < $codelength){
					$x = 1;
					$y = 3;
					$part = rand($x,$y);
					if($part==1){$a=48; $b=57;}
					if($part==2){$a=65; $b=90;}
					if($part==3){$a=97; $b=122;}
					$code_part = chr(rand($a,$b));
					$newcode_length = $newcode_length + 1;
					@$newcode = $newcode.$code_part;
				}
				//data yang akan dimasukkan ke table customer
				$tahun = $this->input->post("tahun");
				$bulan = $this->input->post("bulan");
				$tanggal = $this->input->post("tanggal");
				$pass = md5(sha1("q3fg4".md5($_POST['pass'])."93jwe"));
				$data = array(
					"id_customer" => null,
					"nama" => trim($this->input->post("nama")),
					"email" => trim($this->input->post("email")),
					"password" => $pass,
					"sex" => $this->input->post("jkl"),
					"tgl_lahir" => $tahun."-".$bulan."-".$tanggal,
					"alamat" => "",
					"provinsi" => 0,
					"kota" => 0,
					"kecamatan" => 0,
					"no_hp" => 0,
					"kode_pos" => 0,
					"foto" => 0,
					"kode" => $newcode,
					"aktif" => "N",
					"banned" => "N",
					"tgl" => time(),
					"tgl_update" => time()
					);
				//proses insert data ke table customer
				$insert = $this->model1->insertData("customer", $data);
				//cek apakah proses insert berhasil atau tidak
				if ($insert == 1) {
					$this->session->set_flashdata('sukses', 'Daftar Sukses!');
					redirect('register');
				}else{
					$this->session->set_flashdata('gagal', 'Daftar Gagal! Silakan coba lagi.');
					redirect('register');
				}
			}

		}else{
			redirect('/');
		}
	}

}

/* End of file register.php */
/* Location: ./application/controllers/register.php */