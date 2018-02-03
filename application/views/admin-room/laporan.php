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
        <h1>Laporan
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-12 col-lg-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Laporan Penjualan</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div>
                        <div class="pull-left" style="width:200px;">
                            <label>Pilih Tahun : </label>
                            <select id="thn" class="form-control" style='width:100px;display:inline-block;' onchange="report()">
                                <?php
                                //mengambil nilai terendah dari time_terjual di tbl produk_terjual
                                $start_th = $this->model1->selectQuery2("SELECT MIN(time_terjual) as min FROM produk_terjual");
                                //mengambil nilai tertinggi dari time_terjual di tbl produk_terjual
                                $finish_th = $this->model1->selectQuery2("SELECT MAX(time_terjual) as max FROM produk_terjual");
                                //convert time_terjual ke tahun
                                $mulai = date("Y",$start_th->result()[0]->min);
                                $slesai = date("Y",$finish_th->result()[0]->max);
                                //tahun akhir - tahun awal
                                $hitung = $slesai - $mulai;
                                //tampilkan tahun awal sampai tahun akhir dgn cara decrement looping
                                for ($i=$hitung; $i >= 0; $i--) {
                                    echo '<option value="'.$slesai.'">'.$slesai.'</option>';
                                    $slesai -= $i;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="pull-left" style="width:250px;">
                            <label>Pilih Bulan : </label>
                            <select id="bln" class="form-control" style='width:150px;display:inline-block;' onchange="report()">
                                <option value="">-Semua Bulan-</option>
                                <?php
                                $bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                $no=1;
                                foreach ($bulan as $bln) {
                                    echo "<option value='$no'>$bln</option>";
                                    $no++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-default" id="btn-print">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <center><h3><b>Laporan Penjualan pada Toko Komputer</b></h3></center>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead style="background:#AAAAFF;">
                                <tr>
                                    <th style='text-align:center;'>Kategori</th>
                                    <th style='text-align:center;'>Barang</th>
                                    <th style='text-align:center;'>Subtotal</th>
                                    <th style='text-align:center;'>Subkategori</th>
                                    <th style='text-align:center;'>Barang</th>
                                    <th style='text-align:center;'>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tampilReport">
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
    report();

    function report() {
        var thn = $("#thn").val();
        var bln = $("#bln").val();

        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET', 
            data: 'r_thn='+thn+'&r_bln='+bln,
            success: function(hasil) {
                $("#tampilReport").html(hasil);
            },
            error: function() {
                alert("Error: Terjadi kesalahan!");
            }
        });

        var main = "<?php echo base_url('admin/cetak_laporan/"+thn+"/"+bln+"'); ?>";
        $("#btn-print").attr("onclick","window.open('"+main+"','_blank','scrollbars=yes, resizeable=yes, top=0, left=100, width=1170, height=670')");
    }
</script>
</body>
</html>