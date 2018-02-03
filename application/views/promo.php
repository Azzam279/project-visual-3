<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Promo</title>
    <?php $this->load->view("source-css"); ?>
    <style>
    	.promo-title {
    		font-family: "titilliumBold", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif;
    		font-size: 30px;
    		font-weight: bold;
    		margin-left: 8px;
    		margin-bottom: 10px;
    		line-height: 1em;
    		color: grey;
    		float: left;
    	}

    	.promo-timer {
    		font-family: "titilliumBold", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif;
    		font-size: 16px;
    		font-weight: bold;
    		float: right;
    	}

    	.promo-image {
    		margin-bottom: 15px;
    		cursor: pointer;
    	}
    	.promo-image img {
    		width: 100%;
    		margin: auto;
    	}

    	#promo-expired {
    		font-family: "titilliumBold", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif;
    		font-size: 25px;
    		font-weight: bold;
    		color: grey;
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

		<div class="breadcrumb-container hidden-xs">
			<div class="container">
				<div style="position: relative">
					<div class="abu-abu"></div>
					<a href="<?php echo base_url(); ?>" class="home"><i class="fa fa-home fa-2x"></i></a>
					<ol class="breadcrumb">
						<li><a href="#"><?php echo $promo->judul_promo; ?></a></li>
					</ol>
				</div>
			</div>
		</div>

		<div class="container" style="padding-top:20px;background:white;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<br class="hidden-lg hidden-md hidden-sm visible-xs">
					<br class="hidden-lg hidden-md hidden-sm visible-xs">

					<div class="well well-sm produk-wrapper-new" style="background:white;border:solid 1px #E1E1E1;">

					<?php
					if ($promo->lama_promo > time()) {
					?>

						<?php
						//konversi detik ke hari,jam,menit, dan detik
						$detik = $promo->lama_promo - time();
						$dtk = $detik %60;
						$mnt = floor(($detik %3600) /60);
						$jam = floor(($detik %86400) /3600);
						$hri = floor($detik/60/60/24);
						?>
						<div id="day" style="display:none;"><?php echo $hri; ?></div>
						<div id="hour" style="display:none;"><?php echo $jam; ?></div>
						<div id="minute" style="display:none;"><?php echo $mnt; ?></div>
						<div id="second" style="display:none;"><?php echo $dtk; ?></div>

						<div class="promo-title">
							<?php echo $promo->judul_promo; ?>
						</div>
						<div class="promo-timer">
							<span id="hari"></span> hr : <span id="jam"></span> jam : <span id="menit"></span> mnt : <span id="detik"></span> dtk
						</div>
						<div class="clearfix"></div>
						<div class="promo-image">
							<img src="<?php echo base_url("image/promo/landscape/$promo->gambar_promo_lg"); ?>" class="img-responsive">
						</div>

						<ul class="row produk-3">
							<?php
							$limit = 0;
							//menampilkan produk promo berdasarkan id promo
							foreach ($sql_promo->result() as $p) {
								$img = explode(",", $p->gambar_produk);
							?>
							<li class="col-md-2 col-sm-2 col-lg-2 produk-wrapper-3">
								<a href="<?php echo base_url("detail_produk/p/$p->no_produk"); ?>">
									<center><img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" class="img-responsive"></center>
									<div class="caption">
										<p>
										<?php echo (strlen($p->nama_produk)>40) ? substr($p->nama_produk, 0,40)."..." : $p->nama_produk; ?>
										</p>
										<h5>
											<?php
											if ($p->diskon_produk == 0) {
											?>
											<span>
												<span></span>
												<span>Rp. <?php echo number_format($p->harga_produk,0,",","."); ?></span>
											</span>
											<span class="badge"></span>
											<?php	
											}else{
												$disc = $p->harga_produk * ($p->diskon_produk/100);
												$harga = $p->harga_produk - $disc;
											?>
											<span>
												<span>Rp. <?php echo number_format($p->harga_produk,0,",","."); ?></span><br>
												<span>Rp. <?php echo number_format($harga,0,",","."); ?></span>
											</span>
											<span class="badge">-<?php echo $p->diskon_produk; ?>%</span>
											<?php
											}
											?>
										</h5>
									</div>
								</a>
							</li>
							<?php
							}
							if ($limit == 4) {
								echo "</ul><ul class='row produk-3'>";
								$limit = -1;
							}
							$limit++;
							?>
						</ul>

						<div class="clearfix"></div>

						<script>
							//proses hitung mundur promo
							var day = parseInt(document.getElementById("day").innerHTML);
							var hour = parseInt(document.getElementById("hour").innerHTML);
							var minute = parseInt(document.getElementById("minute").innerHTML);
							var second = parseInt(document.getElementById("second").innerHTML);
							var judul = '<?php $judul = preg_replace("/[^a-zA-Z0-9]/", "-", $promo->judul_promo); ?>';
							function timer_promo(hari,jam,mnt,dtk) {
								document.getElementById("hari").innerHTML = hari;
								document.getElementById("jam").innerHTML = jam;
								document.getElementById("menit").innerHTML = mnt;
								document.getElementById("detik").innerHTML = dtk;
								--dtk;
								if ((hari == 0 || hari < 0) && (jam == 0 || jam < 0) && (mnt == 0 || mnt < 0) && (dtk == 0 || dtk < 0)) {
									window.location = '<?php echo base_url("promo/p/$promo->id_promo/$judul"); ?>';
								}
								if (jam == 0 || jam < 0) {
									if (hari == 0 || hari < 0) {
										jam = 0;
									}else{
										jam = 23;
										--hari;
									}
								}
								if (mnt == 0 || mnt < 0) {
									if ((hari == 0 || hari < 0) && (jam == 0 || jam < 0)) {
										mnt = 0;
									}else{
										mnt = 59;
										--jam;	
									}
								}
								if (dtk == 0 || dtk < 0) {
									if ((hari == 0 || hari < 0) && (jam == 0 || jam < 0) && (mnt == 0 || mnt < 0)) {
										dtk = 0;
									}else{
										dtk = 60;
										--mnt;
									}
								}
								setTimeout('timer_promo('+hari+','+jam+','+mnt+','+dtk+')', 1000);
							}
							timer_promo(day,hour,minute,second);
						</script>						

					<?php
					}else{
					?>
					<center><div id='promo-expired'>Promo Ini Telah Expired!</div></center>
					<img src="<?php echo base_url("image/expired.jpg"); ?>" alt="expired" class="img-responsive" style="margin:0 auto;">
					<?php
					}
					?>

					</div>
				</div>
	        </div>
		</div>
		<?php $this->load->view("footer"); ?>

	</div>
</div>

<?php $this->load->view("source-js"); ?>
</body>
</html>