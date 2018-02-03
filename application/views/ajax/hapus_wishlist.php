<?php
if ($_GET['id_wishlist']) {
	//proses hapus wishlist berdasarkan id wishlist
	$sql_del = $this->model1->deleteData("wishlist", array("id_wishlist" => $_GET['id_wishlist']));
	if ($sql_del == 1) {
		echo "Sukses";
	}else{
		echo "Gagal";
	}
}else{
	redirect('/');
}
?>