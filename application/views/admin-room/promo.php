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
        <h1>Promo
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-6 col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Buat Promo</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
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

                    //jika variable $id tdk kosong
                    if (!empty($id)) {
                        $ed = $edit->result()[0];
                        $action = base_url("crud/edit_promo/$id");
                        $judul = $ed->judul_promo;
                        $wktu = ($ed->lama_promo - $ed->tgl)/60/60/24;
                        $btn = '<button type="submit" name="edit" value="edit" class="btn btn-success">Edit Promo</button>';
                    //jika kosong
                    }else{
                        //mengambil data promo dimana no_kategori = 0
                        $sql_promo = $this->model1->selectWhere("promo", array("no_kategori_promo" => 0));
                        $nmr_promo = $sql_promo->num_rows() + 1;
                        $disabled = ($nmr_promo > 7) ? "disabled" : "";

                        $action = base_url("crud/proses_upload_promo");
                        $judul = "";
                        $wktu = "";
                        $btn = '<button type="submit" name="upload" value="upload" class="btn btn-success" '.$disabled.'>Input Promo</button>';
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($action); ?>" method="post" enctype="multipart/form-data" style="margin-top:13px">
                        <div class="form-group">
                            <label>Judul Promo :</label>
                            <textarea maxlength="200" class="form-control" placeholder="Masukkan Judul Promo" rows="4" name="judul_promo" required><?php echo $judul; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lama Waktu Promo :</label>
                            <div class="input-group">
                                <input type="number" name="waktu_promo" class="form-control" placeholder="Masukkan Angka" onkeypress="return isNumberKeyAngka(event)" value="<?php echo $wktu; ?>" required><span class="input-group-addon">Hari</span>
                                <input type="hidden" name="kategori_promo" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Upload Gambar Promo Portrait:</label>
                            <input type="file" name="promo1" class="form-control" required>
                            <span><small><i>Lebar Max 420px</i></small></span>
                        </div>
                        <div class="form-group">
                            <label>Upload Gambar Promo Landscape :</label>
                            <input type="file" name="promo2" class="form-control" required>
                            <span><small><i>Lebar Max 1120px</i></small></span>
                        </div>
                        <?php echo $btn; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Promo</h3>
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

                    //mengambil data promo dimana no_kategori = 0
                    $sql_promo2 = $this->model1->selectWhere("promo", array("no_kategori_promo" => 0));
                    $nmr_promo2 = $sql_promo2->num_rows() + 1;

                    $warning = ($nmr_promo2 > 7) ? "<div class='alert-gagal'>Hapus Promo non-kategori untuk dapat membuat Promo baru.</div>" : "";
                    echo $warning;
                    ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th width="230">Judul Promo</th>
                                    <th>Waktu Promo</th>
                                    <th>Jenis Promo</th>
                                    <th><center>Aksi</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no=1;
                                //mengambil data promo
                                $list_promo = $this->model1->selectWhere("promo", array("id_promo !=" => 99));
                                foreach ($list_promo->result() as $p) {
                                    $waktu = ($p->lama_promo - $p->tgl)/60/60/24;
                                    $jenis_promo = ($p->no_kategori_promo==0) ? "Non-Kategori" : "Kategori";
                                    $timeout = (time() > $p->lama_promo) ? "style='background:red'" : "";
                                    echo "
                                    <tr $timeout>
                                        <td>$no</td>
                                        <td>$p->judul_promo</td>
                                        <td>$waktu hari</td>
                                        <td>$jenis_promo</td>
                                        <td align='center'>";
                                        if ($p->no_kategori_promo != 0) {
                                        echo "
                                            <a href='".base_url("admin/kategori/?promo=$p->id_promo")."' class='btn btn-warning btn-xs' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";  
                                        }else{
                                        echo "
                                            <a href='".base_url("admin/promo/$p->id_promo")."' class='btn btn-warning btn-xs' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
                                        }
                                        echo "
                                            <button onclick='hapus($p->id_promo,\"$p->judul_promo\")' class='btn btn-danger btn-xs' data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-remove'></i></button>
                                        </td>
                                    </tr>    
                                    ";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <p><small>Jika background pada promo berwarna <font color="red">Merah</font>, maka promo tersebut sudah expired.</small></p>
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
    function hapus(val,judul) {
        swal({
            title: "Yakin Ingin Hapus Promo Ini?",
            text: "Yakin ingin hapus Promo '"+judul+"' ? \n Peringatan: Produk Promo yang bersangkutan akan terhapus!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_promo/"+val+"'); ?>";
            });
    }
</script>
</body>
</html>