<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if ($this->input->post("login")) {
			if (empty($this->input->post("email"))) {
				$this->session->set_flashdata('peringatan', 'Anda belum mengisi Email!');
				redirect('/');
				exit();
			}else if (empty($this->input->post("password"))) {
				$this->session->set_flashdata('peringatan', 'Anda belum mengisi Password!');
				redirect('/');
				exit();
			}else if (!ctype_alnum($this->input->post("password"))) {
				$this->session->set_flashdata('peringatan', 'Password hanya boleh berupa karakter Alfanumerik!');
				redirect('/');
				exit();
			}else{
				//cek apakah email dan password benar atau tidak
				$pass = md5(sha1("q3fg4".md5($_POST['password'])."93jwe"));
				$data = array(
					"email" => $this->input->post("email"),
					"password" => $pass
					);
				$select = $this->model1->selectWhereSpec("customer", $data);
				if ($select->num_rows() == 0) {
					$this->session->set_flashdata('peringatan', 'Email atau Password salah!');
					redirect('/');
					exit();
				}else{
					//cek apakah akun sudah diaktivasi atau belum
					$data2 = array(
						"email" => $this->input->post("email"),
						"password" => $pass,
						"aktif" => "Y"
						);
					$aktif = $this->model1->selectWhereSpec("customer", $data2);
					if ($aktif->num_rows() == 0) {
						$this->session->set_flashdata('peringatan', 'Akun Anda belum aktif! silakan cek email Anda untuk aktivasi akun.');
						redirect('/');
						exit();
					}else{
						//membuat session id customer n nama customer
						$cst = $aktif->result()[0];
						$_SESSION['id_customer'] = $cst->id_customer;
						$_SESSION['nm_customer'] = $cst->nama;
						$_SESSION['foto'] = $cst->foto;
						//jika ada session nick maka hapus session nick
						if (isset($_SESSION['nick'])) {
							unset($_SESSION['nick']);
						}
						redirect('/');
					}
				}
			}
		}else{
			redirect('/');
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */