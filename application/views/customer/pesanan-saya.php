<?php
date_default_timezone_set('Asia/Singapore');
?>
<div class="row">
	<div class="col-md-12">
		<div>
			<h2><b>Pesanan Saya <i class="fa fa-cubes"></i></b></h2><br>
			<?php
			if ($get_pesanan->num_rows() == 0) {
				echo "<br>";
				echo "<center><img src='".base_url("image/empty-new.jpg")."'></center>";
			}

			foreach ($get_pesanan->result() as $data) {
			?>
			<div class="table-responsive" style="border-radius:4px;position:relative;">
				<?php
				if ($data->status_barang == "N" && $data->tgl_exp < time()) {
					echo "<div style='position:absolute;left:0;top:0;bottom:0;right:0;background:rgba(0,0,0,0.3);z-index:5;'></div>";
					echo "<div class='info-batal'>Pesanan Dibatalkan!</div>";
				}
				?>
				<table class="table table-condensed">
					<thead>
						<tr bgcolor="#7FAAFF" style="color:white;">
							<th colspan="2">Produk</th>
							<th>Harga</th>
							<th>Kuantitas</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$noP = explode("|", $data->id_produk);
						$produk = explode("|", $data->produk);
						$gambar = explode("|", $data->gambar);
						$harga = explode("|", $data->harga);
						$qty = explode("|", $data->kuantitas);
						$sub = explode("|", $data->subtotal);
						$count = count($produk);
						for ($x = 0; $x < $count; $x++) {
							$img = explode(",", $gambar[$x]);
						?>
						<tr>
							<td>
								<a href="<?php echo base_url("detail_produk/p/$noP[$x]"); ?>"><img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" style="width:60px;" class="img-responsive"></a>
							</td>
							<td>
								<?php echo $produk[$x]; ?>
							</td>
							<td>
								<?php echo "Rp ".number_format($harga[$x],0,",","."); ?>
							</td>
							<td>
								<?php echo $qty[$x]; ?>
							</td>
							<td>
								<?php echo "Rp ".number_format($sub[$x],0,",","."); ?>
							</td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td></td>
							<td colspan="3" align="right"><b>Subtotal</b></td>
							<td><b><?php echo "Rp ".number_format($data->total,0,",","."); ?></b></td>
						</tr>
						<?php
						$ongkir = ($data->ongkir == 0) ? "Menunggu" : "Rp ".number_format($data->ongkir,0,",",".");
						?>
						<tr>
							<td></td>
							<td colspan="3" align="right"><b>Ongkir</b></td>
							<td><b><?php echo $ongkir; ?></b></td>
						</tr>
						<tr>
						<?php
						$total1 = $data->total + $data->ongkir;
						$total  = ($data->ongkir == 0) ? "Menunggu" : "Rp ".number_format($total1,0,",",".");
						?>
							<td></td>
							<td colspan="3" align="right"><b>Total</b></td>
							<td><b><?php echo $total; ?></b></td>
						</tr>
						<?php
						if ($data->status_barang == "Y") {
							$status = "<font color='#55FF2A'>Dikirim</font>";
						}else if ($data->status_barang == "P") {
							$status = "<font color='orange'>Diproses</font>";
						}else{
							$status = "Menunggu";
						}
						?>
						<tr>
							<td></td>
							<td colspan="3" align="right"><b>Status Order</b></td>
							<td><b><?php echo $status; ?></b></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="3" align="right"><b>Kurir</b></td>
							<td>
							<?php
							$kurir = explode(",", $data->kurir);
							echo "$kurir[0],<br>$kurir[1]";
							?>
							</td>
						</tr>
						<tr>
						<?php
						$resi = (!empty($data->no_resi)) ? $data->no_resi : "-";
						?>
							<td></td>
							<td colspan="3" align="right"><b>Nomor Resi</b></td>
							<td><?php echo $resi; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="margin-top:10px;">
				<div class="pull-left">
					<?php
					if ($data->status_barang == "N" && $data->tgl_exp > time()) {
					?>
					<h6><b>Batas Waktu Pembayaran</b></h6>
					<div><?php echo date("d-m-Y H:i:s",$data->tgl_exp); ?></div><p></p>
					<p style="color:#F46C44;font-weight:700;">Segera lakukan pembayaran ke salah satu rekening dibawah ini:</p>
					<div class="clearfix"></div>
					<div class="bank-wrapper">
						<span><img src="<?php echo base_url("image/bank/Mandiri-small.png"); ?>" class="img-responsive"></span>
						<span>No. Rek 031 0004 669 XXX</span>
					</div>
					<div class="bank-wrapper">
						<span><img src="<?php echo base_url("image/bank/BCA-small.png"); ?>" class="img-responsive"></span>
						<span>No. Rek 676 023 0XXX</span>
					</div>
					<div class="bank-wrapper">
						<span><img src="<?php echo base_url("image/bank/BRI-small.png"); ?>" class="img-responsive"></span>
						<span>No. Rek 092 401 000018 XXX</span>
					</div>
					<div class="bank-wrapper">
						<span><img src="<?php echo base_url("image/bank/BNI-small.png"); ?>" class="img-responsive"></span>
						<span>No. Rek 333 400 5XXX</span>
					</div>
					<?php
					}
					?>
				</div>
				<div class="pull-right">
					<?php
					echo date("d-m-Y H:i:s",$data->tgl);
					?>
				</div>
				<div class="clearfix"></div>
			</div>
			<hr><br>
			<?php
			}
			?>
		</div>
	</div>
</div>
