<?php
include_once("identify.php");
//echo "<script>alert('$_SESSION[id_customer]');</script>";
//echo "<script>alert('$_COOKIE[temp_customer]');</script>";
?>

<div id="nav-fixed" class="nav-fixed">
	<!-- Menu Navigasi 1 -START- -->
	<nav class="navbar navbar-default menu1" id="menu1">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<span id="slogan">Situs jual beli online abal-abal & tidak terpercaya</span>
				<ul class="nav navbar-nav navbar-right">
					<li id="link-home"><a href="<?php echo base_url(); ?>">Home</a></li>
					<?php
					if (isset($_SESSION['id_customer'])) { //jika ada customer login
					?>
					<li>
						<a href="<?php echo base_url("customer/pesanan_saya"); ?>" onclick="updateInfo(<?php echo $my_order; ?>)" id="my-order">Pesanan Saya
						<?php if($my_order!=0){echo "<i class='badge'> $my_order </i>";}?></a>
					</li>
					<?php	
					}else{ //jika tdk login
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" id="my-order">Pesanan Saya 
						<?php if($my_order!=0){echo "<i class='badge'> $my_order </i>";}?></a>
						<ul class="dropdown-menu" id="dropdown-pesanan">
							<li class="gn-submenu">
								<div style="padding:12px;">
									<label>Masukkan Nomor Transaksi</label><p></p>
									<input type="text" id="nmr_trans" class="form-control" placeholder="Nomor Transaksi" onkeypress="return isNumberKeyAngka(event)" required><p></p>
									<button class="btn btn-success btn-block" onclick="cek_pesanan('<?php echo base_url("cek_pesanan/cek/"); ?>')">Lanjut <i class="fa fa-arrow-circle-right"></i></button>
								</div>
							</li>
						</ul>
					</li>
					<?php
					}
					?>
					<li style="font-size:20px;color:#E1E1E1;">|</li>
					<li><a href="<?php echo base_url("jasa_servis"); ?>">Jasa Servis</a></li>
					<li style="font-size:20px;color:#E1E1E1;">|</li>
					<li><a href="#" data-toggle="modal" data-target="#modal-contact">Hubungi Kami</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Menu Navigasi 1 -FINISH- -->

	<!-- Menu Navigasi 2 -START- -->
	<nav class="navbar navbar-default" id="menu2">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="<?php echo base_url(); ?>" class="navbar-brand">
					<img src="<?php echo base_url("image/new-logo.png"); ?>" class="img-responsive">
				</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse-2">
				<!-- Form Pencarian -START- -->
				<form action="<?php echo base_url("search"); ?>" method="post" class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Cari produk..." id="input-search" name="cari">
						<button type="submit" class="btn btn-default btn-lg" id="btn-cari" name="proses" value="proses"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<!-- Form Pencarian -FINISH- -->

				<!-- Keranjang Belanja -START- -->
				<?php
				$sql_qty = $this->model1->selectWhere("troli", array($name => $val));
				$get_qty = $sql_qty->num_rows();
				$sql_total = $this->model1->SUM("troli","subtotal",array($name => $val));
				$get_total = $sql_total->result()[0]->subtotal;
				?>
				<a class="badge" id="keranjang" href="<?php echo base_url("keranjang_belanja"); ?>">
					<span id="jml-item-dikeranjang" class="badge"><?php echo $get_qty; ?></span>
					<i class="fa fa-shopping-cart fa-2x"></i>
					<span id="total-harga-dikeranjang">Rp <?php echo number_format($get_total,0,",","."); ?></span>
				</a>
				<!-- Keranjang Belanja -FINISH- -->

				<!-- Menu Daftar & Login -START- -->
				<ul class="nav navbar-nav navbar-right">
					<?php 
					if (isset($_SESSION['id_customer'])) {
						$whereCst = array("id_customer" => $_SESSION['id_customer']);
						$sql_customer = $this->model1->selectWhere("customer", $whereCst);
						$customer = $sql_customer->result()[0];
					?>
					<li class="dropdown">
						<a href="#" id="btn-login" class="dropdown-toggle" data-toggle="dropdown">Akun</a>
						<ul class="dropdown-menu" style="position:fixed;z-index:9001;">
	                        <li>
	                            <div class="navbar-login">
	                                <div class="row">
	                                    <div class="col-lg-4" style="padding-right:0;">
	                                        <p class="text-center">
	                                        	<?php
	                                        	//mengambil data foto dr tbl customer
	                                        	$getFoto = $this->model1->selectQuery2("SELECT foto FROM customer WHERE id_customer = '$_SESSION[id_customer]'");
	                                        	if (empty($getFoto->result()[0]->foto)) { //jika foto kosong
	                                        	?>
	                                        	<span class="glyphicon glyphicon-user icon-size"></span>
	                                        	<?php
	                                        	}else{ //jika foto tdk kosong
	                                        	?>
	                                        	<img src="<?php echo base_url("image/foto/customer/".$getFoto->result()[0]->foto); ?>" alt="foto" class="img-responsive">
	                                        	<?php
	                                        	}
	                                        	?>
	                                        </p>
	                                        <p align="center">
	                                        	<a href="#uploadFotoModal" data-toggle="modal"><small>Upload Foto</small></a>
	                                        </p>
	                                    </div>
	                                    <div class="col-lg-8">
	                                        <p class="text-left"><strong><?php echo $customer->nama; ?></strong></p>
	                                        <p class="text-left small"><?php echo $customer->email; ?></p>
	                                        <p class="text-left">
	                                            <a href="<?php echo base_url("customer/profile"); ?>" class="btn btn-primary btn-block btn-sm">Akun Saya</a>
	                                        </p>
	                                        <p class="text-left">
	                                            <a href="<?php echo base_url("customer/pesanan_saya"); ?>" class="btn btn-primary btn-block btn-sm">Pesanan Saya</a>
	                                        </p>
	                                        <p class="text-left">
	                                            <a href="<?php echo base_url("customer/wishlist"); ?>" class="btn btn-primary btn-block btn-sm">Wishlist</a>
	                                        </p>
	                                    </div>
	                                </div>
	                            </div>
	                        </li>
	                    </ul>
	                </li>
					<li style="padding:0;">
						<a href="<?php echo base_url("logout"); ?>" id="btn-logout" class="btn btn-danger">Logout</a>
					</li>
                    <?php
                    }else{
                    ?>
                    <li>
						<a id="btn-login" class="btn btn-default btn-outline btn-circle collapsed" data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Login</a>
					</li>
					<li style="padding:0;">
						<a href="<?php echo base_url("register"); ?>" id="btn-daftar">Daftar</a>
					</li>
					<?php
					}
					?>
				</ul>

					<!-- Form Login -START- -->
					<div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2" style="padding-top:4px;">
						<form class="navbar-form navbar-right form-inline" role="form" style="margin-left:0;margin-right:20px;" method="post" action="<?php echo base_url("login");?>">
						  <div class="input-group">
						    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						    <input type="email" class="form-control" name="email" id="Email" placeholder="Email" autofocus required />
						  </div>
						  <div class="input-group">
						    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						    <input type="password" name="password" class="form-control" id="Password" placeholder="Password" required />
						  </div>
						  <button type="submit" class="btn btn-primary" value="login" name="login">Sign in</button>
						</form>
					</div>
					<!-- Form Login -FINISH- -->
				<!-- Menu Daftar & Login -FINISH- -->
			</div>
		</div>
	</nav>
	<!-- Menu Navigasi 2 -FINISH- -->
</div>

<div class="hidden-lg hidden-md hidden-sm visible-xs">
	<br><br><br>
</div>