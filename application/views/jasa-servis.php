<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Jasa Servis</title>
    <?php $this->load->view("source-css"); ?>
    <style>
		.clickable{
		    cursor: pointer;   
		}

		#panel-list-servis .panel-heading div {
			margin-top: -18px;
			font-size: 15px;
		}
		#panel-list-servis .panel-heading div span{
			margin-left:5px;
		}
		#panel-list-servis .panel-body{
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
						<li><a href="#">Jasa Servis</a></li>
					</ol>
				</div>
			</div>
		</div>

		<div class="container" style="padding-top:20px;background:white;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<br class="hidden-lg hidden-md hidden-sm visible-xs">
					<br class="hidden-lg hidden-md hidden-sm visible-xs">

					<div class="panel panel-info" id="panel-list-servis">
						<div class="panel-heading">
							<h3 class="panel-title">Daftar Servis</h3>
							<div class="pull-right">
								<span class="clickable filter" data-toggle="tooltip" title="Cari?" data-placement="top">
									<i class="glyphicon glyphicon-filter"></i>
								</span>
							</div>
						</div>
						<div class="panel-body">
							<input type="text" class="form-control" id="dev-table-filter" placeholder="Cari berdasarkan ID / Nama" />
						</div>
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Nama</th>
										<th>Barang</th>
										<th>Merk</th>
										<th>Kelengkapan</th>
										<th>Kerusakan</th>
										<th>Status</th>
										<th>Tgl Masuk</th>
										<th>Tgl Selesai</th>
									</tr>
								</thead>
								<tbody>
									<?php
									date_default_timezone_set('Asia/Singapore');
									foreach ($servis->result() as $data) {
										echo "
										<tr>
											<td>$data->id_servis</td>
											<td>$data->nama</td>
											<td>$data->barang</td>
											<td>$data->merk</td>
											<td>$data->kelengkapan</td>
											<td>$data->kerusakan</td>
											<td>";
											if ($data->status == "Menunggu") {
								            	echo "<font color='black'>$data->status</font>";
								            }else if ($data->status == "Selesai") {
								            	echo "<font color='lime'>$data->status</font>";
								            }else{
								            	echo "<font color='orange'>$data->status</font>";
								            }	
										echo		
											"</td>
											<td>".date('d-m-Y H:i:s', $data->tgl_masuk)."</td>
											<td>";
										echo ($data->tgl_selesai == 0) ? "-Belum selesai-" : date('d-m-Y H:i:s', $data->tgl_selesai);
										echo		
											"</td>
										</tr>
										";	
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
						
					<!--<img src="<?php //echo base_url("image/Page_Under_Construction.jpg"); ?>" alt="underConstruction" class="img-responsive" style="margin:auto;">-->
					<br><br>
					<div class="clearfix"></div>
				</div>
	        </div>
		</div>

		<?php $this->load->view("footer"); ?>

	</div>
</div>

<?php $this->load->view("source-js"); ?>
<script>
	$(function(){
		$('.container').on('click', '.panel-heading span.filter', function(e){
			var $this = $(this), 
				$panel = $this.parents('.panel');
			
			$panel.find('.panel-body').slideToggle();
			if($this.css('display') != 'none') {
				$panel.find('.panel-body input').focus();
			}
		});
	})
</script>
</body>
</html>