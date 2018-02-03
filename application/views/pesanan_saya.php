<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar</title>
    <?php $this->load->view("source-css"); ?>
    <style>
	/* Ordered-Products -Begin- */
	#ordered-product-wrapper {
		font-family: "Bookman Old Style", serif;
		padding: 12px;
	}
	#ordered-product-wrapper .title-grateful {
		font-size: 22px;
		margin-bottom: 15px;
	}

	.order-timer {
		padding: 30px 25px;
		font-size: 25px;
		background: #55AAFF;
		color: white;
		display: inline-block;
		float: right;
	}

	.bank-wrapper span {
		display: inline-block;
		vertical-align: middle;
	}

	.info-batal {
		border-radius: 5px;
		border: solid 2px orange;
		color: red;
		position: absolute;
		z-index: 10;
		width: 220px;
		height: 40px;
		line-height: 40px;
		top: 50%;
		left: 50%;
		margin-top: -40px;
		margin-left: -110px;
		background: white;
		font-size: 20px;
		font-weight: bold;
		text-align: center;
		transform: rotate(-25deg);
	}
	/* Ordered-Products -End- */
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

		<br><br><br>

		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
				<?php
				if ($cek->num_rows() == 0) {
				?>
				<center>
					<h1>Data tidak ditemukan!</h1>
					<img src="../../image/404-not-found.gif" alt="404-not-found" class="img-responsive">
				</center>
				<?php
				}else if ($cek->result()[0]->status_barang == "N") {
					$check = $cek->result()[0];
				?>
					<div id="ordered-product-wrapper">
						
						<?php
						if ($check->status_barang == "N" && $check->tgl_exp < time()) {
							echo "<div style='position:absolute;left:0;top:0;bottom:0;right:0;background:rgba(0,0,0,0.3);z-index:5;border-radius:5px;'></div>";
							echo "<div class='info-batal'>Pesanan Dibatalkan!</div>";
						}
						?>

						<div class="pull-left">
							<div class="title-grateful"><b>Terima Kasih</b> telah berbelanja di toko Kami.</div>
							<p>
								Segera lakukan pembayaran ke salah satu nomor rekening kami dibawah ini sebelum batas waktu pembelian habis.
							</p>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/Mandiri-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 031 0004 669 XXX</span>
							</div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/BCA-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 676 023 0XXX</span>
							</div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/BRI-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 092 401 000018 XXX</span>
							</div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/BNI-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 333 400 5XXX</span>
							</div>
						</div>

						<div class="pull-right">
							<h4 style="margin-top:0;"><font color="#D2D2D2">Nomor Transaksi</font> <font color="navy">#<?php echo $check->id_order; ?></font></h4>
							<div>
								<h5 align="right"><b>Batas Waktu</b></h5>
								<div class="clearfix"></div>
								<div>
									<?php
									//konversi detik ke hari,jam,menit, dan detik
									$detik = $check->tgl_exp - time();
									$dtk = $detik %60;
									$mnt = floor(($detik %3600) /60);
									$jam = floor(($detik %86400) /3600);
									?>
									<div id="hour" style="display:none;"><?php echo $jam; ?></div>
									<div id="minute" style="display:none;"><?php echo $mnt; ?></div>
									<div id="second" style="display:none;"><?php echo $dtk; ?></div>
									<div class="order-timer">
										<span id="jam"></span> : <span id="menit"></span><span id="detik" style="display:none;"></span>
									</div>
								</div>
							</div>
						</div>

						<div class="clearfix" style="margin-bottom:40px;"><br><br></div>

						<h4>Barang yang dipesan :</h4>
						<div class="table-responsive">
						<?php
						$nama = explode("|",$check->produk);
						$img = explode("|",$check->gambar);
						$harga = explode("|",$check->harga);
						$qty = explode("|",$check->kuantitas);
						$sub = explode("|",$check->subtotal);
						$count = count($nama);
						?>
							<table class="table table-hover">
								<thead>
									<tr bgcolor="#7FAAFF">
										<th colspan="2">Produk</th>
										<th>Harga</th>
										<th>Kuantitas</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody>
									<?php
									for ($x = 0; $x < $count; $x++) {
										$img2 = explode(",", $img[$x]);
									?>
									<tr>
										<td>
											<img src="<?php echo base_url("image/produk-sm/$img2[0]"); ?>" class="img-responsive" style="width:80px;">
										</td>
										<td>
											<?php echo $nama[$x]; ?>
										</td>
										<td>
											<?php echo "Rp ".number_format($harga[$x],0,",","."); ?>
										</td>
										<td>
											<?php echo $qty[$x]; ?>
										</td>
										<td>
											<?php echo "Rp ".number_format($sub[$x],0,",","."); ?>
										</td>
									</tr>
									<?php
									}
									?>
									<tr bgcolor="#EBEBEB">
										<td colspan="4"><b>KURIR</b></td>
										<td><b>
										<?php
										$kurir = explode(",", $check->kurir);
										echo $kurir[0];
										?>
										</b></td>
									</tr>
									<tr bgcolor="#EBEBEB">
										<td colspan="4"><b>ONGKIR</b></td>
										<td><b><?php echo "Rp ".number_format($check->ongkir); ?></b></td>
									</tr>
									<tr bgcolor="#EBEBEB">
										<td colspan="4"><b>TOTAL</b></td>
										<td><b><?php echo "Rp ".number_format($check->total); ?></b></td>
									</tr>
								</tbody>
							</table>
							<div class="pull-left">
							<?php
							date_default_timezone_set('Asia/Singapore');
							echo "Tanggal: ".date("d-m-Y H:i:s",$check->tgl);
							?>
							</div>
							<div class="pull-right"><a href="<?php echo base_url(); ?>" class="btn btn-primary" style="margin-right:20px;"><b><i class="glyphicon glyphicon-home"></i> Halaman Utama</b></a></div>
							<div class="clearfix"></div>
							<p>
								Lihat <a href="#">Halaman Transaksi</a> untuk memantau status transaksi Anda.
							</p>
						</div>
					</div>
				<?php
				}else{

					$data = $cek->result()[0];
					?>
					<div class="table-responsive" style="border-radius:4px;position:relative;">
						<?php
						if ($data->status_barang == "N" && $data->tgl_exp < time()) {
							echo "<div style='position:absolute;left:0;top:0;bottom:0;right:0;background:rgba(0,0,0,0.3);z-index:5;'></div>";
							echo "<div class='info-batal'>Pesanan Dibatalkan!</div>";
						}
						?>
						<table class="table table-condensed">
							<thead>
								<tr bgcolor="#7FAAFF" style="color:white;">
									<th colspan="2">Produk</th>
									<th>Harga</th>
									<th>Kuantitas</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$produk = explode("|", $data->produk);
								$gambar = explode("|", $data->gambar);
								$harga = explode("|", $data->harga);
								$qty = explode("|", $data->kuantitas);
								$sub = explode("|", $data->subtotal);
								$count = count($produk);
								for ($x = 0; $x < $count; $x++) {
									$img = explode(",", $gambar[$x]);
								?>
								<tr>
									<td>
										<img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" style="width:60px;" class="img-responsive">
									</td>
									<td>
										<?php echo $produk[$x]; ?>
									</td>
									<td>
										<?php echo "Rp ".number_format($harga[$x],0,",","."); ?>
									</td>
									<td>
										<?php echo $qty[$x]; ?>
									</td>
									<td>
										<?php echo "Rp ".number_format($sub[$x],0,",","."); ?>
									</td>
								</tr>
								<?php
								}
								?>
								<tr>
									<td></td>
									<td colspan="3" align="right"><b>Subtotal</b></td>
									<td><b><?php echo "Rp ".number_format($data->total,0,",","."); ?></b></td>
								</tr>
								<?php
								$ongkir = ($data->ongkir == 0) ? "Menunggu" : "Rp ".number_format($data->ongkir,0,",",".");
								?>
								<tr>
									<td></td>
									<td colspan="3" align="right"><b>Ongkir</b></td>
									<td><b><?php echo $ongkir; ?></b></td>
								</tr>
								<tr>
								<?php
								$total1 = $data->total + $data->ongkir;
								$total  = ($data->ongkir == 0) ? "Menunggu" : "Rp ".number_format($total1,0,",",".");
								?>
									<td></td>
									<td colspan="3" align="right"><b>Total</b></td>
									<td><b><?php echo $total; ?></b></td>
								</tr>
								<?php
								if ($data->status_barang == "Y") {
									$status = "<font color='#55FF2A'>Dikirim</font>";
								}else if ($data->status_barang == "P") {
									$status = "<font color='orange'>Diproses</font>";
								}else{
									$status = "Menunggu";
								}
								?>
								<tr>
									<td></td>
									<td colspan="3" align="right"><b>Status Order</b></td>
									<td><b><?php echo $status; ?></b></td>
								</tr>
								<tr>
									<td></td>
									<td colspan="3" align="right"><b>Kurir</b></td>
									<td>
									<?php
									$kurir = explode(",", $data->kurir);
									echo "$kurir[0],<br>$kurir[1]";
									?>
									</td>
								</tr>
								<tr>
								<?php
								$resi = (!empty($data->no_resi)) ? $data->no_resi : "-";
								?>
									<td></td>
									<td colspan="3" align="right"><b>Nomor Resi</b></td>
									<td><?php echo $resi; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div style="margin-top:10px;">
						<div class="pull-left">
							<?php
							if ($data->status_barang == "N" && $data->tgl_exp > time()) {
								date_default_timezone_set('Asia/Singapore');
							?>
							<h6><b>Batas Waktu Pembayaran</b></h6>
							<div><?php echo date("d-m-Y H:i:s",$data->tgl_exp); ?></div><p></p>
							<p style="color:#F46C44;font-weight:700;">Segera lakukan pembayaran ke salah satu rekening dibawah ini:</p>
							<div class="clearfix"></div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/Mandiri-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 031 0004 669 XXX</span>
							</div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/BCA-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 676 023 0XXX</span>
							</div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/BRI-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 092 401 000018 XXX</span>
							</div>
							<div class="bank-wrapper">
								<span><img src="<?php echo base_url("image/bank/BNI-small.png"); ?>" class="img-responsive"></span>
								<span>No. Rek 333 400 5XXX</span>
							</div>
							<?php
							}
							?>
						</div>
						<div class="pull-right">
							<?php
							echo date("d-m-Y H:i:s",$data->tgl);
							?>
						</div>
						<div class="clearfix"></div>
					</div>
					<hr><br>
				<?php
				}
				?>	
				</div>
			</div>
		</div>

		<br><br>

		<?php $this->load->view("footer"); ?>

	</div>
