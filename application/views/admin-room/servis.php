<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/demo_table_jui.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/jquery-ui.dataTables.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/dataTables.responsive.css"); ?>">
    <style>
    #form-servis-wrapper {
        display: none;
    }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
<div class="wrapper">

<?php
$this->load->view("admin-room/header");
$this->load->view("admin-room/sidebar");
?>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Servis
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content" id="form-servis-wrapper">
        <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                <?php
                //jika variable id tidak kosong maka tampil form edit
                if ($id != 0) {
                    $title = "Edit Data Servis";
                    $action = base_url("crud/edit_servis");
                    $edits = $edit->result()[0];
                    $button = '<button class="btn btn-success" name="edit" value="edit">Edit</button>
                        <a class="pull-right btn btn-link" href="'.base_url("admin/servis").'"><i class="glyphicon glyphicon-repeat"></i> Kembali</a>';
                    $id_servis = $id;
                    $nama = $edits->nama;
                    $no_telp = $edits->no_telp;
                    $barang = $edits->barang;
                    $merk = $edits->merk;
                    $kelengkapan = $edits->kelengkapan;
                    $kerusakan = $edits->kerusakan;
                //jika kosong maka tampil form tambah
                }else{
                    $title = "Input Data Servis";
                    $action = base_url("crud/tambah_servis");
                    $button = '<button class="btn btn-success" name="tambah" value="tambah">Input</button>';
                    $id_servis = "";
                    $nama = "";
                    $no_telp = "";
                    $barang = "";
                    $merk = "";
                    $kelengkapan = "";
                    $kerusakan = "";
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
                            <label class="col-md-3">Nama Pelanggan :</label>
                            <div class="col-md-8">
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Pelanggan" value="<?php echo $nama; ?>" maxlength="100" required>
                                <input type="hidden" name="id_servis" value="<?php echo $id_servis; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Telepon / HP :</label>
                            <div class="col-md-7">
                                <input type="text" name="no_telp" class="form-control" placeholder="Masukkan Nomor Telp / Hp" value="<?php echo $no_telp; ?>" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Nama Barang :</label>
                            <div class="col-md-9">
                                <input type="text" name="barang" maxlength="300" value="<?php echo $barang; ?>" class="form-control" placeholder="Masukkan Nama Barang" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Merk Barang :</label>
                            <div class="col-md-9">
                                <input name="merk" maxlength="400" class="form-control" placeholder="Masukkan Merk Barang" value="<?php echo $merk; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Kelengkapan :</label>
                            <div class="col-md-9">
                                <textarea name="kelengkapan" rows="6" maxlength="400" placeholder="Masukkan Kelengkapan Barang" class="form-control" required><?php echo $kelengkapan; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Kerusakan :</label>
                            <div class="col-md-9">
                                <textarea name="kerusakan" rows="6" maxlength="400" placeholder="Masukkan Kerusakan Barang" class="form-control" required><?php echo $kerusakan; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <?php echo $button; ?>
                                &nbsp;
                                <input type="reset" class="btn btn-warning" value="Batal">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-md-12 col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Servis</h3>
                    <div class="box-tools pull-right">
                        <a href="javascript:void(0)" id="show-form-servis" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input Servis</a>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="clearfix"><p></p></div>
                    <div class="table-responsive">
                        <table class="display" id="servis_tbl" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="20">ID</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Barang Servis</th>
                                    <th>Status</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Selesai</th>
                                    <th style="width:150px;"><center>Action</center></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <th>ID</th>
                                <th>Nama Pelanggan</th>
                                <th>Barang Servis</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Selesai</th>
                                <th><center>Action</center></th>
                            </tfoot>
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

<!-- Detail Servis Modal -->
<div class="modal fade modal-servis" id="modal-servis" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><center><i class="fa fa-info-circle"></i> Detail Servis</center></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div id="hasilDetail">
                    <center><div class="preloader5" style="margin:10px auto;"></div></center>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>

</div><!-- ./wrapper -->

<?php $this->load->view("admin-room/source-js"); ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery-ui.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.responsive.js"></script>
<script>
    /*$(document).ready(function() {
        $("#servis_tbl").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo base_url('ajax/index/admin-room/server_processing'); ?>"
        });
    });*/

    var dTable;
      // #servis_tbl adalah id pada table
      $(document).ready(function() {
        dTable = $('#servis_tbl').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": true,
          "sPaginationType": "full_numbers",
          "responsive": true,
          "sAjaxSource": "<?php echo base_url('ajax/datatables/admin-room/datatables_serverSide/servis_serverSide'); ?>", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": true, "targets": 0, "searchable": true },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": true, "targets": 2, "searchable": true },
          { "orderable": true, "targets": 3, "searchable": true },
          { "orderable": true, "targets": 4, "searchable": false },
          { "orderable": true, "targets": 5, "searchable": false },
          { "orderable": false, "targets": 6, "searchable": false }
          ],
          "aaSorting" : [[0, "asc"]]
        } );

        $('#servis_tbl tfoot th').each( function () {
     
         //Agar kolom Action Tidak Ada Tombol Pencarian
         if( $(this).text() != "Action" && $(this).text() != "Tanggal Masuk" && $(this).text() != "Tanggal Selesai" ){
          var title = $('#servis_tbl thead th').eq( $(this).index() ).text();
          $(this).html( '<input type="text" placeholder="Cari '+title+'" class="form-control" />' );
         }
        } );
        
        // Untuk Pencarian, di kolom paling bawah
        dTable.columns().every( function () {
         var that = this;
         
         $( 'input', this.footer() ).on( 'keyup change', function () {
          that
          .search( this.value )
          .draw();
         } );
        } );
        
      } );

    $(document).ready(function() {
        // show/hide form
        $("#show-form-servis").click(function() {
            $("#form-servis-wrapper").toggle(1000);
        });
    });

    function showDetail(id) {
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'id_servis='+id,
            success: function(hasil) {
                $("#hasilDetail").html(hasil);
            },
            error: function() {
                alert("Error!");
            }
        });
    }

    function hapus(val,nama) {
        swal({
            title: "Yakin Ingin Hapus '"+nama+"' ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_servis/"+val+"'); ?>";
            });
    }
</script>
</body>
</html>