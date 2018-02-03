<!-- Chatting Form -->
<?php $this->load->view("chatting"); ?>

<!-- go to top -->
<a href="#" class="gotop"><i class="fa fa-angle-up"></i></a>

<!-- Footer -->
<footer>
	<div class="well well-sm bg-footer1" style="margin-bottom:0px;">
		<center>
			<div class="container">
			<div class="row menu-footer">
				<div class="col-md-4 col-sm-4">
					<h4><b>LAYANAN</b></h4><hr />
					<ul style="list-style:none;padding-left:5px;font-size:16px;">
						<li><a href="#">Cara Belanja</a></li>
						<li><a href="#">Cek Status Order</a></li>
						<li><a href="#">Konfirmasi Pembayaran</a></li>
						<li><a href="#">Testimoni</a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal-contact">Hubungi Kami</a></li>
					</ul>
				</div>
				<div class="col-md-4 col-sm-4">
					<h4><b>HUBUNGI KAMI</b></h4><hr />
					Jam Operasional Customer Support:<br>
					Senin-Sabtu: 08.30-17.30 WIB
					<ul style="list-style:none;padding-left:5px;">
						<li style="margin:15px 4px;">
							<table class="table">
							<tr>
								<td width="20%"><h3 style="margin-top:0px;"><span class="label label-info"><span class="glyphicon glyphicon-phone"></span></span></h3></td>
								<td>SMS Only :<br> (0896) 98584961</td>
							</tr>
							<tr>
								<td width="20%"><h3 style="margin-top:0px;"><span class="label label-info"><span class="glyphicon glyphicon-earphone"></span></span></h3></td>
								<td>Telepon :<br> (0511) 734 9852</td>
							</tr>
							<tr>
								<td width="20%"><h3 style="margin-top:0px;"><span class="label label-info"><span class="glyphicon glyphicon-envelope"></span></span></h3></td>
								<td>Email :<br> admin@tokokomputer.com</td>
							</tr>
							</table>
						</li>
						<li style="margin:15px 4px;"></li>
					</ul>
				</div>
				<div class="col-md-4 col-sm-4">
					<h4><b>SOCIAL MEDIA</b></h4><hr/>
					<ul class="social-network social-circle">
	                    <li><a href="http://facebook.com" class="icoFacebook" title="Facebook" data-toggle="tooltip" data-placement="top"><i class="fa fa-facebook"></i></a></li>
	                    <li><a href="http://twitter.com" class="icoTwitter" title="Twitter" data-toggle="tooltip" data-placement="top"><i class="fa fa-twitter"></i></a></li>
	                    <li><a href="http://google.com" class="icoGoogle" title="Google+" data-toggle="tooltip" data-placement="top"><i class="fa fa-google-plus"></i></a></li>
	                    <div class="clearfix"></div>
	                </ul>
				</div>
			</div>
			</div>

			<div class="container" style="border-top:solid 1px #C3C3C3;margin-top:15px;"><br>
				<div style="font-size:10px;">
					<span style="display:inline-block;margin-top:5px">TRANSFER: </span> 
					<ul id="metode-byr">
						<li><img src="<?php echo base_url("image/bank/BCA-small.png"); ?>"></li>
						<li><img src="<?php echo base_url("image/bank/BRI-small.png"); ?>"></li>
						<li><img src="<?php echo base_url("image/bank/BNI-small.png"); ?>"></li>
						<li><img src="<?php echo base_url("image/bank/Mandiri-small.png"); ?>"></li>
					<div class="clearfix"></div>
					</ul>
				</div>
				<div style="font-size:10px;">
					<span style="display:inline-block;margin-top:5px">JASA PENGIRIMAN: </span>
					<ul id="metode-byr">
						<li><img src="<?php echo base_url("image/kurir/JNE2.png"); ?>"></li>
						<li><img src="<?php echo base_url("image/kurir/TIKI2.png"); ?>"></li>
					<div class="clearfix"></div>
					</ul>
				</div>
			</div>
		</center>
		<div class="clearfix"></div>
	</div>

	<div class="well well-sm copyright">
		<center>
			<div id="copyright">
				Hak Cipta @ 2015 Toko Komputer
			</div>
			<div id="creator" class="hidden-xs">
				<small>Created by Azzam</small>
			</div>
		</center>
	</div>
