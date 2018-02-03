<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function index()
	{
		redirect('/');
	}

	public function profile()
	{
		if (empty($_SESSION['id_customer'])) {
			redirect('/');
		}else{
			$data['c'] = "profile";
			$where = array("id_customer" => $_SESSION['id_customer']);
			$data['get_profile'] = $this->model1->selectWhere("customer", $where);
			$this->load->view("customer/main", $data);
		}
	}

	public function alamat()
	{
		if (empty($_SESSION['id_customer'])) {
			redirect('/');
		}else{
			$data['c'] = "alamat";
			$where = array("id_customer" => $_SESSION['id_customer']);
			$data['get_alamat'] = $this->model1->selectWhere("customer", $where);
			$data['sql_p'] = $this->model1->selectData("master_provinsi");
			$data['sql_k'] = $this->model1->selectData("master_kokab");
			$data['sql_kc'] = $this->model1->selectData("master_kecam");
			$this->load->view("customer/main", $data);
		}
	}

	public function pesanan_saya()
	{
		if (empty($_SESSION['id_customer'])) {
			redirect('/');
		}else{
			$data['c'] = "pesanan-saya";
			$where = array("id_customer" => $_SESSION['id_customer']);
			$this->db->order_by("id_order", "DESC");
			$data['get_pesanan'] = $this->model1->selectWhere("order_produk", $where);
			$this->load->view("customer/main", $data);
		}
	}

	public function wishlist()
	{
		if (empty($_SESSION['id_customer'])) {
			redirect('/');
		}else{
			$data['c'] = "wishlist";
			$where = array("id_customer" => $_SESSION['id_customer']);
			$data['sql_wishlist'] = $this->model1->joinData("wishlist","produk","INNER JOIN","wishlist.id_produk = produk.no_produk AND wishlist.id_customer = $_SESSION[id_customer] ORDER BY wishlist.tgl DESC");
			$this->load->view("customer/main", $data);
		}
	}

	public function ubah_password()
	{
		if (empty($_SESSION['id_customer'])) {
			redirect('/');
		}else{
			$data['c'] = "ubah-password";
			$this->load->view("customer/main", $data);
		}
	}

	public function upload_foto()
	{
		if (empty($_SESSION['id_customer'])) {
			redirect('/');
		}else{
			if ($this->input->post("btn_upload_foto")) {
				if (empty($_FILES['upload_foto']['name'])) {
					redirect('/');
				}else if ($_FILES['upload_foto']['size'] > 600000) {
					$this->session->set_flashdata('peringatan', 'Maximal ukuran gambar 600kb!');
					redirect('/');
					exit();
				}else{
					$ext = explode(".", strtolower($_FILES['upload_foto']['name']));
					$c = count($ext) - 1;
					if ($ext[$c] == "jpg" || $ext[$c] == "jpeg" || $ext[$c] == "png") {
						//proses upload n resize foto
						$this->img_upload_resize("upload_foto", "customer-$_SESSION[id_customer].jpg", 87, $ext[$c]);
						//proses update foto pd tbl customer
						$foto = "customer-$_SESSION[id_customer].jpg";
						$update = $this->model1->updateData("id_customer", $_SESSION['id_customer'], "customer", array("foto" => $foto));
						if ($update == 1) {
							//membuat session foto
							$_SESSION['foto'] = $foto;
							//jika ada session nick maka hapus session nick tersebut
							if (isset($_SESSION['nick'])) {unset($_SESSION['nick']);}
							$this->session->set_flashdata('sukses', 'Upload foto berhasil!');
							redirect('/');
						}else{
							$this->session->set_flashdata('gagal', 'Upload foto gagal!');
							redirect('/');
						}
					}else{
						$this->session->set_flashdata('peringatan', 'Upload gambar berekstensi JPG, JPEG, atau PNG');
						redirect('/');
						exit();
					}
				}
			}else{
				redirect('/');	
			}
		}
	}

	private function img_upload_resize($file, $newname, $width, $type)
	{
		$path = "image/foto/customer/$newname";
		$gambar = "image/foto/".$_FILES[''.$file.'']['name'];
		$dir = "image/foto/";

		move_uploaded_file($_FILES[''.$file.'']['tmp_name'], $dir . $_FILES[''.$file.'']['name']);

		//identitas file asli
		if ($type == "png") {
			if (!imagecreatefrompng($gambar)) {
				$this->session->set_flashdata('peringatan', 'Image Error!');
				unlink($gambar);
				redirect('/');
			}else{
				$img_src = imagecreatefrompng($gambar);
			}
		}else{
			if (!imagecreatefromjpeg($gambar)) {
				$this->session->set_flashdata('peringatan', 'Image Error!');
				unlink($gambar);
				redirect('/');
			}else{
				$img_src = imagecreatefromjpeg($gambar);
			}
		}
		$src_width = imageSX($img_src); //lebar asli gambar
		$src_height= imageSY($img_src); //tinggi asli gambar

		//set ukuran gambar hasil perubahan
		$dst_width = $width;
		$dst_height= ($dst_width/$src_width)*$src_height;

		//proses perubahan ukuran
		$img = imagecreatetruecolor($dst_width, $dst_height);
		imagecopyresampled($img, $img_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

		//simpan gambar
		imagejpeg($img, $path, 100);

		//hapus gambar dri memory komputer
		imagedestroy($img_src);
		imagedestroy($img);
		unlink($gambar);
	}

	public function update_profile()
	{
		if ($this->input->post("save_profile")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', 'Nama harus di isi.');
				redirect('customer/profile');
				exit();
			}else if (empty($this->input->post("no_hp"))) {
				$this->session->set_flashdata('peringatan', 'No. Handphone harus di isi.');
				redirect('customer/profile');
				exit();
			}else if (empty($this->input->post("jkl"))) {
				$this->session->set_flashdata('peringatan', 'Jenis Kelamin harus di isi.');
				redirect('customer/profile');
				exit();
			}else if (empty($this->input->post("no_hp"))) {
				$this->session->set_flashdata('peringatan', 'No. Handphone harus di isi.');
				redirect('customer/profile');
				exit();
			}else if (empty($this->input->post("email"))) {
				$this->session->set_flashdata('peringatan', 'Email harus di isi.');
				redirect('customer/profile');
				exit();
			}else if (preg_match("/[^a-zA-Z ]/",$this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', 'Nama harus berupa karakter Alfabet/Huruf.');
				redirect('customer/profile');
				exit();
			}else if (!preg_match("/[0-9]/",$this->input->post("no_hp"))) {
				$this->session->set_flashdata('peringatan', 'No. Handphone harus berupa Angka.');
				redirect('customer/profile');
				exit();
			}else if (!filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
				$this->session->set_flashdata('peringatan', 'Email tidak valid.');
				redirect('customer/profile');
				exit();
			}else{
				//cek apakah email yg di input sudah terdaftar atau belum
				$where_email = array(
					"email" => $this->input->post("email"),
					"email !=" => $this->input->post("email2")
					);
				$cek_email = $this->model1->selectWhereSpec("customer", $where_email);
				if ($cek_email->num_rows() > 0) {
					$this->session->set_flashdata('peringatan', 'Email sudah terdaftar! Gunakan email lain.');
					redirect('customer/profile');
					exit();
				}else{
					//data yg akan dimasukkan ke table customer
					$tahun = $this->input->post("tahun");
					$bulan = $this->input->post("bulan");
					$tanggal = $this->input->post("tanggal");
					$data = array(
						"nama" => trim($this->input->post("nama")),
						"tgl_lahir" => $tahun."-".$bulan."-".$tanggal,
						"no_hp" => $this->input->post("no_hp"),
						"sex" => $this->input->post("jkl"),
						"email" => $this->input->post("email"),
						"tgl_update" => time()
						);
					//proses update table customer
					$update = $this->model1->updateData("id_customer", $_SESSION['id_customer'], "customer", $data);
					//cek apakah proses update berhasil atau tidak
					if ($update == 1) {
						//membuat session nama customer
						$_SESSION['nm_customer'] = trim($this->input->post("nama"));
						//jika ada session nick maka hapus session nick tersebut
						if (isset($_SESSION['nick'])) {unset($_SESSION['nick']);}
						$this->session->set_flashdata('sukses', 'Profile berhasil diperbarui.');
						redirect('customer/profile');
					}else{
						$this->session->set_flashdata('gagal', 'Profile gagal diperbarui.');
						redirect('customer/profile');
					}
				}
			}

		}else{
			redirect('/');
		}
	}

	public function update_alamat()
	{
		if ($this->input->post("save_alamat")) {
			if (empty($this->input->post("alamat"))) {
				$this->session->set_flashdata('peringatan', 'Alamat harus di isi.');
				redirect('customer/alamat');
				exit();
			}else if (empty($this->input->post("provinsi"))) {
				$this->session->set_flashdata('peringatan', 'Provinsi harus di isi.');
				redirect('customer/alamat');
				exit();
			}else if (empty($this->input->post("kota"))) {
				$this->session->set_flashdata('peringatan', 'Kota harus di isi.');
				redirect('customer/alamat');
				exit();
			}else if (empty($this->input->post("kode_pos"))) {
				$this->session->set_flashdata('peringatan', 'Kode Pos harus di isi.');
				redirect('customer/alamat');
				exit();
			}else{
				//data alamat yg akan dimasukkan ke table customer
				$alamat = str_replace("\"", "\"", str_replace("'", "\'", $this->input->post("alamat")));
				$data = array(
					"alamat" => trim(strip_tags($alamat)),
					"provinsi" => $this->input->post("provinsi"),
					"kota" => $this->input->post("kota"),
					"kecamatan" => 0,
					"kode_pos" => $this->input->post("kode_pos"),
					"tgl_update" => time()
					);
				//proses update data alamat customer
				$update = $this->model1->updateData("id_customer",$_SESSION['id_customer'],"customer", $data);
				//cek apakah proses update data alamat berhasil atau tidak
				if ($update == 1) {
					$this->session->set_flashdata('sukses', 'Alamat berhasil diperbarui.');
					redirect('customer/alamat');
				}else{
					$this->session->set_flashdata('gagal', 'Alamat gagal diperbarui.');
					redirect('customer/alamat');
				}
			}

		}else{
			redirect('/');
		}
	}

	public function update_password()
	{
		if ($this->input->post("ok")) {
			if (empty($this->input->post("old_pass"))) {
				$this->session->set_flashdata('peringatan', 'Password lama harus di isi.');
				redirect('customer/ubah_password');
				exit();
			}else if (empty($this->input->post("new_pass"))) {
				$this->session->set_flashdata('peringatan', 'Password baru harus di isi.');
				redirect('customer/ubah_password');
				exit();
			}else if (!ctype_alnum($this->input->post("new_pass"))) {
				$this->session->set_flashdata('peringatan', 'Password hanya boleh berupa karakter Huruf/Angka.');
				redirect('customer/ubah_password');
				exit();
			}else if ($this->input->post("new_pass") != $this->input->post("new_pass2")) {
				$this->session->set_flashdata('peringatan', 'Password tidak sama! ketik ulang password.');
				redirect('customer/ubah_password');
				exit();
			}else{
				//cek apakah password lama benar atau tidak
				$where = array(
					"id_customer" => $_SESSION['id_customer']
					);
				$cek_pass = $this->model1->selectWhere("customer", $where);
				$cek = $cek_pass->result()[0]->password;
				$pass = md5(sha1("q3fg4".md5($_POST['old_pass'])."93jwe"));
				if ($cek != $pass) {
					$this->session->set_flashdata('peringatan', 'Password lama salah.');
					redirect('customer/ubah_password');
					exit();
				}else{
					//proses update password
					$newpass = md5(sha1("q3fg4".md5($_POST['new_pass'])."93jwe"));
					$data = array(
						"password" => $newpass
						);
					$update = $this->model1->updateData("id_customer",$_SESSION['id_customer'],"customer",$data);
					//cek apakah proses update password berhasil atau gagal
					if ($update == 1) {
						$this->session->set_flashdata('sukses', 'Password berhasil diperbarui.');
						redirect('customer/ubah_password');
						exit();
					}else{
						$this->session->set_flashdata('gagal', 'Password gagal diperbarui.');
						redirect('customer/ubah_password');
						exit();
					}
				}
			}

		}else{
			redirect('/');
		}
	}

}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */