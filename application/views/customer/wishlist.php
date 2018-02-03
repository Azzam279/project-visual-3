<div class="row">
	<div class="col-md-12">
		<div>
			<h2><b>Wishlist Saya <i class="fa fa-heart-o"></i></b></h2><br>
			<div class="table-responsive">
			<table class="table table-condensed table-hover table-striped">
				<thead>
					<tr>
						<th width="100"><center>Produk</center></th>
						<th width="250"></th>
						<th>Tanggal</center></th>
						<th>Ketersediaan</center></th>
						<th colspan="2">Harga</th>
					</tr>
				</thead>
				<tbody>
					<?php
					date_default_timezone_set('Asia/Singapore');
					foreach ($sql_wishlist->result() as $wishlist) {
						if ($wishlist->stok_produk > 0) {$stok="<font color='green'>Stok tersedia</font>";}else{$stok="<font color='red'>Stok kosong</font>";}
						$img = explode(",", $wishlist->gambar_produk);

						echo "<tr id='row$wishlist->id_wishlist'>";
							echo "<td><a href='".base_url("detail_produk/p/$wishlist->id_produk")."'><img src='".base_url("image/produk-sm/$img[0]")."' class='img-responsive' style='width:100%;'></a></td>";
							echo "<td>$wishlist->nama_produk<br><div id='wish$wishlist->id_wishlist'></div><a href='javascript:void(0)' class='btn btn-link btn-sm' onclick='del_wish($wishlist->id_wishlist)' id='link$wishlist->id_wishlist'><i class='fa fa-times-circle'></i> Hapus produk</a></td>";
							echo "<td>".date("d/m/Y",$wishlist->tgl)."</td>";
							echo "<td>$stok</td>";
							echo "<td style='color:red;font-weight:bold;'>";
								echo "Rp ".number_format($wishlist->harga_diskon);	
							echo "</td>";
							echo "<td><a href='".base_url("detail_produk/p/$wishlist->id_produk")."' class='btn btn-default'><i class='glyphicon glyphicon-eye-open'></i> Detail Produk</a></td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
			</div>
			<div class="clearfix">
				<small>Limit 20 Wishlist</small>
			</div>			
		</div>
	</div>
</div>