</footer>

<!-- Troli Modal -->
<div class="modal fade" id="modal-cart" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top:105px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Keranjang Belanja <i class="glyphicon glyphicon-shopping-cart glyphicon-large"></i></h4>
      </div>
      <div class="modal-body">
		<div id="isi-troli">
			<center><div class="preloader5" style="margin:10px auto;"></div></center>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Lanjut Belanja</button>
        <a href="<?php echo base_url("order"); ?>" class="btn btn-primary">Lanjut ke pembayaran <i class="fa fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="modal-contact" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="margin-top:105px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><center><i class="glyphicon glyphicon-earphone glyphicon-large"></i> Hubungi Kami</center></h4>
      </div>
	  <form action="<?php echo htmlspecialchars(base_url("contact")); ?>" method="post" id="contactForm">
      <div class="modal-body">
		<div class="row">
	        <div class="col-md-8">
	            <div class="well well-sm">
	            	<div id="pesan-validasi"></div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <label for="name">
	                                Name</label>
	                            <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama" required="required" maxlength="100" />
	                        </div>
	                        <div class="form-group">
	                            <label for="email">
	                                Email Address</label>
	                            <div class="input-group">
	                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
	                                <input name="email" type="email" class="form-control" id="email" placeholder="Masukkan email" required="required" maxlength="130" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label for="subject">
	                                Subject</label>
	                            <input id="subject" name="subject" class="form-control" maxlength="50" required="required" placeholder="Subjek">
	                        </div>
	                    </div>
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <label for="name">
	                                Message</label>
	                            <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
	                                placeholder="Pesan" maxlength="400"></textarea>
	                            <div id="characterLeft"></div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-4">
	            <legend><span class="glyphicon glyphicon-globe"></span> Our office</legend>
	            <address>
	                <strong>Telepon :</strong><br>
	                <i class="glyphicon glyphicon-earphone"></i> (123) 456-7890<br>
	            </address>
	            <address>
	                <strong>SMS :</strong><br>
	                <i class="glyphicon glyphicon-phone"></i> (0812) 345678901<br>
	            </address>
	            <address>
	                <strong>Email :</strong><br>
	                <i class="glyphicon glyphicon-envelope"></i> admin@tokokomputer.com
	            </address>
	        </div>
	    </div>
      </div>
      <div class="modal-footer">
      	<button class="btn btn-primary" type="submit" id="btn-contact"><i class="glyphicon glyphicon-send"></i> Kirim</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Batal</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!-- Modal Upload Foto -->
<div class="modal fade" id="uploadFotoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top:110px;">
      <form action="<?php echo htmlspecialchars(base_url("customer/upload_foto")); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-picture-o"></i> Upload Foto</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label class="col-md-offset-1 col-md-2">Upload : </label>
        	<div class="col-md-7">
        		<input type="file" name="upload_foto" class="form-control" accept="image/jpg,image/jpeg,image/png" required>
        	</div>
        	<div class="clearfix"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" name="btn_upload_foto" value="btn_upload_foto" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>

<input type="hidden" id="host" value="<?php echo base_url(); ?>">

<?php
//validasi
if ($this->session->flashdata('sukses')) {
    echo "<div id='info' class='alert alert-success page-alert'>
    <i class='glyphicon glyphicon-ok'></i> <b>".$this->session->flashdata('sukses')."</b></div>";
}
if ($this->session->flashdata('gagal')) {
    echo "<div id='info' class='alert alert-danger page-alert'>
    <i class='glyphicon glyphicon-remove'></i> <b>".$this->session->flashdata('gagal')."</b></div>";
}
if ($this->session->flashdata('peringatan')) {
    echo "<div id='info' class='alert alert-warning page-alert'>
    <i class='glyphicon glyphicon-warning-sign'></i> <b>".$this->session->flashdata('peringatan')."</b></div>";
}
?>