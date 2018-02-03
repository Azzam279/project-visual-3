<div class="col-md-3 col-lg-3" id="menu-kategori">
	<nav class="navbar navbar-default navbar-fixed-top" id="sidebar-wrapper" role="navigation" style="margin-right:0px;">
        <ul class="nav sidebar-nav nav-kategori">
            <li class="sidebar-brand">
                <a href="#">
                	&nbsp;&nbsp;&nbsp; KATEGORI BELANJA
                </a>
            </li>
            <?php
            foreach ($kategori->result() as $val_kat) {
                $nama_kat = ucwords(str_replace("_"," ",$val_kat->nama_kategori));
                $link_kat = $val_kat->nama_kategori;
            ?>
            <li>
            	<div>
                    <?php
                    if ($val_kat->tipe == "single") {
                    ?>
                    <span>
                        <a href="<?php echo base_url("$link_kat"); ?>"><?php echo $nama_kat; ?></a>
                    </span>
                    <?php    
                    }else{
                    ?>
            		<span>
                    	<a href="<?php echo base_url("$link_kat"); ?>"><?php echo $nama_kat; ?></a>
                    </span>
                    <div class="horz-menu">
                		<p><?php echo "Promo & Koleksi $nama_kat"; ?></p>
                		<hr style="margin:0px auto;">
                        <?php
                        $data = array("no_kategori" => $val_kat->no_kategori);
                        $subkat = $this->model1->selectWhere("subkategori", $data);
                        ?>
                    	<div class="sub-kat">
							<?php
                            foreach ($subkat->result() as $val_subkat) {
                                $nama_sub = ucwords(str_replace("_"," ",$val_subkat->nama_subkategori));
                                $link_sub = $val_subkat->nama_subkategori;
                                echo "<a href='".base_url($link_kat."/".$link_sub)."'>$nama_sub</a>";
                            }
                            $subkat->free_result();
                            ?>
                    	</div>
                    	<div class="subkat-image">
                    		<?php
                            $where = array("no_kategori_promo" => $val_kat->no_kategori);
                            $promo = $this->db->get_where("promo", $where);
                            foreach ($promo->result() as $val_promo) {
                                if ($val_promo->judul_promo == "" && $val_promo->lama_promo == 0 && $val_promo->gambar_promo_lg == "") {
                                    echo "<a href='javascript:void(0)'><img src='".base_url("image/promo/portrait/$val_promo->gambar_promo_md")."' class='img-responsive'></a>";
                                }else{
                                   $judul = preg_replace("/[^a-zA-Z0-9]/", "-", $val_promo->judul_promo);
                                    echo "<a href='".base_url("promo/p/$val_promo->id_promo/$judul/")."'><img src='".base_url("image/promo/portrait/$val_promo->gambar_promo_md")."' class='img-responsive'></a>"; 
                                }
                            }
                            $promo->free_result();
                            ?>
                    	</div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </li>
            <?php
            }
            $kategori->free_result();
            ?>
        </ul>
    </nav>
</div>