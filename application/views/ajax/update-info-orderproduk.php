<?php
if (isset($_GET['jumlah']) && isset($_SESSION['id_customer'])) {
	$data = array("notif" => "N");
	$update = $this->model1->updateData("id_customer",$_SESSION['id_customer'],"order_produk",$data);
}else{
	redirect('/');
}
?>