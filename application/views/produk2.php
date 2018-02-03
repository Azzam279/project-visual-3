<?php
$pecah = explode("/", $_SERVER['PHP_SELF']);
$no1 = count($pecah) - 2;
$no2 = count($pecah) - 1;
$kategori = ucwords(str_replace("_"," ",$pecah[$no1]));
$subkategori = ucwords(str_replace("_"," ",$pecah[$no2]));

if (isset($_GET['sort'])) {
	if ($_GET['sort'] == "terbaru") {
		$sort = "ORDER BY no_produk DESC";
	}else if ($_GET['sort'] == "termahal") {
		$sort = "ORDER BY harga_diskon DESC";
	}else if ($_GET['sort'] == "termurah") {
		$sort = "ORDER BY harga_diskon ASC";
	}else if ($_GET['sort'] == "diskon") {
		$sort = "ORDER BY diskon_produk DESC";
	}
}

if (isset($_GET['sort']) && isset($_GET['brand']) && isset($_GET['pmax'])) {
	$query = "AND no_brand = '$_GET[brand]' AND harga_diskon <= $_GET[pmax] $sort";
}else if (isset($_GET['sort']) && isset($_GET['brand'])) {
	$query = "AND no_brand = '$_GET[brand]' $sort";
}else if (isset($_GET['sort']) && isset($_GET['pmax'])) {
	$query = "AND harga_diskon <= $_GET[pmax] $sort";
}else if (isset($_GET['brand']) && isset($_GET['pmax'])) {
	$query = "AND no_brand = '$_GET[brand]' AND harga_diskon <= $_GET[pmax]";
}else if (isset($_GET['sort'])) {
	$query = "$sort";
}else if (isset($_GET['brand'])) {
	$query = "AND no_brand = '$_GET[brand]'";
}else if (isset($_GET['pmax'])) {
	$query = "AND harga_diskon <= $_GET[pmax]";
}else{
	$query = "ORDER BY no_produk DESC";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $subkategori; ?></title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="../assets/css/easyui.css">
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
						<li><a href="<?php echo base_url("$pecah[3]"); ?>"><?php echo $kategori; ?></a></li>
						<li><a href="<?php echo base_url("$pecah[3]/$pecah[4]"); ?>"><?php echo $subkategori; ?></a></li>
					</ol>
				</div>
			</div>
		</div>

		<?php
		$no_sub = $subkat->result()[0]->no_subkategori;
		$where = array("no_subkategori" => $no_sub);
		$time = time();
		$hal = 24;
		$total_record = $this->model1->selectQuery2("SELECT * FROM produk INNER JOIN promo ON produk.id_promo = promo.id_promo AND promo.lama_promo > $time AND produk.no_subkategori = '$no_sub' $query");
		$haltam = ceil($total_record->num_rows() / $hal);
		$halaman = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
		$start = ($halaman - 1) * $hal;
		$produk = $this->model1->selectQuery2("SELECT * FROM produk INNER JOIN promo ON produk.id_promo = promo.id_promo AND promo.lama_promo > $time AND produk.no_subkategori = '$no_sub' $query LIMIT $start, $hal");
		?>

		<div class="container" style="padding-top:20px;background:white;">
			<div class="row">
				<br class="hidden-lg hidden-md hidden-sm visible-xs">
				<br class="hidden-lg hidden-md hidden-sm visible-xs">

				<div class="col-md-3 col-sm-3 col-lg-3">
					<div class="well well-sm sidebar-kategori-brand">
						<h3><b><?php echo $kategori; ?></b></h3>
						<ul>
							<?php
							$where_sub = array("nama_kategori" => $pecah[$no1]);
							$get_sub = $this->model1->selectWhere("subkategori", $where_sub);
							foreach ($get_sub->result() as $sub) {
								$nama_subkategori = str_replace("_", " ", $sub->nama_subkategori);
							?>
							<li><a href="<?php echo base_url("$sub->nama_kategori/$sub->nama_subkategori"); ?>"><?php echo $nama_subkategori; ?></a></li>
							<?php
							}
							?>
						</ul>
						<hr>
						<h3><b>Brand</b></h3>
						<ul>
							<?php
							//mengambil data no_brand dri tb produk berdasarkan no subkategori & no_brand tdk sama dgn 0
							$get_brand = $this->model1->selectQuery2("SELECT no_brand FROM produk WHERE no_subkategori = '$no_sub' AND no_brand != 0 GROUP BY no_brand");
							
							foreach ($get_brand->result() as $brand) {
							//mengambil data brand berdasarkan no_brand
							$sql_brand = $this->model1->selectQuery2("SELECT * FROM brand WHERE no_brand = '$brand->no_brand'");
							$b = $sql_brand->result()[0];
								if (empty($_GET['brand']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['halaman']) || isset($_GET['sort']))) {
									$brand_link = "?brand=$b->no_brand&$_SERVER[QUERY_STRING]";
								}else if (isset($_GET['brand']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['halaman']) || isset($_GET['sort']))) {
									if (strpos($_SERVER['QUERY_STRING'], "&brand=$_GET[brand]") == TRUE) {
										$query_string = str_replace("&brand=$_GET[brand]", "", $_SERVER['QUERY_STRING']);
									}else{
										$query_string = str_replace("brand=$_GET[brand]&", "", $_SERVER['QUERY_STRING']);
									}
									$brand_link = "?brand=$b->no_brand&$query_string";
								}else{
									$brand_link = "?brand=$b->no_brand";
								}
							?>
							<li><a href="<?php echo $brand_link; ?>"><?php echo $b->nama_brand; ?></a></li>
							<?php
							}
							?>
						</ul>
					</div>
					<div class="well">
						<input id="slider-val" type="hidden" value="<?php echo $hrga = (isset($_GET['pmax'])) ? $_GET['pmax'] : 0; ?>">
						<div id="ss" style="height:100%"></div>
					</div>
				</div>

				<div class="col-md-9 col-sm-9 col-lg-9">
					<div class="well well-sm produk-wrapper-new" style="background:white;border:solid 1px #E1E1E1;">
						<section class="title-produk"><?php echo $subkategori; ?></section>
						<div class="produk-counter">
							<?php
							$jml = ($produk->num_rows() > 24 ) ? 24 : $produk->num_rows();
							?>
							Menampilkan <strong>1-<?php echo $jml; ?></strong> dari <strong><?php echo $produk->num_rows(); ?></strong> Produk
						</div>
						<div class="produk-sort">
							<span>Urut berdasarkan:</span>
							<select onchange="sort(this.value)" class="form-control select" id="select-sort">
								<option value="terbaru">Produk Terbaru</option>
								<option value="termurah">Produk Termurah</option>
								<option value="termahal">Produk Termahal</option>
								<option value="diskon">Diskon Tertinggi</option>
							</select>
							<input type="hidden" id="sort-val" value="<?php echo $s = (isset($_GET['sort'])) ? $_GET['sort'] : ""; ?>">
							<input type="hidden" id="pmax-val" value="<?php echo $p = (isset($_GET['pmax'])) ? $_GET['pmax'] : ""; ?>">
							<input type="hidden" id="query-string" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
							<input type="hidden" id="brand-val" value="<?php echo $p = (isset($_GET['brand'])) ? $_GET['brand'] : ""; ?>">
							<input type="hidden" id="view-val" value="<?php echo $p = (isset($_GET['view_mode'])) ? $_GET['view_mode'] : ""; ?>">
							<input type="hidden" id="page-val" value="<?php echo $p = (isset($_GET['halaman'])) ? $_GET['halaman'] : ""; ?>">
							<span>
								<?php
								if (isset($_GET['view_mode']) && (isset($_GET['pmax']) || isset($_GET['brand']) || isset($_GET['halaman']) || isset($_GET['sort']))) {
									if (strpos($_SERVER['QUERY_STRING'], "&view_mode=$_GET[view_mode]") == TRUE) {
										$replace_str = str_replace("&view_mode=$_GET[view_mode]", "", $_SERVER['QUERY_STRING']);
									}else{
										$replace_str = str_replace("view_mode=$_GET[view_mode]&", "", $_SERVER['QUERY_STRING']);
									}
									$link_viewG = "?view_mode=grid-view&$replace_str";
									$link_viewL = "?view_mode=list-view&$replace_str";
								}else{
									if (isset($_GET['pmax']) || isset($_GET['brand']) || isset($_GET['halaman']) || isset($_GET['sort'])) {
										$link_viewG = "?view_mode=grid-view&$_SERVER[QUERY_STRING]";
										$link_viewL = "?view_mode=list-view&$_SERVER[QUERY_STRING]";
									}else{
										$link_viewG = "?view_mode=grid-view";
										$link_viewL = "?view_mode=list-view";	
									}
								}
								?>
								<a href="<?php echo $link_viewG; ?>" title="Grid View" data-toggle="tooltip" data-placement="top" class="btn btn-link"><i class="glyphicon glyphicon-th-large"></i></a>
								<a href="<?php echo $link_viewL; ?>" title="List View" data-toggle="tooltip" data-placement="top" class="btn btn-link"><i class="glyphicon glyphicon-th-list"></i></a>
							</span>
						</div>
						<div class="clearfix"></div>

						<hr/>
						
						<?php
						if (@$_GET['view_mode'] == "grid-view" || empty($_GET['view_mode'])) {
						?>
						<ul class="row produk-2">
							<?php
							$no = 0;
							foreach ($produk->result() as $produks) {
								$cut_img = explode(",", $produks->gambar_produk);
							?>
							<li class="col-md-3 col-sm-3 produk-wrapper-2">
								<a href="<?php echo base_url("detail_produk/p/$produks->no_produk/"); ?>">
									<center><img src="<?php echo base_url("image/produk-sm/$cut_img[0]"); ?>"></center>
									<div class="caption">
										<p>
										<?php
										$nama_p = (strlen($produks->nama_produk) > 40) ? substr($produks->nama_produk, 0, 40)."..." : $produks->nama_produk;
										echo $nama_p;
										?>
										</p>
										<h5>
										<?php
										if ($produks->diskon_produk != 0) {
											$diskon = $produks->harga_produk * ($produks->diskon_produk / 100);
											$harga = $produks->harga_produk - $diskon;
											?>
											<span>
												<span>Rp <?php echo number_format($produks->harga_produk,0,",","."); ?></span><br>
												<span>Rp. <?php echo number_format($harga,0,",","."); ?></span>
											</span>
											<span class="badge">-<?php echo $produks->diskon_produk; ?>%</span>
											<?php
										}else{
											?>
											<span>
												<span style="display:none;">Rp 0</span>
												<span>Rp. <?php echo number_format($produks->harga_produk,0,",","."); ?></span>
											</span>
											<span class="badge"></span>
											<?php
										}
										?>
										</h5>
										<?php
										echo ($produks->id_promo!=99) ? '<div class="produk-promo-box">PROMO</div>' : "";
										?>
									</div>
								</a>
							</li>
							<?php
							if ($no == 3) {
								echo '</ul><ul class="row produk-2">';
								$no=-1;
							}
							$no++;
							}
							?>
						</ul>
						<?php
						//PAGING
						if (empty($_GET['halaman']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort']))) {
							$link_pageN = "?halaman=".($halaman+1)."&$_SERVER[QUERY_STRING]";
							$link_pageP = "?halaman=".($halaman-1)."&$_SERVER[QUERY_STRING]";
						}else if (isset($_GET['halaman']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort']))) {
							if (strpos($_SERVER['QUERY_STRING'], "&halaman=$_GET[halaman]") == TRUE) {
								$replace_page = str_replace("&halaman=$_GET[halaman]", "", $_SERVER['QUERY_STRING']);
							}else{
								$replace_page = str_replace("halaman=$_GET[halaman]&", "", $_SERVER['QUERY_STRING']);
							}
							$link_pageN = "?halaman=".($halaman+1)."&$replace_page";
							$link_pageP = "?halaman=".($halaman-1)."&$replace_page";
						}else{
							$link_pageN = "?halaman=".($halaman+1);
							$link_pageP = "?halaman=".($halaman-1);
						}

						echo "<div class='row'>
								<div class='col-md-12'>
									<center>";
						echo "<ul class='pagination'>";
						if ($halaman > 1) {
							echo "<li class='previous'><a href='$link_pageP'>&lt;&lt; Prev</a></li>";
						}else{
							echo "<li class='previous'><a href='#' style='cursor: not-allowed;'>&lt;&lt; Prev</a></li>";
						}

						for($page = 1; $page <= $haltam; $page++)
						{
						     if ((($page >= $halaman - 3) && ($page <= $halaman + 3)) || ($page == 1) || ($page == $haltam)) 
						     {
						     	if (isset($_GET['halaman']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort']))) {
									if (strpos($_SERVER['QUERY_STRING'], "&halaman=$_GET[halaman]") == TRUE) {
										$replace_page = str_replace("&halaman=$_GET[halaman]", "", $_SERVER['QUERY_STRING']);
									}else{
										$replace_page = str_replace("halaman=$_GET[halaman]&", "", $_SERVER['QUERY_STRING']);
									}
									$link_page = "?halaman=$page&$replace_page";
								}else{
									if (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort'])) {
										$link_page = "?halaman=$page&$_SERVER[QUERY_STRING]";
									}else{
										$link_page = "?halaman=$page";
									}
								}

						        if ($page == $halaman) echo "<li class='active'><a href='#'>".$page."</a></li> ";
						        else echo "<li><a href='$link_page'>".$page."</a></li>";         
						     }
						}

						if ($halaman < $haltam) {
							echo "<li class='next'><a href='$link_pageN'>Next &gt;&gt;</a></li>";
						}else{
							echo "<li class='next'><a href='#' style='cursor: not-allowed;'>Next &gt;&gt;</a></li>";
						}
						echo "</ul>";
						echo "</center></div></div><div style='clear:both;'></div>";

						}else{
						?>
						<ul class="row produk-2-listview">
							<?php
							$no = 1;
							foreach ($produk->result() as $produks) {
								$cut_img = explode(",", $produks->gambar_produk);
							?>
							<li class="col-md-12 col-sm-12 produk-wrapper-2-listview">
								<a href="<?php echo base_url("detail_produk/p/$produks->no_produk/"); ?>">
								<div class="img-produk">
									<img src="<?php echo base_url("image/produk-sm/$cut_img[0]"); ?>" class="img-responsive">
								</div>
								<div class="caption-produk">
									<h4>
										<?php
										$nama_p = (strlen($produks->nama_produk) > 40) ? substr($produks->nama_produk, 0, 40)."..." : $produks->nama_produk;
										echo $nama_p;
										?>
									</h4>
									<div class="brand-produk-list">
									<?php
									$whereBrands = array("no_brand" => $produks->no_brand);
									$get_brands = $this->model1->selectWhere("brand", $whereBrands);
									if ($get_brands->num_rows() == 0) {
										$brands = "No Brand";
									}else{
										$brands = $get_brands->result()[0]->nama_brand;
									}
									echo "Brand: $brands";
									?>
									</div>
									<div class="harga-produk-list">
										<?php
										if ($produks->diskon_produk != 0) {
										$diskon = $produks->harga_produk * ($produks->diskon_produk / 100);
										$harga = $produks->harga_produk - $diskon;
										?>
										<div>Rp <?php echo number_format($produks->harga_produk,0,",","."); ?></div>
										<div>Rp. <?php echo number_format($harga,0,",","."); ?></div>
										<div><span class="badge">-<?php echo $produks->diskon_produk ?>%</span></div>
										<?php
										}else{
										?>
										<div></div>
										<div>Rp <?php echo number_format($produks->harga_produk,0,",","."); ?></div>
										<?php	
										}
										?>
									</div>
									<?php
									echo ($produks->id_promo!=99) ? '<p></p><div class="produk-promo-box">PROMO</div>' : "";
									?>
								</div>
								</a>
								<div class="detil-produk-list">
									<?php
									if (strlen($produks->deskripsi) > 250) {
										$detail = substr(strip_tags($produks->deskripsi), 0,250)."...";
									}else{
										$detail = strip_tags($produks->deskripsi);
									}
									echo $detail;
									?>
								</div>
							</li>
							<?php
							}
							?>
						</ul>
						<?php
						//PAGING
						if (empty($_GET['halaman']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort']))) {
							$link_pageN = "?halaman=".($halaman+1)."&$_SERVER[QUERY_STRING]";
							$link_pageP = "?halaman=".($halaman-1)."&$_SERVER[QUERY_STRING]";
						}else if (isset($_GET['halaman']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort']))) {
							if (strpos($_SERVER['QUERY_STRING'], "&halaman=$_GET[halaman]") == TRUE) {
								$replace_page = str_replace("&halaman=$_GET[halaman]", "", $_SERVER['QUERY_STRING']);
							}else{
								$replace_page = str_replace("halaman=$_GET[halaman]&", "", $_SERVER['QUERY_STRING']);
							}
							$link_pageN = "?halaman=".($halaman+1)."&$replace_page";
							$link_pageP = "?halaman=".($halaman-1)."&$replace_page";
						}else{
							$link_pageN = "?halaman=".($halaman+1);
							$link_pageP = "?halaman=".($halaman-1);
						}

						echo "<div class='row'>
								<div class='col-md-12'>
									<center>";
						echo "<ul class='pagination'>";
						if ($halaman > 1) {
							echo "<li class='previous'><a href='$link_pageP'>&lt;&lt; Prev</a></li>";
						}else{
							echo "<li class='previous'><a href='#' style='cursor: not-allowed;'>&lt;&lt; Prev</a></li>";
						}

						for($page = 1; $page <= $haltam; $page++)
						{
						     if ((($page >= $halaman - 3) && ($page <= $halaman + 3)) || ($page == 1) || ($page == $haltam)) 
						     {
						     	if (isset($_GET['halaman']) && (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort']))) {
									if (strpos($_SERVER['QUERY_STRING'], "&halaman=$_GET[halaman]") == TRUE) {
										$replace_page = str_replace("&halaman=$_GET[halaman]", "", $_SERVER['QUERY_STRING']);
									}else{
										$replace_page = str_replace("halaman=$_GET[halaman]&", "", $_SERVER['QUERY_STRING']);
									}
									$link_page = "?halaman=$page&$replace_page";
								}else{
									if (isset($_GET['pmax']) || isset($_GET['view_mode']) || isset($_GET['brand']) || isset($_GET['sort'])) {
										$link_page = "?halaman=$page&$_SERVER[QUERY_STRING]";
									}else{
										$link_page = "?halaman=$page";
									}
								}

						        if ($page == $halaman) echo "<li class='active'><a href='#'>".$page."</a></li> ";
						        else echo "<li><a href='$link_page'>".$page."</a></li>";         
						     }
						}

						if ($halaman < $haltam) {
							echo "<li class='next'><a href='$link_pageN'>Next &gt;&gt;</a></li>";
						}else{
							echo "<li class='next'><a href='#' style='cursor: not-allowed;'>Next &gt;&gt;</a></li>";
						}
						echo "</ul>";
						echo "</center></div></div><div style='clear:both;'></div>";

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
<script src="<?php echo base_url("assets/js/jquery.easyui.min.js"); ?>"></script>
<script>
var get = $("#sort-val").val();
var pmax = $("#pmax-val").val();
var brand = $("#brand-val").val();
var view = $("#view-val").val();
var page = $("#page-val").val();
var qry = $("#query-string").val();

$('#ss').slider({
    mode: 'h',
    tipFormatter: function(value){
        return 'Rp ' + value;
    },
    showTip: true,
    min: 0,
    max: 50000000,
    step: 100000,
    value: $("#slider-val").val(),
    onComplete: function(value){
    	if (pmax == "" && (brand!="" || page!="" || get!="" || view!="")) {
    		window.location = '?pmax=' + value + '&' + qry;
    	}else if (pmax != "" && (brand!="" || page!="" || get!="" || view!="")) {
    		if (qry.search("pmax="+pmax) > 0) {
    			window.location = '?pmax=' + value + '&' + qry.replace("&pmax="+pmax,"");
    		}else{
    			window.location = '?pmax=' + value + '&' + qry.replace("pmax="+pmax+"&","");
    		}
    	}else{
    		window.location = '?pmax=' + value;
    	}
    }
});

function sort(val) {
	if (get != "" && (brand!="" || page!="" || pmax!="" || view!="")) {
		if (qry.search("sort="+get) > 0) {
			window.location = '?sort=' + val + '&' + qry.replace("&sort="+get,"");
		}else{
			window.location = '?sort=' + val + '&' + qry.replace("sort="+get+"&","");
		}
	}else if (get == "" && (brand!="" || page!="" || pmax!="" || view!="")) {
		window.location = '?sort=' + val + '&' + qry;
	}else{
		window.location = '?sort=' + val;
	}
}

if (get != "") {
	$("#select-sort").val(get).attr("selected","selected");
}

</script>
</body>
</html>