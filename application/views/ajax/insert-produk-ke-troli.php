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

//jika ada POST beli dan id_produk
if (isset($_POST['beli']) && isset($_POST['id_produk']) && isset($_POST['berat'])) {
	//mengambil data dari table produk berdasarkan no produk
	$get = $this->model1->selectWhere("produk", array("no_produk" => $_POST['id_produk']));
	$p = $get->result()[0];
	//mengambil data dari table troli
	$where_troli = array(
		$name => $val,
		"id_produk" => $_POST['id_produk']
		);
	$troli = $this->model1->selectWhereSpec("troli", $where_troli);
	$id = $troli->num_rows();

	//jika diskon 0%
	if ($p->diskon_produk == 0) {
		$harga = $p->harga_produk;
	//jika diskon tdk 0%
	}else{
		$diskon = $p->harga_produk * ($p->diskon_produk/100);
		$harga = $p->harga_produk - $diskon;
	}

	//jika id produk yg bersangkutan kosong di table troli maka lakukan insert data
	if ($id < 1) {
		$subtotal = $harga * $_POST['beli'];
		$berat = $_POST['berat'] * $_POST['beli'];
		$tgl_exp = time() + (86400*3);
		//data yg akan dimasukkan ke table troli
		$data = array(
			"id_troli" => null,
			"id_produk" => $_POST['id_produk'],
			"id_customer" => $customer,
			"id_cst_sementara" => $tmp_customer,
			"kuantitas" => $_POST['beli'],
			"subtotal" => $subtotal,
			"berat" => $berat,
			"tgl" => time(),
			"tgl_exp" => $tgl_exp
			);
		//proses insert data ke troli
		$insert = $this->model1->insertData("troli", $data);
		
		//cek apakah proses insert berhasil
		if ($insert == 1) {
			$get_troli = $this->model1->joinData("troli","produk","INNER JOIN","troli.id_produk = produk.no_produk AND troli.$name = '$val' ORDER BY troli.tgl DESC");
?>
<div class="row">
	<div class="col-md-12">
		<div id="cart-loading">
			<div class="preloader5" style="left:50%;top:50%;margin:-15px 0 0 -15px;position:absolute"></div>
		</div>
		<div id="isi-all-produk-wrapper">
		<?php
		foreach ($get_troli->result() as $cart) {
			//memecah array gambar
			$img = explode(",", $cart->gambar_produk);

			//jika diskon 0%
			if ($cart->diskon_produk == 0) {
				$harga2 = $cart->harga_produk;
			//jika diskon tdk 0%
			}else{
				$diskon2 = $cart->harga_produk * ($cart->diskon_produk/100);
				$harga2 = $cart->harga_produk - $diskon2;
			}
		?>
		<div class="isi-semua-produk" id="<?php echo "id$cart->id_troli"; ?>">
			<div>
				<img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" class="img-responsive">
			</div>
			<div>
				<h5>
					<?php echo $cart->nama_produk; ?>
				</h5>
				<h6>Rp <?php echo number_format($harga2,0,",","."); ?></h6>
			</div>
			<div>
				<select class="form-control" onchange="change_qty(<?php echo $cart->id_troli; ?>,this.value,<?php echo $harga2; ?>,<?php echo $cart->berat_produk ?>)">
					<?php
					for ($sk = 1; $sk <= $cart->stok_produk; $sk++) {
						if ($sk == $cart->kuantitas) {
							echo "
							<option value='$sk' selected>$sk</option>
							";
						}else{
							echo "
							<option value='$sk'>$sk</option>
							";
						}
					}
					?>
				</select>
			</div>
			<div id="<?php echo "trash-loader$cart->id_troli"; ?>">
				<a href="javascript:void(0)" title="Hapus" onclick="del_item(<?php echo $cart->id_troli;?>)">
					<div id="trash-cart"><i class="glyphicon glyphicon-trash"></i></div>
				</a>
			</div>
			<div class="clearfix"></div>
			<hr>
		</div>
		<?php
		}
		?>
		</div>

		<div class="info-total-harga clearfix">
			<ul>
				<li>
				<?php
				$getTotal = $this->model1->SUM("troli","subtotal",array($name => $val));
				$total = $getTotal->result()[0]->subtotal;
				?>
					<div class="pull-left">Total Harga Barang :</div>
					<div class="pull-right" id="total_cart">Rp <?php echo number_format($total,0,",","."); ?></div>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
		}else{
			echo "insert_gagal";
		}

	//jika tdk kosong, maka lakukan update data
	}else{
		//data yg akan dimasukkan ke troli
		$subtotal = $harga * $_POST['beli'];
		$berat = $_POST['berat'] * $_POST['beli'];
		$data = array(
			"kuantitas" => $_POST['beli'],
			"subtotal" => $subtotal,
			"berat" => $berat,
			"tgl" => time()
			);
		//update berdasarkan
		$array = array(
			$name => $val,
			"id_produk" => $_POST['id_produk']
			);
		//proses update data troli
		$update = $this->model1->updateDataSpec($array, "troli", $data);
		//cek apakah proses update berhasil
		if ($update == 1) {
			//echo "update_sukses";
			$get_troli = $this->model1->joinData("troli","produk","INNER JOIN","troli.id_produk = produk.no_produk AND troli.$name = '$val' ORDER BY troli.tgl DESC");
?>
<div class="row">
	<div class="col-md-12">
		<div id="cart-loading">
			<div class="preloader5" style="left:50%;top:50%;margin:-15px 0 0 -15px;position:absolute"></div>
		</div>
		<div id="isi-all-produk-wrapper">
		<?php
		foreach ($get_troli->result() as $cart) {
			//memecah array gambar
			$img = explode(",", $cart->gambar_produk);

			//jika diskon 0%
			if ($cart->diskon_produk == 0) {
				$harga2 = $cart->harga_produk;
			//jika diskon tdk 0%
			}else{
				$diskon2 = $cart->harga_produk * ($cart->diskon_produk/100);
				$harga2 = $cart->harga_produk - $diskon2;
			}
		?>
		<div class="isi-semua-produk" id="<?php echo "id$cart->id_troli"; ?>">
			<div>
				<img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" class="img-responsive">
			</div>
			<div>
				<h5>
					<?php echo $cart->nama_produk; ?>
				</h5>
				<h6>Rp <?php echo number_format($harga2,0,",","."); ?></h6>
			</div>
			<div>
				<select class="form-control" onchange="change_qty(<?php echo $cart->id_troli; ?>,this.value,<?php echo $harga2; ?>,<?php echo $cart->berat_produk ?>)">
					<?php
					for ($sk = 1; $sk <= $cart->stok_produk; $sk++) {
						if ($sk == $cart->kuantitas) {
							echo "
							<option value='$sk' selected>$sk</option>
							";
						}else{
							echo "
							<option value='$sk'>$sk</option>
							";
						}
					}
					?>
				</select>
			</div>
			<div id="<?php echo "trash-loader$cart->id_troli"; ?>">
				<a href="javascript:void(0)" title="Hapus" onclick="del_item(<?php echo $cart->id_troli;?>)">
					<div id="trash-cart"><i class="glyphicon glyphicon-trash"></i></div>
				</a>
			</div>
			<div class="clearfix"></div>
			<hr>
		</div>
		<?php
		}
		?>
		</div>

		<div class="info-total-harga clearfix">
			<ul>
				<li>
				<?php
				$getTotal = $this->model1->SUM("troli","subtotal",array($name => $val));
				$total = $getTotal->result()[0]->subtotal;
				?>
					<div class="pull-left">Total Harga Barang :</div>
					<div class="pull-right" id="total_cart">Rp <?php echo number_format($total,0,",","."); ?></div>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php
		}else{
			echo "update_gagal";
		}
	}

?>

<script>
	//mengganti kuantitas produk
	function change_qty(id,qty,price,berat) {
		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/select-kuantitas"); ?>',
			type: 'POST',
			dataType: 'html',
			data: 'id_troli='+id+'&qty='+qty+'&harga='+price+'&berat='+berat,
			beforeSend: function() {
				$("#cart-loading").css("display","block");
			},
			success: function(hasil) {
				$("#total_cart").html(hasil);
				$("#total-harga-dikeranjang").html(hasil);
				$("#cart-loading").css("display","none");
			},
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
		});
	}
	
	//menghapus barang/produk
	function del_item(id) {
		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/hapus-items"); ?>',
			type: 'POST',
			dataType: 'html',
			data: 'id_troli='+id,
			beforeSend: function() {
				$("#trash-loader"+id).addClass("preloader6");
			},
			success: function(hasil) {
				$("#id"+id).slideUp();
				$("#total_cart").html(hasil);
				$("#total-harga-dikeranjang").html(hasil);

				//menghitung total item/barang yg ada di troli
				$.ajax({
					url: '<?php echo base_url("ajax/index/ajax/hapus-items"); ?>',
					type: 'POST',
					dataType: 'html',
					data: 'hitung=items',
					success: function(hasil2) {
						$("#jml-item-dikeranjang").html(hasil2);
					}
				});
			},
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
		});
	}
</script>

<?php
}else{
	redirect('/');
}
?>