<div class="box-body">
	<div class="panel-group" id="accordion" ng-app="set_template" ng-controller="TempCtrl">
    	<?php $this->load->view("library/input-function"); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a href="#jud1" data-toggle="collapse" data-parent="#accordion">Menu 1</a>
				</h4>
			</div>
			<div class="body-collapse collapse" id="jud1">
				<div class="panel-body">
					<fieldset>
	            	<form action="" method="post" class="form-horizontal">
	            		<div class="form-group">
	            			<label class="col-md-3">Warna Background :</label>
	            			<div class="col-md-5">
	            				<input type="radio" name="warna_menu1" checked="checked" ng-click="klik_menu1('normal')" id="menu1_biasa" value="biasa"> <label for="menu1_biasa">Warna Biasa</label> <span>&nbsp;</span>
	            				<input type="radio" name="warna_menu1" ng-click="klik_menu1('gradien')" id="menu1_gradien" value="gradien"> <label for="menu1_gradien">Warna Gradient</label>
	            				<hr>
	            				<input type="color" name="biasa_bg_menu1" value="#D4FFFF" ng-disabled="!wm1_1" class="form-control"><br>
	            				<input type="text" name="gradien_bg_menu1" placeholder="Warna Background" ng-disabled="!wm1_2" class="form-control">
		            		</div>
	            		</div>
	            		<br>
	            		<legend><h4><b>Slogan</b></h4></legend>
	            		<div class="form-group">
	            			<label class="col-md-3">Warna Slogan :</label>
	            			<div class="col-md-5">
	            				<input type="color" name="warna_slogan" class="form-control">
	            			</div>
	            		</div>
	            		<div class="form-group">
	            			<label class="col-md-3">Ukuran Font Slogan :</label>
	            			<div class="input-group col-md-5">
	            				<input type="number" name="font_slogan" placeholder="Masukkan Font Size disini..." min="1" max="50" class="form-control"><span class="input-group-addon">px</span>
	            			</div>
	            		</div>
	            		<br>
	            		<legend><h4><b>Link Menu</b></h4></legend>
	            		<div class="form-group">
	            			<label class="col-md-3">Warna Link :</label>
	            			<div class="col-md-5">
	            				<input type="color" name="warna_link" class="form-control">
	            			</div>
	            		</div>
	            		<div class="form-group">
	            			<label class="col-md-3">Ukuran Font Link :</label>
	            			<div class="input-group col-md-5">
	            				<input type="number" name="font_link" placeholder="Masukkan Font Size disini..." min="1" max="50" class="form-control"><span class="input-group-addon">px</span>
	            			</div>
	            		</div>
	            		<div class="form-group">
	            			<div class="col-md-offset-3 col-md-3">
	            				<button type="submit" name="simpan_menu1" value="simpan_menu1" class="btn btn-lg btn-success">Simpan</button>
	            			</div>
	            		</div>
	            	</form>
	            	</fieldset>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a href="#jud2" data-toggle="collapse" data-parent="#accordion">Menu 2</a>
				</h4>
			</div>
			<div class="body-collapse collapse" id="jud2">
				<div class="panel-body">
					<form action="" method="post" class="form-horizontal">
		        		<div class="form-group">
		        			<label class="col-md-3">Warna Background :</label>
		        			<div class="col-md-5">
	            				<input type="radio" name="warna_menu2" checked="checked" ng-click="klik_menu2('normal')" id="menu2_biasa" value="biasa"> <label for="menu2_biasa">Warna Biasa</label> <span>&nbsp;</span>
	            				<input type="radio" name="warna_menu2" ng-click="klik_menu2('gradien')" id="menu2_gradien" value="gradien"> <label for="menu2_gradien">Warna Gradient</label> <hr>
	            				<input type="color" name="warna_bg_menu2" value="#FFFF7F" ng-disabled="!wm2_1" class="form-control"><br>
	            				<input type="text" name="gradien_bg_menu2" ng-disabled="!wm2_2" class="form-control" placeholder="Warna Background">
		        			</div>
		        		</div>
		        		<div class="form-group">
		        			<label class="col-md-3">Logo :</label>
		        			<div class="col-md-6">
		        				<input type="file" name="logo" class="form-control">
		        			</div>
		        		</div>
		        		<div class="form-group">
		        			<label class="col-md-3">Warna Tombol Cari :</label>
		        			<div class="col-md-5">
		        				<input type="color" name="warna_tombol" class="form-control">
		        			</div>
		        		</div>
		        		<div class="form-group">
		        			<div class="col-md-offset-3 col-md-3">
		        				<button class="btn btn-lg btn-success" name="simpan_menu2" value="simpan_menu2">Simpan</button>
		        			</div>
		        		</div>
		        	</form>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a href="#jud3" data-toggle="collapse" data-parent="#accordion">Konten</a>
				</h4>
			</div>
			<div class="body-collapse collapse" id="jud3">
				<div class="panel-body">
					<form action="" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="col-md-3">Warna Background :</label>
							<div class="col-md-5">
	            				<input type="radio" name="warna_konten2" checked="checked" ng-click="klik_menu3('normal')" value="biasa" id="konten_biasa"> <label for="konten_biasa">Warna Biasa</label> <span>&nbsp;</span>
	            				<input type="radio" name="warna_konten2" ng-click="klik_menu3('gradien')" value="gradien" id="konten_gradien"> <label for="konten_gradien">Warna Gradient</label> <hr>
	            				<input type="color" name="konten_bg_biasa" value="#D4FFFF" ng-disabled="!wk1" class="form-control"><br>
	            				<input type="text" name="konten_bg_gradien" ng-disabled="!wk2" class="form-control" placeholder="Warna Background">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Gambar Background :</label>
							<div class="col-md-6">
								<input type="file" name="gambar_konten" class="form-control">
							</div>
						</div>
						<br>
						<legend><h4><b>Produk Box</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Style Font :</label>
							<div class="col-md-5">
								<input type="text" name="font_family" placeholder="Masukkan Font Family disini..." class="form-control">
							</div>
						</div>
						<br>
						<legend><h4><b>Produk Box Judul</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Ukuran Font :</label>
							<div class="input-group col-md-5">
								<input type="number" name="font_size_title" placeholder="Masukkan Font Size disini..." class="form-control"><span class="input-group-addon">px</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Font :</label>
							<div class="col-md-5">
								<input type="color" name="font_color_title" class="form-control">
							</div>
						</div>
						<br>
						<legend><h4><b>Produk Box Harga</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Ukuran Font :</label>
							<div class="input-group col-md-5">
								<input type="number" name="font_size_harga" placeholder="Masukkan Font Size disini..." class="form-control"><span class="input-group-addon">px</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Font :</label>
							<div class="col-md-5">
								<input type="color" name="font_family_harga" class="form-control">
							</div>
						</div>
						<br>
						<legend><h4><b>Produk Box Diskon</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Warna Background :</label>
							<div class="col-md-5">
								<input type="color" name="bg_diskon" class="form-control">
							</div>
						</div>
						<br>
						<legend><h4><b>Menu Kategori Halaman Utama</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Background Kategori Belanja :</label>
							<div class="col-md-5">
								<input type="color" name="bg_kat_belanja" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Background Menu Kategori :</label>
							<div class="col-md-5">
								<input type="color" name="bg_kat_menu" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Style Font Kategori :</label>
							<div class="col-md-5">
								<input type="text" name="font_family_kat" class="form-control" placeholder="Masukkan Font Family disini...">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Teks Kategori :</label>
							<div class="col-md-5">
								<input type="color" name="teks_kat_menu" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Teks Kategori (Hover) :</label>
							<div class="col-md-5">
								<input type="color" name="teks_kat_menu_hover" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-3 col-md-3">
								<button type="submit" name="simpan_koten" value="simpan_koten" class="btn btn-success btn-lg">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a href="#jud4" data-toggle="collapse" data-parent="#accordion">Footer</a>
				</h4>
			</div>
			<div class="body-collapse collapse" id="jud4">
				<div class="panel-body">
					<form action="" method="post" class="form-horizontal">
						<legend><h4><b>Footer Utama</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Background Footer Utama :</label>
							<div class="col-md-5">
	            				<input type="radio" name="warna_footer1" checked="checked" ng-click="klik_menu4('normal')" value="biasa" id="footer_biasa"> <label for="footer_biasa">Warna Biasa</label> <span>&nbsp;</span>
	            				<input type="radio" name="warna_footer1" ng-click="klik_menu4('gradien')" value="gradien" id="footer_gradien"> <label for="footer_gradien">Warna Gradient</label> <hr>
	            				<input type="color" name="footer_bg_biasa" value="#D4FFFF" ng-disabled="!wf1" class="form-control"><br>
	            				<input type="text" name="footer_bg_gradien" ng-disabled="!wf2" class="form-control" placeholder="Warna Background">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Gambar Background Footer :</label>
							<div class="col-md-5">
								<input type="file" name="img_footer1" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Style Font :</label>
							<div class="col-md-5">
								<input type="text" name="font_family_footer1" placeholder="Masukkan Font Family disini" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Font Judul :</label>
							<div class="col-md-5">
								<input type="color" name="font_color_title_footer1" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Font Isi :</label>
							<div class="col-md-5">
								<input type="color" name="warna_font_isi_footer1" class="form-control">
							</div>
						</div>
						<br>
						<legend><h4><b>Footer Kedua</b></h4></legend>
						<div class="form-group">
							<label class="col-md-3">Background Footer Kedua :</label>
							<div class="col-md-5">
								<input type="color" name="warna_footer2" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Style Font :</label>
							<div class="col-md-5">
								<input type="text" name="font_family_footer2" class="form-control" placeholder="Masukkan Font Family disini...">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Ukuran Font :</label>
							<div class="input-group col-md-5">
								<input type="number" name="font_size_footer_kedua" class="form-control" placeholder="Masukkan Font Size disini..."><span class="input-group-addon">px</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Warna Font :</label>
							<div class="col-md-5">
								<input type="color" name="warna_font_footer_kedua" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-3 col-md-3">
								<button class="btn btn-lg btn-success" name="simpan_konten_homepage" value="simpan_konten_homepage">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>