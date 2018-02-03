<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order</title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style2.css"); ?>">
    <style>
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
						            <button type="button" class="btn btn-primary btn-circle"><b>1</b></button>
						            <p>ISI DATA PEMBELIAN</p>
						        </div>
						        <div class="stepwizard-step">
						            <button type="button" class="btn btn-default btn-circle"><b>2</b></button>
						            <p>KONFIRMASI PEMBAYARAN</p>
						        </div> 
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
	    //jika troli kosong maka arahkan ke homepage
	    if ($cek_troli->num_rows() == 0) {
	    	redirect('/');
	    	exit();
	    }

	    if (isset($_SESSION['id_customer'])) {
			$tbl = "customer";
			$name = "id_customer";
	    	$customer = $_SESSION['id_customer'];
			$nama = $cst->nama;
			$email = $cst->email;
			$sex = $cst->sex;
			$tgl_lahir = $cst->tgl_lahir;
			$alamat = $cst->alamat;
			$provinsi = $cst->provinsi;
			$kota = $cst->kota;
			$no_hp = $cst->no_hp;
			$kode_pos = $cst->kode_pos;
	    }else{
			$tbl = "customer_sementara";
			$name = "id_customer_sementara";
	    	$customer = $_COOKIE['temp_customer'];
			$nama = "";
			$email = "";
			$sex = "";
			$tgl_lahir = "";
			$alamat = "";
			$provinsi = "";
			$kota = "";
			$no_hp = "";
			$kode_pos = "";
	    }
