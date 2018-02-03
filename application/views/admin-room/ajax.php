<?php
if (isset($_POST['no_kat'])) {
	if (!empty($_POST['no_kat'])) {
		$where1 = array("no_kategori" => $_POST['no_kat']);
		$get_kat = $this->model1->selectWhere("kategori", $where1);
		$tipe = $get_kat->result()[0]->tipe;

		if ($tipe == "parent") {
			$where2 = array("no_kategori" => $_POST['no_kat']);
			$get_sub = $this->model1->selectWhere("subkategori", $where2);
			echo "<select class='form-control' name='subkategori' required>";
			foreach ($get_sub->result() as $sub) {
				echo "<option value='$sub->no_subkategori'>$sub->nama_subkategori</option>";
			}
			$get_sub->free_result();
			echo "<select>";
		}else{
			echo "
			<select class='form-control' name='subkategori'>
				<option value='999'>-Tidak ada Subkategori-</option>
			</select>";
		}
	}else{
		echo "
		<select class='form-control' name='subkategori' required>
			<option value=''>-Pilih Subkategori-</option>
		</select>";
	}
}

if (isset($_GET['id_order']) && isset($_GET['val'])) {
	//proses update status_barang pd tbl order_produk
	$status = $_GET['val'];
	$info = ($status != "N") ? "Y" : "N";
	$data = array("status_barang" => $status, "notif" => $info);
	$upd_order = $this->model1->updateData("id_order",$_GET['id_order'],"order_produk",$data);
	if ($upd_order == 1) {
		if ($_GET['val'] == "N" || $_GET['val'] == "P") {
			echo "Sukses";
		}else{
			//mengambil data order_produk berdasarkan id_order
			$get_produk = $this->model1->selectWhere("order_produk", array("id_order" => $_GET['id_order']));
			$produk = $get_produk->result()[0];
			$p = explode("|", $produk->id_produk);
			$k = explode("|", $produk->kuantitas);
			$h = explode("|", $produk->harga);
			for ($x=0; $x < count($p); $x++) {
				//mengambil data produk berdasarkan no_produk
				$qry = $this->model1->selectWhere("produk", array("no_produk" => $p[$x]));
				$t = $qry->result()[0];
				//update terjual dan stok pd tbl produk
				$data2 = array(
					"terjual" => $t->terjual + (int)$k[$x],
					"stok_produk" => $t->stok_produk - (int)$k[$x]
					);
				$upd_produk = $this->model1->updateData("no_produk",$p[$x],"produk",$data2);

				//insert terjual, date_terjual, dan time_terjual pd tbl produk_terjual
				$harga = $h[$x] * $k[$x];
				$data3 = array(
					"id_terjual" => null,
					"id_produk" => $p[$x],
					"harga" => $harga,
					"terjual" => (int)$k[$x],
					"date_terjual" => date("m-Y", time()),
					"time_terjual" => time()
					);
				$ins_terjual = $this->model1->insertData("produk_terjual", $data3);
			}
			if ($upd_produk > 0 && $ins_terjual > 0) {
				echo "Sukses";
			}else{
				echo "Gagal2";
			}
		}
	}else{
		echo "Gagal";
	}
}

if (isset($_GET['no_resi'])) {
	//proses update no resi pd tbl order_produk
	$data = array("no_resi" => $_GET['resi']);
	$upd_resi = $this->model1->updateData("id_order",$_GET['no_resi'],"order_produk",$data);
	if ($upd_resi == 1) {
		echo "Sukses";
	}else{
		echo "Gagal";
	}
}

if (isset($_GET['del'])) {
	//proses hapus pesanan
	$del = $this->model1->deleteData("order_produk", array("id_order" => $_GET['del']));
	if ($del == 1) {
		echo "Sukses";
	}else{
		echo "Gagal";
	}
}

if (isset($_GET['act'])) {
    //mengambil class dari function.php
    $this->load->view("admin-room/class");
    //instance class rajaongkir
    $tujuan = new rajaongkir();

    //membuat objek dan menampilkan provinsi & kota
    $prov = $tujuan->showprovince($_GET['id_prov']);
    $kota = $tujuan->showcity($_GET['id_kota']);

	echo "$prov - $kota";
}

if (isset($_GET['status'])) {
	//proses update status admin
	$update_status = $this->model1->updateData("id_admin",$_GET['id_adm'],"admin",array("aktif" => $_GET['status']));
	if ($update_status == 1) {
		echo "Sukses";
	}else{
		echo "Gagal";
	}
}

