<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
	<div class="wrapper">

    <?php
    $this->load->view("admin-room/header");
    $this->load->view("admin-room/sidebar");
    ?>
<section class="content-wrapper">
    <section class="content-header">
        <h1>Ubah Profil
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-offset-2 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Profil</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php
                    //validasi
                    if ($this->session->flashdata('sukses')) {
                        echo "<div class='alert-sukses page-alert'>
                        <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                        <b>".$this->session->flashdata('sukses')."</b></div>";
                    }
                    if ($this->session->flashdata('gagal')) {
                        echo "<div class='alert-gagal page-alert'>
                        <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                        <b>".$this->session->flashdata('gagal')."</b></div>";
                    }
                    if ($this->session->flashdata('peringatan')) {
                        echo "<div class='alert-peringatan page-alert'>
                        <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                        <b>".$this->session->flashdata('peringatan')."</b></div>";
                    }

                    $data = $profil->result()[0];
                    ?>
                    <form action="<?php echo htmlspecialchars(base_url("crud/ubah_profil")) ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3">Nama :</label>
                            <div class="col-md-6">
                                <input type="text" name="nama" maxlength="100" class="form-control" value="<?php echo $data->nama; ?>" required>
                                <input type="hidden" name="id_admin" value="<?php echo $data->id_admin; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Username :</label>
                            <div class="col-md-6">
                                <input type="text" name="user" maxlength="40" value="<?php echo $data->username; ?>" class="form-control" required>
                                <input type="hidden" name="old_user" value="<?php echo $data->username; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Password :</label>
                            <div class="col-md-6">
                                <input type="password" name="pass" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Konfirmasi Password :</label>
                            <div class="col-md-6">
                                <input type="password" name="pass2" class="form-control" placeholder="Konfirmasi Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Hint :</label>
                            <div class="col-md-6">
                                <select name="hint" class="form-control" required>
                                    <option value="Siapa nama Ibu anda?">Siapa nama Ibu anda?</option>
                                    <option value="Siapa nama Ayah anda?">Siapa nama Ayah anda?</option>
                                    <option value="Dimana kota lahir anda?">Dimana kota lahir anda?</option>
                                    <option value="Apa makanan favorit anda?">Apa makanan favorit anda?</option>
                                    <option value="Apa binatang peliharaan anda?">Apa binatang peliharaan anda?</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Jawaban :</label>
                            <div class="col-md-5">
                                <input type="text" name="jawaban" class="form-control" maxlength="150" placeholder="Jawaban" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <button class="btn btn-primary" type="submit" name="update" value="update"><i class="fa fa-check"></i> Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>    
    <?php
    $this->load->view("admin-room/footer");
    $this->load->view("admin-room/control-sidebar");
    ?>

  </div><!-- ./wrapper -->

<?php $this->load->view("admin-room/source-js"); ?>
</body>
</html>