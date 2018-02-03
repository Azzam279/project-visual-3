<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>">
	<style>
article, 
aside, 
details, 
figcaption, 
figure, 
footer, 
header, 
hgroup, 
nav, 
section {
    display: block;
}

html {
    font-size: 100%;
    -webkit-text-size-adjust: 100%;
    -ms-text-size-adjust: 100%;
}

input:focus, 
textarea:focus {
    outline: none;
}

label, 
select, 
button, 
input[type="submit"], 
input[type="radio"], 
input[type="checkbox"] 
input[type="button"] {
    cursor: pointer;
}

a, 
a:visited, 
a:active {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

::selection {
    background: #ed327b;
    color: #fff;
}

::-moz-selection {
    background: #ed327b;
    color: #fff;
}

* {
    font-size:100%;
    margin: 0;
    padding: 0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body {
  background:#55AAFF;
}

* {
  font-family:"Helvetica Neue", Helvetica, Arial;
}

h5 {
  text-align:center;
  margin-top:5px;
  color:rgba(0,0,0,.3);
}

h5 > a,a:visited {
  color:#fff;
  text-decoration:underline;
}

h5 > a:hover {
  text-decoration:none;
}

form {
  background:#fff;
  border-radius:6px;
  padding:20px;
  padding-top:30px;
  width:300px;
  margin:100px auto;
  box-shadow:15px 15px 0px rgba(0,0,0,.1);
}

h1 {
  text-align:center;
  font-size:1.4em;
  font-weight:700;
  color:#ccc;
  margin-bottom:24px;
}

span {
  font-weight:200;
}

input {
  width:100%;
  background:#f5f5f5;
  border:0;
  padding:20px;
  border-radius:6px;
  margin-bottom:10px;
  border:1px solid #eee;
}

.btn {
  position:relative;
  width:100%;
  padding:20px;
  border-radius:6px;
  border:0;
  background:#f26964;
  font-size:1.2em;
  color:#fff;
  text-shadow:1px 1px 0px rgba(0,0,0,.1);
  box-shadow:0px 3px 0px #c1524e;
}

.btn:active {
  top:3px;
  box-shadow:none;
}

h6 {
  text-align:center;
  padding:20px;
  padding-top:35px;
  color:#777;
  cursor:pointer;
}

.social {
  display:none;
}

.fb {
  margin-top:15px;
  background:#3b5998;
  box-shadow:0px 3px 0px #2c416e;
}

.tw {
  background:#00acee;
  box-shadow:0px 3px 0px #008dc3;
}

.google {
  background:#db4a39;
  box-shadow:0px 3px 0px #b93f31;
}
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars(base_url("crud/login_admin")); ?>" method="post">
  <h1><i class="fa fa-user"></i> <span>Login</span> Admin</h1>
  <input placeholder="Username" type="text" name="user" required autofocus />
  <input placeholder="Password" type="password" name="pass" required />
  <button type="submit" name="login" value="login" class="btn"><i class="fa fa-sign-in"></i> Log in</button>
  <!--<h6>Oh, social?</h6>
  <div class="social">
  <button class="tw btn">Twitter</button>
  <button class="fb btn">Facebook</button>
  <button class="google fb btn">Google+</button>
  </div>-->
</form>

<!--<footer>
  <h5>Right click and visit: <a target="_blank" href="http://lifes.gd">Life's Good</a></h5>
</footer>-->

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
<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url();?>assets/admin/js/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(e){
   $('h6').on('click',function(){
      $('.social').stop().slideToggle();
   });
})
//close alert dalam 4.5 detik
$('.page-alert').delay(4500).fadeOut();
</script>
</body>
</html>