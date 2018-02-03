<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test</title><meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css"); ?>">
    <style>
		.star-rating {
			position: relative;
			z-index: 1;
			list-style: none;
			width: 125px;
			height: 25px;
		}
		.star-rating a,
		.star-rating .current-rating {
			float: left;
			display: inline-block;
			position: absolute;
			left: 0;
			top: 0;
			height: 25px;
			line-height: 25px;
		}

		.star-rating a.one-star {
			z-index: 6;
		}
		.star-rating a.two-star {
			z-index: 5;
		}
		.star-rating a.three-star {
			z-index: 4;
		}
		.star-rating a.four-star {
			z-index: 3;
		}
		.star-rating a.five-star {
			z-index: 2;
		}
		.star-rating .current-rating {z-index: 1;}
    </style>
</head>
<body>
	<div class="container">

	<ul class='star-rating'>
	  <li class="current-rating" id="current-rating">
	  	<i class="fa fa-star-o"></i>
	  	<i class="fa fa-star-o"></i>
	  	<i class="fa fa-star-o"></i>
	  	<i class="fa fa-star-o"></i>
	  	<i class="fa fa-star-o"></i>
	  </li>
	  <span id="ratelinks">
	  <li><a href="javascript:void(0)" title="1 star out of 5" class="one-star">
	  	<i class="fa fa-star gold"></i>
	  </a></li>
	  <li><a href="javascript:void(0)" title="2 stars out of 5" class="two-stars">
	  	<i class="fa fa-star gold"></i><i class="fa fa-star gold"></i>
	  </a></li>
	  <li><a href="javascript:void(0)" title="3 stars out of 5" class="three-stars">
	  	<i class="fa fa-star gold"></i><i class="fa fa-star gold"></i><i class="fa fa-star gold"></i>
	  </a></li>
	  <li><a href="javascript:void(0)" title="4 stars out of 5" class="four-stars">
	  	<i class="fa fa-star gold"></i><i class="fa fa star gold"></i><i class="fa fa-star gold"></i><i class="fa fa-star gold"></i>
	  </a></li>
	  <li><a href="javascript:void(0)" title="5 stars out of 5" class="five-stars">
	  	<i class="fa fa-star gold"></i><i class="fa fa-star gold"></i><i class="fa fa-star gold"></i><i class="fa fa-star gold"></i><i class="fa fa-star gold"></i>
	  </a></li>
	  </span>
	</ul>

	</div>
<?php $this->load->view("source-js"); ?>
</body>
</html>