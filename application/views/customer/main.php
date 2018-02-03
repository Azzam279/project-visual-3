<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Customer</title>
    <?php $this->load->view("source-css"); ?>
    <style>
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
						<li><a href="javascript:void(0)">Customer</a></li>
					</ol>
				</div>
			</div>
		</div>

		<br><br>

		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php
					$this->load->view("customer/sidebar");
					$this->load->view("customer/content");
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
	$(document).ready(function() {
		//tampilkan provinsi
		loadProvinsi("#desprovince");
		//event menampilkan kota/kabupaten berdasarkan id provinsi
		$("#desprovince").change(function() {
			var idprovince = $("#desprovince").val();
			var idcity = $("#descity");
			loadCity(idprovince, idcity);
		});
		var kota = $("#kota").val();
		if (kota != "") {
			var idprovince = $("#desprovince").val();
			var idcity = $("#descity");
			loadCity(idprovince, idcity);
		}
	});

	//proses tampilkan provinsi
	function loadProvinsi(id) {
		var id_provinsi = $("#prov").val();
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
		var id_kota = $("#kota").val();
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
			},
			error: function() {
				$(id).html("ERROR!");
			}
		});
	}

	//proses hapus wishlist
	function del_wish(nmr) {
		$.ajax({
			url: '<?php echo base_url("ajax/index/ajax/hapus_wishlist"); ?>',
			type: 'GET',
			dataType: 'html',
			data: 'id_wishlist='+nmr,
			beforeSend: function() {
				$("#link"+nmr).remove();
				$("#wish"+nmr).html("<div class='label label-info'>Loading...</div>");
			},
			success: function(hasil) {
				if (hasil == "Sukses") {
					$("#row"+nmr).slideUp();
				}else{
					$("#wish"+nmr).html("<div class='label label-warning'>Wishlist gagal dihapus!</div>");
				}
			},
			error: function() {
				alert("Error!");
			}
		});
	}
</script>
</body>
</html>