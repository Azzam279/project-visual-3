<?php
$sql_promo = $this->model1->selectWhereSpec("promo", array("id_promo !=" => 99, "no_kategori_promo" => 0));
$promo1 = $sql_promo->result()[0];
$promo3 = $sql_promo->result()[2];
$promo4 = $sql_promo->result()[3];
$promo5 = $sql_promo->result()[4];
$promo6 = $sql_promo->result()[5];
?>
<div class="col-md-9 col-lg-9 hidden-xs hidden-sm" style="padding-left:0px;" id="gambar-promo">
	<div class="col-md-9 col-sm-9" style="padding-right:0px;padding-left:0px;">
		<div style="float:left;width:430px;height:531px;">
        	<div style="background:white;width:100%;height:354px;" class="image-large">
                <?php
                if ($sql_promo->num_rows()[1] == 0) {
                    $promo2 = $sql_promo->result()[1];
                    $title1 = preg_replace("/[^a-zA-Z0-9]/", "-", $promo2->judul_promo);
                ?>
                <a href="<?php echo base_url("promo/p/$promo2->id_promo/$title1"); ?>">
                    <img src="<?php echo base_url("image/promo/portrait/$promo2->gambar_promo_md"); ?>" class="img-responsive" style="width:99%;">
                </a>
                <?php
                }else{
                ?>
        		<a href="#">
        			<img src="<?php echo base_url("image/promo/no-promo.png"); ?>" style="height:96%;" class="img-responsive">
        		</a>
                <?php
                }
                ?>
        	</div>
        	<div>
        		<div style="width:215px;height:177px;background:white;float:left" class="image-small">
        			<?php
                    if ($sql_promo->num_rows()[0] == 0) {
                        $promo1 = $sql_promo->result()[0];
                        $title2 = preg_replace("/[^a-zA-Z0-9]/", "-", $promo1->judul_promo);
                    ?>
                    <a href="<?php echo base_url("promo/p/$promo1->id_promo/$title2"); ?>">
                        <img src="<?php echo base_url("image/promo/portrait/$promo1->gambar_promo_md"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }else{
                    ?>
                    <a href="#">
                        <img src="<?php echo base_url("image/promo/no-promo.png"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }
                    ?>
        		</div>
        		<div style="width:215px;height:177px;background:white;float:left" class="image-small">
        			<?php
                    if ($sql_promo->num_rows()[2] == 0) {
                        $promo3 = $sql_promo->result()[2];
                        $title3 = preg_replace("/[^a-zA-Z0-9]/", "-", $promo3->judul_promo);
                    ?>
                    <a href="<?php echo base_url("promo/p/$promo3->id_promo/$title3"); ?>">
                        <img src="<?php echo base_url("image/promo/portrait/$promo3->gambar_promo_md"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }else{
                    ?>
                    <a href="#">
                        <img src="<?php echo base_url("image/promo/no-promo.png"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }
                    ?>
	        	</div>
        	</div>
    	</div>
    	<div style="float:left;width:215px;height:531px;">
    		<div style="width:100%;height:177px;background:white;" class="image-small">
    			<?php
                    if ($sql_promo->num_rows()[3] == 0) {
                        $promo4 = $sql_promo->result()[3];
                        $title4 = preg_replace("/[^a-zA-Z0-9]/", "-", $promo4->judul_promo);
                    ?>
                    <a href="<?php echo base_url("promo/p/$promo4->id_promo/$title4"); ?>">
                        <img src="<?php echo base_url("image/promo/portrait/$promo4->gambar_promo_md"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }else{
                    ?>
                    <a href="#">
                        <img src="<?php echo base_url("image/promo/no-promo.png"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }
                    ?>
	        </div>
    		<div style="width:100%;height:177px;background:white;" class="image-small">
    			<?php
                    if ($sql_promo->num_rows()[4] == 0) {
                        $promo5 = $sql_promo->result()[4];
                        $title5 = preg_replace("/[^a-zA-Z0-9]/", "-", $promo5->judul_promo);
                    ?>
                    <a href="<?php echo base_url("promo/p/$promo5->id_promo/$title5"); ?>">
                        <img src="<?php echo base_url("image/promo/portrait/$promo5->gambar_promo_md"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }else{
                    ?>
                    <a href="#">
                        <img src="<?php echo base_url("image/promo/no-promo.png"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }
                    ?>
        	</div>
    		<div style="width:100%;height:177px;background:white;" class="image-small">
    			<?php
                    if ($sql_promo->num_rows()[5] == 0) {
                        $promo6 = $sql_promo->result()[5];
                        $title6 = preg_replace("/[^a-zA-Z0-9]/", "-", $promo6->judul_promo);
                    ?>
                    <a href="<?php echo base_url("promo/p/$promo6->id_promo/$title6"); ?>">
                        <img src="<?php echo base_url("image/promo/portrait/$promo6->gambar_promo_md"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }else{
                    ?>
                    <a href="#">
                        <img src="<?php echo base_url("image/promo/no-promo.png"); ?>" class="img-responsive">
                    </a>
                    <?php
                    }
                    ?>
        	</div>
    	</div>
	</div>
	<div class="col-md-3 col-sm-3" style="padding-left:0px;padding-right:0px;">
        <a href="<?php echo base_url("jasa_servis"); ?>">
            <img src="<?php echo base_url("image/poster2.jpg"); ?>" alt="poster" class="img-responsive">
        </a>
	</div>
</div>