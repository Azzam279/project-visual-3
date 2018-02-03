<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
  <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/demo_table_jui.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/jquery-ui.dataTables.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/dataTables.responsive.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/css/ionicons.min.css"); ?>">
    <style>
#loading-wrapper {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: none;
}

#loader {
  width: 100px;
  height: 40px;
  position: absolute;
  top: 0;
  left: 50%;
  margin: -20px -50px;}

#loader div {
  width: 20px;
  height: 20px;
  background: #999;
  border-radius: 50%;
  position: absolute; }

#d1 {-webkit-animation: animate 2s linear infinite;animation: animate 2s linear infinite;-moz-animation: animate 2s linear infinite;-ms-animation: animate 2s linear infinite;-o-animation: animate 2s linear infinite;}
#d2 {-webkit-animation: animate 2s linear infinite -.4s;animation: animate 2s linear infinite -.4s;-moz-animation: animate 2s linear infinite -.4s;-ms-animation: animate 2s linear infinite -.4s;-o-animation: animate 2s linear infinite -.4s;}
#d3 {-webkit-animation: animate 2s linear infinite -.8s;animation: animate 2s linear infinite -.8s;-moz-animation: animate 2s linear infinite -.8s;-ms-animation: animate 2s linear infinite -.8s;-o-animation: animate 2s linear infinite -.8s;}
#d4 {-webkit-animation: animate 2s linear infinite -1.2s;animation: animate 2s linear infinite -1.2s;-moz-animation: animate 2s linear infinite -1.2s;-ms-animation: animate 2s linear infinite -1.2s;-o-animation: animate 2s linear infinite -1.2s;} 
#d5 {-webkit-animation: animate 2s linear infinite -1.6s;animation: animate 2s linear infinite -1.6s;-moz-animation: animate 2s linear infinite -1.6s;-ms-animation: animate 2s linear infinite -1.6s;-o-animation: animate 2s linear infinite -1.6s;}

@-webkit-keyframes animate {
  0% { left: 100px; top:0}
  80% { left: 0; top:0;}
  85% { left: 0; top: -20px; width: 20px; height: 20px;}
  90% { width: 40px; height: 15px; }
  95% { left: 100px; top: -20px; width: 20px; height: 20px;}
  100% { left: 100px; top:0; }}

@-moz-keyframes animate {
  0% { left: 100px; top:0}
  80% { left: 0; top:0;}
  85% { left: 0; top: -20px; width: 20px; height: 20px;}
  90% { width: 40px; height: 15px; }
  95% { left: 100px; top: -20px; width: 20px; height: 20px;}
  100% { left: 100px; top:0; }}

@-ms-keyframes animate {
  0% { left: 100px; top:0}
  80% { left: 0; top:0;}
  85% { left: 0; top: -20px; width: 20px; height: 20px;}
  90% { width: 40px; height: 15px; }
  95% { left: 100px; top: -20px; width: 20px; height: 20px;}
  100% { left: 100px; top:0; }}

@-o-keyframes animate {
  0% { left: 100px; top:0}
  80% { left: 0; top:0;}
  85% { left: 0; top: -20px; width: 20px; height: 20px;}
  90% { width: 40px; height: 15px; }
  95% { left: 100px; top: -20px; width: 20px; height: 20px;}
  100% { left: 100px; top:0; }}

@keyframes animate {
  0% { left: 100px; top:0}
  80% { left: 0; top:0;}
  85% { left: 0; top: -20px; width: 20px; height: 20px;}
  90% { width: 40px; height: 15px; }
  95% { left: 100px; top: -20px; width: 20px; height: 20px;}
  100% { left: 100px; top:0; }}
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
	<div class="wrapper">

    <?php
    $this->load->view("admin-room/header");
    $this->load->view("admin-room/sidebar");
    $this->load->view("admin-room/content");
    $this->load->view("admin-room/footer");
    $this->load->view("admin-room/control-sidebar");
    ?>

  </div><!-- ./wrapper -->

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
                <div id="loading-wrapper">
                    <p style="margin:25px auto 5px auto;color:#ccc;text-align:center;">LOADING...</p><div id="loader"><div id="d1"></div><div id="d2"></div><div id="d3"></div><div id="d4"></div><div id="d5"></div></div>
                    <div style='clear: both;'></div>
                </div>
                <div id="infoValidasi"></div>
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

