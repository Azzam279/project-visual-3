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
        <h1>Kategori
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-7 col-lg-7" style="padding-left:0">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                <?php
                if (empty($edit_kategori->result())) {
                    $title = "Buat Kategori Baru";
                    $action = base_url("crud/tambah_kategori");
                    $value = null;
                    $button = "Tambah";
                    $parent = "checked='checked'";
                    $single = "";
                } else {
                    $title = "Edit Kategori";
                    $ed_kat = $edit_kategori->result()[0];
                    $action = base_url("crud/ubah_kategori/".$ed_kat->no_kategori);
                    $value = $ed_kat->nama_kategori;
                    $button = "Ubah";
                    $parent = ($ed_kat->tipe == "parent") ? "checked='checked'" : "";
                    $single = ($ed_kat->tipe == "single") ? "checked='checked'" : "";
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
                    <form action="<?php echo $action; ?>" method="post" class="form-inline">
                        <div class="form-group col-md-12">
                            <label class="col-md-3" style="margin-top:5px">Nama Kategori :</label>
                            <div class="col-md-9" style="padding:0">
                            <input type="text" name="kategori" class="form-control" style="width:70%" placeholder="Masukkan Kategori Baru" value="<?php echo $value; ?>" required>
                            <button type="submit" name="proses" value="proses" class="btn btn-success" style="margin-bottom:5px;"><?php echo $button; ?></button><br>
                            <input type="radio" name="tipe" value="parent" id="first" <?php echo $parent; ?> required> 
                            <label for="first" style="font-weight:normal;">Kategori Dengan Subkategori</label><br>
                            <input type="radio" name="tipe" value="single" id="second" <?php echo $single; ?> required> 
                            <label for="second" style="font-weight:normal;">Kategori Tanpa Subkategori</label>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (!empty($edit_kategori->result())) {
                        echo "<div class='pull-right' style='margin-top:15px;'><a href='".base_url('admin/kategori/')."' class='btn btn-link'>Kembali <i class='glyphicon glyphicon-repeat'></i></a></div><div class='clearfix'></div>";
                    } else {
                        echo "<div class='clearfix' style='margin-bottom:30px'></div>";
                    }
                    ?>
                    <hr>
                    <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="50">No.</th>
                                <th width="300"><center>Kategori</center></th>
                                <th colspan="2"><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($isi_kategori->result() as $data) {
                                $no++;
                                $nm_kategori = str_replace("_", " ", $data->nama_kategori);
                                echo "
                                <tr>
                                    <td>$no</td>
                                    <td align='center'>$nm_kategori</td>
                                    <td align='center'><button onclick='ubah($data->no_kategori)' class='btn btn-warning btn-sm' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil-square-o'></i></button></td>
                                    <td align='center'><button class='btn btn-danger btn-sm' onclick='hapus($data->no_kategori)' data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-remove'></i></button></td>
                                </tr>
                                ";
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="col-md-5 col-lg-5" style="padding:0">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Buat Promo/Pasang Gambar Kategori</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div>
                        <?php
                        //validasi
                        if ($this->session->flashdata('sukses2')) {
                            echo "<div class='alert-sukses page-alert'>
                            <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                            <b>".$this->session->flashdata('sukses2')."</b></div>";
                        }
                        if ($this->session->flashdata('gagal2')) {
                            echo "<div class='alert-gagal page-alert'>
                            <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                            <b>".$this->session->flashdata('gagal2')."</b></div>";
                        }
                        if ($this->session->flashdata('peringatan2')) {
                            echo "<div class='alert-peringatan page-alert'>
                            <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                            <b>".$this->session->flashdata('peringatan2')."</b></div>";
                        }

                        //jika GET promo tdk kosong
                        if (!empty($_GET['promo'])) {
                            $get_edit = $this->model1->selectWhere("promo", array("id_promo" => $_GET['promo']));
                            $ed = $get_edit->result()[0];
                            $action = base_url("crud/edit_promo/$_GET[promo]");
                            $judul = $ed->judul_promo;
                            $wktu = ($ed->lama_promo - $ed->tgl)/60/60/24;
                            $promo_kat = $ed->no_kategori_promo;
                            $auto = "autofocus";
                            $btn = '<button type="submit" name="edit" value="edit" class="btn btn-success">Ubah Promo</button>';
                        //jika kosong
                        }else{
                            $action = base_url("crud/proses_upload_promo");
                            $judul = "";
                            $wktu = "";
                            $promo_kat = 0;
                            $auto = "";
                            $btn = '<button type="submit" name="upload" value="upload" class="btn btn-success">Tambah Promo</button>';
                        }
                        ?>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#promo" aria-controls="promo" role="tab" data-toggle="tab">Buat Promo</a>
                            </li>
                            <li role="presentation">
                                <a href="#gb_kat" aria-controls="gb_kat" role="tab" data-toggle="tab">Pasang Gambar Kategori</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="promo" role="tabpanel">
                                <form action="<?php echo htmlspecialchars($action); ?>" method="post" enctype="multipart/form-data" style="margin-top:13px">
                                    <div class="form-group">
                                        <label>Judul Promo :</label>
                                        <textarea maxlength="200" class="form-control" placeholder="Masukkan Judul Promo" rows="4" name="judul_promo" <?php echo $auto; ?> required><?php echo $judul; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Lama Waktu Promo :</label>
                                        <div class="input-group">
                                            <input type="number" name="waktu_promo" class="form-control" placeholder="Masukkan Angka" onkeypress="return isNumberKeyAngka(event)" value="<?php echo $wktu; ?>" required><span class="input-group-addon">Hari</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Promo Berdasarkan Kategori :</label>
                                        <select name="kategori_promo" class="form-control" required>
                                            <?php
                                            foreach ($kat_promo->result() as $pick_kategori) {
                                                if ($promo_kat == $pick_kategori->no_kategori) {
                                                    echo '<option value="'.$pick_kategori->no_kategori.'" selected>'.$pick_kategori->nama_kategori.'</option>';
                                                }else{
                                                    echo '<option value="'.$pick_kategori->no_kategori.'">'.$pick_kategori->nama_kategori.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Gambar Promo Portrait:</label>
                                        <input type="file" name="promo1" class="form-control" required>
                                        <span><small><i>Lebar Max 250px</i></small></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Gambar Promo Landscape :</label>
                                        <input type="file" name="promo2" class="form-control" required>
                                        <span><small><i>Lebar Max 1120px</i></small></span>
                                    </div>
                                    <?php echo $btn; ?>
                                </form>
                            </div>
                            <div class="tab-pane" id="gb_kat" role="tabpanel">
                                <form action="<?php echo base_url("crud/proses_upload_gambar_kategori"); ?>" method="post" enctype="multipart/form-data" style="margin-top:10px">
                                    <div class="form-group">
                                        <label>Kategori Gambar :</label>
                                        <select name="gb_kat" class="form-control">
                                            <option value="">-Pilih Kategori-</option>
                                            <?php
                                            foreach ($kat_promo->result() as $pick_kategori) {
                                                echo '<option value="'.$pick_kategori->no_kategori.'">'.$pick_kategori->nama_kategori.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Gambar :</label>
                                        <input type="file" name="gambar" class="form-control"><span><small><i>Lebar Max 250px</i></small></span>
                                    </div>
                                    <button type="submit" name="upload" value="upload" class="btn btn-success">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <br>
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
    function hapus(val) {
        swal({
            title: "Yakin Ingin Hapus Kategori Ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_kategori/"+val+"'); ?>";
            });
    }

    function ubah(val) {
        swal({
            title: "Yakin Ingin Ubah Kategori Ini?",
            text: "Jika Anda mengubah nama kategori, maka Anda harus mengisi kembali subkategori yang ada pada kategori tersebut.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FFAA55",
            confirmButtonText: "Ya, Lanjut!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('admin/kategori/"+val+"'); ?>";
            });
    }
</script>
</body>
</html>