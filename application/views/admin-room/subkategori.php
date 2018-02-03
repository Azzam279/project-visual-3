<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/jquery-ui.min.css"); ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
<div class="wrapper">

<?php
$this->load->view("admin-room/header");
$this->load->view("admin-room/sidebar");
?>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Sub-Kategori
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-6 col-lg-6" style="padding-left:0">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                <?php
                if (empty($edit_subkategori->result())) {
                    $title = "Buat Sub-Kategori";
                    $action = base_url("crud/tambah_subkategori");
                    $value = null;
                    $button = "Tambah";
                } else {
                    $title = "Edit Subkategori";
                    $ed_subkat = $edit_subkategori->result();
                    $action = base_url("crud/ubah_subkategori/".$ed_subkat[0]->no_kategori."/".$ed_subkat[0]->no_subkategori);
                    $value = $ed_subkat[0]->nama_subkategori;
                    $button = "Ubah";
                }
                ?>
                    <h3 class="box-title"><?php echo $title; ?></h3>
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
                    <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3">Pilih Kategori :</label>
                            <div class="col-md-9">
                                <select name="kategori" class="form-control" required>
                                    <option value="">-Pilih Kategori-</option>
                                    <?php
                                    foreach ($isi_kategori->result() as $pick_kategori) {
                                        if ($pick_kategori->no_kategori==$no_kategori) {
                                            echo '<option value="'.$pick_kategori->no_kategori."|".$pick_kategori->nama_kategori.'" selected="selected">'.$pick_kategori->nama_kategori.'</option>';
                                        }else{
                                            echo '<option value="'.$pick_kategori->no_kategori."|".$pick_kategori->nama_kategori.'">'.$pick_kategori->nama_kategori.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Nama Subkategori :</label>
                            <div class="col-md-9">
                                <input type="text" name="subkategori" class="form-control" placeholder="Masukkan Sub-kategori Baru" value="<?php echo $value; ?>" required><br>
                                <button class="btn btn-success" name="proses" value="proses"><?php echo $button; ?></button>
                                <?php
                                if (!empty($edit_subkategori->result())) {
                                ?>
                                <span class="pull-right">
                                    <a href="<?php echo base_url("admin/subkategori/"); ?>" class="btn btn-link">Kembali <i class='glyphicon glyphicon-repeat'></i></a>
                                </span>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6" style="padding:0">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Sub-Kategori</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori</th>
                                    <th>Subkategori</th>
                                    <th colspan="2"><center>Action</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($isi_subkategori->result() as $val_subkat) {
                                    $no++;
                                    $nm_kategori = str_replace("_", " ", $val_subkat->nama_kategori);
                                    $nm_subkategori = str_replace("_", " ", $val_subkat->nama_subkategori);
                                    echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>$nm_kategori</td>
                                        <td>$nm_subkategori</td>
                                        <td align='center'><a class='btn btn-warning btn-sm' href='".base_url("admin/subkategori/$val_subkat->no_kategori/$val_subkat->no_subkategori")."' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil-square-o'></i></a></td>
                                        <td align='center'><button class='btn btn-danger btn-sm' onclick='hapus($val_subkat->no_kategori,$val_subkat->no_subkategori)' data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-remove'></i></button></td>
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
    function hapus(val1,val2) {
        swal({
            title: "Yakin Ingin Hapus Sub-Kategori Ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_subkategori/"+val1+"/"+val2+"'); ?>";
            });
    }
</script>
</body>
</html>