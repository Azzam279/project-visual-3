<div class="row">
	<div class="col-md-10">
		<h2><b>Ubah Password <i class="fa fa-key"></i></b></h2><hr>
		<form action="<?php echo htmlspecialchars(base_url("customer/update_password")); ?>" method="post" class="form-horizontal">
			<div class="form-group">
				<label class="col-md-4">Password Lama :</label>
				<div class="col-md-8">
					<input type="password" name="old_pass" class="form-control" placeholder="Masukkan Password Lama" autofocus required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Password Baru :</label>
				<div class="col-md-8">
					<input type="password" name="new_pass" class="form-control" placeholder="Masukkan Password Baru" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Konfirmasi Password Baru :</label>
				<div class="col-md-8">
					<input type="password" name="new_pass2" class="form-control" placeholder="Ketik Ulang Password Baru" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<button class="btn btn-primary" type="submit" name="ok" value="ok">OK <i class="glyphicon glyphicon-ok"></i></button> &nbsp;
					<input type="reset" value="Cancel" class="btn btn-warning">
				</div>
			</div>
		</form>
	</div>
</div>