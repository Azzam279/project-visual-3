<?php
//jika ada session id customer maka eksekusi script dibawah ini
if (isset($_SESSION['id_customer'])) {
	$customer = $_SESSION['id_customer'];
	$tmp_customer = 0;
	$name = "id_customer";
	$val = $_SESSION['id_customer'];

//jika tdk ada session id maka eksekusi script dibawah ini	
}else{
	//jika ada cookie temp_customer
	if(isset($_COOKIE['temp_customer'])) {
		$customer = 0;
		$tmp_customer = $_COOKIE['temp_customer'];
	//jika tdk ada, maka buat cookie
	}else{
		$customer = 0;
		session_regenerate_id();
		$temp_customer = session_id();
		//set cookie selama 1 tahun
		setcookie("del_temp_customer", $temp_customer, time()+(86400*365), "/");
		//set cookie selama 7 hari
		setcookie("temp_customer", $temp_customer, time()+(86400*7), "/");
		$tmp_customer = $_COOKIE['temp_customer'];
	}
	$name = "id_cst_sementara";
	$val = $_COOKIE['temp_customer'];
}

//jika ada POST hitung = total
if (@$_POST['hitung'] == "total") {
	//menjumlahkan subtotal dari troli
	$select = $this->model1->SUM("troli","subtotal", array($name => $val));
	$total = $select->result()[0]->subtotal;
	echo "Rp ".number_format($total,0,",",".");	
}
//jika ada POST hitung = items
if (@$_POST['hitung'] == "items") {
	//menghitung total item
	$count = $this->model1->selectWhere("troli", array($name => $val));
	$items = $count->num_rows();
	echo $items;
}
//jika POST hitung kosong maka arahkan ke homepage
if (empty($_POST['hitung'])) {
	redirect('/');
}
?>