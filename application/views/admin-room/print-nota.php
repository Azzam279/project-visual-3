<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Nota Terima Servis</title>
	<?php $this->load->view("admin-room/source-css"); ?>
</head>
<body onload="window.print()">

	<?php $data = $cetak->result()[0]; ?>
	
	<br><br><br>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-7 pull-left" style="padding:0;">
					<div style="display:inline-block;vertical-align:top;">
						<img src="../../image/new-logo.png" alt="logo" class="img-responsive">
					</div>
					<div style="display:inline-block; padding-left:10px;">
						<p>
							Jl. Kemuning Ujung No.17 RT.002 RW.009 Gg.Intan Banjarbaru <br>
							089698594961 <br>
							muhammad.azzam2579@gmail.com <br>
						</p>
					</div>
				</div>
				<div class="col-md-5 pull-right" style="padding:0;">
					<div class="table-responsive">
						<table>
							<?php
							echo "
							<tr>
					            <td width='150'><b>ID Pelanggan</b></td>
					            <td width='10'>:</td>
					            <td>$data->id_servis</td>
					        </tr>
					        <tr>
					            <td width='150'><b>Nama Pelanggan</b></td>
					            <td width='10'>:</td>
					            <td>$data->nama</td>
					        </tr>
					        <tr>
					            <td width='150'><b>No Telepon / HP</b></td>
					            <td width='10'>:</td>
					            <td>$data->no_telp</td>
					        </tr>
					        <tr>
					            <td width='150'><b>Tanggal</b></td>
					            <td width='10'>:</td>
					            <td>".date("d-m-Y H:i:s",$data->tgl_masuk)."</td>
					        </tr>
							";
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table border="2" class="table table-bordered table-striped table-condensed">
							<?php
								echo "
								<tr>
						            <td width='200'><b>Nama Barang</b></td>
						            <td>$data->barang</td>
						        </tr>
						        <tr>
						            <td width='200'><b>Merk Barang</b></td>
						            <td>$data->merk</td>
						        </tr>
						        <tr>
						            <td width='200'><b>Kelengkapan</b></td>
						            <td>$data->kelengkapan</td>
						        </tr>
						        <tr>
						            <td width='200'><b>Kerusakan</b></td>
						            <td>$data->kerusakan</td>
						        </tr>
								";
							?>
					</table>
				</div>
			</div>
		</div>
	</div>

<?php $this->load->view("admin-room/source-js"); ?>
</body>
</html>