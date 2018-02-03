<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordered extends CI_Controller {

	public function index()
	{
		if ($this->input->post("beli")) {
			if (empty($this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', 'Nama harus di isi.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("email"))) {
				$this->session->set_flashdata('peringatan', 'Email harus di isi.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("alamat"))) {
				$this->session->set_flashdata('peringatan', 'Alamat harus di isi.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("provinsi"))) {
				$this->session->set_flashdata('peringatan', 'Provinsi harus di isi.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("kota"))) {
				$this->session->set_flashdata('peringatan', 'Kota/Kabupaten harus di isi.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("ongkir"))) {
				$this->session->set_flashdata('peringatan', 'Pilih Jasa Kurir yang Anda inginkan.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("kodepos"))) {
				$this->session->set_flashdata('peringatan', 'Kode Pos harus di isi.');
				redirect('order');
				exit();
			}else if (empty($this->input->post("no_hp"))) {
				$this->session->set_flashdata('peringatan', 'No. Handphone harus di isi.');
				redirect('order');
				exit();
			}else if (preg_match("/[^a-zA-Z ]/",$this->input->post("nama"))) {
				$this->session->set_flashdata('peringatan', 'Nama harus berupa Alfabet.');
				redirect('order');
				exit();
			}else if (!filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
				$this->session->set_flashdata('peringatan', 'Email tidak valid.');
				redirect('order');
				exit();
			}else if (!preg_match("/[0-9]/",$this->input->post("kodepos"))) {
				$this->session->set_flashdata('peringatan', 'Kode Pos harus berupa Angka.');
				redirect('order');
				exit();
			}else if (!preg_match("/[0-9]/",$this->input->post("no_hp"))) {
				$this->session->set_flashdata('peringatan', 'No. Handphone harus berupa Angka.');
				redirect('order');
				exit();
			}else if (!preg_match("/[0-9]{1,13}/",$this->input->post("no_hp"))) {
				$this->session->set_flashdata('peringatan', 'No. Handphone max 13 digit.');
				redirect('order');
				exit();
			}else{
				//jika ada session id customer maka eksekusi script dibawah ini
				if (isset($_SESSION['id_customer'])) {
					$customer = $_SESSION['id_customer'];
					$name = "id_customer";
					$val = $_SESSION['id_customer'];
					$tbl = "customer";
					$id = "id_customer";
					$id_customer = $_SESSION['id_customer'];
					$id_cst_sementara = 0;
					//proses update data customer
					$array = array(
						"nama" => $this->input->post("nama"),
						"email" => $this->input->post("email"),
						"alamat" => trim(htmlentities(nl2br($this->input->post("alamat")))),
						"provinsi" => $this->input->post("provinsi"),
						"kota" => $this->input->post("kota"),
						"kecamatan" => 0,
						"no_hp" => $this->input->post("no_hp"),
						"kode_pos" => $this->input->post("kodepos")
						);
					$update = $this->model1->updateData("id_customer",$_SESSION['id_customer'],"customer", $array);

				//jika tdk ada session id maka eksekusi script dibawah ini	
				}else{
					$customer = $_COOKIE['temp_customer'];
					$name = "id_cst_sementara";
					$val = $_COOKIE['temp_customer'];
					$tbl = "customer_sementara";
					$id = "id_customer_sementara";
					$id_customer = 0;
					$id_cst_sementara = $_COOKIE['temp_customer'];
					//proses insert data customer sementara
					$array = array(
						"id_customer_sementara" => null,
						"id_cst" => $_COOKIE['temp_customer'],
						"nama" => $this->input->post("nama"),
						"email" => $this->input->post("email"),
						"sex" => "-Kosong-",
						"tgl_lahir" => "0000-00-00",
						"alamat" => trim(htmlentities(nl2br($this->input->post("alamat")))),
						"provinsi" => $this->input->post("provinsi"),
						"kota" => $this->input->post("kota"),
						"kecamatan" => 0,
						"no_hp" => $this->input->post("no_hp"),
						"kode_pos" => $this->input->post("kodepos"),
						"tgl" => time()
						);
					$insert = $this->model1->insertData("customer_sementara", $array);
				}

				//mengambil data dari table troli dan produk
	    		$get_troli = $this->model1->joinData("troli","produk","INNER JOIN", "troli.id_produk = produk.no_produk AND troli.$name = '$val' ORDER BY troli.tgl DESC");
	    		//mengambil dan menghitung total dari subtotal + ongkir
	    		$get_total = $this->model1->SUM("troli","subtotal",array($name => $val));
	    		//memecah array ongkir
	    		$ongkir = explode("|", $this->input->post("ongkir"));
	    		//hitung total
	    		$total = $get_total->result()[0]->subtotal + $ongkir[2];

	    		//proses penggabungan string
	    		$id_produk="";$nm_produk="";$img="";$harga="";$qty="";$sub="";
	    		foreach ($get_troli->result() as $troli) {
	    			if ($troli->diskon_produk == 0) {
	    				$hargaP = $troli->harga_produk;
	    			}else{
	    				$diskon = $troli->harga_produk * ($troli->diskon_produk/100);
	    				$hargaP = $troli->harga_produk - $diskon;
	    			}
	    			$id_produk .= $troli->id_produk."|";
	    			$nm_produk .= $troli->nama_produk."|";
	    			$img .= $troli->gambar_produk."|";
	    			$harga .= $hargaP."|";
	    			$qty .= $troli->kuantitas."|";
	    			$sub .= $troli->subtotal."|";
	    		}

	    		//data yg akan dimasukkan ke table order_produk
	    		$data_order = array(
	    			"id_order" => null,
	    			"id_produk" => substr($id_produk, 0,-1),
	    			"id_customer" => $id_customer,
	    			"id_cst_sementara" => $id_cst_sementara,
	    			"produk" => substr($nm_produk, 0,-1),
	    			"gambar" => substr($img, 0,-1),
	    			"harga" => substr($harga, 0,-1),
	    			"kuantitas" => substr($qty, 0,-1),
	    			"subtotal" => substr($sub, 0,-1),
	    			"total" => $total,
	    			"ongkir" => $ongkir[2],
	    			"kurir" => $ongkir[0],
	    			"etd" => $ongkir[1],
	    			"no_resi" => 0,
	    			"status_barang" => "N",
	    			"tgl" => time(),
	    			"tgl_exp" => time()+43200,
	    			"notif" => "N"
	    			);
	    		//proses insert data ke table order_produk
	    		$order = $this->model1->insertData("order_produk", $data_order);

	    		//cek apakah proses insert order berhasil
	    		if ($order == 1) {
	    			//proses hapus item di troli berdasarkan id customer
	    			$delete = $this->model1->deleteData("troli", array($name => $val));
	    			//mengambil data order produk berdasarkan id customer
	    			$this->db->order_by("id_order","DESC");
	    			$data['select'] = $this->model1->selectWhere("order_produk", array($name => $val));
	    			$this->load->view("order-finish", $data);
	    		}else{
	    			$this->session->set_flashdata('gagal', 'Error: Konfirmasi beli gagal.');
					redirect('order');
					exit();
	    		}
			}

		}else{
			redirect('/');
		}
	}

}

/* End of file proses-order.php */
/* Location: ./application/controllers/proses-order.php */