<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order</title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style2.css"); ?>">
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
	/* Ordered-Products -End- */

	.stepwizard-step p {
	    margin-top: 10px;    
	}

	.stepwizard-row {
	    display: table-row;
	}

	.stepwizard {
	    display: table;     
	    width: 100%;
	    position: relative;
	}

	.stepwizard-step button[disabled] {
	    opacity: 1 !important;
	    filter: alpha(opacity=100) !important;
	}

	.stepwizard-row:before {
	    top: 14px;
	    bottom: 0;
	    position: absolute;
	    content: " ";
	    width: 100%;
	    height: 1px;
	    background-color: #ccc;
	    z-order: 0;
	    
	}

	.stepwizard-step {    
	    display: table-cell;
	    text-align: center;
	    position: relative;
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

		<br><br>
	    <div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="well well-small" style="background:white;padding:7px;">
						<div class="stepwizard">
						    <div class="stepwizard-row">
						        <div class="stepwizard-step">
						            <button type="button" class="btn btn-default btn-circle"><b>1</b></button>
						            <p>ISI DATA PEMBELIAN</p>
						        </div>
						        <div class="stepwizard-step">
						            <button type="button" class="btn btn-primary btn-circle"><b>2</b></button>
						            <p>KONFIRMASI PEMBAYARAN</p>
						        </div> 
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php $data = $select->result()[0]; ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div id="ordered-product-wrapper">

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
							<h4 style="margin-top:0;"><font color="#D2D2D2">Nomor Transaksi</font> <font color="navy">#<?php echo $data->id_order; ?></font></h4>
							<div>
								<h5 align="right"><b>Batas Waktu</b></h5>
								<div class="clearfix"></div>
								<div>
									<?php
									//konversi detik ke hari,jam,menit, dan detik
									$detik = $data->tgl_exp - time();
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
						$noP = explode("|", $data->id_produk);
						$nama = explode("|",$data->produk);
						$img = explode("|",$data->gambar);
						$harga = explode("|",$data->harga);
						$qty = explode("|",$data->kuantitas);
						$sub = explode("|",$data->subtotal);
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
											<a href="<?php echo base_url("detail_produk/p/$noP[$x]"); ?>"><img src="<?php echo base_url("image/produk-sm/$img2[0]"); ?>" class="img-responsive" style="width:80px;"></a>
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
										$kurir = explode(",", $data->kurir);
										echo $kurir[0];
										?>
										</b></td>
									</tr>
									<tr bgcolor="#EBEBEB">
										<td colspan="4"><b>ONGKIR</b></td>
										<td><b><?php echo "Rp ".number_format($data->ongkir); ?></b></td>
									</tr>
									<tr bgcolor="#EBEBEB">
										<td colspan="4"><b>TOTAL</b></td>
										<td><b><?php echo "Rp ".number_format($data->total); ?></b></td>
									</tr>
								</tbody>
							</table>
							<div class="pull-left">
							<?php
							date_default_timezone_set('Asia/Singapore');
							echo "Tanggal: ".date("d-m-Y H:i:s",$data->tgl);
							?>
							</div>
							<div class="pull-right"><a href="<?php echo base_url(); ?>" class="btn btn-primary" style="margin-right:20px;"><b><i class="glyphicon glyphicon-home"></i> Halaman Utama</b></a></div>
							<div class="clearfix"></div>
							<p>
								Lihat <a href="#">Halaman Transaksi</a> untuk memantau status transaksi Anda.
							</p>
						</div>
					</div>
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
		}else if (mnt == 0 || mnt < 0) {
			if (jam == 0 || jam < 0) {
				mnt = 0;
			}else{
				mnt = 59;
				dtk = 59;
				--jam;	
			}
		}else if (dtk == 0 || dtk < 1) {
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
<?php
if (isset($_COOKIE['temp_customer'])) {
	//hapus cookie temporary customer
	setcookie("temp_customer", $_COOKIE['temp_customer'], time()-(86400*7), "/");
}
?>
</body>
</html>