?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="col-md-8" style="padding-left:0;">
					<div id="data-pembelian-wrapper">
						<h2>Isi Data Pembelian</h2><hr>
						<form action="<?php echo htmlspecialchars(base_url("ordered")); ?>" method="post" class="form-horizontal">
							<div class="form-group">
								<label class="col-md-3">Nama Pembeli :</label>
								<div class="col-md-7">
									<input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>" maxlength="100" placeholder="Nama Anda" autofocus required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Email Pembeli :</label>
								<div class="col-md-7">
									<input type="email" name="email" class="form-control" value="<?php echo $email; ?>" maxlength="150" placeholder="Email Anda" required><span><small>Pastikan email yang Anda tuliskan valid. <i class="glyphicon glyphicon-question-sign"></i></small></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Alamat :</label>
								<div class="col-md-7">
									<textarea name="alamat" class="form-control" rows="7" placeholder="Contoh: Jl.Kemuning Ujung no.17 RT.009 RW.002 Gg. Intan" maxlength="400" required><?php echo $alamat; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Provinsi :</label>
								<div class="col-md-7">
									<select name="provinsi" class="form-control" id="desprovince">
										<option value="">-Provinsi-</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kota / Kabupaten :</label>
								<div class="col-md-7">
									<select name="kota" class="form-control" id="descity">
										<option value="">-Kota-</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kurir :</label>
								<div class="col-md-9">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										<a href="javascript:void(0)" onclick="cekOngkir()" id="cek" class="btn btn-default btn-sm">Pilih Kurir</a>
									</div>
								</div>
							</div>
							<!--<div class="form-group">
								<label class="col-md-3">Provinsi :</label>
								<div class="col-md-7">
									<?php
									/*echo "<select name='provinsi' class='form-control' id='pro' onchange='pilihKota(this.value,\"$customer\",\"$name\",\"$tbl\")'>";
									echo "<option value=''>-Pilih Provinsi-</option>";
									if ($qry1->num_rows() == 0) {
										$provinsi_id = 0;
									}else{
										$provinsi_id = $qry1->result()[0]->provinsi;
									}
									foreach ($sql_p->result() as $x) {
										if ($x->provinsi_id == $provinsi_id) {
											echo "<option value='$x->provinsi_id' selected>$x->provinsi_nama</option>";
										}else{
											echo "<option value='$x->provinsi_id'>$x->provinsi_nama</option>";
										}
									}
									echo "</select>";
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kota/Kabupaten :</label>
								<div class="col-md-7">
									<div id="city"></div>
									<?php
									if ($qry1->num_rows() == 0) {
										$kota_id = 0;
									}else{
										$kota_id = $qry1->result()[0]->kota;
									}
									echo "<div id='ko'>";
									echo "<select class='form-control' name='kota'>";
									echo "<option value=''>-Pilih Kota/Kabupaten-</option>";
									foreach ($sql_k->result() as $y) {
										if ($y->kota_id == $kota_id) {
											echo "<option value='$y->kota_id' selected>$y->kokab_nama</option>";
										}
									}
									echo "</select>";
									echo "</div>";
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kecamatan :</label>
								<div class="col-md-7">
									<div id="kcmt"></div>
									<?php
									if ($qry1->num_rows() == 0) {
										$kecam_id = 0;
									}else{
										$kecam_id = $qry1->result()[0]->kecamatan;
									}
									echo "<div id='kec'>";
									echo "<select class='form-control' name='kecamatan'>";
									echo "<option value=''>-Pilih Kecamatan-</option>";
									foreach ($sql_kc->result() as $z) {
										if ($z->kecam_id == $kecam_id) {
											echo "<option value='$z->kecam_id' selected>$z->nama_kecam</option>";
										}
									}
									echo "</select>";
									echo "</div>";*/
									?>
								</div>
							</div>-->
							<div class="form-group">
								<label class="col-md-3">Kode Pos :</label>
								<div class="col-md-7">
									<input type="number" name="kodepos" class="form-control" value="<?php echo $kd_pos = ($kode_pos==0) ? "" : $kode_pos; ?>" placeholder="Masukkan Angka Saja" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">No. Handphone :</label>
								<div class="col-md-7">
									<input type="number" name="no_hp" class="form-control" placeholder="08123456789" value="<?php echo $hp = ($no_hp==0) ? "" : $no_hp; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-7">
									<button class="btn btn-success" name="beli" value="beli">Konfirmasi Beli</button>
								</div>
							</div>
						</form>
					</div>
					<br>
				</div>
				<div class="col-md-4" style="padding-right:0;">
					<div id="daftar-belanja-wrapper">
						<h2>Daftar Belanja</h2><hr>
						<div class="table-responsive">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>Barang</th>
										<th><span class="pull-right">Subtotal</span></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$berat = 0;
									foreach ($get_troli->result() as $item) {
									?>
									<tr>
										<td class="daftar-barang">
											<div class="pull-left">
												<?php
												//jika jumlah gambar lebih dari satu eksekusi ini
												if (strpos($item->gambar_produk, ",") == TRUE) {
													$cut = explode(",", $item->gambar_produk);
													$img = $cut[0];
												//jika gambar hanya satu eksekusi script dibawah ini
												}else{
													$img = $item->gambar_produk;
												}
												?>
												<img src="<?php echo base_url("image/produk-sm/$img"); ?>" style="width:50px;">
											</div>
											<div class="pull-left">
												<div>
												<?php
												//jika panjang nama produk lebih dari 15karakter maka eksekusi script ini
												if(strlen($item->nama_produk) > 15) {
													$nama_items = substr($item->nama_produk, 0,15)." ...";
												//jika tdk maka eksekusi script dibawah ini
												}else{
													$nama_items = $item->nama_produk;
												}
												echo $nama_items;
												?>
												</div>
												<?php
												//jika ada diskon
												if ($item->diskon_produk != 0) {
													$diskon = $item->harga_produk * ($item->diskon_produk/100);
													$hargaProduk = $item->harga_produk - $diskon;
												//jika tdk ada diskon	
												}else{
													$hargaProduk = $item->harga_produk;
												}
												?>
												<div><?php echo $item->kuantitas; ?> barang</div>
												<div>Rp <?php echo number_format($hargaProduk,0,",","."); ?></div>
											</div>
										</td>
										<td align="right" class="subtotal-barang">
											Rp <?php echo number_format($item->subtotal,0,",","."); ?>
										</td>
									</tr>
									<?php
										$berat += $item->berat; 
									}
									$get_troli->free_result();
									?>
									<tr>
										<td><span id="total-caption">TOTAL :</span></td>
										<td><span id="harga-caption" class="pull-right">Rp <?php echo number_format($total,0,",","."); ?></span></td>
									</tr>
									<tr>
										<td colspan="2">
											<font color="red"><i>Belum Termasuk Biaya Kirim</i></font>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
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
	function pilihKota(c,v,n,t) {
		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/select-alamat"); ?>',
			type: 'POST',
			datatype: 'php',
			data: 'pick_city='+c+'&tbl='+t+'&name='+n+'&val='+v,
			beforeSend: function(){
				$("#ko").remove();
				$("#kec").remove();
				$("#city").addClass("preloader6");
				$("#kcmt").addClass("preloader6");
			},
			success: function(hasil){
				$("#city").removeClass("preloader6");
				$("#kcmt").removeClass("preloader6");
				$('#city').html(hasil);
			},
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
		});
	}

	function pilihKecamatan(k,v,n,t) {
		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/select-alamat"); ?>',
			type: 'POST',
			datatype: 'php',
			data: 'pick_kcm='+k+'&tbl='+t+'&name='+n+'&val='+v,
			beforeSend: function(){
				$("#kec").remove();
				$("#hpus_kec").remove();
				$("#kcmt").addClass("preloader6");
			},
			success: function(hasil){
				$("#kcmt").removeClass("preloader6");
				$('#kcmt').html(hasil);
			},
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
		});
	}

	$(document).ready(function() {
		//tampilkan provinsi
		loadProvinsi("#desprovince");
		//disable tombol cekOngkir
		$("#cek").attr("disabled","disabled");
		//event menampilkan kota/kabupaten berdasarkan id provinsi
		$("#desprovince").change(function() {
			var idprovince = $("#desprovince").val();
			var idcity = $("#descity");
			loadCity(idprovince, idcity);
		});
		var kota = '<?php echo $kota; ?>';
		if (kota != "") {
			var idprovince = $("#desprovince").val();
			var idcity = $("#descity");
			loadCity(idprovince, idcity);
		}
	});

	//proses tampilkan provinsi
	function loadProvinsi(id) {
		var id_provinsi = '<?php echo $provinsi; ?>';
		$(id).html("Loading...");
		$.ajax({
			url: '<?php echo base_url("ajax/index/api_rajaongkir/proses?act=show_provinsi"); ?>',
			dataType: 'json',
			success: function(response) {
				$(id).html('');
				province = '';
				$.each(response['rajaongkir']['results'], function(i,n) {
					if (n['province_id'] == id_provinsi) {
						province = '<option value="'+n['province_id']+'" selected>'+n['province']+'</option>';
					}else{
						province = '<option value="'+n['province_id']+'">'+n['province']+'</option>';
					}
					province = province + '';
					$(id).append(province);
				});
			},
			error: function() {
				$(id).html("ERROR!");
			}
		});
	}

	//proses tampilkan kota/kabupaten
	function loadCity(idprovince, id) {
		var id_kota = '<?php echo $kota; ?>';
		$.ajax({
			url: '<?php echo base_url("ajax/index/api_rajaongkir/proses?act=show_kota"); ?>',
			dataType: 'json',
			data: {province:idprovince},
			success: function(response) {
				$(id).html('');
				city = '';
				$.each(response['rajaongkir']['results'], function(i,n) {
					if (n['city_id'] == id_kota) {
						city = '<option value="'+n['city_id']+'" selected>'+n['city_name']+'</option>';
					}else{
						city = '<option value="'+n['city_id']+'">'+n['city_name']+'</option>';
					}
					city = city + '';
					$(id).append(city);
				});
				//aktifkan tombol cekOngkir
				$("#cek").removeAttr("disabled");
			},
			error: function() {
				$(id).html("ERROR!");
			}
		});
	}

	//proses tampil ongkir
	function cekOngkir() {
		var origin = 35;
		var destination = $("#descity").val();
		var weight = parseInt('<?php echo $berat; ?>');
		$.ajax({
			url: '<?php echo base_url("ajax/index/api_rajaongkir/proses?act=show_cost"); ?>',
			data: {origin:origin,destination:destination,weight:weight},
			beforeSend: function() {
				$("#accordion").addClass("preloader6");
			},
			success: function(response) {
				$("#accordion").removeClass("preloader6");
				$("#accordion").html(response).slideDown("slow");
			},
			error: function() {
				$("#accordion").html("ERROR!");
			}
		}); 
	}
</script>
</body>
</html>