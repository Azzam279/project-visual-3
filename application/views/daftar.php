<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar</title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style2.css"); ?>">
    <style>
#daftar {
	-webkit-box-shadow: 0px 3px 13px 0px rgba(0,0,0,0.55);
	-moz-box-shadow: 0px 3px 13px 0px rgba(0,0,0,0.55);
	box-shadow: 0px 3px 13px 0px rgba(0,0,0,0.55);
	border: solid 1px rgba(33,180,226,1);
	border-radius: 7px;
	margin-top: 12px;
}

.ribbon-box-5 {
	font:bold 16px Cambria,Georgia,Times,Serif;
	color:#fff;width:80%;
	font-size: 20px;
	text-align:center;padding:0px 30px;
	background: rgba(33,180,226,1);
	background: -moz-linear-gradient(top, rgba(33,180,226,1) 0%, rgba(33,180,226,1) 28%, rgba(183,222,237,1) 98%, rgba(183,222,237,1) 100%);
	background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(33,180,226,1)), color-stop(28%, rgba(33,180,226,1)), color-stop(98%, rgba(183,222,237,1)), color-stop(100%, rgba(183,222,237,1)));
	background: -webkit-linear-gradient(top, rgba(33,180,226,1) 0%, rgba(33,180,226,1) 28%, rgba(183,222,237,1) 98%, rgba(183,222,237,1) 100%);
	background: -o-linear-gradient(top, rgba(33,180,226,1) 0%, rgba(33,180,226,1) 28%, rgba(183,222,237,1) 98%, rgba(183,222,237,1) 100%);
	background: -ms-linear-gradient(top, rgba(33,180,226,1) 0%, rgba(33,180,226,1) 28%, rgba(183,222,237,1) 98%, rgba(183,222,237,1) 100%);
	background: linear-gradient(to bottom, rgba(33,180,226,1) 0%, rgba(33,180,226,1) 28%, rgba(183,222,237,1) 98%, rgba(183,222,237,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#21b4e2', endColorstr='#b7deed', GradientType=0 );
	position:relative;
	line-height:48px;
	margin-top:10px;
	margin-bottom: 25px;
	margin-left: auto;
	margin-right: auto;
}

.ribbon-box-5:before {
	content:"";position:absolute;
	top:100%;left:0px;
	width:0px;height:0px;
	border-width:5px;border-style:solid;
	border-color:rgba(33,180,226,1) rgba(33,180,226,1) transparent transparent;
}

.ribbon-box-5:after {
	content:"";position:absolute;
	top:100%;right:0px;
	width:0px;height:0px;
	border-width:5px;border-style:solid;
	border-color:rgba(33,180,226,1) transparent transparent rgba(33,180,226,1);
}
.ribbon-box-5 div {width:100%;}

.ribbon-box-5 div:before, .ribbon-box-5 div:after {
	content:"";position:absolute;
	width:0px;height:0px;
	border:24px solid rgba(33,180,226,1);
	top:10px;z-index:-1;
}

.ribbon-box-5 div:before {
	border-left-color:transparent;
	right:100%;margin-right:-10px;
}

.ribbon-box-5 div:after {
	border-right-color:transparent;
	left:100%;margin-left:-10px;
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
			<div class="col-md-12 col-sm-12" id="daftar">
				<div id="daftar-bg" class="hidden-xs hidden-sm">
					<img src="<?php echo base_url("image/register.png"); ?>">
				</div>
				<div id="daftar-wrapper">
					<div style="position:relative;z-index:1;">
					    <div class="ribbon-box-5">
					        <div>
					          Buat Akun
					        </div>
					    </div>
					</div>
					<form action="<?php echo htmlspecialchars(base_url("register/proses_register")); ?>" method="post">
						<div class="form-group">
							<label>Nama :</label>
							<input type="text" name="nama" class="form-control" maxlength="150" placeholder="Masukkan Nama Anda" autofocus required>
							<label>Email :</label>
							<input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
							<label>Password :</label>
							<input type="password" name="pass" class="form-control" placeholder="Masukkan Password" required>
							<label>Konfirmasi Password :</label>
							<input type="password" name="pass2" class="form-control" placeholder="Ketik Ulang Password" required>
							<label>Jenis Kelamin :</label><br>
							<input type="radio" name="jkl" value="Laki-laki" id="L" required> <label for="L" style="font-weight:normal;">Laki-laki</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="jkl" value="Perempuan" id="P" required> <label for="P" style="font-weight:normal;">Perempuan</label><br>
							<label>Tanggal Lahir :</label><br>
							<select name="tahun" style="padding:7px;" required>
				        		<?php
				        		for ($t=1945;$t<=2015;$t++) {
				        			echo "<option value='$t'>$t</option>";
				        		}
				        		?>
				        	</select>
				        	<select name="bulan" style="width:120px;padding:7px;" required>
				        		<?php
				        		$arr_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
				        		foreach ($arr_bulan as $key_bln => $val_bln) {
				        			$key = $key_bln+1;
				        			echo "<option value='$key'>$val_bln</option>";
				        		}
				        		?>
				        	</select>
				        	<select name="tanggal" style="padding:7px;" required>
				        		<?php
				        		$tgl = 1;
				        		while ($tgl <= 31) {
				        			echo "<option value='$tgl'>$tgl</option>";
				        			$tgl++;
				        		}
				        		?>
				        	</select>
							<br><br>
							<button class="btn btn-primary" name="daftar" value="daftar">Daftar <i class="glyphicon glyphicon-ok-sign"></i></button>
							<button type="reset" class="btn btn-warning">Cancel <i class="glyphicon glyphicon-remove-sign"></i></button>
						</div>
					</form>
					<br><br>
				</div>
			</div>
		</div>
		</div>

		<br><br>

		<?php $this->load->view("footer"); ?>

	</div>
</div>

<?php $this->load->view("source-js"); ?>
</body>
</html>