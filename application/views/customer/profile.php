<?php $get_cust = $get_profile->result()[0];  ?>
<h2>Halo <b><?php echo $get_cust->nama; ?></b> <i class="fa fa-user"></i></h2><br>
<div class="row">
	<div class="col-md-7">
        <?php
		//mengambil tahun dari tanggal lahir
		$cut_thn = substr($get_cust->tgl_lahir, 0,4);
		//mengambil bulan dari tanggal lahir
		$cut_bln = substr($get_cust->tgl_lahir, 5,2);
		//mengambil tanggal dari tanggal lahir
		$cut_tgl = substr($get_cust->tgl_lahir, 8,2);

		$jkl_l = ($get_cust->sex == "Laki-laki") ? 'checked="checked"' : '';
		$jkl_p = ($get_cust->sex == "Perempuan") ? 'checked="checked"' : '';
		?>
		<form action="<?php echo htmlspecialchars(base_url("customer/update_profile")); ?>" method="post">
			<label>Nama <span class="redstar">*</span></label>
			<input type="text" name="nama" class="form-control" value="<?php echo ucwords($get_cust->nama); ?>" maxlength="100" required><br>
			<label>Tanggal Lahir <span class="redstar">*</span></label><br>
			<select name="tahun" style="height:35px;width:90px;" required>
        		<?php
        		for ($t=1945;$t<=2015;$t++) {
        			if ($cut_thn == $t) {
        				echo "<option value='$t' selected>$t</option>";
        			}else{
        				echo "<option value='$t'>$t</option>";
        			}
        		}
        		?>
            </select>
            <select name="bulan" style="height:35px;width:120px;" required>
        		<?php
        		$arr_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        		foreach ($arr_bulan as $key_bln => $val_bln) {
        			$key = $key_bln+1;
        			if ($cut_bln == $key) {
        				echo "<option value='$key' selected>$val_bln</option>";
        			}else{
        				echo "<option value='$key'>$val_bln</option>";
        			}
        		}
        		?>
        	</select>
        	<select name="tanggal" style="height:35px;width:50px;" required>
        		<?php
        		$tgl = 1;
        		while ($tgl <= 31) {
        			if ($cut_tgl == $tgl) {
        				echo "<option value='$tgl' selected>$tgl</option>";
        				$tgl++;
        			}else{
						echo "<option value='$tgl'>$tgl</option>";
        				$tgl++;
        			}
        		}
        		?>
            </select><br><br>
            <label>No. Handphone <span class="redstar">*</span></label>
			<input type="number" name="no_hp" class="form-control" value="<?php echo $hp = ($get_cust->no_hp==0) ? "" : $get_cust->no_hp; ?>" required><br>
			<label>Jenis Kelamin <span class="redstar">*</span></label><br>
			<input type="radio" name="jkl" value="Laki-laki" id="L"	<?php echo $jkl_l; ?> required> <label for="L" style="font-weight:normal;">Laki-laki</label><br>
			<input type="radio" name="jkl" value="Perempuan" id="P" <?php echo $jkl_p; ?> required> <label for="P" style="font-weight:normal;">Perempuan</label><br><br>
			<label>Email <span class="redstar">*</span></label>
			<input type="email" name="email" class="form-control" value="<?php echo $get_cust->email; ?>" maxlength="150" required>
            <input type="hidden" name="email2" value="<?php echo $get_cust->email; ?>">
            <br><br>
			<button class="btn btn-primary" name="save_profile" value="save_profile">Simpan</button>
		</form>
	</div>
</div>