if (isset($_GET['id_servis'])) {
	//menampilkan data servis utk admin dengan level Kasir / Boss
	$select = $this->model1->selectWhere("servis", array("id_servis" => $_GET['id_servis']));
	$data = $select->result()[0];
	echo "
	<table class='table table-hover table-condensed'>
        <tr>
            <td width='200'><b>ID Pelanggan</b></td>
            <td width='10'>:</td>
            <td>$data->id_servis</td>
        </tr>
        <tr>
            <td width='200'><b>Nama Pelanggan</b></td>
            <td width='10'>:</td>
            <td>$data->nama</td>
        </tr>
        <tr>
            <td width='200'><b>No Telepon / HP</b></td>
            <td width='10'>:</td>
            <td>$data->no_telp</td>
        </tr>
        <tr>
            <td width='200'><b>Nama Barang</b></td>
            <td width='10'>:</td>
            <td>$data->barang</td>
        </tr>
        <tr>
            <td width='200'><b>Merk Barang</b></td>
            <td width='10'>:</td>
            <td>$data->merk</td>
        </tr>
        <tr>
            <td width='200'><b>Kelengkapan</b></td>
            <td width='10'>:</td>
            <td>$data->kelengkapan</td>
        </tr>
        <tr>
            <td width='200'><b>Kerusakan</b></td>
            <td width='10'>:</td>
            <td>$data->kerusakan</td>
        </tr>
        <tr>
            <td width='200'><b>Catatan & Saran</b></td>
            <td width='10'>:</td>
            <td>";
            echo (empty($data->catatan_saran)) ? "-Kosong-" : $data->catatan_saran;
            echo
            "</td>
        </tr>
        <tr>
            <td width='200'><b>Status</b></td>
            <td width='10'>:</td>
            <td>";
            if ($data->status == "Menunggu") {
            	echo "<font color='blue'>$data->status</font>";
            }else if ($data->status == "Selesai") {
            	echo "<font color='lime'>$data->status</font>";
            }else{
            	echo "<font color='orange'>$data->status</font>";
            }
			echo
            "</td>
        </tr>
        <tr>
            <td width='200'><b>Tanggal Masuk</b></td>
            <td width='10'>:</td>
            <td>".date("d-m-Y H:i:s",$data->tgl_masuk)."</td>
        </tr>
        <tr>
            <td width='200'><b>Tanggal Selesai</b></td>
            <td width='10'>:</td>
            <td>";
            echo ($data->tgl_selesai==0) ? "-Kosong-" : date("d-m-Y H:i:s",$data->tgl_selesai);
            echo
            "</td>
        </tr>
    </table>
	";
}

if (isset($_GET['no_servis'])) {
	//menampilkan data servis utk teknisi
	$select = $this->model1->selectWhere("servis", array("id_servis" => $_GET['no_servis']));
	$data = $select->result()[0];
	echo "
	<table class='table table-hover table-condensed'>
        <tr>
            <td width='200'><b>ID Pelanggan</b></td>
            <td width='10'>:</td>
            <td>$data->id_servis</td>
        </tr>
        <tr>
            <td width='200'><b>Nama Pelanggan</b></td>
            <td width='10'>:</td>
            <td>$data->nama</td>
        </tr>
        <tr>
            <td width='200'><b>No Telepon / HP</b></td>
            <td width='10'>:</td>
            <td>$data->no_telp</td>
        </tr>
        <tr>
            <td width='200'><b>Nama Barang</b></td>
            <td width='10'>:</td>
            <td>$data->barang</td>
        </tr>
        <tr>
            <td width='200'><b>Merk Barang</b></td>
            <td width='10'>:</td>
            <td>$data->merk</td>
        </tr>
        <tr>
            <td width='200'><b>Kelengkapan</b></td>
            <td width='10'>:</td>
            <td>$data->kelengkapan</td>
        </tr>
        <tr>
            <td width='200'><b>Kerusakan</b></td>
            <td width='10'>:</td>
            <td>$data->kerusakan</td>
        </tr>
        <tr>
            <td width='200'><b>Catatan & Saran</b></td>
            <td width='10'>:</td>
            <td>";
            echo "
				<textarea name='catatan' id='isi-catatan' class='form-control' rows='5'>$data->catatan_saran</textarea>
				<p></p>
				<button onclick='simpanCatatan($data->id_servis)' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Simpan Perubahan</button>
            ";
            echo
            "</td>
        </tr>
        <tr>
            <td width='200'><b>Status</b></td>
            <td width='10'>:</td>
            <td>
            	<select class='form-control' name='status' onchange='status_servis(this.value,$data->id_servis)'>";
		            $status1 = ($data->status == "Menunggu") ? "selected" : "";
		            $status2 = ($data->status == "Dikerjakan") ? "selected" : "";
		            $status3 = ($data->status == "Selesai") ? "selected" : "";
		            echo "
					<option value='Menunggu' $status1>Menunggu</option>
					<option value='Dikerjakan' $status2>Dikerjakan</option>
					<option value='Selesai' $status3>Selesai</option>
		            ";
			echo
            	"</select>
            </td>
        </tr>
        <tr>
            <td width='200'><b>Tanggal Masuk</b></td>
            <td width='10'>:</td>
            <td>".date("d-m-Y H:i:s",$data->tgl_masuk)."</td>
        </tr>
        <tr>
            <td width='200'><b>Tanggal Selesai</b></td>
            <td width='10'>:</td>
            <td>";
            echo ($data->tgl_selesai==0) ? "-Kosong-" : date("d-m-Y H:i:s",$data->tgl_selesai);
            echo
            "</td>
        </tr>
    </table>
	";
}

