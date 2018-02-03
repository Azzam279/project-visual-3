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
        <h1>Order
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content" id="produk-form">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Orderan Masuk</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" id="close-form"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
        <div id="accordion" style="width:100%;">
        <?php
        date_default_timezone_set('Asia/Singapore');

        //menampilkan seluruh data dari table order_produk
        foreach ($order->result() as $data) {
            //jika id_customer tdk 0, maka jalankan script ini
            if ($data->id_customer != 0) {
                $where = array("id_customer" => $data->id_customer);
                $customer = $this->model1->selectWhere("customer", $where);
                $cst = $customer->result()[0];
            //jika 0, maka jalankan ini
            }else{
                $where = array("id_cst" => $data->id_cst_sementara);
                $customer = $this->model1->selectWhere("customer_sementara", $where);
                $cst = $customer->result()[0];
            }

            //cek apakah kuantitas melebihi stok produk atau tidak
            $nop = explode("|", $data->id_produk);
            $kts = explode("|", $data->kuantitas);
            for ($z=0; $z < count($nop); $z++) {
                $whereP = array("no_produk" => $nop[$z]);
                $sql_produk = $this->model1->selectWhere("produk", $whereP);
                $cek = $sql_produk->result()[0];
                if ($cek->stok_produk < $kts[$z]) {
                    $info = "over";
                }else{
                    $info = "clear";
                }
            }

            //jika tgl_exp kurang dari waktu skarang & status barang "N" maka pesanan Expired
            $expired = ($data->tgl_exp < time() && $data->status_barang=="N") ? "Expired!" : "";
            //jika status barang "Y" maka background accordion menjadi hijau
            if ($data->status_barang == "Y") {
                $bgcolor = "background:#D4FFAA;";
                $checked = "<i class='glyphicon glyphicon-ok'></i>";
            }else if ($data->status_barang == "P") {
                $bgcolor = "background:#FDF5CE;";
                $checked = "<i class='fa fa-spinner'></i>";
            }else{
                $bgcolor = "";
                $checked = "";
            }
        ?>
            <h3 style="padding:15px 33px; margin-bottom:10px; <?php echo $bgcolor; ?>">
                <span class="pull-left"><?php echo "$cst->nama ($cst->email) $checked"; ?></span>
                <span class="pull-right">
                    <?php
                    echo "<span style='color:red;margin-right:15px;'>$expired</span> <span>".date("D-m-Y H:i:s",$data->tgl)."</span> ";
                    ?>
                </span>
                <span class="clearfix"></span>
            </h3>
            <div style="background:white;">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th style="color:#F46C44;" colspan="2">Produk</th>
                                <th style="color:#F46C44;">Harga</th>
                                <th style="color:#F46C44;">Kuantitas</th>
                                <th style="color:#F46C44;">Stok</th>
                                <th style="color:#F46C44;" width="140"><center>Subtotal</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nmr = explode("|", $data->id_produk);
                            $produk = explode("|",$data->produk);
                            $gambar = explode("|",$data->gambar);
                            $harga = explode("|",$data->harga);
                            $qty = explode("|",$data->kuantitas);
                            $sub = explode("|",$data->subtotal);
                            $count = count($produk);
                            for ($x = 0; $x < $count; $x++) {
                                $gambar2 = explode(",", $gambar[$x]);
                                //mengambil data stok dri tbl produk
                                $qry_produk = $this->model1->selectQuery2("SELECT stok_produk FROM produk WHERE no_produk = '$nmr[$x]'");
                                $get_produk = $qry_produk->result()[0];
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo base_url("image/produk-sm/$gambar2[0]"); ?>" class="img-responsive" style="width:70px;">
                                </td>
                                <td>
                                    <?php echo $produk[$x]; ?>
                                </td>
                                <td>
                                    <?php echo "Rp ".number_format($harga[$x]); ?>
                                </td>
                                <td>
                                    <?php
                                    $jml = ($qty[$x] > $get_produk->stok_produk) ? "<font color='red'>$qty[$x]</font>" : $qty[$x];
                                    echo $jml;
                                    ?>
                                </td>
                                <td>
                                    <?php echo $get_produk->stok_produk; ?>
                                </td>
                                <td align="center">
                                    <?php echo "Rp ".number_format($sub[$x]); ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5">
                                    <b>ONGKOS KIRIM</b>
                                </td>
                                <td align="right">
                                    <b><?php echo "Rp ".number_format($data->ongkir); ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <b>TOTAL</b>
                                </td>
                                <td align="right">
                                    <b><?php echo "Rp ".number_format($data->total); ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>TUJUAN</b>
                                </td>
                                <td colspan="5" align="right" id="<?php echo "des$data->id_order"; ?>">
                                    <button class="btn btn-default btn-sm" type="button" onclick="tujuan(<?php echo $data->id_order; ?>,<?php echo $cst->provinsi; ?>,<?php echo $cst->kota; ?>)">Tampilkan Tujuan</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>KURIR</b>
                                </td>
                                <td colspan="4" align="right">
                                    <?php echo $data->kurir; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Status Order</b>
                                </td>
                                <td colspan="4" align="right">
                                    <select id="<?php echo "status$data->id_order"; ?>" style="padding:8px; width:170px;" onchange="removeDisabled(<?php echo $data->id_order; ?>)" class="status" required>
                                        <?php
                                        $wait = ($data->status_barang == "N") ? "selected" : "";
                                        $proses = ($data->status_barang == "P") ? "selected" : "";
                                        $send = ($data->status_barang == "Y") ? "selected" : "";
                                        ?>
                                        <option value="N" <?php echo $wait; ?>>Menunggu</option>
                                        <option value="P" <?php echo $proses; ?>>Diproses</option>
                                        <option value="Y" <?php echo $send; ?>>Dikirim</option>
                                    </select>
                                    <span id="<?php echo "remove$data->id_order"; ?>">
                                        <?php
                                        //jika kuantitas melebihi stok maka disable tombol save
                                        if ($info == "over") {
                                        ?>
                                        <button class="btn btn-success" title="Kuantitas melebihi stok!" data-toggle="tooltip" data-placement="bottom" type="button">Save</button>
                                        <?php   
                                        }else{
                                        ?>
                                        <button class="btn btn-success" onclick="status(<?php echo $data->id_order; ?>)" id="<?php echo "btn$data->id_order"; ?>">Save</button>
                                        <?php
                                        }
                                        ?>
                                    </span>
                                    <script>
                                    var stat = document.getElementById('<?php echo "status$data->id_order"; ?>');
                                    var btn = document.getElementById('<?php echo "btn$data->id_order"; ?>');
                                    if (stat.value == "Y") {
                                        btn.disabled = "disabled";
                                    }
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Nomor Resi</b>
                                </td>
                                <td colspan="4" align="right">
                                    <?php
                                    $noresi = ($data->no_resi != "") ? $data->no_resi : "";
                                    ?>
                                    <input type="text" id="<?php echo "resi$data->id_order"; ?>" style="padding:5px; width:170px;" placeholder="Masukkan No. Resi" value="<?php echo $noresi; ?>" required>
                                    <button class="btn btn-primary" onclick="resi(<?php echo $data->id_order; ?>)">Save</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="pull-left">
                    <h4>Alamat</h4>
                    <p>
                        <?php echo $cst->alamat; ?>
                    </p>
                    <h4>Kode Pos</h4>
                    <p>
                        <?php echo $cst->kode_pos; ?>
                    </p>
                    <h4>No. Handphone</h4>
                    <p>
                        <?php echo $cst->no_hp; ?>
                    </p>
                    <div id="test"></div>
                </div>
                <div class="pull-right" style="position:relative;height:180px;">
                    <br>
                    <p>Nama : <?php echo $cst->nama; ?></p>
                    <p>Jenis Kelamin : <?php echo $cst->sex; ?></p>
                    <p>Tanggal Lahir : <?php echo $cst->tgl_lahir; ?></p>
                    <div style="position:absolute;bottom:0;right:0;">
                        <a href='javascript:void(0)' onclick="hapus(<?php echo $data->id_order; ?>,'<?php echo $cst->nama; ?>')" title='Hapus' data-toggle='tooltip' data-placement='bottom'><i class='fa fa-trash' style='color:red;font-size:20px'></i></a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        }
        ?>
        </div>
                </div>
                <div class="box-footer">
                    <br>
                    <div class="clearfix"></div>
                    <div style="height:40px;">
                    <?php echo $halaman ?> <!--Memanggil variable pagination-->
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
<script src="<?php echo base_url();?>assets/admin/js/jquery-ui.min.js"></script>
<script>
    //accordion jquery-ui
    $("#accordion").accordion({
        active: true,
        heightStyle: "content",
        collapsible:true
    });

    //proses merubah status order
    function status(id) {
        var val = $("#status"+id).val();
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'id_order='+id+'&val='+val,
            beforeSend: function() {
                swal({
                    title: "Sedang Memuat...",
                    text: "",
                    imageUrl: "<?php echo base_url('image/ajaxloader.gif'); ?>"
                });
            },
            success: function(hasil) {
                if (hasil == "Sukses") {
                    swal({
                        title: hasil,
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                        },
                        function(){
                            window.location = "<?php echo base_url('admin/order/'); ?>";
                        });
                }else if (hasil == "Gagal2") {
                    swal("Gagal!", "Terjadi Error!", "error");
                }else{
                    swal("Gagal!", "Ubah status order gagal!", "error");
                }
            },
            error: function() {
                alert("Error!");
            }
        });
    }

    //proses merubah no resi
    function resi(id) {
        var isi = $("#resi"+id).val();
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'no_resi='+id+'&resi='+isi,
            beforeSend: function() {
                swal({
                    title: "Sedang Memuat...",
                    text: "",
                    imageUrl: "<?php echo base_url('image/ajaxloader.gif'); ?>"
                });
            },
            success: function(hasil) {
                if (hasil == "Sukses") {
                    swal({
                        title: hasil,
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#86CCEB",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                        },
                        function(){
                            window.location = "<?php echo base_url('admin/order/'); ?>";
                        });
                }else{
                    swal("Gagal!", "Ubah no resi gagal!", "error");
                }
            },
            error: function() {
                alert("Error!");
            }
        });
    }

    //hapus attribut disabled pd tombol save
    function removeDisabled(id) {
        $("#btn"+id).removeAttr("disabled");
    }

    //hapus orderan
    function hapus(id,nama) {
        swal({
            title: "Yakin Ingin Hapus Pesanan '"+nama+"'?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: false 
            },
            function(){
              $.ajax({
                  url: '<?php echo base_url("admin/ajax"); ?>',
                  type: 'GET',
                  dataType: 'html',
                  data: 'del='+id,
                  beforeSend: function(){
                      swal({
                          title: "Sedang Memuat...",
                          text: "",
                          imageUrl: "<?php echo base_url('image/ajaxloader.gif'); ?>"
                      });
                  },
                  success: function(hasil){
                    if (hasil == "Sukses") {
                        swal({
                            title: "Sukses!",
                            text: "Hapus pesanan '"+nama+"' berhasil!",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#86CCEB",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                            },
                            function(){
                                window.location = "<?php echo base_url('admin/order/'); ?>";
                            });
                    }else{
                        swal("Gagal!", "Hapus pesanan '"+nama+"' gagal!", "error");
                    }
                  },
                  error:function(event, textStatus, errorThrown) {
                     alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                  }
              });
            });
    }

    //tampilkan provinsi & kota tujuan
    function tujuan(id, id_prov, id_kota) {
        $.ajax({
            url: '<?php echo base_url("admin/ajax?act=tujuan"); ?>',
            data: {id_prov:id_prov, id_kota:id_kota},
            beforeSend: function() {
                $("#des"+id).text("Loading...");
            },
            success: function(hasil) {
                $("#des"+id).html(hasil);
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    }
</script>
</body>
</html>