<?php
if (isset($_POST['pick_city'])) {
	//mengambil data kota berdasarkan id provinsi
	$city = $this->model1->selectWhere("master_kokab", array("provinsi_id" => $_POST['pick_city']));
	//mengambil data pelanggan berdasarkan session/cookie
	$cst = $this->model1->selectWhere($_POST['tbl'], array($_POST['name'] => $_POST['val']));
	//data kota dari table pelanggan (customer/customer_sementara)
	if ($cst->num_rows() == 0) {
		$pelanggan = 0;
	}else{
		$pelanggan = $cst->result()[0]->kota;
	}

	echo '<select name="kota" class="form-control" onchange="pilihKecamatan(this.value,\''.$_POST['val'].'\',\''.$_POST['name'].'\',\''.$_POST['tbl'].'\')" required>';

		if (@$_POST['pick_city'] != "") {
			echo "<option value=''>-Pilih Kota/Kabupaten-</option>";
			foreach ($city->result() as $kota) {
				if ($pelanggan == $kota->kota_id) {
					echo "<option value='$kota->kota_id' selected>$kota->kokab_nama</option>";
				}else{
					echo "<option value='$kota->kota_id'>$kota->kokab_nama</option>";
				}
			}
		}else{
			echo '<option value="">-Pilih Kota/Kabupaten-</option>';
		}

	echo '</select>';

	echo "<script>$('#kcmt').html(\"<select name='kecamatan' id='hpus_kec' class='form-control' required><option value=''>-Pilih Kecamatan-</option></select>\")</script>";
}else if (isset($_POST['pick_kcm'])) {
	//mengambil data kecamatan berdasarkan id kota
	$kcm = $this->model1->selectWhere("master_kecam", array("kota_id" => $_POST['pick_kcm']));
	//mengambil data pelanggan berdasarkan session/cookie
	$cst2 = $this->model1->selectWhere($_POST['tbl'], array($_POST['name'] => $_POST['val']));
	//data kota dari table pelanggan (customer/customer_sementara)
	if ($cst2->num_rows() == 0) {
		$pelanggan2 = 0;
	}else{
		$pelanggan2 = $cst2->result()[0]->kecamatan;
	}

	echo '<select name="kecamatan" class="form-control" required>';

		if (@$_POST['pick_kcm'] != "") {
			echo "<option value=''>-Pilih Kecamatan-</option>";
			foreach ($kcm->result() as $kecam) {
				if ($pelanggan2 == $kecam->kecam_id) {
					echo "<option value='$kecam->kecam_id' selected>$kecam->nama_kecam</option>";
				}else{
					echo "<option value='$kecam->kecam_id'>$kecam->nama_kecam</option>";
				}
			}
		}else{
			echo '<option value="">-Pilih Kecamatan-</option>';
		}

	echo '</select>';
}else{
	redirect('/');
}
?>