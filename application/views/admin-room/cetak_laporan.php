<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                        <tbody id="tampilLaporan">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url();?>assets/admin/js/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script>
    report();

    function report() {
        var thn = "<?php echo $thn; ?>";
        var bln = "<?php echo $bln; ?>";

        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET', 
            data: 'r_thn='+thn+'&r_bln='+bln,
            success: function(hasil) {
                $("#tampilLaporan").html(hasil);
                window.print();
            },
            error: function() {
                alert("Error: Terjadi kesalahan!");
            }
        });
    }
</script>
</body>
</html>