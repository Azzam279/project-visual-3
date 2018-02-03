<?php
//jika ada session id customer maka eksekusi script dibawah ini
if (isset($_SESSION['id_customer'])) {
	$customer = $_SESSION['id_customer'];
	$tmp_customer = 0;
	$name = "id_customer";
	$val = $_SESSION['id_customer'];

//jika tdk ada session id maka eksekusi script dibawah ini	
}else{
	$customer = 0;
	$tmp_customer = $_COOKIE['temp_customer'];
	$name = "id_cst_sementara";
	$val = $_COOKIE['temp_customer'];
}

if (isset($_POST['id_troli']) && isset($_POST['qty']) && isset($_POST['harga']) && isset($_POST['berat'])) {
	
	//data yg akan dimasukkan ke troli
	$subtotal = $_POST['qty'] * $_POST['harga'];
	$berat = $_POST['berat'] * $_POST['qty'];
	$data = array(
		"kuantitas" => $_POST['qty'],
		"subtotal" => $subtotal,
		"berat" => $berat,
		"tgl" => time() 
		);
	//update berdasarkan
	$where = array(
		"id_troli" => $_POST['id_troli'],
		$name => $val
		);
	//proses update troli
	$update = $this->model1->updateDataSpec($where, "troli", $data);
	//cek apakah proses update troli berhasil
	if ($update == 1) {
		//menjumlahkan subtotal dari troli
		$select = $this->model1->SUM("troli","subtotal", array($name => $val));
		$total = $select->result()[0]->subtotal;
		echo "Rp ".number_format($total,0,",",".");	
	}else{
		echo "Terjadi error!";
	}

}

if (isset($_POST['qty2']) && isset($_POST['harga2'])) {
	$subtotal2 = $_POST['qty2'] * $_POST['harga2'];
	echo "Rp ".number_format($subtotal2,0,",",".");
}
?>