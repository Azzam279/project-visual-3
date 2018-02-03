<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Keranjang Belanja</title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style2.css"); ?>">
    <style>
	.carousel {
	    margin-bottom: 0;
	    padding: 0 40px 30px 40px;
	}
	/* The controlsy */
	.carousel-control {
		left: -12px;
	    height: 40px;
		width: 40px;
	    background: none repeat scroll 0 0 #222222;
	    border: 4px solid #FFFFFF;
	    border-radius: 23px 23px 23px 23px;
	    margin-top: 90px;
	}
	.carousel-control.right {
		right: -12px;
	}
	/* The indicators */
	.carousel-indicators {
		right: 50%;
		top: auto;
		bottom: -10px;
		margin-right: -19px;
	}
	/* The colour of the indicators */
	.carousel-indicators li {
		background: #cecece;
	}
	.carousel-indicators .active {
	background: #428bca;
	}
    </style>
</head>
<body>

<div id="gototop"></div>

<div id="wrapper2">

	<div id="page-content-wrapper">

		<?php $this->load->view("navbar"); ?>
		<?php $this->load->view("kategori-fixed"); ?>

	    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
	        <span class="hamb-top"></span>
			<span class="hamb-middle"></span>
			<span class="hamb-bottom"></span>
	    </button>

	    <?php
		include("identify.php");
		//cek apakah item yg ada di troli sudah melebihi batas tgl expired atau belum
		//jika sudah maka hapus item expired tersebut
		$time = time();
		$cek_expired = $this->model1->selectQuery2("SELECT * FROM troli WHERE $name = '$val' AND tgl_exp < $time");
		if ($cek_expired->num_rows() > 0) {
			$this->model1->selectQuery2("DELETE FROM troli WHERE $name = '$val' AND tgl_exp < $time");
			redirect('keranjang_belanja');
			exit();
		}

		//mengambil data dari troli dan produk
	    $get_troli = $this->model1->joinData("troli","produk","INNER JOIN", "troli.id_produk = produk.no_produk AND troli.$name = '$val' ORDER BY troli.tgl DESC");
	    ?>

		<div class="breadcrumb-container hidden-xs">
			<div class="container">
				<div style="position: relative">
					<div class="abu-abu"></div>
					<a href="<?php echo base_url(); ?>" class="home"><i class="fa fa-home fa-2x"></i></a>
					<ol class="breadcrumb">
						<li><a href="javascript:void(0)">Keranjang Belanja</a></li>
					</ol>
				</div>
			</div>
		</div>

		<div class="container">
			
			<div class="row">
				<h2 style="margin-left:15px;"><b>Troli Belanja Saya <i class="fa fa-cart-arrow-down" style="color:blue;"></i></b></h2><br>
				<?php
				//jika keranjang kosong maka tampilkan dibawah ini
				if ($get_troli->num_rows() == 0) {
					echo '
					<div class="col-md-12">
						<center><img src="'.base_url("/image/empty-new.jpg").'" class="img-responsive"></center>
					</div>';
				//jika tidak, maka jalankan script dibawah ini
				}else{
				?>
				<div class="col-md-9">
					<div id="detail-cart-wrapper">
						<div class="table-responsive">
							<table class="table">
								<tr style="font-weight:bold;">
									<td colspan="2"><span id="jml_items"><?php echo $get_troli->num_rows(); ?></span> PRODUK</td>
									<td>HARGA</td>
									<td>KUANTITAS</td>
									<td>SUBTOTAL</td>
								</tr>
								<?php
								foreach ($get_troli->result() as $troli) {
								?>
								<tr bgcolor="#F8F8F8" id="<?php echo "id_cart$troli->id_troli"; ?>">
									<td>
										<?php
										//jika ditemukan koma pd gambar_produk maka eksekusi ini
										if (strpos($troli->gambar_produk, ",") == TRUE) {
											$img = explode(",", $troli->gambar_produk);
											$gambar = $img[0];
										?>
										<img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" class="img-responsive img_items" style="width:80px;">
										<?php
										//jika tdk ditemukan, maka eksekusi script ini
										}else{
											$gambar = $troli->gambar_produk;
										?>
										<img src="<?php echo base_url("image/produk-sm/$gambar"); ?>" class="img-responsive img_items" style="width:80px;">
										<?php
										}
										?>
									</td>
									<td>
										<a href="<?php echo base_url("detail_produk/p/$troli->id_produk"); ?>" class="cart-link-produk"><?php echo $troli->nama_produk; ?></a>
										<br>
										<span id="<?php echo "hapus_items$troli->id_troli"; ?>">
										<a href="javascript:void(0)" onclick="del_items(<?php echo $troli->id_troli; ?>)" style="display:inline-block;">
											<div class="trash-cart" id="<?php echo "trash_cart$troli->id_troli"; ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="glyphicon glyphicon-trash"></i></div>
										</a>
										</span>
									</td>
									<td>
										<div>
											<?php
											if ($troli->diskon_produk != 0) {
												$diskon = $troli->harga_produk * ($troli->diskon_produk/100);
												$harga = $troli->harga_produk - $diskon;
											?>
											<div class="old-price">
											<?php echo "Rp ".number_format($troli->harga_produk,0,",","."); ?>
											</div>
											<div class="new-price">
											<?php echo "Rp ".number_format($harga,0,",","."); ?>
											</div>
											<div class="discon">
												<span class="badge">-<?php echo $troli->diskon_produk;  ?>%</span>
											</div>
											<?php
											}else{
												$harga = $troli->harga_produk;
											?>
											<div class="new-price">
											<?php echo "Rp ".number_format($harga,0,",","."); ?>
											</div>
											<?php
											}
											?>
										</div>
									</td>
									<td>
										<select name="qty" class="form-control" style="width:90px;" onchange="quantity(this.value,<?php echo $troli->id_troli; ?>,<?php echo $harga; ?>,<?php echo $troli->berat; ?>)">
											<?php
											for ($qty=1; $qty <= $troli->stok_produk; $qty++) {
												if ($troli->kuantitas == $qty) {
													echo "
													<option value='$qty' selected>$qty</option>
													";
												}else{
													echo "
													<option value='$qty'>$qty</option>
													";
												}
											}
											?>
										</select>
										<div style="margin:auto;" id="<?php echo "preloaderSix$troli->id_troli"; ?>">				
										</div>
									</td>
									<td>
										<span id="<?php echo "sub$troli->id_troli"; ?>">
										<?php echo "Rp ".number_format($troli->subtotal,0,",","."); ?>
										</span>
									</td>
								</tr>
								<?php
								}
								$get_troli->free_result();
								?>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<?php
					$p_total = $this->model1->SUM("troli","subtotal", array($name => $val));
					$total = $p_total->result()[0]->subtotal;
					?>
					<div id="total-cart-wrapper">
						<div class="pull-left"><b>TOTAL</b><br> (<i>Belum termasuk ongkir</i>)</div>
						<div class="pull-right" id="total_cart2"><?php echo "Rp ".number_format($total,0,",","."); ?></div>
						<div class="clearfix"></div><br>
						<a href="<?php echo base_url("order") ?>" class="btn btn-primary btn-block"><b>Checkout</b> <i class="glyphicon glyphicon-chevron-right"></i></a>
					</div>
				</div>
				<?php
				}
				?>
			</div>
			<br><br><br>
		</div>

		<?php $this->load->view("footer"); ?>

	</div>