</div>

<?php $this->load->view("source-js"); ?>
<script>
	//proses hitung mundur batas waktu pembayaran pesanan
	var hour = parseInt(document.getElementById("hour").innerHTML);
	var minute = parseInt(document.getElementById("minute").innerHTML);
	var second = parseInt(document.getElementById("second").innerHTML);
	function timer_promo(jam,mnt,dtk) {
		document.getElementById("jam").innerHTML = jam;
		document.getElementById("menit").innerHTML = mnt;
		document.getElementById("detik").innerHTML = dtk;
		--dtk;
		if ((jam == 0 || jam < 0) && (mnt == 0 || mnt < 0) && (dtk == 0 || dtk < 0)) {
			//window.location = '<?php echo base_url("/"); ?>';
			jam = 0;
			mnt = 0;
			dtk = 0;
		}
		if (mnt == 0 || mnt < 0) {
			if (jam == 0 || jam < 0) {
				mnt = 0;
			}else{
				mnt = 59;
				--jam;	
			}
		}
		if (dtk == 0 || dtk < 1) {
			if ((jam == 0 || jam < 0) && (mnt == 0 || mnt < 0)) {
				dtk = 0;
			}else{
				dtk = 60;
				--mnt;
			}
		}
		setTimeout('timer_promo('+jam+','+mnt+','+dtk+')', 1000);
	}
	timer_promo(hour,minute,second);
</script>
</body>
</html>