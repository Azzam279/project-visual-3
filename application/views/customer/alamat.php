<div class="row">
	<div class="col-md-7">
		<div>
			<h2><center><b>Informasi Alamat <i class="fa fa-map-marker"></i></b></center></h2><hr>
			<?php $alamat = $get_alamat->result()[0]; ?>
			<form action="<?php echo htmlspecialchars(base_url("customer/update_alamat")); ?>" method="post">
				<div class="form-group">
					<label>Alamat <span class="redstar">*</span></label>
					<textarea name="alamat" rows="7" class="form-control" maxlength="400" required><?php echo trim($alamat->alamat); ?></textarea><br>
					<label>Provinsi <span class="redstar">*</span></label>
					<select name="provinsi" class="form-control" id="desprovince">
						<option value="">-Provinsi-</option>
					</select>
					<input type="hidden" id="prov" value="<?php echo $alamat->provinsi; ?>">
					<label>Kota / Kabupaten <span class="redstar">*</span></label>
					<select name="kota" class="form-control" id="descity">
						<option value="">-Kota-</option>
					</select>
					<input type="hidden" id="kota" value="<?php echo $alamat->kota; ?>">
					<br>
					<label>Kode Pos <span class="redstar">*</span></label>
					<?php $kodepos = ($alamat->kode_pos==0) ? "" : $alamat->kode_pos; ?>
					<input type="number" class="form-control" name="kode_pos" value="<?php echo $kodepos; ?>" required><br>
					<button class="btn btn-primary" name="save_alamat" value="save_alamat">Simpan</button><br>
				</div>
			</form>
		</div>
	</div>
</div>