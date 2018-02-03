<div class="col-md-3 col-sm-3" style="padding-right:0;padding-left:0;">
	<div id="sidebar-customer-wrapper">
		<ul class="nav nav-pills nav-stacked">
			<li role="presentation" class="<?php if($c=="profile"){echo "active";}else{echo "";} ?>">
				<a href="<?php echo base_url("customer/profile"); ?>">Profile</a>
			</li>
			<li role="presentation" class="<?php if($c=="alamat"){echo "active";}else{echo "";} ?>">
				<a href="<?php echo base_url("customer/alamat"); ?>">Alamat</a>
			</li>
			<li role="presentation" class="<?php if($c=="pesanan-saya"){echo "active";}else{echo "";} ?>">
				<a href="<?php echo base_url("customer/pesanan_saya"); ?>">Pesanan Saya</a>
			</li>
			<li role="presentation" class="<?php if($c=="wishlist"){echo "active";}else{echo "";} ?>">
				<a href="<?php echo base_url("customer/wishlist"); ?>">Wishlist</a>
			</li>
			<li role="presentation" class="<?php if($c=="ubah-password"){echo "active";}else{echo "";} ?>">
				<a href="<?php echo base_url("customer/ubah_password"); ?>">Ubah Password</a>
			</li>
			<li role="presentation">
				<a href="<?php echo base_url("logout"); ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
			</li>
		</ul>
	</div>
</div>