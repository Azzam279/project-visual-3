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
        <h1>Daftar
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-offset-2 col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Admin Baru</h3>
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
                    ?>
                    <form action="<?php echo htmlspecialchars(base_url("crud/daftar")) ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3">Nama :</label>
                            <div class="col-md-6">
                                <input type="text" name="nama" maxlength="100" placeholder="Nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Username :</label>
                            <div class="col-md-6">
                                <input type="text" name="user" maxlength="40" placeholder="Username" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Password :</label>
                            <div class="col-md-6">
                                <input type="password" name="pass" placeholder="Password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Konfirmasi Password :</label>
                            <div class="col-md-6">
                                <input type="password" name="pass2" placeholder="Konfirmasi Password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Level :</label>
                            <div class="col-md-6">
                                <select name="level" class="form-control" required>
                                    <option value="kasir">Kasir</option>
                                    <option value="teknisi">Teknisi</option>
                                    <option value="owner">Owner</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <button class="btn btn-primary" type="submit" name="daftar" value="daftar"><i class="fa fa-registered"></i> Daftar</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="clearfix"></div>
                    <div id="pesan-validasi"></div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($daftar->result() as $data) {
                                    echo "
                                    <tr>
                                        <td>$data->nama</td>
                                        <td>$data->username</td>
                                        <td>
                                            <select class='form-control' onchange=\"status($data->id_admin,this.value,'".$data->nama."')\">";
                                            if ($data->aktif == "Y") {
                                                echo "<option value='Y' selected>Aktif</option>";
                                                echo "<option value='N'>Tidak Aktif</option>";
                                            }else{
                                                echo "<option value='Y'>Aktif</option>";
                                                echo "<option value='N' selected>Tidak Aktif</option>";
                                            }
                                    echo "
                                            </select>        
                                        </td>
                                        <td>
                                            <button class='btn btn-danger btn-sm' onclick=\"hapus(".$data->id_admin.",'".$data->nama."')\" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-remove'></i></button>
                                        </td>
                                    </tr>
                                    ";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
<script>
    function status(id,val,nama) {
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'id_adm='+id+'&status='+val,
            success: function(hasil) {
                if (hasil == "Sukses") {
                    $("#pesan-validasi").html("<div class='alert-sukses page-alert'><button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><b>Status "+nama+" berhasil diperbaharui!</b></div>");
                }else{
                    $("#pesan-validasi").html("<div class='alert-gagal page-alert'><button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><b>Status "+nama+" gagal diperbaharui!</b></div>");
                }
                //Close alert
                $('.page-alert .close').click(function(e) {
                    e.preventDefault();
                    $(this).closest('.page-alert').slideUp();
                });
            },
            error: function() {
                alert("Error!");
            }
        });
    }

    function hapus(id,nama) {
        swal({
            title: "Yakin Ingin Hapus Admin '"+nama+"' ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_admin/"+id+"/"+nama+"'); ?>";
            });
    }
</script>
</body>
</html>