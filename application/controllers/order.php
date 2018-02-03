<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function index()
	{		
		//jika ada session id customer maka eksekusi script dibawah ini
		if (isset($_SESSION['id_customer'])) {
			$customer = $_SESSION['id_customer'];
			$name = "id_customer";
			$val = $_SESSION['id_customer'];
			$tbl = "customer";
			$id = "id_customer";

		//jika tdk ada session id maka eksekusi script dibawah ini	
		}else{
			$customer = $_COOKIE['temp_customer'];
			$name = "id_cst_sementara";
			$val = $_COOKIE['temp_customer'];
			$tbl = "customer_sementara";
			$id = "id_customer_sementara";
		}

		$data['qry1'] = $this->model1->selectWhere($tbl, array($id => $customer));
		$data['sql_p'] = $this->model1->selectData("master_provinsi");
		$data['sql_k'] = $this->model1->selectData("master_kokab");
		$data['sql_kc'] = $this->model1->selectData("master_kecam");
	    $data['cek_troli'] = $this->model1->selectWhere("troli", array($name => $val));

	    //jika ada session id customer
		if (isset($_SESSION['id_customer'])) {
			$get_cst = $this->model1->selectWhere("customer", array("id_customer" => $_SESSION['id_customer']));
			$data['cst'] = $get_cst->result()[0];
		}

		$data['get_troli'] = $this->model1->joinData("troli","produk","INNER JOIN", "troli.id_produk = produk.no_produk AND troli.$name = '$val' ORDER BY troli.tgl DESC");

		//mengambil dan menghitung total dari subtotal
		$p_total = $this->model1->SUM("troli","subtotal", array($name => $val));
		$data['total'] = $p_total->result()[0]->subtotal;
		
		$this->load->view("order", $data);
	}

}

/* End of file order.php */
/* Location: ./application/controllers/order.php */