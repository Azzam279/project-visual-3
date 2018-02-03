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
        <h1>Brand
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-8 col-lg-8" style="padding-left:0">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                <?php
                //jika variable id tidak kosong maka tampil form edit
                if ($id != 0) {
                    $title = "Edit Brand";
                    $action = base_url("crud/edit_brand");
                    $where = array("no_brand" => $id);
                    $select = $this->model1->selectWhere("brand", $where);
                    $val_brand = $select->result()[0]->nama_brand;
                    $id_brand = $id;
                    $button = '<button class="btn btn-success" name="edit" value="edit">Edit Brand</button>
                        <a class="pull-right btn btn-link" href="'.base_url("admin/brand").'"><i class="glyphicon glyphicon-repeat"></i> Kembali</a>';
                    $req = "";
                    $nama_img = $select->result()[0]->img_brand;
                //jika kosong maka tampil form tambah
                }else{
                    $title = "Input Brand";
                    $action = base_url("crud/tambah_brand");
                    $val_brand = "";
                    $id_brand = "";
                    $button = '<button class="btn btn-success" name="tambah" value="tambah">Input Brand</button>';
                    $req = "required";
                    $nama_img = "";
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
                    <form action="<?php echo $action; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-md-3">Nama Brand :</label>
                            <div class="col-md-7">
                                <input type="text" name="brand" class="form-control" placeholder="Masukkan Nama Brand" value="<?php echo $val_brand; ?>" required>
                                <input type="hidden" name="id_brand" value="<?php echo $id_brand; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Gambar Brand :</label>
                            <div class="col-md-7">
                                <input type="file" name="img_brand" class="form-control" <?php echo $req; ?> accept="image/jpg,image/jpeg,image/png">
                                <input type="hidden" name="nama_img" value="<?php echo $nama_img; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-7">
                                <?php echo $button; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-md-8 col-lg-8" style="padding-left:0">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Brand</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Nama Brand</th>
                                    <th colspan="2"><center>Action</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($brand->result() as $brn) {
                                $no++;
                                echo "
                                <tr>
                                    <td>$no</td>
                                    <td>$brn->nama_brand</td>
                                    <td align='center'><a href='".base_url("admin/brand/$brn->no_brand/")."' class='btn btn-warning btn-sm' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil-square-o'></i></a></td>
                                    <td align='center'><button class='btn btn-danger btn-sm' onclick=\"hapus(".$brn->no_brand.",'".$brn->img_brand."','".$brn->nama_brand."')\" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class='fa fa-remove'></i></button></td>
                                </tr>
                                ";
                                }
                                $brand->free_result();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>

</section>

<?php
$this->load->view("admin-room/footer");
$this->load->view("admin-room/control-sidebar");
?>

</div><!-- ./wrapper -->

<?php $this->load->view("admin-room/source-js"); ?>
<script>
    function hapus(val,img,nama) {
        swal({
            title: "Yakin Ingin Hapus Brand '"+nama+"' ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_brand/"+val+"/"+img+"'); ?>";
            });
    }
</script>
</body>
</html>