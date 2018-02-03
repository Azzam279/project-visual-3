<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <?php $foto_admin = ($_SESSION['foto_admin'] != "") ? $_SESSION['foto_admin'] : "avatar_2x.png"; ?>
        <img src="<?php echo base_url("image/foto/admin/$foto_admin"); ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['nama']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <?php
    if ($_SESSION['level'] == "teknisi") {
    ?>
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="<?php if (empty($judul)) {echo "active";} ?>">
        <a href="<?php echo base_url("admin"); ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
    </ul>
    <?php
    }else if ($_SESSION['level'] == "kasir") {
    ?>
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="<?php if (empty($judul)) {echo "active";} ?>">
        <a href="<?php echo base_url("admin"); ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="<?php if ($judul == "order") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/order"); ?>">
          <i class="fa fa-cubes"></i> <span>Order</span>
        </a>
      </li>
      <li class="<?php if ($judul == "produk") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/produk"); ?>">
          <i class="fa fa-product-hunt"></i> <span>Produk</span>
        </a>
      </li>
      <li class="<?php if ($judul == "brand") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/brand"); ?>">
          <i class="fa fa-plus"></i> <span>Brand</span>
        </a>
      </li>
      <li class="<?php if ($judul == "servis") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/servis"); ?>">
          <i class="fa fa-wrench"></i> <span>Servis</span>
        </a>
      </li>
      <li class="<?php if ($judul == "promo") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/promo"); ?>">
          <i class="fa fa-plus"></i> <span>Promo</span>
        </a>
      </li>
      <li class="<?php if ($judul == "pesan") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/pesan"); ?>">
          <i class="fa fa-envelope-o"></i> <span>Pesan</span>
        </a>
      </li>
    </ul>
    <?php
    }else if ($_SESSION['level'] == "owner") {
    ?>
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="<?php if (empty($judul)) {echo "active";} ?>">
        <a href="<?php echo base_url("admin"); ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="<?php if ($judul == "order") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/order"); ?>">
          <i class="fa fa-cubes"></i> <span>Order</span>
        </a>
      </li>
      <li class="<?php if ($judul == "produk") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/produk"); ?>">
          <i class="fa fa-product-hunt"></i> <span>Produk</span>
        </a>
      </li>
      <li class="<?php if ($judul == "servis") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/servis"); ?>">
          <i class="fa fa-wrench"></i> <span>Servis</span>
        </a>
      </li>
      <li class="<?php if ($judul == "template") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/template"); ?>">
          <i class="fa fa-files-o"></i>
          <span>Template</span>
        </a>
      </li>
      <li class="<?php if ($judul == "brand") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/brand"); ?>">
          <i class="fa fa-plus"></i> <span>Brand</span>
        </a>
      </li>
      <li class="treeview <?php if ($judul=="kategori" || $judul=="subkategori") {echo "active";} ?>">
        <a href="#">
          <i class="fa fa-th-list"></i>
          <span>kategori</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url("admin/kategori"); ?>"><i class="glyphicon glyphicon-plus"></i> Kategori</a></li>
          <li><a href="<?php echo base_url("admin/subkategori"); ?>"><i class="glyphicon glyphicon-plus"></i> Sub-Kategori</a></li>
        </ul>
      </li>
      <li class="<?php if ($judul == "promo") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/promo"); ?>">
          <i class="fa fa-plus"></i> <span>Promo</span>
        </a>
      </li>
      <li class="<?php if ($judul == "pesan") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/pesan"); ?>">
          <i class="fa fa-envelope-o"></i> <span>Pesan</span>
        </a>
      </li>
      <li class="<?php if ($judul == "laporan") {echo "active";} ?>">
        <a href="<?php echo base_url("admin/laporan"); ?>">
          <i class="fa fa-book"></i> <span>Laporan</span>
        </a>
      </li>
    </ul>
    <?php
    }
    ?>
  </section>
  <!-- /.sidebar -->
</aside>