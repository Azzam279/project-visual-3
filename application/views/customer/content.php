<div class="col-md-9 col-sm-9" style="padding-left:0;padding-right:0;">
	<div id="content-customer-wrapper">
		<?php
		if ($c != "") {
			$this->load->view("customer/$c");
		}else{
			$this->load->view("customer/profile");
		}
		?>
	</div>
</div>