if (isset($_GET['update_status']) && isset($_GET['id_service'])) {
	//proses update status barang servis pd tbl servis
	if ($_GET['update_status'] == "Selesai") {
		$update = $this->model1->updateData("id_servis",$_GET['id_service'],"servis",array("status" => $_GET['update_status'], "tgl_selesai" => time()));
	}else{
		$update = $this->model1->updateData("id_servis",$_GET['id_service'],"servis",array("status" => $_GET['update_status'], "tgl_selesai" => "0"));
	}
	//cek apakah proses update berhasil atau gagal
	if ($update == 1) {
		echo "<div class='alert-sukses page-alert'>
			<button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
			Status berhasil diperbaharui!
		</div>";
	}else{
		echo "<div class='alert-gagal page-alert'>
			<button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
			Status gagal diperbaharui!
		</div>";
	}
}

if (isset($_POST['catatan']) && isset($_POST['id_servis'])) {
	//proses update catatan / saran pada tbl servis
	$update = $this->model1->updateData("id_servis",$_POST['id_servis'],"servis",array("catatan_saran" => $_POST['catatan']));
	if ($update == 1) {
		echo "<div class='alert-sukses page-alert'>
			<button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
			Catatan / Saran berhasil diperbaharui!
		</div>";
	}else{
		echo "<div class='alert-gagal page-alert'>
			<button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
			Catatan / Saran berhasil diperbaharui!
		</div>";
	}
}

if (isset($_GET['id_prd']) && isset($_GET['url'])) {
	//proses update notif menjadi 'N' pada tbl feedback
	$where = array("id_produk" => $_GET['id_prd'], "notif" => 'Y');
	$data = array("notif" => 'N');
	$update = $this->model1->updateDataSpec($where,"feedback",$data);
}

if (isset($_GET['bisu']) && isset($_GET['status_banned'])) {
	//jika status banned = Bisu maka Y (banned) jika tidak maka N (unbanned) 
	$banned = ($_GET['status_banned']=="Bisu") ? "Y" : "N";
	$update = $this->model1->updateData("id_online", $_GET['bisu'], "chatting_online", array("banned" => $banned));
	if ($update == 1) {
		echo "Sukses";
	}else{
		echo "Gagal";
	}
}

