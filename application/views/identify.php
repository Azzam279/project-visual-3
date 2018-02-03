<?php
//jika ada session id customer maka eksekusi script dibawah ini
if (isset($_SESSION['id_customer'])) {
	$customer = $_SESSION['id_customer'];
	$tmp_customer = 0;
	$name = "id_customer";
	$val = $_SESSION['id_customer'];

	if(isset($_COOKIE['temp_customer'])){setcookie("temp_customer", $_COOKIE['temp_customer'], time()-(86400*7), "/");}

	//mengambil data status_barang = dikirim dari table order_produk berdasarkan id customer
	$queryOrder = "SELECT status_barang FROM order_produk WHERE id_customer = ? AND notif = ?";
	$dataOrder = array($_SESSION['id_customer'], "Y");
	$sql_pesanan_saya = $this->model1->selectQuery($queryOrder,$dataOrder);
	$my_order = $sql_pesanan_saya->num_rows();

//jika tdk ada session id maka eksekusi script dibawah ini	
}else{
	//jika ada cookie temp_customer
	if(isset($_COOKIE['temp_customer'])) {
		$customer = 0;
		$tmp_customer = $_COOKIE['temp_customer'];
		$name = "id_cst_sementara";
		$val = $_COOKIE['temp_customer'];
	//jika tidak ada cookie, maka buat cookie
	}else{
		session_regenerate_id();
		//set cookie selama 1 tahun
		setcookie("del_temp_customer", session_id(), time()+(86400*365), "/");
		//set cookie selama 7 hari
		setcookie("temp_customer", session_id(), time()+(86400*7), "/");
		$customer = 0;
		$tmp_customer = session_id();
		$name = "id_cst_sementara";
		$val = session_id();
	}
	$my_order = 0;
}

//menghitung pengunjung
$cek_ip_visitor = $this->model1->selectWhere("counting_visitor", array("ip" => $_SERVER['REMOTE_ADDR']));
if ($cek_ip_visitor->num_rows() == 0) {
	$this->model1->insertData("counting_visitor", array("id_visitor" => null, "ip" => $_SERVER['REMOTE_ADDR'], "tgl" => time()));
}
?>
