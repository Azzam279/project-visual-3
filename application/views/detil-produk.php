<?php
//data produk
$p = $detail->result()[0];

//update dilihat pd tbl produk berdasarkan no_produk
$dilihat = array("dilihat" => $p->dilihat+1);
$this->model1->updateData("no_produk", $p->no_produk, "produk", $dilihat);

if ($p->no_subkategori == 999) {
	//mengambil data kategori
	$whereKat = array("no_kategori" => $p->no_kategori);
	$get_kat = $this->model1->selectWhere("kategori", $whereKat);
	$kat = $get_kat->result()[0];
}else{
	//mengambil data subkategori
	$whereSub = array("no_subkategori" => $p->no_subkategori);
	$get_sub = $this->model1->selectWhere("subkategori", $whereSub);
	$sub = $get_sub->result()[0];
}

//mengambil data brand
if (!empty($p->no_brand)) {
	$whereBrand = array("no_brand" => $p->no_brand);
	$get_brn = $this->model1->selectWhere("brand", $whereBrand);
	$brand = $get_brn->result()[0];
	$nama_brand = $brand->nama_brand;
}else{
	$nama_brand = "Tidak ada Brand";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detail Produk</title>
    <?php $this->load->view("source-css"); ?>
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

	#form-feedback {
		display: none;
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
						<?php
						if ($p->no_subkategori == 999) {
						?>
						<li><a href="<?php echo base_url("$kat->nama_kategori"); ?>"><?php echo ucwords(str_replace("_"," ",$kat->nama_kategori)); ?></a></li>
						<?php
						}else{
						?>
						<li><a href="<?php echo base_url("$sub->nama_kategori"); ?>"><?php echo ucwords(str_replace("_"," ",$sub->nama_kategori)); ?></a></li>
						<li><a href="<?php echo base_url("$sub->nama_kategori/$sub->nama_subkategori"); ?>"><?php echo ucwords(str_replace("_"," ",$sub->nama_subkategori)); ?></a></li>
						<?php
						}
						?>
						<li><a href="javascript:void(0)">Detail-Produk</a></li>
					</ol>
				</div>
			</div>
		</div>

		<div class="container" style="padding-top:20px;background:white;">
			<div class="row">
				<br class="hidden-lg hidden-md hidden-sm visible-xs">
				<br class="hidden-lg hidden-md hidden-sm visible-xs">

				<div class="col-lg-9 col-md-9 col-sm-9">
					<div class="col-md-7" style="padding:0">
						<?php
						$img = explode(",", $p->gambar_produk);
						?>
						<div class="col-md-10 col-md-push-2" style="padding:0;">
							<div class="thumbnail" id="thumbnail-large">
								<a href="#">
									<img src="<?php echo base_url("image/produk-md/$img[0]"); ?>" alt="gambar-produk-utama" class="img-responsive" id="zoom_01" data-zoom-image="<?php echo base_url("image/produk-lg/$img[0]"); ?>">
								</a>
							</div>
						</div>
						<div class="col-md-2 col-md-pull-10" style="padding:0;">
							<ul class="thumbnail-small" id="gallery_01">
							<?php
							$count = count($img);
							for ($x = 0; $x < $count; $x++) {
							?>
								<li>
									<a href="#" data-image="<?php echo base_url("image/produk-md/$img[$x]"); ?>" data-zoom-image="<?php echo base_url("image/produk-lg/$img[$x]"); ?>" class="thumbnail">
										<img src="<?php echo base_url("image/produk-sm/$img[$x]"); ?>" class="img-responsive" id="zoom_01">
									</a>
								</li>
							<?php
							}
							?>
							</ul>
						</div>
					</div>

					<div class="col-md-5" style="padding:0">
						<h3 style="font-size:19px"><?php echo $p->nama_produk; ?></h3>
						<small>Brand: <b><?php echo $nama_brand; ?></b></small><br><p></p>
						<div id="loading-wishlist"></div>
						<?php
						if (empty($_SESSION['id_customer'])) {
							echo '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Anda harus login"><i class="fa fa-heart-o"></i> Tambahkan ke Wishlist</a>';
						}else{
							echo '<a href="javascript:void(0)" id="btn-wishlist"><i class="fa fa-heart-o"></i> Tambahkan ke Wishlist</a>';
						}
						?>
						<hr>
						<?php
						//jika diskon produk ini tidak 0% maka jalankan script ini
						if ($p->diskon_produk != 0) {
							$diskon = $p->harga_produk * ($p->diskon_produk/100);
							$harga = $p->harga_produk - $diskon
						?>
						<span class="pull-right"><i style="background:#FF2A2A;font-family:verdana" class="badge">-<?php echo $p->diskon_produk; ?>%</i></span>
						<h5 style="text-decoration:line-through;color:#999;">Rp <?php echo number_format($p->harga_produk,0,",","."); ?></h5>
						<h3 style="color:#A30046"><b>Rp <?php echo number_format($harga,0,",","."); ?></b></h3>
						<?php
						//jika diskon 0% maka jalankan script ini
						}else{
							$harga = $p->harga_produk;
						?>
						<h3 style="color:#A30046"><b>Rp <?php echo number_format($harga,0,",","."); ?></b></h3>
						<?php	
						}
						?>
						<div id="form-detil-produk">
							<div id="jumlah_produk">
								<span>Beli</span> 
								<select id="qty-produk" class="form-control">
									<?php
									for ($s = 1; $s <= $p->stok_produk; $s++) {
										echo "
										<option value='$s'>$s</option>
										";
									}
									?>
								</select>
								<span>dari <?php echo $p->stok_produk; ?> stok barang</span>
							</div>
							<br>
							<?php
							if ($p->stok_produk == 0) {
							?>
							<div style="margin-bottom:8px;color:red;"><small><i>Stok produk ini sedang kosong!</i></small></div>
							<button class="btn btn-success btn-lg btn-block" disabled="disabled"><i class="fa fa-cart-plus"></i> Beli</button>
							<?php
							}else{
							?>
							<button class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#modal-cart" id="beli"><i class="fa fa-cart-plus"></i> Beli</button>
							<?php
							}
							?>
							<br>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3" style="padding:0;border:solid 1px #D2D2D2;border-radius:10px;">
					<h3 style="width:100%;background:linear-gradient(to bottom,#f5f5f5 0,#e8e8e8 100%);margin-top:0;text-align:center;padding:10px 0;border-radius:10px 10px 0 0;">Rate Produk Ini</h3>
					<div style="width:100%;height:100%;padding-left:10px;">
					<ul class='star-rating' style="float:left;">
					  <li class="current-rating" id="current-rating"><!-- will show current rating --></li>
					  <span id="ratelinks">
					  <li><a href="javascript:void(0)" title="1 star out of 5" class="one-star">1.<?php echo $p->no_produk;?></a></li>
					  <li><a href="javascript:void(0)" title="2 stars out of 5" class="two-stars">2.<?php echo $p->no_produk;?></a></li>
					  <li><a href="javascript:void(0)" title="3 stars out of 5" class="three-stars">3.<?php echo $p->no_produk;?></a></li>
					  <li><a href="javascript:void(0)" title="4 stars out of 5" class="four-stars">4.<?php echo $p->no_produk;?></a></li>
					  <li><a href="javascript:void(0)" title="5 stars out of 5" class="five-stars">5.<?php echo $p->no_produk;?></a></li>
					  </span>
					</ul>
					<?php
					$sql_star = $this->model1->selectQuery2("SELECT SUM(counter) as klik FROM vote_star WHERE id_produk = '$p->no_produk'");
					$jml_klik = (empty($sql_star->result()[0]->klik)) ? 1 : $sql_star->result()[0]->klik;
					$star5 = $this->model1->selectQuery2("SELECT SUM(counter) as klik FROM vote_star WHERE id_produk = '$p->no_produk' AND value = 5");
					$lima = (empty($star5->result()[0]->klik)) ? 0 : $star5->result()[0]->klik;
					$persen5 = ($lima/$jml_klik) * 100;
					$star4 = $this->model1->selectQuery2("SELECT SUM(counter) as klik FROM vote_star WHERE id_produk = '$p->no_produk' AND value = 4");
					$empat = (empty($star4->result()[0]->klik)) ? 0 : $star4->result()[0]->klik;
					//echo "<script>alert('".$star4->result()[0]->klik."')</script>";
					$persen4 = ($empat/$jml_klik) * 100;
					$star3 = $this->model1->selectQuery2("SELECT SUM(counter) as klik FROM vote_star WHERE id_produk = '$p->no_produk' AND value = 3");
					$tiga = (empty($star3->result()[0]->klik)) ? 0 : $star3->result()[0]->klik;
					$persen3 = ($tiga/$jml_klik) * 100;
					$star2 = $this->model1->selectQuery2("SELECT SUM(counter) as klik FROM vote_star WHERE id_produk = '$p->no_produk' AND value = 2");
					$dua = (empty($star2->result()[0]->klik)) ? 0 : $star2->result()[0]->klik;
					$persen2 = ($dua/$jml_klik) * 100;
					$star1 = $this->model1->selectQuery2("SELECT SUM(counter) as klik FROM vote_star WHERE id_produk = '$p->no_produk' AND value = 1");
					$satu = (empty($star1->result()[0]->klik)) ? 0 : $star1->result()[0]->klik;
					$persen1 = ($satu/$jml_klik) * 100;
					?>
					<div style="float:left;margin-left:12px;margin-top:2px;"><?php echo (empty($sql_star->result()[0]->klik)) ? 0 : $jml_klik; ?> total <i class="glyphicon glyphicon-star"></i></div>
					<div class="clearfix"></div>
					<br>
					<div class="info-rate-star">
						<div>5 <i class="glyphicon glyphicon-star"></i> </div>
						<div>
							<div style="width:<?php echo $persen5; ?>%;height:22px;background:orange;"></div>
						</div>
						<div><?php echo $lima ?> rate</div>
					</div>
					<div class="info-rate-star">
						<div>4 <i class="glyphicon glyphicon-star"></i> </div>
						<div>
							<div style="width:<?php echo $persen4; ?>%;height:22px;background:orange;"></div>
						</div>
						<div><?php echo $empat ?> rate</div>
					</div>
					<div class="info-rate-star">
						<div>3 <i class="glyphicon glyphicon-star"></i> </div>
						<div>
							<div style="width:<?php echo $persen3; ?>%;height:22px;background:orange;"></div>
						</div>
						<div><?php echo $tiga; ?> rate</div>
					</div>
					<div class="info-rate-star">
						<div>2 <i class="glyphicon glyphicon-star"></i> </div>
						<div>
							<div style="width:<?php echo $persen2; ?>%;height:22px;background:orange;"></div>
						</div>
						<div><?php echo $dua; ?> rate</div>
					</div>
					<div class="info-rate-star">
						<div>1 <i class="glyphicon glyphicon-star"></i> </div>
						<div>
							<div style="width:<?php echo $persen1; ?>%;height:22px;background:orange;"></div>
						</div>
						<div><?php echo $satu; ?> rate</div>
					</div>
					<br>
					</div>
				</div>
	        </div>

			<?php
			/*$all= $this->model1->selectQuery2("SELECT SUM(counter) as counter FROM vote_star WHERE id_produk = '31'");
			$_5 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => 31, "value" => 5));
			$_4 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => 31, "value" => 4));
			$_3 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => 31, "value" => 3));
			$_2 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => 31, "value" => 2));
			$_1 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => 31, "value" => 1));

			$a  = $all->result()[0]->counter;
			$b5 = (($_5->num_rows()==0) ? 0 : $_5->result()[0]->counter) / $a * 100;
			$b4 = (($_4->num_rows()==0) ? 0 : $_4->result()[0]->counter) / $a * 100;
			$b3 = (($_3->num_rows()==0) ? 0 : $_3->result()[0]->counter) / $a * 100;
			$b2 = (($_2->num_rows()==0) ? 0 : $_2->result()[0]->counter) / $a * 100;
			$b1 = (($_1->num_rows()==0) ? 0 : $_1->result()[0]->counter) / $a * 100;
			$t = $b5 + $b4 + $b3 + $b2 + $b1;
			echo "$b5 + $b4 + $b3 + $b2 + $b1 = $t";*/

			if (!empty($_SESSION['id_customer'])) { //jika id customer tdk kosong
				//mengambil data id_produk dari tbl order_produk berdasarkan id_customer dan id_produk
				$sql_cek = $this->model1->selectQuery2("SELECT id_produk FROM order_produk WHERE id_customer = '$_SESSION[id_customer]' AND id_produk LIKE '%$id_product%' AND status_barang = 'Y'");
				if ($sql_cek->num_rows() > 0) { //jika data yg dicari ketemu
					foreach ($sql_cek->result() as $get_cek) {
						$cari = strpos($get_cek->id_produk, "|");
						if ($cari === false) {
							$search = 1;
							break;
						}else{
							$exp = explode("|", $get_cek->id_produk);
							$search = array_search($id_product, $exp);
							if ($search > 0) {break;}
						}
					}
					$sql_cek->free_result();
					
					if ($search == 1) { //jika id_produk ketemu
						$disabled = 'placeholder="Ketikkan feedback disini..."';
						$disFeed = "";
					}else{ //jika id_produk tdk ketemu
						$disabled = 'placeholder="Anda harus membeli produk ini terlebih dahulu untuk dapat memberi Feedback" disabled="disabled"';
						$disFeed = "disabled='disabled'";
					}
				}else{ //jika data yg dicari tdk ketemu
					$disabled = 'placeholder="Anda harus membeli produk ini terlebih dahulu untuk dapat memberi Feedback" disabled="disabled"';
					$disFeed = "disabled='disabled'";
				}
			}else{
				$disabled = 'placeholder="Anda harus membeli produk ini terlebih dahulu untuk dapat memberi Feedback" disabled="disabled"';
				$disFeed = "disabled='disabled'";
			}
			?>

	        <div class="row">
	        	<div class="col-lg-9 col-md-9 col-sm-9">
		            <div class="panel with-nav-tabs panel-default">
		                <div class="panel-heading">
	                        <ul class="nav nav-tabs">
	                            <li class="active"><a href="#tab1default" data-toggle="tab"><i class="fa fa-info-circle"></i> Detail Barang</a></li>
	                            <li><a href="#tab2default" data-toggle="tab"><i class="fa fa-comments-o"></i> Feedback</a></li>
	                            <?php
	                            if (!empty($_SESSION['id_customer'])) {
	                            	echo '<li><a href="javascript:void(0)" id="tulis-feedback"><i class="fa fa-pencil"></i> Tulis feedback</a></li>';
	                            }
	                            ?>
	                        </ul>
		                </div>
		                <div class="panel-body" style="padding:0;">
		                    <div class="tab-content">
		                        <div class="tab-pane fade in active" id="tab1default">
		                        	<div style="padding:15px;">
		                        		<?php echo $p->deskripsi; ?>
		                        	</div>
		                        </div>
		                        <div class="tab-pane fade" id="tab2default">
		                        	<!-- Form Feedback -Start -->
		                        	<div id="form-feedback" style="padding:12px;">
		                        		<form action="<?php echo htmlspecialchars(base_url("detail_produk/feedback/$id_product")); ?>" method="post">
		                        			<p><div id="batasKarakter" class="pull-right"></div></p>
		                        			<textarea name="feedback" class="form-control" rows="7" id="feed-message" maxlength="501" <?php echo $disabled; ?> required></textarea>
		                        			<p></p>
		                        			<select name="tipe" class="form-control" <?php echo $disFeed; ?> required>
		                        				<option value="Feedback positif">Feedback positif</option>
		                        				<option value="Feedback negatif">Feedback negatif</option>
		                        			</select>
		                        			<p></p>
		                        			<button class="btn btn-default pull-right" type="submit" name="kirim_feed" value="kirim_feed" id="btnFeed" <?php echo $disFeed; ?>><i class="fa fa-send"></i> Kirim feedback</button>
		                        			<div class="clearfix"></div>
		                        		</form>
		                        		<hr>
		                        	</div>
		                        	<!-- Form Feedback -Finish -->
		                        	<div class="clearfix"></div>
		                        	<?php
		                        	date_default_timezone_set('Asia/Singapore');
									$hal = 10;
									$total_record = $this->model1->selectQuery2("SELECT id_feedback FROM feedback WHERE id_produk = '$id_product'");
									$haltam = ceil($total_record->num_rows() / $hal);
									$halaman = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
									$start = ($halaman - 1) * $hal;
									$feedback = $this->model1->selectQuery2("SELECT * FROM feedback WHERE id_produk = '$id_product' ORDER BY tgl DESC LIMIT $start, $hal");

		                        	foreach ($feedback->result() as $feed_val) {
		                        		$sql_cust = $this->model1->selectQuery2("SELECT nama FROM customer WHERE id_customer = '$feed_val->id_customer'");
		                        		$nama_cst = $sql_cust->result()[0]->nama;
		                        	?>
									<div class="feedback-wrapper">
										<div style="padding:15px;">
											<div class="feedback-image">
												<img src="../../image/avatar_2x.png" alt="image" class="img-responsive img-rounded">
											</div>
											<div class="feedback-caption">
												<h5><b><?php echo $nama_cst; ?></b></h5>
												<div class="feedback-tipe">
													<?php echo $feed_val->tipe; ?>
												</div>
												<div class="feedback-tgl">
													<?php echo date("d-m-Y H:i:s", $feed_val->tgl); ?>
												</div>
											</div>
											<div class="feedback-content">
												<div class="gn-content">
													<?php
													if ($feed_val->tipe == "Feedback positif") {
														echo "<div style='width:16px;vertical-align:top;display:inline-block;'><i class='fa fa-thumbs-o-up'></i></div> <div style='display:inline-block;'>$feed_val->feedback</div>";
													}else{
														echo "<div style='width:16px;vertical-align:top;display:inline-block;'><i class='fa fa-thumbs-o-down'></i></div> <div style='display:inline-block;'>$feed_val->feedback</div>";
													}
													?>
												</div>
											</div>
										</div>
									</div>
									<?php
									}
									$feedback->free_result();
									//PAGING
									echo "<div style='padding:12px;'>";
									echo "<ul class='pager'>";
									if ($halaman > 1) echo  "<li class='previous'><a href='".base_url("detail_produk/p/$id_product")."?halaman=".($halaman-1)."'><i class='glyphicon glyphicon-menu-left'></i> Prev</a></li>";

									echo "<li><ul class='pagination' style='margin:0px;'>";
									for($page = 1; $page <= $haltam; $page++)
									{
									     if ((($page >= $halaman - 3) && ($page <= $halaman + 3)) || ($page == 1) || ($page == $haltam)) 
									     {
									        if ($page == $halaman) echo "<li class='active'><a href='#'>".$page."</a></li> ";
									        else echo "<li><a href='".base_url("detail_produk/p/$id_product")."?halaman=".$page."'>".$page."</a></li>";         
									     }
									}
									echo "</ul></li>";

									if ($halaman < $haltam) echo "<li class='next'><a href='".base_url("detail_produk/p/$id_product")."?halaman=".($halaman+1)."'>Next <i class='glyphicon glyphicon-menu-right'></i></a></li>";
									echo "</ul>";
									echo "</div>";
									?>
		                        </div>
		                    </div>
		                </div>
		            </div>       		
	        	</div>
	        </div>

			<br><br>

			<div class="row hidden-xs">
				<div class="col-md-12">
					<div style='font-family: "Trebuchet MS", Helvetica, sans-serif; color: navy;'>
						<h3><b>Produk Sejenis</b></h3>
						<hr>
					</div>

	                <div id="Carousel" class="carousel slide">
	                 
	                <ol class="carousel-indicators">
	                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
	                    <li data-target="#Carousel" data-slide-to="1"></li>
	                    <li data-target="#Carousel" data-slide-to="2"></li>
	                </ol>
	                 
	                <!-- Carousel items -->
	                <div class="carousel-inner">

	                <?php
	                //mengambil data produk sebanyak 4 berdasarkan no_brand dan no_kategori
	                $sql_ps1 = $this->model1->selectQuery2("SELECT * FROM produk WHERE no_brand = '$p->no_brand' AND no_kategori = '$p->no_kategori' ORDER BY no_produk DESC LIMIT 0,4");
	                ?>
	                    
	                <div class="item active">
	                	<div class="row">
		                	<?php
							if ($sql_ps1->num_rows() < 4) {
								for ($x1=0; $x1 < 4; $x1++) {
								?>
								<div class="col-md-3"><a href="#" class="thumbnail"><img src="<?php echo base_url("image/250x250.png"); ?>" alt="Image" style="max-width:100%;"></a></div>
								<?php	
								}
							}else{
								foreach ($sql_ps1->result() as $ps1) {
									$ex_img1 = explode(",", $ps1->gambar_produk);
								?>
		                		<div class="col-md-3"><a href="#" class="thumbnail"><img src="<?php echo base_url("image/produk-sm/$ex_img1[0]"); ?>" alt="Image" style="max-width:100%;"></a></div>
		                		<?php
		                		}
	                		}
	                		?>
	                	</div><!--.row-->
	                </div><!--.item-->
	                 
					<?php
					//mengambil data produk sebanyak 4 berdasarkan no_brand dan no_kategori
	                $sql_ps2 = $this->model1->selectQuery2("SELECT * FROM produk WHERE no_brand = '$p->no_brand' AND no_kategori = '$p->no_kategori' ORDER BY no_produk DESC LIMIT 4,4");
	                ?>

	                <div class="item">
	                	<div class="row">
							<?php
							if ($sql_ps2->num_rows() < 4) {
								for ($x2=0; $x2 < 4; $x2++) {
								?>
								<div class="col-md-3"><a href="#" class="thumbnail"><img src="<?php echo base_url("image/250x250.png"); ?>" alt="Image" style="max-width:100%;"></a></div>
								<?php	
								}
							}else{
								foreach ($sql_ps2->result() as $ps2) {
									$ex_img2 = explode(",", $ps2->gambar_produk);
								?>
		                		<div class="col-md-3"><a href="#" class="thumbnail"><img src="<?php echo base_url("image/produk-sm/$ex_img2[0]"); ?>" alt="Image" style="max-width:100%;"></a></div>
		                		<?php
		                		}
	                		}
	                		?>
	                	</div><!--.row-->
	                </div><!--.item-->

	                <?php
					//mengambil data produk sebanyak 4 berdasarkan no_brand dan no_kategori
	                $sql_ps3 = $this->model1->selectQuery2("SELECT * FROM produk WHERE no_brand = '$p->no_brand' AND no_kategori = '$p->no_kategori' ORDER BY no_produk DESC LIMIT 8,4");
	                ?>
	                 
	                <div class="item">
	                	<div class="row">
	                		<?php
							if ($sql_ps3->num_rows() < 4) {
								for ($x3=0; $x3 < 4; $x3++) {
								?>
								<div class="col-md-3"><a href="#" class="thumbnail"><img src="<?php echo base_url("image/250x250.png"); ?>" alt="Image" style="max-width:100%;"></a></div>
								<?php	
								}
							}else{
								foreach ($sql_ps3->result() as $ps3) {
									$ex_img3 = explode(",", $ps3->gambar_produk);
								?>
		                		<div class="col-md-3"><a href="#" class="thumbnail"><img src="<?php echo base_url("image/produk-sm/$ex_img3[0]"); ?>" alt="Image" style="max-width:100%;"></a></div>
		                		<?php
		                		}
	                		}
	                		?>
	                	</div><!--.row-->
	                </div><!--.item-->
	                 
	                </div><!--.carousel-inner-->
	                  <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
	                  <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
	                </div><!--.Carousel-->
				</div>
			</div>
			<br><br>     
		</div>
		<?php $this->load->view("footer"); ?>

	</div>
</div>

<?php $this->load->view("source-js"); ?>
<script>
	//proses menambahkan barang ke troli
	$("#beli").click(function() {
		var qty = $("#qty-produk").val();
		var idP = "<?php echo $p->no_produk; ?>";
		var berat = "<?php echo $p->berat_produk; ?>";

		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/insert-produk-ke-troli"); ?>',
			type: 'POST',
			dataType: 'html',
			data: 'id_produk='+idP+'&beli='+qty+'&berat='+berat,
			success: function(hasil) {
				$("#isi-troli").html(hasil);
				//menghitung total dari subtotal yg ada di troli
				$.ajax({
					url: '<?php echo base_url("ajax/index/ajax/hitung-total-n-items"); ?>',
					type: 'POST',
					dataType: 'html',
					data: 'hitung=total',
					success: function(hasil2) {
						$("#total-harga-dikeranjang").html(hasil2);
					},
		            error:function(event, textStatus, errorThrown) {
		               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		            }
				});
				//menghitung total item/barang yg ada di troli
				$.ajax({
					url: '<?php echo base_url("ajax/index/ajax/hitung-total-n-items"); ?>',
					type: 'POST',
					dataType: 'html',
					data: 'hitung=items',
					success: function(hasil3) {
						$("#jml-item-dikeranjang").html(hasil3);
					},
		            error:function(event, textStatus, errorThrown) {
		               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		            }
				});
			},
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
		});

	});

	$("#btn-wishlist").click(function() {
		var id = "<?php echo $p->no_produk; ?>";
        $.ajax({
            url: '<?php echo base_url("ajax/index/ajax/add-to-wishlist"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'wishlist='+id,
            beforeSend: function() {
            	$("#btn-wishlist").remove();
            	$("#loading-wishlist").text("Loading...");
            },
            success: function(hasil) {
            	$("#loading-wishlist").html(hasil);
            },
            error: function() {
                alert("Error!");
            }
        });
    });

	$(document).ready(function() {
	    $('#Carousel').carousel({
	        interval: 4000
	    })
	});

	// JavaScript Document
	$(document).ready(function() {
		// get current rating
		getRating();
		// get rating function
		function getRating(){
			var id = "<?php echo $p->no_produk; ?>";

			$.ajax({
				type: "GET",
				url: '<?php echo base_url("ajax/index/ajax/update-star"); ?>',
				data: "do=getrate&id="+id,
				cache: false,
				async: false,
				success: function(result) {
					// apply star rating to element
					$("#current-rating").css({ width: "" + result + "%" });
					$("#produk-rating").css({ width: "" + result + "%" });
				},
				error: function(result) {
					alert("some error occured, please try again later");
				}
			});
		}
		
		// link handler
		$('#ratelinks li a').click(function(){
			$.ajax({
				type: "GET",
				url: '<?php echo base_url("ajax/index/ajax/update-star"); ?>',
				data: "rating="+$(this).text()+"&do=rate",
				cache: false,
				async: false,
				success: function(result) {
					// remove #ratelinks element to prevent another rate
					$("#ratelinks").remove();
					// get rating after click
					getRating();
				},
				error: function(result) {
					alert("some error occured, please try again later");
				}
			});
			
		});
	});

	//menampilkan form feedback
	$("#tulis-feedback").click(function() {
		$("#form-feedback").slideToggle();
	});

	//max karakter pd feedback form
    $('#batasKarakter').text('500 karakter tersisa');
    $('#feed-message').keydown(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) {
            $('#batasKarakter').html('<font color="red">Anda telah mencapai batas maksimal!</font>');
            $('#batasKarakter').addClass('red');
            $('#btnFeed').attr('disabled','disabled');            
        }else{
            var ch = max - len;
            $('#batasKarakter').text(ch + ' karakter tersisa');
            $('#btnFeed').removeAttr('disabled');
            $('#batasKarakter').removeClass('red');            
        }
    });
</script>
</body>
</html>