if (isset($_GET['thn']) && isset($_GET['tipe']) && isset($_GET['kat']) && isset($_GET['sub'])) {
	//tahun
	$thn = $_GET['thn'];
	//kategori
	$exp = explode("-", $_GET['kat']);
	$kat = (!empty($_GET['kat'])) ? "AND produk.no_kategori = $exp[0]" : "";
	//subkategori
	$sub = (!empty($_GET['sub'])) ? "AND produk.no_subkategori = $_GET[sub]" : $kat;

	//mengambil data terjual berdasarkan tanggal terjual
	$sql_jan = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '01-$thn' $sub");
	$sql_feb = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '02-$thn' $sub");
	$sql_mar = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '03-$thn' $sub");
	$sql_apr = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '04-$thn' $sub");
	$sql_mei = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '05-$thn' $sub");
	$sql_jun = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '06-$thn' $sub");
	$sql_jul = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '07-$thn' $sub");
	$sql_agu = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '08-$thn' $sub");
	$sql_sep = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '09-$thn' $sub");
	$sql_okt = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '10-$thn' $sub");
	$sql_nov = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '11-$thn' $sub");
	$sql_des = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as trjual FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND produk_terjual.date_terjual = '12-$thn' $sub");
	$jan = ($sql_jan->result()[0]->trjual != 0) ? $sql_jan->result()[0]->trjual : 0;
	$feb = ($sql_feb->result()[0]->trjual != 0) ? $sql_feb->result()[0]->trjual : 0;
	$mar = ($sql_mar->result()[0]->trjual != 0) ? $sql_mar->result()[0]->trjual : 0;
	$apr = ($sql_apr->result()[0]->trjual != 0) ? $sql_apr->result()[0]->trjual : 0;
	$mei = ($sql_mei->result()[0]->trjual != 0) ? $sql_mei->result()[0]->trjual : 0;
	$jun = ($sql_jun->result()[0]->trjual != 0) ? $sql_jun->result()[0]->trjual : 0;
	$jul = ($sql_jul->result()[0]->trjual != 0) ? $sql_jul->result()[0]->trjual : 0;
	$agu = ($sql_agu->result()[0]->trjual != 0) ? $sql_agu->result()[0]->trjual : 0;
	$sep = ($sql_sep->result()[0]->trjual != 0) ? $sql_sep->result()[0]->trjual : 0;
	$okt = ($sql_okt->result()[0]->trjual != 0) ? $sql_okt->result()[0]->trjual : 0;
	$nov = ($sql_nov->result()[0]->trjual != 0) ? $sql_nov->result()[0]->trjual : 0;
	$des = ($sql_des->result()[0]->trjual != 0) ? $sql_des->result()[0]->trjual : 0;

	//tampilkan grafik penjualan
	echo '<div id="SalesChart" style="height:400px;width:100%;"></div>';
	?>
	<script>
	//grafik penjualan dgn canvasjs chart
    var optionz = {
            title: {
                text: "Grafik Penjualan pada tahun <?php echo $thn; ?>"
            },
                    animationEnabled: true,
            data: [
            {
                type: "<?php echo $_GET['tipe']; ?>", //change it to line, area, bar, pie, etc
                dataPoints: [
                    { label: 'Januari', y: parseInt('<?php echo $jan; ?>') },
                    { label: 'Februari', y: parseInt('<?php echo $feb; ?>') },
                    { label: 'Maret', y: parseInt('<?php echo $mar; ?>') },
                    { label: 'April', y: parseInt('<?php echo $apr; ?>') },
                    { label: 'Mei', y: parseInt('<?php echo $mei; ?>') },
                    { label: 'Juni', y: parseInt('<?php echo $jun; ?>') },
                    { label: 'Juli', y: parseInt('<?php echo $jul; ?>') },
                    { label: 'Agustus', y: parseInt('<?php echo $agu; ?>') },
                    { label: 'September', y: parseInt('<?php echo $sep; ?>') },
                    { label: 'Oktober', y: parseInt('<?php echo $okt; ?>') },
                    { label: 'November', y: parseInt('<?php echo $nov; ?>') },
                    { label: 'Desember', y: parseInt('<?php echo $des; ?>') },
                ]
            }
            ]
        };
    $("#SalesChart").CanvasJSChart(optionz);
	</script>
	<?php
}

if (isset($_GET['tipe_kat']) && isset($_GET['nmr_kat'])) {
	if ($_GET['tipe_kat'] == "parent") {
		//mengambil data subkategori berdasarkan nomor kategori
		$subkat_trjual = $this->model1->selectWhere("subkategori", array("no_kategori" => $_GET['nmr_kat']));
			echo '<option value="">-Semua Subkategori-</option>';
		foreach ($subkat_trjual->result() as $subkat) {
			echo "
			<option value='$subkat->no_subkategori'>".ucfirst($subkat->nama_subkategori)."</option>
			";
		}
		$subkat_trjual->free_result();
	}else{
		echo '<option value="">-Semua Subkategori-</option>';
	}
}

