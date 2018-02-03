<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pencarian</title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="assets/css/easyui.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style2.css"); ?>">
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
						<li><a href="#">Pencarian</a></li>
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
					if ($cari->num_rows() < 1) {
						echo "<center><h3>'$pencarian' tidak ditemukan!</h3></center>";
					}else{
					?>

						<ul class="row produk-3">
							<?php
							$no = 0;
							foreach ($cari->result() as $c) {
								$img = explode(",", $c->gambar_produk);
								$nama = (strlen($c->nama_produk) > 40) ? substr($c->nama_produk, 0,40)."..." : $c->nama_produk;
							?>
							<li class="col-md-2 col-sm-2 col-lg-2 produk-wrapper-3">
								<a href="<?php echo base_url("detail_produk/p/$c->no_produk"); ?>">
									<center><img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" class="img-responsive"></center>
									<div class="caption">
										<p><?php echo $nama; ?></p>
										<h5>
											<span>
											<?php
											if ($c->diskon_produk != 0) {
												$diskon = $c->harga_produk * ($c->diskon_produk/100);
												$harga_lama = "Rp ".number_format($c->harga_produk,0,",",".");
												$harga = "Rp ".number_format($c->harga_produk - $diskon,0,",",".");
												$disc = "-$c->diskon_produk%";
											}else{
												$harga_lama = "";
												$harga = "Rp ".number_format($c->harga_produk,0,",",".");
												$disc = "";
											}
											?>
												<span><?php echo $harga_lama; ?></span><br>
												<span><?php echo $harga; ?></span>
											</span>
											<span class="badge"><?php echo $disc; ?></span>
										</h5>
									</div>
								</a>
							</li>
							<?php
								if ($no == 4) {
									echo "</ul><ul class='row produk-3'>";
									$no = -1;
								}
								$no++;
							}
							$cari->free_result();
							?>
						</ul>

					<?php
					}
					?>	

						<div class="clearfix"></div>
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