<?php $this->load->view("admin-room/source-js"); ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery-ui.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.canvasjs.min.js"></script>
<script>
    //close alert dalam 4.5 detik
    $('.page-alert').delay(4500).fadeOut();
    
    //tampilkan grafik penjualan
    grafik_terjual('column');

    function grafik_terjual(type) {
      var thn = $("#thn-trjual").val();
      var kat = $("#kat-trjual").val();
      var sub = $("#sub-trjual").val();

      if (type == "kosong") {
        var tipe = $("#tab-chart-penjualan .active a").text().toLowerCase();
      }else{
        var tipe = type;
      }

      $.ajax({
        url: '<?php echo base_url("admin/ajax"); ?>',
        type: 'GET',
        data: 'thn='+thn+'&tipe='+tipe+'&kat='+kat+'&sub='+sub,
        success: function(hasil) {
          $("#tampilChart").html(hasil);
        },
        error: function() {
          //alert("Error: Terjadi kesalahan! ajax-[1]");
        }
      });
    }

    //menampilkan subkategori berdasarkan nomor kategori
    function subkat_trjual() {
      var kat = $("#kat-trjual").val();
      var kat_tipe = kat.split("-");
      
      $.ajax({
        url: '<?php echo base_url("admin/ajax"); ?>',
        type: 'GET',
        dataType: 'html',
        data: 'nmr_kat='+kat_tipe[0]+'&tipe_kat='+kat_tipe[1],
        beforeSend: function() {
          $("#sub-trjual").attr("disabled","disabled");
        },
        success: function(hasil2) {
          grafik_terjual('kosong');
          $("#sub-trjual").removeAttr("disabled");
          $("#sub-trjual").html(hasil2);
        },
        error: function() {
          alert("Error: Terjadi kesalahan! ajax-[2]");
        }
      });
    }

    //menampilkan detail servis
    function showDetail(id) {
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'no_servis='+id,
            success: function(hasil) {
                $("#hasilDetail").html(hasil);
            },
            error: function() {
                alert("Error!");
            }
        });
    }

    //merubah status servis
    function status_servis(val,id) {
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'GET',
            dataType: 'html',
            data: 'update_status='+val+'&id_service='+id,
            beforeSend: function() {
                $("#loading-wrapper").show();
            },
            success: function(hasil) {
                $("#loading-wrapper").hide();
                $("#infoValidasi").html(hasil);
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

    //memberi catatan / saran di tbl servis
    function simpanCatatan(id) {
        var isi = $("#isi-catatan").val();
        $.ajax({
            url: '<?php echo base_url("admin/ajax"); ?>',
            type: 'POST',
            data: 'catatan='+isi+'&id_servis='+id,
            beforeSend: function() {
                $("#loading-wrapper").show();
            },
            success: function(hasil) {
                $("#loading-wrapper").hide();
                $("#infoValidasi").html(hasil);
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

      var dTable;
      // #servis_tbl adalah id pada table
      $(document).ready(function() {
        dTable = $('#servis').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": true,
          "sPaginationType": "full_numbers",
          "responsive": true,
          "sAjaxSource": "<?php echo base_url('ajax/datatables/admin-room/datatables_serverSide/servis_tek_serverSide'); ?>", // Load Data
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

        $('#servis tfoot th').each( function () {
     
         //Agar kolom Action Tidak Ada Tombol Pencarian
         if( $(this).text() != "Detail" && $(this).text() != "Tanggal Masuk" && $(this).text() != "Tanggal Selesai" ){
          var title = $('#servis thead th').eq( $(this).index() ).text();
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
      
      //host name
      var host = "<?php echo base_url(); ?>";

      //menampilkan pesan chat
      function tampilPesan() {
        $("#direct-chat-messages").load(host+'chatting_admin');
      }
      if ($("#total-chats").text() != "0") {
        setInterval(tampilPesan, 1000);
      }

      $("#input-chat").focus(function() {
        //menjadikan posisi scroll berada dibawah
        var box = document.getElementById("direct-chat-messages");
        box.scrollTop = box.scrollHeight;
      });

      //membisukan customer yg nge-flood / nge-spam
      function bisu(id) {
        $.ajax({
          url: "<?php echo base_url('admin/ajax'); ?>",
          type: 'GET',
          dataType: 'html',
          data: 'bisu='+id+'&status_banned='+$("#btn-bisu-"+id).text(),
          beforeSend: function() {
            $("#btn-bisu-"+id).addClass("m-progress");
            $("#btn-bisu-"+id).attr("disabled","disabled");
          },
          success: function(hasil) {
            $("#btn-bisu-"+id).removeClass("m-progress");
            $("#btn-bisu-"+id).removeAttr("disabled");
            if (hasil == "Sukses") {
              if ($("#btn-bisu-"+id).text() == "Bisu") {
                $("#btn-bisu-"+id).text("Bicara");
              }else{
                $("#btn-bisu-"+id).text("Bisu");
              }
            }else{
              alert("Error: Gagal!");
            }
          },
          error: function() {
            alert("Error: Terjadi kesalahan!");
          }
        });
      }

      //proses kirim pesan chat
      $("#chatting-form").submit(function() {
        $.ajax({
          url: $(this).attr('action') + "?kirim=true",
          type: 'POST',
          data: $(this).serialize(),
          beforeSend: function() {
            $("#btn-chat-admin").addClass("m-progress");
          },
          success: function(hasil) {
            $("#btn-chat-admin").removeClass("m-progress");
            //play suara chat
            var suara = document.getElementById("suara_chat");
            suara.play();
            if (hasil == "Sukses") {
              $("#input-chat").val("");
              function posisiBawah() {
                //menjadikan posisi scroll berada dibawah
                var box = document.getElementById("direct-chat-messages");
                box.scrollTop = box.scrollHeight;
              }
              setTimeout(posisiBawah, 1000);
            }else{
              return false;
            }
          },
          error: function() {
            alert("Error: Terjadi kesalahan.");
          }
        });

        return false;
      });
</script>
</body>
</html>