if (isset($_GET['r_thn']) && isset($_GET['r_bln'])) {
	$r_thn = $_GET['r_thn']; //tahun
	if ($_GET['r_bln'] == "") { //jika $_GET[r_bln] kosong maka tampilkan semua bulan
		$date = "'01-$r_thn','02-$r_thn','03-$r_thn','04-$r_thn','05-$r_thn','06-$r_thn','07-$r_thn','08-$r_thn','09-$r_thn','10-$r_thn','11-$r_thn','12-$r_thn'";
	}else{ //jika tdk maka tampilkan bulan yg brsangkutan
		$r_bln = (strlen($_GET['r_bln'])==1) ? "0".$_GET['r_bln'] : $_GET['r_bln']; //bulan
		$date = "'$r_bln-$r_thn'";
	}
	//mengambil semua data dri tbl kategori
	$kat = $this->model1->selectData("kategori");
	foreach ($kat->result() as $k) {
		//mengambil data subkategori berdasarkan no_kategori
		$sub = $this->model1->selectWhere("subkategori", array("no_kategori" => $k->no_kategori));
		//hitung total barang terjual berdasarkan no_kategori & date_terjual
		$kat_trjual = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as sold FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND date_terjual IN ($date) AND produk.no_kategori = $k->no_kategori");
		//hitung total subtotal(harga) berdasarkan no_kategori & date_terjual
		$kat_subtotal = $this->model1->selectQuery2("SELECT SUM(produk_terjual.harga) as total FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND date_terjual IN ($date) AND produk.no_kategori = $k->no_kategori");
		//rowspan = jumlah record subkategori + 1;
		$rows = $sub->num_rows()+1;
		$rowspan = ($sub->num_rows()!=0) ? "rowspan='$rows'" : "rowspan='2'";
		$kSold = ($kat_trjual->result()[0]->sold!=0) ? $kat_trjual->result()[0]->sold : 0;
		$kTotal = ($kat_subtotal->result()[0]->total!=0) ? $kat_subtotal->result()[0]->total : 0;
		echo "
		<tr>
			<td $rowspan align='center' style='vertical-align:middle'>".str_replace("_", " ", ucwords($k->nama_kategori))."</td>";
			echo "<td $rowspan align='center' style='vertical-align:middle'>";
			echo $kSold;
			echo "</td>";
			echo "<td $rowspan align='center' style='vertical-align:middle'>";
			echo "Rp ".number_format($kTotal,0,",",".");
			echo "</td>
		</tr>";
		if ($sub->num_rows() == 0) { //jika tdk ada subkategori
			echo "<tr>
					<td>-Kosong-</td>
					<td align='center'>$kSold</td>
					<td align='center'>Rp ".number_format($kTotal,0,",",".")."</td>
				</tr>";
		}else{ //jika ada subkategori
			foreach ($sub->result() as $s) {
				//hitung total barang terjual berdasarkan no_subkategori & date_terjual
				$sub_trjual = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as sold FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND date_terjual IN ($date) AND produk.no_subkategori = $s->no_subkategori");
				//hitung total subtotal(harga) berdasarkan no_subkategori & date_terjual
				$sub_subtotal = $this->model1->selectQuery2("SELECT SUM(produk_terjual.harga) as total FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND date_terjual IN ($date) AND produk.no_subkategori = $s->no_subkategori");
				echo "
				<tr>
					<td>".str_replace("_", " ", ucwords($s->nama_subkategori))."</td>
					<td align='center'>";
					$sSold = ($sub_trjual->result()[0]->sold!=0) ? $sub_trjual->result()[0]->sold : 0;
					echo $sSold;
				echo		
					"</td>
					<td align='center'>";
					$sTotal = ($sub_subtotal->result()[0]->total!=0) ? $sub_subtotal->result()[0]->total : 0;
					echo "Rp ".number_format($sTotal,0,",",".");
				echo		
					"</td>
				</tr>
				";
			}
			$sub->free_result();
		}
	}
	$kat->free_result();
	//hitung total barang terjual berdasarkan date_terjual (tanggal terjual)
	$trjual = $this->model1->selectQuery2("SELECT SUM(produk_terjual.terjual) as sold FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND date_terjual IN ($date)");
	//hitung total subtotal(harga) berdasarkan date_terjual (tanggal terjual)
	$total = $this->model1->selectQuery2("SELECT SUM(produk_terjual.harga) as total FROM produk_terjual INNER JOIN produk ON produk_terjual.id_produk = produk.no_produk AND date_terjual IN ($date)");
	echo "<tr style='font-size:15px; background:#F3F3F3;'>
			<td colspan='2'><b>Total Barang Terjual & Omzet : </b></td>
			<td></td>
			<td></td>
			<td align='center'><b>".$trjual->result()[0]->sold."</b></td>
			<td align='center'><b>Rp ".number_format($total->result()[0]->total,0,',','.')."</b></td>
		</tr>";
}
?>
