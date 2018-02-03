<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_produk extends CI_Controller {

	public function index()
	{
		redirect('/');
	}

	public function p($id)
	{
		if (empty($id)) {
			redirect('/');
		}else{
			$time = time();
			$cek = $this->model1->selectQuery2("SELECT * FROM produk INNER JOIN promo ON produk.id_promo = promo.id_promo AND promo.lama_promo > $time AND produk.no_produk = '$id'");
			if ($cek->num_rows() < 1) {
				echo "<script>alert('Produk Promo ini sudah expired!');</script>";
			}else{
				$data['id_product'] = $id;
				$where_produk = array("no_produk" => $id);
				$data['detail'] = $this->model1->selectWhere("produk", $where_produk);
				$this->load->view("detil-produk", $data);
			}
		}
	}

	public function feedback($id)
	{
		if (!empty($_SESSION['id_customer'])) {
			if ($this->input->post("kirim_feed") && !empty($id)) {
				if (empty($this->input->post("feedback"))) {
					$this->session->set_flashdata('peringatan', 'Kolom feedback harus di isi!');
					redirect("detail_produk/p/$id");
					exit();
				}else{
					//proses insert feedback
					$feedback = trim(nl2br(strip_tags($this->input->post("feedback"))));
					$data = array(
						"id_feedback" => null,
						"id_customer" => $_SESSION['id_customer'],
						"id_produk" => $id,
						"feedback" => $feedback,
						"tipe" => $this->input->post("tipe"),
						"tgl" => time(),
						"notif" => 'Y'
						);
					$insert = $this->model1->insertData("feedback", $data);
					//cek apakah insert feedback sukses atau gagal
					if ($insert == 1) {
						$this->session->set_flashdata('sukses', 'Feedback berhasil dikirim!');
						redirect("detail_produk/p/$id");
					}else{
						$this->session->set_flashdata('sukses', 'Feedback gagal dikirim!');
						redirect("detail_produk/p/$id");
					}
				}
			}else{
				redirect('/');
			}
		}else{
			redirect('/');
		}
	}

}

/* End of file detail_produk.php */
/* Location: ./application/controllers/detail_produk.php */