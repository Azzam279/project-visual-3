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

//jika ada POST id_troli
if (isset($_POST['id_troli'])) {
	//proses delete data di table troli
	$where = array(
		"id_troli" => $_POST['id_troli'],
		$name => $val
		);
	$delete = $this->model1->deleteData("troli", $where);

	//cek apakah proses delete sukses
	if ($delete == 1) {
		//menghitung total dari subtotal
		$get_total = $this->model1->SUM("troli","subtotal",array($name => $val));
		$total = $get_total->result()[0]->subtotal;
		echo "Rp ".number_format($total,0,",",".");
	}else{
		echo "Error: Proses delete gagal.";
	}
}
//jika ada POST hitung = items
if (@$_POST['hitung'] == "items") {
	//menghitung total item
	$count = $this->model1->selectWhere("troli", array($name => $val));
	$items = $count->num_rows();
	echo $items;
}
//jika POST id_troli dan hitung kosong maka arahkan ke homepage
if (empty($_POST['id_troli']) && empty($_POST['hitung'])) {
	redirect('/');
}
?>