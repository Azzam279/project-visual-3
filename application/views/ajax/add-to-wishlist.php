<?php
if (isset($_GET['wishlist'])) {
	//mengambil data id customer dan id produk dari tbl wishlist
	$where = array("id_customer" => $_SESSION['id_customer'], "id_produk" => $_GET['wishlist']);
	$cek = $this->model1->selectWhereSpec("wishlist", $where);
	//mengecek apakah produk yg ditambahkan sudah terdaftar atau blm
	if ($cek->num_rows() > 0) { //jika sdh, lakukan update
		$array = array(
			"id_customer" => $_SESSION['id_customer'],
			"id_produk" => $_GET['wishlist']
			);
		$update = $this->model1->updateDataSpec($array,"wishlist", array("tgl" => time()));
		if ($update == 1) {
			echo "<h4><span class='label label-success'>Produk berhasil ditambahkan ke Wishlist!</span></h4>";
		}else{
			echo "<h4><span class='label label-danger'>Produk gagal ditambahkan ke Wishlist!</span></h4>";
		}
	}else{ //jika blm, lakukan insert
		if ($cek->num_rows() > 20) {
			echo "<h4><span class='label label-warning'>Wishlist anda telah mencapai batas maksimal!</span></h4>";
		}else{
			$data = array(
				"id_wishlist" => null,
				"id_customer" => $_SESSION['id_customer'],
				"id_produk" => $_GET['wishlist'],
				"tgl" => time()
				);
			$insert = $this->model1->insertData("wishlist", $data);
			if ($insert == 1) {
				echo "<h4><span class='label label-success'>Produk berhasil ditambahkan ke Wishlist!</span></h4>";
			}else{
				echo "<h4><span class='label label-danger'>Produk gagal ditambahkan ke Wishlist!</span></h4>";
			}
		}
	}
}else{
	redirect('/');
}
?>