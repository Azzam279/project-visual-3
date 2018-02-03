<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Produk Terbaru</h2>
                    <div class="product-carousel">
                    	<?php
                    	foreach ($produk->result() as $p) {
                    		$img = explode(",", $p->gambar_produk);
                    		if ($p->diskon_produk != 0) {
                    			$diskon = $p->harga_produk * ($p->diskon_produk/100);
                    			$harga_lama = "Rp ".number_format($p->harga_produk,0,",",".");
                    			$harga = "Rp ".number_format($p->harga_produk - $diskon,0,",",".");
                    		}else{
                    			$harga_lama = "";
                    			$harga = "Rp ".number_format($p->harga_produk,0,",",".");
                    		}

                    		$nama = (strlen($p->nama_produk) > 40) ? substr($p->nama_produk, 0,40)."..." : $p->nama_produk;
                    	?>
                        <div class="single-product">
                            <div class="product-f-image">
                                <img src="<?php echo base_url("image/produk-sm/$img[0]"); ?>" alt="">
                                <div class="product-hover">
                                    <a href="<?php echo base_url("detail_produk/p/$p->no_produk"); ?>" class="view-details-link"><i class="fa fa-eye"></i> Lihat detail</a>
                                </div>
                            </div>
                            
                            <h2><a href="<?php echo base_url("detail_produk/p/$p->no_produk"); ?>" title="<?php echo $p->nama_produk; ?>"><?php echo $nama; ?></a></h2>
                            
                            <div class="product-carousel-price">
                                <ins><?php echo $harga; ?></ins> <del><?php echo $harga_lama; ?></del>
                            </div> 
                        </div>
                        <?php
                    	}
                        $produk->free_result();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End main content area -->

<div class="brands-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="brand-wrapper">
                    <div class="brand-list" style="vertical-align:middle;">
                        <?php
                        $sql_brand = $this->model1->selectData("brand");
                        foreach ($sql_brand->result() as $brands) {
                            echo "<img src='".base_url("image/brand/$brands->img_brand")."' alt='brands' class='img-responsive'>";
                        }
                        $sql_brand->free_result();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End brands area -->
<br><br>
