<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
    <!--<link rel="stylesheet" href="<?php //echo base_url("assets/admin/css/demo_table_jui.css"); ?>">
    <link rel="stylesheet" href="<?php //echo base_url("assets/admin/css/jquery.dataTables.min.css"); ?>">-->
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/dataTables.bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/dataTables.responsive.css"); ?>">
    <style>
    td.details-control {
        background: url('<?php echo base_url("assets/admin/images/details_open.png"); ?>') no-repeat center center;
        cursor: pointer;
    }
    tr.details td.details-control {
        background: url('<?php echo base_url("assets/admin/images/details_close.png"); ?>') no-repeat center center;
    }    
    </style>

    <?php
    if (empty($id)) {
    ?>
    <style>
        #produk-form {display: none;}
    </style>
    <?php
    }else{
    ?>
    <style>
        #produk-form {display: block;}
    </style>
    <?php    
    }
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
<div class="wrapper">

<?php
$this->load->view("admin-room/header");
$this->load->view("admin-room/sidebar");
?>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Produk
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content" id="produk-form">
        <div class="col-md-10 col-md-offset-1" style="padding-left:0">
            <div class="box box-primary">
                <div class="box-header with-border">
                <?php
                if (!empty($id)) {
                    $title = "Edit Produk";
                    $action = base_url("crud/edit_produk/$id");
                    $getProduk = $produk_select->result()[0];
                    $id_produk = $getProduk->no_produk;
                    $promoP = $getProduk->id_promo;
                    $check_biasa = ($promoP==99) ? "checked='checked'" : "";
                    $check_promo = ($promoP!=99) ? "checked='checked'" : "";
                    $cek_jenis = ($promoP==99) ? "Y" : "N";
                    $namaP = $getProduk->nama_produk;
                    $imgP = $getProduk->gambar_produk;
                    $deskP = trim($getProduk->deskripsi);
                    $katP = $getProduk->no_kategori;
                    $subP = $getProduk->no_subkategori;
                    $brandP = $getProduk->no_brand;
                    $hargaP = $getProduk->harga_produk;
                    $diskonP = $getProduk->diskon_produk;
                    $beratP = $getProduk->berat_produk;
                    $stokP = $getProduk->stok_produk;
                    $required = "";
                    $button = "Edit Produk";
                    $back = '<span class="pull-right"><a href="'.base_url("admin/produk").'" class="btn btn-link"><i class="glyphicon glyphicon-repeat"></i> Kembali</a></span>';
                }else{
                    $title = "Tambah Produk Baru";
                    $action = base_url("crud/tambah_produk");
                    $id_produk = "";
                    $promoP = "";
                    $check_biasa = "checked='checked'";
                    $check_promo = "";
                    $cek_jenis = "";
                    $namaP = "";
                    $imgP = "";
                    $deskP = " ";
                    $katP = "";
                    $subP = "";
                    $brandP = "";
                    $hargaP = "";
                    $diskonP = "";
                    $beratP = "";
                    $stokP = "";
                    $promoP = "";
                    $required = "required";
                    $button = "Input Produk";
                    $back = "<button class='btn btn-warning' type='reset'>Cancel</button>";
                }
                ?>
                    <h3 class="box-title"><?php echo $title; ?></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" id="close-form"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php
                    if (!empty($id)) {
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
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($action); ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group" id="jenis-input">
                            <label class="col-md-3"></label>
                            <div class="col-md-5">
                                <input type="radio" name="jenis" value="N" id="n" <?php echo $check_biasa; ?> onclick="jbiasa()" required> <label for="n">Produk Biasa</label>
                                <span>&nbsp;&nbsp;&nbsp;</span>
                                <input type="radio" name="jenis" value="Y" id="y" onclick="jpromo()" <?php echo $check_promo; ?> required> <label for="y">Produk Promo</label>
                                <input type="hidden" id="cek_jenis" value="<?php echo $cek_jenis; ?>">
                            </div>
                        </div>
                        <div class="form-group" id="promo-input">
                            <label class="col-md-3">Promo :</label>
                            <div class="col-md-7">
                                <select name="promo" class="form-control">
                                    <?php
                                    //mengambil data promo dimana id promo tdk sama dgn 99
                                    $sql_promo = $this->model1->selectWhere("promo", array("id_promo !=" => 99));
                                    //menampilakn smua data promo kecuali id promo 99
                                    foreach ($sql_promo->result() as $pm) {
                                        if ($pm->id_promo == $promoP) {
                                            echo "
                                            <option value='$pm->id_promo' selected>$pm->judul_promo</option>
                                            ";
                                        }else{
                                            echo "
                                            <option value='$pm->id_promo'>$pm->judul_promo</option>
                                            ";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Nama Produk :</label>
                            <div class="col-md-9">
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Produk" value="<?php echo $namaP; ?>" id="nama-produk" autofocus required>
                                <input type="hidden" id="cek_produk" value="<?php echo $id_produk; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Gambar Produk :</label>
                            <div class="col-md-9">
                                <input type="file" name="gambar[]" class="form-control" accept="image/jpeg,image/png,image/jpg" <?php echo $required; ?> multiple>
                                <input type="hidden" name="image" value="<?php echo $imgP; ?>">   
                                <small>Upload File Gambar JPEG | JPG</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Detail Produk :</label>
                            <div class="col-md-9">
                                <textarea name="deskripsi" class="form-control" style="height:500px;" id="my_editor" required><?php echo $deskP; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Kategori :</label>
                            <div class="col-md-9" id="tampil_kat">
                                <select name="kategori" class="form-control" onchange="show_sub(this.value)" required>
                                    <option value="">-Pilih Kategori-</option>
                                    <?php
                                    foreach ($kat->result() as $kategori) {
                                        if ($katP == $kategori->no_kategori) {
                                            echo "
                                            <option value='$kategori->no_kategori' selected>$kategori->nama_kategori</option>
                                            ";    
                                        }else{
                                            echo "
                                            <option value='$kategori->no_kategori'>$kategori->nama_kategori</option>
                                            ";    
                                        }
                                    }
                                    $kat->free_result();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Subkategori :</label>
                            <div class="col-md-9">
                                <span id="tampil_sub">
                                <select name="subkategori" class="form-control" required>
                                    <option value="">-Pilih Subkategori-</option>
                                    <?php
                                    $nmr = 1;
                                    foreach ($subkat->result() as $subkategori) {
                                        if ($subP == $subkategori->no_subkategori) {
                                            echo "
                                            <option value='$subkategori->no_subkategori' selected>$subkategori->nama_subkategori</option>
                                            ";
                                        }else if ($subP == 999) {
                                            echo "
                                            <option value='999' selected>-Tidak ada Subkategori-</option>
                                            ";
                                            if ($nmr == 1) { break; }
                                        }
                                        $nmr++;
                                    }
                                    $subkat->free_result();
                                    ?>
                                </select>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Brand :</label>
                            <div class="col-md-9">
                                <select name="brand" class="form-control">
                                    <option value="">-Pilih Brand-</option>
                                    <?php
                                    foreach ($brand->result() as $brands) {
                                        if ($brandP == $brands->no_brand) {
                                            echo "
                                            <option value='$brands->no_brand' selected>$brands->nama_brand</option>
                                            ";
                                        }else{
                                            echo "
                                            <option value='$brands->no_brand'>$brands->nama_brand</option>
                                            ";
                                        }
                                    }
                                    $brand->free_result();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Harga Produk :</label>
                            <div class="col-md-9">
                                <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga Produk" value="<?php echo $hargaP; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Diskon :</label>
                            <div class="col-md-9">
                                <input type="number" name="diskon" class="form-control" placeholder="Masukkan Diskon Produk" value="<?php echo $diskonP; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Berat Produk :</label>
                            <div class="col-md-9">
                                <input type="number" name="berat" class="form-control" placeholder="Berat Produk dalam satuan Gram" value="<?php echo $beratP; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Stok Produk :</label>
                            <div class="col-md-9">
                                <input type="number" name="stok" class="form-control" placeholder="Masukkan Stok Produk" value="<?php echo $stokP; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-success" name="proses" value="proses"><?php echo $button; ?></button>
                                <?php echo $back; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>

    <?php
    if (empty($id)) {
    ?>
    <section class="content">
        <div class="col-md-12" style="padding:0">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Produk List</h3>
                    <div class="box-tools pull-right">
                        <a href="javascript:void(0)" id="show-form-produk" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Produk Baru</a>
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
                if (isset($_SESSION['warning'])) {
                    echo "<div class='alert-peringatan page-alert'>
                    <button type='button' class='close'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>
                    <b>".$_SESSION['warning']."</b></div>";
                    unset($_SESSION['warning']);
                }
                ?>
                    <table id="produk_tbl" class="display table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th width="200">Nama Produk</th>
                                <th>Kategori</th>
                                <th>Subkategori</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Berat</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
    <?php
    }
    ?>
</section>

<?php
$this->load->view("admin-room/footer");
$this->load->view("admin-room/control-sidebar");
?>

</div><!-- ./wrapper -->

<?php $this->load->view("admin-room/source-js"); ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url("assets/tinymce/jscripts/tiny_mce/tiny_mce.js"); ?>"></script>
<script type="text/javascript">
function ajaxfilemanager(field_name, url, type, win) {
   var ajaxfilemanagerurl = '<?php echo base_url("assets/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php");?>';
   switch (type) {
    case "image":
     break;
    case "media":
     break;
    case "flash": 
     break;
    case "file":
     break;
    default:
     return false;
   }
            tinyMCE.activeEditor.windowManager.open({
                url: '<?php echo base_url("assets/tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php");?>',
                width: 782,
                height: 440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
  }
</script>

<script type="text/javascript">
 tinyMCE.init({
  
  // General options
  mode : "textareas",
  elements : "ajaxfilemanager",
  file_browser_callback : 'ajaxfilemanager',
  theme : "advanced",
  plugins : "safari,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

  // Theme options
  theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
 theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
 theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
 theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
 
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_statusbar_location : "bottom",
  theme_advanced_resizing : true,
  relative_urls : false,
  remove_script_host : false,
  // Example content CSS (should be your site CSS)
  content_css : "css/content.css",

  // Drop lists for link/image/media/template dialogs
  

  // Replace values for the template plugin
  template_replace_values : {
   username : "Some User",
   staffid : "991234"
  }
 });
</script>
<script>
    /*function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="5" style="padding-left:50px; width:100px;">'+
            '<tr>'+
                '<td><a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" href="<?php echo base_url("admin/produk/'+d.no_produk+'"); ?>"><i class="glyphicon glyphicon-edit"></i></a></td>'+
                '<td><button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick=\'hapus('+d.no_produk+',\"'+d.nama_produk+'\")\'><i class="glyphicon glyphicon-remove"></i></button></td>'+
            '</tr>'+
        '</table>';
    }

    $(document).ready(function() {
        var dt = $("#produk_tbl").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo base_url('ajax/datatables/admin-room/datatables_serverSide/server_processing_produk'); ?>",
            "columns" : [
                {
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { "data": "no_produk" },
                { "data": "nama_produk" },
                { "data": "no_kategori" },
                { "data": "no_subkategori" },
                { "data": "harga_produk" },
                { "data": "diskon_produk" },
                { "data": "berat_produk" },
                { "data": "stok_produk" }
            ],
            "order": [[1, 'asc']]
        });

        // Array to track the ids of the details displayed rows
        var detailRows = [];
 
        $('#produk_tbl tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );
     
            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();
     
                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();
     
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );
     
        // On each draw, loop over the `detailRows` array and show any child rows
        dt.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
            } );
        } );
    });*/

    var dTable;
      // #servis_tbl adalah id pada table
      $(document).ready(function() {
        dTable = $('#produk_tbl').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": false,
          "sPaginationType": "full_numbers",
          "responsive": true,
          "sAjaxSource": "<?php echo base_url('ajax/datatables/admin-room/datatables_serverSide/produk_serverSide'); ?>", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": true, "targets": 0, "searchable": true },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": false, "targets": 2, "searchable": false },
          { "orderable": false, "targets": 3, "searchable": false },
          { "orderable": true, "targets": 4, "searchable": true },
          { "orderable": true, "targets": 5, "searchable": true },
          { "orderable": true, "targets": 6, "searchable": true },
          { "orderable": true, "targets": 7, "searchable": true },
          { "orderable": false, "targets": 8, "searchable": false },
          ],
          "aaSorting" : [[0, "asc"]]
        } );
        
      } );

    //close alert dalam 6 detik
    $('.page-alert').delay(6000).slideUp();

    $(document).ready(function() {
        // show/hide form
        $("#show-form-produk").click(function() {
            $("#produk-form").toggle(1000);
        });

        //close form
        $("#close-form").click(function() {
            $("#produk-form").slideUp(1000);
        });
    });

    //hapus produk
    function hapus(val,nama) {
        swal({
            title: "Yakin Ingin Hapus Produk Ini?",
            text: "Yakin ingin hapus produk '"+nama+"' ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false },
            function(){
                window.location = "<?php echo base_url('crud/hapus_produk/"+val+"'); ?>";
            });
    }

    //tampilkan kategori yang sesuai dgn promo kategori yg dipilih
    /*function change_promo(val) {
            $.ajax({
                url: '<?php echo base_url("admin/ajax"); ?>',
                type: 'POST',
                dataType: 'html',
                data: 'id_promo='+val,
                beforeSend: function() {
                    $("#tampil_sub").text("Loading...");
                },
                success: function(hasil) {
                    $("#tampil_sub").html(hasil);
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
    }*/

    //tampilkan subkategori berdasarkan kategori yg dipilih
    function show_sub(id) {
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'POST',
            dataType: 'html',
            data: 'no_kat='+id,
            beforeSend: function() {
                $("#tampil_sub").text("Loading...");
            },
            success: function(hasil) {
                $("#tampil_sub").html(hasil);
            },
            error:function(event, textStatus, errorThrown) {
               alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    }

    if ($("#cek_produk").val() != "") {
        if ($("#cek_jenis").val() == "Y") {
            $("#promo-input").hide();
        }else{
            $("#promo-input").show();
        }
    }else{
        $("#promo-input").hide();
    }
    
    //jika checkbox produk biasa dicentang maka sembunyikan selectbox promo
    function jbiasa() {
        $("#promo-input").slideUp();
    }
    //jika checkbox produk promo dicentang maka tampilkan selectbox promo
    function jpromo() {
        $("#promo-input").slideDown();
    }
</script>
</body>
</html>