</div>

<?php $this->load->view("source-js"); ?>
<script>
	//proses tambah kuantitas
	function quantity(qty,id,price,weight) {
	    $.ajax({
	        url: '<?php echo base_url("ajax/index/ajax/select-kuantitas"); ?>',
	        type: 'POST',
	        dataType: 'html',
	        data: 'id_troli='+id+'&qty='+qty+'&harga='+price+'&berat='+weight,
	        beforeSend: function() {
	        	$("#preloaderSix"+id).addClass("preloader6");
	        },
	        success: function(hasil){
	            $("#total_cart2").html(hasil);
				$("#total-harga-dikeranjang").html(hasil);
				//menghitung subtotal
				$.ajax({
			    	url: '<?php echo base_url("ajax/index/ajax/select-kuantitas"); ?>',
			        type: 'POST',
			        dataType: 'html',
			        data: 'qty2='+qty+'&harga2='+price,
			        success: function(hasil2){
			            $("#sub"+id).html(hasil2);
	        			$("#preloaderSix"+id).removeClass("preloader6");
			        }
			    });
	        },
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
	    });
	}

	//proses hapus item dikeranjang/cart
	function del_items(id) {
		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/hapus-items"); ?>',
	        type: 'POST',
	        dataType: 'html',
	        data: 'id_troli='+id,
	        beforeSend: function(){
	            $("#hapus_items"+id).addClass("preloader6");
	        },
	        success: function(hasil){
	        	$("#hapus_items"+id).removeClass("preloader6");
	        	$("#id_cart"+id).fadeOut();
	            $("#total_cart2").html(hasil);
				$("#total-harga-dikeranjang").html(hasil);
				//menghitung total items di troli
				$.ajax({
			    	url: '<?php echo base_url("ajax/index/ajax/hapus-items"); ?>',
			        type: 'POST',
			        dataType: 'html',
			        data: 'hitung=items',
			        success: function(hasil2){
			            $("#jml_items").html(hasil2);
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
</body>
</html>