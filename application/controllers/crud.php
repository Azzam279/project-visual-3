<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		redirect('admin/');
	}

	public function tambah_kategori()
	{
		if ($this->input->post("proses")) {
			//jika kolom input kategori kosong maka redirect halaman
			if (empty($this->input->post("kategori"))) {
				redirect('admin/kategori');
				exit();
			}
			//jika memasukkan karakter yg tdk valid maka jalankan coding ini
			if (!preg_match("/^[a-zA-Z &]*$/", $this->input->post("kategori"))) {
				$this->session->set_flashdata('peringatan', 'Kategori hanya boleh berupa Huruf, Spasi dan Karakter \'&\'');
				redirect('admin/kategori');
				exit();
			}

			//data dari form tambah kategori
			$kategori = trim(str_replace(" ","_",$this->input->post("kategori")));
			$data = array(
					"no_kategori" => null,
					"nama_kategori" => $kategori,
					"tipe" => $this->input->post("tipe")
				);

			//cek kategori dengan yg ada di database agar tdk trjadi duplikasi data
			$data_cek = array("nama_kategori" => $kategori);
			$sql_cek = $this->model1->selectWhere("kategori", $data_cek);
			if ($sql_cek->num_rows() > 0) {
				$this->session->set_flashdata('peringatan', 'Nama Kategori tidak boleh sama!');
				redirect('admin/kategori');
				exit();
			}

			//proses tambah/insert data baru ke table kategori
			$res = $this->model1->insertData("kategori", $data);

			//jika proses tambah/insert sukses
			if ($res == 1) {
				include("variable.php");
				//proses membuat file -/Start
				$kategori_lg = ucfirst($kategori);
				$isi_file = 
				"<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class $kategori_lg extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						\$where = array(\"nama_kategori\" => \"$kategori\");
						\$data_kat['kategory'] = \$this->model1->selectWhere(\"kategori\", \$where);
						\$this->load->view(\"produk1\", \$data_kat);
					}
				}
				?>";
				$dir = "$doc/$kategori.php";
				$file = fopen($dir, "w");
				//membuat file kategori
				fwrite($file, $isi_file);
				fclose($file);
				// -/Finish

				$this->session->set_flashdata('sukses', 'Kategori berhasil ditambahkan!');
				redirect('admin/kategori');
			//jika proses insert gagal
			}else{
				$this->session->set_flashdata('gagal', 'Kategori gagal ditambahkan!');
				redirect('admin/kategori');
			}
		}else{
			redirect('admin/kategori');
		}
	}

	public function ubah_kategori($no)
	{
		if ($this->input->post("proses")) {
			//jika kolom input kategori kosong maka redirect halaman
			if (empty($this->input->post("kategori"))) {
				redirect('admin/kategori');
				exit();
			}
			//jika memasukkan karakter yg tdk valid maka jalankan coding ini
			if (!preg_match("/^[a-zA-Z &]*$/", $this->input->post("kategori"))) {
				$this->session->set_flashdata('peringatan', 'Kategori hanya boleh berupa Huruf, Spasi dan Karakter \'&\'');
				redirect('admin/kategori');
				exit();
			}

			//mengambil data no_kategori dari table kategori berdasarkan variable $no
			$id = array("no_kategori" => $no);
			$name = $this->model1->selectWhere("kategori",$id);
			$nama = $name->result()[0]->nama_kategori;

			//data dari form edit kategori
			$kategori = trim(str_replace(" ","_",$this->input->post("kategori")));
			$data = array(
					"no_kategori" => $no,
					"nama_kategori" => $kategori
				);

			//cek kategori dengan yg ada di database agar tdk trjadi duplikasi data
			$data_cek = array("nama_kategori" => $kategori);
			$sql_cek = $this->model1->selectWhere("kategori", $data_cek);
			if ($sql_cek->num_rows() > 0) {
				$this->session->set_flashdata('peringatan', 'Nama Kategori tidak boleh sama!');
				redirect('admin/kategori');
				exit();
			}

			//proses update/edit data di table kategori
			$res = $this->model1->updateData("no_kategori",$no,"kategori", $data);
			
			//jika update berhasil
			if ($res == 1) {
				include("variable.php");
				$pathFile = $doc."/".$nama.".php";
				//jika proses hapus file sukses
				if(unlink($pathFile)) {
					//proses membuat file -/Start
					$kategori_lg = ucfirst($kategori);
					$isi_file = 
					"<?php
					if ( ! defined('BASEPATH')) exit('No direct script access allowed');

					class $kategori_lg extends CI_Controller {
						public function __construct()
						{
							parent::__construct();
						}

						public function index()
						{
							\$where = array(\"nama_kategori\" => \"$kategori\");
							\$data_kat['kategory'] = \$this->model1->selectWhere(\"kategori\", \$where);
							\$this->load->view(\"produk1\", \$data_kat);
						}
					}
					?>";
					$dir = "$doc/$kategori.php";
					$file = fopen($dir, "w");
					//membuat file kategori
					fwrite($file, $isi_file);
					fclose($file);
					// -/Finish

					//hapus subkategori yang berhubungan dengan kategori ini
					$cek_sub = $this->model1->selectWhere("subkategori", $id);
					if ($cek_sub->num_rows() > 0) {
						$this->model1->deleteData("subkategori", $id);
					}

					$this->session->set_flashdata('sukses', 'Kategori berhasil diubah!');
					redirect('admin/kategori');	
				//jika proses hapus file gagal
				}else{
					$this->session->set_flashdata('gagal', 'Kategori gagal diubah!');
					redirect('admin/kategori');
				}
			//jika update gagal
			}else{
				$this->session->set_flashdata('gagal', 'Kategori gagal diubah!');
				redirect('admin/kategori');
			}			
		}else{
			redirect('admin/kategori');
		}
	}

	public function hapus_kategori($id)
	{
		//jika variable $id kosong/tdk ada nilai maka redirect halaman
		if (empty($id)) {
			redirect('admin/kategori');
		//jika ada nilainya maka jalankan coding dibawah ini
		}else{
			//data yang akan dihapus
			$data = array("no_kategori" => $id);
			$name = $this->model1->selectWhere("kategori",$data);
			$nama = "<font color='red'>".$name->result()[0]->nama_kategori."</font>";

			//proses hapus data di table kategori
			$result = $this->model1->deleteData("kategori",$data);

			//jika proses hapus berhasil
			if ($result == 1) {
				include("variable.php");
				$pathFile = $doc."/".$name->result()[0]->nama_kategori.".php";
				//hapus file kategori yang bersangkutan
				unlink($pathFile);

				//hapus subkategori yang berhubungan dengan kategori ini
				$cek_sub = $this->model1->selectWhere("subkategori", $id);
				if ($cek_sub->num_rows() > 0) {
					$this->model1->deleteData("subkategori", $id);
				}

				$this->session->set_flashdata('sukses', 'Kategori '.$nama.' berhasil dihapus!');
				redirect('admin/kategori');
			//jika proses hapus gagal
			}else{
				$this->session->set_flashdata('gagal', 'Kategori '.$nama.' gagal dihapus!');
				redirect('admin/kategori');
			}
		}
	}

	// =============================================================================
	// ===============================Sub-Kategori==================================
	// =============================================================================

	public function tambah_subkategori()
	{
		if ($this->input->post("proses")) {
			//jika kolom input kategori dan subkategori kosong maka jalankan coding dibawah ini.
			if (empty($this->input->post("kategori")) && empty($this->input->post("subkategori"))) {
				redirect('admin/subkategori');
				exit();
			}
			//jika memasukkan karakter yg tdk valid maka jalankan coding ini
			if (!preg_match("/^[a-zA-Z &]*$/", $this->input->post("subkategori"))) {
				$this->session->set_flashdata('peringatan', 'Sub-Kategori hanya boleh berupa Huruf, Spasi dan Karakter \'&\'');
				redirect('admin/subkategori');
				exit();
			}

			//data dari form tambah subkategori
			$kategori = explode("|",$this->input->post("kategori"));
			$subkategori = trim(str_replace(" ","_",$this->input->post("subkategori")));
			$data = array(
					"no_subkategori" => null,
					"nama_subkategori" => $subkategori,
					"no_kategori" => $kategori[0],
					"nama_kategori" => $kategori[1],
					);

			//cek subkategori dengan yg ada di database agar tdk trjadi duplikasi data
			$data_cek = array(
						"nama_subkategori" => $subkategori, 
						"no_kategori" => $kategori[0]
						);
			$sql_cek = $this->model1->selectWhereSpec("subkategori", $data_cek);
			if ($sql_cek->num_rows() > 0) {
				$this->session->set_flashdata('peringatan', 'Nama Sub-Kategori tidak boleh sama!');
				redirect('admin/subkategori');
				exit();
			}

			//mengambil semua subkategori -/Start
			$get_subkat = array("no_kategori" => $kategori[0]);
			$total_subkat = $this->model1->selectWhere("subkategori", $get_subkat);
			$total_rows = $this->model1->selectWhere("subkategori", $get_subkat);
			$sub .= "";
			if ($total_rows->num_rows() != 0) {
				foreach ($total_subkat->result() as $val_subkat) {
					$sub .= "
					public function $val_subkat->nama_subkategori()
					{
						\$where2 = array(\"nama_subkategori\" => \"$val_subkat->nama_subkategori\");
						\$data_subkat['subkat'] = \$this->model1->selectWhere(\"subkategori\", \$where2);
						\$this->load->view(\"produk2\", \$data_subkat);
					}
					";
				}
			}
			// -/Finish

			//proses tambah data baru ke table subkategori
			$res = $this->model1->insertData("subkategori", $data);

			//jika proses tambah data sukses, maka jalankan coding dibawah ini
			if ($res == 1) {
				include("variable.php");
				//proses membuat file -/Start
				$kategori_lg = ucfirst($kategori[1]);
				$isi_file = 
				"<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class $kategori_lg extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						\$where = array(\"nama_kategori\" => \"$kategori[1]\");
						\$data_kat['kategory'] = \$this->model1->selectWhere(\"kategori\", \$where);
						\$this->load->view(\"produk1\", \$data_kat);
					}
					$sub
					public function $subkategori()
					{
						\$where2 = array(\"nama_subkategori\" => \"$subkategori\");
						\$data_subkat['subkat'] = \$this->model1->selectWhere(\"subkategori\", \$where2);
						\$this->load->view(\"produk2\", \$data_subkat);
					}
				}
				?>";
				$dir = "$doc/".$kategori[1].".php";
				$file = fopen($dir, "w");
				//membuat file kategori
				fwrite($file, $isi_file);
				fclose($file);
				// -/Finish

				$this->session->set_flashdata('sukses', 'Sub-Kategori berhasil ditambahkan!');
				redirect('admin/subkategori');
			//jika gagal, maka jalankan coding dibawah ini.	
			}else{
				$this->session->set_flashdata('gagal', 'Sub-Kategori gagal ditambahkan!');
				redirect('admin/subkategori');
			}
		}else{
			redirect('admin/subkategori');
		}
	}

	public function ubah_subkategori($no_kat,$no_sub)
	{
		if ($this->input->post("proses")) {
			//jika kolom input kategori dan subkategori kosong maka redirect halaman
			if (empty($this->input->post("kategori")) || empty($this->input->post("subkategori"))) {
				redirect('admin/subkategori');
				exit();
			}
			//jika memasukkan karakter yg tdk valid maka jalankan coding ini
			if (!preg_match("/^[a-zA-Z &]*$/", $this->input->post("subkategori"))) {
				$this->session->set_flashdata('peringatan', 'Sub-Kategori hanya boleh berupa Huruf, Spasi dan Karakter \'&\'');
				redirect('admin/subkategori');
				exit();
			}

			//data dari form edit subkategori
			$kategori = explode("|",$this->input->post("kategori"));
			$subkategori = trim(str_replace(" ","_",$this->input->post("subkategori")));
			$data = array(
					"no_subkategori" => $no_sub,
					"nama_subkategori" => $subkategori,
					"no_kategori" => $kategori[0],
					"nama_kategori" => $kategori[1]
					);

			//cek subkategori dengan yg ada di database agar tdk trjadi duplikasi data
			$data_cek = array(
						"nama_subkategori" => $subkategori, 
						"no_kategori" => $kategori[0]
						);
			$sql_cek = $this->model1->selectWhereSpec("subkategori", $data_cek);
			if ($sql_cek->num_rows() > 0) {
				$this->session->set_flashdata('peringatan', 'Nama Sub-Kategori tidak boleh sama!');
				redirect('admin/subkategori');
				exit();
			}

			//proses update table subkategori
			$res = $this->model1->updateData("no_subkategori",$no_sub,"subkategori", $data);
			
			//jika subkategori berhasil diupdate/diedit maka proses coding dibawah ini
			if ($res == 1) {
				//mengambil semua subkategori -/Start
				$get_subkat = array("no_kategori" => $kategori[0]);
				$total_subkat = $this->model1->selectWhere("subkategori", $get_subkat);
				$total_rows = $this->model1->selectWhere("subkategori", $get_subkat);
				$sub = "";
				if ($total_rows->num_rows() != 0) {
					foreach ($total_subkat->result() as $val_subkat) {
						$sub .= "
						public function $val_subkat->nama_subkategori()
						{
							\$where2 = array(\"nama_subkategori\" => \"$val_subkat->nama_subkategori\");
							\$data_subkat['subkat'] = \$this->model1->selectWhere(\"subkategori\", \$where2);
							\$this->load->view(\"produk2\", \$data_subkat);
						}
						";
					}
					$total_subkat->free_result();
				}
				$total_rows->free_result();
				// -/Finish

				include("variable.php");
				//proses membuat file -/Start
				$kategori_lg = ucfirst($kategori[1]);
				$isi_file = 
				"<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class $kategori_lg extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						\$where = array(\"nama_kategori\" => \"$kategori[1]\");
						\$data_kat['kategory'] = \$this->model1->selectWhere(\"kategori\", \$where);
						\$this->load->view(\"produk1\", \$data_kat);
					}
					$sub
				}
				?>";
				$dir = "$doc/".$kategori[1].".php";
				$file = fopen($dir, "w");
				//membuat file kategori
				fwrite($file, $isi_file);
				fclose($file);
				// -/Finish

				//mengambil semua subkategori lama -/Start
				$get_subkat2 = array("no_kategori" => $no_kat);
				$total_subkat2 = $this->model1->selectWhere("subkategori", $get_subkat2);
				$total_rows2 = $this->model1->selectWhere("subkategori", $get_subkat2);
				$sub2 = "";
				if ($total_rows2->num_rows() != 0) {
					foreach ($total_subkat2->result() as $val_subkat2) {
						$sub2 .= "
						public function $val_subkat2->nama_subkategori()
						{
							\$where2 = array(\"nama_subkategori\" => \"$val_subkat2->nama_subkategori\");
							\$data_subkat['subkat'] = \$this->model1->selectWhere(\"subkategori\", \$where2);
							\$this->load->view(\"produk2\", \$data_subkat);
						}
						";
					}
					$total_subkat2->free_result();
				}
				$total_rows2->free_result();
				// -/Finish

				//mengambil nomor kategori dari table subkategori
				$nama = $this->model1->selectWhere("subkategori", array("no_kategori" => $no_kat));
				$get_nama = $nama->result()[0]->nama_kategori;

				//proses membuat file -/Start
				$kategori_lg2 = ucfirst($get_nama);
				$isi_file2 = 
				"<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class $kategori_lg2 extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						\$where = array(\"nama_kategori\" => \"$get_nama\");
						\$data_kat['kategory'] = \$this->model1->selectWhere(\"kategori\", \$where);
						\$this->load->view(\"produk1\", \$data_kat);
					}
					$sub2
				}
				?>";
				$dir2 = "$doc/".$get_nama.".php";
				$file2 = fopen($dir2, "w");
				//membuat file kategori
				fwrite($file2, $isi_file2);
				fclose($file2);
				// -/Finish

				$this->session->set_flashdata('sukses', 'Sub-Kategori berhasil diubah!');
				redirect('admin/subkategori');
			//jika gagal diupdate, jalankan coding dibawah ini
			}else{
				$this->session->set_flashdata('gagal', 'Sub-Kategori gagal diubah!');
				redirect('admin/subkategori');
			}			
		}else{
			redirect('admin/subkategori');
		}
	}

	public function hapus_subkategori($no_kat,$id)
	{
		//jika variable $id kosong/tdk ada nilai maka redirect halaman
		if (empty($id)) {
			redirect('admin/subkategori');
		//jika ada nilainya maka jalankan coding dibawah ini
		}else{
			//data yang akan dihapus
			$data = array("no_subkategori" => $id);
			$name = $this->model1->selectWhere("subkategori",$data);
			$nama = "<font color='red'>".$name->result()[0]->nama_subkategori."</font>";

			//proses hapus data di table kategori
			$result = $this->model1->deleteData("subkategori",$data);

			//jika proses hapus berhasil
			if ($result == 1) {
				//mengambil semua subkategori -/Start
				$get_subkat = array("no_kategori" => $no_kat);
				$total_subkat = $this->model1->selectWhere("subkategori", $get_subkat);
				$total_rows = $this->model1->selectWhere("subkategori", $get_subkat);
				$sub = "";
				if ($total_rows->num_rows() != 0) {
					foreach ($total_subkat->result() as $val_subkat) {
						$sub .= "
						public function $val_subkat->nama_subkategori()
						{
							\$where2 = array(\"nama_subkategori\" => \"$val_subkat->nama_subkategori\");
							\$data_subkat['subkat'] = \$this->model1->selectWhere(\"subkategori\", \$where2);
							\$this->load->view(\"produk2\", \$data_subkat);
						}
						";
					}
					$total_subkat->free_result();
				}
				$total_rows->free_result();
				// -/Finish

				include("variable.php");
				//mengambil data no_kategori dari table subkategori -/Start
				$id_kat = array("no_kategori" => $no_kat);
				$get_kat = $this->model1->selectWhere("subkategori",$id_kat);
				$nama_kat = $get_kat->result()[0]->nama_kategori;
				// -/Finish

				//proses membuat file -/Start
				$kategori_lg = ucfirst($nama_kat);
				$isi_file = 
				"<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class $kategori_lg extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						\$where = array(\"nama_kategori\" => \"$nama_kat\");
						\$data_kat['kategory'] = \$this->model1->selectWhere(\"kategori\", \$where);
						\$this->load->view(\"produk1\", \$data_kat);
					}
					$sub
				}
				?>";
				$dir = "$doc/".$nama_kat.".php";
				$file = fopen($dir, "w");
				//membuat file kategori
				fwrite($file, $isi_file);
				fclose($file);
				// -/Finish

				$this->session->set_flashdata('sukses', 'Kategori '.$nama.' berhasil dihapus!');
				redirect('admin/subkategori');
			//jika proses hapus gagal
			}else{
				$this->session->set_flashdata('gagal', 'Kategori '.$nama.' gagal dihapus!');
				redirect('admin/subkategori');
			}
		}
	}

	// ================================================================================
	// ================================== Brand =======================================
	// ================================================================================

	public function tambah_brand()
	{
		if ($this->input->post("tambah")) {
			if (empty($this->input->post("brand"))) {
				$this->session->set_flashdata('peringatan', 'Nama Brand harus di isi!');
				redirect('admin/brand');
			}else if (preg_match("/[^a-zA-Z]/", $this->input->post("brand"))) {
				$this->session->set_flashdata('peringatan', 'Nama Brand harus berupa Alfabet!');
				redirect('admin/brand');
			}else if (empty($_FILES['img_brand']['name'])) {
				$this->session->set_flashdata('peringatan', 'Gambar Brand harus di upload!');
				redirect('admin/brand');
			}else{
				$arr = array("jpg","jpeg","png");
				$ext = explode(".", strtolower($_FILES['img_brand']['name']));
				$c = count($ext) - 1;
				if ($_FILES['img_brand']['size'] > 200000) {
					$this->session->set_flashdata('peringatan', 'Ukuran gambar terlalu besar! Max 200kb.');
					redirect('admin/brand');
					exit();
				}else if (in_array($ext[$c], $arr) === TRUE) {
					//proses upload gambar brand
					$newname = $this->input->post("brand")."-".time().".jpg";
					$file = "img_brand";
					$lebar = 270;
					$this->img_brand_resize($file, $newname, $lebar, $ext[$c]);

					//proses insert brand
					$data = array(
						"no_brand" => null,
						"nama_brand" => $this->input->post("brand"),
						"img_brand" => $newname
						);
					$insert = $this->model1->insertData("brand", $data);

					//jika proses tambah data berhasil
					if ($insert == 1) {
						$this->session->set_flashdata('sukses', 'Brand baru sukses ditambahkan!');
						redirect('admin/brand');
					//jika gagal
					}else{
						$this->session->set_flashdata('gagal', 'Brand baru gagal ditambahkan!');
						redirect('admin/brand');
					}
				}else{
					$this->session->set_flashdata('peringatan', 'Upload gambar bertipe JPG,JPEG, atau PNG!');
					redirect('admin/brand');
				}
			}
		}else{
			redirect('admin/brand');
		}
	}

	public function edit_brand()
	{
		if ($this->input->post("edit")) {
			if (empty($this->input->post("brand"))) {
				$this->session->set_flashdata('peringatan', 'Nama Brand harus di isi!');
				redirect('admin/brand');
			}else if (preg_match("/[^a-zA-Z]/", $this->input->post("brand"))) {
				$this->session->set_flashdata('peringatan', 'Nama Brand harus berupa Alfabet!');
				redirect('admin/brand');
			}else{
				if (empty($_FILES['img_brand']['name'])) { //jika gambar brand kosong/tdk diupload
					//proses update brand
					$no_brand = $this->input->post("id_brand");
					$data = array("nama_brand" => $this->input->post("brand"));
					$update = $this->model1->updateData("no_brand",$no_brand,"brand",$data);

					//jika proses update brand berhasil
					if ($update == 1) {
						$this->session->set_flashdata('sukses', 'Nama Brand berhasil diubah!');
						redirect('admin/brand');

					//jika gagal	
					}else{
						$this->session->set_flashdata('gagal', 'Nama Brand gagal diubah!');
						redirect('admin/brand');
					}
				}else{ //jika gambar brand tdk kosong
					$arr = array("jpg","jpeg","png");
					$ext = explode(".", strtolower($_FILES['img_brand']['name']));
					$c = count($ext) - 1;
					if ($_FILES['img_brand']['size'] > 200000) {
						$this->session->set_flashdata('peringatan', 'Ukuran gambar terlalu besar! Max 200kb.');
						redirect('admin/brand');
						exit();
					}else if (in_array($ext[$c], $arr) === TRUE) {
						//proses upload gambar brand
						$newname = $this->input->post("brand")."-".time().".jpg";
						$file = "img_brand";
						$lebar = 270;
						$this->img_brand_resize($file, $newname, $lebar, $ext[$c]);

						//proses update brand
						$no_brand = $this->input->post("id_brand");
						$data = array(
							"nama_brand" => $this->input->post("brand"),
							"img_brand" => $newname
							);
						$update = $this->model1->updateData("no_brand",$no_brand,"brand",$data);

						//jika proses update brand berhasil
						if ($update == 1) {
							unlink("image/brand/".$this->input->post("nama_img"));
							$this->session->set_flashdata('sukses', 'Brand berhasil diperbaharui!');
							redirect('admin/brand');

						//jika gagal	
						}else{
							$this->session->set_flashdata('gagal', 'Brand gagal diperbaharui!');
							redirect('admin/brand');
						}
					}else{
						$this->session->set_flashdata('peringatan', 'Upload gambar bertipe JPG,JPEG, atau PNG!');
						redirect('admin/brand');
					}
				}
			}
		}else{
			redirect('admin/brand');
		}
	}

	public function hapus_brand($id,$img)
	{
		if (!empty($id)) {
			$data = array("no_brand" => $id);
			$delete = $this->model1->deleteData("brand", $data);

			//jika proses hapus berhasil
			if ($delete == 1) {
				unlink("image/brand/$img");
				$this->session->set_flashdata('sukses', 'Brand berhasil dihapus!');
				redirect('admin/brand');
			//jika gagal
			}else{
				$this->session->set_flashdata('gagal', 'Brand gagal dihapus!');
				redirect('admin/brand');
			}
		}else{
			redirect('admin/brand');
		}
	}

	private function img_brand_resize($file, $newname, $width, $type)
	{
		$path = "image/brand/$newname";
		$gambar = "image/brand/".$_FILES[''.$file.'']['name'];
		$dir = "image/brand/";

		move_uploaded_file($_FILES[''.$file.'']['tmp_name'], $dir . $_FILES[''.$file.'']['name']);

		//identitas file asli
		if ($type == "png") {
			if (!imagecreatefrompng($gambar)) {
				$_SESSION['warning'] = "Image Error!";
				unlink($gambar);
				redirect('admin/brand');
			}else{
				$img_src = imagecreatefrompng($gambar);
			}
		}else{
			$img_src = imagecreatefromjpeg($gambar);
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

	// ================================================================================
	// ============================ Upload Gambar Promo ===============================
	// ================================================================================

	public function proses_upload_promo()
	{
		if ($this->input->post("upload")) {
			$judul = strip_tags(trim($this->input->post("judul_promo")));
			$waktu = intval($this->input->post("waktu_promo"));
			$kat_promo = $this->input->post("kategori_promo");
			$img_portrait = $_FILES['promo1'];
			$img_landscape = $_FILES['promo2'];
			$main_promo = time();

			//jika memasukkan karakter tdk valid, jalankan coding ini.
			if (!preg_match("/^[0-9]*$/", $waktu)) {
				$this->session->set_flashdata('peringatan2', 'Waktu Promo harus berupa Angka!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($judul)) {
				$this->session->set_flashdata('peringatan2', 'Judul tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($waktu)) {
				$this->session->set_flashdata('peringatan2', 'Waktu tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($img_portrait)) {
				$this->session->set_flashdata('peringatan2', 'Gambar Promo tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($img_landscape)) {
				$this->session->set_flashdata('peringatan2', 'Gambar Promo tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else{
				if ($kat_promo != 0) {
					//mengambil data dari table promo
					$cek = $this->model1->selectWhere("promo", array("no_kategori_promo" => $kat_promo));
					$cek_kat = $cek->num_rows();
					//mengecek apakah kategori promo sudah terdaftar di database
					if ($cek_kat > 0) {
						//mengambil data dari table kategori
						$get_kat = $this->model1->selectWhere("kategori", array("no_kategori" => $kat_promo));
						$get_nama = $get_kat->result()[0]->nama_kategori;
						$this->session->set_flashdata('peringatan2', "Promo kategori $get_nama sudah terdaftar");
						redirect('admin/kategori');
						exit();
					}
				}

				$img1 = explode(".",strtolower($_FILES["promo1"]['name']));
				$img2 = explode(".",strtolower($_FILES["promo2"]['name']));
				$nmr1 = count($img1) - 1;
				$nmr2 = count($img2) - 1;
				//jika file gambar diupload valid
				if ($img1[$nmr1] == "jpg" || $img1[$nmr1] == "jpeg" || $img1[$nmr1] == "png") {
				if ($img2[$nmr2] == "jpg" || $img2[$nmr2] == "jpeg" || $img2[$nmr2] == "png") {
					
					$new1 = ($kat_promo==0) ? "promo-utama$main_promo-md.jpg" : "promo$kat_promo-md.jpg";
					$file1 = "promo1";
					$direktori1 = "image/promo/portrait/";
					$width1 = ($kat_promo==0) ? 418 : 250;
					//proses upload & resize gambar
					$this->upload_image_resize($new1, $file1, $direktori1, $width1, $img1[$nmr1]);

					$new2 = ($kat_promo==0) ? "promo-utama$main_promo-lg.jpg" : "promo$kat_promo-lg.jpg";
					$file2 = "promo2";
					$direktori2 = "image/promo/landscape/";
					$width2 = 1120;
					//proses upload & resize gambar
					$this->upload_image_resize($new2, $file2, $direktori2, $width2, $img2[$nmr2]);

					//data dari form promo kategori
					$title = str_replace("\"", "\"", str_replace("'","\'",$judul));
					$time = time() + (86400*$waktu);
					$data = array(
							"id_promo" => null,
							"judul_promo" => $judul,
							"lama_promo" => $time,
							"gambar_promo_md" => $new1,
							"gambar_promo_lg" => $new2,
							"no_kategori_promo" => $kat_promo,
							"tgl" => time()
							);

					//proses insert data ke table promo_kategori
					$insert = $this->model1->insertData("promo", $data);

					if ($insert == 1) {
						$this->session->set_flashdata('sukses2', 'Promo Berhasil Ditambahkan');
						redirect('admin/promo');
					}else{
						$this->session->set_flashdata('gagal2', 'Promo Gagal Ditambahkan');
						$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
					}

				//jika bukan file gambar yg diupload
				}else{
					$this->session->set_flashdata('peringatan2', 'Upload File Gambar Ekstensi JPEG|JPG|PNG');
					$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
				}
				}else{
					$this->session->set_flashdata('peringatan2', 'Upload File Gambar Ekstensi JPEG|JPG|PNG');
					$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
				}	
			}

		}else{
			redirect('admin/');
		}
	}

	public function edit_promo($id)
	{
		if ($this->input->post("edit")) {
			$judul = strip_tags(trim($this->input->post("judul_promo")));
			$waktu = intval($this->input->post("waktu_promo"));
			$kat_promo = $this->input->post("kategori_promo");
			$img_portrait = $_FILES['promo1'];
			$img_landscape = $_FILES['promo2'];
			$main_promo = time();

			//jika memasukkan karakter tdk valid, jalankan coding ini.
			if (!preg_match("/^[0-9]*$/", $waktu)) {
				$this->session->set_flashdata('peringatan2', 'Waktu Promo harus berupa Angka!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($judul)) {
				$this->session->set_flashdata('peringatan2', 'Judul tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($waktu)) {
				$this->session->set_flashdata('peringatan2', 'Waktu tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($img_portrait)) {
				$this->session->set_flashdata('peringatan2', 'Gambar Promo tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else if (empty($img_landscape)) {
				$this->session->set_flashdata('peringatan2', 'Gambar Promo tidak boleh kosong!');
				$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
			}else{
				if ($kat_promo != 0) {
					//mengambil data dari table promo
					$cek = $this->model1->selectWhereSpec("promo", array("no_kategori_promo" => $kat_promo, "no_kategori_promo !=" => $kat_promo));
					$cek_kat = $cek->num_rows();
					//mengecek apakah kategori promo sudah terdaftar di database
					if ($cek_kat > 0) {
						//mengambil data dari table kategori
						$get_kat = $this->model1->selectWhere("kategori", array("no_kategori" => $kat_promo));
						$get_nama = $get_kat->result()[0]->nama_kategori;
						$this->session->set_flashdata('peringatan2', "Promo kategori $get_nama sudah terdaftar");
						redirect('admin/kategori');
						exit();
					}
				}

				$img1 = explode(".",strtolower($_FILES["promo1"]['name']));
				$img2 = explode(".",strtolower($_FILES["promo2"]['name']));
				$nmr1 = count($img1) - 1;
				$nmr2 = count($img2) - 1;
				//jika file gambar diupload valid
				if ($img1[$nmr1] == "jpg" || $img1[$nmr1] == "jpeg" || $img1[$nmr1] == "png") {
				if ($img2[$nmr2] == "jpg" || $img2[$nmr2] == "jpeg" || $img2[$nmr2] == "png") {
					
					$new1 = ($kat_promo==0) ? "promo-utama$main_promo-md.jpg" : "promo$kat_promo-md.jpg";
					$file1 = "promo1";
					$direktori1 = "image/promo/portrait/";
					$width1 = ($kat_promo==0) ? 418 : 250;
					//proses upload & resize gambar
					$this->upload_image_resize($new1, $file1, $direktori1, $width1, $img1[$nmr1]);

					$new2 = ($kat_promo==0) ? "promo-utama$main_promo-lg.jpg" : "promo$kat_promo-lg.jpg";
					$file2 = "promo2";
					$direktori2 = "image/promo/landscape/";
					$width2 = 1120;
					//proses upload & resize gambar
					$this->upload_image_resize($new2, $file2, $direktori2, $width2, $img2[$nmr2]);

					//mengambil data promo berdasarkan id_promo
					$get_promo = $this->model1->selectWhere("promo", array("id_promo" => $id));
					$get = $get_promo->result()[0];
					$img1 = $get->gambar_promo_md;
					$img2 = $get->gambar_promo_lg;

					//data dari form promo kategori
					$title = str_replace("\"", "\"", str_replace("'","\'",$judul));
					$time = time() + (86400*$waktu);
					$data = array(
							"judul_promo" => $judul,
							"lama_promo" => $time,
							"gambar_promo_md" => $new1,
							"gambar_promo_lg" => $new2,
							"no_kategori_promo" => $kat_promo,
							"tgl" => time()
							);

					//proses update data ke table promo_kategori
					$update = $this->model1->updateData("id_promo", $id, "promo", $data);
					//cek apakah proses update sukses atau gagal
					if ($update == 1) {
						if ($kat_promo == "0") {
							//hapus gambar lama
							unlink("image/promo/portrait/$img1");
							unlink("image/promo/landscape/$img2");
						}

						$this->session->set_flashdata('sukses2', 'Promo Berhasil Diperbaharui');
						redirect('admin/promo');
					}else{
						$this->session->set_flashdata('gagal2', 'Promo Gagal Diperbaharui');
						$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
					}

				//jika bukan file gambar yg diupload
				}else{
					$this->session->set_flashdata('peringatan2', 'Upload File Gambar Ekstensi JPEG|JPG|PNG');
					$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
				}
				}else{
					$this->session->set_flashdata('peringatan2', 'Upload File Gambar Ekstensi JPEG|JPG|PNG');
					$redirect = ($kat_promo == 0) ? redirect('admin/promo') : redirect('admin/kategori');
				}	
			}

		}else{
			redirect('admin/');
		}
	}

	public function hapus_promo($id)
	{
		if (empty($id)) {
			redirect('admin/');
		}else{
			//mengambil data promo
			$get_gb = $this->model1->selectWhere("promo", array("id_promo" => $id));
			$gb1 = $get_gb->result()[0]->gambar_promo_md;
			$gb2 = $get_gb->result()[0]->gambar_promo_lg;

			//proses delete data promo
			$del = $this->model1->deleteData("promo", array("id_promo" => $id));
			//cek apakah proses delete promo sukses atau tidak
			if ($del == 1) {
				//proses hapus gambar promo
				$img1 = "image/promo/portrait/$gb1";
				$img2 = "image/promo/landscape/$gb2";
				unlink($img1);
				unlink($img2);
				//proses hapus gambar produk promo
				$get_produk = $this->model1->selectWhere("produk", array("id_promo" => $id));
				if ($get_produk->num_rows() > 0) {
					foreach ($get_produk->result() as $p) {
						$ex = explode(",", $p->gambar_produk);
						foreach ($ex as $val) {
							unlink("image/produk-sm/$val");
							unlink("image/produk-md/$val");
							unlink("image/produk-lg/$val");
						}
					}
				}
				//proses delete produk promo yg bersangkutan
				$del_produk = $this->model1->deleteData("produk", array("id_promo" => $id));
				//cek apakah proses delete produk promo sukses atau tidak
				if ($del_produk > 0) {
					$this->session->set_flashdata('sukses', 'Promo Berhasil Dihapus!');
					redirect('admin/promo');
				}else{
					$this->session->set_flashdata('gagal', 'Produk Promo Gagal Dihapus!');
					redirect('admin/promo');
				}
			}else{
				$this->session->set_flashdata('gagal', 'Promo Gagal Dihapus!');
				redirect('admin/promo');
			}
		}
	}

	public function proses_upload_gambar_kategori() {
		if ($this->input->post("upload")) {
			if (empty($this->input->post("gb_kat"))) {
				$this->session->set_flashdata('peringatan2', 'Kategori gambar tidak boleh kosong!');
				redirect('admin/kategori');
			}else if (empty($_FILES['gambar']['name'])) {
				$this->session->set_flashdata('peringatan2', 'Gambar tidak boleh kosong!');
				redirect('admin/kategori');
			}else{
				//mengambil data dari table promo
				$cek = $this->model1->selectWhere("promo", array("no_kategori_promo" => $this->input->post("gb_kat")));
				$cek_kat = $cek->num_rows();
				//mengecek apakah kategori promo sudah terdaftar di database
				if ($cek_kat > 0) {
					//mengambil data dari table kategori
					$get_kat = $this->model1->selectWhere("kategori", array("no_kategori" => $this->input->post("gb_kat")));
					$get_nama = $get_kat->result()[0]->nama_kategori;
					$this->session->set_flashdata('peringatan2', "Promo kategori $get_nama sudah terdaftar");
					redirect('admin/kategori');
					exit();
				}

				$img = explode(".",strtolower($_FILES["gambar"]['name']));
				$nmr = count($img) - 1;
				//jika file gambar diupload valid
				if ($img[$nmr] == "jpg" || $img[$nmr] == "jpeg" || $img[$nmr] == "png") {

					$new = "promo".$this->input->post("gb_kat")."-md.jpg";
					$file = "gambar";
					$direktori = "image/promo/portrait/";
					$width = 250;
					//proses upload & resize gambar
					$this->upload_image_resize($new, $file, $direktori, $width, $img[$nmr]);

					$data = array(
						"id_promo" => null,
						"judul_promo" => "",
						"lama_promo" => "",
						"gambar_promo_md" => $new,
						"gambar_promo_lg" => "",
						"no_kategori_promo" => $this->input->post("gb_kat")
						);
					$insert = $this->model1->insertData("promo", $data);

					if ($insert == 1) {
						$this->session->set_flashdata('sukses2', 'Gambar Kategori Berhasil Ditambahkan');
						redirect('admin/kategori');
					}else{
						$this->session->set_flashdata('gagal2', 'Gambar Kategori Gagal Ditambahkan');
						redirect('admin/kategori');
					}

				//jika bukan file gambar yg diupload
				}else{
					$this->session->set_flashdata('peringatan2', "Upload file gambar! Extension JPG|JPEG|PNG");
					redirect('admin/kategori');
				}
			}

		}else{
			redirect('admin/kategori');	
		}
	}

	private function upload_image_resize($new_name,$file,$dir,$width,$ext)
	{
		//direktori upload
		$dir_upload = $dir . $_FILES[''.$file.'']['name'];

		//simpan gambar dalam ukuran sebenarnya
		move_uploaded_file($_FILES[''.$file.'']['tmp_name'], $dir.$_FILES[''.$file.'']['name']);

		//identitas file asli
		if ($ext == "jpeg" || $ext == "jpg") {
			$img_src = imagecreatefromjpeg($dir_upload);
		}else if ($ext == "png") {
			$img_src = imagecreatefrompng($dir_upload);
		}
		$src_width = imageSX($img_src);
		$src_height = imageSY($img_src);

		//Set ukuran gambar hasil perubahan
		$dst_width = $width;
		$dst_height = ($dst_width/$src_width)*$src_height;

		//proses perubahan ukuran
		$img = imagecreatetruecolor($dst_width, $dst_height);
		imagecopyresampled($img, $img_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

		//simpan gambar
		imagejpeg($img, $dir.$new_name, 100);

		//hapus gambar di memory komputer
		imagedestroy($img_src);
		imagedestroy($img);
		$remove_small = unlink("$dir_upload");
	}

	// ================================================================================
	// ================================= Produk =======================================
	// ================================================================================	

	public function tambah_produk()
	{
		if ($this->input->post("proses")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama produk harus di isi!");
				redirect('admin/produk');
			}else if (empty($_FILES['gambar']['name'][0])) {
				$this->session->set_flashdata('peringatan', "Gambar produk harus di upload!");
				redirect('admin/produk');
			}else if (empty($this->input->post("deskripsi"))) {
				$this->session->set_flashdata('peringatan', "Deskripsi produk harus di isi!");
				redirect('admin/produk');
			}else if (empty($this->input->post("kategori"))) {
				$this->session->set_flashdata('peringatan', "Kategori produk harus di isi!");
				redirect('admin/produk');
			}else if (empty($this->input->post("subkategori"))) {
				$this->session->set_flashdata('peringatan', "Subkategori produk harus di isi!");
				redirect('admin/produk');
			}else if (empty($this->input->post("harga"))) {
				$this->session->set_flashdata('peringatan', "Harga produk harus di isi!");
				redirect('admin/produk');
			}else if (empty($this->input->post("stok"))) {
				$this->session->set_flashdata('peringatan', "Stok produk harus di isi!");
				redirect('admin/produk');
			}else if (!preg_match("/[0-9]/",$this->input->post("harga"))) {
				$this->session->set_flashdata('peringatan', "Harga produk harus berupa angka!");
				redirect('admin/produk');
			}else if (!preg_match("/[0-9]/",$this->input->post("diskon"))) {
				$this->session->set_flashdata('peringatan', "Diskon produk harus berupa angka!");
				redirect('admin/produk');
			}else if (!preg_match("/[0-9]/",$this->input->post("berat"))) {
				$this->session->set_flashdata('peringatan', "Berat produk harus berupa angka!");
				redirect('admin/produk');
			}else if (!preg_match("/[0-9]/",$this->input->post("stok"))) {
				$this->session->set_flashdata('peringatan', "Stok produk harus berupa angka!");
				redirect('admin/produk');
			}else{
				//proses upload file gambar
				include_once("function.php");
				$total_file = count($_FILES['gambar']['tmp_name']);
				if ($total_file <= 4) {
					$img = "";
					for($f = 0; $f < $total_file; $f++){
						$newname = time()."-$f.jpg";
						$img .= upload_gambar_resize($newname,"gambar",$f).",";
					}
					$gambar = substr($img,0,-1);
				}else{
					$this->session->set_flashdata('peringatan', "Maksimal 4 gambar!");
					redirect('admin/produk');
					exit();
				}

				//jika diskon nol maka eksekusi script ini
				if ($this->input->post("diskon") == 0) {
					$harga_diskon = intval($this->input->post("harga"));
				//jika tdk nol maka eksekusi script ini
				}else{
					$disc = intval($this->input->post("harga")) * (intval($this->input->post("diskon"))/100);
					$harga_diskon = intval($this->input->post("harga")) - $disc;
				}

				$id_promo = ($this->input->post("jenis")=="N") ? 99 : $this->input->post("promo");
				$nama_produk = str_replace("'", "\'", str_replace("\"", "\"", str_replace("|", "", $this->input->post("nama"))));
				$deskripsi = str_replace("'", "\'", str_replace("\"", "\"", $this->input->post("deskripsi")));
				//data yang akan dimasukkan ke table produk
				$data = array(
					"no_produk" => null,
					"nama_produk" => trim(htmlentities($nama_produk)),
					"gambar_produk" => $gambar,
					"deskripsi" => trim($deskripsi),
					"no_kategori" => $this->input->post("kategori"),
					"no_subkategori" => $this->input->post("subkategori"),
					"no_brand" => $this->input->post("brand"),
					"harga_produk" => $this->input->post("harga"),
					"harga_diskon" => $harga_diskon,
					"diskon_produk" => intval($this->input->post("diskon")),
					"berat_produk" => intval($this->input->post("berat")),
					"stok_produk" => intval($this->input->post("stok")),
					"dilihat" => 0,
					"terjual" => 0,
					"tgl" => time(),
					"id_promo" => $id_promo
					);
				//proses insert data ke table produk
				$insert = $this->model1->insertData("produk", $data);

				if ($insert == 1) {
					$this->session->set_flashdata('sukses', "Produk baru berhasil ditambahkan!");
					redirect('admin/produk');
				}else{
					$this->session->set_flashdata('gagal', "Produk baru gagal ditambahkan!");
					redirect('admin/produk');
				}
			}

		}else{
			redirect('admin/produk');
		}
	}

	public function edit_produk($id)
	{
		if ($this->input->post("proses")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan2', "Nama produk harus di isi!");
				redirect("admin/produk/$offset/$id");
			}else if (empty($this->input->post("deskripsi"))) {
				$this->session->set_flashdata('peringatan2', "Deskripsi produk harus di isi!");
				redirect("admin/produk/$offset/$id");
			}else if (empty($this->input->post("kategori"))) {
				$this->session->set_flashdata('peringatan2', "Kategori produk harus di isi!");
				redirect("admin/produk/$offset/$id");
			}else if (empty($this->input->post("subkategori"))) {
				$this->session->set_flashdata('peringatan2', "Subkategori produk harus di isi!");
				redirect("admin/produk/$offset/$id");
			}else if (empty($this->input->post("harga"))) {
				$this->session->set_flashdata('peringatan2', "Harga produk harus di isi!");
				redirect("admin/produk/$offset/$id");
			}else if (!preg_match("/[0-9]/",$this->input->post("harga"))) {
				$this->session->set_flashdata('peringatan2', "Harga produk harus berupa angka!");
				redirect("admin/produk/$offset/$id");
			}else if (!preg_match("/[0-9]/",$this->input->post("diskon"))) {
				$this->session->set_flashdata('peringatan2', "Diskon produk harus berupa angka!");
				redirect("admin/produk/$offset/$id");
			}else if (!preg_match("/[0-9]/",$this->input->post("berat"))) {
				$this->session->set_flashdata('peringatan2', "Berat produk harus berupa angka!");
				redirect("admin/produk/$offset/$id");
			}else if (!preg_match("/[0-9]/",$this->input->post("stok"))) {
				$this->session->set_flashdata('peringatan2', "Stok produk harus berupa angka!");
				redirect("admin/produk/$offset/$id");
			}else{
				//mengambil data dari table produk berdasarkan no_produk
				$where = array("no_produk" => $id);
				$get_img = $this->model1->selectWhere("produk", $where);
				
				if (empty($_FILES['gambar']['name'][0])) {
					$gambar = $this->input->post("image");
				}else{
					//proses upload file gambar
					include_once("function.php");
					$total_file = count($_FILES['gambar']['tmp_name']);
					if ($total_file <= 4) {
						$img = "";
						for($f = 0; $f < $total_file; $f++){
							$newname = time()."-$f.jpg";
							$img .= upload_gambar_resize($newname,"gambar",$f).",";
						}
						$gambar = substr($img,0,-1);

						$gambar1 = explode(",", $get_img->result()[0]->gambar_produk);
						$count1 = count($gambar1);
						include_once("variable.php");
						for ($x = 0; $x < $count1; $x++) {
							//hapus gambar yang bersangkutan
							$pathFile1 = $doc_img."/produk-sm/$gambar1[$x]";
							unlink($pathFile1);
							$pathFile2 = $doc_img."/produk-md/$gambar1[$x]";
							unlink($pathFile2);
							$pathFile3 = $doc_img."/produk-lg/$gambar1[$x]";
							unlink($pathFile3);
						}
					}else{
						$this->session->set_flashdata('peringatan2', "Maksimal 4 gambar!");
						redirect("admin/produk/$offset/$id");
						exit();
					}
				}

				//jika diskon nol maka eksekusi script ini
				if ($this->input->post("diskon") == 0) {
					$harga_diskon = intval($this->input->post("harga"));
				//jika tdk nol maka eksekusi script ini
				}else{
					$disc = intval($this->input->post("harga")) * (intval($this->input->post("diskon"))/100);
					$harga_diskon = intval($this->input->post("harga")) - $disc;
				}

				$id_promo = ($this->input->post("jenis")=="N") ? 99 : $this->input->post("promo");
				$nama_produk = str_replace("'", "\'", str_replace("\"", "\"", str_replace("|", "", $this->input->post("nama"))));
				$deskripsi = str_replace("'", "\'", str_replace("\"", "\"", $this->input->post("deskripsi")));
				//data yang akan dimasukkan ke table produk
				$data = array(
					"nama_produk" => trim(htmlentities($nama_produk)),
					"gambar_produk" => $gambar,
					"deskripsi" => trim($deskripsi),
					"no_kategori" => $this->input->post("kategori"),
					"no_subkategori" => $this->input->post("subkategori"),
					"no_brand" => $this->input->post("brand"),
					"harga_produk" => $this->input->post("harga"),
					"harga_diskon" => $harga_diskon,
					"diskon_produk" => intval($this->input->post("diskon")),
					"berat_produk" => intval($this->input->post("berat")),
					"stok_produk" => intval($this->input->post("stok")),
					"id_promo" => $id_promo
					);
				//proses update data produk
				$update = $this->model1->updateData("no_produk",$id,"produk",$data);

				//cek apakah update data berhasil
				if ($update == 1) {
					$this->session->set_flashdata('sukses', "Produk '$nama_produk' berhasil di edit!");
					redirect('admin/produk');
				}else{
					$this->session->set_flashdata('gagal2', "Produk '$nama_produk' gagal di edit!");
					redirect("admin/produk/$offset/$id");
				}
			}

		}else{
			redirect('admin/produk');
		}
	}

	public function hapus_produk($id)
	{
		if (!empty($id)) {
			$dimana = array("no_produk" => $id);
			$select = $this->model1->selectWhere("produk", $dimana);
			$img = $select->result()[0]->gambar_produk;

			$where = array("no_produk" => $id);
			$delete = $this->model1->deleteData("produk", $where);

			//cek apakah proses delete berhasil
			if ($delete == 1) {
				$gambar1 = explode(",", $img);
				$count1 = count($gambar1);
				include_once("variable.php");
				for ($x = 0; $x < $count1; $x++) {
					//hapus gambar yang bersangkutan
					$pathFile1 = $doc_img."/produk-sm/$gambar1[$x]";
					unlink($pathFile1);
					$pathFile2 = $doc_img."/produk-md/$gambar1[$x]";
					unlink($pathFile2);
					$pathFile3 = $doc_img."/produk-lg/$gambar1[$x]";
					unlink($pathFile3);
				}
				redirect("admin/produk");
			}else{
				$this->session->set_flashdata('gagal', "Produk gagal di hapus!");
				redirect("admin/produk");
			}
			
		}else{
			redirect('admin/produk');
		}
	}

	public function daftar()
	{
		if ($this->input->post("daftar")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama harus di isi!");
				redirect("admin/register");
			}else if (empty($this->input->post("user"))) {
				$this->session->set_flashdata('peringatan', "Username harus di isi!");
				redirect("admin/register");
			}else if (empty($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', "Password harus di isi!");
				redirect("admin/register");
			}else if (preg_match("/[^a-zA-Z .]/", $this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama hanya boleh karakter huruf, '.', dan 'Spasi'!");
				redirect("admin/register");
			}else if (!ctype_alnum($this->input->post("user"))) {
				$this->session->set_flashdata('peringatan', "Username hanya boleh karakter huruf atau angka!");
				redirect("admin/register");
			}else if ($this->input->post("pass2") != $this->input->post("pass")) {
				$this->session->set_flashdata('peringatan', "Password tidak sama! Ketik ulang password.");
				redirect("admin/register");
			}else if (!ctype_alnum($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', "Password hanya boleh karakter huruf atau angka!");
				redirect("admin/register");
			}else{
				//cek apakah username sudah terdaftar atau belum di database
				$cek = $this->model1->selectWhere("admin", array("username" => $this->input->post("user")));
				if ($cek->num_rows() > 0) {
					$this->session->set_flashdata('peringatan', "Username sudah terdaftar!");
					redirect("admin/register");
				}else{
					//data yg akan dimasukkan ke database
					$pass = md5("qfe22".sha1(md5("ef49".$this->input->post("pass")."m923"))."pe840");
					$data = array(
						"id_admin" => null,
						"nama" => $this->input->post("nama"),
						"username" => $this->input->post("user"),
						"password" => $pass,
						"level" => $this->input->post("level"),
						"hint" => "",
						"hint_answer" => "",
						"aktif" => "Y",
						"tgl" => time(),
						"online" => "N"
						);
					//proses insert data admin baru
					$insert = $this->model1->insertData("admin",$data);
					//cek apakah proses insert berhasil atau tidak
					if ($insert == 1) {
						$this->session->set_flashdata('sukses', "Daftar Sukses!");
						redirect("admin/register");	
					}else{
						$this->session->set_flashdata('gagal', "Daftar Gagal!");
						redirect("admin/register");
					}
				}
			}
		}else{
			redirect('admin/');
		}
	}

	public function tambah_servis()
	{
		if ($this->input->post("tambah")) {
			//validasi
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama Pelanggan harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("no_telp"))) {
				$this->session->set_flashdata('peringatan', "No Telp / Hp harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("barang"))) {
				$this->session->set_flashdata('peringatan', "Nama Barang harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("kelengkapan"))) {
				$this->session->set_flashdata('peringatan', "Kelengkapan Barang harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("kerusakan"))) {
				$this->session->set_flashdata('peringatan', "Kerusakan Barang harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (preg_match("/[^a-zA-Z .]/", $this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama Pelanggan hanya boleh menggunakan karakter Alfabet, [spasi], dan [.]");
				redirect("admin/servis");
				exit();
			}else{
				//proses input data
				$data = array(
					"id_servis" => null,
					"nama" => $this->input->post("nama"),
					"barang" => $this->input->post("barang"),
					"merk" => $this->input->post("merk"),
					"kelengkapan" => $this->input->post("kelengkapan"),
					"kerusakan" => $this->input->post("kerusakan"),
					"catatan_saran" => "",
					"no_telp" => $this->input->post("no_telp"),
					"status" => "Menunggu",
					"tgl_masuk" => time(),
					"tgl_selesai" => 0
					);
				$insert = $this->model1->insertData("servis", $data);
				//cek apakah proses input berhasil atau gagal
				if ($insert == 1) {
					$this->session->set_flashdata('sukses', "Input data berhasil");
					redirect("admin/servis");
				}else{
					$this->session->set_flashdata('gagal', "Input data gagal");
					redirect("admin/servis");
				}	
			}
		}else{
			redirect('admin/servis');
		}
	}

	public function edit_servis()
	{
		if ($this->input->post("edit")) {
			//validasi
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama Pelanggan harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("no_telp"))) {
				$this->session->set_flashdata('peringatan', "No Telp / Hp harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("barang"))) {
				$this->session->set_flashdata('peringatan', "Nama Barang harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("kelengkapan"))) {
				$this->session->set_flashdata('peringatan', "Kelengkapan Barang harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (empty($this->input->post("kerusakan"))) {
				$this->session->set_flashdata('peringatan', "Kerusakan Barang harus di isi!");
				redirect("admin/servis");
				exit();
			}else if (preg_match("/[^a-zA-Z .]/", $this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama Pelanggan hanya boleh menggunakan karakter Alfabet, [spasi], dan [.]");
				redirect("admin/servis");
				exit();
			}else{
				//proses update data
				$data = array(
					"nama" => $this->input->post("nama"),
					"barang" => $this->input->post("barang"),
					"merk" => $this->input->post("merk"),
					"kelengkapan" => $this->input->post("kelengkapan"),
					"kerusakan" => $this->input->post("kerusakan"),
					"no_telp" => $this->input->post("no_telp")
					);
				$update = $this->model1->updateData("id_servis",$this->input->post("id_servis"),"servis",$data);
				//cek apakah proses update berhasil atau gagal
				if ($update == 1) {
					$this->session->set_flashdata('sukses', "Edit data berhasil");
					redirect("admin/servis");
				}else{
					$this->session->set_flashdata('gagal', "Edit data gagal");
					redirect("admin/servis");
				}
			}
		}else{
			redirect('admin/servis');
		}
	}

	public function hapus_servis($id)
	{
		if (!empty($id)) {
			//proses delete data servis
			$delete = $this->model1->deleteData("servis", array("id_servis" => $id));
			//cek apakah proses delete berhasil atau gagal
			if ($delete == 1) {
				$this->session->set_flashdata('sukses', "Hapus data berhasil");
				redirect("admin/servis");
			}else{
				$this->session->set_flashdata('gagal', "Hapus data gagal");
				redirect("admin/servis");
			}
		}else{
			redirect('admin/servis');
		}
	}

	public function hapus_admin($id, $nama)
	{
		if (!empty($id) && !empty($nama)) {
			$del = $this->model1->deleteData("admin", array("id_admin" => $id));
			if ($del == 1) {
				$this->session->set_flashdata('sukses', "Hapus admin '".$nama."' berhasil");
				redirect("admin/register");
			}else{
				$this->session->set_flashdata('gagal', "Hapus admin '".$nama."' gagal");
				redirect("admin/register");
			}
		}else{
			redirect('admin/');
		}
	}

	public function ubah_profil()
	{
		if ($this->input->post("update")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama harus di isi!");
				redirect("admin/ubah_profil");
			}else if (empty($this->input->post("user"))) {
				$this->session->set_flashdata('peringatan', "Username harus di isi!");
				redirect("admin/ubah_profil");
			}else if (empty($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', "Password harus di isi!");
				redirect("admin/ubah_profil");
			}else if (empty($this->input->post("jawaban"))) {
				$this->session->set_flashdata('peringatan', "Jawaban hint harus di isi!");
				redirect("admin/ubah_profil");
			}else if (preg_match("/[^a-zA-Z .]/", $this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', "Nama hanya boleh menggunakan karakter huruf, '.', dan 'Spasi'");
				redirect("admin/ubah_profil");
			}else if (!ctype_alnum($this->input->post("user"))) {
				$this->session->set_flashdata('peringatan', "Username hanya boleh karakter huruf atau angka!");
				redirect("admin/ubah_profil");
			}else if ($this->input->post("pass2") != $this->input->post("pass")) {
				$this->session->set_flashdata('peringatan', "Password tidak sama! Ketik ulang password.");
				redirect("admin/ubah_profil");
			}else if (!ctype_alnum($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', "Password hanya boleh karakter huruf atau angka!");
				redirect("admin/ubah_profil");
			}else if (preg_match("/[^\w ]/", $this->input->post("jawaban"))) {
				$this->session->set_flashdata('peringatan', "Jawaban hanya boleh menggunakan karakter huruf, angka, dan 'Spasi'");
				redirect("admin/ubah_profil");
			}else{
				//cek apakah username sudah terdaftar atau belum di database
				$user = $this->input->post("user");
				$old = $this->input->post("old_user");
				$cek = $this->model1->selectWhereSpec("admin", array("username" => $user, "username !=" => $old));
				if ($cek->num_rows() > 0) { //jika sudah terdaftar
					$this->session->set_flashdata('peringatan', "Username sudah terdaftar!");
					redirect("admin/ubah_profil");
				}else{ //jika belum terdaftar
					$pass = md5("qfe22".sha1(md5("ef49".$this->input->post("pass")."m923"))."pe840");
					$data = array(
						"nama" => $this->input->post("nama"),
						"username" => $this->input->post("user"),
						"password" => $pass,
						"hint" => $this->input->post("hint"),
						"hint_answer" => $this->input->post("jawaban")
						);
					$update = $this->model1->updateData("id_admin",$this->input->post("id_admin"),"admin",$data);
					if ($update == 1) {
						$_SESSION['nama'] = $this->input->post("nama");
						$this->session->set_flashdata('sukses', "Profil berhasil diperbaharui!");
						redirect("admin/ubah_profil");
					}else{
						$this->session->set_flashdata('gagal', "Profil gagal diperbaharui!");
						redirect("admin/ubah_profil");
					}
				}
			}
		}else{
			redirect('admin/');
		}
	}

	public function upload_foto()
	{
		if ($this->input->post("btn_upload_foto")) {
			if (empty($_FILES['upload_foto']['name'])) {
				redirect('admin/');
			}else if ($_FILES['upload_foto']['size'] > 600000) {
				$this->session->set_flashdata('warning', 'Maximal ukuran gambar 600kb!');
				redirect('admin');
				exit();
			}else{
				$ext = explode(".", strtolower($_FILES['upload_foto']['name']));
				$c = count($ext) - 1;
				if ($ext[$c] == "jpg" || $ext[$c] == "jpeg" || $ext[$c] == "png") {
					//mengambil data username dri tbl admin berdasarkan id_admin
					$sql_user = $this->model1->selectWhere("admin", array("id_admin" => $_SESSION['admin']));
					$user = $sql_user->result()[0];
					//proses upload n resize foto
					$this->img_upload_resize("upload_foto", "$user->username.jpg", 50, $ext[$c]);
					//proses update foto pd tbl customer
					$foto = strval("$user->username.jpg");
					$update = $this->model1->updateData("id_admin", $_SESSION['admin'], "admin", array("foto" => $foto));
					if ($update == 1) {
						$_SESSION['foto_admin'] = $foto;
						$this->session->set_flashdata('success', 'Upload foto berhasil!');
						redirect('admin/');
					}else{
						$this->session->set_flashdata('error', 'Upload foto gagal!');
						redirect('admin/');
					}
				}else{
					$this->session->set_flashdata('warning', 'Upload gambar berekstensi JPG, JPEG, atau PNG');
					redirect('admin/');
					exit();
				}
			}
		}else{
			redirect('admin/');	
		}
	}

	private function img_upload_resize($file, $newname, $width, $type)
	{
		$path = "image/foto/admin/$newname";
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

	public function login_admin()
	{
		if ($this->input->post("login")) {
			if (!ctype_alnum($this->input->post("user"))) {
				$this->session->set_flashdata('peringatan', "Username tidak valid!");
				redirect("login_admin/");
			}else if (!ctype_alnum($this->input->post("pass"))) {
				$this->session->set_flashdata('peringatan', "Password tidak valid!");
				redirect("login_admin/");
			}else{
				$pass = md5("qfe22".sha1(md5("ef49".$this->input->post("pass")."m923"))."pe840");
				$where = array(
					"username" => $this->input->post("user"),
					"password" => $pass
					);
				$cek = $this->model1->selectWhereSpec("admin",$where);
				if ($cek->num_rows() > 0) {
					$data = $cek->result()[0];
					if ($data->level != "teknisi") { //jika admin yg login bukan teknisi
						//ubah status jd online
						$online = $this->model1->updateDataSpec($where, "admin", array("online" => "Y"));
						if ($online > 0) { //jika proses update sukses
							//buat session
							$_SESSION['admin'] = $data->id_admin;
							$_SESSION['level'] = $data->level;
							$_SESSION['nama']  = $data->nama;
							$_SESSION['foto_admin'] = $data->foto;
							redirect('admin/');	
						}else{ //jika proses update gagal
							$this->session->set_flashdata('peringatan', "Gagal login! silakan coba lagi.");
							redirect("login_admin/");
						}
					}else{ //jika teknisi
						//buat session
						$_SESSION['admin'] = $data->id_admin;
						$_SESSION['level'] = $data->level;
						$_SESSION['nama']  = $data->nama;
						$_SESSION['foto_admin'] = $data->foto;
						redirect('admin/');	
					}
				}else{
					$this->session->set_flashdata('gagal', "Username atau Password salah!");
					redirect("login_admin/");	
				}
			}
		}else{
			redirect('/');
		}
	}

	public function logout_admin()
	{
		//ubah status jd offline
		$offline = $this->model1->updateData("id_admin",$_SESSION['admin'],"admin",array("online" => "N"));
		//hapus isi tbl chatting_online n chatting_pesan
		$cekChatOnline = $this->model1->selectData("chatting_online");
		if ($cekChatOnline->num_rows() > 0) { //jika tbl chatting_online tdk kosong maka lakukan delete
			$this->model1->selectQuery2("DELETE FROM chatting_online");
		}
		$cekChatPesan = $this->model1->selectData("chatting_pesan");
		if ($cekChatPesan->num_rows() > 0) { //jika tbl chatting_pesan tdk kosong maka lakukan delete
			$this->model1->selectQuery2("DELETE FROM chatting_pesan");
		}
		//hapus session
		session_destroy();
		redirect('/');
	}

}

/* End of file crud.php */
/* Location: ./application/controllers/crud.php */