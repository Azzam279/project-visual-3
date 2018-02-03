<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Toko Komputer</title>
    <?php $this->load->view("source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/owl.carousel.css"); ?>">
    <style>
.product-f-image {
    position: relative;
}
.product-hover {
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    overflow: hidden;
    border: 1px solid #ddd;
}
.product-hover:after {
  background: none repeat scroll 0 0 #000;
  content: "";
  height: 100%;
  left: -100%;
  opacity: 0.6;
  position: absolute;
  top: 0;
  width: 100%;
  transition: .4s;
}
.product-hover a {
    background: none repeat scroll 0 0 #5a88ca;
    border-radius: 5px;
    color: #fff;
    display: block;
    font-size: 16px;
    left: 10%;
    margin: 0;
    padding: 10px;
    position: absolute;
    text-align: center;
    text-transform: uppercase;
    border: 1px solid #5a88ca;
    width: 80%;
    z-index: 99;
    transition: .4s;
}
.product-hover a:hover {
  background: #000;
  text-decoration: none;
  border-color: #444;
}
.product-carousel-price ins {
  color: #5a88ca;
  font-weight: 700;
  margin-right: 5px;
  text-decoration: none;
}
.product-hover a i.fa {
    margin-right: 5px;
}
.product-hover a.add-to-cart-link {top: -25%;}
.product-hover a.view-details-link { bottom: -35%;}
.single-product h2 {
    font-size: 18px;
    line-height: 25px;
    margin-bottom: 10px;
    margin-top: 15px;
}


.single-product h2 a {
    color: #222;
}
.single-product p {
    color: #5a88ca;
    font-weight: 700;
}

.single-product {
  overflow: hidden;
}
.single-product:hover {}
.single-product:hover .product-hover a.add-to-cart-link {top: 32%;}
.single-product:hover .product-hover a.view-details-link {bottom: 32%;}
.single-product:hover .product-hover:after{left: 0}


.product-carousel {
  padding-top: 40px;
}
.latest-product .owl-nav {
  position: absolute;
  right: 0;
  top: 0;
}
.section-title {
  font-family: "Bookman Old Style", serif;
}

.latest-product .owl-nav div, .related-products-wrapper .owl-nav div {
  background:#fa8072;
  color:#FFF;
  display: inline-block;
  margin-left: 15px;
  padding: 1px 10px;
}
.latest-product .owl-nav div:hover, .brand-wrapper .owl-nav div:hover, .related-products-wrapper .owl-nav div:hover {color: #FFF; background:#f95f5f;}
.brand-list {padding-top: 40px;}
.brand-list .owl-nav {
  position: absolute;
  right: 0;
  top: 0;
}
.brand-wrapper .owl-nav div {
  border: 1px solid #fff;
  color: #fff;
  display: inline-block;
  margin-left: 15px;
  padding: 1px 10px;
}

.brand-wrapper .owl-nav div {
  background:#fa8072;
  color:#FFF;
  display: inline-block;
  margin-left: 15px;
  padding: 1px 10px;
}

.maincontent-area {padding-bottom: 50px; padding-top:20px;}

.product-wid-title {
  font-family: raleway;
  font-size: 30px;
  font-weight: 100;
  margin-bottom: 40px;
}


.single-wid-product {
    margin-bottom: 31px;
    overflow: hidden;
}
.product-thumb {
    float: left;
    height: 90px;
    margin-right: 15px;
    width: 100px;
}
.single-wid-product h2 {
    font-size: 14px;
    margin-bottom: 12px;
}
.product-wid-rating {
    color: #ffc808;
    margin-bottom: 10px;
}
.product-wid-price ins {
    color: #5a88ca;
    font-weight: 700;
    margin-right: 10px;
    text-decoration: none;
}
.single-wid-product h2 a {
    color: #222;
}
.single-wid-product h2 a:hover, .single-product h2 a:hover {
    color: #5a88ca;
}
.wid-view-more {
    background: none repeat scroll 0 0 #5a88ca;
    color: #fff;
    padding: 3px 15px;
    position: absolute;
    right: 10px;
    top: 3px;
}
.wid-view-more:hover {color: #fff;background-color: #222;text-decoration: none}
.single-product-widget {
    position: relative;
}
.product-widget-area {
  padding-bottom: 30px;
  padding-top: 30px;
}
.product-widget-area .zigzag-bottom{background: #f4f4f4;}
    </style>
</head>
<body>

<div id="gototop"></div>

	<?php $this->load->view("navbar"); ?>

	<div class="container" style="padding-top: 120px; background:white;">
		<div class="row">
			<?php
				$this->load->view("kategori");
				$this->load->view("promo-homepage");
			?>
        </div>
		    <br><br><hr style="border: solid 1px #ccc;">
	</div>
	
	<?php $this->load->view("produk-homepage"); ?>

	<?php $this->load->view("footer"); ?>

<?php $this->load->view("source-js"); ?>
<script src="<?php echo base_url("assets/js/owl.carousel.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery.sticky.js"); ?>"></script>
<script>
$(document).ready(function() {
	$(".mainmenu-area").sticky({topSpacing:0});
    
    $('.product-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:5,
            }
        }
    });
    
    $('.brand-list').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:4,
            }
        }
    });
});
</script>
</body>
</html>