<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo base_url("admin"); ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>istrator</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <?php
          //mengambil data pd tbl feedback berdasarkan notif = 'Y' & dklompokkan berdasarkan id_produk
          $sql_feedback = $this->model1->selectQuery2("SELECT id_produk FROM feedback WHERE notif = 'Y' GROUP BY id_produk");
          ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-comments-o"></i>
            <span class="label label-warning"><?php echo $sql_feedback->num_rows(); ?></span>
          </a>
          <ul class="dropdown-menu">
            <?php
            if ($sql_feedback->num_rows() == 0) {
              echo "<li class='header'>Tidak ada notifikasi</li>";
            }else{
              echo "<li class='header'>Anda mempunyai ".$sql_feedback->num_rows()." notifikasi</li>";
            }
            ?>
            <li>
              <ul class="menu">
                <?php
                foreach ($sql_feedback->result() as $feedback) {
                  $jml_feedback = $this->model1->selectQuery2("SELECT id_feedback FROM feedback WHERE notif = 'Y' AND id_produk = '$feedback->id_produk'");
                  $sql_nama = $this->model1->selectWhere("produk", array("no_produk" => $feedback->id_produk));
                  $products_name = substr($sql_nama->result()[0]->nama_produk,0,20)."...";
                  if ($_SESSION['level'] == "teknisi") {
                    echo "
                    <li>
                      <a href='".base_url("detail_produk/p/$feedback->id_produk")."' target='_blank'>
                        <i class='fa fa-comments-o text-aqua'></i> ".$jml_feedback->num_rows()." feedback baru pada $products_name
                      </a>
                    </li>
                    ";
                  }else{
                    echo "
                    <li>
                      <a href='".base_url("detail_produk/p/$feedback->id_produk")."' onclick='clearNotif($feedback->id_produk,\"".base_url('admin/ajax')."\")' target='_blank'>
                        <i class='fa fa-comments-o text-aqua'></i> ".$jml_feedback->num_rows()." feedback baru pada $products_name
                      </a>
                    </li>
                    ";
                  }
                }
                $sql_feedback->free_result();
                ?>
              </ul>
            </li>
          </ul>
        </li>
        <li class="dropdown">
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <i class="caret"></i></a>
        	<ul class="dropdown-menu">
        		<li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Homepage</a></li>
            <?php
            if ($_SESSION['level'] == "owner") {
            ?>
        		<li><a href="<?php echo base_url("admin/register"); ?>"><i class="fa fa-registered"></i> Daftar</a></li>
            <?php
            }
            ?>
            <li><a href="<?php echo base_url("admin/ubah_profil"); ?>"><i class="fa fa-user"></i> Ubah Profil</a></li>
            <li><a href="#uploadFotoModal" data-toggle="modal"><i class="fa fa-upload"></i> Upload Foto</a></li>
        		<li class="divider"></li>
        		<li><a href="<?php echo base_url("crud/logout_admin"); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
        	</ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>